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

        // 3. Helper: Guarantee Cart Drawer DOM exists
        function ensureCartDrawerContainer() {
            if (!$('#quills-cart-drawer').length) {
                $('body').append(
                    '<div class="quills-cart-overlay" id="quills-cart-overlay" aria-hidden="true"></div>' +
                    '<aside class="quills-cart-drawer" id="quills-cart-drawer" aria-hidden="true">' +
                        '<div id="quills-cart-drawer-content"></div>' +
                    '</aside>'
                );
            }
        }
        ensureCartDrawerContainer();

        // 4. Helper: Update Cart Counter in Header
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

        // 5. Helper: Open / Close Cart Drawer
        function openCartDrawer() {
            ensureCartDrawerContainer();
            $('#quills-cart-overlay').addClass('is-active').attr('aria-hidden', 'false');
            $('#quills-cart-drawer').addClass('is-active').attr('aria-hidden', 'false');
            $('body').addClass('quills-drawer-open');
        }

        function closeCartDrawer() {
            $('#quills-cart-overlay').removeClass('is-active').attr('aria-hidden', 'true');
            $('#quills-cart-drawer').removeClass('is-active').attr('aria-hidden', 'true');
            $('body').removeClass('quills-drawer-open');
        }

        // Close drawer events
        $(document).on('click', '#quills-cart-overlay, #quills-drawer-close, .quills-drawer-close', function (e) {
            e.preventDefault();
            closeCartDrawer();
        });

        $(document).on('keyup', function (e) {
            if (e.key === 'Escape') {
                closeCartDrawer();
            }
        });

        // Click on header cart icon to toggle drawer
        $(document).on('click', '.quills-cart-link, .quills-cart-toggle, .quills-cart-icon-wrapper', function (e) {
            e.preventDefault();
            openCartDrawer();
            refreshCartDrawer();
        });

        function refreshCartDrawer() {
            var ajaxUrl = (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php';
            var nonce = (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '';

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_get_cart_drawer',
                    nonce: nonce
                },
                success: function (resp) {
                    if (resp && resp.success && resp.data && resp.data.drawer_html) {
                        $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                    }
                }
            });
        }

        // Stepper (+ / -) in Cart Drawer
        $(document).on('click', '.quills-drawer-step-btn', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var key = $btn.data('key');
            var newQty = parseInt($btn.data('qty'), 10);
            var ajaxUrl = (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php';
            var nonce = (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '';

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_update_cart_qty',
                    nonce: nonce,
                    cart_item_key: key,
                    quantity: newQty
                },
                success: function (resp) {
                    if (resp && resp.success) {
                        updateHeaderBadge(resp.data.cart_count);
                        if (resp.data.drawer_html) {
                            $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                        }
                    }
                }
            });
        });

        // Remove item from Cart Drawer
        $(document).on('click', '.quills-drawer-remove-btn', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var key = $btn.data('key');
            var ajaxUrl = (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php';
            var nonce = (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '';

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_remove_cart_item',
                    nonce: nonce,
                    cart_item_key: key
                },
                success: function (resp) {
                    if (resp && resp.success) {
                        updateHeaderBadge(resp.data.cart_count);
                        if (resp.data.drawer_html) {
                            $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                        }
                    }
                }
            });
        });

        // 6. Interactive AJAX Add to Cart opening Slide-in Cart Drawer
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

        // 7. Buy with shop button on Brew Gear cards -> Add to cart & redirect to /checkout/
        $(document).off('click.brewGearShop', '.quills-bg-btn-shop').on('click.brewGearShop', '.quills-bg-btn-shop', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var $btn = $(this);
            if ($btn.hasClass('loading') || $btn.prop('disabled')) return;

            var productId = $btn.data('product-id') || $btn.closest('.quills-product-card').data('product-id');
            var checkoutUrl = $btn.data('checkout-url') || '/checkout/';
            if (!productId) return;

            $btn.addClass('loading').prop('disabled', true).css('opacity', '0.7');

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
                complete: function() {
                    window.location.href = checkoutUrl;
                }
            });
        });

    });
})(jQuery);
