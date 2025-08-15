<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <section class="error-404 not-found content-section" style="text-align: center; padding: 4rem 0;">
            
            <div class="error-404-content">
                <div class="error-number" style="font-size: 8rem; font-weight: 700; color: #e74c3c; margin-bottom: 1rem; line-height: 1;">
                    404
                </div>
                
                <header class="page-header">
                    <h1 class="page-title section-title">
                        <?php esc_html_e("Oops! That page can't be found.", 'youth-club-theme'); ?>
                    </h1>
                </header>

                <div class="page-content">
                    <p class="section-subtitle" style="margin-bottom: 2rem;">
                        <?php esc_html_e('It looks like nothing was found at this location. Maybe try searching for what you need?', 'youth-club-theme'); ?>
                    </p>

                    <div class="search-form-container" style="max-width: 400px; margin: 0 auto 3rem;">
                        <?php get_search_form(); ?>
                    </div>

                    <div class="error-404-suggestions">
                        <h3 style="margin-bottom: 1.5rem; color: #2c3e50;">Here are some helpful links instead:</h3>
                        
                        <div class="grid grid-3" style="max-width: 800px; margin: 0 auto;">
                            <div class="card">
                                <div class="card-icon">
                                    <span>🏠</span>
                                </div>
                                <h4 class="card-title">Go Home</h4>
                                <p class="card-content">Return to our homepage to find what you're looking for.</p>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Home Page</a>
                            </div>
                            
                            <div class="card">
                                <div class="card-icon">
                                    <span>📖</span>
                                </div>
                                <h4 class="card-title">Browse Posts</h4>
                                <p class="card-content">Check out our latest news and updates.</p>
                                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-primary">View Blog</a>
                            </div>
                            
                            <div class="card">
                                <div class="card-icon">
                                    <span>📞</span>
                                </div>
                                <h4 class="card-title">Contact Us</h4>
                                <p class="card-content">Get in touch if you need help finding something.</p>
                                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">Contact</a>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Show recent posts
                    $recent_posts = new WP_Query(array(
                        'posts_per_page' => 3,
                        'post_status' => 'publish'
                    ));
                    
                    if ($recent_posts->have_posts()) : ?>
                        <div class="recent-posts-section" style="margin-top: 4rem;">
                            <h3 style="margin-bottom: 2rem; color: #2c3e50;">Or check out our recent posts:</h3>
                            <div class="grid grid-3">
                                <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                                    <article class="card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="card-featured-image" style="margin-bottom: 1rem;">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 150px; object-fit: cover; border-radius: 6px;')); ?>
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
                                            <?php echo wp_trim_words(get_the_excerpt(), 12, '...'); ?>
                                        </div>
                                        
                                        <a href="<?php the_permalink(); ?>" class="btn btn-secondary">Read More</a>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php 
                    endif;
                    wp_reset_postdata();
                    ?>

                </div>
            </div>
            
        </section>
    </div>
</main>

<?php
get_footer();
?>