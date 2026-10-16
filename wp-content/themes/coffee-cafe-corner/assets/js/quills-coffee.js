/**
 * Quills Coffee Complete Interactive Engine
 * Handling Single Product, Faceted Filters, and Judge.me Style Reviews
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // ==========================================
        // 1. PRODUCT GALLERY (Thumbnails switch)
        // ==========================================
        $('.quills-thumb').on('click', function() {
            var fullUrl = $(this).data('full');
            if (fullUrl) {
                $('.quills-thumb').removeClass('active');
                $(this).addClass('active');

                var $mainImg = $('#quills-main-image');
                $mainImg.css('opacity', '0.4');
                setTimeout(function() {
                    $mainImg.attr('src', fullUrl).css('opacity', '1');
                }, 150);
            }
        });

        // ==========================================
        // 2. PRODUCT OPTIONS (Size & Grind & Price)
        // ==========================================
        var basePrice = parseFloat($('#quills-btn-add-to-cart').data('base-price')) || 20.00;

        function getPriceForSize(size) {
            if (size === '5lb') {
                return (basePrice === 20.00) ? 105.00 : (basePrice * 5.25);
            } else if (size === '2lb') {
                return (basePrice === 20.00) ? 48.00 : (basePrice * 2.4);
            }
            return basePrice;
        }

        function checkAvailability() {
            var selectedSize = $('#quills-size-group .quills-pill-btn.active').data('size') || '12oz';
            var $activeGrind = $('#quills-grind-group .quills-pill-btn.active');
            var selectedGrind = $activeGrind.data('grind') || 'Whole Bean';

            var $addBtn = $('#quills-btn-add-to-cart');
            var $shopBtn = $('#quills-btn-shop-pay');

            if (selectedSize === '5lb') {
                if (selectedGrind !== 'Whole Bean') {
                    // 5lb bags only available as Whole Bean
                    $activeGrind.addClass('is-unavailable');
                    $addBtn.addClass('is-unavailable').prop('disabled', true);
                    $addBtn.find('.quills-btn-text').text('UNAVAILABLE');
                    $shopBtn.addClass('is-disabled');
                } else {
                    $('#quills-grind-group .quills-pill-btn').removeClass('is-unavailable');
                    $addBtn.removeClass('is-unavailable').prop('disabled', false);
                    $addBtn.find('.quills-btn-text').text('ADD TO CART');
                    $shopBtn.removeClass('is-disabled');
                }
            } else {
                $('#quills-grind-group .quills-pill-btn').removeClass('is-unavailable');
                $addBtn.removeClass('is-unavailable').prop('disabled', false);
                $addBtn.find('.quills-btn-text').text('ADD TO CART');
                $shopBtn.removeClass('is-disabled');
            }
        }

        function updatePrice() {
            var selectedSize = $('#quills-size-group .quills-pill-btn.active').data('size') || '12oz';
            var currentPrice = getPriceForSize(selectedSize);
            var subPrice = currentPrice * 0.9;

            var fmtCurrent = '$' + currentPrice.toFixed(2);
            var fmtSub = '$' + subPrice.toFixed(2);

            $('#quills-dynamic-price').text(fmtCurrent);
            $('#quills-onetime-price-label').html(fmtCurrent + ' <small>each</small>');
            $('#quills-subscribe-price-label').html('<del>' + fmtCurrent + '</del> <strong>' + fmtSub + '</strong> <small>each</small>');

            checkAvailability();
        }

        // Size Pill Click
        $('#quills-size-group .quills-pill-btn').on('click', function() {
            $('#quills-size-group .quills-pill-btn').removeClass('active');
            $(this).addClass('active');
            $('#quills-selected-size-label').text($(this).data('size'));
            updatePrice();
        });

        // Grind Pill Click
        $('#quills-grind-group .quills-pill-btn').on('click', function() {
            $('#quills-grind-group .quills-pill-btn').removeClass('active');
            $(this).addClass('active');
            $('#quills-selected-grind-label').text($(this).data('grind'));
            checkAvailability();
        });

        // Description Accordion Toggle
        $('#quills-desc-toggle').on('click', function() {
            var $wrap = $(this).closest('.quills-desc-accordion-wrapper');
            var isOpen = $wrap.hasClass('is-open');
            if (isOpen) {
                $wrap.removeClass('is-open');
                $('#quills-desc-content').slideUp(200);
                $(this).find('.quills-desc-icon').text('+');
                $(this).attr('aria-expanded', 'false');
            } else {
                $wrap.addClass('is-open');
                $('#quills-desc-content').slideDown(200);
                $(this).find('.quills-desc-icon').text('—');
                $(this).attr('aria-expanded', 'true');
            }
        });

        // Purchase Type (Subscription Radio & Drawer)
        $('.quills-sub-option').on('click', function() {
            var $opt = $(this);
            var $radio = $opt.find('input[type="radio"]');
            $radio.prop('checked', true);
            $('.quills-sub-option').removeClass('active');
            $opt.addClass('active');

            if ($radio.val() === 'subscribe') {
                $('#quills-sub-drawer').slideDown(200);
            } else {
                $('#quills-sub-drawer').slideUp(200);
            }
        });

        // Frequency Pill Click
        $('.quills-freq-pill').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('.quills-freq-pill').removeClass('is-selected');
            $(this).addClass('is-selected');
        });

        // Top Testimonial Slider (Image 2)
        var spQuotes = [
            { text: '"Inkwell is roasted to perfection, tastes great every time."', author: '— Nathan Rzasa' },
            { text: '"One cup is all it took, and we were hooked! Our daily go-to coffee."', author: '— Brianne E.' },
            { text: '"Quills has the best coffee and exceptional roaster quality! 5 stars!!!"', author: '— Tracy S.' }
        ];
        var curSpQuote = 0;

        function setSpQuote(idx) {
            curSpQuote = (idx + spQuotes.length) % spQuotes.length;
            var q = spQuotes[curSpQuote];
            $('#quills-sp-quote-text').fadeOut(120, function() {
                $(this).text(q.text).fadeIn(120);
            });
            $('#quills-sp-quote-author').fadeOut(120, function() {
                $(this).text(q.author).fadeIn(120);
            });
            $('.quills-sp-dot').removeClass('is-active').eq(curSpQuote).addClass('is-active');
        }

        $('#quills-sp-prev').on('click', function() {
            setSpQuote(curSpQuote - 1);
        });
        $('#quills-sp-next').on('click', function() {
            setSpQuote(curSpQuote + 1);
        });
        $('.quills-sp-dot').on('click', function() {
            var idx = parseInt($(this).data('idx'), 10) || 0;
            setSpQuote(idx);
        });

        // Quantity Stepper
        $('#quills-qty-minus').on('click', function() {
            var $input = $('#quills-qty-input');
            var val = parseInt($input.val(), 10) || 1;
            if (val > 1) {
                $input.val(val - 1);
            }
        });

        $('#quills-qty-plus').on('click', function() {
            var $input = $('#quills-qty-input');
            var val = parseInt($input.val(), 10) || 1;
            $input.val(val + 1);
        });

        // Add to Cart via AJAX
        $('#quills-btn-add-to-cart').on('click', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var qty = parseInt($('#quills-qty-input').val(), 10) || 1;
            var size = $('#quills-size-group .quills-pill-btn.active').data('size') || '12oz';
            var grind = $('#quills-grind-group .quills-pill-btn.active').data('grind') || 'Whole Bean';
            var purchaseType = $('input[name="quills_purchase_type"]:checked').val() || 'onetime';

            $btn.addClass('loading');

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_add_to_cart',
                    nonce: quillsData.nonce,
                    product_id: productId,
                    quantity: qty,
                    size: size,
                    grind: grind,
                    purchase_type: purchaseType
                },
                success: function(resp) {
                    $btn.removeClass('loading');
                    if (resp.success) {
                        $('#quills-cart-badge').text(resp.data.cart_count);
                        var $toast = $('#quills-cart-toast');
                        $toast.fadeIn(300);
                        setTimeout(function() {
                            $toast.fadeOut(400);
                        }, 5000);
                    } else {
                        alert(resp.data ? resp.data.message : 'Could not add to cart.');
                    }
                },
                error: function() {
                    $btn.removeClass('loading');
                    alert('Network error adding to cart.');
                }
            });
        });

        // ==========================================
        // 3. ACCORDIONS / DETAILS COLLAPSIBLES
        // ==========================================
        $('.quills-accordion-header').on('click', function() {
            var $item = $(this).closest('.quills-accordion-item');
            var isOpen = $item.hasClass('open');
            if (isOpen) {
                $item.removeClass('open');
                $(this).find('.quills-acc-icon').text('+');
            } else {
                $item.addClass('open');
                $(this).find('.quills-acc-icon').text('−');
            }
        });

        // ==========================================
        // 4. REVIEWS SYSTEM (Judge.me Parity)
        // ==========================================
        // Toggle Write Review Form
        $('#quills-toggle-review-form, #quills-cancel-review-btn').on('click', function() {
            $('#quills-review-form-container').slideToggle(300);
        });

        // Interactive Star Rating Picker
        var ratingTexts = {
            1: '1 / 5 (Poor)',
            2: '2 / 5 (Fair)',
            3: '3 / 5 (Average)',
            4: '4 / 5 (Good)',
            5: '5 / 5 (Outstanding)'
        };

        $('.quills-star-item').on('mouseenter', function() {
            var hoverVal = parseInt($(this).data('val'), 10);
            $('.quills-star-item').each(function() {
                var v = parseInt($(this).data('val'), 10);
                if (v <= hoverVal) {
                    $(this).addClass('hover');
                } else {
                    $(this).removeClass('hover');
                }
            });
        }).on('mouseleave', function() {
            $('.quills-star-item').removeClass('hover');
        }).on('click', function() {
            var selectedVal = parseInt($(this).data('val'), 10);
            $('#quills-input-rating').val(selectedVal);
            $('#quills-rating-text').text(ratingTexts[selectedVal] || selectedVal + ' / 5');

            $('.quills-star-item').each(function() {
                var v = parseInt($(this).data('val'), 10);
                if (v <= selectedVal) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });
        });

        // Submit Review via AJAX
        $('#quills-submit-review-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $submitBtn = $('#quills-submit-review-btn');
            var $feedback = $('#quills-review-feedback');

            $submitBtn.prop('disabled', true).find('span').text('Submitting...');
            $feedback.text('').css('color', '#333');

            var formData = $form.serializeArray();
            formData.push({ name: 'action', value: 'quills_submit_review' });
            formData.push({ name: 'nonce', value: quillsData.nonce });

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: $.param(formData),
                success: function(resp) {
                    $submitBtn.prop('disabled', false).find('span').text('Submit Review');
                    if (resp.success) {
                        $feedback.text(resp.data.message).css('color', '#2e7d32');
                        
                        // Insert new review card on the fly!
                        var rating = parseInt($('#quills-input-rating').val(), 10) || 5;
                        var starsStr = '★'.repeat(rating) + '☆'.repeat(5 - rating);
                        var author = $('#quills-review-author').val() || 'Customer';
                        var title = $('#quills-review-title').val() || '';
                        var content = $('#quills-review-content').val() || '';
                        var initial = author.charAt(0).toUpperCase() || 'C';
                        var filledStars = '<span class="star filled">★</span>'.repeat(rating);
                        var emptyStars = '<span class="star empty">★</span>'.repeat(5 - rating);
                        var newCardHtml = `
                            <div class="quills-review-item-v2" data-rating="${rating}" style="background-color: #f7f3ea; padding: 16px; border-radius: 6px;">
                                <div class="quills-review-item-stars">
                                    ${filledStars}${emptyStars}
                                </div>
                                <div class="quills-review-item-author-row">
                                    <span class="quills-author-avatar-circle">${initial}</span>
                                    <span class="quills-author-name-text">${author}</span>
                                    <span class="quills-verified-pill">Verified</span>
                                    <span class="quills-review-date-text">Just now</span>
                                </div>
                                <div class="quills-review-item-text">
                                    ${content}
                                </div>
                            </div>
                        `;

                        $('.quills-no-reviews').remove();
                        $('#quills-reviews-list').prepend(newCardHtml);

                        setTimeout(function() {
                            $form[0].reset();
                            $('#quills-review-form-container').slideUp(300);
                        }, 2000);

                    } else {
                        $feedback.text(resp.data ? resp.data.message : 'Error submitting review.').css('color', '#c0392b');
                    }
                },
                error: function() {
                    $submitBtn.prop('disabled', false).find('span').text('Submit Review');
                    $feedback.text('Connection error. Please try again.').css('color', '#c0392b');
                }
            });
        });

        // Filter Reviews by Star
        $('.quills-filter-tab').on('click', function() {
            $('.quills-filter-tab').removeClass('active');
            $(this).addClass('active');

            var filter = $(this).data('filter');
            $('.quills-review-card').each(function() {
                var r = $(this).data('rating');
                if (filter === 'all' || String(r) === String(filter)) {
                    $(this).fadeIn(200);
                } else {
                    $(this).fadeOut(200);
                }
            });
        });

        // Sort Reviews
        $('#quills-sort-reviews-select').on('change', function() {
            var sortMode = $(this).val();
            var $list = $('#quills-reviews-list');
            var $items = $list.children('.quills-review-card').get();

            $items.sort(function(a, b) {
                var rA = parseInt($(a).data('rating'), 10) || 5;
                var rB = parseInt($(b).data('rating'), 10) || 5;
                var hA = parseInt($(a).data('helpful'), 10) || 0;
                var hB = parseInt($(b).data('helpful'), 10) || 0;

                if (sortMode === 'highest') {
                    return rB - rA;
                } else if (sortMode === 'helpful') {
                    return hB - hA;
                }
                return 0; // default recent
            });

            $.each($items, function(i, itm) {
                $list.append(itm);
            });
        });

        // Vote Review Helpful
        $(document).on('click', '.quills-btn-vote', function() {
            var $btn = $(this);
            var commentId = $btn.data('id');
            if ($btn.hasClass('voted')) return;

            var $countSpan = $btn.find('.vote-count');
            var currentVotes = parseInt($countSpan.text(), 10) || 0;
            $countSpan.text(currentVotes + 1);
            $btn.addClass('voted').css({'background': '#2e7d32', 'color': '#fff', 'border-color': '#2e7d32'});

            if (commentId) {
                $.post(quillsData.ajaxUrl, {
                    action: 'quills_vote_review',
                    nonce: quillsData.nonce,
                    comment_id: commentId
                });
            }
        });

        // ==========================================
        // 5. FACETED LIVE FILTERS (Collection Page)
        // ==========================================
        // Toggle Sidebar Filter Groups (+ / -)
        $('.quills-filter-group__header').on('click', function() {
            var $group = $(this).closest('.quills-filter-group');
            $group.toggleClass('open');
            var isOpen = $group.hasClass('open');
            $(this).find('.quills-filter-toggle-icon').text(isOpen ? '−' : '+');
            $group.find('.quills-filter-group__body').slideToggle(200);
        });

        function triggerFilter() {
            var $loader = $('#quills-grid-loader');
            $loader.fadeIn(150);

            var processes = [];
            $('input[name="process[]"]:checked').each(function() {
                processes.push($(this).val());
            });

            var roasts = [];
            $('input[name="roast[]"]:checked').each(function() {
                roasts.push($(this).val());
            });

            var types = [];
            $('input[name="type[]"]:checked').each(function() {
                types.push($(this).val());
            });

            var prices = [];
            $('input[name="price[]"]:checked').each(function() {
                prices.push($(this).val());
            });

            var orderby = $('#quills-sort-select').val() || 'featured';

            // Render Active Facet Tags
            var $facetsContainer = $('#quills-active-facets');
            $facetsContainer.empty();

            var allActive = [];
            processes.forEach(function(p) { allActive.push({ type: 'process', label: p }); });
            roasts.forEach(function(r) { allActive.push({ type: 'roast', label: r + ' Roast' }); });
            types.forEach(function(t) { allActive.push({ type: 'type', label: t }); });
            prices.forEach(function(pr) { allActive.push({ type: 'price', label: pr }); });

            if (allActive.length > 0) {
                allActive.forEach(function(item) {
                    var $pill = $('<div class="quills-active-pill" data-type="' + item.type + '" data-label="' + item.label + '">' + item.label + ' <span>✕</span></div>');
                    $facetsContainer.append($pill);
                });
            }

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_filter_products',
                    nonce: quillsData.nonce,
                    processes: processes,
                    roasts: roasts,
                    types: types,
                    prices: prices,
                    orderby: orderby
                },
                success: function(resp) {
                    $loader.fadeOut(150);
                    if (resp.success) {
                        $('#quills-products-container').html(resp.data.html);
                        $('#quills-results-count').html('Showing <strong>' + resp.data.count + '</strong> coffees');
                    }
                },
                error: function() {
                    $loader.fadeOut(150);
                }
            });
        }

        // Filter Form Inputs Change
        $('#quills-filter-form input[type="checkbox"]').on('change', function() {
            triggerFilter();
        });

        // Sort By Change
        $('#quills-sort-select').on('change', function() {
            triggerFilter();
        });

        // Remove active facet tag on click
        $(document).on('click', '.quills-active-pill', function() {
            var label = $(this).data('label');
            $('#quills-filter-form input[type="checkbox"]').each(function() {
                if ($(this).val() === label || $(this).val() + ' Roast' === label) {
                    $(this).prop('checked', false);
                }
            });
            triggerFilter();
        });

        // Clear All Filters Buttons
        $('#quills-clear-all-sidebar, $(document).on("click", "#quills-clear-all-empty")').on('click', function(e) {
            e.preventDefault();
            $('#quills-filter-form input[type="checkbox"]').prop('checked', false);
            triggerFilter();
        });

    });

})(jQuery);
