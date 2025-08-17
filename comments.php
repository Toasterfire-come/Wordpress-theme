<?php
/**
 * The template for displaying comments
 * Retail Trade Scanner Theme
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area" style="margin-top: 3rem; padding-top: 3rem; border-top: 1px solid #e2e8f0;">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title" style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem; color: #0f172a;">
            <?php
            $retail_trade_scanner_comment_count = get_comments_number();
            if ('1' === $retail_trade_scanner_comment_count) {
                printf(
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'retail-trade-scanner'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $retail_trade_scanner_comment_count, 'comments title', 'retail-trade-scanner')),
                    number_format_i18n($retail_trade_scanner_comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list" style="list-style: none; margin: 0; padding: 0;">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'retail_trade_scanner_comment',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <p class="no-comments" style="background: #f8fafc; padding: 1rem; border-radius: 6px; color: #64748b; text-align: center;">
                <?php esc_html_e('Comments are closed.', 'retail-trade-scanner'); ?>
            </p>
            <?php
        endif;

    endif; // Check for have_comments().

    comment_form(array(
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">',
        'title_reply_after'  => '</h3>',
        'class_form'         => 'comment-form',
        'class_submit'       => 'btn btn-primary',
        'comment_field'      => '<p class="comment-form-comment"><label for="comment" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">' . _x('Comment', 'noun', 'retail-trade-scanner') . ' <span class="required">*</span></label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; resize: vertical;"></textarea></p>',
        'fields'             => array(
            'author' => '<p class="comment-form-author"><label for="author" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">' . __('Name', 'retail-trade-scanner') . ' <span class="required">*</span></label> <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name" required="required" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" /></p>',
            'email'  => '<p class="comment-form-email"><label for="email" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">' . __('Email', 'retail-trade-scanner') . ' <span class="required">*</span></label> <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" /></p>',
            'url'    => '<p class="comment-form-url"><label for="url" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">' . __('Website', 'retail-trade-scanner') . '</label> <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;" /></p>',
        ),
    ));
    ?>

</div>

<?php
/**
 * Custom comment callback function
 */
function retail_trade_scanner_comment($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>" style="margin-bottom: 2rem; padding: 1.5rem; background: white; border: 1px solid #e5e7eb; border-radius: 8px;">
    <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <div class="comment-author vcard" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <?php if (0 !== $args['avatar_size']) echo get_avatar($comment, $args['avatar_size'], '', '', array('style' => 'border-radius: 50%;')); ?>
            <div>
                <?php
                $comment_author_link = get_comment_author_link();
                if ('0000-00-00 00:00:00' !== get_comment_time('c')) :
                    ?>
                    <div style="font-weight: 600; color: #0f172a; margin-bottom: 0.25rem;"><?php echo $comment_author_link; ?></div>
                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>" style="color: #64748b; font-size: 0.875rem; text-decoration: none;">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php
                            printf(esc_html__('%1$s at %2$s', 'retail-trade-scanner'), get_comment_date('', $comment), get_comment_time());
                            ?>
                        </time>
                    </a>
                    <?php
                endif;
                ?>
            </div>
        </div>

        <?php if ('0' === $comment->comment_approved) : ?>
            <em class="comment-awaiting-moderation" style="background: #fef3c7; color: #92400e; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; display: block; margin-bottom: 1rem;">
                <?php esc_html_e('Your comment is awaiting moderation.', 'retail-trade-scanner'); ?>
            </em>
        <?php endif; ?>

        <div class="comment-content" style="line-height: 1.6;">
            <?php comment_text(); ?>
        </div>

        <?php
        comment_reply_link(array_merge($args, array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'class'     => 'btn btn-outline',
            'style'     => 'font-size: 0.875rem; margin-top: 1rem;'
        )));
        ?>
    </div>
    <?php
}