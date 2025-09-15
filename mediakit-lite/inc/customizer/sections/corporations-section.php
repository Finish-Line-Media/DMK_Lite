<?php
/**
 * Companies Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Corporations Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_corporations_section( $wp_customize ) {
    /**
     * Companies Section
     */
    $wp_customize->add_section( 'mkp_corporations_section', array(
        'title'       => __( 'Companies', 'mediakit-lite' ),
        'priority'    => 45,
        'description' => __( 'Companies or organizations you own or are affiliated with.', 'mediakit-lite' ),
    ) );
    
    // Enable Corporations Section
    $wp_customize->add_setting( 'mkp_enable_section_corporations', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_corporations', array(
        'label'       => __( 'Enable Companies Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the companies section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_corporations_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_corporations_section_title', array(
        'default'           => __( 'Companies', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_corporations_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_corporations_section',
        'type'            => 'text',
        'priority'        => 2,
    ) );
    
    // Text Alignment Setting
    $wp_customize->add_setting( 'mkp_corporations_text_align', array(
        'default'           => 'left',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_corporations_text_align', array(
        'label'       => __( 'Text Alignment', 'mediakit-lite' ),
        'description' => __( 'Choose how the description text should be aligned', 'mediakit-lite' ),
        'section'     => 'mkp_corporations_section',
        'type'        => 'select',
        'priority'    => 3,
        'choices'     => array(
            'left'    => __( 'Left Aligned', 'mediakit-lite' ),
            'justify' => __( 'Justified', 'mediakit-lite' ),
        ),
    ) );
    
    // Corporation entries
    for ( $i = 1; $i <= 6; $i++ ) {
        // Corporation Name
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_name', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_corp_' . $i . '_name', array(
            'label'       => sprintf( __( 'Company %d Name', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'type'        => 'text',
            'priority'    => 10 + ($i * 10),
        ) );
        
        // Corporation Logo
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_corp_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Company %d Logo', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'priority'    => 11 + ($i * 10),
        ) ) );
        
        // Corporation Bio
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_bio', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_corp_' . $i . '_bio', array(
            'label'       => sprintf( __( 'Company %d Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'type'        => 'textarea',
            'priority'    => 12 + ($i * 10),
        ) );
        
        // Corporation Link
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_corp_' . $i . '_link', array(
            'label'       => sprintf( __( 'Company %d Website', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'type'        => 'url',
            'priority'    => 13 + ($i * 10),
        ) );
    }
}