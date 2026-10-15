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

	public static function ensure_products() {
		$category_term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );
		$term_id       = $category_term ? (int) $category_term->term_id : 0;

		$products_data = array(
			array(
				'slug'          => 'inkwell-signature-blend',
				'title'         => 'Inkwell | Signature Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'type'          => 'blend',
				'process'       => 'Washed & Natural',
				'roast'         => 'Medium',
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
				'type'          => 'espresso blend',
				'process'       => 'Washed & Natural',
				'roast'         => 'Medium',
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
				'type'          => 'blend',
				'process'       => 'Washed & Natural',
				'roast'         => 'Medium-Light',
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
				'type'          => 'blend',
				'process'       => 'Washed',
				'roast'         => 'Dark',
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
				'type'          => 'single-origin',
				'process'       => 'Washed',
				'roast'         => 'Medium-Light',
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
				'type'          => 'blend',
				'process'       => 'Curated Selection',
				'roast'         => 'Mixed',
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
				'type'          => 'blend',
				'process'       => 'Washed & Natural',
				'roast'         => 'Medium',
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
				'type'          => 'decaf single-origin',
				'process'       => 'Sugarcane EA Decaf',
				'roast'         => 'Medium',
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
				'type'          => 'espresso blend',
				'process'       => 'Curated Selection',
				'roast'         => 'Medium',
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
				'type'          => 'single-origin',
				'process'       => 'Washed',
				'roast'         => 'Light',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/guatemala-quetzal.jpg',
				'fallback'      => 'quills/guatemala_alma_main.jpg',
				'notes'         => 'green apple, floral honey, milk chocolate',
				'menu_order'    => 10,
			),
			array(
				'slug'          => 'ethiopia-bombe',
				'title'         => 'Ethiopia | Bombe',
				'price'         => '26.00',
				'price_display' => '$26.00',
				'type'          => 'single-origin',
				'process'       => 'Natural',
				'roast'         => 'Light',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/ethiopia_bombe_main.jpg',
				'fallback'      => 'quills/ethiopia_bombe_label.png',
				'notes'         => 'blueberry, jasmine, bergamot, peach syrup',
				'menu_order'    => 11,
			),
			array(
				'slug'          => 'guatemala-alma',
				'title'         => 'Guatemala | Alma',
				'price'         => '23.00',
				'price_display' => '$23.00',
				'type'          => 'single-origin',
				'process'       => 'Washed',
				'roast'         => 'Light',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/guatemala-alma.jpg',
				'fallback'      => 'quills/guatemala_alma_farm.jpg',
				'notes'         => 'malt chocolate, date, pecan',
				'menu_order'    => 12,
			),
			array(
				'slug'          => 'colombia-el-paraiso',
				'title'         => 'Colombia | El Paraiso',
				'price'         => '26.00',
				'price_display' => 'FROM $26.00',
				'type'          => 'single-origin',
				'process'       => 'Anaerobic Washed',
				'roast'         => 'Light',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/colombia-el-paraiso.jpg',
				'fallback'      => 'quills/colombia_paraiso_main.jpg',
				'notes'         => 'white peach, jasmine, meyer lemon, honey',
				'menu_order'    => 13,
			),
			array(
				'slug'          => 'sunrise-sunset',
				'title'         => 'Sunrise & Sunset',
				'price'         => '44.00',
				'price_display' => '$44.00',
				'type'          => 'blend',
				'process'       => 'Curated Selection',
				'roast'         => 'Medium',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/sunrise-sunset.jpg',
				'fallback'      => 'quills/sunrise-sunset.jpg',
				'notes'         => 'Sunrise light roast blend + Sunset dark roast blend pairing',
				'menu_order'    => 14,
			),
			array(
				'slug'          => 'the-cupping-table',
				'title'         => 'The Cupping Table',
				'price'         => '25.00',
				'price_display' => 'FROM $25.00',
				'type'          => 'single-origin',
				'process'       => 'Roaster\'s Rotation',
				'roast'         => 'Light',
				'rating'        => '5.0',
				'review_count'  => 15,
				'image'         => 'quills/guatemala_alma_farm.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
				'notes'         => 'Bi-weekly rotating rare micro-lot single origin',
				'menu_order'    => 15,
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
					update_post_meta( $product_id, '_coffee_type', $item['type'] );
					update_post_meta( $product_id, '_coffee_process', $item['process'] );
					update_post_meta( $product_id, '_coffee_roast', $item['roast'] );
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
				update_post_meta( $pid, '_price', $item['price'] );
				update_post_meta( $pid, '_regular_price', $item['price'] );
				update_post_meta( $pid, '_price_display', $item['price_display'] );
				update_post_meta( $pid, '_wc_average_rating', $item['rating'] );
				update_post_meta( $pid, '_wc_review_count', $item['review_count'] );
				update_post_meta( $pid, '_coffee_type', $item['type'] );
				update_post_meta( $pid, '_coffee_process', $item['process'] );
				update_post_meta( $pid, '_coffee_roast', $item['roast'] );
				update_post_meta( $pid, '_coffee_tasting_notes', $item['notes'] );
				update_post_meta( $pid, '_coffee_image', $item['image'] );
				update_post_meta( $pid, '_coffee_fallback_image', $item['fallback'] );
				if ( $term_id > 0 ) {
					wp_set_object_terms( $pid, array( $term_id ), self::TAXONOMY, true );
				}
			}
		}
	}

	public static function get_products_query( $tab = 'all', $process = '', $roast = '', $sort_by = 'best-selling' ) {
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

		// Filter by Tab: 'blend', 'single-origin', 'espresso', 'decaf'
		if ( ! empty( $tab ) && 'all' !== $tab ) {
			$meta_queries[] = array(
				'key'     => '_coffee_type',
				'value'   => $tab,
				'compare' => 'LIKE',
			);
		}

		// Filter by Process: Washed, Natural, EA Decaf, etc.
		if ( ! empty( $process ) && 'all' !== $process ) {
			$meta_queries[] = array(
				'key'     => '_coffee_process',
				'value'   => $process,
				'compare' => 'LIKE',
			);
		}

		// Filter by Roast Profile: Light, Medium, Dark
		if ( ! empty( $roast ) && 'all' !== $roast ) {
			$meta_queries[] = array(
				'key'     => '_coffee_roast',
				'value'   => $roast,
				'compare' => 'LIKE',
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

		$query = new WP_Query( $args );

		// Fallback query if no category match is found
		if ( ! $query->have_posts() ) {
			unset( $args['tax_query'] );
			$query = new WP_Query( $args );
		}

		return $query;
	}

	public static function ajax_filter_coffee() {
		$tab     = isset( $_POST['tab'] ) ? sanitize_text_field( wp_unslash( $_POST['tab'] ) ) : 'all';
		$process = isset( $_POST['process'] ) ? sanitize_text_field( wp_unslash( $_POST['process'] ) ) : '';
		$roast   = isset( $_POST['roast'] ) ? sanitize_text_field( wp_unslash( $_POST['roast'] ) ) : '';
		$sort_by = isset( $_POST['sort_by'] ) ? sanitize_text_field( wp_unslash( $_POST['sort_by'] ) ) : 'best-selling';

		$query = self::get_products_query( $tab, $process, $roast, $sort_by );

		ob_start();
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();
				$product_id    = get_the_ID();
				$title         = get_the_title();
				$price_display = get_post_meta( $product_id, '_price_display', true );
				if ( empty( $price_display ) ) {
					$price         = get_post_meta( $product_id, '_price', true );
					$price_display = $price ? '$' . number_format( (float) $price, 2 ) : 'FROM $20.00';
				}
				$rating        = (float) get_post_meta( $product_id, '_wc_average_rating', true );
				$review_count  = (int) get_post_meta( $product_id, '_wc_review_count', true );
				$image_url     = self::get_product_image_url( $product_id );
				?>
				<article class="quills-coffee-card">
					<div class="quills-coffee-card-media">
						<a href="<?php the_permalink(); ?>" class="quills-coffee-card-link">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="quills-coffee-card-img" loading="lazy" />
						</a>
					</div>
					<div class="quills-coffee-card-content">
						<h3 class="quills-coffee-card-title">
							<a href="<?php the_permalink(); ?>"><?php echo esc_html( $title ); ?></a>
						</h3>
						<div class="quills-coffee-card-rating">
							<span class="quills-stars">
								<?php
								$rounded = round( $rating );
								for ( $i = 1; $i <= 5; $i++ ) {
									if ( $i <= $rounded && $rating > 0 ) {
										echo '<span class="quills-star quills-star--filled">★</span>';
									} else {
										echo '<span class="quills-star quills-star--empty">☆</span>';
									}
								}
								?>
							</span>
							<span class="quills-review-count">
								<?php
								if ( $review_count > 0 ) {
									printf( esc_html__( '(%d reviews)', 'coffee-cafe-corner' ), (int) $review_count );
								} else {
									esc_html_e( '(No reviews)', 'coffee-cafe-corner' );
								}
								?>
							</span>
						</div>
						<div class="quills-coffee-card-price">
							<?php echo esc_html( $price_display ); ?>
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
			'total_text' => sprintf( esc_html__( '%d products', 'coffee-cafe-corner' ), (int) $query->found_posts ),
		) );
	}
}

Coffee_Cafe_Corner_Coffee_DB::init();
