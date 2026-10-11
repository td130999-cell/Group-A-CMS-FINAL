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
?>
<div class="wholesale-page-wrapper">
	<!-- Hero Section: Wholesale Coffee Roasting -->
	<section class="wholesale-hero">
		<h1 class="wholesale-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
	</section>

	<!-- Main Content Section: Video & Intro Text -->
	<section class="wholesale-content-section">
		<div class="wholesale-grid">
			<!-- Left Column: Video Card -->
			<div class="wholesale-video-container" id="wholesale-video-card" data-video-id="<?php echo esc_attr( $video_id ); ?>">
				<img 
					src="<?php echo esc_url( $video_poster ); ?>" 
					alt="Michael Quills Wholesale Coffee" 
					class="wholesale-video-poster" 
					id="wholesale-poster-img"
				/>
				
				<!-- Sound / Audio Toggle Button -->
				<button class="wholesale-sound-btn" id="wholesale-sound-toggle" aria-label="Play video with sound">
					<svg viewBox="0 0 24 24" aria-hidden="true">
						<path d="M14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77zm-2.5 0L6.5 7.5H3v9h3.5l5 4.27V3.23zM16.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
					</svg>
				</button>

				<!-- Subtitle Overlay Pill -->
				<div class="wholesale-subtitle-pill" id="wholesale-subtitle">
					<?php echo esc_html( $video_subtitle ); ?>
				</div>

				<!-- Embedded Wistia Video Container -->
				<div class="wholesale-wistia-embed" id="wholesale-wistia-box"></div>
			</div>

			<!-- Right Column: Michael's Introduction & Copy -->
			<div class="wholesale-text-container">
				<h2 class="wholesale-heading"><?php echo esc_html( $intro_heading ); ?></h2>
				<p class="wholesale-lead-bold"><?php echo esc_html( $intro_lead ); ?></p>
				<?php foreach ( $paragraphs as $p ) : ?>
					<p class="wholesale-paragraph"><?php echo esc_html( $p ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Typeform / Questionnaire Section (Embed from Quills Coffee) -->
	<section class="wholesale-form-section">
		<div class="wholesale-form-container">
			<!-- Live Typeform Embed from Quills Coffee -->
			<div data-tf-live="<?php echo esc_attr( $typeform_id ); ?>" id="wholesale-typeform-widget"></div>
		</div>
	</section>
</div>
