<?php
/**
 * Social media icons functionality
 *
 * @package MediaKit_Lite
 */

/**
 * Get available social media platforms
 *
 * @return array
 */
function mkp_get_social_platforms() {
    return array(
        'twitter' => array(
            'label' => __( 'X (formerly Twitter)', 'mediakit-lite' ),
            'icon'  => 'dashicons-twitter',
            'prefix' => 'https://x.com/',
        ),
        'facebook' => array(
            'label' => __( 'Facebook', 'mediakit-lite' ),
            'icon'  => 'dashicons-facebook-alt',
            'prefix' => 'https://facebook.com/',
        ),
        'instagram' => array(
            'label' => __( 'Instagram', 'mediakit-lite' ),
            'icon'  => 'dashicons-instagram',
            'prefix' => 'https://instagram.com/',
        ),
        'linkedin' => array(
            'label' => __( 'LinkedIn', 'mediakit-lite' ),
            'icon'  => 'dashicons-linkedin',
            'prefix' => 'https://linkedin.com/in/',
        ),
        'youtube' => array(
            'label' => __( 'YouTube', 'mediakit-lite' ),
            'icon'  => 'dashicons-youtube',
            'prefix' => 'https://youtube.com/@',
        ),
    );
}

/**
 * Display social media icons
 *
 * @param array $args Display arguments
 */
function mkp_social_icons( $args = array() ) {
    $defaults = array(
        'class' => '',
        'style' => 'default',
    );
    
    $args = wp_parse_args( $args, $defaults );
    $platforms = mkp_get_social_platforms();
    $has_social = false;
    
    // Check if any social links are set
    foreach ( $platforms as $platform => $data ) {
        if ( get_theme_mod( 'mkp_social_' . $platform ) ) {
            $has_social = true;
            break;
        }
    }
    
    if ( ! $has_social ) {
        return;
    }
    
    $class = 'mkp-social';
    if ( ! empty( $args['class'] ) ) {
        $class .= ' ' . esc_attr( $args['class'] );
    }
    ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <ul class="mkp-social__list">
            <?php foreach ( $platforms as $platform => $data ) : 
                $username = get_theme_mod( 'mkp_social_' . $platform );
                if ( ! $username ) {
                    continue;
                }
                
                // Build the URL
                $url = $username;
                if ( ! filter_var( $username, FILTER_VALIDATE_URL ) && ! empty( $data['prefix'] ) ) {
                    $url = $data['prefix'] . ltrim( $username, '@' );
                }
                ?>
                <li class="mkp-social__item">
                    <a href="<?php echo esc_url( $url ); ?>" 
                       class="mkp-social__link mkp-social__link--<?php echo esc_attr( $platform ); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       aria-label="<?php echo esc_attr( $data['label'] ); ?>">
                        <span class="dashicons <?php echo esc_attr( $data['icon'] ); ?>"></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}

