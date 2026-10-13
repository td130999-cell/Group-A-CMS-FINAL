<?php
/**
 * Title: Subscriptions
 * Slug: coffee-cafe-corner/subscriptions
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee Subscription collection page with flexible recurring delivery, grind selection, and automatic savings.
 *
 * @package Coffee_Cafe_Corner
 */

if ( ! class_exists( 'Coffee_Cafe_Corner_Subscription_DB' ) ) {
	require_once get_template_directory() . '/inc/class-subscription-db.php';
}

$query = Coffee_Cafe_Corner_Subscription_DB::get_subscription_products_query();
?>

<div class="quills-subscriptions-wrapper">
	<div class="quills-subscriptions-container">

		<!-- Breadcrumbs -->
		<nav class="quills-sub-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'coffee-cafe-corner' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="quills-sub-breadcrumb-link"><?php esc_html_e( 'Home', 'coffee-cafe-corner' ); ?></a>
			<span class="quills-sub-breadcrumb-sep">/</span>
			<span class="quills-sub-breadcrumb-current"><?php esc_html_e( 'Subscriptions', 'coffee-cafe-corner' ); ?></span>
		</nav>

		<!-- Hero Banner Box with Script Title -->
		<section class="quills-sub-hero" aria-label="<?php esc_attr_e( 'Subscriptions', 'coffee-cafe-corner' ); ?>">
			<div class="quills-sub-hero-card">
				<h1 class="quills-sub-hero-title"><?php esc_html_e( 'Subscriptions', 'coffee-cafe-corner' ); ?></h1>
			</div>
		</section>

		<!-- Promo Gift Highlight -->
		<div class="quills-sub-promo-bar">
			<div class="quills-sub-promo-content">
				<span class="quills-sub-promo-icon">🎁</span>
				<strong class="quills-sub-promo-text">
					<?php esc_html_e( 'Get a free 12 oz bag of coffee when you subscribe.', 'coffee-cafe-corner' ); ?>
				</strong>
				<span class="quills-sub-promo-subtext">
					<?php esc_html_e( 'Quills Subscriptions let you order once then enjoy freshly-roasted coffee delivered to your doorstep.', 'coffee-cafe-corner' ); ?>
				</span>
			</div>
		</div>

		<!-- Intro Philosophy Statement -->
		<section class="quills-sub-intro">
			<p class="quills-sub-intro-text">
				<?php esc_html_e( "Life is busy, we get it. That doesn't mean you can't enjoy an incredible cup of coffee. Quills Subscriptions let you order once then enjoy great, freshly-roasted coffee as often as you like. Choose an option below to start your journey!", 'coffee-cafe-corner' ); ?>
			</p>
		</section>

		<!-- Subscription Plans Grid -->
		<div class="quills-sub-grid">
			<?php
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					$product_id    = get_the_ID();
					$title         = get_the_title();
					$base_price    = (float) get_post_meta( $product_id, '_price', true );
					if ( ! $base_price ) {
						$base_price = 20.00;
					}
					$discount_price= round( $base_price * 0.9, 2 );
					$badge         = get_post_meta( $product_id, '_subscription_badge', true );
					$rating        = (float) get_post_meta( $product_id, '_wc_average_rating', true );
					$review_count  = (int) get_post_meta( $product_id, '_wc_review_count', true );
					$image_rel     = get_post_meta( $product_id, '_subscription_image', true );
					$fallback_rel  = get_post_meta( $product_id, '_subscription_fallback_image', true );

					$image_url = '';
					if ( ! empty( $image_rel ) && file_exists( get_template_directory() . '/assets/images/' . $image_rel ) ) {
						$image_url = trailingslashit( get_template_directory_uri() ) . 'assets/images/' . $image_rel;
					} elseif ( ! empty( $fallback_rel ) && file_exists( ABSPATH . 'wp-content/uploads/' . $fallback_rel ) ) {
						$image_url = content_url( '/uploads/' . $fallback_rel );
					} elseif ( has_post_thumbnail( $product_id ) ) {
						$image_url = get_the_post_thumbnail_url( $product_id, 'medium_large' );
					} else {
						$image_url = trailingslashit( get_template_directory_uri() ) . 'assets/images/coffee/inkwell.jpg';
					}
					?>
					<article class="quills-sub-card" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-base-price="<?php echo esc_attr( $base_price ); ?>">
						<div class="quills-sub-card-media">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="quills-sub-card-img" loading="lazy" />
							<?php if ( ! empty( $badge ) ) : ?>
								<span class="quills-sub-badge"><?php echo esc_html( $badge ); ?></span>
							<?php endif; ?>
						</div>

						<div class="quills-sub-card-body">
							<h3 class="quills-sub-card-title"><?php echo esc_html( $title ); ?></h3>

							<div class="quills-sub-card-rating">
								<span class="quills-stars">
									<?php
									for ( $i = 1; $i <= 5; $i++ ) {
										echo '<span class="quills-star quills-star--filled">★</span>';
									}
									?>
								</span>
								<span class="quills-sub-reviews">(<?php echo esc_html( $review_count ? $review_count : 25 ); ?> reviews)</span>
							</div>

							<p class="quills-sub-card-desc"><?php echo esc_html( get_the_excerpt() ); ?></p>

							<!-- Frequency Selector Options -->
							<div class="quills-sub-option-group">
								<label class="quills-sub-label"><?php esc_html_e( 'Delivery Frequency:', 'coffee-cafe-corner' ); ?></label>
								<div class="quills-sub-frequency-pills">
									<label class="quills-pill-label">
										<input type="radio" name="freq_<?php echo esc_attr( $product_id ); ?>" value="1-week" class="quills-freq-radio" />
										<span class="quills-pill">Every 1 Wk</span>
									</label>
									<label class="quills-pill-label">
										<input type="radio" name="freq_<?php echo esc_attr( $product_id ); ?>" value="2-weeks" class="quills-freq-radio" checked />
										<span class="quills-pill is-featured">Every 2 Wks (Save 10%)</span>
									</label>
									<label class="quills-pill-label">
										<input type="radio" name="freq_<?php echo esc_attr( $product_id ); ?>" value="4-weeks" class="quills-freq-radio" />
										<span class="quills-pill">Every 4 Wks</span>
									</label>
								</div>
							</div>

							<!-- Grind Selector Options -->
							<div class="quills-sub-option-group">
								<label class="quills-sub-label"><?php esc_html_e( 'Grind Option:', 'coffee-cafe-corner' ); ?></label>
								<select class="quills-sub-grind-select" name="grind_<?php echo esc_attr( $product_id ); ?>">
									<option value="whole-bean"><?php esc_html_e( 'Whole Bean (Recommended)', 'coffee-cafe-corner' ); ?></option>
									<option value="drip"><?php esc_html_e( 'Drip / Pour-Over (Medium)', 'coffee-cafe-corner' ); ?></option>
									<option value="french-press"><?php esc_html_e( 'French Press (Coarse)', 'coffee-cafe-corner' ); ?></option>
									<option value="espresso"><?php esc_html_e( 'Espresso (Fine)', 'coffee-cafe-corner' ); ?></option>
									<option value="cold-brew"><?php esc_html_e( 'Cold Brew (Extra Coarse)', 'coffee-cafe-corner' ); ?></option>
								</select>
							</div>

							<!-- Price and Subscribe Button -->
							<div class="quills-sub-action-row">
								<div class="quills-sub-price-wrapper">
									<span class="quills-sub-price-label"><?php esc_html_e( 'Total per order:', 'coffee-cafe-corner' ); ?></span>
									<span class="quills-sub-calculated-price">$<?php echo esc_html( number_format( $discount_price, 2 ) ); ?></span>
									<del class="quills-sub-original-price">$<?php echo esc_html( number_format( $base_price, 2 ) ); ?></del>
								</div>
								<button type="button" class="quills-sub-submit-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>">
									<?php esc_html_e( 'SUBSCRIBE NOW', 'coffee-cafe-corner' ); ?>
								</button>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

		<!-- Subscription Benefits Bar -->
		<section class="quills-sub-perks">
			<div class="quills-perk-item">
				<div class="quills-perk-icon">📦</div>
				<h4 class="quills-perk-title"><?php esc_html_e( 'Free Shipping', 'coffee-cafe-corner' ); ?></h4>
				<p class="quills-perk-desc"><?php esc_html_e( 'All subscription deliveries ship completely free nationwide.', 'coffee-cafe-corner' ); ?></p>
			</div>
			<div class="quills-perk-item">
				<div class="quills-perk-icon">🔥</div>
				<h4 class="quills-perk-title"><?php esc_html_e( 'Roasted to Order', 'coffee-cafe-corner' ); ?></h4>
				<p class="quills-perk-desc"><?php esc_html_e( 'Small-batch roasted within 48 hours of dispatch for peak aroma.', 'coffee-cafe-corner' ); ?></p>
			</div>
			<div class="quills-perk-item">
				<div class="quills-perk-icon">⚡</div>
				<h4 class="quills-perk-title"><?php esc_html_e( 'Zero Commitment', 'coffee-cafe-corner' ); ?></h4>
				<p class="quills-perk-desc"><?php esc_html_e( 'Swap, skip, pause or cancel anytime with one click in your account.', 'coffee-cafe-corner' ); ?></p>
			</div>
		</section>

		<!-- Link to Merch Section -->
		<section class="quills-sub-merch-link-banner">
			<div class="quills-sub-merch-inner">
				<h3 class="quills-sub-merch-title"><?php esc_html_e( 'Looking for Quills Apparel & Mugs?', 'coffee-cafe-corner' ); ?></h3>
				<p class="quills-sub-merch-desc"><?php esc_html_e( 'Explore our embroidered hats, diner mugs, hoodies, and totes.', 'coffee-cafe-corner' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/merch/' ) ); ?>" class="quills-sub-merch-btn">
					<?php esc_html_e( 'EXPLORE MERCH', 'coffee-cafe-corner' ); ?> →
				</a>
			</div>
		</section>

	</div>
</div>
