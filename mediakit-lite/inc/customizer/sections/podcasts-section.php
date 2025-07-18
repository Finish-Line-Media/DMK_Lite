<?php
/**
 * Podcast/Show Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Podcasts Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_podcasts_section( $wp_customize ) {
    /**
     * Podcast/Show Section
     */
    $wp_customize->add_section( 'mkp_podcasts_section', array(
        'title'       => __( 'Podcast/Show', 'mediakit-lite' ),
        'priority'    => 50,
        'description' => __( 'Podcasts or shows you host or co-host.', 'mediakit-lite' ),
    ) );
    
    // Enable Podcasts Section
    $wp_customize->add_setting( 'mkp_enable_section_podcasts', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_podcasts', array(
        'label'       => __( 'Enable Podcast/Show Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the podcast/show section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_podcasts_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_podcasts_section_title', array(
        'default'           => __( 'Podcast/Show', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_podcasts_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_podcasts_section',
        'type'            => 'text',
        'priority'        => 2,
    ) );
    
    // Podcast entries (up to 3)
    for ( $i = 1; $i <= 3; $i++ ) {
        // Podcast Title
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_podcast_' . $i . '_title', array(
            'label'       => sprintf( __( 'Podcast/Show %d Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_podcasts_section',
            'type'        => 'text',
            'priority'    => 10 + ($i * 10),
        ) );
        
        // Podcast Logo/Image
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_podcast_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Podcast/Show %d Logo/Image', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_podcasts_section',
            'priority'    => 11 + ($i * 10),
        ) ) );
        
        // Podcast Description
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_podcast_' . $i . '_description', array(
            'label'       => sprintf( __( 'Podcast/Show %d Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_podcasts_section',
            'type'        => 'textarea',
            'priority'    => 12 + ($i * 10),
        ) );
        
        // Podcast Link
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_podcast_' . $i . '_link', array(
            'label'       => sprintf( __( 'Podcast/Show %d Link', 'mediakit-lite' ), $i ),
            'description' => __( 'Link to podcast page, Apple Podcasts, Spotify, etc.', 'mediakit-lite' ),
            'section'     => 'mkp_podcasts_section',
            'type'        => 'url',
            'priority'    => 13 + ($i * 10),
        ) );
    }
}