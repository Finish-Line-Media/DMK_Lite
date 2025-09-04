/**
 * Books Masonry JavaScript
 *
 * @package MediaKit_Lite
 */

( function() {
    'use strict';
    
    let masonryInstance = null;
    
    // Initialize when DOM is ready
    document.addEventListener( 'DOMContentLoaded', function() {
        const booksGrid = document.querySelector( '.mkp-books__grid' );
        
        if ( ! booksGrid ) {
            return;
        }
        
        // Initialize Masonry
        if ( typeof Masonry !== 'undefined' ) {
            // Determine gutter based on column layout
            let gutterSize = 20;
            if ( booksGrid.classList.contains( 'mkp-books__grid--three-columns' ) ) {
                gutterSize = 20;
            } else if ( booksGrid.classList.contains( 'mkp-books__grid--two-columns' ) ) {
                gutterSize = 20;
            } else {
                gutterSize = 0; // No gutter for single column
            }
            
            masonryInstance = new Masonry( booksGrid, {
                itemSelector: '.mkp-book-card',
                columnWidth: '.mkp-book-card',
                percentPosition: true,
                gutter: gutterSize,
                transitionDuration: '0.3s'
            });
            
            // Layout after all images have loaded
            if ( typeof imagesLoaded !== 'undefined' ) {
                imagesLoaded( booksGrid, function() {
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