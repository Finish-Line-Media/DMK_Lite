<?php
/**
 * Contact Section Template Part
 *
 * @package MediaKit_Lite
 */

$section_class = 'mkp-contact-section';
$section_color = get_theme_mod( 'mkp_contact_background_color', '#ffffff' );
?>

<section id="contact" class="<?php echo esc_attr( $section_class ); ?>" style="background-color: <?php echo esc_attr( $section_color ); ?>">
    <div class="mkp-container">
        <h2 class="mkp-section__title"><?php esc_html_e( 'Get In Touch', 'mediakit-lite' ); ?></h2>
        
        <div class="mkp-contact__content">
            <div class="mkp-contact__info">
                <?php
                $primary_email = get_theme_mod( 'mkp_contact_email_primary' );
                $booking_email = get_theme_mod( 'mkp_contact_email_booking' );
                $press_email = get_theme_mod( 'mkp_contact_email_press' );
                $phone = get_theme_mod( 'mkp_contact_phone' );
                $address = get_theme_mod( 'mkp_contact_address' );
                $calendar_link = get_theme_mod( 'mkp_booking_calendar_link' );
                ?>
                
                <?php if ( $primary_email ) : ?>
                    <div class="mkp-contact__item">
                        <h3><?php esc_html_e( 'General Inquiries', 'mediakit-lite' ); ?></h3>
                        <a href="mailto:<?php echo esc_attr( $primary_email ); ?>" class="mkp-contact-email-primary">
                            <?php echo esc_html( $primary_email ); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if ( $booking_email ) : ?>
                    <div class="mkp-contact__item">
                        <h3><?php esc_html_e( 'Speaking Engagements', 'mediakit-lite' ); ?></h3>
                        <a href="mailto:<?php echo esc_attr( $booking_email ); ?>">
                            <?php echo esc_html( $booking_email ); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if ( $press_email ) : ?>
                    <div class="mkp-contact__item">
                        <h3><?php esc_html_e( 'Press & Media', 'mediakit-lite' ); ?></h3>
                        <a href="mailto:<?php echo esc_attr( $press_email ); ?>">
                            <?php echo esc_html( $press_email ); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if ( $phone ) : ?>
                    <div class="mkp-contact__item">
                        <h3><?php esc_html_e( 'Phone', 'mediakit-lite' ); ?></h3>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if ( $address ) : ?>
                    <div class="mkp-contact__item">
                        <h3><?php esc_html_e( 'Location', 'mediakit-lite' ); ?></h3>
                        <address>
                            <?php echo wp_kses_post( wpautop( $address ) ); ?>
                        </address>
                    </div>
                <?php endif; ?>
                
                <?php if ( $calendar_link ) : ?>
                    <div class="mkp-contact__item">
                        <a href="<?php echo esc_url( $calendar_link ); ?>" class="mkp-btn mkp-btn--primary" target="_blank" rel="noopener">
                            <?php esc_html_e( 'Schedule a Call', 'mediakit-lite' ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php 
            // Social Icons
            if ( function_exists( 'mkp_social_icons' ) ) {
                mkp_social_icons( 'mkp-contact__social' );
            }
            ?>
        </div>
    </div>
</section>