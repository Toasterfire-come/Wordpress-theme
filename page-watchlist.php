<?php
/**
 * Template for Watchlist page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <div>
                    <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                        <?php _e('My Watchlist', 'retail-trade-scanner'); ?>
                    </h1>
                    <p style="font-size: 1.25rem; color: #64748b;">
                        <?php _e('Track your favorite stocks with real-time updates', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button id="add-stock-btn" style="background: #059669; color: white; padding: 1rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                        <span>+</span>
                        <?php _e('Add Stock', 'retail-trade-scanner'); ?>
                    </button>
                    <button id="create-list-btn" style="background: white; border: 2px solid #e2e8f0; color: #374151; padding: 1rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <?php _e('New List', 'retail-trade-scanner'); ?>
                    </button>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div id="watchlist-status" style="display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></div>
                    <span style="font-size: 0.875rem; color: #059669; font-weight: 500;">Live Updates</span>
                </div>
                <span style="color: #cbd5e1;">•</span>
                <span id="last-updated" style="font-size: 0.875rem; color: #64748b;">Last updated: --</span>
            </div>
        </div>

        <!-- Watchlist Tabs -->
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; gap: 0.5rem; border-bottom: 2px solid #f1f5f9;">
                <button class="watchlist-tab active" data-tab="default" style="padding: 1rem 1.5rem; border: none; background: none; font-weight: 600; color: #059669; border-bottom: 2px solid #059669; cursor: pointer;">
                    <?php _e('Default List', 'retail-trade-scanner'); ?>
                    <span style="background: #dcfce7; color: #059669; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; margin-left: 0.5rem;">8</span>
                </button>
                <button class="watchlist-tab" data-tab="tech" style="padding: 1rem 1.5rem; border: none; background: none; font-weight: 500; color: #64748b; cursor: pointer;">
                    <?php _e('Tech Stocks', 'retail-trade-scanner'); ?>
                    <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; margin-left: 0.5rem;">5</span>
                </button>
                <button class="watchlist-tab" data-tab="dividend" style="padding: 1rem 1.5rem; border: none; background: none; font-weight: 500; color: #64748b; cursor: pointer;">
                    <?php _e('Dividend Stocks', 'retail-trade-scanner'); ?>
                    <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; margin-left: 0.5rem;">3</span>
                </button>
                <button class="watchlist-tab" data-tab="crypto" style="padding: 1rem 1.5rem; border: none; background: none; font-weight: 500; color: #64748b; cursor: pointer;">
                    <?php _e('Crypto', 'retail-trade-scanner'); ?>
                    <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; margin-left: 0.5rem;">4</span>
                </button>
            </div>
        </div>

        <!-- Watchlist Controls -->
        <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <label style="font-size: 0.875rem; font-weight: 500; color: #374151;">Sort by:</label>
                        <select id="sort-watchlist" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white;">
                            <option value="symbol">Symbol</option>
                            <option value="change">% Change</option>
                            <option value="price">Price</option>
                            <option value="volume">Volume</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <label style="font-size: 0.875rem; font-weight: 500; color: #374151;">View:</label>
                        <button id="grid-view" class="view-btn active" data-view="grid" style="padding: 0.5rem; border: 1px solid #059669; background: #059669; color: white; border-radius: 4px; cursor: pointer;">
                            ⊞
                        </button>
                        <button id="list-view" class="view-btn" data-view="list" style="padding: 0.5rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 4px; cursor: pointer;">
                            ☰
                        </button>
                    </div>
                </div>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button id="bulk-remove" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                        <?php _e('Remove Selected', 'retail-trade-scanner'); ?>
                    </button>
                    <button id="export-watchlist" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                        📊 <?php _e('Export', 'retail-trade-scanner'); ?>
                    </button>
                </div>
            </div>
        </div>

        <!-- Watchlist Content -->
        <div id="watchlist-content">
            <!-- Content populated by JavaScript -->
        </div>

        <!-- Quick Add Stock Modal -->
        <div id="add-stock-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
            <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: #0f172a;">
                        <?php _e('Add Stock to Watchlist', 'retail-trade-scanner'); ?>
                    </h3>
                    <button id="close-modal" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">×</button>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        <?php _e('Stock Symbol', 'retail-trade-scanner'); ?>
                    </label>
                    <input type="text" id="stock-symbol-input" placeholder="e.g., AAPL, MSFT, TSLA" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 1rem;">
                    <div id="symbol-suggestions" style="margin-top: 0.5rem;">
                        <!-- Suggestions populated by JavaScript -->
                    </div>
                </div>
                
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        <?php _e('Add to List', 'retail-trade-scanner'); ?>
                    </label>
                    <select id="target-list" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white;">
                        <option value="default">Default List</option>
                        <option value="tech">Tech Stocks</option>
                        <option value="dividend">Dividend Stocks</option>
                        <option value="crypto">Crypto</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button id="cancel-add" style="background: white; border: 1px solid #e2e8f0; color: #374151; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 500;">
                        <?php _e('Cancel', 'retail-trade-scanner'); ?>
                    </button>
                    <button id="confirm-add" style="background: #059669; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                        <?php _e('Add Stock', 'retail-trade-scanner'); ?>
                    </button>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
// Watchlist page JavaScript
let currentWatchlist = 'default';
let currentView = 'grid';
let watchlistData = {
    default: [
        { symbol: 'AAPL', name: 'Apple Inc.', price: 195.45, change: 8.92, percent: 4.78, volume: '125.8M', alerts: 2 },
        { symbol: 'MSFT', name: 'Microsoft Corporation', price: 378.20, change: 15.40, percent: 4.24, volume: '48.9M', alerts: 0 },
        { symbol: 'GOOGL', name: 'Alphabet Inc.', price: 142.30, change: -5.20, percent: -3.53, volume: '22.7M', alerts: 1 },
        { symbol: 'AMZN', name: 'Amazon.com Inc.', price: 145.20, change: -4.80, percent: -3.20, volume: '35.4M', alerts: 0 },
        { symbol: 'TSLA', name: 'Tesla Inc.', price: 248.50, change: 12.80, percent: 5.42, volume: '68.7M', alerts: 3 },
        { symbol: 'NVDA', name: 'NVIDIA Corporation', price: 875.30, change: 45.20, percent: 5.45, volume: '25.3M', alerts: 1 },
        { symbol: 'META', name: 'Meta Platforms Inc.', price: 485.20, change: -25.30, percent: -4.95, volume: '15.2M', alerts: 0 },
        { symbol: 'NFLX', name: 'Netflix Inc.', price: 445.67, change: -18.45, percent: -3.98, volume: '8.9M', alerts: 0 }
    ],
    tech: [
        { symbol: 'AAPL', name: 'Apple Inc.', price: 195.45, change: 8.92, percent: 4.78, volume: '125.8M', alerts: 2 },
        { symbol: 'MSFT', name: 'Microsoft Corporation', price: 378.20, change: 15.40, percent: 4.24, volume: '48.9M', alerts: 0 },
        { symbol: 'GOOGL', name: 'Alphabet Inc.', price: 142.30, change: -5.20, percent: -3.53, volume: '22.7M', alerts: 1 },
        { symbol: 'NVDA', name: 'NVIDIA Corporation', price: 875.30, change: 45.20, percent: 5.45, volume: '25.3M', alerts: 1 },
        { symbol: 'AMD', name: 'Advanced Micro Devices', price: 145.67, change: 7.23, percent: 5.23, volume: '22.1M', alerts: 0 }
    ],
    dividend: [
        { symbol: 'JNJ', name: 'Johnson & Johnson', price: 165.45, change: 1.20, percent: 0.73, volume: '8.2M', alerts: 0 },
        { symbol: 'PG', name: 'Procter & Gamble', price: 155.30, change: 0.85, percent: 0.55, volume: '6.1M', alerts: 1 },
        { symbol: 'KO', name: 'The Coca-Cola Company', price: 58.90, change: -0.45, percent: -0.76, volume: '12.5M', alerts: 0 }
    ],
    crypto: [
        { symbol: 'BTC', name: 'Bitcoin', price: 43250.00, change: 1250.00, percent: 2.98, volume: '28.5B', alerts: 2 },
        { symbol: 'ETH', name: 'Ethereum', price: 2650.00, change: -85.50, percent: -3.13, volume: '15.2B', alerts: 1 },
        { symbol: 'ADA', name: 'Cardano', price: 0.48, change: 0.02, percent: 4.35, volume: '890M', alerts: 0 },
        { symbol: 'SOL', name: 'Solana', price: 98.75, change: 5.25, percent: 5.62, volume: '2.1B', alerts: 0 }
    ]
};

document.addEventListener('DOMContentLoaded', function() {
    initializeWatchlist();
    setupEventListeners();
    updateLastUpdated();
    
    // Set up auto-refresh
    setInterval(function() {
        refreshWatchlistData();
        updateLastUpdated();
    }, 180000); // Refresh every 3 minutes
});

function initializeWatchlist() {
    displayWatchlist();
}

function setupEventListeners() {
    // Tab switching
    document.querySelectorAll('.watchlist-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            switchTab(this.dataset.tab);
        });
    });
    
    // View switching
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            switchView(this.dataset.view);
        });
    });
    
    // Sort dropdown
    document.getElementById('sort-watchlist').addEventListener('change', function() {
        sortWatchlist(this.value);
    });
    
    // Add stock modal
    document.getElementById('add-stock-btn').addEventListener('click', openAddStockModal);
    document.getElementById('close-modal').addEventListener('click', closeAddStockModal);
    document.getElementById('cancel-add').addEventListener('click', closeAddStockModal);
    document.getElementById('confirm-add').addEventListener('click', addStockToWatchlist);
    
    // Stock symbol input with suggestions
    document.getElementById('stock-symbol-input').addEventListener('input', showSymbolSuggestions);
    
    // Export watchlist
    document.getElementById('export-watchlist').addEventListener('click', exportWatchlist);
    
    // Bulk remove
    document.getElementById('bulk-remove').addEventListener('click', bulkRemoveStocks);
}

function switchTab(tabName) {
    currentWatchlist = tabName;
    
    // Update tab appearance
    document.querySelectorAll('.watchlist-tab').forEach(tab => {
        tab.style.color = '#64748b';
        tab.style.borderBottom = 'none';
    });
    
    const activeTab = document.querySelector(`[data-tab="${tabName}"]`);
    activeTab.style.color = '#059669';
    activeTab.style.borderBottom = '2px solid #059669';
    
    displayWatchlist();
}

function switchView(viewType) {
    currentView = viewType;
    
    // Update view buttons
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.style.background = 'white';
        btn.style.color = '#64748b';
        btn.style.borderColor = '#e2e8f0';
    });
    
    const activeBtn = document.querySelector(`[data-view="${viewType}"]`);
    activeBtn.style.background = '#059669';
    activeBtn.style.color = 'white';
    activeBtn.style.borderColor = '#059669';
    
    displayWatchlist();
}

function displayWatchlist() {
    const container = document.getElementById('watchlist-content');
    const stocks = watchlistData[currentWatchlist] || [];
    
    if (stocks.length === 0) {
        container.innerHTML = `
            <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1);">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📈</div>
                <h3 style="margin-bottom: 0.5rem; color: #0f172a;">Your watchlist is empty</h3>
                <p style="color: #64748b; margin-bottom: 2rem;">Start tracking stocks by adding them to your watchlist.</p>
                <button onclick="openAddStockModal()" style="background: #059669; color: white; padding: 1rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Add Your First Stock
                </button>
            </div>
        `;
        return;
    }
    
    if (currentView === 'grid') {
        displayGridView(stocks);
    } else {
        displayListView(stocks);
    }
}

function displayGridView(stocks) {
    const container = document.getElementById('watchlist-content');
    
    container.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
            ${stocks.map(stock => `
                <div class="watchlist-card" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; position: relative;" onmouseenter="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 15px -3px rgb(0 0 0 / 0.1)'" onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px -1px rgb(0 0 0 / 0.1)'">
                    
                    <!-- Card Header -->
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">${stock.symbol}</h3>
                                ${stock.alerts > 0 ? `<span style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">${stock.alerts}</span>` : ''}
                            </div>
                            <p style="font-size: 0.875rem; color: #64748b; margin: 0; line-height: 1.4;">${stock.name}</p>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <button onclick="removeFromWatchlist('${stock.symbol}')" style="background: none; border: none; color: #64748b; cursor: pointer; padding: 0.25rem; border-radius: 4px; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#fee2e2'; this.style.color='#dc2626'" onmouseleave="this.style.backgroundColor='transparent'; this.style.color='#64748b'">
                                ×
                            </button>
                        </div>
                    </div>
                    
                    <!-- Price Info -->
                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 2rem; font-weight: bold; color: #0f172a; margin-bottom: 0.25rem;">
                            $${stock.price.toLocaleString()}
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-weight: 500; color: ${stock.change >= 0 ? '#10b981' : '#ef4444'};">
                                ${stock.change >= 0 ? '+' : ''}${stock.change}
                            </span>
                            <span style="font-weight: 500; color: ${stock.percent >= 0 ? '#10b981' : '#ef4444'};">
                                (${stock.percent >= 0 ? '+' : ''}${stock.percent}%)
                            </span>
                        </div>
                    </div>
                    
                    <!-- Volume -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                        <span style="font-size: 0.875rem; color: #64748b;">Volume</span>
                        <span style="font-size: 0.875rem; font-weight: 500; color: #0f172a;">${stock.volume}</span>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <button onclick="setAlert('${stock.symbol}')" style="flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f1f5f9'" onmouseleave="this.style.backgroundColor='#f8fafc'">
                            🔔 Alert
                        </button>
                        <button onclick="viewChart('${stock.symbol}')" style="flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f1f5f9'" onmouseleave="this.style.backgroundColor='#f8fafc'">
                            📊 Chart
                        </button>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

function displayListView(stocks) {
    const container = document.getElementById('watchlist-content');
    
    container.innerHTML = `
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Symbol</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Name</th>
                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">Price</th>
                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">Change</th>
                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: #374151;">Volume</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Alerts</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${stocks.map(stock => `
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='white'">
                            <td style="padding: 1rem;">
                                <div style="font-weight: 600; color: #0f172a;">${stock.symbol}</div>
                            </td>
                            <td style="padding: 1rem; color: #374151;">${stock.name}</td>
                            <td style="padding: 1rem; text-align: right; font-weight: 600; color: #0f172a;">$${stock.price.toLocaleString()}</td>
                            <td style="padding: 1rem; text-align: right;">
                                <div style="font-weight: 500; color: ${stock.change >= 0 ? '#10b981' : '#ef4444'};">
                                    ${stock.change >= 0 ? '+' : ''}${stock.change}
                                </div>
                                <div style="font-size: 0.875rem; color: ${stock.percent >= 0 ? '#10b981' : '#ef4444'};">
                                    ${stock.percent >= 0 ? '+' : ''}${stock.percent}%
                                </div>
                            </td>
                            <td style="padding: 1rem; text-align: right; color: #374151;">${stock.volume}</td>
                            <td style="padding: 1rem; text-align: center;">
                                ${stock.alerts > 0 ? `<span style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">${stock.alerts}</span>` : '-'}
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <button onclick="setAlert('${stock.symbol}')" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem; border-radius: 4px; cursor: pointer; font-size: 0.75rem;">
                                        🔔
                                    </button>
                                    <button onclick="viewChart('${stock.symbol}')" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem; border-radius: 4px; cursor: pointer; font-size: 0.75rem;">
                                        📊
                                    </button>
                                    <button onclick="removeFromWatchlist('${stock.symbol}')" style="background: #fee2e2; border: 1px solid #fecaca; color: #dc2626; padding: 0.5rem; border-radius: 4px; cursor: pointer; font-size: 0.75rem;">
                                        ×
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

function sortWatchlist(sortBy) {
    const stocks = watchlistData[currentWatchlist] || [];
    
    stocks.sort((a, b) => {
        switch (sortBy) {
            case 'symbol':
                return a.symbol.localeCompare(b.symbol);
            case 'change':
                return b.percent - a.percent;
            case 'price':
                return b.price - a.price;
            case 'volume':
                return parseFloat(b.volume) - parseFloat(a.volume);
            default:
                return 0;
        }
    });
    
    displayWatchlist();
}

function openAddStockModal() {
    document.getElementById('add-stock-modal').style.display = 'flex';
    document.getElementById('stock-symbol-input').focus();
}

function closeAddStockModal() {
    document.getElementById('add-stock-modal').style.display = 'none';
    document.getElementById('stock-symbol-input').value = '';
    document.getElementById('symbol-suggestions').innerHTML = '';
}

function showSymbolSuggestions() {
    const input = document.getElementById('stock-symbol-input').value.toUpperCase();
    const suggestions = document.getElementById('symbol-suggestions');
    
    if (input.length < 1) {
        suggestions.innerHTML = '';
        return;
    }
    
    // Mock suggestions - in real app, this would be an API call
    const mockSuggestions = [
        { symbol: 'AAPL', name: 'Apple Inc.' },
        { symbol: 'MSFT', name: 'Microsoft Corporation' },
        { symbol: 'GOOGL', name: 'Alphabet Inc.' },
        { symbol: 'AMZN', name: 'Amazon.com Inc.' },
        { symbol: 'TSLA', name: 'Tesla Inc.' }
    ].filter(stock => stock.symbol.includes(input) || stock.name.toUpperCase().includes(input));
    
    suggestions.innerHTML = mockSuggestions.map(stock => `
        <div onclick="selectSuggestion('${stock.symbol}')" style="padding: 0.5rem; border-radius: 4px; cursor: pointer; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='transparent'">
            <strong>${stock.symbol}</strong> - ${stock.name}
        </div>
    `).join('');
}

function selectSuggestion(symbol) {
    document.getElementById('stock-symbol-input').value = symbol;
    document.getElementById('symbol-suggestions').innerHTML = '';
}

function addStockToWatchlist() {
    const symbol = document.getElementById('stock-symbol-input').value.toUpperCase();
    const targetList = document.getElementById('target-list').value;
    
    if (!symbol) {
        alert('Please enter a stock symbol');
        return;
    }
    
    // Mock add functionality
    alert(`${symbol} added to ${targetList} watchlist!`);
    closeAddStockModal();
}

function removeFromWatchlist(symbol) {
    if (confirm(`Remove ${symbol} from watchlist?`)) {
        const stocks = watchlistData[currentWatchlist];
        const index = stocks.findIndex(stock => stock.symbol === symbol);
        if (index > -1) {
            stocks.splice(index, 1);
            displayWatchlist();
        }
    }
}

function setAlert(symbol) {
    alert(`Setting price alert for ${symbol}`);
}

function viewChart(symbol) {
    alert(`Opening chart for ${symbol}`);
}

function exportWatchlist() {
    alert('Watchlist exported to CSV!');
}

function bulkRemoveStocks() {
    alert('Bulk remove functionality');
}

function refreshWatchlistData() {
    // Mock refresh - in real app, this would fetch fresh data
    console.log('Refreshing watchlist data...');
}

function updateLastUpdated() {
    const element = document.getElementById('last-updated');
    if (element) {
        const now = new Date();
        element.textContent = `Last updated: ${now.toLocaleTimeString()}`;
    }
}

// Add pulse animation
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
`;
document.head.appendChild(style);
</script>

<?php get_footer(); ?>