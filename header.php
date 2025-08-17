<?php
/**
 * The header for Retail Trade Scanner React SPA
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Professional stock analysis and portfolio management platform with real-time market data">
    <meta name="keywords" content="stock scanner, portfolio management, market data, trading platform">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico">
    
    <!-- Preconnect to external APIs for performance -->
    <link rel="preconnect" href="<?php echo defined('RETAIL_TRADE_SCANNER_API_URL') ? RETAIL_TRADE_SCANNER_API_URL : 'http://localhost:8001'; ?>">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class('react-spa'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <!-- WordPress admin bar space -->
    <?php if (is_admin_bar_showing()): ?>
        <div style="height: 32px;"></div>
    <?php endif; ?>