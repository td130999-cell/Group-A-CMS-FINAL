<?php
/**
 * Class Coffee_Cafe_Corner_Wholesale_DB
 *
 * Handles database interaction for the Wholesale page:
 * - Automatically verifies and seeds the Wholesale page and metadata in the database
 * - Provides dynamic database queries for hero title, intro copy, video, and form data
 * - Registers WordPress rewrite rules for /pages/wholesale
 * - Manages Customizer settings for full database-backed customizability
 * - Stores sample requests and wholesale inquiries in the database
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Wholesale_DB {

	/**
	 * Page slug
	 */
	const PAGE_SLUG = 'wholesale';

	/**
	 * Template file
	 */
	const TEMPLATE_NAME = 'page-wholesale.html';

	/**
	 * Initialize hooks
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'ensure_database_records' ) );
		add_action( 'init', array( __CLASS__, 'register_rewrite_rules' ) );
		add_action( 'customize_register', array( __CLASS__, 'register_customizer_settings' ) );
		add_action( 'wp_ajax_wholesale_submit_inquiry', array( __CLASS__, 'handle_inquiry_submission' ) );
		add_action( 'wp_ajax_nopriv_wholesale_submit_inquiry', array( __CLASS__, 'handle_inquiry_submission' ) );
	}

	/**
	 * Register URL rewrites to support both /wholesale/ and /pages/wholesale/
	 */
	public static function register_rewrite_rules() {
		add_rewrite_rule( '^pages/wholesale/?$', 'index.php?pagename=wholesale', 'top' );
	}

	/**
	 * Ensure the Wholesale page exists in the WordPress database
	 *
	 * @return int Page ID
	 */
	public static function ensure_database_records() {
		$page = get_page_by_path( self::PAGE_SLUG );

		$defaults = array(
			'_wp_page_template'          => self::TEMPLATE_NAME,
			'_wholesale_hero_title'      => 'Wholesale Coffee Roasting',
			'_wholesale_intro_heading'    => 'Hey there! I’m Michael.',
			'_wholesale_intro_lead'       => 'We want to help you build a cafe people love coming back to.',
			'_wholesale_paragraph_1'     => 'After 19 years and seven cafes of our own, we know what a new owner needs from a coffee partner.',
			'_wholesale_paragraph_2'     => 'You get coffee we serve in our own cafes, recipes and training for your baristas, and my personal cell for when you need a hand.',
			'_wholesale_paragraph_3'     => 'Answer a few questions below to get your samples. I\'ll reach out to talk through your coffee program and arrange a free sample box.',
			'_wholesale_video_id'        => 'zihbfybcjm',
			'_wholesale_video_poster'    => 'michael-video-poster.jpg',
			'_wholesale_video_subtitle'  => 'and we would love to help you elevate your coffee game.',
			'_wholesale_typeform_id'     => '01KTS8WAR0STGANR36ZWT3PJAP',
		);

		if ( ! $page ) {
			$page_id = wp_insert_post( array(
				'post_title'     => 'Wholesale Coffee Roasting',
				'post_name'      => self::PAGE_SLUG,
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/wholesale"} /-->',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			) );

			if ( ! is_wp_error( $page_id ) && $page_id > 0 ) {
				foreach ( $defaults as $meta_key => $meta_val ) {
					update_post_meta( $page_id, $meta_key, $meta_val );
				}
				flush_rewrite_rules( false );
				return $page_id;
			}
		} else {
			// Ensure essential metadata exists
			foreach ( $defaults as $meta_key => $meta_val ) {
				$existing = get_post_meta( $page->ID, $meta_key, true );
				if ( '' === $existing || false === $existing ) {
					update_post_meta( $page->ID, $meta_key, $meta_val );
				}
			}

			// Ensure page template is set
			$current_tpl = get_post_meta( $page->ID, '_wp_page_template', true );
			if ( self::TEMPLATE_NAME !== $current_tpl ) {
				update_post_meta( $page->ID, '_wp_page_template', self::TEMPLATE_NAME );
			}

			return $page->ID;
		}

		return 0;
	}

	/**
	 * Retrieve wholesale page content directly from the database
	 *
	 * @return array Sanitized array of wholesale page data
	 */
	public static function get_wholesale_data() {
		$page = get_page_by_path( self::PAGE_SLUG );
		$page_id = $page ? $page->ID : 0;

		$hero_title = $page_id ? get_post_meta( $page_id, '_wholesale_hero_title', true ) : '';
		if ( empty( $hero_title ) ) {
			$hero_title = 'Wholesale Coffee Roasting';
		}

		$intro_heading = $page_id ? get_post_meta( $page_id, '_wholesale_intro_heading', true ) : '';
		if ( empty( $intro_heading ) ) {
			$intro_heading = 'Hey there! I’m Michael.';
		}

		$intro_lead = $page_id ? get_post_meta( $page_id, '_wholesale_intro_lead', true ) : '';
		if ( empty( $intro_lead ) ) {
			$intro_lead = 'We want to help you build a cafe people love coming back to.';
		}

		$p1 = $page_id ? get_post_meta( $page_id, '_wholesale_paragraph_1', true ) : '';
		if ( empty( $p1 ) ) {
			$p1 = 'After 19 years and seven cafes of our own, we know what a new owner needs from a coffee partner.';
		}

		$p2 = $page_id ? get_post_meta( $page_id, '_wholesale_paragraph_2', true ) : '';
		if ( empty( $p2 ) ) {
			$p2 = 'You get coffee we serve in our own cafes, recipes and training for your baristas, and my personal cell for when you need a hand.';
		}

		$p3 = $page_id ? get_post_meta( $page_id, '_wholesale_paragraph_3', true ) : '';
		if ( empty( $p3 ) ) {
			$p3 = 'Answer a few questions below to get your samples. I\'ll reach out to talk through your coffee program and arrange a free sample box.';
		}

		$video_id = $page_id ? get_post_meta( $page_id, '_wholesale_video_id', true ) : '';
		if ( empty( $video_id ) ) {
			$video_id = 'zihbfybcjm';
		}

		$video_poster = $page_id ? get_post_meta( $page_id, '_wholesale_video_poster', true ) : '';
		if ( empty( $video_poster ) ) {
			$video_poster = 'michael-video-poster.jpg';
		}

		$video_subtitle = $page_id ? get_post_meta( $page_id, '_wholesale_video_subtitle', true ) : '';
		if ( empty( $video_subtitle ) ) {
			$video_subtitle = 'and we would love to help you elevate your coffee game.';
		}

		$typeform_id = $page_id ? get_post_meta( $page_id, '_wholesale_typeform_id', true ) : '';
		if ( empty( $typeform_id ) ) {
			$typeform_id = '01KTS8WAR0STGANR36ZWT3PJAP';
		}

		$theme_uri = get_template_directory_uri();
		$poster_url = $theme_uri . '/assets/images/wholesale/' . $video_poster;

		return array(
			'page_id'        => $page_id,
			'hero_title'     => $hero_title,
			'intro_heading'  => $intro_heading,
			'intro_lead'     => $intro_lead,
			'paragraphs'     => array( $p1, $p2, $p3 ),
			'video_id'       => $video_id,
			'video_poster'   => $poster_url,
			'video_subtitle' => $video_subtitle,
			'typeform_id'    => $typeform_id,
		);
	}

	/**
	 * Handle Wholesale sample inquiry form submission via AJAX and store in DB
	 */
	public static function handle_inquiry_submission() {
		check_ajax_referer( 'wholesale_nonce', 'security' );

		$name        = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email       = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone       = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$cafe_name   = isset( $_POST['cafe_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cafe_name'] ) ) : '';
		$location    = isset( $_POST['location'] ) ? sanitize_text_field( wp_unslash( $_POST['location'] ) ) : '';
		$timeline    = isset( $_POST['timeline'] ) ? sanitize_text_field( wp_unslash( $_POST['timeline'] ) ) : '';
		$message     = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

		if ( empty( $name ) || empty( $email ) ) {
			wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
		}

		// Save submission to database as custom post or postmeta
		$inquiry_id = wp_insert_post( array(
			'post_title'   => sprintf( 'Wholesale Inquiry: %s (%s)', $cafe_name ? $cafe_name : $name, $name ),
			'post_type'    => 'wholesale_inquiry',
			'post_status'  => 'publish',
			'post_content' => $message,
		) );

		if ( ! is_wp_error( $inquiry_id ) ) {
			update_post_meta( $inquiry_id, '_inquiry_name', $name );
			update_post_meta( $inquiry_id, '_inquiry_email', $email );
			update_post_meta( $inquiry_id, '_inquiry_phone', $phone );
			update_post_meta( $inquiry_id, '_inquiry_cafe', $cafe_name );
			update_post_meta( $inquiry_id, '_inquiry_location', $location );
			update_post_meta( $inquiry_id, '_inquiry_timeline', $timeline );
			update_post_meta( $inquiry_id, '_inquiry_date', current_time( 'mysql' ) );

			wp_send_json_success( array(
				'message' => 'Thank you! Michael will review your details and reach out soon with sample box arrangements.',
			) );
		} else {
			wp_send_json_error( array( 'message' => 'Unable to save inquiry. Please try again.' ) );
		}
	}

	/**
	 * Register Customizer settings for database-backed customization
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 */
	public static function register_customizer_settings( $wp_customize ) {
		$wp_customize->add_section( 'wholesale_settings_section', array(
			'title'       => __( 'Wholesale Page Settings', 'coffee-cafe-corner' ),
			'priority'    => 35,
			'description' => __( 'Customize the content and video on the Wholesale page.', 'coffee-cafe-corner' ),
		) );

		$fields = array(
			'wholesale_hero_title'     => array(
				'label'   => __( 'Hero Title', 'coffee-cafe-corner' ),
				'default' => 'Wholesale Coffee Roasting',
				'type'    => 'text',
			),
			'wholesale_intro_heading'  => array(
				'label'   => __( 'Intro Heading', 'coffee-cafe-corner' ),
				'default' => 'Hey there! I’m Michael.',
				'type'    => 'text',
			),
			'wholesale_intro_lead'     => array(
				'label'   => __( 'Lead Paragraph (Bold)', 'coffee-cafe-corner' ),
				'default' => 'We want to help you build a cafe people love coming back to.',
				'type'    => 'textarea',
			),
			'wholesale_video_subtitle' => array(
				'label'   => __( 'Video Subtitle Pill Text', 'coffee-cafe-corner' ),
				'default' => 'and we would love to help you elevate your coffee game.',
				'type'    => 'text',
			),
			'wholesale_typeform_id'    => array(
				'label'   => __( 'Typeform Form ID', 'coffee-cafe-corner' ),
				'default' => '01KTS8WAR0STGANR36ZWT3PJAP',
				'type'    => 'text',
			),
		);

		foreach ( $fields as $id => $config ) {
			$wp_customize->add_setting( $id, array(
				'default'           => $config['default'],
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( $id, array(
				'label'   => $config['label'],
				'section' => 'wholesale_settings_section',
				'type'    => $config['type'],
			) );
		}
	}
}

Coffee_Cafe_Corner_Wholesale_DB::init();
