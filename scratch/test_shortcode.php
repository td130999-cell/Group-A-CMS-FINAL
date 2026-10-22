<?php
require_once __DIR__ . '/../wp-load.php';

WC()->frontend_includes();
WC()->session->init();
WC()->cart->empty_cart();
WC()->cart->add_to_cart(45, 1);

echo "Cart contents count: " . WC()->cart->get_cart_contents_count() . "\n";
echo "--- TESTING SHORTCODE [woocommerce_checkout] ---\n";
$html = do_shortcode('[woocommerce_checkout]');
echo "Length: " . strlen($html) . "\n";
echo "Contains <form: " . (strpos($html, '<form') !== false ? 'YES' : 'NO') . "\n";
echo "Contains payment_method: " . (strpos($html, 'payment_method') !== false ? 'YES' : 'NO') . "\n";
echo "Contains place_order: " . (strpos($html, 'place_order') !== false ? 'YES' : 'NO') . "\n";
echo "Snippet:\n" . substr($html, 0, 400) . "\n...\n";
