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
        var basePrice = parseFloat($('#quills-btn-add-to-cart').data('base-price')) || 23.00;

        function updatePrice() {
            var $activeSize = $('#quills-size-group .quills-pill-btn.active');
            var multiplier = parseFloat($activeSize.data('multiplier')) || 1.0;
            var currentPrice = basePrice * multiplier;
            var subPrice = currentPrice * 0.9;

            var fmtCurrent = '$' + currentPrice.toFixed(2);
            var fmtSub = '$' + subPrice.toFixed(2);

            $('#quills-dynamic-price').text(fmtCurrent);
            $('#quills-onetime-price-label').text(fmtCurrent);
            $('#quills-subscribe-price-label').text(fmtSub);
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
        });

        // Purchase Type (Subscription Radio)
        $('input[name="quills_purchase_type"]').on('change', function() {
            $('.quills-sub-option').removeClass('active');
            $(this).closest('.quills-sub-option').addClass('active');
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
                        var brew = $('#quills-review-brew').val() || 'Pour Over';

                        var newCardHtml = `
                            <div class="quills-review-card" data-rating="${rating}" data-helpful="1" style="border-left: 4px solid #2e7d32;">
                                <div class="quills-review-card__header">
                                    <div class="quills-author-box">
                                        <span class="quills-author-name">${author}</span>
                                        <span class="quills-verified-badge">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                            Verified Buyer
                                        </span>
                                    </div>
                                    <div class="quills-review-date">Just now</div>
                                </div>
                                <div class="quills-review-card__meta">
                                    <div class="quills-stars quills-stars--card">${starsStr}</div>
                                    <span class="quills-brew-pill">Brewed with: ${brew}</span>
                                </div>
                                <h4 class="quills-review-item-title">${title}</h4>
                                <div class="quills-review-item-body"><p>${content}</p></div>
                                <div class="quills-review-card__footer">
                                    <span class="quills-helpful-label">Was this review helpful?</span>
                                    <button type="button" class="quills-btn-vote">👍 <span class="vote-count">1</span></button>
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
