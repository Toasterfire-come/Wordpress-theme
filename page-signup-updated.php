<?php
/**
 * Template for Signup page - Updated with Rate Limiting & Django Integration
 * Retail Trade Scanner Theme
 */

// Redirect if already logged in
if (is_user_logged_in()) {
    wp_redirect(get_permalink(get_page_by_path('dashboard')));
    exit;
}

// Rate limiting for page access
$rate_limiter = RetailTradeScannerRateLimit::getInstance();
$user_ip = $_SERVER['REMOTE_ADDR'];
if (!$rate_limiter->check_rate_limit($user_ip, 'signup_page_access', 20)) {
    wp_die('Too many signup attempts. Please wait before trying again.', 'Rate Limited', array('response' => 429));
}

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: var(--background-primary, #f8fafc); padding: 2rem 0;" role="main">
    <div class="container" style="max-width: 500px; margin: 0 auto;">
        
        <div class="card" style="padding: 3rem 2rem; text-align: center;">
            <!-- Logo -->
            <div style="margin-bottom: 2rem;">
                <div style="width: 80px; height: 80px; background: var(--accent-color, #059669); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    📊
                </div>
                <h1 style="font-size: 2rem; font-weight: bold; color: var(--text-primary, #0f172a); margin-bottom: 0.5rem;">
                    <?php _e('Create Your Account', 'retail-trade-scanner'); ?>
                </h1>
                <p style="color: var(--text-secondary, #64748b);">
                    <?php _e('Join thousands of traders using our platform', 'retail-trade-scanner'); ?>
                </p>
            </div>

            <!-- Signup Form -->
            <form id="signup-form" style="text-align: left;" data-rate-limit="true">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="first_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-secondary, #374151);">
                            <?php _e('First Name', 'retail-trade-scanner'); ?> *
                        </label>
                        <input 
                            type="text" 
                            id="first_name" 
                            name="first_name" 
                            required
                            autocomplete="given-name"
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border, #d1d5db); border-radius: 6px; font-size: 1rem; background: var(--input-bg, white); color: var(--text-primary, #0f172a);"
                        >
                    </div>
                    <div>
                        <label for="last_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-secondary, #374151);">
                            <?php _e('Last Name', 'retail-trade-scanner'); ?> *
                        </label>
                        <input 
                            type="text" 
                            id="last_name" 
                            name="last_name" 
                            required
                            autocomplete="family-name"
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border, #d1d5db); border-radius: 6px; font-size: 1rem; background: var(--input-bg, white); color: var(--text-primary, #0f172a);"
                        >
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-secondary, #374151);">
                        <?php _e('Email Address', 'retail-trade-scanner'); ?> *
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        autocomplete="email"
                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border, #d1d5db); border-radius: 6px; font-size: 1rem; background: var(--input-bg, white); color: var(--text-primary, #0f172a);"
                    >
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-secondary, #374151);">
                        <?php _e('Password', 'retail-trade-scanner'); ?> *
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        minlength="8"
                        autocomplete="new-password"
                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border, #d1d5db); border-radius: 6px; font-size: 1rem; background: var(--input-bg, white); color: var(--text-primary, #0f172a);"
                    >
                    <div style="margin-top: 0.5rem;">
                        <div id="password-strength" style="height: 4px; background: var(--border-primary, #e5e7eb); border-radius: 2px;">
                            <div id="password-strength-bar" style="height: 100%; width: 0%; background: var(--danger-color, #dc2626); border-radius: 2px; transition: all 0.3s ease;"></div>
                        </div>
                        <p id="password-help" style="font-size: 0.75rem; color: var(--text-muted, #64748b); margin-top: 0.25rem;">
                            <?php _e('Minimum 8 characters, include uppercase, lowercase, number', 'retail-trade-scanner'); ?>
                        </p>
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="confirm_password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-secondary, #374151);">
                        <?php _e('Confirm Password', 'retail-trade-scanner'); ?> *
                    </label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        required
                        minlength="8"
                        autocomplete="new-password"
                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border, #d1d5db); border-radius: 6px; font-size: 1rem; background: var(--input-bg, white); color: var(--text-primary, #0f172a);"
                    >
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="plan" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-secondary, #374151);">
                        <?php _e('Choose Your Plan', 'retail-trade-scanner'); ?>
                    </label>
                    <select 
                        id="plan" 
                        name="plan" 
                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--input-border, #d1d5db); border-radius: 6px; font-size: 1rem; background: var(--input-bg, white); color: var(--text-primary, #0f172a);"
                    >
                        <option value="free"><?php _e('Free - $0/month', 'retail-trade-scanner'); ?></option>
                        <option value="bronze"><?php _e('Bronze - $14.99/month', 'retail-trade-scanner'); ?></option>
                        <option value="silver"><?php _e('Silver - $29.99/month', 'retail-trade-scanner'); ?></option>
                        <option value="gold"><?php _e('Gold - $59.99/month', 'retail-trade-scanner'); ?></option>
                    </select>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: start; gap: 0.75rem; cursor: pointer; line-height: 1.4;">
                        <input type="checkbox" name="terms" required style="margin-top: 0.125rem;">
                        <span style="font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                            <?php _e('I agree to the', 'retail-trade-scanner'); ?>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" style="color: var(--accent-color, #059669); text-decoration: none;">
                                <?php _e('Terms of Service', 'retail-trade-scanner'); ?>
                            </a>
                            <?php _e('and', 'retail-trade-scanner'); ?>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy'))); ?>" style="color: var(--accent-color, #059669); text-decoration: none;">
                                <?php _e('Privacy Policy', 'retail-trade-scanner'); ?>
                            </a>
                        </span>
                    </label>
                </div>

                <!-- Rate Limiting Info -->
                <div id="rate-limit-info" style="display: none; background: var(--background-tertiary, #f1f5f9); padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                    <strong>Security Notice:</strong> Account creation is rate-limited to prevent abuse. Please wait if you encounter delays.
                </div>

                <button 
                    type="submit" 
                    class="btn btn-primary" 
                    style="width: 100%; justify-content: center; padding: 1rem; margin-bottom: 1.5rem;"
                    id="signup-submit-btn"
                >
                    <span class="btn-text"><?php _e('Create Account', 'retail-trade-scanner'); ?></span>
                    <span class="btn-loading" style="display: none;">
                        <span class="loading-spinner" style="width: 20px; height: 20px; margin-right: 0.5rem;"></span>
                        <?php _e('Creating Account...', 'retail-trade-scanner'); ?>
                    </span>
                </button>

                <div id="signup-error" style="display: none; background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.875rem; text-align: center;">
                </div>
            </form>

            <!-- Divider -->
            <div style="position: relative; margin: 2rem 0;">
                <div style="border-top: 1px solid var(--border-primary, #e5e7eb);"></div>
                <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: var(--card-bg, white); padding: 0 1rem; font-size: 0.875rem; color: var(--text-secondary, #64748b);">
                    <?php _e('or', 'retail-trade-scanner'); ?>
                </div>
            </div>

            <!-- Login Link -->
            <p style="color: var(--text-secondary, #64748b); font-size: 0.875rem;">
                <?php _e('Already have an account?', 'retail-trade-scanner'); ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>" style="color: var(--accent-color, #059669); text-decoration: none; font-weight: 500;">
                    <?php _e('Sign in here', 'retail-trade-scanner'); ?>
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: var(--text-secondary, #64748b); text-decoration: none; font-size: 0.875rem;">
                ← <?php _e('Back to homepage', 'retail-trade-scanner'); ?>
            </a>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signup-form');
    const errorDiv = document.getElementById('signup-error');
    const submitBtn = document.getElementById('signup-submit-btn');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    let attempts = 0;
    const maxAttempts = 3;
    
    // Password strength checker
    passwordInput.addEventListener('input', checkPasswordStrength);
    
    function checkPasswordStrength() {
        const password = passwordInput.value;
        const strengthBar = document.getElementById('password-strength-bar');
        const helpText = document.getElementById('password-help');
        
        let strength = 0;
        let feedback = [];
        
        if (password.length >= 8) strength += 25;
        else feedback.push('at least 8 characters');
        
        if (/[a-z]/.test(password)) strength += 25;
        else feedback.push('lowercase letter');
        
        if (/[A-Z]/.test(password)) strength += 25;
        else feedback.push('uppercase letter');
        
        if (/[0-9]/.test(password)) strength += 25;
        else feedback.push('number');
        
        strengthBar.style.width = strength + '%';
        
        if (strength < 25) {
            strengthBar.style.background = 'var(--danger-color, #dc2626)';
            helpText.textContent = 'Weak - Need: ' + feedback.join(', ');
            helpText.style.color = 'var(--danger-color, #dc2626)';
        } else if (strength < 50) {
            strengthBar.style.background = 'var(--warning-color, #d97706)';
            helpText.textContent = 'Fair - Need: ' + feedback.join(', ');
            helpText.style.color = 'var(--warning-color, #d97706)';
        } else if (strength < 75) {
            strengthBar.style.background = 'var(--info-color, #2563eb)';
            helpText.textContent = 'Good - Need: ' + feedback.join(', ');
            helpText.style.color = 'var(--info-color, #2563eb)';
        } else {
            strengthBar.style.background = 'var(--success-color, #059669)';
            helpText.textContent = 'Strong password!';
            helpText.style.color = 'var(--success-color, #059669)';
        }
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Rate limiting check
        if (attempts >= maxAttempts) {
            showError('Too many signup attempts. Please wait 5 minutes before trying again.');
            return;
        }
        
        const formData = new FormData(form);
        
        // Validate password confirmation
        const password = formData.get('password');
        const confirmPassword = formData.get('confirm_password');
        
        if (password !== confirmPassword) {
            showError('<?php _e('Passwords do not match', 'retail-trade-scanner'); ?>');
            return;
        }
        
        // Validate password strength
        if (password.length < 8 || !/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password)) {
            showError('<?php _e('Password does not meet requirements', 'retail-trade-scanner'); ?>');
            return;
        }
        
        const signupData = {
            first_name: formData.get('first_name'),
            last_name: formData.get('last_name'),
            email: formData.get('email'),
            password: password,
            plan: formData.get('plan'),
            terms_accepted: formData.get('terms') ? true : false
        };
        
        // Hide previous errors
        hideError();
        setLoading(true);
        attempts++;
        
        // Call WordPress registration (which can integrate with Django backend)
        fetch(window.retail_trade_scanner_data?.ajax_url || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'retail_trade_scanner_signup',
                nonce: window.retail_trade_scanner_data?.nonce || '',
                ...signupData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showSuccess('<?php _e('Account created successfully! Redirecting...', 'retail-trade-scanner'); ?>');
                
                // Redirect after delay
                setTimeout(() => {
                    window.location.href = '<?php echo esc_url(get_permalink(get_page_by_path('dashboard'))); ?>?welcome=1';
                }, 2000);
            } else {
                showError(data.data?.message || '<?php _e('Account creation failed. Please try again.', 'retail-trade-scanner'); ?>');
            }
        })
        .catch(error => {
            showError('<?php _e('An error occurred. Please try again.', 'retail-trade-scanner'); ?>');
        })
        .finally(() => {
            setLoading(false);
        });
    });
    
    function showError(message) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        errorDiv.style.background = '#fee2e2';
        errorDiv.style.color = '#dc2626';
    }
    
    function showSuccess(message) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        errorDiv.style.background = '#d1fae5';
        errorDiv.style.color = '#059669';
    }
    
    function hideError() {
        errorDiv.style.display = 'none';
    }
    
    function setLoading(loading) {
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        if (loading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'flex';
            submitBtn.disabled = true;
        } else {
            btnText.style.display = 'block';
            btnLoading.style.display = 'none';
            submitBtn.disabled = false;
        }
    }
    
    // Show rate limiting info if user has made attempts
    if (attempts > 0) {
        document.getElementById('rate-limit-info').style.display = 'block';
    }
});
</script>

<?php get_footer(); ?>