<?php
/**
 * The template for displaying 404 pages (not found)
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
    <div class="container" style="text-align: center; max-width: 600px;">
        <div style="font-size: 6rem; margin-bottom: 2rem;">📊</div>
        <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
            <?php _e('Page Not Found', 'retail-trade-scanner'); ?>
        </h1>
        <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 3rem;">
            <?php _e('The page you are looking for might have been moved, deleted, or does not exist.', 'retail-trade-scanner'); ?>
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                <?php _e('Go to Homepage', 'retail-trade-scanner'); ?>
            </a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('dashboard'))); ?>" class="btn btn-outline">
                <?php _e('Go to Dashboard', 'retail-trade-scanner'); ?>
            </a>
        </div>
        
        <div style="margin-top: 3rem; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">
                <?php _e('Try searching for what you need:', 'retail-trade-scanner'); ?>
            </h2>
            <?php get_search_form(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>