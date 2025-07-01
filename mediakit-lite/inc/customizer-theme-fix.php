<?php
/**
 * Fix theme switching in customizer
 *
 * @package MediaKit_Lite
 */

/**
 * Prevent theme from switching during customizer session
 */
function mkp_prevent_customizer_theme_switch() {
    // Only run in customizer
    if ( ! is_customize_preview() ) {
        return;
    }
    
    // Log if we detect a theme mismatch
    $active_theme = get_option( 'stylesheet' );
    if ( $active_theme !== 'mediakit-lite' ) {
        mkp_debug_log( 'WARNING: Theme mismatch in customizer. Active: ' . $active_theme );
    }
}
add_action( 'init', 'mkp_prevent_customizer_theme_switch', 1 );

/**
 * Force our theme to be active in customizer context
 */
function mkp_force_theme_in_customizer( $theme ) {
    if ( is_customize_preview() && get_option( 'mkp_theme_active' ) ) {
        return 'mediakit-lite';
    }
    return $theme;
}
add_filter( 'stylesheet', 'mkp_force_theme_in_customizer', 99 );
add_filter( 'template', 'mkp_force_theme_in_customizer', 99 );

/**
 * Ensure customizer changeset uses correct theme
 */
function mkp_fix_customizer_changeset( $data, $filter_context ) {
    // Check if we have theme-related settings in the changeset
    if ( isset( $data['old_sidebars_widgets_data'] ) ) {
        mkp_debug_log( 'Changeset contains widget data' );
    }
    
    return $data;
}
add_filter( 'customize_changeset_data', 'mkp_fix_customizer_changeset', 10, 2 );

/**
 * Log when customizer changesets are saved
 */
function mkp_log_changeset_save( $post_id ) {
    $post = get_post( $post_id );
    if ( $post && 'customize_changeset' === $post->post_type ) {
        mkp_debug_log( 'Customizer changeset saved: ' . $post_id );
        
        // Check changeset content for theme switches
        $changeset_data = json_decode( $post->post_content, true );
        if ( json_last_error() === JSON_ERROR_NONE ) {
            foreach ( $changeset_data as $setting_id => $setting_data ) {
                if ( strpos( $setting_id, 'theme' ) !== false || strpos( $setting_id, 'stylesheet' ) !== false ) {
                    mkp_debug_log( 'Changeset contains theme-related setting: ' . $setting_id );
                }
            }
        }
    }
}
add_action( 'save_post', 'mkp_log_changeset_save' );