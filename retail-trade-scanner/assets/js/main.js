// Retail Trade Scanner - Main JavaScript
// Professional trading platform with React integration

document.addEventListener("DOMContentLoaded", function() {
    
    // Initialize search bar expansion functionality
    initializeSearchBar();
    
    // Initialize API integration
    initializeAPIIntegration();
    
    // Initialize React integration if available
    initializeReactIntegration();
    
    console.log("Retail Trade Scanner initialized");
});

/**
 * Search Bar Functionality
 */
function initializeSearchBar() {
    const searchInput = document.querySelector(".search-input");
    const searchContainer = document.querySelector(".search-container");
    
    if (searchInput) {
        // Expand search bar on focus
        searchInput.addEventListener("focus", function() {
            this.classList.add("expanded");
            searchContainer.classList.add("active");
        });
        
        // Collapse search bar on blur if no value
        searchInput.addEventListener("blur", function() {
            if (!this.value.trim()) {
                this.classList.remove("expanded");
                searchContainer.classList.remove("active");
            }
        });
        
        // Handle search input
        let searchTimeout;
        searchInput.addEventListener("input", function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length > 1) {
                searchTimeout = setTimeout(() => {
                    performStockSearch(query);
                }, 300);
            }
        });
    }
}

/**
 * Perform stock search via API
 */
function performStockSearch(query) {
    const searchInput = document.querySelector(".search-input");
    if (!searchInput) return;
    
    const apiEndpoint = searchInput.dataset.apiEndpoint;
    if (!apiEndpoint) return;
    
    fetch(`${apiEndpoint}?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            handleSearchResults(data, query);
        })
        .catch(error => {
            console.error('Stock search error:', error);
        });
}

/**
 * Handle search results display
 */
function handleSearchResults(data, query) {
    // Create or update search results dropdown
    let resultsContainer = document.getElementById('search-results');
    
    if (!resultsContainer) {
        resultsContainer = document.createElement('div');
        resultsContainer.id = 'search-results';
        resultsContainer.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        `;
        
        const searchContainer = document.querySelector('.search-container');
        if (searchContainer) {
            searchContainer.style.position = 'relative';
            searchContainer.appendChild(resultsContainer);
        }
    }
    
    // Clear previous results
    resultsContainer.innerHTML = '';
    
    if (data && data.success && data.results && data.results.length > 0) {
        data.results.forEach(stock => {
            const resultItem = document.createElement('div');
            resultItem.style.cssText = `
                padding: 12px 16px;
                border-bottom: 1px solid #f1f5f9;
                cursor: pointer;
                transition: background-color 0.2s;
            `;
            
            resultItem.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; color: #0f172a;">${stock.symbol}</div>
                        <div style="font-size: 0.875rem; color: #64748b;">${stock.company_name || 'N/A'}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 600; color: #0f172a;">$${stock.price || 'N/A'}</div>
                        <div style="font-size: 0.875rem; color: ${(stock.change_percent || 0) >= 0 ? '#059669' : '#dc2626'};">
                            ${stock.change_percent ? (stock.change_percent > 0 ? '+' : '') + stock.change_percent.toFixed(2) + '%' : 'N/A'}
                        </div>
                    </div>
                </div>
            `;
            
            resultItem.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
            });
            
            resultItem.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'white';
            });
            
            resultItem.addEventListener('click', function() {
                selectStock(stock);
            });
            
            resultsContainer.appendChild(resultItem);
        });
        
        resultsContainer.style.display = 'block';
    } else {
        resultsContainer.innerHTML = '<div style="padding: 16px; text-align: center; color: #64748b;">No results found</div>';
        resultsContainer.style.display = 'block';
    }
    
    // Hide results when clicking outside
    setTimeout(() => {
        document.addEventListener('click', function hideResults(e) {
            if (!document.querySelector('.search-container').contains(e.target)) {
                resultsContainer.style.display = 'none';
                document.removeEventListener('click', hideResults);
            }
        });
    }, 100);
}

/**
 * Handle stock selection from search results
 */
function selectStock(stock) {
    const searchInput = document.querySelector(".search-input");
    if (searchInput) {
        searchInput.value = stock.symbol;
    }
    
    const resultsContainer = document.getElementById('search-results');
    if (resultsContainer) {
        resultsContainer.style.display = 'none';
    }
    
    // Navigate to stock detail page or dashboard with stock info
    window.location.href = `/dashboard?stock=${stock.symbol}`;
}

/**
 * API Integration Setup
 */
function initializeAPIIntegration() {
    // Set up global API configuration
    window.RetailTradeScanner = window.RetailTradeScanner || {};
    window.RetailTradeScanner.API = {
        baseURL: window.retail_trade_scanner_data?.rest_url || '/wp-json/retail-trade-scanner/v1/',
        endpoints: window.retail_trade_scanner_data?.api_endpoints || {},
        nonce: window.retail_trade_scanner_data?.nonce || '',
        
        // Generic API call method
        call: function(endpoint, options = {}) {
            const url = this.baseURL + 'proxy/' + endpoint.replace(/^\//, '');
            
            return fetch(url, {
                method: options.method || 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': this.nonce,
                    ...options.headers
                },
                body: options.body ? JSON.stringify(options.body) : undefined,
                ...options
            })
            .then(response => response.json())
            .catch(error => {
                console.error('API call error:', error);
                return { success: false, error: error.message };
            });
        }
    };
}

/**
 * React Integration
 */
function initializeReactIntegration() {
    const reactRoot = document.getElementById('react-root');
    if (reactRoot) {
        // React will mount here when available
        console.log('React root container ready');
        
        // Set up page-specific React components
        const currentPage = window.location.pathname;
        
        switch (currentPage) {
            case '/dashboard':
                initializeDashboard();
                break;
            case '/account':
                initializeAccount();
                break;
            case '/notifications':
                initializeNotifications();
                break;
            case '/billing-history':
                initializeBillingHistory();
                break;
            default:
                console.log('No specific React component for this page');
        }
    }
}

/**
 * Dashboard Page Initialization
 */
function initializeDashboard() {
    console.log('Initializing dashboard...');
    
    // Load dashboard data
    Promise.all([
        window.RetailTradeScanner.API.call('market-data'),
        window.RetailTradeScanner.API.call('portfolio'),
        window.RetailTradeScanner.API.call('watchlist'),
        window.RetailTradeScanner.API.call('news?limit=5')
    ]).then(responses => {
        console.log('Dashboard data loaded:', responses);
    });
}

/**
 * Account Page Initialization  
 */
function initializeAccount() {
    console.log('Initializing account page...');
    
    // Set up account form handlers
    setupAccountForms();
}

/**
 * Notifications Page Initialization
 */
function initializeNotifications() {
    console.log('Initializing notifications page...');
    
    // Load notification settings
    window.RetailTradeScanner.API.call('user/notification-settings')
        .then(data => {
            if (data.success) {
                populateNotificationSettings(data.settings);
            }
        });
}

/**
 * Billing History Page Initialization
 */
function initializeBillingHistory() {
    console.log('Initializing billing history page...');
    
    // Load billing history
    window.RetailTradeScanner.API.call('user/billing-history')
        .then(data => {
            if (data.success) {
                populateBillingHistory(data.history);
            }
        });
}

/**
 * Setup Account Forms (removed 2FA)
 */
function setupAccountForms() {
    // Change Password Form
    const changePasswordForm = document.getElementById('change-password-form');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const passwordData = {
                current_password: formData.get('current_password'),
                new_password: formData.get('new_password'),
                confirm_password: formData.get('confirm_password')
            };
            
            if (passwordData.new_password !== passwordData.confirm_password) {
                showNotification('Passwords do not match', 'error');
                return;
            }
            
            window.RetailTradeScanner.API.call('user/change-password', {
                method: 'POST',
                body: passwordData
            }).then(response => {
                if (response.success) {
                    showNotification('Password changed successfully', 'success');
                    changePasswordForm.reset();
                } else {
                    showNotification(response.error || 'Failed to change password', 'error');
                }
            });
        });
    }
    
    // Update Payment Method Form
    const paymentForm = document.getElementById('payment-method-form');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const paymentData = {
                payment_method: formData.get('payment_method'),
                card_number: formData.get('card_number'),
                expiry_date: formData.get('expiry_date'),
                cvv: formData.get('cvv')
            };
            
            window.RetailTradeScanner.API.call('user/update-payment', {
                method: 'POST',
                body: paymentData
            }).then(response => {
                if (response.success) {
                    showNotification('Payment method updated successfully', 'success');
                } else {
                    showNotification(response.error || 'Failed to update payment method', 'error');
                }
            });
        });
    }
}

/**
 * Populate notification settings
 */
function populateNotificationSettings(settings) {
    if (!settings) return;
    
    Object.keys(settings).forEach(setting => {
        const checkbox = document.getElementById(setting);
        if (checkbox) {
            checkbox.checked = settings[setting];
        }
    });
}

/**
 * Populate billing history
 */
function populateBillingHistory(history) {
    const container = document.getElementById('billing-history-container');
    if (!container || !history) return;
    
    container.innerHTML = history.map(item => `
        <div class="billing-item" style="display: flex; justify-content: space-between; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1rem;">
            <div>
                <div style="font-weight: 600;">${item.description}</div>
                <div style="color: #64748b; font-size: 0.875rem;">${new Date(item.date).toLocaleDateString()}</div>
            </div>
            <div style="text-align: right;">
                <div style="font-weight: 600;">$${item.amount}</div>
                <div style="color: ${item.status === 'paid' ? '#059669' : '#dc2626'}; font-size: 0.875rem;">${item.status}</div>
            </div>
        </div>
    `).join('');
}

/**
 * Show notification to user
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        border-radius: 8px;
        color: white;
        z-index: 10000;
        max-width: 400px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    `;
    
    switch (type) {
        case 'success':
            notification.style.background = '#059669';
            break;
        case 'error':
            notification.style.background = '#dc2626';
            break;
        default:
            notification.style.background = '#2563eb';
    }
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Auto-remove notification after 5 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

/**
 * Update market data in real-time
 */
function updateMarketData() {
    window.RetailTradeScanner.API.call('market-data')
        .then(data => {
            if (data.success && data.market_overview) {
                updateMarketTicker(data.market_overview);
            }
        })
        .catch(error => {
            console.error('Market data update error:', error);
        });
}

/**
 * Update market ticker in header
 */
function updateMarketTicker(marketData) {
    const ticker = document.getElementById('market-ticker');
    if (ticker && marketData) {
        // This would use real market data from your API
        ticker.textContent = '4,789.45 +0.52%';
    }
}

// Initialize market data updates every 3 minutes
setInterval(updateMarketData, 180000);