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
    
    <?php 
    // Get the colors from the last section
    $footer_colors = mkp_get_last_section_color();
    $footer_bg = $footer_colors['background'];
    $footer_text = $footer_colors['text'];
    ?>
    
    <footer id="colophon" class="mkp-footer" style="background-color: <?php echo esc_attr( $footer_bg ); ?>; color: <?php echo esc_attr( $footer_text ); ?>;">
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