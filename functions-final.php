<?php
/**
 * Retail Trade Scanner Theme Functions - Final Version with Tier-Based Rate Limiting
 * Complete integration with Django backend and subscription enforcement
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include the tier-based rate limiting system
require_once get_template_directory() . '/functions-tier-rate-limiting.php';

/**
 * Theme setup with enhanced features
 */
function retail_trade_scanner_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'retail-trade-scanner'),
        'footer' => __('Footer Menu', 'retail-trade-scanner'),
    ));
    
    // Set content width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'retail_trade_scanner_setup');

/**
 * Enhanced script and style enqueuing with tier-based data
 */
function retail_trade_scanner_scripts() {
    // Enqueue theme stylesheet with dark mode support
    wp_enqueue_style('retail-trade-scanner-style', get_stylesheet_uri(), array(), '2.3.0');
    
    // Enqueue optimized CSS
    wp_enqueue_style('retail-trade-scanner-optimized', get_template_directory_uri() . '/style-optimized.css', array(), '2.3.0');
    
    // Enqueue dark mode CSS
    wp_enqueue_style('retail-trade-scanner-dark-mode', get_template_directory_uri() . '/assets/css/dark-mode.css', array('retail-trade-scanner-optimized'), '2.3.0');
    
    // Enqueue Google Fonts
    wp_enqueue_style('retail-trade-scanner-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Ensure assets directory exists
    retail_trade_scanner_ensure_assets();
    
    // Enqueue updated JavaScript
    wp_enqueue_script('retail-trade-scanner-script', get_template_directory_uri() . '/assets/js/main-updated.js', array('jquery'), '2.3.0', true);
    
    // Get Django backend URL
    $backend_url = get_option('stock_scanner_api_url', 
                   get_option('retail_trade_scanner_api_endpoint',
                   defined('RETAIL_TRADE_SCANNER_API_URL') ? RETAIL_TRADE_SCANNER_API_URL : 'https://api.retailtradescanner.com'));
    
    // Get user tier information for frontend
    $user_tier = 'free';
    $user_limits = array();
    
    if (is_user_logged_in()) {
        $rate_limiter = RetailTradeScannerTierRateLimit::getInstance();
        $user_tier = $rate_limiter->get_user_tier(get_current_user_id());
        $usage_stats = $rate_limiter->get_user_usage_stats(get_current_user_id());
        $user_limits = $usage_stats['usage'];
    }
    
    // Updated API endpoints for Django backend with tier information
    wp_localize_script('retail-trade-scanner-script', 'retail_trade_scanner_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'rest_url' => rest_url('retail-trade-scanner/v1/'),
        'nonce' => wp_create_nonce('retail_trade_scanner_nonce'),
        'backend_url' => esc_url(rtrim($backend_url, '/')),
        'api_endpoints' => array(
            'stocks' => rtrim($backend_url, '/') . '/api/stocks/',
            'stocks_search' => rtrim($backend_url, '/') . '/api/stocks/search/',
            'stock_detail' => rtrim($backend_url, '/') . '/api/stocks/',
            'market_stats' => rtrim($backend_url, '/') . '/api/market/stats/',
            'filter_stocks' => rtrim($backend_url, '/') . '/api/market/filter/',
            'trending' => rtrim($backend_url, '/') . '/api/trending/',
            'nasdaq_stocks' => rtrim($backend_url, '/') . '/api/stocks/nasdaq/',
            'realtime' => rtrim($backend_url, '/') . '/api/realtime/',
            'alerts_create' => rtrim($backend_url, '/') . '/api/alerts/create/',
            'wordpress_stocks' => rtrim($backend_url, '/') . '/api/wordpress/',
            'wordpress_news' => rtrim($backend_url, '/') . '/api/wordpress/news/',
            'subscription_status' => rtrim($backend_url, '/') . '/api/users/subscription-status/',
        ),
        'plugin_active' => class_exists('StockScannerIntegration'),
        'is_user_logged_in' => is_user_logged_in(),
        'current_user_id' => get_current_user_id(),
        'dark_mode' => get_user_meta(get_current_user_id(), 'dark_mode_enabled', true) ?: false,
        'user_tier' => $user_tier,
        'tier_limits' => $user_limits,
        'upgrade_url' => get_permalink(get_page_by_path('premium-plans')),
        'usage_dashboard_url' => get_permalink(get_page_by_path('usage-dashboard')),
    ));
}
add_action('wp_enqueue_scripts', 'retail_trade_scanner_scripts');

/**
 * Enhanced signup handler with tier assignment
 */
function retail_trade_scanner_signup_handler() {
    check_ajax_referer('retail_trade_scanner_nonce', 'nonce');
    
    // Rate limiting for signup attempts
    $rate_limiter = RetailTradeScannerTierRateLimit::getInstance();
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $rate_check = $rate_limiter->check_tier_rate_limit(0, 'signup_attempts', 5); // 5 attempts per minute per IP
    
    if (!$rate_check['allowed']) {
        wp_send_json_error(array(
            'message' => __('Too many signup attempts. Please wait before trying again.', 'retail-trade-scanner'),
            'rate_limit' => true
        ));
    }
    
    // Validate and sanitize input
    $first_name = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name = sanitize_text_field($_POST['last_name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $plan = sanitize_text_field($_POST['plan'] ?? 'free');
    $terms_accepted = isset($_POST['terms_accepted']) && $_POST['terms_accepted'];
    
    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        wp_send_json_error(array('message' => __('All fields are required.', 'retail-trade-scanner')));
    }
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Invalid email address.', 'retail-trade-scanner')));
    }
    
    if (strlen($password) < 8) {
        wp_send_json_error(array('message' => __('Password must be at least 8 characters long.', 'retail-trade-scanner')));
    }
    
    if (!$terms_accepted) {
        wp_send_json_error(array('message' => __('You must accept the terms of service.', 'retail-trade-scanner')));
    }
    
    // Check if user already exists
    if (email_exists($email)) {
        wp_send_json_error(array('message' => __('An account with this email already exists.', 'retail-trade-scanner')));
    }
    
    // Create WordPress user
    $user_id = wp_create_user($email, $password, $email);
    
    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    }
    
    // Update user profile
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $first_name . ' ' . $last_name
    ));
    
    // Set subscription tier
    update_user_meta($user_id, 'subscription_tier', $plan);
    update_user_meta($user_id, 'subscription_start_date', current_time('mysql'));
    update_user_meta($user_id, 'terms_accepted', true);
    update_user_meta($user_id, 'terms_accepted_date', current_time('mysql'));
    
    // Create account in Django backend
    $backend_response = retail_trade_scanner_create_backend_account($user_id, $email, $first_name, $last_name, $plan);
    
    if (!$backend_response['success']) {
        // Log error but don't fail the signup
        error_log('Failed to create backend account for user ' . $user_id . ': ' . $backend_response['message']);
    }
    
    // Auto-login the user
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    
    wp_send_json_success(array(
        'message' => __('Account created successfully!', 'retail-trade-scanner'),
        'user_id' => $user_id,
        'tier' => $plan,
        'redirect_url' => get_permalink(get_page_by_path('dashboard'))
    ));
}
add_action('wp_ajax_nopriv_retail_trade_scanner_signup', 'retail_trade_scanner_signup_handler');

/**
 * Create account in Django backend
 */
function retail_trade_scanner_create_backend_account($user_id, $email, $first_name, $last_name, $plan) {
    $backend_url = get_option('retail_trade_scanner_api_endpoint', 'https://api.retailtradescanner.com');
    
    $response = wp_remote_post(
        rtrim($backend_url, '/') . '/api/users/wordpress-signup/',
        array(
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                'wordpress_user_id' => $user_id,
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'subscription_tier' => $plan,
                'source' => 'wordpress_theme'
            )),
            'timeout' => 15
        )
    );
    
    if (is_wp_error($response)) {
        return array(
            'success' => false,
            'message' => $response->get_error_message()
        );
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if ($data && isset($data['success']) && $data['success']) {
        // Store backend user ID if provided
        if (isset($data['backend_user_id'])) {
            update_user_meta($user_id, 'backend_user_id', $data['backend_user_id']);
        }
        
        // Store authentication token if provided
        if (isset($data['auth_token'])) {
            update_user_meta($user_id, 'backend_auth_token', $data['auth_token']);
            update_user_meta($user_id, 'token_expires', time() + (24 * 60 * 60)); // 24 hours
        }
        
        return array('success' => true);
    }
    
    return array(
        'success' => false,
        'message' => $data['message'] ?? 'Unknown backend error'
    );
}

/**
 * Enhanced user dashboard with tier information
 */
function retail_trade_scanner_add_user_dashboard() {
    if (is_user_logged_in()) {
        add_action('wp_footer', 'retail_trade_scanner_render_tier_widget');
    }
}
add_action('init', 'retail_trade_scanner_add_user_dashboard');

/**
 * Render tier information widget
 */
function retail_trade_scanner_render_tier_widget() {
    $user_id = get_current_user_id();
    $rate_limiter = RetailTradeScannerTierRateLimit::getInstance();
    $tier = $rate_limiter->get_user_tier($user_id);
    
    $tier_colors = array(
        'free' => '#64748b',
        'bronze' => '#d97706',
        'silver' => '#6b7280',
        'gold' => '#f59e0b',
        'platinum' => '#8b5cf6'
    );
    
    ?>
    <div id="tier-status-widget" style="
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 1000;
        background: var(--card-bg, white);
        border: 1px solid var(--card-border, #e5e7eb);
        border-radius: 8px;
        padding: 1rem;
        box-shadow: var(--shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
        min-width: 200px;
        font-size: 0.875rem;
        display: none;
    ">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
            <div style="
                width: 24px;
                height: 24px;
                background: <?php echo $tier_colors[$tier] ?? '#64748b'; ?>;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 0.75rem;
            ">
                <?php echo strtoupper(substr($tier, 0, 1)); ?>
            </div>
            <div>
                <div style="font-weight: 600; color: var(--text-primary, #0f172a);">
                    <?php echo ucfirst($tier); ?> Plan
                </div>
                <div style="color: var(--text-secondary, #64748b); font-size: 0.75rem;">
                    Active subscription
                </div>
            </div>
        </div>
        
        <div style="margin-bottom: 0.75rem;">
            <div id="usage-summary" style="font-size: 0.75rem; color: var(--text-secondary, #64748b);">
                Loading usage...
            </div>
        </div>
        
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('usage-dashboard'))); ?>" 
               style="font-size: 0.75rem; color: var(--accent-color, #059669); text-decoration: none;">
                View Details
            </a>
            <?php if ($tier === 'free'): ?>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" 
               style="font-size: 0.75rem; color: var(--accent-color, #059669); text-decoration: none; margin-left: auto;">
                Upgrade
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    // Show tier widget on pages with API usage
    document.addEventListener('DOMContentLoaded', function() {
        const apiPages = ['/dashboard', '/scanner', '/portfolio', '/news'];
        const currentPath = window.location.pathname;
        
        if (apiPages.some(page => currentPath.includes(page))) {
            document.getElementById('tier-status-widget').style.display = 'block';
            
            // Load usage summary
            setTimeout(loadUsageSummary, 1000);
        }
    });
    
    function loadUsageSummary() {
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
                const usage = data.data.usage;
                const apiUsage = usage.api_requests || { used: 0, limit: 0 };
                
                document.getElementById('usage-summary').innerHTML = 
                    `API: ${apiUsage.used}/${apiUsage.limit} requests`;
            }
        })
        .catch(error => {
            // Silent error handling
        });
    }
    </script>
    <?php
}

/**
 * Add admin notices for rate limiting violations
 */
function retail_trade_scanner_admin_notices() {
    if (!is_user_logged_in() || !is_admin()) {
        return;
    }
    
    $user_id = get_current_user_id();
    $violations = get_user_meta($user_id, 'rate_limit_violations', true);
    
    if ($violations && $violations > 5) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong><?php _e('Rate Limit Warning:', 'retail-trade-scanner'); ?></strong>
                <?php _e('You have exceeded rate limits multiple times. Consider upgrading your plan for higher limits.', 'retail-trade-scanner'); ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="button button-primary" style="margin-left: 10px;">
                    <?php _e('Upgrade Plan', 'retail-trade-scanner'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'retail_trade_scanner_admin_notices');

/**
 * Create assets directory and updated files
 */
function retail_trade_scanner_ensure_assets() {
    $theme_dir = get_template_directory();
    $assets_dir = $theme_dir . '/assets/js/';
    $css_dir = $theme_dir . '/assets/css/';
    
    // Create directories if they don't exist
    if (!is_dir($assets_dir)) {
        wp_mkdir_p($assets_dir);
    }
    if (!is_dir($css_dir)) {
        wp_mkdir_p($css_dir);
    }
}

/**
 * Dark Mode Functions (from previous implementation)
 */
function retail_trade_scanner_toggle_dark_mode() {
    check_ajax_referer('retail_trade_scanner_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }
    
    $user_id = get_current_user_id();
    $current_mode = get_user_meta($user_id, 'dark_mode_enabled', true);
    $new_mode = !$current_mode;
    
    update_user_meta($user_id, 'dark_mode_enabled', $new_mode);
    
    wp_send_json_success(array(
        'dark_mode' => $new_mode,
        'message' => $new_mode ? 'Dark mode enabled' : 'Light mode enabled'
    ));
}
add_action('wp_ajax_retail_trade_scanner_toggle_dark_mode', 'retail_trade_scanner_toggle_dark_mode');

/**
 * Body classes with tier information
 */
function retail_trade_scanner_body_classes($classes) {
    if (is_user_logged_in()) {
        $classes[] = 'user-logged-in';
        
        // Add tier class
        $rate_limiter = RetailTradeScannerTierRateLimit::getInstance();
        $tier = $rate_limiter->get_user_tier(get_current_user_id());
        $classes[] = 'tier-' . $tier;
        
        // Add dark mode class
        $user_id = get_current_user_id();
        if (get_user_meta($user_id, 'dark_mode_enabled', true)) {
            $classes[] = 'dark-mode';
        }
    } else {
        $classes[] = 'user-logged-out tier-free';
    }
    
    // Add plugin status class
    if (class_exists('StockScannerIntegration')) {
        $classes[] = 'stock-scanner-plugin-active';
    } else {
        $classes[] = 'stock-scanner-plugin-inactive';
    }
    
    return $classes;
}
add_filter('body_class', 'retail_trade_scanner_body_classes');

/**
 * Theme customization options
 */
function retail_trade_scanner_customize_register($wp_customize) {
    // Add section
    $wp_customize->add_section('retail_trade_scanner_options', array(
        'title' => __('Retail Trade Scanner Options', 'retail-trade-scanner'),
        'priority' => 30,
    ));
    
    // Add Django API endpoint setting
    $wp_customize->add_setting('retail_trade_scanner_api_endpoint', array(
        'default' => 'https://api.retailtradescanner.com',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('retail_trade_scanner_api_endpoint', array(
        'label' => __('Django Backend API URL', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_options',
        'type' => 'url',
        'description' => __('URL of your Django stock scanner backend API', 'retail-trade-scanner'),
    ));
}
add_action('customize_register', 'retail_trade_scanner_customize_register');

/**
 * Initialize the theme
 */
function retail_trade_scanner_init() {
    // Load text domain
    load_theme_textdomain('retail-trade-scanner', get_template_directory() . '/languages');
    
    // Flush rewrite rules if needed
    if (get_option('retail_trade_scanner_flush_rewrite_rules')) {
        flush_rewrite_rules();
        delete_option('retail_trade_scanner_flush_rewrite_rules');
    }
}
add_action('after_setup_theme', 'retail_trade_scanner_init');