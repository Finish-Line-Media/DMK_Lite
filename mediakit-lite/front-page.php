<?php
/**
 * The front page template file
 *
 * @package MediaKit_Lite
 */

// Safety check - ensure this template is only used for the actual front page
if ( ! is_front_page() || is_home() ) {
    // Redirect to correct template
    if ( is_home() && ! is_front_page() ) {
        // This is the blog page - use home.php
        get_template_part( 'home' );
        return;
    }
}

get_header();
?>

<main id="primary" class="mkp-main mkp-main--front-page">
    
    <?php
    // Reset color rotation for this page load
    mkp_reset_section_colors();
    
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
        
        // Check if section is enabled and has content
        if ( ! empty( $section_config['check_function'] ) ) {
            $has_content = call_user_func( $section_config['check_function'] );
            if ( mkp_should_display_section( $section_id, array( $has_content ) ) ) {
                get_template_part( $section_config['template'] );
            }
        } else {
            // No content check needed, just check if enabled
            if ( mkp_should_display_section( $section_id ) ) {
                get_template_part( $section_config['template'] );
            }
        }
    }
    ?>
    
</main>

<?php
get_footer();