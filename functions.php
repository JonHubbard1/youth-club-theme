<?php
/**
 * Youth Club Theme functions and definitions
 *
 * @package Youth_Club_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function youth_club_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'youth-club-theme' ),
        'footer'  => esc_html__( 'Footer Menu', 'youth-club-theme' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Set up the WordPress core custom background feature
    add_theme_support( 'custom-background', apply_filters( 'youth_club_theme_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for core custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Add support for Block Styles
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );

    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'youth_club_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function youth_club_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'youth_club_theme_content_width', 1200 );
}
add_action( 'after_setup_theme', 'youth_club_theme_content_width', 0 );

/**
 * Register widget area.
 */
function youth_club_theme_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'youth-club-theme' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'youth-club-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 1', 'youth-club-theme' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here.', 'youth-club-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 2', 'youth-club-theme' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here.', 'youth-club-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 3', 'youth-club-theme' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here.', 'youth-club-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'youth_club_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function youth_club_theme_scripts() {
    // Enqueue theme stylesheet
    wp_enqueue_style( 'youth-club-theme-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Enqueue navigation script
    wp_enqueue_script( 'youth-club-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true );

    // Enqueue comment reply script on singular posts with comments open
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'youth_club_theme_scripts' );

/**
 * Custom template tags for this theme.
 */
function youth_club_theme_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        esc_html_x( 'Posted on %s', 'post date', 'youth-club-theme' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>';
}

/**
 * Custom function to check if Easy Youth Club plugin is active
 */
function youth_club_theme_is_plugin_active() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    return is_plugin_active( 'easy-youth-club/easy-youth-club.php' );
}

/**
 * Display admin notice if Easy Youth Club plugin is not active
 */
function youth_club_theme_admin_notice() {
    if ( ! youth_club_theme_is_plugin_active() && current_user_can( 'activate_plugins' ) ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php esc_html_e( 'Youth Club Theme works best with the Easy Youth Club plugin. Please activate it for full functionality.', 'youth-club-theme' ); ?></p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'youth_club_theme_admin_notice' );

/**
 * Customizer additions.
 */
function youth_club_theme_customize_register( $wp_customize ) {
    // Add Theme Options Panel
    $wp_customize->add_panel( 'youth_club_theme_options', array(
        'title'       => esc_html__( 'Youth Club Theme Options', 'youth-club-theme' ),
        'priority'    => 30,
        'description' => esc_html__( 'Customize your Youth Club theme settings', 'youth-club-theme' ),
    ) );

    // Add Colors Section
    $wp_customize->add_section( 'youth_club_colors', array(
        'title'    => esc_html__( 'Theme Colors', 'youth-club-theme' ),
        'panel'    => 'youth_club_theme_options',
        'priority' => 10,
    ) );

    // Primary Color Setting
    $wp_customize->add_setting( 'primary_color', array(
        'default'           => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
        'label'    => esc_html__( 'Primary Color', 'youth-club-theme' ),
        'section'  => 'youth_club_colors',
        'settings' => 'primary_color',
    ) ) );

    // Secondary Color Setting
    $wp_customize->add_setting( 'secondary_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
        'label'    => esc_html__( 'Secondary Color', 'youth-club-theme' ),
        'section'  => 'youth_club_colors',
        'settings' => 'secondary_color',
    ) ) );
}
add_action( 'customize_register', 'youth_club_theme_customize_register' );

/**
 * Add custom CSS based on Customizer settings
 */
function youth_club_theme_customizer_css() {
    $primary_color = get_theme_mod( 'primary_color', '#007cba' );
    $secondary_color = get_theme_mod( 'secondary_color', '#333333' );
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr( $primary_color ); ?>;
            --secondary-color: <?php echo esc_attr( $secondary_color ); ?>;
        }
        .main-navigation a:hover,
        .youth-club-event-title,
        a {
            color: var(--primary-color);
        }
        .site-title,
        .entry-title,
        h1, h2, h3, h4, h5, h6 {
            color: var(--secondary-color);
        }
    </style>
    <?php
}
add_action( 'wp_head', 'youth_club_theme_customizer_css' );

/**
 * Integration with Easy Youth Club plugin
 */
if ( youth_club_theme_is_plugin_active() ) {
    // Add custom styles for plugin elements
    function youth_club_theme_plugin_styles() {
        wp_enqueue_style( 'youth-club-theme-plugin-integration', get_template_directory_uri() . '/css/plugin-integration.css', array(), '1.0.0' );
    }
    add_action( 'wp_enqueue_scripts', 'youth_club_theme_plugin_styles' );
    
    // Add theme support for plugin features
    add_action( 'init', function() {
        // Add support for custom post types from the plugin
        add_theme_support( 'easy-youth-club' );
    });
}