<?php
/**
 * Admin customizations and functions
 *
 * @package MediaKit_Lite
 */

/**
 * Get update information
 *
 * @return array Contains 'update_available', 'current_version', 'remote_version', 'download_url'
 */
function mkp_get_update_info() {
    $remote_data = get_transient( 'mkp_remote_version' );
    $current_version = MKP_THEME_VERSION;
    $update_available = false;
    $remote_version = '';
    $download_url = '';
    
    if ( ! empty( $remote_data['version'] ) ) {
        $remote_version = $remote_data['version'];
        $update_available = version_compare( $current_version, $remote_version, '<' );
        $download_url = ! empty( $remote_data['download_url'] ) ? $remote_data['download_url'] : '';
    }
    
    return array(
        'update_available' => $update_available,
        'current_version' => $current_version,
        'remote_version' => $remote_version,
        'download_url' => $download_url,
    );
}

/**
 * Display update alert
 *
 * @param array $update_info Update information from mkp_get_update_info()
 * @param string $context 'dashboard' or 'admin' for different styling
 */
function mkp_display_update_alert( $update_info, $context = 'dashboard' ) {
    if ( ! $update_info['update_available'] ) {
        return;
    }
    
    $class = ( $context === 'admin' ) ? 'notice notice-warning inline' : 'mkp-update-alert';
    ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <?php if ( $context === 'admin' ) : ?><p><?php endif; ?>
        <strong><?php esc_html_e( 'Update Available!', 'mediakit-lite' ); ?></strong>
        <?php printf( esc_html__( 'Version %s is now available.', 'mediakit-lite' ), esc_html( $update_info['remote_version'] ) ); ?>
        <?php if ( ! empty( $update_info['download_url'] ) ) : ?>
            <a href="<?php echo esc_url( $update_info['download_url'] ); ?>" 
               class="<?php echo ( $context === 'admin' ) ? 'button button-primary' : ''; ?>" 
               target="_blank">
                <?php esc_html_e( $context === 'admin' ? 'Download Update' : 'Download', 'mediakit-lite' ); ?>
            </a>
        <?php endif; ?>
        <?php if ( $context === 'admin' ) : ?></p><?php endif; ?>
    </div>
    <?php
}

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
    $update_info = mkp_get_update_info();
    ?>
    <div class="mkp-dashboard-widget">
        <h3><?php esc_html_e( 'MediaKit Lite', 'mediakit-lite' ); ?></h3>
        <p><?php esc_html_e( 'Create your professional digital media kit in minutes! Use the Customizer to add your content.', 'mediakit-lite' ); ?></p>
        
        <?php mkp_display_update_alert( $update_info, 'dashboard' ); ?>
        
        <h3><?php esc_html_e( 'Quick Actions', 'mediakit-lite' ); ?></h3>
        <div class="mkp-dashboard-actions">
            <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize Theme', 'mediakit-lite' ); ?></a>
            <a href="<?php echo esc_url( site_url() ); ?>" class="button" target="_blank"><?php esc_html_e( 'View Site', 'mediakit-lite' ); ?></a>
            <button type="button" class="button mkp-check-updates-dashboard"><?php esc_html_e( 'Check for Updates', 'mediakit-lite' ); ?></button>
        </div>
        
        <div class="mkp-version-info">
            <small><?php printf( esc_html__( 'Current Version: %s', 'mediakit-lite' ), $update_info['current_version'] ); ?></small>
        </div>
    </div>
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
    $update_info = mkp_get_update_info();
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <div class="mkp-admin-page">
            <div class="mkp-admin-welcome">
                <h2><?php esc_html_e( 'Welcome to MediaKit Lite', 'mediakit-lite' ); ?></h2>
                <p><strong><?php esc_html_e( 'Create your professional digital media kit in minutes!', 'mediakit-lite' ); ?></strong></p>
                
                <p><?php esc_html_e( 'MediaKit Lite is your digital media kit solution for building personal leverage. Perfect for showcasing your expertise, publications, speaking topics, and media appearances. Set up everything through the simple WordPress Customizer - no coding required.', 'mediakit-lite' ); ?></p>
                
                <p><strong><?php esc_html_e( 'Quick Start Guide:', 'mediakit-lite' ); ?></strong></p>
                <ol>
                    <li><?php esc_html_e( 'Click "Customize Theme" below to open the WordPress Customizer', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Start with "Brand Settings" to set your colors and fonts', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Add your name, photo, and professional tags in "Hero Section"', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Fill in each section with your content (books, speaking topics, etc.)', 'mediakit-lite' ); ?></li>
                    <li><?php esc_html_e( 'Add your social media links to stay connected', 'mediakit-lite' ); ?></li>
                </ol>
                
                <?php mkp_display_update_alert( $update_info, 'admin' ); ?>
            </div>
            
            <div class="mkp-admin-cards">
                <div class="mkp-admin-card">
                    <h3>1. <?php esc_html_e( 'Customize Your Brand', 'mediakit-lite' ); ?></h3>
                    <p><?php esc_html_e( 'Set your colors, fonts, and upload your logo.', 'mediakit-lite' ); ?></p>
                    <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize Brand', 'mediakit-lite' ); ?></a>
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
            
            <div class="mkp-admin-resources">
                <h2><?php esc_html_e( 'Resources', 'mediakit-lite' ); ?></h2>
                <ul>
                    <li><a href="https://wordpress.org/support/theme/mediakit-lite/" target="_blank"><?php esc_html_e( 'Support Forum', 'mediakit-lite' ); ?></a></li>
                    <li><a href="https://github.com/Finish-Line-Media/DMK_Lite" target="_blank"><?php esc_html_e( 'GitHub Repository', 'mediakit-lite' ); ?></a></li>
                    <li><a href="https://github.com/Finish-Line-Media/DMK_Lite/issues" target="_blank"><?php esc_html_e( 'Report Issues', 'mediakit-lite' ); ?></a></li>
                </ul>
            </div>
            
            <div class="mkp-admin-updates">
                <h3><?php esc_html_e( 'Theme Updates', 'mediakit-lite' ); ?></h3>
                <p>
                    <?php printf( esc_html__( 'Current Version: %s', 'mediakit-lite' ), '<strong>' . $update_info['current_version'] . '</strong>' ); ?>
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
            'https://wordpress.org/support/theme/mediakit-lite/reviews/#new-post'
        );
    }
    
    return $text;
}
add_filter( 'admin_footer_text', 'mkp_admin_footer_text' );

/**
 * Enqueue admin styles and scripts
 */
function mkp_admin_scripts() {
    $screen = get_current_screen();
    
    // Check if we're on our admin pages or dashboard
    if ( strpos( $screen->id, 'mediakit-lite' ) !== false || $screen->id === 'dashboard' ) {
        // Enqueue admin styles
        wp_enqueue_style( 'mediakit-lite-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), MKP_THEME_VERSION );
        
        // Enqueue admin scripts
        wp_enqueue_script( 'mediakit-lite-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), MKP_THEME_VERSION, true );
        
        // Localize script with data
        wp_localize_script( 'mediakit-lite-admin', 'mkpAdmin', array(
            'nonce' => wp_create_nonce( 'mkp_force_check' ),
            'checkingText' => esc_html__( 'Checking...', 'mediakit-lite' ),
            'errorText' => esc_html__( 'Error checking for updates.', 'mediakit-lite' ),
            'networkErrorText' => esc_html__( 'Network error. Please try again.', 'mediakit-lite' ),
        ) );
    }
}
add_action( 'admin_enqueue_scripts', 'mkp_admin_scripts' );

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