<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('content-section'); ?>>
                
                <header class="entry-header">
                    <h1 class="entry-title section-title"><?php the_title(); ?></h1>
                    
                    <div class="entry-meta" style="color: #7f8c8d; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                        <span class="posted-on">
                            <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                            <?php if (get_the_date() !== get_the_modified_date()) : ?>
                                <time class="updated" datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                    (Updated: <?php echo esc_html(get_the_modified_date()); ?>)
                                </time>
                            <?php endif; ?>
                        </span>
                        
                        <span class="byline">
                            by <span class="author vcard">
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php echo esc_html(get_the_author()); ?>
                                </a>
                            </span>
                        </span>
                        
                        <?php if (has_category()) : ?>
                            <span class="cat-links">
                                in <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="entry-featured-image">
                            <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 2rem;')); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                    
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'youth-club-theme'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <?php if (has_tag()) : ?>
                        <div class="tags-links" style="margin-bottom: 1rem;">
                            <strong>Tags:</strong> <?php the_tags('', ', '); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (get_edit_post_link()) : ?>
                        <div class="edit-link">
                            <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        __('Edit <span class="screen-reader-text">%s</span>', 'youth-club-theme'),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    get_the_title()
                                ),
                                '<span class="edit-link">',
                                '</span>'
                            );
                            ?>
                        </div>
                    <?php endif; ?>
                </footer>
                
            </article>

            <!-- Post Navigation -->
            <nav class="post-navigation" style="margin: 3rem 0;">
                <div class="grid grid-2">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ($prev_post) : ?>
                        <div class="nav-previous card">
                            <div style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 0.5rem;">← Previous Post</div>
                            <h4><a href="<?php echo get_permalink($prev_post); ?>"><?php echo get_the_title($prev_post); ?></a></h4>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($next_post) : ?>
                        <div class="nav-next card" style="text-align: right;">
                            <div style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 0.5rem;">Next Post →</div>
                            <h4><a href="<?php echo get_permalink($next_post); ?>"><?php echo get_the_title($next_post); ?></a></h4>
                        </div>
                    <?php endif; ?>
                </div>
            </nav>

            <!-- Author Bio -->
            <?php if (get_the_author_meta('description')) : ?>
                <div class="author-bio card" style="margin: 3rem 0;">
                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('style' => 'border-radius: 50%;')); ?>
                        </div>
                        <div class="author-info">
                            <h3 style="margin-bottom: 0.5rem;">About <?php echo esc_html(get_the_author()); ?></h3>
                            <p><?php echo wp_kses_post(get_the_author_meta('description')); ?></p>
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="btn btn-secondary">
                                View All Posts by <?php echo esc_html(get_the_author()); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Related Posts -->
            <?php
            $categories = get_the_category();
            if ($categories) {
                $category_ids = array();
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }
                
                $related_posts = new WP_Query(array(
                    'category__in' => $category_ids,
                    'post__not_in' => array(get_the_ID()),
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1
                ));
                
                if ($related_posts->have_posts()) : ?>
                    <section class="related-posts" style="margin: 3rem 0;">
                        <h3 class="section-title">Related Posts</h3>
                        <div class="grid grid-3">
                            <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                                <article class="card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="card-featured-image" style="margin-bottom: 1rem;">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 200px; object-fit: cover; border-radius: 6px;')); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h4 class="card-title">
                                        <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                    
                                    <div class="card-meta" style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 1rem;">
                                        <?php echo get_the_date(); ?>
                                    </div>
                                    
                                    <div class="card-content">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary">Read More</a>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </section>
                <?php 
                endif;
                wp_reset_postdata();
            }
            ?>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; // End of the loop. ?>
        
    </div>
</main>

<?php
get_footer();
?>