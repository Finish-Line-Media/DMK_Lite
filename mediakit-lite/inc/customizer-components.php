<?php
/**
 * Properly remove customizer components
 *
 * @package MediaKit_Lite
 */

/**
 * Remove nav menus from customizer components
 * This is the correct way to remove these components without causing errors
 */
function mkp_customize_loaded_components( $components ) {
    // Remove nav menus component
    $key = array_search( 'nav_menus', $components );
    if ( false !== $key ) {
        unset( $components[ $key ] );
    }
    
    // Keep widgets component for sidebar functionality
    
    return $components;
}
add_filter( 'customize_loaded_components', 'mkp_customize_loaded_components', 10, 1 );