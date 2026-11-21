<?php
/**
 * Class Coffee_Cafe_Corner_Coffee_DB
 *
 * Handles database interaction for the Coffee Collection:
 * - Automatically verifies and seeds the category, products, gallery images and authentic reviews in the database
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

    const TAXONOMY      = 'product_cat';
    const CATEGORY_SLUG = 'coffee';
    const PAGE_SLUG     = 'coffee';
    const DB_VERSION    = 'ccc_coffee_db_seeded_v6';

    public static function init() {
        add_action( 'init', array( __CLASS__, 'ensure_database_records' ) );
        add_action( 'wp_ajax_quills_filter_coffee', array( __CLASS__, 'ajax_filter_coffee' ) );
        add_action( 'wp_ajax_nopriv_quills_filter_coffee', array( __CLASS__, 'ajax_filter_coffee' ) );
        add_action( 'save_post_product', array( __CLASS__, 'clear_product_and_filter_cache' ) );
        add_action( 'woocommerce_update_product', array( __CLASS__, 'clear_product_and_filter_cache' ) );
        add_action( 'delete_post', array( __CLASS__, 'clear_product_and_filter_cache' ) );
    }

    public static function clear_product_and_filter_cache( $post_id = 0 ) {
        delete_transient( 'quills_coffee_filter_counts' );
        if ( ! empty( $post_id ) ) {
            delete_transient( 'quills_card_html_' . $post_id );
        }
    }

    public static function ensure_database_records() {
        return; // Seeder disabled: Data is permanently managed in database
        if ( get_option( self::DB_VERSION ) ) {
            return;
        }
        self::ensure_category();
        self::ensure_page();
        self::ensure_products();
        update_option( self::DB_VERSION, 1 );
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

        if ( ! get_post_meta( $page->ID, '_wp_page_template', true ) ) {
            update_post_meta( $page->ID, '_wp_page_template', 'page-coffee.html' );
        }

        return $page->ID;
    }

    public static function resolve_image_url( $filename ) {
        if ( empty( $filename ) ) {
            return '';
        }

        if ( preg_match( '/^https?:\/\//i', $filename ) ) {
            return $filename;
        }

        $basename   = basename( $filename );
        $upload_dir = wp_upload_dir();
        $base_dir   = $upload_dir['basedir'];
        $base_url   = $upload_dir['baseurl'];
        $theme_dir  = get_template_directory();
        $theme_uri  = get_template_directory_uri();

        // Check wp-content/uploads/quills/
        if ( file_exists( $base_dir . '/quills/' . $basename ) ) {
            return $base_url . '/quills/' . $basename;
        }

        // Check wp-content/uploads/
        if ( file_exists( $base_dir . '/' . ltrim( $filename, '/\\' ) ) ) {
            return $base_url . '/' . ltrim( $filename, '/\\' );
        }

        // Check theme assets/images/coffee/
        if ( file_exists( $theme_dir . '/assets/images/coffee/' . $basename ) ) {
            return trailingslashit( $theme_uri ) . 'assets/images/coffee/' . $basename;
        }

        // Check theme assets/images/
        if ( file_exists( $theme_dir . '/assets/images/' . ltrim( $filename, '/\\' ) ) ) {
            return trailingslashit( $theme_uri ) . 'assets/images/' . ltrim( $filename, '/\\' );
        }

        // Default path in quills uploads
        return $base_url . '/quills/' . $basename;
    }

    public static function get_product_image_url( $product_id ) {
        // 1. Featured Image set in wp-admin takes highest priority
        if ( has_post_thumbnail( $product_id ) ) {
            $thumb = get_the_post_thumbnail_url( $product_id, 'large' );
            if ( ! empty( $thumb ) ) {
                return $thumb;
            }
        }

        $coffee_img = get_post_meta( $product_id, '_coffee_image', true );
        if ( ! empty( $coffee_img ) ) {
            $url = self::resolve_image_url( $coffee_img );
            if ( ! empty( $url ) ) {
                return $url;
            }
        }

        $fallback = get_post_meta( $product_id, '_coffee_fallback_image', true );
        if ( ! empty( $fallback ) ) {
            $url = self::resolve_image_url( $fallback );
            if ( ! empty( $url ) ) {
                return $url;
            }
        }

        return trailingslashit( get_template_directory_uri() ) . 'assets/images/coffee/inkwell.jpg';
    }

    public static function get_product_gallery_urls( $product_id ) {
        $urls = array();

        // 1. Check WooCommerce gallery set in wp-admin first
        if ( function_exists( 'wc_get_product' ) ) {
            $product = wc_get_product( $product_id );
            if ( $product ) {
                $wc_gallery_ids = $product->get_gallery_image_ids();
                if ( ! empty( $wc_gallery_ids ) ) {
                    foreach ( $wc_gallery_ids as $gid ) {
                        $gurl = wp_get_attachment_image_url( $gid, 'full' );
                        if ( $gurl && ! in_array( $gurl, $urls ) ) {
                            $urls[] = $gurl;
                        }
                    }
                }
            }
        }

        if ( ! empty( $urls ) ) {
            return $urls;
        }

        $gallery_meta = get_post_meta( $product_id, '_coffee_gallery', true );
        if ( is_array( $gallery_meta ) && ! empty( $gallery_meta ) ) {
            foreach ( $gallery_meta as $gitem ) {
                $url = self::resolve_image_url( $gitem );
                if ( ! empty( $url ) && ! in_array( $url, $urls ) ) {
                    $urls[] = $url;
                }
            }
        }

        return $urls;
    }

    public static function get_filter_counts() {
        $transient_key = 'quills_coffee_filter_counts';
        $cached_counts = get_transient( $transient_key );
        if ( false !== $cached_counts && is_array( $cached_counts ) ) {
            return $cached_counts;
        }

        global $wpdb;

        $coffee_ids = $wpdb->get_col( $wpdb->prepare( "
            SELECT p.ID 
            FROM {$wpdb->posts} p
            JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
            JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
            WHERE p.post_type = 'product'
              AND p.post_status = 'publish'
              AND t.slug = %s
              AND p.ID NOT IN (88, 90, 92)
        ", self::CATEGORY_SLUG ) );

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

        if ( ! empty( $coffee_ids ) ) {
            $id_placeholders = implode( ',', array_map( 'intval', $coffee_ids ) );

            // Process counts
            $proc_rows = $wpdb->get_results( "
                SELECT meta_value, COUNT(DISTINCT post_id) as cnt
                FROM {$wpdb->postmeta}
                WHERE post_id IN ({$id_placeholders})
                  AND meta_key = '_coffee_process'
                GROUP BY meta_value
            " );
            foreach ( $proc_rows as $row ) {
                if ( isset( $counts['process'][ $row->meta_value ] ) ) {
                    $counts['process'][ $row->meta_value ] = (int) $row->cnt;
                }
            }

            // Roast counts
            $roast_rows = $wpdb->get_results( "
                SELECT meta_value, COUNT(DISTINCT post_id) as cnt
                FROM {$wpdb->postmeta}
                WHERE post_id IN ({$id_placeholders})
                  AND meta_key = '_coffee_roast'
                GROUP BY meta_value
            " );
            foreach ( $roast_rows as $row ) {
                if ( isset( $counts['roast'][ $row->meta_value ] ) ) {
                    $counts['roast'][ $row->meta_value ] = (int) $row->cnt;
                }
            }

            // Type counts
            $type_rows = $wpdb->get_results( "
                SELECT meta_value, COUNT(DISTINCT post_id) as cnt
                FROM {$wpdb->postmeta}
                WHERE post_id IN ({$id_placeholders})
                  AND meta_key = '_coffee_type'
                GROUP BY meta_value
            " );
            $type_key_map = array(
                'blend'         => 'Blend',
                'decaf'         => 'Decaf',
                'espresso'      => 'Espresso',
                'single-origin' => 'Single Origin',
            );
            foreach ( $type_rows as $row ) {
                $val_lower = strtolower( trim( $row->meta_value ) );
                if ( isset( $type_key_map[ $val_lower ] ) ) {
                    $counts['type'][ $type_key_map[ $val_lower ] ] = (int) $row->cnt;
                }
            }
        }

        set_transient( $transient_key, $counts, 12 * HOUR_IN_SECONDS );
        return $counts;
    }

    public static function ensure_products() {
        $category_term = get_term_by( 'slug', self::CATEGORY_SLUG, self::TAXONOMY );
        $term_id       = $category_term ? (int) $category_term->term_id : 0;

        $products_data = array(
            array(
                'slug'          => 'inkwell-signature-blend',
                'handle'        => 'inkwell-house-blend',
                'title'         => 'Inkwell | Signature Blend',
                'subtitle'      => 'Our Signature House Blend',
                'price'         => '20.00',
                'price_display' => 'FROM $20.00',
                'type'          => array( 'blend' ),
                'process'       => array( 'Washed' ),
                'roast'         => array( 'Medium' ),
                'origins'       => 'Colombia, Guatemala, Ethiopia',
                'notes'         => 'Graham cracker, cooked cherries, vanilla',
                'menu_order'    => 1,
                'content'       => '<p><span style="font-weight: 400;">Inkwell has quickly become a favorite for many of our customers. This house blend has something for everyone, but it’s not just a simple crowd-pleaser. This blend represents everything we are proud to showcase in our coffees: care in production, intentional sourcing, and a roaster’s unique touch, all balanced in a complex, delicate dance. It’s proof that blending doesn’t mean watering down quality.  </span></p>
<p><span style="font-weight: 400;">Current Coffees: Colombia, Guatemala, and Ethiopia</span></p>
<p> </p>',
                'image'         => 'Inkwell_product_photo.jpg',
                'gallery'       => array( 'Bag_back_product_photo.jpg', '02Inkwell_aa4d8c12-b95b-4cbc-a972-e408d7833d44.png', 'sansebastian.jpg' ),
                'reviews'       => array(
                    array( 'author' => 'Seth Caldwell', 'rating' => 5, 'content' => 'This blend is a great everyday coffee for all preferences.', 'date' => '2026-09-29T18:30:51Z' ),
                    array( 'author' => 'Deborah Richnak', 'rating' => 2, 'content' => 'I had some hollyhock Quill coffee at a VRBO property and that is why I ordered more. That coffee was not available but wha I ordered had a weird after taste. I would have thought it would be delicious considering it was 50$!', 'date' => '2026-08-11T12:53:04Z' ),
                    array( 'author' => 'Dony Erwin Erwin', 'rating' => 4, 'content' => 'It’s a little on the mild side for me. We switched to Night Owl for next month’s delivery. Thanks.', 'date' => '2026-08-03T13:10:00Z' ),
                    array( 'author' => 'Donna', 'rating' => 5, 'content' => 'Amazing so glad we found this place', 'date' => '2026-06-02T16:14:46Z' ),
                    array( 'author' => 'Staci B', 'rating' => 5, 'content' => 'This is currently our favorite coffee! Looking forward to trying your other blends in the future.', 'date' => '2026-06-01T03:49:41Z' ),
                    array( 'author' => 'Gail S', 'rating' => 5, 'content' => 'Delicious and does the trick for our morning coffee fix.', 'date' => '2026-05-27T21:53:22Z' ),
                    array( 'author' => 'Ulzii Delger', 'rating' => 5, 'content' => 'Great one', 'date' => '2026-04-30T03:47:45Z' ),
                    array( 'author' => 'Cheryl Streedain', 'rating' => 5, 'content' => 'Such a good "middle of the road" blend. To my mind is neither too bold or too mild. Thanks', 'date' => '2026-03-18T10:02:35Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'Excellent !', 'date' => '2025-12-08T13:30:09Z' ),
                    array( 'author' => 'Robert Alvey', 'rating' => 5, 'content' => 'We visited a location in Louisville while there for doctor appointments. It was an amazing coffee, and we were very happy. I purchased the inkwell whole bean coffee and started using it. I love it!', 'date' => '2025-12-04T14:34:13Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'Roasted to perfection, taste great every time', 'date' => '2025-11-19T19:24:08Z' ),
                    array( 'author' => 'Lisa Peters', 'rating' => 5, 'content' => 'It’s our favorite!! We entertain frequently and everyone seems to enjoy this coffee.', 'date' => '2025-11-19T18:54:16Z' ),
                    array( 'author' => 'Lori', 'rating' => 5, 'content' => 'Love this coffee. It’s has the best smooth flavor.', 'date' => '2025-01-04T17:31:06Z' ),
                    array( 'author' => 'Jessica', 'rating' => 5, 'content' => 'Best daily coffee and always fresh!', 'date' => '2023-08-25T19:29:03Z' ),
                    array( 'author' => 'Cameron Raulston', 'rating' => 5, 'content' => 'Inkwell | Signature Blend', 'date' => '2022-05-27T21:15:17Z' ),
                    array( 'author' => 'Gary Liebst', 'rating' => 5, 'content' => 'The coffee is delicious as always. Top notch quality.', 'date' => '2022-03-01T18:13:13Z' ),
                    array( 'author' => 'Ron Shay', 'rating' => 5, 'content' => 'Inkwell | House Blend', 'date' => '2021-10-05T19:26:32Z' ),
                    array( 'author' => 'Lesley Turba', 'rating' => 1, 'content' => 'Unable to share my thoughts on this coffee as I still have not received the delivery.', 'date' => '2021-06-08T12:28:16Z' ),
                    array( 'author' => 'Dani', 'rating' => 5, 'content' => 'It is a very good coffee, second time we bought. It is very mild and easy to drink.', 'date' => '2021-03-28T15:14:34Z' ),
                    array( 'author' => 'Jeff Schepper', 'rating' => 5, 'content' => 'Inkwell is one of my all time favorites. The night owl that I also purchased is ok.', 'date' => '2021-03-11T17:00:09Z' ),
                    array( 'author' => 'D.G.', 'rating' => 5, 'content' => 'This was one of the sweetest coffees I\'ve ever had. It is one of the few in which the tasting notes really reflect what\'s in the cup. The notes of sugar and vanilla really burst out, with that cherry-like acidity holding the balance. Fantastic brew in any method!', 'date' => '2021-03-04T16:12:40Z' ),
                    array( 'author' => 'Bryan Beach', 'rating' => 5, 'content' => 'We all know that there are hundreds of delicious coffees out there, but nothing is as satisfying, comforting, and consistent as Inkwell. It\'s like my warm blanket.', 'date' => '2021-02-06T17:35:14Z' ),
                    array( 'author' => 'Debra Totten', 'rating' => 5, 'content' => 'Inkwell is my “go to” coffee. While I enjoy the occasional single source bean, I always come back to Inkwell.', 'date' => '2021-02-02T21:51:42Z' ),
                    array( 'author' => 'Kavya', 'rating' => 5, 'content' => 'great christmas gift for my bf who is from louisville and was feeling a lil homesick. much love from chicago!', 'date' => '2020-12-22T01:39:32Z' ),
                    array( 'author' => 'Jason Kirshner', 'rating' => 4, 'content' => 'I love dark roasts that are bold in flavor. The quills coffee is on the sweeter side with the cherry notes. Other than that, it\'s very strong with nice and dense crema', 'date' => '2020-12-17T14:55:38Z' ),
                    array( 'author' => 'Leeore Intrator', 'rating' => 4, 'content' => 'Inkwell | House Blend', 'date' => '2020-12-02T16:14:56Z' ),
                    array( 'author' => 'laurie severson', 'rating' => 5, 'content' => 'My favorite (and only) addiction. Had this while traveling thru Kentucky. Had to find it and order it for home.', 'date' => '2020-11-30T14:28:27Z' ),
                    array( 'author' => 'Patrick Gallagher', 'rating' => 5, 'content' => 'Great Coffee Great Flavor', 'date' => '2020-10-23T15:29:05Z' ),
                    array( 'author' => 'Brianne Englert', 'rating' => 5, 'content' => 'One cup is all it took, and we were hooked! Sometimes we would make excuses to drive the hour just to get a cup and buy some beans to take back home. Now we order online to have our favorite cup of Joe on a daily basis. Absolutely, love Quills!', 'date' => '2020-10-20T03:27:25Z' ),
                    array( 'author' => 'Seth Moore', 'rating' => 5, 'content' => 'Hopefully it will be good', 'date' => '2020-10-09T01:16:04Z' ),
                    array( 'author' => 'Lori Madison', 'rating' => 5, 'content' => 'Love getting my favorite coffee delivered! I appreciate the updates about my coffee order. There is no better coffee around!', 'date' => '2020-09-15T16:30:36Z' ),
                    array( 'author' => 'Allison', 'rating' => 5, 'content' => 'Delicious Coffee!', 'date' => '2020-09-15T12:40:29Z' ),
                    array( 'author' => 'Susan Olson', 'rating' => 5, 'content' => 'We really enjoyed the flavor.', 'date' => '2020-08-31T12:05:43Z' ),
                    array( 'author' => 'Kadyrii Yusufjon', 'rating' => 5, 'content' => 'Great coffee, better than both, Starbucks and Heine Brothers whole bean coffee', 'date' => '2020-07-27T03:25:57Z' ),
                ),
            ),
            array(
                'slug'          => 'blacksmith-espresso-blend',
                'handle'        => 'blacksmith-espresso',
                'title'         => 'Blacksmith | Espresso Blend',
                'subtitle'      => 'Our Signature Espresso',
                'price'         => '20.00',
                'price_display' => 'FROM $20.00',
                'type'          => array( 'espresso', 'blend' ),
                'process'       => array( 'Washed', 'Natural' ),
                'roast'         => array( 'Medium' ),
                'origins'       => 'Colombia, Nicaragua, Ethiopia',
                'notes'         => "Baker's chocolate, blueberries, hazelnut",
                'menu_order'    => 2,
                'content'       => '<h3><strong>Blacksmith is our flagship espresso for a reason.</strong></h3>
<p>Over 5,000,000 shots pulled across all seven of our cafes and still the most popular coffee in our subscription lineup. It’s the espresso we rely on every single day.</p>
<p>Currently built from a blend of Colombia, Nicaragua, and Ethiopia, Blacksmith is designed as a true daily driver: rich, balanced<span style="font-weight: 400;">, this blend is delicious as a double shot or in milk.<br></span></p>
<h3><strong>This is espresso built for the home barista.</strong></h3>
<p><strong>It’s forgiving.</strong> Not every morning is perfect. Blacksmith still pulls a delicious shot even when your dose is a little off, your grind is approximate, or you’re half-awake at 6 a.m. It’s the reliable daily driver you can count on.</p>
<p><strong>It stands up in milk.</strong> Chocolate-forward and full-bodied, designed to cut through dairy or alternatives without the flavor disappearing.</p>
<p><strong>It’s fresh. </strong>Every bag is roasted to order, rested to degas, and arrives at your door approaching peak freshness, so you get that rich crema and a coffee at its most vibrant.</p>
<blockquote>
<p><meta charset="utf-8"><span style="font-weight: 400;">The name "Blacksmith" represents our ongoing dedication to refinement, inherent to the craft of making great espresso. This is the blend that reminds you that it was, in fact, a great decision to buy that espresso machine for your kitchen.</span></p>
</blockquote>
<p>Available in 12oz, 2lb, and 5lb.</p>
<p style="margin-left: 0px; margin-right: 0px;"><span style="font-weight: 400;"><br></span></p>',
                'image'         => 'Blacksmith_product_photo.jpg',
                'gallery'       => array( 'Bag_back_product_photo_330c0f3d-9888-4609-8d82-a4a80ef09f60.jpg', '06Blacksmith_7704fd7b-3910-413b-b5ba-e1113978892e.png', 'quillscoffee-202.jpg' ),
                'reviews'       => array(
                    array( 'author' => 'Michael Sego', 'rating' => 5, 'content' => 'Coffee was great. One of my fav espresso’s for milk beverages! 😊', 'date' => '2026-05-06T13:38:43Z' ),
                    array( 'author' => 'Robert Alvey', 'rating' => 5, 'content' => 'I tried the espresso beans in my grinder for my espresso machine and they were amazing. Not wax covered like you get at the supermarket, the smell alone is worth the purchase. Also, the roasting date is on the package, which means a lot and not the "best used by".', 'date' => '2026-10-15T17:41:43Z' ),
                    array( 'author' => 'Kim Martin', 'rating' => 5, 'content' => 'Brew recipe works like a charm, 202°, I use 19.5 g in, 48 g out and it is amazing! Now start selling your bourbon caramel please lol :-)', 'date' => '2026-10-15T16:30:40Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'Really enjoying these beans. Easy to dial in and makes great lattes.', 'date' => '2026-10-13T00:54:05Z' ),
                    array( 'author' => 'Donald Schlenbecker', 'rating' => 5, 'content' => 'Smoothest, cleanest espresso I have ever had.', 'date' => '2026-10-12T22:16:08Z' ),
                    array( 'author' => 'Scott Fenton', 'rating' => 5, 'content' => 'Makes excellent espresso', 'date' => '2026-10-07T12:00:12Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'I really enjoy the taste of the coffee. I would like to order a full pound of the same blend. Can you help me?', 'date' => '2026-10-06T19:17:32Z' ),
                    array( 'author' => 'Paul Butera', 'rating' => 5, 'content' => 'Great espresso roast. Pairs perfectly with milk', 'date' => '2026-10-02T01:26:40Z' ),
                    array( 'author' => 'TREVOR', 'rating' => 5, 'content' => 'Its awesome its always made a day or two after shipped super fresh can’t recommend enough', 'date' => '2026-08-27T21:49:06Z' ),
                    array( 'author' => 'Olivia Reuter', 'rating' => 5, 'content' => 'The only espresso we use at home. It\'s perfectly balanced, and consistently delicious!', 'date' => '2026-07-28T14:06:41Z' ),
                    array( 'author' => 'Seth Caldwell', 'rating' => 5, 'content' => 'Coffee came, as promised, freshly roasted and full of aroma. The taste is sweet, slightly fruity, and well balanced. Grinding fresh every time allows this blend to shine again and again in each cup brewed. I love Quill’s dedication to their customer base in ensuring high quality beans. I have been ordering this blend for well over a year now and will definitely continue to do so! Thanks, Quills!', 'date' => '2026-07-11T01:20:51Z' ),
                    array( 'author' => 'TREVOR', 'rating' => 5, 'content' => 'Love that coffee some of the best ive had ordering it all the time now love it', 'date' => '2026-06-13T19:19:31Z' ),
                    array( 'author' => 'Donna', 'rating' => 5, 'content' => 'Incredible find!', 'date' => '2026-06-02T16:13:29Z' ),
                    array( 'author' => 'Jeff Mueller', 'rating' => 5, 'content' => 'Love visiting here when I’m in Louisville! Tried many different beans in our espresso maker and we keep coming back to the Blacksmith, it’s our favorite!', 'date' => '2026-05-13T23:28:39Z' ),
                    array( 'author' => 'Arthur Simpson', 'rating' => 4, 'content' => 'Got me up and going', 'date' => '2026-05-04T13:43:00Z' ),
                    array( 'author' => 'Michael Rakotz', 'rating' => 1, 'content' => 'Bag came opened and was poured out in the box mixed with another bag of your coffee. I asked for a refund and never received so 1 star and I’m out a lot of money. I’ve heard great thing la and truly wanted to try your coffees - you need to work on your customer service. Michael Rakotz', 'date' => '2026-04-21T03:47:37Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'My favorite espresso blender. Rich and aromatic and always freshly roasted.', 'date' => '2026-04-08T12:31:11Z' ),
                    array( 'author' => 'Sonya Combs', 'rating' => 5, 'content' => 'Bought this to mix half and half with decaf de Cana whole bean......love espressos, but needed to cut back on the caffeine!!', 'date' => '2026-03-14T00:11:38Z' ),
                    array( 'author' => 'James Barger', 'rating' => 5, 'content' => 'This is my favorite espresso. I\'ve been to hundreds of coffee shops and Quills stands out among the rest. 10/10!', 'date' => '2026-03-13T14:22:31Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'We love this coffee. It is the best we’ve had since leaving Italy', 'date' => '2026-02-19T23:14:10Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'Love their coffee!', 'date' => '2026-02-04T18:13:57Z' ),
                    array( 'author' => 'Mark', 'rating' => 5, 'content' => 'Great', 'date' => '2026-01-31T14:13:12Z' ),
                    array( 'author' => 'Hilary B', 'rating' => 5, 'content' => 'This is one of my favorites for an easy always enjoyable at-home brew. Not acidic, not burnt, excellent even and consistent flavor. It doesn\'t make me work to get a good cup out of it either so it\'s great for a lazy / easy morning but can also be prepared a number of ways. Yes, this espresso blend goes through my coffee maker, aeropress, pour over ... whatever I\'m in the mood for and it\'s always been good.', 'date' => '2025-12-05T14:55:22Z' ),
                    array( 'author' => 'L.H.', 'rating' => 5, 'content' => 'Best coffee!!!', 'date' => '2025-11-12T21:28:06Z' ),
                    array( 'author' => 'D Hartman', 'rating' => 5, 'content' => 'This coffee roast and blend are truly awesome. So much flavor and subtle notes. If you love lighter body espresso that still holds up in espresso drinks with milk you will not be disappointed! 10 out of 10.', 'date' => '2025-11-12T16:35:47Z' ),
                    array( 'author' => 'Vic Emond', 'rating' => 5, 'content' => 'LOVE this espresso. Best tasting bean out there.', 'date' => '2025-11-04T21:40:35Z' ),
                    array( 'author' => 'Lauren', 'rating' => 5, 'content' => 'best espresso I have ever had', 'date' => '2024-09-30T22:39:45Z' ),
                    array( 'author' => 'Kim', 'rating' => 5, 'content' => 'The coffee is amazing', 'date' => '2023-12-19T22:40:14Z' ),
                    array( 'author' => 'Amber Good', 'rating' => 5, 'content' => 'Great flavor', 'date' => '2022-05-29T20:04:43Z' ),
                    array( 'author' => 'Quinn Cone', 'rating' => 5, 'content' => 'I received Blacksmith via Trade as a random weekly bean, and immediately created a recurring subscription with Quill\'s. It is now my staple espresso, and can\'t recommend it enough.', 'date' => '2022-05-10T14:11:15Z' ),
                    array( 'author' => 'Paige Demetriades', 'rating' => 5, 'content' => 'I have an espresso machine and have searched far and wide for good beans and I haven’t found anything that touches the Blacksmith.', 'date' => '2022-04-16T15:59:59Z' ),
                    array( 'author' => 'Jonathan Ray', 'rating' => 5, 'content' => 'Totally worth ordering even when I have tons of local roasters around me! So good!', 'date' => '2022-04-07T14:34:24Z' ),
                    array( 'author' => 'P Dean Addison', 'rating' => 4, 'content' => 'This batch seemed like a weaker roast than the previous blacksmith espresso.', 'date' => '2022-03-22T15:17:17Z' ),
                ),
            ),
            array(
                'slug'          => 'southern-gothic-cold-brew',
                'handle'        => 'southern-gothic-12oz',
                'title'         => 'Southern Gothic | Cold Brew Blend',
                'subtitle'      => '',
                'price'         => '20.00',
                'price_display' => 'FROM $20.00',
                'type'          => array( 'blend' ),
                'process'       => array( 'Washed', 'Natural' ),
                'roast'         => array( 'Medium' ),
                'origins'       => 'Brazil & Colombia',
                'notes'         => 'Chocolate, caramel, well-balanced.',
                'menu_order'    => 3,
                'content'       => '<p> </p>
<p data-mce-fragment="1">It’s literary. It’s Southern. It’s dark. But we’re not talking about Flannery O’Connor, William Faulkner or Cormac McCarthy. Southern Gothic is warm, comfort coffee at its best. We chose to start offering this as our in-house cold brew because it’s a great, darker-roasted, low-acid blend. Think heavier body, rich full chocolates and caramels. The kind of coffee anybody can enjoy.</p>
<p data-mce-fragment="1">Current coffees: Brazil<strong data-mce-fragment="1">, </strong>Colombia</p>
<p data-mce-fragment="1">We taste: Chocolate, caramel, well-balanced.</p>',
                'image'         => 'Southern_Gothic_glass.jpg',
                'gallery'       => array( 'Bag_back_product_photo_330c0f3d-9888-4609-8d82-a4a80ef09f60.jpg', '01SouthernGothic_ee2f4483-b297-4678-b9c9-d2d7f66c22ba.png', 'kenya.jpg' ),
                'reviews'       => array(
                    array( 'author' => 'Anonymous', 'rating' => 3, 'content' => 'This batch was our most disappointing batch ever given how long we have been getting beans from Quills. These beans had that burn quality that you are simply like, this isn’t our norm but, what exactly happened at the same time. It’s two bags worth of burnt coffee and we are thrilled given the price.', 'date' => '2026-10-13T22:46:57Z' ),
                    array( 'author' => 'Kristopher Johnson', 'rating' => 5, 'content' => 'I visited Louisville in the spring and wanted to share the cold brew with my wife. She loves it too—it’s smooth and flavorful and we love that it’s roasted to order.', 'date' => '2026-07-28T14:13:53Z' ),
                    array( 'author' => 'Jennifer Burk', 'rating' => 5, 'content' => 'The coffee is smooth and delicious. It is my new focorote I found on a trip to Louisville.', 'date' => '2026-07-03T09:53:46Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'That’s why I keep buying Southern Gothic and Inkwell !', 'date' => '2026-03-24T16:40:04Z' ),
                    array( 'author' => 'Natalie', 'rating' => 5, 'content' => 'One of my favorite coffees and still is so happy i can have it delieverd to me since i moved away from the coffee shop.', 'date' => '2026-03-16T15:55:29Z' ),
                    array( 'author' => 'Anonymous', 'rating' => 5, 'content' => 'It’s my go to coffee even after years of trying and exploring', 'date' => '2026-02-21T01:17:13Z' ),
                    array( 'author' => 'Faith', 'rating' => 5, 'content' => 'This is my favorite coffee ever. I look forward to it every morning', 'date' => '2025-09-10T16:48:42Z' ),
                    array( 'author' => 'L', 'rating' => 5, 'content' => 'Southern Gothic | Cold Brew Blend', 'date' => '2022-05-16T12:45:21Z' ),
                    array( 'author' => 'Linda McNutt', 'rating' => 5, 'content' => 'I purchased this for cold brew and it was great. I also made a pot of hot coffee with it, and we enjoyed it that way as well.', 'date' => '2022-05-10T13:26:03Z' ),
                    array( 'author' => 'Melissa Rue', 'rating' => 5, 'content' => 'Amazing!', 'date' => '2021-12-28T22:32:00Z' ),
                    array( 'author' => 'Brian Gibson', 'rating' => 5, 'content' => 'Excellent blend! Can’t wait to try some more blends from Quills!!!', 'date' => '2021-12-14T21:52:42Z' ),
                    array( 'author' => 'Tracy Swart', 'rating' => 5, 'content' => 'Heaven in a cup', 'date' => '2021-11-02T16:24:17Z' ),
                    array( 'author' => 'Clark Fralick', 'rating' => 5, 'content' => 'This is not BS coffee. Great smooth coffee that loves to be drank.', 'date' => '2021-05-29T00:01:47Z' ),
                    array( 'author' => 'KSS', 'rating' => 5, 'content' => 'More complex than I was expecting. I’m pleasantly surprised.', 'date' => '2021-04-15T14:27:08Z' ),
                    array( 'author' => 'j. anderson', 'rating' => 5, 'content' => 'While on a (pre-COVID) road trip, my son and I happened to stop at a coffee shop that served Quills Coffee. I bought a couple of pounds to take home with me. One of the pounds was apparently mostly-forgettable; the other was Southern Gothic. It’s not always available; when we notice that it is, we order some! It’s one of the smoothest, most enjoyable coffees we’ve had.', 'date' => '2021-03-30T19:47:49Z' ),
                    array( 'author' => 'David', 'rating' => 5, 'content' => 'Tried it based on the tasting notes. This is my new favorite of all the blends offered by quills.', 'date' => '2021-03-28T03:46:03Z' ),
                    array( 'author' => 'Dyer Lowery', 'rating' => 5, 'content' => 'I originally ordered this coffee because I thought the name was cute. It definitely exceeded my expectations and is my new favorite from Quills!', 'date' => '2021-03-06T15:58:55Z' ),
                    array( 'author' => 'Steven', 'rating' => 5, 'content' => 'A delicious coffee I can drink everyday with any brew method, will definitely order again!', 'date' => '2021-01-19T14:52:41Z' ),
                    array( 'author' => 'Mark Steingold', 'rating' => 5, 'content' => 'I love this blend...rich taste, smooth, and very satisfying first thing in the morning! A great way to start the day!', 'date' => '2021-01-14T01:36:28Z' ),
                    array( 'author' => 'Donna Standridge', 'rating' => 5, 'content' => 'Southern Gothic - 12 oz', 'date' => '2020-12-27T19:22:18Z' ),
                    array( 'author' => 'Anita Moore', 'rating' => 5, 'content' => 'Since I became a coffee drinker later in life, I struggled for a few years to find a coffee I really loved. Southern Gothic is it! Yay! And Quills is delightful to work with. I\'ve been getting coffee by subscription for a over a year now, and I am very happy!', 'date' => '2020-11-02T04:37:38Z' ),
                ),
            ),
            array(
                'slug'          => 'night-owl-dark-blend',
                'handle'        => 'night-owl',
                'title'         => 'Night Owl | Dark Blend',
                'price'         => '20.00',
                'price_display' => 'FROM $20.00',
                'type'          => array( 'blend' ),
                'process'       => array( 'Washed' ),
                'roast'         => array( 'Dark' ),
                'origins'       => 'Central & South America',
                'notes'         => 'smoky dark cacao, molasses, toasted almond',
                'menu_order'    => 4,
                'content'       => '<p> </p>
<p>A dark roast you say?! What in tarnation!? Well at Quills a common saying is “Quality for All” and we can’t say that if we aren’t constantly looking at our coffee offerings and pushing the boundaries. A blend of Honduras and Colombia, this blend is the darkest roast we’ve done to date, but also something we’re proud to put alongside our other coffees. </p>
<p><em><strong>We taste:  Chocolate cake, caramel, rich, tobacco finish </strong></em></p>
<ul>
<li>Farm: Various Smallholder farms</li>
<li>Origins: Colombia, Honduras</li>
<li>Process: Washed</li>
<li>Variety: Bourbon, caturra, Catuai, Parainema</li>
<li>Elevation: 1200-2100 MASL<span style="font-family: -apple-system, BlinkMacSystemFont, \'San Francisco\', \'Segoe UI\', Roboto, \'Helvetica Neue\', sans-serif; font-size: 0.875rem;"></span>
</li>
</ul>',
                'image'         => 'Night_Owl_product_photo.jpg',
                'gallery'       => array( 'Bag_back_product_photo_330c0f3d-9888-4609-8d82-a4a80ef09f60.jpg', 'quillscoffee-392.jpg', '03NightOwl_4b9ebe26-0fd7-471f-a381-ee66e4419105.png' ),
                'reviews'       => array(
                    array( 'author' => 'Elise Martin', 'rating' => 5, 'content' => 'Deliciously rich flavor from start to finish. My new favorite bean!', 'date' => '2026-06-24T11:54:44Z' ),
                    array( 'author' => 'Orion', 'rating' => 5, 'content' => 'Good fresh beans every time. I got the subscription, and its worth it. Easily the best beans at this price point. Consistent roast, great flavor, reasonable price. Thank you Quills', 'date' => '2026-06-09T12:54:36Z' ),
                    array( 'author' => 'David Nation', 'rating' => 5, 'content' => 'I always drank my coffee weak; until I tasted Quill\'s coffee. Thanks for changing taste for coffee. It\'s a coffee without the bitter taste and contaminants. "Smooth" Thanks!', 'date' => '2026-03-13T15:41:07Z' ),
                    array( 'author' => 'Chris Stamper', 'rating' => 5, 'content' => 'I\'m not usually a dark roast guy but the night owl blend was fantastic. Very smooth and full tasting.', 'date' => '2026-02-04T21:53:32Z' ),
                    array( 'author' => 'Barb Chunn', 'rating' => 5, 'content' => 'The night owl is our favorite beans. It smells and tastes rich and delicious.', 'date' => '2026-01-29T02:33:17Z' ),
                    array( 'author' => 'MTNMAN', 'rating' => 5, 'content' => 'I had visited the quills coffee shop here in Knoxville Tennessee across from restaurant called the Disco chicken. I had looked at the different types of coffee by quills and saw the night owl bag and read the flavor notes. has somebody who enjoys pipe smoking cigars and other artisan flavors need intrigued me to try a cup. I was asked if I wanted drip pour over a French press. as I know French press provides the depth and flavor I chose the French press was the best decision I have made. after that cup of night owl coffee I have since purchased a 2 lb bag and if considered purchasing a 5 lb bag I\'ve been on the hunt for a good dark roast Vienna coffee house is dark horse is a pretty good contender but it\'s still too acidic compared to this. I would highly recommend this.', 'date' => '2025-11-23T14:21:14Z' ),
                    array( 'author' => 'ALYSON', 'rating' => 5, 'content' => 'My husband’s favorite coffee! Always packaged well with shipping.', 'date' => '2024-12-13T00:17:53Z' ),
                    array( 'author' => 'Dawn', 'rating' => 5, 'content' => 'Amazing flavor! Did not disappoint.', 'date' => '2024-01-16T14:57:37Z' ),
                    array( 'author' => 'Kaitlyn Branch', 'rating' => 5, 'content' => 'Quills never fails to provide fresh, delicious coffee for my team and residents! Thank you!', 'date' => '2022-04-26T16:17:01Z' ),
                    array( 'author' => 'Rebecca Dillon', 'rating' => 5, 'content' => 'Night Owl | Dark Blend', 'date' => '2022-03-13T19:14:09Z' ),
                    array( 'author' => 'Jose Torres-Vorshirm', 'rating' => 5, 'content' => 'The dark chocolate tones with that subtle finish of tobacco at the very end makes me want to open a bottle of scotch at 7am. One of the best dark roasts I’ve had, a pleasant and bold jump start in the morning….', 'date' => '2022-01-15T00:10:49Z' ),
                    array( 'author' => 'Alex B.', 'rating' => 5, 'content' => 'Absolutely love Quills!', 'date' => '2021-12-05T13:58:32Z' ),
                    array( 'author' => 'ALYSON FAULHABER', 'rating' => 5, 'content' => 'The best dark roast coffee!', 'date' => '2021-07-14T23:34:55Z' ),
                    array( 'author' => 'Erin Dougherty', 'rating' => 5, 'content' => 'This coffee took me back to visiting the Bourbon Trail and starting the morning at Quills. I highly recommend these coffee beans to kick off any day.', 'date' => '2021-04-02T23:41:55Z' ),
                    array( 'author' => 'Jeff Schepper', 'rating' => 3, 'content' => 'Ok, but will revert back to Inkwell', 'date' => '2021-03-18T16:58:43Z' ),
                    array( 'author' => 'Marlow', 'rating' => 5, 'content' => 'I’ve tried my fair share of dark roasts around the city, but none of them hit the spot. Until I tasted this gem. Rich flavor and smoky after tones: exactly what I’ve been looking for for years. This is my new go-to and favorite coffee. Packs the punch I need in the morning!', 'date' => '2021-01-25T23:39:32Z' ),
                    array( 'author' => 'Alex Stotts', 'rating' => 5, 'content' => 'Quills does it again! As a Dark Roast lover, I was thrilled when the barista at my local Quills brought this new offering to my attention. Certainly not all Dark Roasts are created equal, and this one is top notch. It has the expected qualities of this roast level while maintaining some of the intricacies and delicate nuances many dark roasts miss!', 'date' => '2021-01-09T12:31:18Z' ),
                    array( 'author' => 'Jamie Wiggins', 'rating' => 5, 'content' => 'This is probably the best coffee I\'ve ever had. It is very dark, but if you like a dark roast it is delicious. I make it as an iced pour-over and it doesn\'t need the small splash of milk that most of my other coffees do. I have also bought beans for others', 'date' => '2020-12-06T04:05:11Z' ),
                    array( 'author' => 'William Kissel', 'rating' => 3, 'content' => 'I thought it was okay. Too “dark” for me compared to my favorite Central American varieties.', 'date' => '2020-11-19T23:51:59Z' ),
                ),
            ),
            array(
                'slug'          => 'colombia-earthquake-relief-black-condor',
                'handle'        => 'colombia-black-condor',
                'title'         => 'Colombia Earthquake Relief | Black Condor',
                'price'         => '23.00',
                'price_display' => 'FROM $23.00',
                'type'          => array( 'single-origin' ),
                'process'       => array( 'Washed' ),
                'roast'         => array( 'Light' ),
                'origins'       => 'Tolima, Colombia',
                'notes'         => 'cane sugar, red apple, caramel',
                'menu_order'    => 5,
                'content'       => '<p><strong>For every bag of Black Condor sold, Quills will donate $2 to earthquake relief efforts in Colombia.</strong><br></p>
<div><br></div>
<div>Situated in Gaitania, Tolima, an area historically impacted by conflict and renowned as the birthplace of Colombian coffee, Emmanuel, a dedicated coffee grower, embarked on a venture. In 2016, in collaboration with his family, they established a coffee processing center aimed at assisting over 15 villages in Gaitania, facilitating local coffee growers in bean processing. Forest Coffee and Emmanuel joined forces in 2019 to establish the Black Condor Project, providing support to farmers in Gaitania affected by guerrilla warfare. We regularly conduct workshops with producers to emphasize quality and cover processes such as fermentation, drying, and cupping of their own coffees. The culmination of these efforts is the exquisite Black Condor Coffee.<br><br>We taste: black cherry, pomegranate, milk chocolate, caramel</div>
<div><br></div>
<div>Producer: Black Condor Project</div>
<div>Region: Tolima, Colombia</div>
<div>Process: Washed</div>
<div>Varieties: Caturra &amp; Castillo</div>
<div>Elevation: 1650-1950 MASL</div>',
                'image'         => 'IMG_0333.jpg',
                'gallery'       => array( 'Forest-Coffee-Sourcing-Trip-Experience-Host-Sponsor-1.webp', 'bb98b2a0-44bb-48b9-8824-c1950f8e1ab7_1.jpg', 'ec86ca69-9c51-40ac-a76d-13e68fbeee6f_copy.jpg', 'Black-condor-project-team-II.jpg', 'DSCF9179.jpg', 'Black_Condor_Relief.png' ),
                'reviews'       => array(
                ),
            ),
            array(
                'slug'          => 'bit-of-both',
                'handle'        => 'bit-of-both',
                'title'         => 'Bit of Both',
                'price'         => '46.00',
                'price_display' => '$46.00',
                'type'          => array( 'blend' ),
                'process'       => array( 'Washed & Natural' ),
                'roast'         => array( 'Light' ),
                'origins'       => 'Seasonal Blend Pairing',
                'notes'         => 'Inkwell house blend + rotating seasonal single origin',
                'menu_order'    => 6,
                'content'       => '<div>
<em></em><br>
</div>
<div>Can\'t decide between a blend or single origin? Every person and household is different and this subscription plan is for folks who like a little from both categories. This plan ships a 12oz bag of our house blend Inkwell and a 12oz bag of our current seasonal coffee.</div>',
                'image'         => 'DSC00660.jpg',
                'gallery'       => array(),
                'reviews'       => array(
                ),
            ),
            array(
                'slug'          => 'ommagourd-fall-blend',
                'handle'        => 'ommagourd',
                'title'         => 'Ommagourd | Fall Blend',
                'price'         => '24.00',
                'price_display' => '$24.00',
                'type'          => array( 'blend' ),
                'process'       => array( 'Washed' ),
                'roast'         => array( 'Medium' ),
                'origins'       => 'Seasonal Blend',
                'notes'         => 'spiced pumpkin, brown sugar, nutmeg, baked pecan',
                'menu_order'    => 7,
                'content'       => '<div>
<em>Few things resonate with coffee like the autumn season, and we have designed our fall blend, Ommagourd, to highlight all of your favorite parts!  Think campfire vibes and wool socks.  Taste sweet pies and roasted nuts.  Smell warm spices and vanilla essence.  Feel cozy sweaters and brisk air.  So take a moment this fall, slow down, and breathe in the cooling air - hopefully you can do it with a cup of Ommagourd in your hands.</em><br><br><strong>Also available as a French press brew exclusively at our Firehouse cafe on Main Street.</strong><br><br><em>We taste: Baked apple, oak &amp; maple syrup</em>
</div>
<div><br></div>
<div>Origins: Kenya, Nicaragua, &amp; Ethiopia</div>
<div>Process: Washed</div>
<div><br></div>',
                'image'         => 'DSC00497.jpg',
                'gallery'       => array( 'OmmagourdCoffeeLabel_2026.png', 'DSC05228.jpg' ),
                'reviews'       => array(
                    array( 'author' => 'Lynn B', 'rating' => 5, 'content' => 'This is one of my favorite coffees I have ever had. The body is warm and comforting, with a natural spice and nuttiness that is perfect for a crisp morning or a cozy afternoon in! The fruitiness is more apple/pear on the front with a natural sweetness and weight on the middle with a pleasant warm finish. Truly a perfect cup for autumn.', 'date' => '2025-10-21T15:21:13Z' ),
                ),
            ),
            array(
                'slug'          => 'colombia-ea-decaf',
                'handle'        => 'colombia-ea-decaf',
                'title'         => 'Colombia | EA Decaf',
                'price'         => '21.00',
                'price_display' => 'FROM $21.00',
                'type'          => array( 'decaf', 'single-origin' ),
                'process'       => array( 'Washed' ),
                'roast'         => array( 'Medium' ),
                'origins'       => 'Huila, Colombia',
                'notes'         => 'sweet maple, plum, cocoa powder',
                'menu_order'    => 8,
                'content'       => '<div>
<div><span>The Sugarcane Process gets its name because ethyl acetate, or EA, is derived from fermented sugarcane.</span></div>
<div>
<span></span><br>
</div>
<div><span>Ethyl acetate is a naturally occurring ester (present in bananas and also as a by-product of fermented sugars) that is used as a solvent to bond with and gently remove caffeine from green coffee. </span></div>
<div>
<span></span><br>
</div>
<div><span>First, the coffee is sorted and steamed for 30 minutes under low pressure in order to open the coffee seeds’ pores and prepare them for decaffeination. </span></div>
<div>
<span></span><br>
</div>
<div><span>The coffee is placed in a solution of both water and ethyl acetate, where the E.A. will begin to bond with the salts of chlorogenic acids inside the seeds. The tank will be drained and re-filled over the course of eight hours until caffeine is no longer detected.</span></div>
<div>
<span></span><br>
</div>
<div>
<span>The coffee beans are then dried and polished before being sent to us for roasting.</span><br><br><strong>We taste: milk chocolate, hazelnut, &amp; red apple</strong><br><strong><em><br></em></strong><strong>Country</strong>: Colombia<br><strong>Region:<span> </span></strong>Huila<br><strong>Community:</strong><br><strong>Variety</strong>: Castillo, Caturra, Colombia<br><strong>Process:</strong><span> Sugarcane</span><br><strong>Elevation</strong>: 1,400 - 2,000 Meters Above Sea Level (MASL)</div>
</div>
<div><br></div>',
                'image'         => 'DSC04901.jpg',
                'gallery'       => array( 'ColombiaEADecaf.png' ),
                'reviews'       => array(
                ),
            ),
            array(
                'slug'          => 'the-home-barista',
                'handle'        => 'the-home-barista',
                'title'         => 'The Home Barista',
                'price'         => '46.00',
                'price_display' => '$46.00',
                'type'          => array( 'blend' ),
                'process'       => array( 'Washed & Natural' ),
                'roast'         => array( 'Light' ),
                'origins'       => 'Curated Espresso Pair',
                'notes'         => 'Two 12oz bags curated for the home espresso and milk drinks lover',
                'menu_order'    => 9,
                'content'       => '<div>
<meta charset="utf-8"> <span>Enjoy the two espresso offerings currently available at our cafes at home. Our signature Blacksmith espresso and our seasonal espresso. Crafted to pull a beautiful shot for all of our baristas at home.</span>
</div>',
                'image'         => 'DSC00655.jpg',
                'gallery'       => array(),
                'reviews'       => array(
                ),
            ),
            array(
                'slug'          => 'guatemala-quetzal',
                'handle'        => 'guatemala-quetzal',
                'title'         => 'Guatemala | Quetzal',
                'price'         => '26.00',
                'price_display' => 'FROM $26.00',
                'type'          => array( 'single-origin' ),
                'process'       => array( 'Washed' ),
                'roast'         => array( 'Light' ),
                'origins'       => 'Huehuetenango, Guatemala',
                'notes'         => 'green apple, floral honey, milk chocolate',
                'menu_order'    => 10,
                'content'       => '<div>
<p>The Quetzal (the national bird of Guatemala) Program was born after the creation of “Regional Select - Waykan”, which was our way of highlighting the distinct regional differences we saw coming out of Guatemala. We heard from producers that they wanted to sell us more of their coffee, and Quetzal as a program allows us to buy more and pay more along the larger quality spectrum for high quality coffees from these hardworking men and women in Guatemala.</p>
<p>High-grown, hard-bean coffees from Guatemala are a staple offering for us as they are for many coffee roasters: The crisp acidity, full body, and toffee sweetness found in these coffees make them valuable as approachable and affordable single-origin brews, or as backbone blend components that layer nicely with more complex or fruitier complements.</p>
</div>
<div><span data-sheets-root="1"><strong>We\'re tasting molasses, pecan, &amp; red grape </strong></span></div>
<div>
<strong><em><br></em></strong><meta charset="utf-8">
<p><strong>Country</strong>: <meta charset="utf-8">Guatemala<br><strong>Region: </strong>Huehuetenango<br><strong>Harvest: </strong>December - May<br><strong>Variety</strong>: Bourbon, Catimor, Caturra, Maragogype, Pache<br><strong>Process:</strong> Washed<br><strong>Elevation</strong>: 1,400 - 2,200 Meters Above Sea Level (MASL)</p>
<br>
</div>',
                'image'         => 'DSC03717.jpg',
                'gallery'       => array( 'Quetzal_Coffee_Label.png', 'quetzal1.jpg' ),
                'reviews'       => array(
                ),
            ),
            array(
                'slug'          => 'guatemala-alma',
                'handle'        => 'guatemala-alma-2',
                'title'         => 'Guatemala | Alma',
                'price'         => '23.00',
                'price_display' => '$23.00',
                'type'          => array( 'single-origin' ),
                'process'       => array( 'Washed' ),
                'roast'         => array( 'Light' ),
                'origins'       => 'San Martin Jilotepeque, Guatemala',
                'notes'         => 'malt chocolate, date, pecan',
                'menu_order'    => 11,
                'content'       => '<div>
<div>
<p>For three generations, the producers behind Alma have grown coffee in the highlands of Huehuetenango. Over the past twenty years, they have expanded to partner with other producing families, cooperatives, and associations across Guatemala. Their mission is to connect these families and their coffees with roasters around the world.</p>
<p>Their sustainable sourcing approach is similar to their strategy as farmers and sellers: everything has a home. From 88+ Cup of Excellence submissions to 82-point mill-outs and final picks sold to local consolidators, there is value at every level. Alma brings together bright, fruit-forward coffees scoring 84.5 and above, coffees with a lot of soul, from vendor partners across Guatemala, from Huehuetenango to Jalapa. A Guatemala-based quality-control team meticulously selects each coffee to create a consistent, clean, and lightly fruity blend. “La Alma” means “the soul,” and this blend is intended to bring vitality and warmth to an espresso or house coffee.</p>
<p>For every pound of Alma sold, $0.05 goes directly to Habitat for Humanity Guatemala in support of its Smokeless Stove Program. These clean stoves benefit families for decades by improving indoor air quality and wood-fuel efficiency while reducing cooking time. Sales of Alma from the 2021 harvest alone provided 42 families with new stoves. Future plans include investing in home-building trips at origin with volunteers from every link in the coffee value chain.<br></p>
<br><br><strong>We taste: malt chocolate, date, pecan</strong><br><strong><em><br></em></strong><strong>Country</strong>: Guatemala<br><strong>Region:<span> </span></strong>Huehuetenango<br><strong>Varieties</strong>: <meta charset="utf-8">Bourbon, Caturra, Pache<br><strong>Process:</strong><span> Washed</span><br><strong>Elevation</strong>: 1,400 - 1,600 Meters Above Sea Level (MASL)</div>
</div>
<div><br></div>',
                'image'         => 'DSC05208.jpg',
                'gallery'       => array( 'AlmaCoffeeLabel.png', '13DB14F3-47B4-420F-8A56-B42C84419ACB.jpg', 'ALMA_-_Smokeless_stove_Habit_2.jpg', 'L1120335.jpg' ),
                'reviews'       => array(
                ),
            ),
            array(
                'slug'          => 'colombia-el-paraiso',
                'handle'        => 'colombia-el-paraiso-3',
                'title'         => 'Colombia | El Paraiso',
                'price'         => '26.00',
                'price_display' => 'FROM $26.00',
                'type'          => array( 'single-origin' ),
                'process'       => array( 'Honey' ),
                'roast'         => array( 'Medium' ),
                'origins'       => 'Cauca, Colombia',
                'notes'         => 'white peach, jasmine, meyer lemon, honey',
                'menu_order'    => 12,
                'content'       => '<div>
<p>Jose Ignacio Gomez’s farm is located in Vereda el Naranjal near the town of Buescao in the Nariño department. Paraiso’s Caturra and Colombia varieties of coffee grow at altitudes of 1900 meters above sea level and see an average rainfall of 1800mm per year. Jose grew up in a coffee producing family and has developed a good palate and an eye for good coffee. He grows coffee on six and a half hectares alongside oranges, lemons, and avocados. During the harvest, he, his family and team of trained harvesters hand pick the ripe red cherry and process the harvest in their own micro wet mill on the farm.</p>
<p>Several years ago, Jose Ignacio built a custom solar dryer on the farm near the wet mill. Three tiers of raised drying beds are arranged under the plastic roof, which allows light to enter and the farm’s crosswinds to control the temperature by passing through the open ends of the dryer. Jose oriented the dryer precisely to use the crosswinds for this temperature control purpose.</p>
<p>When coffee is first harvested, in the case of Naturals, or dried, in the case of Honey and Washed lots, it is placed on the lowest bed. As it dries, it is moved to the top tier, where it remains until it reaches the desired humidity and is ready to be transferred to the bodega storage area for a period of rest prior to export known as reposo, when all the flavors that will be perceived in the cup stabilize. Carlos Alberto is Finca El Paraiso’s farm manager and a childhood friend of Jose’s. Carlos is in charge of monitoring the drying process and moving the coffees between tiers as the drying process progresses.</p>
<p>Jose is always looking to experiment and improve production, so he was eager to try planting Geisha trees on his property, as several of his colleagues have done. Nestled among the other varietals, Paraiso’s Geisha trees are part of the farm’s greater ecosystem and part of Jose’s ongoing trials to measure the success of different kinds of coffee, both in terms of agronomic performance (yield, pest and plague resistance) and in terms of appeal to final roaster clients, both in variety and process.</p>
</div>
<div><span><strong>We\'re tasting dark honey, nougat, &amp; stone fruit.</strong></span></div>
<div>
<strong><em><br></em></strong><meta charset="utf-8">
<p><strong>Country</strong>: <meta charset="utf-8">Colombia<br><strong>Region: </strong>Nariño<br><strong>Producer: </strong>Jose Ignacio Gomez<br><strong>Varietal</strong>: Castillo, Caturra, Colombia<br><strong>Process:</strong> Honey<br><strong>Elevation</strong>: 1,900 Meters Above Sea Level (MASL)</p>
<br>
</div>',
                'image'         => 'DSC05126.jpg',
                'gallery'       => array( 'paraisoproductFeatured.jpg', 'RetailLabelQ32025.png', 'Paraiso-honey-2-of-2.jpg' ),
                'reviews'       => array(
                ),
            ),
            array(
                'slug'          => 'sunrise-sunset',
                'handle'        => 'sunrise-sunset',
                'title'         => 'Sunrise & Sunset',
                'price'         => '44.00',
                'price_display' => '$44.00',
                'type'          => array( 'blend' ),
                'process'       => array( 'Washed & Natural' ),
                'roast'         => array( 'Medium' ),
                'origins'       => 'Light & Dark Roast Pairing',
                'notes'         => 'Sunrise light roast blend + Sunset dark roast blend pairing',
                'menu_order'    => 13,
                'content'       => '<p>An evening coffee just hits different, but sometimes you need decaf when it’s late in the day. This subscription plan ships with our Decaf de Caña and our signature house blend Inkwell.</p>',
                'image'         => 'DSC00650.jpg',
                'gallery'       => array(),
                'reviews'       => array(
                ),
            ),
        );

        foreach ( $products_data as $item ) {
            $existing = get_page_by_path( $item['slug'], OBJECT, 'product' );
            if ( ! $existing && ! empty( $item['handle'] ) ) {
                $existing = get_page_by_path( $item['handle'], OBJECT, 'product' );
            }

            $product_id = 0;
            if ( ! $existing ) {
                $product_id = wp_insert_post( array(
                    'post_title'     => $item['title'],
                    'post_name'      => $item['slug'],
                    'post_content'   => $item['content'],
                    'post_excerpt'   => 'Tasting Notes: ' . $item['notes'],
                    'post_status'    => 'publish',
                    'post_type'      => 'product',
                    'menu_order'     => $item['menu_order'],
                    'comment_status' => 'open',
                ) );
            } else {
                $product_id = $existing->ID;
                wp_update_post( array(
                    'ID'           => $product_id,
                    'post_title'   => $item['title'],
                    'post_content' => $item['content'],
                    'post_excerpt' => 'Tasting Notes: ' . $item['notes'],
                    'menu_order'   => $item['menu_order'],
                    'comment_status' => 'open',
                ) );
            }

            if ( ! is_wp_error( $product_id ) && $product_id > 0 ) {
                update_post_meta( $product_id, '_price', $item['price'] );
                update_post_meta( $product_id, '_regular_price', $item['price'] );
                update_post_meta( $product_id, '_price_display', $item['price_display'] );
                update_post_meta( $product_id, '_stock_status', 'instock' );
                update_post_meta( $product_id, '_manage_stock', 'no' );
                update_post_meta( $product_id, '_visibility', 'visible' );

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
                if ( isset( $item['subtitle'] ) ) {
                    update_post_meta( $product_id, '_coffee_subtitle', sanitize_text_field( $item['subtitle'] ) );
                }
                update_post_meta( $product_id, '_coffee_origins', $item['origins'] );
                update_post_meta( $product_id, '_coffee_image', $item['image'] );
                update_post_meta( $product_id, '_coffee_gallery', $item['gallery'] );

                if ( $term_id > 0 ) {
                    wp_set_object_terms( $product_id, array( $term_id ), self::TAXONOMY, true );
                }
                wp_set_object_terms( $product_id, 'simple', 'product_type', false );

                // Seed authentic reviews into wp_comments
                if ( ! empty( $item['reviews'] ) && is_array( $item['reviews'] ) ) {
                    $existing_reviews = get_comments( array(
                        'post_id' => $product_id,
                        'type'    => 'review',
                        'count'   => true,
                    ) );

                    if ( $existing_reviews == 0 ) {
                        $total_stars = 0;
                        $rev_count   = 0;

                        foreach ( $item['reviews'] as $rev ) {
                            $rating = isset( $rev['rating'] ) ? (int) $rev['rating'] : 5;
                            $author = ! empty( $rev['author'] ) ? sanitize_text_field( $rev['author'] ) : 'Coffee Lover';
                            $content = ! empty( $rev['content'] ) ? sanitize_textarea_field( $rev['content'] ) : 'Great coffee!';
                            $date = ! empty( $rev['date'] ) ? sanitize_text_field( $rev['date'] ) : current_time( 'mysql' );

                            $comment_id = wp_insert_comment( array(
                                'comment_post_ID'      => $product_id,
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
                        update_post_meta( $product_id, '_wc_average_rating', number_format( $avg, 1, '.', '' ) );
                        update_post_meta( $product_id, '_wc_review_count', $rev_count );
                    }
                }
            }
        }
    }

    public static function get_products_query( $tab = array(), $process = array(), $roast = array(), $sort_by = 'best-selling' ) {
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 50,
            'post__not_in'   => array( 88, 90, 92 ),
            'tax_query'      => array(
                array(
                    'taxonomy' => self::TAXONOMY,
                    'field'    => 'slug',
                    'terms'    => self::CATEGORY_SLUG,
                ),
            ),
        );

        $meta_queries = array();

        $to_array = function( $val ) {
            if ( is_array( $val ) ) {
                return array_filter( array_map( 'sanitize_text_field', $val ) );
            }
            if ( is_string( $val ) && ! empty( $val ) ) {
                return array( sanitize_text_field( $val ) );
            }
            return array();
        };

        $tab     = $to_array( $tab );
        $process = $to_array( $process );
        $roast   = $to_array( $roast );

        if ( ! empty( $tab ) ) {
            $tab_or = array( 'relation' => 'OR' );
            foreach ( $tab as $t ) {
                $tab_or[] = array(
                    'key'     => '_coffee_type',
                    'value'   => $t,
                    'compare' => '=',
                );
            }
            $meta_queries[] = $tab_or;
        }

        if ( ! empty( $process ) ) {
            $proc_or = array( 'relation' => 'OR' );
            foreach ( $process as $p ) {
                $proc_or[] = array(
                    'key'     => '_coffee_process',
                    'value'   => $p,
                    'compare' => '=',
                );
            }
            $meta_queries[] = $proc_or;
        }

        if ( ! empty( $roast ) ) {
            $roast_or = array( 'relation' => 'OR' );
            foreach ( $roast as $r ) {
                $roast_or[] = array(
                    'key'     => '_coffee_roast',
                    'value'   => $r,
                    'compare' => '=',
                );
            }
            $meta_queries[] = $roast_or;
        }

        if ( ! empty( $meta_queries ) ) {
            $args['meta_query'] = array_merge( array( 'relation' => 'AND' ), $meta_queries );
        }

        switch ( $sort_by ) {
            case 'price-ascending':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order']    = 'ASC';
                break;
            case 'price-descending':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_price';
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
            case 'created-ascending':
                $args['orderby'] = 'date';
                $args['order']   = 'ASC';
                break;
            case 'best-selling':
            case 'manual':
            default:
                $args['orderby'] = array(
                    'menu_order' => 'ASC',
                    'title'      => 'ASC',
                );
                break;
        }

        return new WP_Query( $args );
    }
    public static function render_coffee_card( $product_id ) {
        static $mem_cache = array();
        if ( isset( $mem_cache[ $product_id ] ) ) {
            echo $mem_cache[ $product_id ];
            return;
        }

        $cache_key = 'quills_card_html_' . $product_id;
        $cached    = get_transient( $cache_key );
        if ( false !== $cached && ! empty( $cached ) ) {
            $mem_cache[ $product_id ] = $cached;
            echo $cached;
            return;
        }

        ob_start();
        $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : null;
        if ( ! $product ) {
            $post = get_post( $product_id );
            if ( ! $post ) return;
            $title         = $post->post_title;
            $permalink     = get_permalink( $product_id );
            $raw_meta      = get_post_meta( $product_id, '_price_display', true );
            $price_display = ! empty( $raw_meta ) ? wp_strip_all_tags( $raw_meta ) : '$20.00';
        } else {
            $title         = $product->get_name();
            $permalink     = get_permalink( $product_id );
            $raw_meta      = get_post_meta( $product_id, '_price_display', true );
            if ( ! empty( $raw_meta ) ) {
                $price_display = wp_strip_all_tags( $raw_meta );
            } else {
                $price_val = (float) $product->get_price();
                $price_display = ( $price_val > 0 ) ? ( 'FROM $' . number_format( $price_val, 2 ) ) : 'FROM $20.00';
            }
        }

        $img_url       = self::get_product_image_url( $product_id );
        $review_count  = (int) get_post_meta( $product_id, '_wc_review_count', true );
        if ( $review_count === 0 ) {
            $review_count = (int) get_comments( array( 'post_id' => $product_id, 'type' => 'review', 'count' => true ) );
        }
        $avg_rating    = (float) get_post_meta( $product_id, '_wc_average_rating', true );
        $rating_round  = $avg_rating > 0 ? (int) round( $avg_rating ) : ( $review_count > 0 ? 5 : 0 );

        $tasting_notes = get_post_meta( $product_id, '_coffee_tasting_notes', true );
        $subtitle      = get_post_meta( $product_id, '_coffee_subtitle', true );
        $process_raw   = get_post_meta( $product_id, '_coffee_process', true );
        if ( is_array( $process_raw ) ) {
            $process_str = implode( ' & ', $process_raw );
        } else {
            $process_str = (string) $process_raw;
        }
        $origins       = get_post_meta( $product_id, '_coffee_origins', true );

        $product_slug    = get_post_field( 'post_name', $product_id );
        $raw_custom_desc = '';

        // Brand tasting notes and subtitles fallback only if not set in database
        if ( empty( $tasting_notes ) ) {
            if ( strpos( $title, 'Inkwell' ) !== false || strpos( $product_slug, 'inkwell' ) !== false ) {
                $tasting_notes = 'Graham cracker, cooked cherries, vanilla';
            } elseif ( strpos( $title, 'Blacksmith' ) !== false || strpos( $product_slug, 'blacksmith' ) !== false ) {
                $tasting_notes = "Baker's chocolate, blueberries, hazelnut";
            } elseif ( strpos( $title, 'Southern Gothic' ) !== false || strpos( $product_slug, 'southern-gothic' ) !== false ) {
                $tasting_notes = 'Chocolate, caramel, well-balanced.';
            }
        }
        if ( empty( $subtitle ) ) {
            if ( strpos( $title, 'Inkwell' ) !== false || strpos( $product_slug, 'inkwell' ) !== false ) {
                $subtitle = 'Our Signature House Blend';
            } elseif ( strpos( $title, 'Blacksmith' ) !== false || strpos( $product_slug, 'blacksmith' ) !== false ) {
                $subtitle = 'Our Signature Espresso';
            }
        }
        if ( empty( $process_str ) ) {
            if ( strpos( $title, 'Inkwell' ) !== false || strpos( $product_slug, 'inkwell' ) !== false || strpos( $title, 'Blacksmith' ) !== false || strpos( $product_slug, 'blacksmith' ) !== false ) {
                $process_str = 'Washed & Natural';
            }
        }
        if ( empty( $origins ) ) {
            if ( strpos( $title, 'Inkwell' ) !== false || strpos( $product_slug, 'inkwell' ) !== false ) {
                $origins = 'Colombia, Guatemala, Ethiopia';
            } elseif ( strpos( $title, 'Blacksmith' ) !== false || strpos( $product_slug, 'blacksmith' ) !== false ) {
                $origins = 'Colombia, Nicaragua, Ethiopia';
            }
        }
        if ( strpos( $title, 'Bit of Both' ) !== false || strpos( $product_slug, 'bit-of-both' ) !== false ) {
            $raw_custom_desc = 'Our house blend Inkwell and the current seasonal coffee.';
        } elseif ( strpos( $title, 'The Home Barista' ) !== false || strpos( $product_slug, 'home-barista' ) !== false ) {
            $raw_custom_desc = 'Our signature Blacksmith espresso and our seasonal espresso.';
        } elseif ( strpos( $title, 'Sunrise' ) !== false || strpos( $product_slug, 'sunrise' ) !== false ) {
            $raw_custom_desc = 'Our signature house blend Inkwell and Decaf de Caña.';
        }
        ?>
        <article class="quills-coffee-card" data-product-id="<?php echo esc_attr( $product_id ); ?>">
            <div class="quills-coffee-card-media">
                <a href="<?php echo esc_url( $permalink ); ?>" class="quills-coffee-card-link" aria-label="<?php echo esc_attr( $title ); ?>">
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="quills-coffee-card-img" loading="lazy" />
                </a>
                <div class="rollover_inner" data-permalink="<?php echo esc_url( $permalink ); ?>">
                    <div class="rollover_wrapper">
                        <a href="<?php echo esc_url( $permalink ); ?>" class="rollover_link_overlay" aria-label="<?php echo esc_attr( $title ); ?>">
                            <div class="rollover_top">
                                <span class="collection_name"></span>
                                <h4 class="prod_title"><?php echo esc_html( $title ); ?></h4>
                            </div>
                            <div class="rollover_content">
                                <div class="rte">
                                    <div class="metafield-rich_text_field">
                                        <?php if ( ! empty( $raw_custom_desc ) ) : ?>
                                            <p><?php echo esc_html( $raw_custom_desc ); ?></p>
                                        <?php elseif ( ! empty( $tasting_notes ) ) : ?>
                                            <p><em><strong><?php echo esc_html( $tasting_notes ); ?><br /><br /></strong></em>
                                            <?php if ( ! empty( $subtitle ) ) : ?>
                                                <strong><?php echo esc_html( $subtitle ); ?><br /></strong>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $process_str ) ) : ?>
                                                <strong>Process: </strong><?php echo esc_html( $process_str ); ?><br />
                                            <?php endif; ?>
                                            <?php if ( ! empty( $origins ) ) : ?>
                                                <strong>Origins: </strong><?php echo esc_html( $origins ); ?>
                                            <?php endif; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <p class="rollover_short"></p>
                            </div>
                        </a>
                        <div class="rollover_bottom">
                            <button type="button" class="quills-hover-add-cart" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-permalink="<?php echo esc_url( $permalink ); ?>" aria-label="Add <?php echo esc_attr( $title ); ?> to cart">ADD TO CART</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="quills-coffee-card-content">
                <h3 class="quills-coffee-card-title">
                    <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
                </h3>
                <div class="quills-coffee-card-rating">
                    <span class="quills-stars">
                        <?php
                        for ( $i = 1; $i <= 5; $i++ ) {
                            if ( $review_count > 0 && $i <= $rating_round ) {
                                echo '<span class="quills-star--filled">★</span>';
                            } else {
                                echo '<span class="quills-star--empty">☆</span>';
                            }
                        }
                        ?>
                    </span>
                    <span class="quills-review-count">
                        <?php echo ( $review_count > 0 ) ? '(' . esc_html( $review_count ) . ' reviews)' : '(No reviews)'; ?>
                    </span>
                </div>
                <div class="quills-coffee-card-price"><?php echo esc_html( $price_display ); ?></div>
            </div>
        </article>
        <?php
        $card_html = ob_get_clean();
        set_transient( $cache_key, $card_html, 12 * HOUR_IN_SECONDS );
        $mem_cache[ $product_id ] = $card_html;
        echo $card_html;
    }


    public static function ajax_filter_coffee() {
        $tab     = isset( $_POST['tab'] ) ? (array) $_POST['tab'] : array();
        $process = isset( $_POST['process'] ) ? (array) $_POST['process'] : array();
        $roast   = isset( $_POST['roast'] ) ? (array) $_POST['roast'] : array();
        $sort_by = isset( $_POST['sort_by'] ) ? sanitize_text_field( wp_unslash( $_POST['sort_by'] ) ) : 'best-selling';

        $query = self::get_products_query( $tab, $process, $roast, $sort_by );

        ob_start();
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                self::render_coffee_card( get_the_ID() );
            }
            wp_reset_postdata();
        } else {
            ?>
            <div class="quills-no-products">
                <p>No coffees match the selected criteria.</p>
            </div>
            <?php
        }
        $html = ob_get_clean();

        wp_send_json_success( array(
            'html'  => $html,
            'count' => $query->found_posts,
        ) );
    }
}

Coffee_Cafe_Corner_Coffee_DB::init();
