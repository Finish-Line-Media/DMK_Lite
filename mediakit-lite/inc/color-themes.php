<?php
/**
 * Color Theme Definitions for MediaKit Lite
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get all available color themes
 *
 * @return array Array of color theme configurations
 */
function mkp_get_color_themes() {
    return array(
        'ocean_depths' => array(
            'name' => __( 'Ocean Depths', 'mediakit-lite' ),
            'primary' => '#0D47A1',
            'primary_text' => '#FFFFFF',
            'section_1' => '#1976D2',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E3F2FD',
            'section_2_text' => '#0D47A1',
            'section_3' => '#BBDEFB',
            'section_3_text' => '#0D47A1',
            'accent_1' => '#FF6F61',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00ACC1',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#37474F',
            'border' => '#E0E0E0'
        ),
        'forest_journey' => array(
            'name' => __( 'Forest Journey', 'mediakit-lite' ),
            'primary' => '#1B5E20',
            'primary_text' => '#FFFFFF',
            'section_1' => '#2E7D32',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E8F5E9',
            'section_2_text' => '#1B5E20',
            'section_3' => '#81C784',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#FF7043',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#FDD835',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#263238',
            'border' => '#C8E6C9'
        ),
        'sunset_warmth' => array(
            'name' => __( 'Sunset Warmth', 'mediakit-lite' ),
            'primary' => '#BF360C',
            'primary_text' => '#FFFFFF',
            'section_1' => '#D84315',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#FFF3E0',
            'section_2_text' => '#BF360C',
            'section_3' => '#FFCCBC',
            'section_3_text' => '#BF360C',
            'accent_1' => '#7B1FA2',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00BCD4',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FFF8E1',
            'neutral_dark' => '#3E2723',
            'border' => '#FFAB91'
        ),
        'midnight_elegance' => array(
            'name' => __( 'Midnight Elegance', 'mediakit-lite' ),
            'primary' => '#1A237E',
            'primary_text' => '#FFFFFF',
            'section_1' => '#283593',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E8EAF6',
            'section_2_text' => '#1A237E',
            'section_3' => '#9FA8DA',
            'section_3_text' => '#1A237E',
            'accent_1' => '#F50057',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#FFAB00',
            'accent_2_text' => '#212121',
            'neutral_light' => '#F5F5F5',
            'neutral_dark' => '#212121',
            'border' => '#C5CAE9'
        ),
        'corporate_professional' => array(
            'name' => __( 'Corporate Professional', 'mediakit-lite' ),
            'primary' => '#263238',
            'primary_text' => '#FFFFFF',
            'section_1' => '#37474F',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#ECEFF1',
            'section_2_text' => '#263238',
            'section_3' => '#B0BEC5',
            'section_3_text' => '#263238',
            'accent_1' => '#0288D1',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#689F38',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#455A64',
            'border' => '#CFD8DC'
        ),
        'creative_spirit' => array(
            'name' => __( 'Creative Spirit', 'mediakit-lite' ),
            'primary' => '#4527A0',
            'primary_text' => '#FFFFFF',
            'section_1' => '#5E35B1',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#F3E5F5',
            'section_2_text' => '#4527A0',
            'section_3' => '#CE93D8',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#FF5252',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00E676',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#311B92',
            'border' => '#E1BEE7'
        )
    );
}

/**
 * Get theme names for customizer dropdown
 *
 * @return array Associative array of theme keys and names
 */
function mkp_get_theme_names() {
    $themes = mkp_get_color_themes();
    $names = array();
    
    foreach ( $themes as $key => $theme ) {
        $names[ $key ] = $theme['name'];
    }
    
    return $names;
}

/**
 * Get a specific theme's colors
 *
 * @param string $theme_key The theme identifier
 * @return array Theme colors or default theme if not found
 */
function mkp_get_theme( $theme_key = null ) {
    if ( ! $theme_key ) {
        $theme_key = get_theme_mod( 'mkp_color_theme', 'ocean_depths' );
    }
    
    $themes = mkp_get_color_themes();
    
    if ( ! isset( $themes[ $theme_key ] ) ) {
        $theme_key = 'ocean_depths';
    }
    
    return $themes[ $theme_key ];
}

/**
 * Get a specific color from the current theme
 *
 * @param string $color_key The color identifier (e.g., 'primary', 'accent_1')
 * @return string Hex color value
 */
function mkp_get_theme_color( $color_key ) {
    $theme = mkp_get_theme();
    return isset( $theme[ $color_key ] ) ? $theme[ $color_key ] : '#000000';
}