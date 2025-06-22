<?php
/**
 * Auto-contrast functionality for MediaKit Lite
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Calculate the luminance of a color
 * 
 * @param string $hex Hex color code
 * @return float Luminance value
 */
function mkp_get_color_luminance( $hex ) {
    // Remove # if present
    $hex = str_replace( '#', '', $hex );
    
    // Convert to RGB
    $r = hexdec( substr( $hex, 0, 2 ) ) / 255;
    $g = hexdec( substr( $hex, 2, 2 ) ) / 255;
    $b = hexdec( substr( $hex, 4, 2 ) ) / 255;
    
    // Calculate luminance
    $r = $r <= 0.03928 ? $r / 12.92 : pow( ( $r + 0.055 ) / 1.055, 2.4 );
    $g = $g <= 0.03928 ? $g / 12.92 : pow( ( $g + 0.055 ) / 1.055, 2.4 );
    $b = $b <= 0.03928 ? $b / 12.92 : pow( ( $b + 0.055 ) / 1.055, 2.4 );
    
    return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
}

/**
 * Determine if a color is light or dark
 * 
 * @param string $hex Hex color code
 * @return bool True if color is light, false if dark
 */
function mkp_is_light_color( $hex ) {
    return mkp_get_color_luminance( $hex ) > 0.5;
}

/**
 * Get contrast color (black or white) based on background
 * 
 * @param string $bg_color Background color hex
 * @return string Contrast color hex
 */
function mkp_get_contrast_color( $bg_color ) {
    return mkp_is_light_color( $bg_color ) ? '#000000' : '#ffffff';
}

/**
 * Get contrast color with opacity
 * 
 * @param string $bg_color Background color hex
 * @param string $type Type of contrast (text, heading, muted)
 * @return string RGBA color value
 */
function mkp_get_contrast_color_rgba( $bg_color, $type = 'text' ) {
    $is_light = mkp_is_light_color( $bg_color );
    
    switch ( $type ) {
        case 'heading':
            return $is_light ? 'rgba(0, 0, 0, 0.9)' : 'rgba(255, 255, 255, 0.95)';
        case 'muted':
            return $is_light ? 'rgba(0, 0, 0, 0.6)' : 'rgba(255, 255, 255, 0.7)';
        case 'border':
            return $is_light ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.15)';
        default: // text
            return $is_light ? 'rgba(0, 0, 0, 0.8)' : 'rgba(255, 255, 255, 0.9)';
    }
}

/**
 * Adjust color brightness
 * 
 * @param string $hex Hex color
 * @param int $percent Percentage to adjust (-100 to 100)
 * @return string Adjusted hex color
 */
function mkp_adjust_brightness( $hex, $percent ) {
    // Remove # if present
    $hex = str_replace( '#', '', $hex );
    
    // Convert to RGB
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
    
    // Calculate adjustment
    $r = max( 0, min( 255, $r + ( $r * $percent / 100 ) ) );
    $g = max( 0, min( 255, $g + ( $g * $percent / 100 ) ) );
    $b = max( 0, min( 255, $b + ( $b * $percent / 100 ) ) );
    
    // Return hex
    return '#' . sprintf( '%02x%02x%02x', $r, $g, $b );
}

/**
 * Get button hover color based on button background
 * 
 * @param string $bg_color Button background color
 * @return string Hover color
 */
function mkp_get_button_hover_color( $bg_color ) {
    // If the button is light, darken it on hover
    // If the button is dark, lighten it on hover
    return mkp_is_light_color( $bg_color ) 
        ? mkp_adjust_brightness( $bg_color, -15 ) 
        : mkp_adjust_brightness( $bg_color, 15 );
}