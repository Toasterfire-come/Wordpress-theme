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
    // Enqueue theme stylesheet
    wp_enqueue_style('retail-trade-scanner-style', get_stylesheet_uri(), array(), '2.1.0');
    
    // Check if plugin is active before enqueueing PayPal SDK
    if (get_option('stock_scanner_api_url') || get_option('retail_trade_scanner_paypal_client_id')) {
        // Get PayPal Client ID from plugin or theme options
        $paypal_client_id = get_option('paypal_client_id', get_option('retail_trade_scanner_paypal_client_id', ''));
        
        if ($paypal_client_id) {
            wp_enqueue_script('paypal-sdk', 'https://www.paypal.com/sdk/js?client-id=' . $paypal_client_id, array(), '2.1.0', true);
        }
    }
    
    // Enqueue custom JavaScript
    wp_enqueue_script('retail-trade-scanner-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '2.1.0', true);
    
    // Get backend URL from plugin first, then theme options
    $backend_url = get_option('stock_scanner_api_url', 
                   get_option('retail_trade_scanner_api_endpoint',
                   defined('RETAIL_TRADE_SCANNER_API_URL') ? RETAIL_TRADE_SCANNER_API_URL : 'https://api.retailtradescanner.com/api/'));
    
    // Localize script for AJAX and REST API - Compatible with Plugin
    wp_localize_script('retail-trade-scanner-script', 'retail_trade_scanner_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'rest_url' => rest_url('retail-trade-scanner/v1/'),
        'nonce' => wp_create_nonce('retail_trade_scanner_nonce'),
        'backend_url' => rtrim($backend_url, '/'),
        'paypal_client_id' => $paypal_client_id,
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
        'plugin_active' => class_exists('StockScannerIntegration')
    ));

    // Add stock scanner AJAX if plugin is active
    if (class_exists('StockScannerIntegration')) {
        wp_localize_script('retail-trade-scanner-script', 'stock_scanner_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('stock_scanner_nonce')
        ));
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
        'email-stock-lists' => array(
            'title' => 'Email Stock Lists',
            'content' => '<p>Our email stock lists will keep you informed and up to date on the changing market.</p>

[stock_scanner symbol="TSLA" show_details="true"]
[stock_scanner symbol="NVDA" show_details="true"]

<h5>Frequently asked questions</h5>
<details>
<summary>Why am I not able to access all of the stock lists?</summary>
<p>If you are subscribed to the bronze or silver plan, you may have limited access. Upgrade your plan for full access.</p>
</details>',
            'template' => 'page-email-stock-lists.php'
        ),
        'all-stock-lists' => array(
            'title' => 'All Stock Alerts', 
            'content' => '<h2>Complete Stock Alert Lists</h2>

[stock_scanner symbol="AAPL" show_chart="true" show_details="true"]
[stock_scanner symbol="GOOGL" show_chart="true" show_details="true"]
[stock_scanner symbol="MSFT" show_chart="true" show_details="true"]

<div class="upgrade-notice">
<h4>🚀 Upgrade for Full Access</h4>
<p>Get unlimited access to all stock lists with our premium plans!</p>
<a href="/premium-plans/" class="btn btn-primary">View Premium Plans</a>
</div>',
            'template' => 'page-all-stock-lists.php'
        ),
        'popular-stock-lists' => array(
            'title' => 'Popular Stock Lists',
            'content' => '<h2>Most Popular Stock Lists</h2>

[stock_scanner symbol="AAPL" show_chart="true" show_details="true"]
[stock_scanner symbol="MSFT" show_chart="true" show_details="true"]
[stock_scanner symbol="GOOGL" show_chart="true" show_details="true"]

<p style="text-align: center; margin: 30px 0;">
<a href="/email-stock-lists/" class="btn btn-primary">Browse All Lists</a>
</p>',
            'template' => 'page-popular-stock-lists.php'
        ),
        'stock-search' => array(
            'title' => 'Stock Search',
            'content' => '<h2>Advanced Stock Search</h2>

[stock_scanner symbol="SPY" show_chart="true" show_details="true"]
[stock_scanner symbol="QQQ" show_chart="true" show_details="true"]

<div class="pro-search-notice">
<h4>🎯 Pro Search Features</h4>
<ul>
<li>Advanced filtering options</li>
<li>Technical indicator screening</li>
<li>Custom alerts setup</li>
</ul>
<a href="/premium-plans/">Upgrade to unlock advanced search features</a>
</div>',
            'template' => 'page-stock-search.php'
        ),
        'personalized-stock-finder' => array(
            'title' => 'Personalized Stock Finder',
            'content' => '<h2>Your Personalized Stock Finder</h2>

[stock_scanner symbol="AAPL" show_chart="true" show_details="true"]
[stock_scanner symbol="MSFT" show_chart="true" show_details="true"]

<div class="personalized-upgrade">
<h4>🚀 Get Personalized Recommendations</h4>
<p>Our AI analyzes your preferences and market conditions to suggest the best stocks for your portfolio.</p>
<a href="/premium-plans/" class="btn btn-primary">Start Your Analysis</a>
</div>',
            'template' => 'page-personalized-stock-finder.php'
        ),
        'news-scrapper' => array(
            'title' => 'News Scrapper',
            'content' => '<h2>Financial News Scraper</h2>

[stock_scanner symbol="SPY" show_chart="true" show_details="true"]
[stock_scanner symbol="QQQ" show_chart="true" show_details="true"]

<div class="news-features">
<h4>📊 Real-Time Updates</h4>
<p>Our news scraper monitors hundreds of financial news sources to bring you the most relevant information.</p>
</div>',
            'template' => 'page-news-scrapper.php'
        ),
        'filter-and-scrapper-pages' => array(
            'title' => 'Filter and Scrapper Pages',
            'content' => '<h2>Advanced Filtering & Data Scraping</h2>

[stock_scanner symbol="AAPL" show_chart="true" show_details="true"]
[stock_scanner symbol="MSFT" show_chart="true" show_details="true"]

<div class="filtering-tools">
<h4>📈 Technical Filters</h4>
<ul>
<li>Price movements</li>
<li>Volume analysis</li>
<li>RSI indicators</li>
<li>Moving averages</li>
</ul>
</div>',
            'template' => 'page-filter-and-scrapper-pages.php'
        ),
        'membership-account' => array(
            'title' => 'Membership Account',
            'content' => '<h2>Your Membership Account</h2>

[stock_scanner symbol="AAPL" show_details="true"]

<div class="account-overview">
<h4>Current Plan</h4>
<p>Your current membership level and benefits will be displayed here.</p>
</div>',
            'template' => 'page-membership-account.php'
        ),
        'membership-billing' => array(
            'title' => 'Membership Billing',
            'content' => '<h2>Billing Information</h2>

[stock_scanner symbol="MSFT" show_details="true"]

<div class="billing-info">
<h4>💳 Payment Methods</h4>
<p>View your billing history and manage payment methods.</p>
</div>',
            'template' => 'page-membership-billing.php'
        ),
        'membership-cancel' => array(
            'title' => 'Membership Cancel',
            'content' => '<h2>Cancel Membership</h2>

[stock_scanner symbol="TSLA" show_details="true"]

<div class="cancel-info">
<p>We\'re sorry to see you go. Cancel your membership here.</p>
</div>',
            'template' => 'page-membership-cancel.php'
        ),
        'membership-checkout' => array(
            'title' => 'Membership Checkout',  
            'content' => '<h2>Membership Checkout</h2>

[stock_scanner symbol="GOOGL" show_details="true"]

<div class="checkout-info">
<p>Complete your subscription purchase.</p>
</div>',
            'template' => 'page-membership-checkout.php'
        ),
        'membership-confirmation' => array(
            'title' => 'Membership Confirmation',
            'content' => '<h2>Membership Confirmation</h2>

[stock_scanner symbol="NVDA" show_details="true"]

<div class="confirmation-info">
<h4>🎉 Welcome</h4>
<p>Thank you for your purchase! Your membership is now active.</p>
</div>',
            'template' => 'page-membership-confirmation.php'
        ),
        'membership-orders' => array(
            'title' => 'Membership Orders',
            'content' => '<h2>Your Orders</h2>

[stock_scanner symbol="AMZN" show_details="true"]

<div class="orders-info">
<h4>📦 Order History</h4>
<p>View your order history and transaction details.</p>
</div>',
            'template' => 'page-membership-orders.php'
        ),
        'membership-levels' => array(
            'title' => 'Membership Levels',
            'content' => '<h2>Membership Levels</h2>

[stock_scanner symbol="SPY" show_details="true"]

<div class="levels-info">
<h4>🏆 Available Plans</h4>
<p><a href="/premium-plans/">View detailed pricing</a></p>
</div>',
            'template' => 'page-membership-levels.php'
        ),
        'login' => array(
            'title' => 'Log In',
            'content' => '<h2>Member Login</h2>

[stock_scanner symbol="AAPL" show_details="true"]

<div class="login-info">
<h4>🔐 Secure Access</h4>
<p>Sign in to access your account and premium features.</p>
<p><a href="/wp-login.php">WordPress Login</a></p>
</div>',
            'template' => 'page-login.php'
        ),
        'your-profile' => array(
            'title' => 'Your Profile', 
            'content' => '<h2>User Profile</h2>

[stock_scanner symbol="MSFT" show_details="true"]

<div class="profile-info">
<h4>👤 Profile Settings</h4>
<p>Manage your personal information and preferences.</p>
</div>',
            'template' => 'page-your-profile.php'
        ),
        'terms-and-conditions' => array(
            'title' => 'Terms and Conditions',
            'content' => '<h2>Terms and Conditions</h2>
<p><strong>Last updated:</strong> January 21, 2025</p>

[stock_scanner symbol="SPY" show_details="true"]

<h3>1. Acceptance of Terms</h3>
<p>By accessing and using Retail Trade Scanner, you accept and agree to be bound by the terms and provision of this agreement.</p>

<h3>2. Investment Disclaimer</h3>
<p><strong>Important:</strong> All content is for educational purposes only. Past performance does not guarantee future results. Trading involves risk of loss.</p>',
            'template' => 'page-terms.php'
        ),
        'privacy-policy' => array(
            'title' => 'Privacy Policy',
            'content' => '<h2>Privacy Policy</h2>
<p><strong>Last updated:</strong> January 21, 2025</p>

[stock_scanner symbol="AAPL" show_details="true"]

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
    ));
    
    $wp_customize->add_control('retail_trade_scanner_paypal_client_id', array(
        'label' => __('PayPal Client ID', 'retail-trade-scanner'),
        'section' => 'retail_trade_scanner_options',
        'type' => 'text',
        'description' => __('Your PayPal application Client ID (should match plugin setting)', 'retail-trade-scanner'),
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
// Retail Trade Scanner - Main JavaScript with Plugin Integration
document.addEventListener("DOMContentLoaded", function() {
    console.log("Retail Trade Scanner theme loaded - Plugin Active:", retail_trade_scanner_data.plugin_active);
    
    // Initialize search bar expansion
    const searchInput = document.querySelector(".search-input");
    const searchToggle = document.querySelector(".search-toggle");
    
    if (searchInput && searchToggle) {
        searchToggle.addEventListener("click", function() {
            if (searchInput.classList.contains("expanded")) {
                searchInput.classList.remove("expanded");
            } else {
                searchInput.classList.add("expanded");
                searchInput.focus();
            }
        });
        
        // Close search when clicking outside
        document.addEventListener("click", function(e) {
            if (!searchInput.contains(e.target) && !searchToggle.contains(e.target)) {
                searchInput.classList.remove("expanded");
            }
        });
    }
    
    // Upgrade button handlers for plugin integration
    const upgradeButtons = document.querySelectorAll(".upgrade-btn");
    upgradeButtons.forEach(button => {
        button.addEventListener("click", function() {
            const level = this.getAttribute("data-level");
            const price = this.getAttribute("data-price");
            
            if (retail_trade_scanner_data.plugin_active) {
                // Redirect to plugin checkout if available
                if (typeof window.pmpro_url === "function") {
                    window.location.href = window.pmpro_url("checkout", "?level=" + level);
                } else {
                    window.location.href = "/membership-account/membership-checkout/?level=" + level;
                }
            } else {
                // Show plugin required message
                showNotification("Stock Scanner Plugin required for subscription management.", "error");
            }
        });
    });
    
    // Notification function
    window.showNotification = function(message, type) {
        const notification = document.createElement("div");
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            z-index: 1000;
            max-width: 300px;
            font-weight: 500;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        `;
        
        notification.style.backgroundColor = type === "success" ? "#059669" : "#dc2626";
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    };
    
    // Stock widget refresh functionality (if plugin is active)
    if (retail_trade_scanner_data.plugin_active && typeof stock_scanner_ajax !== "undefined") {
        window.stockScanner = {
            refreshStock: function(symbol) {
                const widget = document.querySelector(`[data-symbol="${symbol}"]`);
                if (!widget) return;
                
                const loading = widget.querySelector(".loading");
                const priceDiv = widget.querySelector(".stock-price");
                
                if (loading) loading.style.display = "block";
                if (priceDiv) priceDiv.style.display = "none";
                
                jQuery.post(stock_scanner_ajax.ajax_url, {
                    action: "get_stock_data",
                    symbol: symbol,
                    nonce: stock_scanner_ajax.nonce
                }, function(response) {
                    if (response.success && response.data) {
                        const data = response.data;
                        
                        if (loading) loading.style.display = "none";
                        if (priceDiv) {
                            priceDiv.style.display = "block";
                            const price = priceDiv.querySelector(".price");
                            const change = priceDiv.querySelector(".change");
                            
                            if (price) price.textContent = "$" + data.price;
                            if (change) {
                                change.textContent = data.change;
                                change.className = "change " + (data.change.startsWith("+") ? "positive" : "negative");
                            }
                        }
                        
                        // Update details if shown
                        const details = widget.querySelector(".stock-details");
                        if (details && data.volume) {
                            details.style.display = "block";
                            const volume = details.querySelector(".volume");
                            const marketCap = details.querySelector(".market-cap");
                            
                            if (volume) volume.textContent = data.volume;
                            if (marketCap) marketCap.textContent = data.market_cap;
                        }
                    } else {
                        showNotification("Failed to refresh stock data", "error");
                        if (loading) loading.style.display = "none";
                    }
                }).fail(function() {
                    showNotification("Error connecting to stock data service", "error");
                    if (loading) loading.style.display = "none";
                });
            }
        };
    }
});
';
        file_put_contents($main_js_file, $js_content);
    }
}
add_action('after_setup_theme', 'retail_trade_scanner_ensure_assets');

/**
 * Remove WordPress admin bar for non-admin users
 */
function retail_trade_scanner_remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'retail_trade_scanner_remove_admin_bar');

/**
 * Custom login redirect
 */
function retail_trade_scanner_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        } else {
            // Redirect to membership account if available
            $account_page = get_page_by_path('membership-account');
            if ($account_page) {
                return get_permalink($account_page);
            }
            return home_url();
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'retail_trade_scanner_login_redirect', 10, 3);

/**
 * Disable WordPress emojis
 */
function retail_trade_scanner_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'retail_trade_scanner_disable_emojis');

/**
 * Security enhancements
 */
// Remove WordPress version info
remove_action('wp_head', 'wp_generator');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove unnecessary meta tags
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Performance optimizations
 */
// Remove query strings from static resources
function retail_trade_scanner_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'retail_trade_scanner_remove_query_strings', 10, 1);
add_filter('script_loader_src', 'retail_trade_scanner_remove_query_strings', 10, 1);

// Defer non-critical JavaScript
function retail_trade_scanner_defer_scripts($tag, $handle, $src) {
    $defer_scripts = array('retail-trade-scanner-script');
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace('<script ', '<script defer ', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'retail_trade_scanner_defer_scripts', 10, 3);

/**
 * Integration helper functions
 */
function retail_trade_scanner_get_membership_level() {
    if (function_exists('pmpro_getMembershipLevelForUser')) {
        $level = pmpro_getMembershipLevelForUser(get_current_user_id());
        return $level ? $level->id : 0;
    }
    return 0;
}

function retail_trade_scanner_can_user_access_feature($feature = 'stocks') {
    $level = retail_trade_scanner_get_membership_level();
    
    $limits = array(
        0 => array('stocks' => 15, 'watchlists' => 0, 'alerts' => 0),
        1 => array('stocks' => 15, 'watchlists' => 0, 'alerts' => 0),  
        2 => array('stocks' => 1000, 'watchlists' => 3, 'alerts' => 10),
        3 => array('stocks' => 5000, 'watchlists' => 10, 'alerts' => 50),
        4 => array('stocks' => 10000, 'watchlists' => -1, 'alerts' => -1)
    );
    
    return isset($limits[$level][$feature]) ? $limits[$level][$feature] : 0;
}