/**
 * Quills Coffee Authentic Script - Homepage (Front Page)
 * For coffee-cafe-corner theme
 * Handles FAQ Accordion, interactive hover, and smooth interactions
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // FAQ Accordion (Delegated handler for robust execution)
    document.addEventListener('click', function (e) {
      const trigger = e.target.closest('.quills-accordion-trigger');
      if (!trigger) return;
      e.preventDefault();

      const item = trigger.closest('.quills-accordion-item');
      if (!item) return;

      const panel = item.querySelector('.quills-accordion-panel');
      const isOpen = item.classList.contains('is-open') || item.classList.contains('open');

      // Close other open accordion items
      const allItems = document.querySelectorAll('.quills-accordion-item');
      allItems.forEach(function (otherItem) {
        if (otherItem !== item && (otherItem.classList.contains('is-open') || otherItem.classList.contains('open'))) {
          otherItem.classList.remove('is-open');
          otherItem.classList.remove('open');
          const otherBtn = otherItem.querySelector('.quills-accordion-trigger');
          if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
          const otherPanel = otherItem.querySelector('.quills-accordion-panel');
          if (otherPanel) {
            otherPanel.style.maxHeight = null;
          }
        }
      });

      // Toggle current item
      if (isOpen) {
        item.classList.remove('is-open');
        item.classList.remove('open');
        trigger.setAttribute('aria-expanded', 'false');
        if (panel) {
          panel.style.maxHeight = null;
        }
      } else {
        item.classList.add('is-open');
        item.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
        if (panel) {
          const scrollH = panel.scrollHeight;
          panel.style.maxHeight = Math.max(scrollH, 250) + 'px';
        }
      }
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

