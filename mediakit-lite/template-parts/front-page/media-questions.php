<?php
/**
 * Media Questions Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-media-questions-section';
$section_color = get_theme_mod( 'mkp_media_questions_background_color', '#f1f3f5' );
?>

<section id="media-questions" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Questions for the Media', 'mediakit-lite' ); ?></h2>
        <p class="mkp-section__subtitle"><?php esc_html_e( 'Interview questions to help producers prepare', 'mediakit-lite' ); ?></p>
        
        <div class="mkp-questions__list">
            <?php for ( $i = 1; $i <= 12; $i++ ) : 
                $question = get_theme_mod( 'mkp_media_question_' . $i );
                if ( $question ) : ?>
                    <div class="mkp-question">
                        <span class="mkp-question__number"><?php echo esc_html( $i ); ?>.</span>
                        <p class="mkp-question__text"><?php echo esc_html( $question ); ?></p>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>