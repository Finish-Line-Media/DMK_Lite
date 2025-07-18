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

    // Add sidebar-related classes
    if ( mkp_should_show_sidebar() ) {
        $classes[] = 'has-sidebar';
    } else {
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
            <input type="search" id="mkp-search-field" class="mkp-search-form__field" placeholder="' . esc_attr__( 'Search...', 'mediakit-lite' ) . '" value="' . get_search_query() . '" name="s" />
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
            'icon' => 'dashicons-facebook-alt',
        ),
        'twitter' => array(
            'url' => 'https://twitter.com/intent/tweet?url=' . urlencode( $url ) . '&text=' . urlencode( $title ),
            'label' => __( 'Share on Twitter', 'mediakit-lite' ),
            'icon' => 'dashicons-twitter',
        ),
        'linkedin' => array(
            'url' => 'https://www.linkedin.com/shareArticle?url=' . urlencode( $url ) . '&title=' . urlencode( $title ) . '&summary=' . urlencode( $excerpt ),
            'label' => __( 'Share on LinkedIn', 'mediakit-lite' ),
            'icon' => 'dashicons-linkedin',
        ),
        'email' => array(
            'url' => 'mailto:?subject=' . urlencode( $title ) . '&body=' . urlencode( $url ),
            'label' => __( 'Share via Email', 'mediakit-lite' ),
            'icon' => 'dashicons-email-alt',
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
                <span class="dashicons <?php echo esc_attr( $data['icon'] ); ?>"></span>
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
    
    // Get the section order
    $section_order = mkp_get_section_order();
    
    // Determine if we're on the front page
    $is_front = is_front_page();
    $base_url = $is_front ? '' : home_url( '/' );
    
    // Define section properties
    $section_config = array(
        'hero' => array(
            'id'    => 'hero',
            'label' => __( 'Home', 'mediakit-lite' ),
            'url'   => $base_url . '#hero',
            'check' => true, // Always show
        ),
        'about' => array(
            'id'    => 'about',
            'label' => __( 'About', 'mediakit-lite' ),
            'url'   => $base_url . '#about',
            'check' => function() {
                // About section has default content, so always show unless explicitly empty
                $content = get_theme_mod( 'mkp_about_content', mkp_get_default_about_content() );
                return ! empty( $content );
            },
        ),
        'books' => array(
            'id'    => 'books',
            'label' => __( 'Books', 'mediakit-lite' ),
            'url'   => $base_url . '#books',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_books', false );
            },
        ),
        'podcasts' => array(
            'id'    => 'podcasts',
            'label' => __( 'Podcasts', 'mediakit-lite' ),
            'url'   => $base_url . '#podcasts',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_podcasts', false );
            },
        ),
        'gallery' => array(
            'id'    => 'gallery',
            'label' => __( 'Gallery', 'mediakit-lite' ),
            'url'   => $base_url . '#gallery',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_gallery', false );
            },
        ),
        'corporations' => array(
            'id'    => 'corporations',
            'label' => __( 'Companies', 'mediakit-lite' ),
            'url'   => $base_url . '#corporations',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_corporations', false );
            },
        ),
        'speaker_topics' => array(
            'id'    => 'speaking',
            'label' => __( 'Speaking', 'mediakit-lite' ),
            'url'   => $base_url . '#speaker_topics',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_speaker_topics', false );
            },
        ),
        'featured_video' => array(
            'id'    => 'featured-video',
            'label' => __( 'Featured Video', 'mediakit-lite' ),
            'url'   => $base_url . '#featured-video',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_featured_video', false );
            },
        ),
        'testimonials' => array(
            'id'    => 'testimonials',
            'label' => __( 'Testimonials', 'mediakit-lite' ),
            'url'   => $base_url . '#testimonials',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_testimonials', false );
            },
        ),
        'awards' => array(
            'id'    => 'awards',
            'label' => __( 'Awards', 'mediakit-lite' ),
            'url'   => $base_url . '#awards',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_awards', false );
            },
        ),
        'media_features' => array(
            'id'    => 'media-features',
            'label' => __( 'Featured In', 'mediakit-lite' ),
            'url'   => $base_url . '#media-features',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_media_features', false );
            },
        ),
        'stats' => array(
            'id'    => 'stats',
            'label' => __( 'Stats', 'mediakit-lite' ),
            'url'   => $base_url . '#stats',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_stats', false );
            },
        ),
        'in_the_media' => array(
            'id'    => 'in-the-media',
            'label' => __( 'In The Media', 'mediakit-lite' ),
            'url'   => $base_url . '#in_the_media',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_in_the_media', false );
            },
        ),
        'media_questions' => array(
            'id'    => 'media-questions',
            'label' => __( 'Media Questions', 'mediakit-lite' ),
            'url'   => $base_url . '#media_questions',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_media_questions', false );
            },
        ),
        'investor' => array(
            'id'    => 'investor',
            'label' => __( 'Investor', 'mediakit-lite' ),
            'url'   => $base_url . '#investor',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_investor', false );
            },
        ),
        'contact' => array(
            'id'    => 'contact',
            'label' => __( 'Contact', 'mediakit-lite' ),
            'url'   => $base_url . '#contact',
            'check' => function() {
                return get_theme_mod( 'mkp_enable_section_contact', false );
            },
        ),
    );
    
    // Build nav items in the order specified
    foreach ( $section_order as $section ) {
        if ( ! isset( $section_config[ $section ] ) ) {
            continue;
        }
        
        $config = $section_config[ $section ];
        
        // Check if section should be included
        $should_include = false;
        if ( isset( $config['check'] ) ) {
            if ( is_callable( $config['check'] ) ) {
                $should_include = call_user_func( $config['check'] );
            } else {
                $should_include = $config['check'];
            }
        }
        
        if ( $should_include ) {
            $nav_items[] = array(
                'id'    => $config['id'],
                'label' => $config['label'],
                'url'   => $config['url'],
            );
        }
    }
    
    // Add Blog link if WordPress is configured with a posts page and it's enabled in settings
    $show_on_front = get_option( 'show_on_front' );
    $page_for_posts = get_option( 'page_for_posts' );
    $show_blog_in_nav = get_theme_mod( 'mkp_show_blog_in_nav', false );
    
    if ( 'page' === $show_on_front && $page_for_posts && $show_blog_in_nav ) {
        $nav_items[] = array(
            'id'    => 'blog',
            'label' => __( 'Blog', 'mediakit-lite' ),
            'url'   => get_permalink( $page_for_posts ),
        );
    }
    
    // Add search to navigation if enabled
    $enable_search = get_theme_mod( 'mkp_enable_search', false );
    if ( $enable_search ) {
        $nav_items[] = array(
            'id'    => 'search',
            'label' => __( 'Search', 'mediakit-lite' ),
            'url'   => '#search', // This will be handled specially in header.php
            'type'  => 'search', // Special type to identify this as search
        );
    }
    
    return $nav_items;
}

/**
 * Check if a URL is embeddable via oEmbed
 *
 * @param string $url The URL to check
 * @return bool
 */
function mkp_is_embeddable_url( $url ) {
    if ( empty( $url ) ) {
        return false;
    }
    
    // Common embeddable domains
    $embeddable_domains = array(
        'youtube.com',
        'youtu.be',
        'vimeo.com',
        'soundcloud.com',
        'spotify.com',
        'twitter.com',
        'x.com',
        'facebook.com',
        'instagram.com',
        'tiktok.com',
        'dailymotion.com',
        'ted.com',
        'wordpress.tv',
        'videopress.com',
        'mixcloud.com',
        'reverbnation.com',
        'kickstarter.com',
        'issuu.com',
        'slideshare.net',
        'scribd.com',
    );
    
    $parsed_url = wp_parse_url( $url );
    if ( ! $parsed_url || ! isset( $parsed_url['host'] ) ) {
        return false;
    }
    
    $host = strtolower( $parsed_url['host'] );
    $host = preg_replace( '/^www\./', '', $host );
    
    foreach ( $embeddable_domains as $domain ) {
        if ( $host === $domain || strpos( $host, '.' . $domain ) !== false ) {
            return true;
        }
    }
    
    // Also check if WordPress can handle it via oEmbed
    $oembed = _wp_oembed_get_object();
    return $oembed->get_provider( $url, array() ) !== false;
}

/**
 * Check if sidebar should be shown based on current page and settings
 *
 * @return bool
 */
function mkp_should_show_sidebar() {
    // Check if sidebar is enabled
    if ( ! get_theme_mod( 'mkp_enable_blog_sidebar', false ) ) {
        return false;
    }
    
    // Check if widgets are available
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        return false;
    }
    
    // Check if we're on the blog page (posts page)
    if ( is_home() ) {
        return get_theme_mod( 'mkp_sidebar_show_blog', true );
    }
    
    // Check if we're on a single post page
    if ( is_single() ) {
        return get_theme_mod( 'mkp_sidebar_show_posts', true );
    }
    
    // Check if we're on an archive page (category, tag, date, author, etc.)
    if ( is_archive() ) {
        return get_theme_mod( 'mkp_sidebar_show_archive', true );
    }
    
    // Don't show sidebar on other pages
    return false;
}