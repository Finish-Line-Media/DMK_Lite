/**
 * Customizer Controls Script
 *
 * @package MediaKit_Pro
 */

( function( $ ) {
    'use strict';
    
    // Default values for settings
    const defaultValues = {
        // Brand Settings
        'mkp_primary_color': '#2c3e50',
        'mkp_secondary_color': '#3498db',
        'mkp_accent_color': '#e74c3c',
        'mkp_primary_font': 'system',
        'mkp_heading_font': 'playfair',
        
        // Background Settings
        'background_color': '#ffffff',
        'background_image': '',
        'mkp_background_overlay': 'rgba(255,255,255,0)',
        
        // Hero Section
        'mkp_hero_title': 'Welcome to My Media Kit',
        'mkp_hero_subtitle': 'Professional Speaker, Author, and Thought Leader',
        'mkp_hero_bio': '',
        
        // Social Media
        'mkp_social_facebook': '',
        'mkp_social_twitter': '',
        'mkp_social_instagram': '',
        'mkp_social_linkedin': '',
        'mkp_social_youtube': '',
        'mkp_social_tiktok': '',
        
        // Contact Settings
        'mkp_contact_email_primary': '',
        'mkp_contact_email_booking': '',
        'mkp_contact_email_press': '',
        'mkp_contact_phone': '',
        'mkp_contact_address': ''
    };
    
    wp.customize.bind( 'ready', function() {
        
        // Initialize color pickers with eyedropper
        setTimeout( function() {
            $( '.customize-control-color input[type="text"]' ).each( function() {
                var $this = $( this );
                if ( ! $this.hasClass( 'wp-color-picker' ) ) {
                    $this.wpColorPicker({
                        change: function( event, ui ) {
                            $this.trigger( 'change' );
                        },
                        clear: function() {
                            $this.trigger( 'change' );
                        }
                    });
                }
            });
        }, 100 );
        
        // Handle reset button clicks
        $( document ).on( 'click', '.mkp-reset-section', function( e ) {
            e.preventDefault();
            
            const $button = $( this );
            const section = $button.data( 'section' );
            
            // Confirm reset
            if ( ! confirm( wp.customize.l10n.confirmReset || 'Are you sure you want to reset all settings in this section to their defaults?' ) ) {
                return;
            }
            
            // Find all controls in this section
            wp.customize.section( section ).controls().forEach( function( control ) {
                const settingId = control.id;
                
                // Skip the reset button itself
                if ( settingId.indexOf( '_reset_' ) !== -1 ) {
                    return;
                }
                
                // Reset to default value if available
                if ( defaultValues.hasOwnProperty( settingId ) ) {
                    wp.customize( settingId ).set( defaultValues[settingId] );
                }
            });
            
            // Show success message
            showNotification( 'Section reset to defaults', 'success' );
        });
        
        // Add individual reset buttons for each control
        wp.customize.control.each( function( control ) {
            // Skip if it's already a reset control or doesn't have a default
            if ( control.params.type === 'reset_button' || ! defaultValues.hasOwnProperty( control.id ) ) {
                return;
            }
            
            // Add reset button to control
            wp.customize.control( control.id ).container.find( '.customize-control-title' ).first().append(
                '<button type="button" class="mkp-reset-single" data-setting="' + control.id + '" title="Reset to default">' +
                '<span class="dashicons dashicons-image-rotate"></span>' +
                '</button>'
            );
        });
        
        // Handle individual reset button clicks
        $( document ).on( 'click', '.mkp-reset-single', function( e ) {
            e.preventDefault();
            e.stopPropagation();
            
            const settingId = $( this ).data( 'setting' );
            
            if ( defaultValues.hasOwnProperty( settingId ) ) {
                wp.customize( settingId ).set( defaultValues[settingId] );
                showNotification( 'Setting reset to default', 'success' );
            }
        });
        
        // Add custom styles for reset buttons
        addCustomStyles();
        
        // Show/hide controls based on other control values
        setupConditionalControls();
        
    });
    
    // Show notification
    function showNotification( message, type = 'info' ) {
        const $notification = $( '<div class="mkp-customizer-notification mkp-notification-' + type + '">' + message + '</div>' );
        
        $( '#customize-header-actions' ).append( $notification );
        
        setTimeout( function() {
            $notification.fadeOut( function() {
                $( this ).remove();
            });
        }, 3000 );
    }
    
    // Add custom styles for reset buttons
    function addCustomStyles() {
        const styles = `
            <style>
                .mkp-reset-single {
                    background: none;
                    border: none;
                    color: #a0a5aa;
                    cursor: pointer;
                    padding: 0;
                    margin-left: 5px;
                    vertical-align: middle;
                }
                
                .mkp-reset-single:hover {
                    color: #0073aa;
                }
                
                .mkp-reset-single .dashicons {
                    font-size: 16px;
                    width: 16px;
                    height: 16px;
                }
                
                .mkp-reset-section {
                    width: 100%;
                    margin-top: 10px;
                }
                
                .mkp-customizer-notification {
                    position: fixed;
                    top: 46px;
                    right: 0;
                    left: 300px;
                    padding: 10px 15px;
                    background: #fff;
                    border-left: 4px solid #46b450;
                    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
                    z-index: 10000;
                }
                
                .mkp-notification-success {
                    border-left-color: #46b450;
                }
                
                .mkp-notification-error {
                    border-left-color: #dc3232;
                }
                
                .mkp-notification-info {
                    border-left-color: #00a0d2;
                }
                
                /* Improve color picker layout */
                .customize-control-color .wp-picker-container {
                    display: block;
                }
                
                .customize-control-color .wp-picker-container .wp-color-result {
                    margin-bottom: 5px;
                }
                
                /* Sidebar checkbox styling */
                #customize-control-mkp_sidebar_show_posts,
                #customize-control-mkp_sidebar_show_blog,
                #customize-control-mkp_sidebar_show_archive {
                    padding-left: 30px;
                    margin-top: -10px;
                    margin-bottom: 5px;
                }
                
                #customize-control-mkp_sidebar_show_posts label,
                #customize-control-mkp_sidebar_show_blog label,
                #customize-control-mkp_sidebar_show_archive label {
                    font-size: 13px;
                }
                
                /* Remove description spacing for sidebar options */
                #customize-control-mkp_sidebar_show_posts .customize-control-description,
                #customize-control-mkp_sidebar_show_blog .customize-control-description,
                #customize-control-mkp_sidebar_show_archive .customize-control-description {
                    display: none;
                }
                
                /* Disabled state for sidebar options */
                .mkp-control-disabled {
                    opacity: 0.6;
                }
                
                .mkp-control-disabled label {
                    color: #72777c;
                }
                
                /* Group sidebar controls visually */
                #customize-control-mkp_enable_blog_sidebar {
                    margin-bottom: 5px;
                }
                
                #customize-control-mkp_sidebar_show_archive {
                    margin-bottom: 15px;
                }
            </style>
        `;
        
        $( 'head' ).append( styles );
    }
    
    // Setup conditional control visibility
    function setupConditionalControls() {
        // Handle sidebar checkbox dependencies
        wp.customize( 'mkp_enable_blog_sidebar', function( setting ) {
            function toggleSidebarOptions( enabled ) {
                const sidebarControls = [
                    'mkp_sidebar_show_posts',
                    'mkp_sidebar_show_blog',
                    'mkp_sidebar_show_archive'
                ];
                
                sidebarControls.forEach( function( controlId ) {
                    const control = wp.customize.control( controlId );
                    if ( control ) {
                        const $container = control.container;
                        const $input = $container.find( 'input[type="checkbox"]' );
                        
                        if ( enabled ) {
                            $container.removeClass( 'mkp-control-disabled' );
                            $input.prop( 'disabled', false );
                        } else {
                            $container.addClass( 'mkp-control-disabled' );
                            $input.prop( 'disabled', true );
                        }
                    }
                });
            }
            
            // Initial state
            toggleSidebarOptions( setting.get() );
            
            // Listen for changes
            setting.bind( function( newValue ) {
                toggleSidebarOptions( newValue );
            });
        });
    }
    
} )( jQuery );