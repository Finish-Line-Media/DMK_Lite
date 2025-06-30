<?php
/**
 * Template part for displaying single post content
 *
 * @package MediaKit_Lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mkp-single-post' ); ?>>
    <header class="mkp-entry-header">
        <?php the_title( '<h1 class="mkp-entry-title">', '</h1>' ); ?>
        
        <div class="mkp-entry-meta">
            <?php mkp_posted_on(); ?>
            <?php mkp_posted_by(); ?>
            <span class="mkp-reading-time">
                <?php echo mkp_get_reading_time(); ?>
            </span>
        </div>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="mkp-entry-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>

    <div class="mkp-entry-content">
        <?php
        the_content();

        wp_link_pages( array(
            'before' => '<div class="mkp-page-links">' . esc_html__( 'Pages:', 'mediakit-lite' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <footer class="mkp-entry-footer">
        <div class="mkp-entry-categories">
            <?php
            $categories_list = get_the_category_list( esc_html__( ', ', 'mediakit-lite' ) );
            if ( $categories_list ) {
                printf( '<span class="mkp-cat-links">' . esc_html__( 'Posted in %1$s', 'mediakit-lite' ) . '</span>', $categories_list );
            }
            ?>
        </div>
        
        <div class="mkp-entry-tags">
            <?php
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mediakit-lite' ) );
            if ( $tags_list ) {
                printf( '<span class="mkp-tags-links">' . esc_html__( 'Tagged %1$s', 'mediakit-lite' ) . '</span>', $tags_list );
            }
            ?>
        </div>
        
        <?php mkp_share_buttons(); ?>
    </footer>

    <?php
    // Author bio
    if ( get_the_author_meta( 'description' ) ) : ?>
        <div class="mkp-author-bio mkp-card">
            <div class="mkp-author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
            </div>
            <div class="mkp-author-info">
                <h3 class="mkp-author-name"><?php the_author(); ?></h3>
                <div class="mkp-author-description">
                    <?php the_author_meta( 'description' ); ?>
                </div>
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="mkp-author-link">
                    <?php esc_html_e( 'View all posts', 'mediakit-lite' ); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <?php
    // Post navigation
    the_post_navigation( array(
        'prev_text' => '<span class="mkp-nav-subtitle">' . esc_html__( 'Previous:', 'mediakit-lite' ) . '</span> <span class="mkp-nav-title">%title</span>',
        'next_text' => '<span class="mkp-nav-subtitle">' . esc_html__( 'Next:', 'mediakit-lite' ) . '</span> <span class="mkp-nav-title">%title</span>',
        'class'     => 'mkp-post-navigation',
    ) );
    ?>
</article>