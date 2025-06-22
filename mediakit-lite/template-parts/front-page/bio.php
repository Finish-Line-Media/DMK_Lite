<?php
/**
 * Bio/About Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-bio-section';
$section_color = get_theme_mod( 'mkp_bio_background_color', '#ffffff' );
$bio_content = get_theme_mod( 'mkp_bio_content' );
?>

<section id="about" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'About', 'mediakit-lite' ); ?></h2>
        
        <div class="mkp-bio-section__content">
            <?php echo wp_kses_post( wpautop( $bio_content ) ); ?>
        </div>
    </div>
</section>