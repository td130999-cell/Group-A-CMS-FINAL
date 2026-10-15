/**
 * Quills Coffee - Subscriptions Interactive Script
 *
 * @package Coffee_Cafe_Corner
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // --- 1. Top Testimonial Slider ---
        var $topSlider = $('#quills-top-testimonial-slider');
        if ($topSlider.length) {
            var $topSlides = $topSlider.find('.quills-sub-slide');
            var $topDots   = $topSlider.find('.quills-sub-dot');
            var topTimer   = null;
            var topIndex   = 0;
            var topCount   = $topSlides.length;

            function goToTopSlide(index) {
                topIndex = (index + topCount) % topCount;
                $topSlides.removeClass('is-active').eq(topIndex).addClass('is-active');
                $topDots.removeClass('is-active').eq(topIndex).addClass('is-active');
            }

            $topDots.on('click', function() {
                var idx = parseInt($(this).data('slide'), 10);
                goToTopSlide(idx);
                resetTopTimer();
            });

            function startTopTimer() {
                topTimer = setInterval(function() {
                    goToTopSlide(topIndex + 1);
                }, 6000);
            }

            function resetTopTimer() {
                if (topTimer) clearInterval(topTimer);
                startTopTimer();
            }

            startTopTimer();
        }

        // --- 2. Bottom Testimonial Slider ---
        var $botSlider = $('#quills-bottom-testimonial-slider');
        if ($botSlider.length) {
            var $botSlides = $botSlider.find('.quills-sub-bottom-slide');
            var $botDots   = $botSlider.find('.quills-sub-bottom-dot');
            var botTimer   = null;
            var botIndex   = 0;
            var botCount   = $botSlides.length;

            function goToBotSlide(index) {
                botIndex = (index + botCount) % botCount;
                $botSlides.removeClass('is-active').eq(botIndex).addClass('is-active');
                $botDots.removeClass('is-active').eq(botIndex).addClass('is-active');
            }

            $botDots.on('click', function() {
                var idx = parseInt($(this).data('slide'), 10);
                goToBotSlide(idx);
                resetBotTimer();
            });

            function startBotTimer() {
                botTimer = setInterval(function() {
                    goToBotSlide(botIndex + 1);
                }, 7000);
            }

            function resetBotTimer() {
                if (botTimer) clearInterval(botTimer);
                startBotTimer();
            }

            startBotTimer();
        }

        // --- 3. Filter Drawer Toggle ---
        var $filterBtn      = $('#quills-sub-filter-btn');
        var $filterDrawer   = $('#quills-sub-filter-drawer');
        var $filterBackdrop = $('#quills-sub-filter-backdrop');
        var $filterClose    = $('#quills-sub-filter-close');

        function openFilter() {
            $filterDrawer.addClass('is-open').attr('aria-hidden', 'false');
            $filterBackdrop.addClass('is-open');
            $filterBtn.attr('aria-expanded', 'true');
        }

        function closeFilter() {
            $filterDrawer.removeClass('is-open').attr('aria-hidden', 'true');
            $filterBackdrop.removeClass('is-open');
            $filterBtn.attr('aria-expanded', 'false');
        }

        $filterBtn.on('click', openFilter);
        $filterClose.on('click', closeFilter);
        $filterBackdrop.on('click', closeFilter);

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $filterDrawer.hasClass('is-open')) {
                closeFilter();
            }
        });

        // --- 4. Live Sorting (AJAX with URL state preservation) ---
        var $sortSelect = $('#quills-sub-sort-select');
        var $grid       = $('#quills-sub-product-grid');
        var $count      = $('#quills-sub-count');

        $sortSelect.on('change', function() {
            var sortBy = $(this).val();

            // Update URL without page reload
            var newUrl = new URL(window.location.href);
            newUrl.searchParams.set('sort_by', sortBy);
            window.history.pushState({ sort_by: sortBy }, '', newUrl.toString());

            if (typeof quillsData !== 'undefined' && quillsData.ajaxUrl) {
                $grid.addClass('is-loading');

                $.ajax({
                    url: quillsData.ajaxUrl,
                    type: 'GET',
                    data: {
                        action: 'quills_filter_subscriptions',
                        sort_by: sortBy
                    },
                    success: function(response) {
                        $grid.removeClass('is-loading');
                        if (response && response.success) {
                            $grid.html(response.data.html);
                            if (response.data.count !== undefined) {
                                $count.text(response.data.count + ' products');
                            }
                        }
                    },
                    error: function() {
                        $grid.removeClass('is-loading');
                        // Fallback reload
                        window.location.href = newUrl.toString();
                    }
                });
            } else {
                window.location.href = newUrl.toString();
            }
        });

    });
})(jQuery);
