<?php
/**
 * Title: 404
 * Slug: coffee-cafe-corner/404
 */
?>

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxx-large","bottom":"var:preset|spacing|xxx-large"},"blockGap":"var:preset|spacing|large"}},"layout":{"type":"constrained","contentSize":"600px"}} -->
    <div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--xxx-large);padding-bottom:var(--wp--preset--spacing--xxx-large)">
        <!-- wp:heading {"textAlign":"center","level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|medium"}},"typography":{"fontWeight":"800","fontSize":"6rem","lineHeight":"1"}},"textColor":"primary"} -->
        <h1 class="wp-block-heading has-text-align-center has-primary-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--medium);font-size:6rem;font-weight:800;line-height:1"><?php esc_html_e('404', 'coffee-cafe-corner'); ?></h1>
        <!-- /wp:heading -->

        <!-- wp:heading {"textAlign":"center","level":2,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|medium"}},"typography":{"fontWeight":"800"}},"textColor":"heading","fontSize":"xxxx-large"} -->
        <h2 class="wp-block-heading has-text-align-center has-heading-color has-text-color has-xxxx-large-font-size" style="margin-bottom:var(--wp--preset--spacing--medium);font-weight:800"><?php esc_html_e('Page Not Found', 'coffee-cafe-corner'); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|large"}}},"textColor":"body","fontSize":"x-large"} -->
        <p class="has-text-align-center has-body-color has-text-color has-x-large-font-size" style="margin-bottom:var(--wp--preset--spacing--large)"><?php esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'coffee-cafe-corner'); ?></p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons">
            <!-- wp:button {"backgroundColor":"primary","textColor":"background"} -->
            <div class="wp-block-button"><a class="wp-block-button__link has-background-color has-primary-background-color has-text-color has-background wp-element-button" href="/"><?php esc_html_e('Back to Homepage', 'coffee-cafe-corner'); ?></a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

        <!-- wp:search {"label":"Search","showLabel":false,"width":75,"widthUnit":"%","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true,"align":"center"} /-->
    </div>
    <!-- /wp:group -->