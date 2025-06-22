<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package MediaKit_Lite
 */

?>
    </div><!-- #content -->
    
    <footer id="colophon" class="mkp-footer">
        <div class="mkp-container">
            <div class="mkp-footer__content">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="mkp-footer__section">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="mkp-footer__section">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="mkp-footer__section">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mkp-footer__bottom">
                <nav class="mkp-footer__nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'mediakit-lite' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'mkp-footer__menu',
                            'container'      => false,
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </nav>
                
                <div class="mkp-footer__copyright">
                    <?php
                    printf(
                        /* translators: 1: Copyright symbol and year, 2: Site name */
                        esc_html__( '%1$s %2$s. All rights reserved.', 'mediakit-lite' ),
                        '&copy; ' . date( 'Y' ),
                        get_bloginfo( 'name' )
                    );
                    ?>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>