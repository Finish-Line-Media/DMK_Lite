<?php
/**
 * Testimonials Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-testimonials-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Count actual testimonials
$actual_testimonial_count = 0;
for ( $i = 1; $i <= 8; $i++ ) {
    $quote = get_theme_mod( 'mkp_testimonial_' . $i . '_quote' );
    if ( $quote ) {
        $actual_testimonial_count++;
    }
}

// For customizer preview
$is_customizer = is_customize_preview();

// Get section title
$section_title = get_theme_mod( 'mkp_testimonials_section_title', __( 'Testimonials', 'mediakit-lite' ) );

// Get text alignment setting
$text_align = get_theme_mod( 'mkp_testimonials_text_align', 'left' );
$quote_class = 'mkp-testimonial-card__quote mkp-text-align-' . $text_align;
?>

<section id="testimonials" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-testimonials__grid mkp-testimonials__grid--count-<?php echo esc_attr( $actual_testimonial_count ); ?>">
            <?php for ( $i = 1; $i <= 8; $i++ ) : 
                $quote = get_theme_mod( 'mkp_testimonial_' . $i . '_quote' );
                $author = get_theme_mod( 'mkp_testimonial_' . $i . '_author' );
                $title = get_theme_mod( 'mkp_testimonial_' . $i . '_title' );
                $organization = get_theme_mod( 'mkp_testimonial_' . $i . '_organization' );
                $photo = get_theme_mod( 'mkp_testimonial_' . $i . '_photo' );
                $rating = get_theme_mod( 'mkp_testimonial_' . $i . '_rating', 0 );
                
                $display = $quote ? 'block' : 'none';
                ?>
                <div class="mkp-testimonial-card mkp-card mkp-testimonial--<?php echo esc_attr( $i ); ?>" style="display: <?php echo esc_attr( $display ); ?>;">
                    <?php if ( $rating > 0 ) : ?>
                        <div class="mkp-testimonial-card__rating" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'mediakit-lite' ), $rating ) ); ?>">
                            <?php for ( $star = 1; $star <= 5; $star++ ) : ?>
                                <span class="mkp-star <?php echo $star <= $rating ? 'mkp-star--filled' : 'mkp-star--empty'; ?>">★</span>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                    
                    <blockquote class="<?php echo esc_attr( $quote_class ); ?>">
                        <?php echo wp_kses_post( wpautop( $quote ) ); ?>
                    </blockquote>
                    
                    <div class="mkp-testimonial-card__author">
                        <?php if ( $photo ) : ?>
                            <div class="mkp-testimonial-card__photo">
                                <img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $author ); ?>" />
                            </div>
                        <?php endif; ?>
                        
                        <div class="mkp-testimonial-card__author-info">
                            <?php if ( $author ) : ?>
                                <cite class="mkp-testimonial-card__author-name"><?php echo esc_html( $author ); ?></cite>
                            <?php endif; ?>
                            
                            <?php if ( $title || $organization ) : ?>
                                <div class="mkp-testimonial-card__author-details">
                                    <?php 
                                    $details = array();
                                    if ( $title ) {
                                        $details[] = esc_html( $title );
                                    }
                                    if ( $organization ) {
                                        $details[] = esc_html( $organization );
                                    }
                                    echo implode( ', ', $details );
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        
        <?php if ( $is_customizer && $actual_testimonial_count === 0 ) : ?>
            <div class="mkp-testimonials__placeholder">
                <p><?php esc_html_e( 'Add testimonials in the Customizer to display them here.', 'mediakit-lite' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>