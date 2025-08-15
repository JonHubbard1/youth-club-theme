<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 */

get_header(); ?>

<main id="primary" class="site-main">
    
    <?php if (is_home() && is_front_page()) : ?>
        <!-- Hero Section for Homepage -->
        <section class="hero-section">
            <div class="hero-container">
                <h1 class="hero-title">
                    <?php 
                    $hero_title = get_theme_mod('hero_title', 'Supporting Young People Every Step of the Way');
                    echo esc_html($hero_title);
                    ?>
                </h1>
                <p class="hero-subtitle">
                    <?php 
                    $hero_subtitle = get_theme_mod('hero_subtitle', 'We provide comprehensive support, resources, and care for young people and their families in our community.');
                    echo esc_html($hero_subtitle);
                    ?>
                </p>
                <div class="hero-cta">
                    <a href="<?php echo esc_url(get_theme_mod('hero_primary_link', '#')); ?>" class="btn btn-primary">
                        <?php echo esc_html(get_theme_mod('hero_primary_text', 'Get Support')); ?>
                    </a>
                    <a href="<?php echo esc_url(get_theme_mod('hero_secondary_link', '#')); ?>" class="btn btn-secondary">
                        <?php echo esc_html(get_theme_mod('hero_secondary_text', 'Learn More')); ?>
                    </a>
                    <a href="<?php echo esc_url(get_theme_mod('donate_link', '#')); ?>" class="btn btn-donate">
                        <?php echo esc_html(get_theme_mod('donate_text', 'Donate Now')); ?>
                    </a>
                </div>
            </div>
        </section>

        <!-- Impact Statistics Section -->
        <section class="content-section stats-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Our Impact</h2>
                    <p class="section-subtitle">Together, we're making a real difference in young people's lives</p>
                </div>
                <div class="grid grid-4">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo esc_html(get_theme_mod('stat_1_number', '1,250')); ?></span>
                        <span class="stat-label"><?php echo esc_html(get_theme_mod('stat_1_label', 'Young People Supported')); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo esc_html(get_theme_mod('stat_2_number', '50')); ?></span>
                        <span class="stat-label"><?php echo esc_html(get_theme_mod('stat_2_label', 'Programs Running')); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo esc_html(get_theme_mod('stat_3_number', '15')); ?></span>
                        <span class="stat-label"><?php echo esc_html(get_theme_mod('stat_3_label', 'Years of Service')); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo esc_html(get_theme_mod('stat_4_number', '98%')); ?></span>
                        <span class="stat-label"><?php echo esc_html(get_theme_mod('stat_4_label', 'Satisfaction Rate')); ?></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="content-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Our Services</h2>
                    <p class="section-subtitle">Comprehensive support designed to meet the unique needs of every young person</p>
                </div>
                <div class="grid grid-3">
                    <div class="card">
                        <div class="card-icon">
                            <span>💙</span>
                        </div>
                        <h3 class="card-title">Health & Wellbeing</h3>
                        <p class="card-content">Supporting physical and mental health through specialised programmes and professional care.</p>
                        <a href="#" class="btn btn-secondary">Learn More</a>
                    </div>
                    <div class="card">
                        <div class="card-icon">
                            <span>🎓</span>
                        </div>
                        <h3 class="card-title">Education Support</h3>
                        <p class="card-content">Helping young people achieve their educational goals with tutoring and mentorship programmes.</p>
                        <a href="#" class="btn btn-secondary">Learn More</a>
                    </div>
                    <div class="card">
                        <div class="card-icon">
                            <span>🏠</span>
                        </div>
                        <h3 class="card-title">Family Support</h3>
                        <p class="card-content">Providing resources and guidance to families navigating challenging circumstances.</p>
                        <a href="#" class="btn btn-secondary">Learn More</a>
                    </div>
                </div>
            </div>
        </section>

    <?php endif; ?>

    <!-- Blog/Content Section -->
    <section class="content-section">
        <div class="container">
            <?php if (!is_front_page()) : ?>
                <div class="section-header">
                    <h1 class="section-title">
                        <?php 
                        if (is_home()) {
                            echo 'Latest News & Updates';
                        } else {
                            the_title();
                        }
                        ?>
                    </h1>
                </div>
            <?php endif; ?>

            <?php if (have_posts()) : ?>
                <div class="grid grid-2">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-featured-image">
                                    <?php the_post_thumbnail('medium', array('class' => 'img-responsive')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <header class="entry-header">
                                <?php if (is_singular()) : ?>
                                    <h1 class="entry-title"><?php the_title(); ?></h1>
                                <?php else : ?>
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h2>
                                <?php endif; ?>

                                <?php if ('post' === get_post_type()) : ?>
                                    <div class="entry-meta">
                                        <span class="posted-on">
                                            <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                <?php echo esc_html(get_the_date()); ?>
                                            </time>
                                        </span>
                                        <span class="byline">
                                            by <span class="author vcard"><?php the_author(); ?></span>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </header>

                            <div class="entry-content">
                                <?php
                                if (is_singular()) {
                                    the_content();
                                } else {
                                    the_excerpt();
                                }
                                ?>
                            </div>

                            <?php if (!is_singular()) : ?>
                                <footer class="entry-footer">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary">Read More</a>
                                </footer>
                            <?php endif; ?>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                // Pagination
                the_posts_pagination(array(
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">Page </span>',
                ));
                ?>

            <?php else : ?>
                <div class="no-posts">
                    <h2>Nothing here</h2>
                    <p>It seems we can't find what you're looking for. Perhaps searching can help.</p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
?>