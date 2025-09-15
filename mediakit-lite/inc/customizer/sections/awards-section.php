<?php
/**
 * Awards & Recognition Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Awards Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_awards_section( $wp_customize ) {
    /**
     * Awards & Recognition Section
     */
    $wp_customize->add_section( 'mkp_awards_section', array(
        'title'       => __( 'Awards & Recognition', 'mediakit-lite' ),
        'priority'    => 53,
        'description' => __( 'Showcase awards, certifications, and achievements.', 'mediakit-lite' ),
    ) );
    
    // Enable Awards Section
    $wp_customize->add_setting( 'mkp_enable_section_awards', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_awards', array(
        'label'       => __( 'Enable Awards Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the awards section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_awards_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_awards_section_title', array(
        'default'           => __( 'Awards & Recognition', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_awards_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_awards_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Awards (up to 8)
    for ( $i = 1; $i <= 8; $i++ ) {
        // Logo
        $wp_customize->add_setting( 'mkp_award_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_award_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Award %d Logo/Badge', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'priority'    => 10 + ( $i * 10 ),
        ) ) );
        
        // Title
        $wp_customize->add_setting( 'mkp_award_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_award_' . $i . '_title', array(
            'label'       => sprintf( __( 'Award Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
        
        // Year
        $wp_customize->add_setting( 'mkp_award_' . $i . '_year', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_award_' . $i . '_year', array(
            'label'       => sprintf( __( 'Year', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 2,
        ) );
        
        // Description
        $wp_customize->add_setting( 'mkp_award_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_award_' . $i . '_description', array(
            'label'       => sprintf( __( 'Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'type'        => 'textarea',
            'priority'    => 10 + ( $i * 10 ) + 3,
        ) );
    }
}