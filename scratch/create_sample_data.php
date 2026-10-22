<?php
/**
 * Create sample coupon, sample order, and enable COD in WooCommerce
 */
require_once __DIR__ . '/../wp-load.php';

if (!function_exists('wc_create_order')) {
    die("Error: WooCommerce is not active.\n");
}

echo "=== 1. KÍCH HOẠT CỔNG THANH TOÁN COD (Cash on Delivery) ===\n";
$cod_settings = array(
    'enabled' => 'yes',
    'title' => 'Cash on delivery',
    'description' => 'Pay with cash upon delivery.',
    'instructions' => 'Pay with cash upon delivery.',
    'enable_for_methods' => array(),
    'enable_for_virtual' => 'yes'
);
update_option('woocommerce_cod_settings', $cod_settings);

// Ensure COD is marked active in gateway order/list
$gateway_order = get_option('woocommerce_gateway_order', array());
if (!is_array($gateway_order)) {
    $gateway_order = array();
}
$gateway_order['cod'] = 0;
update_option('woocommerce_gateway_order', $gateway_order);
echo "-> Đã bật Cash on Delivery (COD) thành công!\n";

echo "\n=== 2. TẠO MÃ GIẢM GIÁ MẪU (QUILLS10) ===\n";
$coupon_code = 'QUILLS10';
$existing_coupon_id = wc_get_coupon_id_by_code($coupon_code);

if ($existing_coupon_id) {
    echo "-> Mã coupon $coupon_code đã tồn tại (ID: $existing_coupon_id).\n";
    $coupon = new WC_Coupon($existing_coupon_id);
} else {
    $coupon = new WC_Coupon();
    $coupon->set_code($coupon_code);
    $coupon->set_discount_type('percent');
    $coupon->set_amount(10); // 10%
    $coupon->set_description('Mã giảm giá chào mừng 10% cho khách hàng mua cà phê');
    $coupon->set_individual_use(false);
    $coupon->set_usage_limit(100);
    $coupon_id = $coupon->save();
    echo "-> Đã tạo mới mã coupon {$coupon->get_code()} thành công! (ID: {$coupon_id}, Giảm 10%)\n";
}

echo "\n=== 3. TẠO ĐƠN HÀNG MẪU (SAMPLE ORDER) ===\n";
// Create order
$order = wc_create_order();

// Add Products
$prod_blacksmith = wc_get_product(45); // Blacksmith | Espresso Blend ($20.00)
$prod_inkwell    = wc_get_product(44); // Inkwell | Signature Blend ($20.00)

if ($prod_blacksmith) {
    $order->add_product($prod_blacksmith, 1);
}
if ($prod_inkwell) {
    $order->add_product($prod_inkwell, 1);
}

// Apply Coupon QUILLS10
$order->apply_coupon($coupon_code);

// Set Billing & Shipping Address
$address = array(
    'first_name' => 'Nguyễn',
    'last_name'  => 'Văn An',
    'company'    => 'Quills Coffee Club',
    'email'      => 'an.nguyen@example.com',
    'phone'      => '0901234567',
    'address_1'  => '123 Đường Lê Lợi, Phường Bến Nghé',
    'city'       => 'Quận 1, TP. Hồ Chí Minh',
    'state'      => 'SG',
    'postcode'   => '700000',
    'country'    => 'VN'
);
$order->set_address($address, 'billing');
$order->set_address($address, 'shipping');

// Set Payment Method COD
$order->set_payment_method('cod');
$order->set_payment_method_title('Cash on delivery');

// Add Shipping line ($5.00 Standard Delivery)
$shipping_item = new WC_Order_Item_Shipping();
$shipping_item->set_method_title('Standard Delivery (Giao hàng tiêu chuẩn)');
$shipping_item->set_method_id('flat_rate:1');
$shipping_item->set_total(5.00);
$order->add_item($shipping_item);

// Calculate totals
$order->calculate_totals();

// Set status to processing (Đang xử lý)
$order->update_status('processing', 'Đơn hàng mẫu thử nghiệm hệ thống Quills Coffee hoàn tất.');

$order_id = $order->save();

echo "-> Đã tạo đơn hàng mẫu thành công!\n";
echo "   - Mã đơn hàng: #" . $order->get_id() . "\n";
echo "   - Khách hàng: " . $order->get_formatted_billing_full_name() . " (" . $order->get_billing_email() . ")\n";
echo "   - Phương thức thanh toán: " . $order->get_payment_method_title() . "\n";
echo "   - Sản phẩm: 1x Blacksmith ($20) + 1x Inkwell ($20) = $40.00\n";
echo "   - Mã giảm giá: " . $coupon_code . " (-$4.00)\n";
echo "   - Phí vận chuyển: $5.00\n";
echo "   - Tổng thanh toán: $" . $order->get_total() . "\n";
echo "   - Trạng thái: " . $order->get_status() . " (Đang xử lý)\n";
echo "=== HOÀN TẤT THÀNH CÔNG ===\n";
