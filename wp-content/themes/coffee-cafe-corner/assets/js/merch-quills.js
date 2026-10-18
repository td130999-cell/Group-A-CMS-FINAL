/**
 * Quills Coffee - Merchandise (Merch) Interactive Scripts
 *
 * Handles:
 * 1. Card click navigation to single product detail pages
 * 2. AJAX Add-to-Cart with Cart Drawer slide-out on /merch/ collection page
 * 3. Size selection chips and stock status on Merch single product pages
 * 4. Interactive Cart Drawer controls (stepper, remove, close triggers)
 *
 * @package Coffee_Cafe_Corner
 */

(function ($) {
    'use strict';

    $(document).ready(function () {

        // 1. Navigation: Click anywhere on Merch Card outside action button
        $(document).on('click', '.quills-merch-card', function (e) {
            if ($(e.target).closest('.quills-merch-btn-add, .quills-cart-drawer, form, button, a').length) {
                return;
            }

            var permalink = $(this).find('a.quills-merch-img-link').attr('href') ||
                            $(this).find('.quills-merch-name a').attr('href');

            if (permalink) {
                window.location.href = permalink;
            }
        });

        // 2. Ensure Cart Drawer DOM container exists
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

        // 3. Update header cart badge
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

        // 4. Open / Close Cart Drawer
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

        $(document).on('click', '#quills-cart-overlay, #quills-drawer-close, .quills-drawer-close', function (e) {
            e.preventDefault();
            closeCartDrawer();
        });

        $(document).on('keyup', function (e) {
            if (e.key === 'Escape') {
                closeCartDrawer();
            }
        });

        // Click header cart link to open drawer
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

        // 5. Size Selection Chips on Merch Product Detail Page
        $(document).on('click', '.quills-merch-size-chips .quills-size-chip:not(.is-disabled)', function (e) {
            e.preventDefault();
            $('.quills-merch-size-chips .quills-size-chip').removeClass('active');
            $(this).addClass('active');
            var selectedSize = $(this).data('size');
            $('#quills-selected-size-label').text(selectedSize);
        });

        // 6. Quick Add to Cart via AJAX on /merch/ Collection Page
        $(document).on('submit', '.quills-merch-quick-add-form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('.quills-merch-btn-add');
            var productId = $form.find('input[name="add-to-cart"]').val();

            if (!productId || $btn.hasClass('loading') || $btn.hasClass('is-soldout')) {
                return;
            }

            var origHtml = $btn.html();
            $btn.addClass('loading').prop('disabled', true).html('<span>ADDING...</span>');

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
                    size: 'M'
                },
                success: function (resp) {
                    $btn.removeClass('loading').prop('disabled', false).html(origHtml);

                    if (resp && resp.success) {
                        updateHeaderBadge(resp.data.cart_count);
                        if (resp.data.drawer_html) {
                            $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                        }
                        openCartDrawer();
                    } else {
                        var msg = (resp && resp.data && resp.data.message) ? resp.data.message : 'Item added to cart.';
                        openCartDrawer();
                        refreshCartDrawer();
                    }
                },
                error: function () {
                    $btn.removeClass('loading').prop('disabled', false).html(origHtml);
                    openCartDrawer();
                    refreshCartDrawer();
                }
            });
        });

        // 7. Add to Cart on Merch Single Product Detail Page
        $(document).on('click', '.quills-single-product-page #quills-btn-add-to-cart', function (e) {
            var $sizeChips = $('.quills-merch-size-chips .quills-size-chip.active');
            if ($sizeChips.length) {
                // Merch product with size chips
                e.preventDefault();
                var $btn = $(this);
                var productId = $btn.data('product-id');
                var qty = parseInt($('#quills-qty-input').val(), 10) || 1;
                var size = $sizeChips.data('size') || 'M';

                $btn.addClass('loading');

                var ajaxUrl = (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php';
                var nonce = (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '';

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'quills_add_to_cart',
                        nonce: nonce,
                        product_id: productId,
                        quantity: qty,
                        size: size
                    },
                    success: function (resp) {
                        $btn.removeClass('loading');
                        if (resp && resp.success) {
                            updateHeaderBadge(resp.data.cart_count);
                            if (resp.data.drawer_html) {
                                $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                            }
                            openCartDrawer();
                        } else {
                            openCartDrawer();
                            refreshCartDrawer();
                        }
                    },
                    error: function () {
                        $btn.removeClass('loading');
                        openCartDrawer();
                        refreshCartDrawer();
                    }
                });
            }
        });

        // 8. Stepper (+ / -) in Cart Drawer
        $(document).on('click', '.quills-drawer-step-btn', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var key = $btn.data('key');
            var qty = parseInt($btn.data('qty'), 10);
            var ajaxUrl = (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php';
            var nonce = (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '';

            $btn.prop('disabled', true);

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_update_cart_qty',
                    nonce: nonce,
                    cart_item_key: key,
                    quantity: qty
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

        // 9. Remove Item from Cart Drawer
        $(document).on('click', '.quills-drawer-remove-item', function (e) {
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

    });

})(jQuery);
