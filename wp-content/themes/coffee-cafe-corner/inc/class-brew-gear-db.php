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
		add_action( 'customize_save_after', array( __CLASS__, 'sync_customizer_products' ) );
	}

	/**
	 * Ensure Category, Products, and Page exist in the WordPress database
	 */
	public static function ensure_database_records() {
		if ( get_option( 'coffee_cafe_corner_brew_gear_seeded_v3' ) ) {
			return;
		}
		self::ensure_category();
		self::ensure_page();
		self::ensure_products();
		update_option( 'coffee_cafe_corner_brew_gear_seeded_v3', 1 );
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
				'description' => "Here at Quills, we typically recommend folks begin their home coffee brewing by purchasing a quality grinder.\n\nThe Baratza Encore is a tried-and-true, easy-to-use burr grinder built for better coffee at home. With a wide range of grind settings, it handles everything from French press to pour-over and drip coffee, making it a great first grinder for anyone ready to move beyond pre-ground coffee.",
				'image'       => 'baratza-encore-grinder.png',
				'gallery'     => array( 'baratza-encore-1.png', 'baratza-encore-2.png', 'baratza-encore-3.png' ),
				'menu_order'  => 1,
				'reviews'     => array(
					array(
						'author'  => 'Marcus K.',
						'rating'  => 5,
						'content' => 'The Baratza Encore has been my daily workhorse for over a year now. Stepless adjustment is consistent and grounds are uniform for my pour-overs. Super easy to dial in!',
						'date'    => '2026-09-12 10:14:00',
					),
					array(
						'author'  => 'Sarah P.',
						'rating'  => 5,
						'content' => 'Compact, durable, and very easy to clean. Recommended by Quills staff and it definitely elevated my morning brew experience.',
						'date'    => '2026-09-28 14:32:00',
					),
				),
			),
			array(
				'slug'        => 'breville-bambino-espresso-machine',
				'title'       => 'Breville Bambino Espresso Machine',
				'price'       => '299.00',
				'description' => 'The Breville Bambino delivers barista-quality espresso in a compact, easy-to-use machine. Its 54mm portafilter holds an 18-gram dose for full flavor, while low-pressure pre-infusion and 9-bar extraction help produce balanced, consistent shots. A powerful manual steam wand creates silky microfoam ideal for latte art, and Breville’s ThermoJet heating system gets the machine ready to brew in just 3 seconds.',
				'image'       => 'breville-bambino-espresso-machine.png',
				'gallery'     => array( 'breville-bambino-espresso-machine.png', 'breville-bambino-2.png', 'breville-bambino-3.png', 'breville-bambino-4.png' ),
				'menu_order'  => 2,
				'reviews'     => array(
					array(
						'author'  => 'David L.',
						'rating'  => 5,
						'content' => 'The 3-second heat-up is a game changer in the mornings. Steam power is shocking for a machine this size, pulls rich crema and velvety microfoam.',
						'date'    => '2026-09-15 08:22:00',
					),
					array(
						'author'  => 'Jessica T.',
						'rating'  => 5,
						'content' => 'Perfect compact home espresso machine. Fits beautifully on the kitchen counter and produces genuine café quality espresso effortlessly.',
						'date'    => '2026-10-02 16:45:00',
					),
				),
			),
			array(
				'slug'        => 'breville-luxe-brewer-thermal',
				'title'       => 'Breville Luxe Brewer™ Thermal',
				'price'       => '349.00',
				'description' => "Experience precision without complexity, delivering consistently great brews at the touch of a button. Simply select Brew and the machine does the rest, providing a perfect cup of coffee that meets SCA (Specialty Coffee Association) Golden Cup standards. Versatile brewing options include Cold Brew and even Custom settings, allowing you to set your own preferences.\n\nThe dual-wall thermal carafe keeps your brew hotter for longer (up to 4 hours) while the large capacity removable water tank is easy to fill. The included flat bottom and cone filter options make this the perfect brewer to suit a wide range of coffee making expertise and taste preferences.",
				'image'       => 'breville-luxe-brewer-thermal.png',
				'gallery'     => array( 'breville-luxe-brewer-thermal.png', 'breville-luxe-2.png' ),
				'menu_order'  => 3,
				'reviews'     => array(
					array(
						'author'  => 'Brian M.',
						'rating'  => 5,
						'content' => 'The thermal carafe keeps coffee hot without cooking it on a hotplate. SCA certified quality shines through every morning.',
						'date'    => '2026-09-20 09:10:00',
					),
					array(
						'author'  => 'Elena R.',
						'rating'  => 5,
						'content' => 'Outstanding drip brewer! Versatile brew options from Gold Cup to Cold Brew, and the carafe stays warm for hours.',
						'date'    => '2026-10-05 11:30:00',
					),
				),
			),
		);

		foreach ( $products_data as $item ) {
			$existing = get_page_by_path( $item['slug'], OBJECT, 'product' );
			$prod_id  = 0;

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
					$prod_id = $product_id;
					update_post_meta( $product_id, '_price', $item['price'] );
					update_post_meta( $product_id, '_regular_price', $item['price'] );
					update_post_meta( $product_id, '_stock_status', 'instock' );
					update_post_meta( $product_id, '_manage_stock', 'no' );
					update_post_meta( $product_id, '_visibility', 'visible' );
					update_post_meta( $product_id, '_wc_average_rating', '5.0' );
					update_post_meta( $product_id, '_wc_review_count', '2' );
					update_post_meta( $product_id, '_brew_gear_image', $item['image'] );
					update_post_meta( $product_id, '_brew_gear_gallery', $item['gallery'] );

					if ( $term_id > 0 ) {
						wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
					}
					// Default simple product type
					wp_set_object_terms( $product_id, 'simple', 'product_type', false );
				}
			} else {
				$prod_id = $existing->ID;
				// Ensure content and meta consistency
				wp_update_post( array(
					'ID'             => $existing->ID,
					'post_title'     => $item['title'],
					'post_content'   => $item['description'],
					'post_excerpt'   => $item['description'],
					'comment_status' => 'open',
				) );
				update_post_meta( $existing->ID, '_price', $item['price'] );
				update_post_meta( $existing->ID, '_regular_price', $item['price'] );
				update_post_meta( $existing->ID, '_brew_gear_image', $item['image'] );
				update_post_meta( $existing->ID, '_brew_gear_gallery', $item['gallery'] );
				if ( $term_id > 0 ) {
					wp_set_object_terms( $existing->ID, array( $term_id ), self::TAXONOMY, true );
				}
			}

			// Seed database customer reviews if empty
			if ( ! empty( $item['reviews'] ) && $prod_id > 0 ) {
				$existing_reviews = get_comments( array(
					'post_id' => $prod_id,
					'type'    => 'review',
					'count'   => true,
				) );

				if ( $existing_reviews == 0 ) {
					$total_stars = 0;
					$rev_count   = 0;

					foreach ( $item['reviews'] as $rev ) {
						$rating  = isset( $rev['rating'] ) ? (int) $rev['rating'] : 5;
						$author  = ! empty( $rev['author'] ) ? sanitize_text_field( $rev['author'] ) : 'Coffee Enthusiast';
						$content = ! empty( $rev['content'] ) ? sanitize_textarea_field( $rev['content'] ) : 'Excellent gear!';
						$date    = ! empty( $rev['date'] ) ? sanitize_text_field( $rev['date'] ) : current_time( 'mysql' );

						$comment_id = wp_insert_comment( array(
							'comment_post_ID'      => $prod_id,
							'comment_author'       => $author,
							'comment_author_email' => sanitize_title( $author ) . '@quills-customer.com',
							'comment_content'      => $content,
							'comment_type'         => 'review',
							'comment_approved'     => 1,
							'comment_date'         => $date,
						) );

						if ( $comment_id > 0 ) {
							update_comment_meta( $comment_id, 'rating', $rating );
							update_comment_meta( $comment_id, '_rating', $rating );
							$total_stars += $rating;
							$rev_count++;
						}
					}

					$avg = $rev_count > 0 ? round( $total_stars / $rev_count, 1 ) : 5.0;
					update_post_meta( $prod_id, '_wc_average_rating', number_format( $avg, 1, '.', '' ) );
					update_post_meta( $prod_id, '_wc_review_count', $rev_count );
					delete_transient( 'quills_sp_reviews_' . $prod_id );
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
	 * Get product image URL (from Customizer, post meta, thumbnail, or theme assets)
	 *
	 * @param int $product_id
	 * @return string Image URL
	 */
	public static function get_product_image_url( $product_id ) {
		// 0. Check Customizer options first
		$slug = get_post_field( 'post_name', $product_id );
		if ( strpos( $slug, 'baratza' ) !== false ) {
			$opt = get_option( 'brew_gear_product_1_image' );
			if ( ! empty( $opt ) ) {
				return $opt;
			}
		} elseif ( strpos( $slug, 'bambino' ) !== false ) {
			$opt = get_option( 'brew_gear_product_2_image' );
			if ( ! empty( $opt ) ) {
				return $opt;
			}
		} elseif ( strpos( $slug, 'luxe' ) !== false ) {
			$opt = get_option( 'brew_gear_product_3_image' );
			if ( ! empty( $opt ) ) {
				return $opt;
			}
		}

		// 1. Check custom theme meta
		$custom_image = get_post_meta( $product_id, '_brew_gear_image', true );
		if ( ! empty( $custom_image ) ) {
			if ( filter_var( $custom_image, FILTER_VALIDATE_URL ) ) {
				return $custom_image;
			}
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
	 * Get product gallery URLs for Brew Gear products
	 *
	 * @param int $product_id
	 * @return array List of image URLs
	 */
	public static function get_product_gallery_urls( $product_id ) {
		$gallery = get_post_meta( $product_id, '_brew_gear_gallery', true );
		if ( empty( $gallery ) || ! is_array( $gallery ) ) {
			$slug = get_post_field( 'post_name', $product_id );
			if ( strpos( $slug, 'baratza' ) !== false ) {
				$gallery = array( 'baratza-encore-1.png', 'baratza-encore-2.png', 'baratza-encore-3.png' );
			} elseif ( strpos( $slug, 'bambino' ) !== false ) {
				$gallery = array( 'breville-bambino-espresso-machine.png', 'breville-bambino-2.png', 'breville-bambino-3.png', 'breville-bambino-4.png' );
			} elseif ( strpos( $slug, 'luxe' ) !== false ) {
				$gallery = array( 'breville-luxe-brewer-thermal.png', 'breville-luxe-2.png' );
			}
		}

		$urls = array();
		if ( is_array( $gallery ) ) {
			foreach ( $gallery as $img ) {
				if ( filter_var( $img, FILTER_VALIDATE_URL ) ) {
					$urls[] = $img;
				} else {
					$theme_file = get_template_directory() . '/assets/images/brew-gear/' . ltrim( $img, '/' );
					if ( file_exists( $theme_file ) ) {
						$urls[] = trailingslashit( get_template_directory_uri() ) . 'assets/images/brew-gear/' . ltrim( $img, '/' );
					}
				}
			}
		}
		return array_values( array_unique( array_filter( $urls ) ) );
	}

	/**
	 * Register Customizer Settings for database-backed banner, label, and product management
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public static function register_customizer_settings( $wp_customize ) {
		$wp_customize->add_section( 'coffee_cafe_corner_brew_gear_section', array(
			'title'       => esc_html__( 'Brew Gear Collection Settings', 'coffee-cafe-corner' ),
			'priority'    => 125,
			'description' => esc_html__( 'Manage Brew Gear banner, labels, and products saved in database.', 'coffee-cafe-corner' ),
		) );

		// 1. Banner Title
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

		// 2. Banner Image
		$wp_customize->add_setting( 'brew_gear_banner_image', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'brew_gear_banner_image', array(
			'label'    => esc_html__( 'Banner Background Image', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_banner_image',
		) ) );

		// 3. Sort By Label
		$wp_customize->add_setting( 'brew_gear_sort_label', array(
			'default'           => 'Sort by:',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_sort_label', array(
			'label'    => esc_html__( 'Sort By Label', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_sort_label',
			'type'     => 'text',
		) );

		// 4. Add To Cart Button Text
		$wp_customize->add_setting( 'brew_gear_add_to_cart_text', array(
			'default'           => 'ADD TO CART',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_add_to_cart_text', array(
			'label'    => esc_html__( 'Add to Cart Button Text', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_add_to_cart_text',
			'type'     => 'text',
		) );

		// 5. Product 1 (Baratza Encore Grinder)
		$wp_customize->add_setting( 'brew_gear_product_1_title', array(
			'default'           => 'Baratza Encore Grinder',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_product_1_title', array(
			'label'       => esc_html__( 'Product 1 Title', 'coffee-cafe-corner' ),
			'section'     => 'coffee_cafe_corner_brew_gear_section',
			'settings'    => 'brew_gear_product_1_title',
			'type'        => 'text',
		) );

		$wp_customize->add_setting( 'brew_gear_product_1_price', array(
			'default'           => '149.00',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_product_1_price', array(
			'label'    => esc_html__( 'Product 1 Price ($)', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_product_1_price',
			'type'     => 'text',
		) );

		$wp_customize->add_setting( 'brew_gear_product_1_image', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'brew_gear_product_1_image', array(
			'label'    => esc_html__( 'Product 1 Image', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_product_1_image',
		) ) );

		// 6. Product 2 (Breville Bambino Espresso Machine)
		$wp_customize->add_setting( 'brew_gear_product_2_title', array(
			'default'           => 'Breville Bambino Espresso Machine',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_product_2_title', array(
			'label'       => esc_html__( 'Product 2 Title', 'coffee-cafe-corner' ),
			'section'     => 'coffee_cafe_corner_brew_gear_section',
			'settings'    => 'brew_gear_product_2_title',
			'type'        => 'text',
		) );

		$wp_customize->add_setting( 'brew_gear_product_2_price', array(
			'default'           => '299.00',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_product_2_price', array(
			'label'    => esc_html__( 'Product 2 Price ($)', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_product_2_price',
			'type'     => 'text',
		) );

		$wp_customize->add_setting( 'brew_gear_product_2_image', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'brew_gear_product_2_image', array(
			'label'    => esc_html__( 'Product 2 Image', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_product_2_image',
		) ) );

		// 7. Product 3 (Breville Luxe Brewer™ Thermal)
		$wp_customize->add_setting( 'brew_gear_product_3_title', array(
			'default'           => 'Breville Luxe Brewer™ Thermal',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_product_3_title', array(
			'label'       => esc_html__( 'Product 3 Title', 'coffee-cafe-corner' ),
			'section'     => 'coffee_cafe_corner_brew_gear_section',
			'settings'    => 'brew_gear_product_3_title',
			'type'        => 'text',
		) );

		$wp_customize->add_setting( 'brew_gear_product_3_price', array(
			'default'           => '349.00',
			'sanitize_callback' => 'sanitize_text_field',
			'type'              => 'option',
		) );
		$wp_customize->add_control( 'brew_gear_product_3_price', array(
			'label'    => esc_html__( 'Product 3 Price ($)', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_product_3_price',
			'type'     => 'text',
		) );

		$wp_customize->add_setting( 'brew_gear_product_3_image', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'brew_gear_product_3_image', array(
			'label'    => esc_html__( 'Product 3 Image', 'coffee-cafe-corner' ),
			'section'  => 'coffee_cafe_corner_brew_gear_section',
			'settings' => 'brew_gear_product_3_image',
		) ) );
	}

	/**
	 * Sync Customizer product changes to WooCommerce database posts & postmeta
	 */
	public static function sync_customizer_products() {
		$items = array(
			array(
				'slug'  => 'baratza-encore-grinder',
				'title' => get_option( 'brew_gear_product_1_title' ),
				'price' => get_option( 'brew_gear_product_1_price' ),
				'image' => get_option( 'brew_gear_product_1_image' ),
			),
			array(
				'slug'  => 'breville-bambino-espresso-machine',
				'title' => get_option( 'brew_gear_product_2_title' ),
				'price' => get_option( 'brew_gear_product_2_price' ),
				'image' => get_option( 'brew_gear_product_2_image' ),
			),
			array(
				'slug'  => 'breville-luxe-brewer-thermal',
				'title' => get_option( 'brew_gear_product_3_title' ),
				'price' => get_option( 'brew_gear_product_3_price' ),
				'image' => get_option( 'brew_gear_product_3_image' ),
			),
		);

		foreach ( $items as $item ) {
			$post = get_page_by_path( $item['slug'], OBJECT, 'product' );
			if ( $post ) {
				$pid = $post->ID;
				if ( ! empty( $item['title'] ) && $item['title'] !== $post->post_title ) {
					wp_update_post( array(
						'ID'         => $pid,
						'post_title' => $item['title'],
					) );
				}
				if ( ! empty( $item['price'] ) ) {
					update_post_meta( $pid, '_price', $item['price'] );
					update_post_meta( $pid, '_regular_price', $item['price'] );
				}
				if ( ! empty( $item['image'] ) ) {
					update_post_meta( $pid, '_brew_gear_image', $item['image'] );
				}
			}
		}
	}
}

Coffee_Cafe_Corner_Brew_Gear_DB::init();
