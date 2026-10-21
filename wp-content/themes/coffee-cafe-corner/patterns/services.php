<?php
/**
 * Title: Services
 * Slug: coffee-cafe-corner/services
 */

$get_url = trailingslashit(get_template_directory_uri());
$coffee_cafe_corner_product_1 = $get_url . 'assets/images/product-static.png';
$coffee_cafe_corner_product_2 = $get_url . 'assets/images/product_1.jpg';
$coffee_cafe_corner_product_3 = $get_url . 'assets/images/product_2.jpg';
$coffee_cafe_corner_product_4 = $get_url . 'assets/images/product_3.jpg';


$coffee_cafe_corner_pluginsList = get_option( 'active_plugins' );
$coffee_cafe_corner_plugin = 'woocommerce/woocommerce.php';
$coffee_cafe_corner_results = in_array( $coffee_cafe_corner_plugin , $coffee_cafe_corner_pluginsList);
if ( $coffee_cafe_corner_results )  {
?>


<!-- wp:group {"className":"service-section","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large","left":"0","right":"0"}}},"backgroundColor":"background","layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group service-section has-background-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-large);padding-right:0;padding-bottom:var(--wp--preset--spacing--x-large);padding-left:0"><!-- wp:heading {"textAlign":"center","level":3,"className":"product-main-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"fontStyle":"normal","fontWeight":"400","fontSize":"42px"}},"textColor":"heading","fontFamily":"cookie"} -->
<h3 class="wp-block-heading has-text-align-center product-main-heading has-heading-color has-text-color has-link-color has-cookie-font-family" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:0;padding-bottom:10px;padding-left:0;font-size:42px;font-style:normal;font-weight:400"><?php esc_html_e('Our Popular Brews', 'coffee-cafe-corner'); ?></h3>
<!-- /wp:heading -->

<!-- wp:columns {"verticalAlignment":"center","className":"product-box"} -->
<div class="wp-block-columns are-vertically-aligned-center product-box"><!-- wp:column {"verticalAlignment":"center","width":"50%","className":"product-box-1"} -->
<div class="wp-block-column is-vertically-aligned-center product-box-1" style="flex-basis:50%"><!-- wp:group {"className":"pro-single-img","layout":{"type":"constrained"}} -->
<div class="wp-block-group pro-single-img"><!-- wp:image {"id":41,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url($coffee_cafe_corner_product_1); ?>" alt="" class="wp-image-41"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"product-box-2"} -->
<div class="wp-block-column is-vertically-aligned-center product-box-2" style="flex-basis:50%"><!-- wp:query {"queryId":10,"query":{"perPage":3,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-small-posts","name":"Small image and title"}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:columns {"verticalAlignment":"center","className":"product-details"} -->
<div class="wp-block-columns are-vertically-aligned-center product-details"><!-- wp:column {"verticalAlignment":"center","width":"25%","className":"product-details-1"} -->
<div class="wp-block-column is-vertically-aligned-center product-details-1" style="flex-basis:25%"><!-- wp:group {"className":"popular-img","style":{"dimensions":{"minHeight":"140px"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"backgroundColor":"border","layout":{"type":"default"}} -->
<div class="wp-block-group popular-img has-border-background-color has-background" style="min-height:140px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"width":"","height":"140px"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"75%","className":"product-details-2"} -->
<div class="wp-block-column is-vertically-aligned-center product-details-2" style="flex-basis:75%"><!-- wp:columns {"className":"product-head-main"} -->
<div class="wp-block-columns product-head-main"><!-- wp:column {"width":"40%","className":"product-head-1"} -->
<div class="wp-block-column product-head-1" style="flex-basis:40%"><!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}},"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"lineHeight":"1"}},"textColor":"black"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"40%","className":"product-head-2","style":{"border":{"bottom":{"width":"1px"}}}} -->
<div class="wp-block-column is-vertically-aligned-bottom product-head-2" style="border-bottom-width:1px;flex-basis:40%"></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"20%","className":"product-head-3"} -->
<div class="wp-block-column is-vertically-aligned-bottom product-head-3" style="flex-basis:20%"><!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textColor":"clip","style":{"elements":{"link":{"color":{"text":"var:preset|color|clip"}}},"typography":{"fontSize":"20px"}}} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:post-excerpt {"moreText":"<?php esc_html_e('View More', 'coffee-cafe-corner'); ?>","excerptLength":15,"className":"product-para","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}},"color":{"text":"#1c130ccc"},"elements":{"link":{"color":{"text":"#1c130ccc"}}},"typography":{"fontSize":"15px"}}} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->



<?php } else { ?>



<!-- wp:group {"className":"service-section","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large","left":"0","right":"0"}}},"backgroundColor":"background","layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group service-section has-background-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-large);padding-right:0;padding-bottom:var(--wp--preset--spacing--x-large);padding-left:0"><!-- wp:heading {"textAlign":"center","level":3,"className":"product-main-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"fontStyle":"normal","fontWeight":"400","fontSize":"42px"}},"textColor":"heading","fontFamily":"cookie"} -->
<h3 class="wp-block-heading has-text-align-center product-main-heading has-heading-color has-text-color has-link-color has-cookie-font-family" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:0;padding-bottom:10px;padding-left:0;font-size:42px;font-style:normal;font-weight:400"><?php esc_html_e('Our Popular Brews', 'coffee-cafe-corner'); ?></h3>
<!-- /wp:heading -->

<!-- wp:columns {"verticalAlignment":"center","className":"product-box"} -->
<div class="wp-block-columns are-vertically-aligned-center product-box"><!-- wp:column {"verticalAlignment":"center","width":"50%","className":"product-box-1"} -->
<div class="wp-block-column is-vertically-aligned-center product-box-1" style="flex-basis:50%"><!-- wp:group {"className":"pro-single-img","layout":{"type":"constrained"}} -->
<div class="wp-block-group pro-single-img"><!-- wp:image {"id":41,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url($coffee_cafe_corner_product_1); ?>" alt="" class="wp-image-41"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"product-box-2"} -->
<div class="wp-block-column is-vertically-aligned-center product-box-2" style="flex-basis:50%"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"25%","className":"product-details-1"} -->
<div class="wp-block-column product-details-1" style="flex-basis:25%"><!-- wp:group {"className":"popular-img","style":{"dimensions":{"minHeight":"140px"},"spacing":{"padding":{"top":"0","bottom":"0"}}},"backgroundColor":"border","layout":{"type":"constrained"}} -->
<div class="wp-block-group popular-img has-border-background-color has-background" style="min-height:140px;padding-top:0;padding-bottom:0"><!-- wp:image {"id":132,"width":"auto","height":"140px","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url($coffee_cafe_corner_product_2); ?>" alt="" class="wp-image-132" style="width:auto;height:140px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"75%","className":"product-details-2"} -->
<div class="wp-block-column product-details-2" style="flex-basis:75%"><!-- wp:columns {"verticalAlignment":null,"className":"product-head-main"} -->
<div class="wp-block-columns product-head-main"><!-- wp:column {"width":"40%","className":"product-head-1"} -->
<div class="wp-block-column product-head-1" style="flex-basis:40%"><!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}}},"textColor":"black"} -->
<h3 class="wp-block-heading has-black-color has-text-color has-link-color"><?php esc_html_e('Espresso Shot', 'coffee-cafe-corner'); ?></h3>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%","className":"product-head-2","style":{"border":{"bottom":{"width":"1px"}}}} -->
<div class="wp-block-column product-head-2" style="border-bottom-width:1px;flex-basis:40%"></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"20%","className":"product-head-3"} -->
<div class="wp-block-column is-vertically-aligned-bottom product-head-3" style="flex-basis:20%"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|clip"}}},"typography":{"fontSize":"20px"}},"textColor":"clip"} -->
<p class="has-clip-color has-text-color has-link-color" style="font-size:20px"><?php esc_html_e('$42', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"product-para","style":{"color":{"text":"#1c130ccc"},"elements":{"link":{"color":{"text":"#1c130ccc"}}},"spacing":{"padding":{"top":"0"},"margin":{"top":"var:preset|spacing|x-small"}}}} -->
<p class="product-para has-text-color has-link-color" style="color:#1c130ccc;margin-top:var(--wp--preset--spacing--x-small);padding-top:0"><?php esc_html_e('Lorem ipsum dolor sit amet, tetur piscing elit. Suspendisse sm congue bibendum. Lorem ipsum', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"product-btn"} -->
<div class="wp-block-buttons product-btn"><!-- wp:button {"backgroundColor":"transparent","style":{"color":{"text":"#663a1e"},"elements":{"link":{"color":{"text":"#663a1e"}}},"spacing":{"padding":{"left":"0","right":"0","top":"0","bottom":"0"}},"typography":{"textTransform":"uppercase"}},"fontFamily":"lora"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-transparent-background-color has-text-color has-background has-link-color has-lora-font-family wp-element-button" style="color:#663a1e;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-transform:uppercase"><?php esc_html_e('View More', 'coffee-cafe-corner'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"25%","className":"product-details-1"} -->
<div class="wp-block-column product-details-1" style="flex-basis:25%"><!-- wp:group {"className":"popular-img","style":{"dimensions":{"minHeight":"140px"},"spacing":{"padding":{"top":"0","bottom":"0"}}},"backgroundColor":"border","layout":{"type":"constrained"}} -->
<div class="wp-block-group popular-img has-border-background-color has-background" style="min-height:140px;padding-top:0;padding-bottom:0"><!-- wp:image {"id":134,"width":"auto","height":"140px","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url($coffee_cafe_corner_product_3); ?>" alt="" class="wp-image-134" style="width:auto;height:140px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"75%","className":"product-details-2"} -->
<div class="wp-block-column product-details-2" style="flex-basis:75%"><!-- wp:columns {"verticalAlignment":null,"className":"product-head-main"} -->
<div class="wp-block-columns product-head-main"><!-- wp:column {"width":"40%","className":"product-head-1"} -->
<div class="wp-block-column product-head-1" style="flex-basis:40%"><!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}}},"textColor":"black"} -->
<h3 class="wp-block-heading has-black-color has-text-color has-link-color"><?php esc_html_e('Cappuccino', 'coffee-cafe-corner'); ?></h3>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%","className":"product-head-2","style":{"border":{"bottom":{"width":"1px"}}}} -->
<div class="wp-block-column product-head-2" style="border-bottom-width:1px;flex-basis:40%"></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"20%","className":"product-head-3"} -->
<div class="wp-block-column is-vertically-aligned-bottom product-head-3" style="flex-basis:20%"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|clip"}}},"typography":{"fontSize":"20px"}},"textColor":"clip"} -->
<p class="has-clip-color has-text-color has-link-color" style="font-size:20px"><?php esc_html_e('$42', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"product-para","style":{"color":{"text":"#1c130ccc"},"elements":{"link":{"color":{"text":"#1c130ccc"}}},"spacing":{"padding":{"top":"0"},"margin":{"top":"var:preset|spacing|x-small"}}}} -->
<p class="product-para has-text-color has-link-color" style="color:#1c130ccc;margin-top:var(--wp--preset--spacing--x-small);padding-top:0"><?php esc_html_e('Lorem ipsum dolor sit amet, tetur piscing elit. Suspendisse sm congue bibendum. Lorem ipsum', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"product-btn"} -->
<div class="wp-block-buttons product-btn"><!-- wp:button {"backgroundColor":"transparent","style":{"color":{"text":"#663a1e"},"elements":{"link":{"color":{"text":"#663a1e"}}},"spacing":{"padding":{"left":"0","right":"0","top":"0","bottom":"0"}},"typography":{"textTransform":"uppercase"}},"fontFamily":"lora"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-transparent-background-color has-text-color has-background has-link-color has-lora-font-family wp-element-button" style="color:#663a1e;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-transform:uppercase"><?php esc_html_e('View More', 'coffee-cafe-corner'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"25%","className":"product-details-1"} -->
<div class="wp-block-column product-details-1" style="flex-basis:25%"><!-- wp:group {"className":"popular-img","style":{"dimensions":{"minHeight":"140px"},"spacing":{"padding":{"top":"0","bottom":"0"}}},"backgroundColor":"border","layout":{"type":"constrained"}} -->
<div class="wp-block-group popular-img has-border-background-color has-background" style="min-height:140px;padding-top:0;padding-bottom:0"><!-- wp:image {"id":135,"width":"auto","height":"140px","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url($coffee_cafe_corner_product_4); ?>" alt="" class="wp-image-135" style="width:auto;height:140px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"75%","className":"product-details-2"} -->
<div class="wp-block-column product-details-2" style="flex-basis:75%"><!-- wp:columns {"verticalAlignment":null,"className":"product-head-main"} -->
<div class="wp-block-columns product-head-main"><!-- wp:column {"width":"40%","className":"product-head-1"} -->
<div class="wp-block-column product-head-1" style="flex-basis:40%"><!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}}},"textColor":"black"} -->
<h3 class="wp-block-heading has-black-color has-text-color has-link-color"><?php esc_html_e('Caramel Latte', 'coffee-cafe-corner'); ?></h3>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%","className":"product-head-2","style":{"border":{"bottom":{"width":"1px"}}}} -->
<div class="wp-block-column product-head-2" style="border-bottom-width:1px;flex-basis:40%"></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"20%","className":"product-head-3"} -->
<div class="wp-block-column is-vertically-aligned-bottom product-head-3" style="flex-basis:20%"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|clip"}}},"typography":{"fontSize":"20px"}},"textColor":"clip"} -->
<p class="has-clip-color has-text-color has-link-color" style="font-size:20px"><?php esc_html_e('$42', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"product-para","style":{"color":{"text":"#1c130ccc"},"elements":{"link":{"color":{"text":"#1c130ccc"}}},"spacing":{"padding":{"top":"0"},"margin":{"top":"var:preset|spacing|x-small"}}}} -->
<p class="product-para has-text-color has-link-color" style="color:#1c130ccc;margin-top:var(--wp--preset--spacing--x-small);padding-top:0"><?php esc_html_e('Lorem ipsum dolor sit amet, tetur piscing elit. Suspendisse sm congue bibendum. Lorem ipsum', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"product-btn"} -->
<div class="wp-block-buttons product-btn"><!-- wp:button {"backgroundColor":"transparent","style":{"color":{"text":"#663a1e"},"elements":{"link":{"color":{"text":"#663a1e"}}},"spacing":{"padding":{"left":"0","right":"0","top":"0","bottom":"0"}},"typography":{"textTransform":"uppercase"}},"fontFamily":"lora"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-transparent-background-color has-text-color has-background has-link-color has-lora-font-family wp-element-button" style="color:#663a1e;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-transform:uppercase"><?php esc_html_e('View More', 'coffee-cafe-corner'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->


<?php } ?>