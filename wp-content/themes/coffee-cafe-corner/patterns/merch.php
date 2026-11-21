<?php
/**
 * Title: Merch
 * Slug: coffee-cafe-corner/merch
 * Categories: coffee-cafe-corner
 * Keywords: merch, apparel, hats, mugs, quills coffee
 */

$img_dir = trailingslashit( get_template_directory_uri() ) . 'assets/images/merch/';

$breadcrumb_home    = get_option( 'quills_merch_breadcrumb_home', __( 'Home', 'coffee-cafe-corner' ) );
$breadcrumb_current = get_option( 'quills_merch_breadcrumb_current', __( 'Merch', 'coffee-cafe-corner' ) );
$banner_title       = get_option( 'quills_merch_banner_title', __( 'Merch', 'coffee-cafe-corner' ) );
$banner_img         = get_option( 'quills_merch_banner_image', $img_dir . 'banner-merch.jpg' );
$sort_label         = get_option( 'quills_merch_sort_label', __( 'Sort by:', 'coffee-cafe-corner' ) );
$add_to_cart_text   = get_option( 'quills_merch_add_to_cart_text', 'ADD TO CART' );
$sold_out_text      = get_option( 'quills_merch_sold_out_text', 'SOLD OUT' );
$no_products_text   = get_option( 'quills_merch_no_products_text', __( 'No products found.', 'coffee-cafe-corner' ) );

$allowed_sorts = array(
  'featured'           => 'Featured',
  'best-selling'       => 'Best selling',
  'title-ascending'    => 'Alphabetically, A-Z',
  'title-descending'   => 'Alphabetically, Z-A',
  'price-ascending'    => 'Price, low to high',
  'price-descending'   => 'Price, high to low',
  'created-ascending'  => 'Date, old to new',
  'created-descending' => 'Date, new to old',
);

$current_sort = isset( $_GET['sort_by'] ) ? sanitize_text_field( wp_unslash( $_GET['sort_by'] ) ) : 'featured';
if ( ! array_key_exists( $current_sort, $allowed_sorts ) ) {
  $current_sort = 'featured';
}

$slug_to_img_fallback = array(
  // Slugs Set 1
  'crewneck-sweatshirt-evergreen'                => 'merch-crewneck-evergreen.jpg',
  'crewneck-sweatshirt-sandstone'                => 'merch-crewneck-sandstone.jpg',
  'owl-ringer-tee'                               => 'merch-owl-ringer-tee.jpg',
  'owl-tee-in-pastel-green'                      => 'merch-owl-tee-pastel-green.jpg',
  'owl-embroidered-hat'                          => 'merch-owl-embroidered-hat.jpg',
  'two-tone-embroidered-hat'                     => 'merch-twotone-embroidered-hat.jpg',
  'quills-speckled-coffee-mug'                   => 'merch-speckled-coffee-mug.jpg',
  'quills-coffee-postage-mug'                    => 'merch-coffee-postage-mug.jpg',
  'quills-slow-coffee-hoodie-charcoal'           => 'merch-slow-coffee-hoodie-charcoal.jpg',
  'quills-slow-coffee-hoodie-saddle'             => 'merch-slow-coffee-hoodie-saddle.jpg',
  'quills-postage-tote-bag'                      => 'merch-postage-tote-bag.jpg',
  'quills-patch-hat-petrol-blue'                 => 'merch-patch-hat-petrol-blue.jpg',

  // Slugs Set 2
  'quills-coffee-leaves-crewneck-sweatshirt'      => 'merch-crewneck-evergreen.jpg',
  'quills-coffee-leaves-crewneck-sweatshirt-copy' => 'merch-crewneck-sandstone.jpg',
  'quills-kentucky-owl-ringer-tee'               => 'merch-owl-ringer-tee.jpg',
  'quills-kentucky-owl-ringer-tee-copy'          => 'merch-owl-tee-pastel-green.jpg',
  'quills-owl-embroidered-hat-copy'              => 'merch-twotone-embroidered-hat.jpg',
  'quills-coffee-mug'                            => 'merch-speckled-coffee-mug.jpg',
  'quills-coffee-mug-copy'                       => 'merch-coffee-postage-mug.jpg',
  'quills-slow-coffee-hoodie-charcoal-copy'      => 'merch-slow-coffee-hoodie-saddle.jpg',
  'two-tone-embroidered-hat-copy'                => 'merch-patch-hat-petrol-blue.jpg',
);

$wc_products = class_exists( 'Coffee_Cafe_Corner_Quills_Products_DB' )
  ? Coffee_Cafe_Corner_Quills_Products_DB::get_merch_products( $current_sort )
  : array();

$merch_products = array();

if ( ! empty( $wc_products ) ) {
  foreach ( $wc_products as $product ) {
    $p_id          = $product->get_id();
    $p_slug        = $product->get_slug();
    $p_name_lower  = strtolower( $product->get_name() );
    $rating        = (float) $product->get_average_rating();
    $reviews_count = (int) $product->get_review_count();

    $thumb_id = $product->get_image_id();
    $img_url  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'full' ) : '';
    if ( ! $img_url ) {
      if ( isset( $slug_to_img_fallback[ $p_slug ] ) ) {
        $img_url = $img_dir . $slug_to_img_fallback[ $p_slug ];
      } elseif ( strpos( $p_name_lower, 'sandstone' ) !== false ) {
        $img_url = $img_dir . 'merch-crewneck-sandstone.jpg';
      } elseif ( strpos( $p_name_lower, 'evergreen' ) !== false ) {
        $img_url = $img_dir . 'merch-crewneck-evergreen.jpg';
      } elseif ( strpos( $p_name_lower, 'ringer' ) !== false ) {
        $img_url = $img_dir . 'merch-owl-ringer-tee.jpg';
      } elseif ( strpos( $p_name_lower, 'pastel' ) !== false ) {
        $img_url = $img_dir . 'merch-owl-tee-pastel-green.jpg';
      } elseif ( strpos( $p_name_lower, 'two-tone' ) !== false || strpos( $p_name_lower, 'twotone' ) !== false ) {
        $img_url = $img_dir . 'merch-twotone-embroidered-hat.jpg';
      } elseif ( strpos( $p_name_lower, 'embroidered' ) !== false ) {
        $img_url = $img_dir . 'merch-owl-embroidered-hat.jpg';
      } elseif ( strpos( $p_name_lower, 'speckled' ) !== false ) {
        $img_url = $img_dir . 'merch-speckled-coffee-mug.jpg';
      } elseif ( strpos( $p_name_lower, 'postage mug' ) !== false || strpos( $p_slug, 'postage-mug' ) !== false ) {
        $img_url = $img_dir . 'merch-coffee-postage-mug.jpg';
      } elseif ( strpos( $p_name_lower, 'charcoal' ) !== false ) {
        $img_url = $img_dir . 'merch-slow-coffee-hoodie-charcoal.jpg';
      } elseif ( strpos( $p_name_lower, 'saddle' ) !== false ) {
        $img_url = $img_dir . 'merch-slow-coffee-hoodie-saddle.jpg';
      } elseif ( strpos( $p_name_lower, 'tote' ) !== false ) {
        $img_url = $img_dir . 'merch-postage-tote-bag.jpg';
      } elseif ( strpos( $p_name_lower, 'patch' ) !== false || strpos( $p_name_lower, 'petrol' ) !== false ) {
        $img_url = $img_dir . 'merch-patch-hat-petrol-blue.jpg';
      } else {
        $img_url = $img_dir . 'merch-crewneck-evergreen.jpg';
      }
    }

    $is_in_stock = $product->is_in_stock();

    $merch_products[] = array(
      'id'          => $p_id,
      'title'       => $product->get_name(),
      'desc'        => $product->get_description() ?: $product->get_short_description(),
      'img_url'     => $img_url,
      'price'       => '$' . number_format( (float) $product->get_price(), 2 ),
      'rating_type' => ( $rating > 0 ) ? 'filled' : 'empty',
      'reviews'     => ( $reviews_count > 0 ) ? '(' . $reviews_count . ' reviews)' : '(No reviews)',
      'link'        => get_permalink( $p_id ),
      'in_stock'    => $is_in_stock,
    );
  }
}

$total_products = count( $merch_products );
?>

<!-- wp:html -->
<div class="quills-merch-wrapper">

  <!-- Breadcrumbs -->
  <div class="quills-merch-container">
    <nav class="quills-merch-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'coffee-cafe-corner' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-merch-bc-link"><?php echo esc_html( $breadcrumb_home ); ?></a>
      <span class="quills-merch-bc-sep">/</span>
      <span class="quills-merch-bc-current"><?php echo esc_html( $breadcrumb_current ); ?></span>
    </nav>
  </div>

  <!-- Collection Banner -->
  <div class="quills-merch-container">
    <div class="quills-merch-banner">
      <img src="<?php echo esc_url( $banner_img ); ?>" alt="<?php echo esc_attr( $banner_title ); ?>" class="quills-merch-banner-img" />
      <div class="quills-merch-banner-overlay">
        <h1 class="quills-merch-banner-title"><?php echo esc_html( $banner_title ); ?></h1>
      </div>
    </div>
  </div>

  <!-- Toolbar: Product Count & Sort -->
  <div class="quills-merch-container">
    <div class="quills-merch-toolbar">
      <div class="quills-merch-count"><?php echo esc_html( $total_products ); ?> products</div>
      <div class="quills-merch-sort">
        <label for="quills-sort-select" class="quills-merch-sort-label"><?php echo esc_html( $sort_label ); ?></label>
        <div class="quills-merch-sort-wrap">
          <select id="quills-sort-select" class="quills-merch-sort-select" onchange="window.location.search = '?sort_by=' + encodeURIComponent(this.value);">
            <?php foreach ( $allowed_sorts as $key => $label ) : ?>
              <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current_sort, $key ); ?>>
                <?php echo esc_html( $label ); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- Product Grid (4 Columns) -->
  <div class="quills-merch-container">
    <div class="quills-merch-grid">
      <?php foreach ( $merch_products as $product ) : ?>
        <div class="quills-merch-card" data-product-id="<?php echo esc_attr( $product['id'] ); ?>">
          <div class="quills-merch-image-box">
            <?php if ( ! $product['in_stock'] ) : ?>
              <div class="quills-merch-badge">Sold out</div>
            <?php endif; ?>
            <a href="<?php echo esc_url( $product['link'] ); ?>" class="quills-merch-img-link">
              <img src="<?php echo esc_url( $product['img_url'] ); ?>" alt="<?php echo esc_attr( $product['title'] ); ?>" class="quills-merch-img" loading="lazy" />
              <div class="quills-merch-rollover">
                <h4 class="quills-merch-rollover-title"><?php echo esc_html( $product['title'] ); ?></h4>
                <div class="quills-merch-rollover-line"></div>
                <div class="quills-merch-rollover-desc">
                  <?php echo nl2br( esc_html( $product['desc'] ) ); ?>
                </div>
              </div>
            </a>
            <div class="quills-merch-quick-add">
              <?php if ( $product['in_stock'] ) : ?>
                <form class="quills-merch-quick-add-form" method="post" action="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ); ?>" style="width: 100%; margin: 0; padding: 0;">
                  <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product['id'] ); ?>" />
                  <button type="submit" class="quills-merch-btn-add" aria-label="<?php echo esc_attr( sprintf( __( 'ADD TO CART %s', 'coffee-cafe-corner' ), $product['title'] ) ); ?>">
                    <span><?php echo esc_html( $add_to_cart_text ); ?></span>
                  </button>
                </form>
              <?php else : ?>
                <button type="button" class="quills-merch-btn-add is-soldout" disabled aria-disabled="true">
                  <span><?php echo esc_html( $sold_out_text ); ?></span>
                </button>
              <?php endif; ?>
            </div>
          </div>
          <div class="quills-merch-info">
            <h3 class="quills-merch-name">
              <a href="<?php echo esc_url( $product['link'] ); ?>"><?php echo esc_html( $product['title'] ); ?></a>
            </h3>
            <div class="quills-merch-rating-row">
              <div class="quills-merch-stars-wrap">
                <?php for ( $i = 0; $i < 5; $i++ ) : ?>
                  <svg class="quills-merch-star-svg <?php echo ( $product['rating_type'] === 'filled' ) ? 'is-filled' : 'is-empty'; ?>" width="13" height="13" viewBox="0 0 24 24" fill="<?php echo ( $product['rating_type'] === 'filled' ) ? '#f59e0b' : 'none'; ?>" stroke="#f59e0b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                  </svg>
                <?php endfor; ?>
              </div>
              <span class="quills-merch-reviews"><?php echo esc_html( $product['reviews'] ); ?></span>
            </div>
            <div class="quills-merch-price"><?php echo esc_html( $product['price'] ); ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>
<!-- /wp:html -->
