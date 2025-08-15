<?php
/**
 * The header for our theme
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'youth-club-theme'); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                if ($custom_logo_id) {
                    echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
                        'class' => 'custom-logo',
                        'alt' => get_bloginfo('name')
                    ));
                } else {
                    ?>
                    <div class="site-logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </div>
                    <?php
                }
                
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) :
                    ?>
                    <p class="site-description sr-only"><?php echo $description; ?></p>
                    <?php
                endif;
                ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="sr-only"><?php esc_html_e('Menu', 'youth-club-theme'); ?></span>
                    <span class="menu-icon">☰</span>
                </button>
                
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => 'youth_club_theme_fallback_menu',
                ));
                ?>
            </nav>

            <!-- Header CTA Button -->
            <?php 
            $header_cta_text = get_theme_mod('header_cta_text', '');
            $header_cta_link = get_theme_mod('header_cta_link', '');
            if ($header_cta_text && $header_cta_link) : 
            ?>
                <div class="header-cta">
                    <a href="<?php echo esc_url($header_cta_link); ?>" class="btn btn-donate">
                        <?php echo esc_html($header_cta_text); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <div id="content" class="site-content">