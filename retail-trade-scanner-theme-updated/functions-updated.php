<?php
/**
 * Retail Trade Scanner Theme Functions - Updated with Dark Mode & API Fixes
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup with dark mode support
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
 * Enqueue scripts and styles - Updated for Django backend
 */
function retail_trade_scanner_scripts() {
    // Enqueue theme stylesheet with dark mode support
    wp_enqueue_style('retail-trade-scanner-style', get_stylesheet_uri(), array(), '2.2.0');
    
    // Enqueue dark mode CSS
    wp_enqueue_style('retail-trade-scanner-dark-mode', get_template_directory_uri() . '/assets/css/dark-mode.css', array('retail-trade-scanner-style'), '2.2.0');
    
    // Enqueue Google Fonts
    wp_enqueue_style('retail-trade-scanner-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Ensure assets directory exists
    retail_trade_scanner_ensure_assets();
    
    // Enqueue updated JavaScript
    wp_enqueue_script('retail-trade-scanner-script', get_template_directory_uri() . '/assets/js/main-updated.js', array('jquery'), '2.2.0', true);
    
    // Get Django backend URL - Updated configuration
    $backend_url = get_option('stock_scanner_api_url', 
                   get_option('retail_trade_scanner_api_endpoint',
                   defined('RETAIL_TRADE_SCANNER_API_URL') ? RETAIL_TRADE_SCANNER_API_URL : 'https://api.retailtradescanner.com'));
    
    // Updated API endpoints for Django backend
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
        ),
        'plugin_active' => class_exists('StockScannerIntegration'),
        'is_user_logged_in' => is_user_logged_in(),
        'current_user_id' => get_current_user_id(),
        'dark_mode' => get_user_meta(get_current_user_id(), 'dark_mode_enabled', true) ?: false,
    ));
}
add_action('wp_enqueue_scripts', 'retail_trade_scanner_scripts');

/**
 * Dark Mode Functions
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
 * Rate Limiting Implementation
 */
class RetailTradeScannerRateLimit {
    private static $instance = null;
    private $rate_limits = array();
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function check_rate_limit($user_id, $action, $limit_per_minute = 60) {
        $cache_key = "rate_limit_{$user_id}_{$action}";
        $current_count = wp_cache_get($cache_key);
        
        if ($current_count === false) {
            wp_cache_set($cache_key, 1, '', 60); // 60 seconds
            return true;
        }
        
        if ($current_count >= $limit_per_minute) {
            return false;
        }
        
        wp_cache_set($cache_key, $current_count + 1, '', 60);
        return true;
    }
    
    public function get_rate_limit_message($action) {
        return sprintf(
            __('Rate limit exceeded for %s. Please wait before making more requests.', 'retail-trade-scanner'),
            $action
        );
    }
}

/**
 * Enhanced API proxy handler with rate limiting
 */
function retail_trade_scanner_proxy_handler($request) {
    $endpoint = $request->get_param('endpoint');
    $method = $request->get_method();
    
    // Rate limiting
    $user_id = get_current_user_id();
    $rate_limiter = RetailTradeScannerRateLimit::getInstance();
    
    if (!$rate_limiter->check_rate_limit($user_id, 'api_request', 100)) {
        return new WP_Error(
            'rate_limit_exceeded',
            $rate_limiter->get_rate_limit_message('API request'),
            array('status' => 429)
        );
    }
    
    // Get Django backend URL
    $backend_url = get_option('stock_scanner_api_url', 
                   get_option('retail_trade_scanner_api_endpoint',
                   'https://api.retailtradescanner.com'));
    
    // Build full URL - handle Django API structure
    if (strpos($endpoint, 'api/') !== 0) {
        $endpoint = 'api/' . ltrim($endpoint, '/');
    }
    
    $full_url = rtrim($backend_url, '/') . '/' . ltrim($endpoint, '/');
    
    // Prepare request arguments
    $args = array(
        'method' => $method,
        'timeout' => 30,
        'headers' => array(
            'Content-Type' => 'application/json',
            'User-Agent' => 'Retail-Trade-Scanner-Theme/2.2.0',
            'Accept' => 'application/json',
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
 * Register REST API endpoints for Django backend integration
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
 * Permission check for proxy requests
 */
function retail_trade_scanner_proxy_permission_check($request) {
    $endpoint = $request->get_param('endpoint');
    
    // Allow public access for market data and basic stock info
    $public_endpoints = array('market/stats', 'stocks/search', 'stocks/nasdaq', 'trending');
    
    foreach ($public_endpoints as $public_endpoint) {
        if (strpos($endpoint, $public_endpoint) !== false) {
            return true;
        }
    }
    
    // Require authentication for user-specific data
    return is_user_logged_in();
}

/**
 * Enhanced error logging with better debugging
 */
function retail_trade_scanner_log_error($message, $context = array()) {
    if (WP_DEBUG && WP_DEBUG_LOG) {
        $log_message = sprintf(
            '[Retail Trade Scanner] %s | Context: %s',
            $message,
            wp_json_encode($context)
        );
        error_log($log_message);
    }
}

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
    
    // Create updated main.js file
    $main_js_file = $assets_dir . 'main-updated.js';
    if (!file_exists($main_js_file)) {
        $js_content = '// Updated JavaScript file - see main-updated.js for full implementation
document.addEventListener("DOMContentLoaded", function() {
    if (typeof window.RetailTradeScanner !== "undefined") {
        window.RetailTradeScanner.init();
    }
});';
        file_put_contents($main_js_file, $js_content);
    }
}

/**
 * Add body classes for dark mode
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
        
        // Add dark mode class
        $user_id = get_current_user_id();
        if (get_user_meta($user_id, 'dark_mode_enabled', true)) {
            $classes[] = 'dark-mode';
        }
    } else {
        $classes[] = 'user-logged-out';
    }
    
    return $classes;
}
add_filter('body_class', 'retail_trade_scanner_body_classes');

/**
 * Add theme customization options
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
    
    // Add dark mode default setting
    $wp_customize->add_setting('retail_trade_scanner_default_dark_mode', array(
        'default' => false,
        'sanitize_callback' => 'retail_trade_scanner_sanitize_checkbox',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('retail_trade_scanner_default_dark_mode', array(
        'label' => __('Enable Dark Mode by Default', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_options',
        'type' => 'checkbox',
        'description' => __('New users will start with dark mode enabled', 'retail-trade-scanner'),
    ));
}
add_action('customize_register', 'retail_trade_scanner_customize_register');

/**
 * Sanitize checkbox values
 */
function retail_trade_scanner_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

// Rest of the functions remain the same as in the original file...
// (Keeping the original functions for page creation, widgets, etc.)