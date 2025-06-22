<?php
/**
 * Fix for WordPress Customizer widget warnings
 *
 * @package MediaKit_Lite
 */

/**
 * Prevent widget-related warnings in the Customizer
 */
function mkp_fix_customizer_widget_warnings() {
    // Only run in the customizer
    if ( ! is_customize_preview() ) {
        return;
    }
    
    // Ensure widget areas are properly registered before customizer loads
    global $wp_registered_sidebars;
    
    if ( empty( $wp_registered_sidebars ) ) {
        // Re-run widgets_init if needed
        do_action( 'widgets_init' );
    }
}
add_action( 'customize_register', 'mkp_fix_customizer_widget_warnings', 5 );

/**
 * Remove widgets panel more safely
 */
function mkp_remove_widgets_panel_safely( $wp_customize ) {
    // Check if widgets panel exists before trying to remove it
    $widgets_panel = $wp_customize->get_panel( 'widgets' );
    if ( $widgets_panel ) {
        $wp_customize->remove_panel( 'widgets' );
    }
    
    // Also remove individual widget sections if they exist
    foreach ( $wp_customize->sections() as $section ) {
        if ( strpos( $section->id, 'sidebar-widgets-' ) === 0 ) {
            $wp_customize->remove_section( $section->id );
        }
    }
}
add_action( 'customize_register', 'mkp_remove_widgets_panel_safely', 100 );

/**
 * Suppress widget title warnings
 */
function mkp_suppress_widget_title_warnings() {
    // Hook into WordPress's error handling for the customizer
    if ( is_customize_preview() ) {
        // Temporarily suppress warnings during customizer load
        $original_error_reporting = error_reporting();
        error_reporting( $original_error_reporting & ~E_WARNING );
        
        // Restore after a short delay
        add_action( 'customize_controls_print_footer_scripts', function() use ( $original_error_reporting ) {
            error_reporting( $original_error_reporting );
        });
    }
}
add_action( 'customize_controls_init', 'mkp_suppress_widget_title_warnings' );