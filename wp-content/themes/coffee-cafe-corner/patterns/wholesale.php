<?php
/**
 * Title: Wholesale
 * Slug: coffee-cafe-corner/wholesale
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee Wholesale Roasting page pattern, dynamically pulling content, video settings, and copy from WordPress database.
 *
 * @package Coffee_Cafe_Corner
 */

// 1. Ensure backend DB class is loaded
if ( ! class_exists( 'Coffee_Cafe_Corner_Wholesale_DB' ) ) {
	require_once get_template_directory() . '/inc/class-wholesale-db.php';
}

// 2. Fetch Wholesale Data from Database
$wholesale = Coffee_Cafe_Corner_Wholesale_DB::get_wholesale_data();

$hero_title     = $wholesale['hero_title'];
$intro_heading  = $wholesale['intro_heading'];
$intro_lead     = $wholesale['intro_lead'];
$paragraphs     = $wholesale['paragraphs'];
$video_poster   = $wholesale['video_poster'];
$video_id       = $wholesale['video_id'];
$video_subtitle = $wholesale['video_subtitle'];
$typeform_id    = $wholesale['typeform_id'];
$form_mode            = $wholesale['form_mode'];
$form_title           = $wholesale['form_title'];
$form_subtitle        = $wholesale['form_subtitle'];
$form_button_text     = $wholesale['form_button_text'];
$form_time_estimate   = $wholesale['form_time_estimate'];
$form_submit_label    = $wholesale['form_submit_label'];
$form_success_message = $wholesale['form_success_message'];
?>
<div class="wholesale-page-wrapper">
	<!-- Hero Section: Wholesale Coffee Roasting -->
	<section class="quills-wholesale-hero-section">
		<h2 class="quills-wholesale-hero-title"><?php echo esc_html( $hero_title ); ?></h2>
	</section>

	<!-- Main Content Section: Video & Intro Text (quills-coffee-fest) -->
	<section class="quills-wholesale-content-section">
		<script async src="https://fast.wistia.com/player.js"></script>
		<script async src="https://fast.wistia.com/embed/<?php echo esc_attr( $video_id ); ?>.js" type="module"></script>
		
		<div class="quills-coffee-fest">
			<!-- Left Column: Wistia Video Player -->
			<div class="quills-coffee-fest__video">
				<wistia-player aspect="1.7777777777777777" media-id="<?php echo esc_attr( $video_id ); ?>"></wistia-player>
			</div>

			<!-- Right Column: Michael's Introduction & Copy -->
			<div class="quills-coffee-fest__text">
				<h2><?php echo esc_html( $intro_heading ); ?></h2>
				<p><strong><?php echo esc_html( $intro_lead ); ?></strong></p>
				<?php foreach ( $paragraphs as $p ) : ?>
					<p><?php echo esc_html( $p ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Sample Request / Questionnaire Section -->
	<section class="quills-wholesale-typeform-section" id="wholesale-sample-section">
		<?php if ( 'typeform' === $form_mode ) : ?>
			<div data-tf-live="<?php echo esc_attr( $typeform_id ); ?>" id="wholesale-typeform-widget"></div>
			<script src="//embed.typeform.com/next/embed.js"></script>
		<?php else : ?>
			<div class="quills-direct-sample-card" id="quills-direct-sample-card">
				<!-- Cover View (Matching Screenshot 100%) -->
				<div class="quills-sample-cover" id="quills-sample-cover">
					<h3 class="quills-sample-title"><?php echo esc_html( $form_title ); ?></h3>
					<p class="quills-sample-subtitle"><?php echo esc_html( $form_subtitle ); ?></p>
					<button type="button" class="quills-sample-start-btn" id="quills-sample-start-btn">
						<?php echo esc_html( $form_button_text ); ?>
					</button>
					<?php if ( ! empty( $form_time_estimate ) ) : ?>
						<div class="quills-sample-time-note">
							<svg class="quills-sample-clock-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<circle cx="12" cy="12" r="10"></circle>
								<polyline points="12 6 12 12 16 14"></polyline>
							</svg>
							<span><?php echo esc_html( $form_time_estimate ); ?></span>
						</div>
					<?php endif; ?>
				</div>

				<!-- Information Input Form (Revealed on click "Get started") -->
				<div class="quills-sample-form-wrap" id="quills-sample-form-wrap" style="display: none;">
					<form class="quills-sample-form" id="wholesale-inquiry-form" method="post" action="">
						<?php wp_nonce_field( 'wholesale_nonce', 'wholesale_nonce_field' ); ?>
						<div class="quills-sample-form-header">
							<h3 class="quills-sample-form-title"><?php echo esc_html( $form_title ); ?></h3>
							<p class="quills-sample-form-subtitle"><?php echo esc_html( $form_subtitle ); ?></p>
						</div>

						<div class="quills-sample-grid">
							<div class="quills-form-group">
								<label for="wholesale-name"><?php esc_html_e( 'Your Name *', 'coffee-cafe-corner' ); ?></label>
								<input type="text" id="wholesale-name" name="name" required placeholder="<?php esc_attr_e( 'e.g. Jane Doe', 'coffee-cafe-corner' ); ?>" />
							</div>
							<div class="quills-form-group">
								<label for="wholesale-email"><?php esc_html_e( 'Email Address *', 'coffee-cafe-corner' ); ?></label>
								<input type="email" id="wholesale-email" name="email" required placeholder="<?php esc_attr_e( 'e.g. jane@mycafe.com', 'coffee-cafe-corner' ); ?>" />
							</div>
							<div class="quills-form-group">
								<label for="wholesale-phone"><?php esc_html_e( 'Phone Number', 'coffee-cafe-corner' ); ?></label>
								<input type="tel" id="wholesale-phone" name="phone" placeholder="<?php esc_attr_e( 'e.g. (502) 555-0199', 'coffee-cafe-corner' ); ?>" />
							</div>
							<div class="quills-form-group">
								<label for="wholesale-cafe"><?php esc_html_e( 'Cafe / Business Name', 'coffee-cafe-corner' ); ?></label>
								<input type="text" id="wholesale-cafe" name="cafe_name" placeholder="<?php esc_attr_e( 'e.g. Sunnyside Cafe', 'coffee-cafe-corner' ); ?>" />
							</div>
							<div class="quills-form-group">
								<label for="wholesale-location"><?php esc_html_e( 'City & State', 'coffee-cafe-corner' ); ?></label>
								<input type="text" id="wholesale-location" name="location" placeholder="<?php esc_attr_e( 'e.g. Louisville, KY', 'coffee-cafe-corner' ); ?>" />
							</div>
							<div class="quills-form-group">
								<label for="wholesale-timeline"><?php esc_html_e( 'Target Launch Timeline', 'coffee-cafe-corner' ); ?></label>
								<select id="wholesale-timeline" name="timeline">
									<option value="Already open"><?php esc_html_e( 'Already open', 'coffee-cafe-corner' ); ?></option>
									<option value="1-3 months"><?php esc_html_e( 'Next 1 - 3 months', 'coffee-cafe-corner' ); ?></option>
									<option value="3-6 months"><?php esc_html_e( 'Next 3 - 6 months', 'coffee-cafe-corner' ); ?></option>
									<option value="6+ months"><?php esc_html_e( '6+ months out', 'coffee-cafe-corner' ); ?></option>
								</select>
							</div>
							<div class="quills-form-group full-width">
								<label for="wholesale-message"><?php esc_html_e( 'Anything specific you\'d like to discuss?', 'coffee-cafe-corner' ); ?></label>
								<textarea id="wholesale-message" name="message" rows="3" placeholder="<?php esc_attr_e( 'Tell us about your equipment, volume, or preferred flavor profile...', 'coffee-cafe-corner' ); ?>"></textarea>
							</div>
						</div>

						<div class="quills-form-actions">
							<button type="button" class="quills-form-back-btn" id="quills-sample-back-btn">
								<?php esc_html_e( 'Cancel', 'coffee-cafe-corner' ); ?>
							</button>
							<button type="submit" class="quills-sample-submit-btn" id="wholesale-submit-button">
								<?php echo esc_html( $form_submit_label ); ?>
							</button>
						</div>

						<div class="quills-form-feedback" id="wholesale-feedback" data-default-success="<?php echo esc_attr( $form_success_message ); ?>"></div>
					</form>
				</div>
			</div>
		<?php endif; ?>
	</section>
</div>
