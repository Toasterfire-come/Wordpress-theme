<?php
/**
 * COMPLIANT Tier-Based Rate Limiting - Matches Premium Plans Page Exactly
 * Retail Trade Scanner Theme - Fixed for Compliance
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * COMPLIANT Rate Limiting System - Matches Premium Plans Page
 */
class RetailTradeScannerCompliantRateLimit {
    private static $instance = null;
    private $backend_url = '';
    
    // Define tier-based limits EXACTLY as advertised on premium plans page
    private $tier_limits = array(
        'free' => array(
            // Monthly limits as advertised
            'monthly_stock_lookups' => 15,
            'email_subscriptions' => 5,
            'watchlists' => 0,
            'historical_data_days' => 0,
            'advanced_filtering' => false,
            'api_access' => false,
            'support_level' => 'community',
            
            // Technical per-minute limits to prevent abuse
            'api_requests_per_minute' => 10, // Conservative limit for free users
            'search_requests_per_minute' => 5,
            'basic_filtering_only' => true
        ),
        'bronze' => array(
            // Monthly limits as advertised  
            'monthly_stock_lookups' => 1000,
            'email_subscriptions' => 15,
            'watchlists' => 3,
            'historical_data_days' => 30,
            'advanced_filtering' => 'basic',
            'api_access' => false,
            'support_level' => 'email',
            
            // Technical per-minute limits
            'api_requests_per_minute' => 30,
            'search_requests_per_minute' => 20,
            'news_sentiment_analysis' => true,
            'basic_portfolio_tracking' => true
        ),
        'silver' => array(
            // Monthly limits as advertised
            'monthly_stock_lookups' => 5000,
            'email_subscriptions' => 'unlimited',
            'watchlists' => 10,
            'historical_data_days' => 365, // 1 year
            'advanced_filtering' => true,
            'api_access' => 'limited',
            'support_level' => 'priority',
            
            // Technical per-minute limits
            'api_requests_per_minute' => 60,
            'search_requests_per_minute' => 40,
            'advanced_screening' => true,
            'priority_support' => true
        ),
        'gold' => array(
            // Monthly limits as advertised
            'monthly_stock_lookups' => 10000,
            'email_subscriptions' => 'unlimited',
            'watchlists' => 'unlimited',
            'historical_data_days' => 1825, // 5 years
            'advanced_filtering' => true,
            'api_access' => 'full',
            'support_level' => 'phone_manager',
            
            // Technical per-minute limits
            'api_requests_per_minute' => 100,
            'search_requests_per_minute' => 80,
            'real_time_alerts' => true,
            'full_rest_api' => true,
            'priority_phone_support' => true
        )
        // Note: Removed Platinum tier - not advertised on premium plans page
    );
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->backend_url = get_option('retail_trade_scanner_api_endpoint', 
                           get_option('stock_scanner_api_url', 
                           'https://api.retailtradescanner.com'));
    }
    
    /**
     * Check both monthly and per-minute limits as per premium plans
     */
    public function check_compliant_rate_limit($user_id, $action, $custom_limit = null) {
        if (!$user_id) {
            // For non-logged-in users, use IP-based limiting with free tier limits
            return $this->check_ip_rate_limit($_SERVER['REMOTE_ADDR'], $action, 'free');
        }
        
        // Get user tier from backend
        $user_tier = $this->get_user_tier($user_id);
        
        if (!$user_tier || !isset($this->tier_limits[$user_tier])) {
            // If we can't verify tier, default to free tier limits
            $user_tier = 'free';
        }
        
        // Check monthly limits first (as advertised on premium plans)
        $monthly_check = $this->check_monthly_limit($user_id, $user_tier, $action);
        if (!$monthly_check['allowed']) {
            return $monthly_check;
        }
        
        // Check feature access based on tier
        if (!$this->has_tier_access($user_tier, $action)) {
            return array(
                'allowed' => false,
                'reason' => 'upgrade_required',
                'message' => $this->get_upgrade_message($action, $user_tier),
                'current_tier' => $user_tier,
                'required_tier' => $this->get_required_tier($action),
                'upgrade_url' => get_permalink(get_page_by_path('premium-plans'))
            );
        }
        
        // Check per-minute limits to prevent abuse
        $minute_check = $this->check_per_minute_limit($user_id, $user_tier, $action);
        if (!$minute_check['allowed']) {
            return $minute_check;
        }
        
        return array(
            'allowed' => true,
            'monthly_remaining' => $monthly_check['remaining'],
            'minute_remaining' => $minute_check['remaining'],
            'tier' => $user_tier,
            'reset_time' => time() + 60
        );
    }
    
    /**
     * Check monthly stock lookup limits as advertised
     */
    private function check_monthly_limit($user_id, $tier, $action) {
        // Only apply monthly limits to stock lookup actions
        if (!in_array($action, array('stock_lookup', 'stock_search', 'stock_detail'))) {
            return array('allowed' => true, 'remaining' => 999999);
        }
        
        $monthly_limit = $this->tier_limits[$tier]['monthly_stock_lookups'];
        
        // Get current month usage
        $current_month = date('Y-m');
        $usage_key = "monthly_stock_usage_{$user_id}_{$current_month}";
        $current_usage = get_option($usage_key, 0);
        
        if ($current_usage >= $monthly_limit) {
            return array(
                'allowed' => false,
                'reason' => 'monthly_limit_exceeded',
                'message' => sprintf(
                    __('Monthly stock lookup limit reached (%d/%d). Upgrade your plan for more lookups.', 'retail-trade-scanner'),
                    $current_usage,
                    $monthly_limit
                ),
                'current_usage' => $current_usage,
                'monthly_limit' => $monthly_limit,
                'tier' => $tier,
                'upgrade_url' => get_permalink(get_page_by_path('premium-plans'))
            );
        }
        
        // Increment usage
        update_option($usage_key, $current_usage + 1);
        
        return array(
            'allowed' => true,
            'remaining' => $monthly_limit - ($current_usage + 1)
        );
    }
    
    /**
     * Check per-minute limits to prevent system abuse
     */
    private function check_per_minute_limit($user_id, $tier, $action) {
        $minute_limit = $this->get_per_minute_limit($tier, $action);
        
        if ($minute_limit === 0) {
            return array('allowed' => true, 'remaining' => 999999);
        }
        
        $cache_key = "minute_rate_limit_{$user_id}_{$action}";
        $current_count = wp_cache_get($cache_key);
        
        if ($current_count === false) {
            wp_cache_set($cache_key, 1, '', 60); // 60 seconds
            return array(
                'allowed' => true,
                'remaining' => $minute_limit - 1
            );
        }
        
        if ($current_count >= $minute_limit) {
            return array(
                'allowed' => false,
                'reason' => 'minute_rate_limit_exceeded',
                'message' => sprintf(
                    __('Too many requests per minute. Please wait before trying again.', 'retail-trade-scanner')
                ),
                'current_count' => $current_count,
                'limit' => $minute_limit,
                'reset_time' => time() + 60,
                'tier' => $tier
            );
        }
        
        wp_cache_set($cache_key, $current_count + 1, '', 60);
        
        return array(
            'allowed' => true,
            'remaining' => $minute_limit - ($current_count + 1)
        );
    }
    
    /**
     * Get per-minute limit for action based on tier
     */
    private function get_per_minute_limit($tier, $action) {
        $action_mapping = array(
            'stock_lookup' => 'api_requests_per_minute',
            'stock_search' => 'search_requests_per_minute',
            'stock_detail' => 'api_requests_per_minute',
            'market_data' => 'api_requests_per_minute',
            'news' => 'api_requests_per_minute'
        );
        
        $limit_key = $action_mapping[$action] ?? 'api_requests_per_minute';
        return $this->tier_limits[$tier][$limit_key] ?? 0;
    }
    
    /**
     * Check if user tier has access to specific feature
     */
    private function has_tier_access($tier, $action) {
        $tier_config = $this->tier_limits[$tier];
        
        switch ($action) {
            case 'advanced_filtering':
                return $tier_config['advanced_filtering'] !== false;
            
            case 'api_access':
                return $tier_config['api_access'] !== false;
            
            case 'historical_data':
                return $tier_config['historical_data_days'] > 0;
            
            case 'watchlist_create':
                $max_watchlists = $tier_config['watchlists'];
                if ($max_watchlists === 'unlimited') return true;
                if ($max_watchlists === 0) return false;
                
                // Check current watchlist count
                $user_id = get_current_user_id();
                $current_watchlists = get_user_meta($user_id, 'watchlist_count', true) ?: 0;
                return $current_watchlists < $max_watchlists;
            
            case 'email_subscription':
                $max_subscriptions = $tier_config['email_subscriptions'];
                if ($max_subscriptions === 'unlimited') return true;
                if ($max_subscriptions === 0) return false;
                
                // Check current subscription count
                $user_id = get_current_user_id();
                $current_subs = get_user_meta($user_id, 'email_subscription_count', true) ?: 0;
                return $current_subs < $max_subscriptions;
            
            case 'news_sentiment':
                return isset($tier_config['news_sentiment_analysis']) && $tier_config['news_sentiment_analysis'];
            
            case 'portfolio_tracking':
                return isset($tier_config['basic_portfolio_tracking']) && $tier_config['basic_portfolio_tracking'];
            
            case 'real_time_alerts':
                return isset($tier_config['real_time_alerts']) && $tier_config['real_time_alerts'];
            
            default:
                return true; // Allow basic actions for all tiers
        }
    }
    
    /**
     * Get user subscription tier from Django backend (same as before)
     */
    private function get_user_tier($user_id) {
        // Try cache first
        $cache_key = "user_tier_{$user_id}";
        $cached_tier = wp_cache_get($cache_key);
        
        if ($cached_tier !== false) {
            return $cached_tier;
        }
        
        // Get WordPress user email for backend lookup
        $user = get_user_by('ID', $user_id);
        if (!$user) {
            return 'free';
        }
        
        // Call Django backend to verify subscription
        $response = wp_remote_post(
            rtrim($this->backend_url, '/') . '/api/users/subscription-status/',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->get_backend_token($user_id),
                    'Content-Type' => 'application/json',
                ),
                'body' => json_encode(array(
                    'email' => $user->user_email,
                    'wordpress_user_id' => $user_id
                )),
                'timeout' => 10,
                'method' => 'POST'
            )
        );
        
        if (is_wp_error($response)) {
            // If backend is unavailable, check WordPress user meta as fallback
            $fallback_tier = get_user_meta($user_id, 'subscription_tier', true);
            return $fallback_tier ?: 'free';
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if ($data && isset($data['subscription_tier'])) {
            $tier = sanitize_text_field($data['subscription_tier']);
            
            // Validate tier exists in our system (no platinum allowed)
            if (!array_key_exists($tier, $this->tier_limits)) {
                $tier = 'free';
            }
            
            // Cache for 5 minutes
            wp_cache_set($cache_key, $tier, '', 300);
            
            // Also update WordPress user meta as backup
            update_user_meta($user_id, 'subscription_tier', $tier);
            update_user_meta($user_id, 'subscription_verified', time());
            
            return $tier;
        }
        
        // Default to free if verification fails
        return 'free';
    }
    
    /**
     * Get backend authentication token for user
     */
    private function get_backend_token($user_id) {
        // Try to get stored token
        $token = get_user_meta($user_id, 'backend_auth_token', true);
        
        if ($token && $this->is_token_valid($token)) {
            return $token;
        }
        
        // Generate new token by authenticating with backend
        $user = get_user_by('ID', $user_id);
        if (!$user) {
            return false;
        }
        
        $response = wp_remote_post(
            rtrim($this->backend_url, '/') . '/api/auth/wordpress-token/',
            array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                ),
                'body' => json_encode(array(
                    'wordpress_user_id' => $user_id,
                    'email' => $user->user_email,
                    'username' => $user->user_login,
                    'wp_nonce' => wp_create_nonce('backend_auth_' . $user_id)
                )),
                'timeout' => 15
            )
        );
        
        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            
            if ($data && isset($data['token'])) {
                $token = sanitize_text_field($data['token']);
                update_user_meta($user_id, 'backend_auth_token', $token);
                update_user_meta($user_id, 'token_expires', time() + (24 * 60 * 60)); // 24 hours
                return $token;
            }
        }
        
        return false;
    }
    
    /**
     * Check if authentication token is still valid
     */
    private function is_token_valid($token) {
        $expires = get_user_meta(get_current_user_id(), 'token_expires', true);
        return $expires && time() < $expires;
    }
    
    /**
     * Get upgrade message for blocked features
     */
    private function get_upgrade_message($action, $current_tier) {
        $feature_names = array(
            'advanced_filtering' => 'Advanced Filtering & Screening',
            'api_access' => 'API Access',
            'historical_data' => 'Historical Data',
            'watchlist_create' => 'Custom Watchlists',
            'email_subscription' => 'Email Subscriptions',
            'news_sentiment' => 'News Sentiment Analysis',
            'portfolio_tracking' => 'Portfolio Tracking',
            'real_time_alerts' => 'Real-time Alerts'
        );
        
        $feature_name = $feature_names[$action] ?? $action;
        $required_tier = $this->get_required_tier($action);
        
        return sprintf(
            __('%s requires %s plan or higher. You are currently on %s plan. Please upgrade to continue.', 'retail-trade-scanner'),
            $feature_name,
            ucfirst($required_tier),
            ucfirst($current_tier)
        );
    }
    
    /**
     * Get minimum required tier for feature
     */
    private function get_required_tier($action) {
        switch ($action) {
            case 'advanced_filtering':
                return 'bronze'; // Basic filtering available in bronze
            case 'api_access':
                return 'silver'; // Limited API access starts in silver
            case 'historical_data':
                return 'bronze'; // 30-day data in bronze
            case 'watchlist_create':
                return 'bronze'; // 3 watchlists in bronze
            case 'email_subscription':
                return 'bronze'; // 15 subscriptions in bronze
            case 'news_sentiment':
                return 'bronze'; // Available in bronze
            case 'portfolio_tracking':
                return 'bronze'; // Basic tracking in bronze
            case 'real_time_alerts':
                return 'gold'; // Premium feature in gold
            default:
                return 'bronze';
        }
    }
    
    /**
     * Get user's current usage statistics - COMPLIANT VERSION
     */
    public function get_compliant_usage_stats($user_id) {
        $tier = $this->get_user_tier($user_id);
        $tier_config = $this->tier_limits[$tier];
        $stats = array();
        
        // Monthly stock lookups
        $current_month = date('Y-m');
        $monthly_usage = get_option("monthly_stock_usage_{$user_id}_{$current_month}", 0);
        $stats['monthly_stock_lookups'] = array(
            'used' => $monthly_usage,
            'limit' => $tier_config['monthly_stock_lookups'],
            'remaining' => max(0, $tier_config['monthly_stock_lookups'] - $monthly_usage),
            'percentage' => $tier_config['monthly_stock_lookups'] > 0 ? 
                round(($monthly_usage / $tier_config['monthly_stock_lookups']) * 100, 1) : 0
        );
        
        // Email subscriptions
        $email_subs = get_user_meta($user_id, 'email_subscription_count', true) ?: 0;
        $email_limit = $tier_config['email_subscriptions'];
        $stats['email_subscriptions'] = array(
            'used' => $email_subs,
            'limit' => $email_limit === 'unlimited' ? 'unlimited' : $email_limit,
            'remaining' => $email_limit === 'unlimited' ? 'unlimited' : max(0, $email_limit - $email_subs),
            'percentage' => $email_limit === 'unlimited' ? 0 : 
                ($email_limit > 0 ? round(($email_subs / $email_limit) * 100, 1) : 0)
        );
        
        // Watchlists
        $watchlists = get_user_meta($user_id, 'watchlist_count', true) ?: 0;
        $watchlist_limit = $tier_config['watchlists'];
        $stats['watchlists'] = array(
            'used' => $watchlists,
            'limit' => $watchlist_limit === 'unlimited' ? 'unlimited' : $watchlist_limit,
            'remaining' => $watchlist_limit === 'unlimited' ? 'unlimited' : max(0, $watchlist_limit - $watchlists),
            'percentage' => $watchlist_limit === 'unlimited' ? 0 :
                ($watchlist_limit > 0 ? round(($watchlists / $watchlist_limit) * 100, 1) : 0)
        );
        
        return array(
            'tier' => $tier,
            'usage' => $stats,
            'features' => array(
                'advanced_filtering' => $tier_config['advanced_filtering'],
                'api_access' => $tier_config['api_access'],
                'historical_data_days' => $tier_config['historical_data_days'],
                'support_level' => $tier_config['support_level']
            ),
            'reset_time' => strtotime('first day of next month')
        );
    }
    
    /**
     * IP-based rate limiting for non-logged-in users
     */
    private function check_ip_rate_limit($ip, $action, $tier = 'free') {
        $limit = $this->get_per_minute_limit($tier, $action);
        $cache_key = "ip_rate_limit_{$ip}_{$action}";
        $current_count = wp_cache_get($cache_key);
        
        if ($current_count === false) {
            wp_cache_set($cache_key, 1, '', 60);
            return array(
                'allowed' => true,
                'remaining' => $limit - 1,
                'reset_time' => time() + 60,
                'tier' => $tier
            );
        }
        
        if ($current_count >= $limit) {
            return array(
                'allowed' => false,
                'reason' => 'rate_limit_exceeded',
                'message' => sprintf(
                    __('Rate limit exceeded. Please sign up for higher limits or wait %d seconds.', 'retail-trade-scanner'),
                    60
                ),
                'current_count' => $current_count,
                'limit' => $limit,
                'reset_time' => time() + 60,
                'tier' => $tier
            );
        }
        
        wp_cache_set($cache_key, $current_count + 1, '', 60);
        
        return array(
            'allowed' => true,
            'remaining' => $limit - ($current_count + 1),
            'reset_time' => time() + 60,
            'tier' => $tier
        );
    }
}

/**
 * COMPLIANT API proxy handler 
 */
function retail_trade_scanner_compliant_proxy_handler($request) {
    $endpoint = $request->get_param('endpoint');
    $method = $request->get_method();
    $user_id = get_current_user_id();
    
    // Initialize compliant rate limiter
    $rate_limiter = RetailTradeScannerCompliantRateLimit::getInstance();
    
    // Map endpoint to action type for rate limiting
    $action = retail_trade_scanner_map_endpoint_to_compliant_action($endpoint);
    
    // Check compliant rate limits
    $rate_check = $rate_limiter->check_compliant_rate_limit($user_id, $action);
    
    if (!$rate_check['allowed']) {
        $error_code = $rate_check['reason'] === 'upgrade_required' ? 402 : 
                     ($rate_check['reason'] === 'monthly_limit_exceeded' ? 402 : 429);
        
        return new WP_Error(
            $rate_check['reason'],
            $rate_check['message'],
            array(
                'status' => $error_code,
                'rate_limit_info' => array(
                    'current_tier' => $rate_check['tier'] ?? 'free',
                    'required_tier' => $rate_check['required_tier'] ?? null,
                    'reset_time' => $rate_check['reset_time'] ?? null,
                    'upgrade_url' => $rate_check['upgrade_url'] ?? get_permalink(get_page_by_path('premium-plans'))
                )
            )
        );
    }
    
    // Continue with Django API call...
    $backend_url = get_option('retail_trade_scanner_api_endpoint', 'https://api.retailtradescanner.com');
    
    if (strpos($endpoint, 'api/') !== 0) {
        $endpoint = 'api/' . ltrim($endpoint, '/');
    }
    
    $full_url = rtrim($backend_url, '/') . '/' . ltrim($endpoint, '/');
    
    $args = array(
        'method' => $method,
        'timeout' => 30,
        'headers' => array(
            'Content-Type' => 'application/json',
            'User-Agent' => 'Retail-Trade-Scanner-Theme/2.3.0',
            'Accept' => 'application/json',
        ),
    );
    
    // Add authentication for logged-in users
    if ($user_id) {
        $token = $rate_limiter->get_backend_token($user_id);
        if ($token) {
            $args['headers']['Authorization'] = 'Bearer ' . $token;
        }
    }
    
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
        unset($query_params['rest_route']);
        if (!empty($query_params)) {
            $full_url .= '?' . http_build_query($query_params);
        }
    }
    
    $response = wp_remote_request($full_url, $args);
    
    if (is_wp_error($response)) {
        return new WP_Error('api_error', $response->get_error_message(), array('status' => 500));
    }
    
    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);
    
    // Add compliant rate limit headers to response
    $response_headers = array(
        'X-Monthly-Remaining' => $rate_check['monthly_remaining'] ?? 'N/A',
        'X-Minute-Remaining' => $rate_check['minute_remaining'] ?? 'N/A',
        'X-User-Tier' => $rate_check['tier']
    );
    
    $decoded_body = json_decode($response_body, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $rest_response = new WP_REST_Response($decoded_body, $response_code);
        foreach ($response_headers as $header => $value) {
            $rest_response->header($header, $value);
        }
        return $rest_response;
    }
    
    $rest_response = new WP_REST_Response($response_body, $response_code);
    foreach ($response_headers as $header => $value) {
        $rest_response->header($header, $value);
    }
    return $rest_response;
}

/**
 * Map API endpoint to compliant action
 */
function retail_trade_scanner_map_endpoint_to_compliant_action($endpoint) {
    $mapping = array(
        'stocks/search' => 'stock_search',
        'stocks/' => 'stock_lookup',
        'market/stats' => 'market_data',
        'news' => 'news',
        'portfolio' => 'portfolio_tracking',
        'alerts' => 'real_time_alerts',
        'historical' => 'historical_data',
        'advanced-filter' => 'advanced_filtering'
    );
    
    foreach ($mapping as $pattern => $action) {
        if (strpos($endpoint, $pattern) !== false) {
            return $action;
        }
    }
    
    return 'stock_lookup'; // Default action
}

/**
 * AJAX handler for getting compliant usage statistics
 */
function retail_trade_scanner_get_compliant_usage_stats() {
    check_ajax_referer('retail_trade_scanner_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }
    
    $user_id = get_current_user_id();
    $rate_limiter = RetailTradeScannerCompliantRateLimit::getInstance();
    $stats = $rate_limiter->get_compliant_usage_stats($user_id);
    
    wp_send_json_success($stats);
}
add_action('wp_ajax_retail_trade_scanner_get_compliant_usage_stats', 'retail_trade_scanner_get_compliant_usage_stats');

// Update the REST API route to use the compliant handler
function retail_trade_scanner_register_compliant_rest_routes() {
    register_rest_route('retail-trade-scanner/v1', '/proxy/(?P<endpoint>.*)', array(
        'methods' => array('GET', 'POST', 'PUT', 'DELETE'),
        'callback' => 'retail_trade_scanner_compliant_proxy_handler',
        'permission_callback' => '__return_true', // We handle permissions in the handler
        'args' => array(
            'endpoint' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));
}
add_action('rest_api_init', 'retail_trade_scanner_register_compliant_rest_routes');