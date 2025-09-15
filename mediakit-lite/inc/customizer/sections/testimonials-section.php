<?php
/**
 * Testimonials Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Testimonials Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_testimonials_section( $wp_customize ) {
    /**
     * Testimonials Section
     */
    $wp_customize->add_section( 'mkp_testimonials_section', array(
        'title'       => __( 'Testimonials', 'mediakit-lite' ),
        'priority'    => 52,
        'description' => __( 'Display client testimonials and reviews.', 'mediakit-lite' ),
    ) );
    
    // Enable Testimonials Section
    $wp_customize->add_setting( 'mkp_enable_section_testimonials', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_testimonials', array(
        'label'       => __( 'Enable Testimonials Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the testimonials section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_testimonials_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_testimonials_section_title', array(
        'default'           => __( 'Testimonials', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_testimonials_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_testimonials_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Text Alignment Setting
    $wp_customize->add_setting( 'mkp_testimonials_text_align', array(
        'default'           => 'left',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_testimonials_text_align', array(
        'label'       => __( 'Text Alignment', 'mediakit-lite' ),
        'description' => __( 'Choose how testimonial text should be aligned', 'mediakit-lite' ),
        'section'     => 'mkp_testimonials_section',
        'type'        => 'select',
        'priority'    => 6,
        'choices'     => array(
            'left'    => __( 'Left Aligned', 'mediakit-lite' ),
            'justify' => __( 'Justified', 'mediakit-lite' ),
        ),
    ) );
    
    // Testimonials (up to 6)
    for ( $i = 1; $i <= 6; $i++ ) {
        // Quote
        $wp_customize->add_setting( 'mkp_testimonial_' . $i . '_quote', array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_testimonial_' . $i . '_quote', array(
            'label'       => sprintf( __( 'Testimonial %d Quote', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_testimonials_section',
            'type'        => 'textarea',
            'priority'    => 10 + ( $i * 10 ),
        ) );
        
        // Author
        $wp_customize->add_setting( 'mkp_testimonial_' . $i . '_author', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_testimonial_' . $i . '_author', array(
            'label'       => sprintf( __( 'Author Name', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_testimonials_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
        
        // Title
        $wp_customize->add_setting( 'mkp_testimonial_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_testimonial_' . $i . '_title', array(
            'label'       => sprintf( __( 'Author Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_testimonials_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 2,
        ) );
        
        // Organization
        $wp_customize->add_setting( 'mkp_testimonial_' . $i . '_organization', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_testimonial_' . $i . '_organization', array(
            'label'       => sprintf( __( 'Organization', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_testimonials_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 3,
        ) );
        
        // Photo
        $wp_customize->add_setting( 'mkp_testimonial_' . $i . '_photo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_testimonial_' . $i . '_photo', array(
            'label'       => sprintf( __( 'Author Photo', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_testimonials_section',
            'priority'    => 10 + ( $i * 10 ) + 4,
        ) ) );
        
        // Rating
        $wp_customize->add_setting( 'mkp_testimonial_' . $i . '_rating', array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_testimonial_' . $i . '_rating', array(
            'label'       => sprintf( __( 'Star Rating', 'mediakit-lite' ), $i ),
            'description' => __( '0-5 stars (0 = no rating)', 'mediakit-lite' ),
            'section'     => 'mkp_testimonials_section',
            'type'        => 'number',
            'input_attrs' => array(
                'min' => 0,
                'max' => 5,
                'step' => 1,
            ),
            'priority'    => 10 + ( $i * 10 ) + 5,
        ) );
    }
}