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
            'name' => __( 'Ocean Depths (Blue)', 'mediakit-lite' ),
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
            'name' => __( 'Forest Journey (Green)', 'mediakit-lite' ),
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
            'name' => __( 'Sunset Warmth (Orange/Purple)', 'mediakit-lite' ),
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
            'name' => __( 'Midnight Elegance (Navy/Pink)', 'mediakit-lite' ),
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
            'name' => __( 'Corporate Professional (Gray/Blue)', 'mediakit-lite' ),
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
            'name' => __( 'Creative Spirit (Purple)', 'mediakit-lite' ),
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
        ),
        'ruby_passion' => array(
            'name' => __( 'Ruby Passion (Red)', 'mediakit-lite' ),
            'primary' => '#B71C1C',
            'primary_text' => '#FFFFFF',
            'section_1' => '#C62828',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#FFEBEE',
            'section_2_text' => '#B71C1C',
            'section_3' => '#EF9A9A',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#1565C0',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#F9A825',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#424242',
            'border' => '#FFCDD2'
        ),
        'golden_hour' => array(
            'name' => __( 'Golden Hour (Yellow/Brown)', 'mediakit-lite' ),
            'primary' => '#F57F17',
            'primary_text' => '#212121',
            'section_1' => '#F9A825',
            'section_1_text' => '#212121',
            'section_2' => '#FFFDE7',
            'section_2_text' => '#F57F17',
            'section_3' => '#FFF176',
            'section_3_text' => '#212121',
            'accent_1' => '#6A4C93',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00897B',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FFFEF7',
            'neutral_dark' => '#5D4037',
            'border' => '#FFE082'
        ),
        'lavender_fields' => array(
            'name' => __( 'Lavender Fields (Purple/Green)', 'mediakit-lite' ),
            'primary' => '#6A1B9A',
            'primary_text' => '#FFFFFF',
            'section_1' => '#7B1FA2',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#F3E5F5',
            'section_2_text' => '#6A1B9A',
            'section_3' => '#CE93D8',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#43A047',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#FFB300',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAF9FB',
            'neutral_dark' => '#4A148C',
            'border' => '#E1BEE7'
        ),
        'arctic_frost' => array(
            'name' => __( 'Arctic Frost (Cyan/White)', 'mediakit-lite' ),
            'primary' => '#00838F',
            'primary_text' => '#FFFFFF',
            'section_1' => '#0097A7',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E0F7FA',
            'section_2_text' => '#00838F',
            'section_3' => '#80DEEA',
            'section_3_text' => '#00838F',
            'accent_1' => '#FF6F00',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#D32F2F',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#263238',
            'border' => '#B2EBF2'
        ),
        'terra_cotta' => array(
            'name' => __( 'Terra Cotta (Brown/Orange)', 'mediakit-lite' ),
            'primary' => '#5D4037',
            'primary_text' => '#FFFFFF',
            'section_1' => '#6D4C41',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#EFEBE9',
            'section_2_text' => '#5D4037',
            'section_3' => '#BCAAA4',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#FF5722',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#009688',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAF7F5',
            'neutral_dark' => '#3E2723',
            'border' => '#D7CCC8'
        ),
        'emerald_city' => array(
            'name' => __( 'Emerald City (Green/Gold)', 'mediakit-lite' ),
            'primary' => '#00695C',
            'primary_text' => '#FFFFFF',
            'section_1' => '#00796B',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E0F2F1',
            'section_2_text' => '#00695C',
            'section_3' => '#80CBC4',
            'section_3_text' => '#00695C',
            'accent_1' => '#FFC107',
            'accent_1_text' => '#212121',
            'accent_2' => '#E91E63',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#004D40',
            'border' => '#B2DFDB'
        ),
        'cherry_blossom' => array(
            'name' => __( 'Cherry Blossom (Pink/Gray)', 'mediakit-lite' ),
            'primary' => '#C2185B',
            'primary_text' => '#FFFFFF',
            'section_1' => '#D81B60',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#FCE4EC',
            'section_2_text' => '#C2185B',
            'section_3' => '#F8BBD0',
            'section_3_text' => '#880E4F',
            'accent_1' => '#424242',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00ACC1',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FFF5F7',
            'neutral_dark' => '#880E4F',
            'border' => '#F48FB1'
        ),
        'sapphire_nights' => array(
            'name' => __( 'Sapphire Nights (Blue/Silver)', 'mediakit-lite' ),
            'primary' => '#0D47A1',
            'primary_text' => '#FFFFFF',
            'section_1' => '#1565C0',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E3F2FD',
            'section_2_text' => '#0D47A1',
            'section_3' => '#90CAF9',
            'section_3_text' => '#0D47A1',
            'accent_1' => '#9E9E9E',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#FFA726',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#1A237E',
            'border' => '#BBDEFB'
        ),
        'autumn_harvest' => array(
            'name' => __( 'Autumn Harvest (Orange/Red)', 'mediakit-lite' ),
            'primary' => '#E65100',
            'primary_text' => '#FFFFFF',
            'section_1' => '#EF6C00',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#FFF3E0',
            'section_2_text' => '#E65100',
            'section_3' => '#FFCC80',
            'section_3_text' => '#E65100',
            'accent_1' => '#C62828',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#2E7D32',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FFF8E1',
            'neutral_dark' => '#BF360C',
            'border' => '#FFB74D'
        ),
        'slate_modern' => array(
            'name' => __( 'Slate Modern (Gray)', 'mediakit-lite' ),
            'primary' => '#455A64',
            'primary_text' => '#FFFFFF',
            'section_1' => '#546E7A',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#ECEFF1',
            'section_2_text' => '#455A64',
            'section_3' => '#B0BEC5',
            'section_3_text' => '#263238',
            'accent_1' => '#FF4081',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00E5FF',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#263238',
            'border' => '#CFD8DC'
        ),
        'coral_reef' => array(
            'name' => __( 'Coral Reef (Coral/Teal)', 'mediakit-lite' ),
            'primary' => '#FF6F61',
            'primary_text' => '#FFFFFF',
            'section_1' => '#FF8A65',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#FFEBE7',
            'section_2_text' => '#FF6F61',
            'section_3' => '#FFAB91',
            'section_3_text' => '#BF360C',
            'accent_1' => '#00838F',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#7B1FA2',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FFF5F4',
            'neutral_dark' => '#5D4037',
            'border' => '#FFCCBC'
        ),
        'amethyst_dream' => array(
            'name' => __( 'Amethyst Dream (Purple/Pink)', 'mediakit-lite' ),
            'primary' => '#7B1FA2',
            'primary_text' => '#FFFFFF',
            'section_1' => '#8E24AA',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#F3E5F5',
            'section_2_text' => '#7B1FA2',
            'section_3' => '#CE93D8',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#E91E63',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00BCD4',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAF5FB',
            'neutral_dark' => '#4A148C',
            'border' => '#E1BEE7'
        ),
        'moss_stone' => array(
            'name' => __( 'Moss Stone (Green/Brown)', 'mediakit-lite' ),
            'primary' => '#33691E',
            'primary_text' => '#FFFFFF',
            'section_1' => '#558B2F',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#F1F8E9',
            'section_2_text' => '#33691E',
            'section_3' => '#AED581',
            'section_3_text' => '#33691E',
            'accent_1' => '#6D4C41',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#FFA000',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAF9F5',
            'neutral_dark' => '#1B5E20',
            'border' => '#C5E1A5'
        ),
        'electric_blue' => array(
            'name' => __( 'Electric Blue (Blue/Yellow)', 'mediakit-lite' ),
            'primary' => '#0277BD',
            'primary_text' => '#FFFFFF',
            'section_1' => '#0288D1',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E1F5FE',
            'section_2_text' => '#0277BD',
            'section_3' => '#81D4FA',
            'section_3_text' => '#01579B',
            'accent_1' => '#FFD600',
            'accent_1_text' => '#212121',
            'accent_2' => '#FF6D00',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#01579B',
            'border' => '#B3E5FC'
        ),
        'mocha_velvet' => array(
            'name' => __( 'Mocha Velvet (Coffee/Red)', 'mediakit-lite' ),
            'primary' => '#4E342E',
            'primary_text' => '#FFFFFF',
            'section_1' => '#5D4037',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#EFEBE9',
            'section_2_text' => '#4E342E',
            'section_3' => '#A1887F',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#D32F2F',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#FFA726',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#3E2723',
            'border' => '#BCAAA4'
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