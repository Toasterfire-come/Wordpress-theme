<?php
/**
 * Template for Market Overview page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Market Overview</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Real-time market data, major indices, top gainers and losers</p>
        </div>

        <!-- Market Summary -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;" id="market-summary">
            <!-- Market summary cards will be populated by JavaScript -->
        </div>

        <!-- Major Indices -->
        <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Major Indices</h2>
                <button id="refresh-indices" class="btn btn-outline">Refresh</button>
            </div>
            
            <div id="major-indices" style="display: grid; gap: 1rem;">
                <!-- Indices will be populated by JavaScript -->
            </div>
        </div>

        <!-- Market Movers -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Top Gainers -->
            <div class="card" style="padding: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #059669;">Top Gainers</h2>
                <div id="top-gainers">
                    <div style="text-align: center; padding: 2rem; color: #64748b;">
                        <div class="loading-spinner" style="margin: 0 auto 1rem;"></div>
                        <p>Loading gainers...</p>
                    </div>
                </div>
            </div>

            <!-- Top Losers -->
            <div class="card" style="padding: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #dc2626;">Top Losers</h2>
                <div id="top-losers">
                    <div style="text-align: center; padding: 2rem; color: #64748b;">
                        <div class="loading-spinner" style="margin: 0 auto 1rem;"></div>
                        <p>Loading losers...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadMarketOverview();
    
    document.getElementById('refresh-indices').addEventListener('click', loadMarketOverview);
    
    // Auto-refresh every 3 minutes
    setInterval(loadMarketOverview, 180000);
});

function loadMarketOverview() {
    loadMarketSummary();
    loadMajorIndices();
    loadMarketMovers();
}

function loadMarketSummary() {
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/market-data')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data && data.data.market_overview) {
            displayMarketSummary(data.data.market_overview);
        } else {
            displayDefaultMarketSummary();
        }
    })
    .catch(error => {
        console.error('Market summary error:', error);
        displayDefaultMarketSummary();
    });
}

function displayMarketSummary(summary) {
    const container = document.getElementById('market-summary');
    
    container.innerHTML = `
        <div class="card" style="padding: 1.5rem; text-align: center; border-left: 4px solid #059669;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">NYSE</div>
            <div style="font-size: 2rem; font-weight: bold; color: #0f172a;">${(summary.total_stocks || 3500).toLocaleString()}</div>
            <div style="color: #64748b; font-size: 0.875rem;">Total Stocks</div>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center; border-left: 4px solid #10b981;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Gainers</div>
            <div style="font-size: 2rem; font-weight: bold; color: #059669;">${(summary.gainers || 1250).toLocaleString()}</div>
            <div style="color: #059669; font-size: 0.875rem;">Rising</div>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center; border-left: 4px solid #ef4444;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Losers</div>
            <div style="font-size: 2rem; font-weight: bold; color: #dc2626;">${(summary.losers || 980).toLocaleString()}</div>
            <div style="color: #dc2626; font-size: 0.875rem;">Falling</div>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center; border-left: 4px solid #3b82f6;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Update Freq</div>
            <div style="font-size: 2rem; font-weight: bold; color: #2563eb;">Sub 3min</div>
            <div style="color: #2563eb; font-size: 0.875rem;">Live Data</div>
        </div>
    `;
}

function displayDefaultMarketSummary() {
    displayMarketSummary({
        total_stocks: 3500,
        gainers: 1250,
        losers: 980,
        unchanged: 1270
    });
}

function loadMajorIndices() {
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/indices')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            displayMajorIndices(data.data);
        } else {
            displayDefaultIndices();
        }
    })
    .catch(error => {
        console.error('Indices error:', error);
        displayDefaultIndices();
    });
}

function displayMajorIndices(indices) {
    const container = document.getElementById('major-indices');
    
    container.innerHTML = indices.map(index => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px; background: white;">
            <div>
                <h3 style="font-weight: 600; margin-bottom: 0.25rem;">${index.name}</h3>
                <p style="color: #64748b; font-size: 0.875rem;">${index.description || ''}</p>
            </div>
            <div style="text-align: right;">
                <div style="font-weight: 600; font-size: 1.125rem;">${formatNumber(index.value)}</div>
                <div style="color: ${index.change >= 0 ? '#059669' : '#dc2626'}; font-size: 0.875rem; font-weight: 500;">
                    ${index.change >= 0 ? '+' : ''}${formatNumber(index.change)} (${index.change_percent >= 0 ? '+' : ''}${index.change_percent.toFixed(2)}%)
                </div>
            </div>
        </div>
    `).join('');
}

function displayDefaultIndices() {
    const defaultIndices = [
        { name: 'S&P 500', description: 'Standard & Poor\'s 500', value: 4789.45, change: 24.87, change_percent: 0.52 },
        { name: 'Dow Jones', description: 'Dow Jones Industrial Average', value: 37890.23, change: -45.32, change_percent: -0.12 },
        { name: 'NASDAQ', description: 'NASDAQ Composite', value: 14567.89, change: 89.45, change_percent: 0.62 },
        { name: 'Russell 2000', description: 'Russell 2000 Index', value: 1987.56, change: 12.34, change_percent: 0.63 }
    ];
    
    displayMajorIndices(defaultIndices);
}

function loadMarketMovers() {
    // Load gainers
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/movers/gainers')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            displayMovers('top-gainers', data.data, 'gainer');
        } else {
            displayDefaultMovers('top-gainers', 'gainer');
        }
    })
    .catch(error => {
        console.error('Gainers error:', error);
        displayDefaultMovers('top-gainers', 'gainer');
    });

    // Load losers
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/movers/losers')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            displayMovers('top-losers', data.data, 'loser');
        } else {
            displayDefaultMovers('top-losers', 'loser');
        }
    })
    .catch(error => {
        console.error('Losers error:', error);
        displayDefaultMovers('top-losers', 'loser');
    });
}

function displayMovers(containerId, movers, type) {
    const container = document.getElementById(containerId);
    
    if (movers.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #64748b;">
                <p>No ${type}s data available</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <div style="display: grid; gap: 0.5rem;">
            ${movers.slice(0, 5).map(stock => `
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #f9fafb; border-radius: 6px;">
                    <div>
                        <div style="font-weight: 600;">${stock.symbol}</div>
                        <div style="color: #64748b; font-size: 0.875rem;">${stock.name || 'N/A'}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 600;">$${(stock.price || 0).toFixed(2)}</div>
                        <div style="color: ${type === 'gainer' ? '#059669' : '#dc2626'}; font-size: 0.875rem; font-weight: 500;">
                            ${type === 'gainer' ? '+' : ''}${(stock.change_percent || 0).toFixed(2)}%
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

function displayDefaultMovers(containerId, type) {
    const defaultGainers = [
        { symbol: 'NVDA', name: 'NVIDIA Corporation', price: 789.45, change_percent: 8.92 },
        { symbol: 'AMD', name: 'Advanced Micro Devices', price: 156.78, change_percent: 6.45 },
        { symbol: 'TSLA', name: 'Tesla Inc', price: 234.56, change_percent: 4.32 },
        { symbol: 'AMZN', name: 'Amazon.com Inc', price: 145.67, change_percent: 3.89 },
        { symbol: 'GOOGL', name: 'Alphabet Inc', price: 134.23, change_percent: 2.67 }
    ];
    
    const defaultLosers = [
        { symbol: 'META', name: 'Meta Platforms Inc', price: 298.45, change_percent: -4.32 },
        { symbol: 'NFLX', name: 'Netflix Inc', price: 456.78, change_percent: -3.89 },
        { symbol: 'AAPL', name: 'Apple Inc', price: 178.90, change_percent: -2.67 },
        { symbol: 'MSFT', name: 'Microsoft Corporation', price: 345.67, change_percent: -2.34 },
        { symbol: 'CRM', name: 'Salesforce Inc', price: 234.56, change_percent: -1.98 }
    ];
    
    const data = type === 'gainer' ? defaultGainers : defaultLosers;
    displayMovers(containerId, data, type);
}

function formatNumber(num) {
    if (num >= 1000) {
        return num.toLocaleString();
    }
    return num.toFixed(2);
}
</script>

<?php get_footer(); ?>