<?php
/**
 * Blog Settings Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Blog Settings customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_blog_settings( $wp_customize ) {
    // ====================
    // Blog Section 
    // ====================
    $wp_customize->add_section( 'mkp_blog_settings', array(
        'title'       => __( 'Blog', 'mediakit-lite' ),
        'priority'    => 59,
        'description' => __( 'Configure blog appearance. To set up a blog, go to Settings → Reading and configure a static page with a posts page.', 'mediakit-lite' ),
    ) );
    
    // Show Blog in Navigation
    $wp_customize->add_setting( 'mkp_show_blog_in_nav', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_show_blog_in_nav', array(
        'label'       => __( 'Show Blog in Navigation', 'mediakit-lite' ),
        'description' => __( 'Display the blog link in the navigation menu when a posts page is configured.', 'mediakit-lite' ),
        'section'     => 'mkp_blog_settings',
        'type'        => 'checkbox',
        'priority'    => 10,
    ) );
    
    // Blog Page Title
    $wp_customize->add_setting( 'mkp_blog_title', array(
        'default'           => __( 'Blog', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_blog_title', array(
        'label'       => __( 'Blog Page Title', 'mediakit-lite' ),
        'description' => __( 'Title shown on the blog archive page.', 'mediakit-lite' ),
        'section'     => 'mkp_blog_settings',
        'type'        => 'text',
        'priority'    => 20,
    ) );
    
    // Blog Page Subtitle
    $wp_customize->add_setting( 'mkp_blog_subtitle', array(
        'default'           => __( 'Thoughts, insights, and updates', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_blog_subtitle', array(
        'label'       => __( 'Blog Page Subtitle', 'mediakit-lite' ),
        'description' => __( 'Subtitle shown on the blog archive page.', 'mediakit-lite' ),
        'section'     => 'mkp_blog_settings',
        'type'        => 'text',
        'priority'    => 30,
    ) );
    
    // Enable Sidebar
    $wp_customize->add_setting( 'mkp_enable_blog_sidebar', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_blog_sidebar', array(
        'label'       => __( 'Enable Sidebar', 'mediakit-lite' ),
        'description' => __( 'Display a sidebar on blog pages. Configure widgets in Appearance → Widgets or in the Widgets panel of this Customizer.', 'mediakit-lite' ),
        'section'     => 'mkp_blog_settings',
        'type'        => 'checkbox',
        'priority'    => 40,
    ) );
    
    // Show Sidebar on Posts
    $wp_customize->add_setting( 'mkp_sidebar_show_posts', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_sidebar_show_posts', array(
        'label'       => __( 'Show on Posts', 'mediakit-lite' ),
        'description' => '',
        'section'     => 'mkp_blog_settings',
        'type'        => 'checkbox',
        'priority'    => 41,
    ) );
    
    // Show Sidebar on Blog
    $wp_customize->add_setting( 'mkp_sidebar_show_blog', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_sidebar_show_blog', array(
        'label'       => __( 'Show on Blog', 'mediakit-lite' ),
        'description' => '',
        'section'     => 'mkp_blog_settings',
        'type'        => 'checkbox',
        'priority'    => 42,
    ) );
    
    // Show Sidebar on Archive
    $wp_customize->add_setting( 'mkp_sidebar_show_archive', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_sidebar_show_archive', array(
        'label'       => __( 'Show on Archive', 'mediakit-lite' ),
        'description' => '',
        'section'     => 'mkp_blog_settings',
        'type'        => 'checkbox',
        'priority'    => 43,
    ) );
}