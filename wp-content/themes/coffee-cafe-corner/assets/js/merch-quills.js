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
            if (!$('#quills-quick-shop-drawer').hasClass('is-active')) {
                $('body').removeClass('quills-drawer-open');
            }
        }

        $(document).on('click', '#quills-cart-overlay, #quills-drawer-close, .quills-drawer-close', function (e) {
            e.preventDefault();
            closeCartDrawer();
        });

        // Ensure Quick Shop Drawer DOM container exists
        function ensureQuickShopDrawerContainer() {
            if (!$('#quills-quick-shop-drawer').length) {
                $('body').append(
                    '<div class="quills-quick-shop-overlay" id="quills-quick-shop-overlay" aria-hidden="true"></div>' +
                    '<div class="quills-quick-shop-drawer" id="quills-quick-shop-drawer" role="dialog" aria-modal="true" aria-hidden="true">' +
                        '<div class="quills-quick-shop-content" id="quills-quick-shop-content"></div>' +
                    '</div>'
                );
            }
        }
        ensureQuickShopDrawerContainer();

        function openQuickShopDrawer(html) {
            ensureQuickShopDrawerContainer();
            $('#quills-quick-shop-content').html(html);
            $('#quills-quick-shop-overlay').addClass('is-active').attr('aria-hidden', 'false');
            $('#quills-quick-shop-drawer').addClass('is-active').attr('aria-hidden', 'false');
            $('body').addClass('quills-drawer-open');
        }

        function closeQuickShopDrawer() {
            $('#quills-quick-shop-overlay').removeClass('is-active').attr('aria-hidden', 'true');
            $('#quills-quick-shop-drawer').removeClass('is-active').attr('aria-hidden', 'true');
            if (!$('#quills-cart-drawer').hasClass('is-active')) {
                $('body').removeClass('quills-drawer-open');
            }
        }

        $(document).on('click', '#quills-quick-shop-overlay, #quills-qs-close, .quills-qs-close', function (e) {
            e.preventDefault();
            closeQuickShopDrawer();
        });

        $(document).on('keyup', function (e) {
            if (e.key === 'Escape') {
                closeCartDrawer();
                closeQuickShopDrawer();
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

        // 6. Open Quick Shop Drawer on /merch/ Collection Page when clicking "ADD TO CART" (Image 5)
        $(document).on('click', '.quills-merch-btn-add:not(.is-soldout)', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var $btn = $(this);
            var $form = $btn.closest('form');
            var productId = $form.find('input[name="add-to-cart"]').val() || $btn.closest('.quills-merch-card').data('product-id');

            if (!productId || $btn.hasClass('loading')) {
                return;
            }

            var origHtml = $btn.html();
            $btn.addClass('loading').prop('disabled', true).html('<span>LOADING...</span>');

            var ajaxUrl = (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php';
            var nonce = (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '';

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_get_quick_shop_drawer',
                    nonce: nonce,
                    product_id: productId
                },
                success: function (resp) {
                    $btn.removeClass('loading').prop('disabled', false).html(origHtml);
                    if (resp && resp.success && resp.data && resp.data.html) {
                        openQuickShopDrawer(resp.data.html);
                    }
                },
                error: function () {
                    $btn.removeClass('loading').prop('disabled', false).html(origHtml);
                }
            });
        });

        $(document).on('submit', '.quills-merch-quick-add-form', function (e) {
            e.preventDefault();
            $(this).find('.quills-merch-btn-add').trigger('click');
        });

        // Inside Quick Shop Drawer: Size selection
        $(document).on('click', '.quills-qs-size-chips .quills-size-chip:not(.is-disabled)', function (e) {
            e.preventDefault();
            var $chips = $(this).closest('.quills-qs-size-chips');
            $chips.find('.quills-size-chip').removeClass('active');
            $(this).addClass('active');
            var selectedSize = $(this).data('size');
            $('#quills-qs-selected-size').text(selectedSize);
        });

        // Inside Quick Shop Drawer: Stepper (+ / -)
        $(document).on('click', '#quills-qs-qty-minus', function (e) {
            e.preventDefault();
            var $input = $('#quills-qs-qty-input');
            var val = parseInt($input.val(), 10) || 1;
            if (val > 1) {
                $input.val(val - 1);
            }
        });

        $(document).on('click', '#quills-qs-qty-plus', function (e) {
            e.preventDefault();
            var $input = $('#quills-qs-qty-input');
            var val = parseInt($input.val(), 10) || 1;
            $input.val(val + 1);
        });

        // Inside Quick Shop Drawer: ADD TO CART button
        $(document).on('click', '#quills-qs-btn-add', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var qty = parseInt($('#quills-qs-qty-input').val(), 10) || 1;
            var size = $('.quills-qs-size-chips .quills-size-chip.active').data('size') || 'M';

            if (!productId || $btn.hasClass('loading')) {
                return;
            }

            $btn.addClass('loading').prop('disabled', true);
            var origText = $btn.find('.quills-qs-btn-text').text();
            $btn.find('.quills-qs-btn-text').text('ADDING...');

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
                    $btn.removeClass('loading').prop('disabled', false);
                    $btn.find('.quills-qs-btn-text').text(origText);

                    // Close Quick Shop Drawer and open Cart Drawer!
                    closeQuickShopDrawer();

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
                    $btn.removeClass('loading').prop('disabled', false);
                    $btn.find('.quills-qs-btn-text').text(origText);
                    closeQuickShopDrawer();
                    openCartDrawer();
                    refreshCartDrawer();
                }
            });
        });

        // Inside Quick Shop Drawer: Buy with Shop Pay
        $(document).on('click', '#quills-qs-btn-shop', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var checkoutUrl = $btn.data('checkout-url') || '/checkout/';
            var $wrapper = $btn.closest('.quills-qs-content');
            var productId = $btn.data('product-id');
            var qty = parseInt($wrapper.find('#quills-qs-qty-input').val(), 10) || 1;
            var size = $wrapper.find('.quills-qs-size-btn.active').data('size') || '';

            var ajaxUrl = (window.quillsMerch && window.quillsMerch.ajaxUrl) ? window.quillsMerch.ajaxUrl : '/wp-admin/admin-ajax.php';
            var nonce = (window.quillsMerch && window.quillsMerch.nonce) ? window.quillsMerch.nonce : '';

            $btn.css('opacity', '0.7');

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
                complete: function () {
                    window.location.href = checkoutUrl;
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
        $(document).on('click', '.quills-drawer-remove-item, .quills-drawer-remove-btn', function (e) {
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
                            updateUpsellNavButtons();
                        }
                    }
                }
            });
        });

        // 10. People Often Add Carousel Navigation & Quick Add (Matching Image 1 & 2)
        function updateUpsellNavButtons() {
            var $track = $('#quills-upsell-track');
            if (!$track.length) return;
            var el = $track[0];
            if (el.scrollLeft > 10) {
                $('#quills-upsell-prev').fadeIn(150);
            } else {
                $('#quills-upsell-prev').fadeOut(150);
            }
            if (el.scrollLeft + el.clientWidth >= el.scrollWidth - 10) {
                $('#quills-upsell-next').fadeOut(150);
            } else {
                $('#quills-upsell-next').fadeIn(150);
            }
        }

        $(document).on('click', '#quills-upsell-next', function (e) {
            e.preventDefault();
            var $track = $('#quills-upsell-track');
            if ($track.length) {
                var current = $track.scrollLeft();
                $track.animate({ scrollLeft: current + 300 }, 300, function () {
                    updateUpsellNavButtons();
                });
            }
        });

        $(document).on('click', '#quills-upsell-prev', function (e) {
            e.preventDefault();
            var $track = $('#quills-upsell-track');
            if ($track.length) {
                var current = $track.scrollLeft();
                $track.animate({ scrollLeft: current - 300 }, 300, function () {
                    updateUpsellNavButtons();
                });
            }
        });

        $(document).on('scroll', '#quills-upsell-track', function () {
            updateUpsellNavButtons();
        });

        // Toggle "People often add" Accordion
        $(document).on('click', '#quills-upsell-toggle', function (e) {
            e.preventDefault();
            $(this).closest('.quills-drawer-upsell-section').toggleClass('collapsed');
        });

        // Quick add from "People often add" carousel
        $(document).on('click', '.quills-drawer-upsell-add-btn', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var productId = $btn.data('product-id');
            if (!productId || $btn.hasClass('loading')) return;

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
                    quantity: 1,
                    size: 'M'
                },
                success: function (resp) {
                    $btn.removeClass('loading');
                    if (resp && resp.success) {
                        updateHeaderBadge(resp.data.cart_count);
                        if (resp.data.drawer_html) {
                            $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                            updateUpsellNavButtons();
                        }
                    }
                },
                error: function () {
                    $btn.removeClass('loading');
                }
            });
        });

        // Initial check for upsell buttons when drawer opens
        $(document).on('quills_cart_opened', function () {
            updateUpsellNavButtons();
        });

    });

})(jQuery);
