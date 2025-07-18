<?php
/**
 * Contact Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Contact Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_contact_section( $wp_customize ) {
    // ====================
    // Contact Section 
    // ====================
    $wp_customize->add_section( 'mkp_contact_section', array(
        'title'       => __( 'Contact', 'mediakit-lite' ),
        'priority'    => 58,
        'description' => __( 'Add contact information including email addresses, physical address, and social media links.', 'mediakit-lite' ),
    ) );
    
    // Enable/Disable Contact Section
    $wp_customize->add_setting( 'mkp_enable_section_contact', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_contact', array(
        'label'       => __( 'Enable Contact Section', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_contact_section_title', array(
        'default'           => __( 'Contact', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_contact_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Email Addresses
    // General Inquiries Email
    $wp_customize->add_setting( 'mkp_contact_general_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_general_email', array(
        'label'       => __( 'General Inquiries Email', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'email',
        'priority'    => 10,
    ) );
    
    // Media/Press Email
    $wp_customize->add_setting( 'mkp_contact_media_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_media_email', array(
        'label'       => __( 'Media/Press Email', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'email',
        'priority'    => 11,
    ) );
    
    // Public Speaking Email
    $wp_customize->add_setting( 'mkp_contact_speaking_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_speaking_email', array(
        'label'       => __( 'Public Speaking Email', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'email',
        'priority'    => 12,
    ) );
    
    // Physical Address
    $wp_customize->add_setting( 'mkp_contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_address', array(
        'label'       => __( 'Physical Address', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'textarea',
        'priority'    => 20,
    ) );
    
    // Social Media Links
    $social_platforms = array(
        'x'         => __( 'X (Twitter)', 'mediakit-lite' ),
        'facebook'  => __( 'Facebook', 'mediakit-lite' ),
        'instagram' => __( 'Instagram', 'mediakit-lite' ),
        'linkedin'  => __( 'LinkedIn', 'mediakit-lite' ),
        'youtube'   => __( 'YouTube', 'mediakit-lite' ),
        'github'    => __( 'GitHub', 'mediakit-lite' ),
        'threads'   => __( 'Threads', 'mediakit-lite' ),
    );
    
    $priority = 30;
    foreach ( $social_platforms as $platform => $label ) {
        $wp_customize->add_setting( 'mkp_contact_social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_contact_social_' . $platform, array(
            'label'       => $label,
            'section'     => 'mkp_contact_section',
            'type'        => 'url',
            'priority'    => $priority++,
        ) );
    }
}