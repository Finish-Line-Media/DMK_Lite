<?php
/**
 * About Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register About Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_about_section( $wp_customize ) {
    /**
     * About Section
     */
    $wp_customize->add_section( 'mkp_about_section', array(
        'title'       => __( 'About', 'mediakit-lite' ),
        'priority'    => 40,
        'description' => __( 'Your professional about information and background.', 'mediakit-lite' ),
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_about_section_title', array(
        'default'           => __( 'About', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_about_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_about_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // About Content
    $wp_customize->add_setting( 'mkp_about_content', array(
        'default'           => mkp_get_default_about_content(),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_about_content', array(
        'label'       => __( 'About Content', 'mediakit-lite' ),
        'description' => __( 'Your professional about information. HTML allowed.', 'mediakit-lite' ),
        'section'     => 'mkp_about_section',
        'type'        => 'textarea',
        'priority'    => 10,
        'input_attrs' => array(
            'rows' => 10,
        ),
    ) );
    
    // Text Alignment Setting
    $wp_customize->add_setting( 'mkp_about_text_align', array(
        'default'           => 'left',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_about_text_align', array(
        'label'       => __( 'Text Alignment', 'mediakit-lite' ),
        'description' => __( 'Choose how the text should be aligned', 'mediakit-lite' ),
        'section'     => 'mkp_about_section',
        'type'        => 'select',
        'priority'    => 7,
        'choices'     => array(
            'left'    => __( 'Left Aligned', 'mediakit-lite' ),
            'justify' => __( 'Justified', 'mediakit-lite' ),
        ),
    ) );
}