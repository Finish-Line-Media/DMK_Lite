<?php
/**
 * Template part for displaying posts in archives
 *
 * @package MediaKit_Lite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mkp-blog-card mkp-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="mkp-blog-card__thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium_large' ); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="mkp-blog-card__content">
        <header class="mkp-blog-card__header">
            <?php the_title( '<h2 class="mkp-blog-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
            
            <div class="mkp-blog-card__meta">
                <?php mkp_posted_on(); ?>
                <?php mkp_posted_by(); ?>
            </div>
        </header>
        
        <div class="mkp-blog-card__excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <footer class="mkp-blog-card__footer">
            <a href="<?php the_permalink(); ?>" class="mkp-blog-card__link">
                <?php esc_html_e( 'Read More', 'mediakit-lite' ); ?>
                <span aria-hidden="true">&rarr;</span>
            </a>
        </footer>
    </div>
</article>