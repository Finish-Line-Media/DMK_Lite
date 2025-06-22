<?php
/**
 * Native Contact Form Functionality
 *
 * @package MediaKit_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register contact form shortcode
 */
function mkp_contact_form_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'type' => 'general', // general, booking, media
        'subject' => '',
        'button_text' => __( 'Send Message', 'mediakit-pro' ),
        'success_message' => __( 'Thank you for your message. We\'ll get back to you soon!', 'mediakit-pro' ),
    ), $atts );
    
    ob_start();
    mkp_render_contact_form( $atts );
    return ob_get_clean();
}
add_shortcode( 'mkp_contact_form', 'mkp_contact_form_shortcode' );

/**
 * Render contact form
 */
function mkp_render_contact_form( $args ) {
    $form_id = 'mkp-contact-form-' . wp_rand();
    $nonce_action = 'mkp_contact_form_' . $args['type'];
    ?>
    
    <div class="mkp-contact-form-wrapper">
        <form id="<?php echo esc_attr( $form_id ); ?>" class="mkp-contact-form" method="post" novalidate>
            <?php wp_nonce_field( $nonce_action, 'mkp_contact_nonce' ); ?>
            <input type="hidden" name="action" value="mkp_submit_contact_form">
            <input type="hidden" name="form_type" value="<?php echo esc_attr( $args['type'] ); ?>">
            <input type="hidden" name="form_subject" value="<?php echo esc_attr( $args['subject'] ); ?>">
            
            <div class="mkp-form-messages"></div>
            
            <?php if ( $args['type'] === 'booking' ) : ?>
                <!-- Booking Form Fields -->
                <div class="mkp-form-row">
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-name"><?php esc_html_e( 'Name', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="text" id="<?php echo $form_id; ?>-name" name="mkp_name" required>
                    </div>
                    
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-email"><?php esc_html_e( 'Email', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="email" id="<?php echo $form_id; ?>-email" name="mkp_email" required>
                    </div>
                </div>
                
                <div class="mkp-form-row">
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-organization"><?php esc_html_e( 'Organization', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="text" id="<?php echo $form_id; ?>-organization" name="mkp_organization" required>
                    </div>
                    
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-phone"><?php esc_html_e( 'Phone', 'mediakit-pro' ); ?></label>
                        <input type="tel" id="<?php echo $form_id; ?>-phone" name="mkp_phone">
                    </div>
                </div>
                
                <div class="mkp-form-row">
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-event-date"><?php esc_html_e( 'Event Date', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="date" id="<?php echo $form_id; ?>-event-date" name="mkp_event_date" required>
                    </div>
                    
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-event-type"><?php esc_html_e( 'Event Type', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <select id="<?php echo $form_id; ?>-event-type" name="mkp_event_type" required>
                            <option value=""><?php esc_html_e( 'Select Event Type', 'mediakit-pro' ); ?></option>
                            <option value="conference"><?php esc_html_e( 'Conference', 'mediakit-pro' ); ?></option>
                            <option value="workshop"><?php esc_html_e( 'Workshop', 'mediakit-pro' ); ?></option>
                            <option value="keynote"><?php esc_html_e( 'Keynote', 'mediakit-pro' ); ?></option>
                            <option value="panel"><?php esc_html_e( 'Panel Discussion', 'mediakit-pro' ); ?></option>
                            <option value="webinar"><?php esc_html_e( 'Webinar', 'mediakit-pro' ); ?></option>
                            <option value="other"><?php esc_html_e( 'Other', 'mediakit-pro' ); ?></option>
                        </select>
                    </div>
                </div>
                
                <div class="mkp-form-group">
                    <label for="<?php echo $form_id; ?>-location"><?php esc_html_e( 'Event Location', 'mediakit-pro' ); ?></label>
                    <input type="text" id="<?php echo $form_id; ?>-location" name="mkp_location" placeholder="<?php esc_attr_e( 'City, State/Country or Virtual', 'mediakit-pro' ); ?>">
                </div>
                
                <div class="mkp-form-group">
                    <label for="<?php echo $form_id; ?>-message"><?php esc_html_e( 'Event Details & Requirements', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                    <textarea id="<?php echo $form_id; ?>-message" name="mkp_message" rows="5" required></textarea>
                </div>
                
            <?php elseif ( $args['type'] === 'media' ) : ?>
                <!-- Media Inquiry Form Fields -->
                <div class="mkp-form-row">
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-name"><?php esc_html_e( 'Name', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="text" id="<?php echo $form_id; ?>-name" name="mkp_name" required>
                    </div>
                    
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-email"><?php esc_html_e( 'Email', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="email" id="<?php echo $form_id; ?>-email" name="mkp_email" required>
                    </div>
                </div>
                
                <div class="mkp-form-row">
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-outlet"><?php esc_html_e( 'Media Outlet', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="text" id="<?php echo $form_id; ?>-outlet" name="mkp_media_outlet" required>
                    </div>
                    
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-deadline"><?php esc_html_e( 'Deadline', 'mediakit-pro' ); ?></label>
                        <input type="date" id="<?php echo $form_id; ?>-deadline" name="mkp_deadline">
                    </div>
                </div>
                
                <div class="mkp-form-group">
                    <label for="<?php echo $form_id; ?>-inquiry-type"><?php esc_html_e( 'Type of Inquiry', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                    <select id="<?php echo $form_id; ?>-inquiry-type" name="mkp_inquiry_type" required>
                        <option value=""><?php esc_html_e( 'Select Inquiry Type', 'mediakit-pro' ); ?></option>
                        <option value="interview"><?php esc_html_e( 'Interview Request', 'mediakit-pro' ); ?></option>
                        <option value="quote"><?php esc_html_e( 'Expert Quote', 'mediakit-pro' ); ?></option>
                        <option value="article"><?php esc_html_e( 'Article Contribution', 'mediakit-pro' ); ?></option>
                        <option value="podcast"><?php esc_html_e( 'Podcast Appearance', 'mediakit-pro' ); ?></option>
                        <option value="tv"><?php esc_html_e( 'TV/Video Appearance', 'mediakit-pro' ); ?></option>
                        <option value="other"><?php esc_html_e( 'Other', 'mediakit-pro' ); ?></option>
                    </select>
                </div>
                
                <div class="mkp-form-group">
                    <label for="<?php echo $form_id; ?>-message"><?php esc_html_e( 'Details of Your Request', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                    <textarea id="<?php echo $form_id; ?>-message" name="mkp_message" rows="5" required></textarea>
                </div>
                
            <?php else : ?>
                <!-- General Contact Form Fields -->
                <div class="mkp-form-row">
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-name"><?php esc_html_e( 'Name', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="text" id="<?php echo $form_id; ?>-name" name="mkp_name" required>
                    </div>
                    
                    <div class="mkp-form-group mkp-form-half">
                        <label for="<?php echo $form_id; ?>-email"><?php esc_html_e( 'Email', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                        <input type="email" id="<?php echo $form_id; ?>-email" name="mkp_email" required>
                    </div>
                </div>
                
                <div class="mkp-form-group">
                    <label for="<?php echo $form_id; ?>-subject"><?php esc_html_e( 'Subject', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                    <input type="text" id="<?php echo $form_id; ?>-subject" name="mkp_subject" required>
                </div>
                
                <div class="mkp-form-group">
                    <label for="<?php echo $form_id; ?>-message"><?php esc_html_e( 'Message', 'mediakit-pro' ); ?> <span class="required">*</span></label>
                    <textarea id="<?php echo $form_id; ?>-message" name="mkp_message" rows="5" required></textarea>
                </div>
            <?php endif; ?>
            
            <!-- Honeypot field for spam protection -->
            <div class="mkp-honeypot" aria-hidden="true">
                <label for="<?php echo $form_id; ?>-website"><?php esc_html_e( 'Website', 'mediakit-pro' ); ?></label>
                <input type="text" id="<?php echo $form_id; ?>-website" name="mkp_website" tabindex="-1" autocomplete="off">
            </div>
            
            <div class="mkp-form-group">
                <button type="submit" class="mkp-btn mkp-btn--primary mkp-form-submit">
                    <span class="mkp-form-submit-text"><?php echo esc_html( $args['button_text'] ); ?></span>
                    <span class="mkp-form-submit-loading" style="display: none;"><?php esc_html_e( 'Sending...', 'mediakit-pro' ); ?></span>
                </button>
            </div>
        </form>
    </div>
    
    <?php
}

/**
 * Handle AJAX form submission
 */
function mkp_handle_contact_form_submission() {
    // Verify nonce
    $form_type = isset( $_POST['form_type'] ) ? sanitize_text_field( $_POST['form_type'] ) : 'general';
    $nonce_action = 'mkp_contact_form_' . $form_type;
    
    if ( ! isset( $_POST['mkp_contact_nonce'] ) || ! wp_verify_nonce( $_POST['mkp_contact_nonce'], $nonce_action ) ) {
        wp_send_json_error( __( 'Security check failed. Please refresh the page and try again.', 'mediakit-pro' ) );
    }
    
    // Check honeypot
    if ( ! empty( $_POST['mkp_website'] ) ) {
        wp_send_json_error( __( 'Spam detected.', 'mediakit-pro' ) );
    }
    
    // Validate required fields
    $required_fields = array( 'mkp_name', 'mkp_email', 'mkp_message' );
    
    if ( $form_type === 'booking' ) {
        $required_fields[] = 'mkp_organization';
        $required_fields[] = 'mkp_event_date';
        $required_fields[] = 'mkp_event_type';
    } elseif ( $form_type === 'media' ) {
        $required_fields[] = 'mkp_media_outlet';
        $required_fields[] = 'mkp_inquiry_type';
    } else {
        $required_fields[] = 'mkp_subject';
    }
    
    foreach ( $required_fields as $field ) {
        if ( empty( $_POST[ $field ] ) ) {
            wp_send_json_error( __( 'Please fill in all required fields.', 'mediakit-pro' ) );
        }
    }
    
    // Sanitize form data
    $form_data = array(
        'name'    => sanitize_text_field( $_POST['mkp_name'] ),
        'email'   => sanitize_email( $_POST['mkp_email'] ),
        'message' => sanitize_textarea_field( $_POST['mkp_message'] ),
        'type'    => $form_type,
    );
    
    // Add type-specific fields
    if ( $form_type === 'booking' ) {
        $form_data['organization'] = sanitize_text_field( $_POST['mkp_organization'] );
        $form_data['phone'] = sanitize_text_field( $_POST['mkp_phone'] ?? '' );
        $form_data['event_date'] = sanitize_text_field( $_POST['mkp_event_date'] );
        $form_data['event_type'] = sanitize_text_field( $_POST['mkp_event_type'] );
        $form_data['location'] = sanitize_text_field( $_POST['mkp_location'] ?? '' );
    } elseif ( $form_type === 'media' ) {
        $form_data['media_outlet'] = sanitize_text_field( $_POST['mkp_media_outlet'] );
        $form_data['deadline'] = sanitize_text_field( $_POST['mkp_deadline'] ?? '' );
        $form_data['inquiry_type'] = sanitize_text_field( $_POST['mkp_inquiry_type'] );
    } else {
        $form_data['subject'] = sanitize_text_field( $_POST['mkp_subject'] );
    }
    
    // Validate email
    if ( ! is_email( $form_data['email'] ) ) {
        wp_send_json_error( __( 'Please enter a valid email address.', 'mediakit-pro' ) );
    }
    
    // Store submission in database
    $submission_id = mkp_store_form_submission( $form_data );
    
    if ( ! $submission_id ) {
        wp_send_json_error( __( 'Failed to save submission. Please try again.', 'mediakit-pro' ) );
    }
    
    // Send email notification
    $email_sent = mkp_send_form_notification( $form_data, $submission_id );
    
    if ( $email_sent ) {
        wp_send_json_success( array(
            'message' => __( 'Thank you for your message. We\'ll get back to you soon!', 'mediakit-pro' ),
        ) );
    } else {
        wp_send_json_error( __( 'Message received but email notification failed. We\'ll still get your message.', 'mediakit-pro' ) );
    }
}
add_action( 'wp_ajax_mkp_submit_contact_form', 'mkp_handle_contact_form_submission' );
add_action( 'wp_ajax_nopriv_mkp_submit_contact_form', 'mkp_handle_contact_form_submission' );

/**
 * Store form submission in database
 */
function mkp_store_form_submission( $form_data ) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'mkp_form_submissions';
    
    $data = array(
        'form_type'      => $form_data['type'],
        'name'           => $form_data['name'],
        'email'          => $form_data['email'],
        'message'        => $form_data['message'],
        'form_data'      => wp_json_encode( $form_data ),
        'ip_address'     => mkp_get_client_ip(),
        'user_agent'     => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'submission_date' => current_time( 'mysql' ),
        'status'         => 'unread',
    );
    
    $format = array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
    
    $wpdb->insert( $table_name, $data, $format );
    
    return $wpdb->insert_id;
}

/**
 * Send form notification email
 */
function mkp_send_form_notification( $form_data, $submission_id ) {
    // Get recipient email based on form type
    $to = mkp_get_form_recipient_email( $form_data['type'] );
    
    // Prepare email subject
    $subject_prefix = '[' . get_bloginfo( 'name' ) . '] ';
    
    if ( $form_data['type'] === 'booking' ) {
        $subject = $subject_prefix . sprintf( __( 'Booking Request from %s', 'mediakit-pro' ), $form_data['name'] );
    } elseif ( $form_data['type'] === 'media' ) {
        $subject = $subject_prefix . sprintf( __( 'Media Inquiry from %s', 'mediakit-pro' ), $form_data['media_outlet'] );
    } else {
        $subject = $subject_prefix . $form_data['subject'];
    }
    
    // Prepare email body
    $message = mkp_format_email_message( $form_data, $submission_id );
    
    // Email headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $form_data['name'] . ' <' . $form_data['email'] . '>',
        'Reply-To: ' . $form_data['email'],
    );
    
    // Send email
    $sent = wp_mail( $to, $subject, $message, $headers );
    
    // Send confirmation to submitter
    if ( $sent && apply_filters( 'mkp_send_form_confirmation', true, $form_data ) ) {
        mkp_send_form_confirmation( $form_data );
    }
    
    return $sent;
}

/**
 * Get form recipient email
 */
function mkp_get_form_recipient_email( $form_type ) {
    switch ( $form_type ) {
        case 'booking':
            $email = get_theme_mod( 'mkp_contact_email_booking' );
            break;
        case 'media':
            $email = get_theme_mod( 'mkp_contact_email_press' );
            break;
        default:
            $email = get_theme_mod( 'mkp_contact_email_primary' );
            break;
    }
    
    // Fallback to admin email
    if ( empty( $email ) ) {
        $email = get_option( 'admin_email' );
    }
    
    return $email;
}

/**
 * Format email message
 */
function mkp_format_email_message( $form_data, $submission_id ) {
    $site_name = get_bloginfo( 'name' );
    $admin_url = admin_url( 'admin.php?page=mkp-form-submissions&view=' . $submission_id );
    
    ob_start();
    ?>
    <html>
    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
            <h2 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;">
                <?php
                if ( $form_data['type'] === 'booking' ) {
                    esc_html_e( 'New Booking Request', 'mediakit-pro' );
                } elseif ( $form_data['type'] === 'media' ) {
                    esc_html_e( 'New Media Inquiry', 'mediakit-pro' );
                } else {
                    esc_html_e( 'New Contact Form Submission', 'mediakit-pro' );
                }
                ?>
            </h2>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Name:', 'mediakit-pro' ); ?></strong></td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( $form_data['name'] ); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Email:', 'mediakit-pro' ); ?></strong></td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <a href="mailto:<?php echo esc_attr( $form_data['email'] ); ?>"><?php echo esc_html( $form_data['email'] ); ?></a>
                    </td>
                </tr>
                
                <?php if ( $form_data['type'] === 'booking' ) : ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Organization:', 'mediakit-pro' ); ?></strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( $form_data['organization'] ); ?></td>
                    </tr>
                    <?php if ( ! empty( $form_data['phone'] ) ) : ?>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Phone:', 'mediakit-pro' ); ?></strong></td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( $form_data['phone'] ); ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Event Date:', 'mediakit-pro' ); ?></strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $form_data['event_date'] ) ) ); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Event Type:', 'mediakit-pro' ); ?></strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( ucfirst( $form_data['event_type'] ) ); ?></td>
                    </tr>
                    <?php if ( ! empty( $form_data['location'] ) ) : ?>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Location:', 'mediakit-pro' ); ?></strong></td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( $form_data['location'] ); ?></td>
                        </tr>
                    <?php endif; ?>
                    
                <?php elseif ( $form_data['type'] === 'media' ) : ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Media Outlet:', 'mediakit-pro' ); ?></strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( $form_data['media_outlet'] ); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Inquiry Type:', 'mediakit-pro' ); ?></strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( ucfirst( str_replace( '_', ' ', $form_data['inquiry_type'] ) ) ); ?></td>
                    </tr>
                    <?php if ( ! empty( $form_data['deadline'] ) ) : ?>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Deadline:', 'mediakit-pro' ); ?></strong></td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $form_data['deadline'] ) ) ); ?></td>
                        </tr>
                    <?php endif; ?>
                    
                <?php else : ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><strong><?php esc_html_e( 'Subject:', 'mediakit-pro' ); ?></strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo esc_html( $form_data['subject'] ); ?></td>
                    </tr>
                <?php endif; ?>
            </table>
            
            <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-left: 4px solid #3498db;">
                <h3 style="margin-top: 0; color: #2c3e50;"><?php esc_html_e( 'Message:', 'mediakit-pro' ); ?></h3>
                <p><?php echo nl2br( esc_html( $form_data['message'] ) ); ?></p>
            </div>
            
            <?php if ( current_user_can( 'manage_options' ) ) : ?>
                <div style="margin-top: 20px; padding: 10px; background-color: #e8f4fd; text-align: center;">
                    <a href="<?php echo esc_url( $admin_url ); ?>" style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 4px;">
                        <?php esc_html_e( 'View in Dashboard', 'mediakit-pro' ); ?>
                    </a>
                </div>
            <?php endif; ?>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666;">
                <p><?php printf( esc_html__( 'This message was sent from %s', 'mediakit-pro' ), esc_html( $site_name ) ); ?></p>
                <p><?php echo esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ); ?></p>
            </div>
        </div>
    </body>
    </html>
    <?php
    
    return ob_get_clean();
}

/**
 * Send confirmation email to submitter
 */
function mkp_send_form_confirmation( $form_data ) {
    $site_name = get_bloginfo( 'name' );
    $subject = sprintf( __( 'Thank you for contacting %s', 'mediakit-pro' ), $site_name );
    
    ob_start();
    ?>
    <html>
    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
            <h2 style="color: #2c3e50;"><?php printf( esc_html__( 'Thank you, %s!', 'mediakit-pro' ), esc_html( $form_data['name'] ) ); ?></h2>
            
            <p><?php esc_html_e( 'We have received your message and will get back to you as soon as possible.', 'mediakit-pro' ); ?></p>
            
            <div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-left: 4px solid #3498db;">
                <h3 style="margin-top: 0;"><?php esc_html_e( 'Your Message:', 'mediakit-pro' ); ?></h3>
                <p><?php echo nl2br( esc_html( $form_data['message'] ) ); ?></p>
            </div>
            
            <?php if ( $form_data['type'] === 'booking' ) : ?>
                <p><?php esc_html_e( 'We typically respond to booking requests within 24-48 hours.', 'mediakit-pro' ); ?></p>
            <?php elseif ( $form_data['type'] === 'media' ) : ?>
                <p><?php esc_html_e( 'We understand the importance of media deadlines and will respond as quickly as possible.', 'mediakit-pro' ); ?></p>
            <?php endif; ?>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666;">
                <p><?php esc_html_e( 'This is an automated confirmation. Please do not reply to this email.', 'mediakit-pro' ); ?></p>
            </div>
        </div>
    </body>
    </html>
    <?php
    
    $message = ob_get_clean();
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $site_name . ' <' . get_option( 'admin_email' ) . '>',
    );
    
    wp_mail( $form_data['email'], $subject, $message, $headers );
}

/**
 * Get client IP address
 */
function mkp_get_client_ip() {
    $ip_keys = array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' );
    
    foreach ( $ip_keys as $key ) {
        if ( array_key_exists( $key, $_SERVER ) === true ) {
            $ip = $_SERVER[ $key ];
            if ( strpos( $ip, ',' ) !== false ) {
                $ip = explode( ',', $ip )[0];
            }
            
            if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
                return $ip;
            }
        }
    }
    
    return '0.0.0.0';
}

/**
 * Create form submissions table
 */
function mkp_create_form_submissions_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'mkp_form_submissions';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        form_type varchar(50) NOT NULL,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        message text NOT NULL,
        form_data longtext,
        ip_address varchar(45),
        user_agent text,
        submission_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        status varchar(20) DEFAULT 'unread',
        notes text,
        PRIMARY KEY (id),
        KEY form_type (form_type),
        KEY status (status),
        KEY submission_date (submission_date)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// Create table on theme activation
add_action( 'after_switch_theme', 'mkp_create_form_submissions_table' );

// Also check table on admin init in case theme was activated differently
function mkp_maybe_create_form_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mkp_form_submissions';
    
    if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
        mkp_create_form_submissions_table();
    }
}
add_action( 'admin_init', 'mkp_maybe_create_form_table' );