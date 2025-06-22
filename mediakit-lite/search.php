<?php
/**
 * The template for displaying search results pages
 *
 * @package MediaKit_Lite
 */

get_header();
?>

<main id="primary" class="mkp-main">
    <div class="mkp-container">
        <?php if ( have_posts() ) : ?>
            
            <header class="mkp-page-header">
                <h1 class="mkp-page-title">
                    <?php
                    /* translators: %s: search query. */
                    printf( esc_html__( 'Search Results for: %s', 'mediakit-lite' ), '<span>' . get_search_query() . '</span>' );
                    ?>
                </h1>
                <p class="mkp-search-results-count">
                    <?php
                    $results_count = $wp_query->found_posts;
                    printf(
                        /* translators: %s: number of search results */
                        esc_html( _n( '%s result found', '%s results found', $results_count, 'mediakit-lite' ) ),
                        number_format_i18n( $results_count )
                    );
                    ?>
                </p>
            </header>
            
            <div class="mkp-search-results">
                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();
                    
                    get_template_part( 'template-parts/content', 'search' );
                    
                endwhile;
                ?>
            </div>
            
            <?php mkp_pagination(); ?>
            
        <?php else : ?>
            
            <section class="mkp-no-results">
                <header class="mkp-page-header">
                    <h1 class="mkp-page-title"><?php esc_html_e( 'Nothing Found', 'mediakit-lite' ); ?></h1>
                </header>
                
                <div class="mkp-page-content">
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mediakit-lite' ); ?></p>
                    
                    <?php get_search_form(); ?>
                    
                    <div class="mkp-search-suggestions">
                        <h3><?php esc_html_e( 'Search Suggestions:', 'mediakit-lite' ); ?></h3>
                        <ul>
                            <li><?php esc_html_e( 'Check your spelling', 'mediakit-lite' ); ?></li>
                            <li><?php esc_html_e( 'Try more general keywords', 'mediakit-lite' ); ?></li>
                            <li><?php esc_html_e( 'Try different keywords', 'mediakit-lite' ); ?></li>
                        </ul>
                    </div>
                </div>
            </section>
            
        <?php endif; ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();