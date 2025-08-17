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
function stock_scanner_setup() {
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
add_action('after_setup_theme', 'stock_scanner_setup');

/**
 * Enqueue scripts and styles
 */
function stock_scanner_scripts() {
    wp_enqueue_style('stock-scanner-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue custom JavaScript if needed
    wp_enqueue_script('stock-scanner-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('stock-scanner-script', 'stock_scanner_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('stock_scanner_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'stock_scanner_scripts');

/**
 * Create required pages on theme activation
 */
function stock_scanner_create_pages() {
    $pages = array(
        'home' => array(
            'title' => 'Home',
            'content' => 'Welcome to Stock Scanner Pro - Professional stock analysis and portfolio management platform.',
            'template' => 'page-home.php'
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
        'contact' => array(
            'title' => 'Contact Us',
            'content' => 'Get in touch with our support team for assistance.',
            'template' => 'page-contact.php'
        ),
        'signup' => array(
            'title' => 'Sign Up',
            'content' => 'Create your Stock Scanner Pro account and start trading.',
            'template' => 'page-signup.php'
        ),
        'login' => array(
            'title' => 'Login',
            'content' => 'Access your Stock Scanner Pro account.',
            'template' => 'page-login.php'
        ),
        'checkout' => array(
            'title' => 'Checkout',
            'content' => 'Complete your subscription purchase securely.',
            'template' => 'page-checkout.php'
        ),
        'terms' => array(
            'title' => 'Terms of Service',
            'content' => 'Terms and conditions for using Stock Scanner Pro services.',
            'template' => 'page-terms.php'
        ),
        'privacy' => array(
            'title' => 'Privacy Policy',
            'content' => 'Our commitment to protecting your privacy and data.',
            'template' => 'page-privacy.php'
        ),
        'about' => array(
            'title' => 'About Us',
            'content' => 'Learn more about Stock Scanner Pro and our mission.',
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
function stock_scanner_activate() {
    stock_scanner_create_pages();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'stock_scanner_activate');

/**
 * Add custom body classes
 */
function stock_scanner_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    if (is_page_template()) {
        $template = get_page_template_slug();
        $classes[] = 'page-template-' . sanitize_html_class(str_replace('.php', '', $template));
    }
    
    return $classes;
}
add_filter('body_class', 'stock_scanner_body_classes');

/**
 * Customize excerpt length
 */
function stock_scanner_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'stock_scanner_excerpt_length');

/**
 * Customize excerpt more
 */
function stock_scanner_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'stock_scanner_excerpt_more');

/**
 * Register widget areas
 */
function stock_scanner_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widgets', 'stock-scanner-pro'),
        'id'            => 'footer-widgets',
        'description'   => __('Add widgets here to appear in the footer.', 'stock-scanner-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'stock_scanner_widgets_init');

/**
 * AJAX handler for stock data (example)
 */
function stock_scanner_get_stock_data() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'stock_scanner_nonce')) {
        wp_die('Security check failed');
    }
    
    $symbol = sanitize_text_field($_POST['symbol']);
    
    // Mock stock data response
    $response = array(
        'success' => true,
        'data' => array(
            'symbol' => $symbol,
            'price' => 125.50,
            'change' => 2.25,
            'change_percent' => 1.83,
            'volume' => 1234567
        )
    );
    
    wp_send_json($response);
}
add_action('wp_ajax_stock_scanner_get_stock_data', 'stock_scanner_get_stock_data');
add_action('wp_ajax_nopriv_stock_scanner_get_stock_data', 'stock_scanner_get_stock_data');

/**
 * Add theme customization options
 */
function stock_scanner_customize_register($wp_customize) {
    // Add section
    $wp_customize->add_section('stock_scanner_options', array(
        'title' => __('Stock Scanner Options', 'stock-scanner-pro'),
        'priority' => 30,
    ));
    
    // Add API endpoint setting
    $wp_customize->add_setting('stock_scanner_api_endpoint', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('stock_scanner_api_endpoint', array(
        'label' => __('API Endpoint URL', 'stock-scanner-pro'),
        'section' => 'stock_scanner_options',
        'type' => 'url',
    ));
    
    // Add contact email setting
    $wp_customize->add_setting('stock_scanner_contact_email', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('stock_scanner_contact_email', array(
        'label' => __('Contact Email', 'stock-scanner-pro'),
        'section' => 'stock_scanner_options',
        'type' => 'email',
    ));
}
add_action('customize_register', 'stock_scanner_customize_register');

/**
 * Add admin notice for theme activation
 */
function stock_scanner_admin_notice() {
    if (get_transient('stock_scanner_activated')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Stock Scanner Pro theme activated! All required pages have been created automatically.', 'stock-scanner-pro'); ?></p>
        </div>
        <?php
        delete_transient('stock_scanner_activated');
    }
}
add_action('admin_notices', 'stock_scanner_admin_notice');

/**
 * Set transient on theme activation
 */
function stock_scanner_set_activation_transient() {
    set_transient('stock_scanner_activated', true, 30);
}
add_action('after_switch_theme', 'stock_scanner_set_activation_transient');