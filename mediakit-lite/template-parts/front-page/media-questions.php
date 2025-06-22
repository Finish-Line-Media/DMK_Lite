<?php
/**
 * Questions for Media Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-media-questions-section';
$section_color = get_theme_mod( 'mkp_media_questions_background_color', '#f8f9fa' );
$list_style = get_theme_mod( 'mkp_media_questions_list_style', 'bullets' );

// Check if section is enabled
if ( ! get_theme_mod( 'mkp_enable_section_media_questions', true ) ) {
    return;
}

// Check if we have any questions
$has_questions = false;
for ( $i = 1; $i <= 12; $i++ ) {
    if ( get_theme_mod( 'mkp_media_question_' . $i ) ) {
        $has_questions = true;
        break;
    }
}

// For customizer preview, always render the section structure
$is_customizer = is_customize_preview();

if ( ! $has_questions && ! $is_customizer ) {
    return;
}
?>

<section id="media-questions" class="<?php echo esc_attr( $section_class ); ?> mkp-media-questions-section--<?php echo esc_attr( $list_style ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?><?php echo ( ! $has_questions && $is_customizer ) ? '; display: none;' : ''; ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Questions for the Media', 'mediakit-lite' ); ?></h2>
        
        <?php
        $tag = 'ul';
        $list_class = 'mkp-media-questions__list mkp-media-questions__list--' . esc_attr( $list_style );
        
        if ( $list_style === 'numbers' ) {
            $tag = 'ol';
        }
        ?>
        
        <?php if ( $has_questions || $is_customizer ) : ?>
            <<?php echo $tag; ?> class="<?php echo esc_attr( $list_class ); ?>">
                <?php for ( $i = 1; $i <= 12; $i++ ) : 
                    $question = get_theme_mod( 'mkp_media_question_' . $i );
                    if ( ! $question && ! $is_customizer ) {
                        continue;
                    }
                    ?>
                    <li class="mkp-media-questions__item mkp-media-questions__item--<?php echo esc_attr( $i ); ?>" <?php echo ( ! $question && $is_customizer ) ? 'style="display: none;"' : ''; ?>>
                        <span class="mkp-media-questions__text"><?php echo esc_html( $question ); ?></span>
                    </li>
                <?php endfor; ?>
            </<?php echo $tag; ?>>
        <?php endif; ?>
        
        <?php if ( ! $has_questions && $is_customizer ) : ?>
            <p class="mkp-media-questions__placeholder" style="text-align: center; color: #999; padding: 40px 0;">
                <?php esc_html_e( 'Start adding questions to see them appear here.', 'mediakit-lite' ); ?>
            </p>
        <?php endif; ?>
    </div>
</section>