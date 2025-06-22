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
        
        // Listen for section enable/disable changes
        var sections = ['books', 'speaker_topics', 'podcast', 'corporations', 'media_questions', 'investor', 'in_the_media', 'contact'];
        
        $.each( sections, function( index, section ) {
            wp.customize( 'mkp_enable_section_' + section, function( setting ) {
                setting.bind( function( enabled ) {
                    var $item = $( '.mkp-section-order-item[data-section="' + section + '"]' );
                    
                    if ( enabled ) {
                        $item.removeClass( 'mkp-section-disabled' );
                        $item.find( '.mkp-section-order-status' ).remove();
                    } else {
                        $item.addClass( 'mkp-section-disabled' );
                        if ( ! $item.find( '.mkp-section-order-status' ).length ) {
                            $item.append( '<span class="mkp-section-order-status">(Hidden)</span>' );
                        }
                    }
                });
            });
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