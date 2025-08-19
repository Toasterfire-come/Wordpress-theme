<?php
/**
 * Template for Usage Dashboard - User Tier & Rate Limit Monitoring
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
                <?php _e('Monitor your API usage and subscription tier limits', 'retail-trade-scanner'); ?>
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

        <!-- Usage Statistics -->
        <div class="card" style="padding: 2rem; margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0; color: var(--text-primary, #0f172a);">
                    <?php _e('Current Usage (Per Minute)', 'retail-trade-scanner'); ?>
                </h2>
                <div style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                    <?php _e('Resets every minute', 'retail-trade-scanner'); ?>
                </div>
            </div>
            
            <div id="usage-stats">
                <div class="loading-spinner" style="margin: 2rem auto;"></div>
                <p style="text-align: center; color: var(--text-secondary, #64748b);">
                    <?php _e('Loading usage statistics...', 'retail-trade-scanner'); ?>
                </p>
            </div>
        </div>

        <!-- Rate Limit Information -->
        <div class="card" style="padding: 2rem; margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--text-primary, #0f172a);">
                <?php _e('Rate Limit Information', 'retail-trade-scanner'); ?>
            </h2>
            
            <div style="background: var(--background-tertiary, #f1f5f9); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary, #0f172a);">
                    <?php _e('How Rate Limiting Works', 'retail-trade-scanner'); ?>
                </h3>
                <div style="display: grid; gap: 1rem; font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                    <p>• <?php _e('Rate limits are enforced per minute based on your subscription tier', 'retail-trade-scanner'); ?></p>
                    <p>• <?php _e('Each API endpoint has different limits (search, market data, real-time data, etc.)', 'retail-trade-scanner'); ?></p>
                    <p>• <?php _e('Free users have access to basic features with lower limits', 'retail-trade-scanner'); ?></p>
                    <p>• <?php _e('Premium users get higher limits and access to real-time data', 'retail-trade-scanner'); ?></p>
                    <p>• <?php _e('Limits reset every minute automatically', 'retail-trade-scanner'); ?></p>
                </div>
            </div>

            <!-- Tier Comparison -->
            <div id="tier-comparison">
                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary, #0f172a);">
                    <?php _e('Tier Comparison', 'retail-trade-scanner'); ?>
                </h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; min-width: 600px; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--background-tertiary, #f1f5f9);">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Feature</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Free</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Bronze</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Silver</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Gold</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; border-bottom: 2px solid var(--border-primary, #e5e7eb);">Platinum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">API Requests/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">20</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">100</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">300</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">1,000</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">2,500</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Real-time Data</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--danger-color, #dc2626);">❌</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 10/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 50/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 150/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 400/min</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Data Export</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--danger-color, #dc2626);">❌</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 5/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 15/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 50/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb); color: var(--success-color, #059669);">✅ 100/min</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid var(--border-primary, #e5e7eb);">Price Alerts</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">2/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">10/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">25/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">50/min</td>
                                <td style="padding: 0.75rem; text-align: center; border-bottom: 1px solid var(--border-primary, #e5e7eb);">100/min</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadUsageStats();
    
    // Auto-refresh every 30 seconds
    setInterval(loadUsageStats, 30000);
    
    // Manual refresh button
    document.getElementById('refresh-tier-btn').addEventListener('click', function() {
        refreshTierStatus();
    });
});

function loadUsageStats() {
    fetch(window.retail_trade_scanner_data?.ajax_url || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'retail_trade_scanner_get_usage_stats',
            nonce: window.retail_trade_scanner_data?.nonce || ''
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayTierInfo(data.data.tier);
            displayUsageStats(data.data.usage);
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
        'bronze': '#d97706',
        'silver': '#6b7280',
        'gold': '#f59e0b',
        'platinum': '#8b5cf6'
    };
    
    const tierNames = {
        'free': 'Free',
        'bronze': 'Bronze',
        'silver': 'Silver', 
        'gold': 'Gold',
        'platinum': 'Platinum'
    };
    
    container.innerHTML = `
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="width: 60px; height: 60px; background: ${tierColors[tier]}; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;">
                ${tierNames[tier].charAt(0)}
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: bold; color: var(--text-primary, #0f172a);">
                    ${tierNames[tier]} Plan
                </div>
                <div style="color: var(--text-secondary, #64748b);">
                    Active subscription tier
                </div>
            </div>
        </div>
    `;
    
    // Show benefits
    displayTierBenefits(tier);
    benefitsContainer.style.display = 'block';
}

function displayTierBenefits(tier) {
    const benefits = {
        'free': [
            { icon: '📊', title: 'Basic Charts', desc: '20 API requests/min' },
            { icon: '🔍', title: 'Stock Search', desc: '10 searches/min' },
            { icon: '📰', title: 'Market News', desc: '5 articles/min' },
            { icon: '🔔', title: 'Basic Alerts', desc: '2 alerts/min' }
        ],
        'bronze': [
            { icon: '📊', title: 'Enhanced Charts', desc: '100 API requests/min' },
            { icon: '🔍', title: 'Advanced Search', desc: '50 searches/min' },
            { icon: '⚡', title: 'Real-time Data', desc: '10 requests/min' },
            { icon: '💾', title: 'Data Export', desc: '5 exports/min' }
        ],
        'silver': [
            { icon: '📊', title: 'Pro Charts', desc: '300 API requests/min' },
            { icon: '⚡', title: 'Real-time Data', desc: '50 requests/min' },
            { icon: '💾', title: 'Data Export', desc: '15 exports/min' },
            { icon: '🔔', title: 'Advanced Alerts', desc: '25 alerts/min' }
        ],
        'gold': [
            { icon: '🚀', title: 'Premium Access', desc: '1,000 API requests/min' },
            { icon: '⚡', title: 'Real-time Data', desc: '150 requests/min' },
            { icon: '💾', title: 'Unlimited Export', desc: '50 exports/min' },
            { icon: '🎯', title: 'Priority Support', desc: 'Dedicated support' }
        ],
        'platinum': [
            { icon: '👑', title: 'Elite Access', desc: '2,500 API requests/min' },
            { icon: '⚡', title: 'Real-time Data', desc: '400 requests/min' },
            { icon: '💾', title: 'Bulk Export', desc: '100 exports/min' },
            { icon: '🏆', title: 'White Glove', desc: 'Premium support' }
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

function displayUsageStats(usage) {
    const container = document.getElementById('usage-stats');
    
    const actionNames = {
        'api_requests': 'API Requests',
        'search_requests': 'Stock Search',
        'market_data': 'Market Data',
        'news_requests': 'News Access',
        'portfolio_access': 'Portfolio',
        'real_time_data': 'Real-time Data',
        'alerts': 'Price Alerts',
        'export_data': 'Data Export'
    };
    
    container.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            ${Object.entries(usage).map(([action, stats]) => {
                const percentage = stats.percentage;
                const isOverLimit = stats.used >= stats.limit && stats.limit > 0;
                const hasAccess = stats.limit > 0;
                
                let statusColor = 'var(--success-color, #059669)';
                let statusText = 'Available';
                
                if (!hasAccess) {
                    statusColor = 'var(--text-muted, #94a3b8)';
                    statusText = 'Not Available';
                } else if (isOverLimit) {
                    statusColor = 'var(--danger-color, #dc2626)';
                    statusText = 'Limit Reached';
                } else if (percentage > 80) {
                    statusColor = 'var(--warning-color, #d97706)';
                    statusText = 'Near Limit';
                }
                
                return `
                    <div class="card" style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0; color: var(--text-primary, #0f172a);">
                                ${actionNames[action] || action}
                            </h3>
                            <span style="color: ${statusColor}; font-size: 0.875rem; font-weight: 500;">
                                ${statusText}
                            </span>
                        </div>
                        
                        ${hasAccess ? `
                            <div style="margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">Usage</span>
                                    <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-primary, #0f172a);">
                                        ${stats.used} / ${stats.limit}
                                    </span>
                                </div>
                                <div style="background: var(--border-primary, #e5e7eb); height: 8px; border-radius: 4px; overflow: hidden;">
                                    <div style="background: ${statusColor}; height: 100%; width: ${Math.min(percentage, 100)}%; transition: width 0.3s ease;"></div>
                                </div>
                            </div>
                            
                            <div style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                                ${stats.remaining} requests remaining
                            </div>
                        ` : `
                            <div style="text-align: center; padding: 1rem; color: var(--text-muted, #94a3b8); font-size: 0.875rem;">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔒</div>
                                Upgrade required for access
                            </div>
                        `}
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
            loadUsageStats(); // Reload stats with new tier
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