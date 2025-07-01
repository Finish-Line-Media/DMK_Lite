<?php
/**
 * Debug logging for tracking theme deactivation
 *
 * @package MediaKit_Lite
 */

/**
 * Log debug messages with timestamp
 */
function mkp_debug_log( $message ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
        error_log( '[MediaKit Debug ' . date('Y-m-d H:i:s') . '] ' . $message );
    }
}

/**
 * Log when theme is being switched
 */
function mkp_log_theme_switch( $new_name, $new_theme, $old_theme ) {
    mkp_debug_log( 'Theme switch initiated. Old: ' . $old_theme->get( 'Name' ) . ', New: ' . $new_name );
    mkp_debug_log( 'Stack trace: ' . wp_debug_backtrace_summary() );
}
add_action( 'switch_theme', 'mkp_log_theme_switch', 10, 3 );

/**
 * Log after theme switch
 */
function mkp_log_after_theme_switch() {
    mkp_debug_log( 'After switch theme - MediaKit Lite activated' );
}
add_action( 'after_switch_theme', 'mkp_log_after_theme_switch' );

/**
 * Log customizer save
 */
function mkp_log_customizer_save() {
    mkp_debug_log( 'Customizer save initiated' );
}
add_action( 'customize_save', 'mkp_log_customizer_save' );

/**
 * Log after customizer save
 */
function mkp_log_customizer_save_after() {
    mkp_debug_log( 'Customizer save completed successfully' );
}
add_action( 'customize_save_after', 'mkp_log_customizer_save_after', 999 );

/**
 * Log when customizer is loaded
 */
function mkp_log_customizer_init() {
    mkp_debug_log( 'Customizer initialized' );
}
add_action( 'customize_register', 'mkp_log_customizer_init', 1 );

/**
 * Log PHP errors that might cause theme deactivation
 */
function mkp_log_shutdown_errors() {
    $error = error_get_last();
    if ( $error && in_array( $error['type'], array( E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR ) ) ) {
        mkp_debug_log( 'Fatal error detected: ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'] );
    }
}
register_shutdown_function( 'mkp_log_shutdown_errors' );

/**
 * Log when admin notices are displayed (theme might have crashed)
 */
function mkp_log_admin_notices() {
    global $pagenow;
    if ( 'themes.php' === $pagenow && isset( $_GET['activated'] ) ) {
        mkp_debug_log( 'Theme activation page loaded with activated parameter' );
    }
}
add_action( 'admin_notices', 'mkp_log_admin_notices' );

/**
 * Log customizer preview init
 */
function mkp_log_customizer_preview() {
    mkp_debug_log( 'Customizer preview initialized' );
}
add_action( 'customize_preview_init', 'mkp_log_customizer_preview' );