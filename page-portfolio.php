<?php
/**
 * Template for Portfolio page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Portfolio</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Track your investment portfolio performance and analytics</p>
        </div>

        <!-- Portfolio Summary -->
        <div id="portfolio-summary" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <!-- Summary cards will be populated by JavaScript -->
        </div>

        <!-- Portfolio Holdings -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Holdings</h2>
                <button id="refresh-portfolio" class="btn btn-outline">Refresh Data</button>
            </div>
            
            <div id="portfolio-holdings">
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <div class="loading-spinner" style="margin: 0 auto 1rem;"></div>
                    <p>Loading portfolio...</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadPortfolio();
    
    document.getElementById('refresh-portfolio').addEventListener('click', loadPortfolio);
});

function loadPortfolio() {
    // Load portfolio summary
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/portfolio/summary')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            displayPortfolioSummary(data.data);
        } else {
            displayEmptyPortfolio();
        }
    })
    .catch(error => {
        console.error('Portfolio summary error:', error);
        displayEmptyPortfolio();
    });
    
    // Load portfolio holdings
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/portfolio/holdings')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            displayPortfolioHoldings(data.data);
        } else {
            displayEmptyHoldings();
        }
    })
    .catch(error => {
        console.error('Portfolio holdings error:', error);
        displayEmptyHoldings();
    });
}

function displayPortfolioSummary(summary) {
    const container = document.getElementById('portfolio-summary');
    
    container.innerHTML = `
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Total Value</div>
            <div style="font-size: 2rem; font-weight: bold; color: #0f172a;">${formatCurrency(summary.total_value || 0)}</div>
            <div style="font-size: 0.875rem; color: ${(summary.daily_change || 0) >= 0 ? '#059669' : '#dc2626'};">
                ${(summary.daily_change || 0) >= 0 ? '+' : ''}${formatCurrency(summary.daily_change || 0)} Today
            </div>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Daily Change</div>
            <div style="font-size: 2rem; font-weight: bold; color: ${(summary.daily_change_percent || 0) >= 0 ? '#059669' : '#dc2626'};">
                ${(summary.daily_change_percent || 0) >= 0 ? '+' : ''}${(summary.daily_change_percent || 0).toFixed(2)}%
            </div>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Holdings</div>
            <div style="font-size: 2rem; font-weight: bold; color: #0f172a;">${summary.total_holdings || 0}</div>
            <div style="font-size: 0.875rem; color: #64748b;">Positions</div>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">All-Time</div>
            <div style="font-size: 2rem; font-weight: bold; color: ${(summary.total_return_percent || 0) >= 0 ? '#059669' : '#dc2626'};">
                ${(summary.total_return_percent || 0) >= 0 ? '+' : ''}${(summary.total_return_percent || 0).toFixed(2)}%
            </div>
            <div style="font-size: 0.875rem; color: #64748b;">Return</div>
        </div>
    `;
}

function displayPortfolioHoldings(holdings) {
    const container = document.getElementById('portfolio-holdings');
    
    if (holdings.length === 0) {
        displayEmptyHoldings();
        return;
    }
    
    container.innerHTML = `
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Symbol</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Shares</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Avg Cost</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Current Price</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Market Value</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Gain/Loss</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${holdings.map(holding => `
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem;">
                                <div style="font-weight: 600;">${holding.symbol}</div>
                                <div style="font-size: 0.875rem; color: #64748b;">${holding.company_name || 'N/A'}</div>
                            </td>
                            <td style="padding: 1rem;">${holding.shares || 0}</td>
                            <td style="padding: 1rem;">${formatCurrency(holding.avg_cost || 0)}</td>
                            <td style="padding: 1rem;">${formatCurrency(holding.current_price || 0)}</td>
                            <td style="padding: 1rem; font-weight: 600;">${formatCurrency(holding.market_value || 0)}</td>
                            <td style="padding: 1rem; color: ${(holding.gain_loss || 0) >= 0 ? '#059669' : '#dc2626'}; font-weight: 600;">
                                ${formatCurrency(holding.gain_loss || 0)}
                                <div style="font-size: 0.875rem;">
                                    (${(holding.gain_loss_percent || 0) >= 0 ? '+' : ''}${(holding.gain_loss_percent || 0).toFixed(2)}%)
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <button onclick="sellHolding('${holding.symbol}')" class="btn btn-outline" style="font-size: 0.875rem; margin-right: 0.5rem;">
                                    Sell
                                </button>
                                <button onclick="viewDetails('${holding.symbol}')" class="btn btn-outline" style="font-size: 0.875rem;">
                                    Details
                                </button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

function displayEmptyPortfolio() {
    document.getElementById('portfolio-summary').innerHTML = `
        <div class="card" style="padding: 1.5rem; text-align: center; grid-column: 1 / -1;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No portfolio data</h3>
            <p style="color: #64748b;">Start by adding some stocks to your portfolio to see performance metrics.</p>
        </div>
    `;
}

function displayEmptyHoldings() {
    document.getElementById('portfolio-holdings').innerHTML = `
        <div style="text-align: center; padding: 3rem; color: #64748b;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">💼</div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No holdings</h3>
            <p>Your portfolio is empty. Start investing to track your performance here.</p>
            <div style="margin-top: 2rem;">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('scanner'))); ?>" class="btn btn-primary">
                    Find Stocks to Buy
                </a>
            </div>
        </div>
    `;
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function sellHolding(symbol) {
    if (confirm(`Are you sure you want to sell your ${symbol} position?`)) {
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/portfolio/sell')); ?>', {
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
                showNotification(`${symbol} position sold`, 'success');
                loadPortfolio();
            } else {
                showNotification('Failed to sell position', 'error');
            }
        })
        .catch(error => {
            showNotification('Error selling position', 'error');
        });
    }
}

function viewDetails(symbol) {
    window.location.href = `<?php echo esc_url(get_permalink(get_page_by_path('scanner'))); ?>?symbol=${symbol}`;
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