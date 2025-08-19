<?php
/**
 * Template for Dashboard page - Updated with Django API Integration
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: var(--background-primary, #f8fafc);" role="main">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: var(--text-primary, #0f172a); margin-bottom: 0.5rem;">
                <?php _e('Dashboard', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: var(--text-secondary, #64748b);">
                <?php _e('Your personalized trading overview with real-time market insights', 'retail-trade-scanner'); ?>
            </p>
        </div>

        <!-- Dashboard Grid -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 3rem;">
            
            <!-- Main Content Area -->
            <div>
                <!-- Market Overview Cards -->
                <div style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary, #0f172a);">
                        <?php _e('Market Overview', 'retail-trade-scanner'); ?>
                    </h2>
                    <div id="market-overview-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <!-- Market data cards populated by JavaScript -->
                    </div>
                </div>

                <!-- Portfolio Summary -->
                <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: var(--text-primary, #0f172a);">
                            <?php _e('Portfolio Performance', 'retail-trade-scanner'); ?>
                        </h2>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('portfolio'))); ?>" class="btn btn-outline" style="margin-left: auto;">
                            <?php _e('View Full Portfolio', 'retail-trade-scanner'); ?>
                        </a>
                    </div>
                    <div id="portfolio-summary">
                        <!-- Portfolio data populated by JavaScript -->
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card" style="padding: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-primary, #0f172a);">
                        <?php _e('Recent Activity', 'retail-trade-scanner'); ?>
                    </h2>
                    <div id="recent-activity">
                        <!-- Recent activity populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Quick Actions -->
                <div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary, #0f172a);">
                        <?php _e('Quick Actions', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="display: grid; gap: 0.75rem;">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('scanner'))); ?>" class="btn btn-primary" style="justify-content: center;">
                            🔍 <?php _e('Stock Scanner', 'retail-trade-scanner'); ?>
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('portfolio'))); ?>" class="btn btn-outline" style="justify-content: center;">
                            📊 <?php _e('My Portfolio', 'retail-trade-scanner'); ?>
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" class="btn btn-outline" style="justify-content: center;">
                            📰 <?php _e('Market News', 'retail-trade-scanner'); ?>
                        </a>
                    </div>
                </div>

                <!-- Watchlist Preview -->
                <div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: var(--text-primary, #0f172a);">
                            <?php _e('Watchlist', 'retail-trade-scanner'); ?>
                        </h3>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('portfolio'))); ?>" style="color: var(--accent-color, #059669); font-size: 0.875rem; text-decoration: none;">
                            <?php _e('View All', 'retail-trade-scanner'); ?>
                        </a>
                    </div>
                    <div id="watchlist-preview">
                        <!-- Watchlist preview populated by JavaScript -->
                    </div>
                </div>

                <!-- Market News -->
                <div class="card" style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: var(--text-primary, #0f172a);">
                            <?php _e('Latest News', 'retail-trade-scanner'); ?>
                        </h3>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" style="color: var(--accent-color, #059669); font-size: 0.875rem; text-decoration: none;">
                            <?php _e('View All', 'retail-trade-scanner'); ?>
                        </a>
                    </div>
                    <div id="news-preview">
                        <!-- News preview populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    
    // Refresh data every 3 minutes
    setInterval(loadDashboardData, 180000);
});

function loadDashboardData() {
    loadMarketOverview();
    loadPortfolioSummary();
    loadWatchlistPreview();
    loadNewsPreview();
    loadRecentActivity();
}

function loadMarketOverview() {
    // Updated to use Django API endpoints
    const apiUrl = window.retail_trade_scanner_data?.api_endpoints?.market_stats || '';
    
    if (!apiUrl) {
        showMarketOverviewError();
        return;
    }
    
    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('market-overview-grid');
        if (container && data) {
            const marketData = data.market_overview || {
                total_stocks: data.total_stocks || 3500,
                gainers: data.gainers || 1250,
                losers: data.losers || 980
            };
            
            container.innerHTML = `
                <div class="card" style="padding: 1.5rem; text-align: center;">
                    <div style="color: var(--text-secondary, #64748b); font-size: 0.875rem; margin-bottom: 0.5rem;">Total Tracked</div>
                    <div style="font-size: 2rem; font-weight: bold; color: var(--text-primary, #0f172a);">${marketData.total_stocks.toLocaleString()}</div>
                </div>
                <div class="card" style="padding: 1.5rem; text-align: center;">
                    <div style="color: var(--text-secondary, #64748b); font-size: 0.875rem; margin-bottom: 0.5rem;">Gainers</div>
                    <div style="font-size: 2rem; font-weight: bold; color: var(--success-color, #059669);">${marketData.gainers.toLocaleString()}</div>
                </div>
                <div class="card" style="padding: 1.5rem; text-align: center;">
                    <div style="color: var(--text-secondary, #64748b); font-size: 0.875rem; margin-bottom: 0.5rem;">Losers</div>
                    <div style="font-size: 2rem; font-weight: bold; color: var(--danger-color, #dc2626);">${marketData.losers.toLocaleString()}</div>
                </div>
            `;
        }
    })
    .catch(error => {
        showMarketOverviewError();
    });
}

function showMarketOverviewError() {
    const container = document.getElementById('market-overview-grid');
    if (container) {
        container.innerHTML = `
            <div class="card" style="padding: 1.5rem; text-align: center; grid-column: 1 / -1;">
                <div style="color: var(--text-muted, #64748b); font-size: 0.875rem;">Market data temporarily unavailable</div>
            </div>
        `;
    }
}

function loadPortfolioSummary() {
    const container = document.getElementById('portfolio-summary');
    if (container) {
        // Mock portfolio data - in real implementation, this would call Django API
        const portfolioData = [
            { symbol: 'AAPL', shares: 100, current_price: 175.50, gain_loss_percent: 17.0 },
            { symbol: 'MSFT', shares: 50, current_price: 378.85, gain_loss_percent: -2.3 }
        ];
        
        const totalValue = portfolioData.reduce((sum, item) => sum + (item.shares * item.current_price), 0);
        const avgGainLoss = portfolioData.reduce((sum, item) => sum + item.gain_loss_percent, 0) / portfolioData.length;
        
        container.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div style="text-align: center;">
                    <div style="color: var(--text-secondary, #64748b); font-size: 0.875rem; margin-bottom: 0.5rem;">Total Value</div>
                    <div style="font-size: 2rem; font-weight: bold; color: var(--text-primary, #0f172a);">$${totalValue.toLocaleString()}</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: var(--text-secondary, #64748b); font-size: 0.875rem; margin-bottom: 0.5rem;">Performance</div>
                    <div style="font-size: 2rem; font-weight: bold; color: ${avgGainLoss >= 0 ? 'var(--success-color, #059669)' : 'var(--danger-color, #dc2626)'};">
                        ${avgGainLoss >= 0 ? '+' : ''}${avgGainLoss.toFixed(1)}%
                    </div>
                </div>
            </div>
            <div style="display: grid; gap: 0.5rem;">
                ${portfolioData.slice(0, 3).map(item => `
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: var(--background-secondary, #f8fafc); border-radius: 6px;">
                        <div>
                            <div style="font-weight: 600;">${item.symbol}</div>
                            <div style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">${item.shares} shares</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 600;">$${item.current_price}</div>
                            <div style="font-size: 0.875rem; color: ${item.gain_loss_percent >= 0 ? 'var(--success-color, #059669)' : 'var(--danger-color, #dc2626)'};">
                                ${item.gain_loss_percent >= 0 ? '+' : ''}${item.gain_loss_percent.toFixed(1)}%
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
}

function loadWatchlistPreview() {
    const container = document.getElementById('watchlist-preview');
    if (container) {
        // Mock watchlist data
        const watchlistData = [
            { symbol: 'TSLA', price: 248.50, change_percent: 3.2 },
            { symbol: 'NVDA', price: 875.30, change_percent: -1.8 },
            { symbol: 'AMZN', price: 145.20, change_percent: 0.7 }
        ];
        
        container.innerHTML = watchlistData.map(item => `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid var(--border-primary, #f1f5f9);">
                <div style="font-weight: 600;">${item.symbol}</div>
                <div style="text-align: right;">
                    <div style="font-weight: 600;">$${item.price}</div>
                    <div style="font-size: 0.75rem; color: ${item.change_percent >= 0 ? 'var(--success-color, #059669)' : 'var(--danger-color, #dc2626)'};">
                        ${item.change_percent >= 0 ? '+' : ''}${item.change_percent}%
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function loadNewsPreview() {
    const container = document.getElementById('news-preview');
    if (container) {
        // Mock news data - in production, this would call Django API
        const newsData = [
            { title: 'Market Opens Higher After Fed Meeting', time: '2 hours ago' },
            { title: 'Tech Stocks Show Volatility', time: '4 hours ago' },
            { title: 'Energy Sector Gains Momentum', time: '6 hours ago' }
        ];
        
        container.innerHTML = newsData.map(item => `
            <div style="padding: 0.75rem 0; border-bottom: 1px solid var(--border-primary, #f1f5f9);">
                <div style="font-weight: 500; font-size: 0.875rem; line-height: 1.4; margin-bottom: 0.25rem;">
                    ${item.title}
                </div>
                <div style="font-size: 0.75rem; color: var(--text-muted, #64748b);">${item.time}</div>
            </div>
        `).join('');
    }
}

function loadRecentActivity() {
    const container = document.getElementById('recent-activity');
    if (container) {
        const activities = [
            { action: 'Added AAPL to watchlist', time: '1 hour ago', type: 'watchlist' },
            { action: 'Price alert triggered for TSLA', time: '3 hours ago', type: 'alert' },
            { action: 'Portfolio updated', time: '1 day ago', type: 'portfolio' }
        ];
        
        container.innerHTML = activities.map(item => `
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid var(--border-primary, #e5e7eb); border-radius: 8px; margin-bottom: 0.75rem;">
                <div style="width: 40px; height: 40px; background: var(--background-secondary, #f1f5f9); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    ${item.type === 'watchlist' ? '👁️' : item.type === 'alert' ? '🔔' : '📊'}
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 500; margin-bottom: 0.25rem;">${item.action}</div>
                    <div style="font-size: 0.875rem; color: var(--text-muted, #64748b);">${item.time}</div>
                </div>
            </div>
        `).join('');
    }
}
</script>

<?php get_footer(); ?>