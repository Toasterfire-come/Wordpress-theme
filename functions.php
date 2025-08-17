<?php
/**
 * Retail Trade Scanner Theme Functions
 * React SPA with WordPress REST API Backend
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
}
add_action('after_setup_theme', 'retail_trade_scanner_setup');

/**
 * Enqueue React build files and configure for SPA
 */
function retail_trade_scanner_scripts() {
    // Dequeue WordPress default styles that might interfere with React
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
    
    // Check if React build exists
    $react_build_path = get_template_directory() . '/build/static/';
    $react_build_url = get_template_directory_uri() . '/build/static/';
    
    if (is_dir($react_build_path)) {
        // Production build
        $js_files = glob($react_build_path . 'js/main.*.js');
        $css_files = glob($react_build_path . 'css/main.*.css');
        
        if (!empty($css_files)) {
            $css_file = basename($css_files[0]);
            wp_enqueue_style('retail-trade-scanner-react-css', $react_build_url . 'css/' . $css_file, array(), '1.0.0');
        }
        
        if (!empty($js_files)) {
            $js_file = basename($js_files[0]);
            wp_enqueue_script('retail-trade-scanner-react', $react_build_url . 'js/' . $js_file, array(), '1.0.0', true);
        }
        
        // Add manifest.json for PWA support
        $manifest_path = get_template_directory() . '/build/manifest.json';
        if (file_exists($manifest_path)) {
            add_action('wp_head', function() {
                echo '<link rel="manifest" href="' . get_template_directory_uri() . '/build/manifest.json">';
            });
        }
    } else {
        // Development mode - React dev server
        wp_enqueue_script('retail-trade-scanner-react-dev', 'http://localhost:3000/static/js/bundle.js', array(), '1.0.0', true);
    }
    
    // Localize script with WordPress data for React
    wp_localize_script(
        is_dir($react_build_path) ? 'retail-trade-scanner-react' : 'retail-trade-scanner-react-dev',
        'wpApiData',
        array(
            'apiUrl' => rest_url('retail-trade-scanner/v1/'),
            'wpRestUrl' => rest_url('wp/v2/'),
            'nonce' => wp_create_nonce('wp_rest'),
            'homeUrl' => home_url('/'),
            'themeUrl' => get_template_directory_uri(),
            'isLoggedIn' => is_user_logged_in(),
            'currentUser' => is_user_logged_in() ? wp_get_current_user()->data : null,
            'siteName' => get_bloginfo('name'),
            'siteDescription' => get_bloginfo('description'),
        )
    );
}
add_action('wp_enqueue_scripts', 'retail_trade_scanner_scripts');

/**
 * Register REST API endpoints for React app
 */
function retail_trade_scanner_register_rest_routes() {
    // Proxy endpoint for external API
    register_rest_route('retail-trade-scanner/v1', '/proxy/(?P<endpoint>.*)', array(
        'methods' => array('GET', 'POST', 'PUT', 'DELETE'),
        'callback' => 'retail_trade_scanner_api_proxy',
        'permission_callback' => '__return_true',
    ));
    
    // Market data endpoints
    register_rest_route('retail-trade-scanner/v1', '/market-data', array(
        'methods' => 'GET',
        'callback' => 'retail_trade_scanner_get_market_data',
        'permission_callback' => '__return_true',
    ));
    
    register_rest_route('retail-trade-scanner/v1', '/stocks/(?P<symbol>[a-zA-Z0-9]+)', array(
        'methods' => 'GET',
        'callback' => 'retail_trade_scanner_get_stock_data',
        'permission_callback' => '__return_true',
    ));
    
    // User-specific endpoints (require authentication)
    register_rest_route('retail-trade-scanner/v1', '/watchlist', array(
        'methods' => array('GET', 'POST', 'DELETE'),
        'callback' => 'retail_trade_scanner_handle_watchlist',
        'permission_callback' => 'is_user_logged_in',
    ));
    
    register_rest_route('retail-trade-scanner/v1', '/portfolio', array(
        'methods' => array('GET', 'POST', 'PUT'),
        'callback' => 'retail_trade_scanner_handle_portfolio',
        'permission_callback' => 'is_user_logged_in',
    ));
    
    // Contact form endpoint
    register_rest_route('retail-trade-scanner/v1', '/contact', array(
        'methods' => 'POST',
        'callback' => 'retail_trade_scanner_handle_contact',
        'permission_callback' => '__return_true',
    ));
    
    // System status endpoint
    register_rest_route('retail-trade-scanner/v1', '/status', array(
        'methods' => 'GET',
        'callback' => 'retail_trade_scanner_get_system_status',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'retail_trade_scanner_register_rest_routes');

/**
 * API Proxy to external backend (FastAPI)
 */
function retail_trade_scanner_api_proxy($request) {
    $endpoint = $request->get_param('endpoint');
    $method = $request->get_method();
    $params = $request->get_params();
    
    // Get backend URL from environment or options
    $backend_url = defined('RETAIL_TRADE_SCANNER_API_URL') 
        ? RETAIL_TRADE_SCANNER_API_URL 
        : get_option('retail_trade_scanner_api_url', 'http://localhost:8001/api');
    
    $api_url = trailingslashit($backend_url) . $endpoint;
    
    $args = array(
        'method' => $method,
        'timeout' => 30,
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    );
    
    if (in_array($method, array('POST', 'PUT', 'PATCH')) && !empty($params)) {
        $args['body'] = json_encode($params);
    } elseif ($method === 'GET' && !empty($params)) {
        $api_url = add_query_arg($params, $api_url);
    }
    
    $response = wp_remote_request($api_url, $args);
    
    if (is_wp_error($response)) {
        return new WP_Error('api_error', $response->get_error_message(), array('status' => 500));
    }
    
    $body = wp_remote_retrieve_body($response);
    $status_code = wp_remote_retrieve_response_code($response);
    
    $data = json_decode($body, true);
    
    return new WP_REST_Response($data, $status_code);
}

/**
 * Market data endpoint
 */
function retail_trade_scanner_get_market_data($request) {
    // Mock data for now - replace with actual API call
    return new WP_REST_Response(array(
        'success' => true,
        'data' => array(
            'indices' => array(
                array('symbol' => 'SPY', 'price' => 445.67, 'change' => 2.34, 'percent' => 0.53),
                array('symbol' => 'QQQ', 'price' => 378.92, 'change' => -1.45, 'percent' => -0.38),
                array('symbol' => 'DIA', 'price' => 345.23, 'change' => 1.87, 'percent' => 0.54),
            ),
            'timestamp' => time()
        )
    ), 200);
}

/**
 * Stock data endpoint
 */
function retail_trade_scanner_get_stock_data($request) {
    $symbol = $request->get_param('symbol');
    
    // Mock data - replace with actual API call
    return new WP_REST_Response(array(
        'success' => true,
        'data' => array(
            'symbol' => strtoupper($symbol),
            'price' => rand(50, 500) + (rand(0, 99) / 100),
            'change' => rand(-10, 10) + (rand(0, 99) / 100),
            'percent' => rand(-5, 5) + (rand(0, 99) / 100),
            'volume' => rand(1000000, 50000000),
            'timestamp' => time()
        )
    ), 200);
}

/**
 * Watchlist handler
 */
function retail_trade_scanner_handle_watchlist($request) {
    $user_id = get_current_user_id();
    $method = $request->get_method();
    
    switch ($method) {
        case 'GET':
            $watchlist = get_user_meta($user_id, 'stock_watchlist', true);
            return new WP_REST_Response(array(
                'success' => true,
                'data' => $watchlist ?: array()
            ), 200);
            
        case 'POST':
            $symbol = $request->get_param('symbol');
            $watchlist = get_user_meta($user_id, 'stock_watchlist', true) ?: array();
            
            if (!in_array($symbol, $watchlist)) {
                $watchlist[] = $symbol;
                update_user_meta($user_id, 'stock_watchlist', $watchlist);
            }
            
            return new WP_REST_Response(array(
                'success' => true,
                'data' => $watchlist
            ), 200);
            
        case 'DELETE':
            $symbol = $request->get_param('symbol');
            $watchlist = get_user_meta($user_id, 'stock_watchlist', true) ?: array();
            $watchlist = array_diff($watchlist, array($symbol));
            
            update_user_meta($user_id, 'stock_watchlist', array_values($watchlist));
            
            return new WP_REST_Response(array(
                'success' => true,
                'data' => array_values($watchlist)
            ), 200);
    }
}

/**
 * Portfolio handler
 */
function retail_trade_scanner_handle_portfolio($request) {
    $user_id = get_current_user_id();
    $method = $request->get_method();
    
    switch ($method) {
        case 'GET':
            $portfolio = get_user_meta($user_id, 'stock_portfolio', true);
            return new WP_REST_Response(array(
                'success' => true,
                'data' => $portfolio ?: array()
            ), 200);
            
        case 'POST':
        case 'PUT':
            $portfolio_data = $request->get_json_params();
            update_user_meta($user_id, 'stock_portfolio', $portfolio_data);
            
            return new WP_REST_Response(array(
                'success' => true,
                'data' => $portfolio_data
            ), 200);
    }
}

/**
 * Contact form handler
 */
function retail_trade_scanner_handle_contact($request) {
    $data = $request->get_json_params();
    
    $name = sanitize_text_field($data['name'] ?? '');
    $email = sanitize_email($data['email'] ?? '');
    $message = sanitize_textarea_field($data['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($message)) {
        return new WP_Error('missing_fields', 'All fields are required', array('status' => 400));
    }
    
    // Send email
    $to = get_option('admin_email');
    $subject = 'Contact Form: ' . $name;
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    $sent = wp_mail($to, $subject, $body, $headers);
    
    return new WP_REST_Response(array(
        'success' => $sent,
        'message' => $sent ? 'Message sent successfully' : 'Failed to send message'
    ), $sent ? 200 : 500);
}

/**
 * System status endpoint
 */
function retail_trade_scanner_get_system_status($request) {
    return new WP_REST_Response(array(
        'success' => true,
        'data' => array(
            'status' => 'operational',
            'uptime' => '99.98%',
            'response_time' => '145ms',
            'last_updated' => time()
        )
    ), 200);
}

/**
 * Handle React Router URLs by serving the main template
 */
function retail_trade_scanner_template_redirect() {
    // Don't interfere with admin, API, or asset requests
    if (is_admin() || 
        strpos($_SERVER['REQUEST_URI'], '/wp-json/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/wp-content/') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/wp-includes/') !== false) {
        return;
    }
    
    // For all other requests, serve the React app
    global $wp_query;
    $wp_query->is_404 = false;
    status_header(200);
    include get_template_directory() . '/index.php';
    exit;
}
add_action('template_redirect', 'retail_trade_scanner_template_redirect');

/**
 * Add CORS headers for API requests
 */
function retail_trade_scanner_add_cors_headers() {
    if (strpos($_SERVER['REQUEST_URI'], '/wp-json/') !== false) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-WP-Nonce');
    }
}
add_action('init', 'retail_trade_scanner_add_cors_headers');

/**
 * Create required pages on theme activation (for URL structure)
 */
function retail_trade_scanner_create_pages() {
    $pages = array(
        'dashboard', 'market-overview', 'scanner', 'watchlist', 'portfolio', 
        'news', 'account', 'premium-plans', 'compare-plans', 'contact', 
        'login', 'signup', 'terms', 'privacy', 'about', 'status'
    );

    foreach ($pages as $slug) {
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            $page_args = array(
                'post_title'     => ucwords(str_replace('-', ' ', $slug)),
                'post_content'   => '', // Empty content - React will handle
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_name'      => $slug,
                'comment_status' => 'closed',
                'ping_status'    => 'closed'
            );
            
            wp_insert_post($page_args);
        }
    }
}

/**
 * Theme activation
 */
function retail_trade_scanner_activate() {
    retail_trade_scanner_create_pages();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'retail_trade_scanner_activate');

/**
 * Add customizer options for API configuration
 */
function retail_trade_scanner_customize_register($wp_customize) {
    $wp_customize->add_section('retail_trade_scanner_api', array(
        'title' => __('API Configuration', 'retail-trade-scanner'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('retail_trade_scanner_api_url', array(
        'default' => 'http://localhost:8001/api',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('retail_trade_scanner_api_url', array(
        'label' => __('External API URL', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_api',
        'type' => 'url',
        'description' => __('URL for the external FastAPI backend', 'retail-trade-scanner'),
    ));
}
add_action('customize_register', 'retail_trade_scanner_customize_register');

/**
 * Remove WordPress head elements that aren't needed for SPA
 */
function retail_trade_scanner_clean_head() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
add_action('init', 'retail_trade_scanner_clean_head');