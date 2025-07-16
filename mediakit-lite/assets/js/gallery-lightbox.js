/**
 * Gallery Lightbox JavaScript
 *
 * @package MediaKit_Lite
 */

( function() {
    'use strict';
    
    let currentImageIndex = 0;
    let galleryImages = [];
    let masonryInstance = null;
    
    // Initialize when DOM is ready
    document.addEventListener( 'DOMContentLoaded', function() {
        const lightbox = document.getElementById( 'mkp-lightbox' );
        if ( ! lightbox ) {
            return;
        }
        
        // Get all gallery items
        const galleryItems = document.querySelectorAll( '.mkp-gallery__item' );
        if ( ! galleryItems.length ) {
            return;
        }
        
        // Initialize Masonry
        const grid = document.querySelector( '.mkp-gallery__grid' );
        if ( grid && typeof Masonry !== 'undefined' ) {
            // Initialize Masonry
            masonryInstance = new Masonry( grid, {
                itemSelector: '.mkp-gallery__item',
                columnWidth: '.mkp-gallery__item',
                percentPosition: true,
                gutter: 16,
                transitionDuration: '0.3s'
            });
            
            // Layout after all images have loaded
            if ( typeof imagesLoaded !== 'undefined' ) {
                imagesLoaded( grid, function() {
                    masonryInstance.layout();
                });
            }
        }
        
        // Build images array
        galleryItems.forEach( function( item, index ) {
            const imageData = {
                url: item.dataset.image,
                caption: item.dataset.caption || '',
                element: item
            };
            galleryImages.push( imageData );
            
            // Add click handler
            item.addEventListener( 'click', function() {
                openLightbox( index );
            });
        });
        
        // Add lightbox controls
        const closeBtn = lightbox.querySelector( '.mkp-lightbox__close' );
        const prevBtn = lightbox.querySelector( '.mkp-lightbox__prev' );
        const nextBtn = lightbox.querySelector( '.mkp-lightbox__next' );
        const lightboxImage = lightbox.querySelector( '.mkp-lightbox__image' );
        const lightboxCaption = lightbox.querySelector( '.mkp-lightbox__caption' );
        
        // Close button
        closeBtn.addEventListener( 'click', closeLightbox );
        
        // Navigation buttons
        prevBtn.addEventListener( 'click', function( e ) {
            e.stopPropagation();
            navigateImage( -1 );
        });
        
        nextBtn.addEventListener( 'click', function( e ) {
            e.stopPropagation();
            navigateImage( 1 );
        });
        
        // Close on background click
        lightbox.addEventListener( 'click', function( e ) {
            if ( e.target === lightbox || e.target === lightbox.querySelector( '.mkp-lightbox__content' ) ) {
                closeLightbox();
            }
        });
        
        // Keyboard navigation
        document.addEventListener( 'keydown', function( e ) {
            if ( ! lightbox.classList.contains( 'mkp-lightbox--active' ) ) {
                return;
            }
            
            switch ( e.key ) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'ArrowLeft':
                    navigateImage( -1 );
                    break;
                case 'ArrowRight':
                    navigateImage( 1 );
                    break;
            }
        });
        
        // Touch swipe support
        let touchStartX = 0;
        let touchEndX = 0;
        
        lightbox.addEventListener( 'touchstart', function( e ) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        lightbox.addEventListener( 'touchend', function( e ) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if ( Math.abs( diff ) > swipeThreshold ) {
                if ( diff > 0 ) {
                    // Swipe left - next image
                    navigateImage( 1 );
                } else {
                    // Swipe right - previous image
                    navigateImage( -1 );
                }
            }
        }
        
        // Functions
        function openLightbox( index ) {
            currentImageIndex = index;
            updateLightboxImage();
            
            // Add classes
            lightbox.classList.add( 'mkp-lightbox--active' );
            if ( galleryImages.length === 1 ) {
                lightbox.classList.add( 'mkp-lightbox--single' );
            }
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
            
            // Set ARIA
            lightbox.setAttribute( 'aria-hidden', 'false' );
        }
        
        function closeLightbox() {
            lightbox.classList.remove( 'mkp-lightbox--active' );
            
            // Restore body scroll
            document.body.style.overflow = '';
            
            // Set ARIA
            lightbox.setAttribute( 'aria-hidden', 'true' );
        }
        
        function navigateImage( direction ) {
            currentImageIndex += direction;
            
            // Wrap around
            if ( currentImageIndex < 0 ) {
                currentImageIndex = galleryImages.length - 1;
            } else if ( currentImageIndex >= galleryImages.length ) {
                currentImageIndex = 0;
            }
            
            updateLightboxImage();
        }
        
        function updateLightboxImage() {
            const imageData = galleryImages[ currentImageIndex ];
            
            // Update image
            lightboxImage.src = imageData.url;
            lightboxImage.alt = imageData.caption;
            
            // Update caption
            if ( imageData.caption ) {
                lightboxCaption.textContent = imageData.caption;
                lightboxCaption.style.display = 'block';
            } else {
                lightboxCaption.style.display = 'none';
            }
            
            // Preload adjacent images
            preloadImage( currentImageIndex - 1 );
            preloadImage( currentImageIndex + 1 );
        }
        
        function preloadImage( index ) {
            if ( index < 0 || index >= galleryImages.length ) {
                return;
            }
            
            const img = new Image();
            img.src = galleryImages[ index ].url;
        }
    });
    
})();