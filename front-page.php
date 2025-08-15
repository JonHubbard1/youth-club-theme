<?php
/**
 * The front page template file
 * 
 * This template will be used for the site's front page, whether it displays the blog index or a static page.
 */

get_header(); ?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
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
                <a href="<?php echo esc_url(get_theme_mod('hero_primary_link', '#services')); ?>" class="btn btn-primary">
                    <?php echo esc_html(get_theme_mod('hero_primary_text', 'Get Support')); ?>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('hero_secondary_link', '#about')); ?>" class="btn btn-secondary">
                    <?php echo esc_html(get_theme_mod('hero_secondary_text', 'Learn More')); ?>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('donate_link', '/donate')); ?>" class="btn btn-donate">
                    <?php echo esc_html(get_theme_mod('donate_text', 'Donate Now')); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Impact Statistics Section -->
    <section class="content-section stats-section" id="impact">
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

    <!-- About Section -->
    <section class="content-section" id="about">
        <div class="container">
            <div class="grid grid-2">
                <div class="about-content">
                    <h2 class="section-title"><?php echo esc_html(get_theme_mod('about_title', 'About Our Mission')); ?></h2>
                    <p><?php echo esc_html(get_theme_mod('about_paragraph_1', 'We believe every young person deserves the opportunity to thrive, regardless of their circumstances. Our dedicated team works tirelessly to provide comprehensive support, resources, and care that makes a lasting difference.')); ?></p>
                    <p><?php echo esc_html(get_theme_mod('about_paragraph_2', 'Through innovative programmes, compassionate care, and community partnerships, we\'ve been supporting young people and their families for over a decade. Our approach is holistic, addressing not just immediate needs but building foundations for long-term success.')); ?></p>
                    <div class="about-features">
                        <?php for ($i = 1; $i <= 4; $i++) : ?>
                            <div class="feature-item">
                                <span class="feature-icon">✓</span>
                                <span><?php echo esc_html(get_theme_mod("about_feature_{$i}", '')); ?></span>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <a href="<?php echo esc_url(get_theme_mod('about_button_link', '/about')); ?>" class="btn btn-primary"><?php echo esc_html(get_theme_mod('about_button_text', 'Learn More About Us')); ?></a>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/about-placeholder.jpg" alt="Young people in our programs" style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px; background-color: #f8f9fa;">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="content-section" style="background-color: #f8f9fa;" id="services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_theme_mod('services_title', 'Our Services')); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_theme_mod('services_subtitle', 'Comprehensive support designed to meet the unique needs of every young person')); ?></p>
            </div>
            <div class="grid grid-3">
                <?php for ($i = 1; $i <= 3; $i++) : ?>
                    <div class="card">
                        <div class="card-icon">
                            <span><?php echo esc_html(get_theme_mod("service_{$i}_icon", '')); ?></span>
                        </div>
                        <h3 class="card-title"><?php echo esc_html(get_theme_mod("service_{$i}_title", '')); ?></h3>
                        <p class="card-content"><?php echo esc_html(get_theme_mod("service_{$i}_description", '')); ?></p>
                        <?php 
                        $features = get_theme_mod("service_{$i}_features", '');
                        if ($features) :
                            $feature_lines = explode("\n", $features);
                        ?>
                            <ul style="list-style: none; padding: 0; margin: 1rem 0;">
                                <?php foreach ($feature_lines as $feature) : ?>
                                    <?php if (trim($feature)) : ?>
                                        <li>• <?php echo esc_html(trim($feature)); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(get_theme_mod("service_{$i}_link", '#')); ?>" class="btn btn-secondary">Learn More</a>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="content-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_theme_mod('testimonials_title', 'Stories of Hope')); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_theme_mod('testimonials_subtitle', 'Hear from the families and young people whose lives have been transformed')); ?></p>
            </div>
            <div class="grid grid-2">
                <?php for ($i = 1; $i <= 2; $i++) : ?>
                    <div class="testimonial">
                        <div class="testimonial-content">
                            "<?php echo esc_html(get_theme_mod("testimonial_{$i}_content", '')); ?>"
                        </div>
                        <div class="testimonial-author"><?php echo esc_html(get_theme_mod("testimonial_{$i}_author", '')); ?></div>
                        <div class="testimonial-role"><?php echo esc_html(get_theme_mod("testimonial_{$i}_role", '')); ?></div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="content-section" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Latest News & Updates</h2>
                <p class="section-subtitle">Stay informed about our programs, events, and community impact</p>
            </div>
            
            <?php
            // Get latest 3 posts
            $latest_posts = new WP_Query(array(
                'posts_per_page' => 3,
                'post_status' => 'publish'
            ));
            
            if ($latest_posts->have_posts()) : ?>
                <div class="grid grid-3">
                    <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                        <article class="card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-featured-image" style="margin-bottom: 1rem;">
                                    <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 200px; object-fit: cover; border-radius: 6px;')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
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
                
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn btn-primary">View All News</a>
                </div>
            <?php 
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="content-section" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white;">
        <div class="container" style="text-align: center;">
            <h2 class="section-title" style="color: white; margin-bottom: 1rem;">Ready to Make a Difference?</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.9); margin-bottom: 2rem;">
                Whether you need support, want to volunteer, or wish to donate, there are many ways to get involved with our mission.
            </p>
            <div class="hero-cta">
                <a href="/get-support" class="btn btn-primary">Get Support</a>
                <a href="/volunteer" class="btn btn-secondary">Volunteer</a>
                <a href="/donate" class="btn" style="background-color: #f39c12; color: white; border-color: #f39c12;">Donate</a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>