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
 * Ensure widgets are registered early
 */
function mkp_early_widget_registration() {
    // Force early widget registration
    if ( function_exists( 'mkp_widgets_init' ) ) {
        mkp_widgets_init();
    }
}
add_action( 'init', 'mkp_early_widget_registration', 5 );

// Widgets removal moved to customize_loaded_components filter in customizer-components.php

// Error suppression removed as requested