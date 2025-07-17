<?php
/**
 * MediaKit Lite Theme Customizer - Cleaned Version
 *
 * @package MediaKit_Lite
 */

// Include custom controls
require_once get_template_directory() . '/inc/customizer-controls/class-gallery-control.php';

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
    // Remove header_textcolor as it's not used in this theme
    
    // Remove default WordPress sections
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );
    $wp_customize->remove_section( 'header_image' );
    // Nav menus panel removal is handled in customizer-components.php
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
    
    // Remove custom logo control
    $wp_customize->remove_control( 'custom_logo' );
    
    // Navigation Font
    $wp_customize->add_setting( 'mkp_nav_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_nav_font', array(
        'label'       => __( 'Navigation Font', 'mediakit-lite' ),
        'description' => __( 'Font for navigation menu items.', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'select',
        'priority'    => 50,
        'choices'     => array(
            'system'    => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'inter'     => __( 'Inter (Modern & Clean)', 'mediakit-lite' ),
            'roboto'    => __( 'Roboto (Google Style)', 'mediakit-lite' ),
            'opensans'  => __( 'Open Sans (Friendly)', 'mediakit-lite' ),
            'lato'      => __( 'Lato (Professional)', 'mediakit-lite' ),
            'montserrat' => __( 'Montserrat (Bold & Modern)', 'mediakit-lite' ),
            'poppins'   => __( 'Poppins (Geometric Sans)', 'mediakit-lite' ),
            'raleway'   => __( 'Raleway (Thin & Stylish)', 'mediakit-lite' ),
        ),
    ) );
    
    // Enable Search in Navigation
    $wp_customize->add_setting( 'mkp_enable_search', array(
        'default'           => false,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_search', array(
        'label'       => __( 'Enable Search in Navigation', 'mediakit-lite' ),
        'description' => __( 'Add a search bar to the main navigation menu.', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'checkbox',
        'priority'    => 60,
    ) );
    
    
    // Color Theme Selector
    $wp_customize->add_setting( 'mkp_color_theme', array(
        'default'           => 'ocean_depths',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_color_theme', array(
        'type'        => 'select',
        'section'     => 'title_tagline',
        'label'       => __( 'Color Theme', 'mediakit-lite' ),
        'description' => __( 'Choose a professional color theme for your entire site. Colors automatically rotate through sections for visual interest.', 'mediakit-lite' ),
        'choices'     => mkp_get_theme_names(),
        'priority'    => 20,
    ) );
    
    // Body Font
    $wp_customize->add_setting( 'mkp_body_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_body_font', array(
        'label'       => __( 'Body Font', 'mediakit-lite' ),
        'description' => __( 'Font family for body text and paragraphs.', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'select',
        'priority'    => 30,
        'choices'     => array(
            'system'    => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'inter'     => __( 'Inter (Modern & Clean)', 'mediakit-lite' ),
            'roboto'    => __( 'Roboto (Google Style)', 'mediakit-lite' ),
            'opensans'  => __( 'Open Sans (Friendly)', 'mediakit-lite' ),
            'lato'      => __( 'Lato (Professional)', 'mediakit-lite' ),
            'montserrat' => __( 'Montserrat (Bold & Modern)', 'mediakit-lite' ),
            'poppins'   => __( 'Poppins (Geometric Sans)', 'mediakit-lite' ),
            'raleway'   => __( 'Raleway (Thin & Stylish)', 'mediakit-lite' ),
        ),
    ) );
    
    // Heading Font
    $wp_customize->add_setting( 'mkp_heading_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_heading_font', array(
        'label'       => __( 'Heading Font', 'mediakit-lite' ),
        'description' => __( 'Font family for all headings (H1-H6).', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'type'        => 'select',
        'priority'    => 40,
        'choices'     => array(
            'system'     => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'inter'      => __( 'Inter (Modern & Clean)', 'mediakit-lite' ),
            'roboto'     => __( 'Roboto (Google Style)', 'mediakit-lite' ),
            'opensans'   => __( 'Open Sans (Friendly)', 'mediakit-lite' ),
            'lato'       => __( 'Lato (Professional)', 'mediakit-lite' ),
            'montserrat' => __( 'Montserrat (Bold & Modern)', 'mediakit-lite' ),
            'playfair'   => __( 'Playfair Display (Elegant Serif)', 'mediakit-lite' ),
            'merriweather' => __( 'Merriweather (Readable Serif)', 'mediakit-lite' ),
            'georgia'    => __( 'Georgia (Classic Serif)', 'mediakit-lite' ),
            'poppins'    => __( 'Poppins (Geometric Sans)', 'mediakit-lite' ),
            'raleway'    => __( 'Raleway (Thin & Stylish)', 'mediakit-lite' ),
        ),
    ) );
    
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
    
    // Professional Tags (1-5)
    for ( $i = 1; $i <= 5; $i++ ) {
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
    
    /**
     * About Section
     */
    $wp_customize->add_section( 'mkp_about_section', array(
        'title'       => __( 'About', 'mediakit-lite' ),
        'priority'    => 40,
        'description' => __( 'Your professional about information and background.', 'mediakit-lite' ),
    ) );
            // About Content
    $wp_customize->add_setting( 'mkp_about_content', array(
        'default'           => mkp_get_default_about_content(),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_about_content', array(
        'label'       => __( 'About Content', 'mediakit-lite' ),
        'description' => __( 'Your professional about information. HTML allowed.', 'mediakit-lite' ),
        'section'     => 'mkp_about_section',
        'type'        => 'textarea',
        'priority'    => 10,
        'input_attrs' => array(
            'rows' => 10,
        ),
    ) );
    
    /**
     * Companies Section
     */
    $wp_customize->add_section( 'mkp_corporations_section', array(
        'title'       => __( 'Companies', 'mediakit-lite' ),
        'priority'    => 45,
        'description' => __( 'Companies or organizations you own or are affiliated with.', 'mediakit-lite' ),
    ) );
    
    // Enable Corporations Section
    $wp_customize->add_setting( 'mkp_enable_section_corporations', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_corporations', array(
        'label'       => __( 'Enable Companies Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the companies section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_corporations_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
            // Corporation entries
    for ( $i = 1; $i <= 6; $i++ ) {
        // Corporation Name
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_name', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_corp_' . $i . '_name', array(
            'label'       => sprintf( __( 'Company %d Name', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'type'        => 'text',
            'priority'    => 10 + ($i * 10),
        ) );
        
        // Corporation Logo
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_corp_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Company %d Logo', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'priority'    => 11 + ($i * 10),
        ) ) );
        
        // Corporation Bio
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_bio', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_corp_' . $i . '_bio', array(
            'label'       => sprintf( __( 'Company %d Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'type'        => 'textarea',
            'priority'    => 12 + ($i * 10),
        ) );
        
        // Corporation Link
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_corp_' . $i . '_link', array(
            'label'       => sprintf( __( 'Company %d Website', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'type'        => 'url',
            'priority'    => 13 + ($i * 10),
        ) );
    }
    
    /**
     * Books Section
     */
    $wp_customize->add_section( 'mkp_books_section', array(
        'title'       => __( 'Books', 'mediakit-lite' ),
        'priority'    => 48,
        'description' => __( 'Books you have authored or co-authored.', 'mediakit-lite' ),
    ) );
    
    // Enable Books Section
    $wp_customize->add_setting( 'mkp_enable_section_books', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_books', array(
        'label'       => __( 'Enable Books Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the books section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_books_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Books per row
    $wp_customize->add_setting( 'mkp_books_per_row', array(
        'default'           => '3',
        'sanitize_callback' => 'mkp_sanitize_select',
    ) );
    
    $wp_customize->add_control( 'mkp_books_per_row', array(
        'label'       => __( 'Books Per Row', 'mediakit-lite' ),
        'description' => __( 'Number of books to display per row on desktop.', 'mediakit-lite' ),
        'section'     => 'mkp_books_section',
        'type'        => 'select',
        'choices'     => array(
            '1' => __( '1 per row', 'mediakit-lite' ),
            '2' => __( '2 per row', 'mediakit-lite' ),
            '3' => __( '3 per row (default)', 'mediakit-lite' ),
        ),
        'priority'    => 2,
    ) );
    
            // Book entries (up to 4)
    for ( $i = 1; $i <= 4; $i++ ) {
        // Book Title
        $wp_customize->add_setting( 'mkp_book_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_book_' . $i . '_title', array(
            'label'       => sprintf( __( 'Book %d Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_books_section',
            'type'        => 'text',
            'priority'    => 10 + ($i * 10),
        ) );
        
        // Book Cover
        $wp_customize->add_setting( 'mkp_book_' . $i . '_cover', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_book_' . $i . '_cover', array(
            'label'       => sprintf( __( 'Book %d Cover Image', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_books_section',
            'priority'    => 11 + ($i * 10),
        ) ) );
        
        // Book Description
        $wp_customize->add_setting( 'mkp_book_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_book_' . $i . '_description', array(
            'label'       => sprintf( __( 'Book %d Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_books_section',
            'type'        => 'textarea',
            'priority'    => 12 + ($i * 10),
        ) );
        
        // Book Link
        $wp_customize->add_setting( 'mkp_book_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_book_' . $i . '_link', array(
            'label'       => sprintf( __( 'Book %d Link', 'mediakit-lite' ), $i ),
            'description' => __( 'Link to book page, Amazon, or other retailer', 'mediakit-lite' ),
            'section'     => 'mkp_books_section',
            'type'        => 'url',
            'priority'    => 13 + ($i * 10),
        ) );
    }
    
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
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_gallery', array(
        'label'       => __( 'Enable Image Gallery', 'mediakit-lite' ),
        'description' => __( 'Show or hide the image gallery section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_gallery_section',
        'type'        => 'checkbox',
        'priority'    => 1,
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
    
    /**
     * Podcast/Show Section
     */
    $wp_customize->add_section( 'mkp_podcasts_section', array(
        'title'       => __( 'Podcast/Show', 'mediakit-lite' ),
        'priority'    => 50,
        'description' => __( 'Podcasts or shows you host or co-host.', 'mediakit-lite' ),
    ) );
    
    // Enable Podcasts Section
    $wp_customize->add_setting( 'mkp_enable_section_podcasts', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_podcasts', array(
        'label'       => __( 'Enable Podcast/Show Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the podcast/show section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_podcasts_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
            // Podcast entries (up to 3)
    for ( $i = 1; $i <= 3; $i++ ) {
        // Podcast Title
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_podcast_' . $i . '_title', array(
            'label'       => sprintf( __( 'Podcast/Show %d Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_podcasts_section',
            'type'        => 'text',
            'priority'    => 10 + ($i * 10),
        ) );
        
        // Podcast Logo/Image
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_podcast_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Podcast/Show %d Logo/Image', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_podcasts_section',
            'priority'    => 11 + ($i * 10),
        ) ) );
        
        // Podcast Description
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_podcast_' . $i . '_description', array(
            'label'       => sprintf( __( 'Podcast/Show %d Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_podcasts_section',
            'type'        => 'textarea',
            'priority'    => 12 + ($i * 10),
        ) );
        
        // Podcast Link
        $wp_customize->add_setting( 'mkp_podcast_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_podcast_' . $i . '_link', array(
            'label'       => sprintf( __( 'Podcast/Show %d Link', 'mediakit-lite' ), $i ),
            'description' => __( 'Link to podcast page, Apple Podcasts, Spotify, etc.', 'mediakit-lite' ),
            'section'     => 'mkp_podcasts_section',
            'type'        => 'url',
            'priority'    => 13 + ($i * 10),
        ) );
    }
    
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
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_speaker_topics', array(
        'label'       => __( 'Enable Speaker Topics Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the speaker topics section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_speaker_section',
        'type'        => 'checkbox',
        'priority'    => 1,
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
    
    /**
     * In The Media Section
     */
    $wp_customize->add_section( 'mkp_in_the_media_section', array(
        'title'       => __( 'In The Media', 'mediakit-lite' ),
        'priority'    => 50,
        'description' => __( 'Showcase your media appearances, interviews, and press coverage.', 'mediakit-lite' ),
    ) );
    
    // Enable In The Media Section
    $wp_customize->add_setting( 'mkp_enable_section_in_the_media', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_in_the_media', array(
        'label'       => __( 'Enable In The Media Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the media appearances section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_in_the_media_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_in_the_media_section_title', array(
        'default'           => __( 'In The Media', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_in_the_media_section_title', array(
        'label'       => __( 'Section Title', 'mediakit-lite' ),
        'description' => __( 'Customize the section title', 'mediakit-lite' ),
        'section'     => 'mkp_in_the_media_section',
        'type'        => 'text',
        'priority'    => 2,
    ) );
    
    // Background Color
            // Media Items (up to 8)
    for ( $i = 1; $i <= 8; $i++ ) {
        // URL only
        $wp_customize->add_setting( 'mkp_media_item_' . $i . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_item_' . $i . '_url', array(
            'label'       => sprintf( __( 'Media Item %d URL', 'mediakit-lite' ), $i ),
            'description' => __( 'Paste YouTube, Spotify, Vimeo, or other media URL', 'mediakit-lite' ),
            'section'     => 'mkp_in_the_media_section',
            'type'        => 'url',
            'priority'    => 10 + $i,
        ) );
    }
    
    /**
     * Featured Video Section
     */
    $wp_customize->add_section( 'mkp_featured_video_section', array(
        'title'       => __( 'Featured Video', 'mediakit-lite' ),
        'priority'    => 51,
        'description' => __( 'Showcase a featured video with optional call-to-action buttons.', 'mediakit-lite' ),
    ) );
    
    // Enable Section
    $wp_customize->add_setting( 'mkp_enable_section_featured_video', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_featured_video', array(
        'label'       => __( 'Enable Featured Video Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the featured video section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_featured_video_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_featured_video_section_title', array(
        'default'           => __( 'Featured Video', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Video URL
    $wp_customize->add_setting( 'mkp_featured_video_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_url', array(
        'label'           => __( 'Video URL', 'mediakit-lite' ),
        'description'     => __( 'Enter a YouTube, Vimeo, or other supported video URL', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'url',
        'priority'        => 10,
    ) );
    
    // Video Title
    $wp_customize->add_setting( 'mkp_featured_video_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_title', array(
        'label'           => __( 'Video Title', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 15,
    ) );
    
    // Video Description
    $wp_customize->add_setting( 'mkp_featured_video_description', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_description', array(
        'label'           => __( 'Video Description', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'textarea',
        'priority'        => 20,
    ) );
    
    // Primary CTA Text
    $wp_customize->add_setting( 'mkp_featured_video_primary_cta_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_primary_cta_text', array(
        'label'           => __( 'Primary Button Text', 'mediakit-lite' ),
        'description'     => __( 'Leave empty to hide the primary button', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 30,
    ) );
    
    // Primary CTA URL
    $wp_customize->add_setting( 'mkp_featured_video_primary_cta_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_primary_cta_url', array(
        'label'           => __( 'Primary Button URL', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'url',
        'priority'        => 35,
    ) );
    
    // Secondary CTA Text
    $wp_customize->add_setting( 'mkp_featured_video_secondary_cta_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_secondary_cta_text', array(
        'label'           => __( 'Secondary Button Text', 'mediakit-lite' ),
        'description'     => __( 'Leave empty to hide the secondary button', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'text',
        'priority'        => 45,
    ) );
    
    // Secondary CTA URL
    $wp_customize->add_setting( 'mkp_featured_video_secondary_cta_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_featured_video_secondary_cta_url', array(
        'label'           => __( 'Secondary Button URL', 'mediakit-lite' ),
        'section'         => 'mkp_featured_video_section',
        'type'            => 'url',
        'priority'        => 50,
    ) );
    
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
        'transport'         => 'postMessage',
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
    
    /**
     * Awards & Recognition Section
     */
    $wp_customize->add_section( 'mkp_awards_section', array(
        'title'       => __( 'Awards & Recognition', 'mediakit-lite' ),
        'priority'    => 53,
        'description' => __( 'Showcase awards, certifications, and achievements.', 'mediakit-lite' ),
    ) );
    
    // Enable Awards Section
    $wp_customize->add_setting( 'mkp_enable_section_awards', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_awards', array(
        'label'       => __( 'Enable Awards Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the awards section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_awards_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_awards_section_title', array(
        'default'           => __( 'Awards & Recognition', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_awards_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_awards_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Awards (up to 6)
    for ( $i = 1; $i <= 6; $i++ ) {
        // Logo
        $wp_customize->add_setting( 'mkp_award_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_award_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Award %d Logo/Badge', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'priority'    => 10 + ( $i * 10 ),
        ) ) );
        
        // Title
        $wp_customize->add_setting( 'mkp_award_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_award_' . $i . '_title', array(
            'label'       => sprintf( __( 'Award Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
        
        // Year
        $wp_customize->add_setting( 'mkp_award_' . $i . '_year', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_award_' . $i . '_year', array(
            'label'       => sprintf( __( 'Year', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 2,
        ) );
        
        // Description
        $wp_customize->add_setting( 'mkp_award_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_award_' . $i . '_description', array(
            'label'       => sprintf( __( 'Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_awards_section',
            'type'        => 'textarea',
            'priority'    => 10 + ( $i * 10 ) + 3,
        ) );
    }
    
    /**
     * Media Features Section
     */
    $wp_customize->add_section( 'mkp_media_features_section', array(
        'title'       => __( 'Media Features', 'mediakit-lite' ),
        'priority'    => 54,
        'description' => __( 'Display "As Seen In" or "Featured In" media logos.', 'mediakit-lite' ),
    ) );
    
    // Enable Media Features Section
    $wp_customize->add_setting( 'mkp_enable_section_media_features', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_media_features', array(
        'label'       => __( 'Enable Media Features Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the media features section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_media_features_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_media_features_section_title', array(
        'default'           => __( 'Featured In', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_media_features_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_media_features_section',
        'type'            => 'text',
        'priority'        => 5,
    ) );
    
    // Media Logos (up to 12)
    for ( $i = 1; $i <= 12; $i++ ) {
        // Logo
        $wp_customize->add_setting( 'mkp_media_feature_' . $i . '_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_media_feature_' . $i . '_logo', array(
            'label'       => sprintf( __( 'Media Logo %d', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_media_features_section',
            'priority'    => 10 + ( $i * 10 ),
        ) ) );
        
        // Name
        $wp_customize->add_setting( 'mkp_media_feature_' . $i . '_name', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_feature_' . $i . '_name', array(
            'label'       => sprintf( __( 'Media Outlet Name', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_media_features_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
        
        // Link
        $wp_customize->add_setting( 'mkp_media_feature_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_feature_' . $i . '_link', array(
            'label'       => sprintf( __( 'Link to Coverage', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_media_features_section',
            'type'        => 'url',
            'priority'    => 10 + ( $i * 10 ) + 2,
        ) );
    }
    
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
        'transport'         => 'postMessage',
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
    
    // Stats (up to 4)
    for ( $i = 1; $i <= 4; $i++ ) {
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
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_media_questions', array(
        'label'       => __( 'Enable Questions for Media Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the media questions section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_media_questions_section',
        'type'        => 'checkbox',
        'priority'    => 1,
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
        ),
        'priority'    => 3,
    ) );
    
    // Media questions (up to 12)
    for ( $i = 1; $i <= 12; $i++ ) {
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
    
    /**
     * Investor Section
     */
    $wp_customize->add_section( 'mkp_investor_section', array(
        'title'       => __( 'Investor', 'mediakit-lite' ),
        'priority'    => 57,
        'description' => __( 'Showcase investment opportunities or investor relations information.', 'mediakit-lite' ),
    ) );
    
    // Enable Investor Section
    $wp_customize->add_setting( 'mkp_enable_section_investor', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_investor', array(
        'label'       => __( 'Enable Investor Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the investor section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_investor_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
            // Investor options (up to 3)
    for ( $i = 1; $i <= 3; $i++ ) {
        // Title
        $wp_customize->add_setting( 'mkp_investor_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_investor_' . $i . '_title', array(
            'label'       => sprintf( __( 'Investor Option %d Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_investor_section',
            'type'        => 'text',
            'priority'    => 10 + ( $i * 10 ),
        ) );
        
        // Description
        $wp_customize->add_setting( 'mkp_investor_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_investor_' . $i . '_description', array(
            'label'       => sprintf( __( 'Investor Option %d Description', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_investor_section',
            'type'        => 'textarea',
            'priority'    => 10 + ( $i * 10 ) + 1,
        ) );
    }
    
    // ====================
    // Contact Section 
    // ====================
    $wp_customize->add_section( 'mkp_contact_section', array(
        'title'       => __( 'Contact', 'mediakit-lite' ),
        'priority'    => 58,
        'description' => __( 'Add contact information including email addresses, physical address, and social media links.', 'mediakit-lite' ),
    ) );
    
    // Enable/Disable Contact Section
    $wp_customize->add_setting( 'mkp_enable_section_contact', array(
        'default'           => false,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_contact', array(
        'label'       => __( 'Enable Contact Section', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
            // Email Addresses
    // General Inquiries Email
    $wp_customize->add_setting( 'mkp_contact_general_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_general_email', array(
        'label'       => __( 'General Inquiries Email', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'email',
        'priority'    => 10,
    ) );
    
    // Media/Press Email
    $wp_customize->add_setting( 'mkp_contact_media_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_media_email', array(
        'label'       => __( 'Media/Press Email', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'email',
        'priority'    => 11,
    ) );
    
    // Public Speaking Email
    $wp_customize->add_setting( 'mkp_contact_speaking_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_speaking_email', array(
        'label'       => __( 'Public Speaking Email', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'email',
        'priority'    => 12,
    ) );
    
    // Physical Address
    $wp_customize->add_setting( 'mkp_contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_address', array(
        'label'       => __( 'Physical Address', 'mediakit-lite' ),
        'section'     => 'mkp_contact_section',
        'type'        => 'textarea',
        'priority'    => 20,
    ) );
    
    // Social Media Links
    $social_platforms = array(
        'x'         => __( 'X (Twitter)', 'mediakit-lite' ),
        'facebook'  => __( 'Facebook', 'mediakit-lite' ),
        'instagram' => __( 'Instagram', 'mediakit-lite' ),
        'linkedin'  => __( 'LinkedIn', 'mediakit-lite' ),
        'youtube'   => __( 'YouTube', 'mediakit-lite' ),
        'github'    => __( 'GitHub', 'mediakit-lite' ),
        'threads'   => __( 'Threads', 'mediakit-lite' ),
    );
    
    $priority = 30;
    foreach ( $social_platforms as $platform => $label ) {
        $wp_customize->add_setting( 'mkp_contact_social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_contact_social_' . $platform, array(
            'label'       => $label,
            'section'     => 'mkp_contact_section',
            'type'        => 'url',
            'priority'    => $priority++,
        ) );
    }
    
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
    
    // Add Selective Refresh support for sections
    if ( isset( $wp_customize->selective_refresh ) ) {
        // Get all sections configuration
        $sections_config = mkp_get_all_sections_config();
        
        // Add partials for each toggleable section
        foreach ( $sections_config as $section_id => $section ) {
            // Skip fixed sections
            if ( isset( $section['fixed'] ) && $section['fixed'] ) {
                continue;
            }
            
            // Add partial for this section
            $wp_customize->selective_refresh->add_partial( 'mkp_section_' . $section_id, array(
                'selector'            => '#' . $section_id,
                'container_inclusive' => true,
                'settings'            => array( 'mkp_enable_section_' . $section_id ),
                'render_callback'     => function() use ( $section_id, $section ) {
                    // Use the same display logic as front-page.php
                    $should_display = false;
                    $is_enabled = get_theme_mod( 'mkp_enable_section_' . $section_id, false );
                    
                    if ( $is_enabled ) {
                        // Check if section has content check function
                        if ( ! empty( $section['check_function'] ) && function_exists( $section['check_function'] ) ) {
                            $has_content = call_user_func( $section['check_function'] );
                            // In customizer, show section even if empty for easier editing
                            if ( $has_content || is_customize_preview() ) {
                                $should_display = true;
                            }
                        } else {
                            // No content check needed, just show if enabled
                            $should_display = true;
                        }
                    }
                    
                    // Always output a container for Selective Refresh to target
                    if ( ! $should_display ) {
                        echo '<div id="' . esc_attr( $section_id ) . '" style="display: none;"></div>';
                        return;
                    }
                    
                    // Render the section template
                    get_template_part( $section['template'] );
                },
                'fallback_refresh'    => false,
            ) );
        }
        
        // Add navigation partial that refreshes when any section is enabled/disabled
        $section_settings = array();
        foreach ( $sections_config as $section_id => $section ) {
            if ( ! isset( $section['fixed'] ) || ! $section['fixed'] ) {
                $section_settings[] = 'mkp_enable_section_' . $section_id;
            }
        }
        
        $wp_customize->selective_refresh->add_partial( 'navigation_menu', array(
            'selector'            => '#site-navigation',
            'container_inclusive' => true,
            'settings'            => $section_settings,
            'render_callback'     => function() {
                ?>
                <nav id="site-navigation" class="mkp-header__navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'mediakit-lite' ); ?>">
                    <button class="mkp-mobile-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'mediakit-lite' ); ?>">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    
                    <?php
                    // Always display section navigation
                    $nav_items = mkp_get_front_page_nav_items();
                    if ( ! empty( $nav_items ) ) {
                        echo '<ul id="primary-menu" class="mkp-nav">';
                        foreach ( $nav_items as $item ) {
                            // Check if this is the search item
                            if ( isset( $item['type'] ) && 'search' === $item['type'] ) {
                                echo '<li class="mkp-nav__item mkp-nav__item--search">';
                                ?>
                                <form role="search" method="get" class="mkp-nav__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                    <label>
                                        <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'mediakit-lite' ); ?></span>
                                        <input type="search" class="mkp-nav__search-field" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'mediakit-lite' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                    </label>
                                    <button type="submit" class="mkp-nav__search-submit">
                                        <span class="dashicons dashicons-search"></span>
                                        <span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'mediakit-lite' ); ?></span>
                                    </button>
                                </form>
                                <?php
                                echo '</li>';
                            } else {
                                echo '<li class="mkp-nav__item">';
                                echo '<a href="' . esc_url( $item['url'] ) . '" class="mkp-nav__link">' . esc_html( $item['label'] ) . '</a>';
                                echo '</li>';
                            }
                        }
                        echo '</ul>';
                    }
                    ?>
                </nav>
                <?php
            },
            'fallback_refresh'    => false,
        ) );
    }
}
add_action( 'customize_register', 'mkp_customize_register' );

// Nav menus removal moved to customize_loaded_components filter in customizer-components.php

/**
 * Sanitize font choice
 */
function mkp_sanitize_font_choice( $value ) {
    $valid = array( 'system', 'inter', 'roboto', 'opensans', 'lato', 'montserrat', 'playfair', 'merriweather', 'georgia', 'poppins', 'raleway' );
    
    if ( in_array( $value, $valid, true ) ) {
        return $value;
    }
    
    return 'system';
}

/**
 * Sanitize position choice
 */
function mkp_sanitize_position_choice( $value ) {
    $valid = array( 'left', 'right' );
    
    if ( in_array( $value, $valid, true ) ) {
        return $value;
    }
    
    return 'left';
}

/**
 * Sanitize gallery images (comma-separated IDs)
 */
function mkp_sanitize_gallery_images( $value ) {
    if ( empty( $value ) ) {
        return '';
    }
    
    // Split comma-separated IDs
    $ids = explode( ',', $value );
    $sanitized = array();
    $count = 0;
    
    foreach ( $ids as $id ) {
        if ( $count >= 50 ) {
            break;
        }
        
        $id = absint( trim( $id ) );
        if ( $id && wp_attachment_is_image( $id ) ) {
            $sanitized[] = $id;
            $count++;
        }
    }
    
    return implode( ',', $sanitized );
}

/**
 * Render the site title for the selective refresh partial.
 */
function mkp_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function mkp_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mkp_customize_preview_js() {
    wp_enqueue_script( 'mkp-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), MKP_THEME_VERSION, true );
    wp_enqueue_script( 'mkp-customizer-live-preview', get_template_directory_uri() . '/assets/js/customizer-live-preview.js', array( 'customize-preview', 'jquery' ), MKP_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'mkp_customize_preview_js' );

/**
 * Enqueue customizer control scripts
 */
function mkp_customize_controls_js() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
    
    wp_enqueue_script( 
        'mkp-customizer-controls', 
        get_template_directory_uri() . '/assets/js/customizer-controls.js', 
        array( 'jquery', 'wp-color-picker', 'customize-controls' ), 
        MKP_THEME_VERSION, 
        true 
    );
}
add_action( 'customize_controls_enqueue_scripts', 'mkp_customize_controls_js' );

/**
 * Sync hero name with site title when saving
 */
function mkp_sync_hero_name_with_site_title( $wp_customize ) {
    // Debug log entry
    if ( function_exists( 'mkp_debug_log' ) ) {
        mkp_debug_log( 'mkp_sync_hero_name_with_site_title started' );
    }
    
    // Validate that we have a valid customizer instance
    if ( ! is_object( $wp_customize ) || ! method_exists( $wp_customize, 'get_setting' ) ) {
        if ( function_exists( 'mkp_debug_log' ) ) {
            mkp_debug_log( 'Invalid customizer instance in mkp_sync_hero_name_with_site_title' );
        }
        return;
    }
    
    // Get the hero name theme mod
    $hero_name = get_theme_mod( 'mkp_hero_name' );
    
    // Only update if we have a valid hero name
    if ( ! empty( $hero_name ) && is_string( $hero_name ) ) {
        // Sanitize the hero name before saving
        $sanitized_hero_name = sanitize_text_field( $hero_name );
        
        // Update the site title
        update_option( 'blogname', $sanitized_hero_name );
        
        if ( function_exists( 'mkp_debug_log' ) ) {
            mkp_debug_log( 'Site title updated to: ' . $sanitized_hero_name );
        }
    }
    
    if ( function_exists( 'mkp_debug_log' ) ) {
        mkp_debug_log( 'mkp_sync_hero_name_with_site_title completed' );
    }
}
add_action( 'customize_save_after', 'mkp_sync_hero_name_with_site_title' );

/**
 * Set initial hero name from site title if not set
 */
function mkp_set_initial_hero_name() {
    $hero_name = get_theme_mod( 'mkp_hero_name' );
    if ( ! $hero_name ) {
        set_theme_mod( 'mkp_hero_name', get_bloginfo( 'name' ) );
    }
}
add_action( 'after_switch_theme', 'mkp_set_initial_hero_name' );