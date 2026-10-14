<?php
/**
 * Title: Merch
 * Slug: coffee-cafe-corner/merch
 * Categories: coffee-cafe-corner
 * Keywords: merch, apparel, hats, mugs, quills coffee
 */

$img_dir = get_template_directory_uri() . '/assets/images/merch/';

$merch_products = [
  [
    'title'       => 'Crewneck Sweatshirt (Evergreen)',
    'desc'        => "Midweight Quills fleece sweatshirt in evergreen color.\n\nCotton/polyester blend.",
    'img'         => 'merch-crewneck-evergreen.jpg',
    'price'       => '$45.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-coffee-leaves-crewneck-sweatshirt/' )
  ],
  [
    'title'       => 'Crewneck Sweatshirt (Sandstone)',
    'desc'        => "Midweight Quills fleece sweatshirt in sandstone color.\n\nCotton/polyester blend.",
    'img'         => 'merch-crewneck-sandstone.jpg',
    'price'       => '$45.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-coffee-leaves-crewneck-sweatshirt-copy/' )
  ],
  [
    'title'       => 'Owl Ringer Tee',
    'desc'        => "Retro ringer tee in ivory with dark green bands.\n\n100% cotton.",
    'img'         => 'merch-owl-ringer-tee.jpg',
    'price'       => '$23.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-kentucky-owl-ringer-tee/' )
  ],
  [
    'title'       => 'Owl Tee in Pastel Green',
    'desc'        => "Garment dyed heavyweight t-shirt in pastel green.\n\n100% US cotton.",
    'img'         => 'merch-owl-tee-pastel-green.jpg',
    'price'       => '$26.00',
    'rating_type' => 'filled',
    'reviews'     => '(8 reviews)',
    'link'        => home_url( '/product/quills-kentucky-owl-ringer-tee-copy/' )
  ],
  [
    'title'       => 'Owl Embroidered Hat',
    'desc'        => "Unstructured snapback in green with gold embroidered owl logo.\n\n100% cotton.",
    'img'         => 'merch-owl-embroidered-hat.jpg',
    'price'       => '$27.00',
    'rating_type' => 'filled',
    'reviews'     => '(1 reviews)',
    'link'        => home_url( '/product/quills-owl-embroidered-hat/' )
  ],
  [
    'title'       => 'Two-tone Embroidered Hat',
    'desc'        => "Five-panel two-tone cap with embroidered Quills Coffee.\n\n100% cotton.",
    'img'         => 'merch-twotone-embroidered-hat.jpg',
    'price'       => '$27.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-owl-embroidered-hat-copy/' )
  ],
  [
    'title'       => 'Quills Speckled Coffee Mug',
    'desc'        => "12 oz ceramic mug in speckled ivory, with Quills logo and Steve the owl.",
    'img'         => 'merch-speckled-coffee-mug.jpg',
    'price'       => '$19.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-coffee-mug/' )
  ],
  [
    'title'       => 'Quills Coffee Postage Mug',
    'desc'        => 'Red Ceramic Quills "Postage"',
    'img'         => 'merch-coffee-postage-mug.jpg',
    'price'       => '$19.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-coffee-mug-copy/' )
  ],
  [
    'title'       => "Quill's Slow Coffee Hoodie (Charcoal)",
    'desc'        => 'QUILLS COFFEE MIDWEIGHT HOODED SWEATSHIRT "SLOW COFFEE"-CHARCOAL',
    'img'         => 'merch-slow-coffee-hoodie-charcoal.jpg',
    'price'       => '$48.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-slow-coffee-hoodie-charcoal/' )
  ],
  [
    'title'       => "Quill's Slow Coffee Hoodie (Saddle)",
    'desc'        => 'QUILLS COFFEE MIDWEIGHT HOODED SWEATSHIRT "SLOW COFFEE"-SADDLE',
    'img'         => 'merch-slow-coffee-hoodie-saddle.jpg',
    'price'       => '$48.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-slow-coffee-hoodie-charcoal-copy/' )
  ],
  [
    'title'       => "Quill's Postage Tote Bag",
    'desc'        => 'QUILLS COFFEE 15"W X 16"H TOTE BAG "POSTAGE"',
    'img'         => 'merch-postage-tote-bag.jpg',
    'price'       => '$18.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/quills-postage-tote-bag/' )
  ],
  [
    'title'       => "Quill's Patch Hat (Petrol Blue)",
    'desc'        => "Five-panel two-tone cap with embroidered Quills Coffee.\n\n100% cotton.",
    'img'         => 'merch-patch-hat-petrol-blue.jpg',
    'price'       => '$27.00',
    'rating_type' => 'empty',
    'reviews'     => '(No reviews)',
    'link'        => home_url( '/product/two-tone-embroidered-hat-copy/' )
  ]
];
?>

<!-- wp:html -->
<div class="quills-merch-wrapper">

  <!-- Breadcrumbs -->
  <div class="quills-merch-container">
    <nav class="quills-merch-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'coffee-cafe-corner' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-merch-bc-link">Home</a>
      <span class="quills-merch-bc-sep">/</span>
      <span class="quills-merch-bc-current">Merch</span>
    </nav>
  </div>

  <!-- Collection Banner -->
  <div class="quills-merch-container">
    <div class="quills-merch-banner">
      <img src="<?php echo esc_url( $img_dir . 'banner-merch.jpg' ); ?>" alt="Quills Coffee Merch" class="quills-merch-banner-img" />
      <div class="quills-merch-banner-overlay">
        <h1 class="quills-merch-banner-title">Merch</h1>
      </div>
    </div>
  </div>

  <!-- Toolbar: Product Count & Sort -->
  <div class="quills-merch-container">
    <div class="quills-merch-toolbar">
      <div class="quills-merch-count">12 products</div>
      <div class="quills-merch-sort">
        <label for="quills-sort-select" class="quills-merch-sort-label">Sort by:</label>
        <div class="quills-merch-sort-wrap">
          <select id="quills-sort-select" class="quills-merch-sort-select">
            <option value="featured" selected>Featured</option>
            <option value="best-selling">Best selling</option>
            <option value="title-ascending">Alphabetically, A-Z</option>
            <option value="title-descending">Alphabetically, Z-A</option>
            <option value="price-ascending">Price, low to high</option>
            <option value="price-descending">Price, high to low</option>
            <option value="created-ascending">Date, old to new</option>
            <option value="created-descending">Date, new to old</option>
          </select>
          <svg class="quills-merch-sort-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="#3A3837" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="1 1 5 5 9 1"></polyline>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Product Grid (4 Columns) -->
  <div class="quills-merch-container">
    <div class="quills-merch-grid">
      <?php foreach ( $merch_products as $product ) : ?>
        <div class="quills-merch-card">
          <div class="quills-merch-image-box">
            <a href="<?php echo esc_url( $product['link'] ); ?>" class="quills-merch-img-link">
              <img src="<?php echo esc_url( $img_dir . $product['img'] ); ?>" alt="<?php echo esc_attr( $product['title'] ); ?>" class="quills-merch-img" loading="lazy" />
              <div class="quills-merch-rollover">
                <h4 class="quills-merch-rollover-title"><?php echo esc_html( $product['title'] ); ?></h4>
                <div class="quills-merch-rollover-line"></div>
                <div class="quills-merch-rollover-desc">
                  <?php echo nl2br( esc_html( $product['desc'] ) ); ?>
                </div>
              </div>
            </a>
            <div class="quills-merch-quick-add">
              <button type="button" class="quills-merch-btn-add" aria-label="ADD TO CART">
                <span>ADD TO CART</span>
              </button>
            </div>
          </div>
          <div class="quills-merch-info">
            <h3 class="quills-merch-name">
              <a href="<?php echo esc_url( $product['link'] ); ?>"><?php echo esc_html( $product['title'] ); ?></a>
            </h3>
            <div class="quills-merch-rating-row">
              <?php if ( $product['rating_type'] === 'filled' ) : ?>
                <span class="quills-merch-stars quills-merch-stars--filled">★★★★★</span>
              <?php else : ?>
                <span class="quills-merch-stars quills-merch-stars--empty">☆☆☆☆☆</span>
              <?php endif; ?>
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
