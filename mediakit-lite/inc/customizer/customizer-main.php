<?php
/**
 * MediaKit Lite Theme Customizer - Main File
 *
 * @package MediaKit_Lite
 */

// Include helper files
require_once get_template_directory() . '/inc/customizer/helpers/sanitization.php';

// Include custom controls
require_once get_template_directory() . '/inc/customizer-controls/class-gallery-control.php';

// Include section files
require_once get_template_directory() . '/inc/customizer/sections/navigation-brand.php';
require_once get_template_directory() . '/inc/customizer/sections/hero-section.php';
require_once get_template_directory() . '/inc/customizer/sections/about-section.php';
require_once get_template_directory() . '/inc/customizer/sections/books-section.php';
require_once get_template_directory() . '/inc/customizer/sections/podcasts-section.php';
require_once get_template_directory() . '/inc/customizer/sections/gallery-section.php';
require_once get_template_directory() . '/inc/customizer/sections/corporations-section.php';
require_once get_template_directory() . '/inc/customizer/sections/speaker-section.php';
require_once get_template_directory() . '/inc/customizer/sections/featured-video-section.php';
require_once get_template_directory() . '/inc/customizer/sections/testimonials-section.php';
require_once get_template_directory() . '/inc/customizer/sections/awards-section.php';
require_once get_template_directory() . '/inc/customizer/sections/media-features-section.php';
require_once get_template_directory() . '/inc/customizer/sections/stats-section.php';
require_once get_template_directory() . '/inc/customizer/sections/in-the-media-section.php';
require_once get_template_directory() . '/inc/customizer/sections/media-questions-section.php';
require_once get_template_directory() . '/inc/customizer/sections/investor-section.php';
require_once get_template_directory() . '/inc/customizer/sections/contact-section.php';
require_once get_template_directory() . '/inc/customizer/sections/blog-settings.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function mkp_customize_register( $wp_customize ) {
    // Add null checks before accessing settings
    if ( $blogname_setting = $wp_customize->get_setting( 'blogname' ) ) {
        $blogname_setting->transport = 'postMessage';
    }
    if ( $blogdescription_setting = $wp_customize->get_setting( 'blogdescription' ) ) {
        $blogdescription_setting->transport = 'postMessage';
    }
    
    // Remove default WordPress sections
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );
    $wp_customize->remove_section( 'header_image' );
    $wp_customize->remove_section( 'static_front_page' );
    $wp_customize->remove_section( 'custom_css' );
    
    // Remove site title and tagline controls
    $wp_customize->remove_control( 'blogname' );
    $wp_customize->remove_control( 'blogdescription' );
    $wp_customize->remove_control( 'display_header_text' );
    
    // Rename Site Identity section to Navigation & Brand
    if ( $wp_customize->get_section( 'title_tagline' ) ) {
        $wp_customize->get_section( 'title_tagline' )->title = __( 'Navigation & Brand', 'mediakit-lite' );
        $wp_customize->get_section( 'title_tagline' )->priority = 25;
        $wp_customize->get_section( 'title_tagline' )->description = __( 'Configure your site branding, typography, and navigation.', 'mediakit-lite' );
    }
    
    // Move site icon control to Navigation & Brand
    if ( $wp_customize->get_control( 'site_icon' ) ) {
        $wp_customize->get_control( 'site_icon' )->section = 'title_tagline';
        $wp_customize->get_control( 'site_icon' )->priority = 10;
        $wp_customize->get_control( 'site_icon' )->description = __( 'The Site Icon is used as a browser and app icon for your site. Icons must be square, and at least 512 × 512 pixels.', 'mediakit-lite' );
    }
    
    // Register all sections
    mkp_register_navigation_brand_section( $wp_customize );
    mkp_register_hero_section( $wp_customize );
    mkp_register_about_section( $wp_customize );
    mkp_register_books_section( $wp_customize );
    mkp_register_podcasts_section( $wp_customize );
    mkp_register_gallery_section( $wp_customize );
    mkp_register_corporations_section( $wp_customize );
    mkp_register_speaker_section( $wp_customize );
    mkp_register_featured_video_section( $wp_customize );
    mkp_register_testimonials_section( $wp_customize );
    mkp_register_awards_section( $wp_customize );
    mkp_register_media_features_section( $wp_customize );
    mkp_register_stats_section( $wp_customize );
    mkp_register_in_the_media_section( $wp_customize );
    mkp_register_media_questions_section( $wp_customize );
    mkp_register_investor_section( $wp_customize );
    mkp_register_contact_section( $wp_customize );
    mkp_register_blog_settings( $wp_customize );
}
add_action( 'customize_register', 'mkp_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mkp_customize_preview_js() {
    wp_enqueue_script( 'mediakit-lite-customizer', get_template_directory_uri() . '/assets/js/customizer-live-preview.js', array( 'customize-preview' ), MKP_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'mkp_customize_preview_js' );

/**
 * Enqueue customizer control scripts
 */
function mkp_customize_controls_enqueue_scripts() {
    wp_enqueue_script( 'mediakit-lite-customize-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array( 'jquery', 'customize-controls' ), MKP_THEME_VERSION, true );
    // CSS file doesn't exist - commented out to prevent 404
    // wp_enqueue_style( 'mediakit-lite-customize-controls', get_template_directory_uri() . '/assets/css/customizer-controls.css', array(), MKP_THEME_VERSION );
}
add_action( 'customize_controls_enqueue_scripts', 'mkp_customize_controls_enqueue_scripts' );