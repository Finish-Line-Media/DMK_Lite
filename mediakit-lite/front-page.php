<?php
/**
 * The front page template file
 *
 * @package MediaKit_Lite
 */

get_header();
?>

<main id="primary" class="mkp-main mkp-main--front-page">
    
    <?php
    // Reset color rotation for this page load
    if ( function_exists( 'mkp_reset_section_colors' ) ) {
        mkp_reset_section_colors();
    }
    
    // Get front page sections configuration
    $sections = mkp_get_front_page_sections();
    
    // Get custom section order
    $section_order = mkp_get_section_order();
    
    // Loop through sections in custom order
    foreach ( $section_order as $section_id ) {
        if ( ! isset( $sections[ $section_id ] ) ) {
            continue;
        }
        
        $section_config = $sections[ $section_id ];
        // Check if section should always show
        if ( ! empty( $section_config['always_show'] ) && $section_config['always_show'] ) {
            get_template_part( $section_config['template'] );
            continue;
        }
        
        // Check if section is enabled
        if ( get_theme_mod( 'mkp_enable_section_' . $section_id, false ) ) {
            get_template_part( $section_config['template'] );
        }
    }
    ?>
    
</main>

<?php
get_footer();