<?php
/**
 * Title: Gift Cards
 * Slug: coffee-cafe-corner/gift-cards
 * Categories: coffee-cafe-corner
 * Keywords: gift cards, voucher, quills coffee
 */

$img_dir = get_template_directory_uri() . '/assets/images/gift-cards/';

$gift_card_prod = class_exists( 'Coffee_Cafe_Corner_Quills_Products_DB' )
  ? Coffee_Cafe_Corner_Quills_Products_DB::get_gift_card_product()
  : null;

$default_online_url = $gift_card_prod ? get_permalink( $gift_card_prod->get_id() ) : home_url( '/product/gift-card/' );
$default_online_img = ( $gift_card_prod && $gift_card_prod->get_image_id() )
  ? ( wp_get_attachment_image_url( $gift_card_prod->get_image_id(), 'full' ) ?: ( $img_dir . 'online-gift-card.png' ) )
  : ( $img_dir . 'online-gift-card.png' );

$default_cafe_url   = 'https://app.squareup.com/gift/YYF6MF7Z4KF6C/order';
$default_cafe_img   = $img_dir . 'cafe-gift-card.png';

// Dynamic Database Values
$giftcards_title        = get_option( 'quills_giftcards_title', 'Gift Cards' );
$giftcards_intro_p1     = get_option( 'quills_giftcards_intro_p1', 'We sell two different types of gift cards: one for the online store, and the other for use in our cafes.' );
$giftcards_intro_p2     = get_option( 'quills_giftcards_intro_p2', 'Please make sure choose the right gift card for your lucky recipient, as they are not interchangeable.' );

$online_card_title      = get_option( 'quills_giftcards_online_title', 'ONLINE STORE GIFT CARD' );
$custom_online_img      = get_option( 'quills_giftcards_online_img', '' );
$online_gift_card_img   = ! empty( $custom_online_img ) ? $custom_online_img : $default_online_img;

$online_desc_1          = get_option( 'quills_giftcards_online_desc_1', 'A gift card that can be used to order whole bean coffee, merchandise, and more <strong>from our website.</strong>' );
$online_desc_2          = get_option( 'quills_giftcards_online_desc_2', '<strong>This type of gift card is not valid in our cafes.</strong>' );
$online_btn_text        = get_option( 'quills_giftcards_online_btn_text', 'CLICK HERE TO PURCHASE' );
$custom_online_url      = get_option( 'quills_giftcards_online_btn_url', '' );
$online_gift_card_url   = ! empty( $custom_online_url ) ? $custom_online_url : $default_online_url;

$cafe_card_title        = get_option( 'quills_giftcards_cafe_title', 'CAFE / IN STORE GIFT CARD' );
$custom_cafe_img        = get_option( 'quills_giftcards_cafe_img', '' );
$cafe_gift_card_img     = ! empty( $custom_cafe_img ) ? $custom_cafe_img : $default_cafe_img;

$cafe_desc_1            = get_option( 'quills_giftcards_cafe_desc_1', 'A gift card that can be used in any of our <strong>cafe locations</strong> towards drinks, food, whole bean coffee, and more.' );
$cafe_desc_2            = get_option( 'quills_giftcards_cafe_desc_2', '<strong>This type of gift card is not valid for the online store.</strong>' );
$cafe_btn_text          = get_option( 'quills_giftcards_cafe_btn_text', 'CLICK HERE TO PURCHASE' );
$custom_cafe_url        = get_option( 'quills_giftcards_cafe_btn_url', '' );
$cafe_gift_card_url     = ! empty( $custom_cafe_url ) ? $custom_cafe_url : $default_cafe_url;
?>

<!-- wp:html -->
<div class="quills-giftcards-wrapper">
  <div class="quills-giftcards-container">

    <!-- Header Section -->
    <header class="quills-giftcards-header">
      <h1 class="quills-giftcards-title"><?php echo esc_html( $giftcards_title ); ?></h1>
      <div class="quills-giftcards-intro">
        <?php if ( ! empty( $giftcards_intro_p1 ) ) : ?>
          <p><?php echo wp_kses_post( $giftcards_intro_p1 ); ?></p>
        <?php endif; ?>
        <?php if ( ! empty( $giftcards_intro_p2 ) ) : ?>
          <p><?php echo wp_kses_post( $giftcards_intro_p2 ); ?></p>
        <?php endif; ?>
      </div>
    </header>

    <!-- 2 Columns Grid: Online & Cafe Cards -->
    <div class="quills-giftcards-grid">

      <!-- Column 1: ONLINE STORE GIFT CARD -->
      <article class="quills-giftcard-card">
        <div class="quills-giftcard-img-box">
          <a href="<?php echo esc_url( $online_gift_card_url ); ?>" aria-label="<?php echo esc_attr( $online_card_title . ' - Quills Coffee' ); ?>">
            <img src="<?php echo esc_url( $online_gift_card_img ); ?>" alt="<?php echo esc_attr( $online_card_title . ' - Quills Coffee' ); ?>" class="quills-giftcard-img" loading="lazy" />
          </a>
        </div>
        <div class="quills-giftcard-body">
          <h2 class="quills-giftcard-name"><?php echo esc_html( $online_card_title ); ?></h2>
          <div class="quills-giftcard-desc">
            <?php if ( ! empty( $online_desc_1 ) ) : ?>
              <p><?php echo wp_kses_post( $online_desc_1 ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $online_desc_2 ) ) : ?>
              <p><?php echo wp_kses_post( $online_desc_2 ); ?></p>
            <?php endif; ?>
          </div>
          <div class="quills-giftcard-btn-wrap">
            <a href="<?php echo esc_url( $online_gift_card_url ); ?>" class="quills-giftcard-btn" aria-label="<?php echo esc_attr( $online_btn_text . ' ' . $online_card_title ); ?>">
              <span><?php echo esc_html( $online_btn_text ); ?>&nbsp;</span>
            </a>
          </div>
        </div>
      </article>

      <!-- Column 2: CAFE / IN STORE GIFT CARD -->
      <article class="quills-giftcard-card">
        <div class="quills-giftcard-img-box">
          <a href="<?php echo esc_url( $cafe_gift_card_url ); ?>" target="_blank" rel="noreferrer noopener" aria-label="<?php echo esc_attr( $cafe_card_title . ' - Quills Coffee' ); ?>">
            <img src="<?php echo esc_url( $cafe_gift_card_img ); ?>" alt="<?php echo esc_attr( $cafe_card_title . ' - Quills Coffee' ); ?>" class="quills-giftcard-img" loading="lazy" />
          </a>
        </div>
        <div class="quills-giftcard-body">
          <h2 class="quills-giftcard-name"><?php echo esc_html( $cafe_card_title ); ?></h2>
          <div class="quills-giftcard-desc">
            <?php if ( ! empty( $cafe_desc_1 ) ) : ?>
              <p><?php echo wp_kses_post( $cafe_desc_1 ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $cafe_desc_2 ) ) : ?>
              <p><?php echo wp_kses_post( $cafe_desc_2 ); ?></p>
            <?php endif; ?>
          </div>
          <div class="quills-giftcard-btn-wrap">
            <a href="<?php echo esc_url( $cafe_gift_card_url ); ?>" target="_blank" rel="noreferrer noopener" class="quills-giftcard-btn" aria-label="<?php echo esc_attr( $cafe_btn_text . ' ' . $cafe_card_title ); ?>">
              <span><?php echo esc_html( $cafe_btn_text ); ?>&nbsp;</span>
            </a>
          </div>
        </div>
      </article>

    </div>

  </div>
</div>
<!-- /wp:html -->
