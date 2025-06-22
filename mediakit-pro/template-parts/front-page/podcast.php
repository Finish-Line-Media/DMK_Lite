<?php
/**
 * Podcast/Show Section Template Part
 *
 * @package MediaKit_Pro
 */

$section_class = 'mkp-podcast-section';
$section_color = get_theme_mod( 'mkp_podcast_background_color', '#f1f3f5' );
$podcast_name = get_theme_mod( 'mkp_podcast_name' );
$podcast_logo = get_theme_mod( 'mkp_podcast_logo' );
$podcast_synopsis = get_theme_mod( 'mkp_podcast_synopsis' );
$podcast_link = get_theme_mod( 'mkp_podcast_link' );
?>

<section id="podcast" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Podcast / Show', 'mediakit-pro' ); ?></h2>
        
        <div class="mkp-podcast__content">
            <?php if ( $podcast_logo ) : ?>
                <div class="mkp-podcast__logo">
                    <img src="<?php echo esc_url( $podcast_logo ); ?>" alt="<?php echo esc_attr( $podcast_name ); ?>" />
                </div>
            <?php endif; ?>
            
            <div class="mkp-podcast__info">
                <h3 class="mkp-podcast__name"><?php echo esc_html( $podcast_name ); ?></h3>
                
                <?php if ( $podcast_synopsis ) : ?>
                    <div class="mkp-podcast__synopsis">
                        <?php echo wp_kses_post( wpautop( $podcast_synopsis ) ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $podcast_link ) : ?>
                    <a href="<?php echo esc_url( $podcast_link ); ?>" class="mkp-btn mkp-btn--primary" target="_blank" rel="noopener">
                        <?php esc_html_e( 'Listen Now', 'mediakit-pro' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>