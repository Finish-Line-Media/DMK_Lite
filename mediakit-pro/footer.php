<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package MediaKit_Pro
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
                
                <div class="mkp-footer__section">
                    <h3><?php esc_html_e( 'Connect', 'mediakit-pro' ); ?></h3>
                    <?php mkp_social_icons(); ?>
                    
                    <?php
                    $contact_email = get_theme_mod( 'mkp_contact_email_primary' );
                    $contact_phone = get_theme_mod( 'mkp_contact_phone' );
                    
                    if ( $contact_email || $contact_phone ) :
                        ?>
                        <div class="mkp-footer__contact">
                            <?php if ( $contact_email ) : ?>
                                <p>
                                    <a href="mailto:<?php echo esc_attr( $contact_email ); ?>">
                                        <?php echo esc_html( $contact_email ); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ( $contact_phone ) : ?>
                                <p>
                                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>">
                                        <?php echo esc_html( $contact_phone ); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mkp-footer__bottom">
                <nav class="mkp-footer__nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'mediakit-pro' ); ?>">
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
                        esc_html__( '%1$s %2$s. All rights reserved.', 'mediakit-pro' ),
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