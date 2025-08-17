<?php
/**
 * Retail Trade Scanner Theme Functions
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
 * Enqueue scripts and styles
 */
function retail_trade_scanner_scripts() {
    // Enqueue theme stylesheet
    wp_enqueue_style('retail-trade-scanner-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue React build files (if built)
    $react_build_path = get_template_directory() . '/build/static/js/';
    if (is_dir($react_build_path)) {
        $js_files = glob($react_build_path . 'main.*.js');
        $css_files = glob(get_template_directory() . '/build/static/css/main.*.css');
        
        if (!empty($js_files)) {
            $js_file = basename($js_files[0]);
            wp_enqueue_script('retail-trade-scanner-react', get_template_directory_uri() . '/build/static/js/' . $js_file, array(), '1.0.0', true);
        }
        
        if (!empty($css_files)) {
            $css_file = basename($css_files[0]);
            wp_enqueue_style('retail-trade-scanner-react-css', get_template_directory_uri() . '/build/static/css/' . $css_file, array(), '1.0.0');
        }
    } else {
        // Development mode - enqueue development React
        wp_enqueue_script('retail-trade-scanner-react-dev', 'http://localhost:3000/static/js/bundle.js', array(), '1.0.0', true);
    }
    
    // Enqueue custom JavaScript
    wp_enqueue_script('retail-trade-scanner-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX and REST API
    wp_localize_script('retail-trade-scanner-script', 'retail_trade_scanner_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'rest_url' => rest_url('retail-trade-scanner/v1/'),
        'nonce' => wp_create_nonce('retail_trade_scanner_nonce'),
        'api_endpoints' => array(
            'stocks' => rest_url('retail-trade-scanner/v1/stocks/'),
            'market_data' => rest_url('retail-trade-scanner/v1/market-data/'),
            'portfolio' => rest_url('retail-trade-scanner/v1/portfolio/'),
            'watchlist' => rest_url('retail-trade-scanner/v1/watchlist/'),
            'news' => rest_url('retail-trade-scanner/v1/news/'),
        ),
    ));
}
add_action('wp_enqueue_scripts', 'retail_trade_scanner_scripts');

/**
 * Create required pages on theme activation
 */
function retail_trade_scanner_create_pages() {
    $pages = array(
        'home' => array(
            'title' => 'Home',
            'content' => 'Welcome to Retail Trade Scanner - Professional stock analysis and portfolio management platform.',
            'template' => 'page-home.php'
        ),
        'dashboard' => array(
            'title' => 'Dashboard',
            'content' => 'Your personalized trading dashboard with portfolio overview and market insights.',
            'template' => 'page-dashboard.php'
        ),
        'market-overview' => array(
            'title' => 'Market Overview',
            'content' => 'Real-time market data, major indices, top gainers and losers.',
            'template' => 'page-market-overview.php'
        ),
        'scanner' => array(
            'title' => 'Stock Scanner',
            'content' => 'Advanced stock screening and filtering tools.',
            'template' => 'page-scanner.php'
        ),
        'watchlist' => array(
            'title' => 'Watchlist',
            'content' => 'Create and manage your stock watchlists with real-time updates.',
            'template' => 'page-watchlist.php'
        ),
        'portfolio' => array(
            'title' => 'Portfolio',
            'content' => 'Track your investment portfolio performance and analytics.',
            'template' => 'page-portfolio.php'
        ),
        'news' => array(
            'title' => 'Market News',
            'content' => 'Latest market news with sentiment analysis and personalized feeds.',
            'template' => 'page-news.php'
        ),
        'account' => array(
            'title' => 'My Account',
            'content' => 'Manage your account settings, billing, and preferences.',
            'template' => 'page-account.php'
        ),
        'notifications' => array(
            'title' => 'Notifications',
            'content' => 'Manage your notification preferences and settings.',
            'template' => 'page-notifications.php'
        ),
        'billing-history' => array(
            'title' => 'Billing History',
            'content' => 'View your billing history and download invoices.',
            'template' => 'page-billing-history.php'
        ),
        'premium-plans' => array(
            'title' => 'Premium Plans',
            'content' => 'Choose your trading plan. From casual lookup users to professional trading firms.',
            'template' => 'page-premium-plans.php'
        ),
        'compare-plans' => array(
            'title' => 'Compare Plans',
            'content' => 'Side-by-side comparison of our pricing plans and features.',
            'template' => 'page-compare-plans.php'
        ),
        'contact' => array(
            'title' => 'Contact Us',
            'content' => 'Get in touch with our support team for assistance.',
            'template' => 'page-contact.php'
        ),
        'signup' => array(
            'title' => 'Sign Up',
            'content' => 'Create your Retail Trade Scanner account and start trading.',
            'template' => 'page-signup.php'
        ),
        'login' => array(
            'title' => 'Login',
            'content' => 'Access your Retail Trade Scanner account.',
            'template' => 'page-login.php'
        ),
        'terms' => array(
            'title' => 'Terms of Service',
            'content' => 'Terms and conditions for using Retail Trade Scanner services.',
            'template' => 'page-terms.php'
        ),
        'privacy' => array(
            'title' => 'Privacy Policy',
            'content' => 'Our commitment to protecting your privacy and data.',
            'template' => 'page-privacy.php'
        ),
        'about' => array(
            'title' => 'About Us',
            'content' => 'Learn more about Retail Trade Scanner and our mission.',
            'template' => 'page-about.php'
        ),
        'faq' => array(
            'title' => 'FAQ',
            'content' => 'Frequently asked questions about our platform and services.',
            'template' => 'page-faq.php'
        ),
        'status' => array(
            'title' => 'System Status',
            'content' => 'Real-time system status and performance metrics.',
            'template' => 'page-status.php'
        )
    );

    foreach ($pages as $slug => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            $page_args = array(
                'post_title'     => $page_data['title'],
                'post_content'   => $page_data['content'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_name'      => $slug,
                'comment_status' => 'closed',
                'ping_status'    => 'closed'
            );
            
            $page_id = wp_insert_post($page_args);
            
            if ($page_id && isset($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
            
            // Set front page
            if ($slug === 'home') {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $page_id);
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
}
add_action('widgets_init', 'retail_trade_scanner_widgets_init');

/**
 * REST API Endpoints for external backend integration
 */
function retail_trade_scanner_register_rest_routes() {
    register_rest_route('retail-trade-scanner/v1', '/proxy/(?P<endpoint>.*)', array(
        'methods' => array('GET', 'POST', 'PUT', 'DELETE'),
        'callback' => 'retail_trade_scanner_api_proxy',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'retail_trade_scanner_register_rest_routes');

/**
 * API Proxy to external backend
 */
function retail_trade_scanner_api_proxy($request) {
    $endpoint = $request->get_param('endpoint');
    $method = $request->get_method();
    $params = $request->get_params();
    
    // Get backend URL from options or environment
    $backend_url = defined('RETAIL_TRADE_SCANNER_API_URL') ? RETAIL_TRADE_SCANNER_API_URL : 'http://localhost:8001/api';
    
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
 * AJAX Handlers for backward compatibility
 */
function retail_trade_scanner_ajax_handler() {
    check_ajax_referer('retail_trade_scanner_nonce', 'nonce');
    
    $action_map = array(
        'stock_scanner_get_quote' => 'get_stock_quote',
        'get_major_indices' => 'get_major_indices',
        'get_market_movers' => 'get_market_movers',
        'add_to_watchlist' => 'add_to_watchlist',
        'remove_from_watchlist' => 'remove_from_watchlist',
        'get_usage_stats' => 'get_usage_stats',
        'get_formatted_portfolio_data' => 'get_portfolio_data',
        'get_formatted_watchlist_data' => 'get_watchlist_data',
        'update_user_account' => 'update_account',
        'update_user_settings' => 'update_settings',
        'change_password' => 'change_password',
        'update_payment_method' => 'update_payment',
        'get_billing_history' => 'get_billing_history',
        'update_notification_settings' => 'update_notifications',
    );
    
    $ajax_action = sanitize_text_field($_POST['ajax_action']);
    
    if (!isset($action_map[$ajax_action])) {
        wp_send_json_error('Invalid action');
        return;
    }
    
    $backend_action = $action_map[$ajax_action];
    $data = array_map('sanitize_text_field', $_POST);
    
    // Proxy to external API
    $backend_url = defined('RETAIL_TRADE_SCANNER_API_URL') ? RETAIL_TRADE_SCANNER_API_URL : 'http://localhost:8001/api';
    $api_url = trailingslashit($backend_url) . $backend_action;
    
    $response = wp_remote_post($api_url, array(
        'body' => json_encode($data),
        'headers' => array('Content-Type' => 'application/json'),
        'timeout' => 30,
    ));
    
    if (is_wp_error($response)) {
        wp_send_json_error($response->get_error_message());
        return;
    }
    
    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);
    
    wp_send_json_success($result);
}

// Register AJAX handlers
$ajax_actions = array(
    'stock_scanner_get_quote', 'get_major_indices', 'get_market_movers',
    'add_to_watchlist', 'remove_from_watchlist', 'get_usage_stats',
    'get_formatted_portfolio_data', 'get_formatted_watchlist_data',
    'update_user_account', 'update_user_settings', 'change_password',
    'update_payment_method', 'get_billing_history', 'update_notification_settings'
);

foreach ($ajax_actions as $action) {
    add_action("wp_ajax_$action", 'retail_trade_scanner_ajax_handler');
    add_action("wp_ajax_nopriv_$action", 'retail_trade_scanner_ajax_handler');
}

/**
 * Add theme customization options
 */
function retail_trade_scanner_customize_register($wp_customize) {
    // Add section
    $wp_customize->add_section('retail_trade_scanner_options', array(
        'title' => __('Retail Trade Scanner Options', 'retail-trade-scanner'),
        'priority' => 30,
    ));
    
    // Add API endpoint setting
    $wp_customize->add_setting('retail_trade_scanner_api_endpoint', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('retail_trade_scanner_api_endpoint', array(
        'label' => __('API Endpoint URL', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_options',
        'type' => 'url',
    ));
}
add_action('customize_register', 'retail_trade_scanner_customize_register');

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
 * Create assets directory and main.js if they don't exist
 */
function retail_trade_scanner_ensure_assets() {
    $assets_dir = get_template_directory() . '/assets/js/';
    
    if (!is_dir($assets_dir)) {
        wp_mkdir_p($assets_dir);
    }
    
    $main_js_file = $assets_dir . 'main.js';
    if (!file_exists($main_js_file)) {
        $js_content = '
// Retail Trade Scanner - Main JavaScript
document.addEventListener("DOMContentLoaded", function() {
    // Initialize search bar expansion
    const searchInput = document.querySelector(".search-input");
    if (searchInput) {
        searchInput.addEventListener("focus", function() {
            this.classList.add("expanded");
        });
        
        searchInput.addEventListener("blur", function() {
            if (!this.value) {
                this.classList.remove("expanded");
            }
        });
    }
    
    // Initialize React app if React root exists
    if (document.getElementById("react-root")) {
        console.log("React integration ready");
    }
});
';
        file_put_contents($main_js_file, $js_content);
    }
}
add_action('after_setup_theme', 'retail_trade_scanner_ensure_assets');