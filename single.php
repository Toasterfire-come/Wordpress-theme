<?php get_header(); ?>

<!-- React App Root Container -->
<div id="root"></div>

<!-- Fallback content for single posts -->
<noscript>
    <div style="padding: 2rem; text-align: center; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <h1><?php bloginfo('name'); ?></h1>
        <p>This application requires JavaScript to be enabled in your browser.</p>
        <p>Please enable JavaScript and refresh the page.</p>
    </div>
</noscript>

<?php get_footer(); ?>