<?php
/**
 * Class Coffee_Cafe_Corner_Subscription_DB
 *
 * Handles database interaction for Quills Coffee Subscriptions:
 * - Automatically verifies and seeds the category, 9 subscription products, and page in the database
 * - Provides dynamic database queries for subscriptions with multi-option sorting
 * - Provides helper functions for product images, tasting notes, ratings, and price displays
 * - AJAX handler for live filtering & sorting
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Subscription_DB {

	const TAXONOMY     = 'product_cat';
	const CATEGORY_SLUG = 'subscriptions';
	const PAGE_SLUG     = 'subscriptions';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'ensure_database_records' ) );
		add_action( 'wp_ajax_quills_filter_subscriptions', array( __CLASS__, 'ajax_filter_subscriptions' ) );
		add_action( 'wp_ajax_nopriv_quills_filter_subscriptions', array( __CLASS__, 'ajax_filter_subscriptions' ) );
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
				'Subscriptions',
				self::TAXONOMY,
				array(
					'description' => 'Get a free 12oz bag of Inkwell when you subscribe. Freshly-roasted coffee delivered to your door.',
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
				'post_title'     => 'Subscriptions',
				'post_name'      => self::PAGE_SLUG,
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/subscriptions"} /-->',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			) );

			if ( ! is_wp_error( $page_id ) && $page_id > 0 ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-subscriptions.html' );
				update_post_meta( $page_id, '_subscription_banner_title', 'Subscriptions' );
				return $page_id;
			}
			return 0;
		}

		if ( ! get_post_meta( $page->ID, '_wp_page_template', true ) ) {
			update_post_meta( $page->ID, '_wp_page_template', 'page-subscriptions.html' );
		}

		return $page->ID;
	}

	public static function ensure_products() {
		$category_term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );
		$term_id       = $category_term ? (int) $category_term->term_id : 0;

		if ( ! $term_id ) {
			return;
		}

		// 9 canonical products for Quills Coffee Subscriptions matching https://quillscoffee.com/collections/subscriptions
		$products = array(
			array(
				'slug'          => 'blacksmith-espresso-blend',
				'title'         => 'Blacksmith | Espresso Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'rating'        => '5.0',
				'review_count'  => 58,
				'image'         => 'quills/blacksmith.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
				'notes'         => 'dark chocolate, caramelized sugar, candied orange',
				'process'       => 'Washed, Natural',
				'origins'       => 'Guatemala & Colombia',
				'order'         => 1,
			),
			array(
				'slug'          => 'inkwell-signature-blend',
				'title'         => 'Inkwell | Signature Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'rating'        => '5.0',
				'review_count'  => 80,
				'image'         => 'quills/inkwell.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
				'notes'         => 'honey, chocolate, clementine',
				'process'       => 'Washed',
				'origins'       => 'Colombia, Guatemala, & Ethiopia',
				'order'         => 2,
			),
			array(
				'slug'          => 'southern-gothic-cold-brew',
				'title'         => 'Southern Gothic | Cold Brew Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'rating'        => '5.0',
				'review_count'  => 31,
				'image'         => 'quills/southern-gothic.jpg',
				'fallback'      => 'quills/southern_gothic_main.jpg',
				'notes'         => 'Chocolate, caramel, well-balanced.',
				'process'       => 'Washed, Natural',
				'origins'       => 'Brazil & Colombia',
				'order'         => 3,
			),
			array(
				'slug'          => 'night-owl-dark-blend',
				'title'         => 'Night Owl | Dark Blend',
				'price'         => '20.00',
				'price_display' => 'FROM $20.00',
				'rating'        => '5.0',
				'review_count'  => 19,
				'image'         => 'quills/night-owl.jpg',
				'fallback'      => 'quills/night_owl_main.jpg',
				'notes'         => 'smoky dark cacao, molasses, toasted almond',
				'process'       => 'Washed',
				'origins'       => 'Colombia & Ethiopia',
				'order'         => 4,
			),
			array(
				'slug'          => 'the-cupping-table',
				'title'         => 'The Cupping Table',
				'price'         => '24.00',
				'price_display' => '$24.00',
				'rating'        => '5.0',
				'review_count'  => 8,
				'image'         => 'quills/the-cupping-table.jpg',
				'fallback'      => 'quills/the-cupping-table.jpg',
				'notes'         => 'Rotating single origins curated by our head roaster',
				'process'       => 'Seasonal Selection',
				'origins'       => 'Curated Single Origins',
				'order'         => 5,
			),
			array(
				'slug'          => 'bit-of-both',
				'title'         => 'Bit of Both',
				'price'         => '46.00',
				'price_display' => '$46.00',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/bit-of-both.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
				'notes'         => 'One bag of Inkwell house blend + one bag of rotating single origin',
				'process'       => 'Washed & Natural',
				'origins'       => 'Blend & Single Origin',
				'order'         => 6,
			),
			array(
				'slug'          => 'sunrise-sunset',
				'title'         => 'Sunrise & Sunset',
				'price'         => '44.00',
				'price_display' => '$44.00',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/sunrise-sunset.jpg',
				'fallback'      => 'quills/sunrise-sunset.jpg',
				'notes'         => 'Sunrise light roast blend + Sunset dark roast blend pairing',
				'process'       => 'Washed & Natural',
				'origins'       => 'Blend & Decaf',
				'order'         => 7,
			),
			array(
				'slug'          => 'the-home-barista',
				'title'         => 'The Home Barista',
				'price'         => '46.00',
				'price_display' => '$46.00',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/the-home-barista.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
				'notes'         => 'Two 12oz bags curated for the dedicated espresso and milk drinks lover',
				'process'       => 'Washed & Natural',
				'origins'       => 'Espresso Selections',
				'order'         => 8,
			),
			array(
				'slug'          => 'colombia-ea-decaf',
				'title'         => 'Colombia | EA Decaf',
				'price'         => '21.00',
				'price_display' => 'FROM $21.00',
				'rating'        => '0',
				'review_count'  => 0,
				'image'         => 'quills/colombia-ea-decaf.jpg',
				'fallback'      => 'quills/blacksmith_back.jpg',
				'notes'         => 'sweet maple, plum, cocoa powder',
				'process'       => 'Sugarcane EA Decaf',
				'origins'       => 'Colombia',
				'order'         => 9,
			),
		);

		foreach ( $products as $item ) {
			// Find existing product by slug
			$existing = get_page_by_path( $item['slug'], OBJECT, 'product' );

			// Also fallback check for 'The Cupping Table' if it had the old subscription slug
			if ( ! $existing && 'the-cupping-table' === $item['slug'] ) {
				$existing = get_page_by_path( 'the-cupping-table-subscription', OBJECT, 'product' );
				if ( $existing ) {
					wp_update_post( array(
						'ID'         => $existing->ID,
						'post_name'  => 'the-cupping-table',
						'post_title' => 'The Cupping Table',
					) );
				}
			}

			if ( ! $existing ) {
				$product_id = wp_insert_post( array(
					'post_title'     => $item['title'],
					'post_name'      => $item['slug'],
					'post_content'   => 'Tasting Notes: ' . $item['notes'],
					'post_excerpt'   => 'Tasting Notes: ' . $item['notes'],
					'post_status'    => 'publish',
					'post_type'      => 'product',
					'comment_status' => 'open',
				) );
			} else {
				$product_id = $existing->ID;
				wp_update_post( array(
					'ID'         => $product_id,
					'post_title' => $item['title'],
				) );
			}

			if ( ! empty( $product_id ) && ! is_wp_error( $product_id ) ) {
				update_post_meta( $product_id, '_price', $item['price'] );
				update_post_meta( $product_id, '_regular_price', $item['price'] );
				update_post_meta( $product_id, '_price_display', $item['price_display'] );
				update_post_meta( $product_id, '_stock_status', 'instock' );
				update_post_meta( $product_id, '_visibility', 'visible' );
				update_post_meta( $product_id, '_wc_average_rating', $item['rating'] );
				update_post_meta( $product_id, '_wc_review_count', $item['review_count'] );

				update_post_meta( $product_id, '_subscription_order', $item['order'] );
				update_post_meta( $product_id, '_coffee_tasting_notes', $item['notes'] );
				update_post_meta( $product_id, '_coffee_process', $item['process'] );
				update_post_meta( $product_id, '_coffee_origins', $item['origins'] );
				update_post_meta( $product_id, '_coffee_image', $item['image'] );
				update_post_meta( $product_id, '_coffee_fallback_image', $item['fallback'] );
				update_post_meta( $product_id, '_is_subscription_product', 'yes' );

				// Assign to Subscriptions category (append = true so Coffee category is preserved)
				wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
				wp_set_object_terms( $product_id, 'simple', 'product_type', false );
			}
		}

		// Clean up any remaining legacy subscription duplicates (e.g. *-subscription except the-cupping-table)
		$legacy_slugs = array(
			'inkwell-subscription',
			'blacksmith-subscription',
			'bit-of-both-subscription',
			'southern-gothic-subscription',
			'night-owl-subscription',
			'colombia-decaf-subscription',
			'the-home-barista-subscription',
			'sunrise-sunset-subscription',
		);
		foreach ( $legacy_slugs as $lslug ) {
			$leg = get_page_by_path( $lslug, OBJECT, 'product' );
			if ( $leg ) {
				wp_delete_post( $leg->ID, true );
			}
		}
	}

	public static function get_product_image_url( $product_id ) {
		$img      = get_post_meta( $product_id, '_coffee_image', true );
		$fallback = get_post_meta( $product_id, '_coffee_fallback_image', true );

		$candidates = array_unique( array_filter( array( $img, $fallback ) ) );
		$upload_dir = wp_upload_dir();
		$base_dir   = $upload_dir['basedir'];
		$base_url   = $upload_dir['baseurl'];
		$theme_dir  = get_template_directory();
		$theme_uri  = get_template_directory_uri();

		foreach ( $candidates as $rel ) {
			$rel = ltrim( $rel, '/\\' );

			if ( file_exists( $base_dir . '/' . $rel ) ) {
				return $base_url . '/' . $rel;
			}
			if ( file_exists( $theme_dir . '/assets/images/' . $rel ) ) {
				return $theme_uri . '/assets/images/' . $rel;
			}
			if ( file_exists( $theme_dir . '/assets/images/coffee/' . basename( $rel ) ) ) {
				return $theme_uri . '/assets/images/coffee/' . basename( $rel );
			}
		}

		if ( has_post_thumbnail( $product_id ) ) {
			return get_the_post_thumbnail_url( $product_id, 'large' );
		}

		return $theme_uri . '/assets/images/coffee/blacksmith.jpg';
	}

	public static function get_subscription_products_query( $sort_by = 'featured' ) {
		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 24,
			'tax_query'      => array(
				array(
					'taxonomy' => self::TAXONOMY,
					'field'    => 'slug',
					'terms'    => self::CATEGORY_SLUG,
				),
			),
		);

		switch ( $sort_by ) {
			case 'best-selling':
				$args['meta_key'] = '_wc_review_count';
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

			case 'created-ascending':
				$args['orderby'] = 'date';
				$args['order']   = 'ASC';
				break;

			case 'created-descending':
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;

			case 'featured':
			default:
				$args['meta_key'] = '_subscription_order';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'ASC';
				break;
		}

		return new WP_Query( $args );
	}

	public static function ajax_filter_subscriptions() {
		$sort_by = isset( $_GET['sort_by'] ) ? sanitize_text_field( wp_unslash( $_GET['sort_by'] ) ) : 'featured';

		$query = self::get_subscription_products_query( $sort_by );

		ob_start();
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				self::render_product_card( get_the_ID() );
			}
			wp_reset_postdata();
		} else {
			echo '<div class="quills-no-products"><p>' . esc_html__( 'No products found.', 'coffee-cafe-corner' ) . '</p></div>';
		}
		$html = ob_get_clean();

		wp_send_json_success( array(
			'html'  => $html,
			'count' => $query->found_posts,
		) );
	}

	public static function render_product_card( $product_id ) {
		$title         = get_the_title( $product_id );
		$permalink     = get_permalink( $product_id );
		$price_display = get_post_meta( $product_id, '_price_display', true );
		$raw_price     = get_post_meta( $product_id, '_price', true );
		if ( empty( $price_display ) ) {
			$price_display = '$' . number_format( (float) $raw_price, 2 );
		}

		$rating       = (float) get_post_meta( $product_id, '_wc_average_rating', true );
		$review_count = (int) get_post_meta( $product_id, '_wc_review_count', true );
		$image_url    = self::get_product_image_url( $product_id );

		$tasting_notes = get_post_meta( $product_id, '_coffee_tasting_notes', true );
		$process       = get_post_meta( $product_id, '_coffee_process', true );
		$origins       = get_post_meta( $product_id, '_coffee_origins', true );
		?>
		<div class="quills-product-card" data-product-id="<?php echo esc_attr( $product_id ); ?>">
			<div class="quills-product-media">
				<a href="<?php echo esc_url( $permalink ); ?>" class="quills-product-image-link" tabindex="-1" aria-hidden="true">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="quills-product-img" loading="lazy" />
				</a>

				<!-- Hover Tasting Details Card -->
				<div class="quills-product-hover-card">
					<h4 class="quills-hover-title"><?php echo esc_html( $title ); ?></h4>
					<div class="quills-hover-divider"></div>
					<?php if ( ! empty( $tasting_notes ) ) : ?>
						<p class="quills-hover-notes"><?php echo esc_html( $tasting_notes ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $process ) ) : ?>
						<p class="quills-hover-meta"><strong><?php esc_html_e( 'Process:', 'coffee-cafe-corner' ); ?></strong> <?php echo esc_html( $process ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $origins ) ) : ?>
						<p class="quills-hover-meta"><strong><?php esc_html_e( 'Origins:', 'coffee-cafe-corner' ); ?></strong> <?php echo esc_html( $origins ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="quills-product-info">
				<h3 class="quills-product-title">
					<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
				</h3>

				<div class="quills-product-rating">
					<span class="quills-stars" aria-label="<?php echo esc_attr( $rating . ' out of 5 stars' ); ?>">
						<?php if ( $review_count > 0 ) : ?>
							<span class="quills-star quills-star--filled">★</span>
							<span class="quills-star quills-star--filled">★</span>
							<span class="quills-star quills-star--filled">★</span>
							<span class="quills-star quills-star--filled">★</span>
							<span class="quills-star quills-star--filled">★</span>
						<?php else : ?>
							<span class="quills-star quills-star--empty">☆</span>
							<span class="quills-star quills-star--empty">☆</span>
							<span class="quills-star quills-star--empty">☆</span>
							<span class="quills-star quills-star--empty">☆</span>
							<span class="quills-star quills-star--empty">☆</span>
						<?php endif; ?>
					</span>
					<span class="quills-review-count">
						<?php
						if ( $review_count > 0 ) {
							printf( esc_html__( '(%d reviews)', 'coffee-cafe-corner' ), $review_count );
						} else {
							esc_html_e( '(No reviews)', 'coffee-cafe-corner' );
						}
						?>
					</span>
				</div>

				<div class="quills-product-price">
					<span class="quills-price-text"><?php echo esc_html( $price_display ); ?></span>
				</div>
			</div>
		</div>
		<?php
	}
}

Coffee_Cafe_Corner_Subscription_DB::init();
