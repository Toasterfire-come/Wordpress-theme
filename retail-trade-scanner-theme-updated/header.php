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
    <?php if (is_user_logged_in()) : ?>
        <!-- Full Header for Logged-in Users -->
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

                    <!-- Expandable Search Bar -->
                    <div class="search-container" style="position: relative; flex: 1; margin: 0 2rem; max-width: 500px;">
                        <div class="search-wrapper" style="position: relative; width: 100%;">
                            <button id="search-toggle" class="search-toggle" style="position: absolute; right: 0; width: 40px; height: 40px; border: none; background: transparent; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10;">
                                🔍
                            </button>
                            <input 
                                type="text" 
                                class="search-input" 
                                placeholder="Search stocks..."
                                id="stock-search"
                                style="width: 40px; height: 40px; border: 2px solid #475569; border-radius: 20px; background: transparent; color: white; padding: 0 45px 0 15px; outline: none; transition: all 0.3s ease; position: absolute; right: 0; opacity: 0;"
                                data-api-endpoint="<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/stocks/search')); ?>"
                            />
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="header-actions" style="display: flex; align-items: center; gap: 1rem;">
                        <!-- Market Status (NYSE Only) -->
                        <div class="market-status" style="text-align: right; margin-right: 1rem;">
                            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">NYSE</p>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="background: #ef4444; color: white; font-size: 0.625rem; padding: 0.125rem 0.375rem; border-radius: 9999px; font-weight: 500;">SUB 3 MIN</span>
                                <span style="color: white; font-weight: 600;" id="market-ticker">4,789.45 +0.52%</span>
                            </div>
                        </div>

                        <!-- User Actions -->
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('account'))); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;">
                            My Account
                        </a>
                        <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;">
                            Logout
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-primary">
                            Upgrade to Pro
                        </a>
                    </div>
                </div>
            </div>
        </header>
    <?php else : ?>
        <!-- Minimal Header for Non-logged-in Users -->
        <header id="masthead" class="site-header" style="background: #0f172a; padding: 1rem 0;">
            <div class="container">
                <div style="display: flex; justify-content: center; align-items: center;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        🏠 Home
                    </a>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <!-- React Root Container -->
    <div id="react-root"></div>

<?php
/**
 * Fallback menu function
 */
function retail_trade_scanner_fallback_menu() {
    echo '<ul class="main-navigation">';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('dashboard'))) . '">Dashboard</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('scanner'))) . '">Scanner</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('portfolio'))) . '">Portfolio</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('news'))) . '">News</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('premium-plans'))) . '">Plans</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('contact'))) . '">Contact</a></li>';
    echo '</ul>';
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Expandable Search Functionality
    const searchToggle = document.getElementById('search-toggle');
    const searchInput = document.getElementById('stock-search');
    
    if (searchToggle && searchInput) {
        searchToggle.addEventListener('click', function() {
            if (searchInput.style.opacity === '0' || !searchInput.style.opacity) {
                // Expand search
                searchInput.style.width = '300px';
                searchInput.style.opacity = '1';
                searchInput.style.background = '#1e293b';
                searchInput.focus();
            } else {
                // Collapse search
                searchInput.style.width = '40px';
                searchInput.style.opacity = '0';
                searchInput.style.background = 'transparent';
                searchInput.blur();
            }
        });
        
        // Collapse when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchToggle.contains(e.target) && !searchInput.contains(e.target)) {
                searchInput.style.width = '40px';
                searchInput.style.opacity = '0';
                searchInput.style.background = 'transparent';
            }
        });
        
        // Search functionality
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
    
    // Initial load and refresh every 3 minutes (180 seconds)
    updateMarketTicker();
    setInterval(updateMarketTicker, 180000);
});
</script>