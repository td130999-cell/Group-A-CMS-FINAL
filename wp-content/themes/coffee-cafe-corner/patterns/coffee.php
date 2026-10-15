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

$url_processes = array();
$url_roasts    = array();
$url_types     = array();
$current_sort  = isset( $_GET['sort_by'] ) ? sanitize_text_field( wp_unslash( $_GET['sort_by'] ) ) : 'best-selling';

// Support standard array or comma-separated query parameters
if ( ! empty( $_GET['process'] ) ) {
	$raw_proc = is_array( $_GET['process'] ) ? $_GET['process'] : explode( ',', sanitize_text_field( wp_unslash( $_GET['process'] ) ) );
	$url_processes = array_merge( $url_processes, $raw_proc );
}
if ( ! empty( $_GET['roast'] ) ) {
	$raw_roast = is_array( $_GET['roast'] ) ? $_GET['roast'] : explode( ',', sanitize_text_field( wp_unslash( $_GET['roast'] ) ) );
	$url_roasts = array_merge( $url_roasts, $raw_roast );
}
if ( ! empty( $_GET['tab'] ) ) {
	$raw_tab = is_array( $_GET['tab'] ) ? $_GET['tab'] : explode( ',', sanitize_text_field( wp_unslash( $_GET['tab'] ) ) );
	$url_types = array_merge( $url_types, $raw_tab );
}

// Support Shopify-style parameters e.g. filter.p.m.custom.process=Honey&filter.p.m.custom.process=Natural
if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
	$raw_pairs = explode( '&', $_SERVER['QUERY_STRING'] );
	foreach ( $raw_pairs as $pair ) {
		$parts = explode( '=', $pair, 2 );
		if ( count( $parts ) === 2 ) {
			$k = urldecode( $parts[0] );
			$v = urldecode( $parts[1] );
			if ( 'filter.p.m.custom.process' === $k ) {
				$url_processes[] = sanitize_text_field( $v );
			} elseif ( 'filter.p.m.custom.roast_profile' === $k ) {
				$url_roasts[] = sanitize_text_field( $v );
			} elseif ( 'filter.p.m.custom.coffee_type' === $k ) {
				$url_types[] = sanitize_title( $v );
			}
		}
	}
}

$url_processes = array_values( array_unique( array_filter( array_map( 'trim', $url_processes ) ) ) );
$url_roasts    = array_values( array_unique( array_filter( array_map( 'trim', $url_roasts ) ) ) );
$url_types     = array_values( array_unique( array_filter( array_map( 'trim', $url_types ) ) ) );

$allowed_sorts = array(
	'best-selling'       => __( 'Best selling', 'coffee-cafe-corner' ),
	'manual'             => __( 'Featured', 'coffee-cafe-corner' ),
	'price-ascending'    => __( 'Price, low to high', 'coffee-cafe-corner' ),
	'price-descending'   => __( 'Price, high to low', 'coffee-cafe-corner' ),
	'title-ascending'    => __( 'Alphabetically, A-Z', 'coffee-cafe-corner' ),
	'title-descending'   => __( 'Alphabetically, Z-A', 'coffee-cafe-corner' ),
	'created-descending' => __( 'Date, new to old', 'coffee-cafe-corner' ),
);

$facet_counts   = Coffee_Cafe_Corner_Coffee_DB::get_filter_counts();
$query          = Coffee_Cafe_Corner_Coffee_DB::get_products_query( $url_types, $url_processes, $url_roasts, $current_sort );
$total_products = $query->found_posts;
$total_selected = count( $url_processes ) + count( $url_roasts ) + count( $url_types );
?>

<div class="quills-coffee-page-wrapper">
	<div class="quills-coffee-container">

		<!-- Top Breadcrumb -->
		<nav class="quills-coffee-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'coffee-cafe-corner' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-breadcrumb-link"><?php esc_html_e( 'Home', 'coffee-cafe-corner' ); ?></a>
			<span class="quills-breadcrumb-sep">/</span>
			<span class="quills-breadcrumb-current"><?php esc_html_e( 'Coffee', 'coffee-cafe-corner' ); ?></span>
		</nav>

		<!-- Hero Banner Box with Coffee Photo & Script Title -->
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

		<!-- Quick Category Filter Pills (Terracotta Red Buttons matching Screenshot 2) -->
		<div class="quills-category-pills-wrap">
			<button type="button" class="quills-category-pill <?php echo in_array( 'blend', $url_types, true ) ? 'is-active' : ''; ?>" data-tab="blend">
				<?php esc_html_e( 'Blends', 'coffee-cafe-corner' ); ?>
			</button>
			<button type="button" class="quills-category-pill <?php echo in_array( 'single-origin', $url_types, true ) ? 'is-active' : ''; ?>" data-tab="single-origin">
				<?php esc_html_e( 'Single Origin', 'coffee-cafe-corner' ); ?>
			</button>
			<button type="button" class="quills-category-pill <?php echo in_array( 'espresso', $url_types, true ) ? 'is-active' : ''; ?>" data-tab="espresso">
				<?php esc_html_e( 'Espresso', 'coffee-cafe-corner' ); ?>
			</button>
			<button type="button" class="quills-category-pill <?php echo in_array( 'decaf', $url_types, true ) ? 'is-active' : ''; ?>" data-tab="decaf">
				<?php esc_html_e( 'Decaf', 'coffee-cafe-corner' ); ?>
			</button>
		</div>

		<!-- 2-Column Main Layout: Left Accordion Sidebar + Right Product Grid -->
		<div class="quills-coffee-main-layout">
			
			<!-- Left Column: Accordion Filter Sidebar -->
			<aside class="quills-coffee-sidebar" aria-label="<?php esc_attr_e( 'Coffee Filters', 'coffee-cafe-corner' ); ?>">
				
				<!-- Active Filters Block (Visible when >= 1 checkbox checked, matches Quills exactly) -->
				<div class="quills-active-filters" id="quills-active-filters" style="<?php echo ( $total_selected > 0 ) ? '' : 'display: none;'; ?>">
					<div class="quills-active-filters-header">
						<span class="quills-active-filters-title"><?php esc_html_e( 'Filter', 'coffee-cafe-corner' ); ?></span>
						<button type="button" class="quills-active-filters-remove-all" id="quills-filters-remove-all">
							<?php esc_html_e( 'Remove all', 'coffee-cafe-corner' ); ?>
						</button>
					</div>
					<div class="quills-active-filters-list" id="quills-active-filters-list">
						<?php foreach ( $url_processes as $proc_item ) : ?>
							<button type="button" class="quills-filter-tag" data-target-name="filter_process[]" data-target-val="<?php echo esc_attr( $proc_item ); ?>">
								<?php echo esc_html( 'Process: ' . $proc_item ); ?> <span class="quills-filter-tag-x">✕</span>
							</button>
						<?php endforeach; ?>
						<?php foreach ( $url_roasts as $roast_item ) : ?>
							<button type="button" class="quills-filter-tag" data-target-name="filter_roast[]" data-target-val="<?php echo esc_attr( $roast_item ); ?>">
								<?php echo esc_html( 'Roast Profile: ' . $roast_item ); ?> <span class="quills-filter-tag-x">✕</span>
							</button>
						<?php endforeach; ?>
						<?php 
						$type_labels = array( 'blend' => 'Blend', 'decaf' => 'Decaf', 'espresso' => 'Espresso', 'single-origin' => 'Single Origin' );
						foreach ( $url_types as $type_item ) : 
							$type_label = $type_labels[ $type_item ] ?? ucfirst( $type_item );
						?>
							<button type="button" class="quills-filter-tag" data-target-name="filter_type[]" data-target-val="<?php echo esc_attr( $type_item ); ?>">
								<?php echo esc_html( 'Coffee: ' . $type_label ); ?> <span class="quills-filter-tag-x">✕</span>
							</button>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Accordion Item 1: Process -->
				<?php $proc_count = count( $url_processes ); ?>
				<div class="quills-accordion-item <?php echo $proc_count > 0 ? 'is-open' : ''; ?>" data-filter-group="process">
					<button type="button" class="quills-accordion-header" aria-expanded="<?php echo $proc_count > 0 ? 'true' : 'false'; ?>">
						<span class="quills-accordion-title">
							<?php esc_html_e( 'Process', 'coffee-cafe-corner' ); ?>
							<span class="quills-accordion-selected-count" data-count-for="process"><?php echo $proc_count > 0 ? '(' . $proc_count . ')' : ''; ?></span>
						</span>
						<span class="quills-accordion-icon"><?php echo $proc_count > 0 ? '−' : '+'; ?></span>
					</button>
					<div class="quills-accordion-content">
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_process[]" value="Honey" data-group-label="Process" data-option-label="Honey" <?php checked( in_array( 'Honey', $url_processes, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Honey', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['process']['Honey'] ?? 1 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_process[]" value="Natural" data-group-label="Process" data-option-label="Natural" <?php checked( in_array( 'Natural', $url_processes, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Natural', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['process']['Natural'] ?? 2 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_process[]" value="Washed" data-group-label="Process" data-option-label="Washed" <?php checked( in_array( 'Washed', $url_processes, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Washed', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['process']['Washed'] ?? 9 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_process[]" value="Washed & Natural" data-group-label="Process" data-option-label="Washed & Natural" <?php checked( in_array( 'Washed & Natural', $url_processes, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Washed & Natural', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['process']['Washed & Natural'] ?? 3 ); ?>)</span>
						</label>
					</div>
				</div>

				<!-- Accordion Item 2: Roast Profile -->
				<?php $roast_count = count( $url_roasts ); ?>
				<div class="quills-accordion-item <?php echo $roast_count > 0 ? 'is-open' : ''; ?>" data-filter-group="roast">
					<button type="button" class="quills-accordion-header" aria-expanded="<?php echo $roast_count > 0 ? 'true' : 'false'; ?>">
						<span class="quills-accordion-title">
							<?php esc_html_e( 'Roast Profile', 'coffee-cafe-corner' ); ?>
							<span class="quills-accordion-selected-count" data-count-for="roast"><?php echo $roast_count > 0 ? '(' . $roast_count . ')' : ''; ?></span>
						</span>
						<span class="quills-accordion-icon"><?php echo $roast_count > 0 ? '−' : '+'; ?></span>
					</button>
					<div class="quills-accordion-content">
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_roast[]" value="Dark" data-group-label="Roast Profile" data-option-label="Dark" <?php checked( in_array( 'Dark', $url_roasts, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Dark', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['roast']['Dark'] ?? 1 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_roast[]" value="Light" data-group-label="Roast Profile" data-option-label="Light" <?php checked( in_array( 'Light', $url_roasts, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Light', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['roast']['Light'] ?? 5 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_roast[]" value="Medium" data-group-label="Roast Profile" data-option-label="Medium" <?php checked( in_array( 'Medium', $url_roasts, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Medium', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['roast']['Medium'] ?? 7 ); ?>)</span>
						</label>
					</div>
				</div>

				<!-- Accordion Item 3: Coffee (Type) -->
				<?php $type_count = count( $url_types ); ?>
				<div class="quills-accordion-item <?php echo $type_count > 0 ? 'is-open' : ''; ?>" data-filter-group="coffee">
					<button type="button" class="quills-accordion-header" aria-expanded="<?php echo $type_count > 0 ? 'true' : 'false'; ?>">
						<span class="quills-accordion-title">
							<?php esc_html_e( 'Coffee', 'coffee-cafe-corner' ); ?>
							<span class="quills-accordion-selected-count" data-count-for="coffee"><?php echo $type_count > 0 ? '(' . $type_count . ')' : ''; ?></span>
						</span>
						<span class="quills-accordion-icon"><?php echo $type_count > 0 ? '−' : '+'; ?></span>
					</button>
					<div class="quills-accordion-content">
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_type[]" value="blend" data-group-label="Coffee" data-option-label="Blend" <?php checked( in_array( 'blend', $url_types, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Blend', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['type']['Blend'] ?? 7 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_type[]" value="decaf" data-group-label="Coffee" data-option-label="Decaf" <?php checked( in_array( 'decaf', $url_types, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Decaf', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['type']['Decaf'] ?? 1 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_type[]" value="espresso" data-group-label="Coffee" data-option-label="Espresso" <?php checked( in_array( 'espresso', $url_types, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Espresso', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['type']['Espresso'] ?? 1 ); ?>)</span>
						</label>
						<label class="quills-filter-checkbox">
							<input type="checkbox" name="filter_type[]" value="single-origin" data-group-label="Coffee" data-option-label="Single Origin" <?php checked( in_array( 'single-origin', $url_types, true ) ); ?>>
							<span class="quills-checkbox-custom"></span>
							<span class="quills-checkbox-label"><?php esc_html_e( 'Single Origin', 'coffee-cafe-corner' ); ?></span>
							<span class="quills-checkbox-count">(<?php echo (int) ( $facet_counts['type']['Single Origin'] ?? 5 ); ?>)</span>
						</label>
					</div>
				</div>

			</aside>

			<!-- Right Column: Product Content Area -->
			<div class="quills-coffee-content-area">
				
				<!-- Toolbar: Product Count & Sort By -->
				<div class="quills-coffee-toolbar">
					<div class="quills-toolbar-left">
						<span class="quills-products-count" id="quills-products-count">
							<?php
							if ( $total_selected > 0 ) {
								printf( esc_html__( '%d of 13 products', 'coffee-cafe-corner' ), (int) $total_products );
							} else {
								printf( esc_html__( '%d products', 'coffee-cafe-corner' ), (int) $total_products );
							}
							?>
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

				<!-- Product Grid (3 columns matching Screenshot 2, 3, 4) -->
				<div class="quills-coffee-grid" id="quills-coffee-grid">
					<?php
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) :
							$query->the_post();
							$product_id    = get_the_ID();
							$title         = get_the_title();
							$price_display = get_post_meta( $product_id, '_price_display', true );
							if ( empty( $price_display ) ) {
								$price         = get_post_meta( $product_id, '_price', true );
								$price_display = $price ? '$' . number_format( (float) $price, 2 ) : 'FROM $20.00';
							}
							$rating        = (float) get_post_meta( $product_id, '_wc_average_rating', true );
							$review_count  = (int) get_post_meta( $product_id, '_wc_review_count', true );
							$image_url     = Coffee_Cafe_Corner_Coffee_DB::get_product_image_url( $product_id );
							?>
							<article class="quills-coffee-card">
								<div class="quills-coffee-card-media">
									<a href="<?php the_permalink(); ?>" class="quills-coffee-card-link">
										<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="quills-coffee-card-img" loading="lazy" />
									</a>
								</div>
								<div class="quills-coffee-card-content">
									<h3 class="quills-coffee-card-title">
										<a href="<?php the_permalink(); ?>"><?php echo esc_html( $title ); ?></a>
									</h3>
									<div class="quills-coffee-card-rating">
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
									<div class="quills-coffee-card-price">
										<?php echo esc_html( $price_display ); ?>
									</div>
								</div>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<p class="quills-no-products"><?php esc_html_e( 'No coffee products found matching the criteria.', 'coffee-cafe-corner' ); ?></p>
						<?php
					endif;
					?>
				</div>

			</div>
		</div>

		<div class="quills-separator-line quills-separator-line--bottom"></div>

		<!-- Customer Testimonial Bottom Banner (Matching Screenshot 4) -->
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

				<div class="quills-slider-dots">
					<button type="button" class="quills-slider-dot is-active" data-bottom-index="0" aria-label="Customer 1"></button>
					<button type="button" class="quills-slider-dot" data-bottom-index="1" aria-label="Customer 2"></button>
					<button type="button" class="quills-slider-dot" data-bottom-index="2" aria-label="Customer 3"></button>
				</div>
			</div>
		</section>

	</div>
</div>
