<?php
/**
 * Investor Section Template Part
 *
 * @package MediaKit_Pro
 */

$section_class = 'mkp-investor-section';
$section_color = get_theme_mod( 'mkp_investor_background_color', '#ffffff' );
$investment_people = get_theme_mod( 'mkp_investment_people' );
$investment_products = get_theme_mod( 'mkp_investment_products' );
$investment_markets = get_theme_mod( 'mkp_investment_markets' );
?>

<section id="investor" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Investment Focus', 'mediakit-pro' ); ?></h2>
        
        <div class="mkp-investor__lanes">
            <?php if ( $investment_people ) : ?>
                <div class="mkp-investor__lane">
                    <h3 class="mkp-investor__lane-title"><?php esc_html_e( 'People', 'mediakit-pro' ); ?></h3>
                    <div class="mkp-investor__lane-content">
                        <?php echo wp_kses_post( wpautop( $investment_people ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ( $investment_products ) : ?>
                <div class="mkp-investor__lane">
                    <h3 class="mkp-investor__lane-title"><?php esc_html_e( 'Products', 'mediakit-pro' ); ?></h3>
                    <div class="mkp-investor__lane-content">
                        <?php echo wp_kses_post( wpautop( $investment_products ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ( $investment_markets ) : ?>
                <div class="mkp-investor__lane">
                    <h3 class="mkp-investor__lane-title"><?php esc_html_e( 'Markets', 'mediakit-pro' ); ?></h3>
                    <div class="mkp-investor__lane-content">
                        <?php echo wp_kses_post( wpautop( $investment_markets ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>