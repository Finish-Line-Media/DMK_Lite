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
    ?>
    <div class="mkp-dashboard-widget">
        <h3><?php esc_html_e( 'Welcome to MediaKit Lite', 'mediakit-lite' ); ?></h3>
        <p><?php esc_html_e( 'Your professional media kit theme is ready. Use the Customizer to configure your content.', 'mediakit-lite' ); ?></p>
        
        <h3><?php esc_html_e( 'Quick Actions', 'mediakit-lite' ); ?></h3>
        <div class="mkp-dashboard-actions">
            <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize Theme', 'mediakit-lite' ); ?></a>
            <a href="<?php echo esc_url( site_url() ); ?>" class="button" target="_blank"><?php esc_html_e( 'View Site', 'mediakit-lite' ); ?></a>
        </div>
        
        <?php
        // Get recent downloads if tracking is enabled
        $recent_downloads = get_option( 'mkp_recent_downloads', array() );
        if ( ! empty( $recent_downloads ) ) : ?>
            <h3><?php esc_html_e( 'Recent Downloads', 'mediakit-lite' ); ?></h3>
            <ul class="mkp-recent-downloads">
                <?php foreach ( array_slice( $recent_downloads, 0, 5 ) as $download ) : ?>
                    <li>
                        <?php echo esc_html( $download['file'] ); ?> - 
                        <time><?php echo esc_html( human_time_diff( $download['time'], current_time( 'timestamp' ) ) ); ?> <?php esc_html_e( 'ago', 'mediakit-lite' ); ?></time>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
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
    
    // Add a divider
    add_submenu_page(
        'mediakit-lite',
        '<span style="display:block; margin:1px 0 1px -5px; padding:0; height:1px; line-height:1px; background:#CCC;"></span>',
        '',
        'read',
        '#',
        ''
    );
    
    // Stats submenu
    add_submenu_page(
        'mediakit-lite',
        __( 'Download Statistics', 'mediakit-lite' ),
        __( 'Download Stats', 'mediakit-lite' ),
        'manage_options',
        'mediakit-lite-stats',
        'mkp_stats_page_display'
    );
    
    // Import/Export submenu
    add_submenu_page(
        'mediakit-lite',
        __( 'Import/Export', 'mediakit-lite' ),
        __( 'Import/Export', 'mediakit-lite' ),
        'manage_options',
        'mediakit-lite-import-export',
        'mkp_import_export_page_display'
    );
}
add_action( 'admin_menu', 'mkp_add_admin_menu', 5 );


/**
 * Display main admin page
 */
function mkp_admin_page_display() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <div class="mkp-admin-page">
            <div class="mkp-admin-welcome">
                <h2><?php esc_html_e( 'Welcome to MediaKit Lite', 'mediakit-lite' ); ?></h2>
                <p><?php esc_html_e( 'Your professional media kit theme is ready to showcase your work. Follow these steps to get started:', 'mediakit-lite' ); ?></p>
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
                    <h3>4. <?php esc_html_e( 'Add Social Links', 'mediakit-lite' ); ?></h3>
                    <p><?php esc_html_e( 'Connect your social media profiles.', 'mediakit-lite' ); ?></p>
                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=mkp_social_media' ) ); ?>" class="button"><?php esc_html_e( 'Add Social Links', 'mediakit-lite' ); ?></a>
                </div>
            </div>
            
            <div class="mkp-admin-resources">
                <h2><?php esc_html_e( 'Resources', 'mediakit-lite' ); ?></h2>
                <ul>
                    <li><a href="#" target="_blank"><?php esc_html_e( 'Theme Documentation', 'mediakit-lite' ); ?></a></li>
                    <li><a href="#" target="_blank"><?php esc_html_e( 'Video Tutorials', 'mediakit-lite' ); ?></a></li>
                    <li><a href="#" target="_blank"><?php esc_html_e( 'Support Forum', 'mediakit-lite' ); ?></a></li>
                </ul>
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
    <?php
}

/**
 * Display statistics page
 */
function mkp_stats_page_display() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <div class="mkp-stats-page">
            <?php
            // Get download statistics
            $downloads = get_option( 'mkp_download_stats', array() );
            
            if ( empty( $downloads ) ) {
                echo '<p>' . esc_html__( 'No download statistics available yet.', 'mediakit-lite' ) . '</p>';
            } else {
                ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'File', 'mediakit-lite' ); ?></th>
                            <th><?php esc_html_e( 'Downloads', 'mediakit-lite' ); ?></th>
                            <th><?php esc_html_e( 'Last Downloaded', 'mediakit-lite' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $downloads as $file_id => $data ) : ?>
                            <tr>
                                <td><?php echo esc_html( get_the_title( $file_id ) ); ?></td>
                                <td><?php echo esc_html( $data['count'] ); ?></td>
                                <td>
                                    <?php 
                                    if ( isset( $data['last_download'] ) ) {
                                        echo esc_html( human_time_diff( $data['last_download'], current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'mediakit-lite' ) );
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Display import/export page
 */
function mkp_import_export_page_display() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <div class="mkp-import-export-page">
            <div class="mkp-export-section">
                <h2><?php esc_html_e( 'Export Media Kit', 'mediakit-lite' ); ?></h2>
                <p><?php esc_html_e( 'Export your media kit content to a file that can be imported into another WordPress site.', 'mediakit-lite' ); ?></p>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php wp_nonce_field( 'mkp_export_nonce' ); ?>
                    <input type="hidden" name="action" value="mkp_export_media_kit">
                    <p>
                        <label>
                            <input type="checkbox" name="export_settings" value="1" checked>
                            <?php esc_html_e( 'Include Theme Settings', 'mediakit-lite' ); ?>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="checkbox" name="export_customizer" value="1" checked>
                            <?php esc_html_e( 'Include Customizer Settings', 'mediakit-lite' ); ?>
                        </label>
                    </p>
                    <p class="submit">
                        <input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Export Media Kit', 'mediakit-lite' ); ?>">
                    </p>
                </form>
            </div>
            
            <hr>
            
            <div class="mkp-import-section">
                <h2><?php esc_html_e( 'Import Media Kit', 'mediakit-lite' ); ?></h2>
                <p><?php esc_html_e( 'Import media kit content from an export file.', 'mediakit-lite' ); ?></p>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
                    <?php wp_nonce_field( 'mkp_import_nonce' ); ?>
                    <input type="hidden" name="action" value="mkp_import_media_kit">
                    <p>
                        <label for="import_file"><?php esc_html_e( 'Choose file:', 'mediakit-lite' ); ?></label>
                        <input type="file" name="import_file" id="import_file" accept=".json">
                    </p>
                    <p class="submit">
                        <input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Import Media Kit', 'mediakit-lite' ); ?>">
                    </p>
                </form>
            </div>
            
            <hr>
            
            <div class="mkp-demo-content-section">
                <h2><?php esc_html_e( 'Demo Content', 'mediakit-lite' ); ?></h2>
                <p><?php esc_html_e( 'Install demo content to see how the theme works.', 'mediakit-lite' ); ?></p>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php wp_nonce_field( 'mkp_demo_content_nonce' ); ?>
                    <input type="hidden" name="action" value="mkp_install_demo_content">
                    <p class="submit">
                        <input type="submit" class="button" value="<?php esc_attr_e( 'Install Demo Content', 'mediakit-lite' ); ?>" onclick="return confirm('<?php esc_attr_e( 'This will create sample posts and pages. Continue?', 'mediakit-lite' ); ?>');">
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    <style>
        .mkp-import-export-page {
            max-width: 800px;
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .mkp-import-export-page hr {
            margin: 30px 0;
        }
    </style>
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