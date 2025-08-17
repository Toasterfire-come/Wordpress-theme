<?php
/**
 * The template for displaying all single posts
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 2rem 1rem;">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="margin-bottom: 2rem;">
                    <?php
                    if (is_singular()) :
                        the_title('<h1 class="entry-title" style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">', '</h1>');
                    else :
                        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    endif;
                    ?>
                    
                    <div class="entry-meta" style="color: #64748b; font-size: 0.875rem;">
                        <span><?php _e('Posted on', 'retail-trade-scanner'); ?> <?php echo get_the_date(); ?></span>
                        <span style="margin: 0 0.5rem;">•</span>
                        <span><?php _e('by', 'retail-trade-scanner'); ?> <?php the_author(); ?></span>
                        <?php if (has_category()) : ?>
                            <span style="margin: 0 0.5rem;">•</span>
                            <span><?php the_category(', '); ?></span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail" style="margin-bottom: 2rem;">
                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; border-radius: 12px;')); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content" style="line-height: 1.7;">
                    <?php
                    the_content(sprintf(
                        wp_kses(
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'retail-trade-scanner'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    ));

                    wp_link_pages(array(
                        'before' => '<div class="page-links" style="margin-top: 2rem; text-align: center;">' . esc_html__('Pages:', 'retail-trade-scanner'),
                        'after'  => '</div>',
                        'link_before' => '<span class="btn btn-outline" style="margin: 0 0.25rem;">',
                        'link_after' => '</span>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                    <?php if (has_tag()) : ?>
                        <div style="margin-bottom: 1rem;">
                            <strong><?php _e('Tags:', 'retail-trade-scanner'); ?></strong>
                            <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>
                </footer>
            </article>

            <nav class="post-navigation" style="margin-top: 3rem; display: flex; justify-content: space-between;">
                <?php
                the_post_navigation(array(
                    'prev_text' => '<span style="color: #64748b;">← ' . __('Previous Post', 'retail-trade-scanner') . '</span><br><span style="font-weight: 600;">%title</span>',
                    'next_text' => '<span style="color: #64748b;">' . __('Next Post', 'retail-trade-scanner') . ' →</span><br><span style="font-weight: 600;">%title</span>',
                ));
                ?>
            </nav>
            
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>