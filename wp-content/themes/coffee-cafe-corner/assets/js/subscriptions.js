/**
 * Quills Coffee - Subscriptions Interactive Script
 *
 * @package Coffee_Cafe_Corner
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        var $grid = $('#quills-sub-grid');

        // Client-side sorting for Subscriptions
        $('#quills-sub-sort-select').on('change', function() {
            var sortType = $(this).val();
            var $cards = $grid.children('.quills-sub-card').get();

            $cards.sort(function(a, b) {
                var titleA = $(a).find('.quills-sub-card-title').text().trim().toLowerCase();
                var titleB = $(b).find('.quills-sub-card-title').text().trim().toLowerCase();
                var priceA = parseFloat($(a).find('.quills-sub-card-price').text().replace(/[^0-9.]/g, '')) || 20.0;
                var priceB = parseFloat($(b).find('.quills-sub-card-price').text().replace(/[^0-9.]/g, '')) || 20.0;

                if (sortType === 'title-ascending') {
                    return titleA.localeCompare(titleB);
                } else if (sortType === 'title-descending') {
                    return titleB.localeCompare(titleA);
                } else if (sortType === 'price-ascending') {
                    return priceA - priceB;
                } else if (sortType === 'price-descending') {
                    return priceB - priceA;
                }
                return 0;
            });

            $.each($cards, function(idx, item) {
                $grid.append(item);
            });
        });

        // Filter button feedback
        $('#quills-sub-filter-btn').on('click', function() {
            $(this).css('transform', 'scale(0.95)');
            var self = this;
            setTimeout(function() {
                $(self).css('transform', 'scale(1)');
            }, 150);
        });
    });
})(jQuery);
