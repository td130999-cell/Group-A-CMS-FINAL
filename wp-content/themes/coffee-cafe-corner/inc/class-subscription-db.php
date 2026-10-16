<?php
/**
 * Class Coffee_Cafe_Corner_Subscription_DB
 *
 * Handles database interaction for Quills Coffee Subscriptions:
 * - Automatically verifies and seeds the category, subscription packages, and page in the database
 * - Provides dynamic database queries for subscriptions with frequency and grind options
 * - Provides AJAX handler for adding customized subscription items to cart
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Coffee_Cafe_Corner_Subscription_DB {

	const TAXONOMY      = 'product_cat';
	const CATEGORY_SLUG  = 'subscriptions';
	const PAGE_SLUG      = 'subscriptions';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'ensure_database_records' ) );
		add_action( 'wp_ajax_quills_add_subscription_to_cart', array( __CLASS__, 'ajax_add_subscription_to_cart' ) );
		add_action( 'wp_ajax_nopriv_quills_add_subscription_to_cart', array( __CLASS__, 'ajax_add_subscription_to_cart' ) );

		// Hook into WooCommerce Cart item display
		add_filter( 'woocommerce_get_item_data', array( __CLASS__, 'display_subscription_cart_meta' ), 10, 2 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( __CLASS__, 'save_subscription_order_meta' ), 10, 4 );
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
					'description' => 'Never run out of freshly-roasted specialty coffee. Flexible subscription plans with automatic savings and free bag offer.',
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

		// Also alias /ca-phe-dinh-ky/
		$vn_page = get_page_by_path( 'ca-phe-dinh-ky' );
		if ( ! $vn_page ) {
			wp_insert_post( array(
				'post_title'     => 'Cà Phê Định Kỳ (Subscriptions)',
				'post_name'      => 'ca-phe-dinh-ky',
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_content'   => '<!-- wp:pattern {"slug":"coffee-cafe-corner/subscriptions"} /-->',
				'comment_status' => 'closed',
			) );
		}

		return $page->ID;
	}

	public static function ensure_products() {
		$category_term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );
		$term_id       = $category_term ? (int) $category_term->term_id : 0;

		$subscription_plans = array(
			array(
				'slug'          => 'blacksmith-subscription',
				'title'         => 'Blacksmith | Espresso Blend',
				'base_price'    => '20.00',
				'price_display' => 'FROM $20.00',
				'description'   => 'Formulated specifically for decadent espresso and rich milk drinks. Velvety body with notes of dark chocolate, caramelized sugar, and candied orange.',
				'image'         => 'coffee/blacksmith.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
				'badge'         => 'ESPRESSO CRAFT',
				'rating'        => '5.0',
				'review_count'  => 58,
				'menu_order'    => 1,
			),
			array(
				'slug'          => 'inkwell-subscription',
				'title'         => 'Inkwell | Signature Blend',
				'base_price'    => '20.00',
				'price_display' => 'FROM $20.00',
				'description'   => 'Our beloved everyday house blend. Rich notes of honey, smooth chocolate, and sweet clementine. Balanced and satisfying for any brewing method.',
				'image'         => 'coffee/inkwell.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
				'badge'         => 'HOUSE FAVORITE',
				'rating'        => '5.0',
				'review_count'  => 80,
				'menu_order'    => 2,
			),
			array(
				'slug'          => 'southern-gothic-subscription',
				'title'         => 'Southern Gothic | Cold Brew Blend',
				'base_price'    => '20.00',
				'price_display' => 'FROM $20.00',
				'description'   => 'Crafted for immersion cold brew and bright iced coffee. Silky sweet notes of berries, dark chocolate, and sweet cream.',
				'image'         => 'coffee/southern-gothic.jpg',
				'fallback'      => 'quills/southern_gothic_main.jpg',
				'badge'         => 'COLD BREW',
				'rating'        => '5.0',
				'review_count'  => 21,
				'menu_order'    => 3,
			),
			array(
				'slug'          => 'night-owl-subscription',
				'title'         => 'Night Owl | French Roast',
				'base_price'    => '20.00',
				'price_display' => 'FROM $20.00',
				'description'   => 'For dark roast purists who appreciate bold richness without bitterness. Notes of smoky dark cacao, molasses, and toasted almond.',
				'image'         => 'coffee/night-owl.jpg',
				'fallback'      => 'quills/night_owl_main.jpg',
				'badge'         => 'DARK ROAST',
				'rating'        => '5.0',
				'review_count'  => 19,
				'menu_order'    => 4,
			),
			array(
				'slug'          => 'colombia-decaf-subscription',
				'title'         => 'Colombia | Paraiso - Sugarcane Decaf',
				'base_price'    => '21.00',
				'price_display' => 'FROM $21.00',
				'description'   => 'All the specialty flavor without the caffeine. Naturally decaffeinated using sugarcane ethyl acetate with sweet maple, plum, and cocoa powder.',
				'image'         => 'coffee/colombia-ea-decaf.jpg',
				'fallback'      => 'quills/blacksmith_back.jpg',
				'badge'         => 'DECAF',
				'rating'        => '5.0',
				'review_count'  => 14,
				'menu_order'    => 5,
			),
			array(
				'slug'          => 'the-cupping-table-subscription',
				'title'         => 'The Cupping Table (Roaster\'s Choice)',
				'base_price'    => '24.00',
				'price_display' => 'FROM $24.00',
				'description'   => 'Our flagship rotating single-origin subscription. Hand-selected by our head roaster, featuring rare lots, exceptional sweetness, and fresh seasonal harvests.',
				'image'         => 'quills/guatemala_alma_main.jpg',
				'fallback'      => 'quills/guatemala_alma_farm.jpg',
				'badge'         => 'MOST POPULAR',
				'rating'        => '5.0',
				'review_count'  => 48,
				'menu_order'    => 6,
			),
			array(
				'slug'          => 'bit-of-both-subscription',
				'title'         => 'Bit of Both',
				'base_price'    => '44.00',
				'price_display' => 'FROM $44.00',
				'description'   => 'Can\'t decide between comfort and adventure? Get two 12oz bags: one bag of our Inkwell blend and one bag of rotating seasonal single origin.',
				'image'         => 'coffee/inkwell.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
				'badge'         => '2-BAG DUO',
				'rating'        => '5.0',
				'review_count'  => 24,
				'menu_order'    => 7,
			),
			array(
				'slug'          => 'the-home-barista-subscription',
				'title'         => 'The Home Barista',
				'base_price'    => '44.00',
				'price_display' => 'FROM $44.00',
				'description'   => 'The complete subscription for high-volume home brewing: two distinct roaster-selected bags shipped every cycle.',
				'image'         => 'coffee/blacksmith.jpg',
				'fallback'      => 'quills/blacksmith_main.jpg',
				'badge'         => 'BEST VALUE',
				'rating'        => '5.0',
				'review_count'  => 18,
				'menu_order'    => 8,
			),
			array(
				'slug'          => 'sunrise-sunset-subscription',
				'title'         => 'Sunrise & Sunset',
				'base_price'    => '42.00',
				'price_display' => 'FROM $42.00',
				'description'   => 'The ideal day-to-night pairing: One bag of caffeinated morning fuel and one bag of delicious evening decaf.',
				'image'         => 'coffee/colombia-ea-decaf.jpg',
				'fallback'      => 'quills/inkwell_main.jpg',
				'badge'         => 'DAY & NIGHT',
				'rating'        => '5.0',
				'review_count'  => 15,
				'menu_order'    => 9,
			),
		);

		foreach ( $subscription_plans as $item ) {
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
					update_post_meta( $product_id, '_price', $item['base_price'] );
					update_post_meta( $product_id, '_regular_price', $item['base_price'] );
					update_post_meta( $product_id, '_price_display', $item['price_display'] );
					update_post_meta( $product_id, '_stock_status', 'instock' );
					update_post_meta( $product_id, '_visibility', 'visible' );
					update_post_meta( $product_id, '_wc_average_rating', $item['rating'] );
					update_post_meta( $product_id, '_wc_review_count', $item['review_count'] );
					update_post_meta( $product_id, '_subscription_badge', $item['badge'] );
					update_post_meta( $product_id, '_subscription_image', $item['image'] );
					update_post_meta( $product_id, '_subscription_fallback_image', $item['fallback'] );
					update_post_meta( $product_id, '_is_subscription_product', 'yes' );

					if ( $term_id > 0 ) {
						wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
					}
					wp_set_object_terms( $product_id, 'simple', 'product_type', false );
				}
			} else {
				$pid = $existing->ID;
				wp_update_post( array(
					'ID'         => $pid,
					'post_title' => $item['title'],
					'menu_order' => $item['menu_order'],
				) );
				update_post_meta( $pid, '_price', $item['base_price'] );
				update_post_meta( $pid, '_regular_price', $item['base_price'] );
				update_post_meta( $pid, '_price_display', $item['price_display'] );
				update_post_meta( $pid, '_wc_average_rating', $item['rating'] );
				update_post_meta( $pid, '_wc_review_count', $item['review_count'] );
				update_post_meta( $pid, '_subscription_badge', $item['badge'] );
				update_post_meta( $pid, '_subscription_image', $item['image'] );
				update_post_meta( $pid, '_subscription_fallback_image', $item['fallback'] );
				update_post_meta( $pid, '_is_subscription_product', 'yes' );
				if ( $term_id > 0 ) {
					wp_set_object_terms( $pid, array( $term_id ), self::TAXONOMY, true );
				}
			}
		}
	}

	public static function get_subscription_products_query() {
		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 20,
			'tax_query'      => array(
				array(
					'taxonomy' => self::TAXONOMY,
					'field'    => 'slug',
					'terms'    => self::CATEGORY_SLUG,
				),
			),
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
		);

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			unset( $args['tax_query'] );
			$args['meta_query'] = array(
				array(
					'key'   => '_is_subscription_product',
					'value' => 'yes',
				),
			);
			$query = new WP_Query( $args );
		}

		return $query;
	}

	public static function ajax_add_subscription_to_cart() {
		$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$frequency  = isset( $_POST['frequency'] ) ? sanitize_text_field( wp_unslash( $_POST['frequency'] ) ) : '2-weeks';
		$grind      = isset( $_POST['grind'] ) ? sanitize_text_field( wp_unslash( $_POST['grind'] ) ) : 'whole-bean';

		if ( ! $product_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid product ID.', 'coffee-cafe-corner' ) ) );
		}

		$frequency_labels = array(
			'1-week'  => 'Every 1 Week',
			'2-weeks' => 'Every 2 Weeks (Save 10%)',
			'4-weeks' => 'Every 4 Weeks (Save 10%)',
		);

		$grind_labels = array(
			'whole-bean'  => 'Whole Bean',
			'drip'        => 'Drip / Pour Over',
			'espresso'    => 'Espresso',
			'french-press'=> 'French Press',
			'cold-brew'   => 'Cold Brew',
		);

		$freq_label  = isset( $frequency_labels[ $frequency ] ) ? $frequency_labels[ $frequency ] : 'Every 2 Weeks';
		$grind_label = isset( $grind_labels[ $grind ] ) ? $grind_labels[ $grind ] : 'Whole Bean';

		$cart_item_data = array(
			'is_subscription'        => true,
			'subscription_frequency' => $freq_label,
			'subscription_grind'     => $grind_label,
			'free_gift_eligible'     => 'Free 12oz Bag of Inkwell',
		);

		// Calculate 10% discount for recurring 2-weeks or 4-weeks
		if ( '2-weeks' === $frequency || '4-weeks' === $frequency ) {
			$base_price = (float) get_post_meta( $product_id, '_price', true );
			if ( $base_price > 0 ) {
				$discounted_price = round( $base_price * 0.9, 2 );
				$cart_item_data['subscription_price'] = $discounted_price;
			}
		}

		$passed = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, 1 );

		if ( $passed && WC()->cart ) {
			$cart_item_key = WC()->cart->add_to_cart( $product_id, 1, 0, array(), $cart_item_data );
			if ( $cart_item_key ) {
				wp_send_json_success( array(
					'message'    => __( 'Subscription added to your cart!', 'coffee-cafe-corner' ),
					'cart_count' => WC()->cart->get_cart_contents_count(),
					'cart_url'   => wc_get_cart_url(),
				) );
			}
		}

		wp_send_json_error( array( 'message' => __( 'Could not add subscription to cart.', 'coffee-cafe-corner' ) ) );
	}

	public static function display_subscription_cart_meta( $item_data, $cart_item ) {
		if ( ! empty( $cart_item['subscription_frequency'] ) ) {
			$item_data[] = array(
				'key'   => __( 'Delivery Frequency', 'coffee-cafe-corner' ),
				'value' => esc_html( $cart_item['subscription_frequency'] ),
			);
		}
		if ( ! empty( $cart_item['subscription_grind'] ) ) {
			$item_data[] = array(
				'key'   => __( 'Grind Type', 'coffee-cafe-corner' ),
				'value' => esc_html( $cart_item['subscription_grind'] ),
			);
		}
		if ( ! empty( $cart_item['free_gift_eligible'] ) ) {
			$item_data[] = array(
				'key'   => __( 'Promo Gift', 'coffee-cafe-corner' ),
				'value' => esc_html( $cart_item['free_gift_eligible'] ),
			);
		}
		return $item_data;
	}

	public static function save_subscription_order_meta( $item, $cart_item_key, $values, $order ) {
		if ( ! empty( $values['subscription_frequency'] ) ) {
			$item->add_meta_data( __( 'Delivery Frequency', 'coffee-cafe-corner' ), $values['subscription_frequency'] );
		}
		if ( ! empty( $values['subscription_grind'] ) ) {
			$item->add_meta_data( __( 'Grind Type', 'coffee-cafe-corner' ), $values['subscription_grind'] );
		}
		if ( ! empty( $values['free_gift_eligible'] ) ) {
			$item->add_meta_data( __( 'Promo Gift', 'coffee-cafe-corner' ), $values['free_gift_eligible'] );
		}
	}
}

Coffee_Cafe_Corner_Subscription_DB::init();
