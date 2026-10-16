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
            
            <!-- Left Column: Primary Image & Vintage Roast Card (Images 3 & 4) -->
            <div class="quills-product-gallery">
                <div class="quills-gallery-stage">
                    <img id="quills-main-image" src="<?php echo esc_url($main_img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="quills-featured-image" loading="eager">
                </div>

                <!-- Vintage Coffee Roast Label Card (Image 4) -->
                <div class="quills-vintage-roast-card" aria-label="Roast Label Card">
                    <div class="quills-roast-card-header">
                        <h2 class="quills-roast-card-title"><?php echo esc_html($short_title); ?></h2>
                    </div>
                    <div class="quills-roast-card-body">
                        <div class="quills-roast-card-left">
                            <div class="quills-roast-field">
                                <span class="quills-roast-field-label">ORIGINS</span>
                                <span class="quills-roast-field-val"><?php echo esc_html($origins); ?></span>
                            </div>
                            <div class="quills-roast-field">
                                <span class="quills-roast-field-label">FLAVOR NOTES</span>
                                <span class="quills-roast-field-val is-italic"><?php echo esc_html($tasting_notes); ?></span>
                            </div>
                            <div class="quills-roast-field-split">
                                <div class="quills-roast-field-sub">
                                    <span class="quills-roast-field-label">BLEND</span>
                                    <span class="quills-roast-field-val"><?php echo esc_html($type); ?></span>
                                </div>
                                <div class="quills-roast-field-sub">
                                    <span class="quills-roast-field-label">PROCESS</span>
                                    <span class="quills-roast-field-val"><?php echo esc_html($process); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="quills-roast-card-right">
                            <div class="quills-roast-field">
                                <span class="quills-roast-field-label">ROAST DATE</span>
                                <span class="quills-roast-field-val is-date">Aug 28 2025</span>
                            </div>
                            <div class="quills-roast-field">
                                <span class="quills-roast-field-label">ROAST</span>
                                <div class="quills-roast-indicators">
                                    <label class="quills-roast-dot-item <?php echo strtolower($roast) === 'light' ? 'is-checked' : ''; ?>">
                                        <span class="quills-roast-circle"></span>
                                        <span class="quills-roast-label">Light</span>
                                    </label>
                                    <label class="quills-roast-dot-item <?php echo (strtolower($roast) === 'medium' || empty($roast)) ? 'is-checked' : ''; ?>">
                                        <span class="quills-roast-circle"></span>
                                        <span class="quills-roast-label">Medium</span>
                                    </label>
                                    <label class="quills-roast-dot-item <?php echo strtolower($roast) === 'dark' ? 'is-checked' : ''; ?>">
                                        <span class="quills-roast-circle"></span>
                                        <span class="quills-roast-label">Dark</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="quills-roast-card-footer">
                        12 OZ / 340 GM
                    </div>
                </div>

                <!-- Extra Context Barista Photo (Image 4 bottom) -->
                <div class="quills-gallery-lifestyle-box">
                    <img src="<?php echo esc_url(home_url('/wp-content/themes/coffee-cafe-corner/assets/images/coffee/coffee-hero-barista.jpg')); ?>" alt="Craft Coffee Experience" class="quills-lifestyle-photo" loading="lazy">
                </div>
            </div>

            <!-- Right Column: Details & Add to Cart (Image 3) -->
            <div class="quills-product-details">
                <h1 class="quills-product-title"><?php echo esc_html($title); ?></h1>

                <!-- Star Rating Badge -->
                <div class="quills-rating-badge">
                    <a href="#quills-reviews-section" class="quills-rating-link">
                        <span class="quills-stars">★★★★★</span>
                        <span class="quills-rating-reviews">80 reviews</span>
                    </a>
                </div>

                <!-- Price -->
                <div class="quills-price-box">
                    <span class="quills-price-current" id="quills-dynamic-price"><?php echo $formatted_price; ?></span>
                </div>

                <!-- Size Selection Pills (Image 3) -->
                <div class="quills-option-group" id="quills-size-group">
                    <div class="quills-section-label">Size: <span id="quills-selected-size-label">12oz</span></div>
                    <div class="quills-pills-row">
                        <button type="button" class="quills-pill-btn active" data-size="12oz" data-multiplier="1.0">12oz</button>
                        <button type="button" class="quills-pill-btn" data-size="5lb" data-multiplier="4.5">5lb</button>
                        <button type="button" class="quills-pill-btn" data-size="2lb" data-multiplier="2.2">2lb</button>
                    </div>
                </div>

                <!-- Grind Type Selection Pills (Image 3) -->
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

                <!-- Purchase Options Box (Image 3) -->
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

                        <!-- Inside Frequency Selector (Image 3) -->
                        <div class="quills-sub-drawer" id="quills-sub-drawer" style="display: none;">
                            <div class="quills-freq-headline">Pick how often we send it</div>
                            <div class="quills-freq-pills-row">
                                <button type="button" class="quills-freq-pill" data-freq="1">Deliver every 1 week</button>
                                <button type="button" class="quills-freq-pill is-selected" data-freq="2">Deliver every 2 weeks</button>
                                <button type="button" class="quills-freq-pill" data-freq="3">Deliver every 3 weeks</button>
                                <button type="button" class="quills-freq-pill" data-freq="4">Deliver every 4 weeks</button>
                            </div>

                            <div class="quills-sub-perks-box">
                                <div class="quills-perk-item highlight">
                                    <strong>FREE bag of <?php echo esc_html($short_title); ?></strong> in your first delivery
                                    <span class="quills-perk-sub">(new subscribers only)</span>
                                </div>
                                <div class="quills-perk-item">
                                    <strong>10% OFF</strong> Recurring
                                </div>
                                <div class="quills-perk-item">
                                    <span class="quills-dollar-icon">$</span> <strong>Lowest Price</strong>
                                </div>
                                <div class="quills-perk-item">
                                    <span>Cancel or Update Any Time</span>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="quills-add-cart-row">
                    <div class="quills-qty-stepper">
                        <button type="button" class="quills-qty-btn" id="quills-qty-minus">−</button>
                        <input type="number" id="quills-qty-input" value="1" min="1" max="99" readonly>
                        <button type="button" class="quills-qty-btn" id="quills-qty-plus">+</button>
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

                <!-- Value Props Icons -->
                <div class="quills-props-list">
                    <div class="quills-prop-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        <span>Free shipping on all orders over $50</span>
                    </div>
                    <div class="quills-prop-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                        <span>Freshly roasted to order within 24-48 hours</span>
                    </div>
                    <div class="quills-prop-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>100% Ethically sourced Specialty Grade Arabica</span>
                    </div>
                </div>

                <!-- Quills Accordions -->
                <div class="quills-accordions">
                    <div class="quills-accordion-item open">
                        <button type="button" class="quills-accordion-header">
                            <span>Coffee Details</span>
                            <span class="quills-acc-icon">−</span>
                        </button>
                        <div class="quills-accordion-content">
                            <table class="quills-specs-table">
                                <tbody>
                                    <tr><th>Origins</th><td><?php echo esc_html($origins); ?></td></tr>
                                    <tr><th>Flavor Notes</th><td><?php echo esc_html($tasting_notes); ?></td></tr>
                                    <tr><th>Roast</th><td><?php echo esc_html($roast); ?></td></tr>
                                    <tr><th>Process</th><td><?php echo esc_html($process); ?></td></tr>
                                    <tr><th>Type</th><td><?php echo esc_html($type); ?></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="quills-accordion-item">
                        <button type="button" class="quills-accordion-header">
                            <span>Brewing Guide</span>
                            <span class="quills-acc-icon">+</span>
                        </button>
                        <div class="quills-accordion-content">
                            <div class="quills-brew-guide-grid">
                                <div class="quills-brew-card">
                                    <div class="quills-brew-title">POUR OVER (V60 / KALITA)</div>
                                    <p><strong>Ratio:</strong> 1:16 (15g coffee : 240g water)</p>
                                    <p><strong>Grind:</strong> Medium-Fine</p>
                                    <p><strong>Water Temp:</strong> 93°C (200°F)</p>
                                    <p><strong>Total Time:</strong> 2:45 – 3:15 min</p>
                                </div>
                                <div class="quills-brew-card">
                                    <div class="quills-brew-title">ESPRESSO (9 BAR)</div>
                                    <p><strong>Dose:</strong> 18g finely ground coffee</p>
                                    <p><strong>Yield:</strong> 38g liquid espresso</p>
                                    <p><strong>Time:</strong> 27 – 30 seconds</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="quills-accordion-item">
                        <button type="button" class="quills-accordion-header">
                            <span>The Story</span>
                            <span class="quills-acc-icon">+</span>
                        </button>
                        <div class="quills-accordion-content">
                            <div class="quills-story-body">
                                <p><?php echo esc_html($title); ?> is roasted with precision in Louisville, Kentucky. Every bean is sourced directly through long-term relationships with dedicated coffee producers who share our obsession with cup quality and sustainable agriculture.</p>
                            </div>
                        </div>
                    </div>
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
                    <span class="quills-reviews-count-label">80 reviews</span>
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
