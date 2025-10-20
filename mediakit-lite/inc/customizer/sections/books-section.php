<?php
/**
 * Books Section Customizer Settings
 *
 * @package MediaKit_Lite
 */

/**
 * Register Books Section customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mkp_register_books_section( $wp_customize ) {
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
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'mkp_enable_section_books', array(
        'label'       => __( 'Enable Books Section', 'mediakit-lite' ),
        'description' => __( 'Show or hide the books section on your landing page.', 'mediakit-lite' ),
        'section'     => 'mkp_books_section',
        'type'        => 'checkbox',
        'priority'    => 1,
    ) );
    
    // Section Title
    $wp_customize->add_setting( 'mkp_books_section_title', array(
        'default'           => __( 'Publications', 'mediakit-lite' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_books_section_title', array(
        'label'           => __( 'Section Title', 'mediakit-lite' ),
        'section'         => 'mkp_books_section',
        'type'            => 'text',
        'priority'        => 2,
    ) );
    
    // Text Alignment Setting
    $wp_customize->add_setting( 'mkp_books_text_align', array(
        'default'           => 'left',
        'sanitize_callback' => 'mkp_sanitize_select',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'mkp_books_text_align', array(
        'label'       => __( 'Text Alignment', 'mediakit-lite' ),
        'description' => __( 'Choose how book descriptions should be aligned', 'mediakit-lite' ),
        'section'     => 'mkp_books_section',
        'type'        => 'select',
        'priority'    => 3,
        'choices'     => array(
            'left'    => __( 'Left Aligned', 'mediakit-lite' ),
            'justify' => __( 'Justified', 'mediakit-lite' ),
        ),
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
    
    // Book entries (up to 6)
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
}