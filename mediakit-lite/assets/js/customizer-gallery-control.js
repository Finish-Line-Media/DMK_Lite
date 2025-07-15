/**
 * Gallery Control JavaScript for Customizer
 *
 * @package MediaKit_Lite
 */

( function( $, wp ) {
    'use strict';
    
    // Ensure customizer object exists
    if ( ! wp || ! wp.customize ) {
        return;
    }
    
    // When customizer is ready
    wp.customize.bind( 'ready', function() {
        
        // Initialize gallery controls
        $( '.mkp-gallery-control' ).each( function() {
            initializeGalleryControl( $( this ) );
        });
        
        /**
         * Initialize a gallery control
         */
        function initializeGalleryControl( $control ) {
            const $input = $control.find( '.mkp-gallery-control__value' );
            const $preview = $control.find( '.mkp-gallery-control__preview' );
            const $selectBtn = $control.find( '.mkp-gallery-control__select' );
            const $clearBtn = $control.find( '.mkp-gallery-control__clear' );
            
            let frame;
            
            // Select/Change images button
            $selectBtn.on( 'click', function( e ) {
                e.preventDefault();
                
                // Create media frame if it doesn't exist
                if ( ! frame ) {
                    frame = wp.media({
                        title: mkpGallery.l10n.title,
                        button: {
                            text: mkpGallery.l10n.button
                        },
                        multiple: 'add',
                        library: {
                            type: 'image'
                        }
                    });
                    
                    // When images are selected
                    frame.on( 'select', function() {
                        const selection = frame.state().get( 'selection' );
                        const imageIds = [];
                        const imageHtml = [];
                        
                        selection.each( function( attachment ) {
                            const id = attachment.get( 'id' );
                            const url = attachment.get( 'sizes' ).thumbnail ? 
                                        attachment.get( 'sizes' ).thumbnail.url : 
                                        attachment.get( 'url' );
                            
                            imageIds.push( id );
                            
                            imageHtml.push(
                                '<div class="mkp-gallery-control__image" data-id="' + id + '">' +
                                    '<img src="' + url + '" alt="">' +
                                    '<button type="button" class="mkp-gallery-control__remove" aria-label="Remove image">' +
                                        '<span class="dashicons dashicons-no"></span>' +
                                    '</button>' +
                                '</div>'
                            );
                        });
                        
                        // Update preview
                        if ( imageIds.length > 0 ) {
                            $preview.html( '<div class="mkp-gallery-control__images">' + imageHtml.join( '' ) + '</div>' );
                            $selectBtn.text( $selectBtn.data( 'change-text' ) || 'Change Images' );
                            
                            // Show clear button
                            if ( $clearBtn.length === 0 ) {
                                $control.find( '.mkp-gallery-control__buttons' ).append(
                                    '<button type="button" class="button mkp-gallery-control__clear">Remove</button>'
                                );
                            }
                        }
                        
                        // Update value
                        $input.val( imageIds.join( ',' ) ).trigger( 'change' );
                    });
                    
                    // Pre-select existing images
                    frame.on( 'open', function() {
                        const selection = frame.state().get( 'selection' );
                        const currentIds = $input.val().split( ',' ).filter( Boolean );
                        
                        currentIds.forEach( function( id ) {
                            const attachment = wp.media.attachment( id );
                            attachment.fetch();
                            selection.add( attachment ? [ attachment ] : [] );
                        });
                    });
                }
                
                frame.open();
            });
            
            // Clear all images
            $control.on( 'click', '.mkp-gallery-control__clear', function( e ) {
                e.preventDefault();
                
                $preview.html( '<div class="mkp-gallery-control__placeholder">No images selected</div>' );
                $input.val( '' ).trigger( 'change' );
                $selectBtn.text( $selectBtn.data( 'select-text' ) || 'Select Images' );
                $( this ).remove();
            });
            
            // Remove individual image
            $control.on( 'click', '.mkp-gallery-control__remove', function( e ) {
                e.preventDefault();
                e.stopPropagation();
                
                const $image = $( this ).closest( '.mkp-gallery-control__image' );
                const removeId = $image.data( 'id' );
                const currentIds = $input.val().split( ',' ).filter( Boolean );
                const newIds = currentIds.filter( function( id ) {
                    return parseInt( id ) !== parseInt( removeId );
                });
                
                $image.fadeOut( function() {
                    $( this ).remove();
                    
                    if ( newIds.length === 0 ) {
                        $preview.html( '<div class="mkp-gallery-control__placeholder">No images selected</div>' );
                        $selectBtn.text( $selectBtn.data( 'select-text' ) || 'Select Images' );
                        $control.find( '.mkp-gallery-control__clear' ).remove();
                    }
                });
                
                $input.val( newIds.join( ',' ) ).trigger( 'change' );
            });
            
            // Make images sortable
            if ( $.fn.sortable ) {
                $control.find( '.mkp-gallery-control__images' ).sortable({
                    items: '.mkp-gallery-control__image',
                    cursor: 'move',
                    tolerance: 'pointer',
                    stop: function() {
                        const newIds = [];
                        $( this ).find( '.mkp-gallery-control__image' ).each( function() {
                            newIds.push( $( this ).data( 'id' ) );
                        });
                        $input.val( newIds.join( ',' ) ).trigger( 'change' );
                    }
                });
            }
        }
    });
    
})( jQuery, wp );