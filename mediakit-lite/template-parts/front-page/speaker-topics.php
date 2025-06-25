<?php
/**
 * Speaker Topics Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-speaker-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];
$list_style = get_theme_mod( 'mkp_speaker_topics_list_style', 'bullets' );

// Check if we have any topics and count them
$has_topics = false;
$topic_count = 0;
for ( $i = 1; $i <= 6; $i++ ) {
    if ( get_theme_mod( 'mkp_speaker_topic_' . $i ) ) {
        $has_topics = true;
        $topic_count++;
    }
}

if ( ! $has_topics ) {
    return;
}
?>

<section id="speaking" class="<?php echo esc_attr( $section_class ); ?> mkp-speaker-section--<?php echo esc_attr( $list_style ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Speaking Topics', 'mediakit-lite' ); ?></h2>
        
        <?php if ( $list_style === 'bullets' || $list_style === 'numbers' ) : ?>
            <?php
            $tag = $list_style === 'bullets' ? 'ul' : 'ol';
            ?>
            <<?php echo $tag; ?> class="mkp-speaker__list mkp-speaker__list--<?php echo esc_attr( $list_style ); ?>">
                <?php for ( $i = 1; $i <= 6; $i++ ) : 
                    $topic = get_theme_mod( 'mkp_speaker_topic_' . $i );
                    $display = $topic ? 'list-item' : 'none';
                    ?>
                    <li class="mkp-speaker__list-item mkp-speaker__list-item--<?php echo esc_attr( $i ); ?>" style="display: <?php echo esc_attr( $display ); ?>;">
                        <h3 class="mkp-speaker__topic-title"><?php echo esc_html( $topic ); ?></h3>
                    </li>
                <?php endfor; ?>
            </<?php echo $tag; ?>>
        <?php else : // cards style ?>
            <div class="mkp-speaker__topics mkp-speaker__topics--count-<?php echo esc_attr( $topic_count ); ?>">
                <?php for ( $i = 1; $i <= 6; $i++ ) : 
                    $topic = get_theme_mod( 'mkp_speaker_topic_' . $i );
                    $display = $topic ? 'flex' : 'none';
                    ?>
                    <div class="mkp-speaker__topic mkp-speaker__topic--<?php echo esc_attr( $i ); ?>" style="display: <?php echo esc_attr( $display ); ?>;">
                        <span class="mkp-speaker__topic-arrow">➤</span>
                        <h3 class="mkp-speaker__topic-title"><?php echo esc_html( $topic ); ?></h3>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</section>