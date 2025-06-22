<?php
/**
 * Companies Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-corporations-section';
$section_color = get_theme_mod( 'mkp_corporations_background_color', '#ffffff' );

// Count actual companies with names
$actual_company_count = 0;
for ( $i = 1; $i <= 4; $i++ ) {
    $name = get_theme_mod( 'mkp_corp_' . $i . '_name' );
    if ( $name ) {
        $actual_company_count++;
    }
}

// Determine section title based on count
$section_title = ( $actual_company_count === 1 ) ? __( 'Company', 'mediakit-lite' ) : __( 'Companies', 'mediakit-lite' );
?>

<section id="corporations" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-corporations__grid">
            <?php for ( $i = 1; $i <= 4; $i++ ) : 
                $name = get_theme_mod( 'mkp_corp_' . $i . '_name' );
                $logo = get_theme_mod( 'mkp_corp_' . $i . '_logo' );
                $bio = get_theme_mod( 'mkp_corp_' . $i . '_bio' );
                $link = get_theme_mod( 'mkp_corp_' . $i . '_link' );
                
                if ( $name ) : ?>
                    <div class="mkp-corp-card mkp-corp--<?php echo esc_attr( $i ); ?>">
                        <?php if ( $logo ) : ?>
                            <div class="mkp-corp-card__logo">
                                <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="mkp-corp-card__name"><?php echo esc_html( $name ); ?></h3>
                        
                        <?php if ( $bio ) : ?>
                            <div class="mkp-corp-card__bio">
                                <?php echo wp_kses_post( wpautop( $bio ) ); ?>
                            </div>
                        <?php endif; ?>
                        
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