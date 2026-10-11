/**
 * Brew Gear Collection JavaScript
 * 
 * Handles client-side sort interactions and image transitions
 *
 * @package Coffee_Cafe_Corner
 */

document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.getElementById('quills-sort-by-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const selectedVal = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('sort_by', selectedVal);
            window.location.href = currentUrl.toString();
        });
    }
});
