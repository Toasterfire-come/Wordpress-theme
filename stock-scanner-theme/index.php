<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- React App Root Container -->
<div id="root"></div>

<!-- Fallback content for when JavaScript is disabled -->
<noscript>
    <div style="padding: 2rem; text-align: center; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <h1>Stock Scanner Pro</h1>
        <p>This application requires JavaScript to be enabled in your browser.</p>
        <p>Please enable JavaScript and refresh the page to use Stock Scanner Pro.</p>
    </div>
</noscript>

<?php wp_footer(); ?>
</body>
</html>