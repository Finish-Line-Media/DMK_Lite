<?php
/**
 * About Section Default Content
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get default about content (Lorem Ipsum)
 * 
 * @return string Default about content with 3 paragraphs
 */
function mkp_get_default_about_content() {
    $default_content = __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.

Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.

Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.', 'mediakit-lite' );
    
    return $default_content;
}

/**
 * Get about content with fallback to default
 * 
 * @return string About content or default content
 */
function mkp_get_about_content() {
    $about_content = get_theme_mod( 'mkp_about_content' );
    
    if ( empty( trim( $about_content ) ) ) {
        return mkp_get_default_about_content();
    }
    
    return $about_content;
}