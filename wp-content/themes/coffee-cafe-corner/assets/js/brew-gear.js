/**
 * Brew Gear Collection JavaScript
 * 
 * Handles:
 * - Client-side sort interactions
 * - Direct card click navigation to product detail page
 * - AJAX Add to Cart opening the Quills Slide-in Cart Drawer
 *
 * @package Coffee_Cafe_Corner
 */

(function ($) {
    'use strict';

    $(document).ready(function () {

        // 1. Sort by dropdown interaction
        $('#quills-sort-by-select').on('change', function () {
            var selectedVal = $(this).val();
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('sort_by', selectedVal);
            window.location.href = currentUrl.toString();
        });

        // 2. Direct Navigation to Product Detail Page when clicking anywhere on the card/image/hover (except Add to Cart button)
        $(document).on('click', '.quills-product-image-box, .quills-product-hover-overlay', function (e) {
            // Do not navigate if user clicked the Add to Cart button or inside the form
            if ($(e.target).closest('.quills-hover-action, .quills-add-to-cart-btn, .quills-add-to-cart-form').length) {
                return;
            }

            var $box = $(this).closest('.quills-product-image-box');
            var permalink = $box.attr('data-permalink') ||
                            $box.find('.quills-hover-link-overlay').attr('href') ||
                            $box.find('.quills-product-default-view').attr('href') ||
                            $box.closest('.quills-product-card').find('.quills-product-title-link').attr('href');

            if (permalink) {
                window.location.href = permalink;
            }
        });

        // 3. Helper: Update Cart Counter in Header
        function updateHeaderBadge(count) {
            var $badge = $('.quills-cart-badge');
            if ($badge.length) {
                $badge.text(count);
                if (count > 0) {
                    $badge.show();
                } else {
                    $badge.hide();
                }
            }
        }

        // 4. Helper: Open Cart Drawer
        function openCartDrawer() {
            $('#quills-cart-overlay').addClass('is-active').attr('aria-hidden', 'false');
            $('#quills-cart-drawer').addClass('is-active').attr('aria-hidden', 'false');
            $('body').addClass('quills-drawer-open');
        }

        // 5. Interactive AJAX Add to Cart opening Slide-in Cart Drawer
        $(document).on('click', '.quills-add-to-cart-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var $btn = $(this);
            var productId = $btn.data('product-id') || $btn.closest('.quills-product-card').data('product-id');
            if (!productId) return;

            var originalText = $btn.text();
            $btn.text('ADDING...').prop('disabled', true);

            var ajaxUrl = (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php';
            var nonce = (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '';

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_add_to_cart',
                    nonce: nonce,
                    product_id: productId,
                    quantity: 1,
                    purchase_type: 'onetime'
                },
                success: function (res) {
                    $btn.text('ADDED ✓').addClass('is-added');

                    setTimeout(function () {
                        $btn.text(originalText).removeClass('is-added').prop('disabled', false);

                        if (res && res.success) {
                            if (res.data && res.data.cart_count !== undefined) {
                                updateHeaderBadge(res.data.cart_count);
                            }
                            if (res.data && res.data.drawer_html) {
                                $('#quills-cart-drawer-content').html(res.data.drawer_html);
                            }
                            openCartDrawer();
                        }
                    }, 350);
                },
                error: function () {
                    $btn.text(originalText).prop('disabled', false);
                    alert('Could not add to cart. Please try again.');
                }
            });
        });

    });
})(jQuery);
