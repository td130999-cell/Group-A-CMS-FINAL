<?php
/**
 * Title: Footer
 * Slug: coffee-cafe-corner/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 */

// Fetch dynamic data from database
$brand_name      = get_option( 'footer_brand_name', 'QUILLS COFFEE' );
$address_street  = get_option( 'footer_address_street', '800 E Main Street' );
$address_city    = get_option( 'footer_address_city', 'Louisville, KY 40206' );
$phone           = get_option( 'footer_phone', '502-861-5844' );
$email           = get_option( 'footer_email', 'hello@quillscoffee.com' );
$currency        = get_option( 'footer_currency', function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'USD' );
$lang            = get_option( 'footer_lang', 'EN' );
$facebook_url    = get_option( 'footer_social_facebook', 'https://www.facebook.com/quillscoffee' );
$instagram_url   = get_option( 'footer_social_instagram', 'https://www.instagram.com/quillscoffee' );
$copyright_text  = get_option( 'footer_copyright', '© ' . date('Y') . ' Group CMS A' );

// Replace dynamic year token if present
$copyright_text = str_replace( array('{year}', '%YEAR%'), date('Y'), $copyright_text );
$theme_url      = trailingslashit( get_template_directory_uri() );
?>

<div class="quills-footer-wrapper">
    <div class="quills-footer-container">
        <!-- 3 Columns Section -->
        <div class="quills-footer-top">
            <!-- Column 1: Brand & Contact Info -->
            <div class="quills-footer-col quills-footer-brand">
                <h4 class="quills-footer-title"><?php echo esc_html( $brand_name ); ?></h4>
                <div class="quills-footer-contact">
                    <?php if ( ! empty( $address_street ) ) : ?>
                        <p class="quills-contact-line"><?php echo esc_html( $address_street ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $address_city ) ) : ?>
                        <p class="quills-contact-line"><?php echo esc_html( $address_city ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $phone ) ) : ?>
                        <p class="quills-contact-line">T: <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $phone) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $email ) ) : ?>
                        <p class="quills-contact-line">E: <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="quills-footer-col quills-footer-links">
                <h4 class="quills-footer-title"><?php esc_html_e( 'QUICK LINKS', 'coffee-cafe-corner' ); ?></h4>
                <?php
                if ( has_nav_menu( 'footer-quick-links' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-quick-links',
                        'container'      => false,
                        'menu_class'     => 'quills-footer-menu',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ) );
                } else {
                    $quick_menu = wp_get_nav_menu_object( 'Quick Links' );
                    if ( $quick_menu ) {
                        wp_nav_menu( array(
                            'menu'        => $quick_menu->term_id,
                            'container'   => false,
                            'menu_class'  => 'quills-footer-menu',
                            'fallback_cb' => false,
                            'depth'       => 1,
                        ) );
                    } else {
                        ?>
                        <ul class="quills-footer-menu">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About Us', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php esc_html_e( 'Email Us', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="https://form.jotform.com/quillscoffee/new-customer-registration-form" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Barista Application', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/refund-policy/' ) ); ?>"><?php esc_html_e( 'Refund policy', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/wholesale/' ) ); ?>"><?php esc_html_e( 'Wholesale', 'coffee-cafe-corner' ); ?></a></li>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>

            <!-- Column 3: Company -->
            <div class="quills-footer-col quills-footer-company">
                <h4 class="quills-footer-title"><?php esc_html_e( 'COMPANY', 'coffee-cafe-corner' ); ?></h4>
                <?php
                if ( has_nav_menu( 'footer-company' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-company',
                        'container'      => false,
                        'menu_class'     => 'quills-footer-menu',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ) );
                } else {
                    $company_menu = wp_get_nav_menu_object( 'Company' );
                    if ( $company_menu ) {
                        wp_nav_menu( array(
                            'menu'        => $company_menu->term_id,
                            'container'   => false,
                            'menu_class'  => 'quills-footer-menu',
                            'fallback_cb' => false,
                            'depth'       => 1,
                        ) );
                    } else {
                        ?>
                        <ul class="quills-footer-menu">
                            <li><a href="<?php echo esc_url( home_url( '/coffee/' ) ); ?>"><?php esc_html_e( 'Coffee', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/subscriptions/' ) ); ?>"><?php esc_html_e( 'Subscriptions', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/brew-gear/' ) ); ?>"><?php esc_html_e( 'Brew Gear', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/wholesale/' ) ); ?>"><?php esc_html_e( 'Wholesale', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/merch/' ) ); ?>"><?php esc_html_e( 'Merch', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/gift-cards/' ) ); ?>"><?php esc_html_e( 'Gift Cards', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>"><?php esc_html_e( 'Visit', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'coffee-cafe-corner' ); ?></a></li>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <!-- Bottom Controls & Payment Row -->
        <div class="quills-footer-bottom">
            <!-- Left: Currency, Language & Socials -->
            <div class="quills-footer-left">
                <!-- Currency Selector -->
                <div class="quills-selector quills-currency-selector" title="Select Currency">
                    <img src="<?php echo esc_url( $theme_url . 'assets/images/us.svg' ); ?>" alt="United States" width="22" height="15" class="quills-flag-icon" />
                    <span><?php echo esc_html( $currency ); ?></span>
                    <svg class="quills-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>

                <!-- Language Selector Dropdown integrated with GTranslate -->
                <div class="quills-selector quills-lang-selector" id="quillsFooterLangSelector" title="Select Language" tabindex="0" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="quills-current-lang-text"><?php echo esc_html( $lang ); ?></span>
                    <svg class="quills-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    
                    <div class="quills-lang-dropdown notranslate" id="quillsFooterLangDropdown">
                        <button type="button" class="quills-lang-option active" data-lang="en">
                            <span class="quills-lang-flag">🇺🇸</span>
                            <span class="quills-lang-name">English</span>
                            <span class="quills-lang-check">✓</span>
                        </button>
                        <button type="button" class="quills-lang-option" data-lang="vi">
                            <span class="quills-lang-flag">🇻🇳</span>
                            <span class="quills-lang-name">Viet Nam</span>
                            <span class="quills-lang-check">✓</span>
                        </button>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="quills-social-links">
                    <?php if ( ! empty( $facebook_url ) ) : ?>
                        <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="quills-social-icon" aria-label="Facebook">
                            <svg viewBox="0 0 72 72" width="18" height="18"><path fill="currentColor" d="m50.05584,39.77451l1.67724,-10.93484l-10.49061,0l0,-7.10195a5.46742,5.46742 0 0 1 6.17078,-5.89741l4.76975,0l0,-9.3117a58.1654,58.1654 0 0 0 -8.47166,-0.73754c-8.64251,0 -14.28934,5.23677 -14.28934,14.71647l0,8.33497l-9.60501,0l0,10.93484l9.60501,0l0,26.43157l11.82046,0l0,-26.43442l8.81337,0l0,-0.00001z" /></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( ! empty( $instagram_url ) ) : ?>
                        <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="quills-social-icon" aria-label="Instagram">
                            <svg viewBox="0 0 511 511.9" width="18" height="18"><path fill="currentColor" d="m510.949219 150.5c-1.199219-27.199219-5.597657-45.898438-11.898438-62.101562-6.5-17.199219-16.5-32.597657-29.601562-45.398438-12.800781-13-28.300781-23.101562-45.300781-29.5-16.296876-6.300781-34.898438-10.699219-62.097657-11.898438-27.402343-1.300781-36.101562-1.601562-105.601562-1.601562s-78.199219.300781-105.5 1.5c-27.199219 1.199219-45.898438 5.601562-62.097657 11.898438-17.203124 6.5-32.601562 16.5-45.402343 29.601562-13 12.800781-23.097657 28.300781-29.5 45.300781-6.300781 16.300781-10.699219 34.898438-11.898438 62.097657-1.300781 27.402343-1.601562 36.101562-1.601562 105.601562s.300781 78.199219 1.5 105.5c1.199219 27.199219 5.601562 45.898438 11.902343 62.101562 6.5 17.199219 16.597657 32.597657 29.597657 45.398438 12.800781 13 28.300781 23.101562 45.300781 29.5 16.300781 6.300781 34.898438 10.699219 62.101562 11.898438 27.296876 1.203124 36 1.5 105.5 1.5s78.199219-.296876 105.5-1.5c27.199219-1.199219 45.898438-5.597657 62.097657-11.898438 34.402343-13.300781 61.601562-40.5 74.902343-74.898438 6.296876-16.300781 10.699219-34.902343 11.898438-62.101562 1.199219-27.300781 1.5-36 1.5-105.5s-.101562-78.199219-1.300781-105.5zm-46.097657 209c-1.101562 25-5.300781 38.5-8.800781 47.5-8.601562 22.300781-26.300781 40-48.601562 48.601562-9 3.5-22.597657 7.699219-47.5 8.796876-27 1.203124-35.097657 1.5-103.398438 1.5s-76.5-.296876-103.402343-1.5c-25-1.097657-38.5-5.296876-47.5-8.796876-11.097657-4.101562-21.199219-10.601562-29.398438-19.101562-8.5-8.300781-15-18.300781-19.101562-29.398438-3.5-9-7.699219-22.601562-8.796876-47.5-1.203124-27-1.5-35.101562-1.5-103.402343s.296876-76.5 1.5-103.398438c1.097657-25 5.296876-38.5 8.796876-47.5 4.101562-11.101562 10.601562-21.199219 19.203124-29.402343 8.296876-8.5 18.296876-15 29.398438-19.097657 9-3.5 22.601562-7.699219 47.5-8.800781 27-1.199219 35.101562-1.5 103.398438-1.5 68.402343 0 76.5.300781 103.402343 1.5 25 1.101562 38.5 5.300781 47.5 8.800781 11.097657 4.097657 21.199219 10.597657 29.398438 19.097657 8.5 8.300781 15 18.300781 19.101562 29.402343 3.5 9 7.699219 22.597657 8.800781 47.5 1.199219 27 1.5 35.097657 1.5 103.398438s-.300781 76.300781-1.5 103.300781zm0 0"/><path fill="currentColor" d="m256.449219 124.5c-72.597657 0-131.5 58.898438-131.5 131.5s58.902343 131.5 131.5 131.5c72.601562 0 131.5-58.898438 131.5-131.5s-58.898438-131.5-131.5-131.5zm0 216.800781c-47.097657 0-85.300781-38.199219-85.300781-85.300781s38.203124-85.300781 85.300781-85.300781c47.101562 0 85.300781 38.199219 85.300781 85.300781s-38.199219 85.300781-85.300781 85.300781zm0 0"/><path fill="currentColor" d="m423.851562 119.300781c0 16.953125-13.746093 30.699219-30.703124 30.699219-16.953126 0-30.699219-13.746094-30.699219-30.699219 0-16.957031 13.746093-30.699219 30.699219-30.699219 16.957031 0 30.703124 13.742188 30.703124 30.699219zm0 0"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Payment Methods Authentic Strip -->
            <div class="quills-footer-payment">
                <img src="<?php echo esc_url( $theme_url . 'assets/images/pm.svg' ); ?>" alt="Payment methods" class="quills-footer-payment-img" width="360" height="24" loading="lazy" />
            </div>
        </div>

        <!-- Copyright -->
        <div class="quills-footer-copyright">
            <p><?php echo wp_kses_post( $copyright_text ); ?></p>
        </div>
    </div>
</div>

<script>
(function() {
    function initQuillsFooterLang() {
        var selector = document.getElementById('quillsFooterLangSelector');
        var dropdown = document.getElementById('quillsFooterLangDropdown');
        if (!selector || !dropdown) return;

        var label = selector.querySelector('.quills-current-lang-text');
        var options = dropdown.querySelectorAll('.quills-lang-option');

        // Toggle open/close
        selector.addEventListener('click', function(e) {
            if (e.target.closest('.quills-lang-option')) return;
            e.stopPropagation();
            var isOpen = selector.classList.toggle('is-open');
            selector.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        // Close on click outside
        document.addEventListener('click', function(e) {
            if (!selector.contains(e.target)) {
                selector.classList.remove('is-open');
                selector.setAttribute('aria-expanded', 'false');
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && selector.classList.contains('is-open')) {
                selector.classList.remove('is-open');
                selector.setAttribute('aria-expanded', 'false');
                selector.focus();
            }
        });

        // Trigger translation
        function switchLanguage(targetLang) {
            targetLang = (targetLang || 'en').toLowerCase();
            
            // Update UI state
            if (label) {
                label.textContent = targetLang.toUpperCase();
            }
            options.forEach(function(opt) {
                if (opt.getAttribute('data-lang') === targetLang) {
                    opt.classList.add('active');
                } else {
                    opt.classList.remove('active');
                }
            });

            // Call GTranslate
            if (typeof window.doGTranslate === 'function') {
                window.doGTranslate('en|' + targetLang);
            } else {
                var script = document.createElement('script');
                script.src = 'https://cdn.gtranslate.net/widgets/latest/lib.min.js';
                script.onload = function() {
                    if (window.__GT && window.__GT.translator) {
                        window.__GT.translator.translate('en', targetLang);
                    }
                };
                document.body.appendChild(script);
            }

            try {
                localStorage.setItem('quills_user_lang', targetLang);
            } catch(e) {}
        }

        // Attach click event to options
        options.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var targetLang = btn.getAttribute('data-lang');
                switchLanguage(targetLang);
                selector.classList.remove('is-open');
                selector.setAttribute('aria-expanded', 'false');
            });
        });

        // Sync initial state on load
        function syncCurrentLang() {
            var current = 'en';
            try {
                var stored = JSON.parse(localStorage.getItem('__GT_TRANSLATE_LANGS'));
                if (stored && stored.tgtLang) {
                    current = stored.tgtLang;
                } else if (localStorage.getItem('quills_user_lang')) {
                    current = localStorage.getItem('quills_user_lang');
                } else if (document.cookie.indexOf('googtrans=/en/vi') !== -1) {
                    current = 'vi';
                }
            } catch(e) {}

            if (label) label.textContent = current.toUpperCase();
            options.forEach(function(opt) {
                if (opt.getAttribute('data-lang') === current) {
                    opt.classList.add('active');
                } else {
                    opt.classList.remove('active');
                }
            });
        }

        syncCurrentLang();
        setTimeout(syncCurrentLang, 500);
        setTimeout(syncCurrentLang, 1500);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initQuillsFooterLang);
    } else {
        initQuillsFooterLang();
    }
})();
</script>