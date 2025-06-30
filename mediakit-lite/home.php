<?php
/**
 * Blog Archive Template
 * 
 * This template is used to display the blog posts index
 * when a static page is set as the front page.
 *
 * @package MediaKit_Lite
 */

get_header();

// Get blog settings
$blog_title = get_theme_mod( 'mkp_blog_title', __( 'Blog', 'mediakit-lite' ) );
$blog_subtitle = get_theme_mod( 'mkp_blog_subtitle', __( 'Thoughts, insights, and updates', 'mediakit-lite' ) );

// Get dynamic colors for the blog header
mkp_reset_section_colors(); // Reset color rotation for consistent appearance
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// WordPress handles the query automatically for home.php
?>

<div id="primary" class="mkp-content-area">
    <main id="main" class="mkp-site-main">
        
        <header class="mkp-blog-header mkp-section" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>;">
            <div class="mkp-container">
                <h1 class="mkp-blog-header__title mkp-section__title" style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html( $blog_title ); ?></h1>
                <?php if ( $blog_subtitle ) : ?>
                    <p class="mkp-blog-header__subtitle mkp-section__description" style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html( $blog_subtitle ); ?></p>
                <?php endif; ?>
            </div>
        </header>
        
        <?php 
        // Get next color for blog content section
        $content_colors = mkp_get_next_section_color();
        $content_bg = $content_colors['background'];
        $content_text = $content_colors['text'];
        ?>
        
        <section class="mkp-blog-content mkp-section" style="background-color: <?php echo esc_attr( $content_bg ); ?>; color: <?php echo esc_attr( $content_text ); ?>;">
            <div class="mkp-container">
                <?php if ( have_posts() ) : ?>
                    
                    <div class="mkp-blog-grid">
                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'mkp-blog-card mkp-card' ); ?>>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="mkp-blog-card__thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'medium_large' ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mkp-blog-card__content">
                                    <header class="mkp-blog-card__header">
                                        <?php the_title( '<h2 class="mkp-blog-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
                                        
                                        <div class="mkp-blog-card__meta">
                                            <?php mkp_posted_on(); ?>
                                            <?php mkp_posted_by(); ?>
                                        </div>
                                    </header>
                                    
                                    <div class="mkp-blog-card__excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <footer class="mkp-blog-card__footer">
                                        <a href="<?php the_permalink(); ?>" class="mkp-blog-card__link">
                                            <?php esc_html_e( 'Read More', 'mediakit-lite' ); ?>
                                            <span aria-hidden="true">&rarr;</span>
                                        </a>
                                    </footer>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        ?>
                    </div>
                    
                    <div class="mkp-blog-pagination">
                        <?php mkp_pagination(); ?>
                    </div>
                    
                <?php else : ?>
                    
                    <div class="mkp-blog-empty">
                        <h2><?php esc_html_e( 'No posts found', 'mediakit-lite' ); ?></h2>
                        <p><?php esc_html_e( 'It looks like there are no blog posts yet. Check back soon!', 'mediakit-lite' ); ?></p>
                        
                        <?php if ( current_user_can( 'publish_posts' ) ) : ?>
                            <p>
                                <a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="button">
                                    <?php esc_html_e( 'Create your first post', 'mediakit-lite' ); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                <?php endif; ?>
            </div>
        </section>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();