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

$online_gift_card_url = $gift_card_prod ? get_permalink( $gift_card_prod->get_id() ) : home_url( '/product/gift-card/' );
$online_gift_card_img = ( $gift_card_prod && $gift_card_prod->get_image_id() )
  ? ( wp_get_attachment_image_url( $gift_card_prod->get_image_id(), 'full' ) ?: ( $img_dir . 'online-gift-card.png' ) )
  : ( $img_dir . 'online-gift-card.png' );

$cafe_gift_card_url   = 'https://app.squareup.com/gift/YYF6MF7Z4KF6C/order';
?>

<!-- wp:html -->
<div class="quills-giftcards-wrapper">
  <div class="quills-giftcards-container">

    <!-- Header Section -->
    <header class="quills-giftcards-header">
      <h1 class="quills-giftcards-title">Gift Cards</h1>
      <div class="quills-giftcards-intro">
        <p>We sell two different types of gift cards: one for the online store, and the other for use in our cafes.</p>
        <p>Please make sure choose the right gift card for your lucky recipient, as they are not interchangeable.</p>
      </div>
    </header>

    <!-- 2 Columns Grid: Online & Cafe Cards -->
    <div class="quills-giftcards-grid">

      <!-- Column 1: ONLINE STORE GIFT CARD -->
      <article class="quills-giftcard-card">
        <div class="quills-giftcard-img-box">
          <a href="<?php echo esc_url( $online_gift_card_url ); ?>" aria-label="Online Store Gift Card - Quills Coffee">
            <img src="<?php echo esc_url( $online_gift_card_img ); ?>" alt="Online Store Gift Card - Quills Coffee" class="quills-giftcard-img" loading="lazy" />
          </a>
        </div>
        <div class="quills-giftcard-body">
          <h2 class="quills-giftcard-name">ONLINE STORE GIFT CARD</h2>
          <div class="quills-giftcard-desc">
            <p>A gift card that can be used to order whole bean coffee, merchandise, and more <strong>from our website.</strong></p>
            <p><strong>This type of gift card is not valid in our cafes.</strong></p>
          </div>
          <div class="quills-giftcard-btn-wrap">
            <a href="<?php echo esc_url( $online_gift_card_url ); ?>" class="quills-giftcard-btn" aria-label="CLICK HERE TO PURCHASE Online Store Gift Card">
              <span>CLICK HERE TO PURCHASE&nbsp;</span>
            </a>
          </div>
        </div>
      </article>

      <!-- Column 2: CAFE / IN STORE GIFT CARD -->
      <article class="quills-giftcard-card">
        <div class="quills-giftcard-img-box">
          <a href="<?php echo esc_url( $cafe_gift_card_url ); ?>" target="_blank" rel="noreferrer noopener" aria-label="Cafe / In Store Gift Card - Quills Coffee">
            <img src="<?php echo esc_url( $img_dir . 'cafe-gift-card.png' ); ?>" alt="Quills Coffee Cafe Gift Card - Quills Coffee" class="quills-giftcard-img" loading="lazy" />
          </a>
        </div>
        <div class="quills-giftcard-body">
          <h2 class="quills-giftcard-name">CAFE / IN STORE GIFT CARD</h2>
          <div class="quills-giftcard-desc">
            <p>A gift card that can be used in any of our <strong>cafe locations</strong> towards drinks, food, whole bean coffee, and more.</p>
            <p><strong>This type of gift card is not valid for the online store.</strong></p>
          </div>
          <div class="quills-giftcard-btn-wrap">
            <a href="<?php echo esc_url( $cafe_gift_card_url ); ?>" target="_blank" rel="noreferrer noopener" class="quills-giftcard-btn" aria-label="CLICK HERE TO PURCHASE Cafe / In Store Gift Card">
              <span>CLICK HERE TO PURCHASE&nbsp;</span>
            </a>
          </div>
        </div>
      </article>

    </div>

  </div>
</div>
<!-- /wp:html -->

