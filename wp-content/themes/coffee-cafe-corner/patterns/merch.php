<?php
/**
 * Title: Merch Collection
 * Slug: coffee-cafe-corner/merch
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee Merchandise collection page pattern, dynamically pulling 12 apparel, mugs, and accessory products from WordPress database.
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! class_exists( 'Coffee_Cafe_Corner_Merch_DB' ) ) {
	require_once get_template_directory() . '/inc/class-merch-db.php';
}

$current_sort = isset( $_GET['sort_by'] ) ? sanitize_text_field( wp_unslash( $_GET['sort_by'] ) ) : 'manual';

$allowed_sorts = array(
	'manual'           => __( 'Featured', 'coffee-cafe-corner' ),
	'title-ascending'  => __( 'Alphabetically, A-Z', 'coffee-cafe-corner' ),
	'title-descending' => __( 'Alphabetically, Z-A', 'coffee-cafe-corner' ),
	'price-ascending'  => __( 'Price, low to high', 'coffee-cafe-corner' ),
	'price-descending' => __( 'Price, high to low', 'coffee-cafe-corner' ),
);

$query = Coffee_Cafe_Corner_Merch_DB::get_merch_products_query( $current_sort );
$total_products = $query->found_posts;
?>

<div class="quills-merch-wrapper">
	<div class="quills-merch-container">

		<!-- Breadcrumb -->
		<nav class="quills-merch-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'coffee-cafe-corner' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-merch-breadcrumb-link"><?php esc_html_e( 'Home', 'coffee-cafe-corner' ); ?></a>
			<span class="quills-merch-breadcrumb-sep">/</span>
			<span class="quills-merch-breadcrumb-current"><?php esc_html_e( 'Merch', 'coffee-cafe-corner' ); ?></span>
		</nav>

		<!-- Hero Banner Box with Script Title -->
		<section class="quills-merch-hero" aria-label="<?php esc_attr_e( 'Merchandise Collection', 'coffee-cafe-corner' ); ?>">
			<div class="quills-merch-hero-card">
				<h1 class="quills-merch-hero-title"><?php esc_html_e( 'Merch', 'coffee-cafe-corner' ); ?></h1>
			</div>
		</section>

		<!-- Toolbar: Count & Sort By -->
		<div class="quills-merch-toolbar">
			<div class="quills-merch-toolbar-left">
				<span class="quills-merch-count">
					<?php printf( esc_html__( '%d products', 'coffee-cafe-corner' ), (int) $total_products ); ?>
				</span>
			</div>

			<div class="quills-merch-toolbar-right">
				<label for="quills-merch-sort-select" class="quills-merch-sort-label"><?php esc_html_e( 'Sort by:', 'coffee-cafe-corner' ); ?></label>
				<div class="quills-merch-sort-wrapper">
					<select id="quills-merch-sort-select" class="quills-merch-sort-select" onchange="if(this.value){ window.location.href = '?sort_by=' + this.value; }">
						<?php foreach ( $allowed_sorts as $val => $label ) : ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<span class="quills-merch-sort-arrow">▾</span>
				</div>
			</div>
		</div>

		<!-- Product Grid (4 Columns) matching Subcription.png -->
		<div class="quills-merch-grid">
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					$product_id   = get_the_ID();
					$title        = get_the_title();
					$price        = (float) get_post_meta( $product_id, '_price', true );
					$rating       = (float) get_post_meta( $product_id, '_wc_average_rating', true );
					$review_count = (int) get_post_meta( $product_id, '_wc_review_count', true );
					$image_rel    = get_post_meta( $product_id, '_merch_image', true );

					$image_url = '';
					if ( ! empty( $image_rel ) && file_exists( get_template_directory() . '/assets/images/' . $image_rel ) ) {
						$image_url = trailingslashit( get_template_directory_uri() ) . 'assets/images/' . $image_rel;
					} elseif ( has_post_thumbnail( $product_id ) ) {
						$image_url = get_the_post_thumbnail_url( $product_id, 'medium_large' );
					} else {
						$image_url = trailingslashit( get_template_directory_uri() ) . 'assets/images/coffee/inkwell.jpg';
					}
					?>
					<article class="quills-merch-card">
						<div class="quills-merch-card-media">
							<a href="<?php the_permalink(); ?>" class="quills-merch-card-link">
								<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="quills-merch-card-img" loading="lazy" />
							</a>
							<div class="quills-merch-card-overlay">
								<button type="button" class="quills-quick-add-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>">
									<?php esc_html_e( 'ADD TO CART', 'coffee-cafe-corner' ); ?>
								</button>
							</div>
						</div>

						<div class="quills-merch-card-content">
							<h3 class="quills-merch-card-title">
								<a href="<?php the_permalink(); ?>"><?php echo esc_html( $title ); ?></a>
							</h3>

							<div class="quills-merch-card-rating">
								<span class="quills-stars">
									<?php
									$rounded = round( $rating );
									for ( $i = 1; $i <= 5; $i++ ) {
										if ( $i <= $rounded && $rating > 0 ) {
											echo '<span class="quills-star quills-star--filled">★</span>';
										} else {
											echo '<span class="quills-star quills-star--empty">☆</span>';
										}
									}
									?>
								</span>
								<span class="quills-review-count">
									<?php
									if ( $review_count > 0 ) {
										printf( esc_html__( '(%d reviews)', 'coffee-cafe-corner' ), (int) $review_count );
									} else {
										esc_html_e( '(No reviews)', 'coffee-cafe-corner' );
									}
									?>
								</span>
							</div>

							<div class="quills-merch-card-price">
								$<?php echo esc_html( number_format( $price ? $price : 25.00, 2 ) ); ?>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

	</div>
</div>
