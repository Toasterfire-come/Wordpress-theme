<?php
/**
 * The header for Stock Scanner Pro theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                            <div class="logo-icon">
                                <span style="font-size: 1.5rem;">📊</span>
                            </div>
                            <div class="logo-text">
                                <div style="font-size: 1.25rem; font-weight: 700; line-height: 1.2;">
                                    <?php bloginfo('name'); ?>
                                </div>
                                <div style="font-size: 0.75rem; color: #94a3b8; line-height: 1;">
                                    Professional Trading Platform
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Navigation -->
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'main-navigation',
                        'fallback_cb'    => 'stock_scanner_fallback_menu',
                    ));
                    ?>
                </nav>

                <!-- Header Actions -->
                <div class="header-actions" style="display: flex; align-items: center; gap: 1rem;">
                    <!-- Market Status -->
                    <div class="market-status" style="text-align: right; margin-right: 1rem;">
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">S&P 500</p>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="background: #ef4444; color: white; font-size: 0.625rem; padding: 0.125rem 0.375rem; border-radius: 9999px; font-weight: 500;">LIVE</span>
                            <span style="color: white; font-weight: 600;">4,789.45 +0.52%</span>
                        </div>
                    </div>

                    <!-- User Actions -->
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;">
                        Login
                    </a>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-primary">
                        Upgrade to Pro
                    </a>
                </div>
            </div>
        </div>
    </header>

<?php
/**
 * Fallback menu function
 */
function stock_scanner_fallback_menu() {
    echo '<ul class="main-navigation">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('dashboard'))) . '">Dashboard</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('scanner'))) . '">Scanner</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('watchlist'))) . '">Watchlist</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('portfolio'))) . '">Portfolio</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('news'))) . '">News</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('premium-plans'))) . '">Plans</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('contact'))) . '">Contact</a></li>';
    echo '</ul>';
}
?>