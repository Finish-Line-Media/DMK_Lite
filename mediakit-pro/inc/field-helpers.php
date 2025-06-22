<?php
/**
 * Field Helper Functions to replace ACF
 *
 * @package MediaKit_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get field value (replacement for ACF get_field)
 */
function mkp_get_field( $field_name, $post_id = null ) {
    if ( $post_id === 'option' ) {
        // Get option value
        return get_option( 'mkp_' . $field_name );
    }
    
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    // Get post meta value
    return get_post_meta( $post_id, '_mkp_' . $field_name, true );
}

/**
 * The field value (replacement for ACF the_field)
 */
function mkp_the_field( $field_name, $post_id = null ) {
    echo esc_html( mkp_get_field( $field_name, $post_id ) );
}

/**
 * Check if field has value
 */
function mkp_have_rows( $field_name, $post_id = null ) {
    $value = mkp_get_field( $field_name, $post_id );
    return ! empty( $value ) && is_array( $value );
}

/**
 * Get sub field value (for use in loops)
 */
function mkp_get_sub_field( $field_name ) {
    global $mkp_current_row;
    
    if ( isset( $mkp_current_row[ $field_name ] ) ) {
        return $mkp_current_row[ $field_name ];
    }
    
    return '';
}

/**
 * The sub field value
 */
function mkp_the_sub_field( $field_name ) {
    echo esc_html( mkp_get_sub_field( $field_name ) );
}

/**
 * Setup rows for iteration
 */
function mkp_setup_rows( $field_name, $post_id = null ) {
    global $mkp_field_rows, $mkp_field_index;
    
    $mkp_field_rows = mkp_get_field( $field_name, $post_id );
    $mkp_field_index = -1;
    
    if ( ! is_array( $mkp_field_rows ) ) {
        $mkp_field_rows = array();
    }
    
    return ! empty( $mkp_field_rows );
}

/**
 * Check if there are more rows
 */
function mkp_have_rows_loop() {
    global $mkp_field_rows, $mkp_field_index, $mkp_current_row;
    
    $mkp_field_index++;
    
    if ( isset( $mkp_field_rows[ $mkp_field_index ] ) ) {
        $mkp_current_row = $mkp_field_rows[ $mkp_field_index ];
        return true;
    }
    
    return false;
}

/**
 * Backward compatibility for ACF functions
 */
if ( ! function_exists( 'get_field' ) ) {
    function get_field( $field_name, $post_id = null ) {
        return mkp_get_field( $field_name, $post_id );
    }
}

if ( ! function_exists( 'the_field' ) ) {
    function the_field( $field_name, $post_id = null ) {
        mkp_the_field( $field_name, $post_id );
    }
}

if ( ! function_exists( 'have_rows' ) ) {
    function have_rows( $field_name, $post_id = null ) {
        return mkp_setup_rows( $field_name, $post_id );
    }
}

if ( ! function_exists( 'the_row' ) ) {
    function the_row() {
        return mkp_have_rows_loop();
    }
}

if ( ! function_exists( 'get_sub_field' ) ) {
    function get_sub_field( $field_name ) {
        return mkp_get_sub_field( $field_name );
    }
}

if ( ! function_exists( 'the_sub_field' ) ) {
    function the_sub_field( $field_name ) {
        mkp_the_sub_field( $field_name );
    }
}