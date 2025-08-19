<?php
/**
 * The template for displaying all pages
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="text-align: center; margin-bottom: 3rem;">
                    <h1 class="entry-title" style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                        <?php the_title(); ?>
                    </h1>
                    <?php if (get_the_excerpt()) : ?>
                        <div style="font-size: 1.25rem; color: #64748b;">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="entry-content" style="max-width: 800px; margin: 0 auto;">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links" style="margin-top: 2rem; text-align: center;">' . esc_html__('Pages:', 'retail-trade-scanner'),
                        'after'  => '</div>',
                        'link_before' => '<span class="btn btn-outline" style="margin: 0 0.25rem;">',
                        'link_after' => '</span>',
                    ));
                    ?>
                </div>
            </article>
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