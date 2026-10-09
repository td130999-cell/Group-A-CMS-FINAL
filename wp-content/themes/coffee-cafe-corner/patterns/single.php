<?php
/**
 * Title: Single
 * Slug: coffee-cafe-corner/single
 */
?>

<!-- wp:pattern {"slug":"coffee-cafe-corner/page-title"} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|xxx-large","bottom":"var:preset|spacing|xxx-large"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xxx-large);padding-bottom:var(--wp--preset--spacing--xxx-large)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:post-featured-image {"width":"100%","height":"400px","style":{"border":{"radius":"16px"},"spacing":{"margin":{"bottom":"var:preset|spacing|large"}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small","margin":{"bottom":"var:preset|spacing|medium"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--medium)"><!-- wp:post-terms {"term":"category","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.5px"}},"textColor":"primary","fontSize":"small"} /-->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size" style="font-weight:500">.</p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"format":"M j, Y","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} /-->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size" style="font-weight:500">.</p>
<!-- /wp:paragraph -->

<!-- wp:post-author {"showAvatar":false,"showBio":false,"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"textAlign":"left","level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|large"}},"typography":{"fontWeight":"800","lineHeight":"1.2"}},"textColor":"heading","fontSize":"huge"} /-->

<!-- wp:post-content {"style":{"typography":{"lineHeight":"1.8"}},"fontSize":"medium"} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large"},"margin":{"top":"var:preset|spacing|large"}},"border":{"top":{"color":"var:preset|color|border","width":"1px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--border);border-top-width:1px;margin-top:var(--wp--preset--spacing--large);padding-top:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large)"><!-- wp:post-terms {"term":"post_tag","prefix":"<?php esc_html_e('Tags: ', 'coffee-cafe-corner'); ?>","style":{"typography":{"fontWeight":"500"}},"textColor":"body","fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"32px"} -->
<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:comments -->
<div class="wp-block-comments"><!-- wp:comments-title {"style":{"spacing":{"margin":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|large"}},"typography":{"fontWeight":"800"}},"textColor":"heading","fontSize":"xxxx-large"} /-->

<!-- wp:comment-template -->
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|small","left":"var:preset|spacing|medium"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"40px"} -->
<div class="wp-block-column" style="flex-basis:40px"><!-- wp:avatar {"size":40,"style":{"border":{"radius":"50px"}}} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:comment-author-name {"style":{"typography":{"fontWeight":"700"}},"textColor":"heading","fontSize":"medium"} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"flex"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:comment-date {"style":{"typography":{"fontWeight":"500"}},"textColor":"muted","fontSize":"small"} /-->

<!-- wp:comment-edit-link {"style":{"typography":{"fontWeight":"500"}},"fontSize":"small","textColor":"primary"} /--></div>
<!-- /wp:group -->

<!-- wp:comment-content {"style":{"spacing":{"margin":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small"}},"typography":{"lineHeight":"1.6"}},"textColor":"body","fontSize":"medium"} /-->

<!-- wp:comment-reply-link {"style":{"typography":{"fontWeight":"600"}},"fontSize":"small","textColor":"primary"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:comment-template -->

<!-- wp:comments-pagination -->
<!-- wp:comments-pagination-previous /-->

<!-- wp:comments-pagination-numbers /-->

<!-- wp:comments-pagination-next /-->
<!-- /wp:comments-pagination -->

<!-- wp:post-comments-form {"style":{"spacing":{"margin":{"top":"var:preset|spacing|xx-large"}}}} /--></div>
<!-- /wp:comments --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%","className":"custom-sidebar"} -->
<div class="wp-block-column custom-sidebar" style="flex-basis:30%">
	<!-- wp:pattern {"slug":"coffee-cafe-corner/sidebar"} /-->
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->