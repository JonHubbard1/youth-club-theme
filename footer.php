<?php
/**
 * The template for displaying the footer
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                
                <!-- About Section -->
                <div class="footer-section">
                    <h3><?php echo esc_html(get_theme_mod('footer_about_title', 'About Us')); ?></h3>
                    <p><?php echo esc_html(get_theme_mod('footer_about_text', 'We are dedicated to supporting young people and their families with comprehensive care, resources, and programs designed to help them thrive.')); ?></p>
                    
                    <!-- Registration Numbers -->
                    <?php 
                    $charity_number = get_theme_mod('charity_number', '');
                    $company_number = get_theme_mod('company_number', '');
                    
                    if ($charity_number || $company_number) : ?>
                        <div class="registration-numbers">
                            <?php if ($charity_number) : ?>
                                <p class="charity-number">Registered Charity No: <?php echo esc_html($charity_number); ?></p>
                            <?php endif; ?>
                            
                            <?php if ($company_number) : ?>
                                <p class="company-number">Company No: <?php echo esc_html($company_number); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Social Media Links -->
                    <div class="social-links">
                        <?php 
                        $social_links = array(
                            'facebook' => get_theme_mod('social_facebook', ''),
                            'twitter' => get_theme_mod('social_twitter', ''),
                            'instagram' => get_theme_mod('social_instagram', ''),
                            'linkedin' => get_theme_mod('social_linkedin', ''),
                        );
                        
                        foreach ($social_links as $platform => $url) {
                            if ($url) {
                                echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener" class="social-link">' . ucfirst($platform) . '</a> ';
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3><?php echo esc_html(get_theme_mod('footer_links_title', 'Quick Links')); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-links',
                        'container'      => false,
                        'fallback_cb'    => 'youth_club_theme_footer_fallback_menu',
                        'depth'          => 1,
                    ));
                    ?>
                </div>

                <!-- Services -->
                <div class="footer-section">
                    <h3><?php echo esc_html(get_theme_mod('footer_services_title', 'Our Services')); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-services',
                        'container'      => false,
                        'fallback_cb'    => 'youth_club_theme_services_fallback_menu',
                        'depth'          => 1,
                    ));
                    ?>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h3><?php echo esc_html(get_theme_mod('footer_contact_title', 'Contact Us')); ?></h3>
                    <div class="contact-info">
                        <?php 
                        $phone = get_theme_mod('contact_phone', '');
                        $email = get_theme_mod('contact_email', '');
                        $address = get_theme_mod('contact_address', '');
                        ?>
                        
                        <?php if ($phone) : ?>
                            <p><strong>Phone:</strong> <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
                        <?php endif; ?>
                        
                        <?php if ($email) : ?>
                            <p><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                        <?php endif; ?>
                        
                        <?php if ($address) : ?>
                            <p><strong>Address:</strong><br><?php echo nl2br(esc_html($address)); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <?php 
    // Funding Partners Section - Outside footer for full width
    if (get_theme_mod('funding_partners_enable', false)) :
                $visible_logos = array();
                
                // Collect all visible logos
                for ($i = 1; $i <= 12; $i++) {
                    $logo_id = get_theme_mod("funding_logo_{$i}", '');
                    $logo_name = get_theme_mod("funding_logo_{$i}_name", '');
                    $logo_url = get_theme_mod("funding_logo_{$i}_url", '');
                    $logo_visible = get_theme_mod("funding_logo_{$i}_visible", true);
                    
                    if ($logo_id && $logo_visible) {
                        $visible_logos[] = array(
                            'id' => $logo_id,
                            'name' => $logo_name,
                            'url' => $logo_url
                        );
                    }
                }
                
                if (!empty($visible_logos)) :
                    $bg_color = get_theme_mod('funding_partners_bg_color', '#f8f9fa');
                    $title = get_theme_mod('funding_partners_title', 'Supported By');
            ?>
                <?php 
                // Calculate if we need dark or light text based on background
                $bg_hex = str_replace('#', '', $bg_color);
                $r = hexdec(substr($bg_hex, 0, 2));
                $g = hexdec(substr($bg_hex, 2, 2));
                $b = hexdec(substr($bg_hex, 4, 2));
                $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
                $text_color = ($brightness > 128) ? '#333333' : '#ffffff';
                ?>
                <div class="funding-partners-section" style="background-color: <?php echo esc_attr($bg_color); ?>;">
                    <div class="container">
                        <?php if ($title) : ?>
                            <h3 class="funding-partners-title" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                        
                        <div class="funding-partners-grid" data-count="<?php echo count($visible_logos); ?>">
                            <?php foreach ($visible_logos as $logo) : 
                                $logo_image = wp_get_attachment_image_src($logo['id'], 'full');
                                if ($logo_image) :
                            ?>
                                <div class="funding-partner-logo">
                                    <?php if ($logo['url']) : ?>
                                        <a href="<?php echo esc_url($logo['url']); ?>" 
                                           target="_blank" 
                                           rel="noopener"
                                           title="<?php echo esc_attr($logo['name']); ?>">
                                    <?php endif; ?>
                                    
                                    <img src="<?php echo esc_url($logo_image[0]); ?>" 
                                         alt="<?php echo esc_attr($logo['name'] ?: 'Partner organization'); ?>"
                                         title="<?php echo esc_attr($logo['name']); ?>">
                                    
                                    <?php if ($logo['url']) : ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php 
                                endif;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php 
                endif;
            endif; 
            ?>

    <footer id="colophon-bottom" class="site-footer-bottom">
        <div class="container">
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                    <?php echo esc_html(get_theme_mod('footer_copyright_text', 'All rights reserved.')); ?></p>
                    
                    <div class="footer-bottom-links">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-legal',
                            'container'      => false,
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.querySelector('.mobile-menu-toggle');
    const navigation = document.querySelector('.main-navigation');
    
    if (toggleButton && navigation) {
        toggleButton.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            navigation.classList.toggle('active');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!navigation.contains(event.target) && !toggleButton.contains(event.target)) {
            navigation.classList.remove('active');
            toggleButton.setAttribute('aria-expanded', 'false');
        }
    });
    
    // Close mobile menu when pressing escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && navigation.classList.contains('active')) {
            navigation.classList.remove('active');
            toggleButton.setAttribute('aria-expanded', 'false');
            toggleButton.focus();
        }
    });
});

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const target = document.querySelector(href);
            
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<?php wp_footer(); ?>

</body>
</html>