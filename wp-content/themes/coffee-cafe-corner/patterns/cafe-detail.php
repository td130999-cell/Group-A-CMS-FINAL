<?php
/**
 * Title: Cafe Detail Subpage
 * Slug: coffee-cafe-corner/cafe-detail
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee authentic Cafe Detail subpage (e.g. ?view=nulu), dynamically pulling from Database.
 */

// 1. Resolve Target Page ID from Database
$page_id = get_the_ID();
if ( ! $page_id ) {
    $visit_page = get_page_by_path( 'visit', OBJECT, 'page' );
    if ( $visit_page ) {
        $page_id = $visit_page->ID;
    }
}

// 2. Resolve requested cafe view
$view = isset( $_GET['view'] ) ? sanitize_key( $_GET['view'] ) : '';

// Normalise aliases
$aliases = array(
    'j-town'        => 'jtown',
    'the-firehouse' => 'nulu',
    'firehouse'     => 'nulu',
    'frankfort'     => 'frankfort-avenue',
);
if ( isset( $aliases[ $view ] ) ) {
    $view = $aliases[ $view ];
}

// 3. Base Assets Path
$theme_url = trailingslashit( get_template_directory_uri() );
$img_dir   = $theme_url . 'assets/images/visit/';

// 4. Fetch Cafe Details directly from Database (wp_options or wp_postmeta)
$all_cafe_details = get_option( 'quills_cafe_details' );
if ( empty( $all_cafe_details ) || ! is_array( $all_cafe_details ) ) {
    $all_cafe_details = get_post_meta( $page_id, '_quills_cafe_details', true );
}

if ( empty( $all_cafe_details ) || ! is_array( $all_cafe_details ) ) {
    $all_cafe_details = array();
}

$cafe = isset( $all_cafe_details[ $view ] ) ? $all_cafe_details[ $view ] : ( ! empty( $all_cafe_details ) ? reset( $all_cafe_details ) : array() );

if ( empty( $cafe ) ) {
    return;
}

// Image URLs
$main_img_url = filter_var( $cafe['image_main'], FILTER_VALIDATE_URL ) ? $cafe['image_main'] : $img_dir . $cafe['image_main'];
$g1_url       = filter_var( $cafe['gallery_1'], FILTER_VALIDATE_URL ) ? $cafe['gallery_1'] : $img_dir . $cafe['gallery_1'];
$g2_url       = filter_var( $cafe['gallery_2'], FILTER_VALIDATE_URL ) ? $cafe['gallery_2'] : $img_dir . $cafe['gallery_2'];
$g3_url       = filter_var( $cafe['gallery_3'], FILTER_VALIDATE_URL ) ? $cafe['gallery_3'] : $img_dir . $cafe['gallery_3'];
?>

<div class="quills-cafe-subpage-container">

    <!-- Cafe Title & Narrative Intro -->
    <header class="quills-subpage-header">
        <h1 class="quills-subpage-title"><?php echo esc_html( $cafe['title'] ); ?></h1>
        <div class="quills-subpage-desc">
            <p><?php echo esc_html( $cafe['desc'] ); ?></p>
        </div>
    </header>

    <!-- Main Location Section: Left Building Photo, Right Address Details -->
    <section class="quills-subpage-main-section">
        <div class="quills-subpage-main-grid">
            <div class="quills-subpage-main-image-wrap">
                <img src="<?php echo esc_url( $main_img_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] ); ?>" class="quills-subpage-main-img" loading="lazy" />
            </div>
            <div class="quills-subpage-details-col">
                <div class="quills-subpage-info-item">
                    <span class="quills-subpage-label">Address:</span>
                    <a href="<?php echo esc_url( $cafe['map_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="quills-subpage-link">
                        <?php echo esc_html( $cafe['address'] ); ?>
                    </a>
                </div>
                <div class="quills-subpage-info-item">
                    <span class="quills-subpage-label">Hours:</span>
                    <span class="quills-subpage-val"><?php echo esc_html( $cafe['hours'] ); ?></span>
                </div>
                <div class="quills-subpage-info-item">
                    <span class="quills-subpage-label">Phone:</span>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $cafe['phone'] ) ); ?>" class="quills-subpage-link">
                        <?php echo esc_html( $cafe['phone'] ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cafe Gallery: Left Large Photo, Right Stacked Photos -->
    <section class="quills-subpage-gallery-section">
        <div class="quills-subpage-gallery-grid">
            <div class="quills-subpage-gallery-left">
                <img src="<?php echo esc_url( $g1_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] . ' Interior' ); ?>" class="quills-subpage-gallery-img" loading="lazy" />
            </div>
            <div class="quills-subpage-gallery-right">
                <div class="quills-subpage-gallery-right-item">
                    <img src="<?php echo esc_url( $g2_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] . ' Photo 2' ); ?>" class="quills-subpage-gallery-img" loading="lazy" />
                </div>
                <div class="quills-subpage-gallery-right-item">
                    <img src="<?php echo esc_url( $g3_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] . ' Photo 3' ); ?>" class="quills-subpage-gallery-img" loading="lazy" />
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="quills-subpage-testimonial-section">
        <h2 class="quills-subpage-testimonial-heading">Testimonial</h2>
        <div class="quills-subpage-stars" aria-label="5 stars rating">
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
        </div>
        <blockquote class="quills-subpage-quote">
            <p>“<?php echo esc_html( $cafe['quote'] ); ?>”</p>
        </blockquote>
        <div class="quills-subpage-author">
            <?php echo esc_html( $cafe['quote_author'] ); ?>
        </div>
    </section>

</div>
