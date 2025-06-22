<?php
/**
 * Theme Update Notice System
 * 
 * Checks for theme updates and displays admin notices
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check for theme updates
 */
function mkp_check_for_updates() {
    // Only check on admin pages
    if ( ! is_admin() ) {
        return;
    }
    
    // Check once per day
    $last_checked = get_transient( 'mkp_update_last_checked' );
    if ( $last_checked ) {
        return;
    }
    
    // Your update server URL - change this to your actual URL
    $update_url = 'https://mediakitpro.com/theme-updates/version.json';
    
    // Get remote version info
    $response = wp_remote_get( $update_url, array(
        'timeout' => 10,
        'headers' => array(
            'Accept' => 'application/json',
        ),
    ) );
    
    if ( is_wp_error( $response ) ) {
        // Set transient to check again in 12 hours on error
        set_transient( 'mkp_update_last_checked', time(), 12 * HOUR_IN_SECONDS );
        return;
    }
    
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );
    
    if ( ! empty( $data['version'] ) ) {
        // Store the remote version info
        set_transient( 'mkp_remote_version', $data, DAY_IN_SECONDS );
    }
    
    // Set transient to check again in 24 hours
    set_transient( 'mkp_update_last_checked', time(), DAY_IN_SECONDS );
}
add_action( 'admin_init', 'mkp_check_for_updates' );

/**
 * Display update notice
 */
function mkp_display_update_notice() {
    // Only show to users who can update themes
    if ( ! current_user_can( 'update_themes' ) ) {
        return;
    }
    
    // Get remote version info
    $remote_data = get_transient( 'mkp_remote_version' );
    if ( empty( $remote_data['version'] ) ) {
        return;
    }
    
    // Compare versions
    $current_version = MKP_THEME_VERSION;
    $remote_version = $remote_data['version'];
    
    if ( version_compare( $current_version, $remote_version, '>=' ) ) {
        return;
    }
    
    // Check if notice was dismissed
    $dismissed = get_user_meta( get_current_user_id(), 'mkp_dismissed_update_' . $remote_version, true );
    if ( $dismissed ) {
        return;
    }
    
    $download_url = ! empty( $remote_data['download_url'] ) ? $remote_data['download_url'] : 'https://mediakitpro.com/downloads/';
    $changelog_url = ! empty( $remote_data['changelog_url'] ) ? $remote_data['changelog_url'] : '';
    ?>
    <div class="notice notice-info is-dismissible mkp-update-notice" data-version="<?php echo esc_attr( $remote_version ); ?>">
        <p>
            <strong><?php esc_html_e( 'MediaKit Lite Theme Update Available!', 'mediakit-lite' ); ?></strong>
        </p>
        <p>
            <?php
            printf(
                esc_html__( 'A new version (%1$s) of MediaKit Lite is available. You are currently using version %2$s.', 'mediakit-lite' ),
                esc_html( $remote_version ),
                esc_html( $current_version )
            );
            ?>
        </p>
        
        <?php if ( ! empty( $remote_data['description'] ) ) : ?>
            <p><?php echo esc_html( $remote_data['description'] ); ?></p>
        <?php endif; ?>
        
        <p>
            <a href="<?php echo esc_url( $download_url ); ?>" class="button button-primary" target="_blank">
                <?php esc_html_e( 'Download Update', 'mediakit-lite' ); ?>
            </a>
            
            <?php if ( $changelog_url ) : ?>
                <a href="<?php echo esc_url( $changelog_url ); ?>" class="button" target="_blank">
                    <?php esc_html_e( 'View Changelog', 'mediakit-lite' ); ?>
                </a>
            <?php endif; ?>
            
            <a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>" class="button">
                <?php esc_html_e( 'Go to Themes', 'mediakit-lite' ); ?>
            </a>
        </p>
        
        <p>
            <small>
                <?php esc_html_e( 'To update: 1) Download the new version, 2) Go to Themes, 3) Delete the current theme, 4) Upload the new mediakit-lite.zip file.', 'mediakit-lite' ); ?>
            </small>
        </p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('.mkp-update-notice').on('click', '.notice-dismiss', function() {
            var version = $(this).parent().data('version');
            $.post(ajaxurl, {
                action: 'mkp_dismiss_update_notice',
                version: version,
                nonce: '<?php echo wp_create_nonce( 'mkp_dismiss_update' ); ?>'
            });
        });
    });
    </script>
    <?php
}
add_action( 'admin_notices', 'mkp_display_update_notice' );

/**
 * Handle AJAX dismiss notice
 */
function mkp_dismiss_update_notice() {
    check_ajax_referer( 'mkp_dismiss_update', 'nonce' );
    
    $version = sanitize_text_field( $_POST['version'] );
    update_user_meta( get_current_user_id(), 'mkp_dismissed_update_' . $version, true );
    
    wp_die();
}
add_action( 'wp_ajax_mkp_dismiss_update_notice', 'mkp_dismiss_update_notice' );

/**
 * Add theme update check to theme info
 */
function mkp_add_theme_update_info() {
    // Only run on themes page
    if ( ! isset( $GLOBALS['pagenow'] ) || $GLOBALS['pagenow'] !== 'themes.php' ) {
        return;
    }
    
    // Get current theme
    $current_theme = wp_get_theme();
    if ( $current_theme->get( 'Name' ) !== 'MediaKit Lite' ) {
        return;
    }
    
    $remote_data = get_transient( 'mkp_remote_version' );
    if ( empty( $remote_data['version'] ) ) {
        return;
    }
    
    $current_version = MKP_THEME_VERSION;
    $remote_version = $remote_data['version'];
    
    if ( version_compare( $current_version, $remote_version, '<' ) ) {
        add_action( 'admin_footer', function() use ( $remote_version ) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                var themeCard = $('.theme[data-slug="mediakit-lite"]');
                if (themeCard.length) {
                    themeCard.addClass('update');
                    themeCard.find('.theme-name').append('<span class="update-message"><?php echo esc_js( sprintf( __( 'Update Available: %s', 'mediakit-lite' ), $remote_version ) ); ?></span>');
                }
            });
            </script>
            <style>
            .theme[data-slug="mediakit-lite"] .update-message {
                display: block;
                font-size: 12px;
                color: #d63638;
                margin-top: 5px;
            }
            </style>
            <?php
        });
    }
}
add_action( 'admin_init', 'mkp_add_theme_update_info' );

/**
 * Clear update cache on theme switch
 */
function mkp_clear_update_cache() {
    delete_transient( 'mkp_update_last_checked' );
    delete_transient( 'mkp_remote_version' );
}
add_action( 'switch_theme', 'mkp_clear_update_cache' );