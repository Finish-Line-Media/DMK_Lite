<?php
/**
 * Fun Facts Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Fun Facts Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_fun_facts_section( $wp_customize ) {
	/**
	 * Fun Facts Section
	 */
	$wp_customize->add_section( 'mkp_fun_facts_section', array(
		'title'       => __( 'Fun Facts', 'mediakit-lite' ),
		'priority'    => 55,
		'description' => __( 'Share fun facts about yourself with photos.', 'mediakit-lite' ),
	) );

	// Enable Fun Facts Section
	$wp_customize->add_setting( 'mkp_enable_section_fun_facts', array(
		'default'           => false,
		'sanitize_callback' => 'mkp_sanitize_checkbox',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'mkp_enable_section_fun_facts', array(
		'label'       => __( 'Enable Fun Facts Section', 'mediakit-lite' ),
		'description' => __( 'Show or hide the fun facts section on your landing page.', 'mediakit-lite' ),
		'section'     => 'mkp_fun_facts_section',
		'type'        => 'checkbox',
		'priority'    => 1,
	) );

	// Section Title
	$wp_customize->add_setting( 'mkp_fun_facts_section_title', array(
		'default'           => __( 'Fun Facts', 'mediakit-lite' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'mkp_fun_facts_section_title', array(
		'label'    => __( 'Section Title', 'mediakit-lite' ),
		'section'  => 'mkp_fun_facts_section',
		'type'     => 'text',
		'priority' => 2,
	) );

	// Fun Facts (up to 6)
	for ( $i = 1; $i <= 6; $i++ ) {
		// Separator heading
		$wp_customize->add_setting( 'mkp_fun_fact_' . $i . '_heading', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mkp_fun_fact_' . $i . '_heading', array(
			'label'       => sprintf( __( '--- Fun Fact %d ---', 'mediakit-lite' ), $i ),
			'section'     => 'mkp_fun_facts_section',
			'type'        => 'hidden',
			'priority'    => 10 + ( $i * 10 ),
		) ) );

		// Title
		$wp_customize->add_setting( 'mkp_fun_fact_' . $i . '_title', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'mkp_fun_fact_' . $i . '_title', array(
			'label'    => sprintf( __( 'Fun Fact %d Title', 'mediakit-lite' ), $i ),
			'section'  => 'mkp_fun_facts_section',
			'type'     => 'text',
			'priority' => 11 + ( $i * 10 ),
		) );

		// Image
		$wp_customize->add_setting( 'mkp_fun_fact_' . $i . '_image', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_fun_fact_' . $i . '_image', array(
			'label'    => sprintf( __( 'Fun Fact %d Image', 'mediakit-lite' ), $i ),
			'section'  => 'mkp_fun_facts_section',
			'priority' => 12 + ( $i * 10 ),
		) ) );

		// Description
		$wp_customize->add_setting( 'mkp_fun_fact_' . $i . '_description', array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'mkp_fun_fact_' . $i . '_description', array(
			'label'    => sprintf( __( 'Fun Fact %d Description', 'mediakit-lite' ), $i ),
			'section'  => 'mkp_fun_facts_section',
			'type'     => 'textarea',
			'priority' => 13 + ( $i * 10 ),
		) );
	}
}
