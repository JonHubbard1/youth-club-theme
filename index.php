<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package Youth_Club_Theme
 */

get_header(); ?>

<div id="primary" class="site-content">
    <div class="container">
        <main id="main" class="site-main">
            
            <?php if ( have_posts() ) : ?>
                
                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <header>
                        <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>
                
                <?php
                // Start the Loop
                while ( have_posts() ) :
                    the_post();
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php
                            if ( is_singular() ) :
                                the_title( '<h1 class="entry-title">', '</h1>' );
                            else :
                                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                            endif;
                            ?>
                            
                            <?php if ( 'post' === get_post_type() ) : ?>
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <span class="byline">
                                        <?php echo get_the_author(); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </header>
                        
                        <div class="entry-content">
                            <?php
                            if ( is_singular() ) :
                                the_content();
                                
                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'youth-club-theme' ),
                                    'after'  => '</div>',
                                ) );
                            else :
                                the_excerpt();
                            endif;
                            ?>
                        </div>
                        
                        <?php if ( is_singular() ) : ?>
                            <footer class="entry-footer">
                                <?php
                                // Display categories and tags
                                $categories_list = get_the_category_list( esc_html__( ', ', 'youth-club-theme' ) );
                                if ( $categories_list ) {
                                    printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'youth-club-theme' ) . '</span>', $categories_list );
                                }
                                
                                $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'youth-club-theme' ) );
                                if ( $tags_list ) {
                                    printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'youth-club-theme' ) . '</span>', $tags_list );
                                }
                                ?>
                            </footer>
                        <?php endif; ?>
                    </article>
                    
                <?php endwhile; ?>
                
                <?php
                // Previous/next page navigation
                the_posts_pagination( array(
                    'prev_text' => esc_html__( 'Previous', 'youth-club-theme' ),
                    'next_text' => esc_html__( 'Next', 'youth-club-theme' ),
                ) );
                ?>
                
            <?php else : ?>
                
                <section class="no-results not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'youth-club-theme' ); ?></h1>
                    </header>
                    
                    <div class="page-content">
                        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
                            
                            <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'youth-club-theme' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
                            
                        <?php elseif ( is_search() ) : ?>
                            
                            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'youth-club-theme' ); ?></p>
                            <?php get_search_form(); ?>
                            
                        <?php else : ?>
                            
                            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'youth-club-theme' ); ?></p>
                            <?php get_search_form(); ?>
                            
                        <?php endif; ?>
                    </div>
                </section>
                
            <?php endif; ?>
            
        </main>
    </div>
</div>

<?php
get_sidebar();
get_footer();