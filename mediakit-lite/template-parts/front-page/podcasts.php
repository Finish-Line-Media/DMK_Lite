<?php
/**
 * Podcasts/Shows Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-podcasts-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Count actual podcasts with titles
$actual_podcast_count = 0;
for ( $i = 1; $i <= 3; $i++ ) {
    $title = get_theme_mod( 'mkp_podcast_' . $i . '_title' );
    if ( $title ) {
        $actual_podcast_count++;
    }
}

// For customizer preview
$is_customizer = is_customize_preview();

// Get customizable section title (defaults to singular/plural based on count)
$default_title = ( $actual_podcast_count === 1 ) ? __( 'Podcast/Show', 'mediakit-lite' ) : __( 'Podcasts/Shows', 'mediakit-lite' );
$section_title = get_theme_mod( 'mkp_podcasts_section_title', $default_title );
?>

<section id="podcasts" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-podcasts__grid">
            <?php for ( $i = 1; $i <= 3; $i++ ) : 
                $title = get_theme_mod( 'mkp_podcast_' . $i . '_title' );
                $logo = get_theme_mod( 'mkp_podcast_' . $i . '_logo' );
                $description = get_theme_mod( 'mkp_podcast_' . $i . '_description' );
                $link = get_theme_mod( 'mkp_podcast_' . $i . '_link' );
                $display = $title ? 'block' : 'none';
                ?>
                <div class="mkp-podcast-card mkp-card mkp-podcast--<?php echo esc_attr( $i ); ?>" style="display: <?php echo esc_attr( $display ); ?>;">
                    <div class="mkp-podcast-card__logo">
                        <?php if ( $logo ) : ?>
                            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $title ); ?> logo" loading="lazy" />
                        <?php else : ?>
                            <div class="mkp-podcast-card__logo-placeholder">
                                <span><?php esc_html_e( 'Podcast Logo', 'mediakit-lite' ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mkp-podcast-card__content">
                        <h3 class="mkp-podcast-card__title"><?php echo esc_html( $title ); ?></h3>
                        
                        <div class="mkp-podcast-card__description mkp-masonry-card__description">
                            <?php if ( $description ) : ?>
                                <?php echo wp_kses_post( wpautop( $description ) ); ?>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ( $link ) : ?>
                            <a href="<?php echo esc_url( $link ); ?>" class="mkp-btn mkp-btn--primary mkp-btn--small" target="_blank" rel="noopener">
                                <?php esc_html_e( 'Listen Now', 'mediakit-lite' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>