<?php
/**
 * Contact Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-contact-section';
$section_color = get_theme_mod( 'mkp_contact_background_color', '#f8f9fa' );

// Check if section is enabled
if ( ! get_theme_mod( 'mkp_enable_section_contact', true ) ) {
    return;
}

// Check if we have any contact info
$has_contact_info = false;
$general_email = get_theme_mod( 'mkp_contact_general_email' );
$media_email = get_theme_mod( 'mkp_contact_media_email' );
$speaking_email = get_theme_mod( 'mkp_contact_speaking_email' );
$address = get_theme_mod( 'mkp_contact_address' );

// Check emails and address
if ( $general_email || $media_email || $speaking_email || $address ) {
    $has_contact_info = true;
}

// Check social links
if ( ! $has_contact_info ) {
    $social_platforms = array( 'x', 'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok', 'github', 'threads' );
    foreach ( $social_platforms as $platform ) {
        if ( get_theme_mod( 'mkp_contact_social_' . $platform ) ) {
            $has_contact_info = true;
            break;
        }
    }
}

// For customizer preview, always render the section structure
$is_customizer = is_customize_preview();

if ( ! $has_contact_info && ! $is_customizer ) {
    return;
}
?>

<section id="contact" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?><?php echo ( ! $has_contact_info && $is_customizer ) ? '; display: none;' : ''; ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Contact', 'mediakit-lite' ); ?></h2>
        
        <div class="mkp-contact__wrapper">
            <?php if ( $general_email || $media_email || $speaking_email || $address || $is_customizer ) : ?>
                <div class="mkp-contact__info">
                    <?php if ( $general_email || $media_email || $speaking_email ) : ?>
                        <div class="mkp-contact__emails">
                            <?php if ( $general_email ) : ?>
                                <div class="mkp-contact__item">
                                    <span class="mkp-contact__label"><?php esc_html_e( 'General Inquiries:', 'mediakit-lite' ); ?></span>
                                    <a href="mailto:<?php echo esc_attr( $general_email ); ?>" class="mkp-contact__email">
                                        <?php echo esc_html( $general_email ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $media_email ) : ?>
                                <div class="mkp-contact__item">
                                    <span class="mkp-contact__label"><?php esc_html_e( 'Media/Press:', 'mediakit-lite' ); ?></span>
                                    <a href="mailto:<?php echo esc_attr( $media_email ); ?>" class="mkp-contact__email">
                                        <?php echo esc_html( $media_email ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $speaking_email ) : ?>
                                <div class="mkp-contact__item">
                                    <span class="mkp-contact__label"><?php esc_html_e( 'Public Speaking:', 'mediakit-lite' ); ?></span>
                                    <a href="mailto:<?php echo esc_attr( $speaking_email ); ?>" class="mkp-contact__email">
                                        <?php echo esc_html( $speaking_email ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $address ) : ?>
                        <div class="mkp-contact__address">
                            <span class="mkp-contact__label"><?php esc_html_e( 'Address:', 'mediakit-lite' ); ?></span>
                            <address class="mkp-contact__address-text">
                                <?php echo nl2br( esc_html( $address ) ); ?>
                            </address>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php 
            // Check if we have any social links
            $social_platforms = array(
                'x'         => 'X',
                'facebook'  => 'Facebook',
                'instagram' => 'Instagram',
                'linkedin'  => 'LinkedIn',
                'youtube'   => 'YouTube',
                'tiktok'    => 'TikTok',
                'github'    => 'GitHub',
                'threads'   => 'Threads'
            );
            
            $has_social = false;
            foreach ( $social_platforms as $platform => $label ) {
                if ( get_theme_mod( 'mkp_contact_social_' . $platform ) ) {
                    $has_social = true;
                    break;
                }
            }
            
            if ( $has_social || $is_customizer ) : ?>
                <div class="mkp-contact__social">
                    <h3 class="mkp-contact__social-title"><?php esc_html_e( 'Connect With Me', 'mediakit-lite' ); ?></h3>
                    <div class="mkp-contact__social-links">
                        <?php foreach ( $social_platforms as $platform => $label ) : 
                            $url = get_theme_mod( 'mkp_contact_social_' . $platform );
                            if ( $url || $is_customizer ) : ?>
                                <a href="<?php echo esc_url( $url ); ?>" 
                                   class="mkp-contact__social-link mkp-contact__social-link--<?php echo esc_attr( $platform ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   title="<?php echo esc_attr( $label ); ?>"
                                   <?php echo ( ! $url && $is_customizer ) ? 'style="display: none;"' : ''; ?>>
                                    <?php echo mkp_get_social_icon( $platform ); ?>
                                    <span class="screen-reader-text"><?php echo esc_html( $label ); ?></span>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ( ! $has_contact_info && $is_customizer ) : ?>
            <p class="mkp-contact__placeholder" style="text-align: center; color: #999; padding: 40px 0;">
                <?php esc_html_e( 'Start adding contact information to see it appear here.', 'mediakit-lite' ); ?>
            </p>
        <?php endif; ?>
    </div>
</section>