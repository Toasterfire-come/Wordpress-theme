<?php
/**
 * Template for Market Overview page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                <?php _e('Market Overview', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #64748b;">
                <?php _e('Real-time market data, major indices, top gainers and losers', 'retail-trade-scanner'); ?>
            </p>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
                <div id="market-status" style="display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                    <span style="font-size: 0.875rem; color: #059669; font-weight: 500;">Market Open</span>
                </div>
                <span style="color: #cbd5e1;">•</span>
                <span id="last-updated" style="font-size: 0.875rem; color: #64748b;">Last updated: --</span>
            </div>
        </div>

        <!-- Major Indices -->
        <section style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">
                <?php _e('Major Indices', 'retail-trade-scanner'); ?>
            </h2>
            <div id="major-indices" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <!-- Major indices data populated by JavaScript -->
            </div>
        </section>

        <!-- Market Movers Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
            
            <!-- Top Gainers -->
            <div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                        <?php _e('Top Gainers', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #10b981;">
                        <span>📈</span>
                        <span style="font-size: 0.875rem; font-weight: 500;">+5.2% avg</span>
                    </div>
                </div>
                <div id="top-gainers">
                    <!-- Top gainers populated by JavaScript -->
                </div>
            </div>
            
            <!-- Top Losers -->
            <div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                        <?php _e('Top Losers', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #ef4444;">
                        <span>📉</span>
                        <span style="font-size: 0.875rem; font-weight: 500;">-3.8% avg</span>
                    </div>
                </div>
                <div id="top-losers">
                    <!-- Top losers populated by JavaScript -->
                </div>
            </div>
            
        </div>

        <!-- Most Active Stocks -->
        <section style="margin-bottom: 3rem;">
            <div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                        <?php _e('Most Active Stocks', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #64748b;">
                        <span>🔥</span>
                        <span style="font-size: 0.875rem; font-weight: 500;">High Volume</span>
                    </div>
                </div>
                <div id="most-active" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
                    <!-- Most active stocks populated by JavaScript -->
                </div>
            </div>
        </section>

        <!-- Sector Performance -->
        <section style="margin-bottom: 3rem;">
            <div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                        <?php _e('Sector Performance', 'retail-trade-scanner'); ?>
                    </h3>
                    <select id="sector-timeframe" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white;">
                        <option value="1d">Today</option>
                        <option value="1w">1 Week</option>
                        <option value="1m">1 Month</option>
                        <option value="3m">3 Months</option>
                    </select>
                </div>
                <div id="sector-performance" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <!-- Sector performance populated by JavaScript -->
                </div>
            </div>
        </section>

        <!-- Market Insights -->
        <section>
            <div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">
                    <?php _e('Market Insights', 'retail-trade-scanner'); ?>
                </h3>
                <div id="market-insights" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    <!-- Market insights populated by JavaScript -->
                </div>
            </div>
        </section>

    </div>
</main>

<script>
// Market Overview page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    loadMajorIndices();
    loadMarketMovers();
    loadMostActive();
    loadSectorPerformance();
    loadMarketInsights();
    updateMarketStatus();
    
    // Set up auto-refresh
    setInterval(function() {
        loadMajorIndices();
        loadMarketMovers();
        updateLastUpdated();
    }, 180000); // Refresh every 3 minutes
    
    // Sector timeframe selector
    document.getElementById('sector-timeframe').addEventListener('change', function() {
        loadSectorPerformance(this.value);
    });
});

function loadMajorIndices() {
    const container = document.getElementById('major-indices');
    if (container) {
        // Mock major indices data
        const indices = [
            { name: 'S&P 500', symbol: 'SPY', price: 445.67, change: 2.34, percent: 0.53, volume: '45.2M' },
            { name: 'NASDAQ 100', symbol: 'QQQ', price: 378.92, change: -1.45, percent: -0.38, volume: '38.7M' },
            { name: 'Dow Jones', symbol: 'DIA', price: 345.23, change: 1.87, percent: 0.54, volume: '12.4M' },
            { name: 'Russell 2000', symbol: 'IWM', price: 198.45, change: 0.87, percent: 0.44, volume: '28.9M' },
            { name: 'VIX', symbol: 'VIX', price: 18.45, change: -0.32, percent: -1.71, volume: '15.2M' }
        ];
        
        container.innerHTML = indices.map(index => `
            <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); border-left: 4px solid ${index.change >= 0 ? '#10b981' : '#ef4444'}; transition: transform 0.2s; cursor: pointer;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 0.25rem; color: #0f172a;">${index.name}</h4>
                        <div style="font-size: 0.875rem; color: #64748b;">${index.symbol}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 1.25rem; font-weight: 600; color: #0f172a;">$${index.price}</div>
                        <div style="font-size: 0.875rem; font-weight: 500; color: ${index.change >= 0 ? '#10b981' : '#ef4444'};">
                            ${index.change >= 0 ? '+' : ''}${index.change} (${index.percent >= 0 ? '+' : ''}${index.percent}%)
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                    <span style="font-size: 0.875rem; color: #64748b;">Volume</span>
                    <span style="font-size: 0.875rem; font-weight: 500; color: #0f172a;">${index.volume}</span>
                </div>
            </div>
        `).join('');
    }
}

function loadMarketMovers() {
    loadTopGainers();
    loadTopLosers();
}

function loadTopGainers() {
    const container = document.getElementById('top-gainers');
    if (container) {
        const gainers = [
            { symbol: 'NVDA', price: 875.30, change: 45.20, percent: 5.45, volume: '25.3M' },
            { symbol: 'TSLA', price: 248.50, change: 12.80, percent: 5.42, volume: '18.7M' },
            { symbol: 'AMD', price: 145.67, change: 7.23, percent: 5.23, volume: '22.1M' },
            { symbol: 'AAPL', price: 195.45, change: 8.92, percent: 4.78, volume: '45.8M' },
            { symbol: 'MSFT', price: 378.20, change: 15.40, percent: 4.24, volume: '28.9M' }
        ];
        
        container.innerHTML = gainers.map(stock => `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s; cursor: pointer;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='transparent'">
                <div>
                    <div style="font-weight: 600; color: #0f172a;">${stock.symbol}</div>
                    <div style="font-size: 0.875rem; color: #64748b;">Vol: ${stock.volume}</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 600; color: #0f172a;">$${stock.price}</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: #10b981;">
                        +${stock.change} (+${stock.percent}%)
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function loadTopLosers() {
    const container = document.getElementById('top-losers');
    if (container) {
        const losers = [
            { symbol: 'META', price: 485.20, change: -25.30, percent: -4.95, volume: '15.2M' },
            { symbol: 'NFLX', price: 445.67, change: -18.45, percent: -3.98, volume: '8.9M' },
            { symbol: 'GOOGL', price: 142.30, change: -5.20, percent: -3.53, volume: '22.7M' },
            { symbol: 'AMZN', price: 145.20, change: -4.80, percent: -3.20, volume: '35.4M' },
            { symbol: 'CRM', price: 267.45, change: -7.95, percent: -2.89, volume: '12.1M' }
        ];
        
        container.innerHTML = losers.map(stock => `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #f1f5f9; transition: background-color 0.2s; cursor: pointer;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='transparent'">
                <div>
                    <div style="font-weight: 600; color: #0f172a;">${stock.symbol}</div>
                    <div style="font-size: 0.875rem; color: #64748b;">Vol: ${stock.volume}</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 600; color: #0f172a;">$${stock.price}</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: #ef4444;">
                        ${stock.change} (${stock.percent}%)
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function loadMostActive() {
    const container = document.getElementById('most-active');
    if (container) {
        const active = [
            { symbol: 'AAPL', price: 195.45, change: 8.92, percent: 4.78, volume: '125.8M' },
            { symbol: 'SPY', price: 445.67, change: 2.34, percent: 0.53, volume: '89.2M' },
            { symbol: 'QQQ', price: 378.92, change: -1.45, percent: -0.38, volume: '78.7M' },
            { symbol: 'TSLA', price: 248.50, change: 12.80, percent: 5.42, volume: '68.7M' },
            { symbol: 'AMZN', price: 145.20, change: -4.80, percent: -3.20, volume: '55.4M' },
            { symbol: 'MSFT', price: 378.20, change: 15.40, percent: 4.24, volume: '48.9M' }
        ];
        
        container.innerHTML = active.map(stock => `
            <div style="background: #f8fafc; border-radius: 8px; padding: 1rem; border-left: 3px solid ${stock.change >= 0 ? '#10b981' : '#ef4444'}; transition: transform 0.2s; cursor: pointer;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <div style="font-weight: 600; color: #0f172a;">${stock.symbol}</div>
                    <div style="font-weight: 600; color: #0f172a;">$${stock.price}</div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.875rem; color: #64748b;">Vol: ${stock.volume}</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: ${stock.change >= 0 ? '#10b981' : '#ef4444'};">
                        ${stock.change >= 0 ? '+' : ''}${stock.change} (${stock.percent >= 0 ? '+' : ''}${stock.percent}%)
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function loadSectorPerformance(timeframe = '1d') {
    const container = document.getElementById('sector-performance');
    if (container) {
        const sectors = [
            { name: 'Technology', percent: 2.45, color: '#10b981' },
            { name: 'Healthcare', percent: 1.23, color: '#10b981' },
            { name: 'Financial', percent: 0.87, color: '#10b981' },
            { name: 'Consumer Disc.', percent: 0.34, color: '#10b981' },
            { name: 'Communication', percent: -0.12, color: '#ef4444' },
            { name: 'Industrials', percent: -0.45, color: '#ef4444' },
            { name: 'Energy', percent: -1.23, color: '#ef4444' },
            { name: 'Utilities', percent: -1.67, color: '#ef4444' }
        ];
        
        container.innerHTML = sectors.map(sector => `
            <div style="background: #f8fafc; border-radius: 8px; padding: 1rem; transition: transform 0.2s; cursor: pointer;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-weight: 500; color: #0f172a;">${sector.name}</div>
                    <div style="font-weight: 600; color: ${sector.color};">
                        ${sector.percent >= 0 ? '+' : ''}${sector.percent}%
                    </div>
                </div>
                <div style="margin-top: 0.5rem; height: 4px; background: #e2e8f0; border-radius: 2px; overflow: hidden;">
                    <div style="height: 100%; width: ${Math.abs(sector.percent) * 20}%; background: ${sector.color}; transition: width 0.3s;"></div>
                </div>
            </div>
        `).join('');
    }
}

function loadMarketInsights() {
    const container = document.getElementById('market-insights');
    if (container) {
        const insights = [
            {
                title: 'Market Sentiment',
                value: 'Bullish',
                description: 'Strong buying pressure across major indices',
                icon: '📈',
                color: '#10b981'
            },
            {
                title: 'VIX Level',
                value: 'Low (18.45)',
                description: 'Market volatility remains subdued',
                icon: '📊',
                color: '#059669'
            },
            {
                title: 'Options Flow',
                value: 'Call Heavy',
                description: 'Bullish options activity detected',
                icon: '⚡',
                color: '#3b82f6'
            }
        ];
        
        container.innerHTML = insights.map(insight => `
            <div style="background: #f8fafc; border-radius: 8px; padding: 1.5rem; text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">${insight.icon}</div>
                <h4 style="font-weight: 600; margin-bottom: 0.5rem; color: #0f172a;">${insight.title}</h4>
                <div style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: ${insight.color};">${insight.value}</div>
                <p style="font-size: 0.875rem; color: #64748b; margin: 0;">${insight.description}</p>
            </div>
        `).join('');
    }
}

function updateMarketStatus() {
    const now = new Date();
    const marketOpen = now.getHours() >= 9 && now.getHours() < 16;
    const statusElement = document.getElementById('market-status');
    
    if (statusElement) {
        if (marketOpen) {
            statusElement.innerHTML = `
                <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></div>
                <span style="font-size: 0.875rem; color: #059669; font-weight: 500;">Market Open</span>
            `;
        } else {
            statusElement.innerHTML = `
                <div style="width: 8px; height: 8px; background: #ef4444; border-radius: 50%;"></div>
                <span style="font-size: 0.875rem; color: #dc2626; font-weight: 500;">Market Closed</span>
            `;
        }
    }
    
    updateLastUpdated();
}

function updateLastUpdated() {
    const element = document.getElementById('last-updated');
    if (element) {
        const now = new Date();
        element.textContent = `Last updated: ${now.toLocaleTimeString()}`;
    }
}

// Add pulse animation for market status
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