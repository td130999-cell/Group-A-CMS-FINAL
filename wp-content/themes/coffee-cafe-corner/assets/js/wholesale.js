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

    // 2. Typeform script injection and fallback handling
    const typeformWidget = document.getElementById('wholesale-typeform-widget');
    const fallbackForm = document.getElementById('wholesale-inquiry-form');

    if (typeformWidget) {
        // Load typeform embed script if not already present
        if (!document.querySelector('script[src*="embed.typeform.com"]')) {
            const tfScript = document.createElement('script');
            tfScript.src = '//embed.typeform.com/next/embed.js';
            tfScript.async = true;
            document.body.appendChild(tfScript);
        }

        // Show fallback form if Typeform does not render after 3 seconds
        setTimeout(function () {
            const tfIframe = typeformWidget.querySelector('iframe');
            if (!tfIframe && fallbackForm) {
                fallbackForm.style.display = 'block';
            }
        }, 3000);
    }

    // 3. AJAX Submission for Fallback Inquiry Form
    if (fallbackForm) {
        fallbackForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById('wholesale-submit-button');
            const feedback = document.getElementById('wholesale-feedback');
            const formData = new FormData(fallbackForm);
            formData.append('action', 'wholesale_submit_inquiry');

            const nonceField = document.getElementById('wholesale_nonce_field');
            if (nonceField) {
                formData.append('security', nonceField.value);
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerText = 'Sending...';
            }

            if (feedback) {
                feedback.className = 'wholesale-form-feedback';
                feedback.style.display = 'none';
            }

            const ajaxUrl = (typeof wholesaleData !== 'undefined' && wholesaleData.ajaxUrl) 
                ? wholesaleData.ajaxUrl 
                : '/wp-admin/admin-ajax.php';

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (res) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Send Sample Request';
                }

                if (feedback) {
                    if (res.success) {
                        feedback.className = 'wholesale-form-feedback success';
                        feedback.innerText = res.data && res.data.message 
                            ? res.data.message 
                            : 'Thank you! Michael will review your details shortly.';
                        feedback.style.display = 'block';
                        fallbackForm.reset();
                    } else {
                        feedback.className = 'wholesale-form-feedback error';
                        feedback.innerText = res.data && res.data.message 
                            ? res.data.message 
                            : 'An error occurred. Please try again.';
                        feedback.style.display = 'block';
                    }
                }
            })
            .catch(function () {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Send Sample Request';
                }
                if (feedback) {
                    feedback.className = 'wholesale-form-feedback error';
                    feedback.innerText = 'Network error. Please try again later.';
                    feedback.style.display = 'block';
                }
            });
        });
    }
});
