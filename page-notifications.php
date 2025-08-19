<?php
/**
 * Template for Notifications page
 * Retail Trade Scanner - Notification management
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Notifications</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Manage your alerts and notification preferences</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            
            <!-- Notification Categories -->
            <div>
                <div class="card" style="padding: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Quick Actions</h2>
                    
                    <div style="display: grid; gap: 1rem;">
                        <button id="enable-all" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            🔔 Enable All Notifications
                        </button>
                        <button id="disable-all" class="btn btn-outline" style="width: 100%; justify-content: center;">
                            🔕 Disable All Notifications  
                        </button>
                        <button id="reset-defaults" class="btn btn-outline" style="width: 100%; justify-content: center;">
                            ↻ Reset to Defaults
                        </button>
                    </div>
                </div>

                <div class="card" style="padding: 1.5rem; margin-top: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Notification Summary</h2>
                    
                    <div id="notification-summary" style="display: grid; gap: 0.75rem;">
                        <!-- Summary will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Main Notification Settings -->
            <div class="card" style="padding: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Notification Settings</h2>
                    <button id="save-all-notifications" class="btn btn-primary">Save All Changes</button>
                </div>

                <div id="notification-categories">
                    
                    <!-- Trading Alerts -->
                    <div class="notification-category" style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: #1e40af; display: flex; align-items: center;">
                            📈 Trading Alerts
                        </h3>
                        <div style="display: grid; gap: 1rem; padding-left: 1rem;">
                            <div class="notification-setting" data-category="trading" data-setting="price_alerts">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Price Alerts</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Get notified when stocks hit your target prices</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="trading" data-setting="volume_alerts">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Volume Alerts</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Alert when unusual trading volume is detected</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="trading" data-setting="market_hours">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Market Hours</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Notifications about market open/close times</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="false">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Portfolio Updates -->
                    <div class="notification-category" style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: #059669; display: flex; align-items: center;">
                            📊 Portfolio Updates
                        </h3>
                        <div style="display: grid; gap: 1rem; padding-left: 1rem;">
                            <div class="notification-setting" data-category="portfolio" data-setting="daily_summary">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Daily Summary</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Daily portfolio performance summary</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="portfolio" data-setting="weekly_report">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Weekly Report</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Comprehensive weekly performance reports</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="portfolio" data-setting="milestone_alerts">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Milestone Alerts</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Get notified of significant gains or losses</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- News & Market -->
                    <div class="notification-category" style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: #7c3aed; display: flex; align-items: center;">
                            📰 News & Market Updates
                        </h3>
                        <div style="display: grid; gap: 1rem; padding-left: 1rem;">
                            <div class="notification-setting" data-category="news" data-setting="breaking_news">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Breaking News</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Important market-moving news alerts</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="news" data-setting="earnings_alerts">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Earnings Alerts</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Notifications for upcoming earnings reports</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="false">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="news" data-setting="analyst_ratings">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Analyst Ratings</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Updates on analyst upgrades/downgrades</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="false">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account & Security -->
                    <div class="notification-category" style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: #dc2626; display: flex; align-items: center;">
                            🔐 Account & Security
                        </h3>
                        <div style="display: grid; gap: 1rem; padding-left: 1rem;">
                            <div class="notification-setting" data-category="security" data-setting="login_alerts">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Login Alerts</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Get notified of account login activity</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="security" data-setting="billing_updates">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Billing Updates</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Notifications for billing and payment issues</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="notification-setting" data-category="security" data-setting="plan_updates">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 500; margin-bottom: 0.25rem;">Plan Updates</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">Changes to your subscription plan</div>
                                    </div>
                                    <div class="toggle-switch" data-enabled="true">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<style>
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    border-radius: 24px;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    border-radius: 50%;
    transition: 0.4s;
}

.toggle-switch input:checked + .slider {
    background-color: #059669;
}

.toggle-switch input:checked + .slider:before {
    transform: translateX(20px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeNotificationToggles();
    updateNotificationSummary();
    
    // Quick action buttons
    document.getElementById('enable-all').addEventListener('click', function() {
        toggleAllNotifications(true);
    });
    
    document.getElementById('disable-all').addEventListener('click', function() {
        toggleAllNotifications(false);
    });
    
    document.getElementById('reset-defaults').addEventListener('click', function() {
        resetToDefaults();
    });
    
    // Save all notifications
    document.getElementById('save-all-notifications').addEventListener('click', function() {
        saveNotificationSettings();
    });
});

function initializeNotificationToggles() {
    const toggles = document.querySelectorAll('.toggle-switch');
    
    toggles.forEach(toggle => {
        const checkbox = toggle.querySelector('input[type="checkbox"]');
        const slider = toggle.querySelector('.slider');
        
        // Set initial state based on data-enabled attribute
        const isEnabled = toggle.dataset.enabled === 'true';
        checkbox.checked = isEnabled;
        
        // Add change event listener
        checkbox.addEventListener('change', function() {
            toggle.dataset.enabled = this.checked ? 'true' : 'false';
            updateNotificationSummary();
        });
    });
}

function toggleAllNotifications(enable) {
    const toggles = document.querySelectorAll('.toggle-switch');
    
    toggles.forEach(toggle => {
        const checkbox = toggle.querySelector('input[type="checkbox"]');
        checkbox.checked = enable;
        toggle.dataset.enabled = enable ? 'true' : 'false';
    });
    
    updateNotificationSummary();
    showNotification(enable ? 'All notifications enabled' : 'All notifications disabled', 'success');
}

function resetToDefaults() {
    const defaults = {
        'price_alerts': true,
        'volume_alerts': true,
        'market_hours': false,
        'daily_summary': true,
        'weekly_report': true,
        'milestone_alerts': true,
        'breaking_news': true,
        'earnings_alerts': false,
        'analyst_ratings': false,
        'login_alerts': true,
        'billing_updates': true,
        'plan_updates': true
    };
    
    const settings = document.querySelectorAll('.notification-setting');
    settings.forEach(setting => {
        const settingName = setting.dataset.setting;
        const toggle = setting.querySelector('.toggle-switch');
        const checkbox = toggle.querySelector('input[type="checkbox"]');
        
        const defaultValue = defaults[settingName] || false;
        checkbox.checked = defaultValue;
        toggle.dataset.enabled = defaultValue ? 'true' : 'false';
    });
    
    updateNotificationSummary();
    showNotification('Settings reset to defaults', 'success');
}

function updateNotificationSummary() {
    const container = document.getElementById('notification-summary');
    const categories = {
        trading: { name: 'Trading Alerts', icon: '📈', count: 0, enabled: 0 },
        portfolio: { name: 'Portfolio Updates', icon: '📊', count: 0, enabled: 0 },
        news: { name: 'News & Market', icon: '📰', count: 0, enabled: 0 },
        security: { name: 'Account & Security', icon: '🔐', count: 0, enabled: 0 }
    };
    
    const settings = document.querySelectorAll('.notification-setting');
    settings.forEach(setting => {
        const category = setting.dataset.category;
        const toggle = setting.querySelector('.toggle-switch');
        const isEnabled = toggle.dataset.enabled === 'true';
        
        if (categories[category]) {
            categories[category].count++;
            if (isEnabled) {
                categories[category].enabled++;
            }
        }
    });
    
    container.innerHTML = Object.values(categories).map(cat => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span>${cat.icon}</span>
                <span style="font-size: 0.875rem; color: #64748b;">${cat.name}</span>
            </div>
            <div style="font-size: 0.875rem; font-weight: 500; color: ${cat.enabled === cat.count ? '#059669' : cat.enabled === 0 ? '#dc2626' : '#f59e0b'};">
                ${cat.enabled}/${cat.count}
            </div>
        </div>
    `).join('');
}

function saveNotificationSettings() {
    const settings = {};
    const notificationSettings = document.querySelectorAll('.notification-setting');
    
    notificationSettings.forEach(setting => {
        const category = setting.dataset.category;
        const settingName = setting.dataset.setting;
        const toggle = setting.querySelector('.toggle-switch');
        const isEnabled = toggle.dataset.enabled === 'true';
        
        if (!settings[category]) {
            settings[category] = {};
        }
        settings[category][settingName] = isEnabled;
    });
    
    // Save to backend API
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/user/notification-settings')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        },
        body: JSON.stringify(settings)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Notification settings saved successfully', 'success');
        } else {
            showNotification('Failed to save notification settings', 'error');
        }
    })
    .catch(error => {
        showNotification('Error saving notification settings', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        z-index: 1000;
        max-width: 300px;
        font-weight: 500;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    `;
    
    notification.style.backgroundColor = type === 'success' ? '#059669' : '#dc2626';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

<?php get_footer(); ?>