<?php
/**
 * MediaKit Lite Theme Customizer
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
    
    // Remove default WordPress sections we're replacing
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );
    
    // Remove site title and tagline controls
    $wp_customize->remove_control( 'blogname' );
    $wp_customize->remove_control( 'blogdescription' );
    $wp_customize->remove_control( 'display_header_text' );
    
    // Rename Site Identity section to Navigation
    if ( $wp_customize->get_section( 'title_tagline' ) ) {
        $wp_customize->get_section( 'title_tagline' )->title = __( 'Navigation', 'mediakit-lite' );
        $wp_customize->get_section( 'title_tagline' )->priority = 25;
        $wp_customize->get_section( 'title_tagline' )->description = __( 'Configure your site navigation and choose which sections to display.', 'mediakit-lite' );
    }
    
    // Move site icon control to Brand Settings (we'll do this after Brand Settings is created)
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
    
    // Section Colors section removed - merged into Brand Settings
    
    /**
     * Brand Settings Section
     */
    $wp_customize->add_section( 'mkp_brand_settings', array(
        'title'       => __( 'Brand Settings', 'mediakit-lite' ),
        'priority'    => 30,
        'description' => __( 'Customize your brand colors, section backgrounds, and typography to match your professional identity. These settings will be applied throughout your media kit.', 'mediakit-lite' ),
    ) );
    
    // Primary Color
    $wp_customize->add_setting( 'mkp_primary_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_primary_color', array(
        'label'       => __( 'Primary Color', 'mediakit-lite' ),
        'description' => __( 'Your main brand color. Used for headings, buttons, and key interface elements.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'settings'    => 'mkp_primary_color',
    ) ) );
    
    // Secondary Color
    $wp_customize->add_setting( 'mkp_secondary_color', array(
        'default'           => '#3498db',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_secondary_color', array(
        'label'       => __( 'Secondary Color', 'mediakit-lite' ),
        'description' => __( 'Supporting color for links, hover states, and secondary buttons. Should complement your primary color.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'settings'    => 'mkp_secondary_color',
    ) ) );
    
    // Hover Color
    $wp_customize->add_setting( 'mkp_accent_color', array(
        'default'           => '#e74c3c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_accent_color', array(
        'label'       => __( 'Hover Color', 'mediakit-lite' ),
        'description' => __( 'Color used for hover states on links, buttons, and interactive elements. Choose a color that provides good contrast.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'settings'    => 'mkp_accent_color',
    ) ) );
    
    // Typography - Primary Font
    $wp_customize->add_setting( 'mkp_primary_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_primary_font', array(
        'label'       => __( 'Primary Font', 'mediakit-lite' ),
        'description' => __( 'Font for body text and general content. System fonts load fastest, while Google fonts offer more personality.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'type'        => 'select',
        'choices'     => array(
            'system'    => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'inter'     => __( 'Inter (Modern & Clean)', 'mediakit-lite' ),
            'roboto'    => __( 'Roboto (Google Style)', 'mediakit-lite' ),
            'opensans'  => __( 'Open Sans (Friendly)', 'mediakit-lite' ),
            'lato'      => __( 'Lato (Professional)', 'mediakit-lite' ),
            'montserrat' => __( 'Montserrat (Bold & Modern)', 'mediakit-lite' ),
        ),
    ) );
    
    // Typography - Heading Font
    $wp_customize->add_setting( 'mkp_heading_font', array(
        'default'           => 'playfair',
        'sanitize_callback' => 'mkp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_heading_font', array(
        'label'       => __( 'Heading Font', 'mediakit-lite' ),
        'description' => __( 'Font for titles and headings. Choose something that reflects your personal brand and stands out.', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'type'        => 'select',
        'choices'     => array(
            'system'    => __( 'System Fonts (Fastest)', 'mediakit-lite' ),
            'playfair'  => __( 'Playfair Display (Elegant Serif)', 'mediakit-lite' ),
            'merriweather' => __( 'Merriweather (Readable Serif)', 'mediakit-lite' ),
            'georgia'   => __( 'Georgia (Classic Serif)', 'mediakit-lite' ),
            'poppins'   => __( 'Poppins (Geometric Sans)', 'mediakit-lite' ),
            'raleway'   => __( 'Raleway (Thin & Stylish)', 'mediakit-lite' ),
        ),
    ) );
    
    // Reset Button for Brand Settings
    $wp_customize->add_setting( 'mkp_reset_brand_settings', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( new MKP_Reset_Control( $wp_customize, 'mkp_reset_brand_settings', array(
        'label'       => __( 'Reset Brand Settings', 'mediakit-lite' ),
        'section'     => 'mkp_brand_settings',
        'priority'    => 100,
    ) ) );
    
    /**
     * Background Settings Section
     */
    $wp_customize->add_section( 'mkp_background_settings', array(
        'title'       => __( 'Background Settings', 'mediakit-lite' ),
        'priority'    => 32,
        'description' => __( 'Control the overall site background. Use a solid color for a clean look, or add a pattern/image for more visual interest. Background images work best at 1920x1080 pixels or larger.', 'mediakit-lite' ),
    ) );
    
    // Move WordPress background color control to our section
    if ( $wp_customize->get_control( 'background_color' ) ) {
        $wp_customize->get_control( 'background_color' )->section = 'mkp_background_settings';
        $wp_customize->get_control( 'background_color' )->priority = 10;
        $wp_customize->get_control( 'background_color' )->description = __( 'Choose a background color for your entire site. This color will show behind all content areas.', 'mediakit-lite' );
    }
    
    // Move WordPress background image control to our section
    if ( $wp_customize->get_control( 'background_image' ) ) {
        $wp_customize->get_control( 'background_image' )->section = 'mkp_background_settings';
        $wp_customize->get_control( 'background_image' )->priority = 20;
        $wp_customize->get_control( 'background_image' )->description = __( 'Upload a background image or pattern. For best results, use images at least 1920x1080 pixels. Subtle patterns or blurred images work well.', 'mediakit-lite' );
    }
    
    // Move background preset control
    if ( $wp_customize->get_control( 'background_preset' ) ) {
        $wp_customize->get_control( 'background_preset' )->section = 'mkp_background_settings';
        $wp_customize->get_control( 'background_preset' )->priority = 30;
    }
    
    // Move background position controls
    if ( $wp_customize->get_control( 'background_position_x' ) ) {
        $wp_customize->get_control( 'background_position_x' )->section = 'mkp_background_settings';
        $wp_customize->get_control( 'background_position_x' )->priority = 40;
    }
    
    // Move background size control
    if ( $wp_customize->get_control( 'background_size' ) ) {
        $wp_customize->get_control( 'background_size' )->section = 'mkp_background_settings';
        $wp_customize->get_control( 'background_size' )->priority = 50;
    }
    
    // Move background repeat control
    if ( $wp_customize->get_control( 'background_repeat' ) ) {
        $wp_customize->get_control( 'background_repeat' )->section = 'mkp_background_settings';
        $wp_customize->get_control( 'background_repeat' )->priority = 60;
    }
    
    // Move background attachment control
    if ( $wp_customize->get_control( 'background_attachment' ) ) {
        $wp_customize->get_control( 'background_attachment' )->section = 'mkp_background_settings';
        $wp_customize->get_control( 'background_attachment' )->priority = 70;
    }
    
    // Background overlay color
    $wp_customize->add_setting( 'mkp_background_overlay_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_background_overlay_color', array(
        'label'       => __( 'Background Overlay Color', 'mediakit-lite' ),
        'description' => __( 'Color for the overlay on background image.', 'mediakit-lite' ),
        'section'     => 'mkp_background_settings',
        'settings'    => 'mkp_background_overlay_color',
        'priority'    => 80,
    ) ) );
    
    // Background overlay opacity
    $wp_customize->add_setting( 'mkp_background_overlay_opacity', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_background_overlay_opacity', array(
        'label'       => __( 'Background Overlay Opacity', 'mediakit-lite' ),
        'description' => __( 'Opacity of the overlay (0 = transparent, 100 = opaque).', 'mediakit-lite' ),
        'section'     => 'mkp_background_settings',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
        'priority'    => 81,
    ) );
    
    // Reset Button for Background Settings
    $wp_customize->add_setting( 'mkp_reset_background_settings', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( new MKP_Reset_Control( $wp_customize, 'mkp_reset_background_settings', array(
        'label'       => __( 'Reset Background Settings', 'mediakit-lite' ),
        'section'     => 'mkp_background_settings',
        'priority'    => 100,
    ) ) );
    
    /**
     * Hero Section
     */
    $wp_customize->add_section( 'mkp_hero_section', array(
        'title'       => __( 'Hero Section', 'mediakit-lite' ),
        'priority'    => 35,
        'description' => __( 'Create a powerful first impression with your hero section. This is the first thing visitors see, so make it count with compelling text and visuals.', 'mediakit-lite' ),
    ) );
    
    // Profile Photo
    $wp_customize->add_setting( 'mkp_hero_profile_photo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_hero_profile_photo', array(
        'label'       => __( 'Profile Photo', 'mediakit-lite' ),
        'description' => __( 'Upload your professional headshot. Image will display at full size with a maximum height of 300px.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'settings'    => 'mkp_hero_profile_photo',
    ) ) );
    
    // Profile Photo Position
    $wp_customize->add_setting( 'mkp_hero_profile_photo_position', array(
        'default'           => 'left',
        'sanitize_callback' => 'mkp_sanitize_position_choice',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_profile_photo_position', array(
        'label'       => __( 'Profile Photo Position', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'radio',
        'choices'     => array(
            'left'  => __( 'Left', 'mediakit-lite' ),
            'right' => __( 'Right', 'mediakit-lite' ),
        ),
    ) );
    
    // Family Crest
    $wp_customize->add_setting( 'mkp_hero_family_crest', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_hero_family_crest', array(
        'label'       => __( 'Family Crest', 'mediakit-lite' ),
        'description' => __( 'Upload your family crest or logo. Image will display at full size with a maximum height of 300px.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'settings'    => 'mkp_hero_family_crest',
    ) ) );
    
    // Family Crest Position
    $wp_customize->add_setting( 'mkp_hero_family_crest_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'mkp_sanitize_position_choice',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_family_crest_position', array(
        'label'       => __( 'Family Crest Position', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'radio',
        'choices'     => array(
            'left'  => __( 'Left', 'mediakit-lite' ),
            'right' => __( 'Right', 'mediakit-lite' ),
        ),
    ) );
    
    // Hero Background Color
    $wp_customize->add_setting( 'mkp_hero_background_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_hero_background_color', array(
        'label'       => __( 'Hero Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the hero section.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'settings'    => 'mkp_hero_background_color',
    ) ) );
    
    // Hero Background Image
    $wp_customize->add_setting( 'mkp_hero_background', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_hero_background', array(
        'label'       => __( 'Hero Background Image (Optional)', 'mediakit-lite' ),
        'description' => __( 'Optional background image (1920x1080 or larger). Leave empty for clean section color background.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'settings'    => 'mkp_hero_background',
    ) ) );
    
    // Hero Video URL
    $wp_customize->add_setting( 'mkp_hero_video', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_video', array(
        'label'       => __( 'Hero Background Video URL', 'mediakit-lite' ),
        'description' => __( 'Optional: Add a YouTube/Vimeo URL for dynamic backgrounds. Keep videos under 30 seconds and ensure they have captions for accessibility.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'url',
    ) );
    
    // Hero Overlay Color
    $wp_customize->add_setting( 'mkp_hero_overlay_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_hero_overlay_color', array(
        'label'       => __( 'Hero Overlay Color', 'mediakit-lite' ),
        'description' => __( 'Color for the overlay on hero background image.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'settings'    => 'mkp_hero_overlay_color',
    ) ) );
    
    // Hero Overlay Opacity
    $wp_customize->add_setting( 'mkp_hero_overlay_opacity', array(
        'default'           => '50',
        'sanitize_callback' => 'absint',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_overlay_opacity', array(
        'label'       => __( 'Hero Overlay Opacity', 'mediakit-lite' ),
        'description' => __( 'Opacity of the overlay (0 = transparent, 100 = opaque).', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ) );
    
    // Person's Name
    $wp_customize->add_setting( 'mkp_hero_name', array(
        'default'           => __( 'Your Name', 'mediakit-lite' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_name', array(
        'label'       => __( 'Person\'s Name', 'mediakit-lite' ),
        'description' => __( 'Your full name as you want it displayed prominently.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'text',
    ) );
    
    // Professional Tags (up to 5)
    for ( $i = 1; $i <= 5; $i++ ) {
        $wp_customize->add_setting( 'mkp_hero_tag_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_hero_tag_' . $i, array(
            'label'       => sprintf( __( 'Professional Tag %d', 'mediakit-lite' ), $i ),
            'description' => $i === 1 ? __( 'Add up to 5 professional tags (e.g., Podcaster, Investor, Speaker, Author, Entrepreneur)', 'mediakit-lite' ) : '',
            'section'     => 'mkp_hero_section',
            'type'        => 'text',
        ) );
    }
    
    // Remove hero bio from hero section as it will be in its own section
    
    // Hero CTA Button 1 Text
    $wp_customize->add_setting( 'mkp_hero_cta1_text', array(
        'default'           => __( 'Book Me', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_cta1_text', array(
        'label'       => __( 'Primary Button Text', 'mediakit-lite' ),
        'description' => __( 'Your main call-to-action. Common options: "Book Me", "Get In Touch", "Schedule a Call", "Learn More"', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'text',
    ) );
    
    // Hero CTA Button 1 URL
    $wp_customize->add_setting( 'mkp_hero_cta1_url', array(
        'default'           => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_cta1_url', array(
        'label'       => __( 'Primary Button URL', 'mediakit-lite' ),
        'description' => __( 'Where the button links to. Use #contact for contact section, or add external booking link.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'url',
    ) );
    
    // Hero CTA Button 2 Text
    $wp_customize->add_setting( 'mkp_hero_cta2_text', array(
        'default'           => __( 'Download Media Kit', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_cta2_text', array(
        'label'       => __( 'Secondary Button Text', 'mediakit-lite' ),
        'description' => __( 'Optional second action. Examples: "Download Media Kit", "View Speaking Topics", "Watch Demo Reel"', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'text',
    ) );
    
    // Hero CTA Button 2 URL
    $wp_customize->add_setting( 'mkp_hero_cta2_url', array(
        'default'           => '#download',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'mkp_hero_cta2_url', array(
        'label'       => __( 'Secondary Button URL', 'mediakit-lite' ),
        'description' => __( 'Link for the secondary button. Can be a page, download link, or external URL.', 'mediakit-lite' ),
        'section'     => 'mkp_hero_section',
        'type'        => 'url',
    ) );
    
    /**
     * Social Media Section
     */
    $wp_customize->add_section( 'mkp_social_media', array(
        'title'       => __( 'Social Media', 'mediakit-lite' ),
        'priority'    => 56,
        'description' => __( 'Connect your social media profiles. Only filled URLs will display. Icons will appear in your header, footer, and contact sections.', 'mediakit-lite' ),
    ) );
    
    // Social Media Platforms
    $social_platforms = array(
        'facebook'  => array( 'label' => __( 'Facebook', 'mediakit-lite' ), 'desc' => __( 'Your Facebook page or profile URL', 'mediakit-lite' ) ),
        'twitter'   => array( 'label' => __( 'X (Twitter)', 'mediakit-lite' ), 'desc' => __( 'Your X profile URL (formerly Twitter)', 'mediakit-lite' ) ),
        'instagram' => array( 'label' => __( 'Instagram', 'mediakit-lite' ), 'desc' => __( 'Your Instagram profile URL', 'mediakit-lite' ) ),
        'linkedin'  => array( 'label' => __( 'LinkedIn', 'mediakit-lite' ), 'desc' => __( 'Your LinkedIn profile URL (important for professional connections)', 'mediakit-lite' ) ),
        'youtube'   => array( 'label' => __( 'YouTube', 'mediakit-lite' ), 'desc' => __( 'Your YouTube channel URL', 'mediakit-lite' ) ),
        'tiktok'    => array( 'label' => __( 'TikTok', 'mediakit-lite' ), 'desc' => __( 'Your TikTok profile URL', 'mediakit-lite' ) ),
    );
    
    foreach ( $social_platforms as $platform => $info ) {
        $wp_customize->add_setting( 'mkp_social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_social_' . $platform, array(
            'label'       => $info['label'] . ' ' . __( 'URL', 'mediakit-lite' ),
            'description' => $info['desc'],
            'section'     => 'mkp_social_media',
            'type'        => 'url',
        ) );
    }
    
    /**
     * About/Bio Section
     */
    $wp_customize->add_section( 'mkp_bio_section', array(
        'title'       => __( 'About/Bio Section', 'mediakit-lite' ),
        'priority'    => 41,
        'description' => __( 'Share your story and background. Keep it concise and impactful (3-5 paragraphs maximum).', 'mediakit-lite' ),
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
        'settings'    => 'mkp_bio_background_color',
    ) ) );
    
    // Bio Content
    $wp_customize->add_setting( 'mkp_bio_content', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_bio_content', array(
        'label'       => __( 'Biography Content', 'mediakit-lite' ),
        'description' => __( 'Write your professional biography. Use paragraphs separated by blank lines. Maximum 3-5 paragraphs for optimal readability.', 'mediakit-lite' ),
        'section'     => 'mkp_bio_section',
        'type'        => 'textarea',
    ) );
    
    /**
     * Books Section
     */
    $wp_customize->add_section( 'mkp_books_section', array(
        'title'       => __( 'Books', 'mediakit-lite' ),
        'priority'    => 42,
        'description' => __( 'Showcase your published books or upcoming releases.', 'mediakit-lite' ),
    ) );
    
    // Enable Books Section
    $wp_customize->add_setting( 'mkp_enable_section_books', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_books', array(
        'label'       => __( 'Enable Books Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the books section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_books_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Books Background Color
    $wp_customize->add_setting( 'mkp_books_background_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_books_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the books section.', 'mediakit-lite' ),
        'section'     => 'mkp_books_section',
        'settings'    => 'mkp_books_background_color',
        'priority'    => 2,
    ) ) );
    
    // Number of books to display
    $wp_customize->add_setting( 'mkp_books_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ) );
    
    $wp_customize->add_control( 'mkp_books_count', array(
        'label'       => __( 'Number of Books', 'mediakit-lite' ),
        'description' => __( 'How many books do you want to display? (1-6)', 'mediakit-lite' ),
        'section'     => 'mkp_books_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 6,
            'step' => 1,
        ),
    ) );
    
    // Book entries
    for ( $i = 1; $i <= 6; $i++ ) {
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
        ) );
        
        // Book Cover Image
        $wp_customize->add_setting( 'mkp_book_' . $i . '_cover', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_book_' . $i . '_cover', array(
            'label'       => sprintf( __( 'Book %d Cover Image', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_books_section',
            'settings'    => 'mkp_book_' . $i . '_cover',
        ) ) );
        
        // Book Description
        $wp_customize->add_setting( 'mkp_book_' . $i . '_description', array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_book_' . $i . '_description', array(
            'label'       => sprintf( __( 'Book %d Description', 'mediakit-lite' ), $i ),
            'description' => __( 'Brief description. For unpublished books, use "Highly Anticipated Book due out this fall" or similar.', 'mediakit-lite' ),
            'section'     => 'mkp_books_section',
            'type'        => 'textarea',
        ) );
        
        // Book Link
        $wp_customize->add_setting( 'mkp_book_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_book_' . $i . '_link', array(
            'label'       => sprintf( __( 'Book %d Purchase Link', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_books_section',
            'type'        => 'url',
        ) );
    }
    
    /**
     * Speaker Topics Section
     */
    $wp_customize->add_section( 'mkp_speaker_section', array(
        'title'       => __( 'Speaker Topics', 'mediakit-lite' ),
        'priority'    => 43,
        'description' => __( 'List 5 themes/topics you are qualified to speak on.', 'mediakit-lite' ),
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
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_speaker_topics_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the speaker topics section.', 'mediakit-lite' ),
        'section'     => 'mkp_speaker_section',
        'settings'    => 'mkp_speaker_topics_background_color',
        'priority'    => 2,
    ) ) );
    
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
        ) );
    }
    
    /**
     * Podcast/Show Section
     */
    $wp_customize->add_section( 'mkp_podcast_section', array(
        'title'       => __( 'Your Podcast/Show', 'mediakit-lite' ),
        'priority'    => 44,
        'description' => __( 'Information about your podcast or show.', 'mediakit-lite' ),
    ) );
    
    // Enable Podcast/Show Section
    $wp_customize->add_setting( 'mkp_enable_section_podcast', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_podcast', array(
        'label'       => __( 'Enable Podcast/Show Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the podcast/show section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_podcast_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Podcast/Show Background Color
    $wp_customize->add_setting( 'mkp_podcast_background_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_podcast_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the podcast/show section.', 'mediakit-lite' ),
        'section'     => 'mkp_podcast_section',
        'settings'    => 'mkp_podcast_background_color',
        'priority'    => 2,
    ) ) );
    
    // Podcast Name
    $wp_customize->add_setting( 'mkp_podcast_name', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_podcast_name', array(
        'label'       => __( 'Podcast/Show Name', 'mediakit-lite' ),
        'section'     => 'mkp_podcast_section',
        'type'        => 'text',
    ) );
    
    // Podcast Logo
    $wp_customize->add_setting( 'mkp_podcast_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_podcast_logo', array(
        'label'       => __( 'Podcast/Show Logo', 'mediakit-lite' ),
        'description' => __( 'Square logo works best (minimum 500x500 pixels)', 'mediakit-lite' ),
        'section'     => 'mkp_podcast_section',
        'settings'    => 'mkp_podcast_logo',
    ) ) );
    
    // Podcast Synopsis
    $wp_customize->add_setting( 'mkp_podcast_synopsis', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_podcast_synopsis', array(
        'label'       => __( 'Podcast/Show Synopsis', 'mediakit-lite' ),
        'description' => __( 'Brief description of your podcast or show', 'mediakit-lite' ),
        'section'     => 'mkp_podcast_section',
        'type'        => 'textarea',
    ) );
    
    // Podcast Link
    $wp_customize->add_setting( 'mkp_podcast_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'mkp_podcast_link', array(
        'label'       => __( 'Podcast/Show Website', 'mediakit-lite' ),
        'section'     => 'mkp_podcast_section',
        'type'        => 'url',
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
        'settings'    => 'mkp_corporations_background_color',
        'priority'    => 2,
    ) ) );
    
    // Number of corporations
    $wp_customize->add_setting( 'mkp_corporations_count', array(
        'default'           => 2,
        'sanitize_callback' => 'absint',
    ) );
    
    $wp_customize->add_control( 'mkp_corporations_count', array(
        'label'       => __( 'Number of Companies', 'mediakit-lite' ),
        'description' => __( 'How many companies to display? (1-4)', 'mediakit-lite' ),
        'section'     => 'mkp_corporations_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 4,
            'step' => 1,
        ),
    ) );
    
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
            'settings'    => 'mkp_corp_' . $i . '_logo',
        ) ) );
        
        // Corporation Bio
        $wp_customize->add_setting( 'mkp_corp_' . $i . '_bio', array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_corp_' . $i . '_bio', array(
            'label'       => sprintf( __( 'Company %d Bio/Synopsis', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_corporations_section',
            'type'        => 'textarea',
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
        ) );
    }
    
    /**
     * Media Questions Section
     */
    $wp_customize->add_section( 'mkp_media_questions_section', array(
        'title'       => __( 'Questions for the Media', 'mediakit-lite' ),
        'priority'    => 46,
        'description' => __( 'Provide 10-12 interview questions to help producers prepare. This does their job for them!', 'mediakit-lite' ),
    ) );
    
    // Enable Media Questions Section
    $wp_customize->add_setting( 'mkp_enable_section_media_questions', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_media_questions', array(
        'label'       => __( 'Enable Media Questions Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the media questions section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_media_questions_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Media Questions Background Color
    $wp_customize->add_setting( 'mkp_media_questions_background_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_media_questions_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the media questions section.', 'mediakit-lite' ),
        'section'     => 'mkp_media_questions_section',
        'settings'    => 'mkp_media_questions_background_color',
        'priority'    => 2,
    ) ) );
    
    // Media questions (12)
    for ( $i = 1; $i <= 12; $i++ ) {
        $wp_customize->add_setting( 'mkp_media_question_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_question_' . $i, array(
            'label'       => sprintf( __( 'Question %d', 'mediakit-lite' ), $i ),
            'description' => $i === 1 ? __( 'Provide engaging questions that showcase your expertise', 'mediakit-lite' ) : '',
            'section'     => 'mkp_media_questions_section',
            'type'        => 'text',
        ) );
    }
    
    /**
     * Investor Section
     */
    $wp_customize->add_section( 'mkp_investor_section', array(
        'title'       => __( 'Investor', 'mediakit-lite' ),
        'priority'    => 47,
        'description' => __( 'Describe your investment focus and philosophy.', 'mediakit-lite' ),
    ) );
    
    // Enable Investor Section
    $wp_customize->add_setting( 'mkp_enable_section_investor', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_investor', array(
        'label'       => __( 'Enable Investor Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the investor section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_investor_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Investor Background Color
    $wp_customize->add_setting( 'mkp_investor_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_investor_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the investor section.', 'mediakit-lite' ),
        'section'     => 'mkp_investor_section',
        'settings'    => 'mkp_investor_background_color',
        'priority'    => 2,
    ) ) );
    
    // Investment Lanes
    $investment_lanes = array(
        'people' => __( 'People', 'mediakit-lite' ),
        'products' => __( 'Products', 'mediakit-lite' ),
        'markets' => __( 'Markets', 'mediakit-lite' ),
    );
    
    foreach ( $investment_lanes as $key => $label ) {
        $wp_customize->add_setting( 'mkp_investment_' . $key, array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_investment_' . $key, array(
            'label'       => sprintf( __( 'Investment in %s', 'mediakit-lite' ), $label ),
            'description' => sprintf( __( 'Describe your investment approach for %s', 'mediakit-lite' ), strtolower( $label ) ),
            'section'     => 'mkp_investor_section',
            'type'        => 'textarea',
        ) );
    }
    
    /**
     * In The Media Section
     */
    $wp_customize->add_section( 'mkp_in_media_section', array(
        'title'       => __( 'In The Media', 'mediakit-lite' ),
        'priority'    => 48,
        'description' => __( 'Showcase your media appearances, podcasts, and audio samples.', 'mediakit-lite' ),
    ) );
    
    // Enable In The Media Section
    $wp_customize->add_setting( 'mkp_enable_section_in_the_media', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_in_the_media', array(
        'label'       => __( 'Enable In The Media Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the in the media section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_in_media_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // In The Media Background Color
    $wp_customize->add_setting( 'mkp_in_media_background_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_in_media_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the in the media section.', 'mediakit-lite' ),
        'section'     => 'mkp_in_media_section',
        'settings'    => 'mkp_in_media_background_color',
        'priority'    => 2,
    ) ) );
    
    // Number of media items
    $wp_customize->add_setting( 'mkp_media_items_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ) );
    
    $wp_customize->add_control( 'mkp_media_items_count', array(
        'label'       => __( 'Number of Media Items', 'mediakit-lite' ),
        'description' => __( 'How many media appearances to display? (1-12)', 'mediakit-lite' ),
        'section'     => 'mkp_in_media_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 12,
            'step' => 1,
        ),
    ) );
    
    // Media items
    for ( $i = 1; $i <= 12; $i++ ) {
        // Media Title
        $wp_customize->add_setting( 'mkp_media_item_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        
        $wp_customize->add_control( 'mkp_media_item_' . $i . '_title', array(
            'label'       => sprintf( __( 'Media Item %d Title', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_in_media_section',
            'type'        => 'text',
        ) );
        
        // Media Type
        $wp_customize->add_setting( 'mkp_media_item_' . $i . '_type', array(
            'default'           => 'podcast',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        
        $wp_customize->add_control( 'mkp_media_item_' . $i . '_type', array(
            'label'       => sprintf( __( 'Media Item %d Type', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_in_media_section',
            'type'        => 'select',
            'choices'     => array(
                'podcast' => __( 'Podcast', 'mediakit-lite' ),
                'interview' => __( 'Interview', 'mediakit-lite' ),
                'audio' => __( 'Audio Sample', 'mediakit-lite' ),
                'video' => __( 'Video', 'mediakit-lite' ),
                'article' => __( 'Article', 'mediakit-lite' ),
            ),
        ) );
        
        // Media Link
        $wp_customize->add_setting( 'mkp_media_item_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( 'mkp_media_item_' . $i . '_link', array(
            'label'       => sprintf( __( 'Media Item %d Link', 'mediakit-lite' ), $i ),
            'section'     => 'mkp_in_media_section',
            'type'        => 'url',
        ) );
    }
    
    /**
     * Contact Information Section
     */
    $wp_customize->add_section( 'mkp_contact_info', array(
        'title'       => __( 'Contact Information', 'mediakit-lite' ),
        'priority'    => 55,
        'description' => __( 'Provide multiple ways for people to reach you. Consider having separate emails for different purposes (general inquiries, bookings, press).', 'mediakit-lite' ),
    ) );
    
    // Enable Contact Section
    $wp_customize->add_setting( 'mkp_enable_section_contact', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_contact', array(
        'label'       => __( 'Enable Contact Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the contact section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Contact Background Color
    $wp_customize->add_setting( 'mkp_contact_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mkp_contact_background_color', array(
        'label'       => __( 'Background Color', 'mediakit-lite' ),
        'description' => __( 'Background color for the contact section.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'settings'    => 'mkp_contact_background_color',
        'priority'    => 2,
    ) ) );
    
    // Primary Email
    $wp_customize->add_setting( 'mkp_contact_email_primary', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_email_primary', array(
        'label'       => __( 'Primary Email', 'mediakit-lite' ),
        'description' => __( 'Your main contact email for general inquiries. This will be displayed prominently.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'type'        => 'email',
    ) );
    
    // Booking Email
    $wp_customize->add_setting( 'mkp_contact_email_booking', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_email_booking', array(
        'label'       => __( 'Booking Email', 'mediakit-lite' ),
        'description' => __( 'Dedicated email for speaking engagements and bookings. Can be the same as primary or a booking agent\'s email.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'type'        => 'email',
    ) );
    
    // Press Email
    $wp_customize->add_setting( 'mkp_contact_email_press', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_email_press', array(
        'label'       => __( 'Press/Media Email', 'mediakit-lite' ),
        'description' => __( 'Email for media inquiries, interview requests, and press kit requests. Can be same as primary or PR team email.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'type'        => 'email',
    ) );
    
    // Phone Number
    $wp_customize->add_setting( 'mkp_contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_phone', array(
        'label'       => __( 'Phone Number', 'mediakit-lite' ),
        'description' => __( 'Optional: Include country code for international reach (e.g., +1-555-123-4567). Consider if you want this public.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'type'        => 'tel',
    ) );
    
    // Address
    $wp_customize->add_setting( 'mkp_contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    
    $wp_customize->add_control( 'mkp_contact_address', array(
        'label'       => __( 'Address', 'mediakit-lite' ),
        'description' => __( 'Optional: Your business address or city/country for location reference. You can be as specific or general as you prefer.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'type'        => 'textarea',
    ) );
    
    // Booking Calendar Link
    $wp_customize->add_setting( 'mkp_booking_calendar_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'mkp_booking_calendar_link', array(
        'label'       => __( 'Booking Calendar Link', 'mediakit-lite' ),
        'description' => __( 'Direct link to your online scheduling tool (Calendly, Acuity, etc.). This enables instant booking for discovery calls or consultations.', 'mediakit-lite' ),
        'section'     => 'mkp_contact_info',
        'type'        => 'url',
    ) );
    
    /**
     * SEO Settings Section
     */
    $wp_customize->add_section( 'mkp_seo_settings', array(
        'title'       => __( 'SEO Settings', 'mediakit-lite' ),
        'priority'    => 60,
        'description' => __( 'Optimize how your media kit appears in search engines and social media. These settings help you get discovered by event planners and media professionals.', 'mediakit-lite' ),
    ) );
    
    // Default Meta Description
    $wp_customize->add_setting( 'mkp_default_meta_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    
    $wp_customize->add_control( 'mkp_default_meta_description', array(
        'label'       => __( 'Default Meta Description', 'mediakit-lite' ),
        'description' => __( 'A compelling 150-160 character description of who you are and what you offer. This appears in search results. Include keywords like "keynote speaker" or your expertise area.', 'mediakit-lite' ),
        'section'     => 'mkp_seo_settings',
        'type'        => 'textarea',
    ) );
    
    // Default Social Media Image
    $wp_customize->add_setting( 'mkp_default_social_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mkp_default_social_image', array(
        'label'       => __( 'Default Social Media Image', 'mediakit-lite' ),
        'description' => __( 'Image shown when your site is shared on social media. Use a professional photo or branded image at 1200x630 pixels for best results across all platforms.', 'mediakit-lite' ),
        'section'     => 'mkp_seo_settings',
        'settings'    => 'mkp_default_social_image',
    ) ) );
    
    // Enable Schema Markup
    $wp_customize->add_setting( 'mkp_enable_schema', array(
        'default'           => true,
        'sanitize_callback' => 'mkp_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_schema', array(
        'label'       => __( 'Enable Schema Markup', 'mediakit-lite' ),
        'description' => __( 'Adds structured data to help search engines understand your content better. This can lead to rich snippets in search results. Recommended to leave enabled.', 'mediakit-lite' ),
        'section'     => 'mkp_seo_settings',
        'type'        => 'checkbox',
    ) );
}
add_action( 'customize_register', 'mkp_customize_register' );

/**
 * Sanitize checkbox
 */
function mkp_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

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
 * Sanitize RGBA color
 */
function mkp_sanitize_rgba( $color ) {
    if ( empty( $color ) || is_array( $color ) ) {
        return 'rgba(0,0,0,0)';
    }
    
    if ( false === strpos( $color, 'rgba' ) ) {
        return sanitize_hex_color( $color );
    }
    
    $color = str_replace( ' ', '', $color );
    sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
    
    return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
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
    wp_enqueue_script( 'mkp-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array( 'customize-controls', 'jquery' ), MKP_THEME_VERSION, true );
    
    // Add localization
    wp_localize_script( 'mkp-customizer-controls', 'mkpCustomizer', array(
        'confirmReset' => __( 'Are you sure you want to reset all settings in this section to their defaults?', 'mediakit-lite' ),
    ) );
}
add_action( 'customize_controls_enqueue_scripts', 'mkp_customize_controls_js' );

/**
 * Add custom CSS based on Customizer settings
 */
function mkp_customizer_css() {
    $primary_color = get_theme_mod( 'mkp_primary_color', '#2c3e50' );
    $secondary_color = get_theme_mod( 'mkp_secondary_color', '#3498db' );
    $accent_color = get_theme_mod( 'mkp_accent_color', '#e74c3c' );
    $primary_font = get_theme_mod( 'mkp_primary_font', 'system' );
    $heading_font = get_theme_mod( 'mkp_heading_font', 'playfair' );
    $nav_font = get_theme_mod( 'mkp_nav_font', 'system' );
    $background_overlay_color = get_theme_mod( 'mkp_background_overlay_color', '#ffffff' );
    $background_overlay_opacity = get_theme_mod( 'mkp_background_overlay_opacity', '0' );
    
    // Font mapping
    $font_stacks = array(
        'system'    => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
        'inter'     => '"Inter", sans-serif',
        'roboto'    => '"Roboto", sans-serif',
        'opensans'  => '"Open Sans", sans-serif',
        'lato'      => '"Lato", sans-serif',
        'montserrat' => '"Montserrat", sans-serif',
        'playfair'  => '"Playfair Display", serif',
        'merriweather' => '"Merriweather", serif',
        'georgia'   => 'Georgia, "Times New Roman", serif',
        'poppins'   => '"Poppins", sans-serif',
        'raleway'   => '"Raleway", sans-serif',
    );
    
    $primary_font_stack = isset( $font_stacks[$primary_font] ) ? $font_stacks[$primary_font] : $font_stacks['system'];
    $heading_font_stack = isset( $font_stacks[$heading_font] ) ? $font_stacks[$heading_font] : $font_stacks['playfair'];
    $nav_font_stack = isset( $font_stacks[$nav_font] ) ? $font_stacks[$nav_font] : $font_stacks['system'];
    
    ?>
    <style type="text/css">
        :root {
            --mkp-primary: <?php echo esc_attr( $primary_color ); ?>;
            --mkp-secondary: <?php echo esc_attr( $secondary_color ); ?>;
            --mkp-accent: <?php echo esc_attr( $accent_color ); ?>;
            --mkp-font-primary: <?php echo esc_attr( $primary_font_stack ); ?>;
            --mkp-font-heading: <?php echo esc_attr( $heading_font_stack ); ?>;
            --mkp-font-nav: <?php echo esc_attr( $nav_font_stack ); ?>;
        }
        
        body {
            font-family: var(--mkp-font-primary);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--mkp-font-heading);
        }
        
        .mkp-nav,
        .mkp-nav__link {
            font-family: var(--mkp-font-nav);
        }
        
        /* Background overlay */
        <?php if ( $background_overlay_opacity > 0 && get_background_image() ) : ?>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: <?php echo esc_attr( $background_overlay_color ); ?>;
            opacity: <?php echo esc_attr( $background_overlay_opacity / 100 ); ?>;
            z-index: -1;
            pointer-events: none;
        }
        
        body {
            position: relative;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'mkp_customizer_css' );

/**
 * Load Google Fonts based on customizer settings
 */
function mkp_load_google_fonts() {
    $primary_font = get_theme_mod( 'mkp_primary_font', 'system' );
    $heading_font = get_theme_mod( 'mkp_heading_font', 'playfair' );
    $nav_font = get_theme_mod( 'mkp_nav_font', 'system' );
    
    $google_fonts = array(
        'inter'     => 'Inter:wght@300;400;500;600;700',
        'roboto'    => 'Roboto:wght@300;400;500;700',
        'opensans'  => 'Open+Sans:wght@300;400;600;700',
        'lato'      => 'Lato:wght@300;400;700',
        'montserrat' => 'Montserrat:wght@300;400;500;600;700',
        'playfair'  => 'Playfair+Display:wght@400;700',
        'merriweather' => 'Merriweather:wght@300;400;700',
        'poppins'   => 'Poppins:wght@300;400;500;600;700',
        'raleway'   => 'Raleway:wght@300;400;500;600;700',
    );
    
    $fonts_to_load = array();
    
    if ( isset( $google_fonts[$primary_font] ) ) {
        $fonts_to_load[] = $google_fonts[$primary_font];
    }
    
    if ( isset( $google_fonts[$heading_font] ) && $heading_font !== $primary_font ) {
        $fonts_to_load[] = $google_fonts[$heading_font];
    }
    
    if ( isset( $google_fonts[$nav_font] ) && $nav_font !== $primary_font && $nav_font !== $heading_font ) {
        $fonts_to_load[] = $google_fonts[$nav_font];
    }
    
    if ( ! empty( $fonts_to_load ) ) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $fonts_to_load ) . '&display=swap';
        wp_enqueue_style( 'mkp-google-fonts', $fonts_url, array(), null );
    }
}
add_action( 'wp_enqueue_scripts', 'mkp_load_google_fonts' );

/**
 * Migrate old rgba overlay values to new color/opacity format
 */
function mkp_migrate_overlay_settings() {
    // Check if migration has already been done
    if ( get_option( 'mkp_overlay_migration_done' ) ) {
        return;
    }
    
    // Migrate hero overlay
    $hero_overlay = get_theme_mod( 'mkp_hero_overlay_color' );
    if ( $hero_overlay && strpos( $hero_overlay, 'rgba' ) !== false ) {
        // Extract rgba values
        if ( preg_match( '/rgba\((\d+),\s*(\d+),\s*(\d+),\s*([\d\.]+)\)/', $hero_overlay, $matches ) ) {
            $r = intval( $matches[1] );
            $g = intval( $matches[2] );
            $b = intval( $matches[3] );
            $a = floatval( $matches[4] );
            
            // Convert to hex color
            $hex = sprintf( '#%02x%02x%02x', $r, $g, $b );
            set_theme_mod( 'mkp_hero_overlay_color', $hex );
            set_theme_mod( 'mkp_hero_overlay_opacity', round( $a * 100 ) );
        }
    }
    
    // Migrate background overlay
    $bg_overlay = get_theme_mod( 'mkp_background_overlay' );
    if ( $bg_overlay && strpos( $bg_overlay, 'rgba' ) !== false ) {
        // Extract rgba values
        if ( preg_match( '/rgba\((\d+),\s*(\d+),\s*(\d+),\s*([\d\.]+)\)/', $bg_overlay, $matches ) ) {
            $r = intval( $matches[1] );
            $g = intval( $matches[2] );
            $b = intval( $matches[3] );
            $a = floatval( $matches[4] );
            
            // Convert to hex color
            $hex = sprintf( '#%02x%02x%02x', $r, $g, $b );
            set_theme_mod( 'mkp_background_overlay_color', $hex );
            set_theme_mod( 'mkp_background_overlay_opacity', round( $a * 100 ) );
            
            // Remove old setting
            remove_theme_mod( 'mkp_background_overlay' );
        }
    }
    
    // Mark migration as done
    update_option( 'mkp_overlay_migration_done', true );
}
add_action( 'after_setup_theme', 'mkp_migrate_overlay_settings' );

/**
 * Migrate old profile image to new profile photo setting
 */
function mkp_migrate_profile_image_settings() {
    // Check if migration has already been done
    if ( get_option( 'mkp_profile_image_migration_done' ) ) {
        return;
    }
    
    // Get old profile image setting
    $old_profile_image = get_theme_mod( 'mkp_hero_profile_image' );
    
    // If old setting exists and new setting doesn't, migrate it
    if ( $old_profile_image && ! get_theme_mod( 'mkp_hero_profile_photo' ) ) {
        set_theme_mod( 'mkp_hero_profile_photo', $old_profile_image );
    }
    
    // Mark migration as done
    update_option( 'mkp_profile_image_migration_done', true );
}
add_action( 'after_setup_theme', 'mkp_migrate_profile_image_settings' );

/**
 * Custom Control: Reset Button
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
    class MKP_Reset_Control extends WP_Customize_Control {
        public $type = 'reset_button';
        
        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php endif; ?>
            <button type="button" class="button mkp-reset-section" data-section="<?php echo esc_attr( $this->section ); ?>">
                <?php esc_html_e( 'Reset Section to Defaults', 'mediakit-lite' ); ?>
            </button>
            <?php
        }
    }
}