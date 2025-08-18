<?php
/**
 * Template for Stock Scanner page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Stock Scanner</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Advanced stock screening and filtering tools</p>
        </div>

        <!-- Scanner Interface -->
        <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem;">Search & Filter Stocks</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Search Symbol/Company</label>
                    <input type="text" id="search-input" placeholder="e.g., AAPL, Apple Inc." style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Min Price</label>
                    <input type="number" id="min-price" placeholder="0" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Max Price</label>
                    <input type="number" id="max-price" placeholder="1000" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button id="search-btn" class="btn btn-primary">Search Stocks</button>
                <button id="clear-btn" class="btn btn-outline">Clear Filters</button>
            </div>
        </div>

        <!-- Results Section -->
        <div class="card" style="padding: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem;">Search Results</h2>
            <div id="results-container">
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                    <p>Enter search criteria above to find stocks</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('search-btn');
    const clearBtn = document.getElementById('clear-btn');
    const resultsContainer = document.getElementById('results-container');
    
    searchBtn.addEventListener('click', performSearch);
    clearBtn.addEventListener('click', clearFilters);
    
    function performSearch() {
        const searchTerm = document.getElementById('search-input').value;
        const minPrice = document.getElementById('min-price').value;
        const maxPrice = document.getElementById('max-price').value;
        
        resultsContainer.innerHTML = '<div style="text-align: center; padding: 2rem;"><div class="loading-spinner"></div><p>Searching...</p></div>';
        
        const params = new URLSearchParams();
        if (searchTerm) params.append('q', searchTerm);
        if (minPrice) params.append('min_price', minPrice);
        if (maxPrice) params.append('max_price', maxPrice);
        
        fetch(`<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/stocks/search')); ?>?${params}`, {
            headers: {
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                displayResults(data.data);
            } else {
                displayNoResults();
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            displayError();
        });
    }
    
    function displayResults(stocks) {
        if (stocks.length === 0) {
            displayNoResults();
            return;
        }
        
        resultsContainer.innerHTML = `
            <div style="display: grid; gap: 1rem;">
                ${stocks.map(stock => `
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px; background: white;">
                        <div>
                            <h3 style="font-weight: 600; margin-bottom: 0.25rem;">${stock.symbol}</h3>
                            <p style="color: #64748b; font-size: 0.875rem;">${stock.name || 'N/A'}</p>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 600; font-size: 1.125rem;">$${(stock.price || 0).toFixed(2)}</div>
                            <div style="color: ${(stock.change || 0) >= 0 ? '#059669' : '#dc2626'}; font-size: 0.875rem;">
                                ${(stock.change || 0) >= 0 ? '+' : ''}${(stock.change_percent || 0).toFixed(2)}%
                            </div>
                        </div>
                        <div>
                            <button onclick="addToWatchlist('${stock.symbol}')" class="btn btn-outline" style="font-size: 0.875rem;">
                                Add to Watchlist
                            </button>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    function displayNoResults() {
        resultsContainer.innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No stocks found</h3>
                <p>Try adjusting your search criteria or filters.</p>
            </div>
        `;
    }
    
    function displayError() {
        resultsContainer.innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #dc2626;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">⚠️</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Search failed</h3>
                <p>There was an error searching for stocks. Please try again.</p>
            </div>
        `;
    }
    
    function clearFilters() {
        document.getElementById('search-input').value = '';
        document.getElementById('min-price').value = '';
        document.getElementById('max-price').value = '';
        resultsContainer.innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                <p>Enter search criteria above to find stocks</p>
            </div>
        `;
    }
});

function addToWatchlist(symbol) {
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
            showNotification(`${symbol} added to watchlist`, 'success');
        } else {
            showNotification('Failed to add to watchlist', 'error');
        }
    })
    .catch(error => {
        showNotification('Error adding to watchlist', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
        border-radius: 8px; color: white; z-index: 1000; font-weight: 500;
        background: ${type === 'success' ? '#059669' : '#dc2626'};
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php get_footer(); ?>