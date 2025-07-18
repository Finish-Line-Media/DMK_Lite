<?php
/**
 * Navigation & Brand Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Navigation & Brand settings
 */
function mkp_register_navigation_brand_section( $wp_customize ) {
    // Remove custom logo control
    $wp_customize->remove_control( 'custom_logo' );
    
    // Navigation Font
    $wp_customize->add_setting( 'mkp_nav_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_nav_font', array(
        'label'       => __( 'Navigation Font', 'mediakit-lite' ),
        'description' => __( 'Font for navigation menu items.', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'select',
        'priority'    => 50,
        'choices'     => array(
            'system'    => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'inter'     => __( 'Inter (Modern & Clean)', 'mediakit-lite' ),
            'roboto'    => __( 'Roboto (Google Style)', 'mediakit-lite' ),
            'opensans'  => __( 'Open Sans (Friendly)', 'mediakit-lite' ),
            'lato'      => __( 'Lato (Professional)', 'mediakit-lite' ),
            'montserrat' => __( 'Montserrat (Bold & Modern)', 'mediakit-lite' ),
            'poppins'   => __( 'Poppins (Geometric Sans)', 'mediakit-lite' ),
            'raleway'   => __( 'Raleway (Thin & Stylish)', 'mediakit-lite' ),
        ),
    ) );
    
    // Enable Search in Navigation
    $wp_customize->add_setting( 'mkp_enable_search', array(
        'default'           => false,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_search', array(
        'label'       => __( 'Enable Search in Navigation', 'mediakit-lite' ),
        'description' => __( 'Add a search bar to the main navigation menu.', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'checkbox',
        'priority'    => 60,
    ) );
    
    // Color Theme Selector
    $wp_customize->add_setting( 'mkp_color_theme', array(
        'default'           => 'ocean_depths',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_color_theme', array(
        'type'        => 'select',
        'section'     => 'title_tagline',
        'label'       => __( 'Color Theme', 'mediakit-lite' ),
        'description' => __( 'Choose a professional color theme for your entire site. Colors automatically rotate through sections for visual interest.', 'mediakit-lite' ),
        'choices'     => mkp_get_theme_names(),
        'priority'    => 20,
    ) );
    
    // Body Font
    $wp_customize->add_setting( 'mkp_body_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_body_font', array(
        'label'       => __( 'Body Font', 'mediakit-lite' ),
        'description' => __( 'Font family for body text and paragraphs.', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'select',
        'priority'    => 30,
        'choices'     => array(
            'system'    => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'inter'     => __( 'Inter (Modern & Clean)', 'mediakit-lite' ),
            'roboto'    => __( 'Roboto (Google Style)', 'mediakit-lite' ),
            'opensans'  => __( 'Open Sans (Friendly)', 'mediakit-lite' ),
            'lato'      => __( 'Lato (Professional)', 'mediakit-lite' ),
            'montserrat' => __( 'Montserrat (Bold & Modern)', 'mediakit-lite' ),
            'poppins'   => __( 'Poppins (Geometric Sans)', 'mediakit-lite' ),
            'raleway'   => __( 'Raleway (Thin & Stylish)', 'mediakit-lite' ),
        ),
    ) );
    
    // Heading Font
    $wp_customize->add_setting( 'mkp_heading_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_heading_font', array(
        'label'       => __( 'Heading Font', 'mediakit-lite' ),
        'description' => __( 'Font family for all headings (H1-H6).', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'select',
        'priority'    => 40,
        'choices'     => array(
            'system'     => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'georgia'    => __( 'Georgia (Classic Serif)', 'mediakit-lite' ),
            'playfair'   => __( 'Playfair Display (Editorial)', 'mediakit-lite' ),
            'merriweather' => __( 'Merriweather (Readable Serif)', 'mediakit-lite' ),
            'inter'      => __( 'Inter (Modern Sans)', 'mediakit-lite' ),
            'roboto'     => __( 'Roboto (Google Style)', 'mediakit-lite' ),
            'opensans'   => __( 'Open Sans (Friendly)', 'mediakit-lite' ),
            'lato'       => __( 'Lato (Professional)', 'mediakit-lite' ),
            'montserrat' => __( 'Montserrat (Bold & Modern)', 'mediakit-lite' ),
            'poppins'    => __( 'Poppins (Geometric Sans)', 'mediakit-lite' ),
            'raleway'    => __( 'Raleway (Thin & Stylish)', 'mediakit-lite' ),
        ),
    ) );
}