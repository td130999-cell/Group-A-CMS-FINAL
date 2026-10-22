<?php
/**
 * Class Coffee_Cafe_Corner_Page_Content_Admin
 *
 * Provides dedicated WordPress Admin UI for managing page content:
 * - Home Page: Hero Banner Title, Subtitle, CTA Button, Reviews, Team Section ("NO ROBOTS. JUST PEOPLE.")
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
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_page_meta_boxes' ) );
		add_action( 'save_post_page', array( __CLASS__, 'save_page_meta' ), 10, 2 );
		add_action( 'admin_init', array( __CLASS__, 'handle_home_settings_save' ) );
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
				__( '🏠 Quản lý Nội dung Trang Chủ (Home Banner & Team Section)', 'coffee-cafe-corner' ),
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
	 * Render Meta Box for Home Page (in page 12 'Home')
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
			<h1>🏠 Quản lý Nội dung Trang Chủ (Quills Home Page)</h1>
			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><strong>Dữ liệu Trang chủ đã được lưu thành công vào Database!</strong> Hãy tải lại trang chủ để xem thay đổi.</p>
				</div>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="quills_save_home_settings">
				<?php wp_nonce_field( 'quills_home_settings_action', 'quills_home_settings_nonce' ); ?>

				<?php self::render_home_form_fields(); ?>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary button-large" value="💾 Lưu Thay Đổi Trang Chủ (Save Settings)">
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Shared Form Fields for Home Page
	 */
	public static function render_home_form_fields() {
		$hero_title    = get_option( 'quills_home_hero_title', "We find them, we roast them, you<br>just enjoy them." );
		$hero_subtitle = get_option( 'quills_home_hero_subtitle', "Get new delicious coffees that you and your guests will love, delivered<br>to your door on your schedule." );
		$hero_cta_text = get_option( 'quills_home_hero_cta_text', "START YOUR SUBSCRIPTION" );
		$hero_cta_link = get_option( 'quills_home_hero_cta_link', home_url( '/subscriptions/' ) );
		$hero_rating   = get_option( 'quills_home_rating_text', "4.62 stars across 13,082 reviews" );
		$hero_quote    = get_option( 'quills_home_hero_quote', "“I’ve searched far and wide and this is the place to get your cup or bag of greatness if you happen to be a true coffee aficionado.” — Jacob Y." );

		$team_title    = get_option( 'quills_home_team_title', "NO ROBOTS. JUST PEOPLE." );
		$team_p1       = get_option( 'quills_home_team_p1', "You should know who's choosing and roasting your coffee. No algorithms here." );
		$team_p2       = get_option( 'quills_home_team_p2', "It’s a small group of real people in the heart of Louisville, Kentucky who love finding and making great coffee and care about sharing it with you." );
		$team_p3       = get_option( 'quills_home_team_p3', "It’s our founder, Nathan, four operations team members, five roasters, four cafe managers, and 42 baristas." );
		$team_p4       = get_option( 'quills_home_team_p4', "Some of us have worked in coffee for years. Others discovered their passion more recently. What we all have in common is this belief that coffee should bring people together." );
		$team_p5       = get_option( 'quills_home_team_p5', "We’re doing our best to deliver coffee that connects people." );
		$team_cta_text = get_option( 'quills_home_team_cta_text', "SHOW ME THE COFFEE" );
		$team_cta_link = get_option( 'quills_home_team_cta_link', home_url( '/coffee/' ) );
		$team_quote    = get_option( 'quills_home_team_quote', "“The best tasting pour over coffee on this planet.” — Kelsey B." );
		?>
		<style>
			.quills-card { background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 22px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
			.quills-card-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 15px; border-bottom: 2px solid #663A1E; padding-bottom: 8px; display: flex; align-items: center; gap: 8px; }
			.quills-form-table { width: 100%; border-collapse: collapse; }
			.quills-form-table th { width: 220px; text-align: left; vertical-align: top; padding: 12px 15px 12px 0; font-weight: 600; color: #334155; font-size: 13.5px; }
			.quills-form-table td { padding: 8px 0; }
			.quills-form-table input[type="text"], .quills-form-table textarea { width: 100%; max-width: 650px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 14px; }
			.quills-desc { font-size: 12px; color: #64748b; margin-top: 4px; }
			.quills-info-banner { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 12px 16px; margin-bottom: 20px; border-radius: 0 6px 6px 0; font-size: 13px; color: #1e3a8a; }
		</style>

		<!-- SECTION 1: HERO BANNER -->
		<div class="quills-card">
			<h2 class="quills-card-title">☕ 1. Phần Hero Banner (Đầu trang chủ)</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_hero_title">Tiêu đề Hero Banner:</label></th>
					<td>
						<textarea name="quills_home_hero_title" id="quills_home_hero_title" rows="2"><?php echo esc_textarea( $hero_title ); ?></textarea>
						<div class="quills-desc">Hỗ trợ thẻ &lt;br&gt; để ngắt dòng.</div>
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
					<th><label for="quills_home_hero_quote">Câu trích dẫn khách hàng:</label></th>
					<td>
						<textarea name="quills_home_hero_quote" id="quills_home_hero_quote" rows="2"><?php echo esc_textarea( $hero_quote ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>

		<!-- SECTION 2: TEAM (NO ROBOTS. JUST PEOPLE.) -->
		<div class="quills-card">
			<h2 class="quills-card-title">👥 2. Phần Đội Ngũ ("NO ROBOTS. JUST PEOPLE.")</h2>
			<table class="quills-form-table">
				<tr>
					<th><label for="quills_home_team_title">Tiêu đề mục:</label></th>
					<td>
						<input type="text" name="quills_home_team_title" id="quills_home_team_title" value="<?php echo esc_attr( $team_title ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p1">Đoạn văn 1:</label></th>
					<td>
						<textarea name="quills_home_team_p1" id="quills_home_team_p1" rows="2"><?php echo esc_textarea( $team_p1 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p2">Đoạn văn 2:</label></th>
					<td>
						<textarea name="quills_home_team_p2" id="quills_home_team_p2" rows="2"><?php echo esc_textarea( $team_p2 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p3">Đoạn văn 3:</label></th>
					<td>
						<textarea name="quills_home_team_p3" id="quills_home_team_p3" rows="2"><?php echo esc_textarea( $team_p3 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p4">Đoạn văn 4:</label></th>
					<td>
						<textarea name="quills_home_team_p4" id="quills_home_team_p4" rows="2"><?php echo esc_textarea( $team_p4 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_p5">Đoạn văn 5:</label></th>
					<td>
						<textarea name="quills_home_team_p5" id="quills_home_team_p5" rows="2"><?php echo esc_textarea( $team_p5 ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_cta_text">Chữ trên nút Team CTA:</label></th>
					<td>
						<input type="text" name="quills_home_team_cta_text" id="quills_home_team_cta_text" value="<?php echo esc_attr( $team_cta_text ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_cta_link">Đường dẫn nút Team CTA:</label></th>
					<td>
						<input type="text" name="quills_home_team_cta_link" id="quills_home_team_cta_link" value="<?php echo esc_attr( $team_cta_link ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="quills_home_team_quote">Trích dẫn đánh giá:</label></th>
					<td>
						<input type="text" name="quills_home_team_quote" id="quills_home_team_quote" value="<?php echo esc_attr( $team_quote ); ?>">
					</td>
				</tr>
			</table>
		</div>

		<!-- SECTION 3: BESTSELLERS INFO -->
		<div class="quills-card">
			<h2 class="quills-card-title">⭐ 3. Sản Phẩm Bestsellers Trang Chủ</h2>
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
			'quills_home_hero_cta_text',
			'quills_home_hero_cta_link',
			'quills_home_rating_text',
			'quills_home_team_title',
			'quills_home_team_cta_text',
			'quills_home_team_cta_link',
			'quills_home_team_quote',
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
		);

		foreach ( $textarea_fields as $field ) {
			if ( isset( $data[ $field ] ) ) {
				// Allow br, strong, em
				$allowed = array( 'br' => array(), 'strong' => array(), 'em' => array() );
				update_option( $field, wp_kses( wp_unslash( $data[ $field ] ), $allowed ) );
			}
		}
	}
}

Coffee_Cafe_Corner_Page_Content_Admin::init();
