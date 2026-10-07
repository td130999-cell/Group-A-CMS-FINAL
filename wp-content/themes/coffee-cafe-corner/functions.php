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