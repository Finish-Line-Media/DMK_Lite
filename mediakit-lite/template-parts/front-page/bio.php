<?php
/**
 * Bio/About Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-bio-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

$bio_content = mkp_get_bio_content(); // This will return default Lorem Ipsum if empty
?>

<section id="about" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'About', 'mediakit-lite' ); ?></h2>
        
        <div class="mkp-bio-section__content">
            <?php echo wp_kses_post( wpautop( $bio_content ) ); ?>
        </div>
    </div>
</section>