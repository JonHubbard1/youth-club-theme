<?php
/**
 * Youth Club Theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function youth_club_theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // This theme uses wp_nav_menu() in multiple locations.
    register_nav_menus(array(
        'primary'        => esc_html__('Header Navigation Menu', 'youth-club-theme'),
        'footer-links'   => esc_html__('Footer - Quick Links Column', 'youth-club-theme'),
        'footer-services' => esc_html__('Footer - Services Column', 'youth-club-theme'),
        'footer-legal'   => esc_html__('Footer - Bottom Legal Links (Privacy, Terms, etc.)', 'youth-club-theme'),
    ));

    // Switch default core markup for search form, comment form, and comments
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom background feature.
    add_theme_support('custom-background', apply_filters('youth_club_theme_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');

    // Add support for wide alignment
    add_theme_support('align-wide');

    // Add support for block editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Primary Red', 'youth-club-theme'),
            'slug'  => 'primary-red',
            'color' => '#e74c3c',
        ),
        array(
            'name'  => esc_html__('Dark Blue', 'youth-club-theme'),
            'slug'  => 'dark-blue',
            'color' => '#2c3e50',
        ),
        array(
            'name'  => esc_html__('Light Blue', 'youth-club-theme'),
            'slug'  => 'light-blue',
            'color' => '#3498db',
        ),
        array(
            'name'  => esc_html__('Orange', 'youth-club-theme'),
            'slug'  => 'orange',
            'color' => '#f39c12',
        ),
        array(
            'name'  => esc_html__('Light Gray', 'youth-club-theme'),
            'slug'  => 'light-gray',
            'color' => '#f8f9fa',
        ),
    ));
}
add_action('after_setup_theme', 'youth_club_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function youth_club_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters('youth_club_theme_content_width', 1200);
}
add_action('after_setup_theme', 'youth_club_theme_content_width', 0);

/**
 * Register widget area.
 */
function youth_club_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'youth-club-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'youth-club-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 1', 'youth-club-theme'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here for the first footer column.', 'youth-club-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 2', 'youth-club-theme'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here for the second footer column.', 'youth-club-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'youth_club_theme_widgets_init');

/**
 * Calculate contrasting colours based on background colour
 */
function youth_club_theme_calculate_contrast_colors($bg_color) {
    // Remove # if present
    $hex = str_replace('#', '', $bg_color);
    
    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Calculate brightness using standard formula
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
    
    // Determine if background is light or dark
    $is_light = $brightness > 128;
    
    return array(
        'text' => $is_light ? '#333333' : '#ecf0f1',
        'heading' => $is_light ? '#2c3e50' : '#ffffff',
        'link' => $is_light ? '#666666' : '#bdc3c7',
        'link_hover' => '#e74c3c', // Always use primary colour for hover
        'border' => $is_light ? '#e0e0e0' : '#34495e'
    );
}

/**
 * Enqueue scripts and styles.
 */
function youth_club_theme_scripts() {
    wp_enqueue_style('youth-club-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    // Add Google Fonts
    wp_enqueue_style('youth-club-theme-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);

    wp_enqueue_script('youth-club-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get('Version'), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'youth_club_theme_scripts');

/**
 * Fallback menu for primary navigation
 */
function youth_club_theme_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    if (get_option('show_on_front') == 'page') {
        echo '<li><a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Blog</a></li>';
    }
    wp_list_pages(array(
        'title_li' => '',
        'walker'   => '',
    ));
    echo '</ul>';
}

/**
 * Fallback menu for footer links
 */
function youth_club_theme_footer_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">Contact</a></li>';
    echo '</ul>';
}

/**
 * Fallback menu for footer services
 */
function youth_club_theme_services_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="#">Health Support</a></li>';
    echo '<li><a href="#">Education Programs</a></li>';
    echo '<li><a href="#">Family Services</a></li>';
    echo '<li><a href="#">Community Outreach</a></li>';
    echo '</ul>';
}

/**
 * Customizer additions.
 */
function youth_club_theme_customize_register($wp_customize) {
    
    // Remove default WordPress Colors section to avoid duplication
    $wp_customize->remove_section('colors');
    
    // Enhanced Logo Settings
    $wp_customize->add_section('logo_settings', array(
        'title'    => __('Logo & Branding', 'youth-club-theme'),
        'priority' => 25,
    ));

    $wp_customize->add_setting('custom_logo_height', array(
        'default'           => '80',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('custom_logo_height', array(
        'label'       => __('Logo Height (px)', 'youth-club-theme'),
        'section'     => 'logo_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 40,
            'max'  => 200,
            'step' => 5,
        ),
    ));

    $wp_customize->add_setting('logo_margin_bottom', array(
        'default'           => '20',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('logo_margin_bottom', array(
        'label'       => __('Logo Bottom Margin (px)', 'youth-club-theme'),
        'section'     => 'logo_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 5,
        ),
    ));

    // Colour Scheme Section
    $wp_customize->add_section('color_scheme', array(
        'title'    => __('Colour Scheme', 'youth-club-theme'),
        'priority' => 26,
    ));

    // Primary colors
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#e74c3c',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => __('Primary Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'primary_color',
    )));

    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => __('Secondary Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'secondary_color',
    )));

    $wp_customize->add_setting('accent_color', array(
        'default'           => '#3498db',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'    => __('Accent Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'accent_color',
    )));

    // Text colours
    $wp_customize->add_setting('heading_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'heading_color', array(
        'label'    => __('Heading Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'heading_color',
    )));

    $wp_customize->add_setting('body_text_color', array(
        'default'           => '#555555',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'body_text_color', array(
        'label'    => __('Body Text Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'body_text_color',
    )));

    $wp_customize->add_setting('link_color', array(
        'default'           => '#3498db',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'link_color', array(
        'label'    => __('Link Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'link_color',
    )));

    // Background colours
    $wp_customize->add_setting('header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bg_color', array(
        'label'    => __('Header Background Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'header_bg_color',
    )));

    $wp_customize->add_setting('footer_bg_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array(
        'label'    => __('Footer Background Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'footer_bg_color',
    )));

    // Page Background Colour (replaces WordPress default)
    $wp_customize->add_setting('background_color', array(
        'default'           => 'ffffff',
        'sanitize_callback' => 'sanitize_hex_color_no_hash',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'background_color', array(
        'label'    => __('Page Background Colour', 'youth-club-theme'),
        'section'  => 'color_scheme',
        'settings' => 'background_color',
    )));

    // Typography Section
    $wp_customize->add_section('typography', array(
        'title'    => __('Typography', 'youth-club-theme'),
        'priority' => 27,
    ));

    // Font families
    $font_choices = array(
        'Inter, sans-serif' => 'Inter (Default)',
        'Arial, sans-serif' => 'Arial',
        'Helvetica, sans-serif' => 'Helvetica',
        'Georgia, serif' => 'Georgia',
        'Times New Roman, serif' => 'Times New Roman',
        'Trebuchet MS, sans-serif' => 'Trebuchet MS',
        'Verdana, sans-serif' => 'Verdana',
        'Roboto, sans-serif' => 'Roboto',
        'Open Sans, sans-serif' => 'Open Sans',
        'Lato, sans-serif' => 'Lato',
        'Montserrat, sans-serif' => 'Montserrat',
        'Playfair Display, serif' => 'Playfair Display',
        'Merriweather, serif' => 'Merriweather',
    );

    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Inter, sans-serif',
        'sanitize_callback' => 'youth_club_theme_sanitize_font_choice',
    ));

    $wp_customize->add_control('heading_font', array(
        'label'    => __('Heading Font', 'youth-club-theme'),
        'section'  => 'typography',
        'type'     => 'select',
        'choices'  => $font_choices,
    ));

    $wp_customize->add_setting('body_font', array(
        'default'           => 'Inter, sans-serif',
        'sanitize_callback' => 'youth_club_theme_sanitize_font_choice',
    ));

    $wp_customize->add_control('body_font', array(
        'label'    => __('Body Font', 'youth-club-theme'),
        'section'  => 'typography',
        'type'     => 'select',
        'choices'  => $font_choices,
    ));

    // Font sizes
    $wp_customize->add_setting('heading_font_size', array(
        'default'           => '32',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('heading_font_size', array(
        'label'       => __('Main Heading Size (px)', 'youth-club-theme'),
        'section'     => 'typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 24,
            'max'  => 72,
            'step' => 2,
        ),
    ));

    $wp_customize->add_setting('body_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('body_font_size', array(
        'label'       => __('Body Font Size (px)', 'youth-club-theme'),
        'section'     => 'typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('line_height', array(
        'default'           => '1.6',
        'sanitize_callback' => 'youth_club_theme_sanitize_float',
    ));

    $wp_customize->add_control('line_height', array(
        'label'       => __('Line Height', 'youth-club-theme'),
        'section'     => 'typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1.2,
            'max'  => 2.5,
            'step' => 0.1,
        ),
    ));

    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section', 'youth-club-theme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Supporting Young People Every Step of the Way',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'    => __('Hero Title', 'youth-club-theme'),
        'section'  => 'hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'We provide comprehensive support, resources, and care for young people and their families in our community.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'youth-club-theme'),
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('hero_primary_text', array(
        'default'           => 'Get Support',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_primary_text', array(
        'label'    => __('Primary Button Text', 'youth-club-theme'),
        'section'  => 'hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('hero_primary_link', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_primary_link', array(
        'label'    => __('Primary Button Link', 'youth-club-theme'),
        'section'  => 'hero_section',
        'type'     => 'url',
    ));

    // Statistics Section
    $wp_customize->add_section('stats_section', array(
        'title'    => __('Impact Statistics', 'youth-club-theme'),
        'priority' => 35,
    ));

    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("stat_{$i}_number", array(
            'default'           => $i == 1 ? '1,250' : ($i == 2 ? '50' : ($i == 3 ? '15' : '98%')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("stat_{$i}_number", array(
            'label'    => sprintf(__('Statistic %d Number', 'youth-club-theme'), $i),
            'section'  => 'stats_section',
            'type'     => 'text',
        ));

        $wp_customize->add_setting("stat_{$i}_label", array(
            'default'           => $i == 1 ? 'Young People Supported' : ($i == 2 ? 'Programs Running' : ($i == 3 ? 'Years of Service' : 'Satisfaction Rate')),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("stat_{$i}_label", array(
            'label'    => sprintf(__('Statistic %d Label', 'youth-club-theme'), $i),
            'section'  => 'stats_section',
            'type'     => 'text',
        ));
    }

    // Contact Information
    $wp_customize->add_section('contact_info', array(
        'title'    => __('Contact Information', 'youth-club-theme'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'    => __('Phone Number', 'youth-club-theme'),
        'section'  => 'contact_info',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'    => __('Email Address', 'youth-club-theme'),
        'section'  => 'contact_info',
        'type'     => 'email',
    ));

    $wp_customize->add_setting('contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label'    => __('Address', 'youth-club-theme'),
        'section'  => 'contact_info',
        'type'     => 'textarea',
    ));

    // Social Media Links
    $wp_customize->add_section('social_media', array(
        'title'    => __('Social Media', 'youth-club-theme'),
        'priority' => 45,
    ));

    $social_platforms = array('facebook', 'twitter', 'instagram', 'linkedin');
    foreach ($social_platforms as $platform) {
        $wp_customize->add_setting("social_{$platform}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_{$platform}", array(
            'label'    => sprintf(__('%s URL', 'youth-club-theme'), ucfirst($platform)),
            'section'  => 'social_media',
            'type'     => 'url',
        ));
    }

    // Footer Settings
    $wp_customize->add_section('footer_settings', array(
        'title'    => __('Footer Settings', 'youth-club-theme'),
        'priority' => 50,
    ));

    $wp_customize->add_setting('footer_about_text', array(
        'default'           => 'We are dedicated to supporting young people and their families with comprehensive care, resources, and programs designed to help them thrive.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('footer_about_text', array(
        'label'    => __('Footer About Text', 'youth-club-theme'),
        'section'  => 'footer_settings',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('footer_copyright_text', array(
        'default'           => 'All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_copyright_text', array(
        'label'    => __('Copyright Text', 'youth-club-theme'),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ));

    // Charity Number
    $wp_customize->add_setting('charity_number', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('charity_number', array(
        'label'       => __('Charity Number', 'youth-club-theme'),
        'section'     => 'footer_settings',
        'type'        => 'text',
        'description' => __('Your registered charity number (if applicable)', 'youth-club-theme'),
    ));

    // Company Number
    $wp_customize->add_setting('company_number', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('company_number', array(
        'label'       => __('Company Number', 'youth-club-theme'),
        'section'     => 'footer_settings',
        'type'        => 'text',
        'description' => __('Your registered company number (if applicable)', 'youth-club-theme'),
    ));

    // ===================================
    // About Our Mission Section
    // ===================================
    $wp_customize->add_section('about_section', array(
        'title'    => __('About Our Mission', 'youth-club-theme'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('about_title', array(
        'default'           => 'About Our Mission',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('about_title', array(
        'label'    => __('Section Title', 'youth-club-theme'),
        'section'  => 'about_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('about_paragraph_1', array(
        'default'           => 'We believe every young person deserves the opportunity to thrive, regardless of their circumstances. Our dedicated team works tirelessly to provide comprehensive support, resources, and care that makes a lasting difference.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('about_paragraph_1', array(
        'label'    => __('First Paragraph', 'youth-club-theme'),
        'section'  => 'about_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('about_paragraph_2', array(
        'default'           => 'Through innovative programmes, compassionate care, and community partnerships, we\'ve been supporting young people and their families for over a decade. Our approach is holistic, addressing not just immediate needs but building foundations for long-term success.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('about_paragraph_2', array(
        'label'    => __('Second Paragraph', 'youth-club-theme'),
        'section'  => 'about_section',
        'type'     => 'textarea',
    ));

    // About features
    $features = array(
        1 => 'Personalised support plans',
        2 => '24/7 crisis support available',
        3 => 'Family-centered approach',
        4 => 'Evidence-based interventions'
    );

    foreach ($features as $i => $default) {
        $wp_customize->add_setting("about_feature_{$i}", array(
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("about_feature_{$i}", array(
            'label'    => __("Feature {$i}", 'youth-club-theme'),
            'section'  => 'about_section',
            'type'     => 'text',
        ));
    }

    $wp_customize->add_setting('about_button_text', array(
        'default'           => 'Learn More About Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('about_button_text', array(
        'label'    => __('Button Text', 'youth-club-theme'),
        'section'  => 'about_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('about_button_link', array(
        'default'           => '/about',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('about_button_link', array(
        'label'    => __('Button Link', 'youth-club-theme'),
        'section'  => 'about_section',
        'type'     => 'url',
    ));

    // ===================================
    // Our Services Section
    // ===================================
    $wp_customize->add_section('services_section', array(
        'title'    => __('Our Services', 'youth-club-theme'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('services_title', array(
        'default'           => 'Our Services',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('services_title', array(
        'label'    => __('Section Title', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('services_subtitle', array(
        'default'           => 'Comprehensive support designed to meet the unique needs of every young person',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('services_subtitle', array(
        'label'    => __('Section Subtitle', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'textarea',
    ));

    // Service 1
    $wp_customize->add_setting('service_1_icon', array(
        'default'           => '💙',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('service_1_icon', array(
        'label'    => __('Service 1 Icon (emoji)', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('service_1_title', array(
        'default'           => 'Health & Wellbeing',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('service_1_title', array(
        'label'    => __('Service 1 Title', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('service_1_description', array(
        'default'           => 'Supporting physical and mental health through specialised programmes, counselling services, and professional healthcare coordination.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('service_1_description', array(
        'label'    => __('Service 1 Description', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('service_1_features', array(
        'default'           => "Mental health counselling\nHealthcare coordination\nWellness programmes\nCrisis intervention",
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('service_1_features', array(
        'label'       => __('Service 1 Features (one per line)', 'youth-club-theme'),
        'section'     => 'services_section',
        'type'        => 'textarea',
        'description' => __('Enter one feature per line', 'youth-club-theme'),
    ));

    $wp_customize->add_setting('service_1_link', array(
        'default'           => '/services/health-wellbeing',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('service_1_link', array(
        'label'    => __('Service 1 Link', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'url',
    ));

    // Service 2
    $wp_customize->add_setting('service_2_icon', array(
        'default'           => '🎓',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('service_2_icon', array(
        'label'    => __('Service 2 Icon (emoji)', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('service_2_title', array(
        'default'           => 'Education Support',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('service_2_title', array(
        'label'    => __('Service 2 Title', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('service_2_description', array(
        'default'           => 'Helping young people achieve their educational goals with tutoring, mentorship, and specialised learning programmes.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('service_2_description', array(
        'label'    => __('Service 2 Description', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('service_2_features', array(
        'default'           => "Individual tutoring\nMentorship programmes\nStudy skills workshops\nCareer guidance",
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('service_2_features', array(
        'label'       => __('Service 2 Features (one per line)', 'youth-club-theme'),
        'section'     => 'services_section',
        'type'        => 'textarea',
        'description' => __('Enter one feature per line', 'youth-club-theme'),
    ));

    $wp_customize->add_setting('service_2_link', array(
        'default'           => '/services/education',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('service_2_link', array(
        'label'    => __('Service 2 Link', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'url',
    ));

    // Service 3
    $wp_customize->add_setting('service_3_icon', array(
        'default'           => '🏠',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('service_3_icon', array(
        'label'    => __('Service 3 Icon (emoji)', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('service_3_title', array(
        'default'           => 'Family Support',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('service_3_title', array(
        'label'    => __('Service 3 Title', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('service_3_description', array(
        'default'           => 'Providing resources, guidance, and practical support to families navigating challenging circumstances.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('service_3_description', array(
        'label'    => __('Service 3 Description', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('service_3_features', array(
        'default'           => "Family counselling\nParenting workshops\nEmergency assistance\nCommunity connections",
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('service_3_features', array(
        'label'       => __('Service 3 Features (one per line)', 'youth-club-theme'),
        'section'     => 'services_section',
        'type'        => 'textarea',
        'description' => __('Enter one feature per line', 'youth-club-theme'),
    ));

    $wp_customize->add_setting('service_3_link', array(
        'default'           => '/services/family-support',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('service_3_link', array(
        'label'    => __('Service 3 Link', 'youth-club-theme'),
        'section'  => 'services_section',
        'type'     => 'url',
    ));

    // ===================================
    // Stories of Hope (Testimonials) Section
    // ===================================
    $wp_customize->add_section('testimonials_section', array(
        'title'    => __('Stories of Hope', 'youth-club-theme'),
        'priority' => 45,
    ));

    $wp_customize->add_setting('testimonials_title', array(
        'default'           => 'Stories of Hope',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonials_title', array(
        'label'    => __('Section Title', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('testimonials_subtitle', array(
        'default'           => 'Hear from the families and young people whose lives have been transformed',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('testimonials_subtitle', array(
        'label'    => __('Section Subtitle', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'textarea',
    ));

    // Testimonial 1
    $wp_customize->add_setting('testimonial_1_content', array(
        'default'           => 'The support we received was life-changing. The team didn\'t just help our son with his immediate challenges – they gave our whole family hope and the tools to build a brighter future.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('testimonial_1_content', array(
        'label'    => __('Testimonial 1 Quote', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('testimonial_1_author', array(
        'default'           => 'Sarah M.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonial_1_author', array(
        'label'    => __('Testimonial 1 Author', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('testimonial_1_role', array(
        'default'           => 'Parent',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonial_1_role', array(
        'label'    => __('Testimonial 1 Role', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'text',
    ));

    // Testimonial 2
    $wp_customize->add_setting('testimonial_2_content', array(
        'default'           => 'I never thought I\'d be able to go to university. The mentorship and educational support I received helped me believe in myself and achieve goals I never thought possible.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('testimonial_2_content', array(
        'label'    => __('Testimonial 2 Quote', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('testimonial_2_author', array(
        'default'           => 'James R.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonial_2_author', array(
        'label'    => __('Testimonial 2 Author', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('testimonial_2_role', array(
        'default'           => 'Program Graduate',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonial_2_role', array(
        'label'    => __('Testimonial 2 Role', 'youth-club-theme'),
        'section'  => 'testimonials_section',
        'type'     => 'text',
    ));

    // ===================================
    // Funding Partners Section
    // ===================================
    $wp_customize->add_section('funding_partners_section', array(
        'title'    => __('Funding Partners', 'youth-club-theme'),
        'priority' => 50,
        'description' => __('Add logos of organizations that have provided funding or support. Logos will automatically resize and arrange to fit the page width.', 'youth-club-theme'),
    ));

    // Enable/disable the section
    $wp_customize->add_setting('funding_partners_enable', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('funding_partners_enable', array(
        'label'    => __('Show Funding Partners Section', 'youth-club-theme'),
        'section'  => 'funding_partners_section',
        'type'     => 'checkbox',
    ));

    // Section title
    $wp_customize->add_setting('funding_partners_title', array(
        'default'           => 'Supported By',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('funding_partners_title', array(
        'label'    => __('Section Title', 'youth-club-theme'),
        'section'  => 'funding_partners_section',
        'type'     => 'text',
    ));

    // Background colour
    $wp_customize->add_setting('funding_partners_bg_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'funding_partners_bg_color', array(
        'label'    => __('Background Colour', 'youth-club-theme'),
        'section'  => 'funding_partners_section',
        'settings' => 'funding_partners_bg_color',
    )));

    // Logo settings - Allow up to 12 logos
    for ($i = 1; $i <= 12; $i++) {
        // Logo image
        $wp_customize->add_setting("funding_logo_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "funding_logo_{$i}", array(
            'label'     => __("Logo {$i}", 'youth-club-theme'),
            'section'   => 'funding_partners_section',
            'mime_type' => 'image',
        )));

        // Logo name/alt text
        $wp_customize->add_setting("funding_logo_{$i}_name", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("funding_logo_{$i}_name", array(
            'label'       => __("Logo {$i} Organization Name", 'youth-club-theme'),
            'section'     => 'funding_partners_section',
            'type'        => 'text',
            'description' => __('Used for accessibility (alt text) and tooltips', 'youth-club-theme'),
        ));

        // Logo URL (optional)
        $wp_customize->add_setting("funding_logo_{$i}_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("funding_logo_{$i}_url", array(
            'label'       => __("Logo {$i} Website URL (optional)", 'youth-club-theme'),
            'section'     => 'funding_partners_section',
            'type'        => 'url',
            'description' => __('If provided, logo will be clickable', 'youth-club-theme'),
        ));

        // Show/hide toggle
        $wp_customize->add_setting("funding_logo_{$i}_visible", array(
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
        ));

        $wp_customize->add_control("funding_logo_{$i}_visible", array(
            'label'   => __("Show Logo {$i}", 'youth-club-theme'),
            'section' => 'funding_partners_section',
            'type'    => 'checkbox',
        ));
    }
}
add_action('customize_register', 'youth_club_theme_customize_register');

/**
 * Custom excerpt length
 */
function youth_club_theme_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'youth_club_theme_excerpt_length');

/**
 * Custom excerpt more text
 */
function youth_club_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'youth_club_theme_excerpt_more');

/**
 * Add custom image sizes
 */
function youth_club_theme_image_sizes() {
    add_image_size('youth-club-theme-featured', 600, 400, true);
    add_image_size('youth-club-theme-thumbnail', 300, 200, true);
}
add_action('after_setup_theme', 'youth_club_theme_image_sizes');

/**
 * Enqueue admin styles for better editor experience
 */
function youth_club_theme_admin_styles() {
    wp_enqueue_style('youth-club-theme-admin', get_template_directory_uri() . '/admin-style.css');
}
add_action('admin_enqueue_scripts', 'youth_club_theme_admin_styles');

/**
 * Add body classes for better styling control
 */
function youth_club_theme_body_classes($classes) {
    // Add class for pages with sidebar
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }
    
    // Add class for front page
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    return $classes;
}
add_filter('body_class', 'youth_club_theme_body_classes');

/**
 * Security enhancements
 */
// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Remove RSD link
remove_action('wp_head', 'rsd_link');

// Remove wlwmanifest.xml
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Accessibility improvements
 */
function youth_club_theme_skip_link_focus_fix() {
    ?>
    <script>
    /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
        var t, e = location.hash.substring(1);
        /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
    }, !1);
    </script>
    <?php
}
add_action('wp_print_footer_scripts', 'youth_club_theme_skip_link_focus_fix');

/**
 * Sanitization functions for Customizer
 */
function youth_club_theme_sanitize_font_choice($input) {
    $valid_fonts = array(
        'Inter, sans-serif',
        'Arial, sans-serif',
        'Helvetica, sans-serif',
        'Georgia, serif',
        'Times New Roman, serif',
        'Trebuchet MS, sans-serif',
        'Verdana, sans-serif',
        'Roboto, sans-serif',
        'Open Sans, sans-serif',
        'Lato, sans-serif',
        'Montserrat, sans-serif',
        'Playfair Display, serif',
        'Merriweather, serif',
    );
    
    return in_array($input, $valid_fonts) ? $input : 'Inter, sans-serif';
}

function youth_club_theme_sanitize_float($input) {
    return floatval($input);
}

/**
 * Generate and output custom CSS based on Customizer settings
 */
function youth_club_theme_custom_css() {
    ?>
    <style type="text/css" id="youth-club-theme-custom-css">
    :root {
        /* Colours */
        --primary-color: <?php echo esc_attr(get_theme_mod('primary_color', '#e74c3c')); ?>;
        --secondary-color: <?php echo esc_attr(get_theme_mod('secondary_color', '#2c3e50')); ?>;
        --accent-color: <?php echo esc_attr(get_theme_mod('accent_color', '#3498db')); ?>;
        --heading-color: <?php echo esc_attr(get_theme_mod('heading_color', '#2c3e50')); ?>;
        --body-text-color: <?php echo esc_attr(get_theme_mod('body_text_color', '#555555')); ?>;
        --link-color: <?php echo esc_attr(get_theme_mod('link_color', '#3498db')); ?>;
        --header-bg-color: <?php echo esc_attr(get_theme_mod('header_bg_color', '#ffffff')); ?>;
        --footer-bg-color: <?php echo esc_attr(get_theme_mod('footer_bg_color', '#2c3e50')); ?>;
        --background-color: #<?php echo esc_attr(get_theme_mod('background_color', 'ffffff')); ?>;
        
        <?php 
        // Calculate footer contrast colours
        $footer_bg = get_theme_mod('footer_bg_color', '#2c3e50');
        $footer_contrast = youth_club_theme_calculate_contrast_colors($footer_bg);
        ?>
        --footer-text-color: <?php echo esc_attr($footer_contrast['text']); ?>;
        --footer-heading-color: <?php echo esc_attr($footer_contrast['heading']); ?>;
        --footer-link-color: <?php echo esc_attr($footer_contrast['link']); ?>;
        --footer-link-hover-color: <?php echo esc_attr($footer_contrast['link_hover']); ?>;
        --footer-border-color: <?php echo esc_attr($footer_contrast['border']); ?>;
        
        /* Typography */
        --heading-font: <?php echo esc_attr(get_theme_mod('heading_font', 'Inter, sans-serif')); ?>;
        --body-font: <?php echo esc_attr(get_theme_mod('body_font', 'Inter, sans-serif')); ?>;
        --heading-font-size: <?php echo esc_attr(get_theme_mod('heading_font_size', '32')); ?>px;
        --body-font-size: <?php echo esc_attr(get_theme_mod('body_font_size', '16')); ?>px;
        --line-height: <?php echo esc_attr(get_theme_mod('line_height', '1.6')); ?>;
        
        /* Logo */
        --logo-height: <?php echo esc_attr(get_theme_mod('custom_logo_height', '80')); ?>px;
        --logo-margin-bottom: <?php echo esc_attr(get_theme_mod('logo_margin_bottom', '20')); ?>px;
    }

    /* Apply colour scheme */
    body {
        font-family: var(--body-font);
        font-size: var(--body-font-size);
        line-height: var(--line-height);
        color: var(--body-text-color);
        background-color: var(--background-color);
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: var(--heading-font);
        color: var(--heading-color);
    }

    h1 {
        font-size: var(--heading-font-size);
    }

    a {
        color: var(--link-color);
    }

    a:hover {
        color: var(--primary-color);
    }

    .site-header {
        background-color: var(--header-bg-color);
    }

    .site-footer {
        background-color: var(--footer-bg-color);
    }

    /* Logo styling */
    .custom-logo {
        height: var(--logo-height);
        width: auto;
        margin-bottom: var(--logo-margin-bottom);
    }

    /* Button styling with primary colour */
    .btn-primary,
    .hero-cta .btn-primary,
    .wp-block-button__link,
    input[type="submit"],
    button[type="submit"] {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover,
    .hero-cta .btn-primary:hover,
    .wp-block-button__link:hover,
    input[type="submit"]:hover,
    button[type="submit"]:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-secondary {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
    }

    .btn-secondary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Hero section styling */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    /* Statistics section */
    .stats-section .stat-number {
        color: var(--primary-color);
    }

    /* Navigation styling */
    .main-navigation a {
        color: var(--heading-color);
    }

    .main-navigation a:hover {
        color: var(--primary-color);
    }

    /* Footer styling */
    .site-footer {
        color: rgba(255, 255, 255, 0.8);
    }

    .site-footer h3,
    .site-footer .widget-title {
        color: white;
    }

    .site-footer a {
        color: rgba(255, 255, 255, 0.8);
    }

    .site-footer a:hover {
        color: white;
    }

    /* Content area styling */
    .content-area {
        background-color: var(--header-bg-color);
    }

    /* Card and section styling */
    .card,
    .service-card,
    .program-card {
        border-color: rgba(0, 0, 0, 0.1);
    }

    .card-header,
    .service-card .card-title,
    .program-card .card-title {
        color: var(--heading-color);
    }

    /* Form styling */
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(<?php 
            // Convert hex to RGB for box-shadow
            $primary = get_theme_mod('primary_color', '#e74c3c');
            list($r, $g, $b) = sscanf($primary, "#%02x%02x%02x");
            echo "$r, $g, $b";
        ?>, 0.25);
    }

    /* Responsive font sizing */
    @media (max-width: 768px) {
        h1 {
            font-size: calc(var(--heading-font-size) * 0.8);
        }
        
        body {
            font-size: calc(var(--body-font-size) * 0.9);
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'youth_club_theme_custom_css');

/**
 * Load Google Fonts for selected typography
 */
function youth_club_theme_load_google_fonts() {
    $heading_font = get_theme_mod('heading_font', 'Inter, sans-serif');
    $body_font = get_theme_mod('body_font', 'Inter, sans-serif');
    
    $google_fonts = array();
    
    // Map font families to Google Fonts URLs
    $font_map = array(
        'Roboto, sans-serif' => 'Roboto:300,400,500,600,700',
        'Open Sans, sans-serif' => 'Open+Sans:300,400,500,600,700',
        'Lato, sans-serif' => 'Lato:300,400,700',
        'Montserrat, sans-serif' => 'Montserrat:300,400,500,600,700',
        'Playfair Display, serif' => 'Playfair+Display:400,700',
        'Merriweather, serif' => 'Merriweather:300,400,700',
    );
    
    if (isset($font_map[$heading_font])) {
        $google_fonts[] = $font_map[$heading_font];
    }
    
    if (isset($font_map[$body_font]) && $body_font !== $heading_font) {
        $google_fonts[] = $font_map[$body_font];
    }
    
    if (!empty($google_fonts)) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $google_fonts) . '&display=swap';
        wp_enqueue_style('youth-club-theme-google-fonts', $fonts_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'youth_club_theme_load_google_fonts');

/**
 * Add Customizer live preview support
 */
function youth_club_theme_customize_preview_js() {
    wp_enqueue_script(
        'youth-club-theme-customizer-preview',
        get_template_directory_uri() . '/js/customizer-preview.js',
        array('customize-preview'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('customize_preview_init', 'youth_club_theme_customize_preview_js');