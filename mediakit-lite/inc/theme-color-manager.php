<?php
/**
 * Theme Color Management Functions for MediaKit Lite
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Global variable to track current color index as sections render
 */
global $mkp_section_color_index;

/**
 * Reset the section color rotation
 * Should be called at the beginning of front page rendering
 */
function mkp_reset_section_colors() {
    global $mkp_section_color_index;
    $mkp_section_color_index = 0;
}

/**
 * Get the next section colors in the rotation
 *
 * @return array Array with 'background' and 'text' color values
 */
function mkp_get_next_section_color() {
    global $mkp_section_color_index;
    
    // Initialize if not set
    if ( ! isset( $mkp_section_color_index ) ) {
        $mkp_section_color_index = 0;
    }
    
    // Get current theme
    $theme_key = get_theme_mod( 'mkp_color_theme', 'ocean_depths' );
    $theme = mkp_get_theme( $theme_key );
    
    // Calculate which color to use (1, 2, or 3)
    $color_num = ( $mkp_section_color_index % 3 ) + 1;
    
    // Increment for next section
    $mkp_section_color_index++;
    
    return array(
        'background' => $theme[ 'section_' . $color_num ],
        'text' => $theme[ 'section_' . $color_num . '_text' ]
    );
}

/**
 * Get section colors by fixed index (for specific use cases)
 *
 * @param int $section_index The section index (0-based)
 * @return array Array with 'background' and 'text' color values
 */
function mkp_get_section_color_by_index( $section_index ) {
    // Get current theme
    $theme_key = get_theme_mod( 'mkp_color_theme', 'ocean_depths' );
    $theme = mkp_get_theme( $theme_key );
    
    // Calculate which color to use (1, 2, or 3)
    $color_num = ( $section_index % 3 ) + 1;
    
    return array(
        'background' => $theme[ 'section_' . $color_num ],
        'text' => $theme[ 'section_' . $color_num . '_text' ]
    );
}

/**
 * Get header/navigation colors
 *
 * @return array Array with 'background' and 'text' color values
 */
function mkp_get_header_colors() {
    $theme = mkp_get_theme();
    
    return array(
        'background' => $theme['primary'],
        'text' => $theme['primary_text']
    );
}

/**
 * Get footer colors
 *
 * @return array Array with 'background' and 'text' color values
 */
function mkp_get_footer_colors() {
    $theme = mkp_get_theme();
    
    return array(
        'background' => $theme['primary'],
        'text' => $theme['primary_text']
    );
}

/**
 * Get button colors by type
 *
 * @param string $type Button type ('primary' or 'secondary')
 * @return array Array with 'background' and 'text' color values
 */
function mkp_get_button_colors( $type = 'primary' ) {
    $theme = mkp_get_theme();
    
    if ( $type === 'secondary' ) {
        return array(
            'background' => $theme['accent_2'],
            'text' => $theme['accent_2_text']
        );
    }
    
    return array(
        'background' => $theme['accent_1'],
        'text' => $theme['accent_1_text']
    );
}

/**
 * Get neutral colors
 *
 * @param string $type Type of neutral color ('light' or 'dark')
 * @return string Hex color value
 */
function mkp_get_neutral_color( $type = 'light' ) {
    $theme = mkp_get_theme();
    
    if ( $type === 'dark' ) {
        return $theme['neutral_dark'];
    }
    
    return $theme['neutral_light'];
}

/**
 * Get border color
 *
 * @return string Hex color value
 */
function mkp_get_border_color() {
    $theme = mkp_get_theme();
    return $theme['border'];
}

/**
 * Output inline CSS variables for current theme
 * This allows for easier use in CSS files
 */
function mkp_output_theme_css_variables() {
    $theme = mkp_get_theme();
    ?>
    <style>
        :root {
            --mkp-theme-primary: <?php echo esc_attr( $theme['primary'] ); ?>;
            --mkp-theme-primary-text: <?php echo esc_attr( $theme['primary_text'] ); ?>;
            --mkp-theme-section-1: <?php echo esc_attr( $theme['section_1'] ); ?>;
            --mkp-theme-section-1-text: <?php echo esc_attr( $theme['section_1_text'] ); ?>;
            --mkp-theme-section-2: <?php echo esc_attr( $theme['section_2'] ); ?>;
            --mkp-theme-section-2-text: <?php echo esc_attr( $theme['section_2_text'] ); ?>;
            --mkp-theme-section-3: <?php echo esc_attr( $theme['section_3'] ); ?>;
            --mkp-theme-section-3-text: <?php echo esc_attr( $theme['section_3_text'] ); ?>;
            --mkp-theme-accent-1: <?php echo esc_attr( $theme['accent_1'] ); ?>;
            --mkp-theme-accent-1-text: <?php echo esc_attr( $theme['accent_1_text'] ); ?>;
            --mkp-theme-accent-2: <?php echo esc_attr( $theme['accent_2'] ); ?>;
            --mkp-theme-accent-2-text: <?php echo esc_attr( $theme['accent_2_text'] ); ?>;
            --mkp-theme-neutral-light: <?php echo esc_attr( $theme['neutral_light'] ); ?>;
            --mkp-theme-neutral-dark: <?php echo esc_attr( $theme['neutral_dark'] ); ?>;
            --mkp-theme-border: <?php echo esc_attr( $theme['border'] ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'mkp_output_theme_css_variables', 5 );