<?php
require_once __DIR__ . '/../wp-load.php';

$order_id = 118;
$order = wc_get_order($order_id);

if ($order) {
    echo "Found Order #$order_id (" . $order->get_total() . "). Deleting...\n";
    $order->delete(true); // Permanent deletion with all items and meta
    echo "Order #$order_id deleted successfully via WooCommerce API.\n";
} else {
    echo "Order #$order_id not found via wc_get_order. Checking database directly...\n";
}

// Ensure database tables are completely clean of order 118
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->prefix}wc_orders WHERE id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}wc_order_addresses WHERE order_id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}wc_order_operational_data WHERE order_id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}wc_orders_meta WHERE order_id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}woocommerce_order_items WHERE order_id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}wc_order_stats WHERE order_id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}wc_order_product_lookup WHERE order_id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}wc_order_coupon_lookup WHERE order_id = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE ID = 118");
$wpdb->query("DELETE FROM {$wpdb->prefix}postmeta WHERE post_id = 118");

echo "Cleaned up all DB references for Order #118.\n";

// Show remaining orders
$remaining = $wpdb->get_results("SELECT id, status, total_amount, date_created_gmt FROM {$wpdb->prefix}wc_orders");
echo "Remaining orders in database: " . count($remaining) . "\n";
foreach ($remaining as $r) {
    echo " - Order #{$r->id}: Status={$r->status}, Total={$r->total_amount}, Date={$r->date_created_gmt}\n";
}
