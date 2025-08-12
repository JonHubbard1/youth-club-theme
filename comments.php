<?php
/**
 * The template for displaying comments
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #eee;">

    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ($comment_count === 1) {
                printf(
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'youth-club-theme'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'youth-club-theme'
                    )),
                    number_format_i18n($comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h3>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list" style="list-style: none; padding: 0;">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'youth_club_theme_comment_callback',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note.
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'youth-club-theme'); ?></p>
            <?php
        endif;

    endif; // Check for have_comments().

    // Comment form
    $comment_form_args = array(
        'title_reply'          => esc_html__('Leave a Reply', 'youth-club-theme'),
        'title_reply_to'       => esc_html__('Leave a Reply to %s', 'youth-club-theme'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after'    => '</h3>',
        'cancel_reply_before'  => ' <small>',
        'cancel_reply_after'   => '</small>',
        'cancel_reply_link'    => esc_html__('Cancel reply', 'youth-club-theme'),
        'label_submit'         => esc_html__('Post Comment', 'youth-club-theme'),
        'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary" value="%4$s">%4$s</button>',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comment', 'youth-club-theme') . ' <span class="required">*</span></label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" class="eyc-form-control"></textarea></p>',
        'fields' => array(
            'author' => '<p class="comment-form-author"><label for="author">' . esc_html__('Name', 'youth-club-theme') . ' <span class="required">*</span></label> <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name" required="required" class="eyc-form-control" /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'youth-club-theme') . ' <span class="required">*</span></label> <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" class="eyc-form-control" /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__('Website', 'youth-club-theme') . '</label> <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" class="eyc-form-control" /></p>',
        ),
        'class_container' => 'comment-respond card',
        'class_form' => 'comment-form',
        'format' => 'html5',
    );

    comment_form($comment_form_args);
    ?>

</div>

<?php
// Custom comment callback function
if (!function_exists('youth_club_theme_comment_callback')) :
    function youth_club_theme_comment_callback($comment, $args, $depth) {
        $tag = ($args['style'] === 'div') ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('comment card', $comment); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <?php 
                        if ($args['avatar_size'] != 0) {
                            echo get_avatar($comment, 60, '', '', array('class' => 'avatar', 'style' => 'border-radius: 50%;'));
                        }
                        ?>
                        <div class="comment-metadata">
                            <b class="fn"><?php comment_author_link(); ?></b>
                            <div class="comment-meta-details" style="color: #7f8c8d; font-size: 0.9rem;">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php
                                    printf(
                                        esc_html__('%1$s at %2$s', 'youth-club-theme'),
                                        get_comment_date('', $comment),
                                        get_comment_time()
                                    );
                                    ?>
                                </time>
                                <?php edit_comment_link(esc_html__('Edit', 'youth-club-theme'), ' <span aria-label="' . esc_attr__('Edit comment', 'youth-club-theme') . '">', '</span>'); ?>
                            </div>
                        </div>
                    </div>
                </footer>

                <div class="comment-content">
                    <?php if ($comment->comment_approved == '0') : ?>
                        <em class="comment-awaiting-moderation" style="color: #f39c12;"><?php esc_html_e('Your comment is awaiting moderation.', 'youth-club-theme'); ?></em>
                    <?php endif; ?>

                    <?php comment_text(); ?>
                </div>

                <div class="reply" style="margin-top: 1rem;">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>',
                        'reply_text' => esc_html__('Reply', 'youth-club-theme'),
                        'login_text' => esc_html__('Log in to Reply', 'youth-club-theme'),
                        'class'     => 'btn btn-secondary',
                    )));
                    ?>
                </div>
            </article>
        <?php
    }
endif;
?>