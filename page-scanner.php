<?php
/**
 * Template for Stock Scanner page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1600px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                <?php _e('Stock Scanner', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #64748b;">
                <?php _e('Advanced stock screening with 50+ technical and fundamental filters', 'retail-trade-scanner'); ?>
            </p>
        </div>

        <!-- Scanner Layout -->
        <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem;">
            
            <!-- Filter Sidebar -->
            <div class="scanner-filters" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); height: fit-content; position: sticky; top: 2rem;">
                
                <!-- Filter Header -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                        <?php _e('Filters', 'retail-trade-scanner'); ?>
                    </h3>
                    <button id="clear-filters" style="background: none; border: none; color: #059669; font-size: 0.875rem; cursor: pointer; text-decoration: underline;">
                        <?php _e('Clear All', 'retail-trade-scanner'); ?>
                    </button>
                </div>

                <!-- Quick Presets -->
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Quick Presets', 'retail-trade-scanner'); ?>
                    </h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <button class="preset-btn" data-preset="momentum" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white; text-align: left; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            📈 <?php _e('Momentum Stocks', 'retail-trade-scanner'); ?>
                        </button>
                        <button class="preset-btn" data-preset="value" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white; text-align: left; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            💎 <?php _e('Value Stocks', 'retail-trade-scanner'); ?>
                        </button>
                        <button class="preset-btn" data-preset="breakout" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white; text-align: left; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            🚀 <?php _e('Breakout Candidates', 'retail-trade-scanner'); ?>
                        </button>
                        <button class="preset-btn" data-preset="dividend" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white; text-align: left; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            💰 <?php _e('Dividend Stocks', 'retail-trade-scanner'); ?>
                        </button>
                    </div>
                </div>

                <!-- Price Range -->
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Price Range', 'retail-trade-scanner'); ?>
                    </h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <input type="number" id="price-min" placeholder="Min" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.875rem;">
                        <input type="number" id="price-max" placeholder="Max" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.875rem;">
                    </div>
                </div>

                <!-- Market Cap -->
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Market Cap', 'retail-trade-scanner'); ?>
                    </h4>
                    <select id="market-cap" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white; font-size: 0.875rem;">
                        <option value="">All</option>
                        <option value="mega">Mega Cap (>$200B)</option>
                        <option value="large">Large Cap ($10B-$200B)</option>
                        <option value="mid">Mid Cap ($2B-$10B)</option>
                        <option value="small">Small Cap ($300M-$2B)</option>
                        <option value="micro">Micro Cap (<$300M)</option>
                    </select>
                </div>

                <!-- Volume -->
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Volume', 'retail-trade-scanner'); ?>
                    </h4>
                    <input type="number" id="volume-min" placeholder="Min Volume" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.875rem;">
                </div>

                <!-- Performance -->
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Performance', 'retail-trade-scanner'); ?>
                    </h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <input type="number" id="change-1d-min" placeholder="1D Min %" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.875rem;">
                        <input type="number" id="change-1d-max" placeholder="1D Max %" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.875rem;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <input type="number" id="change-1w-min" placeholder="1W Min %" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.875rem;">
                        <input type="number" id="change-1w-max" placeholder="1W Max %" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.875rem;">
                    </div>
                </div>

                <!-- Technical Indicators -->
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Technical', 'retail-trade-scanner'); ?>
                    </h4>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                            <input type="checkbox" id="rsi-oversold" style="margin: 0;">
                            <span><?php _e('RSI Oversold (<30)', 'retail-trade-scanner'); ?></span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                            <input type="checkbox" id="rsi-overbought" style="margin: 0;">
                            <span><?php _e('RSI Overbought (>70)', 'retail-trade-scanner'); ?></span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                            <input type="checkbox" id="above-sma20" style="margin: 0;">
                            <span><?php _e('Above SMA 20', 'retail-trade-scanner'); ?></span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                            <input type="checkbox" id="above-sma50" style="margin: 0;">
                            <span><?php _e('Above SMA 50', 'retail-trade-scanner'); ?></span>
                        </label>
                    </div>
                </div>

                <!-- Apply Filters Button -->
                <button id="apply-filters" style="width: 100%; background: #059669; color: white; padding: 1rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;">
                    <?php _e('Apply Filters', 'retail-trade-scanner'); ?>
                </button>
            </div>

            <!-- Results Area -->
            <div class="scanner-results">
                
                <!-- Results Header -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <h3 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: #0f172a;">
                                <?php _e('Scan Results', 'retail-trade-scanner'); ?>
                            </h3>
                            <p id="results-count" style="color: #64748b; margin: 0; font-size: 0.875rem;">
                                <?php _e('Loading...', 'retail-trade-scanner'); ?>
                            </p>
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <select id="sort-by" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white;">
                                <option value="volume">Volume</option>
                                <option value="change">% Change</option>
                                <option value="price">Price</option>
                                <option value="market_cap">Market Cap</option>
                            </select>
                            <button id="export-results" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                                📊 <?php _e('Export', 'retail-trade-scanner'); ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Results Table -->
                <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); overflow: hidden;">
                    <div id="results-table" style="overflow-x: auto;">
                        <!-- Results populated by JavaScript -->
                    </div>
                </div>

                <!-- Load More -->
                <div style="text-align: center; margin-top: 2rem;">
                    <button id="load-more" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 1rem 2rem; border-radius: 8px; cursor: pointer; font-weight: 500; display: none;">
                        <?php _e('Load More Results', 'retail-trade-scanner'); ?>
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</main>

<script>
// Stock Scanner page JavaScript
let currentResults = [];
let currentPage = 1;
const resultsPerPage = 50;

document.addEventListener('DOMContentLoaded', function() {
    initializeScanner();
    loadDefaultResults();
    setupEventListeners();
});

function initializeScanner() {
    // Initialize with default settings
    loadDefaultResults();
}

function setupEventListeners() {
    // Apply filters button
    document.getElementById('apply-filters').addEventListener('click', applyFilters);
    
    // Clear filters button
    document.getElementById('clear-filters').addEventListener('click', clearAllFilters);
    
    // Preset buttons
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            applyPreset(this.dataset.preset);
        });
    });
    
    // Sort dropdown
    document.getElementById('sort-by').addEventListener('change', function() {
        sortResults(this.value);
    });
    
    // Export button
    document.getElementById('export-results').addEventListener('click', exportResults);
    
    // Load more button
    document.getElementById('load-more').addEventListener('click', loadMoreResults);
    
    // Real-time filtering on input changes
    const inputs = ['price-min', 'price-max', 'volume-min', 'change-1d-min', 'change-1d-max', 'change-1w-min', 'change-1w-max'];
    inputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', debounce(applyFilters, 500));
        }
    });
    
    // Market cap and checkbox changes
    document.getElementById('market-cap').addEventListener('change', applyFilters);
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
    });
}

function loadDefaultResults() {
    // Mock stock data for demonstration
    currentResults = [
        { symbol: 'AAPL', name: 'Apple Inc.', price: 195.45, change: 8.92, percent: 4.78, volume: '125.8M', market_cap: '3.1T', rsi: 65, sector: 'Technology' },
        { symbol: 'MSFT', name: 'Microsoft Corporation', price: 378.20, change: 15.40, percent: 4.24, volume: '48.9M', market_cap: '2.8T', rsi: 58, sector: 'Technology' },
        { symbol: 'NVDA', name: 'NVIDIA Corporation', price: 875.30, change: 45.20, percent: 5.45, volume: '25.3M', market_cap: '2.2T', rsi: 72, sector: 'Technology' },
        { symbol: 'GOOGL', name: 'Alphabet Inc.', price: 142.30, change: -5.20, percent: -3.53, volume: '22.7M', market_cap: '1.8T', rsi: 42, sector: 'Communication' },
        { symbol: 'AMZN', name: 'Amazon.com Inc.', price: 145.20, change: -4.80, percent: -3.20, volume: '35.4M', market_cap: '1.5T', rsi: 38, sector: 'Consumer Discretionary' },
        { symbol: 'TSLA', name: 'Tesla Inc.', price: 248.50, change: 12.80, percent: 5.42, volume: '68.7M', market_cap: '789B', rsi: 68, sector: 'Consumer Discretionary' },
        { symbol: 'META', name: 'Meta Platforms Inc.', price: 485.20, change: -25.30, percent: -4.95, volume: '15.2M', market_cap: '1.2T', rsi: 35, sector: 'Communication' },
        { symbol: 'AMD', name: 'Advanced Micro Devices', price: 145.67, change: 7.23, percent: 5.23, volume: '22.1M', market_cap: '235B', rsi: 66, sector: 'Technology' },
        { symbol: 'NFLX', name: 'Netflix Inc.', price: 445.67, change: -18.45, percent: -3.98, volume: '8.9M', market_cap: '198B', rsi: 41, sector: 'Communication' },
        { symbol: 'CRM', name: 'Salesforce Inc.', price: 267.45, change: -7.95, percent: -2.89, volume: '12.1M', market_cap: '265B', rsi: 44, sector: 'Technology' }
    ];
    
    displayResults(currentResults);
    updateResultsCount(currentResults.length);
}

function applyFilters() {
    const filters = getFilterValues();
    let filteredResults = [...currentResults];
    
    // Apply price range filter
    if (filters.priceMin) {
        filteredResults = filteredResults.filter(stock => stock.price >= filters.priceMin);
    }
    if (filters.priceMax) {
        filteredResults = filteredResults.filter(stock => stock.price <= filters.priceMax);
    }
    
    // Apply volume filter
    if (filters.volumeMin) {
        filteredResults = filteredResults.filter(stock => parseFloat(stock.volume) >= filters.volumeMin);
    }
    
    // Apply performance filters
    if (filters.change1dMin) {
        filteredResults = filteredResults.filter(stock => stock.percent >= filters.change1dMin);
    }
    if (filters.change1dMax) {
        filteredResults = filteredResults.filter(stock => stock.percent <= filters.change1dMax);
    }
    
    // Apply technical filters
    if (filters.rsiOversold) {
        filteredResults = filteredResults.filter(stock => stock.rsi < 30);
    }
    if (filters.rsiOverbought) {
        filteredResults = filteredResults.filter(stock => stock.rsi > 70);
    }
    
    displayResults(filteredResults);
    updateResultsCount(filteredResults.length);
}

function getFilterValues() {
    return {
        priceMin: parseFloat(document.getElementById('price-min').value) || null,
        priceMax: parseFloat(document.getElementById('price-max').value) || null,
        volumeMin: parseFloat(document.getElementById('volume-min').value) || null,
        change1dMin: parseFloat(document.getElementById('change-1d-min').value) || null,
        change1dMax: parseFloat(document.getElementById('change-1d-max').value) || null,
        change1wMin: parseFloat(document.getElementById('change-1w-min').value) || null,
        change1wMax: parseFloat(document.getElementById('change-1w-max').value) || null,
        marketCap: document.getElementById('market-cap').value,
        rsiOversold: document.getElementById('rsi-oversold').checked,
        rsiOverbought: document.getElementById('rsi-overbought').checked,
        aboveSma20: document.getElementById('above-sma20').checked,
        aboveSma50: document.getElementById('above-sma50').checked
    };
}

function applyPreset(preset) {
    clearAllFilters();
    
    switch (preset) {
        case 'momentum':
            document.getElementById('change-1d-min').value = '2';
            document.getElementById('volume-min').value = '1000000';
            document.getElementById('above-sma20').checked = true;
            break;
        case 'value':
            document.getElementById('change-1d-max').value = '1';
            document.getElementById('market-cap').value = 'large';
            break;
        case 'breakout':
            document.getElementById('change-1d-min').value = '5';
            document.getElementById('volume-min').value = '2000000';
            document.getElementById('above-sma50').checked = true;
            break;
        case 'dividend':
            document.getElementById('market-cap').value = 'large';
            document.getElementById('change-1d-min').value = '-2';
            document.getElementById('change-1d-max').value = '2';
            break;
    }
    
    // Highlight selected preset
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.style.background = 'white';
        btn.style.borderColor = '#e2e8f0';
    });
    document.querySelector(`[data-preset="${preset}"]`).style.background = '#f0fdf4';
    document.querySelector(`[data-preset="${preset}"]`).style.borderColor = '#059669';
    
    applyFilters();
}

function clearAllFilters() {
    document.getElementById('price-min').value = '';
    document.getElementById('price-max').value = '';
    document.getElementById('volume-min').value = '';
    document.getElementById('change-1d-min').value = '';
    document.getElementById('change-1d-max').value = '';
    document.getElementById('change-1w-min').value = '';
    document.getElementById('change-1w-max').value = '';
    document.getElementById('market-cap').value = '';
    
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.style.background = 'white';
        btn.style.borderColor = '#e2e8f0';
    });
    
    loadDefaultResults();
}

function displayResults(results) {
    const container = document.getElementById('results-table');
    
    if (results.length === 0) {
        container.innerHTML = `
            <div style="padding: 3rem; text-align: center; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                <h3 style="margin-bottom: 0.5rem;">No stocks match your criteria</h3>
                <p>Try adjusting your filters to see more results.</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Symbol</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Name</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">Price</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">Change</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">Volume</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">Market Cap</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">RSI</th>
                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                ${results.map(stock => `
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='white'">
                        <td style="padding: 1rem;">
                            <div style="font-weight: 600; color: #0f172a;">${stock.symbol}</div>
                            <div style="font-size: 0.75rem; color: #64748b;">${stock.sector}</div>
                        </td>
                        <td style="padding: 1rem; color: #374151;">${stock.name}</td>
                        <td style="padding: 1rem; text-align: right; font-weight: 600; color: #0f172a;">$${stock.price}</td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="font-weight: 500; color: ${stock.change >= 0 ? '#10b981' : '#ef4444'};">
                                ${stock.change >= 0 ? '+' : ''}${stock.change}
                            </div>
                            <div style="font-size: 0.875rem; color: ${stock.percent >= 0 ? '#10b981' : '#ef4444'};">
                                ${stock.percent >= 0 ? '+' : ''}${stock.percent}%
                            </div>
                        </td>
                        <td style="padding: 1rem; text-align: right; color: #374151;">${stock.volume}</td>
                        <td style="padding: 1rem; text-align: right; color: #374151;">${stock.market_cap}</td>
                        <td style="padding: 1rem; text-align: right;">
                            <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; background: ${stock.rsi > 70 ? '#fee2e2' : stock.rsi < 30 ? '#dcfce7' : '#f1f5f9'}; color: ${stock.rsi > 70 ? '#dc2626' : stock.rsi < 30 ? '#059669' : '#64748b'};">
                                ${stock.rsi}
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <button onclick="addToWatchlist('${stock.symbol}')" style="background: #059669; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.75rem; margin-right: 0.5rem;">
                                + Watchlist
                            </button>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}

function sortResults(sortBy) {
    let sorted = [...currentResults];
    
    switch (sortBy) {
        case 'volume':
            sorted.sort((a, b) => parseFloat(b.volume) - parseFloat(a.volume));
            break;
        case 'change':
            sorted.sort((a, b) => b.percent - a.percent);
            break;
        case 'price':
            sorted.sort((a, b) => b.price - a.price);
            break;
        case 'market_cap':
            sorted.sort((a, b) => parseFloat(b.market_cap) - parseFloat(a.market_cap));
            break;
    }
    
    displayResults(sorted);
}

function updateResultsCount(count) {
    document.getElementById('results-count').textContent = `${count} stocks found`;
}

function addToWatchlist(symbol) {
    // Mock add to watchlist functionality
    alert(`${symbol} added to watchlist!`);
}

function exportResults() {
    // Mock export functionality
    alert('Results exported to CSV!');
}

function loadMoreResults() {
    // Mock load more functionality
    alert('Loading more results...');
}

// Utility function for debouncing
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>

<?php get_footer(); ?>