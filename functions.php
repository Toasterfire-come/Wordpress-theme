<?php
/**
 * StockScan Pro Theme Functions
 */

if (!defined('ABSPATH')) { exit; }

// Enqueue styles and scripts
add_action('wp_enqueue_scripts', function() {
	$theme_version = '1.0.0';
	$react_css_path = get_template_directory() . '/js/app.css';
	$react_css_uri  = get_template_directory_uri() . '/js/app.css';
	if (file_exists($react_css_path)) {
		wp_enqueue_style('react-app-style', $react_css_uri, [], $theme_version);
	} else {
		wp_enqueue_style('stockscan-style', get_stylesheet_uri(), [], $theme_version);
	}

	// Main script (load in header so inline templates can use localized data)
	wp_enqueue_script('stockscan-main', get_template_directory_uri() . '/js/main.js', ['jquery'], $theme_version, false);

	// Enqueue React app bundle if present (built asset placed in theme's js/ directory)
	$react_js_path = get_template_directory() . '/js/app.js';
	if (file_exists($react_js_path)) {
		wp_enqueue_script('react-app', get_template_directory_uri() . '/js/app.js', [], $theme_version, true);
	}

	// Localize ajax and nonce
	wp_localize_script('stockscan-main', 'StockScan', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('stockscan_nonce'),
		'api_base' => trailingslashit(home_url('/api/')),
	]);
});

// Helper: Proxy to backend API (Django/FastAPI)
function make_backend_api_request($endpoint, $method = 'GET', $body = null, $headers = []) {
	$api_url = trailingslashit(home_url('/api/')) . ltrim($endpoint, '/');
	$args = [
		'method' => $method,
		'timeout' => 10,
		'headers' => array_merge([
			'Content-Type' => 'application/json',
		], $headers),
	];
	if (!is_null($body)) {
		$args['body'] = is_string($body) ? $body : wp_json_encode($body);
	}
	$response = wp_remote_request($api_url, $args);
	if (is_wp_error($response)) {
		return [ 'error' => $response->get_error_message() ];
	}
	$code = wp_remote_retrieve_response_code($response);
	$data = json_decode(wp_remote_retrieve_body($response), true);
	return [ 'code' => $code, 'data' => $data ];
}

// Admin AJAX: examples per spec
function stockscan_verify_ajax_security() {
	if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['nonce']), 'stockscan_nonce')) {
		wp_send_json_error(['message' => 'Invalid nonce'], 403);
	}
}

add_action('wp_ajax_stock_scanner_get_quote', function() {
	stockscan_verify_ajax_security();
	$symbol = isset($_POST['symbol']) ? sanitize_text_field($_POST['symbol']) : '';
	$result = make_backend_api_request('stocks/quote?symbol=' . rawurlencode($symbol));
	wp_send_json($result);
});
add_action('wp_ajax_nopriv_stock_scanner_get_quote', function() { do_action('wp_ajax_stock_scanner_get_quote'); });

add_action('wp_ajax_get_major_indices', function() {
	stockscan_verify_ajax_security();
	$result = make_backend_api_request('market/indices');
	wp_send_json($result);
});
add_action('wp_ajax_nopriv_get_major_indices', function() { do_action('wp_ajax_get_major_indices'); });

add_action('wp_ajax_get_market_movers', function() {
	stockscan_verify_ajax_security();
	$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'gainers';
	$result = make_backend_api_request('stocks/movers?category=' . rawurlencode($category));
	wp_send_json($result);
});
add_action('wp_ajax_nopriv_get_market_movers', function() { do_action('wp_ajax_get_market_movers'); });

add_action('wp_ajax_add_to_watchlist', function() {
	stockscan_verify_ajax_security();
	$symbol = isset($_POST['symbol']) ? sanitize_text_field($_POST['symbol']) : '';
	$result = make_backend_api_request('watchlist/add', 'POST', [ 'symbol' => $symbol ]);
	wp_send_json($result);
});
add_action('wp_ajax_remove_from_watchlist', function() {
	stockscan_verify_ajax_security();
	$symbol = isset($_POST['symbol']) ? sanitize_text_field($_POST['symbol']) : '';
	$result = make_backend_api_request('watchlist/remove', 'POST', [ 'symbol' => $symbol ]);
	wp_send_json($result);
});

add_action('wp_ajax_get_usage_stats', function() {
	stockscan_verify_ajax_security();
	$result = make_backend_api_request('usage/stats');
	wp_send_json($result);
});

add_action('wp_ajax_get_formatted_portfolio_data', function() {
	stockscan_verify_ajax_security();
	$result = make_backend_api_request('portfolio/list');
	wp_send_json($result);
});
add_action('wp_ajax_get_formatted_watchlist_data', function() {
	stockscan_verify_ajax_security();
	$result = make_backend_api_request('watchlist/list');
	wp_send_json($result);
});

add_action('wp_ajax_submit_contact_form', function() {
	stockscan_verify_ajax_security();
	$name = sanitize_text_field($_POST['name'] ?? '');
	$email = sanitize_email($_POST['email'] ?? '');
	$message = sanitize_textarea_field($_POST['message'] ?? '');
	$result = make_backend_api_request('contact/submit', 'POST', compact('name','email','message'));
	wp_send_json($result);
});

add_action('wp_ajax_subscribe_newsletter', function() {
	stockscan_verify_ajax_security();
	$email = sanitize_email($_POST['email'] ?? '');
	$result = make_backend_api_request('newsletter/subscribe', 'POST', compact('email'));
	wp_send_json($result);
});

// PayPal via admin-ajax
add_action('wp_ajax_create_paypal_order', function() {
	stockscan_verify_ajax_security();
	$plan = sanitize_text_field($_POST['plan'] ?? '');
	$result = make_backend_api_request('payments/paypal/create-order', 'POST', [ 'plan' => $plan ]);
	wp_send_json($result);
});
add_action('wp_ajax_capture_paypal_order', function() {
	stockscan_verify_ajax_security();
	$order_id = sanitize_text_field($_POST['orderID'] ?? '');
	$result = make_backend_api_request('payments/paypal/capture-order', 'POST', [ 'order_id' => $order_id ]);
	wp_send_json($result);
});
add_action('wp_ajax_create_paypal_subscription', function() {
	stockscan_verify_ajax_security();
	$plan_id = sanitize_text_field($_POST['planID'] ?? '');
	$result = make_backend_api_request('payments/paypal/create-subscription', 'POST', [ 'plan_id' => $plan_id ]);
	wp_send_json($result);
});

// Minimal REST routes namespace example
add_action('rest_api_init', function() {
	register_rest_route('stock-scanner/v1', '/market-data', [
		'methods' => 'GET',
		'callback' => function($request) {
			$res = make_backend_api_request('market/summary');
			return rest_ensure_response($res);
		}
	]);
	register_rest_route('stock-scanner/v1', '/news', [
		'methods' => 'GET',
		'callback' => function($request) {
			$limit = intval($request->get_param('limit') ?: 10);
			$res = make_backend_api_request('news/feed?limit=' . $limit);
			return rest_ensure_response($res);
		}
	]);
});

add_action('wp_ajax_get_stock_news', function() {
	stockscan_verify_ajax_security();
	$limit = intval($_POST['limit'] ?? 10);
	$result = make_backend_api_request('news/feed?limit=' . $limit);
	wp_send_json($result);
});
add_action('wp_ajax_stock_scanner_register_user', function() {
	stockscan_verify_ajax_security();
	$email = sanitize_email($_POST['email'] ?? '');
	$password = sanitize_text_field($_POST['password'] ?? '');
	$result = make_backend_api_request('user/register', 'POST', compact('email','password'));
	wp_send_json($result);
});
add_action('wp_ajax_submit_cancellation_feedback', function() {
	stockscan_verify_ajax_security();
	$reason = sanitize_textarea_field($_POST['reason'] ?? '');
	$result = make_backend_api_request('feedback/cancelled', 'POST', compact('reason'));
	wp_send_json($result);
});

add_action('rest_api_init', function() {
	register_rest_route('stock-scanner/v1', '/stock-data/(?P<symbol>[A-Za-z0-9\-]+)', [
		'methods' => 'GET',
		'callback' => function($request) {
			$symbol = strtoupper($request['symbol']);
			$res = make_backend_api_request('stock/' . $symbol . '/');
			return rest_ensure_response($res);
		}
	]);
	register_rest_route('stock-scanner/v1', '/historical-data/(?P<symbol>[A-Za-z0-9\-]+)', [
		'methods' => 'GET',
		'callback' => function($request) {
			$symbol = strtoupper($request['symbol']);
			$res = make_backend_api_request('stock/' . $symbol . '/historical');
			return rest_ensure_response($res);
		}
	]);
	register_rest_route('stock-scanner/v1', '/realtime-data/(?P<symbol>[A-Za-z0-9\-]+)', [
		'methods' => 'GET',
		'callback' => function($request) {
			$symbol = strtoupper($request['symbol']);
			$res = make_backend_api_request('stock/' . $symbol . '/realtime');
			return rest_ensure_response($res);
		}
	]);
	register_rest_route('stock-scanner/v1', '/watchlist', [
		'methods' => 'GET',
		'callback' => function($request) {
			$res = make_backend_api_request('watchlist/list');
			return rest_ensure_response($res);
		}
	]);
	register_rest_route('stock-scanner/v1', '/portfolio', [
		'methods' => 'GET',
		'callback' => function($request) {
			$res = make_backend_api_request('portfolio/list');
			return rest_ensure_response($res);
		}
	]);
});

add_action('wp_ajax_stockscan_update_account', function() {
	stockscan_verify_ajax_security();
	$profile = [
		'name' => sanitize_text_field($_POST['name'] ?? ''),
		'timezone' => sanitize_text_field($_POST['timezone'] ?? ''),
	];
	$result = make_backend_api_request('account/update', 'POST', $profile);
	wp_send_json($result);
});

add_action('wp_ajax_stockscan_update_settings', function() {
	stockscan_verify_ajax_security();
	$settings = [
		'notifications' => isset($_POST['notifications']) ? (bool)$_POST['notifications'] : false,
		'email_reports' => isset($_POST['email_reports']) ? (bool)$_POST['email_reports'] : false,
	];
	$result = make_backend_api_request('settings/update', 'POST', $settings);
	wp_send_json($result);
});

add_action('wp_ajax_stockscan_get_billing_history', function() {
	stockscan_verify_ajax_security();
	$result = make_backend_api_request('billing/history');
	wp_send_json($result);
});

// Theme setup (title tag, menus)
add_action('after_setup_theme', function() {
	add_theme_support('title-tag');
	register_nav_menus([
		'primary' => __('Primary Menu', 'stockscan'),
		'footer' => __('Footer Menu', 'stockscan'),
	]);
});

// Page definitions for auto-creation
function stockscan_get_pages_to_create() {
	return [
		[ 'slug' => 'home', 'title' => 'Home', 'template' => 'page-templates/page-home.php', 'seo_title' => 'StockScan Pro – Professional Stock Analysis', 'seo_desc' => 'Advanced stock scanning and market analysis tools for professional traders and investors.' ],
		[ 'slug' => 'dashboard', 'title' => 'Dashboard', 'template' => 'page-dashboard.php', 'seo_title' => 'Dashboard | StockScan Pro', 'seo_desc' => 'Your personalized overview of portfolio, watchlist, market indices and latest news.' ],
		[ 'slug' => 'market-overview', 'title' => 'Market Overview', 'template' => 'page-templates/page-market-overview.php', 'seo_title' => 'Market Overview | StockScan Pro', 'seo_desc' => 'Major indices, top gainers/losers and most active stocks in real time.' ],
		[ 'slug' => 'portfolio', 'title' => 'Portfolio Management', 'template' => 'page-templates/page-portfolio.php', 'seo_title' => 'Portfolio Management | StockScan Pro', 'seo_desc' => 'Track holdings and performance with server-side synced data.' ],
		[ 'slug' => 'watchlist', 'title' => 'Watchlist', 'template' => 'page-watchlist.php', 'seo_title' => 'Watchlist | StockScan Pro', 'seo_desc' => 'Create and manage your stock watchlist with real-time updates.' ],
		[ 'slug' => 'enhanced-watchlist', 'title' => 'Enhanced Watchlist', 'template' => 'page-templates/page-enhanced-watchlist.php', 'seo_title' => 'Enhanced Watchlist | StockScan Pro', 'seo_desc' => 'Advanced filters, sorting and bulk actions for your watchlist.' ],
		[ 'slug' => 'stock-scanner', 'title' => 'Stock Scanner', 'template' => 'page-templates/page-stock-lookup.php', 'seo_title' => 'Stock Scanner | StockScan Pro', 'seo_desc' => 'Look up stock quotes, fundamentals and usage analytics.' ],
		[ 'slug' => 'news', 'title' => 'Stock News', 'template' => 'page-templates/page-stock-news.php', 'seo_title' => 'Market News | StockScan Pro', 'seo_desc' => 'Latest stock market news with sentiment.' ],
		[ 'slug' => 'stock-screener', 'title' => 'Stock Screener', 'template' => 'page-templates/page-stock-screener.php', 'seo_title' => 'Stock Screener | StockScan Pro', 'seo_desc' => 'Server-side screening powered by the backend API.' ],
		[ 'slug' => 'paypal-checkout', 'title' => 'PayPal Checkout', 'template' => 'page-templates/page-paypal-checkout.php', 'seo_title' => 'Checkout | StockScan Pro', 'seo_desc' => 'Secure checkout with PayPal.', 'noindex' => true ],
		[ 'slug' => 'payment-success', 'title' => 'Payment Success', 'template' => 'page-templates/page-payment-success.php', 'seo_title' => 'Payment Success | StockScan Pro', 'seo_desc' => 'Your payment was successful. Next steps to get started.', 'noindex' => true ],
		[ 'slug' => 'payment-cancelled', 'title' => 'Payment Cancelled', 'template' => 'page-templates/page-payment-cancelled.php', 'seo_title' => 'Payment Cancelled | StockScan Pro', 'seo_desc' => 'Your payment was cancelled. Try again or contact support.', 'noindex' => true ],
		[ 'slug' => 'premium-plans', 'title' => 'Premium Plans', 'template' => 'page-premium-plans.php', 'seo_title' => 'Premium Plans | StockScan Pro', 'seo_desc' => 'Pricing tiers and features for every trader.' ],
		[ 'slug' => 'compare-plans', 'title' => 'Compare Plans', 'template' => 'page-compare-plans.php', 'seo_title' => 'Compare Plans | StockScan Pro', 'seo_desc' => 'Side-by-side comparison of plan features.' ],
		[ 'slug' => 'account', 'title' => 'My Account', 'template' => 'page-account.php', 'seo_title' => 'My Account | StockScan Pro', 'seo_desc' => 'Manage your profile, preferences and security.' ],
		[ 'slug' => 'user-settings', 'title' => 'User Settings', 'template' => 'page-templates/page-user-settings.php', 'seo_title' => 'User Settings | StockScan Pro', 'seo_desc' => 'Notification and data preferences.' ],
		[ 'slug' => 'login', 'title' => 'Login', 'template' => 'page-login.php', 'seo_title' => 'Login | StockScan Pro', 'seo_desc' => 'Sign in to your StockScan Pro account.', 'noindex' => true ],
		[ 'slug' => 'signup', 'title' => 'Sign Up', 'template' => 'page-templates/page-signup.php', 'seo_title' => 'Sign Up | StockScan Pro', 'seo_desc' => 'Create your account and choose a plan.' ],
		[ 'slug' => 'contact', 'title' => 'Contact Us', 'template' => 'page-templates/page-contact.php', 'seo_title' => 'Contact Us | StockScan Pro', 'seo_desc' => 'Get support and contact our team.' ],
		[ 'slug' => 'status', 'title' => 'System Status', 'template' => 'page-status.php', 'seo_title' => 'System Status | StockScan Pro', 'seo_desc' => 'Links to API health and endpoint status.' ],
		[ 'slug' => 'security', 'title' => 'Security', 'template' => 'page-templates/page-security.php', 'seo_title' => 'Security | StockScan Pro', 'seo_desc' => 'Our security practices and incident reporting.' ],
		[ 'slug' => 'accessibility', 'title' => 'Accessibility', 'template' => 'page-templates/page-accessibility.php', 'seo_title' => 'Accessibility | StockScan Pro', 'seo_desc' => 'WCAG commitment and accessibility features.' ],
		[ 'slug' => 'terms', 'title' => 'Terms of Service', 'template' => 'page-terms.php', 'seo_title' => 'Terms of Service | StockScan Pro', 'seo_desc' => 'Terms governing the use of our services.' ],
		[ 'slug' => 'privacy', 'title' => 'Privacy Policy', 'template' => 'page-privacy.php', 'seo_title' => 'Privacy Policy | StockScan Pro', 'seo_desc' => 'How we collect, use and protect your data.' ],
		[ 'slug' => 'cookie-policy', 'title' => 'Cookie Policy', 'template' => 'page-cookie-policy.php', 'seo_title' => 'Cookie Policy | StockScan Pro', 'seo_desc' => 'Information about cookies used by our site.' ],
		[ 'slug' => 'faq', 'title' => 'FAQ', 'template' => 'default', 'seo_title' => 'FAQ | StockScan Pro', 'seo_desc' => 'Frequently asked questions and answers.' ],
		[ 'slug' => 'about', 'title' => 'About', 'template' => 'default', 'seo_title' => 'About | StockScan Pro', 'seo_desc' => 'About StockScan Pro and our mission.' ],
		[ 'slug' => 'help-center', 'title' => 'Help Center', 'template' => 'default', 'seo_title' => 'Help Center | StockScan Pro', 'seo_desc' => 'Guides and help resources to get you started.' ],
		[ 'slug' => 'release-notes', 'title' => 'Release Notes', 'template' => 'default', 'seo_title' => 'Release Notes | StockScan Pro', 'seo_desc' => 'Changelog and product updates.' ],
		[ 'slug' => 'roadmap', 'title' => 'Roadmap', 'template' => 'default', 'seo_title' => 'Roadmap | StockScan Pro', 'seo_desc' => 'Upcoming features and improvements.' ],
		[ 'slug' => 'keyboard-shortcuts', 'title' => 'Keyboard Shortcuts', 'template' => 'default', 'seo_title' => 'Keyboard Shortcuts | StockScan Pro', 'seo_desc' => 'Shortcuts to navigate efficiently.' ],
		[ 'slug' => 'getting-started', 'title' => 'Getting Started', 'template' => 'default', 'seo_title' => 'Getting Started | StockScan Pro', 'seo_desc' => 'Quickstart guide for new users.' ],
		[ 'slug' => 'sitemap', 'title' => 'Sitemap', 'template' => 'default', 'seo_title' => 'Sitemap | StockScan Pro', 'seo_desc' => 'Overview of pages and resources.' ],
	];
}

function stockscan_upsert_page($slug, $title, $template = 'default', $content = '') {
	$page = get_page_by_path($slug);
	if ($page) {
		return (int)$page->ID;
	}
	$postarr = [
		'post_title' => $title,
		'post_name' => $slug,
		'post_status' => 'publish',
		'post_type' => 'page',
		'post_content' => $content,
	];
	$page_id = wp_insert_post($postarr, true);
	if (!is_wp_error($page_id) && $template && $template !== 'default') {
		update_post_meta($page_id, '_wp_page_template', $template);
	}
	return is_wp_error($page_id) ? 0 : (int)$page_id;
}

function stockscan_set_front_page($page_id) {
	if ($page_id > 0) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $page_id);
	}
}

// Auto-create pages on theme activation
add_action('after_switch_theme', function() {
	$pages = stockscan_get_pages_to_create();
	$created_ids = [];
	foreach ($pages as $p) {
		$created_ids[$p['slug']] = stockscan_upsert_page($p['slug'], $p['title'], $p['template'] ?? 'default', $p['content'] ?? '');
		// Save SEO meta for popular plugins (optional; harmless if plugin missing)
		if (!empty($p['seo_title'])) {
			update_post_meta($created_ids[$p['slug']], '_yoast_wpseo_title', $p['seo_title']);
			update_post_meta($created_ids[$p['slug']], 'rank_math_title', $p['seo_title']);
		}
		if (!empty($p['seo_desc'])) {
			update_post_meta($created_ids[$p['slug']], '_yoast_wpseo_metadesc', $p['seo_desc']);
			update_post_meta($created_ids[$p['slug']], 'rank_math_description', $p['seo_desc']);
		}
		if (!empty($p['noindex'])) {
			update_post_meta($created_ids[$p['slug']], '_yoast_wpseo_meta-robots-noindex', '1');
			update_post_meta($created_ids[$p['slug']], 'rank_math_robots', 'noindex, nofollow');
		}
	}
	// Set static front page to Home
	if (!empty($created_ids['home'])) {
		stockscan_set_front_page($created_ids['home']);
	}
	flush_rewrite_rules();
});

// Basic SEO meta output (skip if major SEO plugin active)
function stockscan_output_seo_meta() {
	if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) {
		return; // delegate to SEO plugin
	}
	if (!is_singular() && !is_front_page()) {
		return;
	}
	global $post;
	$title = function_exists('wp_get_document_title') ? wp_get_document_title() : get_bloginfo('name');
	$desc = '';
	if (is_singular() && $post) {
		$desc = has_excerpt($post) ? get_the_excerpt($post) : wp_trim_words(wp_strip_all_tags($post->post_content), 28, '…');
	}
	if (!$desc) { $desc = get_bloginfo('description'); }
	$url = is_singular() ? get_permalink() : home_url('/');
	$site = get_bloginfo('name');
	$icon = function_exists('get_site_icon_url') && get_site_icon_url() ? get_site_icon_url() : get_template_directory_uri() . '/screenshot.png';
	$robots = 'index, follow';
	$noindex_slugs = [ 'login', 'signup', 'paypal-checkout', 'payment-success', 'payment-cancelled' ];
	if (is_singular() && $post && in_array($post->post_name, $noindex_slugs, true)) { $robots = 'noindex, nofollow'; }
	echo "\n\t<!-- StockScan Pro basic SEO -->\n";
	echo '<meta name="robots" content="' . esc_attr($robots) . '" />' . "\n";
	echo '<link rel="canonical" href="' . esc_url($url) . '" />' . "\n";
	echo '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr($desc) . '" />' . "\n";
	echo '<meta property="og:type" content="' . (is_front_page() ? 'website' : 'article') . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr($site) . '" />' . "\n";
	echo '<meta property="og:image" content="' . esc_url($icon) . '" />' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr($desc) . '" />' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url($icon) . '" />' . "\n";
	// JSON-LD
	$org = [
		'@context' => 'https://schema.org',
		'@type' => 'Organization',
		'name' => $site,
		'url' => home_url('/'),
	];
	$website = [
		'@context' => 'https://schema.org',
		'@type' => 'WebSite',
		'name' => $site,
		'url' => home_url('/'),
		'potentialAction' => [
			'@type' => 'SearchAction',
			'target' => home_url('/?s={search_term_string}'),
			'query-input' => 'required name=search_term_string',
		],
	];
	echo '<script type="application/ld+json">' . wp_json_encode($org) . '</script>' . "\n";
	echo '<script type="application/ld+json">' . wp_json_encode($website) . '</script>' . "\n";
}
add_action('wp_head', 'stockscan_output_seo_meta', 5);