<?php
/**
 * The template for displaying archive pages
 *
 * @package MediaKit_Lite
 */

get_header();

// Get dynamic colors
mkp_reset_section_colors();
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];
?>

<main id="primary" class="mkp-main mkp-section" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <div class="mkp-archive-wrapper">
            <div class="mkp-content-area">
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
                            <h1 class="mkp-page-title"><?php esc_html_e( 'Nothing Found', 'mediakit-lite' ); ?></h1>
                        </header>
                        
                        <div class="mkp-page-content">
                            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mediakit-lite' ); ?></p>
                            <?php get_search_form(); ?>
                        </div>
                    </section>
                    
                <?php endif; ?>
            </div>
            
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();