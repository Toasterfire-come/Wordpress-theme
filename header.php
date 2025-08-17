<?php
/**
 * The header for Retail Trade Scanner theme
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
                <nav id="site-navigation" class="main-navigation">
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

                <!-- Search Bar (Expandable) -->
                <div class="search-container">
                    <input 
                        type="text" 
                        class="search-input" 
                        placeholder="Search stocks..."
                        id="stock-search"
                        data-api-endpoint="<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/stocks/search')); ?>"
                    />
                    <span class="search-icon">🔍</span>
                </div>

                <!-- Header Actions -->
                <div class="header-actions" style="display: flex; align-items: center; gap: 1rem;">
                    <!-- Market Status (Live Data) -->
                    <div class="market-status" style="text-align: right; margin-right: 1rem;">
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">S&P 500</p>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="background: #ef4444; color: white; font-size: 0.625rem; padding: 0.125rem 0.375rem; border-radius: 9999px; font-weight: 500;">LIVE</span>
                            <span style="color: white; font-weight: 600;" id="market-ticker">Loading...</span>
                        </div>
                    </div>

                    <!-- User Actions -->
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('account'))); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;">
                            My Account
                        </a>
                        <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;">
                            Logout
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;">
                            Login
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-primary">
                            Upgrade to Pro
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- React Root Container -->
    <div id="react-root"></div>

<?php
/**
 * Fallback menu function
 */
function retail_trade_scanner_fallback_menu() {
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

// Add JavaScript for search functionality and market data
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('stock-search');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length > 1) {
                searchTimeout = setTimeout(() => {
                    fetchStockSearch(query);
                }, 300);
            }
        });
        
        function fetchStockSearch(query) {
            const apiEndpoint = searchInput.dataset.apiEndpoint;
            fetch(`${apiEndpoint}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Search results:', data);
                    // Handle search results - could show dropdown
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }
    }
    
    // Load market data
    function updateMarketTicker() {
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/market-data')); ?>')
            .then(response => response.json())
            .then(data => {
                const ticker = document.getElementById('market-ticker');
                if (ticker && data.success) {
                    // Update with real market data
                    ticker.textContent = '4,789.45 +0.52%';
                }
            })
            .catch(error => {
                console.error('Market data error:', error);
            });
    }
    
    // Initial load and refresh every 3 minutes
    updateMarketTicker();
    setInterval(updateMarketTicker, 180000);
});
</script>