<?php
/**
 * The template for displaying search results pages
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        <header class="page-header" style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'retail-trade-scanner'),
                    '<span style="color: #059669;">"' . get_search_query() . '"</span>'
                );
                ?>
            </h1>
            <?php get_search_form(); ?>
        </header>

        <?php if (have_posts()) : ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> style="padding: 2rem;">
                        <header class="entry-header">
                            <?php the_title(sprintf('<h2 class="entry-title" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;"><a href="%s" rel="bookmark" style="text-decoration: none; color: #0f172a;">', esc_url(get_permalink())), '</a></h2>'); ?>
                            
                            <div class="entry-meta" style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem;">
                                <span><?php echo get_the_date(); ?></span>
                                <span style="margin: 0 0.5rem;">•</span>
                                <span><?php the_author(); ?></span>
                            </div>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail" style="margin-bottom: 1rem;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 200px; object-fit: cover; border-radius: 8px;')); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-summary" style="line-height: 1.6;">
                            <?php the_excerpt(); ?>
                        </div>

                        <footer class="entry-footer" style="margin-top: 1rem;">
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="font-size: 0.875rem;">
                                <?php _e('Read More', 'retail-trade-scanner'); ?>
                            </a>
                        </footer>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            the_posts_navigation(array(
                'prev_text' => __('← Older Results', 'retail-trade-scanner'),
                'next_text' => __('Newer Results →', 'retail-trade-scanner'),
            ));
            ?>

        <?php else : ?>
            <section class="no-results not-found" style="text-align: center; padding: 3rem; background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <header class="page-header">
                    <h1 style="font-size: 2rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                        <?php _e('Nothing here', 'retail-trade-scanner'); ?>
                    </h1>
                </header>

                <div class="page-content">
                    <p style="font-size: 1.125rem; color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'retail-trade-scanner'); ?>
                    </p>
                    <?php get_search_form(); ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>