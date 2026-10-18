<?php
/**
 * Class Coffee_Cafe_Corner_Cafe_Locations_DB
 *
 * Handles database interaction & Admin management for all Quills Cafe locations:
 * - Registers WordPress Admin Menu: "Quán Cafe (Cafes)"
 * - Provides intuitive UI for Admin to edit Title, Desc, Address, Hours, Phone, Testimonials, Images
 * - Saves data into WordPress Database (wp_options & wp_postmeta)
 * - Seamlessly integrates with Cafe Detail subpages (?view=...) and Visit page
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Cafe_Locations_DB {

	const OPTION_KEY = 'quills_cafe_details';

	/**
	 * Initialize hooks
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'handle_save' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );
		add_action( 'init', array( __CLASS__, 'ensure_initial_database' ) );
	}

	/**
	 * Get default 7 cafes configuration
	 *
	 * @return array
	 */
	public static function get_default_cafes() {
		return array(
			'nulu' => array(
				'id'           => 'nulu',
				'title'        => 'NULU OR "THE FIREHOUSE"',
				'desc'         => "Our flagship cafe and headquarters. This is where our office is and where you'll find the Roastery barn. Our cafe resides in the historic firehouse station built in 1890. The lively din of downtown business folks fill the space in the mornings. Stroll through the open garage door at the back to enjoy the open air of our courtyard. A collection of picnic tables make it perfect for sitting outside enjoying coffees and treats with a group of friends. On any day of the week you'll likely smell the roasting of coffee in the air. Our Roastery barn sports a large window where you can watch our roasters work. Come on over and take a gander. They don't mind.",
				'image_main'   => 'nulu-main.jpg',
				'address'      => '802 E. Main St.',
				'map_url'      => 'https://www.google.com/maps/place/802+E+Main+St,+Louisville,+KY+40206',
				'hours'        => 'Mon-Fri: 6AM-7PM · Sat-Sun: 7AM-7PM',
				'phone'        => '(502) 861-5844',
				'gallery_1'    => 'nulu-gallery-1.jpg',
				'gallery_2'    => 'nulu-gallery-2.jpg',
				'gallery_3'    => 'nulu-gallery-3.jpg',
				'quote'        => 'One of my favorite coffee shops on planet earth (mind you, I\'ve been to many)! The Quills signature roast coffee, "Inkwell," is a personal favorite and is always available (though there\'s usually a second option as well). Quills Nulu is a great spot in which to read, study, or chat. Be sure to check out the back courtyard!',
				'quote_author' => '— Matthew B',
			),
			'highlands' => array(
				'id'           => 'highlands',
				'title'        => 'HIGHLANDS',
				'desc'         => "Our second location located in the iconic Highlands neighborhood of Louisville. It's often considered the OG location by many customers. Nestled among a collection of eclectic shops, restaurants and bars, it may be the homiest of our cafes. Original hardwood floors, a wooden pew that lines the wall, and a side alley loved for years. The front window is a perfect place to sit and do some coding by the window.",
				'image_main'   => 'highlands-main.jpg',
				'address'      => '930 Baxter Avenue',
				'map_url'      => 'https://www.google.com/maps/place/930+Baxter+Ave,+Louisville,+KY+40204',
				'hours'        => 'Mon-Fri: 7AM-6PM · Sat-Sun: 7AM-7PM',
				'phone'        => '(502) 861-5844',
				'gallery_1'    => 'highlands-gallery-1.jpg',
				'gallery_2'    => 'highlands-gallery-2.jpg',
				'gallery_3'    => 'highlands-gallery-3.jpg',
				'quote'        => 'I love Quills on Baxter! They make my latte with perfect froth every time. We get our coffee beans from here too and they are always fresh and delicious. Atmosphere is comfortable with plenty of space to hang out. One of the best cafes in town!',
				'quote_author' => '— ES',
			),
			'indianapolis' => array(
				'id'           => 'indianapolis',
				'title'        => 'INDIANAPOLIS',
				'desc'         => "Our only cafe outside of Kentucky. This satellite location is just steps from the heartbeat of downtown, our cafe on Meridian Street sits where commuters, creatives, and neighbors all cross paths. Equal parts historic charm and city grit, it's a place that's equally great for studying, reading, hanging out, or having your business meeting. We're happy to serve great coffee with our friends up in Indy.",
				'image_main'   => 'indianapolis-main.jpg',
				'address'      => '941 N. Meridian Street',
				'map_url'      => 'https://www.google.com/maps/place/941+N+Meridian+St,+Indianapolis,+IN+46204',
				'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
				'phone'        => '(502) 861-5844',
				'gallery_1'    => 'indianapolis-gallery-1.jpg',
				'gallery_2'    => 'indianapolis-gallery-2.jpg',
				'gallery_3'    => 'indianapolis-gallery-3.jpg',
				'quote'        => 'One thing that\'s really important to me when it comes to coffee shops is consistency, and Quills hits the mark every time. Trust me when I say this is the BEST COFFEE IN INDY! My drink is always spot on, which is what keeps me a returning customer.',
				'quote_author' => '— Lauryn S.',
			),
			'st-matthews' => array(
				'id'           => 'st-matthews',
				'title'        => 'ST. MATTHEWS',
				'desc'         => "Tucked away just off a busy intersection of Shelbyville Road, you might miss it when you're driving by. You'll find our St. Matthews cafe located on the first floor between Drakes and Green District Salads in a multi-use three story building. A soft cushion seat lines the wall for when you need to sit and focus for awhile. A garage door allows for a lovely breeze for three seasons. And bar seating where you can sit and work and chat with our baristas. A neighborhood place tucked into the everyday bustle.",
				'image_main'   => 'st-matthews-main.jpg',
				'address'      => '3939 Shelbyville Rd., Suite 105',
				'map_url'      => 'https://www.google.com/maps/place/3939+Shelbyville+Rd+Suite+105,+Louisville,+KY+40207',
				'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
				'phone'        => '(502) 861-5844',
				'gallery_1'    => 'st-matthews-gallery-1.jpg',
				'gallery_2'    => 'st-matthews-gallery-2.jpg',
				'gallery_3'    => 'st-matthews-gallery-3.jpg',
				'quote'        => 'Third-wave coffee instead of the common dark and burnt flavors of diners or starbucks. The barista poured a nice rosetta, good foam quality on the cappuccino, and got the milk temperature just right so it was warm as can be without breaking down the milk\'s sweetness.',
				'quote_author' => '— Jake T.',
			),
			'jtown' => array(
				'id'           => 'jtown',
				'title'        => 'J-TOWN',
				'desc'         => "We took over a bank. Well, at least the space. Our cafe in the Gaslight Square District of Louisville has huge ceilings and tons of natural light from the abundance of windows. The huge and hefty vault door (that still works) remains behind the bar and is a favorite sight among visitors. Sneak away to the upper loft to work or study for awhile. It's also a great place to perch and watch the baristas work below.",
				'image_main'   => 'jtown-main.jpg',
				'address'      => '10501 Watterson Trail',
				'map_url'      => 'https://www.google.com/maps/place/10501+Watterson+Trail,+Louisville,+KY+40299',
				'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
				'phone'        => '(502) 861-5844',
				'gallery_1'    => 'jtown-gallery-1.jpg',
				'gallery_2'    => 'jtown-gallery-2.jpg',
				'gallery_3'    => 'jtown-gallery-3.jpg',
				'quote'        => 'Visited Quills Coffee in J-town with my coffee connoisseur father-in-law, and we both loved it! The vibe was relaxed and inviting, totally our style. I asked the barista for a recommendation and boy did she deliver! The drink was rich, smooth, and absolutely perfect. "Woodsman." You can tell they really care about their craft. Definitely a must-visit for coffee lovers!',
				'quote_author' => '— Laura W.',
			),
			'norton-commons' => array(
				'id'           => 'norton-commons',
				'title'        => 'NORTON COMMONS',
				'desc'         => "Our newest cafe rests in the middle of an ever-growing walkable community in the Prospect area. A neighborhood defined by new urbanism and village-style, front-porch living. We're proud to be a part of over 70 independently-owned businesses here. Enjoy a coffee by the fountain just outside, or sit with us inside. This cafe is a gathering spot for neighbors and friends alike.",
				'image_main'   => 'norton-commons-main.jpg',
				'address'      => '11213 River Beauty Loop',
				'map_url'      => 'https://www.google.com/maps/place/11213+River+Beauty+Loop,+Prospect,+KY+40059',
				'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
				'phone'        => '(502) 861-5844',
				'gallery_1'    => 'norton-commons-gallery-1.jpg',
				'gallery_2'    => 'norton-commons-gallery-2.jpg',
				'gallery_3'    => 'norton-commons-gallery-3.jpg',
				'quote'        => 'I love Quills for the drinks but the barista\'s kindness is truly next level. My children ask them five hundred questions and every single barista at the Norton Commons location has answered every single one of them and gone as far as to walk them through step-by-step how they make the coffee and I\'m just so impressed.',
				'quote_author' => '— Whitley G.',
			),
			'frankfort-avenue' => array(
				'id'           => 'frankfort-avenue',
				'title'        => 'FRANKFORT AVENUE',
				'desc'         => "Bookstores, galleries, tree-lined sidewalks. We're happy to be a part of a neighborhood with such old charm. The Frankfort Avenue we share sports hole-in-the-wall gems and fine dining staples. You'll hear the espresso machine running just as often as you hear the train going by. Plop down on the couch or head out back to our patio. Any spot is a good spot here.",
				'image_main'   => 'frankfort-avenue-main.jpg',
				'address'      => '2001 Frankfort Avenue',
				'map_url'      => 'https://www.google.com/maps/place/2001+Frankfort+Ave,+Louisville,+KY+40206',
				'hours'        => 'Mon-Fri: 7AM-7PM · Sat-Sun: 7AM-7PM',
				'phone'        => '(502) 861-5844',
				'gallery_1'    => 'frankfort-avenue-gallery-1.jpg',
				'gallery_2'    => 'frankfort-avenue-gallery-2.jpg',
				'gallery_3'    => 'frankfort-avenue-gallery-3.jpg',
				'quote'        => 'This cafe has been open less than a week and has already easily become my favorite in the \'Ville. It has the same unsurpassed exceptional coffee and friendly service we\'ve come to expect from every Quills, while being situated in a beautiful, recently-renovated older building. A bonus feature of this location is a large back patio area. This will be the perfect "third place" for many to hang out, have a coffee, chat, or finish up a little work. It will be my go-to for sure.',
				'quote_author' => '— Jacob D.',
			),
		);
	}

	/**
	 * Ensure Database has initial records
	 */
	public static function ensure_initial_database() {
		return; // Seeder disabled: Data is permanently managed in database
		$existing = get_option( self::OPTION_KEY );
		if ( empty( $existing ) || ! is_array( $existing ) ) {
			$defaults = self::get_default_cafes();
			update_option( self::OPTION_KEY, $defaults );
			self::sync_to_postmeta( $defaults );
		}
	}

	/**
	 * Sync to related pages' postmeta
	 */
	public static function sync_to_postmeta( $cafes_data ) {
		$page_slugs = array( 'about', 'about-us', 'visit', 'our-cafes' );
		foreach ( $page_slugs as $slug ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( $page ) {
				update_post_meta( $page->ID, '_quills_cafe_details', $cafes_data );
			}
		}
	}

	/**
	 * Register Admin Menu Item
	 */
	public static function register_admin_menu() {
		add_menu_page(
			__( 'Quản lý Quán Cafe', 'coffee-cafe-corner' ),
			__( 'Quán Cafe (Cafes)', 'coffee-cafe-corner' ),
			'manage_options',
			'quills-cafes',
			array( __CLASS__, 'render_admin_page' ),
			'dashicons-coffee',
			26
		);
	}

	/**
	 * Enqueue Media Scripts & Styles for image selector in admin
	 */
	public static function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'quills-cafes' ) === false ) {
			return;
		}
		wp_enqueue_media();
	}

	/**
	 * Handle Saving Settings from Admin
	 */
	public static function handle_save() {
		if ( ! isset( $_POST['quills_save_cafe_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['quills_save_cafe_nonce'] ) ), 'quills_save_cafe_action' ) ) {
			wp_die( 'Bảo mật không hợp lệ (Invalid nonce).' );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Bạn không có quyền thực hiện thao tác này.' );
		}

		$current_cafes = get_option( self::OPTION_KEY, self::get_default_cafes() );
		$cafe_id       = isset( $_POST['active_cafe_id'] ) ? sanitize_key( $_POST['active_cafe_id'] ) : '';

		if ( empty( $cafe_id ) || ! isset( $current_cafes[ $cafe_id ] ) ) {
			return;
		}

		// Sanitize submitted inputs
		$current_cafes[ $cafe_id ]['title']        = sanitize_text_field( wp_unslash( $_POST['cafe_title'] ?? '' ) );
		$current_cafes[ $cafe_id ]['desc']         = wp_kses_post( wp_unslash( $_POST['cafe_desc'] ?? '' ) );
		$current_cafes[ $cafe_id ]['address']      = sanitize_text_field( wp_unslash( $_POST['cafe_address'] ?? '' ) );
		$current_cafes[ $cafe_id ]['map_url']      = esc_url_raw( wp_unslash( $_POST['cafe_map_url'] ?? '' ) );
		$current_cafes[ $cafe_id ]['hours']        = sanitize_text_field( wp_unslash( $_POST['cafe_hours'] ?? '' ) );
		$current_cafes[ $cafe_id ]['phone']        = sanitize_text_field( wp_unslash( $_POST['cafe_phone'] ?? '' ) );
		$current_cafes[ $cafe_id ]['quote']        = wp_kses_post( wp_unslash( $_POST['cafe_quote'] ?? '' ) );
		$current_cafes[ $cafe_id ]['quote_author'] = sanitize_text_field( wp_unslash( $_POST['cafe_quote_author'] ?? '' ) );

		// Images (URL or filename)
		$current_cafes[ $cafe_id ]['image_main'] = sanitize_text_field( wp_unslash( $_POST['cafe_image_main'] ?? '' ) );
		$current_cafes[ $cafe_id ]['gallery_1']  = sanitize_text_field( wp_unslash( $_POST['cafe_gallery_1'] ?? '' ) );
		$current_cafes[ $cafe_id ]['gallery_2']  = sanitize_text_field( wp_unslash( $_POST['cafe_gallery_2'] ?? '' ) );
		$current_cafes[ $cafe_id ]['gallery_3']  = sanitize_text_field( wp_unslash( $_POST['cafe_gallery_3'] ?? '' ) );

		// Save to Database
		update_option( self::OPTION_KEY, $current_cafes );
		self::sync_to_postmeta( $current_cafes );

		// Sync with _visit_cafes postmeta if present
		$visit_page = get_page_by_path( 'visit', OBJECT, 'page' );
		if ( $visit_page ) {
			$visit_cafes = get_post_meta( $visit_page->ID, '_visit_cafes', true );
			if ( is_array( $visit_cafes ) ) {
				foreach ( $visit_cafes as &$vc ) {
					if ( isset( $vc['id'] ) && $vc['id'] === $cafe_id ) {
						$vc['name']    = $current_cafes[ $cafe_id ]['title'];
						$vc['address'] = $current_cafes[ $cafe_id ]['address'];
						$vc['map_url'] = $current_cafes[ $cafe_id ]['map_url'];
						$vc['phone']   = $current_cafes[ $cafe_id ]['phone'];
						$vc['hours']   = $current_cafes[ $cafe_id ]['hours'];
					}
				}
				update_post_meta( $visit_page->ID, '_visit_cafes', $visit_cafes );
			}
		}

		// Redirect back with success message
		wp_safe_redirect( add_query_arg( array(
			'page'    => 'quills-cafes',
			'tab'     => $cafe_id,
			'updated' => 'true',
		), admin_url( 'admin.php' ) ) );
		exit;
	}

	/**
	 * Render the Admin UI
	 */
	public static function render_admin_page() {
		$cafes     = get_option( self::OPTION_KEY, self::get_default_cafes() );
		$active_id = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'st-matthews';

		if ( ! isset( $cafes[ $active_id ] ) ) {
			$active_id = key( $cafes );
		}

		$current = $cafes[ $active_id ];
		$theme_url = trailingslashit( get_template_directory_uri() );
		$img_base  = $theme_url . 'assets/images/visit/';

		// Helper to resolve preview url
		$get_img_preview = function( $img_file ) use ( $img_base ) {
			if ( empty( $img_file ) ) {
				return '';
			}
			return filter_var( $img_file, FILTER_VALIDATE_URL ) ? $img_file : $img_base . $img_file;
		};
		?>
		<div class="wrap quills-admin-wrap" style="max-width: 1100px; margin-top: 20px;">
			<h1 style="display: flex; align-items: center; gap: 10px; font-size: 24px; font-weight: 700; margin-bottom: 15px;">
				<span class="dashicons dashicons-coffee" style="font-size: 32px; width: 32px; height: 32px; color: #b45309;"></span>
				Quản lý Chi nhánh Quán Cafe (Cafe Locations)
			</h1>
			<p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">
				Chỉnh sửa thông tin, địa chỉ, giờ mở cửa, bài đánh giá và hình ảnh cho từng quán cafe. Dữ liệu sẽ được lưu tự động vào cơ sở dữ liệu và hiển thị ngay trên các trang chi tiết <strong>(?view=...)</strong>.
			</p>

			<?php if ( isset( $_GET['updated'] ) && 'true' === $_GET['updated'] ) : ?>
				<div class="notice notice-success is-dismissible" style="border-left-color: #10b981; padding: 12px 15px;">
					<p style="font-size: 14px; font-weight: 600; color: #065f46; margin: 0;">
						✅ Đã lưu thông tin quán <strong><?php echo esc_html( $current['title'] ); ?></strong> thành công vào cơ sở dữ liệu!
					</p>
				</div>
			<?php endif; ?>

			<!-- Tab Navigation -->
			<nav class="nav-tab-wrapper" style="margin-bottom: 25px; border-bottom: 2px solid #cbd5e1;">
				<?php foreach ( $cafes as $id => $c ) : ?>
					<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'quills-cafes', 'tab' => $id ), admin_url( 'admin.php' ) ) ); ?>"
					   class="nav-tab <?php echo ( $active_id === $id ) ? 'nav-tab-active' : ''; ?>"
					   style="<?php echo ( $active_id === $id ) ? 'background: #fff; font-weight: 700; border-bottom-color: #fff; color: #b45309;' : ''; ?>">
						☕ <?php echo esc_html( $c['title'] ); ?>
					</a>
				<?php endforeach; ?>
			</nav>

			<!-- Action Toolbar -->
			<div style="display: flex; justify-content: space-between; align-items: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 20px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<div style="font-size: 15px; font-weight: 600; color: #1e293b;">
					Đang chỉnh sửa chi nhánh: <span style="color: #b45309;"><?php echo esc_html( $current['title'] ); ?></span>
					<code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 12px; margin-left: 6px;">?view=<?php echo esc_html( $active_id ); ?></code>
				</div>
				<div style="display: flex; gap: 10px;">
					<a href="<?php echo esc_url( home_url( '/about-us/?view=' . $active_id ) ); ?>" target="_blank" class="button button-secondary" style="display: flex; align-items: center; gap: 4px;">
						<span class="dashicons dashicons-external" style="font-size: 16px; width: 16px; height: 16px;"></span> Xem trang trên web
					</a>
				</div>
			</div>

			<!-- Main Form -->
			<form method="post" action="">
				<?php wp_nonce_field( 'quills_save_cafe_action', 'quills_save_cafe_nonce' ); ?>
				<input type="hidden" name="active_cafe_id" value="<?php echo esc_attr( $active_id ); ?>" />

				<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px;">
					<!-- Left Column: Content & Details -->
					<div>
						<!-- Basic Info Card -->
						<div class="postbox" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
							<h2 style="font-size: 16px; font-weight: 700; margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a;">
								📌 Thông tin cơ bản
							</h2>

							<div style="margin-bottom: 15px;">
								<label for="cafe_title" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Tên quán (Tiêu đề):</label>
								<input type="text" id="cafe_title" name="cafe_title" value="<?php echo esc_attr( $current['title'] ); ?>" class="large-text" style="border-radius: 6px; padding: 8px 12px; border: 1px solid #cbd5e1;" required />
							</div>

							<div style="margin-bottom: 15px;">
								<label for="cafe_desc" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Đoạn văn giới thiệu chi nhánh:</label>
								<textarea id="cafe_desc" name="cafe_desc" rows="6" class="large-text" style="border-radius: 6px; padding: 10px 12px; border: 1px solid #cbd5e1; line-height: 1.6;"><?php echo esc_textarea( $current['desc'] ); ?></textarea>
							</div>

							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
								<div>
									<label for="cafe_address" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Địa chỉ:</label>
									<input type="text" id="cafe_address" name="cafe_address" value="<?php echo esc_attr( $current['address'] ); ?>" class="large-text" style="border-radius: 6px; padding: 8px 12px; border: 1px solid #cbd5e1;" />
								</div>
								<div>
									<label for="cafe_phone" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Số điện thoại:</label>
									<input type="text" id="cafe_phone" name="cafe_phone" value="<?php echo esc_attr( $current['phone'] ); ?>" class="large-text" style="border-radius: 6px; padding: 8px 12px; border: 1px solid #cbd5e1;" />
								</div>
							</div>

							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
								<div>
									<label for="cafe_hours" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Giờ mở cửa:</label>
									<input type="text" id="cafe_hours" name="cafe_hours" value="<?php echo esc_attr( $current['hours'] ); ?>" class="large-text" style="border-radius: 6px; padding: 8px 12px; border: 1px solid #cbd5e1;" />
								</div>
								<div>
									<label for="cafe_map_url" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Link Google Maps:</label>
									<input type="url" id="cafe_map_url" name="cafe_map_url" value="<?php echo esc_url( $current['map_url'] ); ?>" class="large-text" style="border-radius: 6px; padding: 8px 12px; border: 1px solid #cbd5e1;" />
								</div>
							</div>
						</div>

						<!-- Testimonial Card -->
						<div class="postbox" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
							<h2 style="font-size: 16px; font-weight: 700; margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a;">
								💬 Đánh giá từ khách hàng (Testimonial)
							</h2>

							<div style="margin-bottom: 15px;">
								<label for="cafe_quote" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Nội dung lời nhận xét:</label>
								<textarea id="cafe_quote" name="cafe_quote" rows="4" class="large-text" style="border-radius: 6px; padding: 10px 12px; border: 1px solid #cbd5e1; line-height: 1.5; font-style: italic;"><?php echo esc_textarea( $current['quote'] ); ?></textarea>
							</div>

							<div>
								<label for="cafe_quote_author" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">Tên tác giả nhận xét:</label>
								<input type="text" id="cafe_quote_author" name="cafe_quote_author" value="<?php echo esc_attr( $current['quote_author'] ); ?>" class="large-text" style="border-radius: 6px; padding: 8px 12px; border: 1px solid #cbd5e1;" />
							</div>
						</div>
					</div>

					<!-- Right Column: Images & Save Action -->
					<div>
						<!-- Save Box -->
						<div class="postbox" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
							<h3 style="font-size: 15px; font-weight: 700; margin-top: 0; color: #0f172a;">Lưu dữ liệu</h3>
							<p style="color: #64748b; font-size: 13px;">Nhấn nút dưới để lưu thay đổi của quán này vào cơ sở dữ liệu.</p>
							<button type="submit" class="button button-primary button-large" style="width: 100%; height: 42px; font-size: 15px; font-weight: 600; background: #b45309; border-color: #92400e; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
								💾 Lưu thay đổi quán này
							</button>
						</div>

						<!-- Main Image Box -->
						<div class="postbox" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
							<h3 style="font-size: 15px; font-weight: 700; margin-top: 0; color: #0f172a;">Ảnh chính (Main Banner)</h3>
							<div style="margin-bottom: 10px; border-radius: 6px; overflow: hidden; background: #f8fafc; border: 1px solid #e2e8f0; text-align: center;">
								<img id="preview_cafe_image_main" src="<?php echo esc_url( $get_img_preview( $current['image_main'] ) ); ?>" style="max-width: 100%; height: 160px; object-fit: cover; display: block;" alt="Ảnh chính" />
							</div>
							<div style="display: flex; gap: 6px; align-items: center;">
								<input type="text" id="cafe_image_main" name="cafe_image_main" value="<?php echo esc_attr( $current['image_main'] ); ?>" class="large-text" style="border-radius: 6px; padding: 6px 10px;" />
								<button type="button" class="button quills-upload-btn" data-target="#cafe_image_main" data-preview="#preview_cafe_image_main">Chọn</button>
							</div>
							<p class="description" style="margin-top: 6px; font-size: 12px; color: #94a3b8;">Nhập tên file ảnh hoặc click Chọn từ thư viện media.</p>
						</div>

						<!-- Gallery Box -->
						<div class="postbox" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
							<h3 style="font-size: 15px; font-weight: 700; margin-top: 0; color: #0f172a;">Bộ sưu tập ảnh phụ (Gallery)</h3>

							<!-- Gallery 1 -->
							<div style="margin-bottom: 15px;">
								<label style="display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Ảnh phụ 1:</label>
								<div style="display: flex; gap: 8px; align-items: center;">
									<img id="preview_cafe_gallery_1" src="<?php echo esc_url( $get_img_preview( $current['gallery_1'] ) ); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" />
									<input type="text" id="cafe_gallery_1" name="cafe_gallery_1" value="<?php echo esc_attr( $current['gallery_1'] ); ?>" class="large-text" style="border-radius: 6px; padding: 6px 8px; font-size: 12px;" />
									<button type="button" class="button quills-upload-btn" data-target="#cafe_gallery_1" data-preview="#preview_cafe_gallery_1">Chọn</button>
								</div>
							</div>

							<!-- Gallery 2 -->
							<div style="margin-bottom: 15px;">
								<label style="display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Ảnh phụ 2:</label>
								<div style="display: flex; gap: 8px; align-items: center;">
									<img id="preview_cafe_gallery_2" src="<?php echo esc_url( $get_img_preview( $current['gallery_2'] ) ); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" />
									<input type="text" id="cafe_gallery_2" name="cafe_gallery_2" value="<?php echo esc_attr( $current['gallery_2'] ); ?>" class="large-text" style="border-radius: 6px; padding: 6px 8px; font-size: 12px;" />
									<button type="button" class="button quills-upload-btn" data-target="#cafe_gallery_2" data-preview="#preview_cafe_gallery_2">Chọn</button>
								</div>
							</div>

							<!-- Gallery 3 -->
							<div>
								<label style="display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Ảnh phụ 3:</label>
								<div style="display: flex; gap: 8px; align-items: center;">
									<img id="preview_cafe_gallery_3" src="<?php echo esc_url( $get_img_preview( $current['gallery_3'] ) ); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" />
									<input type="text" id="cafe_gallery_3" name="cafe_gallery_3" value="<?php echo esc_attr( $current['gallery_3'] ); ?>" class="large-text" style="border-radius: 6px; padding: 6px 8px; font-size: 12px;" />
									<button type="button" class="button quills-upload-btn" data-target="#cafe_gallery_3" data-preview="#preview_cafe_gallery_3">Chọn</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<!-- Script for Media Uploader -->
		<script>
		jQuery(document).ready(function($) {
			$('.quills-upload-btn').on('click', function(e) {
				e.preventDefault();
				var targetInput = $( $(this).data('target') );
				var previewImg  = $( $(this).data('preview') );

				var frame = wp.media({
					title: 'Chọn hoặc tải ảnh lên',
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
		});
		</script>
		<?php
	}
}
