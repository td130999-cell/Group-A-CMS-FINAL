/**
 * Quills Coffee Authentic Script - Homepage (Front Page)
 * For coffee-cafe-corner theme
 * Handles FAQ Accordion, interactive hover, and smooth interactions
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // FAQ Accordion
    const accordionTriggers = document.querySelectorAll('.quills-accordion-trigger');

    accordionTriggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        const item = this.closest('.quills-accordion-item');
        const panel = item ? item.querySelector('.quills-accordion-panel') : null;

        if (!item || !panel) return;

        const isOpen = item.classList.contains('is-open');

        // Optional: Close other open accordion items
        const allItems = document.querySelectorAll('.quills-accordion-item');
        allItems.forEach(function (otherItem) {
          if (otherItem !== item && otherItem.classList.contains('is-open')) {
            otherItem.classList.remove('is-open');
            const otherBtn = otherItem.querySelector('.quills-accordion-trigger');
            if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
            const otherPanel = otherItem.querySelector('.quills-accordion-panel');
            if (otherPanel) otherPanel.style.maxHeight = null;
          }
        });

        // Toggle current item
        if (isOpen) {
          item.classList.remove('is-open');
          this.setAttribute('aria-expanded', 'false');
          panel.style.maxHeight = null;
        } else {
          item.classList.add('is-open');
          this.setAttribute('aria-expanded', 'true');
          panel.style.maxHeight = panel.scrollHeight + 'px';
        }
      });
    });

    // Touch device support for product card rollover
    const productCards = document.querySelectorAll('.quills-product-card');
    productCards.forEach(function (card) {
      card.addEventListener('touchstart', function () {
        // Toggle hover state on mobile tap
        this.classList.toggle('is-touched');
      }, { passive: true });
    });

    // Quick Shop Drawer trigger for Bestsellers on Homepage
    document.addEventListener('click', function (e) {
      const addBtn = e.target.closest('.quills-btn--add-to-cart, .quills-hover-add-cart');
      if (!addBtn) return;
      e.preventDefault();
      e.stopPropagation();
      let productId = addBtn.getAttribute('data-product-id');
      if (!productId) {
        const card = addBtn.closest('.quills-product-card');
        if (card) {
          productId = card.getAttribute('data-product-id');
        }
      }
      if (productId && typeof window.openQuickShopDrawer === 'function') {
        window.openQuickShopDrawer(productId);
      }
    });
  });
})();

