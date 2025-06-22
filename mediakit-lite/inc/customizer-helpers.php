<?php
/**
 * Customizer helper functions
 *
 * @package MediaKit_Lite
 */

/**
 * Add a customizer section with common defaults
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 * @param string               $section_id   Section ID
 * @param array                $args         Section arguments
 */
function mkp_add_customizer_section( $wp_customize, $section_id, $args ) {
    $defaults = array(
        'capability' => 'edit_theme_options',
        'priority'   => 10,
    );
    
    $args = wp_parse_args( $args, $defaults );
    $wp_customize->add_section( $section_id, $args );
}

/**
 * Add a color control to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 * @param string               $setting_id   Setting ID
 * @param array                $args         Control arguments
 */
function mkp_add_color_control( $wp_customize, $setting_id, $args ) {
    $defaults = array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    );
    
    $setting_args = wp_parse_args( 
        array(
            'default'           => $args['default'] ?? '',
            'type'              => $defaults['type'],
            'capability'        => $defaults['capability'],
            'transport'         => $args['transport'] ?? $defaults['transport'],
            'sanitize_callback' => $defaults['sanitize_callback'],
        ), 
        array() 
    );
    
    $wp_customize->add_setting( $setting_id, $setting_args );
    
    $control_args = array(
        'label'    => $args['label'] ?? '',
        'section'  => $args['section'] ?? '',
        'settings' => $setting_id,
        'priority' => $args['priority'] ?? 10,
    );
    
    if ( ! empty( $args['description'] ) ) {
        $control_args['description'] = $args['description'];
    }
    
    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            $setting_id, 
            $control_args 
        ) 
    );
}

/**
 * Add an image control to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 * @param string               $setting_id   Setting ID
 * @param array                $args         Control arguments
 */
function mkp_add_image_control( $wp_customize, $setting_id, $args ) {
    $defaults = array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'absint',
    );
    
    $setting_args = wp_parse_args( 
        array(
            'default'           => $args['default'] ?? '',
            'type'              => $defaults['type'],
            'capability'        => $defaults['capability'],
            'transport'         => $args['transport'] ?? $defaults['transport'],
            'sanitize_callback' => $defaults['sanitize_callback'],
        ), 
        array() 
    );
    
    $wp_customize->add_setting( $setting_id, $setting_args );
    
    $control_args = array(
        'label'    => $args['label'] ?? '',
        'section'  => $args['section'] ?? '',
        'settings' => $setting_id,
        'priority' => $args['priority'] ?? 10,
    );
    
    if ( ! empty( $args['description'] ) ) {
        $control_args['description'] = $args['description'];
    }
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( 
            $wp_customize, 
            $setting_id, 
            $control_args 
        ) 
    );
}

/**
 * Add a text control to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 * @param string               $setting_id   Setting ID
 * @param array                $args         Control arguments
 */
function mkp_add_text_control( $wp_customize, $setting_id, $args ) {
    $defaults = array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    );
    
    $setting_args = wp_parse_args( 
        array(
            'default'           => $args['default'] ?? '',
            'type'              => $defaults['type'],
            'capability'        => $defaults['capability'],
            'transport'         => $args['transport'] ?? $defaults['transport'],
            'sanitize_callback' => $args['sanitize_callback'] ?? $defaults['sanitize_callback'],
        ), 
        array() 
    );
    
    $wp_customize->add_setting( $setting_id, $setting_args );
    
    $control_args = array(
        'label'    => $args['label'] ?? '',
        'section'  => $args['section'] ?? '',
        'settings' => $setting_id,
        'type'     => $args['input_type'] ?? 'text',
        'priority' => $args['priority'] ?? 10,
    );
    
    if ( ! empty( $args['description'] ) ) {
        $control_args['description'] = $args['description'];
    }
    
    if ( ! empty( $args['input_attrs'] ) ) {
        $control_args['input_attrs'] = $args['input_attrs'];
    }
    
    $wp_customize->add_control( $setting_id, $control_args );
}

/**
 * Add a textarea control to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 * @param string               $setting_id   Setting ID
 * @param array                $args         Control arguments
 */
function mkp_add_textarea_control( $wp_customize, $setting_id, $args ) {
    $args['input_type'] = 'textarea';
    $args['sanitize_callback'] = $args['sanitize_callback'] ?? 'wp_kses_post';
    mkp_add_text_control( $wp_customize, $setting_id, $args );
}

/**
 * Add a checkbox control to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 * @param string               $setting_id   Setting ID
 * @param array                $args         Control arguments
 */
function mkp_add_checkbox_control( $wp_customize, $setting_id, $args ) {
    $defaults = array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    );
    
    $setting_args = wp_parse_args( 
        array(
            'default'           => $args['default'] ?? false,
            'type'              => $defaults['type'],
            'capability'        => $defaults['capability'],
            'transport'         => $args['transport'] ?? $defaults['transport'],
            'sanitize_callback' => $defaults['sanitize_callback'],
        ), 
        array() 
    );
    
    $wp_customize->add_setting( $setting_id, $setting_args );
    
    $control_args = array(
        'label'    => $args['label'] ?? '',
        'section'  => $args['section'] ?? '',
        'settings' => $setting_id,
        'type'     => 'checkbox',
        'priority' => $args['priority'] ?? 10,
    );
    
    if ( ! empty( $args['description'] ) ) {
        $control_args['description'] = $args['description'];
    }
    
    $wp_customize->add_control( $setting_id, $control_args );
}

/**
 * Add a select control to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object
 * @param string               $setting_id   Setting ID
 * @param array                $args         Control arguments
 */
function mkp_add_select_control( $wp_customize, $setting_id, $args ) {
    $defaults = array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'mkp_sanitize_select',
    );
    
    $setting_args = wp_parse_args( 
        array(
            'default'           => $args['default'] ?? '',
            'type'              => $defaults['type'],
            'capability'        => $defaults['capability'],
            'transport'         => $args['transport'] ?? $defaults['transport'],
            'sanitize_callback' => $defaults['sanitize_callback'],
        ), 
        array() 
    );
    
    $wp_customize->add_setting( $setting_id, $setting_args );
    
    $control_args = array(
        'label'    => $args['label'] ?? '',
        'section'  => $args['section'] ?? '',
        'settings' => $setting_id,
        'type'     => 'select',
        'choices'  => $args['choices'] ?? array(),
        'priority' => $args['priority'] ?? 10,
    );
    
    if ( ! empty( $args['description'] ) ) {
        $control_args['description'] = $args['description'];
    }
    
    $wp_customize->add_control( $setting_id, $control_args );
}

/**
 * Sanitize checkbox
 *
 * @param bool $checked Whether the checkbox is checked
 * @return bool
 */
function mkp_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitize select
 *
 * @param string $input   Input value
 * @param object $setting Setting object
 * @return string
 */
function mkp_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}