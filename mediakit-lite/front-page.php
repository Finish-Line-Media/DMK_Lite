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
    // Get front page sections configuration
    $sections = mkp_get_front_page_sections();
    
    // Loop through sections and display them
    foreach ( $sections as $section_id => $section_config ) {
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