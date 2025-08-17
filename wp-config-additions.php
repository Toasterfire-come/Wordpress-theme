<?php
/**
 * WordPress configuration additions for Stock Scanner Pro theme
 * Add these lines to your wp-config.php file for optimal performance
 */

// Enable WordPress caching
define('WP_CACHE', true);

// Increase memory limit for React app
ini_set('memory_limit', '256M');

// Optimize WordPress database queries
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// Disable file editing in WordPress admin
define('DISALLOW_FILE_EDIT', true);

// Limit post revisions
define('WP_POST_REVISIONS', 3);

// Set automatic update constants
define('WP_AUTO_UPDATE_CORE', 'minor');

// Optimize WordPress for single page applications
define('WP_USE_THEMES', true);

// Enable compression
define('COMPRESS_CSS', true);
define('COMPRESS_SCRIPTS', true);
define('ENFORCE_GZIP', true);

// Security enhancements
define('FORCE_SSL_ADMIN', true); // Only if using HTTPS
define('WP_HTTP_BLOCK_EXTERNAL', false); // Allow external requests for stock data

// WordPress REST API optimizations
define('REST_REQUEST_PARAMETER', 'rest_route');

?>