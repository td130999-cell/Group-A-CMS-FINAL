/**
 * Wholesale Page JavaScript
 * Handles video playback, sound toggle, Typeform embed loading, and AJAX inquiry submissions.
 *
 * @package Coffee_Cafe_Corner
 */

document.addEventListener('DOMContentLoaded', function () {
    const videoCard = document.getElementById('wholesale-video-card');
    const soundToggle = document.getElementById('wholesale-sound-toggle');
    const wistiaBox = document.getElementById('wholesale-wistia-box');
    const subtitlePill = document.getElementById('wholesale-subtitle');
    const posterImg = document.getElementById('wholesale-poster-img');

    // 1. Interactive Video Playback
    function playVideo() {
        if (!videoCard || !wistiaBox) return;

        const videoId = videoCard.getAttribute('data-video-id') || 'zihbfybcjm';

        if (!wistiaBox.classList.contains('active')) {
            wistiaBox.innerHTML = '<iframe src="https://fast.wistia.net/embed/iframe/' + encodeURIComponent(videoId) + '?autoPlay=true&muted=false" title="Michael Quills Wholesale Video" allow="autoplay; fullscreen" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" style="width:100%;height:100%;border-radius:14px;"></iframe>';
            wistiaBox.classList.add('active');

            if (soundToggle) {
                soundToggle.style.display = 'none';
            }
            if (subtitlePill) {
                subtitlePill.style.display = 'none';
            }
            if (posterImg) {
                posterImg.style.display = 'none';
            }
        }
    }

    if (soundToggle) {
        soundToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            playVideo();
        });
    }

    if (videoCard) {
        videoCard.addEventListener('click', function () {
            playVideo();
        });
    }

    // 2. Typeform script injection
    const typeformWidget = document.getElementById('wholesale-typeform-widget');

    if (typeformWidget) {
        // Load typeform embed script if not already present
        if (!document.querySelector('script[src*="embed.typeform.com"]')) {
            const tfScript = document.createElement('script');
            tfScript.src = '//embed.typeform.com/next/embed.js';
            tfScript.async = true;
            document.body.appendChild(tfScript);
        }
    }

    // 3. Direct Sample Request Form Interaction
    const sampleCover = document.getElementById('quills-sample-cover');
    const sampleFormWrap = document.getElementById('quills-sample-form-wrap');
    const startBtn = document.getElementById('quills-sample-start-btn');
    const backBtn = document.getElementById('quills-sample-back-btn');
    const inquiryForm = document.getElementById('wholesale-inquiry-form');
    const feedbackBox = document.getElementById('wholesale-feedback');
    const submitBtn = document.getElementById('wholesale-submit-button');

    if (startBtn && sampleCover && sampleFormWrap) {
        startBtn.addEventListener('click', function () {
            sampleCover.style.display = 'none';
            sampleFormWrap.style.display = 'block';
            const nameInput = document.getElementById('wholesale-name');
            if (nameInput) {
                nameInput.focus();
            }
        });
    }

    if (backBtn && sampleCover && sampleFormWrap) {
        backBtn.addEventListener('click', function () {
            sampleFormWrap.style.display = 'none';
            sampleCover.style.display = 'flex';
        });
    }

    if (inquiryForm) {
        inquiryForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!submitBtn) return;
            const originalBtnText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';

            if (feedbackBox) {
                feedbackBox.style.display = 'none';
                feedbackBox.className = 'quills-form-feedback';
            }

            const formData = new FormData(inquiryForm);
            formData.append('action', 'wholesale_submit_inquiry');
            formData.append('security', inquiryForm.querySelector('#wholesale_nonce_field') ? inquiryForm.querySelector('#wholesale_nonce_field').value : '');

            const ajaxUrl = (typeof wholesaleData !== 'undefined' && wholesaleData.ajaxUrl) ? wholesaleData.ajaxUrl : '/wp-admin/admin-ajax.php';

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;

                if (feedbackBox) {
                    if (data && data.success) {
                        const defaultSuccess = feedbackBox.getAttribute('data-default-success') || (data.data && data.data.message) || 'Thank you! Michael will review your details and reach out soon.';
                        feedbackBox.textContent = (data.data && data.data.message) ? data.data.message : defaultSuccess;
                        feedbackBox.className = 'quills-form-feedback success';
                        feedbackBox.style.display = 'block';
                        inquiryForm.reset();

                        // Hide form grid after success
                        const formGrid = inquiryForm.querySelector('.quills-sample-grid');
                        const formActions = inquiryForm.querySelector('.quills-form-actions');
                        if (formGrid) formGrid.style.display = 'none';
                        if (formActions) formActions.style.display = 'none';
                    } else {
                        feedbackBox.textContent = (data && data.data && data.data.message) ? data.data.message : 'An error occurred. Please try again.';
                        feedbackBox.className = 'quills-form-feedback error';
                        feedbackBox.style.display = 'block';
                    }
                }
            })
            .catch(function (err) {
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
                if (feedbackBox) {
                    feedbackBox.textContent = 'Submission error. Please check your connection and try again.';
                    feedbackBox.className = 'quills-form-feedback error';
                    feedbackBox.style.display = 'block';
                }
            });
        });
    }
});

