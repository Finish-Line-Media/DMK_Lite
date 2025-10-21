<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package MediaKit_Lite
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="mkp-site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'mediakit-lite' ); ?></a>
    
    <header id="masthead" class="mkp-header">
        <div class="mkp-header__inner mkp-container">
            
            <nav id="site-navigation" class="mkp-header__navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'mediakit-lite' ); ?>">
                <button class="mkp-mobile-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'mediakit-lite' ); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <?php
                // Always display section navigation
                $nav_items = mkp_get_front_page_nav_items();
                if ( ! empty( $nav_items ) ) {
                    echo '<div class="mkp-nav-wrapper">';
                    echo '<button class="mkp-nav-scroll mkp-nav-scroll--left" aria-label="' . esc_attr__( 'Scroll navigation left', 'mediakit-lite' ) . '">&larr;</button>';
                    echo '<ul id="primary-menu" class="mkp-nav">';
                    foreach ( $nav_items as $item ) {
                        // Check if this is the search item
                        if ( isset( $item['type'] ) && 'search' === $item['type'] ) {
                            echo '<li class="mkp-nav__item mkp-nav__item--search">';
                            ?>
                            <form role="search" method="get" class="mkp-nav__search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <label>
                                    <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'mediakit-lite' ); ?></span>
                                    <input type="search" class="mkp-nav__search-field" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'mediakit-lite' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                </label>
                                <button type="submit" class="mkp-nav__search-submit">
                                    <span class="dashicons dashicons-search"></span>
                                    <span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'mediakit-lite' ); ?></span>
                                </button>
                            </form>
                            <?php
                            echo '</li>';
                        } else {
                            echo '<li class="mkp-nav__item">';
                            echo '<a href="' . esc_url( $item['url'] ) . '" class="mkp-nav__link">' . esc_html( $item['label'] ) . '</a>';
                            echo '</li>';
                        }
                    }
                    echo '</ul>';
                    echo '<button class="mkp-nav-scroll mkp-nav-scroll--right" aria-label="' . esc_attr__( 'Scroll navigation right', 'mediakit-lite' ) . '">&rarr;</button>';
                    echo '</div>';
                }
                ?>
            </nav>
        </div>
    </header>
    
    <div id="content" class="mkp-content"><?php mkp_schema_markup(); ?>