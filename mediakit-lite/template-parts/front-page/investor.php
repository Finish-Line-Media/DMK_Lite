<?php
/**
 * Investor Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-investor-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Check if we have any investor options
$has_investors = false;
for ( $i = 1; $i <= 3; $i++ ) {
    if ( get_theme_mod( 'mkp_investor_' . $i . '_title' ) ) {
        $has_investors = true;
        break;
    }
}

// For customizer preview, always render the section structure
$is_customizer = is_customize_preview();

if ( ! $has_investors && ! $is_customizer ) {
    return;
}

// Count actual investor options for dynamic title
$actual_investor_count = 0;
for ( $i = 1; $i <= 3; $i++ ) {
    if ( get_theme_mod( 'mkp_investor_' . $i . '_title' ) ) {
        $actual_investor_count++;
    }
}

// Get customizable section title (defaults to singular/plural based on count)
$default_title = ( $actual_investor_count === 1 ) ? __( 'Investment Vertical', 'mediakit-lite' ) : __( 'Investment Verticals', 'mediakit-lite' );
$section_title = get_theme_mod( 'mkp_investor_section_title', $default_title );
?>

<section id="investor" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?><?php echo ( ! $has_investors && $is_customizer ) ? '; display: none;' : ''; ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <?php if ( $has_investors || $is_customizer ) : ?>
            <div class="mkp-investor__grid">
                <?php for ( $i = 1; $i <= 3; $i++ ) : 
                    $title = get_theme_mod( 'mkp_investor_' . $i . '_title' );
                    $description = get_theme_mod( 'mkp_investor_' . $i . '_description' );
                    
                    if ( ! $title && ! $is_customizer ) {
                        continue;
                    }
                    ?>
                    <div class="mkp-investor-card mkp-card mkp-investor--<?php echo esc_attr( $i ); ?>" <?php echo ( ! $title && $is_customizer ) ? 'style="display: none;"' : ''; ?>>
                        <h3 class="mkp-investor-card__title"><?php echo esc_html( $title ); ?></h3>
                        <?php if ( $description ) : ?>
                            <div class="mkp-investor-card__description mkp-masonry-card__description">
                                <?php echo wp_kses_post( wpautop( $description ) ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
        
        <?php if ( ! $has_investors && $is_customizer ) : ?>
            <p class="mkp-investor__placeholder" style="text-align: center; color: #999; padding: 40px 0;">
                <?php esc_html_e( 'Start adding investor options to see them appear here.', 'mediakit-lite' ); ?>
            </p>
        <?php endif; ?>
    </div>
</section>