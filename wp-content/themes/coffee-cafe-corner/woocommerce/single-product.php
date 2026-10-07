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
    $product = wc_get_product(get_the_ID());
}

if (!$product) {
    wp_redirect(wc_get_page_permalink('shop'));
    exit;
}

$id = $product->get_id();
$title = $product->get_name();
$price = (float)$product->get_price();
$formatted_price = wc_price($price);
$sub_price = wc_price($price * 0.9);

// Custom Quills metadata
$tasting_notes = get_post_meta($id, '_quills_tasting_notes', true) ?: 'malt chocolate, date, pecan';
$roast         = get_post_meta($id, '_quills_roast_profile', true) ?: 'Light';
$process       = get_post_meta($id, '_quills_process', true) ?: 'Washed';
$type          = get_post_meta($id, '_quills_coffee_type', true) ?: 'Single Origin';
$country       = get_post_meta($id, '_quills_country', true) ?: 'Guatemala';
$region        = get_post_meta($id, '_quills_region', true) ?: 'Huehuetenango';
$producer      = get_post_meta($id, '_quills_producer', true) ?: 'Partner Smallholders';
$varieties     = get_post_meta($id, '_quills_varieties', true) ?: 'Bourbon, Caturra, Pache';
$elevation     = get_post_meta($id, '_quills_elevation', true) ?: '1,400 - 1,600 MASL';

// Images
$main_img_id  = $product->get_image_id();
$main_img_url = wp_get_attachment_image_url($main_img_id, 'full') ?: wc_placeholder_img_src();

$gallery_ids = $product->get_gallery_image_ids();
$all_images = [$main_img_url];

// Add fallback high-res Quills images if single gallery image
$fallback_extras = [
    home_url('/wp-content/uploads/quills/guatemala_alma_label.png'),
    home_url('/wp-content/uploads/quills/blacksmith_back.jpg'),
    home_url('/wp-content/uploads/quills/guatemala_alma_farm.jpg')
];

foreach ($gallery_ids as $gid) {
    $gurl = wp_get_attachment_image_url($gid, 'full');
    if ($gurl && !in_array($gurl, $all_images)) {
        $all_images[] = $gurl;
    }
}

foreach ($fallback_extras as $extra) {
    if (count($all_images) < 4 && !in_array($extra, $all_images)) {
        $all_images[] = $extra;
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

<!-- Top Announcement Bar -->
<div class="quills-announcement-bar">
    <div class="quills-container">
        <span>FREE SHIPPING ON ORDERS OVER $50 • FRESH ROASTED COFFEE SHIPPED DIRECT TO YOUR DOOR</span>
    </div>
</div>

<!-- Quills Header -->
<header class="quills-header">
    <div class="quills-container quills-header__inner">
        <div class="quills-header__nav-left">
            <nav class="quills-nav">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="quills-nav-link active">SHOP COFFEE</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?type=Single+Origin" class="quills-nav-link">SINGLE ORIGIN</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?type=Blend" class="quills-nav-link">BLENDS</a>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?category=subscriptions" class="quills-nav-link">SUBSCRIPTIONS</a>
            </nav>
        </div>

        <div class="quills-header__logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(home_url('/wp-content/uploads/quills/quills_logo.png')); ?>" alt="Quills Coffee" class="quills-logo-img">
            </a>
        </div>

        <div class="quills-header__actions">
            <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="quills-icon-link" title="Account">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="quills-cart-toggle" title="Cart">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="quills-cart-count" id="quills-cart-badge"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?></span>
            </a>
        </div>
    </div>
</header>

<!-- Breadcrumbs -->
<div class="quills-breadcrumbs-section">
    <div class="quills-container">
        <ul class="quills-breadcrumbs">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            <li><span class="sep">/</span></li>
            <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Coffee</a></li>
            <li><span class="sep">/</span></li>
            <li class="active"><?php echo esc_html($title); ?></li>
        </ul>
    </div>
</div>

<!-- Main Product View -->
<main class="quills-product-main">
    <div class="quills-container">
        <div class="quills-product-layout">
            
            <!-- Left Column: Gallery -->
            <div class="quills-product-gallery">
                <div class="quills-gallery-stage">
                    <img id="quills-main-image" src="<?php echo esc_url($all_images[0]); ?>" alt="<?php echo esc_attr($title); ?>" class="quills-featured-image">
                    <span class="quills-gallery-badge"><?php echo esc_html($roast); ?> Roast</span>
                </div>

                <div class="quills-gallery-thumbs">
                    <?php foreach ($all_images as $idx => $img_url): ?>
                        <div class="quills-thumb <?php echo $idx === 0 ? 'active' : ''; ?>" data-full="<?php echo esc_url($img_url); ?>">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?> thumb <?php echo $idx+1; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Column: Details & Add to Cart -->
            <div class="quills-product-details">
                <div class="quills-brand-tag">QUILLS COFFEE</div>
                <h1 class="quills-product-title"><?php echo esc_html($title); ?></h1>

                <!-- Star Rating Badge -->
                <div class="quills-rating-badge">
                    <a href="#quills-reviews-section" class="quills-rating-link">
                        <span class="quills-stars">★★★★★</span>
                        <span class="quills-rating-num"><?php echo esc_html($review_stats['average']); ?></span>
                        <span class="quills-rating-reviews">(<?php echo esc_html($review_stats['total']); ?> reviews)</span>
                    </a>
                </div>

                <!-- Price -->
                <div class="quills-price-box">
                    <span class="quills-price-current" id="quills-dynamic-price"><?php echo $formatted_price; ?></span>
                    <span class="quills-tax-notice">Taxes included. Free shipping on $50+</span>
                </div>

                <!-- Tasting Notes Badges -->
                <div class="quills-tasting-notes-block">
                    <div class="quills-section-label">TASTING NOTES</div>
                    <div class="quills-notes-pills">
                        <?php 
                        $notes_arr = explode(',', $tasting_notes);
                        foreach ($notes_arr as $n): 
                            $trim_n = trim($n);
                            if ($trim_n):
                        ?>
                            <span class="quills-note-pill"><?php echo esc_html(ucwords($trim_n)); ?></span>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>

                <!-- Roast Level Visual Indicator -->
                <div class="quills-roast-meter-block">
                    <div class="quills-section-label">ROAST PROFILE: <strong><?php echo esc_html(strtoupper($roast)); ?></strong></div>
                    <div class="quills-roast-bar">
                        <div class="quills-roast-step <?php echo strtolower($roast) === 'light' ? 'active' : ''; ?>">
                            <span>Light</span>
                        </div>
                        <div class="quills-roast-step <?php echo strtolower($roast) === 'medium' ? 'active' : ''; ?>">
                            <span>Medium</span>
                        </div>
                        <div class="quills-roast-step <?php echo strtolower($roast) === 'dark' ? 'active' : ''; ?>">
                            <span>Dark</span>
                        </div>
                    </div>
                </div>

                <!-- Size Selection Pills -->
                <div class="quills-option-group" id="quills-size-group">
                    <div class="quills-section-label">SIZE: <span id="quills-selected-size-label">12oz</span></div>
                    <div class="quills-pills-row">
                        <button type="button" class="quills-pill-btn active" data-size="12oz" data-multiplier="1.0">12oz</button>
                        <button type="button" class="quills-pill-btn" data-size="2lb" data-multiplier="2.5">2lb (+$35)</button>
                        <button type="button" class="quills-pill-btn" data-size="5lb" data-multiplier="5.4">5lb (+$100)</button>
                    </div>
                </div>

                <!-- Grind Type Selection Pills -->
                <div class="quills-option-group" id="quills-grind-group">
                    <div class="quills-section-label">GRIND TYPE: <span id="quills-selected-grind-label">Whole Bean</span></div>
                    <div class="quills-pills-row quills-grind-pills">
                        <button type="button" class="quills-pill-btn active" data-grind="Whole Bean">Whole Bean</button>
                        <button type="button" class="quills-pill-btn" data-grind="Automatic Drip">Automatic Drip</button>
                        <button type="button" class="quills-pill-btn" data-grind="Espresso">Espresso</button>
                        <button type="button" class="quills-pill-btn" data-grind="Aeropress">Aeropress</button>
                        <button type="button" class="quills-pill-btn" data-grind="Pour Over">Pour Over</button>
                        <button type="button" class="quills-pill-btn" data-grind="Chemex">Chemex</button>
                        <button type="button" class="quills-pill-btn" data-grind="French Press">French Press</button>
                    </div>
                </div>

                <!-- Purchase Type Radio (One-time vs Subscription) -->
                <div class="quills-subscription-toggle">
                    <label class="quills-sub-option active">
                        <input type="radio" name="quills_purchase_type" value="onetime" checked>
                        <div class="quills-sub-info">
                            <span class="quills-sub-title">One-time purchase</span>
                            <span class="quills-sub-price" id="quills-onetime-price-label"><?php echo $formatted_price; ?></span>
                        </div>
                    </label>

                    <label class="quills-sub-option">
                        <input type="radio" name="quills_purchase_type" value="subscribe">
                        <div class="quills-sub-info">
                            <div class="quills-sub-title">
                                Subscribe &amp; Save 10%
                                <span class="quills-badge-save">SAVE 10%</span>
                            </div>
                            <span class="quills-sub-price" id="quills-subscribe-price-label"><?php echo $sub_price; ?></span>
                        </div>
                        <div class="quills-sub-frequency-dropdown">
                            <select id="quills-sub-freq">
                                <option value="2weeks">Deliver every 2 weeks (Most Popular)</option>
                                <option value="4weeks">Deliver every 4 weeks</option>
                                <option value="6weeks">Deliver every 6 weeks</option>
                            </select>
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
                    
                    <!-- Accordion 1: Coffee Details -->
                    <div class="quills-accordion-item open">
                        <button type="button" class="quills-accordion-header">
                            <span>Coffee Details</span>
                            <span class="quills-acc-icon">−</span>
                        </button>
                        <div class="quills-accordion-content">
                            <table class="quills-specs-table">
                                <tbody>
                                    <tr><th>Country</th><td><?php echo esc_html($country); ?></td></tr>
                                    <tr><th>Region</th><td><?php echo esc_html($region); ?></td></tr>
                                    <tr><th>Producer</th><td><?php echo esc_html($producer); ?></td></tr>
                                    <tr><th>Varieties</th><td><?php echo esc_html($varieties); ?></td></tr>
                                    <tr><th>Process</th><td><?php echo esc_html($process); ?></td></tr>
                                    <tr><th>Elevation</th><td><?php echo esc_html($elevation); ?></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Accordion 2: Brewing Guide -->
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
                                    <p><strong>Grind:</strong> Medium-Fine (like kosher sea salt)</p>
                                    <p><strong>Water Temp:</strong> 93°C (200°F)</p>
                                    <p><strong>Total Time:</strong> 2:45 – 3:15 min</p>
                                </div>
                                <div class="quills-brew-card">
                                    <div class="quills-brew-title">ESPRESSO (9 BAR)</div>
                                    <p><strong>Dose:</strong> 18g finely ground coffee</p>
                                    <p><strong>Yield:</strong> 38g liquid espresso</p>
                                    <p><strong>Time:</strong> 27 – 30 seconds</p>
                                    <p><strong>Tasting Note:</strong> Velvety crema &amp; rich cacao</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 3: Sourcing & Story -->
                    <div class="quills-accordion-item">
                        <button type="button" class="quills-accordion-header">
                            <span>The Story</span>
                            <span class="quills-acc-icon">+</span>
                        </button>
                        <div class="quills-accordion-content">
                            <div class="quills-story-body">
                                <?php echo wpautop($product->get_description()); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 4: Shipping & Guarantee -->
                    <div class="quills-accordion-item">
                        <button type="button" class="quills-accordion-header">
                            <span>Shipping &amp; Freshness</span>
                            <span class="quills-acc-icon">+</span>
                        </button>
                        <div class="quills-accordion-content">
                            <p>We roast in small batches on custom-built Diedrich roasters. Your coffee is dispatched in recyclable, one-way degassing valve bags to lock in peak aromatics.</p>
                            <p>Orders placed Monday through Friday ship within 24 to 48 hours.</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</main>

<!-- Reviews Section (Judge.me Style Parity) -->
<section class="quills-reviews-section" id="quills-reviews-section">
    <div class="quills-container">
        
        <div class="quills-reviews-header">
            <h2 class="quills-reviews-title">CUSTOMER REVIEWS</h2>
            <div class="quills-reviews-subtitle">Authentic reviews from verified coffee enthusiasts</div>
        </div>

        <!-- Review Summary Widget -->
        <div class="quills-review-summary-card">
            
            <!-- Left Score -->
            <div class="quills-summary-score">
                <div class="quills-big-rating"><?php echo esc_html($review_stats['average']); ?></div>
                <div class="quills-stars quills-stars--large">★★★★★</div>
                <div class="quills-summary-count">Based on <?php echo esc_html($review_stats['total']); ?> reviews</div>
            </div>

            <!-- Center Distribution Bars -->
            <div class="quills-summary-bars">
                <?php 
                $dist = $review_stats['distribution'];
                $total_reviews = max(1, $review_stats['total']);
                for ($star = 5; $star >= 1; $star--):
                    $cnt = isset($dist[$star]) ? $dist[$star] : 0;
                    $pct = round(($cnt / $total_reviews) * 100);
                ?>
                    <div class="quills-bar-row">
                        <span class="quills-bar-label"><?php echo $star; ?> ★</span>
                        <div class="quills-bar-track">
                            <div class="quills-bar-fill" style="width: <?php echo $pct; ?>%;"></div>
                        </div>
                        <span class="quills-bar-percent"><?php echo $pct; ?>% (<?php echo $cnt; ?>)</span>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- Right CTA Button -->
            <div class="quills-summary-action">
                <button type="button" class="quills-btn-write-review" id="quills-toggle-review-form">
                    WRITE A REVIEW
                </button>
            </div>

        </div>

        <!-- Inline Review Submission Form (Judge.me Style) -->
        <div class="quills-review-form-wrapper" id="quills-review-form-container" style="display: none;">
            <form id="quills-submit-review-form" class="quills-review-form">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($id); ?>">
                <input type="hidden" name="rating" id="quills-input-rating" value="5">

                <h3 class="quills-form-heading">Share Your Experience</h3>
                <p class="quills-form-subheading">How did this coffee brew for you? We'd love your notes!</p>

                <!-- Interactive Star Selector -->
                <div class="quills-form-row">
                    <label>Overall Rating</label>
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
                    <label for="quills-review-title">Review Headline</label>
                    <input type="text" id="quills-review-title" name="title" placeholder="e.g. Delicious sweet cup on my Chemex!" required>
                </div>

                <div class="quills-form-row">
                    <label for="quills-review-content">Comments &amp; Tasting Experience</label>
                    <textarea id="quills-review-content" name="content" rows="4" placeholder="Describe your brew method, grind size, aromas, or how this coffee tasted to you..." required></textarea>
                </div>

                <div class="quills-form-grid-2">
                    <div class="quills-form-row">
                        <label for="quills-review-author">Your Name</label>
                        <input type="text" id="quills-review-author" name="author" placeholder="e.g. Marcus Vance" required>
                    </div>

                    <div class="quills-form-row">
                        <label for="quills-review-email">Email Address</label>
                        <input type="email" id="quills-review-email" name="email" placeholder="e.g. marcus@example.com" required>
                    </div>
                </div>

                <div class="quills-form-row">
                    <label for="quills-review-brew">Brewing Method Used</label>
                    <select id="quills-review-brew" name="brew_method">
                        <option value="Pour Over (V60 / Kalita)">Pour Over (V60 / Kalita)</option>
                        <option value="Espresso Machine">Espresso Machine</option>
                        <option value="Aeropress">Aeropress</option>
                        <option value="Automatic Drip">Automatic Drip</option>
                        <option value="French Press / Cold Brew">French Press / Cold Brew</option>
                        <option value="Moka Pot">Moka Pot</option>
                    </select>
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

        <!-- Reviews Toolbar: Filter by Stars & Sort -->
        <div class="quills-reviews-toolbar">
            <div class="quills-filter-tabs">
                <button type="button" class="quills-filter-tab active" data-filter="all">All (<?php echo esc_html($review_stats['total']); ?>)</button>
                <button type="button" class="quills-filter-tab" data-filter="5">5 Stars (<?php echo isset($dist[5]) ? $dist[5] : 0; ?>)</button>
                <button type="button" class="quills-filter-tab" data-filter="4">4 Stars (<?php echo isset($dist[4]) ? $dist[4] : 0; ?>)</button>
            </div>

            <div class="quills-sort-reviews">
                <label>Sort By:</label>
                <select id="quills-sort-reviews-select">
                    <option value="recent">Most Recent</option>
                    <option value="highest">Highest Rating</option>
                    <option value="helpful">Most Helpful</option>
                </select>
            </div>
        </div>

        <!-- Review Cards List -->
        <div class="quills-reviews-list" id="quills-reviews-list">
            <?php 
            if (!empty($review_stats['comments'])):
                foreach ($review_stats['comments'] as $comm):
                    $c_rating = (int)get_comment_meta($comm->comment_ID, 'rating', true) ?: 5;
                    $c_title  = get_comment_meta($comm->comment_ID, '_quills_review_title', true);
                    $c_brew   = get_comment_meta($comm->comment_ID, '_quills_brew_method', true) ?: 'Pour Over (V60)';
                    $c_helpful = (int)get_comment_meta($comm->comment_ID, '_quills_helpful', true) ?: 4;
                    $c_date   = date('F j, Y', strtotime($comm->comment_date));
            ?>
                <div class="quills-review-card" data-rating="<?php echo esc_attr($c_rating); ?>" data-helpful="<?php echo esc_attr($c_helpful); ?>">
                    <div class="quills-review-card__header">
                        <div class="quills-author-box">
                            <span class="quills-author-name"><?php echo esc_html($comm->comment_author); ?></span>
                            <span class="quills-verified-badge">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Verified Buyer
                            </span>
                        </div>
                        <div class="quills-review-date"><?php echo esc_html($c_date); ?></div>
                    </div>

                    <div class="quills-review-card__meta">
                        <div class="quills-stars quills-stars--card">
                            <?php echo str_repeat('★', $c_rating) . str_repeat('☆', 5 - $c_rating); ?>
                        </div>
                        <span class="quills-brew-pill">Brewed with: <?php echo esc_html($c_brew); ?></span>
                    </div>

                    <?php if ($c_title): ?>
                        <h4 class="quills-review-item-title"><?php echo esc_html($c_title); ?></h4>
                    <?php endif; ?>

                    <div class="quills-review-item-body">
                        <?php 
                        // Strip internal strong tag if duplicated
                        $content_clean = preg_replace('/^<strong>.*?<\/strong>\s*/s', '', $comm->comment_content);
                        echo wpautop(esc_html($content_clean)); 
                        ?>
                    </div>

                    <div class="quills-review-card__footer">
                        <span class="quills-helpful-label">Was this review helpful?</span>
                        <button type="button" class="quills-btn-vote" data-id="<?php echo esc_attr($comm->comment_ID); ?>">
                            👍 <span class="vote-count"><?php echo esc_html($c_helpful); ?></span>
                        </button>
                    </div>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <p class="quills-no-reviews">Be the first to review this exceptional coffee!</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- Related Coffees Section -->
<section class="quills-related-coffees-section">
    <div class="quills-container">
        <div class="quills-related-heading">
            <h2>MORE FROM THE ROASTERY</h2>
            <p>Fresh coffees roasted weekly in Louisville, Kentucky</p>
        </div>

        <div class="quills-products-grid quills-products-grid--4">
            <?php 
            $related = wc_get_products([
                'exclude' => [$id],
                'limit'   => 4,
                'orderby' => 'rand'
            ]);
            foreach ($related as $rel_prod):
                Quills_Coffee_Experience::render_product_card($rel_prod);
            endforeach;
            ?>
        </div>
    </div>
</section>

<!-- Quills Footer -->
<footer class="quills-footer">
    <div class="quills-container quills-footer__inner">
        <div class="quills-footer__col quills-footer__brand">
            <img src="<?php echo esc_url(home_url('/wp-content/uploads/quills/quills_logo.png')); ?>" alt="Quills Coffee" class="quills-footer-logo">
            <p>Specialty coffee roasted with care. Sourced directly from passionate producers across Latin America and East Africa.</p>
            <div class="quills-social-links">
                <a href="https://instagram.com/quillscoffee" target="_blank" rel="noopener">Instagram</a>
                <a href="https://facebook.com/quillscoffee" target="_blank" rel="noopener">Facebook</a>
            </div>
        </div>

        <div class="quills-footer__col">
            <h4>SHOP COFFEE</h4>
            <ul>
                <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?type=Single+Origin">Single Origins</a></li>
                <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?type=Blend">Blends</a></li>
                <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?roast=Light">Light Roasts</a></li>
                <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?category=subscriptions">Coffee Subscriptions</a></li>
            </ul>
        </div>

        <div class="quills-footer__col">
            <h4>ABOUT QUILLS</h4>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Our Story</a></li>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Locations &amp; Cafes</a></li>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Wholesale Program</a></li>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Brewing Guides</a></li>
            </ul>
        </div>

        <div class="quills-footer__col quills-footer__newsletter">
            <h4>JOIN THE COFFEE CLUB</h4>
            <p>Get 10% off your first bag and early access to limited micro-lots.</p>
            <form class="quills-newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Quills Coffee!');">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">JOIN</button>
            </form>
        </div>
    </div>

    <div class="quills-footer__bottom">
        <div class="quills-container">
            <p>&copy; <?php echo date('Y'); ?> Quills Coffee. All rights reserved. Powered by Group A WordPress CMS.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
