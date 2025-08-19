<?php
/**
 * The header for Retail Trade Scanner theme - Updated with Dark Mode
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
                                    <div style="font-size: 0.75rem; color: var(--text-muted, #94a3b8); line-height: 1;">
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
                                style="position: absolute; right: 0; width: 40px; height: 40px; border: none; background: transparent; color: var(--text-muted, #94a3b8); cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: color 0.2s ease;"
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
                                style="width: 40px; height: 40px; border: 2px solid var(--input-border, #475569); border-radius: 20px; background: var(--input-bg, transparent); color: var(--text-primary, white); padding: 0 45px 0 15px; outline: none; transition: all 0.3s ease; position: absolute; right: 0; opacity: 0;"
                                data-api-endpoint="<?php echo esc_url(get_option('retail_trade_scanner_api_endpoint', '') . '/api/stocks/search/'); ?>"
                                autocomplete="off"
                                spellcheck="false"
                            />
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="header-actions" style="display: flex; align-items: center; gap: 1rem;">
                        <!-- Dark Mode Toggle -->
                        <button 
                            id="header-dark-toggle" 
                            class="btn btn-outline dark-mode-header-toggle"
                            style="border-color: rgba(255,255,255,0.3); color: var(--text-primary, white); padding: 0.5rem;"
                            aria-label="Toggle dark mode"
                            title="Toggle dark mode"
                        >
                            <span class="dark-mode-icon">🌙</span>
                        </button>
                        
                        <!-- Market Status (NYSE Only) -->
                        <div class="market-status" style="text-align: right; margin-right: 1rem;" role="status" aria-live="polite">
                            <p style="font-size: 0.75rem; color: var(--text-muted, #94a3b8); margin: 0;">NYSE</p>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span 
                                    style="background: #ef4444; color: white; font-size: 0.625rem; padding: 0.125rem 0.375rem; border-radius: 9999px; font-weight: 500;"
                                    title="Market data updates under 3 minutes"
                                >
                                    SUB 3 MIN
                                </span>
                                <span style="color: var(--text-primary, white); font-weight: 600;" id="market-ticker" aria-label="Current market status">
                                    4,789.45 +0.52%
                                </span>
                            </div>
                        </div>

                        <!-- User Actions -->
                        <a 
                            href="<?php echo esc_url(get_permalink(get_page_by_path('account'))); ?>" 
                            class="btn btn-outline" 
                            style="border-color: rgba(255,255,255,0.3); color: var(--text-primary, white);"
                            aria-label="Go to my account"
                        >
                            My Account
                        </a>
                        <a 
                            href="<?php echo wp_logout_url(home_url()); ?>" 
                            class="btn btn-outline" 
                            style="border-color: rgba(255,255,255,0.3); color: var(--text-primary, white);"
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
        <header id="masthead" class="site-header" style="background: var(--background-secondary, #0f172a); padding: 1rem 0;" role="banner">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Logo for non-logged-in users -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="Retail Trade Scanner Home">
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--text-primary, white); text-decoration: none;">
                            <div style="width: 32px; height: 32px; background: var(--accent-color, #059669); border-radius: 6px; display: flex; align-items: center; justify-content: center;" aria-hidden="true">
                                <span style="font-size: 1.25rem;">📊</span>
                            </div>
                            <span style="font-size: 1.125rem; font-weight: 600;">Retail Trade Scanner</span>
                        </div>
                    </a>
                    
                    <!-- Dark Mode Toggle for Non-logged Users -->
                    <button 
                        id="header-dark-toggle-guest" 
                        class="btn btn-outline dark-mode-header-toggle"
                        style="border-color: rgba(255,255,255,0.3); color: var(--text-primary, white); padding: 0.5rem; margin-right: 1rem;"
                        aria-label="Toggle dark mode"
                        title="Toggle dark mode"
                    >
                        <span class="dark-mode-icon">🌙</span>
                    </button>
                    
                    <!-- Login/Signup actions -->
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <a href="<?php echo wp_login_url(); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: var(--text-primary, white);">
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

<script>
// Dark mode toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dark mode toggles
    const toggles = document.querySelectorAll('.dark-mode-header-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (window.RetailTradeScanner && window.RetailTradeScanner.darkMode) {
                window.RetailTradeScanner.darkMode.toggle();
            } else {
                // Fallback for when main script isn't loaded yet
                const isDark = document.body.classList.contains('dark-mode');
                if (isDark) {
                    document.body.classList.remove('dark-mode');
                    updateDarkModeIcon(false);
                } else {
                    document.body.classList.add('dark-mode');
                    updateDarkModeIcon(true);
                }
                
                // Save preference in localStorage as fallback
                localStorage.setItem('darkModePreference', (!isDark).toString());
            }
        });
    });
    
    // Load dark mode preference on page load
    loadDarkModePreference();
});

function updateDarkModeIcon(isDark) {
    const icons = document.querySelectorAll('.dark-mode-icon');
    icons.forEach(icon => {
        icon.textContent = isDark ? '☀️' : '🌙';
    });
}

function loadDarkModePreference() {
    // Check WordPress user preference first
    const userPreference = window.retail_trade_scanner_data?.dark_mode;
    
    if (typeof userPreference !== 'undefined') {
        if (userPreference) {
            document.body.classList.add('dark-mode');
            updateDarkModeIcon(true);
        }
    } else {
        // Fallback to localStorage or system preference
        const savedPreference = localStorage.getItem('darkModePreference');
        const systemPreference = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        const shouldUseDark = savedPreference ? savedPreference === 'true' : systemPreference;
        
        if (shouldUseDark) {
            document.body.classList.add('dark-mode');
            updateDarkModeIcon(true);
        }
    }
}
</script>

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
    color: var(--accent-hover, #34d399);
}

.dark-mode-header-toggle {
    transition: all 0.2s ease;
}

.dark-mode-header-toggle:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: scale(1.05);
}

.search-results-dropdown {
    border: 1px solid var(--card-border, #e2e8f0);
    border-radius: 8px;
    background: var(--card-bg, white);
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
        order: -1;
    }
    
    .dark-mode-header-toggle {
        order: -2;
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
    
    .dark-mode-header-toggle {
        width: auto;
        align-self: flex-end;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .search-input {
        border-color: currentColor;
    }
    
    .btn-outline {
        border-color: currentColor;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .search-input,
    .search-toggle,
    .btn,
    .dark-mode-header-toggle {
        transition: none;
    }
}

/* Dark mode specific header styles */
.dark-mode .site-header {
    background-color: var(--background-secondary);
    border-bottom: 1px solid var(--border-primary);
}

.dark-mode .logo {
    color: var(--text-primary);
}

.dark-mode .main-navigation a {
    color: var(--text-secondary);
}

.dark-mode .main-navigation a:hover {
    color: var(--text-primary);
}

.dark-mode .market-status {
    color: var(--text-secondary);
}

.dark-mode #market-ticker {
    color: var(--text-primary);
}
</style>