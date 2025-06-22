<?php
/**
 * In The Media Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-in-media-section';
$section_color = get_theme_mod( 'mkp_in_media_background_color', '#f1f3f5' );
$media_count = get_theme_mod( 'mkp_media_items_count', 6 );
?>

<section id="media" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'In The Media', 'mediakit-lite' ); ?></h2>
        
        <div class="mkp-media-items__grid">
            <?php for ( $i = 1; $i <= $media_count; $i++ ) : 
                $title = get_theme_mod( 'mkp_media_item_' . $i . '_title' );
                $type = get_theme_mod( 'mkp_media_item_' . $i . '_type', 'podcast' );
                $link = get_theme_mod( 'mkp_media_item_' . $i . '_link' );
                
                if ( $title ) : ?>
                    <div class="mkp-media-item">
                        <span class="mkp-media-item__type mkp-media-item__type--<?php echo esc_attr( $type ); ?>">
                            <?php echo esc_html( ucfirst( $type ) ); ?>
                        </span>
                        <h3 class="mkp-media-item__title"><?php echo esc_html( $title ); ?></h3>
                        <?php if ( $link ) : ?>
                            <a href="<?php echo esc_url( $link ); ?>" class="mkp-media-item__link" target="_blank" rel="noopener">
                                <?php esc_html_e( 'View', 'mediakit-lite' ); ?> →
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>