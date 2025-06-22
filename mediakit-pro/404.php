<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package MediaKit_Pro
 */

get_header();
?>

<main id="primary" class="mkp-main">
    <div class="mkp-container">
        <section class="mkp-error-404">
            <header class="mkp-page-header">
                <h1 class="mkp-page-title"><?php esc_html_e( '404', 'mediakit-pro' ); ?></h1>
                <p class="mkp-page-subtitle"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mediakit-pro' ); ?></p>
            </header>
            
            <div class="mkp-page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'mediakit-pro' ); ?></p>
                
                <?php get_search_form(); ?>
                
                <div class="mkp-404-suggestions">
                    <h2><?php esc_html_e( 'Helpful Links', 'mediakit-pro' ); ?></h2>
                    
                    <div class="mkp-grid mkp-grid--3">
                        <div class="mkp-404-section">
                            <h3><?php esc_html_e( 'Recent Posts', 'mediakit-pro' ); ?></h3>
                            <?php
                            $recent_posts = wp_get_recent_posts( array(
                                'numberposts' => 5,
                                'post_status' => 'publish',
                            ) );
                            
                            if ( $recent_posts ) :
                                ?>
                                <ul>
                                    <?php foreach ( $recent_posts as $post ) : ?>
                                        <li>
                                            <a href="<?php echo esc_url( get_permalink( $post['ID'] ) ); ?>">
                                                <?php echo esc_html( $post['post_title'] ); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mkp-404-section">
                            <h3><?php esc_html_e( 'Categories', 'mediakit-pro' ); ?></h3>
                            <ul>
                                <?php
                                wp_list_categories(
                                    array(
                                        'orderby'    => 'count',
                                        'order'      => 'DESC',
                                        'show_count' => 1,
                                        'title_li'   => '',
                                        'number'     => 5,
                                    )
                                );
                                ?>
                            </ul>
                        </div>
                        
                        <div class="mkp-404-section">
                            <h3><?php esc_html_e( 'Archives', 'mediakit-pro' ); ?></h3>
                            <ul>
                                <?php
                                wp_get_archives(
                                    array(
                                        'type'  => 'monthly',
                                        'limit' => 5,
                                    )
                                );
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();