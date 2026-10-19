<?php
if ( ! defined( 'COFFEE_CAFE_CORNER_VERSION' ) ) {
	define( 'COFFEE_CAFE_CORNER_VERSION', '0.0.1' );
}

/**
 * Enqueue scripts and styles.
 */
function coffee_cafe_corner_scripts() {
	wp_enqueue_style( 'coffee-cafe-corner-style', trailingslashit( get_template_directory_uri() ) . 'assets/css/style.css', array(), COFFEE_CAFE_CORNER_VERSION );

	wp_enqueue_style( 'fontawesome', trailingslashit( get_template_directory_uri() ) . 'assets/css/font-awesome/css/all.css', array(), COFFEE_CAFE_CORNER_VERSION );

	// Enqueue theme JavaScript
	wp_enqueue_script( 'coffee-cafe-corner-theme', trailingslashit( get_template_directory_uri() ) . 'assets/js/theme.js',
	    array( 'jquery' ), COFFEE_CAFE_CORNER_VERSION,true );

	$theme_ver = COFFEE_CAFE_CORNER_VERSION . '.' . time();

	// Enqueue custom footer stylesheet (Authentic Quills Coffee Design)
	$footer_css = get_template_directory() . '/assets/css/custom-footer.css';
	wp_enqueue_style( 'coffee-cafe-corner-footer', trailingslashit( get_template_directory_uri() ) . 'assets/css/custom-footer.css', array(), file_exists( $footer_css ) ? filemtime( $footer_css ) : $theme_ver );

	// Enqueue Quills About Us stylesheet (only when not on front page to prevent collision)
	if ( ! is_front_page() ) {
		wp_enqueue_style( 'coffee-cafe-corner-about', trailingslashit( get_template_directory_uri() ) . 'assets/css/about-quills.css', array(), COFFEE_CAFE_CORNER_VERSION );
	}

	// Enqueue Quills Visit stylesheet
	wp_enqueue_style( 'coffee-cafe-corner-visit', trailingslashit( get_template_directory_uri() ) . 'assets/css/visit-quills.css', array(), $theme_ver );

	// Enqueue Quills Brew Gear stylesheet
	$brew_gear_css = get_template_directory() . '/assets/css/brew-gear.css';
	wp_enqueue_style( 'coffee-cafe-corner-brew-gear', trailingslashit( get_template_directory_uri() ) . 'assets/css/brew-gear.css', array(), file_exists( $brew_gear_css ) ? filemtime( $brew_gear_css ) : COFFEE_CAFE_CORNER_VERSION );

	// Enqueue Quills Brew Gear JS
	$brew_gear_js = get_template_directory() . '/assets/js/brew-gear.js';
	wp_enqueue_script( 'coffee-cafe-corner-brew-gear-js', trailingslashit( get_template_directory_uri() ) . 'assets/js/brew-gear.js', array( 'jquery' ), file_exists( $brew_gear_js ) ? filemtime( $brew_gear_js ) : COFFEE_CAFE_CORNER_VERSION, true );
	wp_localize_script( 'coffee-cafe-corner-brew-gear-js', 'quillsData', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'quills_nonce' ),
	) );

	// Enqueue Quills Wholesale stylesheet
	wp_enqueue_style( 'coffee-cafe-corner-wholesale', trailingslashit( get_template_directory_uri() ) . 'assets/css/wholesale.css', array(), $theme_ver );

	// Enqueue Quills Wholesale JS
	if ( file_exists( get_template_directory() . '/assets/js/wholesale.js' ) ) {
		wp_enqueue_script( 'coffee-cafe-corner-wholesale-js', trailingslashit( get_template_directory_uri() ) . 'assets/js/wholesale.js', array(), filemtime( get_template_directory() . '/assets/js/wholesale.js' ), true );
		wp_localize_script( 'coffee-cafe-corner-wholesale-js', 'wholesaleData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	// Enqueue Quills Home stylesheet and script (only on front page to prevent CSS collisions)
	if ( ( is_front_page() || is_home() ) && file_exists( get_template_directory() . '/assets/css/home-quills.css' ) ) {
		wp_enqueue_style( 'coffee-cafe-corner-home', trailingslashit( get_template_directory_uri() ) . 'assets/css/home-quills.css', array(), filemtime( get_template_directory() . '/assets/css/home-quills.css' ) );
	}
	if ( ( is_front_page() || is_home() ) && file_exists( get_template_directory() . '/assets/js/home-quills.js' ) ) {
		wp_enqueue_script( 'coffee-cafe-corner-home-js', trailingslashit( get_template_directory_uri() ) . 'assets/js/home-quills.js', array(), filemtime( get_template_directory() . '/assets/js/home-quills.js' ), true );
	}

	// Enqueue Quills Coffee Collection stylesheet and script
	if ( file_exists( get_template_directory() . '/assets/css/coffee-quills.css' ) ) {
		wp_enqueue_style( 'coffee-cafe-corner-coffee', trailingslashit( get_template_directory_uri() ) . 'assets/css/coffee-quills.css', array(), filemtime( get_template_directory() . '/assets/css/coffee-quills.css' ) );
	}
	if ( file_exists( get_template_directory() . '/assets/js/coffee-quills.js' ) ) {
		wp_enqueue_script( 'coffee-cafe-corner-coffee-js', trailingslashit( get_template_directory_uri() ) . 'assets/js/coffee-quills.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/coffee-quills.js' ), true );
		wp_localize_script( 'coffee-cafe-corner-coffee-js', 'quillsData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'quills_nonce' ),
		) );
	}

	// Enqueue Quills Subscriptions stylesheet and script
	if ( file_exists( get_template_directory() . '/assets/css/subscriptions.css' ) ) {
		wp_enqueue_style( 'coffee-cafe-corner-subscriptions', trailingslashit( get_template_directory_uri() ) . 'assets/css/subscriptions.css', array(), filemtime( get_template_directory() . '/assets/css/subscriptions.css' ) );
	}
	if ( file_exists( get_template_directory() . '/assets/js/subscriptions.js' ) ) {
		wp_enqueue_script( 'coffee-cafe-corner-subscriptions-js', trailingslashit( get_template_directory_uri() ) . 'assets/js/subscriptions.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/subscriptions.js' ), true );
		wp_localize_script( 'coffee-cafe-corner-subscriptions-js', 'quillsData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'quills_nonce' ),
		) );
	}

	// Enqueue Quills Merch stylesheet & script
	if ( file_exists( get_template_directory() . '/assets/css/merch-quills.css' ) ) {
		wp_enqueue_style( 'coffee-cafe-corner-merch-quills', trailingslashit( get_template_directory_uri() ) . 'assets/css/merch-quills.css', array(), filemtime( get_template_directory() . '/assets/css/merch-quills.css' ) );
	} elseif ( file_exists( get_template_directory() . '/assets/css/merch.css' ) ) {
		wp_enqueue_style( 'coffee-cafe-corner-merch', trailingslashit( get_template_directory_uri() ) . 'assets/css/merch.css', array(), filemtime( get_template_directory() . '/assets/css/merch.css' ) );
	}

	if ( file_exists( get_template_directory() . '/assets/js/merch-quills.js' ) ) {
		wp_enqueue_script( 'coffee-cafe-corner-merch-js', trailingslashit( get_template_directory_uri() ) . 'assets/js/merch-quills.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/merch-quills.js' ), true );
		wp_localize_script( 'coffee-cafe-corner-merch-js', 'quillsData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'quills_nonce' ),
		) );
	}

	// Enqueue Quills Gift Cards stylesheet
	if ( file_exists( get_template_directory() . '/assets/css/gift-cards-quills.css' ) ) {
		wp_enqueue_style( 'coffee-cafe-corner-gift-cards', trailingslashit( get_template_directory_uri() ) . 'assets/css/gift-cards-quills.css', array(), filemtime( get_template_directory() . '/assets/css/gift-cards-quills.css' ) );
	}

	// Enqueue Quills Search Modal stylesheet and script
	if ( file_exists( get_template_directory() . '/assets/css/search-modal.css' ) ) {
		wp_enqueue_style( 'coffee-cafe-corner-search-modal', trailingslashit( get_template_directory_uri() ) . 'assets/css/search-modal.css', array(), filemtime( get_template_directory() . '/assets/css/search-modal.css' ) );
	}
	if ( file_exists( get_template_directory() . '/assets/js/search-modal.js' ) ) {
		wp_enqueue_script( 'coffee-cafe-corner-search-js', trailingslashit( get_template_directory_uri() ) . 'assets/js/search-modal.js', array(), filemtime( get_template_directory() . '/assets/js/search-modal.js' ), true );
		wp_localize_script( 'coffee-cafe-corner-search-js', 'quillsSearchData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'homeUrl' => home_url( '/' ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'coffee_cafe_corner_scripts' );

function coffee_cafe_corner_load_dashicons_front_end() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'coffee_cafe_corner_load_dashicons_front_end' );

/**
 * Enqueue Editor styles.
 */
function coffee_cafe_corner_enqueue_editor_block_styles() {
	// Enqueue editor styles.
	add_editor_style( trailingslashit( get_template_directory_uri() ) . 'assets/css/editor-style.css' );
	add_editor_style( trailingslashit( get_template_directory_uri() ) . 'assets/css/custom-footer.css' );
	add_editor_style( trailingslashit( get_template_directory_uri() ) . 'assets/css/visit-quills.css' );
	add_editor_style( trailingslashit( get_template_directory_uri() ) . 'assets/css/brew-gear.css' );
	add_editor_style( trailingslashit( get_template_directory_uri() ) . 'assets/css/wholesale.css' );
	add_editor_style( trailingslashit( get_template_directory_uri() ) . 'assets/css/home-quills.css' );
}
add_action( 'after_setup_theme', 'coffee_cafe_corner_enqueue_editor_block_styles' );

/**
 * Pattern categories.
 */
function coffee_cafe_corner_register_block_pattern_category() {
	register_block_pattern_category(
		'coffee-cafe-corner-banner',
		array(
			'label' => esc_html__( 'Banner', 'coffee-cafe-corner' ),
		)
	);
	
	register_block_pattern_category(
		'coffee-cafe-corner-services',
		array(
			'label' => esc_html__( 'Services', 'coffee-cafe-corner' ),
		)
	);
}
add_action( 'init', 'coffee_cafe_corner_register_block_pattern_category' );

/**
 * Add theme support for various features.
 */
function coffee_cafe_corner_setup() {

	load_theme_textdomain( 'coffee-cafe-corner', get_template_directory() . '/languages' );

	// Add support for block styles.
	add_theme_support( 'wp-block-styles' );
	
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
	
	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Register navigation menus for Header and Footer
	register_nav_menus( array(
		'primary'            => esc_html__( 'Primary Navigation', 'coffee-cafe-corner' ),
		'footer-quick-links' => esc_html__( 'Footer Quick Links', 'coffee-cafe-corner' ),
		'footer-company'     => esc_html__( 'Footer Company', 'coffee-cafe-corner' ),
	) );
}
add_action( 'after_setup_theme', 'coffee_cafe_corner_setup' );

/**
 * TGM Recommendation
 */
require get_parent_theme_file_path( '/TGM/tgm.php' );

/**
 * Upgrade to Pro
 */
$coffee_cafe_corner_pro_customize = trailingslashit( get_template_directory() ) . 'coffee-cafe-corner-pro/class-customize.php';
if ( file_exists( $coffee_cafe_corner_pro_customize ) ) {
    require_once $coffee_cafe_corner_pro_customize;
}

/**
 * Notices
 */
require_once get_parent_theme_file_path( '/activation-notice/class-welcome-notice.php' );

/**getstart*/
$coffee_cafe_corner_theme_info = get_template_directory() . '/coffee-cafe-corner-get-theme-info.php';
if ( file_exists( $coffee_cafe_corner_theme_info ) ) {
    require $coffee_cafe_corner_theme_info;
}

if ( ! function_exists( 'coffee_cafe_corner_admin_scripts' ) ) :
    function coffee_cafe_corner_admin_scripts($hook) {
        wp_enqueue_style( 'coffee-cafe-corner-get-theme-info-css', get_template_directory_uri() . '/assets/css/coffee-cafe-corner-get-theme-info.css', false ); 
    }
endif;
add_action( 'admin_enqueue_scripts', 'coffee_cafe_corner_admin_scripts' );

/**
 * Register Footer Customizer Controls for Database Management
 */
function coffee_cafe_corner_customize_footer( $wp_customize ) {
	$wp_customize->add_section( 'coffee_cafe_corner_footer_section', array(
		'title'       => esc_html__( 'Footer Settings', 'coffee-cafe-corner' ),
		'priority'    => 120,
		'description' => esc_html__( 'Manage Quills Coffee footer contact and link information saved in database.', 'coffee-cafe-corner' ),
	) );

	$settings = array(
		'footer_brand_name'       => array( 'label' => 'Brand / Title', 'default' => 'QUILLS COFFEE' ),
		'footer_address_street'   => array( 'label' => 'Street Address', 'default' => '800 E Main Street' ),
		'footer_address_city'     => array( 'label' => 'City, State Zip', 'default' => 'Louisville, KY 40206' ),
		'footer_phone'            => array( 'label' => 'Phone', 'default' => '502-861-5844' ),
		'footer_email'            => array( 'label' => 'Email', 'default' => 'hello@quillscoffee.com' ),
		'footer_currency'         => array( 'label' => 'Currency Code', 'default' => 'USD' ),
		'footer_lang'             => array( 'label' => 'Language Code', 'default' => 'EN' ),
		'footer_social_facebook'  => array( 'label' => 'Facebook URL', 'default' => 'https://facebook.com/' ),
		'footer_social_instagram' => array( 'label' => 'Instagram URL', 'default' => 'https://instagram.com/' ),
		'footer_copyright'        => array( 'label' => 'Copyright Text', 'default' => '© 2026, Quills Coffee . Website by Cronk Studios' ),
	);

	foreach ( $settings as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data['default'],
			'sanitize_callback' => 'wp_kses_post',
			'type'              => 'option',
		) );

		$wp_customize->add_control( $id, array(
			'label'    => esc_html__( $data['label'], 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_footer_section',
			'settings' => $id,
			'type'     => 'text',
		) );
	}
}
add_action( 'customize_register', 'coffee_cafe_corner_customize_footer' );

/**
 * Seed Footer Options and Navigation Menus in Database if not present
 */
function coffee_cafe_corner_init_footer_database() {
	return; // Seeder disabled: All data managed in database
	// 1. Seed options in wp_options
	$defaults = array(
		'footer_brand_name'       => 'QUILLS COFFEE',
		'footer_address_street'   => '800 E Main Street',
		'footer_address_city'     => 'Louisville, KY 40206',
		'footer_phone'            => '502-861-5844',
		'footer_email'            => 'hello@quillscoffee.com',
		'footer_currency'         => 'USD',
		'footer_lang'             => 'EN',
		'footer_social_facebook'  => 'https://facebook.com/',
		'footer_social_instagram' => 'https://instagram.com/',
		'footer_copyright'        => '© 2026, Quills Coffee . Website by Cronk Studios',
	);

	foreach ( $defaults as $opt => $val ) {
		if ( false === get_option( $opt ) ) {
			add_option( $opt, $val );
		}
	}

	// 2. Seed navigation menus in database (wp_terms & wp_posts)
	if ( ! get_option( 'coffee_cafe_corner_menus_seeded' ) ) {
		// Quick Links Menu
		$quick_links_menu = wp_get_nav_menu_object( 'Quick Links' );
		if ( ! $quick_links_menu ) {
			$quick_menu_id = wp_create_nav_menu( 'Quick Links' );
			if ( ! is_wp_error( $quick_menu_id ) ) {
				$quick_items = array(
					array( 'title' => 'Home', 'url' => home_url( '/' ) ),
					array( 'title' => 'About Us', 'url' => home_url( '/about-us/' ) ),
					array( 'title' => 'Email Us', 'url' => 'mailto:hello@quillscoffee.com' ),
					array( 'title' => 'Barista Application', 'url' => home_url( '/barista-application/' ) ),
					array( 'title' => 'Terms of Service', 'url' => home_url( '/terms-of-service/' ) ),
					array( 'title' => 'Refund policy', 'url' => home_url( '/refund-policy/' ) ),
				);
				foreach ( $quick_items as $pos => $item ) {
					wp_update_nav_menu_item( $quick_menu_id, 0, array(
						'menu-item-title'   => $item['title'],
						'menu-item-url'     => $item['url'],
						'menu-item-status'  => 'publish',
						'menu-item-position'=> $pos + 1,
					) );
				}
			}
		} else {
			$quick_menu_id = $quick_links_menu->term_id;
		}

		// Company Menu
		$company_menu = wp_get_nav_menu_object( 'Company' );
		if ( ! $company_menu ) {
			$company_menu_id = wp_create_nav_menu( 'Company' );
			if ( ! is_wp_error( $company_menu_id ) ) {
				$company_items = array(
					array( 'title' => 'Coffee', 'url' => home_url( '/coffee/' ) ),
					array( 'title' => 'Subscriptions', 'url' => home_url( '/subscriptions/' ) ),
					array( 'title' => 'Brew Gear', 'url' => home_url( '/brew-gear/' ) ),
					array( 'title' => 'Merch', 'url' => home_url( '/merch/' ) ),
					array( 'title' => 'Gift Cards', 'url' => home_url( '/gift-cards/' ) ),
					array( 'title' => 'Visit', 'url' => home_url( '/visit/' ) ),
					array( 'title' => 'About', 'url' => home_url( '/about/' ) ),
				);
				foreach ( $company_items as $pos => $item ) {
					wp_update_nav_menu_item( $company_menu_id, 0, array(
						'menu-item-title'   => $item['title'],
						'menu-item-url'     => $item['url'],
						'menu-item-status'  => 'publish',
						'menu-item-position'=> $pos + 1,
					) );
				}
			}
		} else {
			$company_menu_id = $company_menu->term_id;
		}

		// Bind menus to theme locations
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		if ( ! empty( $quick_menu_id ) ) {
			$locations['footer-quick-links'] = $quick_menu_id;
		}
		if ( ! empty( $company_menu_id ) ) {
			$locations['footer-company'] = $company_menu_id;
		}
		set_theme_mod( 'nav_menu_locations', $locations );

		update_option( 'coffee_cafe_corner_menus_seeded', 1 );
	}

	// 3. Primary Navigation Menu in database (Header)
	$primary_menu = wp_get_nav_menu_object( 'Primary Navigation' );
	if ( ! $primary_menu ) {
		$primary_menu_id = wp_create_nav_menu( 'Primary Navigation' );
		if ( ! is_wp_error( $primary_menu_id ) ) {
			$primary_items = array(
				array( 'title' => 'COFFEE',        'url' => home_url( '/shop/' ) ),
				array( 'title' => 'SUBSCRIPTIONS', 'url' => home_url( '/subscriptions/' ) ),
				array( 'title' => 'BREW GEAR',     'url' => home_url( '/brew-gear/' ) ),
				array( 'title' => 'WHOLESALE',     'url' => home_url( '/wholesale/' ) ),
				array( 'title' => 'MERCH',         'url' => home_url( '/merch/' ) ),
				array( 'title' => 'GIFT CARDS',    'url' => home_url( '/gift-cards/' ) ),
				array( 'title' => 'VISIT',         'url' => home_url( '/visit/' ) ),
				array( 'title' => 'ABOUT',         'url' => home_url( '/about/' ) ),
			);
			foreach ( $primary_items as $pos => $item ) {
				wp_update_nav_menu_item( $primary_menu_id, 0, array(
					'menu-item-title'    => $item['title'],
					'menu-item-url'      => $item['url'],
					'menu-item-status'   => 'publish',
					'menu-item-position' => $pos + 1,
				) );
			}
		}
	} else {
		$primary_menu_id = $primary_menu->term_id;
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $primary_menu_id ) && ( empty( $locations['primary'] ) || $locations['primary'] !== $primary_menu_id ) ) {
		$locations['primary'] = $primary_menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
add_action( 'init', 'coffee_cafe_corner_init_footer_database' );

/**
 * Add custom classes to Primary Navigation menu items and links
 */
function coffee_cafe_corner_nav_menu_classes( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$classes[] = 'quills-nav-item';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'coffee_cafe_corner_nav_menu_classes', 10, 3 );

function coffee_cafe_corner_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$existing_class = isset( $atts['class'] ) ? $atts['class'] . ' ' : '';
		$atts['class'] = trim( $existing_class . 'quills-nav-link' );
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'coffee_cafe_corner_nav_menu_link_attributes', 10, 3 );

/**
 * Ensure Visit Block Pattern is registered even if transient cache is stale
 */
function coffee_cafe_corner_register_visit_pattern() {
	if ( class_exists( 'WP_Block_Patterns_Registry' ) && ! WP_Block_Patterns_Registry::get_instance()->is_registered( 'coffee-cafe-corner/visit' ) ) {
		$pattern_file = get_template_directory() . '/patterns/visit.php';
		if ( file_exists( $pattern_file ) ) {
			ob_start();
			include $pattern_file;
			$pattern_content = ob_get_clean();

			register_block_pattern(
				'coffee-cafe-corner/visit',
				array(
					'title'       => __( 'Visit - Locations & Hours', 'coffee-cafe-corner' ),
					'categories'  => array( 'coffee-cafe-corner', 'pages' ),
					'description' => __( 'Quills Coffee authentic Locations & Hours page pattern, dynamically pulling content from WordPress database.', 'coffee-cafe-corner' ),
					'content'     => $pattern_content,
				)
			);
		}
	}
}
add_action( 'init', 'coffee_cafe_corner_register_visit_pattern', 9 );

/**
 * Seed Visit Page and Cafes Post Meta in Database if not present
 */
function coffee_cafe_corner_init_visit_database() {
	return; // Seeder disabled: All data managed in database
	if ( get_option( 'coffee_cafe_corner_visit_seeded' ) ) {
		return;
	}

	$pages_to_seed = array(
		'visit'     => 'Locations & Hours',
		'our-cafes' => 'Our Cafes',
	);

	$intro_text = "If you happen to be in our neck of the woods, we'd love to see you. This is where it all started after all. While our subscriptions bring our curated coffees to your kitchen, there's something special about serving you in person. Each of our cafes has a little charm of its own. Our in-house team designed each of them to be warm and welcoming in their own ways. We have six cafes in various Louisville neighborhoods, and one in downtown Indianapolis. You can read a bit about each and find our hours and directions below. Stop by for our seasonal menu of espresso drinks, single origin coffees, and baked goods. Fresh bags of our coffees and merch are always available on the shelves as well.";

	$cafes = array(
		array(
			'id'            => 'nulu',
			'name'          => 'NULU OR "THE FIREHOUSE"',
			'image'         => 'nulu.jpg',
			'address'       => '802 E. Main Street, Louisville, KY 40206',
			'map_url'       => 'https://www.google.com/maps/place/802+E+Main+St,+Louisville,+KY+40206',
			'hours'         => 'Mon-Fri: 6AM-7PM · Sat-Sun: 7AM-7PM',
			'phone'         => '(502) 861-5844',
			'read_more_url' => home_url( '/about-us?view=nulu' ),
		),
		array(
			'id'            => 'highlands',
			'name'          => 'HIGHLANDS',
			'image'         => 'highlands.jpg',
			'address'       => '930 Baxter Avenue, Louisville, KY 40204',
			'map_url'       => 'https://www.google.com/maps/place/930+Baxter+Ave,+Louisville,+KY+40204',
			'hours'         => 'Mon-Fri: 7AM-6PM · Sat-Sun: 7AM-7PM',
			'phone'         => '(502) 861-5844',
			'read_more_url' => home_url( '/about-us?view=highlands' ),
		),
		array(
			'id'            => 'indianapolis',
			'name'          => 'INDIANAPOLIS',
			'image'         => 'indianapolis.jpg',
			'address'       => '941 N. Meridian Street, Indianapolis, IN 46204',
			'map_url'       => 'https://www.google.com/maps/place/941+N+Meridian+St,+Indianapolis,+IN+46204',
			'hours'         => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
			'phone'         => '(502) 861-5844',
			'read_more_url' => home_url( '/about-us?view=indianapolis' ),
		),
		array(
			'id'            => 'st-matthews',
			'name'          => 'ST. MATTHEWS',
			'image'         => 'st-matthews.jpg',
			'address'       => '3939 Shelbyville Rd., Suite 105, Louisville, KY 40207',
			'map_url'       => 'https://www.google.com/maps/place/3939+Shelbyville+Rd+Suite+105,+Louisville,+KY+40207',
			'hours'         => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
			'phone'         => '(502) 861-5844',
			'read_more_url' => home_url( '/about-us?view=st-matthews' ),
		),
		array(
			'id'            => 'j-town',
			'name'          => 'J-TOWN',
			'image'         => 'j-town.jpg',
			'address'       => '10501 Watterson Trail, Louisville, KY 40299',
			'map_url'       => 'https://www.google.com/maps/place/10501+Watterson+Trail,+Louisville,+KY+40299',
			'hours'         => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
			'phone'         => '(502) 861-5844',
			'read_more_url' => home_url( '/about-us?view=j-town' ),
		),
		array(
			'id'            => 'norton-commons',
			'name'          => 'NORTON COMMONS',
			'image'         => 'norton-commons.jpg',
			'address'       => '11213 River Beauty Loop, Prospect, KY 40059',
			'map_url'       => 'https://www.google.com/maps/place/11213+River+Beauty+Loop,+Prospect,+KY+40059',
			'hours'         => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
			'phone'         => '(502) 861-5844',
			'read_more_url' => home_url( '/about-us?view=norton-commons' ),
		),
		array(
			'id'            => 'frankfort-avenue',
			'name'          => 'FRANKFORT AVENUE',
			'image'         => 'frankfort-avenue.jpg',
			'address'       => '2001 Frankfort Avenue, Louisville, KY 40206',
			'map_url'       => 'https://www.google.com/maps/place/2001+Frankfort+Ave,+Louisville,+KY+40206',
			'hours'         => 'Mon-Fri: 7AM-7PM · Sat-Sun: 7AM-7PM',
			'phone'         => '(502) 861-5844',
			'read_more_url' => home_url( '/about-us?view=frankfort-avenue' ),
		),
	);

	foreach ( $pages_to_seed as $slug => $title ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page ) {
			$page_id = wp_insert_post( array(
				'post_title'     => $title,
				'post_name'      => $slug,
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/visit"} /-->',
				'comment_status' => 'closed',
			) );
		} else {
			$page_id = $page->ID;
			// Ensure pattern is set in post_content if empty or default
			if ( empty( trim( $page->post_content ) ) ) {
				wp_update_post( array(
					'ID'           => $page_id,
					'post_content' => '<!-- wp:pattern {"slug":"coffee-cafe-corner/visit"} /-->',
				) );
			}
		}

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			// Seed metadata into wp_postmeta table in database if not set
			if ( ! get_post_meta( $page_id, '_visit_hero_title', true ) ) {
				update_post_meta( $page_id, '_visit_hero_title', 'Our Cafes' );
			}
			if ( ! get_post_meta( $page_id, '_visit_hero_image', true ) ) {
				update_post_meta( $page_id, '_visit_hero_image', 'our-cafes-hero.jpg' );
			}
			if ( ! get_post_meta( $page_id, '_visit_breadcrumb', true ) ) {
				update_post_meta( $page_id, '_visit_breadcrumb', 'Locations & Hours' );
			}
			if ( ! get_post_meta( $page_id, '_visit_intro_text', true ) ) {
				update_post_meta( $page_id, '_visit_intro_text', $intro_text );
			}
			if ( ! get_post_meta( $page_id, '_visit_section_title', true ) ) {
				update_post_meta( $page_id, '_visit_section_title', 'LOCATIONS & HOURS' );
			}
			if ( ! get_post_meta( $page_id, '_visit_cafes', true ) ) {
				update_post_meta( $page_id, '_visit_cafes', $cafes );
			}
			if ( ! get_post_meta( $page_id, '_quills_cafe_details', true ) ) {
				$all_details = get_option( 'quills_cafe_details' );
				if ( ! empty( $all_details ) ) {
					update_post_meta( $page_id, '_quills_cafe_details', $all_details );
				}
			}
		}
	}

	$about_page = get_page_by_path( 'about-us', OBJECT, 'page' );
	if ( $about_page && ! get_post_meta( $about_page->ID, '_quills_cafe_details', true ) ) {
		$all_details = get_option( 'quills_cafe_details' );
		if ( ! empty( $all_details ) ) {
			update_post_meta( $about_page->ID, '_quills_cafe_details', $all_details );
		}
	}

	update_option( 'coffee_cafe_corner_visit_seeded', 1 );
}
add_action( 'init', 'coffee_cafe_corner_init_visit_database' );

/**
 * Brew Gear Collection Database Management
 */
require_once get_template_directory() . '/inc/class-brew-gear-db.php';

/**
 * Wholesale Page Database Management
 */
require_once get_template_directory() . '/inc/class-wholesale-db.php';

/**
 * Coffee Collection Database Management
 */
require_once get_template_directory() . '/inc/class-coffee-db.php';

/**
 * Subscriptions Database Management
 */
require_once get_template_directory() . '/inc/class-subscription-db.php';

/**
 * Merch Database Management
 */
require_once get_template_directory() . '/inc/class-merch-db.php';

/**
 * Quills Search Modal & Database Management
 */
require_once get_template_directory() . '/inc/class-search-db.php';

/**
 * Quills Coffee Experience (Single Product, Reviews, Add to Cart)
 */
require_once get_template_directory() . '/inc/class-quills-experience.php';

/**
 * Cafe Locations & Subpages Database Management
 */
require_once get_template_directory() . '/inc/class-cafe-locations-db.php';
if ( class_exists( 'Coffee_Cafe_Corner_Cafe_Locations_DB' ) ) {
	Coffee_Cafe_Corner_Cafe_Locations_DB::init();
}

/**
 * Quills Products (Home Bestsellers, Merch, Gift Cards) Database Management
 */
require_once get_template_directory() . '/inc/class-quills-products-db.php';

/**
 * Quills Product Custom Meta Box & Cache Sync for wp-admin
 */
require_once get_template_directory() . '/inc/class-quills-admin-meta.php';

/**
 * Permanently disable WooCommerce Coming Soon / Site Visibility mode
 * Ensures single product pages, shop, and customer reviews are always accessible
 */
add_filter( 'woocommerce_coming_soon_exclude', '__return_true', 999 );
add_action( 'init', function() {
	if ( get_option( 'woocommerce_coming_soon' ) === 'yes' ) {
		update_option( 'woocommerce_coming_soon', 'no' );
	}
	if ( get_option( 'woocommerce_store_pages_only' ) === 'yes' ) {
		update_option( 'woocommerce_store_pages_only', 'no' );
	}
}, 1 );

