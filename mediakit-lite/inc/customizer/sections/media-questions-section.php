<?php
/**
 * Questions for Media Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Media Questions Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_media_questions_section( $wp_customize ) {
    /**
     * Questions for Media Section
     */
    $wp_customize->add_section( 'mkp_media_questions_section', array(
        'title'       => __( 'Questions for the Media', 'mediakit-lite' ),
        'priority'    => 56,
        'description' => __( 'Suggested questions for media interviews.', 'mediakit-lite' ),
    ) );
    
    // Enable Media Questions Section
    $wp_customize->add_setting( 'mkp_enable_section_media_questions', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_media_questions', array(
        'label'       => __( 'Enable Questions for Media Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the media questions section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_media_questions_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_media_questions_section_title', array(
        'default'           => __( 'Questions for the Media', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_media_questions_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_media_questions_section',
        'type'            => 'text',
        'priority'        => 2,
    ) );
    
    // Text Alignment Setting
    $wp_customize->add_setting( 'mkp_media_questions_text_align', array(
        'default'           => 'left',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_media_questions_text_align', array(
        'label'       => __( 'Text Alignment', 'mediakit-lite' ),
        'description' => __( 'Choose how questions should be aligned', 'mediakit-lite' ),
        'section'     => 'mkp_media_questions_section',
        'type'        => 'select',
        'priority'    => 3,
        'choices'     => array(
            'left'    => __( 'Left Aligned', 'mediakit-lite' ),
            'justify' => __( 'Justified', 'mediakit-lite' ),
        ),
    ) );
    
    // Media Questions Background Color
    // List Style
    $wp_customize->add_setting( 'mkp_media_questions_list_style', array(
        'default'           => 'bullets',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_media_questions_list_style', array(
        'label'       => __( 'List Style', 'mediakit-lite' ),
        'description' => __( 'Choose how to display the questions', 'mediakit-lite' ),
        'section'     => 'mkp_media_questions_section',
        'type'        => 'select',
        'choices'     => array(
            'bullets' => __( 'Bullet Points', 'mediakit-lite' ),
            'numbers' => __( 'Numbered List', 'mediakit-lite' ),
            'cards'   => __( 'Card Style', 'mediakit-lite' ),
        ),
        'priority'    => 5,
    ) );
    
    // Media questions (up to 14)
    for ( $i = 1; $i <= 14; $i++ ) {
        $wp_customize->add_setting( 'mkp_media_question_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_question_' . $i, array(
            'label'       => sprintf( __( 'Question %d', 'mediakit-lite' ), $i ),
            'description' => $i === 1 ? __( 'Enter a question for media interviews', 'mediakit-lite' ) : '',
            'section'     => 'mkp_media_questions_section',
            'type'        => 'text',
            'priority'    => 10 + $i,
        ) );
    }
}