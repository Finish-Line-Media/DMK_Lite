<?php
/**
 * The template for displaying all single posts
 *
 * @package MediaKit_Lite
 */

get_header();
?>

<main id="primary" class="mkp-main">
    <div class="mkp-container">
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
</main>

<?php
get_footer();