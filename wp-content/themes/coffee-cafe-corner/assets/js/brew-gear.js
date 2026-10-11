/**
 * Brew Gear Collection JavaScript
 * 
 * Handles client-side sort interactions and interactive Add-to-Cart
 *
 * @package Coffee_Cafe_Corner
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Sort by dropdown interaction
    const sortSelect = document.getElementById('quills-sort-by-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const selectedVal = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('sort_by', selectedVal);
            window.location.href = currentUrl.toString();
        });
    }

    // 2. Interactive Add To Cart buttons inside hover overlay
    const addToCartForms = document.querySelectorAll('.quills-add-to-cart-form');
    addToCartForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = form.querySelector('.quills-add-to-cart-btn');
            const productIdInput = form.querySelector('input[name="add-to-cart"]');
            if (!productIdInput || !btn) return;

            const productId = productIdInput.value;
            const originalText = btn.textContent;
            btn.textContent = 'ADDING...';
            btn.disabled = true;

            // Submit via FormData to WooCommerce
            const formData = new FormData(form);
            formData.append('product_id', productId);
            formData.append('quantity', 1);

            fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function () {
                btn.textContent = 'ADDED!';
                btn.classList.add('is-added');

                // Update cart count badge in header
                const cartBadge = document.querySelector('.quills-cart-badge');
                if (cartBadge) {
                    const currentCount = parseInt(cartBadge.textContent, 10) || 0;
                    cartBadge.textContent = currentCount + 1;
                }

                setTimeout(function () {
                    btn.textContent = originalText;
                    btn.classList.remove('is-added');
                    btn.disabled = false;
                }, 1600);
            })
            .catch(function () {
                // Fallback to normal form submit if fetch fails
                form.submit();
            });
        });
    });
});
