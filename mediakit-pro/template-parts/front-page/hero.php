<?php
/**
 * Hero Section Template Part
 *
 * @package MediaKit_Pro
 */

$section_class = 'mkp-hero';
$section_color = get_theme_mod( 'mkp_hero_background_color', '#f8f9fa' );
$hero_background = get_theme_mod( 'mkp_hero_background' );
$hero_overlay_color = get_theme_mod( 'mkp_hero_overlay_color', '#000000' );
$hero_overlay_opacity = get_theme_mod( 'mkp_hero_overlay_opacity', '50' );

// Build inline style
$section_style = '';
if ( $hero_background ) {
    $section_style = 'background-image: url(' . esc_url( $hero_background ) . '); background-size: cover; background-position: center; background-repeat: no-repeat;';
} else {
    $section_style = 'background-color: ' . esc_attr( $section_color ) . ';';
}
?>

<section id="hero" class="<?php echo esc_attr( $section_class ); ?>" style="<?php echo esc_attr( $section_style ); ?>; position: relative;">
    <?php if ( $hero_background && $hero_overlay_opacity > 0 ) : ?>
        <div class="mkp-hero__overlay" style="background-color: <?php echo esc_attr( $hero_overlay_color ); ?>; opacity: <?php echo esc_attr( $hero_overlay_opacity / 100 ); ?>; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;"></div>
    <?php endif; ?>
    <div class="mkp-container" style="position: relative; z-index: 2;">
        <div class="mkp-hero__wrapper">
            <?php 
            // Get images and positions
            $profile_photo = get_theme_mod( 'mkp_hero_profile_photo' );
            $profile_photo_position = get_theme_mod( 'mkp_hero_profile_photo_position', 'left' );
            $family_crest = get_theme_mod( 'mkp_hero_family_crest' );
            $family_crest_position = get_theme_mod( 'mkp_hero_family_crest_position', 'right' );
            
            // Display profile photo on left
            if ( $profile_photo && $profile_photo_position === 'left' ) : ?>
                <div class="mkp-hero__images mkp-hero__images--left">
                    <div class="mkp-hero__image">
                        <img src="<?php echo esc_url( $profile_photo ); ?>" alt="<?php esc_attr_e( 'Profile Photo', 'mediakit-pro' ); ?>" />
                    </div>
                </div>
            <?php endif; ?>
            
            <?php // Display family crest on left
            if ( $family_crest && $family_crest_position === 'left' ) : ?>
                <div class="mkp-hero__images mkp-hero__images--left">
                    <div class="mkp-hero__image">
                        <img src="<?php echo esc_url( $family_crest ); ?>" alt="<?php esc_attr_e( 'Family Crest', 'mediakit-pro' ); ?>" />
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="mkp-hero__content">
                <?php 
                // Person's Name
                $name = get_theme_mod( 'mkp_hero_name' );
                if ( $name ) : ?>
                    <h1 class="mkp-hero__name"><?php echo esc_html( $name ); ?></h1>
                <?php endif; ?>
            
            <?php 
            // Professional Tags
            $tags = array();
            for ( $i = 1; $i <= 5; $i++ ) {
                $tag = get_theme_mod( 'mkp_hero_tag_' . $i );
                if ( $tag ) {
                    $tags[] = $tag;
                }
            }
            
            if ( ! empty( $tags ) ) : ?>
                <div class="mkp-hero__tags">
                    <?php foreach ( $tags as $tag ) : ?>
                        <span class="mkp-hero__tag"><?php echo esc_html( $tag ); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php 
            // CTA Buttons
            $cta1_text = get_theme_mod( 'mkp_hero_cta1_text' );
            $cta1_url = get_theme_mod( 'mkp_hero_cta1_url' );
            $cta2_text = get_theme_mod( 'mkp_hero_cta2_text' );
            $cta2_url = get_theme_mod( 'mkp_hero_cta2_url' );
            
            if ( $cta1_text || $cta2_text ) : ?>
                <div class="mkp-hero__buttons">
                    <?php if ( $cta1_text && $cta1_url ) : ?>
                        <a href="<?php echo esc_url( $cta1_url ); ?>" class="mkp-btn mkp-btn--primary mkp-hero__cta1">
                            <?php echo esc_html( $cta1_text ); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $cta2_text && $cta2_url ) : ?>
                        <a href="<?php echo esc_url( $cta2_url ); ?>" class="mkp-btn mkp-btn--secondary mkp-hero__cta2">
                            <?php echo esc_html( $cta2_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            </div>
            
            <?php // Display profile photo on right
            if ( $profile_photo && $profile_photo_position === 'right' ) : ?>
                <div class="mkp-hero__images mkp-hero__images--right">
                    <div class="mkp-hero__image">
                        <img src="<?php echo esc_url( $profile_photo ); ?>" alt="<?php esc_attr_e( 'Profile Photo', 'mediakit-pro' ); ?>" />
                    </div>
                </div>
            <?php endif; ?>
            
            <?php // Display family crest on right
            if ( $family_crest && $family_crest_position === 'right' ) : ?>
                <div class="mkp-hero__images mkp-hero__images--right">
                    <div class="mkp-hero__image">
                        <img src="<?php echo esc_url( $family_crest ); ?>" alt="<?php esc_attr_e( 'Family Crest', 'mediakit-pro' ); ?>" />
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>