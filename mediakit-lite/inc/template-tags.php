<?php
/**
 * Custom template tags for this theme
 *
 * @package MediaKit_Lite
 */

if ( ! function_exists( 'mkp_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function mkp_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'mediakit-lite' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;

if ( ! function_exists( 'mkp_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function mkp_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'mediakit-lite' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;

if ( ! function_exists( 'mkp_entry_footer' ) ) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function mkp_entry_footer() {
        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'mediakit-lite' ) );
            if ( $categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mediakit-lite' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mediakit-lite' ) );
            if ( $tags_list ) {
                /* translators: 1: list of tags. */
                printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mediakit-lite' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mediakit-lite' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'mediakit-lite' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if ( ! function_exists( 'mkp_post_thumbnail' ) ) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function mkp_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                    the_post_thumbnail(
                        'post-thumbnail',
                        array(
                            'alt' => the_title_attribute(
                                array(
                                    'echo' => false,
                                )
                            ),
                        )
                    );
                ?>
            </a>

            <?php
        endif; // End is_singular().
    }
endif;



if ( ! function_exists( 'mkp_media_type_badge' ) ) :
    /**
     * Display media type badge
     */
    function mkp_media_type_badge( $post_id = null ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        
        $media_types = wp_get_post_terms( $post_id, 'media_type' );
        
        if ( ! empty( $media_types ) && ! is_wp_error( $media_types ) ) {
            $media_type = $media_types[0];
            $badge_class = 'mkp-badge mkp-badge--' . sanitize_html_class( $media_type->slug );
            ?>
            <span class="<?php echo esc_attr( $badge_class ); ?>">
                <?php echo esc_html( $media_type->name ); ?>
            </span>
            <?php
        }
    }
endif;

if ( ! function_exists( 'mkp_get_reading_time' ) ) :
    /**
     * Calculate reading time for a post
     */
    function mkp_get_reading_time( $post_id = null ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        
        $content = get_post_field( 'post_content', $post_id );
        $word_count = str_word_count( strip_tags( $content ) );
        $reading_time = ceil( $word_count / 200 ); // Average reading speed
        
        return sprintf(
            /* translators: %s: reading time in minutes */
            _n( '%s minute read', '%s minutes read', $reading_time, 'mediakit-lite' ),
            $reading_time
        );
    }
endif;

if ( ! function_exists( 'mkp_pagination' ) ) :
    /**
     * Display pagination
     */
    function mkp_pagination() {
        $args = array(
            'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'mediakit-lite' ) . '</span>&larr;',
            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'mediakit-lite' ) . '</span>&rarr;',
            'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'mediakit-lite' ) . ' </span>',
            'mid_size' => 2,
            'type' => 'list',
        );
        
        $pagination = paginate_links( $args );
        
        if ( $pagination ) {
            echo '<nav class="mkp-pagination" aria-label="' . esc_attr__( 'Posts navigation', 'mediakit-lite' ) . '">';
            echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo '</nav>';
        }
    }
endif;

if ( ! function_exists( 'mkp_breadcrumbs' ) ) :
    /**
     * Display breadcrumbs
     */
    function mkp_breadcrumbs() {
        if ( is_front_page() ) {
            return;
        }
        
        echo '<nav class="mkp-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'mediakit-lite' ) . '">';
        echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'mediakit-lite' ) . '</a>';
        
        if ( is_single() ) {
            $post_type = get_post_type();
            
            if ( $post_type !== 'post' ) {
                $post_type_object = get_post_type_object( $post_type );
                $post_type_archive = get_post_type_archive_link( $post_type );
                
                if ( $post_type_archive ) {
                    echo '<span class="mkp-breadcrumbs__separator">/</span>';
                    echo '<a href="' . esc_url( $post_type_archive ) . '">' . esc_html( $post_type_object->labels->name ) . '</a>';
                }
            } else {
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    echo '<span class="mkp-breadcrumbs__separator">/</span>';
                    echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                }
            }
            
            echo '<span class="mkp-breadcrumbs__separator">/</span>';
            echo '<span class="mkp-breadcrumbs__current">' . esc_html( get_the_title() ) . '</span>';
        } elseif ( is_page() ) {
            $ancestors = array_reverse( get_post_ancestors( get_the_ID() ) );
            foreach ( $ancestors as $ancestor ) {
                echo '<span class="mkp-breadcrumbs__separator">/</span>';
                echo '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>';
            }
            
            echo '<span class="mkp-breadcrumbs__separator">/</span>';
            echo '<span class="mkp-breadcrumbs__current">' . esc_html( get_the_title() ) . '</span>';
        } elseif ( is_archive() ) {
            echo '<span class="mkp-breadcrumbs__separator">/</span>';
            echo '<span class="mkp-breadcrumbs__current">' . esc_html( get_the_archive_title() ) . '</span>';
        } elseif ( is_search() ) {
            echo '<span class="mkp-breadcrumbs__separator">/</span>';
            echo '<span class="mkp-breadcrumbs__current">' . esc_html__( 'Search Results', 'mediakit-lite' ) . '</span>';
        } elseif ( is_404() ) {
            echo '<span class="mkp-breadcrumbs__separator">/</span>';
            echo '<span class="mkp-breadcrumbs__current">' . esc_html__( '404 Not Found', 'mediakit-lite' ) . '</span>';
        }
        
        echo '</nav>';
    }
endif;