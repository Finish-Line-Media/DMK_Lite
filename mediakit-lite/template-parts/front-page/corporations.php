<?php
/**
 * Companies Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-corporations-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Count actual companies with names or logos
$actual_company_count = 0;
for ( $i = 1; $i <= 6; $i++ ) {
    $name = get_theme_mod( 'mkp_corp_' . $i . '_name' );
    $logo = get_theme_mod( 'mkp_corp_' . $i . '_logo' );
    if ( $name || $logo ) {
        $actual_company_count++;
    }
}

// Get customizable section title (defaults to singular/plural based on count)
$default_title = ( $actual_company_count === 1 ) ? __( 'Company', 'mediakit-lite' ) : __( 'Companies', 'mediakit-lite' );
$section_title = get_theme_mod( 'mkp_corporations_section_title', $default_title );
?>

<section id="corporations" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-corporations__grid mkp-corporations__grid--count-<?php echo esc_attr( $actual_company_count ); ?>">
            <?php for ( $i = 1; $i <= 6; $i++ ) : 
                $name = get_theme_mod( 'mkp_corp_' . $i . '_name' );
                $logo = get_theme_mod( 'mkp_corp_' . $i . '_logo' );
                $bio = get_theme_mod( 'mkp_corp_' . $i . '_bio' );
                $link = get_theme_mod( 'mkp_corp_' . $i . '_link' );
                ?>
                <?php if ( $name || $logo ) : ?>
                <div class="mkp-corp-card mkp-card mkp-corp--<?php echo esc_attr( $i ); ?>">
                    <?php if ( $logo ) : ?>
                    <div class="mkp-corp-card__logo">
                        <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
                    </div>
                    <?php endif; ?>
                    
                    <?php if ( $name ) : ?>
                    <h3 class="mkp-corp-card__name"><?php echo esc_html( $name ); ?></h3>
                    <?php endif; ?>
                    
                    <div class="mkp-corp-card__bio">
                        <?php if ( $bio ) : ?>
                            <?php echo wp_kses_post( wpautop( $bio ) ); ?>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ( $link ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="mkp-btn mkp-btn--secondary mkp-btn--small" target="_blank" rel="noopener">
                            <?php esc_html_e( 'Visit Website', 'mediakit-lite' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>