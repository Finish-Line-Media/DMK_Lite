<?php
/**
 * Dynamic styles generation for MediaKit Lite
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Generate dynamic CSS based on customizer settings
 */
function mkp_generate_dynamic_styles() {
    // Get current theme colors
    $theme = mkp_get_theme();
    
    // Get font settings
    $body_font = get_theme_mod( 'mkp_body_font', 'system' );
    $heading_font = get_theme_mod( 'mkp_heading_font', 'system' );
    $nav_font = get_theme_mod( 'mkp_nav_font', 'system' );
    
    // Font family mappings
    $font_families = array(
        'system'     => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
        'inter'      => '"Inter", sans-serif',
        'roboto'     => '"Roboto", sans-serif',
        'opensans'   => '"Open Sans", sans-serif',
        'lato'       => '"Lato", sans-serif',
        'montserrat' => '"Montserrat", sans-serif',
        'playfair'   => '"Playfair Display", serif',
        'merriweather' => '"Merriweather", serif',
        'georgia'    => 'Georgia, "Times New Roman", serif',
        'poppins'    => '"Poppins", sans-serif',
        'raleway'    => '"Raleway", sans-serif',
    );
    
    $body_font_family = isset( $font_families[ $body_font ] ) ? $font_families[ $body_font ] : $font_families['system'];
    $heading_font_family = isset( $font_families[ $heading_font ] ) ? $font_families[ $heading_font ] : $font_families['system'];
    $nav_font_family = isset( $font_families[ $nav_font ] ) ? $font_families[ $nav_font ] : $font_families['system'];
    
    ob_start();
    ?>
    <style id="mkp-dynamic-styles">
        /* Typography CSS Variables */
        :root {
            --mkp-font-primary: <?php echo $body_font_family; ?>;
            --mkp-font-heading: <?php echo $heading_font_family; ?>;
            --mkp-font-nav: <?php echo $nav_font_family; ?>;
        }
        
        /* Apply nav font */
        .mkp-nav {
            font-family: var(--mkp-font-nav);
        }
        
        /* Header & Navigation */
        .mkp-header {
            background-color: <?php echo esc_attr( $theme['primary'] ); ?>;
            color: <?php echo esc_attr( $theme['primary_text'] ); ?>;
        }
        
        .mkp-nav__link {
            color: <?php echo esc_attr( $theme['primary_text'] ); ?>;
        }
        
        .mkp-nav__link:hover,
        .mkp-nav__link:focus {
            color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
        }
        
        /* Mobile navigation hamburger */
        .mkp-mobile-toggle span {
            background-color: <?php echo esc_attr( $theme['primary_text'] ); ?>;
        }
        
        /* Search in navigation */
        .mkp-nav__search-field {
            background-color: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.3);
            color: <?php echo esc_attr( $theme['neutral_dark'] ); ?>;
        }
        
        .mkp-nav__search-field:focus {
            background-color: rgba(255, 255, 255, 1);
            border-color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
        }
        
        .mkp-nav__search-field::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }
        
        .mkp-nav__search-submit {
            background-color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
            border-color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
            color: <?php echo esc_attr( $theme['accent_1_text'] ); ?>;
        }
        
        .mkp-nav__search-submit:hover {
            background-color: <?php echo esc_attr( $theme['accent_2'] ); ?>;
            border-color: <?php echo esc_attr( $theme['accent_2'] ); ?>;
            color: <?php echo esc_attr( $theme['accent_2_text'] ); ?>;
        }
        
        /* Mobile navigation dropdown */
        @media (max-width: 768px) {
            .mkp-nav {
                background-color: <?php echo esc_attr( $theme['primary'] ); ?>;
            }
        }
        
        /* Footer */
        .mkp-footer {
            margin-top: 0;
        }
        
        .mkp-footer a {
            color: inherit;
            opacity: 0.9;
        }
        
        .mkp-footer a:hover {
            opacity: 1;
            text-decoration: underline;
        }
        
        /* Primary Buttons */
        .mkp-btn--primary {
            background-color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
            color: <?php echo esc_attr( $theme['accent_1_text'] ); ?>;
            border: 2px solid <?php echo esc_attr( $theme['accent_1'] ); ?>;
        }
        
        .mkp-btn--primary:hover,
        .mkp-btn--primary:focus {
            background-color: <?php echo esc_attr( $theme['accent_2'] ); ?>;
            color: <?php echo esc_attr( $theme['accent_2_text'] ); ?>;
            border-color: <?php echo esc_attr( $theme['accent_2'] ); ?>;
            text-decoration: none;
        }
        
        /* Secondary Buttons */
        .mkp-btn--secondary {
            background-color: transparent;
            color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
            border: 2px solid <?php echo esc_attr( $theme['accent_1'] ); ?>;
        }
        
        .mkp-btn--secondary:hover,
        .mkp-btn--secondary:focus {
            background-color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
            color: <?php echo esc_attr( $theme['accent_1_text'] ); ?>;
            border-color: <?php echo esc_attr( $theme['accent_1'] ); ?>;
            text-decoration: none;
        }
        
        /* Links in sections inherit text color */
        .mkp-section a {
            color: inherit;
            text-decoration: underline;
        }
        
        .mkp-section a:hover {
            opacity: 0.8;
        }
        
        /* Section-specific styles for better contrast */
        .mkp-section h1,
        .mkp-section h2,
        .mkp-section h3,
        .mkp-section h4,
        .mkp-section h5,
        .mkp-section h6 {
            color: inherit;
        }
        
        /* Glass-morphism is now applied via the base .mkp-card class */
        
        /* Speaker topic cards inherit section colors */
        .mkp-speaker-section--cards .mkp-speaker__topic-title {
            color: inherit;
        }
        
        .mkp-speaker-section--cards .mkp-speaker__topic-arrow {
            color: inherit;
            opacity: 0.7;
        }
        
        /* Investment verticals inherit section colors */
        .mkp-investor-card__title {
            color: inherit;
        }
        
        .mkp-investor-card__description {
            color: inherit;
            opacity: 0.9;
        }
        
        /* Contact section email color fix */
        .mkp-contact-section .mkp-contact__email {
            color: inherit;
            text-decoration: underline;
        }
        
        .mkp-contact-section .mkp-contact__email:hover {
            opacity: 0.8;
        }
        
        /* Hero tags styling */
        .mkp-hero .mkp-hero__tag {
            background-color: transparent;
            color: inherit;
            padding: 0;
            border-radius: 0;
            font-weight: 400;
        }
        
        .mkp-hero .mkp-hero__tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0;
            justify-content: center;
            align-items: center;
            margin-bottom: var(--mkp-spacing-xl);
        }
        
        .mkp-hero .mkp-hero__tag-group {
            display: inline;
            white-space: nowrap;
        }
        
        .mkp-hero .mkp-hero__separator {
            margin: 0 0.75em;
            opacity: 0.5;
            color: inherit;
        }
        
        /* Border color */
        .mkp-section {
            border-color: <?php echo esc_attr( $theme['border'] ); ?>;
        }
        
        /* Social icons in contact section - removed hover to allow platform-specific colors */
    </style>
    <?php
    
    return ob_get_clean();
}

/**
 * Output dynamic styles
 */
function mkp_output_dynamic_styles() {
    echo mkp_generate_dynamic_styles();
}
add_action( 'wp_head', 'mkp_output_dynamic_styles', 100 );