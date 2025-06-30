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
                    echo '<ul id="primary-menu" class="mkp-nav">';
                    foreach ( $nav_items as $item ) {
                        echo '<li class="mkp-nav__item">';
                        echo '<a href="' . esc_url( $item['url'] ) . '" class="mkp-nav__link">' . esc_html( $item['label'] ) . '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </nav>
        </div>
    </header>
    
    <div id="content" class="mkp-content"><?php mkp_schema_markup(); ?>