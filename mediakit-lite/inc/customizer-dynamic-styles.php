<?php
/**
 * Dynamic styles generation for MediaKit Lite
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Generate dynamic CSS based on customizer settings
 */
function mkp_generate_dynamic_styles() {
    // Get color settings
    $primary_color = get_theme_mod( 'mkp_primary_color', '#2c3e50' );
    $secondary_color = get_theme_mod( 'mkp_secondary_color', '#3498db' );
    $accent_color = get_theme_mod( 'mkp_accent_color', '#e74c3c' );
    
    // Get navigation background
    $nav_bg = get_theme_mod( 'mkp_nav_background_color', '#ffffff' );
    
    // Get section background colors
    $hero_bg = get_theme_mod( 'mkp_hero_background_color', '#f8f9fa' );
    $bio_bg = get_theme_mod( 'mkp_bio_background_color', '#ffffff' );
    $books_bg = get_theme_mod( 'mkp_books_background_color', '#f8f9fa' );
    $podcasts_bg = get_theme_mod( 'mkp_podcasts_background_color', '#ffffff' );
    $speaker_bg = get_theme_mod( 'mkp_speaker_topics_background_color', '#f8f9fa' );
    $corps_bg = get_theme_mod( 'mkp_corporations_background_color', '#ffffff' );
    $media_questions_bg = get_theme_mod( 'mkp_media_questions_background_color', '#f8f9fa' );
    
    ob_start();
    ?>
    <style id="mkp-dynamic-styles">
        /* Navigation Background and Auto-Contrast */
        .mkp-header {
            background-color: <?php echo esc_attr( $nav_bg ); ?>;
        }
        
        .mkp-nav__link {
            color: <?php echo esc_attr( mkp_get_contrast_color( $nav_bg ) ); ?>;
        }
        
        .mkp-nav__link:hover,
        .mkp-nav__link:focus {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }
        
        /* Hero Section Auto-Contrast */
        .mkp-hero {
            color: <?php echo esc_attr( mkp_get_contrast_color( $hero_bg ) ); ?>;
        }
        
        .mkp-hero .mkp-hero__name {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $hero_bg, 'heading' ) ); ?>;
        }
        
        .mkp-hero .mkp-hero__tag {
            background-color: transparent;
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $hero_bg, 'text' ) ); ?>;
            padding: 0;
            border-radius: 0;
            font-weight: 400;
        }
        
        .mkp-hero .mkp-hero__tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0;
            justify-content: center;
            align-items: center;
            margin-bottom: var(--mkp-spacing-xl);
        }
        
        .mkp-hero .mkp-hero__tag:not(:last-child)::after {
            content: '\00B7'; /* Middle dot */
            margin: 0 0.75em;
            opacity: 0.5;
        }
        
        /* Bio Section Auto-Contrast */
        .mkp-bio-section {
            background-color: <?php echo esc_attr( $bio_bg ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $bio_bg ) ); ?>;
        }
        
        .mkp-bio-section h2,
        .mkp-bio-section h3 {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $bio_bg, 'heading' ) ); ?>;
        }
        
        /* Books Section Auto-Contrast */
        .mkp-books-section {
            background-color: <?php echo esc_attr( $books_bg ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $books_bg ) ); ?>;
        }
        
        .mkp-books-section h2,
        .mkp-books-section h3 {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $books_bg, 'heading' ) ); ?>;
        }
        
        .mkp-books-section .mkp-book-card {
            background-color: <?php echo mkp_is_light_color( $books_bg ) ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.2)'; ?>;
        }
        
        .mkp-books-section .mkp-book-card__title {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $books_bg, 'heading' ) ); ?>;
        }
        
        .mkp-books-section .mkp-book-card__description {
            color: <?php echo esc_attr( mkp_get_contrast_color( $books_bg ) ); ?>;
        }
        
        /* Podcasts Section Auto-Contrast */
        .mkp-podcasts-section {
            background-color: <?php echo esc_attr( $podcasts_bg ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $podcasts_bg ) ); ?>;
        }
        
        .mkp-podcasts-section h2,
        .mkp-podcasts-section h3 {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $podcasts_bg, 'heading' ) ); ?>;
        }
        
        .mkp-podcasts-section .mkp-podcast-card {
            background-color: <?php echo mkp_is_light_color( $podcasts_bg ) ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.2)'; ?>;
        }
        
        .mkp-podcasts-section .mkp-podcast-card__title {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $podcasts_bg, 'heading' ) ); ?>;
        }
        
        .mkp-podcasts-section .mkp-podcast-card__description {
            color: <?php echo esc_attr( mkp_get_contrast_color( $podcasts_bg ) ); ?>;
        }
        
        
        /* Speaker Topics Section Auto-Contrast */
        .mkp-speaker-section {
            background-color: <?php echo esc_attr( $speaker_bg ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $speaker_bg ) ); ?>;
        }
        
        .mkp-speaker-section h2,
        .mkp-speaker-section h3,
        .mkp-speaker-section .mkp-speaker__topic-title {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $speaker_bg, 'heading' ) ); ?>;
        }
        
        .mkp-speaker-section .mkp-speaker__topic-arrow {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $speaker_bg, 'heading' ) ); ?>;
        }
        
        /* List styles for speaker topics */
        .mkp-speaker-section .mkp-speaker__list {
            color: <?php echo esc_attr( mkp_get_contrast_color( $speaker_bg ) ); ?>;
        }
        
        .mkp-speaker-section .mkp-speaker__list-item::marker {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $speaker_bg, 'muted' ) ); ?>;
        }
        
        /* Card style for speaker topics */
        .mkp-speaker-section .mkp-speaker__topic {
            background-color: <?php echo mkp_is_light_color( $speaker_bg ) ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.2)'; ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $speaker_bg ) ); ?>;
        }
        
        .mkp-speaker-section--cards .mkp-speaker__topic-title {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $speaker_bg, 'heading' ) ); ?>;
        }
        
        
        /* Companies Section Auto-Contrast */
        .mkp-corporations-section {
            background-color: <?php echo esc_attr( $corps_bg ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $corps_bg ) ); ?>;
        }
        
        .mkp-corporations-section h2,
        .mkp-corporations-section h3 {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $corps_bg, 'heading' ) ); ?>;
        }
        
        /* Company names and cards */
        .mkp-corporations-section .mkp-corp-card__name {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $corps_bg, 'heading' ) ); ?>;
        }
        
        .mkp-corporations-section .mkp-corp-card {
            background-color: <?php echo mkp_is_light_color( $corps_bg ) ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.2)'; ?>;
        }
        
        .mkp-corporations-section .mkp-corp-card__bio {
            color: <?php echo esc_attr( mkp_get_contrast_color( $corps_bg ) ); ?>;
        }
        
        /* Media Questions Section Auto-Contrast */
        .mkp-media-questions-section {
            background-color: <?php echo esc_attr( $media_questions_bg ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $media_questions_bg ) ); ?>;
        }
        
        .mkp-media-questions-section h2,
        .mkp-media-questions-section h3 {
            color: <?php echo esc_attr( mkp_get_contrast_color_rgba( $media_questions_bg, 'heading' ) ); ?>;
        }
        
        .mkp-media-questions__item {
            color: <?php echo esc_attr( mkp_get_contrast_color( $media_questions_bg ) ); ?>;
        }
        
        .mkp-media-questions__arrow {
            color: <?php echo esc_attr( $secondary_color ); ?>;
        }
        
        
        
        
        
        /* Button styles with proper hover states */
        .mkp-btn--primary {
            background-color: <?php echo esc_attr( $secondary_color ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $secondary_color ) ); ?>;
            border: 2px solid <?php echo esc_attr( $secondary_color ); ?>;
        }
        
        .mkp-btn--primary:hover,
        .mkp-btn--primary:focus {
            background-color: <?php echo esc_attr( $accent_color ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $accent_color ) ); ?>;
            border-color: <?php echo esc_attr( $accent_color ); ?>;
            text-decoration: none;
        }
        
        .mkp-btn--secondary {
            background-color: transparent;
            color: <?php echo esc_attr( $secondary_color ); ?>;
            border: 2px solid <?php echo esc_attr( $secondary_color ); ?>;
        }
        
        .mkp-btn--secondary:hover,
        .mkp-btn--secondary:focus {
            background-color: <?php echo esc_attr( $accent_color ); ?>;
            color: <?php echo esc_attr( mkp_get_contrast_color( $accent_color ) ); ?>;
            border-color: <?php echo esc_attr( $accent_color ); ?>;
            text-decoration: none;
        }
        
        /* Ensure button text remains visible on hover */
        .mkp-btn:hover,
        .mkp-btn:focus {
            opacity: 1;
        }
        
        /* Fix for hero with background image */
        <?php if ( get_theme_mod( 'mkp_hero_background' ) ) : ?>
        .mkp-hero .mkp-hero__name,
        .mkp-hero .mkp-hero__tag,
        .mkp-hero .mkp-hero__buttons {
            position: relative;
            z-index: 2;
        }
        <?php endif; ?>
        
        /* Add subtle shadows to all cards */
        .mkp-speaker__topic,
        .mkp-corp-card,
        .mkp-book-card,
        .mkp-podcast-card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    </style>
    <?php
    
    return ob_get_clean();
}

/**
 * Output dynamic styles
 */
function mkp_output_dynamic_styles() {
    echo mkp_generate_dynamic_styles();
}
add_action( 'wp_head', 'mkp_output_dynamic_styles', 100 );