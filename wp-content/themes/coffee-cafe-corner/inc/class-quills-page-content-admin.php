<?php
/**
 * Class Coffee_Cafe_Corner_Page_Content_Admin
 *
 * Provides dedicated WordPress Admin UI for managing page content:
 * - Home Page: All 10 sections completely dynamic, synchronized with WordPress Database (wp_options)
 * - About Us Page: Hero Title, History Section ("WHERE WE STARTED"), Values, Quotes
 * - Full synchronization with WordPress Database (wp_options & wp_postmeta)
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Page_Content_Admin {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_menus' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_page_meta_boxes' ) );
		add_action( 'save_post_page', array( __CLASS__, 'save_page_meta' ), 10, 2 );
		add_action( 'admin_init', array( __CLASS__, 'handle_home_settings_save' ) );
		add_action( 'wp', array( __CLASS__, 'refresh_home_pattern' ), 1 );
		add_filter( 'render_block', array( __CLASS__, 'render_dynamic_home_pattern' ), 10, 2 );
	}

	/**
	 * Dynamically re-evaluate and register Home Quills pattern on every frontend load
	 */
	public static function refresh_home_pattern() {
		if ( ! class_exists( 'WP_Block_Patterns_Registry' ) ) {
			return;
		}
		$registry = WP_Block_Patterns_Registry::get_instance();
		if ( $registry->is_registered( 'coffee-cafe-corner/home-quills' ) ) {
			$registry->unregister( 'coffee-cafe-corner/home-quills' );
		}
		$pattern_file = get_template_directory() . '/patterns/home-quills.php';
		if ( file_exists( $pattern_file ) ) {
			ob_start();
			include $pattern_file;
			$pattern_content = ob_get_clean();
			$registry->register( 'coffee-cafe-corner/home-quills', array(
				'title'      => 'Home Quills',
				'categories' => array( 'featured' ),
				'content'    => $pattern_content,
			) );
		}
	}

	/**
	 * Ensure Home Quills pattern evaluates dynamically at runtime on frontend
	 */
	public static function render_dynamic_home_pattern( $block_content, $block ) {
		if ( isset( $block['blockName'] ) && 'core/pattern' === $block['blockName'] ) {
			if ( isset( $block['attrs']['slug'] ) && 'coffee-cafe-corner/home-quills' === $block['attrs']['slug'] ) {
				$pattern_file = get_template_directory() . '/patterns/home-quills.php';
				if ( file_exists( $pattern_file ) ) {
					ob_start();
					include $pattern_file;
					return ob_get_clean();
				}
			}
		}
		return $block_content;
	}

	/**
	 * Enqueue WordPress Media Library scripts
	 */
	public static function enqueue_admin_assets( $hook ) {
		if ( false !== strpos( $hook, 'quills-home-settings' ) || 'post.php' === $hook || 'post-new.php' === $hook ) {
			wp_enqueue_media();
		}
	}

	/**
	 * Helper to resolve image URL with default fallback
	 */
	public static function get_image_url( $val, $default_filename ) {
		$img_dir = trailingslashit( get_template_directory_uri() ) . 'assets/images/home/';
		if ( empty( $val ) ) {
			return $img_dir . $default_filename;
		}
		if ( strpos( $val, 'http://' ) === 0 || strpos( $val, 'https://' ) === 0 || strpos( $val, '//' ) === 0 ) {
			return $val;
		}
		return $img_dir . ltrim( $val, '/' );
	}

	/**
	 * Register Admin Submenu under Appearance for Home Page Settings
	 */
	public static function register_admin_menus() {
		add_theme_page(
			__( 'Cài đặt Trang chủ (Home Page)', 'coffee-cafe-corner' ),
			__( 'Cài đặt Trang chủ (Home)', 'coffee-cafe-corner' ),
			'manage_options',
			'quills-home-settings',
			array( __CLASS__, 'render_home_settings_page' )
		);
	}

	/**
	 * Register Meta Boxes on Page edit screen for About Us & Home
	 */
	public static function register_page_meta_boxes( $post_type ) {
		if ( 'page' !== $post_type ) {
			return;
		}

		global $post;
		if ( ! $post ) {
			return;
		}

		$slug = $post->post_name;

		// About Us Page Meta Box
		if ( in_array( $slug, array( 'about', 'about-us' ), true ) ) {
			add_meta_box(
				'quills_about_content_meta',
				__( '📖 Quản lý Nội dung Trang Giới thiệu (About Us Content)', 'coffee-cafe-corner' ),
				array( __CLASS__, 'render_about_meta_box' ),
				'page',
				'normal',
				'high'
			);
		}

		// Home Page Meta Box
		if ( in_array( $slug, array( 'home', 'trang-chu' ), true ) ) {
			add_meta_box(
				'quills_home_content_meta',
				__( '🏠 Quản lý Toàn Bộ Nội dung Trang Chủ (Quills Home Page)', 'coffee-cafe-corner' ),
				array( __CLASS__, 'render_home_meta_box' ),
				'page',
				'normal',
				'high'
			);
		}
	}

	/**
	 * Render Meta Box for About Us
	 */
	public static function render_about_meta_box( $post ) {
		wp_nonce_field( 'quills_about_meta_nonce', 'quills_about_meta_nonce_field' );

		$id = $post->ID;

		$hero_title = get_post_meta( $id, '_quills_hero_title', true ) ?: 'About Us';
		$where_started_title = get_post_meta( $id, '_quills_where_we_started_title', true ) ?: 'WHERE WE STARTED';

		$paragraphs = get_post_meta( $id, '_quills_where_we_started_paragraphs', true );
		if ( empty( $paragraphs ) || ! is_array( $paragraphs ) ) {
			$paragraphs_text = "In the early 2000s, many people drank coffee without thinking much about it. I couldn't stop thinking about it.\n\nDuring my time as a social worker, I was meeting with students in local coffeehouses. I found myself constantly talking about what makes exceptional coffee.\n\nHow it's sourced, roasted, how it's brewed. And why doing it right matters.\n\nIn 2007, we took a pair of hammers to an old rundown building in the Germantown neighborhood of Louisville, Kentucky.\n\nAfter a lot of love and elbow grease, we opened the first Quills. That first shop taught us everything. We learned that great coffee can create the kind of spaces where people can connect.\n\nWe learned that when you blend fine coffee with a touch of southern hospitality, when you prioritize connection over speed, something special happens.\n\nYou make places where strangers can become friends. Where a writer finds her words in a warm corner seat. Where a company might be founded on the back of a napkin. Where first dates can turn into something more.\n\nWhen our first building was about to be sold and we had to move, our regular customer Tommy O'Shea helped us find a new home in the Highlands. That shop on Baxter Avenue runs to this day.\n\nWe've grown since then. Today, we roast our coffee in small batches right here in Louisville. Because we wanted better control over the whole experience we were creating. Today we have six cafes here and one in downtown Indianapolis. But at the heart of it all, the vision hasn't changed: Great coffee. Great spaces. Great hospitality.\n\nWe work with our producers and sourcing partners around the world who care deeply about quality. The close work we do with them means that every cup you drink is connected to real people, real farms, and a commitment to doing things the right way.";
		} else {
			$paragraphs_text = implode( "\n\n", $paragraphs );
		}

		$why_here_title   = get_post_meta( $id, '_quills_why_were_here_title', true ) ?: "WHY WE'RE HERE";
		$why_here_content = get_post_meta( $id, '_quills_why_were_here_content', true ) ?: "Quills Coffee is here to deliver a coffee that connects people. Between the barista behind the counter and the customer in front of it. Between strangers at neighboring tables. Between all of us and the farmers who picked the coffee we're enjoying. We believe delivering great coffee is a chance to make memorable human experiences. It's a chance for us to be together, to pause, to talk, to connect.";

		$how_work_title   = get_post_meta( $id, '_quills_how_we_work_title', true ) ?: 'HOW WE WORK';
		$how_work_content = get_post_meta( $id, '_quills_how_we_work_content', true ) ?: "The French have a word: terroir. It means \"the taste of the place itself.\" The soil where something grows. The climate that shapes it. The hands that tend it. It's why a coffee cherry from Guatemala tastes different from one grown in Ethiopia. The earth was different, the rain was different, and so the taste is different. At Quills, we celebrate our own kind of \"terroir\" with three core values: Genuine Care, Continuous Craft, and Creative Education.";

		$quote_text   = get_post_meta( $id, '_quills_where_were_going_quote', true ) ?: "Like soil worked for years, our roots merely grow richer with time. We're not trying to be the biggest coffee company, or the fastest. We're building a place where quality lives, where every cup honors the taste of each dear sight, and most importantly—where people strive to connect with other people.";
		$quote_author = get_post_meta( $id, '_quills_where_were_going_author', true ) ?: '— Nathan Quillo, Founder';
		?>
		<style>
			.quills-admin-box { background: #fafafa; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-top: 10px; }
			.quills-field-group { margin-bottom: 20px; }
			.quills-field-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 13.5px; color: #1e293b; }
			.quills-field-group input[type="text"], .quills-field-group textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 14px; }
			.quills-field-group textarea { line-height: 1.6; min-height: 180px; }
			.quills-field-desc { font-size: 12px; color: #64748b; margin-top: 4px; }
			.quills-badge { background: #663A1E; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
		</style>
		<div class="quills-admin-box">
			<p><em>Chỉnh sửa các trường dưới đây và bấm nút <strong>Cập nhật (Update)</strong> bên cột phải để lưu vào Database. Dữ liệu sẽ cập nhật ngay trên trang <strong>/about-us/</strong>.</em></p>

			<div class="quills-field-group">
				<label><span class="quills-badge">Hero Banner</span> Tiêu đề chính trang About Us:</label>
				<input type="text" name="quills_hero_title" value="<?php echo esc_attr( $hero_title ); ?>">
			</div>

			<div class="quills-field-group">
				<label><span class="quills-badge">Lịch sử</span> Tiêu đề mục câu chuyện:</label>
				<input type="text" name="quills_where_started_title" value="<?php echo esc_attr( $where_started_title ); ?>">
			</div>

			<div class="quills-field-group">
				<label>Nội dung câu chuyện lịch sử hình thành ("Where We Started"):</label>
				<textarea name="quills_where_started_text" rows="12"><?php echo esc_textarea( $paragraphs_text ); ?></textarea>
				<div class="quills-field-desc">Mỗi đoạn văn cách nhau bằng 2 lần xuống dòng (Enter 2 lần). Hệ thống sẽ tự động tách thành các đoạn văn riêng biệt.</div>
			</div>

			<div class="quills-field-group">
				<label><span class="quills-badge">Sứ mệnh</span> Tiêu đề mục sứ mệnh:</label>
				<input type="text" name="quills_why_here_title" value="<?php echo esc_attr( $why_here_title ); ?>">
			</div>

			<div class="quills-field-group">
				<label>Nội dung sứ mệnh ("Why We're Here"):</label>
				<textarea name="quills_why_here_content" rows="4"><?php echo esc_textarea( $why_here_content ); ?></textarea>
			</div>

			<div class="quills-field-group">
				<label><span class="quills-badge">Giá trị</span> Tiêu đề phương thức hoạt động:</label>
				<input type="text" name="quills_how_work_title" value="<?php echo esc_attr( $how_work_title ); ?>">
			</div>

			<div class="quills-field-group">
				<label>Nội dung phương thức hoạt động ("How We Work"):</label>
				<textarea name="quills_how_work_content" rows="4"><?php echo esc_textarea( $how_work_content ); ?></textarea>
			</div>

			<div class="quills-field-group">
				<label><span class="quills-badge">Tầm nhìn</span> Lời trích dẫn kết trang ("Where We're Going"):</label>
				<textarea name="quills_quote_text" rows="3"><?php echo esc_textarea( $quote_text ); ?></textarea>
			</div>

			<div class="quills-field-group">
				<label>Tác giả trích dẫn:</label>
				<input type="text" name="quills_quote_author" value="<?php echo esc_attr( $quote_author ); ?>">
			</div>
		</div>
		<?php
	}

	/**
	 * Save Page Meta for About Us & Home
	 */
	public static function save_page_meta( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

		// Save About Us Meta
		if ( isset( $_POST['quills_about_meta_nonce_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['quills_about_meta_nonce_field'] ) ), 'quills_about_meta_nonce' ) ) {
			if ( isset( $_POST['quills_hero_title'] ) ) {
				update_post_meta( $post_id, '_quills_hero_title', sanitize_text_field( wp_unslash( $_POST['quills_hero_title'] ) ) );
			}
			if ( isset( $_POST['quills_where_started_title'] ) ) {
				update_post_meta( $post_id, '_quills_where_we_started_title', sanitize_text_field( wp_unslash( $_POST['quills_where_started_title'] ) ) );
			}
			if ( isset( $_POST['quills_where_started_text'] ) ) {
				$raw_text = wp_unslash( $_POST['quills_where_started_text'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
				$raw_parts = preg_split( '/\r\n\r\n|\n\n/', $raw_text );
				$cleaned_paragraphs = array();
				foreach ( $raw_parts as $part ) {
					$trimmed = trim( $part );
					if ( ! empty( $trimmed ) ) {
						$cleaned_paragraphs[] = sanitize_textarea_field( $trimmed );
					}
				}
				if ( ! empty( $cleaned_paragraphs ) ) {
					update_post_meta( $post_id, '_quills_where_we_started_paragraphs', $cleaned_paragraphs );
				}
			}
			if ( isset( $_POST['quills_why_here_title'] ) ) {
				update_post_meta( $post_id, '_quills_why_were_here_title', sanitize_text_field( wp_unslash( $_POST['quills_why_here_title'] ) ) );
			}
			if ( isset( $_POST['quills_why_here_content'] ) ) {
				update_post_meta( $post_id, '_quills_why_were_here_content', sanitize_textarea_field( wp_unslash( $_POST['quills_why_here_content'] ) ) );
			}
			if ( isset( $_POST['quills_how_work_title'] ) ) {
				update_post_meta( $post_id, '_quills_how_we_work_title', sanitize_text_field( wp_unslash( $_POST['quills_how_work_title'] ) ) );
			}
			if ( isset( $_POST['quills_how_work_content'] ) ) {
				update_post_meta( $post_id, '_quills_how_we_work_content', sanitize_textarea_field( wp_unslash( $_POST['quills_how_work_content'] ) ) );
			}
			if ( isset( $_POST['quills_quote_text'] ) ) {
				update_post_meta( $post_id, '_quills_where_were_going_quote', sanitize_textarea_field( wp_unslash( $_POST['quills_quote_text'] ) ) );
			}
			if ( isset( $_POST['quills_quote_author'] ) ) {
				update_post_meta( $post_id, '_quills_where_were_going_author', sanitize_text_field( wp_unslash( $_POST['quills_quote_author'] ) ) );
			}
		}

		// Save Home Meta if editing Home page
		if ( isset( $_POST['quills_home_meta_nonce_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['quills_home_meta_nonce_field'] ) ), 'quills_home_meta_nonce' ) ) {
			self::save_home_fields( $_POST );
		}
	}

	/**
	 * Render Meta Box for Home Page (in page 'Home')
	 */
	public static function render_home_meta_box( $post ) {
		wp_nonce_field( 'quills_home_meta_nonce', 'quills_home_meta_nonce_field' );
		self::render_home_form_fields();
	}

	/**
	 * Render Standalone Home Settings Page under Appearance
	 */
	public static function render_home_settings_page() {
		?>
		<div class="wrap">
			<h1 style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
				<span>🏠 Quản lý Toàn Bộ Nội dung Trang Chủ (Home Page)</span>
			</h1>

			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><strong>✅ Dữ liệu Trang chủ đã được lưu thành công vào Database!</strong> Hãy mở trang chủ ngoài giao diện và tải lại để xem nội dung mới nhất.</p>
				</div>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="quills_save_home_settings">
				<?php wp_nonce_field( 'quills_home_settings_action', 'quills_home_settings_nonce' ); ?>

				<?php self::render_home_form_fields(); ?>

				<div style="position: sticky; bottom: 20px; background: #fff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 1px solid #cbd5e1; z-index: 100; display: flex; justify-content: space-between; align-items: center;">
					<span style="font-weight: 600; color: #334155;">✨ Nhấn nút Lưu sau khi chỉnh sửa bất kỳ mục nào trên trang chủ:</span>
					<input type="submit" name="submit" id="submit" class="button button-primary button-large" style="height: 44px; padding: 0 24px; font-size: 15px; font-weight: 700; background: #663A1E; border-color: #4a2812;" value="💾 Lưu Toàn Bộ Thay Đổi Trang Chủ (Save Settings)">
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Shared Form Fields for Home Page
	 */
	public static function render_home_form_fields() {
		$img_dir = trailingslashit( get_template_directory_uri() ) . 'assets/images/home/';

		// 1. Hero Banner
		$hero_img          = get_option( 'quills_home_hero_img', $img_dir . 'home.webp' );
		$hero_title        = get_option( 'quills_home_hero_title', "We find them, we roast them, you<br>just enjoy them." );
		$hero_subtitle     = get_option( 'quills_home_hero_subtitle', "Get new delicious coffees that you and your guests will love, delivered<br>to your door on your schedule." );
		$hero_cta_text     = get_option( 'quills_home_hero_cta_text', "START YOUR SUBSCRIPTION" );
		$hero_cta_link     = get_option( 'quills_home_hero_cta_link', home_url( '/subscriptions/' ) );
		$hero_stars_img    = get_option( 'quills_home_hero_stars_img', $img_dir . 'hero-stars.png' );
		$hero_rating       = get_option( 'quills_home_rating_text', "4.62 stars across 13,082 reviews" );
		$hero_press_label  = get_option( 'quills_home_press_label', "Featured in" );
		$press_logo_1      = get_option( 'quills_home_press_logo_1', $img_dir . 'logo-garden-and-gun.png' );
		$press_logo_2      = get_option( 'quills_home_press_logo_2', $img_dir . 'logo-cosmopolitan.png' );
		$press_logo_3      = get_option( 'quills_home_press_logo_3', $img_dir . 'logo-food-and-wine.png' );
		$press_logo_4      = get_option( 'quills_home_press_logo_4', $img_dir . 'logo-courier-journal.png' );
		$hero_quote        = get_option( 'quills_home_hero_quote', "“I’ve searched far and wide and this is the place to get your cup or bag of greatness if you happen to be a true coffee aficionado.” — Jacob Y." );

		// 2. Team
		$team_img      = get_option( 'quills_home_team_img', $img_dir . 'team-nathan.jpg' );
		$team_title    = get_option( 'quills_home_team_title', "NO ROBOTS. JUST PEOPLE." );
		$team_p1       = get_option( 'quills_home_team_p1', "You should know who's choosing and roasting your coffee. No algorithms here." );
		$team_p2       = get_option( 'quills_home_team_p2', "It’s a small group of real people in the heart of Louisville, Kentucky who love finding and making great coffee and care about sharing it with you." );
		$team_p3       = get_option( 'quills_home_team_p3', "It’s our founder, Nathan, four operations team members, five roasters, four cafe managers, and 42 baristas." );
		$team_p4       = get_option( 'quills_home_team_p4', "Some of us have worked in coffee for years. Others discovered their passion more recently. What we all have in common is this belief that coffee should bring people together." );
		$team_p5       = get_option( 'quills_home_team_p5', "We’re doing our best to deliver coffee that connects people." );
		$team_cta_text = get_option( 'quills_home_team_cta_text', "SHOW ME THE COFFEE" );
		$team_cta_link = get_option( 'quills_home_team_cta_link', home_url( '/coffee/' ) );
		$team_quote    = get_option( 'quills_home_team_quote', "“The best tasting pour over coffee on this planet.” — Kelsey B." );

		// 3. Features Banner (Subscriptions)
		$feat_title        = get_option( 'quills_home_feat_title', "Coffee subscriptions. Change, pause, or cancel anytime." );
		$feat_icon_1       = get_option( 'quills_home_feat_icon_1', $img_dir . 'icon-coffee-bag.png' );
		$feat_step1_title  = get_option( 'quills_home_feat_step1_title', "1. PICK YOUR SUBSCRIPTION" );
		$feat_step1_desc   = get_option( 'quills_home_feat_step1_desc', "Want a favorite on repeat or something new every month? Maybe a mixed bundle? Pick what you like or let us curate your morning for you." );
		$feat_icon_2       = get_option( 'quills_home_feat_icon_2', $img_dir . 'icon-calendar.png' );
		$feat_step2_title  = get_option( 'quills_home_feat_step2_title', "2. PICK HOW OFTEN" );
		$feat_step2_desc   = get_option( 'quills_home_feat_step2_desc', "Every week? Every 2 weeks? How fast are you downing it? If you're not sure, we'll help you get a close guess. You can always change it later." );
		$feat_icon_3       = get_option( 'quills_home_feat_icon_3', $img_dir . 'icon-fingerprint-cup.png' );
		$feat_step3_title  = get_option( 'quills_home_feat_step3_title', "3. ENJOY IT FROM NOW ON" );
		$feat_step3_desc   = get_option( 'quills_home_feat_step3_desc', "Start peeping out the window. We roast 4 days a week. You'll have a fresh new bag of coffee showing up just as you finish the last one." );
		$feat_cta_text     = get_option( 'quills_home_feat_cta_text', "FIND THE SUBSCRIPTION FOR YOU" );
		$feat_cta_link     = get_option( 'quills_home_feat_cta_link', home_url( '/subscriptions/' ) );
		$feat_quote        = get_option( 'quills_home_feat_quote', "“The coffee is absolutely fabulous.”<br>— Athena S." );

		// 4. Roasting
		$roast_img      = get_option( 'quills_home_roast_img', $img_dir . 'roaster-justin.jpg' );
		$roast_title    = get_option( 'quills_home_roast_title', "ROASTED LOCALLY BY US" );
		$roast_p1       = get_option( 'quills_home_roast_p1', "We roast all of our coffee ourselves, right here on Main Street in Louisville, Kentucky." );
		$roast_p2       = get_option( 'quills_home_roast_p2', "Our roasters arrive before dawn, when it’s still cool and quiet. They know the difference between a good cup of coffee and an exceptional one lives in hundreds of small decisions." );
		$roast_p3       = get_option( 'quills_home_roast_p3', "Roasting in small 45-pound batches by hand means each batch gets the kind of attention that big commercial coffee companies simply can't afford to give." );
		$roast_p4       = get_option( 'quills_home_roast_p4', "Justin, our head roaster, and his team of four are paying attention to the temperature, airflow, and the smell." );
		$roast_p5       = get_option( 'quills_home_roast_p5', "They’re listening for a distinctive “crack” of the beans that tells them right when to stop to lock in the best flavors for your coffee." );
		$roast_cta_text = get_option( 'quills_home_roast_cta_text', "SEARCH BY ROAST" );
		$roast_cta_link = get_option( 'quills_home_roast_cta_link', home_url( '/coffee/' ) );
		$roast_quote    = get_option( 'quills_home_roast_quote', "“One of the best coffee roasters in the country and beautiful shops. Worth a visit.”— Crema Guru" );

		// 5. Sourcing
		$source_img      = get_option( 'quills_home_source_img', $img_dir . 'sourcing-farm.jpg' );
		$source_title    = get_option( 'quills_home_source_title', "HAND-PICKED BY FARMERS, HAND SELECTED BY US" );
		$source_p1       = get_option( 'quills_home_source_p1', "Over 11 million tons of coffee is grown every year across the world. Less than 15% of that meets premium specialty grade coffee standards. A fancy way of saying the best of the best. (And the only kind we buy.)" );
		$source_p2       = get_option( 'quills_home_source_p2', "From that rare tier of 15%, we source and sample over 100 exceptional coffees every year." );
		$source_p3       = get_option( 'quills_home_source_p3', "And from those 100, we pick around 20 of the best to serve and ship to our customers." );
		$source_p4       = get_option( 'quills_home_source_p4', "It's like having your own personal coffee sommelier." );
		$source_p5       = get_option( 'quills_home_source_p5', "We do all this so you can enjoy exceptional coffee every single day." );
		$source_cta_text = get_option( 'quills_home_source_cta_text', "SEE WHAT WE FOUND FOR YOU" );
		$source_cta_link = get_option( 'quills_home_source_cta_link', home_url( '/coffee/' ) );
		$source_quote    = get_option( 'quills_home_source_quote', "“Excellent coffee and excellent sourcing. A place that loves wonderful coffees, the best the world has to offer.”<br>— Preston S." );

		// 6. Circular Badge
		$badge_img = get_option( 'quills_home_badge_img', $img_dir . 'badge-coffee-connect-people.png' );

		// 7. Bestsellers Title
		$bestsellers_title    = get_option( 'quills_home_bestsellers_title', "Our Bestsellers" );
		$bestsellers_subtitle = get_option( 'quills_home_bestsellers_subtitle', "The ones people keep coming back for." );

		// 8. Cupping (Taste-tested twice a week)
		$cupping_img      = get_option( 'quills_home_cupping_img', $img_dir . 'cupping-tasting.jpg' );
		$cupping_title    = get_option( 'quills_home_cupping_title', "TASTE-TESTED TWICE A WEEK" );
		$cupping_p1       = get_option( 'quills_home_cupping_p1', "Every coffee gets tested, tweaked, and perfected every week until we run out of it." );
		$cupping_p2       = get_option( 'quills_home_cupping_p2', "When we find something wrong — and we do — we dump the whole batch and start over." );
		$cupping_p3       = get_option( 'quills_home_cupping_p3', "We do this to make sure you get the absolute best flavors and aromas from every coffee you get from us." );
		$cupping_cta_text = get_option( 'quills_home_cupping_cta_text', "SHOW ME THE COFFEE" );
		$cupping_cta_link = get_option( 'quills_home_cupping_cta_link', home_url( '/coffee/' ) );
		$cupping_quote    = get_option( 'quills_home_cupping_quote', "“If you love regular ol coffee but not the regular ol taste - you will love Quills!”<br>— Amie M" );

		// 9. FAQ Accordion
		$faq_title = get_option( 'quills_home_faq_title', "FAQ" );
		$faq_q1    = get_option( 'quills_home_faq_q1', "How fresh is the coffee I get?" );
		$faq_a1    = get_option( 'quills_home_faq_a1', "All coffee is roasted to order. Our small roastery team of four guys roasts 4 days a week.\n\nWe ship coffee orders at peak freshness, after an initial resting period to degas. This way you receive your order as it's beginning to approach peak freshness, so you can get the best flavors from every bag of coffee you receive." );
		$faq_q2    = get_option( 'quills_home_faq_q2', "When will my coffee ship?" );
		$faq_a2    = get_option( 'quills_home_faq_a2', "If you order by midnight Sunday, your order will ship on Wednesday.\n\nIf you order by midnight Tuesday, your order will ship on Friday." );
		$faq_q3    = get_option( 'quills_home_faq_q3', "I’d like to work at Quills. How do I apply?" );
		$faq_a3    = get_option( 'quills_home_faq_a3', "We hire baristas often! You can <a href=\"https://form.jotform.com/quillscoffee/new-customer-registration-form\" target=\"_blank\" rel=\"noopener noreferrer\">apply here.</a>" );
		$faq_q4    = get_option( 'quills_home_faq_q4', "My question is about something else" );
		$faq_a4    = get_option( 'quills_home_faq_a4', "Go ahead and reach out to <a href=\"mailto:hello@quillscoffee.com\">hello@quillscoffee.com</a>. You're gonna talk to one of us, not a bot." );

		// 10. The Hoot
		$hoot_heading   = get_option( 'quills_home_hoot_heading', "THE HOOT" );
		$hoot_icon      = get_option( 'quills_home_hoot_icon', $img_dir . 'hoot-icon.png' );
		$hoot_p1        = get_option( 'quills_home_hoot_p1', "The Hoot is one short email from us sent every Friday morning. It takes about 5 minutes to read. It’s less of a 'newsletter' and more like an actual letter." );
		$hoot_p2        = get_option( 'quills_home_hoot_p2', "We sometimes send readers links to secret coffees and exclusive reader-only merch." );
		$hoot_highlight = get_option( 'quills_home_hoot_highlight', "8,212 kind folks" );
		$hoot_p3        = get_option( 'quills_home_hoot_p3', "currently get it sent to their inbox." );
		$hoot_p4        = get_option( 'quills_home_hoot_p4', "We share what the people behind your coffee have been up to that week. You may hear about some wild coffee our head roaster Justin has tasted. Or behind-the-scenes on the new seasonal drinks our beverage director Jess is whipping up." );
		$hoot_p5        = get_option( 'quills_home_hoot_p5', "And we always add a little something fun in the PS." );
		$hoot_cf7_id    = get_option( 'quills_home_hoot_cf7_id', "141" );
		$hoot_btn_text  = get_option( 'quills_home_hoot_btn_text', "TRY IT" );
		?>
		<style>
			.quills-admin-nav { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 25px; background: #fff; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; }
			.quills-admin-nav a { text-decoration: none; font-size: 13px; font-weight: 600; padding: 6px 12px; border-radius: 6px; background: #f1f5f9; color: #334155; transition: all .2s; }
			.quills-admin-nav a:hover { background: #663A1E; color: #fff; }
			.quills-card { background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 24px; margin-bottom: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
			.quills-card-title { font-size: 17px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 18px; border-bottom: 2px solid #663A1E; padding-bottom: 10px; display: flex; align-items: center; gap: 8px; }
			.quills-form-table { width: 100%; border-collapse: collapse; }
			.quills-form-table th { width: 230px; text-align: left; vertical-align: top; padding: 12px 15px 12px 0; font-weight: 600; color: #334155; font-size: 13.5px; }
			.quills-form-table td { padding: 8px 0; }
			.quills-form-table input[type="text"], .quills-form-table textarea { width: 100%; max-width: 680px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 14px; }
			.quills-img-row { display: flex; gap: 12px; align-items: center; margin-bottom: 6px; flex-wrap: wrap; }
			.quills-img-preview { max-height: 80px; max-width: 140px; object-fit: contain; border-radius: 4px; border: 1px solid #cbd5e1; background: #fafafa; padding: 2px; }
			.quills-desc { font-size: 12px; color: #64748b; margin-top: 4px; }
			.quills-info-banner { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 14px 18px; margin-bottom: 10px; border-radius: 0 6px 6px 0; font-size: 13px; color: #1e3a8a; line-height: 1.6; }
			.quills-step-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 16px; margin-bottom: 15px; max-width: 700px; }
		</style>

		<!-- Fast Navigation Jump Bar -->
		<div class="quills-admin-nav">
			<a href="#sec-hero">☕ 1. Hero Banner</a>
			<a href="#sec-team">👥 2. Đội ngũ (Team)</a>
			<a href="#sec-feat">📦 3. Gói Đăng Ký 3 Bước</a>
			<a href="#sec-roast">♨️ 4. Xưởng Rang</a>
			<a href="#sec-source">🌱 5. Tuyển Chọn Hạt</a>
			<a href="#sec-badge">🏷️ 6. Huy Hiệu Tròn</a>
			<a href="#sec-bestsellers">⭐ 7. Bestsellers</a>
			<a href="#sec-cupping">🧪 8. Thử Nếm Cà Phê</a>
			<a href="#sec-faq">❓ 9. Câu Hỏi FAQ</a>
			<a href="#sec-hoot">🦉 10. Bản Tin The Hoot</a>
		</div>

		<!-- SECTION 1: HERO BANNER -->
		<div class="quills-card" id="sec-hero">
			<h2 class="quills-card-title">☕ 1. Phần Hero Banner (Đầu trang chủ)</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_hero_img">Ảnh nền Hero Banner:</label></th>
					<td>
						<div class="quills-img-row">
							<img id="preview_quills_home_hero_img" src="<?php echo esc_url( self::get_image_url( $hero_img, 'home.webp' ) ); ?>" class="quills-img-preview" alt="Hero Preview" />
							<input type="text" name="quills_home_hero_img" id="quills_home_hero_img" value="<?php echo esc_attr( $hero_img ); ?>" style="max-width: 400px;">
							<button type="button" class="button quills-upload-btn" data-target="#quills_home_hero_img" data-preview="#preview_quills_home_hero_img">📁 Chọn / Tải ảnh lên</button>
							<button type="button" class="button quills-reset-btn" data-target="#quills_home_hero_img" data-preview="#preview_quills_home_hero_img" data-default="<?php echo esc_attr( $img_dir . 'home.webp' ); ?>">Khôi phục</button>
						</div>
						<div class="quills-desc">Mặc định: assets/images/home/home.webp.</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hero_title">Tiêu đề Hero Banner:</label></th>
					<td>
						<textarea name="quills_home_hero_title" id="quills_home_hero_title" rows="2"><?php echo esc_textarea( $hero_title ); ?></textarea>
						<div class="quills-desc">Hỗ trợ thẻ &lt;br&gt; để ngắt dòng đẹp mắt.</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hero_subtitle">Phụ đề Hero Banner:</label></th>
					<td>
						<textarea name="quills_home_hero_subtitle" id="quills_home_hero_subtitle" rows="2"><?php echo esc_textarea( $hero_subtitle ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hero_cta_text">Chữ trên nút Hero CTA:</label></th>
					<td>
						<input type="text" name="quills_home_hero_cta_text" id="quills_home_hero_cta_text" value="<?php echo esc_attr( $hero_cta_text ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hero_cta_link">Đường dẫn nút Hero CTA:</label></th>
					<td>
						<input type="text" name="quills_home_hero_cta_link" id="quills_home_hero_cta_link" value="<?php echo esc_attr( $hero_cta_link ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_rating_text">Dòng đánh giá sao:</label></th>
					<td>
						<input type="text" name="quills_home_rating_text" id="quills_home_rating_text" value="<?php echo esc_attr( $hero_rating ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_press_label">Nhãn báo chí đối tác:</label></th>
					<td>
						<input type="text" name="quills_home_press_label" id="quills_home_press_label" value="<?php echo esc_attr( $hero_press_label ); ?>">
					</td>
				</tr>
				<tr>
					<th><label>4 Logo Báo Chí Đối Tác:</label></th>
					<td>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; max-width: 680px;">
							<div>
								<span style="font-size: 11px; font-weight: 600;">Logo 1 (Garden & Gun):</span>
								<div class="quills-img-row">
									<img id="preview_logo1" src="<?php echo esc_url( self::get_image_url( $press_logo_1, 'logo-garden-and-gun.png' ) ); ?>" class="quills-img-preview" style="max-height: 40px;" />
									<input type="text" name="quills_home_press_logo_1" id="quills_home_press_logo_1" value="<?php echo esc_attr( $press_logo_1 ); ?>">
									<button type="button" class="button quills-upload-btn" data-target="#quills_home_press_logo_1" data-preview="#preview_logo1">Chọn</button>
								</div>
							</div>
							<div>
								<span style="font-size: 11px; font-weight: 600;">Logo 2 (Cosmopolitan):</span>
								<div class="quills-img-row">
									<img id="preview_logo2" src="<?php echo esc_url( self::get_image_url( $press_logo_2, 'logo-cosmopolitan.png' ) ); ?>" class="quills-img-preview" style="max-height: 40px;" />
									<input type="text" name="quills_home_press_logo_2" id="quills_home_press_logo_2" value="<?php echo esc_attr( $press_logo_2 ); ?>">
									<button type="button" class="button quills-upload-btn" data-target="#quills_home_press_logo_2" data-preview="#preview_logo2">Chọn</button>
								</div>
							</div>
							<div>
								<span style="font-size: 11px; font-weight: 600;">Logo 3 (Food & Wine):</span>
								<div class="quills-img-row">
									<img id="preview_logo3" src="<?php echo esc_url( self::get_image_url( $press_logo_3, 'logo-food-and-wine.png' ) ); ?>" class="quills-img-preview" style="max-height: 40px;" />
									<input type="text" name="quills_home_press_logo_3" id="quills_home_press_logo_3" value="<?php echo esc_attr( $press_logo_3 ); ?>">
									<button type="button" class="button quills-upload-btn" data-target="#quills_home_press_logo_3" data-preview="#preview_logo3">Chọn</button>
								</div>
							</div>
							<div>
								<span style="font-size: 11px; font-weight: 600;">Logo 4 (Courier Journal):</span>
								<div class="quills-img-row">
									<img id="preview_logo4" src="<?php echo esc_url( self::get_image_url( $press_logo_4, 'logo-courier-journal.png' ) ); ?>" class="quills-img-preview" style="max-height: 40px;" />
									<input type="text" name="quills_home_press_logo_4" id="quills_home_press_logo_4" value="<?php echo esc_attr( $press_logo_4 ); ?>">
									<button type="button" class="button quills-upload-btn" data-target="#quills_home_press_logo_4" data-preview="#preview_logo4">Chọn</button>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hero_quote">Câu trích dẫn khách hàng:</label></th>
					<td>
						<textarea name="quills_home_hero_quote" id="quills_home_hero_quote" rows="2"><?php echo esc_textarea( $hero_quote ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>

		<!-- SECTION 2: TEAM (NO ROBOTS. JUST PEOPLE.) -->
		<div class="quills-card" id="sec-team">
			<h2 class="quills-card-title">👥 2. Phần Đội Ngũ ("NO ROBOTS. JUST PEOPLE.")</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_team_img">Ảnh đội ngũ (Nathan):</label></th>
					<td>
						<div class="quills-img-row">
							<img id="preview_quills_home_team_img" src="<?php echo esc_url( self::get_image_url( $team_img, 'team-nathan.jpg' ) ); ?>" class="quills-img-preview" alt="Team Preview" />
							<input type="text" name="quills_home_team_img" id="quills_home_team_img" value="<?php echo esc_attr( $team_img ); ?>" style="max-width: 400px;">
							<button type="button" class="button quills-upload-btn" data-target="#quills_home_team_img" data-preview="#preview_quills_home_team_img">📁 Chọn / Tải ảnh lên</button>
							<button type="button" class="button quills-reset-btn" data-target="#quills_home_team_img" data-preview="#preview_quills_home_team_img" data-default="<?php echo esc_attr( $img_dir . 'team-nathan.jpg' ); ?>">Khôi phục</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_title">Tiêu đề mục:</label></th>
					<td>
						<input type="text" name="quills_home_team_title" id="quills_home_team_title" value="<?php echo esc_attr( $team_title ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p1">Đoạn văn 1:</label></th>
					<td><textarea name="quills_home_team_p1" id="quills_home_team_p1" rows="2"><?php echo esc_textarea( $team_p1 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p2">Đoạn văn 2:</label></th>
					<td><textarea name="quills_home_team_p2" id="quills_home_team_p2" rows="2"><?php echo esc_textarea( $team_p2 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p3">Đoạn văn 3:</label></th>
					<td><textarea name="quills_home_team_p3" id="quills_home_team_p3" rows="2"><?php echo esc_textarea( $team_p3 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p4">Đoạn văn 4:</label></th>
					<td><textarea name="quills_home_team_p4" id="quills_home_team_p4" rows="2"><?php echo esc_textarea( $team_p4 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p5">Đoạn văn 5:</label></th>
					<td><textarea name="quills_home_team_p5" id="quills_home_team_p5" rows="2"><?php echo esc_textarea( $team_p5 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_team_cta_text">Chữ trên nút Team CTA:</label></th>
					<td><input type="text" name="quills_home_team_cta_text" id="quills_home_team_cta_text" value="<?php echo esc_attr( $team_cta_text ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_team_cta_link">Đường dẫn nút Team CTA:</label></th>
					<td><input type="text" name="quills_home_team_cta_link" id="quills_home_team_cta_link" value="<?php echo esc_attr( $team_cta_link ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_team_quote">Trích dẫn đánh giá:</label></th>
					<td><input type="text" name="quills_home_team_quote" id="quills_home_team_quote" value="<?php echo esc_attr( $team_quote ); ?>"></td>
				</tr>
			</table>
		</div>

		<!-- SECTION 3: FEATURES BANNER (SUBSCRIPTION 3 STEPS) -->
		<div class="quills-card" id="sec-feat">
			<h2 class="quills-card-title">📦 3. Mục Đăng Ký Định Kỳ 3 Bước (Subscriptions Features)</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_feat_title">Tiêu đề chính mục:</label></th>
					<td>
						<input type="text" name="quills_home_feat_title" id="quills_home_feat_title" value="<?php echo esc_attr( $feat_title ); ?>">
					</td>
				</tr>
				<tr>
					<th><label>Bước 1 (Pick Subscription):</label></th>
					<td>
						<div class="quills-step-box">
							<div class="quills-img-row">
								<img id="preview_feat1" src="<?php echo esc_url( self::get_image_url( $feat_icon_1, 'icon-coffee-bag.png' ) ); ?>" class="quills-img-preview" style="max-height: 48px;" />
								<input type="text" name="quills_home_feat_icon_1" id="quills_home_feat_icon_1" value="<?php echo esc_attr( $feat_icon_1 ); ?>" placeholder="Icon URL">
								<button type="button" class="button quills-upload-btn" data-target="#quills_home_feat_icon_1" data-preview="#preview_feat1">Chọn Icon</button>
							</div>
							<input type="text" name="quills_home_feat_step1_title" value="<?php echo esc_attr( $feat_step1_title ); ?>" placeholder="Tiêu đề bước 1" style="margin-bottom: 8px;">
							<textarea name="quills_home_feat_step1_desc" rows="2" placeholder="Mô tả bước 1"><?php echo esc_textarea( $feat_step1_desc ); ?></textarea>
						</div>
					</td>
				</tr>
				<tr>
					<th><label>Bước 2 (Pick How Often):</label></th>
					<td>
						<div class="quills-step-box">
							<div class="quills-img-row">
								<img id="preview_feat2" src="<?php echo esc_url( self::get_image_url( $feat_icon_2, 'icon-calendar.png' ) ); ?>" class="quills-img-preview" style="max-height: 48px;" />
								<input type="text" name="quills_home_feat_icon_2" id="quills_home_feat_icon_2" value="<?php echo esc_attr( $feat_icon_2 ); ?>" placeholder="Icon URL">
								<button type="button" class="button quills-upload-btn" data-target="#quills_home_feat_icon_2" data-preview="#preview_feat2">Chọn Icon</button>
							</div>
							<input type="text" name="quills_home_feat_step2_title" value="<?php echo esc_attr( $feat_step2_title ); ?>" placeholder="Tiêu đề bước 2" style="margin-bottom: 8px;">
							<textarea name="quills_home_feat_step2_desc" rows="2" placeholder="Mô tả bước 2"><?php echo esc_textarea( $feat_step2_desc ); ?></textarea>
						</div>
					</td>
				</tr>
				<tr>
					<th><label>Bước 3 (Enjoy From Now On):</label></th>
					<td>
						<div class="quills-step-box">
							<div class="quills-img-row">
								<img id="preview_feat3" src="<?php echo esc_url( self::get_image_url( $feat_icon_3, 'icon-fingerprint-cup.png' ) ); ?>" class="quills-img-preview" style="max-height: 48px;" />
								<input type="text" name="quills_home_feat_icon_3" id="quills_home_feat_icon_3" value="<?php echo esc_attr( $feat_icon_3 ); ?>" placeholder="Icon URL">
								<button type="button" class="button quills-upload-btn" data-target="#quills_home_feat_icon_3" data-preview="#preview_feat3">Chọn Icon</button>
							</div>
							<input type="text" name="quills_home_feat_step3_title" value="<?php echo esc_attr( $feat_step3_title ); ?>" placeholder="Tiêu đề bước 3" style="margin-bottom: 8px;">
							<textarea name="quills_home_feat_step3_desc" rows="2" placeholder="Mô tả bước 3"><?php echo esc_textarea( $feat_step3_desc ); ?></textarea>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_feat_cta_text">Chữ trên nút CTA:</label></th>
					<td><input type="text" name="quills_home_feat_cta_text" id="quills_home_feat_cta_text" value="<?php echo esc_attr( $feat_cta_text ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_feat_cta_link">Đường dẫn nút CTA:</label></th>
					<td><input type="text" name="quills_home_feat_cta_link" id="quills_home_feat_cta_link" value="<?php echo esc_attr( $feat_cta_link ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_feat_quote">Lời trích dẫn:</label></th>
					<td><textarea name="quills_home_feat_quote" id="quills_home_feat_quote" rows="2"><?php echo esc_textarea( $feat_quote ); ?></textarea></td>
				</tr>
			</table>
		</div>

		<!-- SECTION 4: ROASTED LOCALLY BY US -->
		<div class="quills-card" id="sec-roast">
			<h2 class="quills-card-title">♨️ 4. Phần Xưởng Rang ("ROASTED LOCALLY BY US")</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_roast_img">Ảnh thợ rang (Justin):</label></th>
					<td>
						<div class="quills-img-row">
							<img id="preview_quills_home_roast_img" src="<?php echo esc_url( self::get_image_url( $roast_img, 'roaster-justin.jpg' ) ); ?>" class="quills-img-preview" alt="Roast Preview" />
							<input type="text" name="quills_home_roast_img" id="quills_home_roast_img" value="<?php echo esc_attr( $roast_img ); ?>" style="max-width: 400px;">
							<button type="button" class="button quills-upload-btn" data-target="#quills_home_roast_img" data-preview="#preview_quills_home_roast_img">📁 Chọn / Tải ảnh lên</button>
							<button type="button" class="button quills-reset-btn" data-target="#quills_home_roast_img" data-preview="#preview_quills_home_roast_img" data-default="<?php echo esc_attr( $img_dir . 'roaster-justin.jpg' ); ?>">Khôi phục</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_title">Tiêu đề mục:</label></th>
					<td><input type="text" name="quills_home_roast_title" id="quills_home_roast_title" value="<?php echo esc_attr( $roast_title ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_p1">Đoạn văn 1:</label></th>
					<td><textarea name="quills_home_roast_p1" id="quills_home_roast_p1" rows="2"><?php echo esc_textarea( $roast_p1 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_p2">Đoạn văn 2:</label></th>
					<td><textarea name="quills_home_roast_p2" id="quills_home_roast_p2" rows="2"><?php echo esc_textarea( $roast_p2 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_p3">Đoạn văn 3:</label></th>
					<td><textarea name="quills_home_roast_p3" id="quills_home_roast_p3" rows="2"><?php echo esc_textarea( $roast_p3 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_p4">Đoạn văn 4:</label></th>
					<td><textarea name="quills_home_roast_p4" id="quills_home_roast_p4" rows="2"><?php echo esc_textarea( $roast_p4 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_p5">Đoạn văn 5:</label></th>
					<td><textarea name="quills_home_roast_p5" id="quills_home_roast_p5" rows="2"><?php echo esc_textarea( $roast_p5 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_cta_text">Chữ trên nút CTA:</label></th>
					<td><input type="text" name="quills_home_roast_cta_text" id="quills_home_roast_cta_text" value="<?php echo esc_attr( $roast_cta_text ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_cta_link">Đường dẫn nút CTA:</label></th>
					<td><input type="text" name="quills_home_roast_cta_link" id="quills_home_roast_cta_link" value="<?php echo esc_attr( $roast_cta_link ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_roast_quote">Trích dẫn đánh giá:</label></th>
					<td><textarea name="quills_home_roast_quote" id="quills_home_roast_quote" rows="2"><?php echo esc_textarea( $roast_quote ); ?></textarea></td>
				</tr>
			</table>
		</div>

		<!-- SECTION 5: HAND-PICKED BY FARMERS -->
		<div class="quills-card" id="sec-source">
			<h2 class="quills-card-title">🌱 5. Phần Nguồn Gốc Hạt Tuyển Chọn ("HAND-PICKED BY FARMERS")</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_source_img">Ảnh nông trại:</label></th>
					<td>
						<div class="quills-img-row">
							<img id="preview_quills_home_source_img" src="<?php echo esc_url( self::get_image_url( $source_img, 'sourcing-farm.jpg' ) ); ?>" class="quills-img-preview" alt="Source Preview" />
							<input type="text" name="quills_home_source_img" id="quills_home_source_img" value="<?php echo esc_attr( $source_img ); ?>" style="max-width: 400px;">
							<button type="button" class="button quills-upload-btn" data-target="#quills_home_source_img" data-preview="#preview_quills_home_source_img">📁 Chọn / Tải ảnh lên</button>
							<button type="button" class="button quills-reset-btn" data-target="#quills_home_source_img" data-preview="#preview_quills_home_source_img" data-default="<?php echo esc_attr( $img_dir . 'sourcing-farm.jpg' ); ?>">Khôi phục</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_source_title">Tiêu đề mục:</label></th>
					<td><input type="text" name="quills_home_source_title" id="quills_home_source_title" value="<?php echo esc_attr( $source_title ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_p1">Đoạn văn 1:</label></th>
					<td><textarea name="quills_home_source_p1" id="quills_home_source_p1" rows="2"><?php echo esc_textarea( $source_p1 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_p2">Đoạn văn 2:</label></th>
					<td><textarea name="quills_home_source_p2" id="quills_home_source_p2" rows="2"><?php echo esc_textarea( $source_p2 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_p3">Đoạn văn 3:</label></th>
					<td><textarea name="quills_home_source_p3" id="quills_home_source_p3" rows="2"><?php echo esc_textarea( $source_p3 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_p4">Đoạn văn 4:</label></th>
					<td><textarea name="quills_home_source_p4" id="quills_home_source_p4" rows="2"><?php echo esc_textarea( $source_p4 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_p5">Đoạn văn 5:</label></th>
					<td><textarea name="quills_home_source_p5" id="quills_home_source_p5" rows="2"><?php echo esc_textarea( $source_p5 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_cta_text">Chữ trên nút CTA:</label></th>
					<td><input type="text" name="quills_home_source_cta_text" id="quills_home_source_cta_text" value="<?php echo esc_attr( $source_cta_text ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_cta_link">Đường dẫn nút CTA:</label></th>
					<td><input type="text" name="quills_home_source_cta_link" id="quills_home_source_cta_link" value="<?php echo esc_attr( $source_cta_link ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_source_quote">Trích dẫn đánh giá:</label></th>
					<td><textarea name="quills_home_source_quote" id="quills_home_source_quote" rows="2"><?php echo esc_textarea( $source_quote ); ?></textarea></td>
				</tr>
			</table>
		</div>

		<!-- SECTION 6: CIRCULAR BADGE -->
		<div class="quills-card" id="sec-badge">
			<h2 class="quills-card-title">🏷️ 6. Phần Huy Hiệu Tròn ("COFFEE CONNECT PEOPLE")</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_badge_img">Ảnh huy hiệu tròn:</label></th>
					<td>
						<div class="quills-img-row">
							<img id="preview_quills_home_badge_img" src="<?php echo esc_url( self::get_image_url( $badge_img, 'badge-coffee-connect-people.png' ) ); ?>" class="quills-img-preview" alt="Badge Preview" />
							<input type="text" name="quills_home_badge_img" id="quills_home_badge_img" value="<?php echo esc_attr( $badge_img ); ?>" style="max-width: 400px;">
							<button type="button" class="button quills-upload-btn" data-target="#quills_home_badge_img" data-preview="#preview_quills_home_badge_img">📁 Chọn / Tải ảnh lên</button>
							<button type="button" class="button quills-reset-btn" data-target="#quills_home_badge_img" data-preview="#preview_quills_home_badge_img" data-default="<?php echo esc_attr( $img_dir . 'badge-coffee-connect-people.png' ); ?>">Khôi phục</button>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<!-- SECTION 7: BESTSELLERS INFO & HEADER -->
		<div class="quills-card" id="sec-bestsellers">
			<h2 class="quills-card-title">⭐ 7. Sản Phẩm Bestsellers Trang Chủ</h2>
			<table class="quills-form-table" style="margin-bottom: 20px;">
				<tr>
					<th><label for="quills_home_bestsellers_title">Tiêu đề mục:</label></th>
					<td><input type="text" name="quills_home_bestsellers_title" id="quills_home_bestsellers_title" value="<?php echo esc_attr( $bestsellers_title ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_bestsellers_subtitle">Phụ đề mục:</label></th>
					<td><input type="text" name="quills_home_bestsellers_subtitle" id="quills_home_bestsellers_subtitle" value="<?php echo esc_attr( $bestsellers_subtitle ); ?>"></td>
				</tr>
			</table>
			<div class="quills-info-banner">
				<strong>ℹ️ Lưu ý quan trọng:</strong> 3 sản phẩm bán chạy nhất hiển thị trên Trang Chủ (<strong>Blacksmith</strong>, <strong>Inkwell</strong>, và <strong>Southern Gothic</strong>) được quản lý 100% tự động từ menu <strong>Products (Sản phẩm)</strong>.
				<br><br>
				Bạn chỉ cần vào <strong>Products $\rightarrow$ All Products</strong>, click vào sản phẩm tương ứng để:
				<ul style="margin: 8px 0 0 20px; list-style: disc;">
					<li>Đổi Tên, Giá bán, Ảnh túi cà phê</li>
					<li>Đổi Nhãn nổi bật (Tag: BLACKSMITH, INKWELL...), Màu nhãn (Tag Color: #1c1d1d, #EB5A3C...)</li>
					<li>Đổi Đoạn mô tả ngắn gọn (Tag Description)</li>
				</ul>
				Tất cả thay đổi sẽ đồng bộ hiển thị ngay lập tức trên trang chủ!
			</div>
		</div>

		<!-- SECTION 8: CUPPING (TASTE-TESTED TWICE A WEEK) -->
		<div class="quills-card" id="sec-cupping">
			<h2 class="quills-card-title">🧪 8. Phần Thử Nếm Cà Phê ("TASTE-TESTED TWICE A WEEK")</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_cupping_img">Ảnh buổi thử nếm:</label></th>
					<td>
						<div class="quills-img-row">
							<img id="preview_quills_home_cupping_img" src="<?php echo esc_url( self::get_image_url( $cupping_img, 'cupping-tasting.jpg' ) ); ?>" class="quills-img-preview" alt="Cupping Preview" />
							<input type="text" name="quills_home_cupping_img" id="quills_home_cupping_img" value="<?php echo esc_attr( $cupping_img ); ?>" style="max-width: 400px;">
							<button type="button" class="button quills-upload-btn" data-target="#quills_home_cupping_img" data-preview="#preview_quills_home_cupping_img">📁 Chọn / Tải ảnh lên</button>
							<button type="button" class="button quills-reset-btn" data-target="#quills_home_cupping_img" data-preview="#preview_quills_home_cupping_img" data-default="<?php echo esc_attr( $img_dir . 'cupping-tasting.jpg' ); ?>">Khôi phục</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_cupping_title">Tiêu đề mục:</label></th>
					<td><input type="text" name="quills_home_cupping_title" id="quills_home_cupping_title" value="<?php echo esc_attr( $cupping_title ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_cupping_p1">Đoạn văn 1:</label></th>
					<td><textarea name="quills_home_cupping_p1" id="quills_home_cupping_p1" rows="2"><?php echo esc_textarea( $cupping_p1 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_cupping_p2">Đoạn văn 2:</label></th>
					<td><textarea name="quills_home_cupping_p2" id="quills_home_cupping_p2" rows="2"><?php echo esc_textarea( $cupping_p2 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_cupping_p3">Đoạn văn 3:</label></th>
					<td><textarea name="quills_home_cupping_p3" id="quills_home_cupping_p3" rows="2"><?php echo esc_textarea( $cupping_p3 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_cupping_cta_text">Chữ trên nút CTA:</label></th>
					<td><input type="text" name="quills_home_cupping_cta_text" id="quills_home_cupping_cta_text" value="<?php echo esc_attr( $cupping_cta_text ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_cupping_cta_link">Đường dẫn nút CTA:</label></th>
					<td><input type="text" name="quills_home_cupping_cta_link" id="quills_home_cupping_cta_link" value="<?php echo esc_attr( $cupping_cta_link ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_cupping_quote">Trích dẫn đánh giá:</label></th>
					<td><textarea name="quills_home_cupping_quote" id="quills_home_cupping_quote" rows="2"><?php echo esc_textarea( $cupping_quote ); ?></textarea></td>
				</tr>
			</table>
		</div>

		<!-- SECTION 9: FAQ ACCORDION -->
		<div class="quills-card" id="sec-faq">
			<h2 class="quills-card-title">❓ 9. Phần Câu Hỏi Thường Gặp (FAQ Accordion)</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_faq_title">Tiêu đề mục FAQ:</label></th>
					<td><input type="text" name="quills_home_faq_title" id="quills_home_faq_title" value="<?php echo esc_attr( $faq_title ); ?>"></td>
				</tr>
				<tr>
					<th><label>Câu hỏi 1:</label></th>
					<td>
						<input type="text" name="quills_home_faq_q1" value="<?php echo esc_attr( $faq_q1 ); ?>" style="margin-bottom: 6px;" placeholder="Câu hỏi 1">
						<textarea name="quills_home_faq_a1" rows="3" placeholder="Câu trả lời 1"><?php echo esc_textarea( $faq_a1 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label>Câu hỏi 2:</label></th>
					<td>
						<input type="text" name="quills_home_faq_q2" value="<?php echo esc_attr( $faq_q2 ); ?>" style="margin-bottom: 6px;" placeholder="Câu hỏi 2">
						<textarea name="quills_home_faq_a2" rows="3" placeholder="Câu trả lời 2"><?php echo esc_textarea( $faq_a2 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label>Câu hỏi 3:</label></th>
					<td>
						<input type="text" name="quills_home_faq_q3" value="<?php echo esc_attr( $faq_q3 ); ?>" style="margin-bottom: 6px;" placeholder="Câu hỏi 3">
						<textarea name="quills_home_faq_a3" rows="3" placeholder="Câu trả lời 3"><?php echo esc_textarea( $faq_a3 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label>Câu hỏi 4:</label></th>
					<td>
						<input type="text" name="quills_home_faq_q4" value="<?php echo esc_attr( $faq_q4 ); ?>" style="margin-bottom: 6px;" placeholder="Câu hỏi 4">
						<textarea name="quills_home_faq_a4" rows="3" placeholder="Câu trả lời 4"><?php echo esc_textarea( $faq_a4 ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>

		<!-- SECTION 10: THE HOOT (NEWSLETTER) -->
		<div class="quills-card" id="sec-hoot">
			<h2 class="quills-card-title">🦉 10. Phần Đăng Ký Bản Tin (The Hoot Newsletter)</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_hoot_heading">Tiêu đề chính:</label></th>
					<td><input type="text" name="quills_home_hoot_heading" id="quills_home_hoot_heading" value="<?php echo esc_attr( $hoot_heading ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_icon">Icon con cú (The Hoot):</label></th>
					<td>
						<div class="quills-img-row">
							<img id="preview_quills_home_hoot_icon" src="<?php echo esc_url( self::get_image_url( $hoot_icon, 'hoot-icon.png' ) ); ?>" class="quills-img-preview" style="max-height: 48px;" alt="Hoot Icon" />
							<input type="text" name="quills_home_hoot_icon" id="quills_home_hoot_icon" value="<?php echo esc_attr( $hoot_icon ); ?>" style="max-width: 400px;">
							<button type="button" class="button quills-upload-btn" data-target="#quills_home_hoot_icon" data-preview="#preview_quills_home_hoot_icon">📁 Chọn</button>
						</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_p1">Đoạn văn 1:</label></th>
					<td><textarea name="quills_home_hoot_p1" id="quills_home_hoot_p1" rows="2"><?php echo esc_textarea( $hoot_p1 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_p2">Đoạn văn 2:</label></th>
					<td><textarea name="quills_home_hoot_p2" id="quills_home_hoot_p2" rows="2"><?php echo esc_textarea( $hoot_p2 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_highlight">Chữ số người đăng ký nổi bật:</label></th>
					<td>
						<input type="text" name="quills_home_hoot_highlight" id="quills_home_hoot_highlight" value="<?php echo esc_attr( $hoot_highlight ); ?>" style="max-width: 300px;">
						<span style="color: #64748b; font-size: 13px; margin-left: 10px;">(Hiển thị màu cam nổi bật)</span>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_p3">Đoạn văn 3 (vế sau số người):</label></th>
					<td><input type="text" name="quills_home_hoot_p3" id="quills_home_hoot_p3" value="<?php echo esc_attr( $hoot_p3 ); ?>"></td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_p4">Đoạn văn 4:</label></th>
					<td><textarea name="quills_home_hoot_p4" id="quills_home_hoot_p4" rows="2"><?php echo esc_textarea( $hoot_p4 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_p5">Đoạn văn 5:</label></th>
					<td><textarea name="quills_home_hoot_p5" id="quills_home_hoot_p5" rows="2"><?php echo esc_textarea( $hoot_p5 ); ?></textarea></td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_cf7_id">ID Form Contact Form 7:</label></th>
					<td>
						<input type="text" name="quills_home_hoot_cf7_id" id="quills_home_hoot_cf7_id" value="<?php echo esc_attr( $hoot_cf7_id ); ?>" style="max-width: 150px;">
						<div class="quills-desc">Mặc định: 141. Nhập ID form Contact Form 7 để tích hợp gửi email.</div>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_hoot_btn_text">Chữ trên nút (Form dự phòng):</label></th>
					<td><input type="text" name="quills_home_hoot_btn_text" id="quills_home_hoot_btn_text" value="<?php echo esc_attr( $hoot_btn_text ); ?>" style="max-width: 200px;"></td>
				</tr>
			</table>
		</div>

		<!-- Script for Media Uploader & Reset -->
		<script>
		jQuery(document).ready(function($) {
			$('.quills-upload-btn').on('click', function(e) {
				e.preventDefault();
				var targetInput = $( $(this).data('target') );
				var previewImg  = $( $(this).data('preview') );

				var frame = wp.media({
					title: 'Chọn hoặc tải ảnh lên cho Trang Chủ',
					button: { text: 'Sử dụng ảnh này' },
					multiple: false
				});

				frame.on('select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					targetInput.val(attachment.url);
					if (previewImg.length) {
						previewImg.attr('src', attachment.url);
					}
				});

				frame.open();
			});

			$('.quills-reset-btn').on('click', function(e) {
				e.preventDefault();
				var targetInput = $( $(this).data('target') );
				var previewImg  = $( $(this).data('preview') );
				var defaultVal  = $(this).data('default');
				targetInput.val(defaultVal);
				if (previewImg.length) {
					previewImg.attr('src', defaultVal);
				}
			});
		});
		</script>
		<?php
	}

	/**
	 * Handle POST submission from Appearance -> Cài đặt Trang chủ
	 */
	public static function handle_home_settings_save() {
		add_action( 'admin_post_quills_save_home_settings', function() {
			if ( ! isset( $_POST['quills_home_settings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['quills_home_settings_nonce'] ) ), 'quills_home_settings_action' ) ) {
				wp_die( 'Lỗi bảo mật (Invalid nonce).' );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( 'Bạn không có quyền thực hiện thao tác này.' );
			}

			self::save_home_fields( $_POST );

			wp_safe_redirect( add_query_arg( array( 'page' => 'quills-home-settings', 'updated' => '1' ), admin_url( 'themes.php' ) ) );
			exit;
		} );
	}

	/**
	 * Save fields to wp_options
	 */
	public static function save_home_fields( $data ) {
		$text_fields = array(
			// Section 1: Hero
			'quills_home_hero_img',
			'quills_home_hero_cta_text',
			'quills_home_hero_cta_link',
			'quills_home_hero_stars_img',
			'quills_home_rating_text',
			'quills_home_press_label',
			'quills_home_press_logo_1',
			'quills_home_press_logo_2',
			'quills_home_press_logo_3',
			'quills_home_press_logo_4',

			// Section 2: Team
			'quills_home_team_img',
			'quills_home_team_title',
			'quills_home_team_cta_text',
			'quills_home_team_cta_link',
			'quills_home_team_quote',

			// Section 3: Features
			'quills_home_feat_title',
			'quills_home_feat_icon_1',
			'quills_home_feat_step1_title',
			'quills_home_feat_icon_2',
			'quills_home_feat_step2_title',
			'quills_home_feat_icon_3',
			'quills_home_feat_step3_title',
			'quills_home_feat_cta_text',
			'quills_home_feat_cta_link',

			// Section 4: Roasting
			'quills_home_roast_img',
			'quills_home_roast_title',
			'quills_home_roast_cta_text',
			'quills_home_roast_cta_link',

			// Section 5: Sourcing
			'quills_home_source_img',
			'quills_home_source_title',
			'quills_home_source_cta_text',
			'quills_home_source_cta_link',

			// Section 6: Badge
			'quills_home_badge_img',

			// Section 7: Bestsellers Header
			'quills_home_bestsellers_title',
			'quills_home_bestsellers_subtitle',

			// Section 8: Cupping
			'quills_home_cupping_img',
			'quills_home_cupping_title',
			'quills_home_cupping_cta_text',
			'quills_home_cupping_cta_link',

			// Section 9: FAQ
			'quills_home_faq_title',
			'quills_home_faq_q1',
			'quills_home_faq_q2',
			'quills_home_faq_q3',
			'quills_home_faq_q4',

			// Section 10: The Hoot
			'quills_home_hoot_heading',
			'quills_home_hoot_icon',
			'quills_home_hoot_highlight',
			'quills_home_hoot_p3',
			'quills_home_hoot_cf7_id',
			'quills_home_hoot_btn_text',
		);

		foreach ( $text_fields as $field ) {
			if ( isset( $data[ $field ] ) ) {
				update_option( $field, sanitize_text_field( wp_unslash( $data[ $field ] ) ) );
			}
		}

		$textarea_fields = array(
			'quills_home_hero_title',
			'quills_home_hero_subtitle',
			'quills_home_hero_quote',

			'quills_home_team_p1',
			'quills_home_team_p2',
			'quills_home_team_p3',
			'quills_home_team_p4',
			'quills_home_team_p5',

			'quills_home_feat_step1_desc',
			'quills_home_feat_step2_desc',
			'quills_home_feat_step3_desc',
			'quills_home_feat_quote',

			'quills_home_roast_p1',
			'quills_home_roast_p2',
			'quills_home_roast_p3',
			'quills_home_roast_p4',
			'quills_home_roast_p5',
			'quills_home_roast_quote',

			'quills_home_source_p1',
			'quills_home_source_p2',
			'quills_home_source_p3',
			'quills_home_source_p4',
			'quills_home_source_p5',
			'quills_home_source_quote',

			'quills_home_cupping_p1',
			'quills_home_cupping_p2',
			'quills_home_cupping_p3',
			'quills_home_cupping_quote',

			'quills_home_faq_a1',
			'quills_home_faq_a2',
			'quills_home_faq_a3',
			'quills_home_faq_a4',

			'quills_home_hoot_p1',
			'quills_home_hoot_p2',
			'quills_home_hoot_p4',
			'quills_home_hoot_p5',
		);

		$allowed = array(
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'p'      => array(),
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'class'  => array(),
			),
			'span'   => array(
				'class' => array(),
				'style' => array(),
			),
		);

		foreach ( $textarea_fields as $field ) {
			if ( isset( $data[ $field ] ) ) {
				update_option( $field, wp_kses( wp_unslash( $data[ $field ] ), $allowed ) );
			}
		}

		// Clear transients & cache
		delete_transient( 'quills_home_content' );
		clean_post_cache( 0 );
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}
		self::clear_page_cache();
	}

	/**
	 * Invalidate high-speed RAM and disk page cache
	 */
	public static function clear_page_cache() {
		$dirs = array( '/dev/shm/quills_page_cache', WP_CONTENT_DIR . '/cache/quills_page_cache' );
		foreach ( $dirs as $d ) {
			if ( is_dir( $d ) ) {
				$files = glob( $d . '/*.html' );
				if ( $files ) {
					foreach ( $files as $f ) {
						@unlink( $f );
					}
				}
			}
		}
	}
}

Coffee_Cafe_Corner_Page_Content_Admin::init();
