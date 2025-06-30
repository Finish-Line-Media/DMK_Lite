/**
 * Main JavaScript file for MediaKit Lite theme
 */

(function($) {
    'use strict';
    
    // Mobile Navigation Toggle
    const mobileToggle = document.querySelector('.mkp-mobile-toggle');
    const navigation = document.querySelector('.mkp-nav');
    
    if (mobileToggle && navigation) {
        mobileToggle.addEventListener('click', function() {
            this.classList.toggle('is-active');
            navigation.classList.toggle('mkp-nav--active');
            this.setAttribute('aria-expanded', navigation.classList.contains('mkp-nav--active'));
        });
    }
    
    // Smooth Scroll for anchor links (only for hash links on the same page)
    $('a[href^="#"]:not([href="#"])').on('click', function(e) {
        // Only handle if it's a hash link (not full URL)
        const href = $(this).attr('href');
        if (href && href.charAt(0) === '#') {
            const target = $(href);
            
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
                return false;
            }
        }
    });
    
    // Sticky Header
    const header = document.querySelector('.mkp-header');
    let lastScrollTop = 0;
    
    if (header) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                header.classList.add('mkp-header--scrolled');
                
                if (scrollTop > lastScrollTop) {
                    header.classList.add('mkp-header--hidden');
                } else {
                    header.classList.remove('mkp-header--hidden');
                }
            } else {
                header.classList.remove('mkp-header--scrolled');
                header.classList.remove('mkp-header--hidden');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    }
    
    // Stats Counter Animation
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };
    
    const animateValue = (element, start, end, duration) => {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    };
    
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                const statsNumbers = entry.target.querySelectorAll('.mkp-stats__number');
                statsNumbers.forEach(stat => {
                    const endValue = parseInt(stat.getAttribute('data-count'));
                    animateValue(stat, 0, endValue, 2000);
                });
                entry.target.classList.add('animated');
            }
        });
    }, observerOptions);
    
    const statsSection = document.querySelector('.mkp-stats--animated');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
    
    // Media Tabs
    $('.mkp-media-tabs__button').on('click', function() {
        const tabName = $(this).attr('data-tab');
        
        $('.mkp-media-tabs__button').removeClass('is-active');
        $(this).addClass('is-active');
        
        if (tabName === 'all') {
            $('.mkp-media-item').show();
        } else {
            $('.mkp-media-item').hide();
            $('.mkp-media-item[data-media-type*="' + tabName + '"]').show();
        }
    });
    
    // Copy to Clipboard functionality
    $('.mkp-copy-about').on('click', function() {
        const aboutType = $(this).attr('data-about');
        const aboutContent = $(this).siblings('.mkp-about-version__content').text();
        
        navigator.clipboard.writeText(aboutContent).then(() => {
            const originalText = $(this).text();
            $(this).text('Copied!');
            setTimeout(() => {
                $(this).text(originalText);
            }, 2000);
        });
    });
    
    $('.mkp-copy-questions').on('click', function() {
        const questions = [];
        $(this).siblings('.mkp-questions-list').find('li').each(function() {
            questions.push($(this).text());
        });
        
        navigator.clipboard.writeText(questions.join('\n')).then(() => {
            const originalText = $(this).text();
            $(this).text('Copied!');
            setTimeout(() => {
                $(this).text(originalText);
            }, 2000);
        });
    });
    
    
    // Lazy Loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => imageObserver.observe(img));
    }
    
    // Video Section - Play/Pause on scroll
    const videos = document.querySelectorAll('.mkp-hero__video');
    if (videos.length) {
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.play();
                } else {
                    entry.target.pause();
                }
            });
        }, { threshold: 0.5 });
        
        videos.forEach(video => videoObserver.observe(video));
    }
    
    // Form Validation
    $('.mkp-form').on('submit', function(e) {
        let isValid = true;
        
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('error');
                isValid = false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
    // Accessibility: Skip links
    $('.skip-link').on('click', function(e) {
        e.preventDefault();
        const target = $(this).attr('href');
        $(target).attr('tabindex', '-1').focus();
    });
    
    // Contact Form Handling
    $('.mkp-contact-form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('.mkp-form-submit');
        const $submitText = $submitBtn.find('.mkp-form-submit-text');
        const $submitLoading = $submitBtn.find('.mkp-form-submit-loading');
        const $messages = $form.find('.mkp-form-messages');
        
        // Clear previous messages
        $messages.empty();
        
        // Validate form
        let isValid = true;
        $form.find('[required]').each(function() {
            if (!$(this).val().trim()) {
                $(this).addClass('error');
                isValid = false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if (!isValid) {
            $messages.html('<div class="mkp-form-message mkp-form-message--error">Please fill in all required fields.</div>');
            return;
        }
        
        // Show loading state
        $submitBtn.prop('disabled', true);
        $submitText.hide();
        $submitLoading.show();
        
        // Submit form via AJAX
        $.ajax({
            url: mkp_ajax.ajax_url,
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                if (response.success) {
                    $messages.html('<div class="mkp-form-message mkp-form-message--success">' + response.data.message + '</div>');
                    $form[0].reset();
                    
                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: $messages.offset().top - 100
                    }, 500);
                } else {
                    $messages.html('<div class="mkp-form-message mkp-form-message--error">' + response.data + '</div>');
                }
            },
            error: function() {
                $messages.html('<div class="mkp-form-message mkp-form-message--error">An error occurred. Please try again.</div>');
            },
            complete: function() {
                // Reset button state
                $submitBtn.prop('disabled', false);
                $submitText.show();
                $submitLoading.hide();
            }
        });
    });
    
    // Clear error state on input
    $('.mkp-contact-form').on('input change', 'input.error, textarea.error, select.error', function() {
        $(this).removeClass('error');
    });
    
    // Fix social links functionality
    $(document).ready(function() {
        // Remove customize-unpreviewable class from social links
        $('.mkp-social__link').removeClass('customize-unpreviewable');
        
        // Ensure social links are clickable
        $('.mkp-social__link').on('click', function(e) {
            e.stopPropagation();
        });
        
        // Remove any conflicting inline styles on hover
        $('.mkp-social__link').hover(
            function() {
                $(this).removeAttr('style').addClass('hovered');
            },
            function() {
                $(this).removeClass('hovered');
            }
        );
    });
    
})(jQuery);