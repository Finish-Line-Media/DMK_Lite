<?php
/**
 * MediaKit Lite Theme Customizer - Cleaned Version
 *
 * @package MediaKit_Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function mkp_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
    // Remove default WordPress sections
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );
    $wp_customize->remove_panel( 'nav_menus' );
    // Widget panel removal is handled in customizer-widget-fix.php
    $wp_customize->remove_section( 'static_front_page' );
    $wp_customize->remove_section( 'custom_css' );
    
    // Remove site title and tagline controls
    $wp_customize->remove_control( 'blogname' );
    $wp_customize->remove_control( 'blogdescription' );
    $wp_customize->remove_control( 'display_header_text' );
    
    // Rename Site Identity section to Navigation
    if ( $wp_customize->get_section( 'title_tagline' ) ) {
        $wp_customize->get_section( 'title_tagline' )->title = __( 'Navigation', 'mediakit-lite' );
        $wp_customize->get_section( 'title_tagline' )->priority = 25;
        $wp_customize->get_section( 'title_tagline' )->description = __( 'Configure your site navigation.', 'mediakit-lite' );
    }
    
    // Move site icon control to Brand Settings
    if ( $wp_customize->get_control( 'site_icon' ) ) {
        $wp_customize->get_control( 'site_icon' )->section = 'mkp_brand_settings';
        $wp_customize->get_control( 'site_icon' )->priority = 1;
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
    
    // Navigation Background Color
    $wp_customize->add_setting( 'mkp_nav_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_nav_background_color', array(
        'label'       => __( 'Navigation Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the navigation bar.', 'mediakit-lite' ),
        'section'     => 'title_tagline',
        'priority'    => 15,
    ) ) );
    
    /**
     * Brand Settings Section
     */
    $wp_customize->add_section( 'mkp_brand_settings', array(
        'title'       => __( 'Brand Settings', 'mediakit-lite' ),
        'priority'    => 30,
        'description' => __( 'Customize your brand colors and typography to match your professional identity.', 'mediakit-lite' ),
    ) );
    
    // Primary Color
    $wp_customize->add_setting( 'mkp_primary_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_primary_color', array(
        'label'       => __( 'Primary Color', 'mediakit-lite' ),
        'description' => __( 'Main brand color used for headings and important elements.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'priority'    => 10,
    ) ) );
    
    // Secondary Color
    $wp_customize->add_setting( 'mkp_secondary_color', array(
        'default'           => '#3498db',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_secondary_color', array(
        'label'       => __( 'Secondary Color', 'mediakit-lite' ),
        'description' => __( 'Secondary brand color used for buttons and links.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'priority'    => 20,
    ) ) );
    
    // Accent Color
    $wp_customize->add_setting( 'mkp_accent_color', array(
        'default'           => '#e74c3c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_accent_color', array(
        'label'       => __( 'Accent Color', 'mediakit-lite' ),
        'description' => __( 'Accent color used for hover states and highlights.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'priority'    => 30,
    ) ) );
    
    // Heading Font
    $wp_customize->add_setting( 'mkp_heading_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_heading_font', array(
        'label'       => __( 'Heading Font', 'mediakit-lite' ),
        'description' => __( 'Font family for all headings (H1-H6).', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
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
    
    // Body Font
    $wp_customize->add_setting( 'mkp_body_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_body_font', array(
        'label'       => __( 'Body Font', 'mediakit-lite' ),
        'description' => __( 'Font family for body text and paragraphs.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
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
    
    /**
     * Hero Section
     */
    $wp_customize->add_section( 'mkp_hero_section', array(
        'title'       => __( 'Hero Section', 'mediakit-lite' ),
        'priority'    => 35,
        'description' => __( 'Configure your hero section with background image, name, and professional tags.', 'mediakit-lite' ),
    ) );
    
    // Hero Background Color
    $wp_customize->add_setting( 'mkp_hero_background_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_hero_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the hero section.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'priority'    => 1,
    ) ) );
    
    // Hero Background Image
    $wp_customize->add_setting( 'mkp_hero_background', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_hero_background', array(
        'label'       => __( 'Hero Background Image', 'mediakit-lite' ),
        'description' => __( 'Optional background image for the hero section. Recommended size: 1920x800 pixels.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'priority'    => 2,
    ) ) );
    
    // Hero Images (1-4)
    for ( $i = 1; $i <= 4; $i++ ) {
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
    
    // Primary Button Text
    $wp_customize->add_setting( 'mkp_hero_button_primary_text', array(
        'default'           => __( 'Book Me to Speak', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_button_primary_text', array(
        'label'       => __( 'Primary Button Text', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'text',
        'priority'    => 30,
    ) );
    
    // Primary Button Link
    $wp_customize->add_setting( 'mkp_hero_button_primary_link', array(
        'default'           => '#about',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_button_primary_link', array(
        'label'       => __( 'Primary Button Link', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'url',
        'priority'    => 31,
    ) );
    
    /**
     * About/Bio Section
     */
    $wp_customize->add_section( 'mkp_bio_section', array(
        'title'       => __( 'About/Bio Section', 'mediakit-lite' ),
        'priority'    => 40,
        'description' => __( 'Your professional biography and background information.', 'mediakit-lite' ),
    ) );
    
    // Bio Background Color
    $wp_customize->add_setting( 'mkp_bio_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_bio_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the bio section.', 'mediakit-lite' ),
        'section'     => 'mkp_bio_section',
        'priority'    => 1,
    ) ) );
    
    // Bio Content
    $wp_customize->add_setting( 'mkp_bio_content', array(
        'default'           => mkp_get_default_bio_content(),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_bio_content', array(
        'label'       => __( 'Biography Content', 'mediakit-lite' ),
        'description' => __( 'Your professional biography. HTML allowed.', 'mediakit-lite' ),
        'section'     => 'mkp_bio_section',
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
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_corporations', array(
        'label'       => __( 'Enable Companies Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the companies section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_corporations_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Corporations Background Color
    $wp_customize->add_setting( 'mkp_corporations_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_corporations_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the companies section.', 'mediakit-lite' ),
        'section'     => 'mkp_corporations_section',
        'priority'    => 2,
    ) ) );
    
    
    // Corporation entries
    for ( $i = 1; $i <= 4; $i++ ) {
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
     * Speaker Topics Section
     */
    $wp_customize->add_section( 'mkp_speaker_section', array(
        'title'       => __( 'Speaker Topics', 'mediakit-lite' ),
        'priority'    => 50,
        'description' => __( 'Topics you speak about professionally.', 'mediakit-lite' ),
    ) );
    
    // Enable Speaker Topics Section
    $wp_customize->add_setting( 'mkp_enable_section_speaker_topics', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_speaker_topics', array(
        'label'       => __( 'Enable Speaker Topics Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the speaker topics section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_speaker_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Speaker Topics Background Color
    $wp_customize->add_setting( 'mkp_speaker_topics_background_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_speaker_topics_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the speaker topics section.', 'mediakit-lite' ),
        'section'     => 'mkp_speaker_section',
        'priority'    => 2,
    ) ) );
    
    // List Style
    $wp_customize->add_setting( 'mkp_speaker_topics_list_style', array(
        'default'           => 'bullets',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'postMessage',
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
    
    // Speaker topics (exactly 5)
    for ( $i = 1; $i <= 5; $i++ ) {
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
add_action( 'customize_register', 'mkp_customize_register' );

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