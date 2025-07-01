/**
 * Debug logging for customizer exit
 */
( function( $ ) {
    
    // Log when customizer is ready
    wp.customize.bind( 'ready', function() {
        console.log( '[MediaKit Debug] Customizer ready' );
        
        // Monitor for close button clicks
        $( '.customize-controls-close' ).on( 'click', function(e) {
            console.log( '[MediaKit Debug] Close button clicked' );
            console.log( '[MediaKit Debug] Changeset status:', wp.customize.state( 'changesetStatus' ).get() );
            console.log( '[MediaKit Debug] Changeset UUID:', wp.customize.settings.changeset.uuid );
            console.log( '[MediaKit Debug] Is theme preview:', wp.customize.settings.theme.active );
            
            // Log any unsaved changes
            var unsaved = false;
            wp.customize.each( function( setting ) {
                if ( setting._dirty ) {
                    unsaved = true;
                    console.log( '[MediaKit Debug] Unsaved setting:', setting.id );
                }
            });
            
            if ( unsaved ) {
                console.log( '[MediaKit Debug] WARNING: Exiting with unsaved changes!' );
            }
        });
        
        // Monitor for beforeunload
        $( window ).on( 'beforeunload', function() {
            console.log( '[MediaKit Debug] Window unloading from customizer' );
        });
    });
    
} )( jQuery );