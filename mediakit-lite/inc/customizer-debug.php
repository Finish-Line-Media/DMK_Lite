<?php
/**
 * Customizer debug functionality
 *
 * @package MediaKit_Lite
 */

/**
 * Enqueue debug scripts in customizer
 */
function mkp_customizer_debug_scripts() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        wp_enqueue_script( 
            'mediakit-lite-customizer-debug', 
            MKP_THEME_URI . '/assets/js/customizer-debug.js', 
            array( 'jquery', 'customize-controls' ), 
            MKP_THEME_VERSION, 
            true 
        );
    }
}
add_action( 'customize_controls_enqueue_scripts', 'mkp_customizer_debug_scripts' );

/**
 * Add debug info to customizer
 */
function mkp_customizer_debug_info() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        ?>
        <script>
        console.log( '[MediaKit Debug] Customizer loaded' );
        console.log( '[MediaKit Debug] Active theme:', '<?php echo esc_js( get_option( 'stylesheet' ) ); ?>' );
        console.log( '[MediaKit Debug] Theme mod count:', <?php echo count( get_theme_mods() ); ?> );
        </script>
        <?php
    }
}
add_action( 'customize_controls_print_footer_scripts', 'mkp_customizer_debug_info' );