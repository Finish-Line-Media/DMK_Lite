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
    // Always log for debugging theme crash
    error_log( '[MediaKit Debug ' . date('Y-m-d H:i:s') . '] ' . $message );
    
    // Also log memory usage in customizer
    if ( is_customize_preview() || ( is_admin() && isset( $_GET['customize_changeset_uuid'] ) ) ) {
        $memory = round( memory_get_usage() / 1024 / 1024, 2 );
        $peak = round( memory_get_peak_usage() / 1024 / 1024, 2 );
        error_log( '[MediaKit Memory] Current: ' . $memory . 'MB, Peak: ' . $peak . 'MB' );
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
    
    // Log current theme info
    $current_theme = wp_get_theme();
    mkp_debug_log( 'Current theme in customizer: ' . $current_theme->get( 'Name' ) );
    
    // Check if we're in a theme preview
    if ( ! empty( $_GET['theme'] ) ) {
        mkp_debug_log( 'Theme preview detected: ' . $_GET['theme'] );
    }
    
    // Check changeset theme
    global $wp_customize;
    if ( isset( $wp_customize ) ) {
        $changeset_data = $wp_customize->changeset_data();
        if ( ! empty( $changeset_data ) ) {
            mkp_debug_log( 'Changeset data present' );
        }
    }
}
add_action( 'customize_register', 'mkp_log_customizer_init', 1 );

/**
 * Log PHP errors that might cause theme deactivation
 */
function mkp_log_shutdown_errors() {
    // Always log when shutdown function runs in admin
    if ( is_admin() ) {
        error_log( '[MediaKit Debug SHUTDOWN ' . date('Y-m-d H:i:s') . '] Shutdown function called' );
    }
    
    $error = error_get_last();
    if ( $error ) {
        // Log all errors, not just fatal ones
        error_log( '[MediaKit Debug SHUTDOWN ' . date('Y-m-d H:i:s') . '] Error type ' . $error['type'] . ': ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'] );
    }
    
    // Check if theme is still active
    $active_theme = get_option( 'stylesheet' );
    if ( $active_theme !== 'mediakit-lite' && get_option( 'mkp_theme_active' ) ) {
        error_log( '[MediaKit Debug SHUTDOWN ' . date('Y-m-d H:i:s') . '] Theme was deactivated! Now active: ' . $active_theme );
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

/**
 * Log when customizer controls are printed
 */
function mkp_log_customizer_controls() {
    mkp_debug_log( 'Customizer controls printed' );
}
add_action( 'customize_controls_print_footer_scripts', 'mkp_log_customizer_controls' );

/**
 * Log AJAX requests that might indicate customizer exit
 */
function mkp_log_ajax_requests() {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        $action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'unknown';
        mkp_debug_log( 'AJAX action: ' . $action );
    }
}
add_action( 'init', 'mkp_log_ajax_requests' );

/**
 * Log when returning from customizer
 */
function mkp_log_customizer_return() {
    if ( isset( $_GET['return'] ) ) {
        mkp_debug_log( 'Returning from customizer to: ' . $_GET['return'] );
    }
    
    // Check if we're on a page that suggests we left customizer
    if ( isset( $_SERVER['HTTP_REFERER'] ) && strpos( $_SERVER['HTTP_REFERER'], 'customize.php' ) !== false ) {
        mkp_debug_log( 'Referred from customizer' );
    }
}
add_action( 'admin_init', 'mkp_log_customizer_return' );

/**
 * Log all page loads to catch crash
 */
function mkp_log_page_loads() {
    if ( is_admin() ) {
        global $pagenow;
        mkp_debug_log( 'Admin page load: ' . $pagenow . ' | Query: ' . $_SERVER['QUERY_STRING'] );
        
        // Special logging for potential crash scenarios
        if ( $pagenow === 'themes.php' ) {
            $active_theme = wp_get_theme();
            mkp_debug_log( 'Themes page - Active theme: ' . $active_theme->get( 'Name' ) );
        }
    }
}
add_action( 'admin_init', 'mkp_log_page_loads', 0 );