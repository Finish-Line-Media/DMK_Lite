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

    // Check if Sahara Sunset theme - use navbar colors for copyright section
    $current_theme = get_theme_mod( 'mkp_color_theme', 'ocean_depths' );
    if ( $current_theme === 'sahara_sunset' ) {
        $copyright_colors = mkp_get_header_colors();
        $copyright_bg = $copyright_colors['background'];
        $copyright_text = '#FFFFFF'; // Force white text for Sahara Sunset
    } else {
        // Other themes use footer colors for copyright
        $copyright_bg = $footer_bg;
        $copyright_text = $footer_text;
    }
    ?>

    <?php if ( $current_theme === 'sahara_sunset' ) : ?>
        <!-- Sticky footer CSS for Sahara Sunset theme -->
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            .mkp-site {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }
            #content {
                flex: 1 0 auto;
            }
            .mkp-footer {
                flex-shrink: 0;
            }
        </style>
    <?php endif; ?>
    
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

            <?php if ( $current_theme !== 'sahara_sunset' ) : ?>
                <!-- For non-Sahara themes, copyright stays inside container -->
                <div class="mkp-footer__bottom" style="background-color: <?php echo esc_attr( $copyright_bg ); ?>; color: <?php echo esc_attr( $copyright_text ); ?>; padding: var(--mkp-spacing-lg) 0; margin-top: var(--mkp-spacing-xl);">
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
            <?php endif; ?>
        </div>

        <?php if ( $current_theme === 'sahara_sunset' ) : ?>
            <!-- For Sahara Sunset, copyright is full-width outside container -->
            <div class="mkp-footer__bottom" style="background-color: <?php echo esc_attr( $copyright_bg ); ?>; color: <?php echo esc_attr( $copyright_text ); ?>; padding: var(--mkp-spacing-xxl) 0; margin-top: var(--mkp-spacing-xl);">
                <div class="mkp-container">
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
        <?php endif; ?>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>