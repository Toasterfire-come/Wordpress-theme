<?php
/**
 * Template for Login page
 * Retail Trade Scanner Theme
 */

// Redirect if already logged in
if (is_user_logged_in()) {
    wp_redirect(get_permalink(get_page_by_path('dashboard')));
    exit;
}

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; display: flex; align-items: center; background: #f8fafc;">
    <div class="container" style="max-width: 400px; margin: 0 auto;">
        
        <div class="card" style="padding: 3rem 2rem; text-align: center;">
            <!-- Logo -->
            <div style="margin-bottom: 2rem;">
                <div style="width: 80px; height: 80px; background: #059669; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    📊
                </div>
                <h1 style="font-size: 2rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                    <?php _e('Welcome Back', 'retail-trade-scanner'); ?>
                </h1>
                <p style="color: #64748b;">
                    <?php _e('Sign in to your Retail Trade Scanner account', 'retail-trade-scanner'); ?>
                </p>
            </div>

            <!-- Login Form -->
            <form id="login-form" style="text-align: left;">
                <div style="margin-bottom: 1.5rem;">
                    <label for="username" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        <?php _e('Username or Email', 'retail-trade-scanner'); ?>
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                    >
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                        <?php _e('Password', 'retail-trade-scanner'); ?>
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                    >
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" id="remember" name="remember">
                        <span style="font-size: 0.875rem; color: #64748b;">
                            <?php _e('Remember me', 'retail-trade-scanner'); ?>
                        </span>
                    </label>
                    <a href="#" style="font-size: 0.875rem; color: #059669; text-decoration: none;">
                        <?php _e('Forgot password?', 'retail-trade-scanner'); ?>
                    </a>
                </div>

                <button 
                    type="submit" 
                    class="btn btn-primary" 
                    style="width: 100%; justify-content: center; padding: 1rem; margin-bottom: 1.5rem;"
                >
                    <?php _e('Sign In', 'retail-trade-scanner'); ?>
                </button>

                <div id="login-error" style="display: none; background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.875rem; text-align: center;">
                </div>
            </form>

            <!-- Divider -->
            <div style="position: relative; margin: 2rem 0;">
                <div style="border-top: 1px solid #e5e7eb;"></div>
                <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: white; padding: 0 1rem; font-size: 0.875rem; color: #64748b;">
                    <?php _e('or', 'retail-trade-scanner'); ?>
                </div>
            </div>

            <!-- Sign Up Link -->
            <p style="color: #64748b; font-size: 0.875rem;">
                <?php _e("Don't have an account?", 'retail-trade-scanner'); ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" style="color: #059669; text-decoration: none; font-weight: 500;">
                    <?php _e('Sign up for free', 'retail-trade-scanner'); ?>
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
    const form = document.getElementById('login-form');
    const errorDiv = document.getElementById('login-error');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const loginData = {
            username: formData.get('username'),
            password: formData.get('password'),
            remember: formData.get('remember') ? true : false
        };
        
        // Hide previous errors
        errorDiv.style.display = 'none';
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = '<?php _e('Signing In...', 'retail-trade-scanner'); ?>';
        submitBtn.disabled = true;
        
        // Call login API
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/auth/login')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            },
            body: JSON.stringify(loginData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store auth token if provided
                if (data.token) {
                    localStorage.setItem('retail_trade_scanner_token', data.token);
                }
                
                // Redirect to dashboard
                window.location.href = '<?php echo esc_url(get_permalink(get_page_by_path('dashboard'))); ?>';
            } else {
                // Show error message
                errorDiv.textContent = data.message || '<?php _e('Login failed. Please check your credentials.', 'retail-trade-scanner'); ?>';
                errorDiv.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Login error:', error);
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