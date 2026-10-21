<?php
/**
 * Title: Archive Title
 * Slug: coffee-cafe-corner/archive-title
 * Categories: coffee-cafe-corner, archive-title
 */
$coffee_cafe_corner_get_url = trailingslashit(get_template_directory_uri());
$coffee_cafe_corner_header_banner = $coffee_cafe_corner_get_url . 'assets/images/header-banner.png';
?>

<!-- wp:cover {"url":"<?php echo esc_url($coffee_cafe_corner_header_banner); ?>","id":6,"dimRatio":0,"minHeight":400,"className":"inner-cover-img","layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-cover inner-cover-img" style="min-height:400px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-6" alt="" src="<?php echo esc_url($coffee_cafe_corner_header_banner); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:query-title {"type":"archive","textAlign":"center"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->