<?php
/**
 * Template for Account Settings page
 * Retail Trade Scanner - Real data integration
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">My Account</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Manage your profile, payment, and account settings</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem; max-width: 1200px; margin: 0 auto;">
            
            <!-- Sidebar Navigation -->
            <div>
                <div class="card" style="padding: 1.5rem; margin-bottom: 1.5rem; text-align: center;" id="user-profile-card">
                    <div id="user-avatar" style="width: 80px; height: 80px; background: linear-gradient(135deg, #059669, #10b981); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; font-weight: bold;">
                        ?
                    </div>
                    <h3 id="user-name" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Loading...</h3>
                    <p id="user-email" style="color: #64748b; margin-bottom: 1rem;">Loading...</p>
                    <div id="user-plan" style="background: #d1fae5; color: #047857; padding: 0.25rem 0.75rem; border-radius: 1rem; display: inline-block; font-size: 0.875rem; font-weight: 500;">
                        Loading...
                    </div>
                </div>

                <nav id="account-nav" style="background: white; border-radius: 12px; padding: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="nav-btn active" data-tab="profile" style="width: 100%; text-align: left; padding: 1rem; border: none; background: #f1f5f9; color: #1e40af; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;">
                        👤 Profile Information
                    </button>
                    <button class="nav-btn" data-tab="security" style="width: 100%; text-align: left; padding: 1rem; border: none; background: transparent; color: #64748b; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;">
                        🔒 Security & Password
                    </button>
                    <button class="nav-btn" data-tab="billing" style="width: 100%; text-align: left; padding: 1rem; border: none; background: transparent; color: #64748b; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;">
                        💳 Billing & Payment
                    </button>
                    <button class="nav-btn" data-tab="notifications" style="width: 100%; text-align: left; padding: 1rem; border: none; background: transparent; color: #64748b; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;">
                        📧 Email Notifications
                    </button>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div id="account-content">
                
                <!-- Profile Tab -->
                <div class="tab-content active" id="profile-tab">
                    <div class="card" style="padding: 2rem;">
                        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
                            <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Profile Information</h2>
                            <button id="save-profile" class="btn btn-primary" style="margin-left: auto;">Save Changes</button>
                        </div>
                        
                        <form id="profile-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">First Name</label>
                                <input type="text" name="first_name" id="profile-first-name" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Last Name</label>
                                <input type="text" name="last_name" id="profile-last-name" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Email Address</label>
                                <input type="email" name="email" id="profile-email" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Phone Number</label>
                                <input type="tel" name="phone" id="profile-phone" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Company</label>
                                <input type="text" name="company" id="profile-company" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab -->
                <div class="tab-content" id="security-tab" style="display: none;">
                    <div class="card" style="padding: 2rem;">
                        <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem;">Security & Password</h2>
                        
                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Change Password</h3>
                            <form id="change-password-form" style="display: grid; gap: 1rem; max-width: 400px;">
                                <div>
                                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Current Password</label>
                                    <input type="password" name="current_password" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" required>
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">New Password</label>
                                    <input type="password" name="new_password" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" required>
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Confirm New Password</label>
                                    <input type="password" name="confirm_password" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" required>
                                </div>
                                <button type="submit" class="btn btn-primary" style="justify-self: start;">Update Password</button>
                            </form>
                        </div>

                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Security Information</h3>
                            <div id="security-info" style="display: grid; gap: 1rem;">
                                <!-- Security info will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billing Tab -->
                <div class="tab-content" id="billing-tab" style="display: none;">
                    <div class="card" style="padding: 2rem;">
                        <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem;">Billing & Payment</h2>
                        
                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;">Current Plan</h3>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-outline">Manage Plan</a>
                            </div>
                            <div id="current-plan-info" style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 6px; padding: 1rem;">
                                <!-- Plan info will be populated by JavaScript -->
                            </div>
                        </div>

                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;">Billing History</h3>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('billing-history'))); ?>" class="btn btn-outline">View All History</a>
                            </div>
                            <div id="recent-billing" style="display: grid; gap: 0.75rem;">
                                <!-- Recent billing items will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Notifications Tab -->
                <div class="tab-content" id="notifications-tab" style="display: none;">
                    <div class="card" style="padding: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                            <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Email Notification Settings</h2>
                            <button id="save-notifications" class="btn btn-primary">Save Settings</button>
                        </div>
                        
                        <div id="notification-settings" style="display: grid; gap: 1rem;">
                            <!-- Notification settings will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load user data
    loadUserData();
    
    // Tab Navigation
    const navButtons = document.querySelectorAll('.nav-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    navButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Remove active class from all buttons and tabs
            navButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.background = 'transparent';
                btn.style.color = '#64748b';
            });
            
            tabContents.forEach(tab => {
                tab.classList.remove('active');
                tab.style.display = 'none';
            });
            
            // Add active class to clicked button and corresponding tab
            this.classList.add('active');
            this.style.background = '#f1f5f9';
            this.style.color = '#1e40af';
            
            const activeTab = document.getElementById(tabName + '-tab');
            if (activeTab) {
                activeTab.classList.add('active');
                activeTab.style.display = 'block';
            }
        });
    });
    
    // Profile Form Handler
    document.getElementById('save-profile').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('profile-form'));
        const profileData = Object.fromEntries(formData);
        
        // API call to update profile
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/user/profile')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            },
            body: JSON.stringify(profileData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Profile updated successfully', 'success');
                loadUserData(); // Refresh user data
            } else {
                showNotification('Failed to update profile', 'error');
            }
        })
        .catch(error => {
            showNotification('Error updating profile', 'error');
        });
    });
    
    // Change Password Handler
    document.getElementById('change-password-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        if (formData.get('new_password') !== formData.get('confirm_password')) {
            showNotification('Passwords do not match', 'error');
            return;
        }
        
        const passwordData = {
            current_password: formData.get('current_password'),
            new_password: formData.get('new_password')
        };
        
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/user/change-password')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            },
            body: JSON.stringify(passwordData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Password changed successfully', 'success');
                this.reset();
            } else {
                showNotification(data.message || 'Failed to change password', 'error');
            }
        })
        .catch(error => {
            showNotification('Error changing password', 'error');
        });
    });
    
    // Load initial data
    loadNotificationSettings();
});

function loadUserData() {
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/user/profile')); ?>', {
        method: 'GET',
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            const user = data.data;
            
            // Update sidebar profile
            const initials = `${user.first_name?.[0] || ''}${user.last_name?.[0] || ''}` || 'U';
            document.getElementById('user-avatar').textContent = initials;
            document.getElementById('user-name').textContent = `${user.first_name || ''} ${user.last_name || ''}`.trim() || 'User';
            document.getElementById('user-email').textContent = user.email || '';
            document.getElementById('user-plan').textContent = user.plan || 'Free Plan';
            
            // Update form fields
            document.getElementById('profile-first-name').value = user.first_name || '';
            document.getElementById('profile-last-name').value = user.last_name || '';
            document.getElementById('profile-email').value = user.email || '';
            document.getElementById('profile-phone').value = user.phone || '';
            document.getElementById('profile-company').value = user.company || '';
            
            // Load billing info
            loadBillingInfo(user);
            loadSecurityInfo(user);
        }
    })
    .catch(error => {
        console.error('Error loading user data:', error);
        // Set defaults for logged-in WordPress users
        <?php if (is_user_logged_in()) : ?>
            const wpUser = <?php echo json_encode([
                'first_name' => get_user_meta(get_current_user_id(), 'first_name', true),
                'last_name' => get_user_meta(get_current_user_id(), 'last_name', true),
                'email' => wp_get_current_user()->user_email,
            ]); ?>;
            
            document.getElementById('user-name').textContent = `${wpUser.first_name} ${wpUser.last_name}`.trim() || 'User';
            document.getElementById('user-email').textContent = wpUser.email;
            document.getElementById('profile-first-name').value = wpUser.first_name;
            document.getElementById('profile-last-name').value = wpUser.last_name;
            document.getElementById('profile-email').value = wpUser.email;
        <?php endif; ?>
    });
}

function loadBillingInfo(user) {
    document.getElementById('current-plan-info').innerHTML = `
        <div style="font-weight: 600; color: #1e40af;">${user.plan || 'Free Plan'} - ${user.plan_price || '$0'}/month</div>
        <div style="color: #1d4ed8; font-size: 0.875rem;">Next billing date: ${user.next_billing || 'N/A'}</div>
    `;
    
    // Load recent billing
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/billing/history')); ?>?limit=3', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            loadRecentBilling(data.data);
        } else {
            loadRecentBilling([]);
        }
    })
    .catch(error => {
        console.error('Billing error:', error);
        loadRecentBilling([]);
    });
}

function loadSecurityInfo(user) {
    document.getElementById('security-info').innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-weight: 500;">Last Password Change</div>
                <div style="color: #64748b; font-size: 0.875rem;">${user.last_password_change || 'Never'}</div>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-weight: 500;">Account Status</div>
                <div style="color: #059669; font-size: 0.875rem;">✓ Active and Secure</div>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-weight: 500;">Last Login</div>
                <div style="color: #64748b; font-size: 0.875rem;">${user.last_login || 'Unknown'}</div>
            </div>
        </div>
    `;
}

function loadNotificationSettings() {
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/user/notifications')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        const settings = data.success && data.data ? data.data : {
            email_alerts: true,
            price_alerts: true,
            news_updates: false,
            portfolio_updates: true,
            weekly_reports: true
        };
        
        renderNotificationSettings(settings);
    })
    .catch(error => {
        console.error('Notification settings error:', error);
        renderNotificationSettings({
            email_alerts: true,
            price_alerts: true,
            news_updates: false,
            portfolio_updates: true,
            weekly_reports: true
        });
    });
}

function renderNotificationSettings(settings) {
    const container = document.getElementById('notification-settings');
    const settingsConfig = [
        { id: 'email_alerts', label: 'Email Alerts', description: 'Receive important alerts via email' },
        { id: 'price_alerts', label: 'Price Alerts', description: 'Get notified when stocks hit your target prices' },
        { id: 'news_updates', label: 'News Updates', description: 'Stay informed with relevant market news' },
        { id: 'portfolio_updates', label: 'Portfolio Updates', description: 'Receive updates about portfolio performance' },
        { id: 'weekly_reports', label: 'Weekly Reports', description: 'Get weekly performance summaries' }
    ];
    
    container.innerHTML = settingsConfig.map(setting => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
            <div>
                <div style="font-weight: 500; margin-bottom: 0.25rem;">${setting.label}</div>
                <div style="color: #64748b; font-size: 0.875rem;">${setting.description}</div>
            </div>
            <label style="position: relative; display: inline-block; width: 44px; height: 24px;">
                <input type="checkbox" ${settings[setting.id] ? 'checked' : ''} data-setting="${setting.id}" style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: ${settings[setting.id] ? '#059669' : '#ccc'}; border-radius: 24px; transition: 0.4s;"></span>
                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: ${settings[setting.id] ? '23px' : '3px'}; bottom: 3px; background-color: white; border-radius: 50%; transition: 0.4s;"></span>
            </label>
        </div>
    `).join('');
    
    // Add event listeners to toggles
    container.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const slider = this.nextElementSibling;
            const knob = slider.nextElementSibling;
            
            if (this.checked) {
                slider.style.backgroundColor = '#059669';
                knob.style.left = '23px';
            } else {
                slider.style.backgroundColor = '#ccc';
                knob.style.left = '3px';
            }
        });
    });
    
    // Save notifications handler
    document.getElementById('save-notifications').addEventListener('click', function() {
        const checkboxes = container.querySelectorAll('input[type="checkbox"]');
        const notificationData = {};
        
        checkboxes.forEach(checkbox => {
            notificationData[checkbox.dataset.setting] = checkbox.checked;
        });
        
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/user/notifications')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            },
            body: JSON.stringify(notificationData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Notification settings saved', 'success');
            } else {
                showNotification('Failed to save settings', 'error');
            }
        })
        .catch(error => {
            showNotification('Error saving settings', 'error');
        });
    });
}

function loadRecentBilling(items) {
    const container = document.getElementById('recent-billing');
    
    if (items.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #64748b;">
                <p>No billing history available.</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = items.map(item => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #f9fafb; border-radius: 6px;">
            <div>
                <div style="font-weight: 500; margin-bottom: 0.25rem;">${item.description || 'Subscription'}</div>
                <div style="color: #64748b; font-size: 0.875rem;">${item.date}</div>
            </div>
            <div style="text-align: right;">
                <div style="font-weight: 600; margin-bottom: 0.25rem;">${item.amount}</div>
                <div style="color: #059669; font-size: 0.875rem;">${item.status}</div>
            </div>
        </div>
    `).join('');
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
    `;
    
    notification.style.backgroundColor = type === 'success' ? '#059669' : '#dc2626';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

<?php get_footer(); ?>