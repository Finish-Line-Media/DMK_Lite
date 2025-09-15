<?php
/**
 * Investor Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Investor Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_investor_section( $wp_customize ) {
    /**
     * Investor Section
     */
    $wp_customize->add_section( 'mkp_investor_section', array(
        'title'       => __( 'Investor', 'mediakit-lite' ),
        'priority'    => 57,
        'description' => __( 'Showcase investment opportunities or investor relations information.', 'mediakit-lite' ),
    ) );
    
    // Enable Investor Section
    $wp_customize->add_setting( 'mkp_enable_section_investor', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_investor', array(
        'label'       => __( 'Enable Investor Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the investor section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_investor_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_investor_section_title', array(
        'default'           => __( 'Investor', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_investor_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_investor_section',
        'type'            => 'text',
        'priority'        => 2,
    ) );
    
    // Investor options (up to 5)
    for ( $i = 1; $i <= 5; $i++ ) {
        // Title
        $wp_customize->add_setting( 'mkp_investor_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_investor_' . $i . '_title', array(
            'label'       => sprintf( __( 'Investor Option %d Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_investor_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ),
        ) );
        
        // Description
        $wp_customize->add_setting( 'mkp_investor_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_investor_' . $i . '_description', array(
            'label'       => sprintf( __( 'Investor Option %d Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_investor_section',
            'type'        => 'textarea',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
    }
}