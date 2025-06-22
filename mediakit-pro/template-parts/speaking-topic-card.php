<?php
/**
 * Template part for displaying speaking topic card
 *
 * @package MediaKit_Pro
 */

// Get custom fields using native functions
$target_audience = get_post_meta( get_the_ID(), '_mkp_target_audience', true );
$duration = get_post_meta( get_the_ID(), '_mkp_duration', true );
$key_takeaways = get_post_meta( get_the_ID(), '_mkp_key_takeaways', true );

// Duration labels
$duration_labels = array(
    '30min' => __( '30 minutes', 'mediakit-pro' ),
    '45min' => __( '45 minutes', 'mediakit-pro' ),
    '60min' => __( '60 minutes', 'mediakit-pro' ),
    '90min' => __( '90 minutes', 'mediakit-pro' ),
    'half-day' => __( 'Half Day Workshop', 'mediakit-pro' ),
    'full-day' => __( 'Full Day Workshop', 'mediakit-pro' ),
);
?>

<article class="mkp-speaker-topic">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="mkp-speaker-topic__image">
            <?php the_post_thumbnail( 'mkp-portfolio' ); ?>
        </div>
    <?php endif; ?>
    
    <div class="mkp-speaker-topic__content">
        <h3 class="mkp-speaker-topic__title"><?php the_title(); ?></h3>
        
        <div class="mkp-speaker-topic__excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <div class="mkp-speaker-topic__meta">
            <?php if ( $target_audience ) : ?>
                <div class="mkp-speaker-topic__audience">
                    <strong><?php esc_html_e( 'Audience:', 'mediakit-pro' ); ?></strong>
                    <?php echo esc_html( $target_audience ); ?>
                </div>
            <?php endif; ?>
            
            <?php if ( $duration && isset( $duration_labels[ $duration ] ) ) : ?>
                <div class="mkp-speaker-topic__duration">
                    <strong><?php esc_html_e( 'Duration:', 'mediakit-pro' ); ?></strong>
                    <?php echo esc_html( $duration_labels[ $duration ] ); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ( ! empty( $key_takeaways ) ) : ?>
            <div class="mkp-speaker-topic__takeaways">
                <h4><?php esc_html_e( 'Key Takeaways:', 'mediakit-pro' ); ?></h4>
                <ul>
                    <?php foreach ( $key_takeaways as $takeaway ) : ?>
                        <?php if ( ! empty( $takeaway ) ) : ?>
                            <li><?php echo esc_html( $takeaway ); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <a href="<?php the_permalink(); ?>" class="mkp-btn mkp-btn--text">
            <?php esc_html_e( 'Learn More', 'mediakit-pro' ); ?> &rarr;
        </a>
    </div>
</article>