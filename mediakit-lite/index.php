<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package MediaKit_Lite
 */

get_header();
?>

<main id="primary" class="mkp-main">
    <div class="mkp-container">
        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header class="mkp-page-header">
                <h1 class="mkp-page-title"><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>
        
        <?php if ( have_posts() ) : ?>
            
            <?php if ( is_search() ) : ?>
                <header class="mkp-page-header">
                    <h1 class="mkp-page-title">
                        <?php
                        /* translators: %s: search query. */
                        printf( esc_html__( 'Search Results for: %s', 'mediakit-lite' ), '<span>' . get_search_query() . '</span>' );
                        ?>
                    </h1>
                </header>
            <?php endif; ?>
            
            <div class="mkp-posts-grid">
                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();
                    
                    get_template_part( 'template-parts/content', get_post_type() );
                    
                endwhile;
                ?>
            </div>
            
            <?php mkp_pagination(); ?>
            
        <?php else : ?>
            
            <section class="mkp-no-results">
                <header class="mkp-page-header">
                    <h1 class="mkp-page-title"><?php esc_html_e( 'Nothing Found', 'mediakit-lite' ); ?></h1>
                </header>
                
                <div class="mkp-page-content">
                    <?php if ( is_search() ) : ?>
                        
                        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mediakit-lite' ); ?></p>
                        <?php get_search_form(); ?>
                        
                    <?php else : ?>
                        
                        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mediakit-lite' ); ?></p>
                        <?php get_search_form(); ?>
                        
                    <?php endif; ?>
                </div>
            </section>
            
        <?php endif; ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();