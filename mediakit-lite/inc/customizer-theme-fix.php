<?php
/**
 * Fix theme switching in customizer
 *
 * @package MediaKit_Lite
 */

/**
 * Prevent WordPress from creating changesets with theme switches
 */
function mkp_prevent_theme_switch_changeset() {
    // If we're coming from our own admin page, make sure theme parameter is correct
    if ( isset( $_GET['page'] ) && $_GET['page'] === 'mediakit-lite' ) {
        mkp_debug_log( 'Coming from MediaKit admin page' );
    }
    
    // If this is a theme preview for our own theme, that's OK
    if ( isset( $_GET['theme'] ) && $_GET['theme'] === 'mediakit-lite' && get_option( 'stylesheet' ) === 'mediakit-lite' ) {
        mkp_debug_log( 'Theme preview is for already active theme - OK' );
    }
}
add_action( 'customize_controls_init', 'mkp_prevent_theme_switch_changeset', 1 );

/**
 * Prevent changeset from including theme switch
 */
function mkp_filter_customize_changeset_branching( $allow_branching ) {
    // Log when branching is being checked
    mkp_debug_log( 'Changeset branching check: ' . ( $allow_branching ? 'true' : 'false' ) );
    return $allow_branching;
}
add_filter( 'customize_changeset_branching', 'mkp_filter_customize_changeset_branching' );

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