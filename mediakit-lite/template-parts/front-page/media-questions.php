<?php
/**
 * Questions for Media Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-media-questions-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];
$list_style = get_theme_mod( 'mkp_media_questions_list_style', 'bullets' );

// Get text alignment setting
$text_align = get_theme_mod( 'mkp_media_questions_text_align', 'left' );
$question_class = 'mkp-media-questions__question mkp-text-align-' . $text_align;

// Check if we have any questions and count them
$has_questions = false;
$question_count = 0;
for ( $i = 1; $i <= 12; $i++ ) {
    if ( get_theme_mod( 'mkp_media_question_' . $i ) ) {
        $has_questions = true;
        $question_count++;
    }
}

// For customizer preview, always render the section structure
$is_customizer = is_customize_preview();

if ( ! $has_questions && ! $is_customizer ) {
    return;
}
?>

<section id="media_questions" class="<?php echo esc_attr( $section_class ); ?> mkp-media-questions-section--<?php echo esc_attr( $list_style ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?><?php echo ( ! $has_questions && $is_customizer ) ? '; display: none;' : ''; ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( get_theme_mod( 'mkp_media_questions_section_title', __( 'Questions for the Media', 'mediakit-lite' ) ) ); ?></h2>
        
        <?php if ( $has_questions || $is_customizer ) : ?>
            <?php if ( $list_style === 'bullets' || $list_style === 'numbers' ) : ?>
                <?php
                $tag = $list_style === 'bullets' ? 'ul' : 'ol';
                $list_class = 'mkp-media-questions__list mkp-media-questions__list--' . esc_attr( $list_style );
                ?>
                <<?php echo $tag; ?> class="<?php echo esc_attr( $list_class ); ?>">
                    <?php for ( $i = 1; $i <= 12; $i++ ) : 
                        $question = get_theme_mod( 'mkp_media_question_' . $i );
                        if ( ! $question && ! $is_customizer ) {
                            continue;
                        }
                        ?>
                        <li class="mkp-media-questions__item mkp-media-questions__item--<?php echo esc_attr( $i ); ?> <?php echo esc_attr( $question_class ); ?>" <?php echo ( ! $question && $is_customizer ) ? 'style="display: none;"' : ''; ?>>
                            <span class="mkp-media-questions__text"><?php echo esc_html( $question ); ?></span>
                        </li>
                    <?php endfor; ?>
                </<?php echo $tag; ?>>
            <?php else : // cards style ?>
                <div class="mkp-media-questions__cards mkp-media-questions__cards--count-<?php echo esc_attr( $question_count ); ?>">
                    <?php for ( $i = 1; $i <= 12; $i++ ) : 
                        $question = get_theme_mod( 'mkp_media_question_' . $i );
                        if ( ! $question && ! $is_customizer ) {
                            continue;
                        }
                        $display = $question ? 'flex' : 'none';
                        ?>
                        <div class="mkp-media-questions__card mkp-card mkp-media-questions__card--<?php echo esc_attr( $i ); ?>" style="display: <?php echo esc_attr( $display ); ?>;">
                            <span class="mkp-media-questions__card-icon">?</span>
                            <p class="mkp-media-questions__card-text"><?php echo esc_html( $question ); ?></p>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ( ! $has_questions && $is_customizer ) : ?>
            <p class="mkp-media-questions__placeholder" style="text-align: center; color: #999; padding: 40px 0;">
                <?php esc_html_e( 'Start adding questions to see them appear here.', 'mediakit-lite' ); ?>
            </p>
        <?php endif; ?>
    </div>
</section>