<?php
/**
 * Customizer preview safety functions
 *
 * This file loads early to ensure functions are available in the customizer preview context
 * 
 * @package MediaKit_Lite
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Note: mkp_debug_log is now defined in debug-logging.php with proper function_exists check

/**
 * Check if we're in customizer preview context
 */
function mkp_is_customizer_preview() {
    return is_customize_preview() || ( isset( $_REQUEST['wp_customize'] ) && 'on' === $_REQUEST['wp_customize'] );
}

/**
 * Safely load admin functions only when not in customizer preview
 */
function mkp_should_load_admin_functions() {
    // Don't load admin functions in customizer preview iframe
    if ( mkp_is_customizer_preview() ) {
        return false;
    }
    
    // Don't load if we're in the customizer controls context
    if ( isset( $_GET['customize_changeset_uuid'] ) ) {
        return true; // Load in controls, but not preview
    }
    
    return is_admin();
}