<?php
/**
 * Stats & Achievements Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Stats Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_stats_section( $wp_customize ) {
    /**
     * Stats & Achievements Section
     */
    $wp_customize->add_section( 'mkp_stats_section', array(
        'title'       => __( 'Stats & Achievements', 'mediakit-lite' ),
        'priority'    => 55,
        'description' => __( 'Display key metrics and achievements.', 'mediakit-lite' ),
    ) );
    
    // Enable Stats Section
    $wp_customize->add_setting( 'mkp_enable_section_stats', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_stats', array(
        'label'       => __( 'Enable Stats Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the stats section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_stats_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_stats_section_title', array(
        'default'           => __( 'By The Numbers', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_stats_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_stats_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Stats (up to 6)
    for ( $i = 1; $i <= 6; $i++ ) {
        // Number
        $wp_customize->add_setting( 'mkp_stat_' . $i . '_number', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_stat_' . $i . '_number', array(
            'label'       => sprintf( __( 'Stat %d Number', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_stats_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ),
        ) );
        
        // Label
        $wp_customize->add_setting( 'mkp_stat_' . $i . '_label', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_stat_' . $i . '_label', array(
            'label'       => sprintf( __( 'Label', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_stats_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
        
        // Prefix
        $wp_customize->add_setting( 'mkp_stat_' . $i . '_prefix', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_stat_' . $i . '_prefix', array(
            'label'       => sprintf( __( 'Prefix', 'mediakit-lite' ), $i ),
            'description' => __( 'e.g., $, €', 'mediakit-lite' ),
            'section'     => 'mkp_stats_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 2,
        ) );
        
        // Suffix
        $wp_customize->add_setting( 'mkp_stat_' . $i . '_suffix', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_stat_' . $i . '_suffix', array(
            'label'       => sprintf( __( 'Suffix', 'mediakit-lite' ), $i ),
            'description' => __( 'e.g., +, K, M', 'mediakit-lite' ),
            'section'     => 'mkp_stats_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 3,
        ) );
        
        // Icon
        $wp_customize->add_setting( 'mkp_stat_' . $i . '_icon', array(
            'default'           => 'star',
            'sanitize_callback' => 'mkp_sanitize_select',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_stat_' . $i . '_icon', array(
            'label'       => sprintf( __( 'Icon', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_stats_section',
            'type'        => 'select',
            'choices'     => array(
                'users'      => __( 'Users/People', 'mediakit-lite' ),
                'star'       => __( 'Star', 'mediakit-lite' ),
                'award'      => __( 'Award', 'mediakit-lite' ),
                'chart'      => __( 'Chart/Growth', 'mediakit-lite' ),
                'calendar'   => __( 'Calendar', 'mediakit-lite' ),
                'location'   => __( 'Location/Map', 'mediakit-lite' ),
                'microphone' => __( 'Microphone', 'mediakit-lite' ),
                'book'       => __( 'Book', 'mediakit-lite' ),
                'video'      => __( 'Video', 'mediakit-lite' ),
                'portfolio'  => __( 'Portfolio', 'mediakit-lite' ),
                'megaphone'  => __( 'Megaphone', 'mediakit-lite' ),
                'analytics'  => __( 'Analytics', 'mediakit-lite' ),
            ),
            'priority'    => 10 + ( $i * 10 ) + 4,
        ) );
    }
}