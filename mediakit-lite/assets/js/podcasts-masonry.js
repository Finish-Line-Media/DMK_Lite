/**
 * Podcasts Masonry JavaScript
 *
 * @package MediaKit_Lite
 */

( function() {
    'use strict';
    
    let masonryInstance = null;
    
    // Initialize when DOM is ready
    document.addEventListener( 'DOMContentLoaded', function() {
        const podcastsGrid = document.querySelector( '.mkp-podcasts__grid' );
        
        if ( ! podcastsGrid ) {
            return;
        }
        
        // Initialize Masonry
        if ( typeof Masonry !== 'undefined' ) {
            masonryInstance = new Masonry( podcastsGrid, {
                itemSelector: '.mkp-podcast-card',
                columnWidth: '.mkp-podcast-card',
                percentPosition: true,
                gutter: 20,
                transitionDuration: '0.3s'
            });
            
            // Layout after all images have loaded
            if ( typeof imagesLoaded !== 'undefined' ) {
                imagesLoaded( podcastsGrid, function() {
                    masonryInstance.layout();
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
    
    // Listen for universal relayout events from masonry-cards.js
    window.addEventListener( 'masonryRelayout', function() {
        if ( masonryInstance ) {
            masonryInstance.layout();
        }
    });
    
})();