<?php
/**
 * The front page template file
 *
 * @package MediaKit_Lite
 */

get_header();
?>

<main id="primary" class="mkp-main mkp-main--front-page">
    
    <?php
    // Hero Section
    get_template_part( 'template-parts/front-page/hero' );
    
    // About/Bio Section (Always shown)
    get_template_part( 'template-parts/front-page/bio' );
    
    // Books Section
    $books_count = get_theme_mod( 'mkp_books_count', 3 );
    $has_books = false;
    for ( $i = 1; $i <= $books_count; $i++ ) {
        if ( get_theme_mod( 'mkp_book_' . $i . '_title' ) ) {
            $has_books = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_books', true ) && $has_books ) {
        get_template_part( 'template-parts/front-page/books' );
    }
    
    // Speaker Topics Section
    $has_topics = false;
    for ( $i = 1; $i <= 5; $i++ ) {
        if ( get_theme_mod( 'mkp_speaker_topic_' . $i ) ) {
            $has_topics = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_speaker_topics', true ) && $has_topics ) {
        get_template_part( 'template-parts/front-page/speaker-topics' );
    }
    
    // Podcast/Show Section
    if ( get_theme_mod( 'mkp_enable_section_podcast', true ) && get_theme_mod( 'mkp_podcast_name' ) ) {
        get_template_part( 'template-parts/front-page/podcast' );
    }
    
    // Corporations Section
    $corps_count = get_theme_mod( 'mkp_corporations_count', 2 );
    $has_corps = false;
    for ( $i = 1; $i <= $corps_count; $i++ ) {
        if ( get_theme_mod( 'mkp_corp_' . $i . '_name' ) ) {
            $has_corps = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_corporations', true ) && $has_corps ) {
        get_template_part( 'template-parts/front-page/corporations' );
    }
    
    // Media Questions Section
    $has_questions = false;
    for ( $i = 1; $i <= 12; $i++ ) {
        if ( get_theme_mod( 'mkp_media_question_' . $i ) ) {
            $has_questions = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_media_questions', true ) && $has_questions ) {
        get_template_part( 'template-parts/front-page/media-questions' );
    }
    
    // Investor Section
    if ( get_theme_mod( 'mkp_enable_section_investor', true ) && 
         ( get_theme_mod( 'mkp_investment_people' ) || 
           get_theme_mod( 'mkp_investment_products' ) || 
           get_theme_mod( 'mkp_investment_markets' ) ) ) {
        get_template_part( 'template-parts/front-page/investor' );
    }
    
    // In The Media Section
    $media_count = get_theme_mod( 'mkp_media_items_count', 6 );
    $has_media = false;
    for ( $i = 1; $i <= $media_count; $i++ ) {
        if ( get_theme_mod( 'mkp_media_item_' . $i . '_title' ) ) {
            $has_media = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_in_the_media', true ) && $has_media ) {
        get_template_part( 'template-parts/front-page/in-the-media' );
    }
    
    // Contact Section
    if ( get_theme_mod( 'mkp_enable_section_contact', true ) ) {
        get_template_part( 'template-parts/front-page/contact' );
    }
    ?>
    
</main>

<?php
get_footer();