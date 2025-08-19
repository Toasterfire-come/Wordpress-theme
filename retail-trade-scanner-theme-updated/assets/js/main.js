// Retail Trade Scanner - Main JavaScript - Bug Fixed Version
// Professional trading platform with enhanced error handling and performance

(function() {
    'use strict';

    // Global namespace
    window.RetailTradeScanner = window.RetailTradeScanner || {};
    
    // Configuration
    const config = {
        searchDelay: 300,
        apiTimeout: 10000,
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
        
        // Log function with debug mode check
        log: function(message, type = 'info') {
            if (config.debug || (window.retail_trade_scanner_data && window.retail_trade_scanner_data.debug_mode)) {
                console[type]('[RTS]', message);
            }
        },
        
        // Safe DOM query
        safeQuery: function(selector) {
            try {
                return document.querySelector(selector);
            } catch (e) {
                utils.log(`Invalid selector: ${selector}`, 'error');
                return null;
            }
        },
        
        // Safe DOM query all
        safeQueryAll: function(selector) {
            try {
                return document.querySelectorAll(selector);
            } catch (e) {
                utils.log(`Invalid selector: ${selector}`, 'error');
                return [];
            }
        }
    };
    
    // Search functionality
    const SearchManager = {
        init: function() {
            this.initializeSearchBar();
            this.initializeSearchResults();
        },
        
        initializeSearchBar: function() {
            const searchInput = utils.safeQuery('.search-input, #stock-search');
            const searchToggle = utils.safeQuery('.search-toggle, #search-toggle');
            
            if (!searchInput) {
                utils.log('Search input not found');
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
                // Only collapse if clicking outside and input is empty
                setTimeout(() => {
                    if (!searchInput.value.trim() && !this.isClickInsideSearch(e)) {
                        this.collapseSearch(searchInput);
                    }
                }, 200);
            });
            
            // Search input handling
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
            searchInput.style.background = 'var(--slate-800, #1e293b)';
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
                searchInput.style.background = 'transparent';
                searchInput.classList.remove('expanded');
                
                const container = searchInput.closest('.search-container');
                if (container) {
                    container.classList.remove('active');
                }
            }
        },
        
        isSearchExpanded: function(searchInput) {
            return searchInput.classList.contains('expanded') || 
                   searchInput.style.opacity === '1';
        },
        
        isClickInsideSearch: function(e) {
            const searchContainer = utils.safeQuery('.search-container');
            const searchResults = utils.safeQuery('#search-results');
            
            return (searchContainer && searchContainer.contains(e.target)) ||
                   (searchResults && searchResults.contains(e.target));
        },
        
        performSearch: function(query, searchInput) {
            utils.log(`Performing search for: ${query}`);
            
            const apiEndpoint = searchInput.dataset.apiEndpoint;
            if (!apiEndpoint) {
                utils.log('No API endpoint configured for search');
                return;
            }
            
            // Show loading state
            this.showSearchLoading();
            
            // Make API call
            this.callSearchAPI(apiEndpoint, query)
                .then(data => {
                    this.handleSearchResults(data, query);
                })
                .catch(error => {
                    utils.log(`Search error: ${error.message}`, 'error');
                    this.showSearchError();
                });
        },
        
        callSearchAPI: function(endpoint, query) {
            const url = `${endpoint}?q=${encodeURIComponent(query)}`;
            
            return fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': window.retail_trade_scanner_data?.nonce || ''
                },
                timeout: config.apiTimeout
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            });
        },
        
        initializeSearchResults: function() {
            // Ensure results container exists
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
                        background: white;
                        border: 1px solid var(--slate-200, #e2e8f0);
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
        
        displaySearchResults: function(results, container) {
            container.innerHTML = '';
            
            results.slice(0, 8).forEach(result => { // Limit to 8 results
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
                border-bottom: 1px solid var(--slate-100, #f1f5f9);
                cursor: pointer;
                transition: background-color 0.2s ease;
            `;
            
            const changeColor = (result.change_percent || 0) >= 0 ? 'var(--green-600, #059669)' : 'var(--red-600, #dc2626)';
            const changeSign = (result.change_percent || 0) >= 0 ? '+' : '';
            
            item.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; color: var(--slate-900, #0f172a);">
                            ${this.escapeHtml(result.symbol || 'N/A')}
                        </div>
                        <div style="font-size: 0.875rem; color: var(--slate-600, #64748b);">
                            ${this.escapeHtml(result.company_name || result.name || 'N/A')}
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 600; color: var(--slate-900, #0f172a);">
                            $${result.price ? Number(result.price).toFixed(2) : 'N/A'}
                        </div>
                        <div style="font-size: 0.875rem; color: ${changeColor};">
                            ${result.change_percent ? `${changeSign}${Number(result.change_percent).toFixed(2)}%` : 'N/A'}
                        </div>
                    </div>
                </div>
            `;
            
            // Add hover effects
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'var(--slate-50, #f8fafc)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'white';
            });
            
            // Add click handler
            item.addEventListener('click', () => {
                this.selectSearchResult(result);
            });
            
            return item;
        },
        
        selectSearchResult: function(result) {
            utils.log(`Selected stock: ${result.symbol}`);
            
            // Fill search input with selected symbol
            const searchInput = utils.safeQuery('.search-input, #stock-search');
            if (searchInput) {
                searchInput.value = result.symbol;
            }
            
            // Hide search results
            this.hideSearchResults();
            
            // Navigate or emit event
            if (window.location.pathname === '/dashboard') {
                // Update dashboard with selected stock
                this.updateDashboardStock(result);
            } else {
                // Navigate to dashboard with stock parameter
                const url = new URL('/dashboard', window.location.origin);
                url.searchParams.set('stock', result.symbol);
                window.location.href = url.toString();
            }
        },
        
        updateDashboardStock: function(stock) {
            // Emit custom event for dashboard to handle
            const event = new CustomEvent('stockSelected', {
                detail: stock
            });
            document.dispatchEvent(event);
        },
        
        showSearchLoading: function() {
            const container = utils.safeQuery('#search-results');
            if (container) {
                container.innerHTML = `
                    <div style="padding: 16px; text-align: center; color: var(--slate-600, #64748b);">
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
                    <div style="padding: 16px; text-align: center; color: var(--red-600, #dc2626);">
                        <div>⚠️ Search failed</div>
                        <div style="font-size: 0.875rem; margin-top: 4px;">Please try again</div>
                    </div>
                `;
                container.style.display = 'block';
            }
        },
        
        showNoResults: function(container, query) {
            container.innerHTML = `
                <div style="padding: 16px; text-align: center; color: var(--slate-600, #64748b);">
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
    
    // API Manager
    const APIManager = {
        init: function() {
            this.setupGlobalAPI();
            this.setupErrorHandling();
        },
        
        setupGlobalAPI: function() {
            window.RetailTradeScanner.API = {
                baseURL: window.retail_trade_scanner_data?.rest_url || '/wp-json/retail-trade-scanner/v1/',
                endpoints: window.retail_trade_scanner_data?.api_endpoints || {},
                nonce: window.retail_trade_scanner_data?.nonce || '',
                
                call: function(endpoint, options = {}) {
                    const url = this.baseURL + 'proxy/' + endpoint.replace(/^\//, '');
                    
                    const defaultOptions = {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': this.nonce
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
                                utils.log(`API call failed, retrying (${attempt}/${config.retryAttempts})`, 'warn');
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
                utils.log(`Unhandled promise rejection: ${event.reason}`, 'error');
            });
        }
    };
    
    // Notification Manager
    const NotificationManager = {
        show: function(message, type = 'info', duration = 5000) {
            const notification = document.createElement('div');
            notification.className = 'rts-notification';
            
            const colors = {
                success: 'var(--green-600, #059669)',
                error: 'var(--red-600, #dc2626)',
                warning: 'var(--yellow-600, #d97706)',
                info: 'var(--blue-600, #2563eb)'
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
    
    // Market Data Manager
    const MarketDataManager = {
        init: function() {
            this.updateMarketData();
            this.startPeriodicUpdates();
        },
        
        updateMarketData: function() {
            if (window.RetailTradeScanner.API) {
                window.RetailTradeScanner.API.call('market-data')
                    .then(data => {
                        this.updateMarketTicker(data);
                    })
                    .catch(error => {
                        utils.log(`Market data error: ${error.message}`, 'error');
                    });
            }
        },
        
        updateMarketTicker: function(data) {
            const ticker = utils.safeQuery('#market-ticker');
            if (ticker && data && data.success) {
                // Update with real data or keep default
                const marketValue = data.market_overview?.value || '4,789.45 +0.52%';
                ticker.textContent = marketValue;
            }
        },
        
        startPeriodicUpdates: function() {
            // Update every 3 minutes
            setInterval(() => {
                this.updateMarketData();
            }, 180000);
        }
    };
    
    // Form Manager
    const FormManager = {
        init: function() {
            this.setupFormValidation();
            this.setupFormSubmissions();
        },
        
        setupFormValidation: function() {
            const forms = utils.safeQueryAll('form[data-validate]');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (!this.validateForm(form)) {
                        e.preventDefault();
                    }
                });
            });
        },
        
        setupFormSubmissions: function() {
            // Handle upgrade button clicks
            const upgradeButtons = utils.safeQueryAll('.upgrade-btn');
            upgradeButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    this.handleUpgradeClick(e, button);
                });
            });
        },
        
        validateForm: function(form) {
            let isValid = true;
            const inputs = form.querySelectorAll('input[required], select[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    this.showFieldError(input, 'This field is required');
                    isValid = false;
                } else {
                    this.clearFieldError(input);
                }
            });
            
            return isValid;
        },
        
        showFieldError: function(input, message) {
            this.clearFieldError(input);
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'field-error';
            errorDiv.style.cssText = 'color: var(--red-600, #dc2626); font-size: 0.875rem; margin-top: 0.25rem;';
            errorDiv.textContent = message;
            
            input.parentNode.appendChild(errorDiv);
            input.style.borderColor = 'var(--red-500, #ef4444)';
        },
        
        clearFieldError: function(input) {
            const existingError = input.parentNode.querySelector('.field-error');
            if (existingError) {
                existingError.remove();
            }
            input.style.borderColor = '';
        },
        
        handleUpgradeClick: function(e, button) {
            e.preventDefault();
            
            const level = button.dataset.level;
            const price = button.dataset.price;
            
            if (!window.retail_trade_scanner_data?.is_user_logged_in) {
                NotificationManager.show('Please log in to upgrade your plan', 'warning');
                setTimeout(() => {
                    window.location.href = '/wp-login.php';
                }, 1500);
                return;
            }
            
            if (window.retail_trade_scanner_data?.plugin_active) {
                // Redirect to plugin checkout if available
                if (typeof window.pmpro_url === 'function') {
                    window.location.href = window.pmpro_url('checkout', `?level=${level}`);
                } else {
                    window.location.href = `/membership-checkout/?level=${level}`;
                }
            } else {
                NotificationManager.show('Stock Scanner Plugin required for subscription management.', 'error');
            }
        }
    };
    
    // Main initialization
    const App = {
        init: function() {
            utils.log('Initializing Retail Trade Scanner');
            
            // Initialize components
            APIManager.init();
            SearchManager.init();
            MarketDataManager.init();
            FormManager.init();
            
            // Initialize page-specific functionality
            this.initPageSpecific();
            
            // Global event listeners
            this.setupGlobalEvents();
            
            utils.log('Retail Trade Scanner initialized successfully');
        },
        
        initPageSpecific: function() {
            const path = window.location.pathname;
            
            switch (path) {
                case '/dashboard':
                case '/dashboard/':
                    this.initDashboard();
                    break;
                case '/account':
                case '/account/':
                    this.initAccount();
                    break;
                case '/premium-plans':
                case '/premium-plans/':
                    this.initPremiumPlans();
                    break;
            }
        },
        
        initDashboard: function() {
            utils.log('Initializing dashboard');
            
            // Listen for stock selection events
            document.addEventListener('stockSelected', (e) => {
                utils.log(`Dashboard received stock selection: ${e.detail.symbol}`);
                // Handle dashboard stock update
            });
        },
        
        initAccount: function() {
            utils.log('Initializing account page');
            // Account-specific initialization
        },
        
        initPremiumPlans: function() {
            utils.log('Initializing premium plans page');
            // Premium plans specific initialization
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
    
    // Global functions for backward compatibility
    window.showNotification = NotificationManager.show.bind(NotificationManager);
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', App.init.bind(App));
    } else {
        App.init();
    }
    
})();