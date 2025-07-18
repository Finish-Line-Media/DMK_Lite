<?php
/**
 * Featured Video Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-featured-video-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Get video URL
$video_url = get_theme_mod( 'mkp_featured_video_url' );

// For customizer preview
$is_customizer = is_customize_preview();

// Get other settings
$section_title = get_theme_mod( 'mkp_featured_video_section_title', __( 'Featured Video', 'mediakit-lite' ) );
$video_title = get_theme_mod( 'mkp_featured_video_title' );
$video_description = get_theme_mod( 'mkp_featured_video_description' );
$primary_cta_text = get_theme_mod( 'mkp_featured_video_primary_cta_text' );
$primary_cta_url = get_theme_mod( 'mkp_featured_video_primary_cta_url' );
$secondary_cta_text = get_theme_mod( 'mkp_featured_video_secondary_cta_text' );
$secondary_cta_url = get_theme_mod( 'mkp_featured_video_secondary_cta_url' );
?>

<section id="featured-video" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-featured-video__wrapper">
            <?php if ( $video_url ) : 
                $embed = wp_oembed_get( $video_url );
                if ( $embed ) : ?>
                    <div class="mkp-featured-video__embed">
                        <?php echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php else : ?>
                    <div class="mkp-featured-video__error">
                        <p><?php esc_html_e( 'Invalid video URL. Please enter a valid YouTube, Vimeo, or other supported video URL.', 'mediakit-lite' ); ?></p>
                    </div>
                <?php endif; ?>
            <?php elseif ( $is_customizer ) : ?>
                <div class="mkp-featured-video__placeholder">
                    <div class="mkp-featured-video__placeholder-content">
                        <span class="dashicons dashicons-video-alt3"></span>
                        <p><?php esc_html_e( 'Add a video URL to display your featured video here', 'mediakit-lite' ); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ( $video_title || $video_description || ( $primary_cta_text && $primary_cta_url ) || ( $secondary_cta_text && $secondary_cta_url ) ) : ?>
                <div class="mkp-featured-video__content">
                    <?php if ( $video_title ) : ?>
                        <h3 class="mkp-featured-video__title"><?php echo esc_html( $video_title ); ?></h3>
                    <?php endif; ?>
                    
                    <?php if ( $video_description ) : ?>
                        <div class="mkp-featured-video__description">
                            <?php echo wp_kses_post( wpautop( $video_description ) ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( ( $primary_cta_text && $primary_cta_url ) || ( $secondary_cta_text && $secondary_cta_url ) ) : ?>
                        <div class="mkp-featured-video__cta-buttons">
                            <?php if ( $primary_cta_text && $primary_cta_url ) : ?>
                                <a href="<?php echo esc_url( $primary_cta_url ); ?>" class="mkp-btn mkp-btn--primary">
                                    <?php echo esc_html( $primary_cta_text ); ?>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ( $secondary_cta_text && $secondary_cta_url ) : ?>
                                <a href="<?php echo esc_url( $secondary_cta_url ); ?>" class="mkp-btn mkp-btn--secondary">
                                    <?php echo esc_html( $secondary_cta_text ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>