<?php
/**
 * Title: Coffee Collection
 * Slug: coffee-cafe-corner/coffee
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee flagship Coffee collection page pattern, dynamically pulling freshly roasted coffee products and metadata from WordPress database.
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! class_exists( 'Coffee_Cafe_Corner_Coffee_DB' ) ) {
	require_once get_template_directory() . '/inc/class-coffee-db.php';
}

$current_tab     = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'all';
$current_process = isset( $_GET['process'] ) ? sanitize_text_field( wp_unslash( $_GET['process'] ) ) : 'all';
$current_sort    = isset( $_GET['sort_by'] ) ? sanitize_text_field( wp_unslash( $_GET['sort_by'] ) ) : 'manual';

$allowed_sorts = array(
	'manual'             => __( 'Featured', 'coffee-cafe-corner' ),
	'best-selling'       => __( 'Best selling', 'coffee-cafe-corner' ),
	'title-ascending'    => __( 'Alphabetically, A-Z', 'coffee-cafe-corner' ),
	'title-descending'   => __( 'Alphabetically, Z-A', 'coffee-cafe-corner' ),
	'price-ascending'    => __( 'Price, low to high', 'coffee-cafe-corner' ),
	'price-descending'   => __( 'Price, high to low', 'coffee-cafe-corner' ),
	'created-descending' => __( 'Date, new to old', 'coffee-cafe-corner' ),
);

$query = Coffee_Cafe_Corner_Coffee_DB::get_products_query( $current_tab, $current_process, $current_sort );
$total_products = $query->found_posts;
?>

<div class="quills-coffee-page-wrapper">
	<div class="quills-coffee-container">

		<!-- Top Breadcrumb -->
		<nav class="quills-coffee-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'coffee-cafe-corner' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-breadcrumb-link"><?php esc_html_e( 'Home', 'coffee-cafe-corner' ); ?></a>
			<span class="quills-breadcrumb-sep">/</span>
			<span class="quills-breadcrumb-current"><?php esc_html_e( 'Coffee', 'coffee-cafe-corner' ); ?></span>
		</nav>

		<!-- Hero Banner Box with Script Title -->
		<section class="quills-coffee-hero" aria-label="<?php esc_attr_e( 'Coffee Collection', 'coffee-cafe-corner' ); ?>">
			<div class="quills-coffee-hero-card">
				<h1 class="quills-coffee-hero-title"><?php esc_html_e( 'Coffee', 'coffee-cafe-corner' ); ?></h1>
			</div>
		</section>

		<!-- Fresh Roasting Philosophy Announcement -->
		<section class="quills-coffee-announcement" aria-label="<?php esc_attr_e( 'Roasting Schedule', 'coffee-cafe-corner' ); ?>">
			<div class="quills-announcement-inner">
				<p class="quills-announcement-headline">
					<?php esc_html_e( 'We want your coffee to be as fresh as possible. Therefore, we roast everything to order.', 'coffee-cafe-corner' ); ?>
				</p>
				<p class="quills-announcement-schedule">
					<?php esc_html_e( 'Orders placed by midnight Sunday ship by Wednesday.', 'coffee-cafe-corner' ); ?><br />
					<?php esc_html_e( 'Orders placed by midnight Tuesday ship by Friday.', 'coffee-cafe-corner' ); ?>
				</p>
			</div>
		</section>

		<div class="quills-separator-line"></div>

		<!-- Top Testimonial Quote Slider -->
		<section class="quills-quote-slider-section" aria-label="<?php esc_attr_e( 'Customer Quote', 'coffee-cafe-corner' ); ?>">
			<div class="quills-quote-stars">
				<span class="quills-gold-star">★</span>
				<span class="quills-gold-star">★</span>
				<span class="quills-gold-star">★</span>
				<span class="quills-gold-star">★</span>
				<span class="quills-gold-star">★</span>
			</div>
			<blockquote class="quills-quote-text" id="quills-quote-text">
				"Heaven in a cup."
			</blockquote>
			<cite class="quills-quote-author" id="quills-quote-author">— Tracy S.</cite>
			
			<div class="quills-slider-dots">
				<button type="button" class="quills-slider-dot is-active" data-index="0" aria-label="Quote 1"></button>
				<button type="button" class="quills-slider-dot" data-index="1" aria-label="Quote 2"></button>
				<button type="button" class="quills-slider-dot" data-index="2" aria-label="Quote 3"></button>
			</div>
		</section>

		<div class="quills-separator-line"></div>

		<!-- Category Filter Tabs Bar -->
		<nav class="quills-coffee-tabs-bar" aria-label="<?php esc_attr_e( 'Coffee Category Filter', 'coffee-cafe-corner' ); ?>">
			<ul class="quills-tabs-list">
				<li class="quills-tab-item">
					<button type="button" class="quills-tab-btn <?php echo ( 'all' === $current_tab ) ? 'is-active' : ''; ?>" data-tab="all">
						<?php esc_html_e( 'All', 'coffee-cafe-corner' ); ?>
					</button>
				</li>
				<li class="quills-tab-item">
					<button type="button" class="quills-tab-btn <?php echo ( 'blend' === $current_tab ) ? 'is-active' : ''; ?>" data-tab="blend">
						<?php esc_html_e( 'Blends', 'coffee-cafe-corner' ); ?>
					</button>
				</li>
				<li class="quills-tab-item">
					<button type="button" class="quills-tab-btn <?php echo ( 'single-origin' === $current_tab ) ? 'is-active' : ''; ?>" data-tab="single-origin">
						<?php esc_html_e( 'Single Origin', 'coffee-cafe-corner' ); ?>
					</button>
				</li>
				<li class="quills-tab-item">
					<button type="button" class="quills-tab-btn <?php echo ( 'espresso' === $current_tab ) ? 'is-active' : ''; ?>" data-tab="espresso">
						<?php esc_html_e( 'Espresso', 'coffee-cafe-corner' ); ?>
					</button>
				</li>
				<li class="quills-tab-item">
					<button type="button" class="quills-tab-btn <?php echo ( 'decaf' === $current_tab ) ? 'is-active' : ''; ?>" data-tab="decaf">
						<?php esc_html_e( 'Decaf', 'coffee-cafe-corner' ); ?>
					</button>
				</li>
			</ul>
		</nav>

		<!-- Toolbar: Process Filter, Product Count, Sort By -->
		<div class="quills-coffee-toolbar">
			<div class="quills-toolbar-left">
				<div class="quills-process-dropdown-wrapper">
					<button type="button" class="quills-process-toggle-btn" id="quills-process-toggle" aria-expanded="false">
						<span class="quills-process-title"><?php esc_html_e( 'Process', 'coffee-cafe-corner' ); ?></span>
						<span class="quills-process-plus">+</span>
					</button>
					<div class="quills-process-menu" id="quills-process-menu">
						<button type="button" class="quills-process-option is-active" data-process="all"><?php esc_html_e( 'All Processes', 'coffee-cafe-corner' ); ?></button>
						<button type="button" class="quills-process-option" data-process="Washed"><?php esc_html_e( 'Washed', 'coffee-cafe-corner' ); ?></button>
						<button type="button" class="quills-process-option" data-process="Natural"><?php esc_html_e( 'Natural', 'coffee-cafe-corner' ); ?></button>
						<button type="button" class="quills-process-option" data-process="Anaerobic"><?php esc_html_e( 'Anaerobic', 'coffee-cafe-corner' ); ?></button>
						<button type="button" class="quills-process-option" data-process="Decaf"><?php esc_html_e( 'Sugarcane EA Decaf', 'coffee-cafe-corner' ); ?></button>
					</div>
				</div>
			</div>

			<div class="quills-toolbar-center">
				<span class="quills-products-count" id="quills-products-count">
					<?php printf( esc_html__( '%d products', 'coffee-cafe-corner' ), (int) $total_products ); ?>
				</span>
			</div>

			<div class="quills-toolbar-right">
				<label for="quills-coffee-sort-select" class="quills-sort-label"><?php esc_html_e( 'Sort by:', 'coffee-cafe-corner' ); ?></label>
				<div class="quills-sort-select-wrapper">
					<select id="quills-coffee-sort-select" class="quills-sort-select">
						<?php foreach ( $allowed_sorts as $val => $label ) : ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<span class="quills-sort-arrow">▾</span>
				</div>
			</div>
		</div>

		<!-- Product Grid (3 columns) -->
		<div class="quills-coffee-grid" id="quills-coffee-grid">
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					$card = Coffee_Cafe_Corner_Coffee_DB::get_product_card_data( get_the_ID() );
					if ( ! $card ) {
						continue;
					}
					?>
					<article class="quills-coffee-card">
						<div class="quills-coffee-card-media">
							<a href="<?php echo esc_url( $card['permalink'] ); ?>" class="quills-coffee-card-link">
								<img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" class="quills-coffee-card-img" loading="lazy" />
							</a>

							<!-- HOVER OVERLAY: Hidden by default, appears ONLY on hover -->
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
								<button type="button" class="quills-coffee-card-add-btn" data-product-id="<?php echo esc_attr( $card['id'] ); ?>">
									<?php esc_html_e( 'ADD TO CART', 'coffee-cafe-corner' ); ?>
								</button>
							</div>
						</div>
						<div class="quills-coffee-card-content">
							<h3 class="quills-coffee-card-title">
								<a href="<?php echo esc_url( $card['permalink'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a>
							</h3>
							<div class="quills-coffee-card-rating">
								<span class="quills-stars-gold">★★★★★</span>
								<span class="quills-review-count">(<?php echo esc_html( $card['review_count'] ); ?> reviews)</span>
							</div>
							<div class="quills-coffee-card-price">
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

		<div class="quills-separator-line quills-separator-line--bottom"></div>

		<!-- Customer Testimonial Bottom Banner (Linen Canvas Texture) -->
		<section class="quills-coffee-testimonials-banner" aria-label="<?php esc_attr_e( 'Customer Testimonials', 'coffee-cafe-corner' ); ?>">
			<div class="quills-testimonials-inner">
				<h2 class="quills-testimonials-heading">
					<?php esc_html_e( 'More kind words from customers', 'coffee-cafe-corner' ); ?>
				</h2>
				<div class="quills-testimonials-stars">
					<span class="quills-gold-star">★</span>
					<span class="quills-gold-star">★</span>
					<span class="quills-gold-star">★</span>
					<span class="quills-gold-star">★</span>
					<span class="quills-gold-star">★</span>
				</div>
				<blockquote class="quills-testimonials-quote" id="quills-bottom-quote-text">
					"Amazing coffee. Quills is consistently head and shoulders above others."
				</blockquote>
				<cite class="quills-testimonials-author" id="quills-bottom-quote-author">— Mitchell George</cite>

				<div class="quills-slider-dots">
					<button type="button" class="quills-slider-dot is-active" data-bottom-index="0" aria-label="Customer 1"></button>
					<button type="button" class="quills-slider-dot" data-bottom-index="1" aria-label="Customer 2"></button>
					<button type="button" class="quills-slider-dot" data-bottom-index="2" aria-label="Customer 3"></button>
				</div>
			</div>
		</section>

	</div>
</div>
