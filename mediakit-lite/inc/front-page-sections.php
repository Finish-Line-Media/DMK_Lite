<?php
/**
 * Front page section display logic
 *
 * @package MediaKit_Lite
 */

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
    $is_enabled = get_theme_mod( $enabled_key, true );
    
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
    for ( $i = 1; $i <= 5; $i++ ) {
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
    for ( $i = 1; $i <= 4; $i++ ) {
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
 * Get front page sections configuration
 *
 * @return array
 */
function mkp_get_front_page_sections() {
    return array(
        'hero' => array(
            'template' => 'template-parts/front-page/hero',
            'always_show' => true,
        ),
        'bio' => array(
            'template' => 'template-parts/front-page/bio',
            'always_show' => true,
        ),
        'books' => array(
            'template' => 'template-parts/front-page/books',
            'check_function' => 'mkp_has_books',
        ),
        'podcasts' => array(
            'template' => 'template-parts/front-page/podcasts',
            'check_function' => 'mkp_has_podcasts',
        ),
        'corporations' => array(
            'template' => 'template-parts/front-page/corporations',
            'check_function' => 'mkp_has_companies',
        ),
        'speaker_topics' => array(
            'template' => 'template-parts/front-page/speaker-topics',
            'check_function' => 'mkp_has_speaker_topics',
        ),
    );
}