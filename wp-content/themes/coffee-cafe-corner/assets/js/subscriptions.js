/**
 * Quills Coffee - Subscriptions Interactive Script
 *
 * @package Coffee_Cafe_Corner
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Live price calculation when changing delivery frequency
        $('.quills-freq-radio').on('change', function() {
            var $card = $(this).closest('.quills-sub-card');
            var basePrice = parseFloat($card.data('base-price')) || 20.00;
            var freq = $(this).val();
            var $priceDisplay = $card.find('.quills-sub-calculated-price');
            var $origPrice = $card.find('.quills-sub-original-price');

            if (freq === '2-weeks' || freq === '4-weeks') {
                var discounted = (basePrice * 0.9).toFixed(2);
                $priceDisplay.text('$' + discounted);
                $origPrice.show();
            } else {
                $priceDisplay.text('$' + basePrice.toFixed(2));
                $origPrice.hide();
            }
        });

        // AJAX Subscribe Button
        $('.quills-sub-submit-btn').on('click', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var $card = $btn.closest('.quills-sub-card');
            var productId = $btn.data('product-id');
            var frequency = $card.find('.quills-freq-radio:checked').val() || '2-weeks';
            var grind = $card.find('.quills-sub-grind-select').val() || 'whole-bean';
            var originalText = $btn.text();

            $btn.prop('disabled', true).text('PROCESSING...');

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_add_subscription_to_cart',
                    product_id: productId,
                    frequency: frequency,
                    grind: grind
                },
                success: function(res) {
                    if (res && res.success) {
                        $btn.text('SUBSCRIBED ✓');
                        var $badge = $('.quills-cart-badge');
                        if ($badge.length) {
                            $badge.text(res.data.cart_count);
                        }
                        setTimeout(function() {
                            window.location.href = res.data.cart_url;
                        }, 800);
                    } else {
                        $btn.prop('disabled', false).text(originalText);
                        alert(res.data.message || 'Could not process subscription.');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).text(originalText);
                    alert('Network error occurred. Please try again.');
                }
            });
        });
    });
})(jQuery);
