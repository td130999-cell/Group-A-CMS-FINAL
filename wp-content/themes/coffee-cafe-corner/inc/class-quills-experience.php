<?php
/**
 * Quills Coffee Experience Engine
 * Replicating Quills Coffee (Reviews, Faceted Filters, Single Product Page)
 */

if (!defined('ABSPATH')) {
    exit;
}

class Quills_Coffee_Experience {

    public static function init() {
        add_action('after_setup_theme', [__CLASS__, 'setup_woocommerce']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets'], 20);
        
        // Rewrite rules for product pages
        add_action('init', [__CLASS__, 'register_rewrites']);
        add_filter('query_vars', [__CLASS__, 'register_query_vars']);
        add_filter('request', [__CLASS__, 'map_product_request']);

        // AJAX endpoints
        add_action('wp_ajax_quills_filter_products', [__CLASS__, 'ajax_filter_products']);
        add_action('wp_ajax_nopriv_quills_filter_products', [__CLASS__, 'ajax_filter_products']);

        add_action('wp_ajax_quills_submit_review', [__CLASS__, 'ajax_submit_review']);
        add_action('wp_ajax_nopriv_quills_submit_review', [__CLASS__, 'ajax_submit_review']);

        add_action('wp_ajax_quills_vote_review', [__CLASS__, 'ajax_vote_review']);
        add_action('wp_ajax_nopriv_quills_vote_review', [__CLASS__, 'ajax_vote_review']);

        add_action('wp_ajax_quills_add_to_cart', [__CLASS__, 'ajax_add_to_cart']);
        add_action('wp_ajax_nopriv_quills_add_to_cart', [__CLASS__, 'ajax_add_to_cart']);

        // Cart Drawer endpoints
        add_action('wp_ajax_quills_get_cart_drawer', [__CLASS__, 'ajax_get_cart_drawer']);
        add_action('wp_ajax_nopriv_quills_get_cart_drawer', [__CLASS__, 'ajax_get_cart_drawer']);

        // Quick Shop Drawer endpoints (Image 2)
        add_action('wp_ajax_quills_get_quick_shop_drawer', [__CLASS__, 'ajax_get_quick_shop_drawer']);
        add_action('wp_ajax_nopriv_quills_get_quick_shop_drawer', [__CLASS__, 'ajax_get_quick_shop_drawer']);

        add_action('wp_ajax_quills_update_cart_qty', [__CLASS__, 'ajax_update_cart_qty']);
        add_action('wp_ajax_nopriv_quills_update_cart_qty', [__CLASS__, 'ajax_update_cart_qty']);

        add_action('wp_ajax_quills_remove_cart_item', [__CLASS__, 'ajax_remove_cart_item']);
        add_action('wp_ajax_nopriv_quills_remove_cart_item', [__CLASS__, 'ajax_remove_cart_item']);

        // Custom cart pricing & options session hooks (for subscriptions & variants)
        add_filter('woocommerce_get_cart_item_from_session', [__CLASS__, 'get_cart_item_from_session'], 20, 2);
        add_action('woocommerce_before_calculate_totals', [__CLASS__, 'apply_custom_cart_item_prices'], 20, 1);
        add_filter('woocommerce_get_item_data', [__CLASS__, 'display_cart_item_custom_data'], 10, 2);

        add_action('wp_footer', [__CLASS__, 'render_cart_drawer_container'], 100);

        // Template loaders
        add_filter('template_include', [__CLASS__, 'override_templates'], 99);
    }

    public static function register_rewrites() {
        add_rewrite_rule('^product/([^/]+)/?$', 'index.php?product=$matches[1]', 'top');
        add_rewrite_rule('^collections/coffee/products/([^/]+)/?$', 'index.php?product=$matches[1]', 'top');
        add_rewrite_rule('^products/([^/]+)/?$', 'index.php?product=$matches[1]', 'top');

        if (!get_option('quills_experience_rewrites_flushed_v3')) {
            flush_rewrite_rules(false);
            update_option('quills_experience_rewrites_flushed_v3', 1);
        }
    }

    public static function register_query_vars($vars) {
        $vars[] = 'product';
        return $vars;
    }

    public static function map_product_request($query_vars) {
        if (!empty($query_vars['product'])) {
            $slug = sanitize_title($query_vars['product']);
            $alias_map = [
                'blacksmith-espresso'  => 'blacksmith-espresso-blend',
                'inkwell-blend'        => 'inkwell-signature-blend',
                'inkwell-house-blend'  => 'inkwell-signature-blend',
                'southern-gothic'      => 'southern-gothic-cold-brew',
                'southern-gothic-12oz' => 'southern-gothic-cold-brew',
            ];
            if (isset($alias_map[$slug])) {
                $slug = $alias_map[$slug];
            }
            $query_vars['post_type'] = 'product';
            $query_vars['name']      = $slug;
            $query_vars['product']   = $slug;
        }
        return $query_vars;
    }

    public static function setup_woocommerce() {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }

    public static function enqueue_assets() {
        // Enqueue Quills Fonts
        wp_enqueue_style(
            'quills-google-fonts',
            'https://fonts.googleapis.com/css2?family=Besley:ital,wght@0,400;0,600;0,700;1,400&family=Barlow+Condensed:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap',
            [],
            null
        );

        // Quills CSS
        wp_enqueue_style(
            'quills-coffee-style',
            get_template_directory_uri() . '/assets/css/quills-coffee.css',
            [],
            '1.1.6'
        );

        // Quills JS
        wp_enqueue_script(
            'quills-coffee-script',
            get_template_directory_uri() . '/assets/js/quills-coffee.js',
            ['jquery'],
            '1.1.5',
            true
        );

        wp_localize_script('quills-coffee-script', 'quillsData', [
            'ajaxUrl'   => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('quills_nonce'),
            'cartUrl'   => wc_get_cart_url(),
            'siteUrl'   => home_url(),
            'shopUrl'   => wc_get_page_permalink('shop')
        ]);
    }

    public static function override_templates($template) {
        if (is_product() || is_singular('product') || !empty(get_query_var('product'))) {
            $custom = get_template_directory() . '/woocommerce/single-product.php';
            if (file_exists($custom)) {
                return $custom;
            }
        }
        if (is_shop() || is_product_taxonomy()) {
            $custom = get_template_directory() . '/woocommerce/archive-product.php';
            if (file_exists($custom)) {
                return $custom;
            }
        }
        return $template;
    }

    /**
     * AJAX Filter Products (Roast, Process, Type, Price, Sort)
     */
    public static function ajax_filter_products() {
        check_ajax_referer('quills_nonce', 'nonce');

        $processes    = isset($_POST['processes']) ? array_map('sanitize_text_field', (array)$_POST['processes']) : [];
        $roasts       = isset($_POST['roasts']) ? array_map('sanitize_text_field', (array)$_POST['roasts']) : [];
        $types        = isset($_POST['types']) ? array_map('sanitize_text_field', (array)$_POST['types']) : [];
        $price_ranges = isset($_POST['prices']) ? array_map('sanitize_text_field', (array)$_POST['prices']) : [];
        $orderby      = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'menu_order';

        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => ['relation' => 'AND']
        ];

        if (!empty($processes)) {
            $args['meta_query'][] = [
                'key'     => '_quills_process',
                'value'   => $processes,
                'compare' => 'IN'
            ];
        }

        if (!empty($roasts)) {
            $args['meta_query'][] = [
                'key'     => '_quills_roast_profile',
                'value'   => $roasts,
                'compare' => 'IN'
            ];
        }

        if (!empty($types)) {
            $args['meta_query'][] = [
                'key'     => '_quills_coffee_type',
                'value'   => $types,
                'compare' => 'IN'
            ];
        }

        // Sorting
        switch ($orderby) {
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
            default:
                $args['orderby'] = 'date';
                $args['order']   = 'DESC';
        }

        $query = new WP_Query($args);
        $filtered_posts = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product = wc_get_product(get_the_ID());
                $price = (float)$product->get_price();

                // Client price filter check
                if (!empty($price_ranges)) {
                    $matched_price = false;
                    foreach ($price_ranges as $pr) {
                        if ($pr === 'under-21' && $price < 21) $matched_price = true;
                        if ($pr === '21-23' && $price >= 21 && $price <= 23) $matched_price = true;
                        if ($pr === 'over-23' && $price > 23) $matched_price = true;
                    }
                    if (!$matched_price) {
                        continue;
                    }
                }

                $filtered_posts[] = $product;
            }
            wp_reset_postdata();
        }

        ob_start();
        if (!empty($filtered_posts)) {
            foreach ($filtered_posts as $prod) {
                self::render_product_card($prod);
            }
        } else {
            echo '<div class="quills-no-products">';
            echo '<p>No coffees match your selected filters.</p>';
            echo '<button class="quills-reset-filters-btn" id="quills-clear-all-empty">Clear All Filters</button>';
            echo '</div>';
        }
        $html = ob_get_clean();

        wp_send_json_success([
            'html'  => $html,
            'count' => count($filtered_posts)
        ]);
    }

    /**
     * Render Quills Coffee Product Card
     */
    public static function render_product_card($product) {
        $id = $product->get_id();
        $title = $product->get_name();
        $permalink = $product->get_permalink();
        $price = wc_price($product->get_price());
        $main_img_url = wp_get_attachment_image_url($product->get_image_id(), 'large') ?: wc_placeholder_img_src();
        
        $sec_img_id = get_post_meta($id, '_quills_secondary_image_id', true);
        $sec_img_url = $sec_img_id ? wp_get_attachment_image_url($sec_img_id, 'large') : $main_img_url;
        
        $tasting_notes = get_post_meta($id, '_quills_tasting_notes', true);
        $roast = get_post_meta($id, '_quills_roast_profile', true);
        $process = get_post_meta($id, '_quills_process', true);
        $type = get_post_meta($id, '_quills_coffee_type', true);

        $rating = $product->get_average_rating() ?: 5.0;
        $review_count = $product->get_review_count() ?: 3;
        ?>
        <div class="quills-product-card" data-id="<?php echo esc_attr($id); ?>" data-roast="<?php echo esc_attr($roast); ?>" data-process="<?php echo esc_attr($process); ?>" data-type="<?php echo esc_attr($type); ?>">
            <a href="<?php echo esc_url($permalink); ?>" class="quills-card-media-wrapper">
                <div class="quills-card-image-box">
                    <img src="<?php echo esc_url($main_img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="quills-card-img quills-card-img--primary" loading="lazy">
                    <img src="<?php echo esc_url($sec_img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="quills-card-img quills-card-img--secondary" loading="lazy">
                </div>
                <?php if ($roast): ?>
                    <span class="quills-card-roast-badge"><?php echo esc_html($roast); ?> Roast</span>
                <?php endif; ?>
            </a>

            <div class="quills-card-info">
                <?php if ($tasting_notes): ?>
                    <div class="quills-card-tasting-notes">
                        <?php echo esc_html(ucwords($tasting_notes)); ?>
                    </div>
                <?php endif; ?>

                <h3 class="quills-card-title">
                    <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
                </h3>

                <div class="quills-card-rating">
                    <span class="quills-stars">★★★★★</span>
                    <span class="quills-rating-count">(<?php echo esc_html($review_count); ?>)</span>
                </div>

                <div class="quills-card-price">
                    <?php echo $price; ?>
                </div>

                <div class="quills-card-actions">
                    <a href="<?php echo esc_url($permalink); ?>" class="quills-card-quick-buy">
                        SELECT OPTIONS
                    </a>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * AJAX Submit Review
     */
    public static function ajax_submit_review() {
        check_ajax_referer('quills_nonce', 'nonce');

        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $rating     = isset($_POST['rating']) ? min(5, max(1, absint($_POST['rating']))) : 5;
        $title      = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $content    = isset($_POST['content']) ? sanitize_textarea_field($_POST['content']) : '';
        $author     = isset($_POST['author']) ? sanitize_text_field($_POST['author']) : 'Anonymous Coffee Lover';
        $email      = isset($_POST['email']) ? sanitize_email($_POST['email']) : 'user@example.com';
        $brew       = isset($_POST['brew_method']) ? sanitize_text_field($_POST['brew_method']) : 'Pour Over';

        if (!$product_id || empty($content)) {
            wp_send_json_error(['message' => 'Please fill in all required fields.']);
        }

        $full_comment = "<strong>" . esc_html($title) . "</strong>\n\n" . esc_html($content);

        $comment_id = wp_insert_comment([
            'comment_post_ID'      => $product_id,
            'comment_author'       => $author,
            'comment_author_email' => $email,
            'comment_content'      => $full_comment,
            'comment_type'         => 'review',
            'comment_approved'     => 1,
            'user_id'              => get_current_user_id()
        ]);

        if ($comment_id) {
            update_comment_meta($comment_id, 'rating', $rating);
            update_comment_meta($comment_id, 'verified', 1);
            update_comment_meta($comment_id, '_quills_review_title', $title);
            update_comment_meta($comment_id, '_quills_brew_method', $brew);
            update_comment_meta($comment_id, '_quills_helpful', 0);

            // Clear WC transient caches
            delete_transient('wc_average_rating_' . $product_id);

            wp_send_json_success([
                'message' => 'Thank you! Your review has been published.',
                'review_id' => $comment_id
            ]);
        }

        wp_send_json_error(['message' => 'Could not save review. Please try again.']);
    }

    /**
     * AJAX Vote Review Helpful
     */
    public static function ajax_vote_review() {
        check_ajax_referer('quills_nonce', 'nonce');
        $comment_id = isset($_POST['comment_id']) ? absint($_POST['comment_id']) : 0;
        if ($comment_id) {
            $votes = (int)get_comment_meta($comment_id, '_quills_helpful', true);
            $votes++;
            update_comment_meta($comment_id, '_quills_helpful', $votes);
            wp_send_json_success(['votes' => $votes]);
        }
        wp_send_json_error();
    }

    /**
     * Restore custom cart item data from session
     */
    public static function get_cart_item_from_session($cart_item, $values) {
        if (isset($values['quills_custom_price'])) {
            $cart_item['quills_custom_price'] = $values['quills_custom_price'];
        }
        if (isset($values['quills_options'])) {
            $cart_item['quills_options'] = $values['quills_options'];
        }
        return $cart_item;
    }

    /**
     * Recalculate price in cart based on custom options / subscribe discount
     */
    public static function apply_custom_cart_item_prices($cart) {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        static $calculating = false;
        if ($calculating) {
            return;
        }
        $calculating = true;

        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            if (isset($cart_item['quills_custom_price']) && is_numeric($cart_item['quills_custom_price'])) {
                $cart_item['data']->set_price((float)$cart_item['quills_custom_price']);
            }
        }

        $calculating = false;
    }

    /**
     * Display custom options in cart/checkout
     */
    public static function display_cart_item_custom_data($item_data, $cart_item) {
        if (!empty($cart_item['quills_options']) && is_array($cart_item['quills_options'])) {
            foreach ($cart_item['quills_options'] as $key => $val) {
                if (!empty($val)) {
                    $item_data[] = [
                        'key'   => $key,
                        'value' => $val,
                    ];
                }
            }
        }
        return $item_data;
    }

    /**
     * AJAX Add to Cart with Options & Cart Drawer Return
     */
    public static function ajax_add_to_cart() {
        check_ajax_referer('quills_nonce', 'nonce');
        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $quantity   = isset($_POST['quantity']) ? max(1, absint($_POST['quantity'])) : 1;
        $size       = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '';
        $grind      = isset($_POST['grind']) ? sanitize_text_field($_POST['grind']) : '';
        $purchase   = isset($_POST['purchase_type']) ? sanitize_text_field($_POST['purchase_type']) : 'onetime';
        $frequency  = isset($_POST['frequency']) ? sanitize_text_field($_POST['frequency']) : '';

        $product = wc_get_product($product_id);
        if (!$product) {
            wp_send_json_error(['message' => 'Product not found.']);
        }

        $base_price = (float)$product->get_price();
        if ($base_price <= 0) {
            $base_price = 20.00;
        }

        $is_brew_gear = has_term('brew-gear', 'product_cat', $product_id) || (bool)get_post_meta($product_id, '_brew_gear_image', true);
        $is_merch     = has_term('merch', 'product_cat', $product_id) || (bool)get_post_meta($product_id, '_merch_image', true);

        if ($is_brew_gear) {
            $unit_price = $base_price;
            $item_data  = [];
        } elseif ($is_merch) {
            $unit_price = $base_price;
            $item_data  = [];
            if (!empty($size)) {
                $item_data['Size'] = $size;
            }
        } else {
            // Calculate unit price according to Size
            if ($size === '5lb') {
                $unit_price = ($base_price == 20.00) ? 105.00 : ($base_price * 5.25);
            } elseif ($size === '2lb') {
                $unit_price = ($base_price == 20.00) ? 48.00 : ($base_price * 2.4);
            } else {
                $unit_price = $base_price;
            }

            // Apply 10% Discount for Subscribe
            if ($purchase === 'subscribe') {
                $unit_price = round($unit_price * 0.9, 2);
            }

            $item_data = [];
            if (!empty($size)) {
                $item_data['Size'] = $size;
            }
            if (!empty($grind)) {
                $item_data['Grind Type'] = $grind;
            }
            if ($purchase === 'subscribe') {
                $freq_text = !empty($frequency) ? $frequency : 'Deliver every 2 weeks';
                $item_data['Purchase Type'] = $freq_text;
                $item_data['is_subscription'] = true;
            } else {
                $item_data['Purchase Type'] = 'One-time Purchase';
                $item_data['is_subscription'] = false;
            }
        }

        $cart_item_data = [
            'quills_options'      => $item_data,
            'quills_custom_price' => $unit_price
        ];

        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, [], $cart_item_data);

        if ($cart_item_key) {
            WC()->cart->calculate_totals();
            wp_send_json_success([
                'cart_count'  => WC()->cart->get_cart_contents_count(),
                'cart_total'  => WC()->cart->get_cart_total(),
                'drawer_html' => self::render_cart_drawer_html(),
                'message'     => 'Added to cart successfully!'
            ]);
        } else {
            wp_send_json_error(['message' => 'Could not add to cart.']);
        }
    }

    /**
     * AJAX Get Cart Drawer HTML from Database
     */
    public static function ajax_get_cart_drawer() {
        check_ajax_referer('quills_nonce', 'nonce');
        $count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
        $total = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_total() : '$0.00';

        wp_send_json_success([
            'cart_count'  => $count,
            'cart_total'  => $total,
            'drawer_html' => self::render_cart_drawer_html()
        ]);
    }

    /**
     * AJAX Get Quick Shop Drawer HTML from Database (Image 2)
     */
    public static function ajax_get_quick_shop_drawer() {
        if (isset($_POST['nonce'])) {
            check_ajax_referer('quills_nonce', 'nonce', false);
        }
        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $product = function_exists('wc_get_product') ? wc_get_product($product_id) : null;
        if (!$product) {
            $post = get_post($product_id);
            if (!$post) {
                wp_send_json_error(['message' => 'Product not found.']);
            }
            $title = $post->post_title;
            $permalink = get_permalink($product_id);
            $base_price = (float) get_post_meta($product_id, '_price', true) ?: 20.00;
        } else {
            $title = $product->get_name();
            $permalink = get_permalink($product_id);
            $base_price = (float)$product->get_price();
            if ($base_price <= 0) $base_price = 20.00;
        }

        $formatted_price = function_exists('wc_price') ? wc_price($base_price) : '$' . number_format($base_price, 2);

        // Images from Database
        if (!class_exists('Coffee_Cafe_Corner_Coffee_DB')) {
            require_once get_template_directory() . '/inc/class-coffee-db.php';
        }
        $img_url = Coffee_Cafe_Corner_Coffee_DB::get_product_image_url($product_id);

        // Database Reviews
        $comments = get_comments([
            'post_id' => $product_id,
            'status'  => 'approve',
            'type'    => 'review'
        ]);
        $review_count = (int) get_post_meta($product_id, '_wc_review_count', true);
        if ($review_count === 0 && !empty($comments)) {
            $review_count = count($comments);
        }
        $avg_rating = (float) get_post_meta($product_id, '_wc_average_rating', true);
        if ($avg_rating <= 0 && $review_count > 0) {
            $sum = 0;
            foreach ($comments as $c) {
                $sum += (int) get_comment_meta($c->comment_ID, 'rating', true) ?: 5;
            }
            $avg_rating = round($sum / $review_count, 1);
        }
        $rating_round = $avg_rating > 0 ? (int) round($avg_rating) : ($review_count > 0 ? 5 : 0);

        // Sizes configuration
        $is_bundle = ($base_price >= 40.00);
        $sizes = $is_bundle ? ['Two 12oz Bags'] : ['12oz', '5lb', '2lb'];

        $grinds = [
            'Whole Bean',
            'Automatic Drip',
            'Espresso',
            'Aeropress',
            'Pour Over',
            'Chemex',
            'French Press / Cold Brew'
        ];

        ob_start();
        ?>
        <div class="quills-qs-wrapper" data-product-id="<?php echo esc_attr($product_id); ?>">
            <button type="button" class="quills-qs-close" id="quills-qs-close" aria-label="Close Quick Shop">✕</button>

            <div class="quills-qs-media">
                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="quills-qs-img" />
            </div>

            <div class="quills-qs-info">
                <h3 class="quills-qs-title"><?php echo esc_html($title); ?></h3>
                
                <div class="quills-qs-price" id="quills-qs-price"><?php echo $formatted_price; ?></div>

                <div class="quills-qs-rating">
                    <span class="quills-qs-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo ($review_count > 0 && $i <= $rating_round) ? 'filled' : 'empty'; ?>">★</span>
                        <?php endfor; ?>
                    </span>
                    <span class="quills-qs-review-count">
                        <?php echo ($review_count > 0) ? '(' . esc_html($review_count) . ' reviews)' : '(No reviews)'; ?>
                    </span>
                </div>

                <!-- Size Selector -->
                <div class="quills-qs-option-group" id="quills-qs-size-group">
                    <div class="quills-qs-option-label">Size: <span id="quills-qs-selected-size"><?php echo esc_html($sizes[0]); ?></span></div>
                    <div class="quills-qs-pills-row">
                        <?php foreach ($sizes as $idx => $s): ?>
                            <button type="button" class="quills-qs-pill quills-qs-size-pill <?php echo ($idx === 0) ? 'active' : ''; ?>" data-size="<?php echo esc_attr($s); ?>">
                                <?php echo esc_html($s); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Grind Type Selector -->
                <div class="quills-qs-option-group" id="quills-qs-grind-group">
                    <div class="quills-qs-option-label">Grind Type: <span id="quills-qs-selected-grind">Whole Bean</span></div>
                    <div class="quills-qs-pills-row quills-qs-grind-pills">
                        <?php foreach ($grinds as $idx => $g): ?>
                            <button type="button" class="quills-qs-pill quills-qs-grind-pill <?php echo ($idx === 0) ? 'active' : ''; ?>" data-grind="<?php echo esc_attr($g); ?>">
                                <?php echo esc_html($g); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Add to Cart Action Row -->
                <div class="quills-qs-actions-row">
                    <div class="quills-qs-qty-stepper">
                        <button type="button" class="quills-qs-qty-btn" id="quills-qs-qty-minus" aria-label="Decrease quantity">—</button>
                        <input type="number" class="quills-qs-qty-input" id="quills-qs-qty-input" value="1" min="1" readonly />
                        <button type="button" class="quills-qs-qty-btn" id="quills-qs-qty-plus" aria-label="Increase quantity">+</button>
                    </div>

                    <button type="button" class="quills-qs-btn-add" id="quills-qs-btn-add" data-product-id="<?php echo esc_attr($product_id); ?>" data-base-price="<?php echo esc_attr($base_price); ?>">
                        <span class="quills-qs-btn-text">ADD TO CART</span>
                    </button>
                </div>

                <!-- Buy with Shop Pay -->
                <button type="button" class="quills-qs-btn-shop" id="quills-qs-btn-shop" data-product-id="<?php echo esc_attr($product_id); ?>" data-checkout-url="<?php echo esc_url(function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/')); ?>">
                    <span>Buy with</span> <span class="quills-shop-brand">shop</span>
                </button>

                <!-- View all details -->
                <div class="quills-qs-details-link-wrap">
                    <a href="<?php echo esc_url($permalink); ?>" class="quills-qs-details-link">View all details</a>
                </div>
            </div>
        </div>
        <?php
        $html = ob_get_clean();

        wp_send_json_success([
            'html'       => $html,
            'product_id' => $product_id,
            'title'      => $title,
            'base_price' => $base_price
        ]);
    }

    /**
     * AJAX Update Cart Item Quantity
     */
    public static function ajax_update_cart_qty() {
        check_ajax_referer('quills_nonce', 'nonce');
        $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
        $quantity      = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($cart_item_key && function_exists('WC') && WC()->cart) {
            if ($quantity <= 0) {
                WC()->cart->remove_cart_item($cart_item_key);
            } else {
                WC()->cart->set_quantity($cart_item_key, $quantity, true);
            }
            WC()->cart->calculate_totals();

            wp_send_json_success([
                'cart_count'  => WC()->cart->get_cart_contents_count(),
                'cart_total'  => WC()->cart->get_cart_total(),
                'drawer_html' => self::render_cart_drawer_html(),
                'message'     => 'Cart updated successfully!'
            ]);
        }

        wp_send_json_error(['message' => 'Invalid cart item.']);
    }

    /**
     * AJAX Remove Cart Item
     */
    public static function ajax_remove_cart_item() {
        check_ajax_referer('quills_nonce', 'nonce');
        $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';

        if ($cart_item_key && function_exists('WC') && WC()->cart) {
            WC()->cart->remove_cart_item($cart_item_key);
            WC()->cart->calculate_totals();

            wp_send_json_success([
                'cart_count'  => WC()->cart->get_cart_contents_count(),
                'cart_total'  => WC()->cart->get_cart_total(),
                'drawer_html' => self::render_cart_drawer_html(),
                'message'     => 'Item removed from cart.'
            ]);
        }

        wp_send_json_error(['message' => 'Could not remove item.']);
    }

    /**
     * Render Cart Drawer HTML from Database (matching Image 3 & quillscoffee.com)
     */
    public static function render_cart_drawer_html() {
        if (!function_exists('WC') || !WC()->cart) {
            return '<div class="quills-drawer-empty-body"><p class="quills-drawer-empty-text">Your cart is currently empty.</p></div>';
        }

        $cart  = WC()->cart;
        $items = $cart->get_cart();
        $count = $cart->get_cart_contents_count();
        $subtotal = $cart->get_cart_contents_total();

        // Query database for Upsell: Crewneck Sweatshirt (Evergreen)
        $upsell_product = null;
        $upsell_posts = get_posts([
            'name'             => 'crewneck-sweatshirt-evergreen',
            'post_type'        => 'product',
            'post_status'      => 'publish',
            'numberposts'      => 1,
            'suppress_filters' => true
        ]);
        if (!empty($upsell_posts)) {
            $upsell_product = wc_get_product($upsell_posts[0]->ID);
        }

        $upsell_data = [
            'id'    => $upsell_product ? $upsell_product->get_id() : 0,
            'title' => $upsell_product ? $upsell_product->get_name() : 'Crewneck Sweatshirt (Evergreen)',
            'price' => $upsell_product ? wc_price($upsell_product->get_price()) : '$45.00',
            'img'   => ''
        ];
        if ($upsell_product) {
            $img_id = $upsell_product->get_image_id();
            if ($img_id) {
                $upsell_data['img'] = wp_get_attachment_image_url($img_id, 'medium');
            }
            if (!$upsell_data['img']) {
                $meta_img = get_post_meta($upsell_product->get_id(), '_merch_image', true);
                if ($meta_img) {
                    $upsell_data['img'] = get_template_directory_uri() . '/assets/images/' . ltrim($meta_img, '/');
                }
            }
        }
        if (!$upsell_data['img']) {
            $upsell_data['img'] = get_template_directory_uri() . '/assets/images/merch/crewneck-sweatshirt-evergreen.png';
        }

        ob_start();
        ?>
        <!-- Header -->
        <div class="quills-drawer-header">
            <h2 class="quills-drawer-title">Your cart <em>(<?php echo esc_html($count); ?>)</em></h2>
            <button type="button" class="quills-drawer-close" id="quills-drawer-close" aria-label="Close cart">✕</button>
        </div>

        <?php if ($count === 0 || empty($items)): ?>
            <div class="quills-drawer-empty-body">
                <p class="quills-drawer-empty-text">Your cart is currently empty.</p>
                <a href="<?php echo esc_url(home_url('/coffee/')); ?>" class="quills-drawer-btn-continue">CONTINUE SHOPPING</a>
            </div>
        <?php else: ?>
            <div class="quills-drawer-scroll-area">
                <!-- Items list directly from WC Database -->
                <div class="quills-drawer-items-list">
                    <?php 
                    foreach ($items as $cart_item_key => $cart_item):
                        $product = $cart_item['data'];
                        if (!$product || !$product->exists()) continue;

                        $product_id = $cart_item['product_id'];
                        $title      = $product->get_name();
                        $qty        = $cart_item['quantity'];
                        $line_total = wc_price($cart_item['line_total']);

                        // Image directly from DB
                        $is_gear  = has_term('brew-gear', 'product_cat', $product_id) || (bool)get_post_meta($product_id, '_brew_gear_image', true);
                        $is_merch = has_term('merch', 'product_cat', $product_id) || (bool)get_post_meta($product_id, '_merch_image', true);
                        if ($is_gear) {
                            if (!class_exists('Coffee_Cafe_Corner_Brew_Gear_DB')) {
                                require_once get_template_directory() . '/inc/class-brew-gear-db.php';
                            }
                            $img_url = Coffee_Cafe_Corner_Brew_Gear_DB::get_product_image_url($product_id);
                        } elseif ($is_merch) {
                            if (!class_exists('Coffee_Cafe_Corner_Merch_DB')) {
                                require_once get_template_directory() . '/inc/class-merch-db.php';
                            }
                            $img_url = Coffee_Cafe_Corner_Merch_DB::get_product_image_url($product_id);
                        } else {
                            $img_url = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail');
                            if (!$img_url && class_exists('Coffee_Cafe_Corner_Coffee_DB')) {
                                $img_url = Coffee_Cafe_Corner_Coffee_DB::get_product_image_url($product_id);
                            }
                            if (!$img_url) {
                                $meta_img = get_post_meta($product_id, '_merch_image', true);
                                if ($meta_img) {
                                    $img_url = get_template_directory_uri() . '/assets/images/merch/' . basename($meta_img);
                                }
                            }
                        }
                        if (!$img_url) {
                            $img_url = wc_placeholder_img_src();
                        }

                        $opts = isset($cart_item['quills_options']) ? $cart_item['quills_options'] : [];
                        $size = isset($opts['Size']) ? $opts['Size'] : '';
                        $grind = !empty($opts['Grind Type']) ? $opts['Grind Type'] : (!empty($opts['Grind']) ? $opts['Grind'] : '');
                        $purchase_type = isset($opts['Purchase Type']) ? $opts['Purchase Type'] : '';
                    ?>
                        <div class="quills-drawer-item" data-key="<?php echo esc_attr($cart_item_key); ?>">
                            <div class="quills-drawer-item-img-wrap">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="quills-drawer-item-img">
                            </div>

                            <div class="quills-drawer-item-details">
                                <div class="quills-drawer-item-top">
                                    <h3 class="quills-drawer-item-title"><?php echo esc_html($title); ?></h3>
                                    <span class="quills-drawer-item-price"><?php echo $line_total; ?></span>
                                </div>

                                <div class="quills-drawer-item-meta">
                                    <?php if ($size): ?>
                                        <div class="quills-drawer-meta-line">Size: <?php echo esc_html($size); ?></div>
                                    <?php endif; ?>
                                    <?php if ($grind): ?>
                                        <div class="quills-drawer-meta-line">Grind Type: <?php echo esc_html($grind); ?></div>
                                    <?php endif; ?>
                                    <?php 
                                    if ($purchase_type && $purchase_type !== 'One-time Purchase'): 
                                        $display_freq = $purchase_type;
                                        if (preg_match('/(Deliver every\s+\d+\s+weeks?)/i', $display_freq, $m)) {
                                            $display_freq = $m[1];
                                        } elseif (strpos($display_freq, 'Subscribe') !== false) {
                                            $display_freq = 'Deliver every 2 weeks';
                                        }
                                    ?>
                                        <div class="quills-drawer-meta-line quills-drawer-meta-sub"><?php echo esc_html($display_freq); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="quills-drawer-item-controls">
                                    <div class="quills-drawer-stepper">
                                        <button type="button" class="quills-drawer-step-btn quills-drawer-minus" data-key="<?php echo esc_attr($cart_item_key); ?>" data-qty="<?php echo $qty - 1; ?>" aria-label="Decrease quantity">−</button>
                                        <span class="quills-drawer-qty-val"><?php echo (int)$qty; ?></span>
                                        <button type="button" class="quills-drawer-step-btn quills-drawer-plus" data-key="<?php echo esc_attr($cart_item_key); ?>" data-qty="<?php echo $qty + 1; ?>" aria-label="Increase quantity">+</button>
                                    </div>

                                    <button type="button" class="quills-drawer-remove-btn" data-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Remove item" title="Remove item">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Upsell Section: People often add -->
                <div class="quills-drawer-upsell-section">
                    <div class="quills-drawer-upsell-header" id="quills-upsell-toggle">
                        <span class="quills-drawer-upsell-title">People often add:</span>
                        <span class="quills-drawer-upsell-arrow">⌵</span>
                    </div>

                    <div class="quills-drawer-upsell-box" id="quills-upsell-box">
                        <div class="quills-drawer-upsell-card">
                            <img src="<?php echo esc_url($upsell_data['img']); ?>" alt="<?php echo esc_attr($upsell_data['title']); ?>" class="quills-drawer-upsell-thumb">
                            <div class="quills-drawer-upsell-meta">
                                <div class="quills-drawer-upsell-name"><?php echo esc_html($upsell_data['title']); ?></div>
                                <div class="quills-drawer-upsell-price-tag"><?php echo $upsell_data['price']; ?></div>
                            </div>
                            <button type="button" class="quills-drawer-upsell-add-btn" data-product-id="<?php echo esc_attr($upsell_data['id']); ?>" title="Quick add to cart">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="quills-drawer-footer">
                <div class="quills-drawer-note-wrapper">
                    <button type="button" class="quills-drawer-note-toggle" id="quills-note-toggle">Add order note</button>
                    <div class="quills-drawer-note-textarea-wrap" id="quills-note-textarea-wrap" style="display: none;">
                        <textarea id="quills-order-note-input" rows="2" placeholder="Special instructions for seller..."></textarea>
                    </div>
                </div>

                <div class="quills-drawer-subtotal-row">
                    <span class="quills-drawer-subtotal-label">SUBTOTAL</span>
                    <span class="quills-drawer-subtotal-amount">$<?php echo esc_html(number_format($subtotal, 2)); ?> USD</span>
                </div>

                <div class="quills-drawer-tax-notice">Taxes and shipping calculated at checkout</div>

                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="quills-drawer-checkout-btn">
                    CHECK OUT
                </a>
            </div>
        <?php endif; ?>
        <?php
        return ob_get_clean();
    }

    /**
     * Render Outer Cart Drawer Container in wp_footer
     */
    public static function render_cart_drawer_container() {
        ?>
        <!-- Quills Slide-in Cart Drawer Overlay & Container (matching quillscoffee.com) -->
        <div class="quills-cart-overlay" id="quills-cart-overlay" aria-hidden="true"></div>
        <div class="quills-cart-drawer" id="quills-cart-drawer" role="dialog" aria-modal="true" aria-label="Shopping Cart">
            <div class="quills-cart-drawer-content" id="quills-cart-drawer-content">
                <?php echo self::render_cart_drawer_html(); ?>
            </div>
        </div>

        <!-- Quills Quick Shop Drawer Overlay & Container (matching Image 2 & quillscoffee.com) -->
        <div class="quills-quick-shop-overlay" id="quills-quick-shop-overlay" aria-hidden="true"></div>
        <div class="quills-quick-shop-drawer" id="quills-quick-shop-drawer" role="dialog" aria-modal="true" aria-hidden="true">
            <div class="quills-quick-shop-content" id="quills-quick-shop-content"></div>
        </div>
        <?php
    }

    /**
     * Get Review Statistics for a Product
     */
    public static function get_review_stats($product_id) {
        $comments = get_comments([
            'post_id' => $product_id,
            'status'  => 'approve',
            'type'    => 'review'
        ]);

        $total = count($comments);
        $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $sum = 0;

        foreach ($comments as $c) {
            $r = (int)get_comment_meta($c->comment_ID, 'rating', true);
            if ($r < 1 || $r > 5) $r = 5;
            $distribution[$r]++;
            $sum += $r;
        }

        $average = $total > 0 ? round($sum / $total, 1) : 5.0;

        return [
            'total'        => $total ?: 3,
            'average'      => $average,
            'distribution' => $distribution,
            'comments'     => $comments
        ];
    }
}

Quills_Coffee_Experience::init();
