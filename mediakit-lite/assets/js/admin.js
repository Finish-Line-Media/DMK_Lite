/**
 * MediaKit Lite Admin JavaScript
 *
 * Handles update checking functionality for both dashboard widget and admin page
 *
 * @package MediaKit_Lite
 * @since 1.10.6
 */

(function($) {
    'use strict';

    /**
     * Handle update check button clicks
     */
    function handleUpdateCheck(button) {
        var $button = $(button);
        var originalText = $button.text();
        
        $button.prop('disabled', true).text(mkpAdmin.checkingText);
        
        $.post(ajaxurl, {
            action: 'mkp_force_update_check',
            nonce: mkpAdmin.nonce
        })
        .done(function(response) {
            // Log debug information if available
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
                var errorMsg = response.data && response.data.message ? 
                    response.data.message : 
                    mkpAdmin.errorText;
                alert(errorMsg);
                
                if (response.data && response.data.debug) {
                    console.error('Update check error debug:', response.data.debug);
                }
                
                $button.prop('disabled', false).text(originalText);
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Update check network error:', status, error);
            alert(mkpAdmin.networkErrorText);
            $button.prop('disabled', false).text(originalText);
        });
    }

    /**
     * Initialize admin functionality
     */
    $(document).ready(function() {
        // Dashboard widget update check
        $('.mkp-check-updates-dashboard').on('click', function(e) {
            e.preventDefault();
            handleUpdateCheck(this);
        });
        
        // Main admin page update check
        $('.mkp-check-updates-main').on('click', function(e) {
            e.preventDefault();
            handleUpdateCheck(this);
        });
    });

})(jQuery);