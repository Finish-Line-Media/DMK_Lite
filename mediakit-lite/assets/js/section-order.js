/**
 * Section order customizer control
 *
 * @package MediaKit_Lite
 */

( function( $ ) {
    
    wp.customize.controlConstructor['section_order'] = wp.customize.Control.extend({
        
        ready: function() {
            var control = this;
            
            // Initialize sortable
            control.container.find( '.mkp-section-order-list' ).sortable({
                items: '.mkp-section-sortable',
                handle: '.mkp-section-order-handle',
                axis: 'y',
                update: function( event, ui ) {
                    control.updateOrder();
                }
            });
        },
        
        updateOrder: function() {
            var control = this,
                order = [];
            
            // Collect the order
            control.container.find( '.mkp-section-order-item' ).each( function() {
                order.push( $( this ).data( 'section' ) );
            });
            
            // Update the hidden input
            control.container.find( '.mkp-section-order-input' ).val( order.join( ',' ) ).trigger( 'change' );
            
            // Update the setting
            control.setting.set( order.join( ',' ) );
        }
        
    });
    
} )( jQuery );