/**
 * Quills Coffee - Coffee Collection Script
 * 
 * Handles:
 * - Live AJAX category tabs & process filtering
 * - Live sorting without full page reload
 * - Testimonial quote sliders
 * - Quick Add To Cart AJAX handling
 *
 * @package Coffee_Cafe_Corner
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        var $grid = $('#quills-coffee-grid');
        var $count = $('#quills-products-count');
        var currentTab = 'all';
        var currentProcess = 'all';
        var currentSort = 'manual';

        // 1. Process Dropdown Toggle
        $('#quills-process-toggle').on('click', function(e) {
            e.stopPropagation();
            var $menu = $('#quills-process-menu');
            var isOpen = $menu.hasClass('is-open');
            $menu.toggleClass('is-open', !isOpen);
            $(this).attr('aria-expanded', !isOpen);
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.quills-process-dropdown-wrapper').length) {
                $('#quills-process-menu').removeClass('is-open');
                $('#quills-process-toggle').attr('aria-expanded', 'false');
            }
        });

        // 2. Filter Tabs
        $('.quills-tab-btn').on('click', function() {
            var $btn = $(this);
            $('.quills-tab-btn').removeClass('is-active');
            $btn.addClass('is-active');
            currentTab = $btn.data('tab');
            fetchFilteredCoffee();
        });

        // 3. Process Options
        $('.quills-process-option').on('click', function() {
            var $opt = $(this);
            $('.quills-process-option').removeClass('is-active');
            $opt.addClass('is-active');
            currentProcess = $opt.data('process');
            $('#quills-process-menu').removeClass('is-open');
            $('#quills-process-toggle').attr('aria-expanded', 'false');
            fetchFilteredCoffee();
        });

        // 4. Sort Dropdown
        $('#quills-coffee-sort-select').on('change', function() {
            currentSort = $(this).val();
            fetchFilteredCoffee();
        });

        // AJAX Fetch Function
        function fetchFilteredCoffee() {
            $grid.css('opacity', '0.4');

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_filter_coffee',
                    tab: currentTab,
                    process: currentProcess,
                    sort_by: currentSort
                },
                success: function(res) {
                    if (res && res.success) {
                        $grid.html(res.data.html);
                        $count.text(res.data.count + (res.data.count === 1 ? ' product' : ' products'));
                    }
                    $grid.css('opacity', '1');
                },
                error: function() {
                    $grid.css('opacity', '1');
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
            var q = topQuotes[idx] || topQuotes[0];
            $('#quills-quote-text').css('opacity', 0);
            $('#quills-quote-author').css('opacity', 0);
            setTimeout(function() {
                $('#quills-quote-text').text(q.text).css('opacity', 1);
                $('#quills-quote-author').text(q.author).css('opacity', 1);
            }, 200);
        });

        var bottomQuotes = [
            { text: '"Amazing coffee. Quills is consistently head and shoulders above others."', author: '— Mitchell George' },
            { text: '"Their single-origin coffees rival the finest roasters anywhere in the country."', author: '— Coffee Review Daily' },
            { text: '"Subscribing to Inkwell was the best morning upgrade I\'ve ever made."', author: '— Daniel P.' }
        ];

        $('.quills-slider-dot[data-bottom-index]').on('click', function() {
            var idx = parseInt($(this).data('bottom-index'), 10);
            $('.quills-slider-dot[data-bottom-index]').removeClass('is-active');
            $(this).addClass('is-active');
            var q = bottomQuotes[idx] || bottomQuotes[0];
            $('#quills-bottom-quote-text').css('opacity', 0);
            $('#quills-bottom-quote-author').css('opacity', 0);
            setTimeout(function() {
                $('#quills-bottom-quote-text').text(q.text).css('opacity', 1);
                $('#quills-bottom-quote-author').text(q.author).css('opacity', 1);
            }, 200);
        });

        // 6. Quick Add to Cart AJAX
        $(document).on('click', '.quills-quick-add-btn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var originalText = $btn.text();

            $btn.prop('disabled', true).text('ADDING...');

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'woocommerce_add_to_cart',
                    product_id: productId,
                    quantity: 1
                },
                success: function() {
                    $btn.text('ADDED ✓');
                    // Update header cart count badge if available
                    var $badge = $('.quills-cart-badge');
                    if ($badge.length) {
                        var c = parseInt($badge.first().text(), 10) || 0;
                        $badge.text(c + 1);
                    }
                    setTimeout(function() {
                        $btn.prop('disabled', false).text(originalText);
                    }, 1500);
                },
                error: function() {
                    $btn.prop('disabled', false).text(originalText);
                }
            });
        });
    });
})(jQuery);
