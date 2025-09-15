<?php
/**
 * Hero Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Hero Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_hero_section( $wp_customize ) {
    /**
     * Hero Section
     */
    $wp_customize->add_section( 'mkp_hero_section', array(
        'title'       => __( 'Hero', 'mediakit-lite' ),
        'priority'    => 35,
        'description' => __( 'Configure your hero section with professional images, name, and titles.', 'mediakit-lite' ),
    ) );
    
    // Hero Images (1-2)
    for ( $i = 1; $i <= 2; $i++ ) {
        $wp_customize->add_setting( 'mkp_hero_image_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_hero_image_' . $i, array(
            'label'       => sprintf( __( 'Hero Image %d', 'mediakit-lite' ), $i ),
            'description' => $i === 1 ? __( 'Professional photos to display alongside your name. Square images work best.', 'mediakit-lite' ) : '',
            'section'     => 'mkp_hero_section',
            'priority'    => 2 + $i,
        ) ) );
        
        // Image Position
        $wp_customize->add_setting( 'mkp_hero_image_' . $i . '_position', array(
            'default'           => 'left',
            'sanitize_callback' => 'mkp_sanitize_position_choice',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( 'mkp_hero_image_' . $i . '_position', array(
            'label'       => sprintf( __( 'Image %d Position', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_hero_section',
            'type'        => 'radio',
            'choices'     => array(
                'left'  => __( 'Left', 'mediakit-lite' ),
                'right' => __( 'Right', 'mediakit-lite' ),
            ),
            'priority'    => 6 + $i,
        ) );
        
        // Image Size
        $wp_customize->add_setting( 'mkp_hero_image_' . $i . '_size', array(
            'default'           => 'medium',
            'sanitize_callback' => 'mkp_sanitize_select',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( 'mkp_hero_image_' . $i . '_size', array(
            'label'       => sprintf( __( 'Image %d Size', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_hero_section',
            'type'        => 'select',
            'choices'     => array(
                'small'  => __( 'Small', 'mediakit-lite' ),
                'medium' => __( 'Medium', 'mediakit-lite' ),
                'large'  => __( 'Large', 'mediakit-lite' ),
            ),
            'priority'    => 8 + $i,
        ) );
    }
    
    // Hero Name
    $wp_customize->add_setting( 'mkp_hero_name', array(
        'default'           => get_bloginfo( 'name' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_name', array(
        'label'       => __( 'Your Name', 'mediakit-lite' ),
        'description' => __( 'Your professional name as you want it displayed.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'text',
        'priority'    => 20,
    ) );
    
    // Hero Name Image
    $wp_customize->add_setting( 'mkp_hero_name_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_hero_name_image', array(
        'label'       => __( 'Name Logo/Image (Optional)', 'mediakit-lite' ),
        'description' => __( 'Upload an image to display instead of the text name. This could be a stylized logo or signature.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'priority'    => 21,
    ) ) );
    
    // Professional Tags (1-7)
    for ( $i = 1; $i <= 7; $i++ ) {
        $wp_customize->add_setting( 'mkp_hero_tag_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_hero_tag_' . $i, array(
            'label'       => sprintf( __( 'Professional Tag %d', 'mediakit-lite' ), $i ),
            'description' => $i === 1 ? __( 'Your professional titles (e.g., Author, Speaker, Consultant)', 'mediakit-lite' ) : '',
            'section'     => 'mkp_hero_section',
            'type'        => 'text',
            'priority'    => 20 + $i,
        ) );
    }
}