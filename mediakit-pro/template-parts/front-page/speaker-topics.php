<?php
/**
 * Speaker Topics Section Template Part
 *
 * @package MediaKit_Pro
 */

$section_class = 'mkp-speaker-section';
$section_color = get_theme_mod( 'mkp_speaker_topics_background_color', '#ffffff' );
?>

<section id="speaking" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Speaking Topics', 'mediakit-pro' ); ?></h2>
        
        <div class="mkp-speaker__topics">
            <?php for ( $i = 1; $i <= 5; $i++ ) : 
                $topic = get_theme_mod( 'mkp_speaker_topic_' . $i );
                if ( $topic ) : ?>
                    <div class="mkp-speaker__topic">
                        <span class="mkp-speaker__topic-number"><?php echo esc_html( $i ); ?></span>
                        <h3 class="mkp-speaker__topic-title"><?php echo esc_html( $topic ); ?></h3>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>