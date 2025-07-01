<?php
/**
 * The template for displaying all single posts
 *
 * @package MediaKit_Lite
 */

get_header();

// Get dynamic colors for single post
mkp_reset_section_colors();
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];
?>

<main id="primary" class="mkp-main mkp-section" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <div class="mkp-single-wrapper">
            <div class="mkp-content-area">
                <?php
                while ( have_posts() ) :
                    the_post();
                    
                    get_template_part( 'template-parts/content', 'single' );
                    
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    
                endwhile; // End of the loop.
                ?>
            </div>
            
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();