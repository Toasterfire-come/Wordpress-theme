<?php
/**
 * Enhanced Retail Trade Scanner Theme Functions - Tier-Based Rate Limiting
 * Integrates with Django backend for user subscription validation
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enhanced Rate Limiting with User Tier Support
 */
class RetailTradeScannerTierRateLimit {
    private static $instance = null;
    private $rate_limits = array();
    private $backend_url = '';
    
    // Define tier-based rate limits (requests per minute)
    private $tier_limits = array(
        'free' => array(
            'api_requests' => 20,
            'search_requests' => 10,
            'market_data' => 5,
            'news_requests' => 5,
            'portfolio_access' => 3,
            'real_time_data' => 0, // No real-time for free users
            'alerts' => 2,
            'export_data' => 0 // No exports for free users
        ),
        'bronze' => array(
            'api_requests' => 100,
            'search_requests' => 50,
            'market_data' => 30,
            'news_requests' => 25,
            'portfolio_access' => 20,
            'real_time_data' => 10,
            'alerts' => 10,
            'export_data' => 5
        ),
        'silver' => array(
            'api_requests' => 300,
            'search_requests' => 150,
            'market_data' => 100,
            'news_requests' => 75,
            'portfolio_access' => 60,
            'real_time_data' => 50,
            'alerts' => 25,
            'export_data' => 15
        ),
        'gold' => array(
            'api_requests' => 1000,
            'search_requests' => 500,
            'market_data' => 300,
            'news_requests' => 200,
            'portfolio_access' => 200,
            'real_time_data' => 150,
            'alerts' => 50,
            'export_data' => 50
        ),
        'platinum' => array(
            'api_requests' => 2500,
            'search_requests' => 1000,
            'market_data' => 750,
            'news_requests' => 500,
            'portfolio_access' => 500,
            'real_time_data' => 400,
            'alerts' => 100,
            'export_data' => 100
        )
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
     * Check rate limit with tier enforcement
     */
    public function check_tier_rate_limit($user_id, $action, $custom_limit = null) {
        if (!$user_id) {
            // For non-logged-in users, use IP-based limiting with free tier limits
            return $this->check_ip_rate_limit($_SERVER['REMOTE_ADDR'], $action, 'free');
        }
        
        // Get user tier from backend
        $user_tier = $this->get_user_tier($user_id);
        
        if (!$user_tier) {
            // If we can't verify tier, default to free tier limits
            $user_tier = 'free';
        }
        
        // Check if user has access to this action based on tier
        if (!$this->has_tier_access($user_tier, $action)) {
            return array(
                'allowed' => false,
                'reason' => 'upgrade_required',
                'message' => $this->get_upgrade_message($action, $user_tier),
                'current_tier' => $user_tier,
                'required_tier' => $this->get_required_tier($action)
            );
        }
        
        // Get tier-specific limit
        $limit = $custom_limit ?: $this->get_tier_limit($user_tier, $action);
        
        // Check rate limit
        $cache_key = "tier_rate_limit_{$user_id}_{$action}";
        $current_count = wp_cache_get($cache_key);
        
        if ($current_count === false) {
            wp_cache_set($cache_key, 1, '', 60); // 60 seconds
            return array(
                'allowed' => true,
                'remaining' => $limit - 1,
                'reset_time' => time() + 60,
                'tier' => $user_tier
            );
        }
        
        if ($current_count >= $limit) {
            return array(
                'allowed' => false,
                'reason' => 'rate_limit_exceeded',
                'message' => $this->get_rate_limit_message($action, $user_tier),
                'current_count' => $current_count,
                'limit' => $limit,
                'reset_time' => time() + 60,
                'tier' => $user_tier
            );
        }
        
        wp_cache_set($cache_key, $current_count + 1, '', 60);
        
        return array(
            'allowed' => true,
            'remaining' => $limit - ($current_count + 1),
            'reset_time' => time() + 60,
            'tier' => $user_tier
        );
    }
    
    /**
     * Get user subscription tier from Django backend
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
        $response = wp_remote_get(
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
            
            // Validate tier exists in our system
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
     * Check if user tier has access to specific action
     */
    private function has_tier_access($tier, $action) {
        if (!isset($this->tier_limits[$tier])) {
            return false;
        }
        
        $limit = $this->tier_limits[$tier][$action] ?? 0;
        return $limit > 0;
    }
    
    /**
     * Get rate limit for specific tier and action
     */
    private function get_tier_limit($tier, $action) {
        return $this->tier_limits[$tier][$action] ?? 0;
    }
    
    /**
     * Get upgrade message for blocked actions
     */
    private function get_upgrade_message($action, $current_tier) {
        $action_names = array(
            'real_time_data' => 'Real-time Stock Data',
            'export_data' => 'Data Export',
            'api_requests' => 'API Requests',
            'search_requests' => 'Stock Search',
            'market_data' => 'Market Data',
            'news_requests' => 'News Access',
            'portfolio_access' => 'Portfolio Features',
            'alerts' => 'Price Alerts'
        );
        
        $action_name = $action_names[$action] ?? $action;
        $required_tier = $this->get_required_tier($action);
        
        return sprintf(
            __('%s requires %s plan or higher. You are currently on %s plan. Please upgrade to continue.', 'retail-trade-scanner'),
            $action_name,
            ucfirst($required_tier),
            ucfirst($current_tier)
        );
    }
    
    /**
     * Get minimum required tier for action
     */
    private function get_required_tier($action) {
        foreach ($this->tier_limits as $tier => $limits) {
            if (isset($limits[$action]) && $limits[$action] > 0) {
                return $tier;
            }
        }
        return 'gold'; // Default to highest tier if not found
    }
    
    /**
     * Get rate limit exceeded message
     */
    private function get_rate_limit_message($action, $tier) {
        $limit = $this->get_tier_limit($tier, $action);
        
        return sprintf(
            __('Rate limit exceeded for %s on %s plan (%d requests per minute). Please wait or upgrade for higher limits.', 'retail-trade-scanner'),
            $action,
            ucfirst($tier),
            $limit
        );
    }
    
    /**
     * IP-based rate limiting for non-logged-in users
     */
    private function check_ip_rate_limit($ip, $action, $tier = 'free') {
        $limit = $this->get_tier_limit($tier, $action);
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
    
    /**
     * Get user's current usage statistics
     */
    public function get_user_usage_stats($user_id) {
        $tier = $this->get_user_tier($user_id);
        $stats = array();
        
        foreach ($this->tier_limits[$tier] as $action => $limit) {
            $cache_key = "tier_rate_limit_{$user_id}_{$action}";
            $current_count = wp_cache_get($cache_key) ?: 0;
            
            $stats[$action] = array(
                'used' => $current_count,
                'limit' => $limit,
                'remaining' => max(0, $limit - $current_count),
                'percentage' => $limit > 0 ? round(($current_count / $limit) * 100, 1) : 0
            );
        }
        
        return array(
            'tier' => $tier,
            'usage' => $stats,
            'reset_time' => time() + 60
        );
    }
    
    /**
     * Force refresh user tier from backend
     */
    public function refresh_user_tier($user_id) {
        $cache_key = "user_tier_{$user_id}";
        wp_cache_delete($cache_key);
        return $this->get_user_tier($user_id);
    }
}

/**
 * Enhanced API proxy handler with tier-based rate limiting
 */
function retail_trade_scanner_tier_proxy_handler($request) {
    $endpoint = $request->get_param('endpoint');
    $method = $request->get_method();
    $user_id = get_current_user_id();
    
    // Initialize rate limiter
    $rate_limiter = RetailTradeScannerTierRateLimit::getInstance();
    
    // Map endpoint to action type for rate limiting
    $action = retail_trade_scanner_map_endpoint_to_action($endpoint);
    
    // Check tier-based rate limit
    $rate_check = $rate_limiter->check_tier_rate_limit($user_id, $action);
    
    if (!$rate_check['allowed']) {
        $error_code = $rate_check['reason'] === 'upgrade_required' ? 402 : 429;
        
        return new WP_Error(
            $rate_check['reason'],
            $rate_check['message'],
            array(
                'status' => $error_code,
                'rate_limit_info' => array(
                    'current_tier' => $rate_check['tier'] ?? 'free',
                    'required_tier' => $rate_check['required_tier'] ?? null,
                    'reset_time' => $rate_check['reset_time'] ?? null,
                    'upgrade_url' => get_permalink(get_page_by_path('premium-plans'))
                )
            )
        );
    }
    
    // Continue with original proxy logic...
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
            'User-Agent' => 'Retail-Trade-Scanner-Theme/2.2.0',
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
    
    // Add rate limit headers to response
    $response_headers = array(
        'X-RateLimit-Remaining' => $rate_check['remaining'],
        'X-RateLimit-Reset' => $rate_check['reset_time'],
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
 * Map API endpoint to rate limiting action
 */
function retail_trade_scanner_map_endpoint_to_action($endpoint) {
    $mapping = array(
        'stocks/search' => 'search_requests',
        'stocks' => 'api_requests',
        'market/stats' => 'market_data',
        'market/filter' => 'search_requests',
        'trending' => 'market_data',
        'realtime' => 'real_time_data',
        'news' => 'news_requests',
        'portfolio' => 'portfolio_access',
        'alerts' => 'alerts',
        'export' => 'export_data'
    );
    
    foreach ($mapping as $pattern => $action) {
        if (strpos($endpoint, $pattern) !== false) {
            return $action;
        }
    }
    
    return 'api_requests'; // Default action
}

/**
 * AJAX handler for getting user usage statistics
 */
function retail_trade_scanner_get_usage_stats() {
    check_ajax_referer('retail_trade_scanner_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }
    
    $user_id = get_current_user_id();
    $rate_limiter = RetailTradeScannerTierRateLimit::getInstance();
    $stats = $rate_limiter->get_user_usage_stats($user_id);
    
    wp_send_json_success($stats);
}
add_action('wp_ajax_retail_trade_scanner_get_usage_stats', 'retail_trade_scanner_get_usage_stats');

/**
 * AJAX handler for refreshing user tier
 */
function retail_trade_scanner_refresh_tier() {
    check_ajax_referer('retail_trade_scanner_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }
    
    $user_id = get_current_user_id();
    $rate_limiter = RetailTradeScannerTierRateLimit::getInstance();
    $new_tier = $rate_limiter->refresh_user_tier($user_id);
    
    wp_send_json_success(array(
        'tier' => $new_tier,
        'message' => sprintf(__('Subscription tier updated to %s', 'retail-trade-scanner'), ucfirst($new_tier))
    ));
}
add_action('wp_ajax_retail_trade_scanner_refresh_tier', 'retail_trade_scanner_refresh_tier');

// Update the REST API route to use the new tier-based handler
function retail_trade_scanner_register_tier_rest_routes() {
    register_rest_route('retail-trade-scanner/v1', '/proxy/(?P<endpoint>.*)', array(
        'methods' => array('GET', 'POST', 'PUT', 'DELETE'),
        'callback' => 'retail_trade_scanner_tier_proxy_handler',
        'permission_callback' => '__return_true', // We handle permissions in the handler
        'args' => array(
            'endpoint' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));
}
add_action('rest_api_init', 'retail_trade_scanner_register_tier_rest_routes');