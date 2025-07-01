<?php
/**
 * Theme crash detection
 *
 * @package MediaKit_Lite
 */

/**
 * Set a flag when theme is active
 */
function mkp_set_active_flag() {
    update_option( 'mkp_theme_active', true );
    mkp_debug_log( 'Theme active flag set' );
}
add_action( 'after_setup_theme', 'mkp_set_active_flag' );

/**
 * Clear flag when theme is deactivated
 */
function mkp_clear_active_flag() {
    delete_option( 'mkp_theme_active' );
    mkp_debug_log( 'Theme active flag cleared - theme deactivating!' );
}
add_action( 'switch_theme', 'mkp_clear_active_flag' );

/**
 * Check if we're still the active theme
 */
function mkp_check_if_still_active() {
    $current_theme = get_option( 'stylesheet' );
    $our_theme = get_option( 'mkp_theme_active' );
    
    if ( $our_theme && $current_theme !== 'mediakit-lite' ) {
        mkp_debug_log( 'CRITICAL: Theme was deactivated! Current theme: ' . $current_theme );
    }
}
add_action( 'admin_init', 'mkp_check_if_still_active' );

/**
 * Monitor for theme health check failures
 */
function mkp_monitor_theme_health() {
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'activate' && isset( $_GET['error'] ) ) {
        mkp_debug_log( 'Theme activation error detected: ' . $_GET['error'] );
    }
}
add_action( 'admin_init', 'mkp_monitor_theme_health' );