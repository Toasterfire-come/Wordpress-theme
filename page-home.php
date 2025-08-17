<?php
/**
 * Template for Home page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    
    <!-- Hero Section -->
    <section style="padding: 6rem 0; color: white; text-align: center;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <h1 style="font-size: 4rem; font-weight: bold; margin-bottom: 1.5rem; line-height: 1.1;">
                <?php _e('Professional Stock Analysis', 'retail-trade-scanner'); ?>
                <br>
                <span style="color: #34d399;"><?php _e('Made Simple', 'retail-trade-scanner'); ?></span>
            </h1>
            <p style="font-size: 1.5rem; color: #cbd5e1; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                <?php _e('Real-time market data, advanced screening tools, and portfolio management for retail traders.', 'retail-trade-scanner'); ?>
            </p>
            
            <!-- CTA Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 4rem;">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" 
                   class="btn-primary" 
                   style="background: #059669; color: white; padding: 1rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.125rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s;">
                    <?php _e('Start Free Trial', 'retail-trade-scanner'); ?>
                    <span>→</span>
                </a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('dashboard'))); ?>" 
                   class="btn-secondary" 
                   style="border: 2px solid #cbd5e1; color: #cbd5e1; padding: 1rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.125rem; transition: all 0.2s;">
                    <?php _e('View Dashboard', 'retail-trade-scanner'); ?>
                </a>
            </div>
            
            <!-- Live Market Ticker -->
            <div id="market-ticker" style="background: rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; backdrop-filter: blur(10px);">
                <!-- Market data populated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section style="padding: 6rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('Everything You Need to Trade', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.25rem; color: #64748b; max-width: 600px; margin: 0 auto;">
                    <?php _e('Professional-grade tools designed for retail traders who demand institutional-quality data and analysis.', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <!-- Feature Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                
                <!-- Real-time Data -->
                <div class="feature-card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center; transition: transform 0.2s;">
                    <div style="width: 64px; height: 64px; background: #dcfdf7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <span style="font-size: 2rem;">⚡</span>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Real-time Data', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b; line-height: 1.6;">
                        <?php _e('Live market data updated every 3 minutes with institutional-grade accuracy and reliability.', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
                <!-- Advanced Scanner -->
                <div class="feature-card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center; transition: transform 0.2s;">
                    <div style="width: 64px; height: 64px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <span style="font-size: 2rem;">🔍</span>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Advanced Scanner', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b; line-height: 1.6;">
                        <?php _e('Powerful stock screening with 50+ technical and fundamental filters to find your next trade.', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
                <!-- Portfolio Management -->
                <div class="feature-card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center; transition: transform 0.2s;">
                    <div style="width: 64px; height: 64px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <span style="font-size: 2rem;">📊</span>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Portfolio Tracking', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b; line-height: 1.6;">
                        <?php _e('Comprehensive portfolio analytics with performance tracking, risk analysis, and tax reporting.', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Market Overview Section -->
    <section style="padding: 6rem 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('Live Market Overview', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.125rem; color: #64748b;">
                    <?php _e('Stay updated with real-time market movements and key indices.', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <!-- Market Data Grid -->
            <div id="home-market-overview" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <!-- Market data populated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Pricing Preview Section -->
    <section style="padding: 6rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('Choose Your Trading Plan', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.125rem; color: #64748b;">
                    <?php _e('From casual lookup users to professional trading firms.', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <!-- Pricing Cards Preview -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 900px; margin: 0 auto;">
                
                <!-- Free Plan -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem; color: #0f172a;">Free</h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">$0</div>
                    <p style="color: #64748b; margin-bottom: 2rem;">Perfect for getting started</p>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" 
                       style="background: #e2e8f0; color: #475569; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-block;">
                        <?php _e('Get Started', 'retail-trade-scanner'); ?>
                    </a>
                </div>
                
                <!-- Pro Plan -->
                <div style="background: linear-gradient(135deg, #059669, #047857); color: white; border-radius: 12px; padding: 2rem; text-align: center; transform: scale(1.05); position: relative;">
                    <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #fbbf24; color: #92400e; padding: 0.25rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                        <?php _e('Popular', 'retail-trade-scanner'); ?>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem;">Pro</h3>
                    <div style="font-size: 3rem; font-weight: bold; margin-bottom: 1rem;">$29</div>
                    <p style="margin-bottom: 2rem; opacity: 0.9;">For serious traders</p>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" 
                       style="background: white; color: #059669; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block;">
                        <?php _e('Start Free Trial', 'retail-trade-scanner'); ?>
                    </a>
                </div>
                
                <!-- Enterprise Plan -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem; color: #0f172a;">Enterprise</h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">$99</div>
                    <p style="color: #64748b; margin-bottom: 2rem;">For trading firms</p>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                       style="background: #0f172a; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-block;">
                        <?php _e('Contact Sales', 'retail-trade-scanner'); ?>
                    </a>
                </div>
                
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" 
                   style="color: #059669; text-decoration: none; font-weight: 600; font-size: 1.125rem;">
                    <?php _e('View all plans and features →', 'retail-trade-scanner'); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<script>
// Home page JavaScript for market data and interactions
document.addEventListener('DOMContentLoaded', function() {
    loadMarketTicker();
    loadHomeMarketOverview();
    initializeHoverEffects();
});

function loadMarketTicker() {
    const ticker = document.getElementById('market-ticker');
    if (ticker) {
        // Mock market ticker data
        const tickerData = [
            { symbol: 'SPY', price: 445.67, change: 2.34, percent: 0.53 },
            { symbol: 'QQQ', price: 378.92, change: -1.45, percent: -0.38 },
            { symbol: 'IWM', price: 198.45, change: 0.87, percent: 0.44 }
        ];
        
        ticker.innerHTML = `
            <div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 2rem;">
                ${tickerData.map(item => `
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="font-weight: 600; font-size: 1.125rem;">${item.symbol}</div>
                        <div style="font-weight: 600; font-size: 1.125rem;">$${item.price}</div>
                        <div style="font-weight: 500; color: ${item.change >= 0 ? '#10b981' : '#ef4444'};">
                            ${item.change >= 0 ? '+' : ''}${item.change} (${item.percent >= 0 ? '+' : ''}${item.percent}%)
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
}

function loadHomeMarketOverview() {
    const container = document.getElementById('home-market-overview');
    if (container) {
        // Mock market overview data
        const marketData = [
            { name: 'S&P 500', symbol: 'SPY', price: 445.67, change: 2.34, percent: 0.53 },
            { name: 'NASDAQ', symbol: 'QQQ', price: 378.92, change: -1.45, percent: -0.38 },
            { name: 'Dow Jones', symbol: 'DIA', price: 345.23, change: 1.87, percent: 0.54 },
            { name: 'Russell 2000', symbol: 'IWM', price: 198.45, change: 0.87, percent: 0.44 }
        ];
        
        container.innerHTML = marketData.map(item => `
            <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); border-left: 4px solid ${item.change >= 0 ? '#10b981' : '#ef4444'};">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                    <div>
                        <h3 style="font-weight: 600; margin-bottom: 0.25rem;">${item.name}</h3>
                        <div style="font-size: 0.875rem; color: #64748b;">${item.symbol}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 1.25rem; font-weight: 600;">$${item.price}</div>
                        <div style="font-size: 0.875rem; font-weight: 500; color: ${item.change >= 0 ? '#10b981' : '#ef4444'};">
                            ${item.change >= 0 ? '+' : ''}${item.change} (${item.percent >= 0 ? '+' : ''}${item.percent}%)
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function initializeHoverEffects() {
    // Add hover effects to feature cards
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 10px 15px -3px rgb(0 0 0 / 0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 6px -1px rgb(0 0 0 / 0.1)';
        });
    });
    
    // Add hover effects to CTA buttons
    const btnPrimary = document.querySelector('.btn-primary');
    const btnSecondary = document.querySelector('.btn-secondary');
    
    if (btnPrimary) {
        btnPrimary.addEventListener('mouseenter', function() {
            this.style.background = '#047857';
            this.style.transform = 'translateY(-2px)';
        });
        
        btnPrimary.addEventListener('mouseleave', function() {
            this.style.background = '#059669';
            this.style.transform = 'translateY(0)';
        });
    }
    
    if (btnSecondary) {
        btnSecondary.addEventListener('mouseenter', function() {
            this.style.background = '#cbd5e1';
            this.style.color = '#0f172a';
        });
        
        btnSecondary.addEventListener('mouseleave', function() {
            this.style.background = 'transparent';
            this.style.color = '#cbd5e1';
        });
    }
}
</script>

<?php get_footer(); ?>