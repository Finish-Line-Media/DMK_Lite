<?php
/**
 * Media Features Section Template Part
 * "As Seen In" or "Featured In" media logos
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-media-features-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Count actual media features
$actual_media_count = 0;
for ( $i = 1; $i <= 12; $i++ ) {
    $logo = get_theme_mod( 'mkp_media_feature_' . $i . '_logo' );
    if ( $logo ) {
        $actual_media_count++;
    }
}

// For customizer preview, always render the section structure
$is_customizer = is_customize_preview();

// Don't show section if no media features (unless in customizer)
if ( $actual_media_count === 0 && ! $is_customizer ) {
    return;
}

// Get section title
$section_title = get_theme_mod( 'mkp_media_features_section_title', __( 'Featured In', 'mediakit-lite' ) );
?>

<section id="media-features" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-media-features__grid mkp-media-features__grid--count-<?php echo esc_attr( $actual_media_count ); ?>">
            <?php for ( $i = 1; $i <= 12; $i++ ) : 
                $logo = get_theme_mod( 'mkp_media_feature_' . $i . '_logo' );
                $name = get_theme_mod( 'mkp_media_feature_' . $i . '_name' );
                $link = get_theme_mod( 'mkp_media_feature_' . $i . '_link' );
                
                if ( ! $logo ) {
                    continue;
                }
                ?>
                <div class="mkp-media-feature-item mkp-media-feature--<?php echo esc_attr( $i ); ?>">
                    <?php if ( $link ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener" class="mkp-media-feature__link">
                    <?php endif; ?>
                        
                        <img 
                            src="<?php echo esc_url( $logo ); ?>" 
                            alt="<?php echo esc_attr( $name ?: __( 'Media outlet logo', 'mediakit-lite' ) ); ?>" 
                            class="mkp-media-feature__logo"
                        />
                        
                    <?php if ( $link ) : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
        
        <?php if ( $is_customizer && $actual_media_count === 0 ) : ?>
            <div class="mkp-media-features__placeholder">
                <p><?php esc_html_e( 'Add media outlet logos in the Customizer to display them here.', 'mediakit-lite' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>