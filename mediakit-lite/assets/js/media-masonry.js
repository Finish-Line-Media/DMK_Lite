/**
 * Media Masonry JavaScript
 *
 * @package MediaKit_Lite
 */

( function() {
    'use strict';
    
    let masonryInstance = null;
    
    // Initialize when DOM is ready
    document.addEventListener( 'DOMContentLoaded', function() {
        const mediaGrid = document.querySelector( '.mkp-media-grid' );
        
        if ( ! mediaGrid ) {
            return;
        }
        
        // Initialize Masonry
        if ( typeof Masonry !== 'undefined' ) {
            masonryInstance = new Masonry( mediaGrid, {
                itemSelector: '.mkp-media-embed',
                columnWidth: '.mkp-media-embed',
                percentPosition: true,
                gutter: 20,
                transitionDuration: '0.3s'
            });
            
            // Layout after all embeds have loaded
            if ( typeof imagesLoaded !== 'undefined' ) {
                imagesLoaded( mediaGrid, function() {
                    masonryInstance.layout();
                    
                    // Also wait for iframes to load
                    const iframes = mediaGrid.querySelectorAll( 'iframe' );
                    let loadedCount = 0;
                    
                    if ( iframes.length > 0 ) {
                        iframes.forEach( function( iframe ) {
                            iframe.addEventListener( 'load', function() {
                                loadedCount++;
                                if ( loadedCount === iframes.length ) {
                                    // All iframes loaded, relayout
                                    setTimeout( function() {
                                        masonryInstance.layout();
                                    }, 500 );
                                }
                            });
                        });
                    }
                });
            }
            
            // Relayout on window resize
            let resizeTimer;
            window.addEventListener( 'resize', function() {
                clearTimeout( resizeTimer );
                resizeTimer = setTimeout( function() {
                    if ( masonryInstance ) {
                        masonryInstance.layout();
                    }
                }, 250 );
            });
        }
    });
    
})();