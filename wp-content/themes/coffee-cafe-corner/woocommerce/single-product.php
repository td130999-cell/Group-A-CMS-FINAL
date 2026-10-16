<?php
/**
 * Quills Coffee - Single Product Page Template
 * Replicating https://quillscoffee.com/products/guatemala-alma-2 100%
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;
if (!$product && function_exists('wc_get_product')) {
    $pid = get_the_ID();
    if (!$pid) {
        $slug = get_query_var('product') ?: get_query_var('name');
        if ($slug) {
            $p_obj = get_page_by_path($slug, OBJECT, 'product');
            if ($p_obj) {
                $pid = $p_obj->ID;
            }
        }
    }
    if ($pid) {
        $product = wc_get_product($pid);
    }
}

if (!$product && function_exists('wc_get_product')) {
    $fallback_post = get_page_by_path('inkwell-signature-blend', OBJECT, 'product');
    if ($fallback_post) {
        $product = wc_get_product($fallback_post->ID);
    }
}

if (!$product) {
    wp_redirect(home_url('/coffee/'));
    exit;
}

$id    = $product->get_id();
$title = $product->get_name();
$price = (float)$product->get_price();
if ($price <= 0) {
    $price = 20.00;
}
$formatted_price = wc_price($price);
$sub_price       = wc_price(round($price * 0.9, 2));

// Custom Quills metadata from Database
if (!class_exists('Coffee_Cafe_Corner_Coffee_DB')) {
    require_once get_template_directory() . '/inc/class-coffee-db.php';
}

$tasting_notes = get_post_meta($id, '_coffee_tasting_notes', true) ?: (get_post_meta($id, '_quills_tasting_notes', true) ?: 'Graham cracker, cooked cherries, vanilla');
$roast         = get_post_meta($id, '_coffee_roast', true) ?: (get_post_meta($id, '_quills_roast_profile', true) ?: 'Medium');
$process       = get_post_meta($id, '_coffee_process', true) ?: (get_post_meta($id, '_quills_process', true) ?: 'Washed & Natural');
$type          = get_post_meta($id, '_coffee_type', true) ?: (get_post_meta($id, '_quills_coffee_type', true) ?: 'Signature Blend');
$origins       = get_post_meta($id, '_coffee_origins', true) ?: (get_post_meta($id, '_quills_country', true) ?: 'Colombia, Guatemala, & Ethiopia');
$short_title   = strtoupper(trim(explode('|', $title)[0]));

// Images
$main_img_url = Coffee_Cafe_Corner_Coffee_DB::get_product_image_url($id);

$all_images = [$main_img_url];
$gallery_ids = $product->get_gallery_image_ids();
foreach ($gallery_ids as $gid) {
    $gurl = wp_get_attachment_image_url($gid, 'full');
    if ($gurl && !in_array($gurl, $all_images)) {
        $all_images[] = $gurl;
    }
}

// Review stats
$review_stats = Quills_Coffee_Experience::get_review_stats($id);
$review_count = (int)get_post_meta($id, '_wc_review_count', true) ?: ($review_stats['total'] ?: 21);

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html($title); ?> | Quills Coffee</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('quills-body quills-single-product-page'); ?>>

<?php get_template_part( 'patterns/header' ); ?>

<div class="quills-coffee-page-wrapper">

<!-- Breadcrumbs (Image 2) -->
<div class="quills-breadcrumbs-section">
    <div class="quills-container">
        <ul class="quills-breadcrumbs">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            <li><span class="sep">/</span></li>
            <li><a href="<?php echo esc_url(home_url('/coffee/')); ?>">Coffee</a></li>
            <li><span class="sep">/</span></li>
            <li class="active"><?php echo esc_html($title); ?></li>
        </ul>
    </div>
</div>

<div class="quills-container">
    <div class="quills-separator-line"></div>
</div>

<!-- Top Testimonial Quote Slider (Image 2) -->
<section class="quills-sp-quote-slider-section" aria-label="<?php esc_attr_e( 'Customer Quote', 'coffee-cafe-corner' ); ?>">
    <div class="quills-container quills-sp-quote-container">
        <button type="button" class="quills-sp-slider-arrow quills-sp-arrow-prev" id="quills-sp-prev" aria-label="Previous quote">
            ‹
        </button>

        <div class="quills-sp-quote-content">
            <div class="quills-sp-quote-stars">
                <span class="quills-gold-star">★</span>
                <span class="quills-gold-star">★</span>
                <span class="quills-gold-star">★</span>
                <span class="quills-gold-star">★</span>
                <span class="quills-gold-star">★</span>
            </div>
            <blockquote class="quills-sp-quote-text" id="quills-sp-quote-text">
                "Inkwell is one of my all time favorites."
            </blockquote>
            <cite class="quills-sp-quote-author" id="quills-sp-quote-author">— Jeff S.</cite>

            <div class="quills-sp-slider-dots">
                <span class="quills-sp-dot is-active" data-idx="0"></span>
                <span class="quills-sp-dot" data-idx="1"></span>
                <span class="quills-sp-dot" data-idx="2"></span>
            </div>
        </div>

        <button type="button" class="quills-sp-slider-arrow quills-sp-arrow-next" id="quills-sp-next" aria-label="Next quote">
            ›
        </button>
    </div>
</section>

<div class="quills-container">
    <div class="quills-separator-line"></div>
</div>

<!-- Main Product View (Images 3 & 4) -->
<main class="quills-product-main">
    <div class="quills-container">
        <div class="quills-product-layout">
            
            <!-- Left Column: Primary Image & Description Accordion (Image 1) -->
            <div class="quills-product-gallery">
                <div class="quills-gallery-stage">
                    <img id="quills-main-image" src="<?php echo esc_url($main_img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="quills-featured-image" loading="eager">
                </div>

                <!-- Description Accordion (Image 1 parity) -->
                <div class="quills-desc-accordion-wrapper is-open">
                    <button type="button" class="quills-desc-header" id="quills-desc-toggle" aria-expanded="true">
                        <span class="quills-desc-title">Description</span>
                        <span class="quills-desc-icon">—</span>
                    </button>
                    <div class="quills-desc-content" id="quills-desc-content">
                        <div class="quills-desc-text">
                            <?php 
                            $post_content = get_post_field('post_content', $id);
                            if (!empty($post_content)) {
                                echo wpautop(wp_kses_post($post_content));
                            }
                            ?>
                            <?php if (!empty($origins)): ?>
                                <p class="quills-desc-meta-line"><strong>Current coffees:</strong> <?php echo esc_html($origins); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($tasting_notes)): ?>
                                <p class="quills-desc-meta-line"><strong>We taste:</strong> <?php echo esc_html($tasting_notes); ?>.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details & Add to Cart (Image 1) -->
            <div class="quills-product-details">
                <h1 class="quills-product-title"><?php echo esc_html($title); ?></h1>

                <!-- Star Rating Badge -->
                <div class="quills-rating-badge">
                    <a href="#quills-reviews-section" class="quills-rating-link">
                        <span class="quills-stars quills-stars-gold">★★★★★</span>
                        <span class="quills-rating-reviews"><?php echo esc_html($review_count); ?> reviews</span>
                    </a>
                </div>

                <!-- Price -->
                <div class="quills-price-box">
                    <span class="quills-price-current" id="quills-dynamic-price"><?php echo $formatted_price; ?></span>
                </div>

                <!-- Size Selection Pills (Image 1) -->
                <div class="quills-option-group" id="quills-size-group">
                    <div class="quills-section-label">Size: <span id="quills-selected-size-label">12oz</span></div>
                    <div class="quills-pills-row">
                        <button type="button" class="quills-pill-btn active" data-size="12oz">12oz</button>
                        <button type="button" class="quills-pill-btn" data-size="5lb">5lb</button>
                        <button type="button" class="quills-pill-btn" data-size="2lb">2lb</button>
                    </div>
                </div>

                <!-- Grind Type Selection Pills (Image 1) -->
                <div class="quills-option-group" id="quills-grind-group">
                    <div class="quills-section-label">Grind Type: <span id="quills-selected-grind-label">Whole Bean</span></div>
                    <div class="quills-pills-row quills-grind-pills">
                        <button type="button" class="quills-pill-btn active" data-grind="Whole Bean">Whole Bean</button>
                        <button type="button" class="quills-pill-btn" data-grind="Automatic Drip">Automatic Drip</button>
                        <button type="button" class="quills-pill-btn" data-grind="Espresso">Espresso</button>
                        <button type="button" class="quills-pill-btn" data-grind="Aeropress">Aeropress</button>
                        <button type="button" class="quills-pill-btn" data-grind="Pour Over">Pour Over</button>
                        <button type="button" class="quills-pill-btn" data-grind="Chemex">Chemex</button>
                        <button type="button" class="quills-pill-btn" data-grind="French Press / Cold Brew">French Press / Cold Brew</button>
                    </div>
                </div>

                <!-- Purchase Options Box (Image 1) -->
                <div class="quills-subscription-toggle">
                    <!-- Option 1: One-Time Purchase -->
                    <label class="quills-sub-option active" data-type="onetime">
                        <div class="quills-sub-row">
                            <span class="quills-radio-custom"></span>
                            <input type="radio" name="quills_purchase_type" value="onetime" checked style="display: none;">
                            <span class="quills-sub-title">One-time purchase</span>
                            <span class="quills-sub-price" id="quills-onetime-price-label"><?php echo $formatted_price; ?> <small>each</small></span>
                        </div>
                    </label>

                    <!-- Option 2: Subscribe & Save 10% -->
                    <label class="quills-sub-option" data-type="subscribe">
                        <div class="quills-sub-row">
                            <span class="quills-radio-custom"></span>
                            <input type="radio" name="quills_purchase_type" value="subscribe" style="display: none;">
                            <div class="quills-sub-title-wrap">
                                <span class="quills-sub-title">Subscribe</span>
                                <span class="quills-badge-save-v2">Save 10%</span>
                            </div>
                            <span class="quills-sub-price" id="quills-subscribe-price-label">
                                <del><?php echo $formatted_price; ?></del> <strong><?php echo $sub_price; ?></strong> <small>each</small>
                            </span>
                        </div>

                        <!-- Inside Frequency Selector (Image 1) -->
                        <div class="quills-sub-drawer" id="quills-sub-drawer">
                            <div class="quills-freq-headline">Pick how often we send it</div>
                            <div class="quills-freq-pills-row">
                                <button type="button" class="quills-freq-pill" data-freq="1">Deliver every 1 week</button>
                                <button type="button" class="quills-freq-pill is-selected" data-freq="2">Deliver every 2 weeks</button>
                                <button type="button" class="quills-freq-pill" data-freq="3">Deliver every 3 weeks</button>
                                <button type="button" class="quills-freq-pill" data-freq="4">Deliver every 4 weeks</button>
                            </div>

                            <div class="quills-sub-perks-box">
                                <div class="quills-perk-row">
                                    <div class="quills-perk-title"><strong>FREE bag of Inkwell</strong> in your first delivery</div>
                                    <div class="quills-perk-sub">(new subscribers only)</div>
                                </div>
                                <div class="quills-perk-row">
                                    <div class="quills-perk-title"><strong>10% OFF</strong> Recurring</div>
                                </div>
                                <div class="quills-perk-row">
                                    <div class="quills-perk-title"><span class="quills-dollar-icon">$</span> <strong>Lowest Price</strong></div>
                                </div>
                                <div class="quills-perk-row">
                                    <div class="quills-perk-title"><strong>Cancel or Update</strong> Any Time</div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="quills-add-cart-row">
                    <div class="quills-qty-stepper">
                        <button type="button" class="quills-qty-btn" id="quills-qty-minus" aria-label="Decrease quantity">−</button>
                        <input type="text" id="quills-qty-input" value="1" readonly inputmode="numeric">
                        <button type="button" class="quills-qty-btn" id="quills-qty-plus" aria-label="Increase quantity">+</button>
                    </div>

                    <button type="button" class="quills-btn-add-cart" id="quills-btn-add-to-cart" data-product-id="<?php echo esc_attr($id); ?>" data-base-price="<?php echo esc_attr($price); ?>">
                        <span class="quills-btn-text">ADD TO CART</span>
                        <span class="quills-btn-spinner"></span>
                    </button>
                </div>

                <!-- Buy with Shop Pay Button (Image 1) -->
                <button type="button" class="quills-btn-shop-pay" id="quills-btn-shop-pay" onclick="window.location.href='<?php echo esc_url(wc_get_checkout_url()); ?>';">
                    <span>Buy with</span> <span class="quills-shop-brand">shop</span>
                </button>

                <!-- Toast Notification -->
                <div class="quills-cart-toast" id="quills-cart-toast">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Added to your cart!</span>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="quills-toast-view-cart">View Cart →</a>
                </div>

            </div>

        </div>
    </div>
</main>

<!-- Customer Reviews Section (Image 5) -->
<section class="quills-reviews-section-v2" id="quills-reviews-section">
    <div class="quills-container">
        
        <!-- Header Row (Image 5) -->
        <div class="quills-reviews-header-v2">
            <h2 class="quills-reviews-title-v2">Customer Reviews</h2>
            
            <div class="quills-reviews-toolbar-v2">
                <div class="quills-reviews-stats-badge">
                    <span class="quills-reviews-avg">4.9</span>
                    <span class="quills-reviews-count-label"><?php echo esc_html($review_count); ?> reviews</span>
                    <span class="quills-reviews-trophy" title="Verified Store Rating">🏆</span>
                    <span class="quills-reviews-badge-circle" title="Verified Customer Feedback">✔</span>
                </div>

                <div class="quills-reviews-actions-right">
                    <button type="button" class="quills-btn-write-review-v2" id="quills-toggle-review-form">
                        WRITE A REVIEW
                    </button>
                    <button type="button" class="quills-review-icon-btn" id="quills-review-filter-btn" title="Filter reviews">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    </button>
                    <button type="button" class="quills-review-icon-btn" id="quills-review-sort-btn" title="Sort reviews">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Write a Review Inline Form -->
        <div class="quills-review-form-wrapper" id="quills-review-form-container" style="display: none;">
            <form id="quills-submit-review-form" class="quills-review-form">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($id); ?>">
                <input type="hidden" name="rating" id="quills-input-rating" value="5">

                <h3 class="quills-form-heading">Write a Review</h3>
                <p class="quills-form-subheading">Share your thoughts on <?php echo esc_html($title); ?> with fellow coffee enthusiasts!</p>

                <!-- Interactive Star Selector -->
                <div class="quills-form-row">
                    <label>Rating</label>
                    <div class="quills-star-picker" id="quills-star-picker">
                        <span class="quills-star-item active" data-val="1">★</span>
                        <span class="quills-star-item active" data-val="2">★</span>
                        <span class="quills-star-item active" data-val="3">★</span>
                        <span class="quills-star-item active" data-val="4">★</span>
                        <span class="quills-star-item active" data-val="5">★</span>
                        <span class="quills-star-rating-text" id="quills-rating-text">5 / 5 (Outstanding)</span>
                    </div>
                </div>

                <div class="quills-form-row">
                    <label for="quills-review-title">Review Title</label>
                    <input type="text" id="quills-review-title" name="title" placeholder="Give your review a title" required>
                </div>

                <div class="quills-form-row">
                    <label for="quills-review-content">Review Body</label>
                    <textarea id="quills-review-content" name="content" rows="4" placeholder="Write your comments here..." required></textarea>
                </div>

                <div class="quills-form-grid-2">
                    <div class="quills-form-row">
                        <label for="quills-review-author">Name (displayed publicly)</label>
                        <input type="text" id="quills-review-author" name="author" placeholder="Enter your name" required>
                    </div>

                    <div class="quills-form-row">
                        <label for="quills-review-email">Email Address (private)</label>
                        <input type="email" id="quills-review-email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="quills-form-actions">
                    <button type="button" class="quills-btn-cancel-review" id="quills-cancel-review-btn">Cancel</button>
                    <button type="submit" class="quills-btn-submit-review" id="quills-submit-review-btn">
                        <span>Submit Review</span>
                    </button>
                </div>

                <div class="quills-form-feedback" id="quills-review-feedback"></div>
            </form>
        </div>

        <!-- Reviews List (Image 5) -->
        <div class="quills-reviews-list-v2" id="quills-reviews-list">
            <?php 
            $db_comments = get_comments([
                'post_id' => $id,
                'status'  => 'approve',
                'type'    => 'review',
                'orderby' => 'comment_date',
                'order'   => 'DESC'
            ]);

            if (!empty($db_comments)):
                foreach ($db_comments as $comm):
                    $c_rating = (int)get_comment_meta($comm->comment_ID, 'rating', true) ?: 5;
                    $c_date   = date('m/d/Y', strtotime($comm->comment_date));
                    $initial  = strtoupper(substr($comm->comment_author, 0, 1));
                    $c_body   = preg_replace('/^<strong>.*?<\/strong>\s*/s', '', $comm->comment_content);
            ?>
                <div class="quills-review-item-v2" data-rating="<?php echo esc_attr($c_rating); ?>">
                    <div class="quills-review-item-stars">
                        <?php 
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<span class="star ' . ($i <= $c_rating ? 'filled' : 'empty') . '">★</span>';
                        }
                        ?>
                    </div>

                    <div class="quills-review-item-author-row">
                        <span class="quills-author-avatar-circle"><?php echo esc_html($initial); ?></span>
                        <span class="quills-author-name-text"><?php echo esc_html($comm->comment_author); ?></span>
                        <span class="quills-verified-pill">Verified</span>
                        <span class="quills-review-date-text"><?php echo esc_html($c_date); ?></span>
                    </div>

                    <div class="quills-review-item-text">
                        <?php echo wp_kses_post(trim($c_body)); ?>
                    </div>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <!-- Authentic Fallback Cards matching Image 2 & Quills Coffee -->
                <div class="quills-review-item-v2" data-rating="4">
                    <div class="quills-review-item-stars">
                        <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star empty">★</span>
                    </div>
                    <div class="quills-review-item-author-row">
                        <span class="quills-author-avatar-circle">D</span>
                        <span class="quills-author-name-text">Dony Erwin Erwin</span>
                        <span class="quills-verified-pill">Verified</span>
                        <span class="quills-review-date-text">08/02/2024</span>
                    </div>
                    <div class="quills-review-item-text">
                        It's a little on the mild side for me. We switched to Night Owl for next month's delivery. Thanks.
                    </div>
                </div>

                <div class="quills-review-item-v2" data-rating="5">
                    <div class="quills-review-item-stars">
                        <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span>
                    </div>
                    <div class="quills-review-item-author-row">
                        <span class="quills-author-avatar-circle">D</span>
                        <span class="quills-author-name-text">Donna</span>
                        <span class="quills-verified-pill">Verified by shop</span>
                        <span class="quills-review-date-text">08/02/2024</span>
                    </div>
                    <div class="quills-review-item-text">
                        Amazing so glad we found this place
                        <span class="quills-review-subnote">Review written in Shop App</span>
                    </div>
                </div>

                <div class="quills-review-item-v2" data-rating="5">
                    <div class="quills-review-item-stars">
                        <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span>
                    </div>
                    <div class="quills-review-item-author-row">
                        <span class="quills-author-avatar-circle">S</span>
                        <span class="quills-author-name-text">Staci R</span>
                        <span class="quills-verified-pill">Verified</span>
                        <span class="quills-review-date-text">08/01/2024</span>
                    </div>
                    <div class="quills-review-item-text">
                        This is currently our favorite coffee! Looking forward to trying your other blends in the future.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Customer Reviews Pagination matching Image 2 -->
        <div class="quills-reviews-pagination">
            <button type="button" class="quills-page-arrow" disabled>‹</button>
            <button type="button" class="quills-page-num is-active">1</button>
            <button type="button" class="quills-page-num">2</button>
            <button type="button" class="quills-page-num">3</button>
            <button type="button" class="quills-page-num">4</button>
            <span class="quills-page-dots">...</span>
            <button type="button" class="quills-page-num">16</button>
            <button type="button" class="quills-page-arrow">›</button>
        </div>

    </div>
</section>

<!-- Subscribe to The Hoot Section (Image 2) -->
<section class="quills-hoot-section" aria-label="<?php esc_attr_e( 'Subscribe to The Hoot', 'coffee-cafe-corner' ); ?>">
    <div class="quills-container quills-hoot-container">
        <h2 class="quills-hoot-title"><?php esc_html_e( 'Subscribe to The Hoot', 'coffee-cafe-corner' ); ?></h2>
        <p class="quills-hoot-sub"><?php esc_html_e( 'A 5-min read every Friday morning. Get access to secret coffees and reader-only merch.', 'coffee-cafe-corner' ); ?></p>
        <form class="quills-hoot-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to The Hoot!');">
            <input type="email" placeholder="<?php esc_attr_e( 'Email', 'coffee-cafe-corner' ); ?>" class="quills-hoot-input" required />
            <button type="submit" class="quills-hoot-btn"><?php esc_html_e( 'SUBSCRIBE', 'coffee-cafe-corner' ); ?></button>
        </form>
    </div>
</section>

</div><!-- /.quills-coffee-page-wrapper -->

<?php get_template_part( 'patterns/footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
