<?php
/**
 * Awards & Recognition Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-awards-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Count actual awards
$actual_award_count = 0;
for ( $i = 1; $i <= 6; $i++ ) {
    $title = get_theme_mod( 'mkp_award_' . $i . '_title' );
    $logo = get_theme_mod( 'mkp_award_' . $i . '_logo' );
    if ( $title || $logo ) {
        $actual_award_count++;
    }
}

// For customizer preview
$is_customizer = is_customize_preview();

// Get section title
$section_title = get_theme_mod( 'mkp_awards_section_title', __( 'Awards & Recognition', 'mediakit-lite' ) );
?>

<section id="awards" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-awards__grid mkp-awards__grid--count-<?php echo esc_attr( $actual_award_count ); ?>">
            <?php for ( $i = 1; $i <= 6; $i++ ) : 
                $title = get_theme_mod( 'mkp_award_' . $i . '_title' );
                $logo = get_theme_mod( 'mkp_award_' . $i . '_logo' );
                $year = get_theme_mod( 'mkp_award_' . $i . '_year' );
                $description = get_theme_mod( 'mkp_award_' . $i . '_description' );
                
                if ( ! $title && ! $logo ) {
                    continue;
                }
                ?>
                <div class="mkp-award-card mkp-card mkp-award--<?php echo esc_attr( $i ); ?>">
                    <?php if ( $logo ) : ?>
                        <div class="mkp-award-card__logo">
                            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
                        </div>
                    <?php else : ?>
                        <div class="mkp-award-card__logo-placeholder">
                            <span class="dashicons dashicons-awards"></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mkp-award-card__content">
                        <?php if ( $title ) : ?>
                            <h3 class="mkp-award-card__title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ( $year ) : ?>
                            <div class="mkp-award-card__year"><?php echo esc_html( $year ); ?></div>
                        <?php endif; ?>
                        
                        <?php if ( $description ) : ?>
                            <div class="mkp-award-card__description mkp-masonry-card__description">
                                <?php echo wp_kses_post( wpautop( $description ) ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        
        <?php if ( $is_customizer && $actual_award_count === 0 ) : ?>
            <div class="mkp-awards__placeholder">
                <p><?php esc_html_e( 'Add awards and recognition in the Customizer to display them here.', 'mediakit-lite' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>