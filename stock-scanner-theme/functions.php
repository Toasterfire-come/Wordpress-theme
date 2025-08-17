<?php
/**
 * Stock Scanner Pro Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function stock_scanner_theme_setup() {
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
        'primary' => __('Primary Menu', 'stock-scanner-pro'),
        'footer' => __('Footer Menu', 'stock-scanner-pro'),
    ));
}
add_action('after_setup_theme', 'stock_scanner_theme_setup');

/**
 * Enqueue React build assets
 */
function stock_scanner_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');
    
    // Get React build assets
    $css_files = glob(get_template_directory() . '/assets/css/*.css');
    $js_files = glob(get_template_directory() . '/assets/js/*.js');
    
    // Enqueue CSS files
    foreach ($css_files as $css_file) {
        $filename = basename($css_file);
        $handle = 'stock-scanner-' . pathinfo($filename, PATHINFO_FILENAME);
        wp_enqueue_style(
            $handle,
            get_template_directory_uri() . '/assets/css/' . $filename,
            array(),
            $theme_version
        );
    }
    
    // Enqueue JS files
    foreach ($js_files as $js_file) {
        $filename = basename($js_file);
        $handle = 'stock-scanner-' . pathinfo($filename, PATHINFO_FILENAME);
        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . '/assets/js/' . $filename,
            array(),
            $theme_version,
            true
        );
    }
    
    // Add inline script to handle React Router with WordPress
    if (!empty($js_files)) {
        $main_js_file = '';
        foreach ($js_files as $js_file) {
            $filename = basename($js_file);
            if (strpos($filename, 'main') !== false) {
                $main_js_file = 'stock-scanner-' . pathinfo($filename, PATHINFO_FILENAME);
                break;
            }
        }
        
        if ($main_js_file) {
            wp_add_inline_script($main_js_file, '
                // Handle React Router with WordPress URLs
                window.addEventListener("load", function() {
                    // Prevent WordPress from interfering with React Router
                    if (window.history && window.history.pushState) {
                        // Let React Router handle navigation
                        document.addEventListener("click", function(e) {
                            var link = e.target.closest("a");
                            if (link && link.href && link.href.indexOf(window.location.origin) === 0) {
                                var path = link.href.replace(window.location.origin, "");
                                if (path.match(/^\/(dashboard|market-overview|scanner|watchlist|portfolio|news|account|premium|plans|compare-plans|login|signup|contact)/)) {
                                    e.preventDefault();
                                    window.history.pushState({}, "", link.href);
                                    // Let React Router handle the route change
                                    window.dispatchEvent(new PopStateEvent("popstate"));
                                }
                            }
                        });
                    }
                });
            ', 'before');
        }
    }
    
    // Localize script for WordPress data
    $script_handle = '';
    foreach ($js_files as $js_file) {
        $filename = basename($js_file);
        if (strpos($filename, 'main') !== false) {
            $script_handle = 'stock-scanner-' . pathinfo($filename, PATHINFO_FILENAME);
            break;
        }
    }
    
    if ($script_handle) {
        wp_localize_script($script_handle, 'wpData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_rest'),
            'restUrl' => rest_url('wp/v2/'),
            'homeUrl' => home_url('/'),
            'themeUrl' => get_template_directory_uri(),
        ));
    }
}
add_action('wp_enqueue_scripts', 'stock_scanner_enqueue_assets');

/**
 * Remove WordPress admin bar for clean React app experience
 */
function stock_scanner_remove_admin_bar() {
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'stock_scanner_remove_admin_bar');

/**
 * Custom post types and endpoints for React app
 */
function stock_scanner_register_post_types() {
    // Register custom post types if needed for the stock scanner app
    // This can be extended based on specific requirements
}
add_action('init', 'stock_scanner_register_post_types');

/**
 * AJAX handlers for React app
 */
function stock_scanner_ajax_handler() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'wp_rest')) {
        wp_die('Security check failed');
    }
    
    // Handle AJAX requests from React app
    $action = sanitize_text_field($_POST['action']);
    
    switch ($action) {
        case 'get_user_data':
            // Return user data for React app
            wp_send_json_success(array(
                'user' => wp_get_current_user(),
                'logged_in' => is_user_logged_in()
            ));
            break;
        
        default:
            wp_send_json_error('Invalid action');
    }
}
add_action('wp_ajax_stock_scanner_action', 'stock_scanner_ajax_handler');
add_action('wp_ajax_nopriv_stock_scanner_action', 'stock_scanner_ajax_handler');

/**
 * Disable WordPress theme customization for this React-based theme
 */
function stock_scanner_customize_register($wp_customize) {
    // Remove default WordPress customizer sections that don't apply to React app
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('background_image');
    $wp_customize->remove_section('header_image');
}
add_action('customize_register', 'stock_scanner_customize_register');

/**
 * Handle React Router routing
 */
function stock_scanner_handle_routing($template) {
    // For React SPA, we want to serve the main template for all routes
    // that should be handled by React Router
    $react_routes = array(
        'dashboard',
        'market-overview', 
        'scanner',
        'watchlist',
        'portfolio',
        'news',
        'account',
        'premium',
        'plans',
        'compare-plans',
        'login',
        'signup',
        'contact',
        'billing-history',
        'notifications',
        'faq'
    );
    
    global $wp_query;
    $request_uri = $_SERVER['REQUEST_URI'];
    $current_path = trim(parse_url($request_uri, PHP_URL_PATH), '/');
    
    // Check if current path should be handled by React
    foreach ($react_routes as $route) {
        if ($current_path === $route || strpos($current_path, $route . '/') === 0) {
            // Prevent 404 for React routes
            $wp_query->is_404 = false;
            status_header(200);
            
            // Set proper query vars for WordPress
            $wp_query->is_home = false;
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
            
            // Return the main index template
            return get_template_directory() . '/index.php';
        }
    }
    
    // Also handle the home page with React
    if ($current_path === '' || $current_path === 'home') {
        $wp_query->is_404 = false;
        status_header(200);
        return get_template_directory() . '/index.php';
    }
    
    return $template;
}
add_filter('template_include', 'stock_scanner_handle_routing');

/**
 * Clean up WordPress head for React app
 */
function stock_scanner_cleanup_head() {
    // Remove WordPress generator meta tag
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove feed links
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('init', 'stock_scanner_cleanup_head');

/**
 * Add security headers
 */
function stock_scanner_security_headers() {
    if (!is_admin()) {
        header('X-Frame-Options: DENY');
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'stock_scanner_security_headers');

/**
 * Optimize WordPress for React SPA
 */
function stock_scanner_optimize_wp() {
    // Remove unnecessary WordPress features for SPA
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');
    
    // Remove REST API links from head (React will use REST API directly)
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
}
add_action('init', 'stock_scanner_optimize_wp');

/**
 * Handle CORS for React app
 */
function stock_scanner_handle_cors() {
    // Allow CORS for REST API requests from React
    header('Access-Control-Allow-Origin: ' . home_url());
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-WP-Nonce');
    header('Access-Control-Allow-Credentials: true');
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        status_header(200);
        exit();
    }
}
add_action('rest_api_init', 'stock_scanner_handle_cors');

/**
 * Custom REST API endpoints for React app
 */
function stock_scanner_register_api_routes() {
    register_rest_route('stock-scanner/v1', '/user-data', array(
        'methods' => 'GET',
        'callback' => 'stock_scanner_get_user_data',
        'permission_callback' => function() {
            return is_user_logged_in();
        }
    ));
    
    register_rest_route('stock-scanner/v1', '/theme-data', array(
        'methods' => 'GET',
        'callback' => 'stock_scanner_get_theme_data',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'stock_scanner_register_api_routes');

/**
 * Get user data for React app
 */
function stock_scanner_get_user_data() {
    $current_user = wp_get_current_user();
    
    return array(
        'id' => $current_user->ID,
        'username' => $current_user->user_login,
        'email' => $current_user->user_email,
        'display_name' => $current_user->display_name,
        'roles' => $current_user->roles,
        'logged_in' => is_user_logged_in()
    );
}

/**
 * Get theme data for React app
 */
function stock_scanner_get_theme_data() {
    return array(
        'site_name' => get_bloginfo('name'),
        'site_url' => home_url(),
        'theme_url' => get_template_directory_uri(),
        'rest_url' => rest_url(),
        'nonce' => wp_create_nonce('wp_rest')
    );
}