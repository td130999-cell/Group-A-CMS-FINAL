<?php
/**
 * Quills Coffee - Order Received / Thank You Template
 * Displays complete order details querying 100% dynamic data from the WooCommerce database.
 */

defined('ABSPATH') || exit;

// Retrieve Order from query var or GET param
$order_id = absint( get_query_var( 'order-received' ) );
if ( ! $order_id && isset( $_GET['order_id'] ) ) {
    $order_id = absint( $_GET['order_id'] );
}

$order = $order_id ? wc_get_order( $order_id ) : false;

// Security check: verify order key if present in URL
$order_key = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : '';
$is_key_valid = true;
if ( $order && $order_key ) {
    if ( $order->get_order_key() !== $order_key && ! current_user_can( 'edit_shop_orders' ) ) {
        $is_key_valid = false;
    }
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $order ? 'Order #' . esc_html($order->get_order_number()) . ' Received' : 'Order Received'; ?> | Quills Coffee</title>
    <?php wp_head(); ?>
    <style>
        /* Scoped Quills Order Received Page Styles */
        body.quills-order-received-page {
            background-color: #FBF8F2 !important;
            color: #1F2937;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .quills-order-wrapper {
            max-width: 1080px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        /* Success Hero */
        .quills-order-hero {
            text-align: center;
            margin-bottom: 36px;
            padding: 20px 0;
        }

        .quills-order-hero__icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 18px;
            background: #2D4A3E;
            color: #FFFFFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(45, 74, 62, 0.25);
        }

        .quills-order-hero__icon svg {
            width: 32px;
            height: 32px;
            stroke-width: 2.5;
        }

        .quills-order-hero__title {
            font-family: 'Besley', Georgia, serif;
            font-size: 32px;
            font-weight: 700;
            color: #18221E;
            margin: 0 0 10px;
            letter-spacing: -0.5px;
        }

        .quills-order-hero__subtitle {
            font-size: 16px;
            color: #556960;
            margin: 0 auto;
            max-width: 580px;
            line-height: 1.5;
        }

        .quills-order-hero__status {
            display: inline-block;
            margin-top: 14px;
            background: #E8F2EC;
            color: #1E6B47;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #D0E5D9;
        }

        /* Summary Bar */
        .quills-order-summary-bar {
            background: #FFFFFF;
            border: 1px solid #EAE3D2;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 36px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .quills-summary-item {
            border-right: 1px solid #EFEAE0;
            padding-right: 15px;
        }

        .quills-summary-item:last-child {
            border-right: none;
            padding-right: 0;
        }

        .quills-summary-item__label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #7A8B83;
            margin-bottom: 6px;
        }

        .quills-summary-item__val {
            font-size: 17px;
            font-weight: 700;
            color: #18221E;
            word-break: break-word;
        }

        /* 2 Column Layout */
        .quills-order-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 32px;
            align-items: start;
        }

        /* Card styles */
        .quills-card {
            background: #FFFFFF;
            border: 1px solid #EAE3D2;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .quills-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #EFEAE0;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .quills-card__title {
            font-family: 'Besley', Georgia, serif;
            font-size: 19px;
            font-weight: 700;
            color: #18221E;
            margin: 0;
        }

        /* Order Items List */
        .quills-item-row {
            display: flex;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #F3EFE6;
        }

        .quills-item-row:last-child {
            border-bottom: none;
        }

        .quills-item-thumb {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: #F4EFE6;
            flex-shrink: 0;
            margin-right: 16px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quills-item-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .quills-item-info {
            flex: 1;
            min-width: 0;
        }

        .quills-item-name {
            font-size: 15px;
            font-weight: 700;
            color: #18221E;
            margin: 0 0 4px;
            line-height: 1.3;
        }

        .quills-item-meta {
            font-size: 12px;
            color: #6C7D75;
            margin: 0;
        }

        .quills-item-meta span {
            display: inline-block;
            margin-right: 10px;
        }

        .quills-item-pricing {
            text-align: right;
            padding-left: 16px;
            flex-shrink: 0;
        }

        .quills-item-qty {
            font-size: 12px;
            color: #7A8B83;
            margin-bottom: 2px;
        }

        .quills-item-total {
            font-size: 16px;
            font-weight: 700;
            color: #18221E;
        }

        /* Financial Breakdown */
        .quills-cost-table {
            width: 100%;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #EFEAE0;
        }

        .quills-cost-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
            color: #4B5563;
        }

        .quills-cost-row.quills-cost-discount {
            color: #B91C1C;
        }

        .quills-cost-row.quills-cost-total {
            border-top: 1px solid #E5E7EB;
            margin-top: 10px;
            padding-top: 12px;
            font-size: 18px;
            font-weight: 800;
            color: #18221E;
        }

        .quills-cost-total span:last-child {
            color: #2D4A3E;
            font-size: 20px;
        }

        /* Customer Detail Blocks */
        .quills-detail-group {
            margin-bottom: 18px;
        }

        .quills-detail-group:last-child {
            margin-bottom: 0;
        }

        .quills-detail-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #7A8B83;
            margin-bottom: 4px;
        }

        .quills-detail-value {
            font-size: 14px;
            line-height: 1.5;
            color: #18221E;
        }

        .quills-address-box {
            background: #FAF7F0;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            line-height: 1.5;
            color: #2A3832;
        }

        /* Action Buttons */
        .quills-order-actions {
            margin-top: 36px;
            display: flex;
            gap: 16px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .quills-btn-primary {
            background: #2D4A3E;
            color: #FFFFFF !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 14px rgba(45, 74, 62, 0.2);
        }

        .quills-btn-primary:hover {
            background: #22372E;
            transform: translateY(-1px);
        }

        .quills-btn-secondary {
            background: #FFFFFF;
            color: #2D4A3E !important;
            border: 1px solid #C4D3CB;
            padding: 13px 24px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .quills-btn-secondary:hover {
            background: #F3F7F5;
            border-color: #2D4A3E;
        }

        /* Help Box */
        .quills-order-help {
            margin-top: 32px;
            text-align: center;
            font-size: 13px;
            color: #6C7D75;
        }

        .quills-order-help a {
            color: #2D4A3E;
            font-weight: 600;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 820px) {
            .quills-order-summary-bar {
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }
            .quills-summary-item:nth-child(2) {
                border-right: none;
            }
            .quills-order-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .quills-order-summary-bar {
                grid-template-columns: 1fr;
            }
            .quills-summary-item {
                border-right: none;
                border-bottom: 1px solid #EFEAE0;
                padding-bottom: 12px;
            }
            .quills-summary-item:last-child {
                border-bottom: none;
            }
        }

        /* Print styles */
        @media print {
            .quills-announcement-bar,
            .quills-header,
            .quills-footer-wrapper,
            .quills-order-actions,
            #wpadminbar {
                display: none !important;
            }
            body.quills-order-received-page {
                background: #FFFFFF !important;
            }
            .quills-card, .quills-order-summary-bar {
                border: 1px solid #CCC !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body <?php body_class('quills-body quills-order-received-page'); ?>>

<?php get_template_part( 'patterns/header' ); ?>

<div class="quills-order-wrapper">

    <?php if ( ! $order || ! $is_key_valid ) : ?>
        <div class="quills-order-hero">
            <div class="quills-order-hero__icon" style="background:#8C3B3B;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <h1 class="quills-order-hero__title">Order Not Found</h1>
            <p class="quills-order-hero__subtitle">We could not locate this order or your access key has expired.</p>
            <div class="quills-order-actions">
                <a href="<?php echo esc_url( home_url('/coffee/') ); ?>" class="quills-btn-primary">Return to Shop</a>
            </div>
        </div>
    <?php else : 
        $order_number   = $order->get_order_number();
        $date_created   = $order->get_date_created() ? $order->get_date_created()->date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) : '';
        $order_status   = $order->get_status();
        $payment_title  = $order->get_payment_method_title() ?: 'Cash on delivery';
        $order_total    = $order->get_formatted_order_total();
        $billing_email  = $order->get_billing_email();
        $billing_phone  = $order->get_billing_phone();
        $billing_name   = trim( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
        $customer_note  = $order->get_customer_note();

        // Human-friendly status translation
        $status_map = [
            'processing' => 'Processing (Đang chuẩn bị hàng)',
            'completed'  => 'Completed (Đã giao hàng)',
            'on-hold'    => 'On Hold (Tạm giữ)',
            'pending'    => 'Pending Payment (Chờ thanh toán)',
            'cancelled'  => 'Cancelled (Đã hủy)',
            'refunded'   => 'Refunded (Đã hoàn tiền)',
            'failed'     => 'Failed (Thất bại)'
        ];
        $display_status = isset($status_map[$order_status]) ? $status_map[$order_status] : ucfirst($order_status);
    ?>

        <!-- Success Hero -->
        <div class="quills-order-hero">
            <div class="quills-order-hero__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h1 class="quills-order-hero__title">THANK YOU FOR YOUR ORDER!</h1>
            <p class="quills-order-hero__subtitle">
                Your order <strong>#<?php echo esc_html($order_number); ?></strong> has been received and is currently being processed.
                <?php if ( $billing_email ) : ?>
                    A confirmation email has been dispatched to <strong><?php echo esc_html($billing_email); ?></strong>.
                <?php endif; ?>
            </p>
            <div class="quills-order-hero__status">
                ● <?php echo esc_html($display_status); ?>
            </div>
        </div>

        <!-- 4-Stat Summary Bar -->
        <div class="quills-order-summary-bar">
            <div class="quills-summary-item">
                <div class="quills-summary-item__label">Order Number</div>
                <div class="quills-summary-item__val">#<?php echo esc_html($order_number); ?></div>
            </div>
            <div class="quills-summary-item">
                <div class="quills-summary-item__label">Date & Time</div>
                <div class="quills-summary-item__val"><?php echo esc_html($date_created); ?></div>
            </div>
            <div class="quills-summary-item">
                <div class="quills-summary-item__label">Total Amount</div>
                <div class="quills-summary-item__val" style="color:#2D4A3E;"><?php echo wp_kses_post($order_total); ?></div>
            </div>
            <div class="quills-summary-item">
                <div class="quills-summary-item__label">Payment Method</div>
                <div class="quills-summary-item__val"><?php echo esc_html($payment_title); ?></div>
            </div>
        </div>

        <!-- Main 2-Column Grid -->
        <div class="quills-order-grid">

            <!-- LEFT: Order Items & Costs -->
            <div class="quills-order-grid__left">
                <div class="quills-card">
                    <div class="quills-card__header">
                        <h2 class="quills-card__title">Order Items</h2>
                        <span style="font-size:13px; color:#6C7D75;"><?php echo count($order->get_items()); ?> item(s)</span>
                    </div>

                    <div class="quills-items-list">
                        <?php foreach ( $order->get_items() as $item_id => $item ) : 
                            $product     = $item->get_product();
                            $item_name   = $item->get_name();
                            $quantity    = $item->get_quantity();
                            $subtotal    = $order->get_formatted_line_subtotal( $item );
                            $thumb_url   = '';

                            if ( $product ) {
                                $image_id = $product->get_image_id();
                                if ( $image_id ) {
                                    $thumb_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
                                }
                            }
                            if ( ! $thumb_url ) {
                                // Fallback coffee pouch icon or placeholder
                                $thumb_url = home_url( '/wp-content/themes/coffee-cafe-corner/assets/images/coffee-placeholder.png' );
                            }
                        ?>
                            <div class="quills-item-row">
                                <div class="quills-item-thumb">
                                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($item_name); ?>" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'60\' height=\'60\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%238c7b66\' stroke-width=\'1.5\'><path d=\'M18 8h1a4 4 0 0 1 0 8h-1\'/><path d=\'M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z\'/><line x1=\'6\' y1=\'1\' x2=\'6\' y2=\'4\'/><line x1=\'10\' y1=\'1\' x2=\'10\' y2=\'4\'/><line x1=\'14\' y1=\'1\' x2=\'14\' y2=\'4\'/></svg>';">
                                </div>
                                <div class="quills-item-info">
                                    <div class="quills-item-name"><?php echo esc_html($item_name); ?></div>
                                    <div class="quills-item-meta">
                                        <?php 
                                            // Output item metadata (e.g. Size, Grind)
                                            $meta_data = $item->get_formatted_meta_data('');
                                            if ( ! empty($meta_data) ) {
                                                foreach ( $meta_data as $meta ) {
                                                    echo '<span>' . esc_html($meta->display_key) . ': <strong>' . wp_kses_post($meta->display_value) . '</strong></span>';
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="quills-item-pricing">
                                    <div class="quills-item-qty">Qty: <?php echo esc_html($quantity); ?></div>
                                    <div class="quills-item-total"><?php echo wp_kses_post($subtotal); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Financial Summary -->
                    <div class="quills-cost-table">
                        <div class="quills-cost-row">
                            <span>Subtotal</span>
                            <span><?php echo wc_price( $order->get_subtotal() ); ?></span>
                        </div>

                        <?php if ( $order->get_total_discount() > 0 ) : ?>
                            <div class="quills-cost-row quills-cost-discount">
                                <span>Discount <?php 
                                    $coupons = $order->get_coupon_codes();
                                    if (!empty($coupons)) echo '(' . esc_html(implode(', ', $coupons)) . ')'; 
                                ?></span>
                                <span>-<?php echo wc_price( $order->get_total_discount() ); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="quills-cost-row">
                            <span>Shipping <?php 
                                $shipping_method = $order->get_shipping_method();
                                if ($shipping_method) echo '(' . esc_html($shipping_method) . ')';
                            ?></span>
                            <span>
                                <?php 
                                    $shipping_total = (float) $order->get_shipping_total();
                                    echo $shipping_total > 0 ? wc_price( $shipping_total ) : 'Free';
                                ?>
                            </span>
                        </div>

                        <?php if ( $order->get_total_tax() > 0 ) : ?>
                            <div class="quills-cost-row">
                                <span>Taxes</span>
                                <span><?php echo wc_price( $order->get_total_tax() ); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="quills-cost-row quills-cost-total">
                            <span>Total Due</span>
                            <span><?php echo wp_kses_post( $order_total ); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Customer, Shipping, Billing -->
            <div class="quills-order-grid__right">
                
                <!-- Customer Details Card -->
                <div class="quills-card">
                    <div class="quills-card__header">
                        <h2 class="quills-card__title">Customer Details</h2>
                    </div>

                    <div class="quills-detail-group">
                        <div class="quills-detail-label">Recipient Name</div>
                        <div class="quills-detail-value"><strong><?php echo esc_html($billing_name ?: 'Valued Customer'); ?></strong></div>
                    </div>

                    <?php if ( $billing_email ) : ?>
                        <div class="quills-detail-group">
                            <div class="quills-detail-label">Email Address</div>
                            <div class="quills-detail-value"><?php echo esc_html($billing_email); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ( $billing_phone ) : ?>
                        <div class="quills-detail-group">
                            <div class="quills-detail-label">Phone Number</div>
                            <div class="quills-detail-value"><?php echo esc_html($billing_phone); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Shipping / Billing Address Card -->
                <div class="quills-card">
                    <div class="quills-card__header">
                        <h2 class="quills-card__title">Delivery Address</h2>
                    </div>

                    <?php 
                        $shipping_address = $order->get_formatted_shipping_address();
                        $billing_address  = $order->get_formatted_billing_address();
                        $display_address  = $shipping_address ?: $billing_address;
                    ?>

                    <div class="quills-address-box">
                        <?php if ( $display_address ) : ?>
                            <?php echo wp_kses_post( $display_address ); ?>
                        <?php else : ?>
                            <em>No address specified.</em>
                        <?php endif; ?>
                    </div>

                    <?php if ( $customer_note ) : ?>
                        <div class="quills-detail-group" style="margin-top:16px;">
                            <div class="quills-detail-label">Customer Order Note</div>
                            <div class="quills-detail-value" style="font-style:italic; background:#FFF; border-left:3px solid #2D4A3E; padding:8px 12px; margin-top:4px;">
                                "<?php echo esc_html( $customer_note ); ?>"
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Payment Notice Card -->
                <div class="quills-card" style="background:#F2F7F4; border-color:#D0E2D8;">
                    <div style="display:flex; align-items:flex-start; gap:12px;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2D4A3E" stroke-width="2" style="flex-shrink:0; margin-top:2px;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        <div style="font-size:13px; color:#233D31; line-height:1.4;">
                            <strong>Payment Notice:</strong><br>
                            You have selected <strong><?php echo esc_html($payment_title); ?></strong>. Please prepare the exact cash amount of <strong><?php echo wp_kses_post($order_total); ?></strong> when the courier delivers your package.
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Action Buttons -->
        <div class="quills-order-actions">
            <a href="<?php echo esc_url( home_url('/coffee/') ); ?>" class="quills-btn-primary">
                CONTINUE SHOPPING →
            </a>
            <button type="button" onclick="window.print();" class="quills-btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                PRINT RECEIPT
            </button>
        </div>

        <!-- Support Box -->
        <div class="quills-order-help">
            Have questions regarding your order? Reach our customer care team at <a href="mailto:hello@quillscoffee.com">hello@quillscoffee.com</a> or call <a href="tel:5028615844">(502) 861-5844</a>.
        </div>

    <?php endif; ?>

</div><!-- /.quills-order-wrapper -->

<?php get_template_part( 'patterns/footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
