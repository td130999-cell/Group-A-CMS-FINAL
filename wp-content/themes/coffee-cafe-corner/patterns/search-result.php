<?php
/**
 * Title: Search Result
 * Slug: coffee-cafe-corner/search-result
 * Categories: coffee-cafe-corner, search-result
 */
$coffee_cafe_corner_get_url = trailingslashit(get_template_directory_uri());
$coffee_cafe_corner_header_banner = $coffee_cafe_corner_get_url . 'assets/images/header-banner.png';
?>

<!-- wp:cover {"url":"<?php echo esc_url($coffee_cafe_corner_header_banner); ?>","id":6,"dimRatio":0,"isUserOverlayColor":true,"minHeight":400,"align":"full","className":"inner-cover-img","layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-cover alignfull inner-cover-img" style="min-height:400px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-6" alt="" src="<?php echo esc_url($coffee_cafe_corner_header_banner); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:query-title {"type":"search","textAlign":"center","level":2,"className":"wow slideInDown","style":{"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}},"typography":{"letterSpacing":"1px","fontSize":"42px"}}} /--></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->