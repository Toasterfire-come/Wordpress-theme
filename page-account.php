<?php
/**
 * Template for Account Settings page - Bug Fixed Version
 * Retail Trade Scanner - Enhanced security and user experience
 */

get_header(); 

// Security check - ensure user is logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

$current_user = wp_get_current_user();
?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;" role="main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">My Account</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Manage your profile, payment, and account settings</p>
        </div>

        <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem; max-width: 1200px; margin: 0 auto;">
            
            <!-- Sidebar Navigation -->
            <aside>
                <div class="card" style="padding: 1.5rem; margin-bottom: 1.5rem; text-align: center;" id="user-profile-card">
                    <div id="user-avatar" style="width: 80px; height: 80px; background: linear-gradient(135deg, #059669, #10b981); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; font-weight: bold;">
                        <?php 
                        $first_name = get_user_meta($current_user->ID, 'first_name', true);
                        $last_name = get_user_meta($current_user->ID, 'last_name', true);
                        $initials = '';
                        if ($first_name) $initials .= strtoupper(substr($first_name, 0, 1));
                        if ($last_name) $initials .= strtoupper(substr($last_name, 0, 1));
                        if (empty($initials)) $initials = strtoupper(substr($current_user->display_name, 0, 1));
                        echo esc_html($initials ?: 'U');
                        ?>
                    </div>
                    <h3 id="user-name" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">
                        <?php echo esc_html($current_user->display_name); ?>
                    </h3>
                    <p id="user-email" style="color: #64748b; margin-bottom: 1rem;">
                        <?php echo esc_html($current_user->user_email); ?>
                    </p>
                    <div id="user-plan" style="background: #d1fae5; color: #047857; padding: 0.25rem 0.75rem; border-radius: 1rem; display: inline-block; font-size: 0.875rem; font-weight: 500;">
                        Free Plan
                    </div>
                </div>

                <nav id="account-nav" style="background: white; border-radius: 12px; padding: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" role="navigation" aria-label="Account Settings Navigation">
                    <button class="nav-btn active" data-tab="profile" style="width: 100%; text-align: left; padding: 1rem; border: none; background: #f1f5f9; color: #1e40af; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;" aria-pressed="true">
                        <span aria-hidden="true">👤</span> Profile Information
                    </button>
                    <button class="nav-btn" data-tab="security" style="width: 100%; text-align: left; padding: 1rem; border: none; background: transparent; color: #64748b; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;" aria-pressed="false">
                        <span aria-hidden="true">🔒</span> Security & Password
                    </button>
                    <button class="nav-btn" data-tab="billing" style="width: 100%; text-align: left; padding: 1rem; border: none; background: transparent; color: #64748b; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;" aria-pressed="false">
                        <span aria-hidden="true">💳</span> Billing & Payment
                    </button>
                    <button class="nav-btn" data-tab="notifications" style="width: 100%; text-align: left; padding: 1rem; border: none; background: transparent; color: #64748b; border-radius: 8px; margin-bottom: 0.25rem; cursor: pointer; font-weight: 500;" aria-pressed="false">
                        <span aria-hidden="true">📧</span> Email Notifications
                    </button>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <div id="account-content">
                
                <!-- Profile Tab -->
                <section class="tab-content active" id="profile-tab" aria-labelledby="profile-tab-heading">
                    <div class="card" style="padding: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                            <h2 id="profile-tab-heading" style="font-size: 1.5rem; font-weight: 600; margin: 0;">Profile Information</h2>
                            <button id="save-profile" class="btn btn-primary" style="margin-left: auto;" aria-describedby="profile-save-help">
                                Save Changes
                            </button>
                        </div>
                        
                        <form id="profile-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" novalidate>
                            <div>
                                <label for="profile-first-name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                    First Name <span style="color: #ef4444;" aria-label="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="first_name" 
                                    id="profile-first-name" 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                                    value="<?php echo esc_attr(get_user_meta($current_user->ID, 'first_name', true)); ?>"
                                    required
                                    aria-required="true"
                                >
                            </div>
                            <div>
                                <label for="profile-last-name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                    Last Name <span style="color: #ef4444;" aria-label="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="last_name" 
                                    id="profile-last-name" 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                                    value="<?php echo esc_attr(get_user_meta($current_user->ID, 'last_name', true)); ?>"
                                    required
                                    aria-required="true"
                                >
                            </div>
                            <div>
                                <label for="profile-email" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                    Email Address <span style="color: #ef4444;" aria-label="required">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="profile-email" 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                                    value="<?php echo esc_attr($current_user->user_email); ?>"
                                    required
                                    aria-required="true"
                                >
                            </div>
                            <div>
                                <label for="profile-phone" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Phone Number</label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    id="profile-phone" 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                                    value="<?php echo esc_attr(get_user_meta($current_user->ID, 'phone', true)); ?>"
                                >
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <label for="profile-company" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Company</label>
                                <input 
                                    type="text" 
                                    name="company" 
                                    id="profile-company" 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                                    value="<?php echo esc_attr(get_user_meta($current_user->ID, 'company', true)); ?>"
                                >
                            </div>
                        </form>
                        <div id="profile-save-help" style="font-size: 0.875rem; color: #64748b; margin-top: 1rem;">
                            Changes will be saved to your WordPress profile and synced with the trading platform.
                        </div>
                    </div>
                </section>

                <!-- Security Tab -->
                <section class="tab-content" id="security-tab" style="display: none;" aria-labelledby="security-tab-heading">
                    <div class="card" style="padding: 2rem;">
                        <h2 id="security-tab-heading" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem;">Security & Password</h2>
                        
                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Change Password</h3>
                            <form id="change-password-form" style="display: grid; gap: 1rem; max-width: 400px;" novalidate>
                                <div>
                                    <label for="current-password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                        Current Password <span style="color: #ef4444;" aria-label="required">*</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        name="current_password" 
                                        id="current-password"
                                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" 
                                        required
                                        aria-required="true"
                                        autocomplete="current-password"
                                    >
                                </div>
                                <div>
                                    <label for="new-password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                        New Password <span style="color: #ef4444;" aria-label="required">*</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        name="new_password" 
                                        id="new-password"
                                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" 
                                        required
                                        aria-required="true"
                                        autocomplete="new-password"
                                        minlength="8"
                                    >
                                    <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem;">
                                        Minimum 8 characters, include letters and numbers
                                    </div>
                                </div>
                                <div>
                                    <label for="confirm-password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                        Confirm New Password <span style="color: #ef4444;" aria-label="required">*</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        name="confirm_password" 
                                        id="confirm-password"
                                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" 
                                        required
                                        aria-required="true"
                                        autocomplete="new-password"
                                    >
                                </div>
                                <button type="submit" class="btn btn-primary" style="justify-self: start;">
                                    Update Password
                                </button>
                            </form>
                        </div>

                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Security Information</h3>
                            <div id="security-info" style="display: grid; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-weight: 500;">Account Created</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">
                                            <?php echo esc_html(date('F j, Y', strtotime($current_user->user_registered))); ?>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-weight: 500;">Account Status</div>
                                        <div style="color: #059669; font-size: 0.875rem;">
                                            <span aria-hidden="true">✓</span> Active and Secure
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-weight: 500;">User Role</div>
                                        <div style="color: #64748b; font-size: 0.875rem;">
                                            <?php echo esc_html(ucfirst(implode(', ', $current_user->roles))); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Billing Tab -->
                <section class="tab-content" id="billing-tab" style="display: none;" aria-labelledby="billing-tab-heading">
                    <div class="card" style="padding: 2rem;">
                        <h2 id="billing-tab-heading" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem;">Billing & Payment</h2>
                        
                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;">Current Plan</h3>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-outline">
                                    Upgrade Plan
                                </a>
                            </div>
                            <div id="current-plan-info" style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 6px; padding: 1rem;">
                                <div style="font-weight: 600; color: #1e40af;">Free Plan - $0/month</div>
                                <div style="color: #1d4ed8; font-size: 0.875rem;">15 stock lookups per month included</div>
                            </div>
                        </div>

                        <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;">Billing History</h3>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('billing-history'))); ?>" class="btn btn-outline">
                                    View All History
                                </a>
                            </div>
                            <div id="recent-billing" style="display: grid; gap: 0.75rem;">
                                <div style="text-align: center; padding: 2rem; color: #64748b;">
                                    <p>No billing history available on Free Plan.</p>
                                    <p style="font-size: 0.875rem; margin-top: 0.5rem;">
                                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>">Upgrade to a paid plan</a> 
                                        to see billing history.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Email Notifications Tab -->
                <section class="tab-content" id="notifications-tab" style="display: none;" aria-labelledby="notifications-tab-heading">
                    <div class="card" style="padding: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                            <h2 id="notifications-tab-heading" style="font-size: 1.5rem; font-weight: 600; margin: 0;">Email Notification Settings</h2>
                            <button id="save-notifications" class="btn btn-primary">Save Settings</button>
                        </div>
                        
                        <div id="notification-settings" style="display: grid; gap: 1rem;" role="group" aria-labelledby="notifications-tab-heading">
                            <!-- Notification settings will be populated by JavaScript -->
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize account page
    AccountPage.init();
});

// Account Page Manager
const AccountPage = {
    currentUser: <?php echo json_encode(array(
        'ID' => $current_user->ID,
        'display_name' => $current_user->display_name,
        'user_email' => $current_user->user_email,
        'first_name' => get_user_meta($current_user->ID, 'first_name', true),
        'last_name' => get_user_meta($current_user->ID, 'last_name', true),
        'phone' => get_user_meta($current_user->ID, 'phone', true),
        'company' => get_user_meta($current_user->ID, 'company', true),
        'user_registered' => $current_user->user_registered,
        'roles' => $current_user->roles,
    )); ?>,

    init: function() {
        this.setupTabNavigation();
        this.setupFormHandlers();
        this.loadNotificationSettings();
    },

    setupTabNavigation: function() {
        const navButtons = document.querySelectorAll('.nav-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        navButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.dataset.tab;
                
                // Update ARIA states
                navButtons.forEach(btn => {
                    btn.setAttribute('aria-pressed', 'false');
                    btn.classList.remove('active');
                    btn.style.background = 'transparent';
                    btn.style.color = '#64748b';
                });
                
                tabContents.forEach(tab => {
                    tab.classList.remove('active');
                    tab.style.display = 'none';
                });
                
                // Activate selected tab
                button.setAttribute('aria-pressed', 'true');
                button.classList.add('active');
                button.style.background = '#f1f5f9';
                button.style.color = '#1e40af';
                
                const activeTab = document.getElementById(tabName + '-tab');
                if (activeTab) {
                    activeTab.classList.add('active');
                    activeTab.style.display = 'block';
                    
                    // Focus management
                    const heading = activeTab.querySelector('h2');
                    if (heading) {
                        heading.focus();
                    }
                }
            });
        });
    },

    setupFormHandlers: function() {
        // Profile form handler
        const saveProfileBtn = document.getElementById('save-profile');
        const profileForm = document.getElementById('profile-form');
        
        if (saveProfileBtn && profileForm) {
            saveProfileBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.saveProfile(profileForm);
            });
        }
        
        // Password change handler
        const passwordForm = document.getElementById('change-password-form');
        if (passwordForm) {
            passwordForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.changePassword(passwordForm);
            });
        }
    },

    saveProfile: function(form) {
        const formData = new FormData(form);
        const profileData = Object.fromEntries(formData);
        
        // Basic validation
        if (!profileData.first_name || !profileData.last_name || !profileData.email) {
            this.showNotification('Please fill in all required fields', 'error');
            return;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(profileData.email)) {
            this.showNotification('Please enter a valid email address', 'error');
            return;
        }
        
        // Show loading state
        const saveBtn = document.getElementById('save-profile');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Saving...';
        saveBtn.disabled = true;
        
        // API call to update profile
        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: new FormData(Object.assign(document.createElement('form'), {
                action: 'retail_trade_scanner_update_profile',
                nonce: '<?php echo wp_create_nonce('retail_trade_scanner_nonce'); ?>',
                ...profileData
            }))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showNotification('Profile updated successfully', 'success');
                this.updateUserDisplay(profileData);
            } else {
                this.showNotification(data.data?.message || 'Failed to update profile', 'error');
            }
        })
        .catch(error => {
            console.error('Profile update error:', error);
            this.showNotification('Error updating profile', 'error');
        })
        .finally(() => {
            saveBtn.textContent = originalText;
            saveBtn.disabled = false;
        });
    },

    changePassword: function(form) {
        const formData = new FormData(form);
        const currentPassword = formData.get('current_password');
        const newPassword = formData.get('new_password');
        const confirmPassword = formData.get('confirm_password');
        
        // Validation
        if (!currentPassword || !newPassword || !confirmPassword) {
            this.showNotification('Please fill in all password fields', 'error');
            return;
        }
        
        if (newPassword !== confirmPassword) {
            this.showNotification('New passwords do not match', 'error');
            return;
        }
        
        if (newPassword.length < 8) {
            this.showNotification('Password must be at least 8 characters long', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Updating...';
        submitBtn.disabled = true;
        
        // API call to change password
        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: new FormData(Object.assign(document.createElement('form'), {
                action: 'retail_trade_scanner_change_password',
                nonce: '<?php echo wp_create_nonce('retail_trade_scanner_nonce'); ?>',
                current_password: currentPassword,
                new_password: newPassword
            }))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showNotification('Password changed successfully', 'success');
                form.reset();
            } else {
                this.showNotification(data.data?.message || 'Failed to change password', 'error');
            }
        })
        .catch(error => {
            console.error('Password change error:', error);
            this.showNotification('Error changing password', 'error');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    },

    updateUserDisplay: function(profileData) {
        // Update sidebar display
        const initials = `${profileData.first_name?.[0] || ''}${profileData.last_name?.[0] || ''}` || 'U';
        document.getElementById('user-avatar').textContent = initials;
        document.getElementById('user-name').textContent = `${profileData.first_name} ${profileData.last_name}`.trim();
        document.getElementById('user-email').textContent = profileData.email;
    },

    loadNotificationSettings: function() {
        const defaultSettings = {
            email_alerts: true,
            price_alerts: true,
            news_updates: false,
            portfolio_updates: true,
            weekly_reports: true
        };
        
        this.renderNotificationSettings(defaultSettings);
    },

    renderNotificationSettings: function(settings) {
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
                    <input 
                        type="checkbox" 
                        ${settings[setting.id] ? 'checked' : ''} 
                        data-setting="${setting.id}" 
                        style="opacity: 0; width: 0; height: 0;"
                        aria-label="Toggle ${setting.label}"
                    >
                    <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: ${settings[setting.id] ? '#059669' : '#ccc'}; border-radius: 24px; transition: 0.4s;"></span>
                    <span class="slider-knob" style="position: absolute; content: ''; height: 18px; width: 18px; left: ${settings[setting.id] ? '23px' : '3px'}; bottom: 3px; background-color: white; border-radius: 50%; transition: 0.4s;"></span>
                </label>
            </div>
        `).join('');
        
        // Add event listeners to toggles
        container.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const slider = this.parentElement.querySelector('.slider');
                const knob = this.parentElement.querySelector('.slider-knob');
                
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
        document.getElementById('save-notifications').addEventListener('click', () => {
            this.saveNotificationSettings(container);
        });
    },

    saveNotificationSettings: function(container) {
        const checkboxes = container.querySelectorAll('input[type="checkbox"]');
        const notificationData = {};
        
        checkboxes.forEach(checkbox => {
            notificationData[checkbox.dataset.setting] = checkbox.checked;
        });
        
        const saveBtn = document.getElementById('save-notifications');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Saving...';
        saveBtn.disabled = true;
        
        // Save to WordPress user meta
        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: new FormData(Object.assign(document.createElement('form'), {
                action: 'retail_trade_scanner_save_notifications',
                nonce: '<?php echo wp_create_nonce('retail_trade_scanner_nonce'); ?>',
                notifications: JSON.stringify(notificationData)
            }))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showNotification('Notification settings saved', 'success');
            } else {
                this.showNotification('Failed to save settings', 'error');
            }
        })
        .catch(error => {
            console.error('Notification save error:', error);
            this.showNotification('Error saving settings', 'error');
        })
        .finally(() => {
            saveBtn.textContent = originalText;
            saveBtn.disabled = false;
        });
    },

    showNotification: function(message, type = 'info') {
        if (window.RetailTradeScanner && window.RetailTradeScanner.notify) {
            window.RetailTradeScanner.notify(message, type);
        } else {
            // Fallback notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
                border-radius: 8px; color: white; z-index: 1000; font-weight: 500;
                background: ${type === 'success' ? '#059669' : type === 'error' ? '#dc2626' : '#2563eb'};
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    }
};
</script>

<style>
/* Mobile responsiveness for account page */
@media (max-width: 768px) {
    .container > div {
        grid-template-columns: 1fr !important;
        gap: 1rem;
    }
    
    #profile-form {
        grid-template-columns: 1fr !important;
    }
    
    .card {
        padding: 1rem !important;
    }
}

/* Focus states for better accessibility */
.nav-btn:focus {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
}

.tab-content h2:focus {
    outline: none;
}

/* Form validation styles */
.field-error {
    color: var(--red-600, #dc2626);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

input:invalid {
    border-color: var(--red-500, #ef4444);
}

input:valid {
    border-color: var(--green-500, #10b981);
}
</style>

<?php get_footer(); ?>