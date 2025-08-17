<?php
/**
 * Template for Account Settings page
 * Retail Trade Scanner - No 2FA, connects to existing backend
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
                <div class="card" style="padding: 1.5rem; margin-bottom: 1.5rem; text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #059669, #10b981); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; font-weight: bold;">
                        JS
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">John Smith</h3>
                    <p style="color: #64748b; margin-bottom: 1rem;">john@example.com</p>
                    <div style="background: #d1fae5; color: #047857; padding: 0.25rem 0.75rem; border-radius: 1rem; display: inline-block; font-size: 0.875rem; font-weight: 500;">
                        Pro Plan
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
                        🔔 Notifications
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
                                <input type="text" name="first_name" value="John" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Last Name</label>
                                <input type="text" name="last_name" value="Smith" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Email Address</label>
                                <input type="email" name="email" value="john@example.com" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Phone Number</label>
                                <input type="tel" name="phone" value="+1 (555) 123-4567" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Company</label>
                                <input type="text" name="company" value="Trading Corp" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab (No 2FA) -->
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
                            <div style="display: grid; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-weight: 500;">Last Password Change</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">January 15, 2024</div>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-weight: 500;">Account Status</div>
                                        <div style="color: #059669; font-size: 0.875rem;">✓ Active and Secure</div>
                                    </div>
                                </div>
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
                            <div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 6px; padding: 1rem;">
                                <div style="font-weight: 600; color: #1e40af;">Pro Plan - $49.99/month</div>
                                <div style="color: #1d4ed8; font-size: 0.875rem;">Next billing date: March 15, 2024</div>
                            </div>
                        </div>

                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;">Payment Method</h3>
                                <button id="update-payment" class="btn btn-outline">Update Payment</button>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 40px; height: 28px; background: #1a365d; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: bold;">VISA</div>
                                <div>
                                    <div style="font-weight: 500;">•••• •••• •••• 4567</div>
                                    <div style="color: #64748b; font-size: 0.875rem;">Expires 12/25</div>
                                </div>
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

                <!-- Notifications Tab -->
                <div class="tab-content" id="notifications-tab" style="display: none;">
                    <div class="card" style="padding: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                            <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Notification Settings</h2>
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
            } else {
                showNotification('Failed to update profile', 'error');
            }
        })
        .catch(error => {
            showNotification('Error updating profile', 'error');
        });
    });
    
    // Load initial data
    loadNotificationSettings();
    loadRecentBilling();
});

function loadNotificationSettings() {
    const container = document.getElementById('notification-settings');
    const settings = [
        { id: 'email_alerts', label: 'Email Alerts', description: 'Receive important alerts via email', enabled: true },
        { id: 'price_alerts', label: 'Price Alerts', description: 'Get notified when stocks hit your target prices', enabled: true },
        { id: 'news_updates', label: 'News Updates', description: 'Stay informed with relevant market news', enabled: false },
        { id: 'portfolio_updates', label: 'Portfolio Updates', description: 'Receive updates about portfolio performance', enabled: true },
        { id: 'weekly_reports', label: 'Weekly Reports', description: 'Get weekly performance summaries', enabled: true }
    ];
    
    container.innerHTML = settings.map(setting => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
            <div>
                <div style="font-weight: 500; margin-bottom: 0.25rem;">${setting.label}</div>
                <div style="color: #64748b; font-size: 0.875rem;">${setting.description}</div>
            </div>
            <label style="position: relative; display: inline-block; width: 44px; height: 24px;">
                <input type="checkbox" ${setting.enabled ? 'checked' : ''} data-setting="${setting.id}" style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: ${setting.enabled ? '#059669' : '#ccc'}; border-radius: 24px; transition: 0.4s;"></span>
                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: ${setting.enabled ? '23px' : '3px'}; bottom: 3px; background-color: white; border-radius: 50%; transition: 0.4s;"></span>
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
}

function loadRecentBilling() {
    const container = document.getElementById('recent-billing');
    const recentItems = [
        { date: '2024-02-15', description: 'Pro Plan Subscription', amount: '$49.99', status: 'Paid' },
        { date: '2024-01-15', description: 'Pro Plan Subscription', amount: '$49.99', status: 'Paid' },
        { date: '2023-12-15', description: 'Basic Plan Subscription', amount: '$24.99', status: 'Paid' }
    ];
    
    container.innerHTML = recentItems.map(item => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #f9fafb; border-radius: 6px;">
            <div>
                <div style="font-weight: 500; margin-bottom: 0.25rem;">${item.description}</div>
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