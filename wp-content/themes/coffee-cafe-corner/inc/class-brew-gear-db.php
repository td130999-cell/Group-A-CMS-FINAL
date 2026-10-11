<?php
/**
 * Class Coffee_Cafe_Corner_Brew_Gear_DB
 *
 * Handles database interaction for the Brew Gear collection:
 * - Automatically verifies and seeds the category, products, and page in the database
 * - Provides dynamic database queries for products with multi-option sorting
 * - Manages custom options for the banner and page metadata
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Brew_Gear_DB {

	/**
	 * Taxonomy slug for WooCommerce product categories
	 */
	const TAXONOMY = 'product_cat';

	/**
	 * Category slug
	 */
	const CATEGORY_SLUG = 'brew-gear';

	/**
	 * Page slug
	 */
	const PAGE_SLUG = 'brew-gear';

	/**
	 * Hook initialization
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'ensure_database_records' ) );
		add_action( 'customize_register', array( __CLASS__, 'register_customizer_settings' ) );
	}

	/**
	 * Ensure Category, Products, and Page exist in the WordPress database
	 */
	public static function ensure_database_records() {
		self::ensure_category();
		self::ensure_page();
		self::ensure_products();
	}

	/**
	 * Ensure 'Brew Gear' product category exists
	 *
	 * @return int Term ID
	 */
	public static function ensure_category() {
		$term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );

		if ( ! $term ) {
			$inserted = wp_insert_term(
				'Brew Gear',
				self::TAXONOMY,
				array(
					'description' => 'You can make great coffee at home. Shop our selection of brewing gear and have café quality coffee from the comfort of your own home.',
					'slug'        => self::CATEGORY_SLUG,
				)
			);
			if ( ! is_wp_error( $inserted ) ) {
				return $inserted['term_id'];
			}
			return 0;
		}

		return $term->term_id;
	}

	/**
	 * Ensure 'Brew Gear' page exists in database
	 *
	 * @return int Page ID
	 */
	public static function ensure_page() {
		$page = get_page_by_path( self::PAGE_SLUG );

		if ( ! $page ) {
			$page_id = wp_insert_post( array(
				'post_title'     => 'Brew Gear',
				'post_name'      => self::PAGE_SLUG,
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/brew-gear"} /-->',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			) );

			if ( ! is_wp_error( $page_id ) && $page_id > 0 ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-brew-gear.html' );
				update_post_meta( $page_id, '_brew_gear_banner_title', 'Brew Gear' );
				return $page_id;
			}
			return 0;
		}

		return $page->ID;
	}

	/**
	 * Ensure the 3 equipment products exist in the database with prices and metadata
	 */
	public static function ensure_products() {
		$category_term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );
		$term_id       = $category_term ? (int) $category_term->term_id : 0;

		$products_data = array(
			array(
				'slug'        => 'baratza-encore-grinder',
				'title'       => 'Baratza Encore Grinder',
				'price'       => '149.00',
				'description' => 'The standard for at-home brewing, the Baratza Encore is consistent, reliable, and versatile.',
				'image'       => 'baratza-encore-grinder.png',
				'menu_order'  => 1,
			),
			array(
				'slug'        => 'breville-bambino-espresso-machine',
				'title'       => 'Breville Bambino Espresso Machine',
				'price'       => '299.00',
				'description' => 'Like professional machines, the Bambino can deliver third wave specialty coffee at home using 54mm portafilter.',
				'image'       => 'breville-bambino-espresso-machine.png',
				'menu_order'  => 2,
			),
			array(
				'slug'        => 'breville-luxe-brewer-thermal',
				'title'       => 'Breville Luxe Brewer™ Thermal',
				'price'       => '349.00',
				'description' => 'Precision craft filter coffee brewer with double wall thermal carafe for optimal temperature stability.',
				'image'       => 'breville-luxe-brewer-thermal.png',
				'menu_order'  => 3,
			),
		);

		foreach ( $products_data as $item ) {
			$existing = get_page_by_path( $item['slug'], OBJECT, 'product' );

			if ( ! $existing ) {
				$product_id = wp_insert_post( array(
					'post_title'     => $item['title'],
					'post_name'      => $item['slug'],
					'post_content'   => $item['description'],
					'post_excerpt'   => $item['description'],
					'post_status'    => 'publish',
					'post_type'      => 'product',
					'menu_order'     => $item['menu_order'],
					'comment_status' => 'open',
				) );

				if ( ! is_wp_error( $product_id ) && $product_id > 0 ) {
					update_post_meta( $product_id, '_price', $item['price'] );
					update_post_meta( $product_id, '_regular_price', $item['price'] );
					update_post_meta( $product_id, '_stock_status', 'instock' );
					update_post_meta( $product_id, '_manage_stock', 'no' );
					update_post_meta( $product_id, '_visibility', 'visible' );
					update_post_meta( $product_id, '_wc_average_rating', '0' );
					update_post_meta( $product_id, '_wc_review_count', '0' );
					update_post_meta( $product_id, '_brew_gear_image', $item['image'] );

					if ( $term_id > 0 ) {
						wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
					}
					// Default simple product type
					wp_set_object_terms( $product_id, 'simple', 'product_type', false );
				}
			} else {
				// Ensure meta consistency
				update_post_meta( $existing->ID, '_price', $item['price'] );
				update_post_meta( $existing->ID, '_regular_price', $item['price'] );
				update_post_meta( $existing->ID, '_brew_gear_image', $item['image'] );
				if ( $term_id > 0 ) {
					wp_set_object_terms( $existing->ID, array( $term_id ), self::TAXONOMY, true );
				}
			}
		}
	}

	/**
	 * Query products dynamically from the database based on sort parameter
	 *
	 * @param string $sort_by Sort key
	 * @return WP_Query
	 */
	public static function get_products_query( $sort_by = 'manual' ) {
		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 50,
			'tax_query'      => array(
				array(
					'taxonomy' => self::TAXONOMY,
					'field'    => 'slug',
					'terms'    => self::CATEGORY_SLUG,
				),
			),
		);

		switch ( $sort_by ) {
			case 'price-ascending':
				$args['meta_key'] = '_price';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'ASC';
				break;

			case 'price-descending':
				$args['meta_key'] = '_price';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;

			case 'title-ascending':
				$args['orderby'] = 'title';
				$args['order']   = 'ASC';
				break;

			case 'title-descending':
				$args['orderby'] = 'title';
				$args['order']   = 'DESC';
				break;

			case 'created-descending':
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;

			case 'best-selling':
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;

			case 'manual':
			case 'featured':
			default:
				$args['orderby'] = 'menu_order title';
				$args['order']   = 'ASC';
				break;
		}

		$query = new WP_Query( $args );

		// Fallback query if no category match is found
		if ( ! $query->have_posts() ) {
			unset( $args['tax_query'] );
			$args['post__in'] = array();
			$slugs = array( 'baratza-encore-grinder', 'breville-bambino-espresso-machine', 'breville-luxe-brewer-thermal' );
			foreach ( $slugs as $slug ) {
				$p = get_page_by_path( $slug, OBJECT, 'product' );
				if ( $p ) {
					$args['post__in'][] = $p->ID;
				}
			}
			if ( ! empty( $args['post__in'] ) ) {
				$query = new WP_Query( $args );
			}
		}

		return $query;
	}

	/**
	 * Get product image URL (from post meta, thumbnail, or theme assets)
	 *
	 * @param int $product_id
	 * @return string Image URL
	 */
	public static function get_product_image_url( $product_id ) {
		// 1. Check custom theme meta
		$custom_image = get_post_meta( $product_id, '_brew_gear_image', true );
		if ( ! empty( $custom_image ) ) {
			$theme_file = get_template_directory() . '/assets/images/brew-gear/' . $custom_image;
			if ( file_exists( $theme_file ) ) {
				return get_template_directory_uri() . '/assets/images/brew-gear/' . $custom_image;
			}
		}

		// 2. Check WordPress featured image
		if ( has_post_thumbnail( $product_id ) ) {
			$thumb = get_the_post_thumbnail_url( $product_id, 'large' );
			if ( $thumb ) {
				return $thumb;
			}
		}

		// 3. Fallback based on slug
		$slug = get_post_field( 'post_name', $product_id );
		if ( strpos( $slug, 'baratza' ) !== false ) {
			return get_template_directory_uri() . '/assets/images/brew-gear/baratza-encore-grinder.png';
		}
		if ( strpos( $slug, 'bambino' ) !== false ) {
			return get_template_directory_uri() . '/assets/images/brew-gear/breville-bambino-espresso-machine.png';
		}
		if ( strpos( $slug, 'luxe' ) !== false ) {
			return get_template_directory_uri() . '/assets/images/brew-gear/breville-luxe-brewer-thermal.png';
		}

		return get_template_directory_uri() . '/assets/images/brew-gear/brew-gear-banner.jpg';
	}

	/**
	 * Register Customizer Settings for database-backed banner management
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public static function register_customizer_settings( $wp_customize ) {
		$wp_customize->add_section( 'coffee_cafe_corner_brew_gear_section', array(
			'title'       => esc_html__( 'Brew Gear Collection Settings', 'coffee-cafe-corner' ),
			'priority'    => 125,
			'description' => esc_html__( 'Manage Brew Gear collection banner title, description, and settings saved in database.', 'coffee-cafe-corner' ),
		) );

		$wp_customize->add_setting( 'brew_gear_banner_title', array(
			'default'           => 'Brew Gear',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );

		$wp_customize->add_control( 'brew_gear_banner_title', array(
			'label'    => esc_html__( 'Banner Title', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_banner_title',
			'type'     => 'text',
		) );
	}
}

Coffee_Cafe_Corner_Brew_Gear_DB::init();
