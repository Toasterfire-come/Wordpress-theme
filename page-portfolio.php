<?php
/**
 * Template for Portfolio page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                <?php _e('My Portfolio', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #64748b;">
                <?php _e('Track your investment performance with comprehensive analytics', 'retail-trade-scanner'); ?>
            </p>
        </div>

        <!-- Portfolio Summary Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            
            <!-- Total Value -->
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <?php _e('Total Value', 'retail-trade-scanner'); ?>
                </div>
                <div id="total-value" style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                    $0
                </div>
                <div id="total-change" style="font-size: 0.875rem; font-weight: 500;">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
            
            <!-- Day Change -->
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <?php _e('Day Change', 'retail-trade-scanner'); ?>
                </div>
                <div id="day-change" style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">
                    $0
                </div>
                <div id="day-percent" style="font-size: 0.875rem; font-weight: 500;">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
            
            <!-- Total Gain/Loss -->
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <?php _e('Total Gain/Loss', 'retail-trade-scanner'); ?>
                </div>
                <div id="total-gain-loss" style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">
                    $0
                </div>
                <div id="total-gain-percent" style="font-size: 0.875rem; font-weight: 500;">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
            
            <!-- Cash Balance -->
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <?php _e('Cash Balance', 'retail-trade-scanner'); ?>
                </div>
                <div id="cash-balance" style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                    $12,450.00
                </div>
                <div style="font-size: 0.875rem; color: #64748b;">
                    <?php _e('Available for trading', 'retail-trade-scanner'); ?>
                </div>
            </div>
            
        </div>

        <!-- Portfolio Performance Chart -->
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: #0f172a;">
                    <?php _e('Portfolio Performance', 'retail-trade-scanner'); ?>
                </h3>
                <div style="display: flex; gap: 0.5rem;">
                    <button class="timeframe-btn active" data-timeframe="1D" style="padding: 0.5rem 1rem; border: 1px solid #059669; background: #059669; color: white; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">1D</button>
                    <button class="timeframe-btn" data-timeframe="1W" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">1W</button>
                    <button class="timeframe-btn" data-timeframe="1M" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">1M</button>
                    <button class="timeframe-btn" data-timeframe="1Y" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">1Y</button>
                    <button class="timeframe-btn" data-timeframe="ALL" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">ALL</button>
                </div>
            </div>
            <div id="portfolio-chart" style="height: 300px; background: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                <?php _e('Portfolio performance chart will be displayed here', 'retail-trade-scanner'); ?>
            </div>
        </div>

        <!-- Holdings and Analytics -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 3rem;">
            
            <!-- Holdings -->
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: #0f172a;">
                        <?php _e('Holdings', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <select id="holdings-sort" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white;">
                            <option value="value">By Value</option>
                            <option value="change">By Change</option>
                            <option value="symbol">By Symbol</option>
                        </select>
                        <button id="add-holding" style="background: #059669; color: white; padding: 0.5rem 1rem; border: none; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                            + <?php _e('Add', 'retail-trade-scanner'); ?>
                        </button>
                    </div>
                </div>
                
                <div id="holdings-list">
                    <!-- Holdings populated by JavaScript -->
                </div>
            </div>
            
            <!-- Portfolio Analytics -->
            <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem; color: #0f172a;">
                    <?php _e('Analytics', 'retail-trade-scanner'); ?>
                </h3>
                
                <!-- Allocation Chart -->
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #374151;">
                        <?php _e('Asset Allocation', 'retail-trade-scanner'); ?>
                    </h4>
                    <div id="allocation-chart" style="height: 200px; background: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 0.875rem;">
                        <?php _e('Allocation chart', 'retail-trade-scanner'); ?>
                    </div>
                </div>
                
                <!-- Key Metrics -->
                <div>
                    <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #374151;">
                        <?php _e('Key Metrics', 'retail-trade-scanner'); ?>
                    </h4>
                    <div id="portfolio-metrics">
                        <!-- Metrics populated by JavaScript -->
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Recent Activity -->
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: #0f172a;">
                    <?php _e('Recent Activity', 'retail-trade-scanner'); ?>
                </h3>
                <button style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                    <?php _e('View All', 'retail-trade-scanner'); ?>
                </button>
            </div>
            
            <div id="recent-activity">
                <!-- Activity populated by JavaScript -->
            </div>
        </div>

    </div>
</main>

<script>
// Portfolio page JavaScript
let portfolioData = {
    totalValue: 85420.50,
    dayChange: 1250.30,
    dayPercent: 1.49,
    totalGainLoss: 12850.50,
    totalGainPercent: 17.7,
    cashBalance: 12450.00,
    holdings: [
        { symbol: 'AAPL', name: 'Apple Inc.', shares: 50, avgCost: 150.00, currentPrice: 195.45, value: 9772.50, gainLoss: 2272.50, gainLossPercent: 30.3 },
        { symbol: 'MSFT', name: 'Microsoft Corporation', shares: 25, avgCost: 320.00, currentPrice: 378.20, value: 9455.00, gainLoss: 1455.00, gainLossPercent: 18.2 },
        { symbol: 'GOOGL', name: 'Alphabet Inc.', shares: 30, avgCost: 125.00, currentPrice: 142.30, value: 4269.00, gainLoss: 519.00, gainLossPercent: 13.8 },
        { symbol: 'AMZN', name: 'Amazon.com Inc.', shares: 40, avgCost: 135.00, currentPrice: 145.20, value: 5808.00, gainLoss: 408.00, gainLossPercent: 7.6 },
        { symbol: 'TSLA', name: 'Tesla Inc.', shares: 15, avgCost: 220.00, currentPrice: 248.50, value: 3727.50, gainLoss: 427.50, gainLossPercent: 12.9 },
        { symbol: 'NVDA', name: 'NVIDIA Corporation', shares: 8, avgCost: 450.00, currentPrice: 875.30, value: 7002.40, gainLoss: 3402.40, gainLossPercent: 94.5 }
    ],
    recentActivity: [
        { type: 'buy', symbol: 'NVDA', shares: 2, price: 875.30, date: '2024-01-15', time: '10:30 AM' },
        { type: 'sell', symbol: 'AAPL', shares: 10, price: 195.45, date: '2024-01-14', time: '2:15 PM' },
        { type: 'dividend', symbol: 'MSFT', amount: 68.50, date: '2024-01-12', time: '9:00 AM' },
        { type: 'buy', symbol: 'GOOGL', shares: 5, price: 142.30, date: '2024-01-10', time: '11:45 AM' }
    ]
};

document.addEventListener('DOMContentLoaded', function() {
    initializePortfolio();
    setupEventListeners();
});

function initializePortfolio() {
    updateSummaryCards();
    displayHoldings();
    displayPortfolioMetrics();
    displayRecentActivity();
}

function setupEventListeners() {
    // Timeframe buttons
    document.querySelectorAll('.timeframe-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            switchTimeframe(this.dataset.timeframe);
        });
    });
    
    // Holdings sort
    document.getElementById('holdings-sort').addEventListener('change', function() {
        sortHoldings(this.value);
    });
    
    // Add holding button
    document.getElementById('add-holding').addEventListener('click', addHolding);
}

function updateSummaryCards() {
    document.getElementById('total-value').textContent = `$${portfolioData.totalValue.toLocaleString()}`;
    
    const totalChangeEl = document.getElementById('total-change');
    const totalGainPercent = ((portfolioData.totalValue - portfolioData.cashBalance) / (portfolioData.totalValue - portfolioData.cashBalance - portfolioData.totalGainLoss)) * 100 - 100;
    totalChangeEl.innerHTML = `<span style="color: ${totalGainPercent >= 0 ? '#10b981' : '#ef4444'};">+${totalGainPercent.toFixed(1)}% All Time</span>`;
    
    const dayChangeEl = document.getElementById('day-change');
    dayChangeEl.textContent = `$${portfolioData.dayChange.toLocaleString()}`;
    dayChangeEl.style.color = portfolioData.dayChange >= 0 ? '#10b981' : '#ef4444';
    
    const dayPercentEl = document.getElementById('day-percent');
    dayPercentEl.innerHTML = `<span style="color: ${portfolioData.dayPercent >= 0 ? '#10b981' : '#ef4444'};">${portfolioData.dayPercent >= 0 ? '+' : ''}${portfolioData.dayPercent}%</span>`;
    
    const totalGainLossEl = document.getElementById('total-gain-loss');
    totalGainLossEl.textContent = `$${portfolioData.totalGainLoss.toLocaleString()}`;
    totalGainLossEl.style.color = portfolioData.totalGainLoss >= 0 ? '#10b981' : '#ef4444';
    
    const totalGainPercentEl = document.getElementById('total-gain-percent');
    totalGainPercentEl.innerHTML = `<span style="color: ${portfolioData.totalGainPercent >= 0 ? '#10b981' : '#ef4444'};">${portfolioData.totalGainPercent >= 0 ? '+' : ''}${portfolioData.totalGainPercent}%</span>`;
}

function displayHoldings() {
    const container = document.getElementById('holdings-list');
    
    container.innerHTML = portfolioData.holdings.map(holding => `
        <div style="display: flex; align-items: center; padding: 1rem 0; border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='transparent'">
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <div>
                        <div style="font-weight: 600; color: #0f172a;">${holding.symbol}</div>
                        <div style="font-size: 0.875rem; color: #64748b;">${holding.shares} shares</div>
                    </div>
                    <div style="margin-left: auto; text-align: right;">
                        <div style="font-weight: 600; color: #0f172a;">$${holding.value.toLocaleString()}</div>
                        <div style="font-size: 0.875rem; color: #64748b;">@$${holding.currentPrice}</div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.875rem; color: #64748b;">
                        Avg Cost: $${holding.avgCost}
                    </div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: ${holding.gainLoss >= 0 ? '#10b981' : '#ef4444'};">
                        ${holding.gainLoss >= 0 ? '+' : ''}$${holding.gainLoss.toLocaleString()} (${holding.gainLossPercent >= 0 ? '+' : ''}${holding.gainLossPercent}%)
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function displayPortfolioMetrics() {
    const container = document.getElementById('portfolio-metrics');
    
    const totalEquityValue = portfolioData.holdings.reduce((sum, holding) => sum + holding.value, 0);
    const largestHolding = portfolioData.holdings.reduce((max, holding) => holding.value > max.value ? holding : max);
    const bestPerformer = portfolioData.holdings.reduce((max, holding) => holding.gainLossPercent > max.gainLossPercent ? holding : max);
    
    const metrics = [
        { label: 'Total Positions', value: portfolioData.holdings.length },
        { label: 'Equity Value', value: `$${totalEquityValue.toLocaleString()}` },
        { label: 'Largest Holding', value: `${largestHolding.symbol} (${((largestHolding.value / totalEquityValue) * 100).toFixed(1)}%)` },
        { label: 'Best Performer', value: `${bestPerformer.symbol} (+${bestPerformer.gainLossPercent}%)` },
        { label: 'Diversification', value: 'Moderate' },
        { label: 'Risk Level', value: 'Medium' }
    ];
    
    container.innerHTML = metrics.map(metric => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
            <span style="font-size: 0.875rem; color: #64748b;">${metric.label}</span>
            <span style="font-size: 0.875rem; font-weight: 500; color: #0f172a;">${metric.value}</span>
        </div>
    `).join('');
}

function displayRecentActivity() {
    const container = document.getElementById('recent-activity');
    
    const activityIcons = {
        buy: '🟢',
        sell: '🔴',
        dividend: '💰',
        split: '🔄'
    };
    
    const activityLabels = {
        buy: 'Bought',
        sell: 'Sold',
        dividend: 'Dividend',
        split: 'Stock Split'
    };
    
    container.innerHTML = portfolioData.recentActivity.map(activity => `
        <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #f1f5f9;">
            <div style="font-size: 1.5rem;">${activityIcons[activity.type]}</div>
            <div style="flex: 1;">
                <div style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                    ${activityLabels[activity.type]} ${activity.symbol}
                    ${activity.shares ? `- ${activity.shares} shares` : ''}
                    ${activity.amount ? `- $${activity.amount}` : ''}
                </div>
                <div style="font-size: 0.875rem; color: #64748b;">
                    ${activity.date} at ${activity.time}
                    ${activity.price ? `@ $${activity.price}` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

function switchTimeframe(timeframe) {
    // Update active button
    document.querySelectorAll('.timeframe-btn').forEach(btn => {
        btn.style.background = 'white';
        btn.style.color = '#64748b';
        btn.style.borderColor = '#e2e8f0';
    });
    
    const activeBtn = document.querySelector(`[data-timeframe="${timeframe}"]`);
    activeBtn.style.background = '#059669';
    activeBtn.style.color = 'white';
    activeBtn.style.borderColor = '#059669';
    
    // Mock chart update
    console.log(`Switching to ${timeframe} timeframe`);
}

function sortHoldings(sortBy) {
    switch (sortBy) {
        case 'value':
            portfolioData.holdings.sort((a, b) => b.value - a.value);
            break;
        case 'change':
            portfolioData.holdings.sort((a, b) => b.gainLossPercent - a.gainLossPercent);
            break;
        case 'symbol':
            portfolioData.holdings.sort((a, b) => a.symbol.localeCompare(b.symbol));
            break;
    }
    
    displayHoldings();
}

function addHolding() {
    alert('Add new holding functionality');
}
</script>

<?php get_footer(); ?>