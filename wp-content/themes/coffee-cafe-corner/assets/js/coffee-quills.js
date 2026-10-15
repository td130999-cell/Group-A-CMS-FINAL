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

        function onFiltersChanged() {
            var filters = getSelectedFilters();
            updateActiveFilterTags();
            updateAccordionHeaderCounts();
            syncCategoryPills(filters.tab);
            fetchFilteredCoffee();
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
                $pill.addClass('is-active');
                $targetCheckbox.prop('checked', true);
            }

            onFiltersChanged();
        });

        // 3. Sidebar Square Checkbox Filters
        $('input[name="filter_process[]"], input[name="filter_roast[]"], input[name="filter_type[]"]').on('change', function() {
            onFiltersChanged();
        });

        // 4. Click individual active filter tag to remove it
        $(document).on('click', '.quills-filter-tag', function(e) {
            e.preventDefault();
            var name = $(this).data('target-name');
            var val = $(this).data('target-val');
            $('input[name="' + name + '"][value="' + val + '"]').prop('checked', false);
            onFiltersChanged();
        });

        // 5. Click "Remove all" to clear all active filters
        $('#quills-filters-remove-all').on('click', function(e) {
            e.preventDefault();
            $('input[name^="filter_"]').prop('checked', false);
            $('.quills-category-pill').removeClass('is-active');
            onFiltersChanged();
        });

        // 6. Sort Dropdown
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
                        var count = res.data.count;
                        if (filters.totalChecked > 0) {
                            $count.text(count + ' of ' + TOTAL_PRODUCTS + ' products');
                        } else {
                            $count.text(TOTAL_PRODUCTS + ' products');
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
