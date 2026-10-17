/**
 * Quills Coffee - Coffee Collection Script
 * 
 * Handles:
 * - Category pill filtering (Blends, Single Origin, Espresso, Decaf)
 * - Accordion sidebar toggling (Process, Roast Profile, Coffee)
 * - Accordion filter radio changes with live AJAX updates
 * - Live sorting dropdown (Best selling, Featured, Price, Title, Date)
 * - Testimonial quote sliders (Top & Bottom)
 *
 * @package Coffee_Cafe_Corner
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        var $grid = $('#quills-coffee-grid');
        var $count = $('#quills-products-count');
        var currentSort = $('#quills-coffee-sort-select').val() || 'best-selling';
        var TOTAL_PRODUCTS = 13;

        function getSelectedFilters() {
            var process = $('input[name="filter_process[]"]:checked').map(function() { return this.value; }).get();
            var roast = $('input[name="filter_roast[]"]:checked').map(function() { return this.value; }).get();
            var types = $('input[name="filter_type[]"]:checked').map(function() { return this.value; }).get();
            return {
                process: process,
                roast: roast,
                tab: types,
                totalChecked: process.length + roast.length + types.length
            };
        }

        function updateActiveFilterTags() {
            var $checked = $('input[name^="filter_"]:checked');
            var $container = $('#quills-active-filters');
            var $list = $('#quills-active-filters-list');

            if ($checked.length === 0) {
                $list.empty();
                $container.hide();
                return;
            }

            var html = '';
            $checked.each(function() {
                var $input = $(this);
                var group = $input.data('group-label') || '';
                var option = $input.data('option-label') || $input.val();
                var name = $input.attr('name');
                var val = $input.val();

                html += '<button type="button" class="quills-filter-tag" data-target-name="' + name + '" data-target-val="' + val + '">';
                html += group + ': ' + option + ' <span class="quills-filter-tag-x">✕</span>';
                html += '</button>';
            });

            $list.html(html);
            $container.show();
        }

        function updateAccordionHeaderCounts() {
            var procCount = $('input[name="filter_process[]"]:checked').length;
            var roastCount = $('input[name="filter_roast[]"]:checked').length;
            var typeCount = $('input[name="filter_type[]"]:checked').length;

            $('[data-count-for="process"]').text(procCount > 0 ? '(' + procCount + ')' : '');
            $('[data-count-for="roast"]').text(roastCount > 0 ? '(' + roastCount + ')' : '');
            $('[data-count-for="coffee"]').text(typeCount > 0 ? '(' + typeCount + ')' : '');
        }

        function syncCategoryPills(selectedTypes) {
            $('.quills-category-pill').each(function() {
                var tab = $(this).data('tab');
                if (selectedTypes.indexOf(tab) !== -1) {
                    $(this).addClass('is-active');
                } else {
                    $(this).removeClass('is-active');
                }
            });
        }

        function updateUrlParams() {
            var filters = getSelectedFilters();
            var params = new URLSearchParams();
            if (currentSort && currentSort !== 'best-selling') {
                params.set('sort_by', currentSort);
            }
            filters.process.forEach(function(p) {
                params.append('filter.p.m.custom.process', p);
            });
            filters.roast.forEach(function(r) {
                params.append('filter.p.m.custom.roast_profile', r);
            });
            filters.tab.forEach(function(t) {
                params.append('filter.p.m.custom.coffee_type', t);
            });
            var newQuery = params.toString();
            var newUrl = window.location.pathname + (newQuery ? '?' + newQuery : '');
            window.history.replaceState({}, '', newUrl);
        }

        function initFromUrl() {
            if (!window.location.search) {
                updateActiveFilterTags();
                updateAccordionHeaderCounts();
                return;
            }
            var params = new URLSearchParams(window.location.search);
            var changed = false;

            if (params.has('sort_by')) {
                currentSort = params.get('sort_by');
                $('#quills-coffee-sort-select').val(currentSort);
            }

            params.getAll('filter.p.m.custom.process').forEach(function(val) {
                var $chk = $('input[name="filter_process[]"][value="' + val + '"]');
                if ($chk.length && !$chk.is(':checked')) {
                    $chk.prop('checked', true);
                    changed = true;
                }
            });

            params.getAll('filter.p.m.custom.roast_profile').forEach(function(val) {
                var $chk = $('input[name="filter_roast[]"][value="' + val + '"]');
                if ($chk.length && !$chk.is(':checked')) {
                    $chk.prop('checked', true);
                    changed = true;
                }
            });

            params.getAll('filter.p.m.custom.coffee_type').forEach(function(val) {
                var $chk = $('input[name="filter_type[]"][value="' + val + '"]');
                if ($chk.length && !$chk.is(':checked')) {
                    $chk.prop('checked', true);
                    changed = true;
                }
            });

            $('.quills-accordion-item').each(function() {
                var hasChecked = $(this).find('input[type="checkbox"]:checked').length > 0;
                if (hasChecked) {
                    $(this).addClass('is-open');
                    $(this).find('.quills-accordion-header').attr('aria-expanded', 'true');
                    $(this).find('.quills-accordion-icon').text('−');
                }
            });

            updateActiveFilterTags();
            updateAccordionHeaderCounts();
            syncCategoryPills(getSelectedFilters().tab);

            if (changed) {
                fetchFilteredCoffee();
            }
        }

        function onFiltersChanged() {
            var filters = getSelectedFilters();
            updateActiveFilterTags();
            updateAccordionHeaderCounts();
            syncCategoryPills(filters.tab);
            updateUrlParams();
            fetchFilteredCoffee();
        }

        initFromUrl();

        // 1. Accordion Toggle
        $('.quills-accordion-header').on('click', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.quills-accordion-item');
            var isOpen = $item.hasClass('is-open');
            var $icon = $(this).find('.quills-accordion-icon');

            if (isOpen) {
                $item.removeClass('is-open');
                $(this).attr('aria-expanded', 'false');
                $icon.text('+');
            } else {
                $item.addClass('is-open');
                $(this).attr('aria-expanded', 'true');
                $icon.text('−');
            }
        });

        // 2. Category Quick Pills
        $('.quills-category-pill').on('click', function(e) {
            e.preventDefault();
            var $pill = $(this);
            var selectedTab = $pill.data('tab');
            var $targetCheckbox = $('input[name="filter_type[]"][value="' + selectedTab + '"]');

            if ($pill.hasClass('is-active')) {
                $pill.removeClass('is-active');
                $targetCheckbox.prop('checked', false);
            } else {
                $pill.addClass('is-active');
                $targetCheckbox.prop('checked', true);
            }

            onFiltersChanged();
        });

        // 3. Sidebar Square Checkbox Filters (Event Delegation)
        $(document).on('change', 'input[name="filter_process[]"], input[name="filter_roast[]"], input[name="filter_type[]"]', function() {
            onFiltersChanged();
        });

        // 4. Click individual active filter tag to remove it
        $(document).on('click', '.quills-filter-tag', function(e) {
            e.preventDefault();
            var name = $(this).attr('data-target-name') || $(this).data('target-name');
            var val = $(this).attr('data-target-val') || $(this).data('target-val');
            $('input[name="' + name + '"][value="' + val + '"]').prop('checked', false);
            onFiltersChanged();
        });

        // 5. Click "Remove all" to clear all active filters
        $(document).on('click', '#quills-filters-remove-all', function(e) {
            e.preventDefault();
            $('input[name^="filter_"]').prop('checked', false);
            $('.quills-category-pill').removeClass('is-active');
            onFiltersChanged();
        });

        // 6. Sort Dropdown
        $(document).on('change', '#quills-coffee-sort-select', function() {
            currentSort = $(this).val();
            updateUrlParams();
            fetchFilteredCoffee();
        });

        // 6b. Coffee Card Hover Behavior
        $(document).on('mouseenter', '.quills-coffee-card', function() {
            $(this).addClass('is-hovered');
        }).on('mouseleave', '.quills-coffee-card', function() {
            $(this).removeClass('is-hovered');
        });

        // Helper to update Cart Badge across header
        function setQuillsCartCount(count) {
            count = parseInt(count, 10) || 0;
            var $badges = $('#quills-cart-badge, .quills-cart-badge');
            if (count > 0) {
                $badges.text(count).removeClass('is-empty').show();
            } else {
                $badges.text('0').addClass('is-empty').hide();
            }
        }

        // 7a. Hover Card Navigation: Clicking anywhere outside ADD TO CART navigates to single product detail page
        $(document).off('click.quillsRollover', '.rollover_inner').on('click.quillsRollover', '.rollover_inner', function(e) {
            if ($(e.target).closest('.quills-hover-add-cart, .rollover_bottom').length) {
                return; // Handled by 7b
            }
            var permalink = $(this).data('permalink') || $(this).find('.rollover_link_overlay').attr('href') || $(this).closest('.quills-coffee-card').find('.quills-coffee-card-link').attr('href');
            if (permalink) {
                window.location.href = permalink;
            }
        });

        // 7b. Open Quick Shop Drawer (Image 2)
        function ensureQuickShopContainers() {
            if ($('#quills-quick-shop-overlay').length === 0) {
                $('body').append('<div class="quills-quick-shop-overlay" id="quills-quick-shop-overlay" aria-hidden="true"></div>');
            }
            if ($('#quills-quick-shop-drawer').length === 0) {
                $('body').append(
                    '<div class="quills-quick-shop-drawer" id="quills-quick-shop-drawer" role="dialog" aria-modal="true" aria-hidden="true">' +
                        '<div class="quills-quick-shop-content" id="quills-quick-shop-content"></div>' +
                    '</div>'
                );
            }
        }

        function openQuickShopDrawer(productId) {
            ensureQuickShopContainers();
            var $drawer = $('#quills-quick-shop-drawer');
            var $overlay = $('#quills-quick-shop-overlay');
            var $content = $('#quills-quick-shop-content');

            $overlay.addClass('is-active').attr('aria-hidden', 'false');
            $drawer.addClass('is-active').attr('aria-hidden', 'false');
            $('body').addClass('quills-drawer-open');

            // Loading skeleton
            $content.html(
                '<div class="quills-qs-loading-skeleton">' +
                    '<div class="quills-qs-spinner"></div>' +
                    '<p>Loading product options...</p>' +
                '</div>'
            );

            $.ajax({
                url: (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'quills_get_quick_shop_drawer',
                    nonce: (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '',
                    product_id: productId
                },
                success: function(resp) {
                    if (resp && resp.success && resp.data && resp.data.html) {
                        $content.html(resp.data.html);
                    } else {
                        $content.html('<div class="quills-qs-loading-skeleton"><p>Could not load product options.</p></div>');
                    }
                },
                error: function() {
                    $content.html('<div class="quills-qs-loading-skeleton"><p>Error loading product details.</p></div>');
                }
            });
        }

        function closeQuickShopDrawer() {
            $('#quills-quick-shop-overlay').removeClass('is-active').attr('aria-hidden', 'true');
            $('#quills-quick-shop-drawer').removeClass('is-active').attr('aria-hidden', 'true');
            if (!$('#quills-cart-drawer').hasClass('is-active')) {
                $('body').removeClass('quills-drawer-open');
            }
        }

        // Trigger Quick Shop Drawer on card button click
        $(document).off('click.quillsQS', '.quills-hover-add-cart').on('click.quillsQS', '.quills-hover-add-cart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            var productId = $(this).data('product-id');
            if (!productId) {
                productId = $(this).closest('.quills-coffee-card').data('product-id');
            }
            if (productId) {
                openQuickShopDrawer(productId);
            }
            return false;
        });

        // Close Quick Shop Drawer Handlers
        $(document).off('click.quillsQSClose', '#quills-qs-close, #quills-quick-shop-overlay').on('click.quillsQSClose', '#quills-qs-close, #quills-quick-shop-overlay', function(e) {
            e.preventDefault();
            closeQuickShopDrawer();
        });

        $(document).on('keydown', function(e) {
            if ((e.key === 'Escape' || e.keyCode === 27) && $('#quills-quick-shop-drawer').hasClass('is-active')) {
                closeQuickShopDrawer();
            }
        });

        // Quick Shop: Size selection & dynamic price
        $(document).on('click', '.quills-qs-size-pill', function(e) {
            e.preventDefault();
            var $wrapper = $(this).closest('.quills-qs-wrapper');
            $wrapper.find('.quills-qs-size-pill').removeClass('active');
            $(this).addClass('active');

            var selectedSize = $(this).data('size') || '12oz';
            $wrapper.find('#quills-qs-selected-size').text(selectedSize);

            var $addBtn = $wrapper.find('#quills-qs-btn-add');
            var basePrice = parseFloat($addBtn.data('base-price')) || 20.00;
            var currentPrice = basePrice;

            if (selectedSize === '5lb') {
                currentPrice = (basePrice === 20.00) ? 105.00 : (basePrice * 5.25);
            } else if (selectedSize === '2lb') {
                currentPrice = (basePrice === 20.00) ? 48.00 : (basePrice * 2.4);
            }

            $wrapper.find('#quills-qs-price').html('$' + currentPrice.toFixed(2));

            // 5lb bags are whole bean only
            var $activeGrind = $wrapper.find('.quills-qs-grind-pill.active');
            if (selectedSize === '5lb') {
                if ($activeGrind.data('grind') !== 'Whole Bean') {
                    $wrapper.find('.quills-qs-grind-pill').removeClass('active');
                    $wrapper.find('.quills-qs-grind-pill[data-grind="Whole Bean"]').addClass('active');
                    $wrapper.find('#quills-qs-selected-grind').text('Whole Bean');
                }
            }
        });

        // Quick Shop: Grind Type selection
        $(document).on('click', '.quills-qs-grind-pill', function(e) {
            e.preventDefault();
            var $wrapper = $(this).closest('.quills-qs-wrapper');
            var selectedSize = $wrapper.find('.quills-qs-size-pill.active').data('size') || '12oz';

            if (selectedSize === '5lb' && $(this).data('grind') !== 'Whole Bean') {
                alert('5lb bags are only available as Whole Bean.');
                return;
            }

            $wrapper.find('.quills-qs-grind-pill').removeClass('active');
            $(this).addClass('active');
            $wrapper.find('#quills-qs-selected-grind').text($(this).data('grind'));
        });

        // Quick Shop: Quantity Stepper
        $(document).on('click', '#quills-qs-qty-minus', function(e) {
            e.preventDefault();
            var $input = $(this).siblings('#quills-qs-qty-input');
            var val = parseInt($input.val(), 10) || 1;
            if (val > 1) {
                $input.val(val - 1);
            }
        });

        $(document).on('click', '#quills-qs-qty-plus', function(e) {
            e.preventDefault();
            var $input = $(this).siblings('#quills-qs-qty-input');
            var val = parseInt($input.val(), 10) || 1;
            $input.val(val + 1);
        });

        // Quick Shop: Add to Cart Action
        $(document).on('click', '#quills-qs-btn-add', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var $wrapper = $btn.closest('.quills-qs-wrapper');
            var productId = $btn.data('product-id');
            var size = $wrapper.find('.quills-qs-size-pill.active').data('size') || '12oz';
            var grind = $wrapper.find('.quills-qs-grind-pill.active').data('grind') || 'Whole Bean';
            var quantity = parseInt($wrapper.find('#quills-qs-qty-input').val(), 10) || 1;

            $btn.prop('disabled', true).find('.quills-qs-btn-text').text('ADDING...');

            $.ajax({
                url: (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'quills_add_to_cart',
                    nonce: (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '',
                    product_id: productId,
                    quantity: quantity,
                    size: size,
                    grind: grind,
                    purchase_type: 'onetime'
                },
                success: function(res) {
                    $btn.find('.quills-qs-btn-text').text('ADDED ✓');
                    setTimeout(function() {
                        $btn.prop('disabled', false).find('.quills-qs-btn-text').text('ADD TO CART');
                        closeQuickShopDrawer();
                        if (res && res.success) {
                            setQuillsCartCount(res.data.cart_count);
                            if (res.data && res.data.drawer_html) {
                                $('#quills-cart-drawer-content').html(res.data.drawer_html);
                                $('#quills-cart-overlay').addClass('is-active').attr('aria-hidden', 'false');
                                $('#quills-cart-drawer').addClass('is-active').attr('aria-hidden', 'false');
                                $('body').addClass('quills-drawer-open');
                            }
                        }
                    }, 400);
                },
                error: function() {
                    $btn.prop('disabled', false).find('.quills-qs-btn-text').text('ADD TO CART');
                    alert('Error adding to cart. Please try again.');
                }
            });
        });

        // Quick Shop: Buy with Shop Pay
        $(document).on('click', '#quills-qs-btn-shop', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var $wrapper = $btn.closest('.quills-qs-wrapper');
            var productId = $btn.data('product-id');
            var checkoutUrl = $btn.data('checkout-url') || '/checkout/';
            var size = $wrapper.find('.quills-qs-size-pill.active').data('size') || '12oz';
            var grind = $wrapper.find('.quills-qs-grind-pill.active').data('grind') || 'Whole Bean';
            var quantity = parseInt($wrapper.find('#quills-qs-qty-input').val(), 10) || 1;

            $.ajax({
                url: (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'quills_add_to_cart',
                    nonce: (typeof quillsData !== 'undefined' && quillsData.nonce) ? quillsData.nonce : '',
                    product_id: productId,
                    quantity: quantity,
                    size: size,
                    grind: grind,
                    purchase_type: 'onetime'
                },
                success: function() {
                    window.location.href = checkoutUrl;
                },
                error: function() {
                    window.location.href = checkoutUrl;
                }
            });
        });

        // AJAX Fetch Function
        function fetchFilteredCoffee() {
            var $productGrid = $('#quills-coffee-grid');
            var $productCount = $('#quills-products-count');
            $productGrid.css('opacity', '0.4');
            var filters = getSelectedFilters();

            $.ajax({
                url: (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) ? quillsData.ajaxUrl : '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'quills_filter_coffee',
                    tab: filters.tab,
                    process: filters.process,
                    roast: filters.roast,
                    sort_by: currentSort
                },
                success: function(res) {
                    if (res && res.success) {
                        $productGrid.html(res.data.html);
                        var count = res.data.count;
                        if (filters.totalChecked > 0) {
                            $productCount.text(count + ' of ' + TOTAL_PRODUCTS + ' products');
                        } else {
                            $productCount.text(TOTAL_PRODUCTS + ' products');
                        }
                    }
                    $productGrid.css('opacity', '1');
                },
                error: function() {
                    $productGrid.css('opacity', '1');
                }
            });
        }

        // 5. Testimonial Sliders
        var topQuotes = [
            { text: '"Heaven in a cup."', author: '— Tracy S.' },
            { text: '"The cleanest pour-over roast in Louisville. Sweet and lively."', author: '— Michael K.' },
            { text: '"Consistently fresh, vibrant and roasted with exceptional care."', author: '— Amanda L.' }
        ];

        $('.quills-slider-dot[data-index]').on('click', function() {
            var idx = parseInt($(this).data('index'), 10);
            $('.quills-slider-dot[data-index]').removeClass('is-active');
            $(this).addClass('is-active');

            if (topQuotes[idx]) {
                $('#quills-quote-text').fadeOut(150, function() {
                    $(this).text(topQuotes[idx].text).fadeIn(150);
                });
                $('#quills-quote-author').fadeOut(150, function() {
                    $(this).text(topQuotes[idx].author).fadeIn(150);
                });
            }
        });

        var bottomQuotes = [
            { text: '"Amazing coffee. Quills is consistently head and shoulders above others."', author: '— Mitchell George' },
            { text: '"Their single-origin Ethiopia Bombe is hands-down the best coffee I had this year."', author: '— Sarah Jenkins' },
            { text: '"Subscribed to Blacksmith espresso for over 2 years now. Never disappointed."', author: '— David R.' }
        ];

        $('.quills-slider-dot[data-bottom-index]').on('click', function() {
            var idx = parseInt($(this).data('bottom-index'), 10);
            $('.quills-slider-dot[data-bottom-index]').removeClass('is-active');
            $(this).addClass('is-active');

            if (bottomQuotes[idx]) {
                $('#quills-bottom-quote-text').fadeOut(150, function() {
                    $(this).text(bottomQuotes[idx].text).fadeIn(150);
                });
            }
        });
    });

})(jQuery);
