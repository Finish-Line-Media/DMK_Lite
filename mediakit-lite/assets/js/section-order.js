/**
 * Section order customizer control
 *
 * @package MediaKit_Lite
 */

( function( $ ) {
    
    // Wait for the customizer to be ready
    wp.customize.bind( 'ready', function() {
        
        // Initialize sortable on our section order list
        $( '#mkp-sortable-sections' ).sortable({
            items: '.mkp-section-sortable',
            handle: '.mkp-section-order-handle',
            axis: 'y',
            cursor: 'move',
            placeholder: 'mkp-section-placeholder',
            forcePlaceholderSize: true,
            update: function( event, ui ) {
                var order = [];
                
                // Collect the new order
                $( '#mkp-sortable-sections .mkp-section-order-item' ).each( function() {
                    order.push( $( this ).data( 'section' ) );
                });
                
                // Update the hidden input
                $( '.mkp-section-order-input' ).val( order.join( ',' ) ).trigger( 'change' );
            }
        });
        
        // Add visual feedback
        $( '#mkp-sortable-sections' ).on( 'sortstart', function( event, ui ) {
            ui.placeholder.height( ui.item.height() );
        });
        
    });
    
    // Also register as a custom control for compatibility
    if ( wp.customize.controlConstructor ) {
        wp.customize.controlConstructor['section_order'] = wp.customize.Control.extend({
            ready: function() {
                // Control is ready
            }
        });
    }
    
} )( jQuery );