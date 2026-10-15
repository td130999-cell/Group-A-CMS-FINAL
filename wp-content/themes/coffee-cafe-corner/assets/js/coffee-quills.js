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

        function getSelectedFilters() {
            var process = $('input[name="filter_process[]"]:checked').map(function() { return this.value; }).get();
            var roast = $('input[name="filter_roast[]"]:checked').map(function() { return this.value; }).get();
            var types = $('input[name="filter_type[]"]:checked').map(function() { return this.value; }).get();
            return {
                process: process,
                roast: roast,
                tab: types
            };
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
                // If single pill click mode preferred, uncheck other pills or toggle
                $pill.addClass('is-active');
                $targetCheckbox.prop('checked', true);
            }

            var filters = getSelectedFilters();
            syncCategoryPills(filters.tab);
            fetchFilteredCoffee();
        });

        // 3. Sidebar Square Checkbox Filters
        $('input[name="filter_process[]"], input[name="filter_roast[]"], input[name="filter_type[]"]').on('change', function() {
            var filters = getSelectedFilters();
            syncCategoryPills(filters.tab);
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
                        $grid.html(res.data.html);
                        if (res.data.total_text) {
                            $count.text(res.data.total_text);
                        } else {
                            $count.text(res.data.count + (res.data.count === 1 ? ' product' : ' products'));
                        }
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
