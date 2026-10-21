<?php
/**
 * Class Coffee_Cafe_Corner_Quills_Products_DB
 *
 * Handles database interaction and real WooCommerce product management for:
 * - Home Bestsellers (Coffee products: Blacksmith, Inkwell, Southern Gothic)
 * - Merch Collection (12 authentic merchandise products)
 * - Gift Cards (Online Store Gift Card WooCommerce product & page)
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Quills_Products_DB {

	const TAX_CAT = 'product_cat';

	/**
	 * Hook initialization
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'ensure_database_records' ), 20 );
	}

	/**
	 * Ensure Categories, Pages, and Products exist in WooCommerce Database
	 */
	public static function ensure_database_records() {
		return; // Seeder disabled: Data is permanently managed in database
		// Only run when WooCommerce is active
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		if ( get_option( 'quills_products_seeded_v1' ) ) {
			return;
		}

		self::ensure_pages();
		self::ensure_categories();
		self::ensure_products();
		update_option( 'quills_products_seeded_v1', 1 );
	}

	/**
	 * Ensure Merch and Gift Cards pages exist with proper patterns
	 */
	public static function ensure_pages() {
		$pages = array(
			'merch'      => array(
				'title'   => 'Merch',
				'pattern' => '<!-- wp:pattern {"slug":"coffee-cafe-corner/merch"} /-->',
			),
			'gift-cards' => array(
				'title'   => 'Gift Cards',
				'pattern' => '<!-- wp:pattern {"slug":"coffee-cafe-corner/gift-cards"} /-->',
			),
		);

		foreach ( $pages as $slug => $data ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( ! $page ) {
				wp_insert_post( array(
					'post_title'     => $data['title'],
					'post_name'      => $slug,
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'post_content'   => $data['pattern'],
					'comment_status' => 'closed',
					'ping_status'    => 'closed',
				) );
			}
		}
	}

	/**
	 * Ensure categories exist
	 */
	public static function ensure_categories() {
		self::get_or_create_term( 'Coffee', 'coffee' );
		self::get_or_create_term( 'Merch', 'merch' );
		self::get_or_create_term( 'Gift Cards', 'gift-cards' );
	}

	public static function get_or_create_term( $name, $slug ) {
		$term = get_term_by( 'slug', $slug, self::TAX_CAT );
		if ( ! $term ) {
			$inserted = wp_insert_term( $name, self::TAX_CAT, array( 'slug' => $slug ) );
			if ( ! is_wp_error( $inserted ) ) {
				return $inserted['term_id'];
			}
			return 0;
		}
		return $term->term_id;
	}

	/**
	 * Ensure all real products are populated in WooCommerce
	 */
	public static function ensure_products() {
		$coffee_cat_id    = self::get_or_create_term( 'Coffee', 'coffee' );
		$merch_cat_id     = self::get_or_create_term( 'Merch', 'merch' );
		$giftcards_cat_id = self::get_or_create_term( 'Gift Cards', 'gift-cards' );

		// 1. Home Bestsellers (Coffee)
		$coffee_products = array(
			array(
				'name'          => 'Blacksmith | Espresso Blend',
				'slug'          => 'blacksmith-espresso',
				'price'         => '20.00',
				'img'           => 'product-blacksmith-front.jpg',
				'short_desc'    => "Baker's chocolate, blueberries, hazelnut",
				'desc'          => "The F1 car of our lineup. Our signature espresso that folks enjoy in every latte, cappuccino, and cortado in our cafés.\n\nProcess: Washed & Natural\nOrigins: Colombia, Nicaragua, Ethiopia",
				'rating'        => 5.0,
				'reviews_count' => 60,
				'meta'          => array(
					'_quills_tag'       => 'BLACKSMITH',
					'_quills_tag_color' => '#000000',
					'_quills_tag_desc'  => 'The F1 car of our lineup. Our signature espresso that folks enjoy in every latte, cappuccino, and cortado in our cafés.',
					'_quills_tasting'   => "Baker's chocolate, blueberries, hazelnut",
					'_quills_details'   => "Our Signature Espresso\nProcess: Washed & Natural\nOrigins: Colombia, Nicaragua, Ethiopia",
					'_quills_back_img'  => 'product-bag-back.jpg',
				),
			),
			array(
				'name'          => 'Inkwell | Signature Blend',
				'slug'          => 'inkwell-blend',
				'price'         => '20.00',
				'img'           => 'product-inkwell-front.jpg',
				'short_desc'    => 'Graham cracker, cooked cherries, vanilla',
				'desc'          => "The daily driver. Our classic house blend that's on drip at our cafes from open to close. Loved by regulars for 17 years.\n\nProcess: Washed & Natural\nOrigins: Colombia, Guatemala, Ethiopia",
				'rating'        => 5.0,
				'reviews_count' => 80,
				'meta'          => array(
					'_quills_tag'       => 'INKWELL',
					'_quills_tag_color' => '#f15239',
					'_quills_tag_desc'  => "The daily driver. Our classic house blend that's on drip at our cafes from open to close. Loved by regulars for 17 years.",
					'_quills_tasting'   => 'Graham cracker, cooked cherries, vanilla',
					'_quills_details'   => "Our Signature House Blend\nProcess: Washed & Natural\nOrigins: Colombia, Guatemala, Ethiopia",
					'_quills_back_img'  => 'product-bag-back.jpg',
				),
			),
			array(
				'name'          => 'Southern Gothic | Cold Brew Blend',
				'slug'          => 'southern-gothic',
				'price'         => '20.00',
				'img'           => 'product-southern-gothic-front.jpg',
				'short_desc'    => 'Chocolate, caramel, well-balanced.',
				'desc'          => "Our cold brew blend crafted for our customers who prefer their coffee chilled.\n\nProcess: Washed, Natural\nOrigins: Brazil & Colombia",
				'rating'        => 5.0,
				'reviews_count' => 21,
				'meta'          => array(
					'_quills_tag'       => 'SOUTHERN GOTHIC',
					'_quills_tag_color' => '#926685',
					'_quills_tag_desc'  => 'Our cold brew blend crafted for our customers who prefer their coffee chilled.',
					'_quills_tasting'   => 'Chocolate, caramel, well-balanced.',
					'_quills_details'   => "Process: Washed, Natural\nOrigins: Brazil & Colombia",
					'_quills_back_img'  => 'product-bag-back.jpg',
				),
			),
		);

		foreach ( $coffee_products as $cp ) {
			self::seed_single_product( $cp, $coffee_cat_id, 'assets/images/home' );
		}

		// 2. Merch (12 products)
		$merch_items = array(
			array(
				'name'          => 'Crewneck Sweatshirt (Evergreen)',
				'slug'          => 'quills-coffee-leaves-crewneck-sweatshirt',
				'price'         => '45.00',
				'img'           => 'merch-crewneck-evergreen.jpg',
				'desc'          => "Midweight Quills fleece sweatshirt in evergreen color.\n\nCotton/polyester blend.",
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => 'Crewneck Sweatshirt (Sandstone)',
				'slug'          => 'quills-coffee-leaves-crewneck-sweatshirt-copy',
				'price'         => '45.00',
				'img'           => 'merch-crewneck-sandstone.jpg',
				'desc'          => "Midweight Quills fleece sweatshirt in sandstone color.\n\nCotton/polyester blend.",
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => 'Owl Ringer Tee',
				'slug'          => 'quills-kentucky-owl-ringer-tee',
				'price'         => '23.00',
				'img'           => 'merch-owl-ringer-tee.jpg',
				'desc'          => "Retro ringer tee in ivory with dark green bands.\n\n100% cotton.",
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => 'Owl Tee in Pastel Green',
				'slug'          => 'quills-kentucky-owl-ringer-tee-copy',
				'price'         => '26.00',
				'img'           => 'merch-owl-tee-pastel-green.jpg',
				'desc'          => "Garment dyed heavyweight t-shirt in pastel green.\n\n100% US cotton.",
				'rating'        => 5.0,
				'reviews_count' => 2,
			),
			array(
				'name'          => 'Owl Embroidered Hat',
				'slug'          => 'quills-owl-embroidered-hat',
				'price'         => '27.00',
				'img'           => 'merch-owl-embroidered-hat.jpg',
				'desc'          => "Unstructured snapback in green with gold embroidered owl logo.\n\n100% cotton.",
				'rating'        => 5.0,
				'reviews_count' => 1,
			),
			array(
				'name'          => 'Two-tone Embroidered Hat',
				'slug'          => 'quills-owl-embroidered-hat-copy',
				'price'         => '27.00',
				'img'           => 'merch-twotone-embroidered-hat.jpg',
				'desc'          => "Five-panel two-tone cap with embroidered Quills Coffee.\n\n100% cotton.",
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => 'Quills Speckled Coffee Mug',
				'slug'          => 'quills-coffee-mug',
				'price'         => '19.00',
				'img'           => 'merch-speckled-coffee-mug.jpg',
				'desc'          => '12 oz ceramic mug in speckled ivory, with Quills logo and Steve the owl.',
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => 'Quills Coffee Postage Mug',
				'slug'          => 'quills-coffee-mug-copy',
				'price'         => '19.00',
				'img'           => 'merch-coffee-postage-mug.jpg',
				'desc'          => 'Red Ceramic Quills "Postage"',
				'rating'        => 0,
				'reviews_count' => 0,
				'stock_status'  => 'outofstock',
			),
			array(
				'name'          => "Quill's Slow Coffee Hoodie (Charcoal)",
				'slug'          => 'quills-slow-coffee-hoodie-charcoal',
				'price'         => '48.00',
				'img'           => 'merch-slow-coffee-hoodie-charcoal.jpg',
				'desc'          => 'QUILLS COFFEE MIDWEIGHT HOODED SWEATSHIRT "SLOW COFFEE"-CHARCOAL',
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => "Quill's Slow Coffee Hoodie (Saddle)",
				'slug'          => 'quills-slow-coffee-hoodie-charcoal-copy',
				'price'         => '48.00',
				'img'           => 'merch-slow-coffee-hoodie-saddle.jpg',
				'desc'          => 'QUILLS COFFEE MIDWEIGHT HOODED SWEATSHIRT "SLOW COFFEE"-SADDLE',
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => "Quill's Postage Tote Bag",
				'slug'          => 'quills-postage-tote-bag',
				'price'         => '18.00',
				'img'           => 'merch-postage-tote-bag.jpg',
				'desc'          => 'QUILLS COFFEE 15"W X 16"H TOTE BAG "POSTAGE"',
				'rating'        => 0,
				'reviews_count' => 0,
			),
			array(
				'name'          => "Quill's Patch Hat (Petrol Blue)",
				'slug'          => 'two-tone-embroidered-hat-copy',
				'price'         => '27.00',
				'img'           => 'merch-patch-hat-petrol-blue.jpg',
				'desc'          => "Five-panel two-tone cap with embroidered Quills Coffee.\n\n100% cotton.",
				'rating'        => 0,
				'reviews_count' => 0,
			),
		);

		foreach ( $merch_items as $mi ) {
			self::seed_single_product( $mi, $merch_cat_id, 'assets/images/merch' );
		}

		// 3. Gift Card
		$gift_card = array(
			'name'          => 'Gift Card',
			'slug'          => 'gift-card',
			'price'         => '25.00',
			'img'           => 'online-gift-card.png',
			'short_desc'    => 'Digital gift card for whole bean coffee, merchandise, and more from our online store.',
			'desc'          => "A gift card that can be used to order whole bean coffee, merchandise, and more from our website.\n\nThis type of gift card is not valid in our cafes.",
			'rating'        => 5.0,
			'reviews_count' => 12,
		);

		self::seed_single_product( $gift_card, $giftcards_cat_id, 'assets/images/gift-cards' );
	}

	/**
	 * Seed a single WooCommerce product
	 */
	public static function seed_single_product( $data, $cat_id, $img_rel_dir ) {
		$existing = get_page_by_path( $data['slug'], OBJECT, 'product' );
		if ( $existing ) {
			return $existing->ID;
		}

		$product = new WC_Product_Simple();
		$product->set_name( $data['name'] );
		$product->set_slug( $data['slug'] );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_regular_price( $data['price'] );
		$product->set_price( $data['price'] );
		$product->set_description( $data['desc'] ?? '' );
		$product->set_short_description( $data['short_desc'] ?? '' );
		$product->set_manage_stock( false );
		$product->set_stock_status( $data['stock_status'] ?? 'instock' );

		if ( $cat_id ) {
			$product->set_category_ids( array( $cat_id ) );
		}

		// Attach featured image
		if ( ! empty( $data['img'] ) ) {
			$thumb_id = self::get_or_create_attachment( $data['img'], $img_rel_dir, $data['name'] );
			if ( $thumb_id ) {
				$product->set_image_id( $thumb_id );
			}
		}

		if ( isset( $data['rating'] ) ) {
			$product->set_average_rating( $data['rating'] );
			$product->set_review_count( $data['reviews_count'] );
		}

		$product_id = $product->save();

		// Custom Meta
		if ( ! empty( $data['meta'] ) && is_array( $data['meta'] ) ) {
			foreach ( $data['meta'] as $meta_k => $meta_v ) {
				update_post_meta( $product_id, $meta_k, $meta_v );
			}
		}

		return $product_id;
	}

	/**
	 * Attach image from theme directory to Media Library
	 */
	public static function get_or_create_attachment( $image_filename, $relative_theme_path, $title ) {
		$theme_dir = get_template_directory();
		$full_path = $theme_dir . '/' . $relative_theme_path . '/' . $image_filename;

		if ( ! file_exists( $full_path ) ) {
			return 0;
		}

		global $wpdb;
		$attachment_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND guid LIKE %s",
			'%' . $image_filename . '%'
		) );

		if ( $attachment_id ) {
			return (int) $attachment_id;
		}

		$upload_dir  = wp_upload_dir();
		$target_file = $upload_dir['path'] . '/' . $image_filename;
		@copy( $full_path, $target_file );

		$wp_filetype = wp_check_filetype( $image_filename, null );
		$attachment  = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_text_field( $title ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		$attachment_id = wp_insert_attachment( $attachment, $target_file );
		if ( ! is_wp_error( $attachment_id ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			$attach_data = wp_generate_attachment_metadata( $attachment_id, $target_file );
			wp_update_attachment_metadata( $attachment_id, $attach_data );
			return $attachment_id;
		}

		return 0;
	}

	/**
	 * Query Home Bestsellers (Real DB Products)
	 *
	 * @return WC_Product[]
	 */
	public static function get_home_bestsellers() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return array();
		}

		$bestseller_slug_groups = array(
			array( 'blacksmith-espresso-blend', 'blacksmith-espresso' ),
			array( 'inkwell-signature-blend', 'inkwell-blend' ),
			array( 'southern-gothic-cold-brew', 'southern-gothic' ),
		);

		$products = array();
		foreach ( $bestseller_slug_groups as $slugs ) {
			foreach ( $slugs as $slug ) {
				$prod_post = get_page_by_path( $slug, OBJECT, 'product' );
				if ( $prod_post && function_exists( 'wc_get_product' ) ) {
					$wc_prod = wc_get_product( $prod_post->ID );
					if ( $wc_prod && $wc_prod->is_visible() ) {
						$products[] = $wc_prod;
						break;
					}
				}
			}
		}

		if ( count( $products ) < 3 ) {
			$fallback = wc_get_products( array(
				'category' => array( 'coffee' ),
				'status'   => 'publish',
				'limit'    => 3,
			) );
			foreach ( $fallback as $p ) {
				if ( ! in_array( $p, $products, true ) ) {
					$products[] = $p;
				}
				if ( count( $products ) >= 3 ) {
					break;
				}
			}
		}

		return $products;
	}

	/**
	 * Query Merch Collection (Real DB Products)
	 *
	 * @param string $sort Sort key
	 * @return WC_Product[]
	 */
	public static function get_merch_products( $sort = 'featured' ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return array();
		}

		$args = array(
			'category' => array( 'merch' ),
			'status'   => 'publish',
			'limit'    => 12,
		);

		if ( 'featured' === $sort || empty( $sort ) ) {
			$ordered_slugs = array(
				array( 'crewneck-sweatshirt-evergreen', 'quills-coffee-leaves-crewneck-sweatshirt' ),
				array( 'crewneck-sweatshirt-sandstone', 'quills-coffee-leaves-crewneck-sweatshirt-copy' ),
				array( 'owl-ringer-tee', 'quills-kentucky-owl-ringer-tee' ),
				array( 'owl-tee-in-pastel-green', 'quills-kentucky-owl-ringer-tee-copy' ),
				array( 'owl-embroidered-hat', 'quills-owl-embroidered-hat' ),
				array( 'two-tone-embroidered-hat', 'quills-owl-embroidered-hat-copy' ),
				array( 'quills-speckled-coffee-mug', 'quills-coffee-mug' ),
				array( 'quills-coffee-postage-mug', 'quills-coffee-mug-copy' ),
				array( 'quills-slow-coffee-hoodie-charcoal' ),
				array( 'quills-slow-coffee-hoodie-saddle', 'quills-slow-coffee-hoodie-charcoal-copy' ),
				array( 'quills-postage-tote-bag' ),
				array( 'quills-patch-hat-petrol-blue', 'two-tone-embroidered-hat-copy' ),
			);

			$ordered_products = array();
			$used_ids = array();

			foreach ( $ordered_slugs as $slug_group ) {
				foreach ( $slug_group as $slug ) {
					$post = get_page_by_path( $slug, OBJECT, 'product' );
					if ( $post && ! in_array( $post->ID, $used_ids, true ) ) {
						$wc_p = wc_get_product( $post->ID );
						if ( $wc_p && $wc_p->is_visible() ) {
							$ordered_products[] = $wc_p;
							$used_ids[] = $post->ID;
							break;
						}
					}
				}
			}

			if ( count( $ordered_products ) >= 12 ) {
				return $ordered_products;
			}

			$fallback = wc_get_products( $args );
			foreach ( $fallback as $p ) {
				if ( ! in_array( $p->get_id(), $used_ids, true ) ) {
					$ordered_products[] = $p;
					$used_ids[] = $p->get_id();
				}
				if ( count( $ordered_products ) >= 12 ) {
					break;
				}
			}
			return $ordered_products;
		}
		switch ( $sort ) {
			case 'price-ascending':
				$args['orderby'] = 'price';
				$args['order']   = 'ASC';
				break;
			case 'price-descending':
				$args['orderby'] = 'price';
				$args['order']   = 'DESC';
				break;
			case 'title-ascending':
				$args['orderby'] = 'title';
				$args['order']   = 'ASC';
				break;
			case 'title-descending':
				$args['orderby'] = 'title';
				$args['order']   = 'DESC';
				break;
			case 'created-ascending':
				$args['orderby'] = 'date';
				$args['order']   = 'ASC';
				break;
			case 'created-descending':
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;
			default:
				$args['orderby'] = 'date';
				$args['order']   = 'ASC';
				break;
		}

		return wc_get_products( $args );
	}

	/**
	 * Query Gift Card (Real DB Product)
	 *
	 * @return WC_Product|null
	 */
	public static function get_gift_card_product() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return null;
		}

		$products = wc_get_products( array(
			'category' => array( 'gift-cards' ),
			'status'   => 'publish',
			'limit'    => 1,
		) );

		return ! empty( $products ) ? $products[0] : null;
	}
}

Coffee_Cafe_Corner_Quills_Products_DB::init();
