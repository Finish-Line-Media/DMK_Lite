<?php
/**
 * Theme Update Notice System - GitHub Integration
 * 
 * Checks for theme updates from GitHub releases and displays admin notices
 *
 * @package MediaKit_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check for theme updates from GitHub
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
    
    // GitHub API endpoint for latest release
    $github_api_url = 'https://api.github.com/repos/Finish-Line-Media/DMK_Lite/releases/latest';
    
    // Primary method: Check GitHub API
    $response = wp_remote_get( $github_api_url, array(
        'timeout' => 10,
        'headers' => array(
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'MediaKit-Lite-Theme/' . MKP_THEME_VERSION,
        ),
    ) );
    
    if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
        $body = wp_remote_retrieve_body( $response );
        $release_data = json_decode( $body, true );
        
        if ( ! empty( $release_data['tag_name'] ) ) {
            // Remove 'v' prefix if present
            $version = ltrim( $release_data['tag_name'], 'v' );
            
            // Find the theme ZIP asset
            $download_url = '';
            if ( ! empty( $release_data['assets'] ) ) {
                foreach ( $release_data['assets'] as $asset ) {
                    if ( $asset['name'] === 'mediakit-lite.zip' ) {
                        $download_url = $asset['browser_download_url'];
                        break;
                    }
                }
            }
            
            // Fallback to zipball if no asset found
            if ( empty( $download_url ) && ! empty( $release_data['zipball_url'] ) ) {
                $download_url = $release_data['zipball_url'];
            }
            
            $update_data = array(
                'version' => $version,
                'description' => $release_data['name'] ?? '',
                'body' => $release_data['body'] ?? '',
                'download_url' => $download_url,
                'changelog_url' => $release_data['html_url'] ?? '',
                'release_date' => $release_data['published_at'] ?? '',
                'prerelease' => $release_data['prerelease'] ?? false,
            );
            
            // Store the remote version info
            set_transient( 'mkp_remote_version', $update_data, DAY_IN_SECONDS );
            set_transient( 'mkp_update_last_checked', time(), DAY_IN_SECONDS );
            return;
        }
    }
    
    // Fallback method: Check version.json in repository
    $version_url = 'https://raw.githubusercontent.com/Finish-Line-Media/DMK_Lite/main/version.json';
    
    $response = wp_remote_get( $version_url, array(
        'timeout' => 10,
        'headers' => array(
            'Accept' => 'application/json',
        ),
    ) );
    
    if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        
        if ( ! empty( $data['version'] ) ) {
            // Store the remote version info
            set_transient( 'mkp_remote_version', $data, DAY_IN_SECONDS );
        }
    }
    
    // Set transient to check again in 24 hours (or 12 hours on error)
    $check_interval = is_wp_error( $response ) ? 12 * HOUR_IN_SECONDS : DAY_IN_SECONDS;
    set_transient( 'mkp_update_last_checked', time(), $check_interval );
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
    
    // Skip prereleases unless explicitly enabled
    if ( ! empty( $remote_data['prerelease'] ) && ! apply_filters( 'mkp_show_prerelease_updates', false ) ) {
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
    
    $download_url = ! empty( $remote_data['download_url'] ) ? $remote_data['download_url'] : '#';
    $changelog_url = ! empty( $remote_data['changelog_url'] ) ? $remote_data['changelog_url'] : '';
    ?>
    <div class="notice notice-info is-dismissible mkp-update-notice" data-version="<?php echo esc_attr( $remote_version ); ?>">
        <p>
            <strong><?php esc_html_e( 'MediaKit Lite Theme Update Available!', 'mediakit-lite' ); ?></strong>
        </p>
        <p>
            <?php
            printf(
                esc_html__( 'Version %1$s is now available. You are currently using version %2$s.', 'mediakit-lite' ),
                esc_html( $remote_version ),
                esc_html( $current_version )
            );
            ?>
        </p>
        
        <?php if ( ! empty( $remote_data['description'] ) ) : ?>
            <p><strong><?php echo esc_html( $remote_data['description'] ); ?></strong></p>
        <?php endif; ?>
        
        <?php if ( ! empty( $remote_data['body'] ) ) : ?>
            <details style="margin: 10px 0;">
                <summary style="cursor: pointer;"><?php esc_html_e( 'View release notes', 'mediakit-lite' ); ?></summary>
                <div style="margin-top: 10px; padding: 10px; background: #f0f0f0; border-radius: 3px;">
                    <?php echo wp_kses_post( wpautop( $remote_data['body'] ) ); ?>
                </div>
            </details>
        <?php endif; ?>
        
        <p>
            <?php if ( $download_url !== '#' ) : ?>
                <a href="<?php echo esc_url( $download_url ); ?>" class="button button-primary" target="_blank">
                    <?php esc_html_e( 'Download Update', 'mediakit-lite' ); ?>
                </a>
            <?php endif; ?>
            
            <?php if ( $changelog_url ) : ?>
                <a href="<?php echo esc_url( $changelog_url ); ?>" class="button" target="_blank">
                    <?php esc_html_e( 'View on GitHub', 'mediakit-lite' ); ?>
                </a>
            <?php endif; ?>
            
            <a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>" class="button">
                <?php esc_html_e( 'Go to Themes', 'mediakit-lite' ); ?>
            </a>
            
            <button type="button" class="button mkp-check-updates" style="margin-left: 5px;">
                <?php esc_html_e( 'Check Again', 'mediakit-lite' ); ?>
            </button>
        </p>
        
        <p>
            <small>
                <?php esc_html_e( 'To update: 1) Download the new version, 2) Go to Themes, 3) Delete the current theme, 4) Upload the new mediakit-lite.zip file.', 'mediakit-lite' ); ?>
            </small>
        </p>
        
        <?php if ( ! empty( $remote_data['release_date'] ) ) : ?>
            <p>
                <small>
                    <?php
                    $release_date = date_i18n( get_option( 'date_format' ), strtotime( $remote_data['release_date'] ) );
                    printf( esc_html__( 'Released on %s', 'mediakit-lite' ), esc_html( $release_date ) );
                    ?>
                </small>
            </p>
        <?php endif; ?>
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
        
        $('.mkp-check-updates').on('click', function() {
            var $button = $(this);
            $button.prop('disabled', true).text('<?php esc_html_e( 'Checking...', 'mediakit-lite' ); ?>');
            
            $.post(ajaxurl, {
                action: 'mkp_force_update_check',
                nonce: '<?php echo wp_create_nonce( 'mkp_force_check' ); ?>'
            }, function() {
                location.reload();
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
 * Handle AJAX force update check
 */
function mkp_force_update_check() {
    check_ajax_referer( 'mkp_force_check', 'nonce' );
    
    // Clear transients to force a new check
    delete_transient( 'mkp_update_last_checked' );
    delete_transient( 'mkp_remote_version' );
    
    // Run update check
    mkp_check_for_updates();
    
    wp_die();
}
add_action( 'wp_ajax_mkp_force_update_check', 'mkp_force_update_check' );

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
        add_action( 'admin_footer', function() use ( $remote_version, $remote_data ) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                var themeCard = $('.theme[data-slug="mediakit-lite"]');
                if (themeCard.length) {
                    themeCard.addClass('update');
                    themeCard.find('.theme-name').append('<span class="update-message"><?php echo esc_js( sprintf( __( 'Update Available: %s', 'mediakit-lite' ), $remote_version ) ); ?></span>');
                    
                    // Add update button to theme details
                    var updateHtml = '<div class="theme-update-message notice inline notice-warning notice-alt"><p>';
                    updateHtml += '<?php echo esc_js( sprintf( __( 'New version available: %s', 'mediakit-lite' ), $remote_version ) ); ?> ';
                    <?php if ( ! empty( $remote_data['download_url'] ) ) : ?>
                    updateHtml += '<a href="<?php echo esc_js( $remote_data['download_url'] ); ?>" target="_blank"><?php esc_html_e( 'Download now', 'mediakit-lite' ); ?></a>';
                    <?php endif; ?>
                    updateHtml += '</p></div>';
                    
                    // Add to theme overlay when opened
                    $(document).on('click', '.theme[data-slug="mediakit-lite"]', function() {
                        setTimeout(function() {
                            var $overlay = $('.theme-overlay.active');
                            if ($overlay.length && !$overlay.find('.theme-update-message').length) {
                                $overlay.find('.theme-info').prepend(updateHtml);
                            }
                        }, 100);
                    });
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
            .theme-update-message {
                margin: 0 0 20px 0 !important;
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

/**
 * Add update check link to theme page
 */
function mkp_add_update_check_link( $links, $theme ) {
    if ( $theme->get( 'Name' ) === 'MediaKit Lite' ) {
        $links['check_update'] = sprintf(
            '<a href="%s" class="mkp-check-theme-update">%s</a>',
            wp_nonce_url( admin_url( 'themes.php?action=mkp_check_update' ), 'mkp_check_update' ),
            __( 'Check for updates', 'mediakit-lite' )
        );
    }
    return $links;
}
add_filter( 'theme_action_links', 'mkp_add_update_check_link', 10, 2 );

/**
 * Handle manual update check from theme page
 */
function mkp_handle_manual_update_check() {
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'mkp_check_update' ) {
        check_admin_referer( 'mkp_check_update' );
        
        // Clear transients
        delete_transient( 'mkp_update_last_checked' );
        delete_transient( 'mkp_remote_version' );
        
        // Redirect back to themes page
        wp_redirect( admin_url( 'themes.php' ) );
        exit;
    }
}
add_action( 'admin_init', 'mkp_handle_manual_update_check' );