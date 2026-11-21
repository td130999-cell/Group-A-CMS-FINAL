<?php
/**
 * Title: Hero Banner
 * Slug: coffee-cafe-corner/hero-banner
 */
$get_url = trailingslashit(get_template_directory_uri());
$coffee_cafe_corner_hero_image_1 = $get_url . 'assets/images/slide-bg.png';
$coffee_cafe_corner_hero_image_2 = $get_url . 'assets/images/slide-img.png';
?>

<!-- wp:cover {"url":"<?php echo esc_url($coffee_cafe_corner_hero_image_1); ?>","id":146,"dimRatio":0,"isUserOverlayColor":true,"minHeight":600,"sizeSlug":"large","className":"slide-bg","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-cover slide-bg" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;min-height:600px"><img class="wp-block-cover__image-background wp-image-146 size-large" alt="" src="<?php echo esc_url($coffee_cafe_corner_hero_image_1); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"className":"slider-box"} -->
<div class="wp-block-columns slider-box"><!-- wp:column {"width":"50%","className":"banner-contentt"} -->
<div class="wp-block-column banner-contentt" style="flex-basis:50%"><!-- wp:group {"className":"slide-content-box","layout":{"type":"constrained"}} -->
<div class="wp-block-group slide-content-box"><!-- wp:heading {"textAlign":"left","className":"banner-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|slidebg"}}},"typography":{"fontStyle":"normal","fontWeight":"400","textTransform":"capitalize","fontSize":"70px","letterSpacing":"5px"}},"textColor":"slidebg","fontFamily":"cookie"} -->
<h2 class="wp-block-heading has-text-align-left banner-heading has-slidebg-color has-text-color has-link-color has-cookie-font-family" style="font-size:70px;font-style:normal;font-weight:400;letter-spacing:5px;text-transform:capitalize"><?php esc_html_e('The Perfect', 'coffee-cafe-corner'); ?><br><?php esc_html_e('Blend of', 'coffee-cafe-corner'); ?><br><?php esc_html_e('Aroma', 'coffee-cafe-corner'); ?> &amp; <?php esc_html_e('Taste', 'coffee-cafe-corner'); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"left","className":"banner-para","style":{"elements":{"link":{"color":{"text":"var:preset|color|slidebg"}}},"spacing":{"margin":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}}},"textColor":"slidebg","fontFamily":"lora"} -->
<p class="has-text-align-left banner-para has-slidebg-color has-text-color has-link-color has-lora-font-family" style="margin-top:var(--wp--preset--spacing--x-small);margin-bottom:var(--wp--preset--spacing--x-small)"><?php esc_html_e('Experience the rich aroma of handpicked beans brewed to', 'coffee-cafe-corner'); ?><br> <?php esc_html_e('perfection. From classic espresso to creamy lattes, every cup', 'coffee-cafe-corner'); ?><br><?php esc_html_e('is crafted to energize your day.', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"Banner-btnss","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group Banner-btnss"><!-- wp:buttons {"className":"banner-btn","style":{"spacing":{"padding":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons banner-btn" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;padding-top:0;padding-bottom:0"><!-- wp:button {"backgroundColor":"heading","textColor":"slidebg","style":{"spacing":{"padding":{"top":"6px","bottom":"6px"}},"elements":{"link":{"color":{"text":"var:preset|color|slidebg"}}},"border":{"radius":{"topLeft":"6px","topRight":"6px","bottomLeft":"6px","bottomRight":"6px"}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontFamily":"lora"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-slidebg-color has-heading-background-color has-text-color has-background has-link-color has-lora-font-family wp-element-button" style="border-top-left-radius:6px;border-top-right-radius:6px;border-bottom-left-radius:6px;border-bottom-right-radius:6px;padding-top:6px;padding-bottom:6px;font-style:normal;font-weight:400"><?php esc_html_e('Explore Menu', 'coffee-cafe-corner'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:buttons {"className":"banner-btn 2","style":{"spacing":{"padding":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons banner-btn 2" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;padding-top:0;padding-bottom:0"><!-- wp:button {"backgroundColor":"transparent","textColor":"heading","style":{"spacing":{"padding":{"top":"6px","bottom":"6px"}},"border":{"radius":{"topLeft":"6px","topRight":"6px","bottomLeft":"6px","bottomRight":"6px"},"width":"1px"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontFamily":"lora"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-heading-color has-transparent-background-color has-text-color has-background has-link-color has-lora-font-family wp-element-button" style="border-width:1px;border-top-left-radius:6px;border-top-right-radius:6px;border-bottom-left-radius:6px;border-bottom-right-radius:6px;padding-top:6px;padding-bottom:6px;font-style:normal;font-weight:400"><?php esc_html_e('Learn More About Us', 'coffee-cafe-corner'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"banner-position"} -->
<div class="wp-block-column is-vertically-aligned-center banner-position" style="flex-basis:50%"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:image {"id":156,"sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url($coffee_cafe_corner_hero_image_2); ?>" alt="" class="wp-image-156"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->