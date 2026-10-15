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
        
        // AJAX endpoints
        add_action('wp_ajax_quills_filter_products', [__CLASS__, 'ajax_filter_products']);
        add_action('wp_ajax_nopriv_quills_filter_products', [__CLASS__, 'ajax_filter_products']);

        add_action('wp_ajax_quills_submit_review', [__CLASS__, 'ajax_submit_review']);
        add_action('wp_ajax_nopriv_quills_submit_review', [__CLASS__, 'ajax_submit_review']);

        add_action('wp_ajax_quills_vote_review', [__CLASS__, 'ajax_vote_review']);
        add_action('wp_ajax_nopriv_quills_vote_review', [__CLASS__, 'ajax_vote_review']);

        add_action('wp_ajax_quills_add_to_cart', [__CLASS__, 'ajax_add_to_cart']);
        add_action('wp_ajax_nopriv_quills_add_to_cart', [__CLASS__, 'ajax_add_to_cart']);

        // Template loaders
        add_filter('template_include', [__CLASS__, 'override_templates'], 99);
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
            '1.0.4'
        );

        // Quills JS
        wp_enqueue_script(
            'quills-coffee-script',
            get_template_directory_uri() . '/assets/js/quills-coffee.js',
            ['jquery'],
            '1.0.4',
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
        if (is_product()) {
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
     * AJAX Add to Cart with Options
     */
    public static function ajax_add_to_cart() {
        check_ajax_referer('quills_nonce', 'nonce');
        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $quantity   = isset($_POST['quantity']) ? max(1, absint($_POST['quantity'])) : 1;
        $size       = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '12oz';
        $grind      = isset($_POST['grind']) ? sanitize_text_field($_POST['grind']) : 'Whole Bean';
        $purchase   = isset($_POST['purchase_type']) ? sanitize_text_field($_POST['purchase_type']) : 'onetime';

        $item_data = [
            'Size'          => $size,
            'Grind'         => $grind,
            'Purchase Type' => ($purchase === 'subscribe') ? 'Subscribe & Save (10% Off)' : 'One-time Purchase'
        ];

        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, [], ['quills_options' => $item_data]);

        if ($cart_item_key) {
            wp_send_json_success([
                'cart_count' => WC()->cart->get_cart_contents_count(),
                'cart_total' => WC()->cart->get_cart_total(),
                'message'    => 'Added to cart successfully!'
            ]);
        } else {
            wp_send_json_error(['message' => 'Could not add to cart.']);
        }
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
