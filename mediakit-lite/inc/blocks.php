<?php
/**
 * Custom Gutenberg Blocks
 *
 * @package MediaKit_Lite
 */

/**
 * Register custom block categories
 */
function mkp_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'mediakit-lite',
                'title' => __( 'MediaKit Lite', 'mediakit-lite' ),
                'icon'  => 'admin-customizer',
            ),
        )
    );
}
add_filter( 'block_categories_all', 'mkp_block_categories', 10, 2 );

/**
 * Register custom blocks
 */
function mkp_register_blocks() {
    // Check if function exists
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }
    
    // Hero Section Block
    register_block_type( 'mediakit-lite/hero-section', array(
        'attributes' => array(
            'backgroundImage' => array(
                'type' => 'string',
                'default' => '',
            ),
            'backgroundVideo' => array(
                'type' => 'string',
                'default' => '',
            ),
            'overlayColor' => array(
                'type' => 'string',
                'default' => 'rgba(0,0,0,0.5)',
            ),
            'headline' => array(
                'type' => 'string',
                'default' => 'Welcome to My Media Kit',
            ),
            'subheadline' => array(
                'type' => 'string',
                'default' => 'Professional Speaker, Author, and Thought Leader',
            ),
            'bioText' => array(
                'type' => 'string',
                'default' => '',
            ),
            'ctaButtons' => array(
                'type' => 'array',
                'default' => array(),
            ),
            'socialLinks' => array(
                'type' => 'boolean',
                'default' => true,
            ),
        ),
        'render_callback' => 'mkp_render_hero_section_block',
        'category' => 'mediakit-lite',
    ) );
    
    // Timeline Block
    register_block_type( 'mediakit-lite/timeline', array(
        'attributes' => array(
            'items' => array(
                'type' => 'array',
                'default' => array(),
            ),
        ),
        'render_callback' => 'mkp_render_timeline_block',
        'category' => 'mediakit-lite',
    ) );
    
    // Stats/Metrics Block
    register_block_type( 'mediakit-lite/stats', array(
        'attributes' => array(
            'stats' => array(
                'type' => 'array',
                'default' => array(),
            ),
            'animated' => array(
                'type' => 'boolean',
                'default' => true,
            ),
        ),
        'render_callback' => 'mkp_render_stats_block',
        'category' => 'mediakit-lite',
    ) );
    
    // Media Logo Bar Block
    register_block_type( 'mediakit-lite/media-logos', array(
        'attributes' => array(
            'logos' => array(
                'type' => 'array',
                'default' => array(),
            ),
            'grayscale' => array(
                'type' => 'boolean',
                'default' => true,
            ),
        ),
        'render_callback' => 'mkp_render_media_logos_block',
        'category' => 'mediakit-lite',
    ) );
    
    // Video Embed Section Block
    register_block_type( 'mediakit-lite/video-section', array(
        'attributes' => array(
            'videoUrl' => array(
                'type' => 'string',
                'default' => '',
            ),
            'videoTitle' => array(
                'type' => 'string',
                'default' => '',
            ),
            'videoDescription' => array(
                'type' => 'string',
                'default' => '',
            ),
            'additionalVideos' => array(
                'type' => 'array',
                'default' => array(),
            ),
        ),
        'render_callback' => 'mkp_render_video_section_block',
        'category' => 'mediakit-lite',
    ) );
    
    // Download Section Block
    register_block_type( 'mediakit-lite/download-section', array(
        'attributes' => array(
            'title' => array(
                'type' => 'string',
                'default' => 'Download Media Kit',
            ),
            'description' => array(
                'type' => 'string',
                'default' => '',
            ),
            'files' => array(
                'type' => 'array',
                'default' => array(),
            ),
            'trackDownloads' => array(
                'type' => 'boolean',
                'default' => true,
            ),
        ),
        'render_callback' => 'mkp_render_download_section_block',
        'category' => 'mediakit-lite',
    ) );
}
add_action( 'init', 'mkp_register_blocks' );

/**
 * Enqueue block editor assets
 */
function mkp_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'mediakit-lite-blocks',
        get_template_directory_uri() . '/assets/js/blocks.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
        MKP_THEME_VERSION,
        true
    );
    
    wp_enqueue_style(
        'mediakit-lite-blocks-editor',
        get_template_directory_uri() . '/assets/css/blocks-editor.css',
        array( 'wp-edit-blocks' ),
        MKP_THEME_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'mkp_enqueue_block_editor_assets' );

/**
 * Render Hero Section Block
 */
function mkp_render_hero_section_block( $attributes ) {
    $background_style = '';
    
    if ( ! empty( $attributes['backgroundImage'] ) ) {
        $background_style = 'background-image: url(' . esc_url( $attributes['backgroundImage'] ) . ');';
    }
    
    ob_start();
    ?>
    <section class="mkp-hero mkp-hero--block" style="<?php echo esc_attr( $background_style ); ?>">
        <?php if ( ! empty( $attributes['backgroundVideo'] ) ) : ?>
            <video class="mkp-hero__video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url( $attributes['backgroundVideo'] ); ?>" type="video/mp4">
            </video>
        <?php endif; ?>
        
        <div class="mkp-hero__overlay" style="background-color: <?php echo esc_attr( $attributes['overlayColor'] ); ?>"></div>
        
        <div class="mkp-container">
            <div class="mkp-hero__content">
                <?php if ( ! empty( $attributes['headline'] ) ) : ?>
                    <h1 class="mkp-hero__title"><?php echo esc_html( $attributes['headline'] ); ?></h1>
                <?php endif; ?>
                
                <?php if ( ! empty( $attributes['subheadline'] ) ) : ?>
                    <p class="mkp-hero__subtitle"><?php echo esc_html( $attributes['subheadline'] ); ?></p>
                <?php endif; ?>
                
                <?php if ( ! empty( $attributes['bioText'] ) ) : ?>
                    <div class="mkp-hero__bio"><?php echo wp_kses_post( $attributes['bioText'] ); ?></div>
                <?php endif; ?>
                
                <?php if ( ! empty( $attributes['ctaButtons'] ) ) : ?>
                    <div class="mkp-hero__buttons">
                        <?php foreach ( $attributes['ctaButtons'] as $button ) : ?>
                            <a href="<?php echo esc_url( $button['url'] ); ?>" class="mkp-btn mkp-btn--<?php echo esc_attr( $button['style'] ); ?>">
                                <?php echo esc_html( $button['text'] ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $attributes['socialLinks'] ) : ?>
                    <?php mkp_social_icons( 'mkp-hero__social' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Render Timeline Block
 */
function mkp_render_timeline_block( $attributes ) {
    if ( empty( $attributes['items'] ) ) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="mkp-timeline">
        <?php foreach ( $attributes['items'] as $item ) : ?>
            <div class="mkp-timeline__item">
                <div class="mkp-timeline__marker">
                    <?php if ( ! empty( $item['icon'] ) ) : ?>
                        <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                    <?php endif; ?>
                </div>
                <div class="mkp-timeline__content">
                    <?php if ( ! empty( $item['date'] ) ) : ?>
                        <time class="mkp-timeline__date"><?php echo esc_html( $item['date'] ); ?></time>
                    <?php endif; ?>
                    <?php if ( ! empty( $item['title'] ) ) : ?>
                        <h3 class="mkp-timeline__title"><?php echo esc_html( $item['title'] ); ?></h3>
                    <?php endif; ?>
                    <?php if ( ! empty( $item['description'] ) ) : ?>
                        <p class="mkp-timeline__description"><?php echo wp_kses_post( $item['description'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Stats Block
 */
function mkp_render_stats_block( $attributes ) {
    if ( empty( $attributes['stats'] ) ) {
        return '';
    }
    
    $animated_class = $attributes['animated'] ? ' mkp-stats--animated' : '';
    
    ob_start();
    ?>
    <div class="mkp-stats<?php echo esc_attr( $animated_class ); ?>">
        <div class="mkp-grid mkp-grid--<?php echo count( $attributes['stats'] ); ?>">
            <?php foreach ( $attributes['stats'] as $stat ) : ?>
                <div class="mkp-stats__item">
                    <?php if ( ! empty( $stat['icon'] ) ) : ?>
                        <div class="mkp-stats__icon">
                            <i class="<?php echo esc_attr( $stat['icon'] ); ?>"></i>
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $stat['number'] ) ) : ?>
                        <div class="mkp-stats__number" data-count="<?php echo esc_attr( $stat['number'] ); ?>">
                            <?php echo $attributes['animated'] ? '0' : esc_html( $stat['number'] ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $stat['label'] ) ) : ?>
                        <div class="mkp-stats__label"><?php echo esc_html( $stat['label'] ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Media Logos Block
 */
function mkp_render_media_logos_block( $attributes ) {
    if ( empty( $attributes['logos'] ) ) {
        return '';
    }
    
    $grayscale_class = $attributes['grayscale'] ? ' mkp-media-logos--grayscale' : '';
    
    ob_start();
    ?>
    <div class="mkp-media-logos<?php echo esc_attr( $grayscale_class ); ?>">
        <div class="mkp-media-logos__grid">
            <?php foreach ( $attributes['logos'] as $logo ) : ?>
                <div class="mkp-media-logos__item">
                    <?php if ( ! empty( $logo['link'] ) ) : ?>
                        <a href="<?php echo esc_url( $logo['link'] ); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url( $logo['image'] ); ?>" 
                         alt="<?php echo esc_attr( $logo['name'] ); ?>" 
                         class="mkp-media-logos__image">
                    
                    <?php if ( ! empty( $logo['link'] ) ) : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Video Section Block
 */
function mkp_render_video_section_block( $attributes ) {
    if ( empty( $attributes['videoUrl'] ) ) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="mkp-video-section">
        <div class="mkp-video-section__featured">
            <?php if ( ! empty( $attributes['videoTitle'] ) ) : ?>
                <h3 class="mkp-video-section__title"><?php echo esc_html( $attributes['videoTitle'] ); ?></h3>
            <?php endif; ?>
            
            <div class="mkp-video-section__embed">
                <?php echo wp_oembed_get( $attributes['videoUrl'] ); ?>
            </div>
            
            <?php if ( ! empty( $attributes['videoDescription'] ) ) : ?>
                <p class="mkp-video-section__description"><?php echo wp_kses_post( $attributes['videoDescription'] ); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if ( ! empty( $attributes['additionalVideos'] ) ) : ?>
            <div class="mkp-video-section__gallery">
                <h4 class="mkp-video-section__gallery-title"><?php esc_html_e( 'More Videos', 'mediakit-lite' ); ?></h4>
                <div class="mkp-grid mkp-grid--3">
                    <?php foreach ( $attributes['additionalVideos'] as $video ) : ?>
                        <div class="mkp-video-section__gallery-item">
                            <div class="mkp-video-section__thumbnail">
                                <?php echo wp_oembed_get( $video['url'] ); ?>
                            </div>
                            <?php if ( ! empty( $video['title'] ) ) : ?>
                                <h5 class="mkp-video-section__gallery-item-title"><?php echo esc_html( $video['title'] ); ?></h5>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Download Section Block
 */
function mkp_render_download_section_block( $attributes ) {
    if ( empty( $attributes['files'] ) ) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="mkp-download-section">
        <?php if ( ! empty( $attributes['title'] ) ) : ?>
            <h2 class="mkp-download-section__title"><?php echo esc_html( $attributes['title'] ); ?></h2>
        <?php endif; ?>
        
        <?php if ( ! empty( $attributes['description'] ) ) : ?>
            <p class="mkp-download-section__description"><?php echo wp_kses_post( $attributes['description'] ); ?></p>
        <?php endif; ?>
        
        <div class="mkp-download-section__files">
            <?php foreach ( $attributes['files'] as $file ) : ?>
                <div class="mkp-download-section__file">
                    <div class="mkp-download-section__file-info">
                        <h4 class="mkp-download-section__file-name"><?php echo esc_html( $file['name'] ); ?></h4>
                        <?php if ( ! empty( $file['description'] ) ) : ?>
                            <p class="mkp-download-section__file-description"><?php echo esc_html( $file['description'] ); ?></p>
                        <?php endif; ?>
                        <span class="mkp-download-section__file-size"><?php echo mkp_get_file_size( $file['url'] ); ?></span>
                    </div>
                    <a href="<?php echo esc_url( $file['url'] ); ?>" 
                       class="mkp-btn mkp-btn--primary mkp-download-section__button" 
                       download
                       <?php if ( $attributes['trackDownloads'] ) : ?>
                       data-track-download="<?php echo esc_attr( $file['id'] ); ?>"
                       <?php endif; ?>>
                        <?php esc_html_e( 'Download', 'mediakit-lite' ); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Register block patterns
 */
function mkp_register_block_patterns() {
    register_block_pattern_category(
        'mediakit-lite',
        array( 'label' => __( 'MediaKit Lite', 'mediakit-lite' ) )
    );
    
    // Media Kit Homepage Pattern
    register_block_pattern(
        'mediakit-lite/media-kit-homepage',
        array(
            'title'       => __( 'Media Kit Homepage', 'mediakit-lite' ),
            'description' => __( 'A complete media kit homepage layout', 'mediakit-lite' ),
            'categories'  => array( 'mediakit-lite' ),
            'content'     => '<!-- wp:mediakit-lite/hero-section /-->
<!-- wp:mediakit-lite/stats /-->
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">Featured In</h2>
<!-- /wp:heading -->
<!-- wp:mediakit-lite/media-logos /-->
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">Speaking Topics</h2>
<!-- /wp:heading -->
<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"speaking_topic","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
<div class="wp-block-query">
<!-- wp:post-template -->
<!-- wp:post-featured-image {"isLink":true} /-->
<!-- wp:post-title {"isLink":true} /-->
<!-- wp:post-excerpt /-->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->',
        )
    );
    
    // Speaker Bio Pattern
    register_block_pattern(
        'mediakit-lite/speaker-bio',
        array(
            'title'       => __( 'Speaker Bio Section', 'mediakit-lite' ),
            'description' => __( 'A professional speaker bio section', 'mediakit-lite' ),
            'categories'  => array( 'mediakit-lite' ),
            'content'     => '<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%">
<!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img alt=""/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%">
<!-- wp:heading -->
<h2>About [Name]</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Insert your professional bio here. This should be a compelling narrative that highlights your expertise, experience, and unique value proposition as a speaker.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">Book Me to Speak</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link">Download One-Sheet</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->',
        )
    );
}
add_action( 'init', 'mkp_register_block_patterns' );