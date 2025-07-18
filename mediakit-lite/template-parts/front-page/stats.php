<?php
/**
 * Stats & Achievements Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-stats-section mkp-section';

// Get dynamic colors for this section
$colors = mkp_get_next_section_color();
$section_color = $colors['background'];
$text_color = $colors['text'];

// Count actual stats
$actual_stat_count = 0;
for ( $i = 1; $i <= 4; $i++ ) {
    $number = get_theme_mod( 'mkp_stat_' . $i . '_number' );
    $label = get_theme_mod( 'mkp_stat_' . $i . '_label' );
    if ( $number && $label ) {
        $actual_stat_count++;
    }
}

// For customizer preview
$is_customizer = is_customize_preview();

// Get section title
$section_title = get_theme_mod( 'mkp_stats_section_title', __( 'By The Numbers', 'mediakit-lite' ) );

// Available icons
$available_icons = array(
    'users' => 'dashicons-groups',
    'star' => 'dashicons-star-filled',
    'award' => 'dashicons-awards',
    'chart' => 'dashicons-chart-line',
    'calendar' => 'dashicons-calendar-alt',
    'location' => 'dashicons-location',
    'microphone' => 'dashicons-microphone',
    'book' => 'dashicons-book',
    'video' => 'dashicons-video-alt3',
    'portfolio' => 'dashicons-portfolio',
    'megaphone' => 'dashicons-megaphone',
    'analytics' => 'dashicons-analytics',
);
?>

<section id="stats" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php echo esc_html( $section_title ); ?></h2>
        
        <div class="mkp-stats__grid mkp-stats__grid--count-<?php echo esc_attr( $actual_stat_count ); ?>">
            <?php for ( $i = 1; $i <= 4; $i++ ) : 
                $number = get_theme_mod( 'mkp_stat_' . $i . '_number' );
                $label = get_theme_mod( 'mkp_stat_' . $i . '_label' );
                $prefix = get_theme_mod( 'mkp_stat_' . $i . '_prefix', '' );
                $suffix = get_theme_mod( 'mkp_stat_' . $i . '_suffix', '' );
                $icon = get_theme_mod( 'mkp_stat_' . $i . '_icon', 'star' );
                
                if ( ! $number || ! $label ) {
                    continue;
                }
                
                // Get the dashicon class
                $icon_class = isset( $available_icons[ $icon ] ) ? $available_icons[ $icon ] : 'dashicons-star-filled';
                ?>
                <div class="mkp-stat-item mkp-stat--<?php echo esc_attr( $i ); ?>">
                    <div class="mkp-stat__icon">
                        <span class="dashicons <?php echo esc_attr( $icon_class ); ?>"></span>
                    </div>
                    
                    <div class="mkp-stat__number">
                        <?php if ( $prefix ) : ?>
                            <span class="mkp-stat__prefix"><?php echo esc_html( $prefix ); ?></span>
                        <?php endif; ?>
                        
                        <span class="mkp-stat__value" data-target="<?php echo esc_attr( $number ); ?>">
                            <?php echo esc_html( $number ); ?>
                        </span>
                        
                        <?php if ( $suffix ) : ?>
                            <span class="mkp-stat__suffix"><?php echo esc_html( $suffix ); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mkp-stat__label">
                        <?php echo esc_html( $label ); ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        
        <?php if ( $is_customizer && $actual_stat_count === 0 ) : ?>
            <div class="mkp-stats__placeholder">
                <p><?php esc_html_e( 'Add statistics and achievements in the Customizer to display them here.', 'mediakit-lite' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>