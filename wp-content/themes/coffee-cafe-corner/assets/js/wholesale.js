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
});

