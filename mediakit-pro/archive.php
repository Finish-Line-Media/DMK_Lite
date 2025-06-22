<?php
/**
 * The template for displaying archive pages
 *
 * @package MediaKit_Pro
 */

get_header();
?>

<main id="primary" class="mkp-main">
    <div class="mkp-container">
        <?php if ( have_posts() ) : ?>
            
            <header class="mkp-page-header">
                <h1 class="mkp-page-title"><?php echo mkp_get_archive_title(); ?></h1>
                <?php
                the_archive_description( '<div class="mkp-archive-description">', '</div>' );
                ?>
            </header>
            
            <div class="mkp-archive-grid">
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
                    <h1 class="mkp-page-title"><?php esc_html_e( 'Nothing Found', 'mediakit-pro' ); ?></h1>
                </header>
                
                <div class="mkp-page-content">
                    <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mediakit-pro' ); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </section>
            
        <?php endif; ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();