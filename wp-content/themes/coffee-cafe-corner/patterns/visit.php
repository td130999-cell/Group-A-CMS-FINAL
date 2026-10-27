<?php
/**
 * Title: Visit - Locations & Hours
 * Slug: coffee-cafe-corner/visit
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee authentic Locations & Hours page pattern, dynamically pulling content from WordPress database.
 */

// If a cafe detail view is requested via ?view=..., delegate to the cafe detail subpage
if ( ! empty( $_GET['view'] ) ) {
	$cafe_detail_pattern = get_template_directory() . '/patterns/cafe-detail.php';
	if ( file_exists( $cafe_detail_pattern ) ) {
		include $cafe_detail_pattern;
		return;
	}
}

// 1. Resolve Target Page ID from Database
$page_id = get_the_ID();
$valid_slugs = array( 'visit', 'our-cafes', 'locations', 'locations-hours' );

if ( ! $page_id || ! in_array( get_post_field( 'post_name', $page_id ), $valid_slugs, true ) ) {
    foreach ( $valid_slugs as $slug ) {
        $found_page = get_page_by_path( $slug, OBJECT, 'page' );
        if ( $found_page ) {
            $page_id = $found_page->ID;
            break;
        }
    }
}

// 2. Base Assets Path
$theme_url = trailingslashit( get_template_directory_uri() );
$img_dir   = $theme_url . 'assets/images/visit/';

// 3. Fetch Data Dynamically from WordPress Database (wp_options or wp_postmeta) with robust defaults
$hero_title = get_option( 'quills_visit_hero_title' );
if ( empty( $hero_title ) ) {
    $hero_title = get_post_meta( $page_id, '_visit_hero_title', true ) ?: 'Our Cafes';
}

$hero_img_file = get_option( 'quills_visit_hero_image' );
if ( empty( $hero_img_file ) ) {
    $hero_img_file = get_post_meta( $page_id, '_visit_hero_image', true ) ?: 'our-cafes-hero.jpg';
}
$hero_img_url  = filter_var( $hero_img_file, FILTER_VALIDATE_URL ) ? $hero_img_file : $img_dir . $hero_img_file;

$breadcrumb_label = get_option( 'quills_visit_breadcrumb' );
if ( empty( $breadcrumb_label ) ) {
    $breadcrumb_label = get_post_meta( $page_id, '_visit_breadcrumb', true ) ?: 'Locations & Hours';
}

$intro_text = get_option( 'quills_visit_intro_text' );
if ( empty( $intro_text ) ) {
    $intro_text = get_post_meta( $page_id, '_visit_intro_text', true );
}
if ( empty( $intro_text ) ) {
    $intro_text = "If you happen to be in our neck of the woods, we'd love to see you. This is where it all started after all. While our subscriptions bring our curated coffees to your kitchen, there's something special about serving you in person. Each of our cafes has a little charm of its own. Our in-house team designed each of them to be warm and welcoming in their own ways. We have six cafes in various Louisville neighborhoods, and one in downtown Indianapolis. You can read a bit about each and find our hours and directions below. Stop by for our seasonal menu of espresso drinks, single origin coffees, and baked goods. Fresh bags of our coffees and merch are always available on the shelves as well.";
}

$section_title = get_option( 'quills_visit_section_title' );
if ( empty( $section_title ) ) {
    $section_title = get_post_meta( $page_id, '_visit_section_title', true ) ?: 'LOCATIONS & HOURS';
}

$cafes = get_post_meta( $page_id, '_visit_cafes', true );

// Fallback from quills_cafe_details in database if _visit_cafes is not set
if ( empty( $cafes ) || ! is_array( $cafes ) ) {
    $all_cafe_details = get_option( 'quills_cafe_details' );
    if ( ! empty( $all_cafe_details ) && is_array( $all_cafe_details ) ) {
        $cafes = array();
        foreach ( $all_cafe_details as $c_id => $c_data ) {
            $cafes[] = array(
                'id'            => $c_id,
                'name'          => isset( $c_data['title'] ) ? $c_data['title'] : '',
                'image'         => isset( $c_data['image_main'] ) ? $c_data['image_main'] : '',
                'address'       => isset( $c_data['address'] ) ? $c_data['address'] : '',
                'map_url'       => isset( $c_data['map_url'] ) ? $c_data['map_url'] : '',
                'hours'         => isset( $c_data['hours'] ) ? $c_data['hours'] : '',
                'phone'         => isset( $c_data['phone'] ) ? $c_data['phone'] : '',
                'read_more_url' => home_url( '/visit/?view=' . $c_id ),
            );
        }
    }
}

// Split into Row 1 (3 cafes) and Row 2 (4 cafes)
$row_top_cafes    = array_slice( $cafes, 0, 3 );
$row_bottom_cafes = array_slice( $cafes, 3 );
?>

<div class="quills-visit-page-container">

    <!-- 1. Breadcrumbs -->
    <div class="quills-visit-breadcrumb-wrap">
        <nav class="quills-visit-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span class="quills-visit-bc-sep">/</span>
            <span class="quills-visit-bc-current"><?php echo esc_html( $breadcrumb_label ); ?></span>
        </nav>
    </div>

    <!-- 2. Hero Banner Section -->
    <section class="quills-visit-hero-section">
        <div class="quills-visit-hero-banner" style="background-image: url('<?php echo esc_url( $hero_img_url ); ?>');">
            <div class="quills-visit-hero-overlay"></div>
            <h1 class="quills-visit-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
        </div>
    </section>

    <!-- 3. Intro Text Section -->
    <section class="quills-visit-intro-section">
        <div class="quills-visit-intro-content">
            <p><?php echo nl2br( esc_html( $intro_text ) ); ?></p>
        </div>
    </section>

    <!-- 4. Section Heading: LOCATIONS & HOURS -->
    <section class="quills-visit-section-header">
        <h2 class="quills-visit-section-title"><?php echo esc_html( $section_title ); ?></h2>
    </section>

    <!-- 5. Cafes Grid (Row 1: 3 Cafes, Row 2: 4 Cafes) -->
    <section class="quills-cafes-wrapper">

        <?php if ( ! empty( $row_top_cafes ) ) : ?>
            <div class="quills-cafes-row-top">
                <?php foreach ( $row_top_cafes as $cafe ) :
                    $img_src = filter_var( $cafe['image'], FILTER_VALIDATE_URL ) ? $cafe['image'] : $img_dir . $cafe['image'];
                    $map_link = ! empty( $cafe['map_url'] ) ? $cafe['map_url'] : 'https://www.google.com/maps/search/' . rawurlencode( $cafe['address'] );
                    $raw_card_link = ! empty( $cafe['read_more_url'] ) ? $cafe['read_more_url'] : $map_link;
                    $card_link = str_replace( '/about-us?view=', '/visit/?view=', $raw_card_link );
                ?>
                    <article class="quills-cafe-card">
                        <a href="<?php echo esc_url( $card_link ); ?>" class="quills-cafe-image-link" aria-label="<?php echo esc_attr( $cafe['name'] ); ?>">
                            <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $cafe['name'] ); ?>" class="quills-cafe-image" loading="lazy" />
                        </a>
                        <div class="quills-cafe-body">
                            <h3 class="quills-cafe-title"><?php echo esc_html( $cafe['name'] ); ?></h3>
                            <div class="quills-cafe-details">
                                <div class="quills-cafe-info-row">
                                    <span class="quills-cafe-label">Address:</span>
                                    <a href="<?php echo esc_url( $map_link ); ?>" target="_blank" rel="noopener noreferrer" class="quills-cafe-address-link">
                                        <?php echo esc_html( $cafe['address'] ); ?>
                                    </a>
                                </div>
                                <div class="quills-cafe-info-row">
                                    <span class="quills-cafe-label">Hours:</span>
                                    <span><?php echo esc_html( $cafe['hours'] ); ?></span>
                                </div>
                                <div class="quills-cafe-info-row">
                                    <span class="quills-cafe-label">Phone:</span>
                                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $cafe['phone'] ) ); ?>" class="quills-cafe-phone-link">
                                        <?php echo esc_html( $cafe['phone'] ); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="quills-cafe-btn-wrap">
                                <a href="<?php echo esc_url( $card_link ); ?>" class="quills-cafe-btn">
                                    READ MORE
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $row_bottom_cafes ) ) : ?>
            <div class="quills-cafes-row-bottom">
                <?php foreach ( $row_bottom_cafes as $cafe ) :
                    $img_src = filter_var( $cafe['image'], FILTER_VALIDATE_URL ) ? $cafe['image'] : $img_dir . $cafe['image'];
                    $map_link = ! empty( $cafe['map_url'] ) ? $cafe['map_url'] : 'https://www.google.com/maps/search/' . rawurlencode( $cafe['address'] );
                    $raw_card_link = ! empty( $cafe['read_more_url'] ) ? $cafe['read_more_url'] : $map_link;
                    $card_link = str_replace( '/about-us?view=', '/visit/?view=', $raw_card_link );
                ?>
                    <article class="quills-cafe-card">
                        <a href="<?php echo esc_url( $card_link ); ?>" class="quills-cafe-image-link" aria-label="<?php echo esc_attr( $cafe['name'] ); ?>">
                            <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $cafe['name'] ); ?>" class="quills-cafe-image" loading="lazy" />
                        </a>
                        <div class="quills-cafe-body">
                            <h3 class="quills-cafe-title"><?php echo esc_html( $cafe['name'] ); ?></h3>
                            <div class="quills-cafe-details">
                                <div class="quills-cafe-info-row">
                                    <span class="quills-cafe-label">Address:</span>
                                    <a href="<?php echo esc_url( $map_link ); ?>" target="_blank" rel="noopener noreferrer" class="quills-cafe-address-link">
                                        <?php echo esc_html( $cafe['address'] ); ?>
                                    </a>
                                </div>
                                <div class="quills-cafe-info-row">
                                    <span class="quills-cafe-label">Hours:</span>
                                    <span><?php echo esc_html( $cafe['hours'] ); ?></span>
                                </div>
                                <div class="quills-cafe-info-row">
                                    <span class="quills-cafe-label">Phone:</span>
                                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $cafe['phone'] ) ); ?>" class="quills-cafe-phone-link">
                                        <?php echo esc_html( $cafe['phone'] ); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="quills-cafe-btn-wrap">
                                <a href="<?php echo esc_url( $card_link ); ?>" class="quills-cafe-btn">
                                    READ MORE
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </section>

</div>
