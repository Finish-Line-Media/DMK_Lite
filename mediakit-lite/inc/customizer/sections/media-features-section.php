<?php
/**
 * Media Features Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Media Features Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_media_features_section( $wp_customize ) {
    /**
     * Media Features Section
     */
    $wp_customize->add_section( 'mkp_media_features_section', array(
        'title'       => __( 'Media Features', 'mediakit-lite' ),
        'priority'    => 54,
        'description' => __( 'Display "As Seen In" or "Featured In" media logos.', 'mediakit-lite' ),
    ) );
    
    // Enable Media Features Section
    $wp_customize->add_setting( 'mkp_enable_section_media_features', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_media_features', array(
        'label'       => __( 'Enable Media Features Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the media features section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_media_features_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_media_features_section_title', array(
        'default'           => __( 'Featured In', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_media_features_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_media_features_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Media Logos (up to 14)
    for ( $i = 1; $i <= 14; $i++ ) {
        // Logo
        $wp_customize->add_setting( 'mkp_media_feature_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_media_feature_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Media Logo %d', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_media_features_section',
            'priority'    => 10 + ( $i * 10 ),
        ) ) );
        
        // Name
        $wp_customize->add_setting( 'mkp_media_feature_' . $i . '_name', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_feature_' . $i . '_name', array(
            'label'       => sprintf( __( 'Media Outlet Name', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_media_features_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
        
        // Link
        $wp_customize->add_setting( 'mkp_media_feature_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_feature_' . $i . '_link', array(
            'label'       => sprintf( __( 'Link to Coverage', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_media_features_section',
            'type'        => 'url',
            'priority'    => 10 + ( $i * 10 ) + 2,
        ) );
    }
}