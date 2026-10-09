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
$facebook_url    = get_option( 'footer_social_facebook', 'https://facebook.com/' );
$instagram_url   = get_option( 'footer_social_instagram', 'https://instagram.com/' );
$copyright_text  = get_option( 'footer_copyright', '© ' . date('Y') . ', Quills Coffee . Website by Cronk Studios' );

// Replace dynamic year token if present
$copyright_text = str_replace( array('{year}', '%YEAR%'), date('Y'), $copyright_text );
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
                            <li><a href="<?php echo esc_url( home_url( '/barista-application/' ) ); ?>"><?php esc_html_e( 'Barista Application', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'coffee-cafe-corner' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/refund-policy/' ) ); ?>"><?php esc_html_e( 'Refund policy', 'coffee-cafe-corner' ); ?></a></li>
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
                    <svg class="quills-flag-icon" viewBox="0 0 640 480" width="18" height="13">
                        <g fill-rule="evenodd">
                            <path fill="#bd3d44" d="M0 0h640v480H0z"/>
                            <path stroke="#fff" stroke-width="37" d="M0 55.5h640M0 129.5h640M0 203.5h640M0 277.5h640M0 351.5h640M0 425.5h640"/>
                            <path fill="#192f5d" d="M0 0h260v259H0z"/>
                            <circle cx="35" cy="30" r="8" fill="#fff"/>
                            <circle cx="85" cy="30" r="8" fill="#fff"/>
                            <circle cx="135" cy="30" r="8" fill="#fff"/>
                            <circle cx="185" cy="30" r="8" fill="#fff"/>
                            <circle cx="230" cy="30" r="8" fill="#fff"/>
                            <circle cx="60" cy="70" r="8" fill="#fff"/>
                            <circle cx="110" cy="70" r="8" fill="#fff"/>
                            <circle cx="160" cy="70" r="8" fill="#fff"/>
                            <circle cx="210" cy="70" r="8" fill="#fff"/>
                            <circle cx="35" cy="110" r="8" fill="#fff"/>
                            <circle cx="85" cy="110" r="8" fill="#fff"/>
                            <circle cx="135" cy="110" r="8" fill="#fff"/>
                            <circle cx="185" cy="110" r="8" fill="#fff"/>
                            <circle cx="230" cy="110" r="8" fill="#fff"/>
                            <circle cx="60" cy="150" r="8" fill="#fff"/>
                            <circle cx="110" cy="150" r="8" fill="#fff"/>
                            <circle cx="160" cy="150" r="8" fill="#fff"/>
                            <circle cx="210" cy="150" r="8" fill="#fff"/>
                            <circle cx="35" cy="190" r="8" fill="#fff"/>
                            <circle cx="85" cy="190" r="8" fill="#fff"/>
                            <circle cx="135" cy="190" r="8" fill="#fff"/>
                            <circle cx="185" cy="190" r="8" fill="#fff"/>
                            <circle cx="230" cy="190" r="8" fill="#fff"/>
                            <circle cx="60" cy="230" r="8" fill="#fff"/>
                            <circle cx="110" cy="230" r="8" fill="#fff"/>
                            <circle cx="160" cy="230" r="8" fill="#fff"/>
                            <circle cx="210" cy="230" r="8" fill="#fff"/>
                        </g>
                    </svg>
                    <span><?php echo esc_html( $currency ); ?></span>
                    <svg class="quills-chevron" width="8" height="5" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>

                <!-- Language Selector -->
                <div class="quills-selector quills-lang-selector" title="Select Language">
                    <span><?php echo esc_html( $lang ); ?></span>
                    <svg class="quills-chevron" width="8" height="5" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>

                <!-- Social Links -->
                <div class="quills-social-links">
                    <?php if ( ! empty( $facebook_url ) ) : ?>
                        <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="quills-social-icon" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" width="16" height="16"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( ! empty( $instagram_url ) ) : ?>
                        <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="quills-social-icon" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" width="16" height="16"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Payment Badges -->
            <div class="quills-footer-payment">
                <!-- AMEX -->
                <span class="quills-payment-badge" title="American Express">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <text x="19" y="15" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="7.5" font-weight="900" letter-spacing="0.5" text-anchor="middle">AMEX</text>
                    </svg>
                </span>

                <!-- Apple Pay -->
                <span class="quills-payment-badge" title="Apple Pay">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <g fill="#ffffff">
                            <path d="M13.5 11.2c-.3.4-.8.7-1.3.6-.1-.5.2-1 .5-1.3.3-.4.8-.6 1.2-.6.1.5-.1 1-.4 1.3zm1.4 3.7c-.3.5-.6.9-1.1.9-.4 0-.6-.3-1.1-.3-.5 0-.7.3-1.1.3-.5 0-.9-.5-1.2-1-.6-1.1-.5-2.5.2-3.1.4-.4 1-.5 1.4-.2.4.2.6.4.9.4.3 0 .6-.2.9-.4.3-.2.8-.2 1.2.1.2.1.4.3.5.6-.5.3-.8.8-.7 1.4.1.6.4 1 .8 1.3-.2.3-.3.7-.5 1z"/>
                            <text x="21" y="15" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="8" font-weight="700">Pay</text>
                        </g>
                    </svg>
                </span>

                <!-- Diners Club -->
                <span class="quills-payment-badge" title="Diners Club">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <circle cx="16" cy="12" r="5" fill="none" stroke="#ffffff" stroke-width="1.2"/>
                        <circle cx="22" cy="12" r="5" fill="none" stroke="#ffffff" stroke-width="1.2"/>
                        <path d="M19 8.2v7.6" stroke="#ffffff" stroke-width="1.2"/>
                    </svg>
                </span>

                <!-- Discover -->
                <span class="quills-payment-badge" title="Discover">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <text x="19" y="14" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="6" font-weight="800" letter-spacing="0.4" text-anchor="middle">DISCOVER</text>
                    </svg>
                </span>

                <!-- Google Pay -->
                <span class="quills-payment-badge" title="Google Pay">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <text x="14" y="15" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="8.5" font-weight="900">G</text>
                        <text x="22" y="15" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="7.5" font-weight="600">Pay</text>
                    </svg>
                </span>

                <!-- Mastercard -->
                <span class="quills-payment-badge" title="Mastercard">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <circle cx="15.5" cy="12" r="5" fill="#ffffff" fill-opacity="0.8"/>
                        <circle cx="22.5" cy="12" r="5" fill="#ffffff" fill-opacity="0.6"/>
                    </svg>
                </span>

                <!-- Shop Pay -->
                <span class="quills-payment-badge" title="Shop Pay">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <circle cx="13" cy="12" r="3.5" fill="none" stroke="#ffffff" stroke-width="1.2"/>
                        <text x="22" y="15" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="7.5" font-weight="700">Pay</text>
                    </svg>
                </span>

                <!-- Visa -->
                <span class="quills-payment-badge" title="Visa">
                    <svg viewBox="0 0 38 24" width="38" height="24">
                        <rect width="38" height="24" rx="3" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-width="1"/>
                        <text x="19" y="15.5" fill="#ffffff" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="8.5" font-weight="900" font-style="italic" letter-spacing="0.5" text-anchor="middle">VISA</text>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Copyright -->
        <div class="quills-footer-copyright">
            <p><?php echo wp_kses_post( $copyright_text ); ?></p>
        </div>
    </div>
</div>