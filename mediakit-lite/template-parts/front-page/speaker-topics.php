<?php
/**
 * Speaker Topics Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-speaker-section';
$section_color = get_theme_mod( 'mkp_speaker_topics_background_color', '#ffffff' );
$list_style = get_theme_mod( 'mkp_speaker_topics_list_style', 'bullets' );

// Collect topics
$topics = array();
for ( $i = 1; $i <= 5; $i++ ) {
    $topic = get_theme_mod( 'mkp_speaker_topic_' . $i );
    if ( $topic ) {
        $topics[] = $topic;
    }
}

if ( empty( $topics ) ) {
    return;
}
?>

<section id="speaking" class="<?php echo esc_attr( $section_class ); ?> mkp-speaker-section--<?php echo esc_attr( $list_style ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Speaking Topics', 'mediakit-lite' ); ?></h2>
        
        <?php if ( $list_style === 'bullets' || $list_style === 'numbers' ) : ?>
            <?php
            $tag = $list_style === 'bullets' ? 'ul' : 'ol';
            ?>
            <<?php echo $tag; ?> class="mkp-speaker__list mkp-speaker__list--<?php echo esc_attr( $list_style ); ?>">
                <?php foreach ( $topics as $topic ) : ?>
                    <li class="mkp-speaker__list-item">
                        <h3 class="mkp-speaker__topic-title"><?php echo esc_html( $topic ); ?></h3>
                    </li>
                <?php endforeach; ?>
            </<?php echo $tag; ?>>
        <?php else : // cards style ?>
            <div class="mkp-speaker__topics">
                <?php 
                $index = 1;
                foreach ( $topics as $topic ) : ?>
                    <div class="mkp-speaker__topic">
                        <span class="mkp-speaker__topic-number"><?php echo esc_html( $index ); ?></span>
                        <h3 class="mkp-speaker__topic-title"><?php echo esc_html( $topic ); ?></h3>
                    </div>
                <?php 
                $index++;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>