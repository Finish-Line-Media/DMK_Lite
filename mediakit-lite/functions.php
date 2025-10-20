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

// Log theme activation start
if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
    error_log( '[MediaKit] Functions.php loaded at ' . date( 'Y-m-d H:i:s' ) );
    
    // Log WordPress context
    $context = array(
        'doing_ajax' => defined( 'DOING_AJAX' ) && DOING_AJAX,
        'doing_cron' => defined( 'DOING_CRON' ) && DOING_CRON,
        'wp_installing' => function_exists( 'wp_installing' ) ? wp_installing() : 'unknown',
        'is_admin' => function_exists( 'is_admin' ) ? is_admin() : 'unknown',
        'current_theme' => get_option( 'stylesheet' ),
        'current_template' => get_option( 'template' ),
    );
    error_log( '[MediaKit] Load context: ' . json_encode( $context ) );
}

// Emergency shutdown detection
if ( get_transient( 'mkp_theme_loading' ) ) {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] [ERROR] [EMERGENCY] Previous theme load did not complete properly - possible crash detected!' );
        error_log( '[MediaKit] [ERROR] Theme was loading but shutdown hook never fired' );
    }
    delete_transient( 'mkp_theme_loading' );
}

/**
 * Define Constants
 */
define( 'MKP_THEME_VERSION', '2.0.6' );
define( 'MKP_THEME_DIR', get_template_directory() );
define( 'MKP_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function mkp_theme_setup() {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] Theme setup function called' );
    }
    
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
    
    // Add support for customizer selective refresh
    add_theme_support( 'customize-selective-refresh-widgets' );
    
    // Navigation menus are not used in this theme
    // The theme uses a dynamic navigation system based on front page sections
    
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
    // Register sidebar widget area
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'mediakit-lite' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog pages.', 'mediakit-lite' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'mkp_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function mkp_scripts() {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] mkp_scripts function called' );
    }
    
    // Enqueue main stylesheet
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] About to enqueue stylesheet' );
        error_log( '[MediaKit] Stylesheet URI: ' . MKP_THEME_URI . '/style.css' );
    }
    wp_enqueue_style( 'mediakit-lite-style', MKP_THEME_URI . '/style.css', array(), MKP_THEME_VERSION );
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] Stylesheet enqueued successfully' );
    }
    
    // Enqueue Google Fonts based on selected fonts
    $body_font = get_theme_mod( 'mkp_body_font', 'system' );
    $heading_font = get_theme_mod( 'mkp_heading_font', 'system' );
    $nav_font = get_theme_mod( 'mkp_nav_font', 'system' );
    
    $google_fonts = array();
    $font_weights = array(
        'inter' => 'Inter:wght@300;400;500;600;700',
        'roboto' => 'Roboto:wght@300;400;500;700',
        'opensans' => 'Open+Sans:wght@300;400;600;700',
        'lato' => 'Lato:wght@300;400;700;900',
        'montserrat' => 'Montserrat:wght@300;400;500;600;700',
        'playfair' => 'Playfair+Display:wght@400;700',
        'merriweather' => 'Merriweather:wght@300;400;700',
        'poppins' => 'Poppins:wght@300;400;500;600;700',
        'raleway' => 'Raleway:wght@300;400;500;600;700',
    );
    
    // Add selected fonts to the array
    foreach ( array( $body_font, $heading_font, $nav_font ) as $font ) {
        if ( $font !== 'system' && $font !== 'georgia' && isset( $font_weights[ $font ] ) ) {
            $google_fonts[ $font ] = $font_weights[ $font ];
        }
    }
    
    // Build Google Fonts URL if we have any non-system fonts
    if ( ! empty( $google_fonts ) ) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', array_values( $google_fonts ) ) . '&display=swap';
        wp_enqueue_style( 'mediakit-lite-fonts', $fonts_url, array(), null );
    }
    
    // Enqueue Dashicons for frontend use
    wp_enqueue_style( 'dashicons' );
    
    // Enqueue main JavaScript
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] About to enqueue script' );
        error_log( '[MediaKit] Script URI: ' . MKP_THEME_URI . '/assets/js/main.js' );
    }
    wp_enqueue_script( 'mediakit-lite-script', MKP_THEME_URI . '/assets/js/main.js', array('jquery'), MKP_THEME_VERSION, true );
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] Script enqueued successfully' );
    }
    
    // Localize script
    wp_localize_script( 'mediakit-lite-script', 'mkp_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'mkp_nonce' ),
    ) );
    
    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    
    // Gallery lightbox script - only on front page if gallery is enabled
    if ( is_front_page() && get_theme_mod( 'mkp_enable_section_gallery', false ) && mkp_has_gallery_images() ) {
        wp_enqueue_script( 'mediakit-lite-gallery', MKP_THEME_URI . '/assets/js/gallery-lightbox.js', array( 'masonry', 'imagesloaded' ), MKP_THEME_VERSION, true );
    }
    
    // Media masonry script - DISABLED - using CSS Grid instead
    // if ( is_front_page() && get_theme_mod( 'mkp_enable_section_in_the_media', false ) && mkp_has_media_items() ) {
    //     wp_enqueue_script( 'mediakit-lite-media-masonry', MKP_THEME_URI . '/assets/js/media-masonry.js', array( 'masonry', 'imagesloaded' ), MKP_THEME_VERSION, true );
    // }
    
    // Books masonry script - only on front page if books section is enabled
    if ( is_front_page() && get_theme_mod( 'mkp_enable_section_books', false ) && mkp_has_books() ) {
        wp_enqueue_script( 'mediakit-lite-books-masonry', MKP_THEME_URI . '/assets/js/books-masonry.js', array( 'masonry', 'imagesloaded' ), MKP_THEME_VERSION, true );
    }
    
    // Podcasts masonry script - only on front page if podcasts section is enabled
    if ( is_front_page() && get_theme_mod( 'mkp_enable_section_podcasts', false ) && mkp_has_podcasts() ) {
        wp_enqueue_script( 'mediakit-lite-podcasts-masonry', MKP_THEME_URI . '/assets/js/podcasts-masonry.js', array( 'masonry', 'imagesloaded' ), MKP_THEME_VERSION, true );
    }
    
    // Universal masonry card height control - load on front page if any masonry sections exist
    if ( is_front_page() && ( 
        ( get_theme_mod( 'mkp_enable_section_books', false ) && mkp_has_books() ) ||
        ( get_theme_mod( 'mkp_enable_section_podcasts', false ) && mkp_has_podcasts() ) ||
        ( get_theme_mod( 'mkp_enable_section_gallery', false ) && mkp_has_gallery_images() ) ||
        ( get_theme_mod( 'mkp_enable_section_testimonials', false ) && mkp_has_testimonials() ) ||
        ( get_theme_mod( 'mkp_enable_section_awards', false ) && mkp_has_awards() ) ||
        ( get_theme_mod( 'mkp_enable_section_investor', false ) && mkp_has_investors() )
    ) ) {
        wp_enqueue_script( 'mediakit-lite-masonry-cards', MKP_THEME_URI . '/assets/js/masonry-cards.js', array(), MKP_THEME_VERSION, true );
    }
    
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] mkp_scripts function completed' );
    }
}
add_action( 'wp_enqueue_scripts', 'mkp_scripts' );

// Add early shutdown hook right after wp_enqueue_scripts
add_action('shutdown', function() {
    error_log('[MediaKit] Shutdown - Current theme: ' . get_option('stylesheet'));
    error_log('[MediaKit] Shutdown - Template: ' . get_option('template'));
}, 1); // Priority 1 to run early

// Monitor all theme-related actions
// DISABLED - Too verbose, creating excessive log entries
/*
add_action('all', function($tag) {
    if (strpos($tag, 'theme') !== false || strpos($tag, 'switch') !== false) {
        error_log('[MediaKit] Action fired: ' . $tag);
    }
});
*/


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
    mkp_log_theme_event( 'ACTIVATION', 'Theme activation function called' );
    
    // Verify theme is actually active
    $current_theme = wp_get_theme();
    $verification_data = array(
        'current_theme_name' => $current_theme->get( 'Name' ),
        'current_theme_template' => $current_theme->get_template(),
        'theme_root' => get_theme_root(),
        'stylesheet_directory' => get_stylesheet_directory(),
        'template_directory' => get_template_directory(),
        'files_exist' => array(
            'style.css' => file_exists( get_stylesheet_directory() . '/style.css' ),
            'functions.php' => file_exists( get_stylesheet_directory() . '/functions.php' ),
            'index.php' => file_exists( get_stylesheet_directory() . '/index.php' ),
        ),
    );
    
    mkp_log_theme_event( 'ACTIVATION_VERIFY', 'Verifying theme activation', $verification_data );
    
    // Set emergency shutdown detection flag
    set_transient( 'mkp_theme_loading', true, 300 ); // 5 minutes
    
    // Check if we've already run the setup
    if ( get_option( 'mkp_theme_setup_complete' ) ) {
        mkp_log_theme_event( 'ACTIVATION', 'Theme setup already complete, skipping initialization' );
        return;
    }
    
    // Check if user already has a static front page configured
    if ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) {
        // User already has configuration, just mark as complete
        update_option( 'mkp_theme_setup_complete', true );
        return;
    }
    
    // Create default pages
    $home_page_id = 0;
    $blog_page_id = 0;
    
    // Check if a page called "Home" already exists
    $home_page = get_page_by_title( 'Home' );
    if ( ! $home_page ) {
        // Create Home page
        $home_page_id = wp_insert_post( array(
            'post_title'    => 'Home',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'comment_status' => 'closed',
            'ping_status'   => 'closed',
        ) );
    } else {
        $home_page_id = $home_page->ID;
    }
    
    // Check if a page called "Blog" already exists
    $blog_page = get_page_by_title( 'Blog' );
    if ( ! $blog_page ) {
        // Create Blog page
        $blog_page_id = wp_insert_post( array(
            'post_title'    => 'Blog',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'comment_status' => 'closed',
            'ping_status'   => 'closed',
        ) );
    } else {
        $blog_page_id = $blog_page->ID;
    }
    
    // Configure reading settings if pages were created successfully
    if ( $home_page_id && $blog_page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $home_page_id );
        update_option( 'page_for_posts', $blog_page_id );
    }
    
    // Mark setup as complete
    update_option( 'mkp_theme_setup_complete', true );
    
    // Set flag for activation
    add_option( 'mkp_theme_activated', true );
}
add_action( 'after_switch_theme', 'mkp_theme_activation' );

/**
 * Dedicated logging function for theme events
 */
function mkp_log_theme_event( $event_type, $message, $data = array(), $level = 'info' ) {
    if ( ! defined( 'WP_DEBUG_LOG' ) || ! WP_DEBUG_LOG ) {
        return;
    }
    
    $timestamp = date( 'Y-m-d H:i:s' );
    $memory = round( memory_get_usage() / 1024 / 1024, 2 ) . 'MB';
    $peak_memory = round( memory_get_peak_usage() / 1024 / 1024, 2 ) . 'MB';
    
    // Build log entry
    $log_entry = sprintf(
        '[MediaKit] [%s] [%s] %s | Memory: %s (Peak: %s)',
        strtoupper( $level ),
        $event_type,
        $message,
        $memory,
        $peak_memory
    );
    
    error_log( $log_entry );
    
    // Log additional data if provided
    if ( ! empty( $data ) ) {
        error_log( '[MediaKit] Additional data: ' . print_r( $data, true ) );
    }
    
    // Log context information
    $context = array(
        'user_id' => get_current_user_id(),
        'is_admin' => is_admin(),
        'is_customizer' => is_customize_preview(),
        'is_ajax' => wp_doing_ajax(),
        'is_cron' => wp_doing_cron(),
        'current_url' => isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : 'N/A',
    );
    
    error_log( '[MediaKit] Context: ' . print_r( $context, true ) );
}

/**
 * Theme deactivation cleanup
 */
function mkp_theme_deactivation() {
    mkp_log_theme_event( 'DEACTIVATION', 'Theme deactivation cleanup running' );
    
    // Clean up transients
    delete_transient( 'mkp_theme_activation' );
}
add_action( 'switch_theme', 'mkp_theme_deactivation' );

/**
 * Enhanced theme switching logging
 */
add_action( 'switch_theme', function( $new_name, $new_theme, $old_theme ) {
    // Get active plugins
    $active_plugins = get_option( 'active_plugins', array() );
    $plugin_names = array();
    
    // Only try to get plugin data if we're in admin context where plugin.php is loaded
    if ( function_exists( 'get_plugin_data' ) ) {
        foreach ( $active_plugins as $plugin ) {
            $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin, false, false );
            $plugin_names[] = $plugin_data['Name'] . ' (' . $plugin . ')';
        }
    } else {
        // If get_plugin_data isn't available, just list the plugin files
        $plugin_names = $active_plugins;
    }
    
    // Capture request data safely
    $request_data = array(
        'method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'None',
    );
    
    // Check for customizer context
    $customizer_data = array();
    if ( isset( $_POST['customize_changeset_uuid'] ) ) {
        $customizer_data['changeset_uuid'] = sanitize_text_field( $_POST['customize_changeset_uuid'] );
    }
    if ( isset( $_POST['customize_theme'] ) ) {
        $customizer_data['customize_theme'] = sanitize_text_field( $_POST['customize_theme'] );
    }
    if ( isset( $_POST['action'] ) ) {
        $customizer_data['action'] = sanitize_text_field( $_POST['action'] );
    }
    
    $switch_data = array(
        'old_theme' => array(
            'name' => $old_theme->get( 'Name' ),
            'version' => $old_theme->get( 'Version' ),
            'template' => $old_theme->get_template(),
            'stylesheet' => $old_theme->get_stylesheet(),
        ),
        'new_theme' => array(
            'name' => $new_name,
            'object' => is_object( $new_theme ) ? get_class( $new_theme ) : 'Not an object',
        ),
        'active_plugins' => $plugin_names,
        'request_data' => $request_data,
        'customizer_data' => $customizer_data,
        'user_capability' => current_user_can( 'switch_themes' ) ? 'Can switch themes' : 'Cannot switch themes',
    );
    
    mkp_log_theme_event( 'THEME_SWITCH', "Switching from {$old_theme->get('Name')} to {$new_name}", $switch_data, 'warning' );
    
    // Log simplified backtrace
    $backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 15 );
    $simplified_trace = array();
    foreach ( $backtrace as $index => $trace ) {
        $simplified_trace[] = sprintf(
            '#%d %s%s%s() called at [%s:%s]',
            $index,
            $trace['class'] ?? '',
            $trace['type'] ?? '',
            $trace['function'] ?? 'Unknown',
            $trace['file'] ?? 'Unknown',
            $trace['line'] ?? '0'
        );
    }
    mkp_log_theme_event( 'THEME_SWITCH_TRACE', 'Backtrace', array( 'trace' => $simplified_trace ), 'info' );
}, 5, 3 );

/**
 * Enhanced theme switching log with backtrace
 */
add_action('switch_theme', function($new_name, $new_theme, $old_theme) {
    error_log(sprintf(
        "[THEME_SWITCH] From '%s' to '%s' at %s | Stack: %s",
        $old_theme->get('Name'),
        $new_name,
        current_time('mysql'),
        wp_debug_backtrace_summary()
    ));
}, 10, 3);

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

// Load customizer preview safety first
$safety_file = MKP_THEME_DIR . '/inc/customizer-preview-safety.php';
if ( file_exists( $safety_file ) ) {
    require_once $safety_file;
}

// Ensure all files exist before requiring them
$required_files = array(
    '/inc/about-defaults.php',
    '/inc/customizer-components.php',
    '/inc/customizer-social-control.php',
    '/inc/customizer-widget-fix.php',
    '/inc/color-themes.php',
    '/inc/theme-color-manager.php',
    '/inc/customizer/customizer-main.php',
    '/inc/customizer-dynamic-styles.php',
    '/inc/template-tags.php',
    '/inc/template-functions.php',
    '/inc/front-page-sections.php',
    '/inc/social-icon-svgs.php',
    '/inc/section-order.php',
    '/inc/form-submissions.php',
    '/inc/update-notice.php',
    '/inc/blocks.php',
);

foreach ( $required_files as $file ) {
    $file_path = MKP_THEME_DIR . $file;
    if ( file_exists( $file_path ) ) {
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( '[MediaKit] Loading file: ' . $file );
        }
        require_once $file_path;
    } else {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( '[MediaKit] Missing required file: ' . $file_path );
        }
    }
}

// Admin customizations - use safety check to prevent loading in preview
if ( function_exists( 'mkp_should_load_admin_functions' ) && mkp_should_load_admin_functions() ) {
    $admin_file = MKP_THEME_DIR . '/inc/admin-functions.php';
    if ( file_exists( $admin_file ) ) {
        require_once $admin_file;
    }
} elseif ( is_admin() && ! is_customize_preview() ) {
    // Fallback if safety function not available
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
 * Output alignment styles directly in head to ensure they work
 * This fixes issues with @import statements not loading on some servers
 */
function mkp_output_alignment_styles() {
    ?>
    <style id="mkp-alignment-overrides">
    /* Text alignment overrides to ensure customizer settings work */
    .mkp-text-align-left,
    .mkp-text-align-left p,
    .mkp-text-align-left li,
    .mkp-text-align-left blockquote {
        text-align: left !important;
    }
    .mkp-text-align-justify,
    .mkp-text-align-justify p,
    .mkp-text-align-justify li,
    .mkp-text-align-justify blockquote {
        text-align: justify !important;
        text-justify: inter-word !important;
    }
    </style>
    <?php
}
add_action( 'wp_head', 'mkp_output_alignment_styles', 999 );

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

/**
 * Add responsive wrapper to oEmbed content with provider detection
 *
 * @param string $html The returned oEmbed HTML
 * @param string $url  URL of the content to be embedded
 * @param array  $attr An array of shortcode attributes
 * @param int    $post_id Post ID
 * @return string Modified embed HTML
 */
function mkp_wrap_oembed_html( $html, $url, $attr, $post_id ) {
    if ( empty( $html ) ) {
        return $html;
    }
    
    $classes = array( 'mkp-embed-responsive' );
    
    // Detect provider and add specific class
    if ( false !== strpos( $url, 'youtube.com' ) || false !== strpos( $url, 'youtu.be' ) ) {
        $classes[] = 'mkp-embed--youtube';
    } elseif ( false !== strpos( $url, 'vimeo.com' ) ) {
        $classes[] = 'mkp-embed--vimeo';
    } elseif ( false !== strpos( $url, 'spotify.com' ) ) {
        $classes[] = 'mkp-embed--spotify';
    } elseif ( false !== strpos( $url, 'twitter.com' ) || false !== strpos( $url, 'x.com' ) ) {
        $classes[] = 'mkp-embed--twitter';
    } elseif ( false !== strpos( $url, 'instagram.com' ) ) {
        $classes[] = 'mkp-embed--instagram';
    } elseif ( false !== strpos( $url, 'tiktok.com' ) ) {
        $classes[] = 'mkp-embed--tiktok';
    } elseif ( false !== strpos( $url, 'facebook.com' ) ) {
        $classes[] = 'mkp-embed--facebook';
    } else {
        // Generic video class for unknown providers
        if ( preg_match( '/<iframe|<video/', $html ) ) {
            $classes[] = 'mkp-embed--video';
        }
    }
    
    $classes_string = implode( ' ', $classes );
    
    return '<div class="' . esc_attr( $classes_string ) . '">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'mkp_wrap_oembed_html', 10, 4 );

// Log completion of functions.php loading
if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
    error_log( '[MediaKit] Functions.php completed loading' );
}

// Register shutdown function to clear emergency flag and log shutdown
register_shutdown_function( function() {
    // Log normal shutdown
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        $shutdown_data = array(
            'memory_usage' => round( memory_get_usage() / 1024 / 1024, 2 ) . 'MB',
            'peak_memory' => round( memory_get_peak_usage() / 1024 / 1024, 2 ) . 'MB',
            'execution_time' => defined( 'WP_START_TIMESTAMP' ) ? round( microtime( true ) - WP_START_TIMESTAMP, 3 ) . 's' : 'unknown',
        );
        error_log( '[MediaKit] [INFO] [SHUTDOWN] Theme shutdown initiated | ' . json_encode( $shutdown_data ) );
    }
    
    // Clear the emergency detection flag
    delete_transient( 'mkp_theme_loading' );
    
    // Check for fatal errors
    $error = error_get_last();
    if ( $error && in_array( $error['type'], array( E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR ), true ) ) {
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( '[MediaKit] [ERROR] [SHUTDOWN] Fatal error detected: ' . print_r( $error, true ) );
        }
    } else {
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( '[MediaKit] [INFO] [SHUTDOWN] Clean shutdown completed' );
        }
    }
} );

// Add action logging for key WordPress hooks
add_action( 'init', function() {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] Init action fired' );
    }
}, 1 );

add_action( 'wp', function() {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] WP action fired' );
    }
}, 1 );

add_action( 'template_redirect', function() {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] Template redirect fired' );
    }
}, 1 );

// Customizer-specific logging
add_action( 'customize_register', function( $wp_customize ) {
    mkp_log_theme_event( 'CUSTOMIZER', 'Customize register action fired' );
}, 1 );

add_action( 'customize_preview_init', function() {
    mkp_log_theme_event( 'CUSTOMIZER', 'Entering customizer preview mode' );
} );

add_action( 'customize_controls_init', function() {
    mkp_log_theme_event( 'CUSTOMIZER', 'Customizer controls initializing' );
} );

add_action( 'customize_save_after', function( $wp_customize ) {
    $data = array(
        'changeset_uuid' => $wp_customize->changeset_uuid(),
        'changeset_status' => $wp_customize->changeset_post_id() ? get_post_status( $wp_customize->changeset_post_id() ) : 'none',
    );
    mkp_log_theme_event( 'CUSTOMIZER', 'Customizer saved', $data );
} );


// Monitor theme validation process
add_filter( 'validate_current_theme', function( $validate ) {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        // Log the initial value we received
        error_log( '[MediaKit] [INFO] [THEME_VALIDATION] Filter called with initial value: ' . ( $validate ? 'true' : 'false' ) );
        
        // Only log details, don't interfere with validation
        $current_theme = wp_get_theme();
        $validation_data = array(
            'input_value' => $validate,
            'theme_name' => $current_theme->get( 'Name' ),
            'theme_exists' => $current_theme->exists(),
            'theme_errors' => $current_theme->errors() ? $current_theme->errors()->get_error_messages() : 'none',
            'parent_theme' => $current_theme->parent() ? $current_theme->parent()->get( 'Name' ) : 'none',
            'theme_root' => get_theme_root(),
            'stylesheet' => get_option( 'stylesheet' ),
            'template' => get_option( 'template' ),
            'files_check' => array(
                'style.css' => file_exists( get_stylesheet_directory() . '/style.css' ),
                'index.php' => file_exists( get_stylesheet_directory() . '/index.php' ),
                'functions.php' => file_exists( get_stylesheet_directory() . '/functions.php' ),
            ),
        );
        
        mkp_log_theme_event( 'THEME_VALIDATION', 'Validation filter processing', $validation_data );
        
        // Check for other filters that might be interfering
        global $wp_filter;
        if ( isset( $wp_filter['validate_current_theme'] ) ) {
            $filter_count = count( $wp_filter['validate_current_theme']->callbacks );
            error_log( '[MediaKit] Total filters on validate_current_theme: ' . $filter_count );
        }
        
        // If WordPress is telling us not to validate, log why
        if ( ! $validate ) {
            error_log( '[MediaKit] [WARNING] WordPress passed false to validate_current_theme filter' );
            error_log( '[MediaKit] This means WordPress wants to skip validation, not that validation failed' );
            
            // Log backtrace to understand why
            $backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
            $trace_summary = array();
            foreach ( $backtrace as $i => $trace ) {
                if ( $i > 5 ) break;
                $trace_summary[] = sprintf(
                    '#%d %s%s%s()',
                    $i,
                    isset( $trace['class'] ) ? $trace['class'] : '',
                    isset( $trace['type'] ) ? $trace['type'] : '',
                    isset( $trace['function'] ) ? $trace['function'] : 'unknown'
                );
            }
            error_log( '[MediaKit] Called from: ' . implode( ' -> ', $trace_summary ) );
        }
    }
    
    // IMPORTANT: Always return the original value unchanged
    return $validate;
}, 999, 1 ); // Use high priority to run last

// Track theme-related option changes
add_action( 'updated_option', function( $option_name, $old_value, $value ) {
    // List of theme-related options to monitor
    $theme_options = array(
        'template',           // Parent theme
        'stylesheet',         // Child theme or current theme
        'current_theme',      // Theme name
        'theme_switched',     // Theme switch tracking
        'theme_mods_' . get_option( 'stylesheet' ), // Theme modifications
    );
    
    if ( in_array( $option_name, $theme_options, true ) || strpos( $option_name, 'theme_mods_' ) === 0 ) {
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( '[MediaKit] [WARNING] [OPTION_CHANGE] Theme-related option changed: ' . $option_name );
            error_log( '[MediaKit] OLD VALUE: ' . print_r( $old_value, true ) );
            error_log( '[MediaKit] NEW VALUE: ' . print_r( $value, true ) );
            
            // Get simplified backtrace
            $backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
            $trace_summary = array();
            foreach ( $backtrace as $i => $trace ) {
                $trace_summary[] = sprintf(
                    '#%d %s%s%s() in %s:%d',
                    $i,
                    isset( $trace['class'] ) ? $trace['class'] : '',
                    isset( $trace['type'] ) ? $trace['type'] : '',
                    isset( $trace['function'] ) ? $trace['function'] : 'unknown',
                    isset( $trace['file'] ) ? basename( $trace['file'] ) : 'unknown',
                    isset( $trace['line'] ) ? $trace['line'] : 0
                );
            }
            error_log( '[MediaKit] BACKTRACE: ' . implode( ' -> ', $trace_summary ) );
            
            // Additional context
            $context = array(
                'is_admin' => is_admin(),
                'is_customizer' => is_customize_preview(),
                'user_can_switch' => current_user_can( 'switch_themes' ),
                'doing_ajax' => wp_doing_ajax(),
                'current_action' => current_action(),
            );
            error_log( '[MediaKit] CONTEXT: ' . json_encode( $context ) );
        }
    }
}, 10, 3 );

// Also monitor when options are added (in case of first-time setup)
add_action( 'added_option', function( $option_name, $value ) {
    $theme_options = array( 'template', 'stylesheet', 'current_theme' );
    
    if ( in_array( $option_name, $theme_options, true ) ) {
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( '[MediaKit] [INFO] [OPTION_ADD] Theme option added: ' . $option_name . ' = ' . print_r( $value, true ) );
        }
    }
}, 10, 2 );

/**
 * JavaScript/AJAX Theme Switch Detection
 */
add_action('admin_footer-themes.php', function() {
    ?>
    <script>
    console.log('[MediaKit] Theme monitoring active');
    
    // Monitor all AJAX requests
    const originalSend = XMLHttpRequest.prototype.send;
    XMLHttpRequest.prototype.send = function(data) {
        console.log('[MediaKit] AJAX Request:', this.responseURL, data);
        
        // Log theme-related requests
        if (data && (data.toString().includes('switch') || data.toString().includes('theme'))) {
            console.error('[MediaKit] Theme-related AJAX data:', data);
        }
        
        this.addEventListener('load', function() {
            // Log ALL heartbeat responses
            if (data && data.toString().includes('heartbeat')) {
                console.log('[MediaKit] Heartbeat response:', this.responseText);
            }
            
            // Check for theme switches
            if (this.responseText && (this.responseText.includes('switch') || this.responseText.includes('theme'))) {
                console.error('[MediaKit] Theme-related AJAX response:', this.responseText.substring(0, 500));
            }
        });
        
        originalSend.apply(this, arguments);
    };
    
    // Monitor fetch requests
    const originalFetch = window.fetch;
    window.fetch = function(...args) {
        console.log('[MediaKit] Fetch request:', args);
        
        // Check if request body contains theme-related data
        if (args[1] && args[1].body) {
            const body = args[1].body.toString();
            if (body.includes('switch') || body.includes('theme')) {
                console.error('[MediaKit] Theme-related fetch body:', body);
            }
        }
        
        return originalFetch.apply(this, args).then(response => {
            // Clone response to read it without consuming
            const cloned = response.clone();
            cloned.text().then(text => {
                if (text.includes('switch') || text.includes('theme')) {
                    console.error('[MediaKit] Theme-related fetch response:', text.substring(0, 500));
                }
            });
            return response;
        });
    };
    
    // Monitor theme state every second
    let currentTheme = '<?php echo get_option('stylesheet'); ?>';
    setInterval(function() {
        // Check if theme has changed in DOM
        const activeTheme = document.querySelector('.theme.active');
        if (activeTheme) {
            const themeName = activeTheme.getAttribute('data-slug');
            if (themeName && themeName !== currentTheme) {
                console.error('[MediaKit] Theme changed in DOM!', 'From:', currentTheme, 'To:', themeName);
                currentTheme = themeName;
            }
        }
    }, 1000);
    
    // Monitor localStorage/sessionStorage
    const storageProxy = function(storage, name) {
        const original = storage.setItem;
        storage.setItem = function(key, value) {
            if (key.includes('theme') || value.includes('theme')) {
                console.error('[MediaKit] ' + name + ' theme-related:', key, value);
            }
            original.apply(this, arguments);
        };
    };
    
    storageProxy(localStorage, 'localStorage');
    storageProxy(sessionStorage, 'sessionStorage');
    
    // Heartbeat monitoring disabled - was causing excessive logging
    </script>
    <?php
});

/**
 * Database Theme Reference Check
 */
function mkp_check_theme_references() {
    global $wpdb;
    
    // Check for any options containing theme references
    $results = $wpdb->get_results(
        "SELECT option_name, option_value 
         FROM {$wpdb->options} 
         WHERE (option_value LIKE '%twentytwenty%' 
            OR option_value LIKE '%theme%switch%'
            OR option_value LIKE '%switch%theme%')
         AND option_name NOT LIKE '%transient%'
         LIMIT 20"
    );
    
    if ( ! empty( $results ) && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( '[MediaKit] [DB_CHECK] Found theme references in database:' );
        foreach ( $results as $row ) {
            $value_preview = substr( $row->option_value, 0, 200 );
            error_log( '[MediaKit] [DB_CHECK] ' . $row->option_name . ' => ' . $value_preview );
        }
    }
    
    // Also check specific theme options
    $theme_options = array(
        'template' => get_option( 'template' ),
        'stylesheet' => get_option( 'stylesheet' ),
        'current_theme' => get_option( 'current_theme' ),
        'theme_switched' => get_option( 'theme_switched' ),
    );
    
    error_log( '[MediaKit] [DB_CHECK] Current theme options: ' . json_encode( $theme_options ) );
}

// Run database check on specific actions
add_action( 'after_switch_theme', 'mkp_check_theme_references' );
add_action( 'admin_init', function() {
    // Check once per admin session
    if ( ! get_transient( 'mkp_db_check_done' ) ) {
        mkp_check_theme_references();
        set_transient( 'mkp_db_check_done', true, HOUR_IN_SECONDS );
    }
} );

/**
 * Enhanced AJAX Action Logging
 */
add_action( 'admin_init', function() {
    // Log all AJAX actions
    if ( wp_doing_ajax() && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        $action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'unknown';
        
        // Log theme-related AJAX actions
        if ( strpos( $action, 'theme' ) !== false || strpos( $action, 'switch' ) !== false ) {
            error_log( '[MediaKit] [AJAX] Theme-related action: ' . $action );
            error_log( '[MediaKit] [AJAX] Request data: ' . json_encode( $_REQUEST ) );
        }
    }
} );

/**
 * Heartbeat API Monitoring - DISABLED
 * Commented out to reduce excessive logging
 */
/*
add_filter('heartbeat_received', function($response, $data) {
    error_log('[MediaKit] Heartbeat received on themes page: ' . json_encode($data));
    error_log('[MediaKit] Heartbeat response: ' . json_encode($response));
    error_log('[MediaKit] Current theme at heartbeat: ' . get_option('stylesheet'));
    return $response;
}, 10, 2);
*/

/**
 * Debug theme availability check
 */
add_action( 'after_setup_theme', function() {
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        $theme = wp_get_theme();
        $parent = $theme->parent();
        
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Current theme: ' . $theme->get('Name') );
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Theme exists: ' . ( $theme->exists() ? 'yes' : 'no' ) );
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Theme errors: ' . ( $theme->errors() ? json_encode( $theme->errors()->get_error_messages() ) : 'none' ) );
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Parent theme: ' . ( $parent ? $parent->get('Name') : 'none' ) );
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Theme root: ' . get_theme_root() );
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Stylesheet directory: ' . get_stylesheet_directory() );
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Template directory: ' . get_template_directory() );
        
        // Check if theme files are readable
        $required_files = array(
            'style.css' => get_stylesheet_directory() . '/style.css',
            'index.php' => get_stylesheet_directory() . '/index.php',
            'functions.php' => get_stylesheet_directory() . '/functions.php',
        );
        
        foreach ( $required_files as $file => $path ) {
            error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] ' . $file . ' exists: ' . ( file_exists( $path ) ? 'yes' : 'no' ) );
            error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] ' . $file . ' readable: ' . ( is_readable( $path ) ? 'yes' : 'no' ) );
        }
        
        // Check if it's a symlink issue
        $theme_path = get_stylesheet_directory();
        error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Theme path is symlink: ' . ( is_link( $theme_path ) ? 'yes' : 'no' ) );
        if ( is_link( $theme_path ) ) {
            error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Symlink target: ' . readlink( $theme_path ) );
            error_log( '[MediaKit] [THEME_AVAILABILITY_DEBUG] Symlink target exists: ' . ( file_exists( readlink( $theme_path ) ) ? 'yes' : 'no' ) );
        }
    }
}, 1 );

/**
 * Try to prevent theme from being switched if it's valid
 */
/*
// DISABLED FOR SAFETY - This was forcing validation
add_filter( 'validate_current_theme', function( $validate ) {
    // If this is MediaKit Lite, always validate it
    $current_theme = get_option( 'stylesheet' );
    if ( $current_theme === 'mediakit-lite' ) {
        error_log( '[MediaKit] [THEME_VALIDATION_OVERRIDE] Forcing MediaKit Lite validation to true' );
        return true;
    }
    return $validate;
}, 999 ); // High priority to run last
*/