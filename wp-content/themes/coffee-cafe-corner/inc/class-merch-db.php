<?php
/**
 * Class Coffee_Cafe_Corner_Merch_DB
 *
 * Handles database interaction for Quills Coffee Merchandise (Merch):
 * - Automatically verifies and seeds the category, 12 apparel/merch products, and page in the database
 * - Matches the exact 12 products and pricing shown in the Merch layout
 * - Provides dynamic database queries and sorting
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
		self::ensure_category();
		self::ensure_page();
		self::ensure_products();
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
				'slug'         => 'crewneck-sweatshirt-evergreen',
				'title'        => 'Crewneck Sweatshirt (Evergreen)',
				'price'        => '45.00',
				'description'  => 'Comfortable heavyweight cotton-fleece crewneck in rich evergreen forest shade with classic Quills emblem embroidery.',
				'image'        => 'merch/crewneck-sweatshirt-evergreen.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 1,
			),
			array(
				'slug'         => 'crewneck-sweatshirt-sandstone',
				'title'        => 'Crewneck Sweatshirt (Sandstone)',
				'price'        => '45.00',
				'description'  => 'Soft brushed sandstone fleece crewneck sweatshirt, perfect for cool morning cafe rituals.',
				'image'        => 'merch/crewneck-sweatshirt-sandstone.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 2,
			),
			array(
				'slug'         => 'owl-ringer-tee',
				'title'        => 'Owl Ringer Tee',
				'price'        => '23.00',
				'description'  => 'Vintage-inspired retro ringer tee featuring contrasting ribbed collar and the iconic Quills Owl graphic.',
				'image'        => 'merch/owl-ringer-tee.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 3,
			),
			array(
				'slug'         => 'owl-tee-in-pastel-green',
				'title'        => 'Owl Tee in Pastel Green',
				'price'        => '26.00',
				'description'  => 'Ultra-soft 100% combed ringspun cotton tee in soothing pastel sage green with subtle chest illustration.',
				'image'        => 'merch/owl-tee-pastel-green.png',
				'rating'       => '5.0',
				'review_count' => 2,
				'menu_order'   => 4,
			),
			array(
				'slug'         => 'owl-embroidered-hat',
				'title'        => 'Owl Embroidered Hat',
				'price'        => '27.00',
				'description'  => 'Low-profile unstructured dad hat with fine custom owl embroidery and brass buckle back strap.',
				'image'        => 'merch/owl-embroidered-hat.png',
				'rating'       => '4.0',
				'review_count' => 1,
				'menu_order'   => 5,
			),
			array(
				'slug'         => 'two-tone-embroidered-hat',
				'title'        => 'Two-tone Embroidered Hat',
				'price'        => '27.00',
				'description'  => 'Two-tone vintage baseball cap with structured crown and contrasting visor in earthy khaki and olive.',
				'image'        => 'merch/two-tone-embroidered-hat.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 6,
			),
			array(
				'slug'         => 'quills-speckled-coffee-mug',
				'title'        => 'Quills Speckled Coffee Mug',
				'price'        => '19.00',
				'description'  => 'Heavyweight 12oz ceramic diner mug with natural stone speckles and hand-stamped Quills logo.',
				'image'        => 'merch/quills-speckled-coffee-mug.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 7,
			),
			array(
				'slug'         => 'quills-coffee-postage-mug',
				'title'        => 'Quills Coffee Postage Mug',
				'price'        => '19.00',
				'description'  => 'Classic stoneware coffee mug celebrating our Louisville heritage with vintage postage postal artwork.',
				'image'        => 'merch/quills-coffee-postage-mug.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 8,
			),
			array(
				'slug'         => 'quills-slow-coffee-hoodie-charcoal',
				'title'        => 'Quill\'s Slow Coffee Hoodie (Charcoal)',
				'price'        => '48.00',
				'description'  => 'Cozy fleece pullover hoodie in heather charcoal with kangaroo pocket and "Slow Coffee" mantra typography on back.',
				'image'        => 'merch/quills-slow-coffee-hoodie-charcoal.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 9,
			),
			array(
				'slug'         => 'quills-slow-coffee-hoodie-saddle',
				'title'        => 'Quill\'s Slow Coffee Hoodie (Saddle)',
				'price'        => '48.00',
				'description'  => 'Rich warm saddle brown hoodie featuring double-lined hood, thick matching drawstrings, and custom print.',
				'image'        => 'merch/quills-slow-coffee-hoodie-saddle.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 10,
			),
			array(
				'slug'         => 'quills-postage-tote-bag',
				'title'        => 'Quill\'s Postage Tote Bag',
				'price'        => '18.00',
				'description'  => 'Durable 100% natural cotton canvas tote with reinforced shoulder straps, designed for market runs and book carrying.',
				'image'        => 'merch/quills-postage-tote-bag.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 11,
			),
			array(
				'slug'         => 'quills-patch-hat-petrol-blue',
				'title'        => 'Quill\'s Patch Hat (Petrol Blue)',
				'price'        => '27.00',
				'description'  => 'Washed cotton twill cap in petrol blue with merrowed border woven Quills Coffee patch on front.',
				'image'        => 'merch/quills-patch-hat-petrol-blue.png',
				'rating'       => '0',
				'review_count' => 0,
				'menu_order'   => 12,
			),
		);

		foreach ( $merch_products as $item ) {
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
					update_post_meta( $product_id, '_visibility', 'visible' );
					update_post_meta( $product_id, '_wc_average_rating', $item['rating'] );
					update_post_meta( $product_id, '_wc_review_count', $item['review_count'] );
					update_post_meta( $product_id, '_merch_image', $item['image'] );

					if ( $term_id > 0 ) {
						wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
					}
					wp_set_object_terms( $product_id, 'simple', 'product_type', false );
				}
			} else {
				$pid = $existing->ID;
				update_post_meta( $pid, '_price', $item['price'] );
				update_post_meta( $pid, '_regular_price', $item['price'] );
				update_post_meta( $pid, '_wc_average_rating', $item['rating'] );
				update_post_meta( $pid, '_wc_review_count', $item['review_count'] );
				update_post_meta( $pid, '_merch_image', $item['image'] );
				if ( $term_id > 0 ) {
					wp_set_object_terms( $pid, array( $term_id ), self::TAXONOMY, true );
				}
			}
		}
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
