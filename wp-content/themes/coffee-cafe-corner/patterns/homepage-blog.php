<?php
/**
 * Title: Homepage Blog
 * Slug: coffee-cafe-corner/homepage-blog
 */
?>

<!-- wp:group {"align":"full","className":"our-blog","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|small","right":"0","left":"var:preset|spacing|medium"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"background","layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group alignfull our-blog has-background-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xx-large"}}},"layout":{"type":"constrained","contentSize":""}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--xx-large)"><!-- wp:heading {"textAlign":"center","level":3,"className":"product-main-heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|clip"}}},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontStyle":"normal","fontWeight":"400","fontSize":"40px"}},"textColor":"clip","fontFamily":"cookie"} -->
<h3 class="wp-block-heading has-text-align-center product-main-heading has-clip-color has-text-color has-link-color has-cookie-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:10px;padding-right:0;padding-bottom:10px;padding-left:0;font-size:40px;font-style:normal;font-weight:400"><?php esc_html_e('Our Latest Blogs', 'coffee-cafe-corner'); ?></h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide","layout":{"type":"constrained","contentSize":"100%","wideSize":""}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"className":"simple-blog","fontFamily":"lora","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"coffee-cafe-corner-portfolio-card","style":{"spacing":{"blockGap":"0","margin":{"bottom":"var:preset|spacing|large"}},"border":{"radius":"16px","width":"1px","color":"var:preset|color|border"}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group coffee-cafe-corner-portfolio-card has-border-color has-background-background-color has-background" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:16px;margin-bottom:var(--wp--preset--spacing--large)"><!-- wp:group {"className":"blog-default-image","style":{"spacing":{"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}}},"backgroundColor":"border","layout":{"type":"constrained"}} -->
<div class="wp-block-group blog-default-image has-border-background-color has-background" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"style":{"border":{"radius":{"topLeft":"16px","topRight":"16px"}},"spacing":{"margin":{"top":"0"}}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","right":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small","margin":{"bottom":"var:preset|spacing|small"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--small)"><!-- wp:post-date {"format":"M j, Y","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"typography":{"fontWeight":"500","fontStyle":"normal"}},"textColor":"primary","fontSize":"small","fontFamily":"lora"} /-->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"500"}},"textColor":"primary","fontSize":"small"} -->
<p class="has-primary-color has-text-color has-small-font-size" style="font-weight:500">.</p>
<!-- /wp:paragraph -->

<!-- wp:post-author {"showAvatar":false,"showBio":false,"style":{"typography":{"fontWeight":"500","fontStyle":"normal"}},"textColor":"primary","fontSize":"small","fontFamily":"lora"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|small"}},"typography":{"fontWeight":"700","lineHeight":"1.3","fontStyle":"normal"},"elements":{"link":{"color":{"text":"var:preset|color|heading"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"color":{"text":"#151414"}},"fontSize":"x-large","fontFamily":"lora"} /-->

<!-- wp:post-excerpt {"excerptLength":20,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|small"}},"color":{"text":"#555555"}},"fontSize":"small","fontFamily":"lora"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","style":{"spacing":{"padding":{"top":"4px","right":"12px","bottom":"4px","left":"12px"}},"border":{"radius":"20px"},"typography":{"fontWeight":"500","fontStyle":"normal"}},"backgroundColor":"surface","textColor":"body","fontSize":"small","fontFamily":"lora"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->