<?php
/**
 * Retail Trade Scanner Theme Functions - Bug-Fixed & Integration-Ready Version
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
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
 * Check if stock scanner plugin is active
 */
function retail_trade_scanner_plugin_check() {
    // Check for plugin class or function
    if (!class_exists('StockScannerIntegration') && !function_exists('create_stock_scanner_pages')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible">
                <p><strong>Retail Trade Scanner Theme:</strong> The Stock Scanner Integration plugin is required for full functionality. Please install and activate the plugin.</p>
            </div>';
        });
    }
}
add_action('admin_init', 'retail_trade_scanner_plugin_check');

/**
 * Enqueue scripts and styles - Bug Fixed Version
 */
function retail_trade_scanner_scripts() {
    // Enqueue theme stylesheet with proper versioning
    wp_enqueue_style('retail-trade-scanner-style', get_stylesheet_uri(), array(), '2.1.1');
    
    // Enqueue Google Fonts for better typography
    wp_enqueue_style('retail-trade-scanner-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Check if plugin is active before enqueueing PayPal SDK
    $paypal_client_id = '';
    if (get_option('stock_scanner_api_url') || get_option('retail_trade_scanner_paypal_client_id')) {
        // Get PayPal Client ID from plugin or theme options
        $paypal_client_id = get_option('paypal_client_id', get_option('retail_trade_scanner_paypal_client_id', ''));
        
        if ($paypal_client_id && !is_admin()) {
            wp_enqueue_script('paypal-sdk', 'https://www.paypal.com/sdk/js?client-id=' . esc_attr($paypal_client_id), array(), '2.1.1', true);
        }
    }
    
    // Ensure assets directory exists and create main.js if needed
    retail_trade_scanner_ensure_assets();
    
    // Enqueue custom JavaScript with proper dependencies
    wp_enqueue_script('retail-trade-scanner-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '2.1.1', true);
    
    // Get backend URL from plugin first, then theme options
    $backend_url = get_option('stock_scanner_api_url', 
                   get_option('retail_trade_scanner_api_endpoint',
                   defined('RETAIL_TRADE_SCANNER_API_URL') ? RETAIL_TRADE_SCANNER_API_URL : 'https://api.retailtradescanner.com/api/'));
    
    // Localize script for AJAX and REST API - Compatible with Plugin
    wp_localize_script('retail-trade-scanner-script', 'retail_trade_scanner_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'rest_url' => rest_url('retail-trade-scanner/v1/'),
        'nonce' => wp_create_nonce('retail_trade_scanner_nonce'),
        'backend_url' => esc_url(rtrim($backend_url, '/')),
        'paypal_client_id' => esc_attr($paypal_client_id),
        'api_endpoints' => array(
            'stocks' => rest_url('retail-trade-scanner/v1/proxy/stocks/'),
            'market_data' => rest_url('retail-trade-scanner/v1/proxy/market-data/'),
            'portfolio' => rest_url('retail-trade-scanner/v1/proxy/portfolio/'),
            'watchlist' => rest_url('retail-trade-scanner/v1/proxy/watchlist/'),
            'news' => rest_url('retail-trade-scanner/v1/proxy/news/'),
            'user' => rest_url('retail-trade-scanner/v1/proxy/user/'),
            'billing' => rest_url('retail-trade-scanner/v1/proxy/billing/'),
            'paypal' => rest_url('retail-trade-scanner/v1/paypal/'),
        ),
        'plugin_active' => class_exists('StockScannerIntegration'),
        'is_user_logged_in' => is_user_logged_in(),
        'current_user_id' => get_current_user_id(),
    ));

    // Add stock scanner AJAX if plugin is active
    if (class_exists('StockScannerIntegration')) {
        wp_localize_script('retail-trade-scanner-script', 'stock_scanner_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('stock_scanner_nonce')
        ));
    }
    
    // Add conditional scripts for specific pages
    if (is_page_template('page-premium-plans.php')) {
        wp_enqueue_script('retail-trade-scanner-paypal', get_template_directory_uri() . '/assets/js/paypal-integration.js', array('retail-trade-scanner-script'), '2.1.1', true);
    }
}
add_action('wp_enqueue_scripts', 'retail_trade_scanner_scripts');

/**
 * Create required pages on theme activation - Plugin Compatible
 */
function retail_trade_scanner_create_pages() {
    $pages = array(
        'premium-plans' => array(
            'title' => 'Premium Plans',
            'content' => '[stock_scanner symbol="AAPL" show_chart="true" show_details="true"]

<div class="pricing-section">
<h2>Choose Your Trading Plan</h2>
<p>From casual lookup users to professional trading firms. Find the plan that fits your needs.</p>

<div class="pricing-grid">
<!-- FREE PLAN -->
<div class="pricing-card free-plan">
<h3>🆓 Free Plan</h3>
<div class="price">$0<span>/month</span></div>
<ul class="feature-list">
<li>✅ 15 stocks per month</li>
<li>✅ Basic stock lookup</li>
<li>✅ 5 email list subscriptions</li>
<li>✅ Market news access</li>
<li>✅ Community support</li>
</ul>
<a href="/wp-login.php?action=register" class="btn btn-outline">Get Started Free</a>
</div>

<!-- BRONZE PLAN - Aligned with Plugin -->
<div class="pricing-card bronze-plan popular">
<div class="popular-badge">Most Popular</div>
<h3>🥉 Bronze Plan</h3>
<div class="price">$14.99<span>/month</span></div>
<ul class="feature-list">
<li>✅ 1,000 stocks per month</li>
<li>✅ Advanced stock lookup</li>
<li>✅ Email alerts & notifications</li>
<li>✅ News sentiment analysis</li>
<li>✅ Basic portfolio tracking</li>
</ul>
<div id="bronze-payment-button" class="payment-button-container">
<button class="btn btn-primary upgrade-btn" data-level="2" data-price="14.99">Upgrade to Bronze</button>
</div>
</div>

<!-- SILVER PLAN - Aligned with Plugin -->
<div class="pricing-card silver-plan">
<h3>🥈 Silver Plan</h3>
<div class="price">$29.99<span>/month</span></div>
<ul class="feature-list">
<li>✅ 5,000 stocks per month</li>
<li>✅ Advanced filtering & screening</li>
<li>✅ 1-year historical data</li>
<li>✅ Custom watchlists (10)</li>
<li>✅ Priority email support</li>
</ul>
<div id="silver-payment-button" class="payment-button-container">
<button class="btn btn-primary upgrade-btn" data-level="3" data-price="29.99">Upgrade to Silver</button>
</div>
</div>

<!-- GOLD PLAN - Aligned with Plugin -->
<div class="pricing-card gold-plan">
<h3>🏆 Gold Plan</h3>
<div class="price">$59.99<span>/month</span></div>
<ul class="feature-list">
<li>✅ 10,000 stocks per month</li>
<li>✅ All premium features</li>
<li>✅ Real-time alerts</li>
<li>✅ API access</li>
<li>✅ 5-year historical data</li>
<li>✅ Priority phone support</li>
</ul>
<div id="gold-payment-button" class="payment-button-container">
<button class="btn btn-primary upgrade-btn" data-level="4" data-price="59.99">Upgrade to Gold</button>
</div>
</div>
</div>

<h3>📊 Live Stock Analysis</h3>
[stock_scanner symbol="MSFT" show_chart="true" show_details="true"]
[stock_scanner symbol="GOOGL" show_chart="true" show_details="true"]
</div>',
            'template' => 'page-premium-plans.php'
        ),
        'dashboard' => array(
            'title' => 'Dashboard',
            'content' => '<h2>Welcome to your Trading Dashboard</h2>
<p>Access all your trading tools and portfolio information from here.</p>',
            'template' => 'page-dashboard.php'
        ),
        'scanner' => array(
            'title' => 'Stock Scanner',
            'content' => '<h2>Advanced Stock Scanner</h2>
<p>Find the best trading opportunities with our powerful screening tools.</p>',
            'template' => 'page-scanner.php'
        ),
        'portfolio' => array(
            'title' => 'Portfolio',
            'content' => '<h2>Portfolio Management</h2>
<p>Track and manage your investment portfolio.</p>',
            'template' => 'page-portfolio.php'
        ),
        'account' => array(
            'title' => 'My Account',
            'content' => '<h2>Account Settings</h2>
<p>Manage your account settings and preferences.</p>',
            'template' => 'page-account.php'
        ),
        'billing-history' => array(
            'title' => 'Billing History',
            'content' => '<h2>Billing History</h2>
<p>View your billing history and manage payments.</p>',
            'template' => 'page-billing-history.php'
        ),
        'news' => array(
            'title' => 'Market News',
            'content' => '<h2>Latest Market News</h2>
<p>Stay updated with the latest market news and analysis.</p>',
            'template' => 'page-news.php'
        ),
        'contact' => array(
            'title' => 'Contact',
            'content' => '<h2>Contact Us</h2>
<p>Get in touch with our support team.</p>',
            'template' => 'page-contact.php'
        ),
        'about' => array(
            'title' => 'About Us',
            'content' => '<h2>About Retail Trade Scanner</h2>
<p>Learn more about our platform and mission.</p>',
            'template' => 'page-about.php'
        ),
        'signup' => array(
            'title' => 'Sign Up',
            'content' => '<h2>Create Your Account</h2>
<p>Join thousands of traders using our platform.</p>',
            'template' => 'page-signup.php'
        ),
        'login' => array(
            'title' => 'Login',
            'content' => '<h2>Login to Your Account</h2>
<p>Access your dashboard and trading tools.</p>',
            'template' => 'page-login.php'
        ),
        'terms' => array(
            'title' => 'Terms and Conditions',
            'content' => '<h2>Terms and Conditions</h2>
<p><strong>Last updated:</strong> January 21, 2025</p>

<h3>1. Acceptance of Terms</h3>
<p>By accessing and using Retail Trade Scanner, you accept and agree to be bound by the terms and provision of this agreement.</p>

<h3>2. Investment Disclaimer</h3>
<p><strong>Important:</strong> All content is for educational purposes only. Past performance does not guarantee future results. Trading involves risk of loss.</p>',
            'template' => 'page-terms.php'
        ),
        'privacy' => array(
            'title' => 'Privacy Policy',
            'content' => '<h2>Privacy Policy</h2>
<p><strong>Last updated:</strong> January 21, 2025</p>

<h3>1. Information We Collect</h3>
<p>We collect information you provide directly to us, such as when you create an account, subscribe to our services, or contact us.</p>

<h3>2. Data Security</h3>
<p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>',
            'template' => 'page-privacy.php'
        )
    );

    foreach ($pages as $slug => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            $page_args = array(
                'post_title'     => sanitize_text_field($page_data['title']),
                'post_content'   => wp_kses_post($page_data['content']),
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_name'      => sanitize_title($slug),
                'comment_status' => 'closed',
                'ping_status'    => 'closed'
            );
            
            $page_id = wp_insert_post($page_args);
            
            if ($page_id && isset($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', sanitize_text_field($page_data['template']));
            }
        }
    }
}

/**
 * Activate theme setup
 */
function retail_trade_scanner_activate() {
    retail_trade_scanner_create_pages();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'retail_trade_scanner_activate');

/**
 * Add custom body classes
 */
function retail_trade_scanner_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    if (is_page_template()) {
        $template = get_page_template_slug();
        $classes[] = 'page-template-' . sanitize_html_class(str_replace('.php', '', $template));
    }
    
    // Add plugin status class
    if (class_exists('StockScannerIntegration')) {
        $classes[] = 'stock-scanner-plugin-active';
    } else {
        $classes[] = 'stock-scanner-plugin-inactive';
    }
    
    // Add user login status
    if (is_user_logged_in()) {
        $classes[] = 'user-logged-in';
    } else {
        $classes[] = 'user-logged-out';
    }
    
    return $classes;
}
add_filter('body_class', 'retail_trade_scanner_body_classes');

/**
 * Register widget areas
 */
function retail_trade_scanner_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widgets', 'retail-trade-scanner'),
        'id'            => 'footer-widgets',
        'description'   => __('Add widgets here to appear in the footer.', 'retail-trade-scanner'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Sidebar Widgets', 'retail-trade-scanner'),
        'id'            => 'sidebar-widgets',
        'description'   => __('Add widgets here to appear in the sidebar.', 'retail-trade-scanner'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'retail_trade_scanner_widgets_init');

/**
 * Add theme customization options - Aligned with Plugin
 */
function retail_trade_scanner_customize_register($wp_customize) {
    // Add section
    $wp_customize->add_section('retail_trade_scanner_options', array(
        'title' => __('Retail Trade Scanner Options', 'retail-trade-scanner'),
        'priority' => 30,
    ));
    
    // Add API endpoint setting (compatible with plugin)
    $wp_customize->add_setting('retail_trade_scanner_api_endpoint', array(
        'default' => 'https://api.retailtradescanner.com/api/',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('retail_trade_scanner_api_endpoint', array(
        'label' => __('Backend API URL', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_options',
        'type' => 'url',
        'description' => __('URL of your Retail Trade Scanner backend API (should match plugin setting)', 'retail-trade-scanner'),
    ));
    
    // Add PayPal Client ID setting (compatible with plugin)
    $wp_customize->add_setting('retail_trade_scanner_paypal_client_id', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('retail_trade_scanner_paypal_client_id', array(
        'label' => __('PayPal Client ID', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_options',
        'type' => 'text',
        'description' => __('Your PayPal application Client ID (should match plugin setting)', 'retail-trade-scanner'),
    ));
    
    // Add debug mode setting
    $wp_customize->add_setting('retail_trade_scanner_debug_mode', array(
        'default' => false,
        'sanitize_callback' => 'retail_trade_scanner_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('retail_trade_scanner_debug_mode', array(
        'label' => __('Enable Debug Mode', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_options',
        'type' => 'checkbox',
        'description' => __('Enable debug logging for troubleshooting', 'retail-trade-scanner'),
    ));
}
add_action('customize_register', 'retail_trade_scanner_customize_register');

/**
 * Sanitize checkbox values
 */
function retail_trade_scanner_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Admin notice for theme activation
 */
function retail_trade_scanner_admin_notice() {
    if (get_transient('retail_trade_scanner_activated')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Retail Trade Scanner theme activated! All required pages have been created automatically.', 'retail-trade-scanner'); ?></p>
        </div>
        <?php
        delete_transient('retail_trade_scanner_activated');
    }
}
add_action('admin_notices', 'retail_trade_scanner_admin_notice');

/**
 * Set transient on theme activation
 */
function retail_trade_scanner_set_activation_transient() {
    set_transient('retail_trade_scanner_activated', true, 30);
}
add_action('after_switch_theme', 'retail_trade_scanner_set_activation_transient');

/**
 * Create assets directory and main.js if they don't exist - FIXED VERSION
 */
function retail_trade_scanner_ensure_assets() {
    $theme_dir = get_template_directory();
    $assets_dir = $theme_dir . '/assets/js/';
    
    // Create directories if they don't exist
    if (!is_dir($assets_dir)) {
        wp_mkdir_p($assets_dir);
    }
    
    $main_js_file = $assets_dir . 'main.js';
    if (!file_exists($main_js_file)) {
        $js_content = file_get_contents(dirname(__FILE__) . '/assets/js/main.js.template');
        if ($js_content === false) {
            // Fallback to basic JS if template doesn't exist
            $js_content = '// Retail Trade Scanner - Main JavaScript
document.addEventListener("DOMContentLoaded", function() {
    console.log("Retail Trade Scanner theme loaded");
    
    // Initialize theme functionality
    if (typeof window.RetailTradeScanner !== "undefined") {
        window.RetailTradeScanner.init();
    }
});';
        }
        
        file_put_contents($main_js_file, $js_content);
    }
    
    // Create PayPal integration file if it doesn't exist
    $paypal_js_file = $assets_dir . 'paypal-integration.js';
    if (!file_exists($paypal_js_file)) {
        $paypal_js_content = '// PayPal Integration for Retail Trade Scanner
document.addEventListener("DOMContentLoaded", function() {
    if (typeof paypal !== "undefined") {
        initializePayPalButtons();
    }
});

function initializePayPalButtons() {
    // PayPal button initialization will be handled here
    console.log("PayPal SDK loaded and ready");
}';
        file_put_contents($paypal_js_file, $paypal_js_content);
    }
}

/**
 * Add REST API endpoints for theme functionality
 */
function retail_trade_scanner_register_rest_routes() {
    register_rest_route('retail-trade-scanner/v1', '/proxy/(?P<endpoint>.*)', array(
        'methods' => array('GET', 'POST', 'PUT', 'DELETE'),
        'callback' => 'retail_trade_scanner_proxy_handler',
        'permission_callback' => 'retail_trade_scanner_proxy_permission_check',
        'args' => array(
            'endpoint' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));
}
add_action('rest_api_init', 'retail_trade_scanner_register_rest_routes');

/**
 * Handle proxy requests to backend API
 */
function retail_trade_scanner_proxy_handler($request) {
    $endpoint = $request->get_param('endpoint');
    $method = $request->get_method();
    
    // Get backend URL
    $backend_url = get_option('stock_scanner_api_url', 
                   get_option('retail_trade_scanner_api_endpoint',
                   'https://api.retailtradescanner.com/api/'));
    
    $full_url = rtrim($backend_url, '/') . '/' . ltrim($endpoint, '/');
    
    // Prepare request arguments
    $args = array(
        'method' => $method,
        'timeout' => 30,
        'headers' => array(
            'Content-Type' => 'application/json',
            'User-Agent' => 'Retail-Trade-Scanner-Theme/2.1.1',
        ),
    );
    
    // Add body for POST/PUT requests
    if (in_array($method, array('POST', 'PUT'))) {
        $body = $request->get_body();
        if (!empty($body)) {
            $args['body'] = $body;
        }
    }
    
    // Add query parameters for GET requests
    if ($method === 'GET') {
        $query_params = $request->get_query_params();
        unset($query_params['rest_route']); // Remove WordPress REST route param
        if (!empty($query_params)) {
            $full_url .= '?' . http_build_query($query_params);
        }
    }
    
    // Make the request
    $response = wp_remote_request($full_url, $args);
    
    if (is_wp_error($response)) {
        return new WP_Error('api_error', $response->get_error_message(), array('status' => 500));
    }
    
    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);
    
    // Try to decode JSON response
    $decoded_body = json_decode($response_body, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        return new WP_REST_Response($decoded_body, $response_code);
    }
    
    return new WP_REST_Response($response_body, $response_code);
}

/**
 * Check permissions for proxy requests
 */
function retail_trade_scanner_proxy_permission_check($request) {
    // Allow public access for market data and basic stock info
    $endpoint = $request->get_param('endpoint');
    $public_endpoints = array('market-data', 'stocks/search', 'news');
    
    foreach ($public_endpoints as $public_endpoint) {
        if (strpos($endpoint, $public_endpoint) !== false) {
            return true;
        }
    }
    
    // Require authentication for user-specific data
    return is_user_logged_in();
}

/**
 * Add security headers
 */
function retail_trade_scanner_add_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('init', 'retail_trade_scanner_add_security_headers');

/**
 * Handle AJAX requests for theme functionality
 */
function retail_trade_scanner_ajax_handler() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'retail_trade_scanner_nonce')) {
        wp_die('Security check failed');
    }
    
    $action = sanitize_text_field($_POST['action_type']);
    
    switch ($action) {
        case 'search_stocks':
            retail_trade_scanner_handle_search();
            break;
        case 'add_to_watchlist':
            retail_trade_scanner_handle_watchlist_add();
            break;
        default:
            wp_send_json_error('Invalid action');
    }
}
add_action('wp_ajax_retail_trade_scanner_action', 'retail_trade_scanner_ajax_handler');
add_action('wp_ajax_nopriv_retail_trade_scanner_action', 'retail_trade_scanner_ajax_handler');

/**
 * Handle stock search AJAX
 */
function retail_trade_scanner_handle_search() {
    $query = sanitize_text_field($_POST['query']);
    
    if (empty($query)) {
        wp_send_json_error('Query is required');
    }
    
    // Here you would typically call your backend API
    // For now, return mock data
    $results = array(
        array(
            'symbol' => 'AAPL',
            'company_name' => 'Apple Inc.',
            'price' => 175.50,
            'change_percent' => 2.1
        ),
        array(
            'symbol' => 'MSFT',
            'company_name' => 'Microsoft Corporation',
            'price' => 378.85,
            'change_percent' => -0.8
        )
    );
    
    wp_send_json_success($results);
}

/**
 * Handle add to watchlist AJAX
 */
function retail_trade_scanner_handle_watchlist_add() {
    if (!is_user_logged_in()) {
        wp_send_json_error('Login required');
    }
    
    $symbol = sanitize_text_field($_POST['symbol']);
    
    if (empty($symbol)) {
        wp_send_json_error('Symbol is required');
    }
    
    // Add to user meta or call backend API
    $user_id = get_current_user_id();
    $watchlist = get_user_meta($user_id, 'stock_watchlist', true);
    
    if (!is_array($watchlist)) {
        $watchlist = array();
    }
    
    if (!in_array($symbol, $watchlist)) {
        $watchlist[] = $symbol;
        update_user_meta($user_id, 'stock_watchlist', $watchlist);
        wp_send_json_success('Added to watchlist');
    } else {
        wp_send_json_error('Already in watchlist');
    }
}

/**
 * Optimize theme performance
 */
function retail_trade_scanner_optimize_performance() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Disable emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'retail_trade_scanner_optimize_performance');

/**
 * Add theme support for additional features
 */
function retail_trade_scanner_after_setup_theme() {
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for wide alignment
    add_theme_support('align-wide');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for dark mode
    add_theme_support('dark-editor-style');
}
add_action('after_setup_theme', 'retail_trade_scanner_after_setup_theme');

/**
 * Enqueue block editor assets
 */
function retail_trade_scanner_block_editor_assets() {
    wp_enqueue_style(
        'retail-trade-scanner-editor',
        get_template_directory_uri() . '/assets/css/editor-style.css',
        array(),
        '2.1.1'
    );
}
add_action('enqueue_block_editor_assets', 'retail_trade_scanner_block_editor_assets');

/**
 * Custom login styles
 */
function retail_trade_scanner_login_styles() {
    wp_enqueue_style('retail-trade-scanner-login', get_template_directory_uri() . '/assets/css/login.css', array(), '2.1.1');
}
add_action('login_enqueue_scripts', 'retail_trade_scanner_login_styles');

/**
 * AJAX handler for profile updates
 */
function retail_trade_scanner_update_profile() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'retail_trade_scanner_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed'));
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }
    
    $user_id = get_current_user_id();
    
    // Sanitize input data
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $company = sanitize_text_field($_POST['company']);
    
    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields'));
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address'));
    }
    
    // Check if email is already in use by another user
    $existing_user = get_user_by('email', $email);
    if ($existing_user && $existing_user->ID !== $user_id) {
        wp_send_json_error(array('message' => 'This email is already in use by another account'));
    }
    
    // Update user data
    $user_data = array(
        'ID' => $user_id,
        'user_email' => $email,
        'display_name' => trim($first_name . ' ' . $last_name)
    );
    
    $result = wp_update_user($user_data);
    
    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => $result->get_error_message()));
    }
    
    // Update user meta
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'company', $company);
    
    wp_send_json_success(array('message' => 'Profile updated successfully'));
}
add_action('wp_ajax_retail_trade_scanner_update_profile', 'retail_trade_scanner_update_profile');

/**
 * AJAX handler for password changes
 */
function retail_trade_scanner_change_password() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'retail_trade_scanner_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed'));
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }
    
    $user_id = get_current_user_id();
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    
    // Validate inputs
    if (empty($current_password) || empty($new_password)) {
        wp_send_json_error(array('message' => 'Please fill in all password fields'));
    }
    
    if (strlen($new_password) < 8) {
        wp_send_json_error(array('message' => 'Password must be at least 8 characters long'));
    }
    
    // Get current user
    $user = get_user_by('id', $user_id);
    
    // Check current password
    if (!wp_check_password($current_password, $user->user_pass, $user_id)) {
        wp_send_json_error(array('message' => 'Current password is incorrect'));
    }
    
    // Update password
    wp_set_password($new_password, $user_id);
    
    // Update last password change meta
    update_user_meta($user_id, 'last_password_change', current_time('mysql'));
    
    wp_send_json_success(array('message' => 'Password changed successfully'));
}
add_action('wp_ajax_retail_trade_scanner_change_password', 'retail_trade_scanner_change_password');

/**
 * AJAX handler for notification settings
 */
function retail_trade_scanner_save_notifications() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'retail_trade_scanner_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed'));
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }
    
    $user_id = get_current_user_id();
    $notifications = json_decode(stripslashes($_POST['notifications']), true);
    
    if (!is_array($notifications)) {
        wp_send_json_error(array('message' => 'Invalid notification data'));
    }
    
    // Save notification preferences
    update_user_meta($user_id, 'notification_preferences', $notifications);
    
    wp_send_json_success(array('message' => 'Notification settings saved successfully'));
}
add_action('wp_ajax_retail_trade_scanner_save_notifications', 'retail_trade_scanner_save_notifications');

/**
 * Add custom user fields to profile
 */
function retail_trade_scanner_user_profile_fields($user) {
    ?>
    <h3>Retail Trade Scanner Profile</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="company">Company</label></th>
            <td>
                <input type="text" name="company" id="company" value="<?php echo esc_attr(get_user_meta($user->ID, 'company', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'retail_trade_scanner_user_profile_fields');
add_action('edit_user_profile', 'retail_trade_scanner_user_profile_fields');

/**
 * Save custom user profile fields
 */
function retail_trade_scanner_save_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    update_user_meta($user_id, 'company', sanitize_text_field($_POST['company']));
}
add_action('personal_options_update', 'retail_trade_scanner_save_user_profile_fields');
add_action('edit_user_profile_update', 'retail_trade_scanner_save_user_profile_fields');

/**
 * Add PayPal webhook handler
 */
function retail_trade_scanner_paypal_webhook() {
    // Verify PayPal webhook signature (implement proper verification in production)
    $headers = getallheaders();
    
    // Get webhook data
    $input = file_get_contents('php://input');
    $webhook_data = json_decode($input, true);
    
    if (!$webhook_data) {
        status_header(400);
        exit('Invalid webhook data');
    }
    
    // Log webhook for debugging
    if (get_option('retail_trade_scanner_debug_mode')) {
        error_log('PayPal Webhook: ' . print_r($webhook_data, true));
    }
    
    // Handle different webhook events
    switch ($webhook_data['event_type']) {
        case 'PAYMENT.CAPTURE.COMPLETED':
            $this->handle_payment_completed($webhook_data);
            break;
            
        case 'BILLING.SUBSCRIPTION.ACTIVATED':
            $this->handle_subscription_activated($webhook_data);
            break;
            
        case 'BILLING.SUBSCRIPTION.CANCELLED':
            $this->handle_subscription_cancelled($webhook_data);
            break;
            
        default:
            // Log unhandled event
            error_log('Unhandled PayPal webhook event: ' . $webhook_data['event_type']);
    }
    
    status_header(200);
    exit('Webhook processed');
}

/**
 * Handle payment completed webhook
 */
function retail_trade_scanner_handle_payment_completed($webhook_data) {
    // Extract order information
    $resource = $webhook_data['resource'];
    $order_id = $resource['id'];
    $amount = $resource['amount']['value'];
    
    // Save payment record
    $payment_data = array(
        'order_id' => sanitize_text_field($order_id),
        'amount' => floatval($amount),
        'status' => 'completed',
        'date' => current_time('mysql'),
        'webhook_data' => $webhook_data
    );
    
    // Store in WordPress options or custom table
    $payments = get_option('retail_trade_scanner_payments', array());
    $payments[] = $payment_data;
    update_option('retail_trade_scanner_payments', $payments);
}

/**
 * Custom CSS for admin
 */
function retail_trade_scanner_admin_styles() {
    echo '<style>
        .retail-trade-scanner-admin {
            background: #f1f5f9;
            border: 1px solid #059669;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }
        .retail-trade-scanner-admin h2 {
            color: #059669;
            margin-top: 0;
        }
    </style>';
}
add_action('admin_head', 'retail_trade_scanner_admin_styles');

/**
 * Add theme info to admin footer
 */
function retail_trade_scanner_admin_footer() {
    echo '<span id="footer-thankyou">Retail Trade Scanner Theme v2.1.1 - Professional Trading Platform</span>';
}
add_filter('admin_footer_text', 'retail_trade_scanner_admin_footer');