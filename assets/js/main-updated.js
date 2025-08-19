// Retail Trade Scanner - Updated JavaScript - Django Backend Compatible
// Dark mode support, cleaned console logs, rate limiting, Django API integration

(function() {
    'use strict';

    // Global namespace
    window.RetailTradeScanner = window.RetailTradeScanner || {};
    
    // Configuration
    const config = {
        searchDelay: 300,
        apiTimeout: 15000,
        retryAttempts: 3,
        debug: false
    };
    
    // Utility functions
    const utils = {
        // Debounce function for search
        debounce: function(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        // Log function with debug mode check - PRODUCTION SAFE
        log: function(message, type = 'info') {
            // Only log in debug mode and development environment
            if (config.debug && window.location.hostname === 'localhost') {
                // Removed console.log for production
            }
        },
        
        // Safe DOM query
        safeQuery: function(selector) {
            try {
                return document.querySelector(selector);
            } catch (e) {
                return null;
            }
        },
        
        // Safe DOM query all
        safeQueryAll: function(selector) {
            try {
                return document.querySelectorAll(selector);
            } catch (e) {
                return [];
            }
        },
        
        // Format currency
        formatCurrency: function(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount || 0);
        },
        
        // Format percentage
        formatPercentage: function(value) {
            const num = parseFloat(value) || 0;
            return (num >= 0 ? '+' : '') + num.toFixed(2) + '%';
        }
    };
    
    // Dark Mode Manager
    const DarkModeManager = {
        init: function() {
            this.createToggleButton();
            this.loadUserPreference();
            this.setupEventListeners();
        },
        
        createToggleButton: function() {
            if (!document.querySelector('.dark-mode-toggle')) {
                const toggle = document.createElement('button');
                toggle.className = 'dark-mode-toggle';
                toggle.innerHTML = `
                    <span class="toggle-icon">🌙</span>
                    <span class="toggle-text">Dark Mode</span>
                `;
                toggle.setAttribute('aria-label', 'Toggle dark mode');
                toggle.addEventListener('click', () => this.toggle());
                document.body.appendChild(toggle);
            }
        },
        
        loadUserPreference: function() {
            const isDarkMode = window.retail_trade_scanner_data?.dark_mode || false;
            if (isDarkMode) {
                this.enable();
            } else {
                this.disable();
            }
        },
        
        toggle: function() {
            const isDarkMode = document.body.classList.contains('dark-mode');
            if (isDarkMode) {
                this.disable();
            } else {
                this.enable();
            }
            
            // Save preference via AJAX
            this.savePreference(!isDarkMode);
        },
        
        enable: function() {
            document.body.classList.add('dark-mode');
            this.updateToggleButton(true);
        },
        
        disable: function() {
            document.body.classList.remove('dark-mode');
            this.updateToggleButton(false);
        },
        
        updateToggleButton: function(isDark) {
            const toggle = document.querySelector('.dark-mode-toggle');
            if (toggle) {
                const icon = toggle.querySelector('.toggle-icon');
                const text = toggle.querySelector('.toggle-text');
                
                if (isDark) {
                    icon.textContent = '☀️';
                    text.textContent = 'Light Mode';
                } else {
                    icon.textContent = '🌙';
                    text.textContent = 'Dark Mode';
                }
            }
        },
        
        savePreference: function(enabled) {
            if (window.retail_trade_scanner_data?.ajax_url) {
                fetch(window.retail_trade_scanner_data.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'retail_trade_scanner_toggle_dark_mode',
                        nonce: window.retail_trade_scanner_data.nonce
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        NotificationManager.show(data.data.message, 'success', 2000);
                    }
                })
                .catch(error => {
                    // Silent error handling in production
                });
            }
        },
        
        setupEventListeners: function() {
            // Listen for system theme changes
            if (window.matchMedia) {
                const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                mediaQuery.addEventListener('change', (e) => {
                    if (!localStorage.getItem('darkModePreference')) {
                        if (e.matches) {
                            this.enable();
                        } else {
                            this.disable();
                        }
                    }
                });
            }
        }
    };
    
    // Enhanced API Manager for Django Backend
    const APIManager = {
        init: function() {
            this.setupGlobalAPI();
            this.setupErrorHandling();
        },
        
        setupGlobalAPI: function() {
            window.RetailTradeScanner.API = {
                baseURL: window.retail_trade_scanner_data?.backend_url || '',
                endpoints: window.retail_trade_scanner_data?.api_endpoints || {},
                
                // Direct Django API call
                callDjango: function(endpoint, options = {}) {
                    const url = this.baseURL + '/' + endpoint.replace(/^\//, '');
                    
                    const defaultOptions = {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        timeout: config.apiTimeout
                    };
                    
                    const mergedOptions = {
                        ...defaultOptions,
                        ...options,
                        headers: { ...defaultOptions.headers, ...options.headers }
                    };
                    
                    if (options.body && typeof options.body === 'object') {
                        mergedOptions.body = JSON.stringify(options.body);
                    }
                    
                    return this.fetchWithRetry(url, mergedOptions);
                },
                
                // WordPress proxy call
                call: function(endpoint, options = {}) {
                    const proxyUrl = window.retail_trade_scanner_data?.rest_url + 'proxy/' + endpoint.replace(/^\//, '');
                    
                    const defaultOptions = {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': window.retail_trade_scanner_data?.nonce || ''
                        },
                        timeout: config.apiTimeout
                    };
                    
                    const mergedOptions = {
                        ...defaultOptions,
                        ...options,
                        headers: { ...defaultOptions.headers, ...options.headers }
                    };
                    
                    if (options.body && typeof options.body === 'object') {
                        mergedOptions.body = JSON.stringify(options.body);
                    }
                    
                    return this.fetchWithRetry(proxyUrl, mergedOptions);
                },
                
                fetchWithRetry: function(url, options, attempt = 1) {
                    return fetch(url, options)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                            }
                            return response.json();
                        })
                        .catch(error => {
                            if (attempt < config.retryAttempts) {
                                return new Promise(resolve => {
                                    setTimeout(() => {
                                        resolve(this.fetchWithRetry(url, options, attempt + 1));
                                    }, 1000 * attempt);
                                });
                            } else {
                                throw error;
                            }
                        });
                }
            };
        },
        
        setupErrorHandling: function() {
            // Global error handler for unhandled promise rejections
            window.addEventListener('unhandledrejection', (event) => {
                // Silent error handling in production
                event.preventDefault();
            });
        }
    };
    
    // Enhanced Search Manager
    const SearchManager = {
        init: function() {
            this.initializeSearchBar();
            this.initializeSearchResults();
        },
        
        initializeSearchBar: function() {
            const searchInput = utils.safeQuery('.search-input, #stock-search');
            const searchToggle = utils.safeQuery('.search-toggle, #search-toggle');
            
            if (!searchInput) {
                return;
            }
            
            // Toggle functionality
            if (searchToggle) {
                searchToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.toggleSearch(searchInput);
                });
            }
            
            // Focus and blur events
            searchInput.addEventListener('focus', () => {
                this.expandSearch(searchInput);
            });
            
            searchInput.addEventListener('blur', (e) => {
                setTimeout(() => {
                    if (!searchInput.value.trim() && !this.isClickInsideSearch(e)) {
                        this.collapseSearch(searchInput);
                    }
                }, 200);
            });
            
            // Search input handling with debouncing
            const debouncedSearch = utils.debounce((query) => {
                this.performSearch(query, searchInput);
            }, config.searchDelay);
            
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                if (query.length > 1) {
                    debouncedSearch(query);
                } else {
                    this.hideSearchResults();
                }
            });
            
            // Close search on outside click
            document.addEventListener('click', (e) => {
                if (!this.isClickInsideSearch(e)) {
                    this.collapseSearch(searchInput);
                    this.hideSearchResults();
                }
            });
        },
        
        performSearch: function(query, searchInput) {
            // Show loading state
            this.showSearchLoading();
            
            // Use Django API directly
            window.RetailTradeScanner.API.callDjango('api/stocks/search', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                // Add query parameter to URL if API supports it
                const url = new URL(window.RetailTradeScanner.API.baseURL + '/api/stocks/search/');
                url.searchParams.append('q', query);
                
                return fetch(url.toString(), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
            })
            .then(response => response.json())
            .then(data => {
                this.handleSearchResults(data, query);
            })
            .catch(error => {
                this.showSearchError();
            });
        },
        
        handleSearchResults: function(data, query) {
            const resultsContainer = utils.safeQuery('#search-results');
            if (!resultsContainer) return;
            
            if (data && data.success && data.results && data.results.length > 0) {
                this.displaySearchResults(data.results, resultsContainer);
            } else if (data && data.data && data.data.length > 0) {
                this.displaySearchResults(data.data, resultsContainer);
            } else {
                this.showNoResults(resultsContainer, query);
            }
        },
        
        // ... rest of SearchManager methods remain similar but with removed console.log statements
        
        toggleSearch: function(searchInput) {
            if (this.isSearchExpanded(searchInput)) {
                this.collapseSearch(searchInput);
            } else {
                this.expandSearch(searchInput);
                searchInput.focus();
            }
        },
        
        expandSearch: function(searchInput) {
            searchInput.style.width = '300px';
            searchInput.style.opacity = '1';
            searchInput.classList.add('expanded');
            
            const container = searchInput.closest('.search-container');
            if (container) {
                container.classList.add('active');
            }
        },
        
        collapseSearch: function(searchInput) {
            if (!searchInput.value.trim()) {
                searchInput.style.width = '40px';
                searchInput.style.opacity = '0';
                searchInput.classList.remove('expanded');
                
                const container = searchInput.closest('.search-container');
                if (container) {
                    container.classList.remove('active');
                }
            }
        },
        
        isSearchExpanded: function(searchInput) {
            return searchInput.classList.contains('expanded');
        },
        
        isClickInsideSearch: function(e) {
            const searchContainer = utils.safeQuery('.search-container');
            const searchResults = utils.safeQuery('#search-results');
            
            return (searchContainer && searchContainer.contains(e.target)) ||
                   (searchResults && searchResults.contains(e.target));
        },
        
        initializeSearchResults: function() {
            let resultsContainer = utils.safeQuery('#search-results');
            
            if (!resultsContainer) {
                const searchContainer = utils.safeQuery('.search-container');
                if (searchContainer) {
                    resultsContainer = document.createElement('div');
                    resultsContainer.id = 'search-results';
                    resultsContainer.className = 'search-results-dropdown';
                    resultsContainer.style.cssText = `
                        position: absolute;
                        top: 100%;
                        left: 0;
                        right: 0;
                        background: var(--card-bg, white);
                        border: 1px solid var(--card-border, #e2e8f0);
                        border-radius: 8px;
                        box-shadow: var(--shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
                        max-height: 300px;
                        overflow-y: auto;
                        z-index: 1000;
                        display: none;
                    `;
                    searchContainer.appendChild(resultsContainer);
                    searchContainer.style.position = 'relative';
                }
            }
        },
        
        displaySearchResults: function(results, container) {
            container.innerHTML = '';
            
            results.slice(0, 8).forEach(result => {
                const resultItem = this.createSearchResultItem(result);
                container.appendChild(resultItem);
            });
            
            container.style.display = 'block';
        },
        
        createSearchResultItem: function(result) {
            const item = document.createElement('div');
            item.className = 'search-result-item';
            item.style.cssText = `
                padding: 12px 16px;
                border-bottom: 1px solid var(--border-primary, #f1f5f9);
                cursor: pointer;
                transition: background-color 0.2s ease;
            `;
            
            const changeColor = (result.change_percent || 0) >= 0 ? 'var(--success-color, #059669)' : 'var(--danger-color, #dc2626)';
            const changeSign = (result.change_percent || 0) >= 0 ? '+' : '';
            
            item.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; color: var(--text-primary, #0f172a);">
                            ${this.escapeHtml(result.ticker || result.symbol || 'N/A')}
                        </div>
                        <div style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                            ${this.escapeHtml(result.company_name || result.name || 'N/A')}
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 600; color: var(--text-primary, #0f172a);">
                            ${result.current_price ? utils.formatCurrency(result.current_price) : 'N/A'}
                        </div>
                        <div style="font-size: 0.875rem; color: ${changeColor};">
                            ${result.change_percent ? utils.formatPercentage(result.change_percent) : 'N/A'}
                        </div>
                    </div>
                </div>
            `;
            
            // Add hover effects
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'var(--background-tertiary, #f8fafc)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
            });
            
            // Add click handler
            item.addEventListener('click', () => {
                this.selectSearchResult(result);
            });
            
            return item;
        },
        
        selectSearchResult: function(result) {
            const searchInput = utils.safeQuery('.search-input, #stock-search');
            if (searchInput) {
                searchInput.value = result.ticker || result.symbol;
            }
            
            this.hideSearchResults();
            
            // Navigate or emit event
            if (window.location.pathname.includes('/dashboard')) {
                this.updateDashboardStock(result);
            } else {
                const url = new URL('/dashboard/', window.location.origin);
                url.searchParams.set('stock', result.ticker || result.symbol);
                window.location.href = url.toString();
            }
        },
        
        updateDashboardStock: function(stock) {
            const event = new CustomEvent('stockSelected', {
                detail: stock
            });
            document.dispatchEvent(event);
        },
        
        showSearchLoading: function() {
            const container = utils.safeQuery('#search-results');
            if (container) {
                container.innerHTML = `
                    <div style="padding: 16px; text-align: center; color: var(--text-muted, #64748b);">
                        <div class="loading-spinner" style="display: inline-block; margin-bottom: 8px;"></div>
                        <div>Searching...</div>
                    </div>
                `;
                container.style.display = 'block';
            }
        },
        
        showSearchError: function() {
            const container = utils.safeQuery('#search-results');
            if (container) {
                container.innerHTML = `
                    <div style="padding: 16px; text-align: center; color: var(--danger-color, #dc2626);">
                        <div>⚠️ Search failed</div>
                        <div style="font-size: 0.875rem; margin-top: 4px;">Please try again</div>
                    </div>
                `;
                container.style.display = 'block';
            }
        },
        
        showNoResults: function(container, query) {
            container.innerHTML = `
                <div style="padding: 16px; text-align: center; color: var(--text-muted, #64748b);">
                    <div>No results found for "${this.escapeHtml(query)}"</div>
                </div>
            `;
            container.style.display = 'block';
        },
        
        hideSearchResults: function() {
            const container = utils.safeQuery('#search-results');
            if (container) {
                container.style.display = 'none';
            }
        },
        
        escapeHtml: function(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    };
    
    // Enhanced Notification Manager
    const NotificationManager = {
        show: function(message, type = 'info', duration = 5000) {
            const notification = document.createElement('div');
            notification.className = 'rts-notification';
            
            const colors = {
                success: 'var(--success-color, #059669)',
                error: 'var(--danger-color, #dc2626)',
                warning: 'var(--warning-color, #d97706)',
                info: 'var(--accent-color, #2563eb)'
            };
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 16px 24px;
                border-radius: 8px;
                color: white;
                background: ${colors[type] || colors.info};
                z-index: 10000;
                max-width: 400px;
                box-shadow: var(--shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
                transform: translateX(100%);
                transition: transform 0.3s ease;
                font-weight: 500;
            `;
            
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Animate in
            requestAnimationFrame(() => {
                notification.style.transform = 'translateX(0)';
            });
            
            // Auto-remove
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, duration);
            
            return notification;
        }
    };
    
    // Main initialization
    const App = {
        init: function() {
            // Initialize components
            APIManager.init();
            DarkModeManager.init();
            SearchManager.init();
            
            // Initialize page-specific functionality
            this.initPageSpecific();
            
            // Global event listeners
            this.setupGlobalEvents();
        },
        
        initPageSpecific: function() {
            const path = window.location.pathname;
            
            switch (true) {
                case path.includes('/dashboard'):
                    this.initDashboard();
                    break;
                case path.includes('/account'):
                    this.initAccount();
                    break;
                case path.includes('/premium-plans'):
                    this.initPremiumPlans();
                    break;
                case path.includes('/scanner'):
                    this.initScanner();
                    break;
            }
        },
        
        initDashboard: function() {
            // Listen for stock selection events
            document.addEventListener('stockSelected', (e) => {
                // Handle dashboard stock update
            });
        },
        
        initAccount: function() {
            // Account-specific initialization
        },
        
        initPremiumPlans: function() {
            // Premium plans specific initialization
        },
        
        initScanner: function() {
            // Scanner page specific initialization
        },
        
        setupGlobalEvents: function() {
            // Handle keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                // Ctrl/Cmd + K for search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = utils.safeQuery('.search-input, #stock-search');
                    if (searchInput) {
                        SearchManager.expandSearch(searchInput);
                        searchInput.focus();
                    }
                }
                
                // Escape to close search
                if (e.key === 'Escape') {
                    const searchInput = utils.safeQuery('.search-input, #stock-search');
                    if (searchInput) {
                        SearchManager.collapseSearch(searchInput);
                        SearchManager.hideSearchResults();
                    }
                }
            });
        }
    };
    
    // Expose global functions
    window.RetailTradeScanner.init = App.init.bind(App);
    window.RetailTradeScanner.utils = utils;
    window.RetailTradeScanner.notify = NotificationManager.show.bind(NotificationManager);
    window.RetailTradeScanner.darkMode = DarkModeManager;
    
    // Global functions for backward compatibility
    window.showNotification = NotificationManager.show.bind(NotificationManager);
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', App.init.bind(App));
    } else {
        App.init();
    }
    
})();