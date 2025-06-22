<?php
/**
 * The template for displaying all pages
 *
 * @package MediaKit_Lite
 */

get_header();
?>

<main id="primary" class="mkp-main">
    <div class="mkp-container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'mkp-page' ); ?>>
                <header class="mkp-page__header">
                    <h1 class="mkp-page__title"><?php the_title(); ?></h1>
                </header>
                
                <?php mkp_post_thumbnail(); ?>
                
                <div class="mkp-page__content">
                    <?php
                    the_content();
                    
                    wp_link_pages(
                        array(
                            'before' => '<div class="mkp-page-links">' . esc_html__( 'Pages:', 'mediakit-lite' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>
                
                <?php if ( get_edit_post_link() ) : ?>
                    <footer class="mkp-page__footer">
                        <?php
                        edit_post_link(
                            sprintf(
                                wp_kses(
                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                    __( 'Edit <span class="screen-reader-text">%s</span>', 'mediakit-lite' ),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                wp_kses_post( get_the_title() )
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer>
                <?php endif; ?>
            </article>
            
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            
        endwhile; // End of the loop.
        ?>
    </div>
</main>

<?php
get_footer();