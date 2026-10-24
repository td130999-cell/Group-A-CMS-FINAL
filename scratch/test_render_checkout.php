<?php
require_once __DIR__ . '/../wp-load.php';

// Add item to cart first so checkout does not 302 redirect to cart
WC()->frontend_includes();
if (WC()->cart) {
    WC()->cart->empty_cart();
    WC()->cart->add_to_cart(45, 1);
}

$post = get_post(9);
echo "Post ID: " . $post->ID . "\n";
echo "Post Title: " . $post->post_title . "\n";
echo "Post Name: " . $post->post_name . "\n";
echo "Post Content (first 200 chars):\n" . substr($post->post_content, 0, 200) . "\n\n";

$rendered = apply_filters('the_content', $post->post_content);
echo "Rendered Length: " . strlen($rendered) . "\n";
echo "Rendered Content:\n" . $rendered . "\n";
