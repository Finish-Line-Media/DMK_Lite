<?php
/**
 * Customizer Sanitization Functions
 *
 * @package MediaKit_Lite
 */

/**
 * Checkbox sanitization callback
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function mkp_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Select sanitization callback
 *
 * @param string $input The input value.
 * @param object $setting The setting object.
 * @return string The sanitized value.
 */
function mkp_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Number sanitization callback
 *
 * @param int $number The number value.
 * @param object $setting The setting object.
 * @return int The sanitized number.
 */
function mkp_sanitize_number( $number, $setting ) {
    $number = absint( $number );
    $atts = $setting->manager->get_control( $setting->id )->input_attrs;
    
    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
    $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
    
    return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 * Image sanitization callback
 *
 * @param string $image Image URL.
 * @param object $setting Setting object.
 * @return string The sanitized image URL.
 */
function mkp_sanitize_image( $image, $setting ) {
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon',
        'svg'          => 'image/svg+xml',
    );
    
    $file = wp_check_filetype( $image, $mimes );
    return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Sanitize font choice
 *
 * @param string $value The font choice.
 * @return string The sanitized font choice.
 */
function mkp_sanitize_font_choice( $value ) {
    $valid = array( 'system', 'inter', 'roboto', 'opensans', 'lato', 'montserrat', 'playfair', 'merriweather', 'georgia', 'poppins', 'raleway' );
    
    if ( in_array( $value, $valid, true ) ) {
        return $value;
    }
    
    return 'system';
}

/**
 * Sanitize position choice
 *
 * @param string $value The position value.
 * @return string The sanitized position.
 */
function mkp_sanitize_position_choice( $value ) {
    $valid = array( 'left', 'right' );
    
    if ( in_array( $value, $valid, true ) ) {
        return $value;
    }
    
    return 'left';
}

/**
 * Sanitize gallery images (comma-separated IDs)
 *
 * @param string $value Comma-separated image IDs.
 * @return string Sanitized comma-separated IDs.
 */
function mkp_sanitize_gallery_images( $value ) {
    if ( empty( $value ) ) {
        return '';
    }
    
    // Split comma-separated IDs
    $ids = explode( ',', $value );
    $sanitized = array();
    $count = 0;
    
    foreach ( $ids as $id ) {
        if ( $count >= 50 ) {
            break;
        }
        
        $id = absint( trim( $id ) );
        if ( $id && wp_attachment_is_image( $id ) ) {
            $sanitized[] = $id;
            $count++;
        }
    }
    
    return implode( ',', $sanitized );
}

/**
 * Sanitize color theme choice
 *
 * @param string $value The theme choice.
 * @return string The sanitized theme choice.
 */
function mkp_sanitize_color_theme( $value ) {
    $themes = mkp_get_theme_names();
    
    if ( array_key_exists( $value, $themes ) ) {
        return $value;
    }
    
    return 'ocean_depths';
}

/**
 * HEX Color sanitization callback
 *
 * @param string $hex_color HEX color to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The sanitized hex color if not null; otherwise, the setting default.
 */
function mkp_sanitize_hex_color( $hex_color, $setting ) {
    $hex_color = sanitize_hex_color( $hex_color );
    
    if ( ! is_null( $hex_color ) ) {
        return $hex_color;
    }
    
    return $setting->default;
}

/**
 * Alpha color sanitization callback
 *
 * @param string $color The alpha color.
 * @return string The sanitized alpha color.
 */
function mkp_sanitize_alpha_color( $color ) {
    if ( '' === $color ) {
        return '';
    }
    
    if ( false === strpos( $color, 'rgba' ) ) {
        return sanitize_hex_color( $color );
    }
    
    $color = str_replace( ' ', '', $color );
    sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
    
    return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
}