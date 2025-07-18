<?php
/**
 * Image Gallery Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Gallery Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_gallery_section( $wp_customize ) {
    /**
     * Image Gallery Section
     */
    $wp_customize->add_section( 'mkp_gallery_section', array(
        'title'       => __( 'Image Gallery', 'mediakit-lite' ),
        'priority'    => 49,
        'description' => __( 'Display a gallery of images on your media kit.', 'mediakit-lite' ),
    ) );
    
    // Enable Gallery Section
    $wp_customize->add_setting( 'mkp_enable_section_gallery', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_gallery', array(
        'label'       => __( 'Enable Image Gallery', 'mediakit-lite' ),
        'description' => __( 'Show or hide the image gallery section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_gallery_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_gallery_section_title', array(
        'default'           => __( 'Image Gallery', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_gallery_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_gallery_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Gallery Images
    $wp_customize->add_setting( 'mkp_gallery_images', array(
        'default'           => '',
        'sanitize_callback' => 'mkp_sanitize_gallery_images',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( new MKP_Gallery_Control( $wp_customize, 'mkp_gallery_images', array(
        'label'       => __( 'Gallery Images', 'mediakit-lite' ),
        'description' => __( 'Select up to 50 images for your gallery. Images will use their WordPress Media Library caption and alt text. Edit images in the Media Library to update these.', 'mediakit-lite' ),
        'section'     => 'mkp_gallery_section',
        'priority'    => 10,
    ) ) );
}