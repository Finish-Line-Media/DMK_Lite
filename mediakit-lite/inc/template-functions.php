<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package MediaKit_Lite
 */

/**
 * Adds custom classes to the array of body classes.
 */
function mkp_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }
    
    // Add class for media kit template
    if ( is_page_template( 'template-media-kit.php' ) ) {
        $classes[] = 'media-kit-template';
    }
    
    // Add class for front page
    if ( is_front_page() ) {
        $classes[] = 'front-page';
    }

    return $classes;
}
add_filter( 'body_class', 'mkp_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mkp_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'mkp_pingback_header' );

/**
 * Changes the excerpt more link
 */
function mkp_excerpt_more_link( $more ) {
    if ( ! is_admin() ) {
        global $post;
        return '... <a class="mkp-read-more" href="' . esc_url( get_permalink( $post->ID ) ) . '">' . __( 'Read More', 'mediakit-lite' ) . '</a>';
    }
    return $more;
}
add_filter( 'excerpt_more', 'mkp_excerpt_more_link' );

/**
 * Add custom classes to navigation menu items
 */
function mkp_nav_menu_css_class( $classes, $item, $args ) {
    if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
        $classes[] = 'mkp-nav__item';
        
        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes ) ) {
            $classes[] = 'mkp-nav__item--active';
        }
    }
    
    return $classes;
}
add_filter( 'nav_menu_css_class', 'mkp_nav_menu_css_class', 10, 3 );

/**
 * Add custom classes to navigation menu links
 */
function mkp_nav_menu_link_attributes( $atts, $item, $args ) {
    if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
        $atts['class'] = 'mkp-nav__link';
    }
    
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'mkp_nav_menu_link_attributes', 10, 3 );

/**
 * Custom search form
 */
function mkp_search_form( $form ) {
    $form = '<form role="search" method="get" class="mkp-search-form" action="' . esc_url( home_url( '/' ) ) . '">
        <label>
            <span class="screen-reader-text">' . esc_html__( 'Search for:', 'mediakit-lite' ) . '</span>
            <input type="search" class="mkp-search-form__field" placeholder="' . esc_attr__( 'Search...', 'mediakit-lite' ) . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="mkp-search-form__submit">
            <span class="screen-reader-text">' . esc_html__( 'Search', 'mediakit-lite' ) . '</span>
            <svg class="mkp-search-form__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
        </button>
    </form>';
    
    return $form;
}
add_filter( 'get_search_form', 'mkp_search_form' );

/**
 * Custom comment form fields
 */
function mkp_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    
    $fields['author'] = '<p class="comment-form-author mkp-form-group">
        <label for="author">' . __( 'Name', 'mediakit-lite' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
        <input id="author" class="mkp-form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
    </p>';
    
    $fields['email'] = '<p class="comment-form-email mkp-form-group">
        <label for="email">' . __( 'Email', 'mediakit-lite' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
        <input id="email" class="mkp-form-control" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
    </p>';
    
    $fields['url'] = '<p class="comment-form-url mkp-form-group">
        <label for="url">' . __( 'Website', 'mediakit-lite' ) . '</label>
        <input id="url" class="mkp-form-control" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
    </p>';
    
    return $fields;
}
add_filter( 'comment_form_default_fields', 'mkp_comment_form_fields' );

/**
 * Get attachment ID from URL
 */
function mkp_get_attachment_id_from_url( $attachment_url = '' ) {
    global $wpdb;
    $attachment_id = false;
    
    if ( '' == $attachment_url ) {
        return;
    }
    
    $upload_dir_paths = wp_upload_dir();
    
    if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
        $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
        $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
    }
    
    return $attachment_id;
}

/**
 * Get related posts
 */
function mkp_get_related_posts( $post_id = null, $number = 3 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $post_type = get_post_type( $post_id );
    $related_posts = array();
    
    // For custom post types, get posts from the same taxonomy
    if ( in_array( $post_type, array( 'speaking_topic', 'media_appearance', 'portfolio_item' ) ) ) {
        $taxonomies = get_object_taxonomies( $post_type );
        
        if ( ! empty( $taxonomies ) ) {
            $terms = wp_get_object_terms( $post_id, $taxonomies[0], array( 'fields' => 'ids' ) );
            
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $args = array(
                    'post_type' => $post_type,
                    'posts_per_page' => $number,
                    'post__not_in' => array( $post_id ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomies[0],
                            'field' => 'term_id',
                            'terms' => $terms,
                        ),
                    ),
                );
                
                $related_posts = get_posts( $args );
            }
        }
    } else {
        // For regular posts, get posts from the same category
        $categories = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
        
        if ( ! empty( $categories ) ) {
            $args = array(
                'category__in' => $categories,
                'posts_per_page' => $number,
                'post__not_in' => array( $post_id ),
            );
            
            $related_posts = get_posts( $args );
        }
    }
    
    // If no related posts found, get recent posts
    if ( empty( $related_posts ) ) {
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $number,
            'post__not_in' => array( $post_id ),
        );
        
        $related_posts = get_posts( $args );
    }
    
    return $related_posts;
}

/**
 * Display star rating
 */
function mkp_star_rating( $rating, $max = 5 ) {
    $output = '<div class="mkp-star-rating" aria-label="' . sprintf( esc_attr__( 'Rating: %s out of %s stars', 'mediakit-lite' ), $rating, $max ) . '">';
    
    for ( $i = 1; $i <= $max; $i++ ) {
        if ( $i <= $rating ) {
            $output .= '<span class="mkp-star mkp-star--filled">★</span>';
        } else {
            $output .= '<span class="mkp-star mkp-star--empty">☆</span>';
        }
    }
    
    $output .= '</div>';
    
    return $output;
}

/**
 * Format large numbers
 */
function mkp_format_number( $number ) {
    if ( $number >= 1000000 ) {
        return round( $number / 1000000, 1 ) . 'M';
    } elseif ( $number >= 1000 ) {
        return round( $number / 1000, 1 ) . 'K';
    }
    
    return $number;
}

/**
 * Get file size in human readable format
 */
function mkp_get_file_size( $file_url ) {
    $file_path = str_replace( wp_get_upload_dir()['baseurl'], wp_get_upload_dir()['basedir'], $file_url );
    
    if ( file_exists( $file_path ) ) {
        $bytes = filesize( $file_path );
        $units = array( 'B', 'KB', 'MB', 'GB' );
        
        for ( $i = 0; $bytes > 1024; $i++ ) {
            $bytes /= 1024;
        }
        
        return round( $bytes, 2 ) . ' ' . $units[ $i ];
    }
    
    return __( 'Unknown', 'mediakit-lite' );
}

/**
 * Check if current page is using a specific template
 */
function mkp_is_page_template( $template ) {
    global $post;
    
    if ( ! $post ) {
        return false;
    }
    
    $page_template = get_page_template_slug( $post->ID );
    
    return $page_template === $template;
}

/**
 * Get social share links
 */
function mkp_get_share_links( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $url = get_permalink( $post_id );
    $title = get_the_title( $post_id );
    $excerpt = get_the_excerpt( $post_id );
    
    $share_links = array(
        'facebook' => array(
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $url ),
            'label' => __( 'Share on Facebook', 'mediakit-lite' ),
            'icon' => 'facebook',
        ),
        'twitter' => array(
            'url' => 'https://twitter.com/intent/tweet?url=' . urlencode( $url ) . '&text=' . urlencode( $title ),
            'label' => __( 'Share on Twitter', 'mediakit-lite' ),
            'icon' => 'twitter',
        ),
        'linkedin' => array(
            'url' => 'https://www.linkedin.com/shareArticle?url=' . urlencode( $url ) . '&title=' . urlencode( $title ) . '&summary=' . urlencode( $excerpt ),
            'label' => __( 'Share on LinkedIn', 'mediakit-lite' ),
            'icon' => 'linkedin',
        ),
        'email' => array(
            'url' => 'mailto:?subject=' . urlencode( $title ) . '&body=' . urlencode( $url ),
            'label' => __( 'Share via Email', 'mediakit-lite' ),
            'icon' => 'email',
        ),
    );
    
    return apply_filters( 'mkp_share_links', $share_links, $post_id );
}

/**
 * Display share buttons
 */
function mkp_share_buttons( $post_id = null ) {
    $share_links = mkp_get_share_links( $post_id );
    
    if ( empty( $share_links ) ) {
        return;
    }
    
    ?>
    <div class="mkp-share-buttons">
        <span class="mkp-share-buttons__label"><?php esc_html_e( 'Share:', 'mediakit-lite' ); ?></span>
        <?php foreach ( $share_links as $platform => $data ) : ?>
            <a href="<?php echo esc_url( $data['url'] ); ?>" class="mkp-share-buttons__link mkp-share-buttons__link--<?php echo esc_attr( $platform ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $data['label'] ); ?>">
                <span class="mkp-share-buttons__icon"><?php echo esc_html( $data['icon'] ); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Get archive title without prefix
 */
function mkp_get_archive_title() {
    $title = get_the_archive_title();
    
    // Remove prefixes like "Category:", "Tag:", etc.
    $title = preg_replace( '/^(Category|Tag|Author|Archives):\s*/', '', $title );
    
    return $title;
}

/**
 * Custom password form
 */
function mkp_password_form() {
    global $post;
    
    $label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
    
    $output = '<form class="mkp-password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
        <p>' . __( 'This content is password protected. To view it please enter your password below:', 'mediakit-lite' ) . '</p>
        <div class="mkp-form-group">
            <label for="' . $label . '">' . __( 'Password:', 'mediakit-lite' ) . '</label>
            <input class="mkp-form-control" name="post_password" id="' . $label . '" type="password" size="20" />
        </div>
        <button type="submit" class="mkp-btn mkp-btn--primary">' . esc_attr__( 'Enter', 'mediakit-lite' ) . '</button>
    </form>';
    
    return $output;
}
add_filter( 'the_password_form', 'mkp_password_form' );

/**
 * Generate front page section navigation
 */
function mkp_get_front_page_nav_items() {
    $nav_items = array();
    
    // Always include Hero
    $nav_items[] = array(
        'id'    => 'hero',
        'label' => __( 'Home', 'mediakit-lite' ),
        'url'   => '#hero',
    );
    
    // Bio Section (Always shown if content exists)
    if ( get_theme_mod( 'mkp_bio_content' ) ) {
        $nav_items[] = array(
            'id'    => 'about',
            'label' => __( 'About', 'mediakit-lite' ),
            'url'   => '#about',
        );
    }
    
    // Books Section
    $books_count = get_theme_mod( 'mkp_books_count', 3 );
    $has_books = false;
    for ( $i = 1; $i <= $books_count; $i++ ) {
        if ( get_theme_mod( 'mkp_book_' . $i . '_title' ) ) {
            $has_books = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_books', true ) && $has_books ) {
        $nav_items[] = array(
            'id'    => 'books',
            'label' => __( 'Books', 'mediakit-lite' ),
            'url'   => '#books',
        );
    }
    
    // Speaker Topics Section
    $has_topics = false;
    for ( $i = 1; $i <= 5; $i++ ) {
        if ( get_theme_mod( 'mkp_speaker_topic_' . $i ) ) {
            $has_topics = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_speaker_topics', true ) && $has_topics ) {
        $nav_items[] = array(
            'id'    => 'speaking',
            'label' => __( 'Speaking', 'mediakit-lite' ),
            'url'   => '#speaking',
        );
    }
    
    // Podcast Section
    if ( get_theme_mod( 'mkp_enable_section_podcast', true ) && get_theme_mod( 'mkp_podcast_name' ) ) {
        $nav_items[] = array(
            'id'    => 'podcast',
            'label' => __( 'Podcast', 'mediakit-lite' ),
            'url'   => '#podcast',
        );
    }
    
    // Corporations Section
    $corps_count = get_theme_mod( 'mkp_corporations_count', 2 );
    $has_corps = false;
    for ( $i = 1; $i <= $corps_count; $i++ ) {
        if ( get_theme_mod( 'mkp_corp_' . $i . '_name' ) ) {
            $has_corps = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_corporations', true ) && $has_corps ) {
        $nav_items[] = array(
            'id'    => 'corporations',
            'label' => __( 'Corporations', 'mediakit-lite' ),
            'url'   => '#corporations',
        );
    }
    
    // Media Questions Section
    $has_questions = false;
    for ( $i = 1; $i <= 12; $i++ ) {
        if ( get_theme_mod( 'mkp_media_question_' . $i ) ) {
            $has_questions = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_media_questions', true ) && $has_questions ) {
        $nav_items[] = array(
            'id'    => 'media-questions',
            'label' => __( 'Interview Q&A', 'mediakit-lite' ),
            'url'   => '#media-questions',
        );
    }
    
    // Investor Section
    if ( get_theme_mod( 'mkp_enable_section_investor', true ) && 
         ( get_theme_mod( 'mkp_investment_people' ) || 
           get_theme_mod( 'mkp_investment_products' ) || 
           get_theme_mod( 'mkp_investment_markets' ) ) ) {
        $nav_items[] = array(
            'id'    => 'investor',
            'label' => __( 'Investor', 'mediakit-lite' ),
            'url'   => '#investor',
        );
    }
    
    // In The Media Section
    $media_count = get_theme_mod( 'mkp_media_items_count', 6 );
    $has_media = false;
    for ( $i = 1; $i <= $media_count; $i++ ) {
        if ( get_theme_mod( 'mkp_media_item_' . $i . '_title' ) ) {
            $has_media = true;
            break;
        }
    }
    if ( get_theme_mod( 'mkp_enable_section_in_the_media', true ) && $has_media ) {
        $nav_items[] = array(
            'id'    => 'media',
            'label' => __( 'Media', 'mediakit-lite' ),
            'url'   => '#media',
        );
    }
    
    // Contact Section
    if ( get_theme_mod( 'mkp_enable_section_contact', true ) ) {
        $nav_items[] = array(
            'id'    => 'contact',
            'label' => __( 'Contact', 'mediakit-lite' ),
            'url'   => '#contact',
        );
    }
    
    return $nav_items;
}