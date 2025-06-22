<?php
/**
 * MediaKit Lite functions and definitions
 *
 * @package MediaKit_Lite
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Define Constants
 */
define( 'MKP_THEME_VERSION', '1.5.9' );
define( 'MKP_THEME_DIR', get_template_directory() );
define( 'MKP_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function mkp_theme_setup() {
    // Add theme support
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    
    
    // Add support for Block Styles
    add_theme_support( 'wp-block-styles' );
    
    // Add support for full and wide align images
    add_theme_support( 'align-wide' );
    
    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    
    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );
    
    
    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'mediakit-lite' ),
        'footer'  => esc_html__( 'Footer Menu', 'mediakit-lite' ),
        'social'  => esc_html__( 'Social Links Menu', 'mediakit-lite' ),
    ) );
    
    // Set content width
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }
}
add_action( 'after_setup_theme', 'mkp_theme_setup' );

/**
 * Register widget areas
 */
function mkp_widgets_init() {
    // Ensure we have valid widget area data
    $widget_areas = array(
        array(
            'name'          => esc_html__( 'Sidebar', 'mediakit-lite' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'mediakit-lite' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ),
        array(
            'name'          => esc_html__( 'Footer 1', 'mediakit-lite' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Footer widget area 1', 'mediakit-lite' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ),
        array(
            'name'          => esc_html__( 'Footer 2', 'mediakit-lite' ),
            'id'            => 'footer-2',
            'description'   => esc_html__( 'Footer widget area 2', 'mediakit-lite' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ),
        array(
            'name'          => esc_html__( 'Footer 3', 'mediakit-lite' ),
            'id'            => 'footer-3',
            'description'   => esc_html__( 'Footer widget area 3', 'mediakit-lite' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ),
    );
    
    // Register each widget area with proper error checking
    foreach ( $widget_areas as $widget_area ) {
        if ( ! empty( $widget_area['id'] ) && ! empty( $widget_area['name'] ) ) {
            register_sidebar( $widget_area );
        }
    }
}
add_action( 'widgets_init', 'mkp_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function mkp_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style( 'mediakit-lite-style', get_stylesheet_uri(), array(), MKP_THEME_VERSION );
    
    // Enqueue Google Fonts if needed
    wp_enqueue_style( 'mediakit-lite-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap', array(), null );
    
    // Enqueue main JavaScript
    wp_enqueue_script( 'mediakit-lite-script', MKP_THEME_URI . '/assets/js/main.js', array('jquery'), MKP_THEME_VERSION, true );
    
    // Localize script
    wp_localize_script( 'mediakit-lite-script', 'mkp_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'mkp_nonce' ),
    ) );
    
    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mkp_scripts' );



/**
 * Flush rewrite rules on theme activation
 */
function mkp_rewrite_flush() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'mkp_rewrite_flush' );

/**
 * Theme activation hook
 */
function mkp_theme_activation() {
    // Set flag for activation
    add_option( 'mkp_theme_activated', true );
    
}
add_action( 'after_switch_theme', 'mkp_theme_activation' );

/**
 * Theme deactivation cleanup
 */
function mkp_theme_deactivation() {
    // Clean up transients
    delete_transient( 'mkp_theme_activation' );
}
add_action( 'switch_theme', 'mkp_theme_deactivation' );

/**
 * Custom excerpt length
 */
function mkp_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'mkp_excerpt_length', 999 );

/**
 * Custom excerpt more
 */
function mkp_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'mkp_excerpt_more' );

/**
 * Add custom image sizes
 */
function mkp_add_image_sizes() {
    add_image_size( 'mkp-hero', 1920, 1080, true );
    add_image_size( 'mkp-portfolio', 600, 400, true );
    add_image_size( 'mkp-testimonial', 150, 150, true );
    add_image_size( 'mkp-press-logo', 200, 100, false );
}
add_action( 'after_setup_theme', 'mkp_add_image_sizes' );

/**
 * Include additional files
 */

// Error handling for debugging
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );
}

// Ensure all files exist before requiring them
$required_files = array(
    '/inc/auto-contrast.php',
    '/inc/bio-defaults.php',
    '/inc/customizer-helpers.php',
    '/inc/customizer-social-control.php',
    '/inc/customizer-widget-fix.php',
    '/inc/customizer.php',
    '/inc/customizer-dynamic-styles.php',
    '/inc/template-tags.php',
    '/inc/template-functions.php',
    '/inc/front-page-sections.php',
    '/inc/social-icons.php',
    '/inc/section-order.php',
    '/inc/field-helpers.php',
    '/inc/meta-boxes.php',
    '/inc/options-pages.php',
    '/inc/form-submissions.php',
    '/inc/update-notice.php',
    '/inc/blocks.php',
);

foreach ( $required_files as $file ) {
    $file_path = MKP_THEME_DIR . $file;
    if ( file_exists( $file_path ) ) {
        require_once $file_path;
    } else {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'MediaKit Lite: Missing required file: ' . $file_path );
        }
    }
}

// Admin customizations
if ( is_admin() ) {
    $admin_file = MKP_THEME_DIR . '/inc/admin-functions.php';
    if ( file_exists( $admin_file ) ) {
        require_once $admin_file;
    }
}

/**
 * Security: Sanitize upload file names
 */
function mkp_sanitize_upload_filename( $filename ) {
    $sanitized_filename = remove_accents( $filename );
    $sanitized_filename = preg_replace( '/[^a-zA-Z0-9._-]/', '', $sanitized_filename );
    $sanitized_filename = strtolower( $sanitized_filename );
    return $sanitized_filename;
}
add_filter( 'sanitize_file_name', 'mkp_sanitize_upload_filename', 10 );

/**
 * Add async/defer attributes to scripts
 */
function mkp_add_script_attributes( $tag, $handle ) {
    $scripts_to_defer = array( 'mediakit-lite-script' );
    
    foreach( $scripts_to_defer as $defer_script ) {
        if ( $defer_script === $handle ) {
            return str_replace( ' src', ' defer src', $tag );
        }
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'mkp_add_script_attributes', 10, 2 );

/**
 * Disable emojis for better performance
 */
function mkp_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'mkp_disable_emojis' );

/**
 * Add support for SVG uploads (with security checks)
 */
function mkp_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'mkp_mime_types' );

/**
 * Sanitize SVG uploads
 */
function mkp_sanitize_svg( $file ) {
    if ( $file['type'] === 'image/svg+xml' ) {
        $svg_content = file_get_contents( $file['tmp_name'] );
        
        // Basic SVG sanitization
        $svg_content = preg_replace( '/<script[\s\S]*?<\/script>/i', '', $svg_content );
        $svg_content = preg_replace( '/on\w+="[^"]*"/i', '', $svg_content );
        
        file_put_contents( $file['tmp_name'], $svg_content );
    }
    
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'mkp_sanitize_svg' );



/**
 * Add Open Graph meta tags
 */
function mkp_add_opengraph_tags() {
    global $post;
    
    if ( is_single() || is_page() ) {
        echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
        echo '<meta property="og:type" content="article" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url( get_permalink() ) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
        
        if ( has_post_thumbnail() ) {
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
            echo '<meta property="og:image" content="' . esc_url( $thumbnail[0] ) . '" />' . "\n";
        }
        
        if ( $post->post_excerpt ) {
            echo '<meta property="og:description" content="' . esc_attr( $post->post_excerpt ) . '" />' . "\n";
        }
    }
}
add_action( 'wp_head', 'mkp_add_opengraph_tags' );

/**
 * Schema markup helper function
 */
function mkp_schema_markup( $type = 'WebPage' ) {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => $type,
        'name' => get_the_title(),
        'url' => get_permalink(),
    );
    
    if ( has_post_thumbnail() ) {
        $schema['image'] = get_the_post_thumbnail_url( null, 'large' );
    }
    
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}

// Body classes are handled in inc/template-functions.php

/**
 * Custom walker for navigation
 */
class Mkp_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"mkp-nav__submenu\">\n";
    }
    
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'mkp-nav__item';
        
        if ( in_array( 'current-menu-item', $classes ) ) {
            $classes[] = 'mkp-nav__item--active';
        }
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        
        $output .= $indent . '<li' . $class_names .'>';
        
        $attributes = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="mkp-nav__link"';
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}