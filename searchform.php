<?php
/**
 * Template for displaying search forms
 * Retail Trade Scanner Theme
 */
?>

<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="max-width: 400px; margin: 0 auto;">
    <div style="display: flex; gap: 0.5rem;">
        <input 
            type="search" 
            placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'retail-trade-scanner'); ?>"
            value="<?php echo get_search_query(); ?>" 
            name="s"
            style="flex: 1; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
        />
        <button 
            type="submit"
            class="btn btn-primary"
            style="padding: 0.75rem 1.5rem; white-space: nowrap;"
        >
            <?php echo esc_html_x('Search', 'submit button', 'retail-trade-scanner'); ?>
        </button>
    </div>
</form>