/**
 * Navbar Scroll Arrows
 * Handles horizontal scrolling of navigation menu with arrow buttons
 *
 * @package MediaKit_Lite
 */

(function() {
    'use strict';

    // Only run on desktop/tablet (769px+)
    if (window.innerWidth < 769) {
        return;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nav = document.querySelector('.mkp-nav');
        const leftArrow = document.querySelector('.mkp-nav-scroll--left');
        const rightArrow = document.querySelector('.mkp-nav-scroll--right');

        if (!nav || !leftArrow || !rightArrow) {
            return;
        }

        // Scroll amount (in pixels)
        const scrollAmount = 200;

        // Scroll left
        leftArrow.addEventListener('click', function() {
            nav.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });

        // Scroll right
        rightArrow.addEventListener('click', function() {
            nav.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });

        // Update arrow visibility based on scroll position
        function updateArrows() {
            const scrollLeft = nav.scrollLeft;
            const maxScroll = nav.scrollWidth - nav.clientWidth;

            // Hide left arrow if at the start
            if (scrollLeft <= 0) {
                leftArrow.classList.add('mkp-nav-scroll--hidden');
            } else {
                leftArrow.classList.remove('mkp-nav-scroll--hidden');
            }

            // Hide right arrow if at the end
            if (scrollLeft >= maxScroll - 1) { // -1 for rounding errors
                rightArrow.classList.add('mkp-nav-scroll--hidden');
            } else {
                rightArrow.classList.remove('mkp-nav-scroll--hidden');
            }

            // Hide both arrows if nav is not scrollable
            if (maxScroll <= 0) {
                leftArrow.classList.add('mkp-nav-scroll--hidden');
                rightArrow.classList.add('mkp-nav-scroll--hidden');
            }
        }

        // Update arrows on scroll
        nav.addEventListener('scroll', updateArrows);

        // Update arrows on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 769) {
                updateArrows();
            }
        });

        // Initial update
        updateArrows();
    });
})();
