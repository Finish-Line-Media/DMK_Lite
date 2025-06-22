<?php
/**
 * Admin customizations and functions
 *
 * @package MediaKit_Lite
 */

/**
 * Customize admin dashboard
 */
function mkp_custom_dashboard_widgets() {
    // Remove default dashboard widgets
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
    
    // Add custom dashboard widget
    wp_add_dashboard_widget(
        'mkp_dashboard_widget',
        __( 'Media Kit Overview', 'mediakit-lite' ),
        'mkp_dashboard_widget_display'
    );
}
add_action( 'wp_dashboard_setup', 'mkp_custom_dashboard_widgets' );

/**
 * Display custom dashboard widget
 */
function mkp_dashboard_widget_display() {
    // Get update info
    $remote_data = get_transient( 'mkp_remote_version' );
    $update_available = false;
    
    if ( ! empty( $remote_data['version'] ) ) {
        $current_version = MKP_THEME_VERSION;
        $remote_version = $remote_data['version'];
        $update_available = version_compare( $current_version, $remote_version, '<' );
    }
    ?>
    <div class="mkp-dashboard-widget">
        <h3><?php esc_html_e( 'MediaKit Lite', 'mediakit-lite' ); ?></h3>
        <p><?php esc_html_e( 'Create your professional digital media kit in minutes! Use the Customizer to add your content.', 'mediakit-lite' ); ?></p>
        
        
        <?php if ( $update_available ) : ?>
            <div class="mkp-update-alert" style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; margin: 15px 0; border-radius: 3px;">
                <strong><?php esc_html_e( 'Update Available!', 'mediakit-lite' ); ?></strong>
                <?php printf( esc_html__( 'Version %s is now available.', 'mediakit-lite' ), esc_html( $remote_version ) ); ?>
                <?php if ( ! empty( $remote_data['download_url'] ) ) : ?>
                    <a href="<?php echo esc_url( $remote_data['download_url'] ); ?>" target="_blank"><?php esc_html_e( 'Download', 'mediakit-lite' ); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <h3><?php esc_html_e( 'Quick Actions', 'mediakit-lite' ); ?></h3>
        <div class="mkp-dashboard-actions">
            <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize Theme', 'mediakit-lite' ); ?></a>
            <a href="<?php echo esc_url( site_url() ); ?>" class="button" target="_blank"><?php esc_html_e( 'View Site', 'mediakit-lite' ); ?></a>
            <button type="button" class="button mkp-check-updates-dashboard"><?php esc_html_e( 'Check for Updates', 'mediakit-lite' ); ?></button>
        </div>
        
        <div class="mkp-version-info" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
            <small><?php printf( esc_html__( 'Current Version: %s', 'mediakit-lite' ), MKP_THEME_VERSION ); ?></small>
        </div>
    </div>
    
    <style>
        .mkp-dashboard-stats {
            margin: 0;
        }
        .mkp-dashboard-stats li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mkp-dashboard-stats li:last-child {
            border-bottom: none;
        }
        .mkp-dashboard-stats .dashicons {
            color: #0073aa;
        }
        .mkp-dashboard-stats strong {
            font-size: 18px;
        }
        .mkp-dashboard-stats .button {
            margin-left: auto;
        }
        .mkp-dashboard-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .mkp-recent-downloads {
            margin: 0;
        }
        .mkp-recent-downloads li {
            padding: 5px 0;
            font-size: 13px;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        $('.mkp-check-updates-dashboard').on('click', function() {
            var $button = $(this);
            var originalText = $button.text();
            $button.prop('disabled', true).text('<?php esc_html_e( 'Checking...', 'mediakit-lite' ); ?>');
            
            $.post(ajaxurl, {
                action: 'mkp_force_update_check',
                nonce: '<?php echo wp_create_nonce( 'mkp_force_check' ); ?>'
            }, function(response) {
                if (response.success) {
                    if (response.data.update_available) {
                        alert(response.data.message);
                        location.reload();
                    } else {
                        alert(response.data.message);
                        $button.prop('disabled', false).text(originalText);
                    }
                } else {
                    alert(response.data || '<?php esc_html_e( 'Error checking for updates.', 'mediakit-lite' ); ?>');
                    $button.prop('disabled', false).text(originalText);
                }
            }).fail(function() {
                alert('<?php esc_html_e( 'Network error. Please try again.', 'mediakit-lite' ); ?>');
                $button.prop('disabled', false).text(originalText);
            });
        });
    });
    </script>
    <?php
}

/**
 * Add admin menu pages
 */
function mkp_add_admin_menu() {
    // Main menu
    add_menu_page(
        __( 'Media Kit', 'mediakit-lite' ),
        __( 'Media Kit', 'mediakit-lite' ),
        'manage_options',
        'mediakit-lite',
        'mkp_admin_page_display',
        'dashicons-id-alt',
        30
    );
    
    // Overview submenu
    add_submenu_page(
        'mediakit-lite',
        __( 'Media Kit Overview', 'mediakit-lite' ),
        __( 'Overview', 'mediakit-lite' ),
        'manage_options',
        'mediakit-lite',
        'mkp_admin_page_display'
    );
    
}
add_action( 'admin_menu', 'mkp_add_admin_menu', 5 );


/**
 * Display main admin page
 */
function mkp_admin_page_display() {
    // Get update info
    $remote_data = get_transient( 'mkp_remote_version' );
    $update_available = false;
    
    if ( ! empty( $remote_data['version'] ) ) {
        $current_version = MKP_THEME_VERSION;
        $remote_version = $remote_data['version'];
        $update_available = version_compare( $current_version, $remote_version, '<' );
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <div class="mkp-admin-page">
            <div class="mkp-admin-welcome">
                <h2><?php esc_html_e( 'Welcome to MediaKit Lite', 'mediakit-lite' ); ?></h2>
                <p><strong><?php esc_html_e( 'Create your professional digital media kit in minutes!', 'mediakit-lite' ); ?></strong></p>
                
                <p><?php esc_html_e( 'MediaKit Lite is your digital media kit solution for building personal leverage. Perfect for showcasing your expertise, publications, speaking topics, and media appearances. Set up everything through the simple WordPress Customizer - no coding required. Need a custom-built media kit? Ask about our tailored design services.', 'mediakit-lite' ); ?></p>
                
                <p><strong><?php esc_html_e( 'Quick Start Guide:', 'mediakit-lite' ); ?></strong></p>
                <ol style="margin-left: 20px;">
                    <li><?php esc_html_e( 'Click "Customize Theme" below to open the WordPress Customizer', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Start with "Brand Settings" to set your colors and fonts', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Add your name, photo, and professional tags in "Hero Section"', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Fill in each section with your content (books, speaking topics, etc.)', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Add your social media links to stay connected', 'mediakit-lite' ); ?></li>
                </ol>
                
                <?php if ( $update_available ) : ?>
                    <div class="notice notice-warning inline" style="margin: 20px 0;">
                        <p>
                            <strong><?php esc_html_e( 'Update Available!', 'mediakit-lite' ); ?></strong>
                            <?php printf( esc_html__( 'Version %s is now available.', 'mediakit-lite' ), esc_html( $remote_version ) ); ?>
                            <?php if ( ! empty( $remote_data['download_url'] ) ) : ?>
                                <a href="<?php echo esc_url( $remote_data['download_url'] ); ?>" class="button button-primary" target="_blank" style="margin-left: 10px;"><?php esc_html_e( 'Download Update', 'mediakit-lite' ); ?></a>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mkp-admin-cards">
                <div class="mkp-admin-card">
                    <h3>1. <?php esc_html_e( 'Customize Your Brand', 'mediakit-lite' ); ?></h3>
                    <p><?php esc_html_e( 'Set your colors, fonts, and upload your logo.', 'mediakit-lite' ); ?></p>
                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=mkp_brand_settings' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize Brand', 'mediakit-lite' ); ?></a>
                </div>
                
                <div class="mkp-admin-card">
                    <h3>2. <?php esc_html_e( 'Configure Sections', 'mediakit-lite' ); ?></h3>
                    <p><?php esc_html_e( 'Set up your bio, books, media items, and more.', 'mediakit-lite' ); ?></p>
                    <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button"><?php esc_html_e( 'Configure Sections', 'mediakit-lite' ); ?></a>
                </div>
                
                <div class="mkp-admin-card">
                    <h3>3. <?php esc_html_e( 'Configure Hero Section', 'mediakit-lite' ); ?></h3>
                    <p><?php esc_html_e( 'Set up your homepage hero with background and text.', 'mediakit-lite' ); ?></p>
                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=mkp_hero_section' ) ); ?>" class="button"><?php esc_html_e( 'Setup Hero', 'mediakit-lite' ); ?></a>
                </div>
                
                <div class="mkp-admin-card">
                    <h3>4. <?php esc_html_e( 'Section Order', 'mediakit-lite' ); ?></h3>
                    <p><?php esc_html_e( 'Drag and drop to reorder your front page sections.', 'mediakit-lite' ); ?></p>
                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=mkp_section_order' ) ); ?>" class="button"><?php esc_html_e( 'Manage Sections', 'mediakit-lite' ); ?></a>
                </div>
            </div>
            
            <div class="mkp-admin-upgrade" style="background: #f9f9f9; padding: 20px; margin: 20px 0; border: 1px solid #e0e0e0; border-radius: 3px;">
                <h3 style="margin-top: 0; font-size: 16px; color: #666;"><?php esc_html_e( 'Want More Features?', 'mediakit-lite' ); ?></h3>
                <p style="margin: 10px 0; color: #666; font-size: 14px;"><?php esc_html_e( 'Need a fully customized media kit with advanced features? Finish Line Media can build you a professional, branded media kit starting at just $900.', 'mediakit-lite' ); ?></p>
                <p style="margin: 10px 0; color: #666; font-size: 14px;"><?php esc_html_e( 'We also offer professional WordPress hosting and management for $50/month with no contracts or commitments.', 'mediakit-lite' ); ?></p>
                <p style="margin: 15px 0 0 0;">
                    <a href="https://finishline.media/#form" target="_blank" class="button button-secondary" style="font-size: 13px;"><?php esc_html_e( 'Get a Custom Quote', 'mediakit-lite' ); ?></a>
                    <a href="https://finishline.media" target="_blank" style="margin-left: 10px; font-size: 13px; color: #999;"><?php esc_html_e( 'Learn More →', 'mediakit-lite' ); ?></a>
                </p>
            </div>
            
            <div class="mkp-admin-resources">
                <h2><?php esc_html_e( 'Resources', 'mediakit-lite' ); ?></h2>
                <ul>
                    <li><a href="#" target="_blank"><?php esc_html_e( 'Theme Documentation', 'mediakit-lite' ); ?></a></li>
                    <li><a href="#" target="_blank"><?php esc_html_e( 'Video Tutorials', 'mediakit-lite' ); ?></a></li>
                    <li><a href="#" target="_blank"><?php esc_html_e( 'Support Forum', 'mediakit-lite' ); ?></a></li>
                </ul>
            </div>
            
            <div class="mkp-admin-updates" style="background: #f0f0f1; padding: 20px; margin-top: 20px; border: 1px solid #ccd0d4; border-radius: 3px;">
                <h3 style="margin-top: 0;"><?php esc_html_e( 'Theme Updates', 'mediakit-lite' ); ?></h3>
                <p>
                    <?php printf( esc_html__( 'Current Version: %s', 'mediakit-lite' ), '<strong>' . MKP_THEME_VERSION . '</strong>' ); ?>
                    <?php 
                    $last_checked = get_transient( 'mkp_update_last_checked' );
                    if ( $last_checked ) {
                        echo '<br><small>' . sprintf( esc_html__( 'Last checked: %s', 'mediakit-lite' ), human_time_diff( $last_checked ) . ' ' . esc_html__( 'ago', 'mediakit-lite' ) ) . '</small>';
                    }
                    ?>
                </p>
                <button type="button" class="button button-secondary mkp-check-updates-main"><?php esc_html_e( 'Check for Updates', 'mediakit-lite' ); ?></button>
            </div>
        </div>
    </div>
    
    <style>
        .mkp-admin-page {
            max-width: 1200px;
            margin-top: 20px;
        }
        .mkp-admin-welcome {
            background: #fff;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .mkp-admin-welcome h2 {
            margin-top: 0;
            font-size: 28px;
        }
        .mkp-admin-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .mkp-admin-card {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .mkp-admin-card h3 {
            margin-top: 0;
        }
        .mkp-admin-resources {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .mkp-admin-resources h2 {
            margin-top: 0;
        }
        .mkp-admin-resources ul {
            margin: 0;
            list-style: disc;
            padding-left: 20px;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        $('.mkp-check-updates-main').on('click', function() {
            var $button = $(this);
            var originalText = $button.text();
            $button.prop('disabled', true).text('<?php esc_html_e( 'Checking...', 'mediakit-lite' ); ?>');
            
            $.post(ajaxurl, {
                action: 'mkp_force_update_check',
                nonce: '<?php echo wp_create_nonce( 'mkp_force_check' ); ?>'
            }, function(response) {
                // Log debug information
                if (response.data && response.data.debug) {
                    console.log('MediaKit Lite Update Check Debug:', response.data.debug);
                }
                
                if (response.success) {
                    if (response.data.update_available) {
                        alert(response.data.message);
                        location.reload();
                    } else {
                        alert(response.data.message);
                        $button.prop('disabled', false).text(originalText);
                    }
                } else {
                    var errorMsg = response.data && response.data.message ? response.data.message : '<?php esc_html_e( 'Error checking for updates.', 'mediakit-lite' ); ?>';
                    alert(errorMsg);
                    if (response.data && response.data.debug) {
                        console.error('Update check error debug:', response.data.debug);
                    }
                    $button.prop('disabled', false).text(originalText);
                }
            }).fail(function(xhr, status, error) {
                console.error('Update check network error:', status, error);
                alert('<?php esc_html_e( 'Network error. Please try again.', 'mediakit-lite' ); ?>');
                $button.prop('disabled', false).text(originalText);
            });
        });
    });
    </script>
    <?php
}



/**
 * Add theme info to admin footer
 */
function mkp_admin_footer_text( $text ) {
    $screen = get_current_screen();
    
    if ( strpos( $screen->id, 'mediakit-lite' ) !== false ) {
        $text = sprintf(
            __( 'Thank you for using <strong>MediaKit Lite</strong>. <a href="%s" target="_blank">Leave a review</a>', 'mediakit-lite' ),
            '#'
        );
    }
    
    return $text;
}
add_filter( 'admin_footer_text', 'mkp_admin_footer_text' );

/**
 * Enqueue admin styles
 */
function mkp_admin_styles() {
    $screen = get_current_screen();
    
    if ( strpos( $screen->id, 'mediakit-lite' ) !== false ) {
        wp_enqueue_style( 'mediakit-lite-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), MKP_THEME_VERSION );
    }
}
add_action( 'admin_enqueue_scripts', 'mkp_admin_styles' );

/**
 * Add theme setup wizard
 */
function mkp_theme_activation_redirect() {
    global $pagenow;
    
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
        wp_redirect( admin_url( 'admin.php?page=mediakit-lite' ) );
        exit;
    }
}
add_action( 'admin_init', 'mkp_theme_activation_redirect' );