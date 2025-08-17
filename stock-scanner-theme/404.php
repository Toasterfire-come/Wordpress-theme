<?php get_header(); ?>

<!-- React App Root Container -->
<div id="root"></div>

<!-- Fallback content for 404 pages -->
<noscript>
    <div style="padding: 2rem; text-align: center; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <h1>Page Not Found</h1>
        <p>The page you are looking for could not be found.</p>
        <p><a href="<?php echo home_url(); ?>">Return to Home</a></p>
    </div>
</noscript>

<?php get_footer(); ?>