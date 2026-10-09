<?php
/**
 * Title: Header
 * Slug: coffee-cafe-corner/header
 * Categories: header
 * Block Types: core/template-part/header
 */
?>

<!-- wp:html -->
<div id="quills-header-wrapper" class="quills-header-wrapper">
  <div class="quills-header-top">
    <div class="quills-header-container">
      
      <!-- Left: Inline Search Box -->
      <div class="quills-header-left">
        <form role="search" method="get" class="quills-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <button type="submit" class="quills-search-btn" aria-label="<?php esc_attr_e( 'Search', 'coffee-cafe-corner' ); ?>">
            <svg class="quills-icon quills-icon--search" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#151515" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="7.5"></circle>
              <line x1="21" y1="21" x2="16.5" y2="16.5"></line>
            </svg>
          </button>
          <input type="search" class="quills-search-input" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
        </form>
      </div>

      <!-- Center: Logo -->
      <div class="quills-header-center">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-logo-link" rel="home">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/quills-logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="quills-logo-img" />
        </a>
      </div>

      <!-- Right: Currency, Account, Cart -->
      <div class="quills-header-right">
        <!-- Currency Selector -->
        <div class="quills-currency-wrap" tabindex="0" role="button" aria-label="<?php esc_attr_e( 'Currency selector', 'coffee-cafe-corner' ); ?>">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/us-flag.svg' ); ?>" alt="USD" class="quills-flag-img" width="22" height="15" />
          <span class="quills-currency-code">USD</span>
          <svg class="quills-icon quills-icon--chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#151515" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </div>

        <!-- Account Link -->
        <a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink( 'myaccount' ) : home_url('/my-account/') ); ?>" class="quills-icon-link quills-account-link" aria-label="<?php esc_attr_e( 'Account', 'coffee-cafe-corner' ); ?>">
          <svg class="quills-icon quills-icon--user" width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="user">
              <path fill="#151515" d="m14,2.44897a11.272,11.272 0 1 0 11.272,11.272a11.289,11.289 0 0 0 -11.272,-11.272zm0,1.734a9.545,9.545 0 0 1 7.343,15.634a7.842,7.842 0 0 0 -4.415,-4.653a4.335,4.335 0 1 0 -5.853,0a7.831,7.831 0 0 0 -4.41,4.654a9.539,9.539 0 0 1 7.335,-15.635zm0,5.2a2.6,2.6 0 1 1 -2.6,2.6a2.585,2.585 0 0 1 2.6,-2.597l0,-0.003zm0,6.937a6.047,6.047 0 0 1 5.928,4.873a9.526,9.526 0 0 1 -11.848,0a6.034,6.034 0 0 1 5.92,-4.871l0,-0.002z" />
            </g>
          </svg>
        </a>

        <!-- Cart Link with Badge -->
        <a href="<?php echo esc_url( function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/') ); ?>" class="quills-icon-link quills-cart-link" aria-label="<?php esc_attr_e( 'Cart', 'coffee-cafe-corner' ); ?>">
          <div class="quills-cart-icon-wrapper">
            <svg class="quills-icon quills-icon--cart" width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g id="cart">
                <path fill="#151515" d="m1.87025,4a0.87,0.87 0 1 0 0,1.741l1.6,0a0.863,0.863 0 0 1 0.854,0.707l0.173,0.907l1.871,9.827a3.782,3.782 0 0 0 3.706,3.065l10.864,0a3.781,3.781 0 0 0 3.706,-3.065l1.871,-9.827a0.87,0.87 0 0 0 -0.854,-1.034l-19.59,0l-0.037,-0.2a2.62,2.62 0 0 0 -2.565,-2.121l-1.599,0zm4.53,4.062l18.2,0l-1.675,8.794a2.022,2.022 0 0 1 -2,1.65l-10.851,0a2.023,2.023 0 0 1 -2,-1.65l0,0l-1.674,-8.794zm5.041,13.345a1.741,1.741 0 1 0 1.741,1.741a1.741,1.741 0 0 0 -1.738,-1.741l-0.003,0zm8.123,0a1.741,1.741 0 1 0 1.741,1.741a1.741,1.741 0 0 0 -1.738,-1.741l-0.003,0z" />
              </g>
            </svg>
            <span class="quills-cart-badge"><?php 
              $cart_count = 1;
              if ( function_exists('WC') && WC()->cart ) {
                $wc_count = WC()->cart->get_cart_contents_count();
                if ( $wc_count > 0 ) {
                  $cart_count = $wc_count;
                }
              }
              echo esc_html( $cart_count );
            ?></span>
          </div>
        </a>

        <!-- Mobile Menu Toggle Button -->
        <button class="quills-mobile-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'coffee-cafe-corner' ); ?>" onclick="var menu = document.getElementById('quills-nav-menu'); if(menu) menu.classList.toggle('is-open');">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#151515" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>

      </div>
    </div>
  </div>

  <!-- Divider Line (Contained) -->
  <div class="quills-divider-container">
    <div class="quills-header-divider"></div>
  </div>

  <!-- Bottom Row: Centered Navigation Menu -->
  <nav class="quills-header-bottom" id="quills-nav-menu" aria-label="<?php esc_attr_e( 'Primary Navigation', 'coffee-cafe-corner' ); ?>">
    <ul class="quills-nav-list">
      <li class="quills-nav-item"><a href="<?php echo esc_url( home_url('/shop/') ); ?>" class="quills-nav-link">COFFEE</a></li>
      <li class="quills-nav-item"><a href="<?php echo esc_url( home_url('/subscriptions/') ); ?>" class="quills-nav-link">SUBSCRIPTIONS</a></li>
      <li class="quills-nav-item"><a href="<?php echo esc_url( home_url('/brew-gear/') ); ?>" class="quills-nav-link">BREW GEAR</a></li>
      <li class="quills-nav-item"><a href="<?php echo esc_url( home_url('/merch/') ); ?>" class="quills-nav-link">MERCH</a></li>
      <li class="quills-nav-item"><a href="<?php echo esc_url( home_url('/gift-cards/') ); ?>" class="quills-nav-link">GIFT CARDS</a></li>
      <li class="quills-nav-item"><a href="<?php echo esc_url( home_url('/visit/') ); ?>" class="quills-nav-link">VISIT</a></li>
      <li class="quills-nav-item"><a href="<?php echo esc_url( home_url('/about/') ); ?>" class="quills-nav-link">ABOUT</a></li>
    </ul>
  </nav>
</div>
<!-- /wp:html -->