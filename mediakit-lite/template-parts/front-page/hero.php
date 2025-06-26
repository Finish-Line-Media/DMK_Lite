<?php
/**
 * Hero Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-hero mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Build inline style
$section_style = 'background-color: ' . esc_attr( $section_color ) . '; color: ' . esc_attr( $text_color ) . ';';
?>

<section id="hero" class="<?php echo esc_attr( $section_class ); ?>" style="<?php echo esc_attr( $section_style ); ?>">
    <div class="mkp-container">
        <div class="mkp-hero__wrapper">
            <?php 
            // Get all images on the left side
            $left_images = array();
            for ( $i = 1; $i <= 2; $i++ ) {
                $image = get_theme_mod( 'mkp_hero_image_' . $i );
                $position = get_theme_mod( 'mkp_hero_image_' . $i . '_position', 'left' );
                if ( $image && $position === 'left' ) {
                    $left_images[] = $image;
                }
            }
            
            // Display left images
            if ( ! empty( $left_images ) ) : ?>
                <div class="mkp-hero__images mkp-hero__images--left">
                    <?php foreach ( $left_images as $image ) : ?>
                        <div class="mkp-hero__image">
                            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_theme_mod( 'mkp_hero_name', get_bloginfo( 'name' ) ) ); ?>" />
                        </div>
                    <?php endforeach; ?>
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
                    <?php 
                    $total_tags = count( $tags );
                    foreach ( $tags as $index => $tag ) : ?>
                        <span class="mkp-hero__tag-group">
                            <span class="mkp-hero__tag"><?php echo esc_html( $tag ); ?></span>
                            <?php if ( $index < $total_tags - 1 ) : ?>
                                <span class="mkp-hero__separator" aria-hidden="true">·</span>
                            <?php endif; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            </div>
            
            <?php 
            // Get all images on the right side
            $right_images = array();
            for ( $i = 1; $i <= 2; $i++ ) {
                $image = get_theme_mod( 'mkp_hero_image_' . $i );
                $position = get_theme_mod( 'mkp_hero_image_' . $i . '_position', 'left' );
                if ( $image && $position === 'right' ) {
                    $right_images[] = $image;
                }
            }
            
            // Display right images
            if ( ! empty( $right_images ) ) : ?>
                <div class="mkp-hero__images mkp-hero__images--right">
                    <?php foreach ( $right_images as $image ) : ?>
                        <div class="mkp-hero__image">
                            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_theme_mod( 'mkp_hero_name', get_bloginfo( 'name' ) ) ); ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>