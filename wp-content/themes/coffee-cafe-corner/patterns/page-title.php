<?php
/**
 * Title: Page Title
 * Slug: coffee-cafe-corner/page-title
 * Categories: coffee-cafe-corner, page-title
 */
$coffee_cafe_corner_get_url = trailingslashit(get_template_directory_uri());
$coffee_cafe_corner_header_banner = $coffee_cafe_corner_get_url . 'assets/images/header-banner.png';
?>

<!-- wp:cover {"url":"<?php echo esc_url($coffee_cafe_corner_header_banner); ?>","id":6,"dimRatio":0,"minHeight":400,"className":"inner-cover-img","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-cover inner-cover-img" style="margin-top:0;margin-bottom:0;min-height:400px"><img class="wp-block-cover__image-background wp-image-6" alt="" src="<?php echo esc_url($coffee_cafe_corner_header_banner); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:post-title {"textAlign":"center","className":"wow slideInDown","style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px","fontSize":"42px"}},"textColor":"white"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->