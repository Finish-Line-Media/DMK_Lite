<?php
/**
 * Template part for displaying testimonials
 *
 * @package MediaKit_Pro
 */

$testimonial_text = get_post_meta( get_the_ID(), '_mkp_testimonial_text', true );
$author_name = get_post_meta( get_the_ID(), '_mkp_author_name', true );
$author_title = get_post_meta( get_the_ID(), '_mkp_author_title', true );
$author_company = get_post_meta( get_the_ID(), '_mkp_author_company', true );
$author_photo = get_post_meta( get_the_ID(), '_mkp_author_photo', true );
$rating = get_post_meta( get_the_ID(), '_mkp_rating', true );
?>

<div class="mkp-testimonial">
    <?php if ( $rating ) : ?>
        <div class="mkp-testimonial__rating">
            <?php echo mkp_star_rating( $rating ); ?>
        </div>
    <?php endif; ?>
    
    <?php if ( $testimonial_text ) : ?>
        <blockquote class="mkp-testimonial__text">
            <?php echo esc_html( $testimonial_text ); ?>
        </blockquote>
    <?php endif; ?>
    
    <div class="mkp-testimonial__author">
        <?php if ( $author_photo ) : ?>
            <div class="mkp-testimonial__photo">
                <?php echo wp_get_attachment_image( $author_photo, 'mkp-testimonial' ); ?>
            </div>
        <?php endif; ?>
        
        <div class="mkp-testimonial__info">
            <?php if ( $author_name ) : ?>
                <div class="mkp-testimonial__name"><?php echo esc_html( $author_name ); ?></div>
            <?php endif; ?>
            
            <?php if ( $author_title || $author_company ) : ?>
                <div class="mkp-testimonial__position">
                    <?php
                    if ( $author_title && $author_company ) {
                        echo esc_html( $author_title . ', ' . $author_company );
                    } elseif ( $author_title ) {
                        echo esc_html( $author_title );
                    } else {
                        echo esc_html( $author_company );
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>