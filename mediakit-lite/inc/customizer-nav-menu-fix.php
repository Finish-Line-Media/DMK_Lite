<?php
/**
 * Fix for nav menu warnings in customizer
 *
 * @package MediaKit_Lite
 */

/**
 * Prevent nav menu errors by ensuring menu locations exist
 */
function mkp_fix_nav_menu_warnings() {
    // Register a dummy nav menu location to prevent errors
    register_nav_menus( array(
        'dummy' => __( 'Dummy Menu', 'mediakit-lite' ),
    ) );
}
add_action( 'init', 'mkp_fix_nav_menu_warnings' );

/**
 * Remove nav menus from customizer with multiple approaches
 */
function mkp_remove_nav_menus_completely( $wp_customize ) {
    // Remove the panel if it exists
    if ( $wp_customize->get_panel( 'nav_menus' ) ) {
        $wp_customize->remove_panel( 'nav_menus' );
    }
    
    // Remove all nav menu sections
    $sections = $wp_customize->sections();
    foreach ( $sections as $section ) {
        if ( strpos( $section->id, 'nav_menu' ) !== false || 
             strpos( $section->id, 'menu_locations' ) !== false ) {
            $wp_customize->remove_section( $section->id );
        }
    }
    
    // Remove all nav menu controls
    $controls = $wp_customize->controls();
    foreach ( $controls as $control ) {
        if ( strpos( $control->id, 'nav_menu' ) !== false ) {
            $wp_customize->remove_control( $control->id );
        }
    }
}
add_action( 'customize_register', 'mkp_remove_nav_menus_completely', 9999 );

/**
 * Hide nav menus with CSS as a fallback
 */
function mkp_hide_nav_menus_css() {
    ?>
    <style>
        #accordion-panel-nav_menus,
        .control-section[id*="nav_menu"],
        .customize-section-nav_menu,
        .customize-panel-nav_menus {
            display: none !important;
        }
    </style>
    <?php
}
add_action( 'customize_controls_print_styles', 'mkp_hide_nav_menus_css' );

/**
 * Prevent nav menu initialization errors
 */
function mkp_prevent_nav_menu_errors( $wp_customize ) {
    // Try to prevent the nav menu class from initializing
    remove_action( 'customize_register', array( $wp_customize->nav_menus, 'customize_register' ), 11 );
}
add_action( 'customize_register', 'mkp_prevent_nav_menu_errors', 5 );