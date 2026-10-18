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
            var $topPrev   = $topSlider.find('.quills-sub-nav-prev');
            var $topNext   = $topSlider.find('.quills-sub-nav-next');
            var topTimer   = null;
            var topIndex   = 0;
            var topCount   = $topSlides.length;

            function updateTopNavState() {
                if (topIndex === 0) {
                    $topPrev.addClass('is-disabled');
                } else {
                    $topPrev.removeClass('is-disabled');
                }

                if (topIndex === topCount - 1) {
                    $topNext.addClass('is-disabled');
                } else {
                    $topNext.removeClass('is-disabled');
                }
            }

            function goToTopSlide(index) {
                if (index < 0) {
                    index = 0;
                } else if (index >= topCount) {
                    index = topCount - 1;
                }
                topIndex = index;
                $topSlides.removeClass('is-active').eq(topIndex).addClass('is-active');
                $topDots.removeClass('is-active').eq(topIndex).addClass('is-active');
                updateTopNavState();
            }

            $topDots.on('click', function() {
                var idx = parseInt($(this).data('slide'), 10);
                goToTopSlide(idx);
                resetTopTimer();
            });

            $topPrev.on('click', function(e) {
                e.preventDefault();
                if (topIndex > 0) {
                    goToTopSlide(topIndex - 1);
                    resetTopTimer();
                }
            });

            $topNext.on('click', function(e) {
                e.preventDefault();
                if (topIndex < topCount - 1) {
                    goToTopSlide(topIndex + 1);
                    resetTopTimer();
                }
            });

            function startTopTimer() {
                topTimer = setInterval(function() {
                    var nextIdx = topIndex + 1;
                    if (nextIdx >= topCount) {
                        nextIdx = 0;
                    }
                    goToTopSlide(nextIdx);
                }, 6000);
            }

            function resetTopTimer() {
                if (topTimer) clearInterval(topTimer);
                startTopTimer();
            }

            $topSlider.on('mouseenter', function() {
                if (topTimer) {
                    clearInterval(topTimer);
                    topTimer = null;
                }
            }).on('mouseleave', function() {
                resetTopTimer();
            });

            updateTopNavState();
            startTopTimer();
        }

        // --- 2. Bottom Testimonial Slider ---
        var $botSlider = $('#quills-bottom-testimonial-slider');
        if ($botSlider.length) {
            var $botSlides = $botSlider.find('.quills-sub-bottom-slide');
            var $botDots   = $botSlider.find('.quills-sub-bottom-dot');
            var $botPrev   = $botSlider.find('.quills-sub-nav-prev');
            var $botNext   = $botSlider.find('.quills-sub-nav-next');
            var botTimer   = null;
            var botIndex   = 0;
            var botCount   = $botSlides.length;

            function updateBotNavState() {
                if (botIndex === 0) {
                    $botPrev.addClass('is-disabled');
                } else {
                    $botPrev.removeClass('is-disabled');
                }

                if (botIndex === botCount - 1) {
                    $botNext.addClass('is-disabled');
                } else {
                    $botNext.removeClass('is-disabled');
                }
            }

            function goToBotSlide(index) {
                if (index < 0) {
                    index = 0;
                } else if (index >= botCount) {
                    index = botCount - 1;
                }
                botIndex = index;
                $botSlides.removeClass('is-active').eq(botIndex).addClass('is-active');
                $botDots.removeClass('is-active').eq(botIndex).addClass('is-active');
                updateBotNavState();
            }

            $botDots.on('click', function() {
                var idx = parseInt($(this).data('slide'), 10);
                goToBotSlide(idx);
                resetBotTimer();
            });

            $botPrev.on('click', function(e) {
                e.preventDefault();
                if (botIndex > 0) {
                    goToBotSlide(botIndex - 1);
                    resetBotTimer();
                }
            });

            $botNext.on('click', function(e) {
                e.preventDefault();
                if (botIndex < botCount - 1) {
                    goToBotSlide(botIndex + 1);
                    resetBotTimer();
                }
            });

            function startBotTimer() {
                botTimer = setInterval(function() {
                    var nextIdx = botIndex + 1;
                    if (nextIdx >= botCount) {
                        nextIdx = 0;
                    }
                    goToBotSlide(nextIdx);
                }, 7000);
            }

            function resetBotTimer() {
                if (botTimer) clearInterval(botTimer);
                startBotTimer();
            }

            $botSlider.on('mouseenter', function() {
                if (botTimer) {
                    clearInterval(botTimer);
                    botTimer = null;
                }
            }).on('mouseleave', function() {
                resetBotTimer();
            });

            updateBotNavState();
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

        // --- 5. Direct Navigation on Product Media / Rollover Click ---
        $(document).on('click', '.quills-product-media, .rollover_inner', function(e) {
            // If the user directly clicked an anchor link, let standard browser navigation proceed
            if ($(e.target).closest('a').length) {
                return;
            }
            var $card = $(this).closest('.quills-product-card');
            var permalink = $(this).data('permalink') ||
                            $(this).find('.rollover_link_overlay').attr('href') ||
                            $card.find('.quills-product-title a').attr('href') ||
                            $card.find('.quills-product-image-link').attr('href');
            if (permalink) {
                window.location.href = permalink;
            }
        });

    });
})(jQuery);
