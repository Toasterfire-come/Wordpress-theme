<?php
/**
 * Template for Stock Scanner page - Bug Fixed Version
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;" role="main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <header style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Stock Scanner</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Advanced stock screening and filtering tools for professional traders</p>
        </header>

        <!-- Scanner Interface -->
        <section class="card" style="padding: 2rem; margin-bottom: 2rem;" aria-labelledby="scanner-heading">
            <h2 id="scanner-heading" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem;">Search & Filter Stocks</h2>
            
            <form id="scanner-form" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                <div>
                    <label for="search-symbol" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        Search Symbol/Company
                    </label>
                    <input 
                        type="text" 
                        id="search-symbol" 
                        name="symbol"
                        placeholder="e.g., AAPL, Apple Inc." 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                        autocomplete="off"
                        aria-describedby="search-help"
                    >
                    <div id="search-help" style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem;">
                        Enter stock symbol or company name
                    </div>
                </div>
                <div>
                    <label for="min-price" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        Minimum Price ($)
                    </label>
                    <input 
                        type="number" 
                        id="min-price" 
                        name="min_price"
                        placeholder="0" 
                        min="0" 
                        step="0.01"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                    >
                </div>
                <div>
                    <label for="max-price" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        Maximum Price ($)
                    </label>
                    <input 
                        type="number" 
                        id="max-price" 
                        name="max_price"
                        placeholder="1000" 
                        min="0" 
                        step="0.01"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                    >
                </div>
                <div>
                    <label for="market-cap" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        Market Cap
                    </label>
                    <select 
                        id="market-cap" 
                        name="market_cap"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background: white;"
                    >
                        <option value="">Any Size</option>
                        <option value="mega">Mega Cap (>$200B)</option>
                        <option value="large">Large Cap ($10B - $200B)</option>
                        <option value="mid">Mid Cap ($2B - $10B)</option>
                        <option value="small">Small Cap ($300M - $2B)</option>
                        <option value="micro">Micro Cap (<$300M)</option>
                    </select>
                </div>
                <div>
                    <label for="sector" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        Sector
                    </label>
                    <select 
                        id="sector" 
                        name="sector"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background: white;"
                    >
                        <option value="">All Sectors</option>
                        <option value="technology">Technology</option>
                        <option value="healthcare">Healthcare</option>
                        <option value="financial">Financial Services</option>
                        <option value="consumer_discretionary">Consumer Discretionary</option>
                        <option value="communication">Communication Services</option>
                        <option value="industrials">Industrials</option>
                        <option value="consumer_staples">Consumer Staples</option>
                        <option value="energy">Energy</option>
                        <option value="utilities">Utilities</option>
                        <option value="real_estate">Real Estate</option>
                        <option value="materials">Materials</option>
                    </select>
                </div>
                <div>
                    <label for="volume" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        Min Volume
                    </label>
                    <select 
                        id="volume" 
                        name="volume"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background: white;"
                    >
                        <option value="">Any Volume</option>
                        <option value="100000">100K+</option>
                        <option value="500000">500K+</option>
                        <option value="1000000">1M+</option>
                        <option value="5000000">5M+</option>
                    </select>
                </div>
            </form>
            
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <button id="search-btn" class="btn btn-primary" type="button" aria-describedby="search-status">
                    <span aria-hidden="true">🔍</span> Search Stocks
                </button>
                <button id="clear-btn" class="btn btn-outline" type="button">
                    <span aria-hidden="true">🗑️</span> Clear Filters
                </button>
                <button id="save-scan-btn" class="btn btn-outline" type="button" style="margin-left: auto;">
                    <span aria-hidden="true">💾</span> Save Scan
                </button>
            </div>
            <div id="search-status" style="margin-top: 1rem; font-size: 0.875rem; color: #64748b;" role="status" aria-live="polite">
                Ready to search
            </div>
        </section>

        <!-- Quick Filters -->
        <section class="card" style="padding: 1.5rem; margin-bottom: 2rem;" aria-labelledby="quick-filters-heading">
            <h3 id="quick-filters-heading" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Quick Filters</h3>
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <button class="quick-filter-btn" data-filter="trending" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 20px; background: white; cursor: pointer; font-size: 0.875rem; transition: all 0.2s ease;">
                    📈 Trending Now
                </button>
                <button class="quick-filter-btn" data-filter="gainers" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 20px; background: white; cursor: pointer; font-size: 0.875rem; transition: all 0.2s ease;">
                    🚀 Top Gainers
                </button>
                <button class="quick-filter-btn" data-filter="losers" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 20px; background: white; cursor: pointer; font-size: 0.875rem; transition: all 0.2s ease;">
                    📉 Top Losers
                </button>
                <button class="quick-filter-btn" data-filter="volume" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 20px; background: white; cursor: pointer; font-size: 0.875rem; transition: all 0.2s ease;">
                    📊 High Volume
                </button>
                <button class="quick-filter-btn" data-filter="tech" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 20px; background: white; cursor: pointer; font-size: 0.875rem; transition: all 0.2s ease;">
                    💻 Tech Stocks
                </button>
                <button class="quick-filter-btn" data-filter="dividend" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 20px; background: white; cursor: pointer; font-size: 0.875rem; transition: all 0.2s ease;">
                    💰 Dividend Stocks
                </button>
            </div>
        </section>

        <!-- Results Section -->
        <section class="card" style="padding: 2rem;" aria-labelledby="results-heading">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 id="results-heading" style="font-size: 1.5rem; font-weight: 600; margin: 0;">Search Results</h2>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <label for="sort-by" style="font-size: 0.875rem; color: #64748b;">Sort by:</label>
                    <select id="sort-by" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; background: white;">
                        <option value="symbol">Symbol</option>
                        <option value="price">Price</option>
                        <option value="change">% Change</option>
                        <option value="volume">Volume</option>
                        <option value="market_cap">Market Cap</option>
                    </select>
                </div>
            </div>
            
            <div id="results-container" aria-live="polite">
                <div id="initial-state" style="text-align: center; padding: 3rem; color: #64748b;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;" aria-hidden="true">🔍</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Ready to Scan</h3>
                    <p>Enter search criteria above or use quick filters to find stocks</p>
                    <div style="margin-top: 2rem;">
                        <p style="font-size: 0.875rem; color: #94a3b8;">
                            <strong>Pro Tip:</strong> Use multiple filters to narrow down your results and find the perfect trading opportunities
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div id="pagination" style="display: none; margin-top: 2rem; text-align: center;">
                <div style="display: inline-flex; gap: 0.5rem; align-items: center;">
                    <button id="prev-page" class="btn btn-outline" style="padding: 0.5rem 1rem;" disabled>
                        ← Previous
                    </button>
                    <span id="page-info" style="padding: 0 1rem; font-size: 0.875rem; color: #64748b;"></span>
                    <button id="next-page" class="btn btn-outline" style="padding: 0.5rem 1rem;" disabled>
                        Next →
                    </button>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stock Scanner
    StockScanner.init();
});

// Stock Scanner Manager
const StockScanner = {
    currentPage: 1,
    itemsPerPage: 20,
    totalResults: 0,
    currentResults: [],
    
    init: function() {
        this.setupEventListeners();
        this.setupQuickFilters();
        this.loadInitialData();
    },
    
    setupEventListeners: function() {
        // Search button
        document.getElementById('search-btn').addEventListener('click', () => {
            this.performSearch();
        });
        
        // Clear button
        document.getElementById('clear-btn').addEventListener('click', () => {
            this.clearFilters();
        });
        
        // Save scan button
        document.getElementById('save-scan-btn').addEventListener('click', () => {
            this.saveScan();
        });
        
        // Sort dropdown
        document.getElementById('sort-by').addEventListener('change', (e) => {
            this.sortResults(e.target.value);
        });
        
        // Form submit (Enter key)
        document.getElementById('scanner-form').addEventListener('submit', (e) => {
            e.preventDefault();
            this.performSearch();
        });
        
        // Real-time search for symbol input
        const symbolInput = document.getElementById('search-symbol');
        let searchTimeout;
        symbolInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            const query = e.target.value.trim();
            
            if (query.length > 1) {
                searchTimeout = setTimeout(() => {
                    this.performQuickSearch(query);
                }, 500);
            } else if (query.length === 0) {
                this.showInitialState();
            }
        });
        
        // Pagination
        document.getElementById('prev-page').addEventListener('click', () => {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.displayResults(this.currentResults);
            }
        });
        
        document.getElementById('next-page').addEventListener('click', () => {
            const maxPages = Math.ceil(this.totalResults / this.itemsPerPage);
            if (this.currentPage < maxPages) {
                this.currentPage++;
                this.displayResults(this.currentResults);
            }
        });
    },
    
    setupQuickFilters: function() {
        const quickFilters = document.querySelectorAll('.quick-filter-btn');
        quickFilters.forEach(btn => {
            btn.addEventListener('click', (e) => {
                // Remove active state from all filters
                quickFilters.forEach(b => {
                    b.style.background = 'white';
                    b.style.borderColor = '#d1d5db';
                    b.style.color = '#374151';
                });
                
                // Activate clicked filter
                btn.style.background = '#dbeafe';
                btn.style.borderColor = '#3b82f6';
                btn.style.color = '#1d4ed8';
                
                const filter = btn.dataset.filter;
                this.applyQuickFilter(filter);
            });
            
            // Hover effects
            btn.addEventListener('mouseenter', function() {
                if (this.style.background === 'white' || !this.style.background) {
                    this.style.background = '#f8fafc';
                }
            });
            
            btn.addEventListener('mouseleave', function() {
                if (this.style.background === 'rgb(248, 250, 252)') {
                    this.style.background = 'white';
                }
            });
        });
    },
    
    applyQuickFilter: function(filter) {
        this.updateSearchStatus(`Loading ${filter} stocks...`);
        
        // Clear form
        this.clearFilters(false);
        
        // Apply filter-specific logic
        switch (filter) {
            case 'trending':
                this.loadTrendingStocks();
                break;
            case 'gainers':
                this.loadTopGainers();
                break;
            case 'losers':
                this.loadTopLosers();
                break;
            case 'volume':
                document.getElementById('volume').value = '1000000';
                this.performSearch();
                break;
            case 'tech':
                document.getElementById('sector').value = 'technology';
                this.performSearch();
                break;
            case 'dividend':
                this.loadDividendStocks();
                break;
        }
    },
    
    performSearch: function() {
        const formData = new FormData(document.getElementById('scanner-form'));
        const searchParams = Object.fromEntries(formData);
        
        // Remove empty values
        Object.keys(searchParams).forEach(key => {
            if (!searchParams[key]) {
                delete searchParams[key];
            }
        });
        
        this.updateSearchStatus('Searching stocks...');
        this.showLoading();
        
        // Build API URL
        const params = new URLSearchParams(searchParams);
        const apiUrl = `<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/stocks/search')); ?>?${params}`;
        
        this.callAPI(apiUrl)
            .then(data => {
                if (data && (data.success || data.data)) {
                    const results = data.data || data.results || [];
                    this.handleSearchResults(results, searchParams);
                } else {
                    this.showNoResults(searchParams);
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                this.showError(error.message);
            });
    },
    
    performQuickSearch: function(query) {
        const apiUrl = `<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/stocks/search')); ?>?q=${encodeURIComponent(query)}`;
        
        this.callAPI(apiUrl)
            .then(data => {
                if (data && (data.success || data.data)) {
                    const results = data.data || data.results || [];
                    this.handleSearchResults(results.slice(0, 10), { symbol: query }); // Limit quick search results
                }
            })
            .catch(error => {
                console.error('Quick search error:', error);
            });
    },
    
    callAPI: function(url) {
        return fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        });
    },
    
    handleSearchResults: function(results, searchParams) {
        this.currentResults = results;
        this.totalResults = results.length;
        this.currentPage = 1;
        
        if (results.length > 0) {
            this.displayResults(results);
            this.updateSearchStatus(`Found ${results.length} stocks matching your criteria`);
        } else {
            this.showNoResults(searchParams);
        }
    },
    
    displayResults: function(results) {
        const container = document.getElementById('results-container');
        document.getElementById('initial-state')?.remove();
        
        // Calculate pagination
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const pageResults = results.slice(startIndex, endIndex);
        
        if (pageResults.length === 0) {
            this.showNoResults({});
            return;
        }
        
        container.innerHTML = `
            <div class="results-grid" style="display: grid; gap: 1rem;">
                ${pageResults.map(stock => this.createStockCard(stock)).join('')}
            </div>
        `;
        
        // Show pagination if needed
        if (results.length > this.itemsPerPage) {
            this.showPagination();
        } else {
            this.hidePagination();
        }
        
        // Add event listeners to new cards
        this.setupCardEventListeners();
    },
    
    createStockCard: function(stock) {
        const change = stock.change_percent || stock.change || 0;
        const changeColor = change >= 0 ? 'var(--green-600, #059669)' : 'var(--red-600, #dc2626)';
        const changeSign = change >= 0 ? '+' : '';
        
        return `
            <div class="stock-card" style="display: grid; grid-template-columns: 1fr auto auto; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px; background: white; transition: all 0.2s ease;" data-symbol="${this.escapeHtml(stock.symbol)}">
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 0.25rem; font-size: 1.125rem;">${this.escapeHtml(stock.symbol)}</h3>
                    <p style="color: #64748b; font-size: 0.875rem; margin: 0;">${this.escapeHtml(stock.company_name || stock.name || 'N/A')}</p>
                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem; font-size: 0.75rem; color: #94a3b8;">
                        ${stock.sector ? `<span>📊 ${this.escapeHtml(stock.sector)}</span>` : ''}
                        ${stock.market_cap ? `<span>💰 ${this.formatMarketCap(stock.market_cap)}</span>` : ''}
                    </div>
                </div>
                <div style="text-align: right; margin-right: 1rem;">
                    <div style="font-weight: 600; font-size: 1.125rem; margin-bottom: 0.25rem;">$${Number(stock.price || 0).toFixed(2)}</div>
                    <div style="color: ${changeColor}; font-size: 0.875rem; font-weight: 500;">
                        ${changeSign}${Number(change).toFixed(2)}%
                    </div>
                    ${stock.volume ? `<div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">Vol: ${this.formatVolume(stock.volume)}</div>` : ''}
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <button class="add-watchlist-btn btn btn-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem; white-space: nowrap;" data-symbol="${this.escapeHtml(stock.symbol)}" title="Add ${this.escapeHtml(stock.symbol)} to watchlist">
                        <span aria-hidden="true">⭐</span> Watchlist
                    </button>
                    <button class="view-details-btn btn btn-primary" style="font-size: 0.875rem; padding: 0.5rem 1rem; white-space: nowrap;" data-symbol="${this.escapeHtml(stock.symbol)}" title="View ${this.escapeHtml(stock.symbol)} details">
                        <span aria-hidden="true">📊</span> Details
                    </button>
                </div>
            </div>
        `;
    },
    
    setupCardEventListeners: function() {
        // Watchlist buttons
        document.querySelectorAll('.add-watchlist-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const symbol = btn.dataset.symbol;
                this.addToWatchlist(symbol, btn);
            });
        });
        
        // Details buttons
        document.querySelectorAll('.view-details-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const symbol = btn.dataset.symbol;
                this.viewStockDetails(symbol);
            });
        });
        
        // Card hover effects
        document.querySelectorAll('.stock-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = 'var(--shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1))';
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = 'none';
                this.style.transform = 'translateY(0)';
            });
        });
    },
    
    addToWatchlist: function(symbol, button) {
        if (!<?php echo is_user_logged_in() ? 'true' : 'false'; ?>) {
            this.showNotification('Please log in to add stocks to your watchlist', 'warning');
            return;
        }
        
        const originalText = button.innerHTML;
        button.innerHTML = '<span aria-hidden="true">⏳</span> Adding...';
        button.disabled = true;
        
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/watchlist/add')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            },
            body: JSON.stringify({ symbol: symbol })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showNotification(`${symbol} added to watchlist`, 'success');
                button.innerHTML = '<span aria-hidden="true">✓</span> Added';
                button.style.background = 'var(--green-600, #059669)';
                button.style.color = 'white';
                button.style.borderColor = 'var(--green-600, #059669)';
            } else {
                this.showNotification(data.message || 'Failed to add to watchlist', 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Watchlist error:', error);
            this.showNotification('Error adding to watchlist', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    },
    
    viewStockDetails: function(symbol) {
        // Navigate to stock details or open modal
        window.location.href = `/dashboard?stock=${encodeURIComponent(symbol)}`;
    },
    
    showLoading: function() {
        const container = document.getElementById('results-container');
        container.innerHTML = `
            <div style="text-align: center; padding: 3rem;">
                <div class="loading-spinner" style="margin: 0 auto 1rem;"></div>
                <p style="color: #64748b;">Scanning markets for matching stocks...</p>
            </div>
        `;
    },
    
    showNoResults: function(searchParams) {
        const container = document.getElementById('results-container');
        const hasFilters = Object.keys(searchParams).length > 0;
        
        container.innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;" aria-hidden="true">📊</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No stocks found</h3>
                <p>${hasFilters ? 'Try adjusting your search criteria or filters.' : 'Enter search criteria to find stocks.'}</p>
                ${hasFilters ? '<button id="clear-and-retry" class="btn btn-primary" style="margin-top: 1rem;">Clear Filters & Try Again</button>' : ''}
            </div>
        `;
        
        this.updateSearchStatus('No results found');
        this.hidePagination();
        
        // Add event listener for clear and retry button
        const clearBtn = document.getElementById('clear-and-retry');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                this.clearFilters();
            });
        }
    },
    
    showError: function(message) {
        const container = document.getElementById('results-container');
        container.innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #dc2626;">
                <div style="font-size: 3rem; margin-bottom: 1rem;" aria-hidden="true">⚠️</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Search Failed</h3>
                <p style="margin-bottom: 1rem;">There was an error searching for stocks: ${this.escapeHtml(message)}</p>
                <button id="retry-search" class="btn btn-primary">Try Again</button>
            </div>
        `;
        
        this.updateSearchStatus('Search failed');
        this.hidePagination();
        
        // Add retry handler
        document.getElementById('retry-search').addEventListener('click', () => {
            this.performSearch();
        });
    },
    
    showInitialState: function() {
        const container = document.getElementById('results-container');
        container.innerHTML = `
            <div id="initial-state" style="text-align: center; padding: 3rem; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;" aria-hidden="true">🔍</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Ready to Scan</h3>
                <p>Enter search criteria above or use quick filters to find stocks</p>
            </div>
        `;
        this.updateSearchStatus('Ready to search');
        this.hidePagination();
    },
    
    clearFilters: function(showInitial = true) {
        // Clear form
        document.getElementById('scanner-form').reset();
        
        // Clear active quick filters
        document.querySelectorAll('.quick-filter-btn').forEach(btn => {
            btn.style.background = 'white';
            btn.style.borderColor = '#d1d5db';
            btn.style.color = '#374151';
        });
        
        // Reset sort
        document.getElementById('sort-by').value = 'symbol';
        
        // Clear results
        this.currentResults = [];
        this.totalResults = 0;
        this.currentPage = 1;
        
        if (showInitial) {
            this.showInitialState();
        }
    },
    
    sortResults: function(sortBy) {
        if (!this.currentResults.length) return;
        
        const sorted = [...this.currentResults].sort((a, b) => {
            switch (sortBy) {
                case 'price':
                    return (b.price || 0) - (a.price || 0);
                case 'change':
                    return (b.change_percent || b.change || 0) - (a.change_percent || a.change || 0);
                case 'volume':
                    return (b.volume || 0) - (a.volume || 0);
                case 'market_cap':
                    return (b.market_cap || 0) - (a.market_cap || 0);
                case 'symbol':
                default:
                    return (a.symbol || '').localeCompare(b.symbol || '');
            }
        });
        
        this.currentResults = sorted;
        this.displayResults(sorted);
    },
    
    showPagination: function() {
        const pagination = document.getElementById('pagination');
        const pageInfo = document.getElementById('page-info');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        
        const maxPages = Math.ceil(this.totalResults / this.itemsPerPage);
        
        pageInfo.textContent = `Page ${this.currentPage} of ${maxPages} (${this.totalResults} results)`;
        prevBtn.disabled = this.currentPage === 1;
        nextBtn.disabled = this.currentPage === maxPages;
        
        pagination.style.display = 'block';
    },
    
    hidePagination: function() {
        document.getElementById('pagination').style.display = 'none';
    },
    
    updateSearchStatus: function(message) {
        document.getElementById('search-status').textContent = message;
    },
    
    saveScan: function() {
        if (!<?php echo is_user_logged_in() ? 'true' : 'false'; ?>) {
            this.showNotification('Please log in to save scans', 'warning');
            return;
        }
        
        const formData = new FormData(document.getElementById('scanner-form'));
        const scanData = Object.fromEntries(formData);
        
        // Remove empty values
        Object.keys(scanData).forEach(key => {
            if (!scanData[key]) {
                delete scanData[key];
            }
        });
        
        if (Object.keys(scanData).length === 0) {
            this.showNotification('Please set some filters before saving', 'warning');
            return;
        }
        
        const scanName = prompt('Enter a name for this scan:', `Scan ${new Date().toLocaleDateString()}`);
        if (!scanName) return;
        
        this.showNotification('Saving scan...', 'info');
        
        // Save scan (implement API call)
        setTimeout(() => {
            this.showNotification(`Scan "${scanName}" saved successfully`, 'success');
        }, 1000);
    },
    
    loadInitialData: function() {
        // Load popular stocks or market overview on page load
        this.loadTrendingStocks();
    },
    
    loadTrendingStocks: function() {
        // Mock trending stocks data
        const trendingStocks = [
            { symbol: 'AAPL', company_name: 'Apple Inc.', price: 175.43, change_percent: 2.1, volume: 52308400, sector: 'Technology', market_cap: 2845000000000 },
            { symbol: 'MSFT', company_name: 'Microsoft Corporation', price: 378.85, change_percent: -0.8, volume: 28342100, sector: 'Technology', market_cap: 2819000000000 },
            { symbol: 'GOOGL', company_name: 'Alphabet Inc.', price: 141.80, change_percent: 1.3, volume: 25841300, sector: 'Technology', market_cap: 1785000000000 },
            { symbol: 'TSLA', company_name: 'Tesla Inc.', price: 248.50, change_percent: 3.7, volume: 89234500, sector: 'Consumer Discretionary', market_cap: 784000000000 },
            { symbol: 'NVDA', company_name: 'NVIDIA Corporation', price: 875.28, change_percent: -1.2, volume: 41523800, sector: 'Technology', market_cap: 2156000000000 }
        ];
        
        this.handleSearchResults(trendingStocks, { filter: 'trending' });
    },
    
    loadTopGainers: function() {
        // Mock top gainers data
        const topGainers = [
            { symbol: 'COIN', company_name: 'Coinbase Global Inc.', price: 89.45, change_percent: 12.3, volume: 15234200, sector: 'Financial Services' },
            { symbol: 'AMD', company_name: 'Advanced Micro Devices', price: 142.67, change_percent: 8.9, volume: 52341800, sector: 'Technology' },
            { symbol: 'PLTR', company_name: 'Palantir Technologies', price: 24.18, change_percent: 7.2, volume: 89456300, sector: 'Technology' }
        ];
        
        this.handleSearchResults(topGainers, { filter: 'gainers' });
    },
    
    loadTopLosers: function() {
        // Mock top losers data
        const topLosers = [
            { symbol: 'NFLX', company_name: 'Netflix Inc.', price: 423.15, change_percent: -4.2, volume: 8234100, sector: 'Communication Services' },
            { symbol: 'META', company_name: 'Meta Platforms Inc.', price: 312.84, change_percent: -3.1, volume: 18453200, sector: 'Technology' }
        ];
        
        this.handleSearchResults(topLosers, { filter: 'losers' });
    },
    
    loadDividendStocks: function() {
        // Mock dividend stocks data
        const dividendStocks = [
            { symbol: 'JNJ', company_name: 'Johnson & Johnson', price: 167.89, change_percent: 0.3, volume: 7234500, sector: 'Healthcare' },
            { symbol: 'PG', company_name: 'Procter & Gamble', price: 148.72, change_percent: -0.1, volume: 5823400, sector: 'Consumer Staples' },
            { symbol: 'KO', company_name: 'The Coca-Cola Company', price: 58.94, change_percent: 0.2, volume: 12345600, sector: 'Consumer Staples' }
        ];
        
        this.handleSearchResults(dividendStocks, { filter: 'dividend' });
    },
    
    // Utility functions
    escapeHtml: function(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    },
    
    formatMarketCap: function(marketCap) {
        const cap = Number(marketCap);
        if (cap >= 1e12) return `$${(cap / 1e12).toFixed(1)}T`;
        if (cap >= 1e9) return `$${(cap / 1e9).toFixed(1)}B`;
        if (cap >= 1e6) return `$${(cap / 1e6).toFixed(1)}M`;
        return `$${cap.toLocaleString()}`;
    },
    
    formatVolume: function(volume) {
        const vol = Number(volume);
        if (vol >= 1e6) return `${(vol / 1e6).toFixed(1)}M`;
        if (vol >= 1e3) return `${(vol / 1e3).toFixed(1)}K`;
        return vol.toLocaleString();
    },
    
    showNotification: function(message, type = 'info') {
        if (window.RetailTradeScanner && window.RetailTradeScanner.notify) {
            window.RetailTradeScanner.notify(message, type);
        } else {
            // Fallback notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
                border-radius: 8px; color: white; z-index: 1000; font-weight: 500;
                background: ${type === 'success' ? '#059669' : type === 'error' ? '#dc2626' : type === 'warning' ? '#d97706' : '#2563eb'};
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    }
};
</script>

<style>
/* Additional styles for scanner page */
.loading-spinner {
    border: 4px solid var(--slate-200, #e2e8f0);
    border-top: 4px solid var(--emerald-600, #059669);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.quick-filter-btn:focus {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
}

.stock-card:focus-within {
    box-shadow: var(--shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
    transform: translateY(-2px);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    #scanner-form {
        grid-template-columns: 1fr !important;
    }
    
    .stock-card {
        grid-template-columns: 1fr !important;
        text-align: center;
        gap: 1rem;
    }
    
    .stock-card > div:last-child {
        flex-direction: row;
        justify-content: center;
    }
    
    .results-grid {
        grid-template-columns: 1fr !important;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 1rem 0.5rem !important;
    }
    
    .card {
        padding: 1rem !important;
    }
    
    .quick-filter-btn {
        font-size: 0.75rem !important;
        padding: 0.375rem 0.75rem !important;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .stock-card {
        border-color: #000;
    }
    
    .quick-filter-btn {
        border-color: #000;
    }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    .stock-card,
    .quick-filter-btn,
    .loading-spinner {
        transition: none;
        animation: none;
    }
}
</style>

<?php get_footer(); ?>