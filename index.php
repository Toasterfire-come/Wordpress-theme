<?php
/**
 * Main template for React SPA
 * Retail Trade Scanner - WordPress + React Integration
 */

get_header(); ?>

<!-- React App Container -->
<div id="root"></div>

<!-- Fallback content for non-JS users -->
<noscript>
    <div style="padding: 4rem 2rem; text-align: center; background: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 600px; background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            <h1 style="font-size: 2rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                <?php _e('JavaScript Required', 'retail-trade-scanner'); ?>
            </h1>
            <p style="color: #64748b; line-height: 1.6; margin-bottom: 2rem;">
                <?php _e('Retail Trade Scanner requires JavaScript to function properly. Please enable JavaScript in your browser settings and refresh this page.', 'retail-trade-scanner'); ?>
            </p>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    <?php _e('How to enable JavaScript:', 'retail-trade-scanner'); ?>
                </h3>
                <ul style="text-align: left; color: #64748b; font-size: 0.875rem; line-height: 1.5;">
                    <li><?php _e('Chrome: Settings > Privacy and security > Site Settings > JavaScript', 'retail-trade-scanner'); ?></li>
                    <li><?php _e('Firefox: Preferences > Privacy & Security > Permissions', 'retail-trade-scanner'); ?></li>
                    <li><?php _e('Safari: Preferences > Security > Enable JavaScript', 'retail-trade-scanner'); ?></li>
                </ul>
            </div>
            <a href="<?php echo esc_url(home_url('/')); ?>" 
               style="background: #059669; color: white; padding: 1rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">
                <?php _e('Refresh Page', 'retail-trade-scanner'); ?>
            </a>
        </div>
    </div>
</noscript>

<?php get_footer(); ?>