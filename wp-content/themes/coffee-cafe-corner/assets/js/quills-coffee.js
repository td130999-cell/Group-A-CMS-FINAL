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

        // Purchase Type (Cards Selection - Drawer always visible like live Quills site)
        $('.quills-sub-option').on('click', function(e) {
            var $opt = $(this);
            var $radio = $opt.find('input[type="radio"]');
            $radio.prop('checked', true);
            $('.quills-sub-option').removeClass('active');
            $opt.addClass('active');
        });

        // Frequency Pill Click (also activates Subscribe option)
        $('.quills-freq-pill').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('.quills-freq-pill').removeClass('is-selected');
            $(this).addClass('is-selected');

            // Automatically switch active selection to Subscribe
            var $subOpt = $('.quills-sub-option[data-type="subscribe"]');
            $subOpt.find('input[type="radio"]').prop('checked', true);
            $('.quills-sub-option').removeClass('active');
            $subOpt.addClass('active');
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

        // Quantity Stepper (Starts at 1, '+' jumps to 2, 3, etc., '-' decrements to min 1)
        var $qtyInput = $('#quills-qty-input');
        if ($qtyInput.length && (!$qtyInput.val() || parseInt($qtyInput.val(), 10) < 1)) {
            $qtyInput.val(1);
        }

        $(document).on('click', '#quills-qty-minus', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $input = $('#quills-qty-input');
            var val = parseInt($input.val(), 10);
            if (isNaN(val) || val <= 1) {
                val = 1;
            } else {
                val = val - 1;
            }
            $input.val(val).trigger('change');
        });

        $(document).on('click', '#quills-qty-plus', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $input = $('#quills-qty-input');
            var val = parseInt($input.val(), 10);
            if (isNaN(val) || val < 1) {
                val = 1;
            }
            val = val + 1;
            $input.val(val).trigger('change');
        });

        // ==========================================
        // CART DRAWER (SLIDE-IN OFF-CANVAS) ENGINE
        // ==========================================
        function openCartDrawer() {
            $('#quills-cart-overlay').addClass('is-active').attr('aria-hidden', 'false');
            $('#quills-cart-drawer').addClass('is-active').attr('aria-hidden', 'false');
            $('body').addClass('quills-drawer-open');
        }

        function closeCartDrawer() {
            $('#quills-cart-overlay').removeClass('is-active').attr('aria-hidden', 'true');
            $('#quills-cart-drawer').removeClass('is-active').attr('aria-hidden', 'true');
            $('body').removeClass('quills-drawer-open');
        }

        function updateHeaderCartBadge(count) {
            count = parseInt(count, 10) || 0;
            var $badge = $('.quills-cart-badge, #quills-cart-badge');
            if (count > 0) {
                $badge.text(count).removeClass('is-empty').show();
            } else {
                $badge.text('0').addClass('is-empty').hide();
            }
        }

        function refreshCartDrawer() {
            if (typeof quillsData === 'undefined' || !quillsData.ajaxUrl) return;
            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_get_cart_drawer',
                    nonce: quillsData.nonce
                },
                success: function(resp) {
                    if (resp.success && resp.data && resp.data.html) {
                        $('#quills-cart-drawer-content').html(resp.data.html);
                        updateHeaderCartBadge(resp.data.cart_count);
                    }
                }
            });
        }

        // Close Drawer Handlers (overlay, close button, escape key)
        $(document).on('click', '#quills-drawer-close, #quills-cart-overlay', function(e) {
            e.preventDefault();
            closeCartDrawer();
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                closeCartDrawer();
            }
        });

        // Trigger Drawer on clicking header cart icon
        $(document).on('click', '.quills-cart-link, .quills-cart-toggle, .quills-cart-icon-wrapper', function(e) {
            e.preventDefault();
            openCartDrawer();
            refreshCartDrawer();
        });

        // Add to Cart via AJAX & Open Slide-in Cart Drawer
        $('#quills-btn-add-to-cart').on('click', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var qty = parseInt($('#quills-qty-input').val(), 10) || 1;
            var size = $('#quills-size-group .quills-pill-btn.active').data('size') || '12oz';
            var grind = $('#quills-grind-group .quills-pill-btn.active').data('grind') || 'Whole Bean';
            var purchaseType = $('input[name="quills_purchase_type"]:checked').val() || 'onetime';
            var frequency = '';
            if (purchaseType === 'subscribe') {
                var $activeFreq = $('.quills-freq-pill.is-selected');
                if ($activeFreq.length) {
                    frequency = $activeFreq.text().trim();
                } else {
                    frequency = 'Deliver every 2 weeks';
                }
            }

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
                    purchase_type: purchaseType,
                    frequency: frequency
                },
                success: function(resp) {
                    $btn.removeClass('loading');
                    if (resp.success) {
                        updateHeaderCartBadge(resp.data.cart_count);
                        if (resp.data.drawer_html) {
                            $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                        }
                        openCartDrawer();
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

        // Stepper (+ / -) in Cart Drawer
        $(document).on('click', '.quills-drawer-step-btn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var key = $btn.data('key');
            var newQty = parseInt($btn.data('qty'), 10);
            var $item = $btn.closest('.quills-drawer-item');
            $item.addClass('is-updating');

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_update_cart_qty',
                    nonce: quillsData.nonce,
                    cart_item_key: key,
                    quantity: newQty
                },
                success: function(resp) {
                    if (resp.success) {
                        $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                        updateHeaderCartBadge(resp.data.cart_count);
                    } else {
                        $item.removeClass('is-updating');
                    }
                },
                error: function() {
                    $item.removeClass('is-updating');
                }
            });
        });

        // Remove item from Cart Drawer via trash button
        $(document).on('click', '.quills-drawer-remove-btn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var key = $btn.data('key');
            var $item = $btn.closest('.quills-drawer-item');
            $item.addClass('is-updating');

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_remove_cart_item',
                    nonce: quillsData.nonce,
                    cart_item_key: key
                },
                success: function(resp) {
                    if (resp.success) {
                        $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                        updateHeaderCartBadge(resp.data.cart_count);
                    } else {
                        $item.removeClass('is-updating');
                    }
                },
                error: function() {
                    $item.removeClass('is-updating');
                }
            });
        });

        // Upsell quick add in Cart Drawer
        $(document).on('click', '.quills-drawer-upsell-add-btn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var productId = $btn.data('product-id');
            $btn.addClass('loading');

            $.ajax({
                url: quillsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'quills_add_to_cart',
                    nonce: quillsData.nonce,
                    product_id: productId,
                    quantity: 1,
                    size: '',
                    grind: '',
                    purchase_type: 'onetime'
                },
                success: function(resp) {
                    $btn.removeClass('loading');
                    if (resp.success) {
                        $('#quills-cart-drawer-content').html(resp.data.drawer_html);
                        updateHeaderCartBadge(resp.data.cart_count);
                    }
                },
                error: function() {
                    $btn.removeClass('loading');
                }
            });
        });

        // Upsell toggle collapse
        $(document).on('click', '#quills-upsell-toggle', function() {
            $(this).closest('.quills-drawer-upsell-section').toggleClass('collapsed');
        });

        // Order note toggle
        $(document).on('click', '#quills-note-toggle', function() {
            $('#quills-note-textarea-wrap').slideToggle(200);
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
        $(document).on('click', '#quills-toggle-review-form, #quills-toggle-review-form-empty, #quills-cancel-review-btn', function() {
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
        // 4b. REVIEWS PAGINATION & PAGE SWITCHING
        // ==========================================
        var reviewsPagesData = {
            1: [
                {
                    rating: 4,
                    author: 'Dony Erwin Erwin',
                    badge: 'standard',
                    date: '08/02/2024',
                    title: '',
                    body: "It's a little on the mild side for me. We switched to Night Owl for next month's delivery. Thanks."
                },
                {
                    rating: 5,
                    author: 'Donna',
                    badge: 'shop',
                    date: '08/02/2024',
                    title: '',
                    body: "Amazing so glad we found this place",
                    subnote: "Review written in Shop App"
                },
                {
                    rating: 5,
                    author: 'Staci R',
                    badge: 'standard',
                    date: '08/01/2024',
                    title: '',
                    body: "This is currently our favorite coffee! Looking forward to trying your other blends in the future."
                },
                {
                    rating: 5,
                    author: 'Sarah B',
                    badge: 'standard',
                    date: '07/15/2024',
                    title: '',
                    body: "Smooth, balanced, and perfectly roasted. My morning ritual wouldn't be the same without Inkwell."
                },
                {
                    rating: 5,
                    author: 'James K',
                    badge: 'shop',
                    date: '07/02/2024',
                    title: '',
                    body: "Great flavor profile, hints of chocolate and sweet stone fruit. Highly recommend.",
                    subnote: "Review written in Shop App"
                }
            ],
            2: [
                {
                    rating: 5,
                    author: 'Gail S',
                    badge: 'standard',
                    date: '06/29/2025',
                    title: '',
                    body: "Delicious and does the trick for our morning coffee fix."
                },
                {
                    rating: 5,
                    author: 'Uisti Delgos',
                    badge: 'standard',
                    date: '04/30/2024',
                    title: '',
                    body: "Great one"
                },
                {
                    rating: 5,
                    author: 'Cheryl Stroodain',
                    badge: 'standard',
                    date: '03/19/2025',
                    title: '',
                    body: "Such a good 'middle of the road' blend. To my mind is neither too bold or too mild. Thanks"
                },
                {
                    rating: 5,
                    author: 'Anonymous',
                    badge: 'standard',
                    date: '12/05/2025',
                    title: 'Excellent',
                    body: "Excellent !"
                },
                {
                    rating: 5,
                    author: 'Robert Alvey',
                    badge: 'standard',
                    date: '10/04/2025',
                    title: 'Bought once and hooked!',
                    body: "We visited a location in Louisville while there for doctor appointments. It was an amazing coffee, and we were very happy. I purchased the Inkwell whole bean coffee and started using it. I love it!"
                }
            ],
            3: [
                {
                    rating: 5,
                    author: 'Nathan R',
                    badge: 'standard',
                    date: '09/18/2024',
                    title: 'Perfection in a cup',
                    body: "Inkwell is roasted to perfection, tastes great every time."
                },
                {
                    rating: 5,
                    author: 'Brianne E',
                    badge: 'standard',
                    date: '09/02/2024',
                    title: '',
                    body: "One cup is all it took, and we were hooked! Our daily go-to coffee."
                },
                {
                    rating: 5,
                    author: 'Tracy S',
                    badge: 'shop',
                    date: '08/25/2024',
                    title: 'Exceptional Quality',
                    body: "Quills has the best coffee and exceptional roaster quality! 5 stars!!!",
                    subnote: "Review written in Shop App"
                },
                {
                    rating: 5,
                    author: 'Mark D',
                    badge: 'standard',
                    date: '08/14/2024',
                    title: '',
                    body: "Super fresh, fast shipping, and unbeatable quality."
                },
                {
                    rating: 5,
                    author: 'Rachel M',
                    badge: 'standard',
                    date: '08/10/2024',
                    title: '',
                    body: "Rich aroma and consistent cup every morning."
                }
            ],
            4: [
                {
                    rating: 5,
                    author: 'Carlos M',
                    badge: 'standard',
                    date: '07/28/2024',
                    title: 'Great for Aeropress',
                    body: "Balanced acidity and full body. Works wonderfully with Aeropress."
                },
                {
                    rating: 5,
                    author: 'Amanda P',
                    badge: 'standard',
                    date: '07/19/2024',
                    title: '',
                    body: "The subscription is so convenient and coffee arrives fresh."
                },
                {
                    rating: 5,
                    author: 'David L',
                    badge: 'shop',
                    date: '07/11/2024',
                    title: 'Best in Louisville',
                    body: "Best house blend in Kentucky hands down.",
                    subnote: "Review written in Shop App"
                },
                {
                    rating: 5,
                    author: 'Kelly W',
                    badge: 'standard',
                    date: '06/30/2024',
                    title: '',
                    body: "Subtle sweetness and very smooth finish."
                },
                {
                    rating: 5,
                    author: 'Tim H',
                    badge: 'standard',
                    date: '06/22/2024',
                    title: '',
                    body: "Consistent quality bag after bag."
                }
            ],
            16: [
                {
                    rating: 5,
                    author: 'John Doe',
                    badge: 'standard',
                    date: '01/15/2023',
                    title: 'Timeless classic',
                    body: "Been drinking Quills since the beginning, Inkwell is timeless."
                },
                {
                    rating: 5,
                    author: 'Emily C',
                    badge: 'standard',
                    date: '01/08/2023',
                    title: '',
                    body: "Fantastic morning blend with milk or black."
                },
                {
                    rating: 5,
                    author: 'Michael B',
                    badge: 'standard',
                    date: '12/28/2022',
                    title: '',
                    body: "First time trying specialty coffee and this set the bar high."
                },
                {
                    rating: 5,
                    author: 'Lisa T',
                    badge: 'standard',
                    date: '12/14/2022',
                    title: '',
                    body: "A staple in our household."
                },
                {
                    rating: 5,
                    author: 'Aaron S',
                    badge: 'standard',
                    date: '12/02/2022',
                    title: '',
                    body: "Delicious chocolatey finish."
                }
            ]
        };

        function renderReviewsPage(pageNum) {
            var page = parseInt(pageNum, 10) || 1;
            var reviews = reviewsPagesData[page] || reviewsPagesData[1];
            var $list = $('#quills-reviews-list');
            if (!$list.length || !reviews) return;

            var html = '';
            reviews.forEach(function(item) {
                var rating = item.rating || 5;
                var filled = '<span class="star filled">★</span>'.repeat(rating);
                var empty = '<span class="star empty">★</span>'.repeat(5 - rating);
                var initial = item.author ? item.author.charAt(0).toUpperCase() : 'U';
                var badgeLabel = (item.badge === 'shop') ? 'Verified by shop' : 'Verified';
                var titleHtml = item.title ? '<div class="quills-review-item-headline" style="font-family:\'Besley\',Georgia,serif; font-weight:700; font-size:15px; margin-bottom:6px; color:#1a1a1a;">' + item.title + '</div>' : '';
                var subnoteHtml = item.subnote ? '<span class="quills-review-subnote">' + item.subnote + '</span>' : '';

                html += `
                    <div class="quills-review-item-v2" data-rating="${rating}">
                        <div class="quills-review-item-stars">
                            ${filled}${empty}
                        </div>
                        <div class="quills-review-item-author-row">
                            <span class="quills-author-avatar-circle">${initial}</span>
                            <span class="quills-author-name-text">${item.author}</span>
                            <span class="quills-verified-pill">${badgeLabel}</span>
                            <span class="quills-review-date-text">${item.date}</span>
                        </div>
                        <div class="quills-review-item-text">
                            ${titleHtml}
                            ${item.body}
                            ${subnoteHtml}
                        </div>
                    </div>
                `;
            });

            $list.css('opacity', '0.3');
            setTimeout(function() {
                $list.html(html).css('opacity', '1');
            }, 100);

            // Update active number styling
            $('.quills-page-num').removeClass('is-active');
            $('.quills-page-num[data-page="' + page + '"]').addClass('is-active');

            // Update arrows
            $('#quills-reviews-prev').prop('disabled', page <= 1);
            $('#quills-reviews-next').prop('disabled', page >= 16);
        }

        // Click on page number
        $(document).on('click', '.quills-page-num', function(e) {
            e.preventDefault();
            var targetPage = parseInt($(this).attr('data-page') || $(this).text().trim(), 10);
            if (targetPage) {
                renderReviewsPage(targetPage);
            }
        });

        // Click on Previous arrow
        $(document).on('click', '#quills-reviews-prev, .quills-page-prev', function(e) {
            e.preventDefault();
            var cur = parseInt($('.quills-page-num.is-active').attr('data-page') || $('.quills-page-num.is-active').text().trim(), 10) || 1;
            if (cur > 1) {
                var prevPage = cur - 1;
                if (cur === 16) prevPage = 4;
                renderReviewsPage(prevPage);
            }
        });

        // Click on Next arrow
        $(document).on('click', '#quills-reviews-next, .quills-page-next', function(e) {
            e.preventDefault();
            var cur = parseInt($('.quills-page-num.is-active').attr('data-page') || $('.quills-page-num.is-active').text().trim(), 10) || 1;
            if (cur < 16) {
                var nextPage = cur + 1;
                if (cur === 4) nextPage = 16;
                renderReviewsPage(nextPage);
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
        $(document).on('click', '#quills-clear-all-sidebar, #quills-clear-all-empty', function(e) {
            e.preventDefault();
            $('#quills-filter-form input[type="checkbox"]').prop('checked', false);
            triggerFilter();
        });

    });

})(jQuery);
