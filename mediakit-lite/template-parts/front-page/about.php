<?php
/**
 * About Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-about-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

$about_content = mkp_get_about_content(); // This will return default Lorem Ipsum if empty
?>

<section id="about" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( get_theme_mod( 'mkp_about_section_title', __( 'About', 'mediakit-lite' ) ) ); ?></h2>
        
        <div class="mkp-about-section__content">
            <?php echo wp_kses_post( wpautop( $about_content ) ); ?>
        </div>
    </div>
</section>