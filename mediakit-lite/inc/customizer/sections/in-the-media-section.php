<?php
/**
 * In The Media Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register In The Media Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_in_the_media_section( $wp_customize ) {
    /**
     * In The Media Section
     */
    $wp_customize->add_section( 'mkp_in_the_media_section', array(
        'title'       => __( 'In The Media', 'mediakit-lite' ),
        'priority'    => 50,
        'description' => __( 'Showcase your media appearances, interviews, and press coverage.', 'mediakit-lite' ),
    ) );
    
    // Enable In The Media Section
    $wp_customize->add_setting( 'mkp_enable_section_in_the_media', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_in_the_media', array(
        'label'       => __( 'Enable In The Media Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the media appearances section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_in_the_media_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_in_the_media_section_title', array(
        'default'           => __( 'In The Media', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_in_the_media_section_title', array(
        'label'       => __( 'Section Title', 'mediakit-lite' ),
        'description' => __( 'Customize the section title', 'mediakit-lite' ),
        'section'     => 'mkp_in_the_media_section',
        'type'        => 'text',
        'priority'    => 2,
    ) );
    
    // Background Color
    // Media Items (up to 8)
    for ( $i = 1; $i <= 8; $i++ ) {
        // URL only
        $wp_customize->add_setting( 'mkp_media_item_' . $i . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_item_' . $i . '_url', array(
            'label'       => sprintf( __( 'Media Item %d URL', 'mediakit-lite' ), $i ),
            'description' => __( 'Paste YouTube, Spotify, Vimeo, or other media URL', 'mediakit-lite' ),
            'section'     => 'mkp_in_the_media_section',
            'type'        => 'url',
            'priority'    => 10 + $i,
        ) );
    }
}