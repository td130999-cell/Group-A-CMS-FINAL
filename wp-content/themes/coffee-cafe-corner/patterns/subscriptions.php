<?php
/**
 * Title: Subscriptions
 * Slug: coffee-cafe-corner/subscriptions
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee Subscriptions collection page matching https://quillscoffee.com/collections/subscriptions
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! class_exists( 'Coffee_Cafe_Corner_Subscription_DB' ) ) {
	require_once get_template_directory() . '/inc/class-subscription-db.php';
}

$sort_by = isset( $_GET['sort_by'] ) ? sanitize_text_field( wp_unslash( $_GET['sort_by'] ) ) : 'featured';
$query   = Coffee_Cafe_Corner_Subscription_DB::get_subscription_products_query( $sort_by );

$sub_img_dir = trailingslashit( get_template_directory_uri() ) . 'assets/images/';

$banner_url = get_option( 'quills_sub_hero_img', '' );
if ( empty( $banner_url ) ) {
	$banner_url = content_url( '/uploads/quills/coffeesfreebagbanner2.png' );
	if ( ! file_exists( ABSPATH . 'wp-content/uploads/quills/coffeesfreebagbanner2.png' ) ) {
		$banner_url = $sub_img_dir . 'subscriptions-banner.png';
	}
}

$breadcrumb_home    = get_option( 'quills_sub_breadcrumb_home', __( 'Home', 'coffee-cafe-corner' ) );
$breadcrumb_current = get_option( 'quills_sub_breadcrumb_current', __( 'Subscriptions', 'coffee-cafe-corner' ) );
$hero_title         = get_option( 'quills_sub_hero_title', __( 'Subscriptions', 'coffee-cafe-corner' ) );

$intro_title = get_option( 'quills_sub_intro_title', __( 'Get a free 12oz bag of Inkwell when you subscribe.', 'coffee-cafe-corner' ) );
$intro_desc  = get_option( 'quills_sub_intro_desc', __( 'Experience freshly-roasted coffee delivered right to your door. Choose between crafted blends or a curated rotation of single-origins from around the world.', 'coffee-cafe-corner' ) );
$intro_note  = get_option( 'quills_sub_intro_note', __( '(Free bag offer valid for new subscribers only.)', 'coffee-cafe-corner' ) );

// Top quotes
$top_q1_text   = get_option( 'quills_sub_top_q1_text', '"The smell alone makes you want to rip open the bag and drink it right away. This coffee is THE BEST."' );
$top_q1_author = get_option( 'quills_sub_top_q1_author', '— C. Diller' );
$top_q2_text   = get_option( 'quills_sub_top_q2_text', '"One cup is all it took, and we were hooked! Now we order online to have our favorite cup on a daily basis."' );
$top_q2_author = get_option( 'quills_sub_top_q2_author', '— Brianne E.' );
$top_q3_text   = get_option( 'quills_sub_top_q3_text', '"Quills has the best coffee and great customer service! 5 stars!!! We love getting to try a variety of different roasts!"' );
$top_q3_author = get_option( 'quills_sub_top_q3_author', '— Kelly Davis' );

// Bottom quotes
$bottom_heading = get_option( 'quills_sub_bottom_heading', __( 'More kind words from customers', 'coffee-cafe-corner' ) );
$bottom_q1_text   = get_option( 'quills_sub_bottom_q1_text', '"This is probably the best coffee I\'ve ever had."' );
$bottom_q1_author = get_option( 'quills_sub_bottom_q1_author', '— Jamie W.' );
$bottom_q2_text   = get_option( 'quills_sub_bottom_q2_text', '"It’s our favorite coffee!! We entertain frequently and everyone seems to enjoy this coffee."' );
$bottom_q2_author = get_option( 'quills_sub_bottom_q2_author', '— Lisa Peters' );
$bottom_q3_text   = get_option( 'quills_sub_bottom_q3_text', '"Mega delicious! Just sent some to my sister in California to try to get her hooked."' );
$bottom_q3_author = get_option( 'quills_sub_bottom_q3_author', '— Sarah R.' );
?>

<div class="quills-subscriptions-page">
	<div class="quills-subscriptions-inner">

		<!-- 1. Breadcrumbs -->
		<nav class="quills-sub-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'coffee-cafe-corner' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-sub-breadcrumb-link"><?php echo esc_html( $breadcrumb_home ); ?></a>
			<span class="quills-sub-sep">/</span>
			<span class="quills-sub-current"><?php echo esc_html( $breadcrumb_current ); ?></span>
		</nav>

		<!-- 2. Hero Banner with Script Title and FREE BAG Badge -->
		<section class="quills-sub-hero-banner" aria-label="<?php esc_attr_e( 'Subscriptions Banner', 'coffee-cafe-corner' ); ?>">
			<div class="quills-sub-hero-image-wrap">
				<img src="<?php echo esc_url( $banner_url ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>" class="quills-sub-hero-bg-img" />
				<div class="quills-sub-hero-overlay">
					<h1 class="quills-sub-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
				</div>
			</div>
		</section>

		<!-- 3. Rich Text Copy Section -->
		<section class="quills-sub-intro-section">
			<h2 class="quills-sub-intro-title">
				<?php echo esc_html( $intro_title ); ?>
			</h2>
			<p class="quills-sub-intro-desc">
				<?php echo esc_html( $intro_desc ); ?>
			</p>
			<p class="quills-sub-intro-note">
				<?php echo esc_html( $intro_note ); ?>
			</p>
		</section>

		<!-- Divider -->
		<hr class="quills-sub-divider" />

		<!-- 4. Top Testimonial Slider -->
		<section class="quills-sub-testimonial-slider" id="quills-top-testimonial-slider" aria-label="<?php esc_attr_e( 'Customer Reviews', 'coffee-cafe-corner' ); ?>">
			<div class="quills-sub-track-container">
				<!-- Navigation Arrows (Hidden by default, visible on hover) -->
				<button type="button" class="quills-sub-nav-btn quills-sub-nav-prev is-disabled" aria-label="<?php esc_attr_e( 'Previous review', 'coffee-cafe-corner' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
				</button>
				<button type="button" class="quills-sub-nav-btn quills-sub-nav-next" aria-label="<?php esc_attr_e( 'Next review', 'coffee-cafe-corner' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
				</button>

				<div class="quills-sub-slider-track">
				<!-- Slide 1 -->
				<div class="quills-sub-slide is-active" data-index="0">
					<div class="quills-sub-stars">★★★★★</div>
					<blockquote class="quills-sub-quote">
						<?php echo esc_html( $top_q1_text ); ?>
					</blockquote>
					<div class="quills-sub-author"><?php echo esc_html( $top_q1_author ); ?></div>
				</div>

				<!-- Slide 2 -->
				<div class="quills-sub-slide" data-index="1">
					<div class="quills-sub-stars">★★★★★</div>
					<blockquote class="quills-sub-quote">
						<?php echo esc_html( $top_q2_text ); ?>
					</blockquote>
					<div class="quills-sub-author"><?php echo esc_html( $top_q2_author ); ?></div>
				</div>

				<!-- Slide 3 -->
				<div class="quills-sub-slide" data-index="2">
					<div class="quills-sub-stars">★★★★★</div>
					<blockquote class="quills-sub-quote">
						<?php echo esc_html( $top_q3_text ); ?>
					</blockquote>
					<div class="quills-sub-author"><?php echo esc_html( $top_q3_author ); ?></div>
				</div>
			</div>
		</div>

		<!-- Pagination Dots -->
			<div class="quills-sub-dots" role="tablist">
				<button type="button" class="quills-sub-dot is-active" data-slide="0" aria-label="<?php esc_attr_e( 'Slide 1', 'coffee-cafe-corner' ); ?>"></button>
				<button type="button" class="quills-sub-dot" data-slide="1" aria-label="<?php esc_attr_e( 'Slide 2', 'coffee-cafe-corner' ); ?>"></button>
				<button type="button" class="quills-sub-dot" data-slide="2" aria-label="<?php esc_attr_e( 'Slide 3', 'coffee-cafe-corner' ); ?>"></button>
			</div>
		</section>

		<!-- Divider -->
		<hr class="quills-sub-divider" />

		<!-- 5. Collection Toolbar (Count, Filter, Sort) -->
		<div class="quills-sub-toolbar">
			<div class="quills-sub-toolbar-left">
				<span class="quills-sub-product-count" id="quills-sub-count">
					<?php printf( esc_html__( '%d products', 'coffee-cafe-corner' ), $query->found_posts ); ?>
				</span>
			</div>

			<div class="quills-sub-toolbar-right">
				<button type="button" class="quills-sub-filter-trigger" id="quills-sub-filter-btn" aria-expanded="false" aria-controls="quills-sub-filter-drawer">
					<svg class="quills-filter-icon" width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

				<div class="quills-sub-sort-control">
					<label for="quills-sub-sort-select" class="quills-sub-sort-label"><?php esc_html_e( 'Sort by:', 'coffee-cafe-corner' ); ?></label>
					<div class="quills-sub-select-wrapper">
						<select id="quills-sub-sort-select" class="quills-sub-sort-dropdown">
							<option value="featured" <?php selected( $sort_by, 'featured' ); ?>><?php esc_html_e( 'Featured', 'coffee-cafe-corner' ); ?></option>
							<option value="best-selling" <?php selected( $sort_by, 'best-selling' ); ?>><?php esc_html_e( 'Best selling', 'coffee-cafe-corner' ); ?></option>
							<option value="title-ascending" <?php selected( $sort_by, 'title-ascending' ); ?>><?php esc_html_e( 'Alphabetically, A-Z', 'coffee-cafe-corner' ); ?></option>
							<option value="title-descending" <?php selected( $sort_by, 'title-descending' ); ?>><?php esc_html_e( 'Alphabetically, Z-A', 'coffee-cafe-corner' ); ?></option>
							<option value="price-ascending" <?php selected( $sort_by, 'price-ascending' ); ?>><?php esc_html_e( 'Price, low to high', 'coffee-cafe-corner' ); ?></option>
							<option value="price-descending" <?php selected( $sort_by, 'price-descending' ); ?>><?php esc_html_e( 'Price, high to low', 'coffee-cafe-corner' ); ?></option>
							<option value="created-descending" <?php selected( $sort_by, 'created-descending' ); ?>><?php esc_html_e( 'Date, new to old', 'coffee-cafe-corner' ); ?></option>
							<option value="created-ascending" <?php selected( $sort_by, 'created-ascending' ); ?>><?php esc_html_e( 'Date, old to new', 'coffee-cafe-corner' ); ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<!-- Filter Drawer / Modal -->
		<div class="quills-sub-filter-drawer" id="quills-sub-filter-drawer" aria-hidden="true">
			<div class="quills-sub-filter-drawer-header">
				<h3 class="quills-sub-filter-drawer-title"><?php esc_html_e( 'Filter products', 'coffee-cafe-corner' ); ?></h3>
				<button type="button" class="quills-sub-filter-close-btn" id="quills-sub-filter-close" aria-label="<?php esc_attr_e( 'Close filters', 'coffee-cafe-corner' ); ?>">✕</button>
			</div>
			<div class="quills-sub-filter-drawer-body">
				<div class="quills-sub-filter-group">
					<h4 class="quills-sub-filter-heading"><?php esc_html_e( 'Availability', 'coffee-cafe-corner' ); ?></h4>
					<label class="quills-sub-filter-checkbox">
						<input type="checkbox" name="filter_in_stock" checked />
						<span><?php esc_html_e( 'In stock (9)', 'coffee-cafe-corner' ); ?></span>
					</label>
				</div>
				<div class="quills-sub-filter-group">
					<h4 class="quills-sub-filter-heading"><?php esc_html_e( 'Product type', 'coffee-cafe-corner' ); ?></h4>
					<label class="quills-sub-filter-checkbox">
						<input type="checkbox" name="filter_type_blend" checked />
						<span><?php esc_html_e( 'Blend (6)', 'coffee-cafe-corner' ); ?></span>
					</label>
					<label class="quills-sub-filter-checkbox">
						<input type="checkbox" name="filter_type_single" checked />
						<span><?php esc_html_e( 'Single Origin (2)', 'coffee-cafe-corner' ); ?></span>
					</label>
					<label class="quills-sub-filter-checkbox">
						<input type="checkbox" name="filter_type_decaf" checked />
						<span><?php esc_html_e( 'Decaf (1)', 'coffee-cafe-corner' ); ?></span>
					</label>
				</div>
			</div>
		</div>
		<div class="quills-sub-filter-backdrop" id="quills-sub-filter-backdrop"></div>

		<!-- 6. 3-Column Product Grid -->
		<div class="quills-sub-grid" id="quills-sub-product-grid">
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					Coffee_Cafe_Corner_Subscription_DB::render_product_card( get_the_ID() );
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="quills-no-products">
					<p><?php esc_html_e( 'No subscription products found.', 'coffee-cafe-corner' ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<!-- Divider -->
		<hr class="quills-sub-divider quills-sub-divider--bottom" />

		<!-- 7. Bottom Testimonial Section -->
		<section class="quills-sub-bottom-testimonials" id="quills-bottom-testimonial-slider" aria-label="<?php esc_attr_e( 'More Customer Reviews', 'coffee-cafe-corner' ); ?>">
			<h2 class="quills-sub-bottom-heading">
				<?php echo esc_html( $bottom_heading ); ?>
			</h2>

			<div class="quills-sub-track-container">
				<!-- Navigation Arrows (Hidden by default, visible on hover) -->
				<button type="button" class="quills-sub-nav-btn quills-sub-nav-prev is-disabled" aria-label="<?php esc_attr_e( 'Previous review', 'coffee-cafe-corner' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
				</button>
				<button type="button" class="quills-sub-nav-btn quills-sub-nav-next" aria-label="<?php esc_attr_e( 'Next review', 'coffee-cafe-corner' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
				</button>

				<div class="quills-sub-bottom-track">
					<!-- Slide 1 -->
					<div class="quills-sub-bottom-slide is-active" data-index="0">
						<div class="quills-sub-stars">★★★★★</div>
						<blockquote class="quills-sub-quote">
							<?php echo esc_html( $bottom_q1_text ); ?>
						</blockquote>
						<div class="quills-sub-author"><?php echo esc_html( $bottom_q1_author ); ?></div>
					</div>

					<!-- Slide 2 -->
					<div class="quills-sub-bottom-slide" data-index="1">
						<div class="quills-sub-stars">★★★★★</div>
						<blockquote class="quills-sub-quote">
							<?php echo esc_html( $bottom_q2_text ); ?>
						</blockquote>
						<div class="quills-sub-author"><?php echo esc_html( $bottom_q2_author ); ?></div>
					</div>

					<!-- Slide 3 -->
					<div class="quills-sub-bottom-slide" data-index="2">
						<div class="quills-sub-stars">★★★★★</div>
						<blockquote class="quills-sub-quote">
							<?php echo esc_html( $bottom_q3_text ); ?>
						</blockquote>
						<div class="quills-sub-author"><?php echo esc_html( $bottom_q3_author ); ?></div>
					</div>
				</div>
			</div>

			<!-- Pagination Dots -->
			<div class="quills-sub-dots" role="tablist">
				<button type="button" class="quills-sub-bottom-dot is-active" data-slide="0" aria-label="<?php esc_attr_e( 'Slide 1', 'coffee-cafe-corner' ); ?>"></button>
				<button type="button" class="quills-sub-bottom-dot" data-slide="1" aria-label="<?php esc_attr_e( 'Slide 2', 'coffee-cafe-corner' ); ?>"></button>
				<button type="button" class="quills-sub-bottom-dot" data-slide="2" aria-label="<?php esc_attr_e( 'Slide 3', 'coffee-cafe-corner' ); ?>"></button>
			</div>
		</section>

	</div>
</div>
