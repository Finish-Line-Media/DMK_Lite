<?php
/**
 * Properly remove customizer components
 *
 * @package MediaKit_Lite
 */

/**
 * Remove nav menus and widgets from customizer components
 * This is the correct way to remove these components without causing errors
 */
function mkp_customize_loaded_components( $components ) {
    // Remove nav menus component
    $key = array_search( 'nav_menus', $components );
    if ( false !== $key ) {
        unset( $components[ $key ] );
    }
    
    // Remove widgets component
    $key = array_search( 'widgets', $components );
    if ( false !== $key ) {
        unset( $components[ $key ] );
    }
    
    return $components;
}
add_filter( 'customize_loaded_components', 'mkp_customize_loaded_components', 10, 1 );