<?php
/**
 * Class Coffee_Cafe_Corner_Merch_DB
 *
 * Handles database interaction for Quills Coffee Merchandise (Merch):
 * - Automatically verifies and seeds the category, 12 apparel/merch products, and page in the database
 * - Matches the exact 12 products, pricing, high-res images, sizing, and descriptions from Quills Coffee
 * - Provides dynamic database queries, sorting, and single product helper methods
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Merch_DB {

	const TAXONOMY      = 'product_cat';
	const CATEGORY_SLUG  = 'merch';
	const PAGE_SLUG      = 'merch';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'ensure_database_records' ) );
	}

	public static function ensure_database_records() {
		if ( get_option( 'coffee_cafe_corner_merch_seeded_v4' ) ) {
			return;
		}
		self::ensure_category();
		self::ensure_page();
		self::ensure_products();
		update_option( 'coffee_cafe_corner_merch_seeded_v4', 1 );
	}

	public static function ensure_category() {
		$term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );

		if ( ! $term ) {
			$inserted = wp_insert_term(
				'Merch',
				self::TAXONOMY,
				array(
					'description' => 'Wear your favorite roaster with pride. Premium crafted tees, fleece hoodies, embroidered hats, mugs, and heavy canvas tote bags.',
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

	public static function ensure_page() {
		$page = get_page_by_path( self::PAGE_SLUG );

		if ( ! $page ) {
			$page_id = wp_insert_post( array(
				'post_title'     => 'Merch',
				'post_name'      => self::PAGE_SLUG,
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/merch"} /-->',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			) );

			if ( ! is_wp_error( $page_id ) && $page_id > 0 ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-merch.html' );
				update_post_meta( $page_id, '_merch_banner_title', 'Merch' );
				return $page_id;
			}
			return 0;
		}

		if ( ! get_post_meta( $page->ID, '_wp_page_template', true ) ) {
			update_post_meta( $page->ID, '_wp_page_template', 'page-merch.html' );
		}

		return $page->ID;
	}

	public static function ensure_products() {
		$category_term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );
		$term_id       = $category_term ? (int) $category_term->term_id : 0;

		$merch_products = array(
			array(
				'slugs'        => array( 'crewneck-sweatshirt-evergreen', 'quills-coffee-leaves-crewneck-sweatshirt' ),
				'title'        => 'Crewneck Sweatshirt (Evergreen)',
				'price'        => '45.00',
				'description'  => "Midweight Quills fleece sweatshirt in evergreen color.\n\nCotton/polyester blend.",
				'image'        => 'merch-crewneck-evergreen.jpg',
				'gallery'      => array( 'merch-crewneck-evergreen.jpg' ),
				'sizes'        => array(
					array( 'size' => 'XS', 'available' => false ),
					array( 'size' => 'S', 'available' => false ),
					array( 'size' => 'M', 'available' => true ),
					array( 'size' => 'L', 'available' => true ),
					array( 'size' => 'XL', 'available' => true ),
					array( 'size' => '2XL', 'available' => false ),
				),
				'default_size' => 'M',
				'low_stock'    => 'Low stock: 3 left',
				'rating'       => '5.0',
				'review_count' => 2,
				'menu_order'   => 1,
				'reviews'      => array(
					array(
						'author'  => 'Tyler B.',
						'rating'  => 5,
						'content' => 'Super soft fleece and fits true to size. The evergreen color and owl embroidery are top notch!',
						'date'    => '2026-09-18 11:20:00',
					),
					array(
						'author'  => 'Hannah M.',
						'rating'  => 5,
						'content' => 'One of my favorite sweatshirts now. Washes nicely without shrinking.',
						'date'    => '2026-10-01 15:45:00',
					),
				),
			),
			array(
				'slugs'        => array( 'crewneck-sweatshirt-sandstone', 'quills-coffee-leaves-crewneck-sweatshirt-copy' ),
				'title'        => 'Crewneck Sweatshirt (Sandstone)',
				'price'        => '45.00',
				'description'  => "Midweight Quills fleece sweatshirt in sandstone color.\n\nCotton/polyester blend.",
				'image'        => 'merch-crewneck-sandstone.jpg',
				'gallery'      => array( 'merch-crewneck-sandstone.jpg' ),
				'sizes'        => array(
					array( 'size' => 'XS', 'available' => true ),
					array( 'size' => 'S', 'available' => true ),
					array( 'size' => 'M', 'available' => true ),
					array( 'size' => 'L', 'available' => true ),
					array( 'size' => 'XL', 'available' => true ),
					array( 'size' => '2XL', 'available' => false ),
				),
				'default_size' => 'M',
				'low_stock'    => 'Low stock: 4 left',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 2,
			),
			array(
				'slugs'        => array( 'owl-ringer-tee', 'quills-kentucky-owl-ringer-tee' ),
				'title'        => 'Owl Ringer Tee',
				'price'        => '23.00',
				'description'  => "Retro ringer tee in ivory with dark green bands.\n\n100% cotton.",
				'image'        => 'merch-owl-ringer-tee.jpg',
				'gallery'      => array( 'merch-owl-ringer-tee.jpg' ),
				'sizes'        => array(
					array( 'size' => 'XS', 'available' => true ),
					array( 'size' => 'S', 'available' => true ),
					array( 'size' => 'M', 'available' => true ),
					array( 'size' => 'L', 'available' => true ),
					array( 'size' => 'XL', 'available' => false ),
					array( 'size' => '2XL', 'available' => true ),
				),
				'default_size' => 'M',
				'low_stock'    => 'Low stock: 2 left',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 3,
			),
			array(
				'slugs'        => array( 'owl-tee-in-pastel-green', 'quills-kentucky-owl-ringer-tee-copy' ),
				'title'        => 'Owl Tee in Pastel Green',
				'price'        => '26.00',
				'description'  => "Garment dyed heavyweight t-shirt in pastel green.\n\n100% US cotton.",
				'image'        => 'merch-owl-tee-pastel-green.jpg',
				'gallery'      => array( 'merch-owl-tee-pastel-green.jpg' ),
				'sizes'        => array(
					array( 'size' => 'S', 'available' => true ),
					array( 'size' => 'M', 'available' => false ),
					array( 'size' => 'L', 'available' => true ),
					array( 'size' => 'XL', 'available' => true ),
					array( 'size' => '2XL', 'available' => true ),
				),
				'default_size' => 'S',
				'low_stock'    => 'Low stock: 5 left',
				'rating'       => '5.0',
				'review_count' => 2,
				'menu_order'   => 4,
				'reviews'      => array(
					array(
						'author'  => 'Emily C.',
						'rating'  => 5,
						'content' => 'Gorgeous sage green shade and the cotton is so heavy and durable.',
						'date'    => '2026-09-14 09:30:00',
					),
					array(
						'author'  => 'Jake W.',
						'rating'  => 5,
						'content' => 'Great boxy fit, love the subtle owl graphic.',
						'date'    => '2026-10-03 14:15:00',
					),
				),
			),
			array(
				'slugs'        => array( 'owl-embroidered-hat', 'quills-owl-embroidered-hat' ),
				'title'        => 'Owl Embroidered Hat',
				'price'        => '27.00',
				'description'  => "Unstructured snapback in green with gold embroidered owl logo.\n\n100% cotton.",
				'image'        => 'merch-owl-embroidered-hat.jpg',
				'gallery'      => array( 'merch-owl-embroidered-hat.jpg' ),
				'sizes'        => array(),
				'default_size' => '',
				'low_stock'    => 'In stock',
				'rating'       => '5.0',
				'review_count' => 1,
				'menu_order'   => 5,
				'reviews'      => array(
					array(
						'author'  => 'Ryan G.',
						'rating'  => 5,
						'content' => 'Fits comfortably and embroidery quality is incredible.',
						'date'    => '2026-09-22 17:00:00',
					),
				),
			),
			array(
				'slugs'        => array( 'two-tone-embroidered-hat', 'quills-owl-embroidered-hat-copy' ),
				'title'        => 'Two-tone Embroidered Hat',
				'price'        => '27.00',
				'description'  => "Five-panel two-tone cap with embroidered Quills Coffee.\n\n100% cotton.",
				'image'        => 'merch-twotone-embroidered-hat.jpg',
				'gallery'      => array( 'merch-twotone-embroidered-hat.jpg' ),
				'sizes'        => array(),
				'default_size' => '',
				'low_stock'    => 'In stock',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 6,
			),
			array(
				'slugs'        => array( 'quills-speckled-coffee-mug', 'quills-coffee-mug' ),
				'title'        => 'Quills Speckled Coffee Mug',
				'price'        => '19.00',
				'description'  => '12 oz ceramic mug in speckled ivory, with Quills logo and Steve the owl.',
				'image'        => 'merch-speckled-coffee-mug.jpg',
				'gallery'      => array( 'merch-speckled-coffee-mug.jpg' ),
				'sizes'        => array(),
				'default_size' => '',
				'low_stock'    => 'In stock',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 7,
			),
			array(
				'slugs'        => array( 'quills-coffee-postage-mug', 'quills-coffee-mug-copy' ),
				'title'        => 'Quills Coffee Postage Mug',
				'price'        => '19.00',
				'description'  => '12 oz ceramic mug in red with vintage postage postal artwork.',
				'image'        => 'merch-coffee-postage-mug.jpg',
				'gallery'      => array( 'merch-coffee-postage-mug.jpg' ),
				'sizes'        => array(),
				'default_size' => '',
				'low_stock'    => 'Sold out',
				'stock_status' => 'outofstock',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 8,
			),
			array(
				'slugs'        => array( 'quills-slow-coffee-hoodie-charcoal' ),
				'title'        => 'Quill\'s Slow Coffee Hoodie (Charcoal)',
				'price'        => '48.00',
				'description'  => "QUILLS COFFEE MIDWEIGHT HOODED SWEATSHIRT \"SLOW COFFEE\"-CHARCOAL\n\nCozy fleece pullover hoodie in heather charcoal with kangaroo pocket and \"Slow Coffee\" mantra typography on back.",
				'image'        => 'merch-slow-coffee-hoodie-charcoal.jpg',
				'gallery'      => array( 'merch-slow-coffee-hoodie-charcoal.jpg', 'merch-slow-coffee-hoodie-back.jpg' ),
				'sizes'        => array(
					array( 'size' => 'S', 'available' => true ),
					array( 'size' => 'M', 'available' => true ),
					array( 'size' => 'L', 'available' => true ),
					array( 'size' => 'XL', 'available' => false ),
					array( 'size' => '2XL', 'available' => false ),
				),
				'default_size' => 'M',
				'low_stock'    => 'Low stock: 2 left',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 9,
			),
			array(
				'slugs'        => array( 'quills-slow-coffee-hoodie-saddle', 'quills-slow-coffee-hoodie-charcoal-copy' ),
				'title'        => 'Quill\'s Slow Coffee Hoodie (Saddle)',
				'price'        => '48.00',
				'description'  => "QUILLS COFFEE MIDWEIGHT HOODED SWEATSHIRT \"SLOW COFFEE\"-SADDLE\n\nRich warm saddle brown hoodie featuring double-lined hood, thick matching drawstrings, and custom print.",
				'image'        => 'merch-slow-coffee-hoodie-saddle.jpg',
				'gallery'      => array( 'merch-slow-coffee-hoodie-saddle.jpg', 'merch-slow-coffee-hoodie-back.jpg' ),
				'sizes'        => array(
					array( 'size' => 'S', 'available' => true ),
					array( 'size' => 'M', 'available' => true ),
					array( 'size' => 'L', 'available' => true ),
					array( 'size' => 'XL', 'available' => true ),
					array( 'size' => '2XL', 'available' => false ),
				),
				'default_size' => 'M',
				'low_stock'    => 'Low stock: 4 left',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 10,
			),
			array(
				'slugs'        => array( 'quills-postage-tote-bag' ),
				'title'        => 'Quill\'s Postage Tote Bag',
				'price'        => '18.00',
				'description'  => "100% cotton, double-sided tote bag for carrying around your TBR stack.\nDrink good coffee and read good books. Forever and always.\n15\"W X 16\"H",
				'image'        => 'merch-postage-tote-bag.jpg',
				'gallery'      => array( 'merch-postage-tote-bag.jpg' ),
				'sizes'        => array(),
				'default_size' => '',
				'low_stock'    => 'In stock',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 11,
			),
			array(
				'slugs'        => array( 'quills-patch-hat-petrol-blue', 'two-tone-embroidered-hat-copy' ),
				'title'        => 'Quill\'s Patch Hat (Petrol Blue)',
				'price'        => '27.00',
				'description'  => "Five-panel two-tone cap with embroidered Quills Coffee patch.\n\n100% cotton.",
				'image'        => 'merch-patch-hat-petrol-blue.jpg',
				'gallery'      => array( 'merch-patch-hat-petrol-blue.jpg' ),
				'sizes'        => array(),
				'default_size' => '',
				'low_stock'    => 'In stock',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 12,
			),
		);

		foreach ( $merch_products as $item ) {
			$stock_status = isset( $item['stock_status'] ) ? $item['stock_status'] : 'instock';

			foreach ( $item['slugs'] as $slug ) {
				$existing = get_page_by_path( $slug, OBJECT, 'product' );
				$prod_id  = 0;

				if ( ! $existing ) {
					$product_id = wp_insert_post( array(
						'post_title'     => $item['title'],
						'post_name'      => $slug,
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
						update_post_meta( $product_id, '_stock_status', $stock_status );
						update_post_meta( $product_id, '_visibility', 'visible' );
						update_post_meta( $product_id, '_wc_average_rating', $item['rating'] );
						update_post_meta( $product_id, '_wc_review_count', $item['review_count'] );
						update_post_meta( $product_id, '_merch_image', $item['image'] );
						update_post_meta( $product_id, '_merch_gallery', $item['gallery'] );
						update_post_meta( $product_id, '_merch_sizes', $item['sizes'] );
						update_post_meta( $product_id, '_merch_default_size', $item['default_size'] );
						update_post_meta( $product_id, '_merch_low_stock', $item['low_stock'] );

						if ( $term_id > 0 ) {
							wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
						}
						wp_set_object_terms( $product_id, 'simple', 'product_type', false );
					}
				} else {
					$prod_id = $existing->ID;
					wp_update_post( array(
						'ID'             => $existing->ID,
						'post_title'     => $item['title'],
						'post_content'   => $item['description'],
						'post_excerpt'   => $item['description'],
						'comment_status' => 'open',
					) );
					update_post_meta( $prod_id, '_price', $item['price'] );
					update_post_meta( $prod_id, '_regular_price', $item['price'] );
					update_post_meta( $prod_id, '_stock_status', $stock_status );
					update_post_meta( $prod_id, '_wc_average_rating', $item['rating'] );
					update_post_meta( $prod_id, '_wc_review_count', $item['review_count'] );
					update_post_meta( $prod_id, '_merch_image', $item['image'] );
					update_post_meta( $prod_id, '_merch_gallery', $item['gallery'] );
					update_post_meta( $prod_id, '_merch_sizes', $item['sizes'] );
					update_post_meta( $prod_id, '_merch_default_size', $item['default_size'] );
					update_post_meta( $prod_id, '_merch_low_stock', $item['low_stock'] );
					if ( $term_id > 0 ) {
						wp_set_object_terms( $prod_id, array( $term_id ), self::TAXONOMY, true );
					}
				}

				// Seed customer reviews if provided
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
							$author  = ! empty( $rev['author'] ) ? sanitize_text_field( $rev['author'] ) : 'Quills Customer';
							$content = ! empty( $rev['content'] ) ? sanitize_textarea_field( $rev['content'] ) : 'Great quality merch!';
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
	}

	public static function get_product_image_url( $product_id ) {
		$img_name = get_post_meta( $product_id, '_merch_image', true );
		if ( ! $img_name ) {
			$img_name = 'merch-crewneck-evergreen.jpg';
		}
		$basename = basename( $img_name );
		return trailingslashit( get_template_directory_uri() ) . 'assets/images/merch/' . $basename;
	}

	public static function get_product_gallery_urls( $product_id ) {
		$gallery = get_post_meta( $product_id, '_merch_gallery', true );
		if ( ! is_array( $gallery ) || empty( $gallery ) ) {
			return array( self::get_product_image_url( $product_id ) );
		}
		$urls = array();
		foreach ( $gallery as $img ) {
			$basename = basename( $img );
			$urls[]   = trailingslashit( get_template_directory_uri() ) . 'assets/images/merch/' . $basename;
		}
		return array_unique( array_filter( $urls ) );
	}

	public static function get_product_sizes( $product_id ) {
		$sizes = get_post_meta( $product_id, '_merch_sizes', true );
		return is_array( $sizes ) ? $sizes : array();
	}

	public static function get_product_default_size( $product_id ) {
		return get_post_meta( $product_id, '_merch_default_size', true ) ?: 'M';
	}

	public static function get_product_low_stock( $product_id ) {
		return get_post_meta( $product_id, '_merch_low_stock', true ) ?: '';
	}

	public static function get_merch_products_query( $sort_by = 'manual' ) {
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

			case 'manual':
			case 'featured':
			default:
				$args['orderby'] = 'menu_order title';
				$args['order']   = 'ASC';
				break;
		}

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			unset( $args['tax_query'] );
			$query = new WP_Query( $args );
		}

		return $query;
	}
}

Coffee_Cafe_Corner_Merch_DB::init();
