/**
 * Fun Facts Modal JavaScript
 *
 * @package MediaKit_Lite
 */

( function() {
    'use strict';

    document.addEventListener( 'DOMContentLoaded', function() {
        const modal = document.getElementById( 'mkp-fun-fact-modal' );
        if ( ! modal ) {
            return;
        }

        const overlay     = modal.querySelector( '.mkp-fun-fact-modal__overlay' );
        const closeBtn    = modal.querySelector( '.mkp-fun-fact-modal__close' );
        const modalImage  = modal.querySelector( '.mkp-fun-fact-modal__image' );
        const modalTitle  = modal.querySelector( '.mkp-fun-fact-modal__title' );
        const modalDesc   = modal.querySelector( '.mkp-fun-fact-modal__description' );
        const imageCol    = modal.querySelector( '.mkp-fun-fact-modal__image-col' );

        // Load fun facts data from JSON script tag
        let factsData = {};
        const dataEl = document.getElementById( 'mkp-fun-facts-data' );
        if ( dataEl ) {
            try {
                factsData = JSON.parse( dataEl.textContent );
            } catch ( e ) {
                // Silently fail
            }
        }

        // Attach click handlers to all fun fact cards
        const cards = document.querySelectorAll( '.mkp-fun-fact-card' );
        cards.forEach( function( card ) {
            card.addEventListener( 'click', function() {
                const factNum = card.getAttribute( 'data-fact' );
                openModal( factNum );
            } );
        } );

        function openModal( factNum ) {
            const data = factsData[ factNum ];
            if ( ! data ) {
                return;
            }

            // Set content
            modalTitle.textContent = data.title;

            // Format description - convert newlines to paragraphs
            if ( data.description ) {
                const formatted = '<p>' + data.description.replace( /\n\n/g, '</p><p>' ).replace( /\n/g, '<br />' ) + '</p>';
                modalDesc.innerHTML = formatted;
            } else {
                modalDesc.innerHTML = '';
            }

            // Set image
            if ( data.image ) {
                modalImage.src = data.image;
                modalImage.alt = data.title;
                imageCol.style.display = '';
            } else {
                imageCol.style.display = 'none';
            }

            // Show modal
            modal.classList.add( 'mkp-fun-fact-modal--active' );
            document.body.style.overflow = 'hidden';
            modal.setAttribute( 'aria-hidden', 'false' );
        }

        function closeModal() {
            modal.classList.remove( 'mkp-fun-fact-modal--active' );
            document.body.style.overflow = '';
            modal.setAttribute( 'aria-hidden', 'true' );
        }

        // Close handlers
        closeBtn.addEventListener( 'click', closeModal );
        overlay.addEventListener( 'click', closeModal );

        // Keyboard - Escape to close
        document.addEventListener( 'keydown', function( e ) {
            if ( e.key === 'Escape' && modal.classList.contains( 'mkp-fun-fact-modal--active' ) ) {
                closeModal();
            }
        } );
    } );

} )();
