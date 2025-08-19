<?php
/**
 * Template for COMPLIANT Usage Dashboard - Matches Premium Plans Page
 * Retail Trade Scanner Theme
 */

// Redirect if not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: var(--background-primary, #f8fafc);" role="main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: var(--text-primary, #0f172a); margin-bottom: 0.5rem;">
                <?php _e('Usage Dashboard', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: var(--text-secondary, #64748b);">
                <?php _e('Monitor your monthly usage and plan features', 'retail-trade-scanner'); ?>
            </p>
        </div>

        <!-- Current Tier Card -->
        <div class="card" style="padding: 2rem; margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary, #0f172a);">
                        <?php _e('Current Subscription', 'retail-trade-scanner'); ?>
                    </h2>
                    <div id="current-tier-info">
                        <div class="loading-spinner" style="margin: 1rem 0;"></div>
                        <p><?php _e('Loading subscription details...', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button id="refresh-tier-btn" class="btn btn-outline">
                        🔄 <?php _e('Refresh Status', 'retail-trade-scanner'); ?>
                    </button>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-primary">
                        ⭐ <?php _e('Upgrade Plan', 'retail-trade-scanner'); ?>
                    </a>
                </div>
            </div>
            
            <!-- Tier Benefits -->
            <div id="tier-benefits" style="display: none;">
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary, #0f172a);">
                    <?php _e('Your Plan Benefits', 'retail-trade-scanner'); ?>
                </h3>
                <div id="benefits-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <!-- Benefits populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Monthly Usage Statistics (As Advertised) -->
        <div class="card" style="padding: 2rem; margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: var(--text-primary, #0f172a);">
                    <?php _e('Monthly Usage (As Per Premium Plans)', 'retail-trade-scanner'); ?>
                </h2>
                <div style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                    <?php _e('Resets monthly', 'retail-trade-scanner'); ?>
                </div>
            </div>
            
            <div id="monthly-usage-stats">
                <div class="loading-spinner" style="margin: 2rem auto;"></div>
                <p style="text-align: center; color: var(--text-secondary, #64748b);">
                    <?php _e('Loading monthly usage statistics...', 'retail-trade-scanner'); ?>
                </p>
            </div>
        </div>

        <!-- Feature Access Status -->
        <div class="card" style="padding: 2rem; margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-primary, #0f172a);">
                <?php _e('Feature Access Status', 'retail-trade-scanner'); ?>
            </h2>
            
            <div id="feature-access">
                <div class="loading-spinner" style="margin: 2rem auto;"></div>
                <p style="text-align: center; color: var(--text-secondary, #64748b);">
                    <?php _e('Loading feature access...', 'retail-trade-scanner'); ?>
                </p>
            </div>
        </div>

        <!-- Plan Comparison (Matches Premium Plans Page) -->
        <div class="card" style="padding: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-primary, #0f172a);">
                <?php _e('Plan Comparison', 'retail-trade-scanner'); ?>
            </h2>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; min-width: 600px; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--background-tertiary, #f1f5f9);">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Feature</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Free</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Bronze</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Silver</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Gold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Monthly Stock Lookups</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">15</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">1,000</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">5,000</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">10,000</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Email Subscriptions</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">5</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">15</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Unlimited</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Unlimited</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Custom Watchlists</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--danger-color, #dc2626);">❌</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">3</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">10</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Unlimited</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Historical Data</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--danger-color, #dc2626);">❌</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">30 days</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">1 year</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">5 years</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Advanced Filtering</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--danger-color, #dc2626);">❌</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Basic</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅</td>
                            <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.75rem;">API Access</td>
                            <td style="padding: 0.75rem; text-align: center; color: var(--danger-color, #dc2626);">❌</td>
                            <td style="padding: 0.75rem; text-align: center; color: var(--danger-color, #dc2626);">❌</td>
                            <td style="padding: 0.75rem; text-align: center;">Limited</td>
                            <td style="padding: 0.75rem; text-align: center; color: var(--success-color, #059669);">Full</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCompliantUsageStats();
    
    // Auto-refresh every 30 seconds
    setInterval(loadCompliantUsageStats, 30000);
    
    // Manual refresh button
    document.getElementById('refresh-tier-btn').addEventListener('click', function() {
        refreshTierStatus();
    });
});

function loadCompliantUsageStats() {
    fetch(window.retail_trade_scanner_data?.ajax_url || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'retail_trade_scanner_get_compliant_usage_stats',
            nonce: window.retail_trade_scanner_data?.nonce || ''
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayTierInfo(data.data.tier);
            displayMonthlyUsageStats(data.data.usage);
            displayFeatureAccess(data.data.features);
        } else {
            showError('Failed to load usage statistics');
        }
    })
    .catch(error => {
        showError('Error loading usage statistics');
    });
}

function displayTierInfo(tier) {
    const container = document.getElementById('current-tier-info');
    const benefitsContainer = document.getElementById('tier-benefits');
    
    const tierColors = {
        'free': '#64748b',
        'bronze': '#cd7f32',
        'silver': '#c0c0c0',
        'gold': '#ffd700'
    };
    
    const tierNames = {
        'free': 'Free',
        'bronze': 'Bronze',
        'silver': 'Silver', 
        'gold': 'Gold'
    };
    
    const tierPrices = {
        'free': '$0',
        'bronze': '$14.99',
        'silver': '$29.99',
        'gold': '$59.99'
    };
    
    container.innerHTML = `
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="width: 60px; height: 60px; background: ${tierColors[tier]}; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;">
                ${tierNames[tier].charAt(0)}
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: var(--text-primary, #0f172a);">
                        ${tierNames[tier]} Plan
                    </div>
                    <div style="font-size: 1.25rem; font-weight: 600; color: var(--text-secondary, #64748b);">
                        ${tierPrices[tier]}/month
                    </div>
                </div>
                <div style="color: var(--text-secondary, #64748b);">
                    Active subscription tier
                </div>
            </div>
        </div>
    `;
    
    // Show benefits matching premium plans page
    displayTierBenefits(tier);
    benefitsContainer.style.display = 'block';
}

function displayTierBenefits(tier) {
    // Benefits matching EXACTLY what's on the premium plans page
    const benefits = {
        'free': [
            { icon: '📊', title: 'Stock Lookups', desc: '15 per month' },
            { icon: '🔍', title: 'Symbol Search', desc: 'Basic lookup' },
            { icon: '⚙️', title: 'Price Filtering', desc: 'Basic filtering' },
            { icon: '❌', title: 'No Portfolio', desc: 'Management' }
        ],
        'bronze': [
            { icon: '📊', title: 'Stock Lookups', desc: '1,000 per month' },
            { icon: '🔍', title: 'Full Scanner', desc: '& lookup' },
            { icon: '📧', title: 'Email Alerts', desc: '& notifications' },
            { icon: '📰', title: 'News Sentiment', desc: 'Analysis' },
            { icon: '💼', title: 'Portfolio', desc: 'Basic tracking' }
        ],
        'silver': [
            { icon: '📊', title: 'Stock Lookups', desc: '5,000 per month' },
            { icon: '🔍', title: 'Advanced Filter', desc: '& screening' },
            { icon: '📈', title: 'Historical Data', desc: '1-year access' },
            { icon: '👁️', title: 'Watchlists', desc: '10 custom lists' },
            { icon: '🏆', title: 'Priority', desc: 'Support' }
        ],
        'gold': [
            { icon: '📊', title: 'Stock Lookups', desc: '10,000 per month' },
            { icon: '🌟', title: 'All Premium', desc: 'Features' },
            { icon: '⚡', title: 'Real-time', desc: 'Alerts' },
            { icon: '🔌', title: 'Full REST API', desc: 'Access' },
            { icon: '📞', title: 'Phone Support', desc: '+ Manager' }
        ]
    };
    
    const benefitsGrid = document.getElementById('benefits-grid');
    benefitsGrid.innerHTML = benefits[tier].map(benefit => `
        <div style="background: var(--background-tertiary, #f1f5f9); padding: 1rem; border-radius: 8px; text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">${benefit.icon}</div>
            <div style="font-weight: 600; margin-bottom: 0.25rem; color: var(--text-primary, #0f172a);">${benefit.title}</div>
            <div style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">${benefit.desc}</div>
        </div>
    `).join('');
}

function displayMonthlyUsageStats(usage) {
    const container = document.getElementById('monthly-usage-stats');
    
    container.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            ${Object.entries(usage).map(([key, stats]) => {
                const titles = {
                    'monthly_stock_lookups': 'Monthly Stock Lookups',
                    'email_subscriptions': 'Email Subscriptions',
                    'watchlists': 'Custom Watchlists'
                };
                
                const title = titles[key] || key;
                const isUnlimited = stats.limit === 'unlimited';
                const percentage = isUnlimited ? 0 : stats.percentage;
                const isOverLimit = stats.used >= stats.limit && !isUnlimited;
                
                let statusColor = 'var(--success-color, #059669)';
                let statusText = 'Available';
                
                if (stats.limit === 0) {
                    statusColor = 'var(--text-muted, #94a3b8)';
                    statusText = 'Not Available';
                } else if (isOverLimit) {
                    statusColor = 'var(--danger-color, #dc2626)';
                    statusText = 'Limit Reached';
                } else if (percentage > 80 && !isUnlimited) {
                    statusColor = 'var(--warning-color, #d97706)';
                    statusText = 'Near Limit';
                }
                
                return `
                    <div class="card" style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0; color: var(--text-primary, #0f172a);">
                                ${title}
                            </h3>
                            <span style="color: ${statusColor}; font-size: 0.875rem; font-weight: 500;">
                                ${statusText}
                            </span>
                        </div>
                        
                        ${stats.limit === 0 ? `
                            <div style="text-align: center; padding: 1rem; color: var(--text-muted, #94a3b8); font-size: 0.875rem;">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔒</div>
                                Upgrade required for access
                            </div>
                        ` : `
                            <div style="margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">Usage</span>
                                    <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-primary, #0f172a);">
                                        ${stats.used} / ${isUnlimited ? '∞' : stats.limit}
                                    </span>
                                </div>
                                ${!isUnlimited ? `
                                    <div style="background: var(--border-primary, #e5e7eb); height: 8px; border-radius: 4px; overflow: hidden;">
                                        <div style="background: ${statusColor}; height: 100%; width: ${Math.min(percentage, 100)}%; transition: width 0.3s ease;"></div>
                                    </div>
                                ` : ''}
                            </div>
                            
                            <div style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                                ${isUnlimited ? 'Unlimited usage' : `${stats.remaining} remaining this month`}
                            </div>
                        `}
                    </div>
                `;
            }).join('')}
        </div>
    `;
}

function displayFeatureAccess(features) {
    const container = document.getElementById('feature-access');
    
    const featureNames = {
        'advanced_filtering': 'Advanced Filtering & Screening',
        'api_access': 'API Access',
        'historical_data_days': 'Historical Data Access',
        'support_level': 'Support Level'
    };
    
    container.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            ${Object.entries(features).map(([key, value]) => {
                const name = featureNames[key] || key;
                let displayValue = value;
                let statusColor = 'var(--success-color, #059669)';
                let icon = '✅';
                
                if (value === false || value === 0) {
                    displayValue = 'Not Available';
                    statusColor = 'var(--text-muted, #94a3b8)';
                    icon = '❌';
                } else if (key === 'historical_data_days') {
                    if (value >= 1825) displayValue = '5 Years';
                    else if (value >= 365) displayValue = '1 Year';
                    else if (value >= 30) displayValue = '30 Days';
                    else displayValue = 'Not Available';
                } else if (key === 'support_level') {
                    const levels = {
                        'community': 'Community',
                        'email': 'Email Support',
                        'priority': 'Priority Support',
                        'phone_manager': 'Phone + Manager'
                    };
                    displayValue = levels[value] || value;
                } else if (value === 'basic') {
                    displayValue = 'Basic Access';
                } else if (value === 'limited') {
                    displayValue = 'Limited Access';
                } else if (value === 'full') {
                    displayValue = 'Full Access';
                }
                
                return `
                    <div style="background: var(--background-tertiary, #f1f5f9); padding: 1rem; border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <span style="font-size: 1.25rem;">${icon}</span>
                            <div style="font-weight: 600; color: var(--text-primary, #0f172a);">${name}</div>
                        </div>
                        <div style="color: ${statusColor}; font-weight: 500;">
                            ${displayValue}
                        </div>
                    </div>
                `;
            }).join('')}
        </div>
    `;
}

function refreshTierStatus() {
    const btn = document.getElementById('refresh-tier-btn');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<span class="loading-spinner" style="width: 16px; height: 16px; margin-right: 0.5rem;"></span> Refreshing...';
    btn.disabled = true;
    
    // Use the existing refresh function but update action name
    fetch(window.retail_trade_scanner_data?.ajax_url || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'retail_trade_scanner_refresh_tier',
            nonce: window.retail_trade_scanner_data?.nonce || ''
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess(data.data.message);
            loadCompliantUsageStats(); // Reload stats with new tier
        } else {
            showError('Failed to refresh tier status');
        }
    })
    .catch(error => {
        showError('Error refreshing tier status');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function showError(message) {
    if (window.showNotification) {
        window.showNotification(message, 'error');
    }
}

function showSuccess(message) {
    if (window.showNotification) {
        window.showNotification(message, 'success');
    }
}
</script>

<?php get_footer(); ?>