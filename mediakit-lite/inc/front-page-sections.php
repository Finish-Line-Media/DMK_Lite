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
 * Check if books section has content
 *
 * @return bool
 */
function mkp_has_books() {
    $books_count = get_theme_mod( 'mkp_books_count', 3 );
    for ( $i = 1; $i <= $books_count; $i++ ) {
        if ( get_theme_mod( 'mkp_book_' . $i . '_title' ) ) {
            return true;
        }
    }
    return false;
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
 * Check if podcast section has content
 *
 * @return bool
 */
function mkp_has_podcast() {
    return (bool) get_theme_mod( 'mkp_podcast_name' );
}

/**
 * Check if corporations/companies section has content
 *
 * @return bool
 */
function mkp_has_companies() {
    $corps_count = get_theme_mod( 'mkp_corporations_count', 2 );
    for ( $i = 1; $i <= $corps_count; $i++ ) {
        if ( get_theme_mod( 'mkp_corp_' . $i . '_name' ) ) {
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
function mkp_has_investor_content() {
    return get_theme_mod( 'mkp_investment_people' ) || 
           get_theme_mod( 'mkp_investment_products' ) || 
           get_theme_mod( 'mkp_investment_markets' );
}

/**
 * Check if media items section has content
 *
 * @return bool
 */
function mkp_has_media_items() {
    $media_count = get_theme_mod( 'mkp_media_items_count', 6 );
    for ( $i = 1; $i <= $media_count; $i++ ) {
        if ( get_theme_mod( 'mkp_media_item_' . $i . '_title' ) ) {
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
        'speaker_topics' => array(
            'template' => 'template-parts/front-page/speaker-topics',
            'check_function' => 'mkp_has_speaker_topics',
        ),
        'podcast' => array(
            'template' => 'template-parts/front-page/podcast',
            'check_function' => 'mkp_has_podcast',
        ),
        'corporations' => array(
            'template' => 'template-parts/front-page/corporations',
            'check_function' => 'mkp_has_companies',
        ),
        'media_questions' => array(
            'template' => 'template-parts/front-page/media-questions',
            'check_function' => 'mkp_has_media_questions',
        ),
        'investor' => array(
            'template' => 'template-parts/front-page/investor',
            'check_function' => 'mkp_has_investor_content',
        ),
        'in_the_media' => array(
            'template' => 'template-parts/front-page/in-the-media',
            'check_function' => 'mkp_has_media_items',
        ),
        'contact' => array(
            'template' => 'template-parts/front-page/contact',
            'always_show' => false,
        ),
    );
}