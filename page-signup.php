<?php
/**
 * Template for Signup page
 * Retail Trade Scanner Theme
 */

// Redirect if already logged in
if (is_user_logged_in()) {
    wp_redirect(get_permalink(get_page_by_path('dashboard')));
    exit;
}

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc; padding: 2rem 0;">
    <div class="container" style="max-width: 500px; margin: 0 auto;">
        
        <div class="card" style="padding: 3rem 2rem; text-align: center;">
            <!-- Logo -->
            <div style="margin-bottom: 2rem;">
                <div style="width: 80px; height: 80px; background: #059669; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    📊
                </div>
                <h1 style="font-size: 2rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                    <?php _e('Create Your Account', 'retail-trade-scanner'); ?>
                </h1>
                <p style="color: #64748b;">
                    <?php _e('Join thousands of traders using our platform', 'retail-trade-scanner'); ?>
                </p>
            </div>

            <!-- Signup Form -->
            <form id="signup-form" style="text-align: left;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="first_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                            <?php _e('First Name', 'retail-trade-scanner'); ?> *
                        </label>
                        <input 
                            type="text" 
                            id="first_name" 
                            name="first_name" 
                            required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                        >
                    </div>
                    <div>
                        <label for="last_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                            <?php _e('Last Name', 'retail-trade-scanner'); ?> *
                        </label>
                        <input 
                            type="text" 
                            id="last_name" 
                            name="last_name" 
                            required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                        >
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        <?php _e('Email Address', 'retail-trade-scanner'); ?> *
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                    >
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        <?php _e('Password', 'retail-trade-scanner'); ?> *
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        minlength="8"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                    >
                    <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">
                        <?php _e('Minimum 8 characters', 'retail-trade-scanner'); ?>
                    </p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="confirm_password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        <?php _e('Confirm Password', 'retail-trade-scanner'); ?> *
                    </label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        required
                        minlength="8"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                    >
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="plan" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        <?php _e('Choose Your Plan', 'retail-trade-scanner'); ?>
                    </label>
                    <select 
                        id="plan" 
                        name="plan" 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background: white;"
                    >
                        <option value="free"><?php _e('Free - $0/month', 'retail-trade-scanner'); ?></option>
                        <option value="basic"><?php _e('Basic - $24.99/month', 'retail-trade-scanner'); ?></option>
                        <option value="pro"><?php _e('Pro - $49.99/month', 'retail-trade-scanner'); ?></option>
                    </select>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: start; gap: 0.75rem; cursor: pointer; line-height: 1.4;">
                        <input type="checkbox" name="terms" required style="margin-top: 0.125rem;">
                        <span style="font-size: 0.875rem; color: #64748b;">
                            <?php _e('I agree to the', 'retail-trade-scanner'); ?>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" style="color: #059669; text-decoration: none;">
                                <?php _e('Terms of Service', 'retail-trade-scanner'); ?>
                            </a>
                            <?php _e('and', 'retail-trade-scanner'); ?>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy'))); ?>" style="color: #059669; text-decoration: none;">
                                <?php _e('Privacy Policy', 'retail-trade-scanner'); ?>
                            </a>
                        </span>
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="btn btn-primary" 
                    style="width: 100%; justify-content: center; padding: 1rem; margin-bottom: 1.5rem;"
                >
                    <?php _e('Create Account', 'retail-trade-scanner'); ?>
                </button>

                <div id="signup-error" style="display: none; background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.875rem; text-align: center;">
                </div>
            </form>

            <!-- Divider -->
            <div style="position: relative; margin: 2rem 0;">
                <div style="border-top: 1px solid #e5e7eb;"></div>
                <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: white; padding: 0 1rem; font-size: 0.875rem; color: #64748b;">
                    <?php _e('or', 'retail-trade-scanner'); ?>
                </div>
            </div>

            <!-- Login Link -->
            <p style="color: #64748b; font-size: 0.875rem;">
                <?php _e('Already have an account?', 'retail-trade-scanner'); ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>" style="color: #059669; text-decoration: none; font-weight: 500;">
                    <?php _e('Sign in here', 'retail-trade-scanner'); ?>
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; font-size: 0.875rem;">
                ← <?php _e('Back to homepage', 'retail-trade-scanner'); ?>
            </a>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signup-form');
    const errorDiv = document.getElementById('signup-error');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        // Validate password confirmation
        const password = formData.get('password');
        const confirmPassword = formData.get('confirm_password');
        
        if (password !== confirmPassword) {
            errorDiv.textContent = '<?php _e('Passwords do not match', 'retail-trade-scanner'); ?>';
            errorDiv.style.display = 'block';
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
        errorDiv.style.display = 'none';
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = '<?php _e('Creating Account...', 'retail-trade-scanner'); ?>';
        submitBtn.disabled = true;
        
        // Call signup API
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/auth/register')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            },
            body: JSON.stringify(signupData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store auth token if provided
                if (data.token) {
                    localStorage.setItem('retail_trade_scanner_token', data.token);
                }
                
                // Redirect to dashboard or welcome page
                window.location.href = '<?php echo esc_url(get_permalink(get_page_by_path('dashboard'))); ?>?welcome=1';
            } else {
                // Show error message
                errorDiv.textContent = data.message || '<?php _e('Account creation failed. Please try again.', 'retail-trade-scanner'); ?>';
                errorDiv.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Signup error:', error);
            errorDiv.textContent = '<?php _e('An error occurred. Please try again.', 'retail-trade-scanner'); ?>';
            errorDiv.style.display = 'block';
        })
        .finally(() => {
            // Reset button state
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });
});
</script>

<?php get_footer(); ?>