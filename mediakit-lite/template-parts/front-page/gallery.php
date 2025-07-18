<?php
/**
 * Template part for displaying gallery section
 *
 * @package MediaKit_Lite
 */

// Get gallery images
$gallery_images_string = get_theme_mod( 'mkp_gallery_images', '' );

// For customizer preview
$is_customizer = is_customize_preview();

// Convert comma-separated string to array
$gallery_images = ! empty( $gallery_images_string ) 
    ? array_filter( array_map( 'absint', explode( ',', $gallery_images_string ) ) )
    : array();

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Build section classes
$section_class = 'mkp-gallery-section mkp-section';
?>

<section id="gallery" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( get_theme_mod( 'mkp_gallery_section_title', __( 'Image Gallery', 'mediakit-lite' ) ) ); ?></h2>
        
        <div class="mkp-gallery__grid">
            <?php foreach ( $gallery_images as $image_id ) : 
                if ( ! $image_id ) continue;
                
                $image_url = wp_get_attachment_image_url( $image_id, 'large' );
                $image_full_url = wp_get_attachment_image_url( $image_id, 'full' );
                $image_caption = wp_get_attachment_caption( $image_id );
                $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                
                if ( ! $image_url ) continue;
                ?>
                <div class="mkp-gallery__item" data-image="<?php echo esc_url( $image_full_url ); ?>" data-caption="<?php echo esc_attr( $image_caption ); ?>">
                    <?php echo wp_get_attachment_image( $image_id, 'medium_large', false, array(
                        'class' => 'mkp-gallery__image',
                        'loading' => 'lazy'
                    ) ); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox HTML -->
<div id="mkp-lightbox" class="mkp-lightbox" aria-hidden="true">
    <button class="mkp-lightbox__close" aria-label="<?php esc_attr_e( 'Close gallery', 'mediakit-lite' ); ?>">
        <span aria-hidden="true">&times;</span>
    </button>
    <button class="mkp-lightbox__prev" aria-label="<?php esc_attr_e( 'Previous image', 'mediakit-lite' ); ?>">
        <span aria-hidden="true">&#8249;</span>
    </button>
    <button class="mkp-lightbox__next" aria-label="<?php esc_attr_e( 'Next image', 'mediakit-lite' ); ?>">
        <span aria-hidden="true">&#8250;</span>
    </button>
    <div class="mkp-lightbox__content">
        <img class="mkp-lightbox__image" src="" alt="">
        <div class="mkp-lightbox__caption"></div>
    </div>
</div>