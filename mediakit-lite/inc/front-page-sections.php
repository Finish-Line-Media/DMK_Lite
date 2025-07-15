<?php
/**
 * Front page section display logic
 *
 * @package MediaKit_Lite
 */

/**
 * Get all sections configuration - single source of truth
 *
 * @return array Complete section configuration
 */
function mkp_get_all_sections_config() {
    return array(
        'hero' => array(
            'title' => __( 'Hero Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/hero',
            'always_show' => true,
            'fixed' => true,  // Cannot be reordered
        ),
        'about' => array(
            'title' => __( 'About Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/about',
            'always_show' => true,
        ),
        'books' => array(
            'title' => __( 'Books Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/books',
            'check_function' => 'mkp_has_books',
        ),
        'podcasts' => array(
            'title' => __( 'Podcasts/Shows Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/podcasts',
            'check_function' => 'mkp_has_podcasts',
        ),
        'corporations' => array(
            'title' => __( 'Companies Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/corporations',
            'check_function' => 'mkp_has_companies',
        ),
        'speaker_topics' => array(
            'title' => __( 'Speaker Topics Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/speaker-topics',
            'check_function' => 'mkp_has_speaker_topics',
        ),
        'gallery' => array(
            'title' => __( 'Image Gallery Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/gallery',
            'check_function' => 'mkp_has_gallery_images',
        ),
        'in_the_media' => array(
            'title' => __( 'In The Media Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/in-the-media',
            'check_function' => 'mkp_has_media_items',
        ),
        'media_questions' => array(
            'title' => __( 'Questions for Media Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/media-questions',
            'check_function' => 'mkp_has_media_questions',
        ),
        'investor' => array(
            'title' => __( 'Investor Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/investor',
            'check_function' => 'mkp_has_investors',
        ),
        'contact' => array(
            'title' => __( 'Contact Section', 'mediakit-lite' ),
            'template' => 'template-parts/front-page/contact',
            'check_function' => 'mkp_has_contact_info',
        ),
    );
}

/**
 * Check if a section should be displayed
 *
 * @param string $section_name The section identifier
 * @param array  $content_checks Array of content check conditions
 * @return bool Whether the section should be displayed
 */
function mkp_should_display_section( $section_name, $content_checks = array() ) {
    // Check if section is enabled
    $enabled_key = 'mkp_enable_section_' . $section_name;
    $is_enabled = get_theme_mod( $enabled_key, false );
    
    if ( ! $is_enabled ) {
        return false;
    }
    
    // Check if section has content
    if ( ! empty( $content_checks ) ) {
        $has_content = false;
        foreach ( $content_checks as $check ) {
            if ( $check ) {
                $has_content = true;
                break;
            }
        }
        return $has_content;
    }
    
    return true;
}


/**
 * Check if speaker topics section has content
 *
 * @return bool
 */
function mkp_has_speaker_topics() {
    for ( $i = 1; $i <= 6; $i++ ) {
        if ( get_theme_mod( 'mkp_speaker_topic_' . $i ) ) {
            return true;
        }
    }
    return false;
}


/**
 * Check if corporations/companies section has content
 *
 * @return bool
 */
function mkp_has_companies() {
    for ( $i = 1; $i <= 6; $i++ ) {
        if ( get_theme_mod( 'mkp_corp_' . $i . '_name' ) ) {
            return true;
        }
    }
    return false;
}

/**
 * Check if books section has content
 *
 * @return bool
 */
function mkp_has_books() {
    for ( $i = 1; $i <= 4; $i++ ) {
        if ( get_theme_mod( 'mkp_book_' . $i . '_title' ) ) {
            return true;
        }
    }
    return false;
}

/**
 * Check if podcasts section has content
 *
 * @return bool
 */
function mkp_has_podcasts() {
    for ( $i = 1; $i <= 3; $i++ ) {
        if ( get_theme_mod( 'mkp_podcast_' . $i . '_title' ) ) {
            return true;
        }
    }
    return false;
}

/**
 * Check if media questions section has content
 *
 * @return bool
 */
function mkp_has_media_questions() {
    for ( $i = 1; $i <= 12; $i++ ) {
        if ( get_theme_mod( 'mkp_media_question_' . $i ) ) {
            return true;
        }
    }
    return false;
}

/**
 * Check if investor section has content
 *
 * @return bool
 */
function mkp_has_investors() {
    for ( $i = 1; $i <= 3; $i++ ) {
        if ( get_theme_mod( 'mkp_investor_' . $i . '_title' ) ) {
            return true;
        }
    }
    return false;
}

/**
 * Check if in the media section has content
 *
 * @return bool
 */
function mkp_has_media_items() {
    for ( $i = 1; $i <= 8; $i++ ) {
        if ( get_theme_mod( 'mkp_media_item_' . $i . '_url' ) ) {
            return true;
        }
    }
    return false;
}

/**
 * Check if contact section has content
 *
 * @return bool
 */
function mkp_has_contact_info() {
    // Check email addresses
    if ( get_theme_mod( 'mkp_contact_general_email' ) || 
         get_theme_mod( 'mkp_contact_media_email' ) || 
         get_theme_mod( 'mkp_contact_speaking_email' ) ) {
        return true;
    }
    
    // Check address
    if ( get_theme_mod( 'mkp_contact_address' ) ) {
        return true;
    }
    
    // Check social links
    $social_platforms = array( 'x', 'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok', 'github', 'threads' );
    foreach ( $social_platforms as $platform ) {
        if ( get_theme_mod( 'mkp_contact_social_' . $platform ) ) {
            return true;
        }
    }
    
    return false;
}

/**
 * Check if gallery has images
 */
function mkp_has_gallery_images() {
    $gallery_images = get_theme_mod( 'mkp_gallery_images', '' );
    return ! empty( $gallery_images );
}

/**
 * Get front page sections configuration
 *
 * @return array
 */
function mkp_get_front_page_sections() {
    $all_sections = mkp_get_all_sections_config();
    $sections = array();
    
    // Extract only the data needed for front page rendering
    foreach ( $all_sections as $id => $config ) {
        $sections[ $id ] = array(
            'template' => $config['template'],
        );
        
        if ( isset( $config['always_show'] ) ) {
            $sections[ $id ]['always_show'] = $config['always_show'];
        }
        
        if ( isset( $config['check_function'] ) ) {
            $sections[ $id ]['check_function'] = $config['check_function'];
        }
    }
    
    return $sections;
}