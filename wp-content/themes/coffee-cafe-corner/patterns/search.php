<?php
/**
 * Title: Search
 * Slug: coffee-cafe-corner/search
 */
?>

<!-- wp:pattern {"slug":"coffee-cafe-corner/search-result"} /-->


<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|xxx-large","bottom":"var:preset|spacing|xxx-large"},"blockGap":"var:preset|spacing|large"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--xxx-large);padding-bottom:var(--wp--preset--spacing--xxx-large)"><!-- wp:query-title {"type":"search","showPrefix":false,"align":"wide","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|medium"}},"typography":{"fontWeight":"800"}},"textColor":"heading","fontSize":"xxxx-large"} /-->

<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|xx-large"}}},"layout":{"type":"constrained","contentSize":"600px"}} -->
<div class="wp-block-group alignwide" style="margin-bottom:var(--wp--preset--spacing--xx-large)"><!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|large"}}},"textColor":"body","fontSize":"large"} -->
<p class="has-text-align-center has-body-color has-text-color has-large-font-size" style="margin-bottom:var(--wp--preset--spacing--large)"><?php esc_html_e('Try searching for something else or refine your search terms below.', 'coffee-cafe-corner'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search articles, insights, and more...","width":100,"widthUnit":"%","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true,"align":"center","style":{"border":{"radius":"12px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"coffee-cafe-corner-portfolio-card","style":{"spacing":{"blockGap":"0","margin":{"bottom":"var:preset|spacing|large"}},"border":{"radius":"16px","width":"1px","color":"var:preset|color|border"}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group coffee-cafe-corner-portfolio-card has-border-color has-background-background-color has-background" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:16px;margin-bottom:var(--wp--preset--spacing--large)"><!-- wp:post-featured-image {"isLink":true,"style":{"border":{"radius":{"topLeft":"16px","topRight":"16px"}},"spacing":{"margin":{"top":"0"}}}} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","right":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small","margin":{"bottom":"var:preset|spacing|small"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--small)"><!-- wp:post-date {"format":"M j, Y","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} /-->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size" style="font-weight:500">.</p>
<!-- /wp:paragraph -->

<!-- wp:post-author {"showAvatar":false,"showBio":false,"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|small"}},"typography":{"fontWeight":"700","lineHeight":"1.3"},"elements":{"link":{"color":{"text":"var:preset|color|heading"},":hover":{"color":{"text":"var:preset|color|primary"}}}}},"fontSize":"large"} /-->

<!-- wp:post-excerpt {"excerptLength":25,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|small"}}},"textColor":"body","fontSize":"small"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","style":{"spacing":{"padding":{"top":"4px","right":"12px","bottom":"4px","left":"12px"}},"border":{"radius":"20px"},"typography":{"fontWeight":"500"}},"backgroundColor":"surface","textColor":"body","fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"arrow","style":{"spacing":{"margin":{"top":"var:preset|spacing|xx-large"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->