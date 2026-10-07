<?php
/**
 * Quills Coffee - Collection / Shop Page Template with Faceted Live Filters
 * Replicating https://quillscoffee.com/collections/coffee 100%
 */

if (!defined('ABSPATH')) {
    exit;
}

$all_products = wc_get_products([
    'limit'   => -1,
    'status'  => 'publish',
    'orderby' => 'date',
    'order'   => 'DESC'
]);

$total_count = count($all_products);

// Calculate dynamic facet counts
$counts_process = ['Washed' => 0, 'Natural' => 0, 'Honey' => 0, 'Washed & Natural' => 0];
$counts_roast   = ['Light' => 0, 'Medium' => 0, 'Dark' => 0];
$counts_type    = ['Single Origin' => 0, 'Blend' => 0];

foreach ($all_products as $p) {
    $proc = get_post_meta($p->get_id(), '_quills_process', true);
    $rst  = get_post_meta($p->get_id(), '_quills_roast_profile', true);
    $typ  = get_post_meta($p->get_id(), '_quills_coffee_type', true);

    if (isset($counts_process[$proc])) $counts_process[$proc]++;
    if (isset($counts_roast[$rst])) $counts_roast[$rst]++;
    if (isset($counts_type[$typ])) $counts_type[$typ]++;
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Coffees | Quills Coffee</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('quills-body quills-archive-page'); ?>>

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

<!-- Collection Hero Banner -->
<section class="quills-collection-hero">
    <div class="quills-container">
        <ul class="quills-breadcrumbs">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
            <li><span class="sep">/</span></li>
            <li class="active">Collections</li>
            <li><span class="sep">/</span></li>
            <li class="active">Coffees</li>
        </ul>

        <div class="quills-collection-hero__content">
            <h1 class="quills-collection-hero__title">COFFEES</h1>
            <p class="quills-collection-hero__desc">
                From vibrant, fruit-forward single origins to rich, chocolatey signature blends roasted weekly on custom Diedrich roasters. Ethically sourced and delivered fresh to your door.
            </p>
        </div>
    </div>
</section>

<!-- Collection Main Section: Filters Sidebar & Product Grid -->
<main class="quills-collection-main">
    <div class="quills-container">
        
        <!-- Top Toolbar: Active Filters, Counter, Sort -->
        <div class="quills-collection-toolbar">
            <div class="quills-toolbar__left">
                <span class="quills-results-count" id="quills-results-count">Showing <strong><?php echo esc_html($total_count); ?></strong> coffees</span>
                <div class="quills-active-facets" id="quills-active-facets">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>

            <div class="quills-toolbar__right">
                <div class="quills-sort-box">
                    <label for="quills-sort-select">Sort by:</label>
                    <select id="quills-sort-select" class="quills-sort-select">
                        <option value="featured">Featured</option>
                        <option value="price-ascending">Price: Low to High</option>
                        <option value="price-descending">Price: High to Low</option>
                        <option value="title-ascending">Alphabetically: A-Z</option>
                        <option value="title-descending">Alphabetically: Z-A</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 2-Column Layout -->
        <div class="quills-collection-layout">
            
            <!-- Left Sidebar: Faceted Filters (Exact Quills Structure) -->
            <aside class="quills-filter-sidebar" id="quills-filter-sidebar">
                <div class="quills-filter-sidebar__header">
                    <h3>FILTER COFFEES</h3>
                    <button type="button" class="quills-clear-all-btn" id="quills-clear-all-sidebar">Clear All</button>
                </div>

                <form id="quills-filter-form" class="quills-filter-form">
                    
                    <!-- Filter Group 1: Process -->
                    <div class="quills-filter-group open">
                        <div class="quills-filter-group__header">
                            <span>Process (Sơ chế)</span>
                            <span class="quills-filter-toggle-icon">−</span>
                        </div>
                        <div class="quills-filter-group__body">
                            <?php foreach ($counts_process as $proc_name => $count): ?>
                                <label class="quills-filter-checkbox">
                                    <input type="checkbox" name="process[]" value="<?php echo esc_attr($proc_name); ?>">
                                    <span class="quills-checkbox-custom"></span>
                                    <span class="quills-checkbox-label"><?php echo esc_html($proc_name); ?></span>
                                    <span class="quills-checkbox-count">(<?php echo esc_html($count); ?>)</span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Filter Group 2: Roast Profile -->
                    <div class="quills-filter-group open">
                        <div class="quills-filter-group__header">
                            <span>Roast Profile (Mức rang)</span>
                            <span class="quills-filter-toggle-icon">−</span>
                        </div>
                        <div class="quills-filter-group__body">
                            <?php foreach ($counts_roast as $roast_name => $count): ?>
                                <label class="quills-filter-checkbox">
                                    <input type="checkbox" name="roast[]" value="<?php echo esc_attr($roast_name); ?>">
                                    <span class="quills-checkbox-custom"></span>
                                    <span class="quills-checkbox-label"><?php echo esc_html($roast_name); ?></span>
                                    <span class="quills-checkbox-count">(<?php echo esc_html($count); ?>)</span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Filter Group 3: Coffee Type -->
                    <div class="quills-filter-group open">
                        <div class="quills-filter-group__header">
                            <span>Coffee Type (Dòng cà phê)</span>
                            <span class="quills-filter-toggle-icon">−</span>
                        </div>
                        <div class="quills-filter-group__body">
                            <?php foreach ($counts_type as $type_name => $count): ?>
                                <label class="quills-filter-checkbox">
                                    <input type="checkbox" name="type[]" value="<?php echo esc_attr($type_name); ?>">
                                    <span class="quills-checkbox-custom"></span>
                                    <span class="quills-checkbox-label"><?php echo esc_html($type_name); ?></span>
                                    <span class="quills-checkbox-count">(<?php echo esc_html($count); ?>)</span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Filter Group 4: Price Range -->
                    <div class="quills-filter-group open">
                        <div class="quills-filter-group__header">
                            <span>Price (Khoảng giá)</span>
                            <span class="quills-filter-toggle-icon">−</span>
                        </div>
                        <div class="quills-filter-group__body">
                            <label class="quills-filter-checkbox">
                                <input type="checkbox" name="price[]" value="under-21">
                                <span class="quills-checkbox-custom"></span>
                                <span class="quills-checkbox-label">Under $21</span>
                            </label>
                            <label class="quills-filter-checkbox">
                                <input type="checkbox" name="price[]" value="21-23">
                                <span class="quills-checkbox-custom"></span>
                                <span class="quills-checkbox-label">$21 – $23</span>
                            </label>
                            <label class="quills-filter-checkbox">
                                <input type="checkbox" name="price[]" value="over-23">
                                <span class="quills-checkbox-custom"></span>
                                <span class="quills-checkbox-label">Over $23</span>
                            </label>
                        </div>
                    </div>

                </form>
            </aside>

            <!-- Right Column: Product Cards Grid -->
            <div class="quills-collection-grid-area">
                
                <!-- Loading Overlay -->
                <div class="quills-grid-loader" id="quills-grid-loader" style="display: none;">
                    <div class="quills-spinner"></div>
                </div>

                <!-- Products Container -->
                <div class="quills-products-grid quills-products-grid--3" id="quills-products-container">
                    <?php 
                    foreach ($all_products as $prod) {
                        Quills_Coffee_Experience::render_product_card($prod);
                    }
                    ?>
                </div>

            </div>

        </div>

    </div>
</main>

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
