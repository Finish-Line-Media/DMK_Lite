<?php
/**
 * Speaker Topics Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Speaker Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_speaker_section( $wp_customize ) {
    /**
     * Speaker Topics Section
     */
    $wp_customize->add_section( 'mkp_speaker_section', array(
        'title'       => __( 'Speaker Topics', 'mediakit-lite' ),
        'priority'    => 50,
        'description' => __( 'Topics you speak about professionally.', 'mediakit-lite' ),
    ) );
    
    // Enable Speaker Topics Section
    $wp_customize->add_setting( 'mkp_enable_section_speaker_topics', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_speaker_topics', array(
        'label'       => __( 'Enable Speaker Topics Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the speaker topics section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_speaker_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_speaker_section_title', array(
        'default'           => __( 'Speaking Topics', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_speaker_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_speaker_section',
        'type'            => 'text',
        'priority'        => 2,
    ) );
    
    // Text Alignment Setting
    $wp_customize->add_setting( 'mkp_speaker_text_align', array(
        'default'           => 'left',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_speaker_text_align', array(
        'label'       => __( 'Text Alignment', 'mediakit-lite' ),
        'description' => __( 'Choose how topic descriptions should be aligned', 'mediakit-lite' ),
        'section'     => 'mkp_speaker_section',
        'type'        => 'select',
        'priority'    => 3,
        'choices'     => array(
            'left'    => __( 'Left Aligned', 'mediakit-lite' ),
            'justify' => __( 'Justified', 'mediakit-lite' ),
        ),
    ) );
    
    // Speaker Topics Background Color
    // List Style
    $wp_customize->add_setting( 'mkp_speaker_topics_list_style', array(
        'default'           => 'bullets',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_speaker_topics_list_style', array(
        'label'       => __( 'List Style', 'mediakit-lite' ),
        'description' => __( 'Choose how to display your speaking topics', 'mediakit-lite' ),
        'section'     => 'mkp_speaker_section',
        'type'        => 'select',
        'choices'     => array(
            'bullets' => __( 'Bullet Points', 'mediakit-lite' ),
            'numbers' => __( 'Numbered List', 'mediakit-lite' ),
            'cards'   => __( 'Card Style', 'mediakit-lite' ),
        ),
        'priority'    => 3,
    ) );
    
    // Speaker topics (up to 6)
    for ( $i = 1; $i <= 6; $i++ ) {
        $wp_customize->add_setting( 'mkp_speaker_topic_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_speaker_topic_' . $i, array(
            'label'       => sprintf( __( 'Speaking Topic %d', 'mediakit-lite' ), $i ),
            'description' => $i === 1 ? __( 'Enter a topic you speak about professionally', 'mediakit-lite' ) : '',
            'section'     => 'mkp_speaker_section',
            'type'        => 'text',
            'priority'    => 10 + $i,
        ) );
    }
}