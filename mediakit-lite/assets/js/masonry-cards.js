/**
 * Universal Masonry Card Height Control
 * Handles read more/less functionality for all masonry sections
 *
 * @package MediaKit_Lite
 */

( function() {
    'use strict';
    
    // Initialize when DOM is ready
    document.addEventListener( 'DOMContentLoaded', function() {
        initializeMasonryCards();
        
        // Re-initialize when window resizes (for dynamic content)
        let resizeTimer;
        window.addEventListener( 'resize', function() {
            clearTimeout( resizeTimer );
            resizeTimer = setTimeout( function() {
                initializeMasonryCards();
            }, 250 );
        });
    });
    
    /**
     * Initialize all masonry cards with height control
     */
    function initializeMasonryCards() {
        const descriptions = document.querySelectorAll( '.mkp-masonry-card__description' );
        
        descriptions.forEach( function( description ) {
            if ( description.dataset.initialized ) {
                return;
            }
            
            setupDescriptionCard( description );
            description.dataset.initialized = 'true';
        });
    }
    
    /**
     * Setup individual description card with overflow detection and read more
     */
    function setupDescriptionCard( description ) {
        // Check if content overflows the max height
        const isOverflowing = isContentOverflowing( description );
        
        if ( isOverflowing ) {
            description.classList.add( 'mkp-description--clamped' );
            
            // Add has-overflow class to parent card for gradient styling
            const card = description.closest( '.mkp-card' );
            if ( card ) {
                card.classList.add( 'mkp-card--has-overflow' );
            }
            
            // Create and add read more button
            const readMoreBtn = createReadMoreButton( description );
            description.parentNode.insertBefore( readMoreBtn, description.nextSibling );
        }
    }
    
    /**
     * Check if content overflows the container height
     */
    function isContentOverflowing( element ) {
        // Temporarily remove height constraint to measure full content
        const originalMaxHeight = element.style.maxHeight;
        const originalOverflow = element.style.overflow;
        
        element.style.maxHeight = 'none';
        element.style.overflow = 'visible';
        
        const isOverflowing = element.scrollHeight > 120; // Our max-height in pixels
        
        // Restore original styles
        element.style.maxHeight = originalMaxHeight;
        element.style.overflow = originalOverflow;
        
        return isOverflowing;
    }
    
    /**
     * Create read more/less toggle button
     */
    function createReadMoreButton( description ) {
        const button = document.createElement( 'button' );
        button.className = 'mkp-read-more-btn';
        button.textContent = 'Read more';
        button.setAttribute( 'aria-expanded', 'false' );
        
        // Add click handler
        button.addEventListener( 'click', function( e ) {
            e.preventDefault();
            toggleDescription( description, button );
        });
        
        return button;
    }
    
    /**
     * Toggle description expanded/collapsed state
     */
    function toggleDescription( description, button ) {
        const isExpanded = description.classList.contains( 'mkp-description--expanded' );
        
        if ( isExpanded ) {
            // Collapse
            description.classList.remove( 'mkp-description--expanded' );
            button.textContent = 'Read more';
            button.setAttribute( 'aria-expanded', 'false' );
            
            // Scroll to top of card for better UX
            description.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        } else {
            // Expand
            description.classList.add( 'mkp-description--expanded' );
            button.textContent = 'Read less';
            button.setAttribute( 'aria-expanded', 'true' );
        }
        
        // Trigger masonry relayout if available
        relayoutMasonry();
    }
    
    /**
     * Trigger masonry relayout across all instances
     */
    function relayoutMasonry() {
        // Small delay to let CSS transitions complete
        setTimeout( function() {
            // Trigger custom event that masonry scripts can listen to
            window.dispatchEvent( new CustomEvent( 'masonryRelayout' ) );
            
            // Direct relayout for common masonry instances
            if ( window.booksmasonry && typeof window.booksMasonry.layout === 'function' ) {
                window.booksMasonry.layout();
            }
            
            if ( window.podcastsMasonry && typeof window.podcastsMasonry.layout === 'function' ) {
                window.podcastsMasonry.layout();
            }
            
            // Also try to find masonry instances in global scope
            ['masonryInstance', 'masonry'].forEach( function( varName ) {
                if ( window[varName] && typeof window[varName].layout === 'function' ) {
                    window[varName].layout();
                }
            });
        }, 300 );
    }
    
})();