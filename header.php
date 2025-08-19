<?php
/**
 * The header for Retail Trade Scanner theme - Bug Fixed Version
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Professional stock analysis and portfolio management platform">
    <meta name="theme-color" content="#0f172a">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <?php if (is_user_logged_in()) : ?>
        <!-- Full Header for Logged-in Users -->
        <header id="masthead" class="site-header" role="banner">
            <div class="container">
                <div class="header-content">
                    <!-- Logo -->
                    <div class="site-branding">
                        <?php if (has_custom_logo()) : ?>
                            <div class="site-logo">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="Retail Trade Scanner Home">
                                <div class="logo-icon" aria-hidden="true">
                                    <span style="font-size: 1.5rem;">📊</span>
                                </div>
                                <div class="logo-text">
                                    <div style="font-size: 1.25rem; font-weight: 700; line-height: 1.2;">
                                        Retail Trade Scanner
                                    </div>
                                    <div style="font-size: 0.75rem; color: #94a3b8; line-height: 1;">
                                        Professional Trading Platform
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Navigation -->
                    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary Navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'menu_class'     => 'main-navigation',
                            'fallback_cb'    => 'retail_trade_scanner_fallback_menu',
                        ));
                        ?>
                    </nav>

                    <!-- Expandable Search Bar -->
                    <div class="search-container" style="position: relative; flex: 1; margin: 0 2rem; max-width: 500px;">
                        <div class="search-wrapper" style="position: relative; width: 100%;">
                            <button 
                                id="search-toggle" 
                                class="search-toggle" 
                                style="position: absolute; right: 0; width: 40px; height: 40px; border: none; background: transparent; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: color 0.2s ease;"
                                aria-label="Open stock search"
                                type="button"
                            >
                                <span style="font-size: 16px;">🔍</span>
                            </button>
                            <input 
                                type="search" 
                                class="search-input" 
                                placeholder="Search stocks (Ctrl+K)..."
                                id="stock-search"
                                style="width: 40px; height: 40px; border: 2px solid #475569; border-radius: 20px; background: transparent; color: white; padding: 0 45px 0 15px; outline: none; transition: all 0.3s ease; position: absolute; right: 0; opacity: 0;"
                                data-api-endpoint="<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/stocks/search')); ?>"
                                autocomplete="off"
                                spellcheck="false"
                            />
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="header-actions" style="display: flex; align-items: center; gap: 1rem;">
                        <!-- Market Status (NYSE Only) -->
                        <div class="market-status" style="text-align: right; margin-right: 1rem;" role="status" aria-live="polite">
                            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">NYSE</p>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span 
                                    style="background: #ef4444; color: white; font-size: 0.625rem; padding: 0.125rem 0.375rem; border-radius: 9999px; font-weight: 500;"
                                    title="Market data updates under 3 minutes"
                                >
                                    SUB 3 MIN
                                </span>
                                <span style="color: white; font-weight: 600;" id="market-ticker" aria-label="Current market status">
                                    4,789.45 +0.52%
                                </span>
                            </div>
                        </div>

                        <!-- User Actions -->
                        <a 
                            href="<?php echo esc_url(get_permalink(get_page_by_path('account'))); ?>" 
                            class="btn btn-outline" 
                            style="border-color: rgba(255,255,255,0.3); color: white;"
                            aria-label="Go to my account"
                        >
                            My Account
                        </a>
                        <a 
                            href="<?php echo wp_logout_url(home_url()); ?>" 
                            class="btn btn-outline" 
                            style="border-color: rgba(255,255,255,0.3); color: white;"
                            aria-label="Logout"
                        >
                            Logout
                        </a>
                        <a 
                            href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" 
                            class="btn btn-primary"
                            aria-label="Upgrade to Pro plan"
                        >
                            Upgrade to Pro
                        </a>
                    </div>
                </div>
            </div>
        </header>
    <?php else : ?>
        <!-- Minimal Header for Non-logged-in Users -->
        <header id="masthead" class="site-header" style="background: #0f172a; padding: 1rem 0;" role="banner">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Logo for non-logged-in users -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="Retail Trade Scanner Home">
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: white; text-decoration: none;">
                            <div style="width: 32px; height: 32px; background: #059669; border-radius: 6px; display: flex; align-items: center; justify-content: center;" aria-hidden="true">
                                <span style="font-size: 1.25rem;">📊</span>
                            </div>
                            <span style="font-size: 1.125rem; font-weight: 600;">Retail Trade Scanner</span>
                        </div>
                    </a>
                    
                    <!-- Login/Signup actions -->
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <a href="<?php echo wp_login_url(); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;">
                            Login
                        </a>
                        <a href="<?php echo wp_registration_url(); ?>" class="btn btn-primary">
                            Sign Up Free
                        </a>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <!-- Skip to content link for accessibility -->
    <a class="screen-reader-text" href="#main" style="position: absolute; left: -9999px; top: 0; z-index: 999999; padding: 8px 16px; background: #000; color: #fff; text-decoration: none; font-weight: 600;">
        Skip to content
    </a>

    <!-- React Root Container -->
    <div id="react-root"></div>

<?php
/**
 * Fallback menu function - Enhanced version
 */
function retail_trade_scanner_fallback_menu() {
    $menu_items = array(
        'dashboard' => array('title' => 'Dashboard', 'icon' => '📊'),
        'scanner' => array('title' => 'Scanner', 'icon' => '🔍'),
        'portfolio' => array('title' => 'Portfolio', 'icon' => '💼'),
        'news' => array('title' => 'News', 'icon' => '📰'),
        'premium-plans' => array('title' => 'Plans', 'icon' => '⭐'),
        'contact' => array('title' => 'Contact', 'icon' => '📧')
    );
    
    echo '<ul class="main-navigation" role="menubar">';
    foreach ($menu_items as $slug => $item) {
        $url = esc_url(get_permalink(get_page_by_path($slug)));
        $current_class = (is_page($slug)) ? ' class="current-menu-item"' : '';
        echo "<li{$current_class} role=\"none\">";
        echo "<a href=\"{$url}\" role=\"menuitem\">";
        echo "<span aria-hidden=\"true\">{$item['icon']}</span> {$item['title']}";
        echo "</a></li>";
    }
    echo '</ul>';
}
?>

<style>
/* Additional CSS for better accessibility and mobile support */
.search-input:focus {
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.3);
}

.btn:focus {
    outline: 2px solid rgba(255, 255, 255, 0.8);
    outline-offset: 2px;
}

.search-toggle:hover {
    color: var(--emerald-400, #34d399);
}

.search-results-dropdown {
    border: 1px solid var(--slate-200, #e2e8f0);
    border-radius: 8px;
    background: white;
    box-shadow: var(--shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .search-container {
        margin: 0;
        max-width: none;
    }
    
    .header-actions {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .market-status {
        margin-right: 0;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .header-actions .btn {
        width: 100%;
        text-align: center;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .search-input {
        border-color: #000;
    }
    
    .btn-outline {
        border-color: currentColor;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .search-input,
    .search-toggle,
    .btn {
        transition: none;
    }
}
</style>