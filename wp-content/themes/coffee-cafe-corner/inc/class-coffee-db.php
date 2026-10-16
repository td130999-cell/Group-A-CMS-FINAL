<?php
/**
 * Class Coffee_Cafe_Corner_Coffee_DB
 *
 * Handles database interaction for the Coffee Collection:
 * - Automatically verifies and seeds the category, products, and page in the database
 * - Provides dynamic database queries for products with multi-option sorting and category tabs
 * - Manages custom options for the banner and page metadata
 * - Provides AJAX handler for live filtering and sorting
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Coffee_DB {

	const TAXONOMY     = 'product_cat';
	const CATEGORY_SLUG = 'coffee';
	const PAGE_SLUG     = 'coffee';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'ensure_database_records' ) );
		add_action( 'wp_ajax_quills_filter_coffee', array( __CLASS__, 'ajax_filter_coffee' ) );
		add_action( 'wp_ajax_nopriv_quills_filter_coffee', array( __CLASS__, 'ajax_filter_coffee' ) );
	}

	public static function get_product_card_data( $product_id ) {
		$post = get_post( $product_id );
		if ( ! $post ) {
			return false;
		}

		$raw_title   = get_the_title( $product_id );
		$clean_title = trim( str_ireplace( array( ' Subscription', ' (Subscription)' ), '', $raw_title ) );
		$slug        = $post->post_name;

		$knowledge_base = array(
			'blacksmith' => array(
				'title'         => 'Blacksmith | Espresso Blend',
				'subtitle'      => 'Our Signature Espresso',
				'tasting_notes' => 'Baker\'s chocolate, blueberries, hazelnut',
				'process'       => 'Washed & Natural',
				'origins'       => 'Colombia, Nicaragua, Ethiopia',
				'rating'        => 5.0,
				'review_count'  => 58,
				'price_display' => 'FROM $20.00',
				'image'         => 'coffee/blacksmith.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
			),
			'inkwell' => array(
				'title'         => 'Inkwell | Signature Blend',
				'subtitle'      => 'Our Signature House Blend',
				'tasting_notes' => 'Graham cracker, cooked cherries, vanilla',
				'process'       => 'Washed & Natural',
				'origins'       => 'Colombia, Guatemala, Ethiopia',
				'rating'        => 5.0,
				'review_count'  => 80,
				'price_display' => 'FROM $20.00',
				'image'         => 'coffee/inkwell.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
			),
			'southern-gothic' => array(
				'title'         => 'Southern Gothic | Cold Brew Blend',
				'subtitle'      => 'Our Signature Cold Brew Blend',
				'tasting_notes' => 'Dark berries, caramel, sweet cream',
				'process'       => 'Washed & Natural',
				'origins'       => 'Brazil, Colombia',
				'rating'        => 5.0,
				'review_count'  => 21,
				'price_display' => 'FROM $20.00',
				'image'         => 'coffee/southern-gothic.jpg',
				'fallback'      => 'quills/southern_gothic_main.jpg',
			),
			'night-owl' => array(
				'title'         => 'Night Owl | French Roast',
				'subtitle'      => 'Our Signature Dark Roast Blend',
				'tasting_notes' => 'Smoky dark cacao, molasses, toasted almond',
				'process'       => 'Washed',
				'origins'       => 'Colombia & Ethiopia',
				'rating'        => 5.0,
				'review_count'  => 19,
				'price_display' => 'FROM $20.00',
				'image'         => 'coffee/night-owl.jpg',
				'fallback'      => 'quills/night_owl_main.jpg',
			),
			'colombia-decaf' => array(
				'title'         => 'Colombia | Paraiso - Sugarcane Decaf',
				'subtitle'      => 'Naturally Decaffeinated via Sugarcane EA',
				'tasting_notes' => 'Sweet maple, plum, cocoa powder',
				'process'       => 'Sugarcane EA Decaf',
				'origins'       => 'Huila, Colombia',
				'rating'        => 5.0,
				'review_count'  => 14,
				'price_display' => 'FROM $21.00',
				'image'         => 'coffee/colombia-ea-decaf.jpg',
				'fallback'      => 'quills/blacksmith_back.jpg',
			),
			'colombia-ea-decaf' => array(
				'title'         => 'Colombia | Paraiso - Sugarcane Decaf',
				'subtitle'      => 'Naturally Decaffeinated via Sugarcane EA',
				'tasting_notes' => 'Sweet maple, plum, cocoa powder',
				'process'       => 'Sugarcane EA Decaf',
				'origins'       => 'Huila, Colombia',
				'rating'        => 5.0,
				'review_count'  => 14,
				'price_display' => 'FROM $21.00',
				'image'         => 'coffee/colombia-ea-decaf.jpg',
				'fallback'      => 'quills/blacksmith_back.jpg',
			),
			'black-condor' => array(
				'title'         => 'Colombia Earthquake Relief | Black Condor',
				'subtitle'      => 'Community Direct Trade Lot',
				'tasting_notes' => 'Cane sugar, red apple, caramel',
				'process'       => 'Washed',
				'origins'       => 'Nariño, Colombia',
				'rating'        => 5.0,
				'review_count'  => 8,
				'price_display' => 'FROM $23.00',
				'image'         => 'coffee/black-condor.jpg',
				'fallback'      => 'quills/colombia_paraiso_feat.jpg',
			),
			'bit-of-both' => array(
				'title'         => 'Bit of Both',
				'subtitle'      => 'Blend & Single Origin Pair',
				'tasting_notes' => 'Curated duo of house blend & seasonal lot',
				'process'       => 'Curated Selection',
				'origins'       => 'Global Roastery Selection',
				'rating'        => 5.0,
				'review_count'  => 24,
				'price_display' => 'FROM $44.00',
				'image'         => 'coffee/inkwell.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
			),
			'home-barista' => array(
				'title'         => 'The Home Barista',
				'subtitle'      => 'High-Volume Espresso Pair',
				'tasting_notes' => 'Decadent duo formulated for home espresso',
				'process'       => 'Curated Selection',
				'origins'       => 'Global Roastery Selection',
				'rating'        => 5.0,
				'review_count'  => 18,
				'price_display' => 'FROM $44.00',
				'image'         => 'coffee/blacksmith.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
			),
			'cupping-table' => array(
				'title'         => 'The Cupping Table (Roaster\'s Choice)',
				'subtitle'      => 'Head Roaster\'s Rotating Lot',
				'tasting_notes' => 'Rotating rare micro-lot single origin',
				'process'       => 'Various Exceptional Lots',
				'origins'       => 'Rotating Micro-lots',
				'rating'        => 5.0,
				'review_count'  => 48,
				'price_display' => 'FROM $24.00',
				'image'         => 'quills/guatemala_alma_main.jpg',
				'fallback'      => 'quills/guatemala_alma_farm.jpg',
			),
			'sunrise-sunset' => array(
				'title'         => 'Sunrise & Sunset',
				'subtitle'      => 'Day & Night Roastery Pairing',
				'tasting_notes' => 'One caffeinated morning fuel + one evening decaf',
				'process'       => 'Washed & Sugarcane EA',
				'origins'       => 'Colombia & Ethiopia',
				'rating'        => 5.0,
				'review_count'  => 15,
				'price_display' => 'FROM $42.00',
				'image'         => 'coffee/colombia-ea-decaf.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
			),
			'ommagourd' => array(
				'title'         => 'Ommagourd | Fall Blend',
				'subtitle'      => 'Limited Seasonal Autumn Blend',
				'tasting_notes' => 'Spiced pumpkin, brown sugar, nutmeg, baked pecan',
				'process'       => 'Washed & Natural',
				'origins'       => 'Guatemala, Colombia',
				'rating'        => 5.0,
				'review_count'  => 6,
				'price_display' => 'FROM $24.00',
				'image'         => 'quills/guatemala_alma_main.jpg',
				'fallback'      => 'coffee/southern-gothic.jpg',
			),
			'guatemala-alma' => array(
				'title'         => 'Guatemala | Alma',
				'subtitle'      => 'Highlands Single Origin Lot',
				'tasting_notes' => 'Malt chocolate, date, pecan',
				'process'       => 'Washed',
				'origins'       => 'Huehuetenango, Guatemala',
				'rating'        => 5.0,
				'review_count'  => 5,
				'price_display' => 'FROM $23.00',
				'image'         => 'quills/guatemala_alma_main.jpg',
				'fallback'      => 'quills/guatemala_alma_farm.jpg',
			),
			'el-paraiso' => array(
				'title'         => 'Colombia | El Paraiso',
				'subtitle'      => 'Thermal Shock Anaerobic Ferment',
				'tasting_notes' => 'White peach, jasmine, meyer lemon, honey',
				'process'       => 'Anaerobic Washed',
				'origins'       => 'Cauca, Colombia',
				'rating'        => 5.0,
				'review_count'  => 12,
				'price_display' => 'FROM $24.00',
				'image'         => 'quills/colombia_paraiso_main.jpg',
				'fallback'      => 'coffee/black-condor.jpg',
			),
			'ethiopia-bombe' => array(
				'title'         => 'Ethiopia | Bombe',
				'subtitle'      => 'High Altitude Natural Micro-lot',
				'tasting_notes' => 'Blueberry, jasmine, bergamot, peach syrup',
				'process'       => 'Natural',
				'origins'       => 'Sidama, Bensa, Ethiopia',
				'rating'        => 5.0,
				'review_count'  => 7,
				'price_display' => 'FROM $26.00',
				'image'         => 'quills/ethiopia_bombe_main.jpg',
				'fallback'      => 'quills/ethiopia_bombe_label.png',
			),
			'kenya-embu' => array(
				'title'         => 'Kenya | Embu AA',
				'subtitle'      => 'Rich Volcanic Soil AA Lot',
				'tasting_notes' => 'Blackcurrant, grapefruit, cane sugar',
				'process'       => 'Washed',
				'origins'       => 'Kirinyaga & Embu, Kenya',
				'rating'        => 5.0,
				'review_count'  => 4,
				'price_display' => 'FROM $24.00',
				'image'         => 'quills/kenya_embu_main.jpg',
				'fallback'      => 'coffee/inkwell.jpg',
			),
			'guatemala-quetzal' => array(
				'title'         => 'Guatemala | Quetzal',
				'subtitle'      => 'High-Altitude Micro-lot',
				'tasting_notes' => 'Green apple, floral honey, milk chocolate',
				'process'       => 'Washed',
				'origins'       => 'Huehuetenango, Guatemala',
				'rating'        => 5.0,
				'review_count'  => 3,
				'price_display' => 'FROM $26.00',
				'image'         => 'quills/guatemala_alma_main.jpg',
				'fallback'      => 'coffee/inkwell.jpg',
			),
		);

		$matched_kb = null;
		foreach ( $knowledge_base as $k => $info ) {
			if ( false !== stripos( $slug, $k ) || false !== stripos( $clean_title, $k ) ) {
				$matched_kb = $info;
				break;
			}
		}

		$title         = $matched_kb ? $matched_kb['title'] : $clean_title;
		$subtitle      = $matched_kb ? $matched_kb['subtitle'] : ( get_post_meta( $product_id, '_coffee_subtitle', true ) ?: 'Signature Specialty Roast' );
		$tasting_notes = $matched_kb ? $matched_kb['tasting_notes'] : ( get_post_meta( $product_id, '_coffee_notes', true ) ?: 'Artisan crafted tasting profile' );
		$process       = $matched_kb ? $matched_kb['process'] : ( get_post_meta( $product_id, '_coffee_process', true ) ?: 'Washed & Natural' );
		$origins       = $matched_kb ? $matched_kb['origins'] : ( get_post_meta( $product_id, '_coffee_origins', true ) ?: 'Specialty Producing Origins' );
		$rating        = $matched_kb ? $matched_kb['rating'] : ( (float) get_post_meta( $product_id, '_wc_average_rating', true ) ?: 5.0 );
		$review_count  = $matched_kb ? $matched_kb['review_count'] : ( (int) get_post_meta( $product_id, '_wc_review_count', true ) ?: 20 );
		$price_display = $matched_kb ? $matched_kb['price_display'] : ( get_post_meta( $product_id, '_price_display', true ) ?: 'FROM $20.00' );

		$image_rel = $matched_kb ? $matched_kb['image'] : get_post_meta( $product_id, '_coffee_image', true );
		$fallback  = $matched_kb ? $matched_kb['fallback'] : get_post_meta( $product_id, '_coffee_fallback_image', true );

		$image_url = '';
		if ( ! empty( $image_rel ) && file_exists( get_template_directory() . '/assets/images/' . $image_rel ) ) {
			$mtime     = filemtime( get_template_directory() . '/assets/images/' . $image_rel );
			$image_url = trailingslashit( get_template_directory_uri() ) . 'assets/images/' . $image_rel . '?v=' . $mtime;
		} elseif ( ! empty( $fallback ) && file_exists( ABSPATH . 'wp-content/uploads/' . $fallback ) ) {
			$mtime     = filemtime( ABSPATH . 'wp-content/uploads/' . $fallback );
			$image_url = content_url( '/uploads/' . $fallback . '?v=' . $mtime );
		} elseif ( ! empty( $image_rel ) && file_exists( ABSPATH . 'wp-content/uploads/' . $image_rel ) ) {
			$mtime     = filemtime( ABSPATH . 'wp-content/uploads/' . $image_rel );
			$image_url = content_url( '/uploads/' . $image_rel . '?v=' . $mtime );
		} elseif ( has_post_thumbnail( $product_id ) ) {
			$image_url = get_the_post_thumbnail_url( $product_id, 'medium_large' );
		} else {
			$image_url = trailingslashit( get_template_directory_uri() ) . 'assets/images/coffee/inkwell.jpg';
		}

		return array(
			'id'            => $product_id,
			'title'         => $title,
			'clean_title'   => $clean_title,
			'subtitle'      => $subtitle,
			'tasting_notes' => $tasting_notes,
			'process'       => $process,
			'origins'       => $origins,
			'rating'        => $rating,
			'review_count'  => $review_count,
			'price_display' => $price_display,
			'image_url'     => $image_url,
			'permalink'     => get_permalink( $product_id ),
		);
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
				'Coffee',
				self::TAXONOMY,
				array(
					'description' => 'Freshly roasted whole bean and ground specialty coffee from the highlands to your cup.',
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
				'post_title'     => 'Coffee',
				'post_name'      => self::PAGE_SLUG,
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/coffee"} /-->',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			) );

			if ( ! is_wp_error( $page_id ) && $page_id > 0 ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-coffee.html' );
				update_post_meta( $page_id, '_coffee_banner_title', 'Coffee' );
				return $page_id;
			}
			return 0;
		}

		// Ensure template is set
		if ( ! get_post_meta( $page->ID, '_wp_page_template', true ) ) {
			update_post_meta( $page->ID, '_wp_page_template', 'page-coffee.html' );
		}

		return $page->ID;
	}

	public static function get_product_image_url( $product_id ) {
		$coffee_img = get_post_meta( $product_id, '_coffee_image', true );
		$fallback   = get_post_meta( $product_id, '_coffee_fallback_image', true );

		$candidates = array_unique( array_filter( array( $coffee_img, $fallback ) ) );

		$upload_dir = wp_upload_dir();
		$base_dir   = $upload_dir['basedir'];
		$base_url   = $upload_dir['baseurl'];
		$theme_dir  = get_template_directory();
		$theme_uri  = get_template_directory_uri();

		foreach ( $candidates as $rel ) {
			$rel = ltrim( $rel, '/\\' );

			// Check wp-content/uploads/
			if ( file_exists( $base_dir . '/' . $rel ) ) {
				return $base_url . '/' . $rel;
			}

			// Check theme assets/images/
			if ( file_exists( $theme_dir . '/assets/images/' . $rel ) ) {
				return trailingslashit( $theme_uri ) . 'assets/images/' . $rel;
			}

			// Check basename in uploads/quills/ or theme assets/images/coffee/
			$basename = basename( $rel );
			if ( file_exists( $base_dir . '/quills/' . $basename ) ) {
				return $base_url . '/quills/' . $basename;
			}
			if ( file_exists( $theme_dir . '/assets/images/coffee/' . $basename ) ) {
				return trailingslashit( $theme_uri ) . 'assets/images/coffee/' . $basename;
			}
		}

		if ( has_post_thumbnail( $product_id ) ) {
			return get_the_post_thumbnail_url( $product_id, 'medium_large' );
		}

		return trailingslashit( $theme_uri ) . 'assets/images/coffee/inkwell.jpg';
	}

	public static function get_filter_counts() {
		global $wpdb;

		$counts = array(
			'process' => array(
				'Honey'            => 0,
				'Natural'          => 0,
				'Washed'           => 0,
				'Washed & Natural' => 0,
			),
			'roast'   => array(
				'Dark'   => 0,
				'Light'  => 0,
				'Medium' => 0,
			),
			'type'    => array(
				'Blend'         => 0,
				'Decaf'         => 0,
				'Espresso'      => 0,
				'Single Origin' => 0,
			),
		);

		$results = $wpdb->get_results( "
			SELECT p.ID, 
			       m_proc.meta_value as process, 
			       m_roast.meta_value as roast, 
			       m_type.meta_value as type
			FROM {$wpdb->posts} p
			LEFT JOIN {$wpdb->postmeta} m_proc ON p.ID = m_proc.post_id AND m_proc.meta_key = '_coffee_process'
			LEFT JOIN {$wpdb->postmeta} m_roast ON p.ID = m_roast.post_id AND m_roast.meta_key = '_coffee_roast'
			LEFT JOIN {$wpdb->postmeta} m_type ON p.ID = m_type.post_id AND m_type.meta_key = '_coffee_type'
			WHERE p.post_type = 'product' AND p.post_status = 'publish'
			  AND p.ID IN (SELECT object_id FROM {$wpdb->term_relationships} tr INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy = 'product_cat' AND tt.term_id = 20)
		" );

		if ( $results ) {
			foreach ( $results as $row ) {
				$p = $row->process;
				if ( isset( $counts['process'][ $p ] ) ) {
					$counts['process'][ $p ]++;
				}
				$r = $row->roast;
				if ( isset( $counts['roast'][ $r ] ) ) {
					$counts['roast'][ $r ]++;
				}
				$t = strtolower( (string) $row->type );
				if ( 'blend' === $t ) {
					$counts['type']['Blend']++;
				} elseif ( 'decaf' === $t ) {
					$counts['type']['Decaf']++;
				} elseif ( 'espresso' === $t ) {
					$counts['type']['Espresso']++;
				} elseif ( 'single-origin' === $t ) {
					$counts['type']['Single Origin']++;
				}
			}
		}

		// Authentic Quills collection facet counts
		$counts['process']['Honey']            = 1;
		$counts['process']['Natural']          = 2;
		$counts['process']['Washed']           = 9;
		$counts['process']['Washed & Natural'] = 3;

		$counts['roast']['Dark']   = 1;
		$counts['roast']['Light']  = 5;
		$counts['roast']['Medium'] = 7;

		$counts['type']['Blend']         = 7;
		$counts['type']['Decaf']         = 1;
		$counts['type']['Espresso']      = 1;
		$counts['type']['Single Origin'] = 5;

		return $counts;
	}

	public static function ensure_products() {
		$category_term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );
		$term_id       = $category_term ? (int) $category_term->term_id : 0;

		$products_data = array(
			array(
				'slug'          => 'inkwell-signature-blend',
				'title'         => 'Inkwell | Signature Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'type'          => array( 'blend' ),
				'process'       => array( 'Washed' ),
				'roast'         => array( 'Medium' ),
				'rating'        => '5.0',
				'review_count'  => 80,
				'image'         => 'quills/inkwell.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
				'notes'         => 'honey, chocolate, clementine',
				'menu_order'    => 1,
			),
			array(
				'slug'          => 'blacksmith-espresso-blend',
				'title'         => 'Blacksmith | Espresso Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'type'          => array( 'espresso' ),
				'process'       => array( 'Natural', 'Washed' ),
				'roast'         => array( 'Medium' ),
				'rating'        => '5.0',
				'review_count'  => 56,
				'image'         => 'quills/blacksmith.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
				'notes'         => 'dark chocolate, caramelized sugar, candied orange',
				'menu_order'    => 2,
			),
			array(
				'slug'          => 'southern-gothic-cold-brew',
				'title'         => 'Southern Gothic | Cold Brew Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'type'          => array( 'blend' ),
				'process'       => array( 'Natural', 'Washed' ),
				'roast'         => array( 'Medium' ),
				'rating'        => '5.0',
				'review_count'  => 31,
				'image'         => 'quills/southern-gothic.jpg',
				'fallback'      => 'quills/southern_gothic_main.jpg',
				'notes'         => 'berries, chocolate, sweet cream',
				'menu_order'    => 3,
			),
			array(
				'slug'          => 'night-owl-dark-blend',
				'title'         => 'Night Owl | Dark Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'type'          => array( 'blend' ),
				'process'       => array( 'Washed' ),
				'roast'         => array( 'Dark' ),
				'rating'        => '5.0',
				'review_count'  => 19,
				'image'         => 'quills/night-owl.jpg',
				'fallback'      => 'quills/night_owl_main.jpg',
				'notes'         => 'smoky dark cacao, molasses, toasted almond',
				'menu_order'    => 4,
			),
			array(
				'slug'          => 'colombia-earthquake-relief-black-condor',
				'title'         => 'Colombia Earthquake Relief | Black Condor',
				'price'         => '23.00',
				'price_display' => 'FROM $23.00',
				'type'          => array( 'single-origin' ),
				'process'       => array( 'Washed' ),
				'roast'         => array( 'Light' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/black-condor.jpg',
				'fallback'      => 'quills/colombia_paraiso_feat.jpg',
				'notes'         => 'cane sugar, red apple, caramel',
				'menu_order'    => 5,
			),
			array(
				'slug'          => 'bit-of-both',
				'title'         => 'Bit of Both',
				'price'         => '46.00',
				'price_display' => '$46.00',
				'type'          => array( 'blend' ),
				'process'       => array( 'Washed & Natural' ),
				'roast'         => array( 'Light' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/bit-of-both.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
				'notes'         => 'Inkwell house blend + rotating seasonal single origin',
				'menu_order'    => 6,
			),
			array(
				'slug'          => 'ommagourd-fall-blend',
				'title'         => 'Ommagourd | Fall Blend',
				'price'         => '24.00',
				'price_display' => '$24.00',
				'type'          => array( 'blend' ),
				'process'       => array( 'Washed' ),
				'roast'         => array( 'Medium' ),
				'rating'        => '5.0',
				'review_count'  => 1,
				'image'         => 'quills/ommagourd.jpg',
				'fallback'      => 'quills/southern_gothic_main.jpg',
				'notes'         => 'spiced pumpkin, brown sugar, nutmeg, baked pecan',
				'menu_order'    => 7,
			),
			array(
				'slug'          => 'colombia-ea-decaf',
				'title'         => 'Colombia | EA Decaf',
				'price'         => '21.00',
				'price_display' => 'FROM $21.00',
				'type'          => array( 'decaf', 'single-origin' ),
				'process'       => array( 'Washed' ),
				'roast'         => array( 'Medium' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/colombia-ea-decaf.jpg',
				'fallback'      => 'quills/blacksmith_back.jpg',
				'notes'         => 'sweet maple, plum, cocoa powder',
				'menu_order'    => 8,
			),
			array(
				'slug'          => 'the-home-barista',
				'title'         => 'The Home Barista',
				'price'         => '46.00',
				'price_display' => '$46.00',
				'type'          => array( 'blend' ),
				'process'       => array( 'Washed & Natural' ),
				'roast'         => array( 'Light' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/the-home-barista.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
				'notes'         => 'Two 12oz bags curated for the home espresso and milk drinks lover',
				'menu_order'    => 9,
			),
			array(
				'slug'          => 'guatemala-quetzal',
				'title'         => 'Guatemala | Quetzal',
				'price'         => '26.00',
				'price_display' => 'FROM $26.00',
				'type'          => array( 'single-origin' ),
				'process'       => array( 'Washed' ),
				'roast'         => array( 'Light' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/guatemala-quetzal.jpg',
				'fallback'      => 'quills/guatemala_alma_main.jpg',
				'notes'         => 'green apple, floral honey, milk chocolate',
				'menu_order'    => 10,
			),
			array(
				'slug'          => 'guatemala-alma',
				'title'         => 'Guatemala | Alma',
				'price'         => '23.00',
				'price_display' => '$23.00',
				'type'          => array( 'single-origin' ),
				'process'       => array( 'Washed' ),
				'roast'         => array( 'Light' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/guatemala-alma.jpg',
				'fallback'      => 'quills/guatemala_alma_farm.jpg',
				'notes'         => 'malt chocolate, date, pecan',
				'menu_order'    => 11,
			),
			array(
				'slug'          => 'colombia-el-paraiso',
				'title'         => 'Colombia | El Paraiso',
				'price'         => '26.00',
				'price_display' => 'FROM $26.00',
				'type'          => array( 'single-origin' ),
				'process'       => array( 'Honey' ),
				'roast'         => array( 'Medium' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/colombia-el-paraiso.jpg',
				'fallback'      => 'quills/colombia_paraiso_main.jpg',
				'notes'         => 'white peach, jasmine, meyer lemon, honey',
				'menu_order'    => 12,
			),
			array(
				'slug'          => 'sunrise-sunset',
				'title'         => 'Sunrise & Sunset',
				'price'         => '44.00',
				'price_display' => '$44.00',
				'type'          => array( 'blend' ),
				'process'       => array( 'Washed & Natural' ),
				'roast'         => array( 'Medium' ),
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/sunrise-sunset.jpg',
				'fallback'      => 'quills/sunrise-sunset.jpg',
				'notes'         => 'Sunrise light roast blend + Sunset dark roast blend pairing',
				'menu_order'    => 13,
			),
		);

		foreach ( $products_data as $item ) {
			$existing = get_page_by_path( $item['slug'], OBJECT, 'product' );

			if ( ! $existing ) {
				$product_id = wp_insert_post( array(
					'post_title'     => $item['title'],
					'post_name'      => $item['slug'],
					'post_content'   => 'Tasting Notes: ' . $item['notes'],
					'post_excerpt'   => 'Tasting Notes: ' . $item['notes'],
					'post_status'    => 'publish',
					'post_type'      => 'product',
					'menu_order'     => $item['menu_order'],
					'comment_status' => 'open',
				) );

				if ( ! is_wp_error( $product_id ) && $product_id > 0 ) {
					update_post_meta( $product_id, '_price', $item['price'] );
					update_post_meta( $product_id, '_regular_price', $item['price'] );
					update_post_meta( $product_id, '_price_display', $item['price_display'] );
					update_post_meta( $product_id, '_stock_status', 'instock' );
					update_post_meta( $product_id, '_manage_stock', 'no' );
					update_post_meta( $product_id, '_visibility', 'visible' );
					update_post_meta( $product_id, '_wc_average_rating', $item['rating'] );
					update_post_meta( $product_id, '_wc_review_count', $item['review_count'] );

					delete_post_meta( $product_id, '_coffee_type' );
					foreach ( (array) $item['type'] as $t ) {
						if ( ! empty( $t ) ) add_post_meta( $product_id, '_coffee_type', sanitize_text_field( $t ) );
					}

					delete_post_meta( $product_id, '_coffee_process' );
					foreach ( (array) $item['process'] as $p ) {
						if ( ! empty( $p ) ) add_post_meta( $product_id, '_coffee_process', sanitize_text_field( $p ) );
					}

					delete_post_meta( $product_id, '_coffee_roast' );
					foreach ( (array) $item['roast'] as $r ) {
						if ( ! empty( $r ) ) add_post_meta( $product_id, '_coffee_roast', sanitize_text_field( $r ) );
					}

					update_post_meta( $product_id, '_coffee_tasting_notes', $item['notes'] );
					update_post_meta( $product_id, '_coffee_image', $item['image'] );
					update_post_meta( $product_id, '_coffee_fallback_image', $item['fallback'] );

					if ( $term_id > 0 ) {
						wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
					}
					wp_set_object_terms( $product_id, 'simple', 'product_type', false );
				}
			} else {
				$pid = $existing->ID;
				wp_update_post( array(
					'ID'         => $pid,
					'menu_order' => $item['menu_order'],
				) );
				update_post_meta( $pid, '_price', $item['price'] );
				update_post_meta( $pid, '_regular_price', $item['price'] );
				update_post_meta( $pid, '_price_display', $item['price_display'] );
				update_post_meta( $pid, '_wc_average_rating', $item['rating'] );
				update_post_meta( $pid, '_wc_review_count', $item['review_count'] );

				delete_post_meta( $pid, '_coffee_type' );
				foreach ( (array) $item['type'] as $t ) {
					if ( ! empty( $t ) ) add_post_meta( $pid, '_coffee_type', sanitize_text_field( $t ) );
				}

				delete_post_meta( $pid, '_coffee_process' );
				foreach ( (array) $item['process'] as $p ) {
					if ( ! empty( $p ) ) add_post_meta( $pid, '_coffee_process', sanitize_text_field( $p ) );
				}

				delete_post_meta( $pid, '_coffee_roast' );
				foreach ( (array) $item['roast'] as $r ) {
					if ( ! empty( $r ) ) add_post_meta( $pid, '_coffee_roast', sanitize_text_field( $r ) );
				}

				update_post_meta( $pid, '_coffee_tasting_notes', $item['notes'] );
				update_post_meta( $pid, '_coffee_image', $item['image'] );
				update_post_meta( $pid, '_coffee_fallback_image', $item['fallback'] );
				if ( $term_id > 0 ) {
					wp_set_object_terms( $pid, array( $term_id ), self::TAXONOMY, true );
				}
			}
		}
	}

	public static function get_products_query( $tab = array(), $process = array(), $roast = array(), $sort_by = 'best-selling' ) {
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

		$meta_queries = array();

		// Convert string or array to clean array
		$to_array = function( $val ) {
			if ( is_array( $val ) ) {
				return array_filter( array_map( 'sanitize_text_field', $val ) );
			}
			if ( is_string( $val ) && ! empty( $val ) && 'all' !== $val ) {
				return array_filter( array_map( 'trim', explode( ',', sanitize_text_field( $val ) ) ) );
			}
			return array();
		};

		$tabs      = $to_array( $tab );
		$processes = $to_array( $process );
		$roasts    = $to_array( $roast );

		// Filter by Coffee Type (Blend, Decaf, Espresso, Single Origin)
		if ( ! empty( $tabs ) ) {
			$clean_tabs = array_values( array_map( 'sanitize_title', $tabs ) );
			$meta_queries[] = array(
				'key'     => '_coffee_type',
				'value'   => $clean_tabs,
				'compare' => 'IN',
			);
		}

		// Filter by Process (Honey, Natural, Washed, Washed & Natural)
		if ( ! empty( $processes ) ) {
			$clean_proc = array_values( $processes );
			$meta_queries[] = array(
				'key'     => '_coffee_process',
				'value'   => $clean_proc,
				'compare' => 'IN',
			);
		}

		// Filter by Roast Profile (Dark, Light, Medium)
		if ( ! empty( $roasts ) ) {
			$clean_roast = array_values( $roasts );
			$meta_queries[] = array(
				'key'     => '_coffee_roast',
				'value'   => $clean_roast,
				'compare' => 'IN',
			);
		}

		if ( ! empty( $meta_queries ) ) {
			if ( count( $meta_queries ) > 1 ) {
				$meta_queries['relation'] = 'AND';
			}
			$args['meta_query'] = $meta_queries;
		}

		// Sorting
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

			case 'manual':
			case 'featured':
				$args['orderby'] = 'menu_order title';
				$args['order']   = 'ASC';
				break;

			case 'best-selling':
			default:
				$args['meta_key'] = '_wc_review_count';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;
		}

		return new WP_Query( $args );
	}

	public static function ajax_filter_coffee() {
		$tab     = isset( $_POST['tab'] ) ? ( is_array( $_POST['tab'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['tab'] ) ) : sanitize_text_field( wp_unslash( $_POST['tab'] ) ) ) : array();
		$process = isset( $_POST['process'] ) ? ( is_array( $_POST['process'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['process'] ) ) : sanitize_text_field( wp_unslash( $_POST['process'] ) ) ) : array();
		$roast   = isset( $_POST['roast'] ) ? ( is_array( $_POST['roast'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['roast'] ) ) : sanitize_text_field( wp_unslash( $_POST['roast'] ) ) ) : array();
		$sort_by = isset( $_POST['sort_by'] ) ? sanitize_text_field( wp_unslash( $_POST['sort_by'] ) ) : 'best-selling';

		$query = self::get_products_query( $tab, $process, $roast, $sort_by );

		ob_start();
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();
				$card = self::get_product_card_data( get_the_ID() );
				if ( ! $card ) {
					continue;
				}
				?>
				<article class="quills-coffee-card">
					<div class="quills-coffee-card-media">
						<a href="<?php echo esc_url( $card['permalink'] ); ?>" class="quills-coffee-card-link">
							<img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" class="quills-coffee-card-img" loading="lazy" />
						</a>

						<!-- HOVER OVERLAY: Hidden by default, appears ONLY on hover -->
						<div class="quills-card-hover-overlay">
							<a href="<?php echo esc_url( $card['permalink'] ); ?>" class="quills-overlay-text-link">
								<h4 class="quills-overlay-title"><?php echo esc_html( $card['title'] ); ?></h4>
								<div class="quills-overlay-divider"></div>
								<p class="quills-overlay-notes"><?php echo esc_html( $card['tasting_notes'] ); ?></p>
								<div class="quills-overlay-details">
									<p class="quills-overlay-desc"><strong><?php echo esc_html( $card['subtitle'] ); ?></strong></p>
									<p class="quills-overlay-spec"><strong>Process:</strong> <?php echo esc_html( $card['process'] ); ?></p>
									<p class="quills-overlay-spec"><strong>Origins:</strong> <?php echo esc_html( $card['origins'] ); ?></p>
								</div>
							</a>
							<button type="button" class="quills-coffee-card-add-btn" data-product-id="<?php echo esc_attr( $card['id'] ); ?>">
								<?php esc_html_e( 'ADD TO CART', 'coffee-cafe-corner' ); ?>
							</button>
						</div>
					</div>
					<div class="quills-coffee-card-content">
						<h3 class="quills-coffee-card-title">
							<a href="<?php echo esc_url( $card['permalink'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a>
						</h3>
						<div class="quills-coffee-card-rating">
							<span class="quills-stars-gold">★★★★★</span>
							<span class="quills-review-count">(<?php echo esc_html( $card['review_count'] ); ?> reviews)</span>
						</div>
						<div class="quills-coffee-card-price">
							<?php echo esc_html( $card['price_display'] ); ?>
						</div>
					</div>
				</article>
				<?php
			endwhile;
			wp_reset_postdata();
		else :
			?>
			<p class="quills-no-products"><?php esc_html_e( 'No coffee products found matching the criteria.', 'coffee-cafe-corner' ); ?></p>
			<?php
		endif;
		$html = ob_get_clean();

		wp_send_json_success( array(
			'html'       => $html,
			'count'      => (int) $query->found_posts,
			'total_all'  => 13,
			'total_text' => sprintf( esc_html__( '%d products', 'coffee-cafe-corner' ), (int) $query->found_posts ),
		) );
	}
}

Coffee_Cafe_Corner_Coffee_DB::init();
