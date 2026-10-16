<?php
/**
 * Title: Subscriptions
 * Slug: coffee-cafe-corner/subscriptions
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee Subscription collection page matching quillscoffee.com/collections/subscriptions.
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! class_exists( 'Coffee_Cafe_Corner_Coffee_DB' ) ) {
	require_once get_template_directory() . '/inc/class-coffee-db.php';
}

if ( ! class_exists( 'Coffee_Cafe_Corner_Subscription_DB' ) ) {
	require_once get_template_directory() . '/inc/class-subscription-db.php';
}

$query = Coffee_Cafe_Corner_Subscription_DB::get_subscription_products_query();
$total_products = $query->found_posts ? $query->found_posts : 9;
?>

<div class="quills-subscriptions-page-wrapper">
	<div class="quills-subscriptions-container">

		<!-- Breadcrumb -->
		<nav class="quills-sub-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'coffee-cafe-corner' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-sub-breadcrumb-link"><?php esc_html_e( 'Home', 'coffee-cafe-corner' ); ?></a>
			<span class="quills-sub-breadcrumb-sep">/</span>
			<span class="quills-sub-breadcrumb-current"><?php esc_html_e( 'Subscriptions', 'coffee-cafe-corner' ); ?></span>
		</nav>

		<!-- Hero Banner Box with Coffee Bags & FREE BAG Badge -->
		<section class="quills-sub-hero-section" aria-label="<?php esc_attr_e( 'Subscriptions Hero', 'coffee-cafe-corner' ); ?>">
			<div class="quills-sub-hero-banner">
				<img 
					src="<?php echo esc_url( trailingslashit( get_template_directory_uri() ) . 'assets/images/subscription-hero-banner.png' ); ?>" 
					alt="<?php esc_attr_e( 'Subscriptions - Get a Free Bag', 'coffee-cafe-corner' ); ?>" 
					class="quills-sub-hero-img" 
				/>
			</div>
			<h2 class="quills-sub-hero-tagline">
				<?php esc_html_e( 'Get a free 12oz bag of Inkwell when you subscribe.', 'coffee-cafe-corner' ); ?>
			</h2>
		</section>

		<!-- Subscriptions Toolbar: Product Count, Filter, Sort By -->
		<div class="quills-sub-toolbar">
			<div class="quills-sub-toolbar-left">
				<span class="quills-sub-products-count" id="quills-sub-products-count">
					<?php printf( esc_html__( '%d products', 'coffee-cafe-corner' ), (int) $total_products ); ?>
				</span>
			</div>

			<div class="quills-sub-toolbar-right">
				<button type="button" class="quills-sub-filter-btn" id="quills-sub-filter-btn" aria-label="Filter">
					<svg class="quills-filter-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="4" y1="21" x2="4" y2="14"></line>
						<line x1="4" y1="10" x2="4" y2="3"></line>
						<line x1="12" y1="21" x2="12" y2="12"></line>
						<line x1="12" y1="8" x2="12" y2="3"></line>
						<line x1="20" y1="21" x2="20" y2="16"></line>
						<line x1="20" y1="12" x2="20" y2="3"></line>
						<line x1="1" y1="14" x2="7" y2="14"></line>
						<line x1="9" y1="8" x2="15" y2="8"></line>
						<line x1="17" y1="16" x2="23" y2="16"></line>
					</svg>
					<span><?php esc_html_e( 'Filter', 'coffee-cafe-corner' ); ?></span>
				</button>

				<div class="quills-sub-sort-wrapper">
					<label for="quills-sub-sort-select" class="quills-sub-sort-label"><?php esc_html_e( 'Sort by:', 'coffee-cafe-corner' ); ?></label>
					<div class="quills-sub-sort-box">
						<select id="quills-sub-sort-select" class="quills-sub-sort-select">
							<option value="featured"><?php esc_html_e( 'Featured', 'coffee-cafe-corner' ); ?></option>
							<option value="best-selling"><?php esc_html_e( 'Best selling', 'coffee-cafe-corner' ); ?></option>
							<option value="title-ascending"><?php esc_html_e( 'Alphabetically, A-Z', 'coffee-cafe-corner' ); ?></option>
							<option value="title-descending"><?php esc_html_e( 'Alphabetically, Z-A', 'coffee-cafe-corner' ); ?></option>
							<option value="price-ascending"><?php esc_html_e( 'Price, low to high', 'coffee-cafe-corner' ); ?></option>
							<option value="price-descending"><?php esc_html_e( 'Price, high to low', 'coffee-cafe-corner' ); ?></option>
							<option value="created-descending"><?php esc_html_e( 'Date, new to old', 'coffee-cafe-corner' ); ?></option>
						</select>
						<span class="quills-sort-arrow">▾</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Subscription Products Grid (3 columns) -->
		<div class="quills-sub-grid" id="quills-sub-grid">
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					$card = Coffee_Cafe_Corner_Coffee_DB::get_product_card_data( get_the_ID() );
					if ( ! $card ) {
						continue;
					}
					?>
					<article class="quills-sub-card" data-product-id="<?php echo esc_attr( $card['id'] ); ?>">
						<div class="quills-sub-card-media">
							<a href="<?php echo esc_url( $card['permalink'] ); ?>" class="quills-sub-card-link">
								<img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" class="quills-sub-card-img" loading="lazy" />
							</a>

							<!-- HOVER OVERLAY: Hidden by default, appears ONLY on hover (Matching Image 2) -->
							<div class="quills-card-hover-overlay">
								<a href="<?php echo esc_url( $card['permalink'] ); ?>" class="quills-overlay-text-link">
									<h4 class="quills-overlay-title"><?php echo esc_html( $card['title'] ); ?></h4>
									<div class="quills-overlay-divider"></div>
									<p class="quills-overlay-notes"><?php echo esc_html( $card['tasting_notes'] ); ?></p>
									<div class="quills-overlay-details">
										<p class="quills-overlay-desc"><strong><?php echo esc_html( $card['subtitle'] ); ?></strong></p>
										<p class="quills-overlay-spec"><strong>Process:</strong> <?php echo esc_html( $card['process'] ); ?></p>
										<p class="quills-overlay-spec"><strong>Origins:</strong> <?php echo esc_html( $card['origins'] ); ?></p>
									</div>
								</a>
							</div>
						</div>

						<div class="quills-sub-card-content">
							<h3 class="quills-sub-card-title">
								<a href="<?php echo esc_url( $card['permalink'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a>
							</h3>
							<div class="quills-sub-card-rating">
								<span class="quills-stars-gold">★★★★★</span>
								<span class="quills-review-count">(<?php echo esc_html( $card['review_count'] ); ?> reviews)</span>
							</div>
							<div class="quills-sub-card-price">
								<?php echo esc_html( $card['price_display'] ); ?>
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
