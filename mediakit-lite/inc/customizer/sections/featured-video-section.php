<?php
/**
 * Featured Video Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Featured Video Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_featured_video_section( $wp_customize ) {
    /**
     * Featured Video Section
     */
    $wp_customize->add_section( 'mkp_featured_video_section', array(
        'title'       => __( 'Featured Video', 'mediakit-lite' ),
        'priority'    => 51,
        'description' => __( 'Showcase a featured video with optional call-to-action buttons.', 'mediakit-lite' ),
    ) );
    
    // Enable Section
    $wp_customize->add_setting( 'mkp_enable_section_featured_video', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_featured_video', array(
        'label'       => __( 'Enable Featured Video Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the featured video section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_featured_video_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_featured_video_section_title', array(
        'default'           => __( 'Featured Video', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Video URL
    $wp_customize->add_setting( 'mkp_featured_video_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_url', array(
        'label'           => __( 'Video URL', 'mediakit-lite' ),
        'description'     => __( 'Enter a YouTube, Vimeo, or other supported video URL', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'url',
        'priority'        => 10,
    ) );
    
    // Video Title
    $wp_customize->add_setting( 'mkp_featured_video_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_title', array(
        'label'           => __( 'Video Title', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 15,
    ) );
    
    // Video Description
    $wp_customize->add_setting( 'mkp_featured_video_description', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_description', array(
        'label'           => __( 'Video Description', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'textarea',
        'priority'        => 20,
    ) );
    
    // Primary CTA Text
    $wp_customize->add_setting( 'mkp_featured_video_primary_cta_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_primary_cta_text', array(
        'label'           => __( 'Primary Button Text', 'mediakit-lite' ),
        'description'     => __( 'Leave empty to hide the primary button', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 30,
    ) );
    
    // Primary CTA URL
    $wp_customize->add_setting( 'mkp_featured_video_primary_cta_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_primary_cta_url', array(
        'label'           => __( 'Primary Button URL', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'url',
        'priority'        => 35,
    ) );
    
    // Secondary CTA Text
    $wp_customize->add_setting( 'mkp_featured_video_secondary_cta_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_secondary_cta_text', array(
        'label'           => __( 'Secondary Button Text', 'mediakit-lite' ),
        'description'     => __( 'Leave empty to hide the secondary button', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 45,
    ) );
    
    // Secondary CTA URL
    $wp_customize->add_setting( 'mkp_featured_video_secondary_cta_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_secondary_cta_url', array(
        'label'           => __( 'Secondary Button URL', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'url',
        'priority'        => 50,
    ) );
}