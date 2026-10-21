/**
 * Quills Coffee - Live Search Modal & Drawer Script
 * Handles trigger events, modal toggling, debounced AJAX live search,
 * clear button, and suggestions interaction matching https://quillscoffee.com/
 *
 * @package Coffee_Cafe_Corner
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('quills-search-modal');
        if (!modal) return;

        const backdrop = document.getElementById('quills-search-backdrop');
        const closeBtn = document.getElementById('quills-search-close-btn');
        const input = document.getElementById('quills-search-modal-input');
        const clearBtn = document.getElementById('quills-search-clear-btn');
        const initialView = document.getElementById('quills-search-initial-view');
        const liveView = document.getElementById('quills-search-live-view');
        const loader = document.getElementById('quills-search-loader');
        const productsList = document.getElementById('quills-search-products-list');
        const viewAllBtn = document.getElementById('quills-search-view-all-btn');

        const sectionSuggestions = document.getElementById('quills-search-section-suggestions');
        const suggestionsList = document.getElementById('quills-search-suggestions-list');
        const divider1 = document.getElementById('quills-search-divider-1');

        const sectionPages = document.getElementById('quills-search-section-pages');
        const pagesList = document.getElementById('quills-search-pages-list');
        const divider2 = document.getElementById('quills-search-divider-2');

        const sectionCollections = document.getElementById('quills-search-section-collections');
        const collectionsList = document.getElementById('quills-search-collections-list');

        let debounceTimer = null;
        let currentAbortController = null;

        // 1. Open Modal Trigger
        function openModal() {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('quills-search-active');

            setTimeout(() => {
                if (input) {
                    input.focus();
                    if (input.value.trim().length > 0) {
                        input.select();
                    }
                }
            }, 80);
        }
        window.quillsOpenSearch = openModal;

        // 2. Close Modal Trigger
        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('quills-search-active');

            // Clean up query string in URL if present
            if (window.location.search && window.location.search.includes('s=')) {
                try {
                    window.history.replaceState({}, document.title, window.location.pathname);
                } catch(e) {}
            }
        }
        window.quillsCloseSearch = closeModal;

        // Bind header triggers
        const headerSearchElements = document.querySelectorAll('.quills-search-input, .quills-search-btn, .quills-search-form');
        headerSearchElements.forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openModal();
            });
            el.addEventListener('focus', function(e) {
                if (el.classList.contains('quills-search-input')) {
                    e.preventDefault();
                    openModal();
                }
            });
        });

        // Close triggers
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (backdrop) backdrop.addEventListener('click', closeModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        // 3. Clear button trigger
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (input) {
                    input.value = '';
                    handleQueryChange('');
                    input.focus();
                }
            });
        }

        // 4. Input live typing event
        if (input) {
            input.addEventListener('input', function() {
                const query = input.value.trim();
                handleQueryChange(query);
            });
        }

        function handleQueryChange(query) {
            if (query.length > 0) {
                if (clearBtn) clearBtn.classList.add('is-visible');
                if (initialView) initialView.style.display = 'none';
                if (liveView) liveView.style.display = 'block';

                // Debounce search
                if (debounceTimer) clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    performLiveSearch(query);
                }, 200);
            } else {
                if (clearBtn) clearBtn.classList.remove('is-visible');
                if (liveView) liveView.style.display = 'none';
                if (initialView) initialView.style.display = 'block';

                if (debounceTimer) clearTimeout(debounceTimer);
                if (currentAbortController) {
                    currentAbortController.abort();
                    currentAbortController = null;
                }
                if (loader) loader.style.display = 'none';
            }
        }

        // 5. AJAX Live Search Request
        function performLiveSearch(query) {
            if (currentAbortController) {
                currentAbortController.abort();
            }
            currentAbortController = new AbortController();

            if (loader) loader.style.display = 'flex';

            const ajaxUrl = (typeof quillsSearchData !== 'undefined' && quillsSearchData.ajaxUrl) 
                ? quillsSearchData.ajaxUrl 
                : '/wp-admin/admin-ajax.php';

            const url = `${ajaxUrl}?action=quills_live_search&q=${encodeURIComponent(query)}`;

            fetch(url, { signal: currentAbortController.signal })
                .then(res => res.json())
                .then(res => {
                    if (loader) loader.style.display = 'none';
                    if (res && res.success && res.data) {
                        renderResults(res.data, query);
                    }
                })
                .catch(err => {
                    if (err.name !== 'AbortError') {
                        console.error('Quills search error:', err);
                        if (loader) loader.style.display = 'none';
                    }
                });
        }

        // 6. Render Results Layout
        function renderResults(data, query) {
            // Products
            if (productsList) {
                productsList.innerHTML = data.products || '';
            }

            // View All button (compact, left-aligned)
            if (viewAllBtn) {
                viewAllBtn.textContent = `VIEW ALL FOR "${query.toUpperCase()}"`;
                viewAllBtn.href = data.view_all_url || `/?s=${encodeURIComponent(query)}`;
                viewAllBtn.style.display = 'inline-block';
            }

            // Suggestions
            const suggestions = data.suggestions || [];
            if (suggestionsList && sectionSuggestions) {
                if (suggestions.length > 0) {
                    suggestionsList.innerHTML = suggestions.map(s => {
                        const highlighted = highlightMatch(s, query);
                        return `
                            <li class="quills-search-aside-item">
                                <button type="button" class="quills-search-suggestion-btn" data-suggestion="${escapeHtml(s)}">
                                    ${highlighted}
                                </button>
                            </li>
                        `;
                    }).join('');
                    sectionSuggestions.style.display = 'block';
                    if (divider1) divider1.style.display = 'block';

                    // Bind click on suggestions
                    suggestionsList.querySelectorAll('.quills-search-suggestion-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const val = this.getAttribute('data-suggestion');
                            if (val && input) {
                                input.value = val;
                                handleQueryChange(val);
                                input.focus();
                            }
                        });
                    });
                } else {
                    suggestionsList.innerHTML = '';
                    sectionSuggestions.style.display = 'none';
                    if (divider1) divider1.style.display = 'none';
                }
            }

            // Pages
            const pages = data.pages || [];
            if (pagesList && sectionPages) {
                if (pages.length > 0) {
                    pagesList.innerHTML = pages.map(p => `
                        <li class="quills-search-aside-item">
                            <a href="${p.url}" class="quills-search-aside-link">
                                ${escapeHtml(p.title)}
                            </a>
                        </li>
                    `).join('');
                    sectionPages.style.display = 'block';
                    if (divider2) divider2.style.display = 'block';
                } else {
                    pagesList.innerHTML = '';
                    sectionPages.style.display = 'none';
                    if (divider2) divider2.style.display = 'none';
                }
            }

            // Collections
            const collections = data.collections || [];
            if (collectionsList && sectionCollections) {
                if (collections.length > 0) {
                    collectionsList.innerHTML = collections.map(c => `
                        <li class="quills-search-aside-item">
                            <a href="${c.url}" class="quills-search-aside-link">
                                ${escapeHtml(c.name)}
                            </a>
                        </li>
                    `).join('');
                    sectionCollections.style.display = 'block';
                } else {
                    collectionsList.innerHTML = '';
                    sectionCollections.style.display = 'none';
                }
            }
        }

        function highlightMatch(text, query) {
            if (!query) return escapeHtml(text);
            const escaped = escapeHtml(text);
            const reg = new RegExp(escapeRegex(query), 'gi');
            return escaped.replace(reg, '<strong class="quills-search-bold">$&</strong>');
        }

        function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Auto-open modal if URL already has ?s=...
        try {
            const urlParams = new URLSearchParams(window.location.search);
            const sQuery = urlParams.get('s');
            if (sQuery && sQuery.trim().length > 0) {
                openModal();
                if (input) {
                    input.value = sQuery.trim();
                    handleQueryChange(sQuery.trim());
                }
            }
        } catch(e) {}
    });
})();
