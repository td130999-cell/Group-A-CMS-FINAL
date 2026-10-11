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

	<!-- Typeform / Questionnaire Section (Embed from Quills Coffee) -->
	<section class="quills-wholesale-typeform-section">
		<div data-tf-live="<?php echo esc_attr( $typeform_id ); ?>" id="wholesale-typeform-widget"></div>
		<script src="//embed.typeform.com/next/embed.js"></script>
	</section>
</div>
