<?php
/**
 * Title: Brew Gear
 * Slug: coffee-cafe-corner/brew-gear
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee inspired Brew Gear collection page pattern, dynamically pulling products and metadata from WordPress database.
 *
 * @package Coffee_Cafe_Corner
 */

// 1. Ensure backend DB class is loaded
if ( ! class_exists( 'Coffee_Cafe_Corner_Brew_Gear_DB' ) ) {
	require_once get_template_directory() . '/inc/class-brew-gear-db.php';
}

// 2. Resolve Page and Banner Data from Database
$page_id = get_the_ID();
if ( ! $page_id || get_post_field( 'post_name', $page_id ) !== 'brew-gear' ) {
	$brew_page = get_page_by_path( 'brew-gear' );
	if ( $brew_page ) {
		$page_id = $brew_page->ID;
	}
}

$banner_title = get_option( 'brew_gear_banner_title' );
if ( empty( $banner_title ) && $page_id ) {
	$banner_title = get_post_meta( $page_id, '_brew_gear_banner_title', true );
}
if ( empty( $banner_title ) ) {
	$banner_title = 'Brew Gear';
}

$banner_image_url = '';
if ( $page_id ) {
	$custom_banner = get_post_meta( $page_id, '_brew_gear_banner_image', true );
	if ( ! empty( $custom_banner ) ) {
		$banner_image_url = $custom_banner;
	}
}
if ( empty( $banner_image_url ) ) {
	$banner_image_url = trailingslashit( get_template_directory_uri() ) . 'assets/images/brew-gear/brew-gear-banner.jpg';
}

// 3. Process Dynamic Sorting from Request
$allowed_sorts = array(
	'manual'             => __( 'Featured', 'coffee-cafe-corner' ),
	'best-selling'       => __( 'Best selling', 'coffee-cafe-corner' ),
	'title-ascending'    => __( 'Alphabetically, A-Z', 'coffee-cafe-corner' ),
	'title-descending'   => __( 'Alphabetically, Z-A', 'coffee-cafe-corner' ),
	'price-ascending'    => __( 'Price, low to high', 'coffee-cafe-corner' ),
	'price-descending'   => __( 'Price, high to low', 'coffee-cafe-corner' ),
	'created-descending' => __( 'Date, new to old', 'coffee-cafe-corner' ),
);

$current_sort = isset( $_GET['sort_by'] ) ? sanitize_text_field( wp_unslash( $_GET['sort_by'] ) ) : 'manual';
if ( ! array_key_exists( $current_sort, $allowed_sorts ) ) {
	$current_sort = 'manual';
}

// 4. Query Products from Database
$products_query = Coffee_Cafe_Corner_Brew_Gear_DB::get_products_query( $current_sort );
$total_products = $products_query->found_posts;
?>

<div class="quills-brew-gear-wrapper">
	<div class="quills-brew-gear-container">

		<!-- Breadcrumb -->
		<nav class="quills-brew-gear-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'coffee-cafe-corner' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-breadcrumb-link"><?php esc_html_e( 'Home', 'coffee-cafe-corner' ); ?></a>
			<span class="quills-breadcrumb-sep">/</span>
			<span class="quills-breadcrumb-current"><?php echo esc_html( $banner_title ); ?></span>
		</nav>

		<!-- Hero Banner -->
		<section class="quills-brew-gear-banner" style="background-image: url('<?php echo esc_url( $banner_image_url ); ?>');" aria-label="<?php echo esc_attr( $banner_title ); ?>">
			<div class="quills-brew-gear-banner-overlay"></div>
			<h1 class="quills-brew-gear-banner-title"><?php echo esc_html( $banner_title ); ?></h1>
		</section>

		<!-- Sub-Toolbar (Count & Sort) -->
		<div class="quills-brew-gear-toolbar">
			<p class="quills-products-count">
				<?php
				/* translators: %d: total products */
				printf( esc_html( _n( '%d product', '%d products', $total_products, 'coffee-cafe-corner' ) ), (int) $total_products );
				?>
			</p>

			<div class="quills-sort-container">
				<span class="quills-sort-label"><?php esc_html_e( 'Sort by:', 'coffee-cafe-corner' ); ?></span>
				<div class="quills-sort-select-wrap">
					<select id="quills-sort-by-select" class="quills-sort-select" aria-label="<?php esc_attr_e( 'Sort by', 'coffee-cafe-corner' ); ?>">
						<?php foreach ( $allowed_sorts as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current_sort, $key ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<svg class="quills-sort-chevron" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="6 9 12 15 18 9"></polyline>
					</svg>
				</div>
			</div>
		</div>

		<!-- Products Grid -->
		<div class="quills-product-grid">
			<?php
			if ( $products_query->have_posts() ) :
				while ( $products_query->have_posts() ) :
					$products_query->the_post();
					$product_id   = get_the_ID();
					$price        = get_post_meta( $product_id, '_price', true );
					$review_count = (int) get_post_meta( $product_id, '_wc_review_count', true );
					$image_url    = Coffee_Cafe_Corner_Brew_Gear_DB::get_product_image_url( $product_id );
					$permalink    = get_permalink( $product_id );
					?>
					<article class="quills-product-card" data-product-id="<?php echo esc_attr( $product_id ); ?>">
						<div class="quills-product-image-box">
							<!-- Default View (Non-hover) -->
							<div class="quills-product-default-view">
								<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="quills-product-image" loading="lazy" />
							</div>

							<!-- Hover Overlay (Exact Match to User Mockup) -->
							<div class="quills-product-hover-overlay">
								<div class="quills-hover-header">
									<span class="quills-hover-title"><?php the_title(); ?></span>
									<div class="quills-hover-divider"></div>
								</div>

								<div class="quills-hover-image-wrap">
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="quills-hover-image" loading="lazy" />
								</div>

								<div class="quills-hover-action">
									<form class="quills-add-to-cart-form" method="post" action="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ); ?>">
										<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product_id ); ?>" />
										<button type="submit" class="quills-add-to-cart-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'coffee-cafe-corner' ), get_the_title() ) ); ?>">
											<?php esc_html_e( 'ADD TO CART', 'coffee-cafe-corner' ); ?>
										</button>
									</form>
								</div>
							</div>
						</div>

						<div class="quills-product-info">
							<h3 class="quills-product-title">
								<a href="<?php echo esc_url( $permalink ); ?>" class="quills-product-title-link">
									<?php the_title(); ?>
								</a>
							</h3>

							<div class="quills-product-rating">
								<div class="quills-rating-stars" aria-hidden="true">
									<?php for ( $i = 0; $i < 5; $i++ ) : ?>
										<svg class="quills-star-icon" viewBox="0 0 24 24">
											<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
										</svg>
									<?php endfor; ?>
								</div>
								<span class="quills-review-count">
									<?php if ( $review_count > 0 ) : ?>
										(<?php echo esc_html( $review_count ); ?> <?php echo esc_html( _n( 'review', 'reviews', $review_count, 'coffee-cafe-corner' ) ); ?>)
									<?php else : ?>
										(<?php esc_html_e( 'No reviews', 'coffee-cafe-corner' ); ?>)
									<?php endif; ?>
								</span>
							</div>

							<div class="quills-product-price">
								<?php
								if ( function_exists( 'wc_price' ) && is_numeric( $price ) ) {
									echo wp_kses_post( wc_price( $price ) );
								} elseif ( is_numeric( $price ) ) {
									echo esc_html( '$' . number_format( (float) $price, 2 ) );
								} else {
									echo esc_html( $price );
								}
								?>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p class="quills-no-products"><?php esc_html_e( 'No products found.', 'coffee-cafe-corner' ); ?></p>
			<?php endif; ?>
		</div>

	</div>
</div>
