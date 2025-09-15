/**
 * Enhanced live preview with auto-contrast
 *
 * @package MediaKit_Lite
 */

( function( $ ) {
    
    // Helper function to calculate luminance
    function getLuminance( hex ) {
        // Remove # if present
        hex = hex.replace( '#', '' );
        
        // Convert to RGB
        const r = parseInt( hex.substr( 0, 2 ), 16 ) / 255;
        const g = parseInt( hex.substr( 2, 2 ), 16 ) / 255;
        const b = parseInt( hex.substr( 4, 2 ), 16 ) / 255;
        
        // Calculate luminance
        const rLinear = r <= 0.03928 ? r / 12.92 : Math.pow( ( r + 0.055 ) / 1.055, 2.4 );
        const gLinear = g <= 0.03928 ? g / 12.92 : Math.pow( ( g + 0.055 ) / 1.055, 2.4 );
        const bLinear = b <= 0.03928 ? b / 12.92 : Math.pow( ( b + 0.055 ) / 1.055, 2.4 );
        
        return 0.2126 * rLinear + 0.7152 * gLinear + 0.0722 * bLinear;
    }
    
    // Helper function to determine if color is light
    function isLightColor( hex ) {
        return getLuminance( hex ) > 0.5;
    }
    
    // Helper function to get contrast color
    function getContrastColor( bgColor ) {
        return isLightColor( bgColor ) ? '#000000' : '#ffffff';
    }
    
    // Helper function to get contrast color with opacity
    function getContrastColorRGBA( bgColor, type ) {
        const isLight = isLightColor( bgColor );
        
        switch ( type ) {
            case 'heading':
                return isLight ? 'rgba(0, 0, 0, 0.9)' : 'rgba(255, 255, 255, 0.95)';
            case 'muted':
                return isLight ? 'rgba(0, 0, 0, 0.6)' : 'rgba(255, 255, 255, 0.7)';
            case 'border':
                return isLight ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.15)';
            default: // text
                return isLight ? 'rgba(0, 0, 0, 0.8)' : 'rgba(255, 255, 255, 0.9)';
        }
    }
    
    /**
     * Generic card section updater
     * Simplifies adding live preview for card-based sections
     * 
     * @param {Object} config - Configuration object
     * @param {string} config.sectionPrefix - Prefix for customizer settings (e.g., 'mkp_testimonial_')
     * @param {string} config.sectionClass - Section class name (e.g., 'mkp-testimonials-section')
     * @param {string} config.cardClass - Card class name (e.g., 'mkp-testimonial-card')
     * @param {number} config.maxItems - Maximum number of items
     * @param {Array} config.fields - Array of field configurations
     */
    function setupCardSectionUpdates( config ) {
        const { sectionPrefix, sectionClass, cardClass, maxItems, fields } = config;
        
        // Handle section title if it exists
        if ( wp.customize.has( sectionPrefix + 'section_title' ) ) {
            wp.customize( sectionPrefix + 'section_title', function( value ) {
                value.bind( function( to ) {
                    $( '.' + sectionClass + ' .mkp-section__title' ).text( to );
                } );
            } );
        }
        
        // Loop through items
        for ( let i = 1; i <= maxItems; i++ ) {
            ( function( itemNum ) {
                fields.forEach( function( field ) {
                    const settingName = sectionPrefix + itemNum + '_' + field.name;
                    
                    if ( wp.customize.has( settingName ) ) {
                        wp.customize( settingName, function( value ) {
                            value.bind( function( to ) {
                                const $card = $( '.' + cardClass + '.' + sectionPrefix.replace('mkp_', 'mkp-').replace('_', '') + '--' + itemNum );
                                
                                // Call the field's update function
                                if ( field.updateFn ) {
                                    field.updateFn( $card, to, itemNum );
                                }
                            } );
                        } );
                    }
                } );
            } )( i );
        }
    }
    
    // Other section background colors with auto-contrast
    const sections = [
        { setting: 'mkp_about_background_color', selector: '.mkp-about-section' },
        { setting: 'mkp_books_background_color', selector: '.mkp-books-section' },
        { setting: 'mkp_podcasts_background_color', selector: '.mkp-podcasts-section' },
        { setting: 'mkp_speaker_topics_background_color', selector: '.mkp-speaker-section' },
        { setting: 'mkp_corporations_background_color', selector: '.mkp-corporations-section' },
        { setting: 'mkp_in_the_media_background_color', selector: '.mkp-in-the-media' },
        { setting: 'mkp_media_questions_background_color', selector: '.mkp-media-questions-section' },
        { setting: 'mkp_investor_background_color', selector: '.mkp-investor-section' },
        { setting: 'mkp_contact_background_color', selector: '.mkp-contact-section' }
    ];
    
    sections.forEach( function( section ) {
        wp.customize( section.setting, function( value ) {
            value.bind( function( to ) {
                const $section = $( section.selector );
                
                // Update background color
                $section.css( 'background-color', to );
                
                // Update text colors based on background
                const textColor = getContrastColor( to );
                const headingColor = getContrastColorRGBA( to, 'heading' );
                
                $section.css( 'color', textColor );
                // Headings inherit color from section - removed inline style override
                
                // Special handling for contact section
                if ( section.selector === '.mkp-contact-section' ) {
                    
                    // Let all contact elements inherit color from section - removed inline style overrides
                    
                    // Add class to indicate light/dark background for CSS to handle
                    if ( isLightColor( to ) ) {
                        $section.addClass( 'mkp-contact-section--light' ).removeClass( 'mkp-contact-section--dark' );
                    } else {
                        $section.addClass( 'mkp-contact-section--dark' ).removeClass( 'mkp-contact-section--light' );
                    }
                }
                
                // Special handling for speaker topic cards
                if ( section.selector === '.mkp-speaker-section' ) {
                    const isLight = isLightColor( to );
                    
                    // Update card backgrounds to contrast with section background
                    if ( isLight ) {
                        $section.find( '.mkp-speaker__topic' ).css({
                            'background-color': 'rgba(0, 0, 0, 0.05)',
                            'box-shadow': '0 2px 8px rgba(0,0,0,0.1)'
                        });
                    } else {
                        $section.find( '.mkp-speaker__topic' ).css({
                            'background-color': 'rgba(255, 255, 255, 0.1)',
                            'box-shadow': '0 2px 8px rgba(0,0,0,0.3)'
                        });
                    }
                    
                    // Arrow colors handled by CSS - removed inline style override
                }
            } );
        } );
    } );
    
    // Button color updates with proper hover states
    wp.customize( 'mkp_secondary_color', function( value ) {
        value.bind( function( to ) {
            // Update CSS variables
            document.documentElement.style.setProperty( '--mkp-secondary', to );
            
            // Update primary button
            const btnTextColor = getContrastColor( to );
            $( '.mkp-btn--primary' ).css({
                'background-color': to,
                'color': btnTextColor,
                'border-color': to
            });
            
            // Update secondary button
            $( '.mkp-btn--secondary' ).css({
                'color': to,
                'border-color': to
            });
            
            // Arrow colors handled by CSS - removed inline style override
        } );
    } );
    
    wp.customize( 'mkp_accent_color', function( value ) {
        value.bind( function( to ) {
            // Update CSS variables
            document.documentElement.style.setProperty( '--mkp-accent', to );
            
            // Create hover styles
            const hoverTextColor = getContrastColor( to );
            const hoverStyles = `
                .mkp-btn--primary:hover,
                .mkp-btn--primary:focus {
                    background-color: ${to} !important;
                    color: ${hoverTextColor} !important;
                    border-color: ${to} !important;
                }
                .mkp-btn--secondary:hover,
                .mkp-btn--secondary:focus {
                    background-color: ${to} !important;
                    color: ${hoverTextColor} !important;
                    border-color: ${to} !important;
                }
            `;
            
            // Remove old hover styles and add new ones
            $( '#mkp-button-hover-styles' ).remove();
            $( '<style id="mkp-button-hover-styles">' + hoverStyles + '</style>' ).appendTo( 'head' );
        } );
    } );
    
    // Hero name update - also updates site title
    wp.customize( 'mkp_hero_name', function( value ) {
        value.bind( function( to ) {
            // Update hero name
            $( '.mkp-hero__name' ).text( to );
            
            // Also update the site title (blogname) in customizer
            if ( wp.customize.has( 'blogname' ) ) {
                wp.customize( 'blogname' ).set( to );
            }
        } );
    } );
    
    // When site title changes, also update hero name
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            // Update the hero name setting to match
            if ( wp.customize.has( 'mkp_hero_name' ) ) {
                wp.customize( 'mkp_hero_name' ).set( to );
                // Also update the hero name display
                $( '.mkp-hero__name' ).text( to );
            }
        } );
    } );
    
    // Hero tags update
    for ( let i = 1; i <= 7; i++ ) {
        ( function( tagNum ) {
            wp.customize( 'mkp_hero_tag_' + tagNum, function( value ) {
                value.bind( function( to ) {
                    const $tags = $( '.mkp-hero__tags' );
                    const $existingTags = $tags.find( '.mkp-hero__tag' );
                    const tags = [];
                    
                    // Collect all tag values
                    for ( let j = 1; j <= 7; j++ ) {
                        const tagValue = j === tagNum ? to : ( wp.customize( 'mkp_hero_tag_' + j ).get() || '' );
                        if ( tagValue ) {
                            tags.push( tagValue );
                        }
                    }
                    
                    // Rebuild tags with proper spacing
                    $tags.empty();
                    tags.forEach( function( tag, index ) {
                        const $tag = $( '<span class="mkp-hero__tag">' + tag + '</span>' );
                        $tags.append( $tag );
                    } );
                } );
            } );
        } )( i );
    }
    
    // About Section
    wp.customize( 'mkp_about_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-about-section .mkp-section__title' ).text( to );
        } );
    } );
    
    wp.customize( 'mkp_about_content', function( value ) {
        value.bind( function( to ) {
            const $content = $( '.mkp-about-section__content' );
            if ( to ) {
                // Simple wpautop implementation for live preview
                const formattedContent = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                $content.html( formattedContent );
            } else {
                $content.empty();
            }
        } );
    } );
    
    // Featured Video Section
    wp.customize( 'mkp_featured_video_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-featured-video-section .mkp-section__title' ).text( to );
        } );
    } );
    
    wp.customize( 'mkp_featured_video_url', function( value ) {
        value.bind( function( to ) {
            // Video URL changes require refresh for oEmbed processing
            wp.customize.preview.send( 'refresh' );
        } );
    } );
    
    wp.customize( 'mkp_featured_video_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-featured-video__title' ).text( to );
        } );
    } );
    
    wp.customize( 'mkp_featured_video_description', function( value ) {
        value.bind( function( to ) {
            const $description = $( '.mkp-featured-video__description' );
            if ( to ) {
                // Simple wpautop implementation for live preview
                const formattedDesc = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                $description.html( formattedDesc );
            } else {
                $description.empty();
            }
        } );
    } );
    
    wp.customize( 'mkp_featured_video_primary_cta_text', function( value ) {
        value.bind( function( to ) {
            const $btn = $( '.mkp-featured-video__cta .mkp-btn--primary' );
            if ( to ) {
                $btn.text( to ).show();
            } else {
                $btn.hide();
            }
        } );
    } );
    
    wp.customize( 'mkp_featured_video_primary_cta_url', function( value ) {
        value.bind( function( to ) {
            const $btn = $( '.mkp-featured-video__cta .mkp-btn--primary' );
            if ( to ) {
                $btn.attr( 'href', to );
            }
        } );
    } );
    
    wp.customize( 'mkp_featured_video_secondary_cta_text', function( value ) {
        value.bind( function( to ) {
            const $btn = $( '.mkp-featured-video__cta .mkp-btn--secondary' );
            if ( to ) {
                $btn.text( to ).show();
            } else {
                $btn.hide();
            }
        } );
    } );
    
    wp.customize( 'mkp_featured_video_secondary_cta_url', function( value ) {
        value.bind( function( to ) {
            const $btn = $( '.mkp-featured-video__cta .mkp-btn--secondary' );
            if ( to ) {
                $btn.attr( 'href', to );
            }
        } );
    } );
    
    
    // Function to update companies section title
    function updateCompaniesSectionTitle() {
        let companyCount = 0;
        for ( let i = 1; i <= 8; i++ ) {
            const nameExists = wp.customize.has( 'mkp_corp_' + i + '_name' );
            const logoExists = wp.customize.has( 'mkp_corp_' + i + '_logo' );
            const name = nameExists ? wp.customize( 'mkp_corp_' + i + '_name' ).get() : '';
            const logo = logoExists ? wp.customize( 'mkp_corp_' + i + '_logo' ).get() : '';
            if ( name || logo ) {
                companyCount++;
            }
        }
        
        const title = companyCount === 1 ? 'Company' : 'Companies';
        $( '.mkp-corporations-section .mkp-section__title' ).text( title );
    }
    
    // Companies (Corporations) section updates
    const maxCorps = 8;
    for ( let i = 1; i <= maxCorps; i++ ) {
        ( function( corpNum ) {
            // Company name
            wp.customize( 'mkp_corp_' + corpNum + '_name', function( value ) {
                value.bind( function( to ) {
                    // Update the company name
                    const $card = $( '.mkp-corp-card.mkp-corp--' + corpNum );
                    $card.find( '.mkp-corp-card__name' ).text( to );
                    
                    // Show/hide card based on content (name OR logo)
                    const logoExists = wp.customize.has( 'mkp_corp_' + corpNum + '_logo' );
                    const logo = logoExists ? wp.customize( 'mkp_corp_' + corpNum + '_logo' ).get() : '';
                    if ( to || logo ) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                    
                    // Update section title
                    updateCompaniesSectionTitle();
                } );
            } );
            
            // Company bio
            wp.customize( 'mkp_corp_' + corpNum + '_bio', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-corp-card.mkp-corp--' + corpNum );
                    const $bio = $card.find( '.mkp-corp-card__bio' );
                    
                    if ( to ) {
                        // Simple wpautop implementation for live preview
                        const formattedBio = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                        $bio.html( formattedBio );
                    } else {
                        $bio.empty();
                    }
                } );
            } );
            
            // Company logo
            wp.customize( 'mkp_corp_' + corpNum + '_logo', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-corp-card.mkp-corp--' + corpNum );
                    const $logoContainer = $card.find( '.mkp-corp-card__logo' );
                    
                    if ( to ) {
                        // If attachment ID, fetch URL
                        if ( $.isNumeric( to ) ) {
                            wp.media.attachment( to ).fetch().then( function() {
                                const attachment = wp.media.attachment( to );
                                const logoHtml = '<img src="' + attachment.get( 'url' ) + '" alt="" />';
                                $logoContainer.html( logoHtml );
                            } );
                        }
                    } else {
                        // Remove the image when logo is cleared
                        $logoContainer.empty();
                    }
                    
                    // Show/hide card based on content (name OR logo)
                    const nameExists = wp.customize.has( 'mkp_corp_' + corpNum + '_name' );
                    const name = nameExists ? wp.customize( 'mkp_corp_' + corpNum + '_name' ).get() : '';
                    if ( name || to ) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                    
                    // Update section title
                    updateCompaniesSectionTitle();
                } );
            } );
            
            // Company link
            wp.customize( 'mkp_corp_' + corpNum + '_link', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-corp-card.mkp-corp--' + corpNum );
                    const $link = $card.find( '.mkp-btn' );
                    
                    if ( to ) {
                        if ( $link.length ) {
                            $link.attr( 'href', to );
                        } else {
                            // Create the link if it doesn't exist
                            $card.append( '<a href="' + to + '" class="mkp-btn mkp-btn--secondary mkp-btn--small" target="_blank" rel="noopener">Visit Website</a>' );
                        }
                    } else {
                        // Remove the link if URL is empty
                        $link.remove();
                    }
                } );
            } );
        } )( i );
    }
    
    // Function to update books section title
    function updateBooksSectionTitle() {
        let bookCount = 0;
        for ( let i = 1; i <= 6; i++ ) {
            if ( wp.customize.has( 'mkp_book_' + i + '_title' ) ) {
                const title = wp.customize( 'mkp_book_' + i + '_title' ).get();
                if ( title ) {
                    bookCount++;
                }
            }
        }
        
        const title = bookCount === 1 ? 'Book' : 'Books';
        $( '.mkp-books-section .mkp-section__title' ).text( title );
    }
    
    // Books section updates
    const maxBooks = 6;
    for ( let i = 1; i <= maxBooks; i++ ) {
        ( function( bookNum ) {
            // Book title
            wp.customize( 'mkp_book_' + bookNum + '_title', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-book-card.mkp-book--' + bookNum );
                    $card.find( '.mkp-book-card__title' ).text( to );
                    
                    // Show/hide card based on content
                    if ( to ) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                    
                    // Update section title
                    updateBooksSectionTitle();
                } );
            } );
            
            // Book description
            wp.customize( 'mkp_book_' + bookNum + '_description', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-book-card.mkp-book--' + bookNum );
                    const $description = $card.find( '.mkp-book-card__description' );
                    
                    if ( to ) {
                        // Simple wpautop implementation for live preview
                        const formattedDesc = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                        $description.html( formattedDesc );
                    } else {
                        $description.empty();
                    }
                } );
            } );
            
            // Book cover
            wp.customize( 'mkp_book_' + bookNum + '_cover', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-book-card.mkp-book--' + bookNum );
                    const $coverContainer = $card.find( '.mkp-book-card__cover' );
                    
                    if ( to ) {
                        // If attachment ID, fetch URL
                        if ( $.isNumeric( to ) ) {
                            wp.media.attachment( to ).fetch().then( function() {
                                const attachment = wp.media.attachment( to );
                                const coverHtml = '<img src="' + attachment.get( 'url' ) + '" alt="" />';
                                $coverContainer.html( coverHtml );
                            } );
                        } else {
                            // Direct URL
                            const coverHtml = '<img src="' + to + '" alt="" />';
                            $coverContainer.html( coverHtml );
                        }
                    } else {
                        // Remove the image when cover is cleared
                        $coverContainer.empty();
                    }
                } );
            } );
            
            // Book link
            wp.customize( 'mkp_book_' + bookNum + '_link', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-book-card.mkp-book--' + bookNum );
                    const $link = $card.find( '.mkp-btn' );
                    
                    if ( to ) {
                        if ( $link.length ) {
                            $link.attr( 'href', to );
                        } else {
                            // Create the link if it doesn't exist
                            $card.find( '.mkp-book-card__content' ).append( '<a href="' + to + '" class="mkp-btn mkp-btn--primary mkp-btn--small" target="_blank" rel="noopener">Learn More</a>' );
                        }
                    } else {
                        // Remove the link if URL is empty
                        $link.remove();
                    }
                } );
            } );
        } )( i );
    }
    
    // Function to update podcasts section title
    function updatePodcastsSectionTitle() {
        let podcastCount = 0;
        for ( let i = 1; i <= 5; i++ ) {
            if ( wp.customize.has( 'mkp_podcast_' + i + '_title' ) ) {
                const title = wp.customize( 'mkp_podcast_' + i + '_title' ).get();
                if ( title ) {
                    podcastCount++;
                }
            }
        }
        
        const title = podcastCount === 1 ? 'Podcast/Show' : 'Podcasts/Shows';
        $( '.mkp-podcasts-section .mkp-section__title' ).text( title );
    }
    
    // Podcasts section updates
    const maxPodcasts = 5;
    for ( let i = 1; i <= maxPodcasts; i++ ) {
        ( function( podcastNum ) {
            // Podcast title
            wp.customize( 'mkp_podcast_' + podcastNum + '_title', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-podcast-card.mkp-podcast--' + podcastNum );
                    $card.find( '.mkp-podcast-card__title' ).text( to );
                    
                    // Show/hide card based on content
                    if ( to ) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                    
                    // Update section title
                    updatePodcastsSectionTitle();
                } );
            } );
            
            // Podcast description
            wp.customize( 'mkp_podcast_' + podcastNum + '_description', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-podcast-card.mkp-podcast--' + podcastNum );
                    const $description = $card.find( '.mkp-podcast-card__description' );
                    
                    if ( to ) {
                        // Simple wpautop implementation for live preview
                        const formattedDesc = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                        $description.html( formattedDesc );
                    } else {
                        $description.empty();
                    }
                } );
            } );
            
            // Podcast logo
            wp.customize( 'mkp_podcast_' + podcastNum + '_logo', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-podcast-card.mkp-podcast--' + podcastNum );
                    const $logoContainer = $card.find( '.mkp-podcast-card__logo' );
                    
                    if ( to ) {
                        // If attachment ID, fetch URL
                        if ( $.isNumeric( to ) ) {
                            wp.media.attachment( to ).fetch().then( function() {
                                const attachment = wp.media.attachment( to );
                                const logoHtml = '<img src="' + attachment.get( 'url' ) + '" alt="" loading="lazy" />';
                                $logoContainer.html( logoHtml );
                            } );
                        } else {
                            // Direct URL
                            const logoHtml = '<img src="' + to + '" alt="" loading="lazy" />';
                            $logoContainer.html( logoHtml );
                        }
                    } else {
                        // Show placeholder when logo is cleared
                        $logoContainer.html( '<div class="mkp-podcast-card__logo-placeholder"><span>Podcast Logo</span></div>' );
                    }
                } );
            } );
            
            // Podcast link
            wp.customize( 'mkp_podcast_' + podcastNum + '_link', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-podcast-card.mkp-podcast--' + podcastNum );
                    const $link = $card.find( '.mkp-btn' );
                    
                    if ( to ) {
                        if ( $link.length ) {
                            $link.attr( 'href', to );
                        } else {
                            // Create the link if it doesn't exist
                            $card.find( '.mkp-podcast-card__content' ).append( '<a href="' + to + '" class="mkp-btn mkp-btn--primary mkp-btn--small" target="_blank" rel="noopener">Listen Now</a>' );
                        }
                    } else {
                        // Remove the link if URL is empty
                        $link.remove();
                    }
                } );
            } );
        } )( i );
    }
    
    // Testimonials section updates
    const maxTestimonials = 8;
    
    // Section title update
    wp.customize( 'mkp_testimonials_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-testimonials-section .mkp-section__title' ).text( to );
        } );
    } );
    
    for ( let i = 1; i <= maxTestimonials; i++ ) {
        ( function( testimonialNum ) {
            // Testimonial quote
            wp.customize( 'mkp_testimonial_' + testimonialNum + '_quote', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-testimonial-card.mkp-testimonial--' + testimonialNum );
                    const $quote = $card.find( '.mkp-testimonial-card__quote' );
                    
                    if ( to ) {
                        // Simple wpautop implementation for live preview
                        const formattedQuote = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                        $quote.html( formattedQuote );
                        $card.show();
                    } else {
                        $quote.empty();
                        $card.hide();
                    }
                } );
            } );
            
            // Author name
            wp.customize( 'mkp_testimonial_' + testimonialNum + '_author', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-testimonial-card.mkp-testimonial--' + testimonialNum );
                    $card.find( '.mkp-testimonial-card__author-name' ).text( to );
                } );
            } );
            
            // Author title
            wp.customize( 'mkp_testimonial_' + testimonialNum + '_title', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-testimonial-card.mkp-testimonial--' + testimonialNum );
                    updateAuthorDetails( $card, testimonialNum );
                } );
            } );
            
            // Organization
            wp.customize( 'mkp_testimonial_' + testimonialNum + '_organization', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-testimonial-card.mkp-testimonial--' + testimonialNum );
                    updateAuthorDetails( $card, testimonialNum );
                } );
            } );
            
            // Helper function to update author details
            function updateAuthorDetails( $card, num ) {
                const title = wp.customize( 'mkp_testimonial_' + num + '_title' ).get() || '';
                const org = wp.customize( 'mkp_testimonial_' + num + '_organization' ).get() || '';
                const $details = $card.find( '.mkp-testimonial-card__author-details' );
                
                const details = [];
                if ( title ) details.push( title );
                if ( org ) details.push( org );
                
                if ( details.length > 0 ) {
                    $details.text( details.join( ', ' ) ).show();
                } else {
                    $details.hide();
                }
            }
            
            // Photo
            wp.customize( 'mkp_testimonial_' + testimonialNum + '_photo', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-testimonial-card.mkp-testimonial--' + testimonialNum );
                    const $photoContainer = $card.find( '.mkp-testimonial-card__photo' );
                    
                    if ( to ) {
                        // If attachment ID, fetch URL
                        if ( $.isNumeric( to ) ) {
                            wp.media.attachment( to ).fetch().then( function() {
                                const attachment = wp.media.attachment( to );
                                const photoHtml = '<img src="' + attachment.get( 'url' ) + '" alt="" />';
                                $photoContainer.html( photoHtml ).show();
                            } );
                        } else {
                            // Direct URL
                            const photoHtml = '<img src="' + to + '" alt="" />';
                            $photoContainer.html( photoHtml ).show();
                        }
                    } else {
                        $photoContainer.hide();
                    }
                } );
            } );
            
            // Rating
            wp.customize( 'mkp_testimonial_' + testimonialNum + '_rating', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-testimonial-card.mkp-testimonial--' + testimonialNum );
                    const $rating = $card.find( '.mkp-testimonial-card__rating' );
                    
                    if ( to > 0 ) {
                        let starsHtml = '';
                        for ( let star = 1; star <= 5; star++ ) {
                            const className = star <= to ? 'mkp-star--filled' : 'mkp-star--empty';
                            starsHtml += '<span class="mkp-star ' + className + '">★</span>';
                        }
                        $rating.html( starsHtml ).show();
                    } else {
                        $rating.hide();
                    }
                } );
            } );
        } )( i );
    }
    
    // Awards section updates
    const maxAwards = 8;
    
    // Section title update
    wp.customize( 'mkp_awards_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-awards-section .mkp-section__title' ).text( to );
        } );
    } );
    
    for ( let i = 1; i <= maxAwards; i++ ) {
        ( function( awardNum ) {
            // Award logo
            wp.customize( 'mkp_award_' + awardNum + '_logo', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-award-card.mkp-award--' + awardNum );
                    const $logoContainer = $card.find( '.mkp-award-card__logo' );
                    const $placeholder = $card.find( '.mkp-award-card__logo-placeholder' );
                    
                    if ( to ) {
                        // If attachment ID, fetch URL
                        if ( $.isNumeric( to ) ) {
                            wp.media.attachment( to ).fetch().then( function() {
                                const attachment = wp.media.attachment( to );
                                const logoHtml = '<img src="' + attachment.get( 'url' ) + '" alt="" />';
                                $logoContainer.html( logoHtml ).show();
                                $placeholder.hide();
                            } );
                        } else {
                            // Direct URL
                            const logoHtml = '<img src="' + to + '" alt="" />';
                            $logoContainer.html( logoHtml ).show();
                            $placeholder.hide();
                        }
                    } else {
                        $logoContainer.empty().hide();
                        $placeholder.show();
                    }
                    
                    updateAwardVisibility( awardNum );
                } );
            } );
            
            // Award title
            wp.customize( 'mkp_award_' + awardNum + '_title', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-award-card.mkp-award--' + awardNum );
                    $card.find( '.mkp-award-card__title' ).text( to );
                    updateAwardVisibility( awardNum );
                } );
            } );
            
            // Award year
            wp.customize( 'mkp_award_' + awardNum + '_year', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-award-card.mkp-award--' + awardNum );
                    $card.find( '.mkp-award-card__year' ).text( to );
                } );
            } );
            
            // Award description
            wp.customize( 'mkp_award_' + awardNum + '_description', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-award-card.mkp-award--' + awardNum );
                    const $description = $card.find( '.mkp-award-card__description' );
                    
                    if ( to ) {
                        // Simple wpautop implementation for live preview
                        const formattedDesc = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                        $description.html( formattedDesc );
                    } else {
                        $description.empty();
                    }
                } );
            } );
            
            // Helper function to update award visibility
            function updateAwardVisibility( num ) {
                const $card = $( '.mkp-award-card.mkp-award--' + num );
                const title = wp.customize( 'mkp_award_' + num + '_title' ).get() || '';
                const logo = wp.customize( 'mkp_award_' + num + '_logo' ).get() || '';
                
                if ( title || logo ) {
                    $card.show();
                } else {
                    $card.hide();
                }
            }
        } )( i );
    }
    
    // Stats section updates
    const maxStats = 6;
    
    // Section title update
    wp.customize( 'mkp_stats_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-stats-section .mkp-section__title' ).text( to );
        } );
    } );
    
    for ( let i = 1; i <= maxStats; i++ ) {
        ( function( statNum ) {
            // Stat number
            wp.customize( 'mkp_stat_' + statNum + '_number', function( value ) {
                value.bind( function( to ) {
                    const $stat = $( '.mkp-stat.mkp-stat--' + statNum );
                    $stat.find( '.mkp-stat__number' ).text( to );
                    
                    // Show/hide stat based on content
                    if ( to ) {
                        $stat.show();
                    } else {
                        $stat.hide();
                    }
                } );
            } );
            
            // Stat label
            wp.customize( 'mkp_stat_' + statNum + '_label', function( value ) {
                value.bind( function( to ) {
                    const $stat = $( '.mkp-stat.mkp-stat--' + statNum );
                    $stat.find( '.mkp-stat__label' ).text( to );
                } );
            } );
            
            // Stat prefix
            wp.customize( 'mkp_stat_' + statNum + '_prefix', function( value ) {
                value.bind( function( to ) {
                    const $stat = $( '.mkp-stat.mkp-stat--' + statNum );
                    $stat.find( '.mkp-stat__prefix' ).text( to );
                } );
            } );
            
            // Stat suffix
            wp.customize( 'mkp_stat_' + statNum + '_suffix', function( value ) {
                value.bind( function( to ) {
                    const $stat = $( '.mkp-stat.mkp-stat--' + statNum );
                    $stat.find( '.mkp-stat__suffix' ).text( to );
                } );
            } );
            
            // Stat icon
            wp.customize( 'mkp_stat_' + statNum + '_icon', function( value ) {
                value.bind( function( to ) {
                    const $stat = $( '.mkp-stat.mkp-stat--' + statNum );
                    const $icon = $stat.find( '.mkp-stat__icon .dashicons' );
                    
                    if ( to ) {
                        // Update dashicon class
                        $icon.removeClass().addClass( 'dashicons dashicons-' + to );
                        $stat.find( '.mkp-stat__icon' ).show();
                    } else {
                        $stat.find( '.mkp-stat__icon' ).hide();
                    }
                } );
            } );
        } )( i );
    }
    
    // Media Features section updates
    const maxMediaFeatures = 8;
    
    // Section title update
    wp.customize( 'mkp_media_features_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-media-features-section .mkp-section__title' ).text( to );
        } );
    } );
    
    for ( let i = 1; i <= maxMediaFeatures; i++ ) {
        ( function( featureNum ) {
            // Media feature logo
            wp.customize( 'mkp_media_feature_' + featureNum + '_logo', function( value ) {
                value.bind( function( to ) {
                    const $item = $( '.mkp-media-feature.mkp-media-feature--' + featureNum );
                    const $logoContainer = $item.find( '.mkp-media-feature__logo' );
                    
                    if ( to ) {
                        // If attachment ID, fetch URL
                        if ( $.isNumeric( to ) ) {
                            wp.media.attachment( to ).fetch().then( function() {
                                const attachment = wp.media.attachment( to );
                                const logoHtml = '<img src="' + attachment.get( 'url' ) + '" alt="" />';
                                $logoContainer.html( logoHtml );
                            } );
                        } else {
                            // Direct URL
                            const logoHtml = '<img src="' + to + '" alt="" />';
                            $logoContainer.html( logoHtml );
                        }
                    } else {
                        $logoContainer.empty();
                    }
                    
                    updateMediaFeatureVisibility( featureNum );
                } );
            } );
            
            // Media feature name
            wp.customize( 'mkp_media_feature_' + featureNum + '_name', function( value ) {
                value.bind( function( to ) {
                    const $item = $( '.mkp-media-feature.mkp-media-feature--' + featureNum );
                    $item.find( '.mkp-media-feature__name' ).text( to );
                    updateMediaFeatureVisibility( featureNum );
                } );
            } );
            
            // Media feature link
            wp.customize( 'mkp_media_feature_' + featureNum + '_link', function( value ) {
                value.bind( function( to ) {
                    const $item = $( '.mkp-media-feature.mkp-media-feature--' + featureNum );
                    const $link = $item.find( 'a' );
                    
                    if ( to ) {
                        $link.attr( 'href', to );
                    } else {
                        $link.attr( 'href', '#' );
                    }
                } );
            } );
            
            // Helper function to update media feature visibility
            function updateMediaFeatureVisibility( num ) {
                const $item = $( '.mkp-media-feature.mkp-media-feature--' + num );
                const logo = wp.customize( 'mkp_media_feature_' + num + '_logo' ).get() || '';
                const name = wp.customize( 'mkp_media_feature_' + num + '_name' ).get() || '';
                
                if ( logo || name ) {
                    $item.show();
                } else {
                    $item.hide();
                }
            }
        } )( i );
    }
    
    // Speaker Section Title
    wp.customize( 'mkp_speaker_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-speaker-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Speaker Topics List Style
    wp.customize( 'mkp_speaker_topics_list_style', function( value ) {
        value.bind( function( to ) {
            // Force refresh for style changes as it requires DOM structure changes
            wp.customize.preview.send( 'refresh' );
        } );
    } );
    
    // Update speaker topics text
    for ( let i = 1; i <= 8; i++ ) {
        ( function( topicNum ) {
            wp.customize( 'mkp_speaker_topic_' + topicNum, function( value ) {
                value.bind( function( to ) {
                    // Update all instances of this topic
                    const $listItem = $( '.mkp-speaker__list-item--' + topicNum );
                    const $cardItem = $( '.mkp-speaker__topic--' + topicNum );
                    
                    // Update text
                    $listItem.find( '.mkp-speaker__topic-title' ).text( to );
                    $cardItem.find( '.mkp-speaker__topic-title' ).text( to );
                    
                    // Show/hide based on content
                    if ( to ) {
                        $listItem.css( 'display', 'list-item' );
                        $cardItem.css( 'display', 'flex' );
                    } else {
                        $listItem.hide();
                        $cardItem.hide();
                    }
                } );
            } );
        } )( i );
    }
    
    
    // Navigation Background Color
    wp.customize( 'mkp_nav_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-header' ).css( 'background-color', to );
            
            // Nav link colors handled by dynamic styles - removed inline style override
        } );
    } );
    
    // Define font stacks once for all font controls
    const fontStacks = {
        'system': '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
        'inter': '"Inter", sans-serif',
        'roboto': '"Roboto", sans-serif',
        'opensans': '"Open Sans", sans-serif',
        'lato': '"Lato", sans-serif',
        'montserrat': '"Montserrat", sans-serif',
        'playfair': '"Playfair Display", serif',
        'merriweather': '"Merriweather", serif',
        'georgia': 'Georgia, "Times New Roman", serif',
        'poppins': '"Poppins", sans-serif',
        'raleway': '"Raleway", sans-serif'
    };
    
    // Google font mappings
    const googleFontUrls = {
        'inter': 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'roboto': 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap',
        'opensans': 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap',
        'lato': 'https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap',
        'montserrat': 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap',
        'playfair': 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap',
        'merriweather': 'https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap',
        'poppins': 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap',
        'raleway': 'https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap'
    };
    
    // Helper function to load Google font
    function loadGoogleFont( fontKey ) {
        if ( fontKey !== 'system' && fontKey !== 'georgia' && googleFontUrls[fontKey] ) {
            const fontUrl = googleFontUrls[fontKey];
            if ( ! $( 'link[href="' + fontUrl + '"]' ).length ) {
                $( 'head' ).append( '<link rel="stylesheet" href="' + fontUrl + '">' );
            }
        }
    }
    
    // Body Font
    wp.customize( 'mkp_body_font', function( value ) {
        value.bind( function( to ) {
            if ( fontStacks[to] ) {
                // Update CSS variable
                document.documentElement.style.setProperty( '--mkp-font-primary', fontStacks[to] );
                
                // Load Google font if needed
                loadGoogleFont( to );
            }
        } );
    } );
    
    // Heading Font
    wp.customize( 'mkp_heading_font', function( value ) {
        value.bind( function( to ) {
            if ( fontStacks[to] ) {
                // Update CSS variable
                document.documentElement.style.setProperty( '--mkp-font-heading', fontStacks[to] );
                
                // Load Google font if needed
                loadGoogleFont( to );
            }
        } );
    } );
    
    // Navigation Font
    wp.customize( 'mkp_nav_font', function( value ) {
        value.bind( function( to ) {
            if ( fontStacks[to] ) {
                // Update CSS variable
                document.documentElement.style.setProperty( '--mkp-font-nav', fontStacks[to] );
                
                // Also update directly for immediate effect
                $( '.mkp-nav, .mkp-nav__link' ).css( 'font-family', fontStacks[to] );
                
                // Load Google font if needed
                loadGoogleFont( to );
            }
        } );
    } );
    
    // Media Questions List Style
    wp.customize( 'mkp_media_questions_list_style', function( value ) {
        value.bind( function( to ) {
            // Force refresh for style changes as it requires DOM structure changes
            wp.customize.preview.send( 'refresh' );
        } );
    } );
    
    // Update media questions text
    for ( let i = 1; i <= 12; i++ ) {
        ( function( questionNum ) {
            wp.customize( 'mkp_media_question_' + questionNum, function( value ) {
                value.bind( function( to ) {
                    const $section = $( '.mkp-media-questions-section' );
                    const $item = $( '.mkp-media-questions__item--' + questionNum );
                    const $card = $( '.mkp-media-questions__card--' + questionNum );
                    const $placeholder = $( '.mkp-media-questions__placeholder' );
                    
                    if ( to ) {
                        // Update text in both list and card layouts
                        $item.find( '.mkp-media-questions__text' ).text( to );
                        $card.find( '.mkp-media-questions__card-text' ).text( to );
                        // Show item/card
                        $item.show();
                        $card.css( 'display', 'flex' );
                    } else {
                        // Hide item/card
                        $item.hide();
                        $card.hide();
                    }
                    
                    // Check if any questions remain
                    let hasQuestions = false;
                    for ( let j = 1; j <= 12; j++ ) {
                        if ( wp.customize( 'mkp_media_question_' + j ).get() ) {
                            hasQuestions = true;
                            break;
                        }
                    }
                    
                    // Show/hide section and placeholder based on content
                    if ( hasQuestions ) {
                        $placeholder.hide();
                        if ( wp.customize( 'mkp_enable_section_media_questions' ).get() ) {
                            $section.show();
                        }
                    } else {
                        $placeholder.show();
                        // Still show section in customizer even if no questions
                        if ( wp.customize( 'mkp_enable_section_media_questions' ).get() ) {
                            $section.show();
                        } else {
                            $section.hide();
                        }
                    }
                } );
            } );
        } )( i );
    }
    
    // Handle enable/disable section toggle
    // Note: Section enable/disable toggles use 'refresh' transport for reliability
    // This ensures proper PHP conditional checks and theme functions run correctly
    // The code below is kept for reference but not used:
    /*
    wp.customize( 'mkp_enable_section_media_questions', function( value ) {
        value.bind( function( to ) {
            const $section = $( '.mkp-media-questions-section' );
            if ( to ) {
                $section.show();
            } else {
                $section.hide();
            }
        } );
    } );
    */
    
    
    // Update investor options
    for ( let i = 1; i <= 3; i++ ) {
        ( function( investorNum ) {
            // Investor title
            wp.customize( 'mkp_investor_' + investorNum + '_title', function( value ) {
                value.bind( function( to ) {
                    const $section = $( '.mkp-investor-section' );
                    const $card = $( '.mkp-investor-card.mkp-investor--' + investorNum );
                    const $placeholder = $( '.mkp-investor__placeholder' );
                    
                    $card.find( '.mkp-investor-card__title' ).text( to );
                    
                    // Show/hide card based on content
                    if ( to ) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                    
                    // Check if any investors remain
                    let hasInvestors = false;
                    for ( let j = 1; j <= 3; j++ ) {
                        if ( wp.customize( 'mkp_investor_' + j + '_title' ).get() ) {
                            hasInvestors = true;
                            break;
                        }
                    }
                    
                    // Show/hide section and placeholder based on content
                    if ( hasInvestors ) {
                        $placeholder.hide();
                        if ( wp.customize( 'mkp_enable_section_investor' ).get() ) {
                            $section.show();
                        }
                    } else {
                        $placeholder.show();
                        // Still show section in customizer even if no investors
                        if ( wp.customize( 'mkp_enable_section_investor' ).get() ) {
                            $section.show();
                        } else {
                            $section.hide();
                        }
                    }
                } );
            } );
            
            // Investor description
            wp.customize( 'mkp_investor_' + investorNum + '_description', function( value ) {
                value.bind( function( to ) {
                    const $card = $( '.mkp-investor-card.mkp-investor--' + investorNum );
                    const $description = $card.find( '.mkp-investor-card__description' );
                    
                    if ( to ) {
                        // Simple wpautop implementation for live preview
                        const formattedDesc = '<p>' + to.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                        $description.html( formattedDesc );
                    } else {
                        $description.empty();
                    }
                } );
            } );
        } )( i );
    }
    
    // Handle enable/disable investor section toggle
    // Note: Section enable/disable toggles use 'refresh' transport for reliability
    // This ensures proper PHP conditional checks and theme functions run correctly
    // The code below is kept for reference but not used:
    /*
    wp.customize( 'mkp_enable_section_investor', function( value ) {
        value.bind( function( to ) {
            const $section = $( '.mkp-investor-section' );
            if ( to ) {
                $section.show();
            } else {
                $section.hide();
            }
        } );
    } );
    */
    
    // Contact Section - simplified approach
    
    // Contact Section Title
    wp.customize( 'mkp_contact_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-contact-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Gallery Section Title
    wp.customize( 'mkp_gallery_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-gallery-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Media Questions Section Title
    wp.customize( 'mkp_media_questions_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-media-questions-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Books Section Title
    wp.customize( 'mkp_books_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-books-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Podcasts Section Title
    wp.customize( 'mkp_podcasts_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-podcasts-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Corporations Section Title
    wp.customize( 'mkp_corporations_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-corporations-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Investor Section Title
    wp.customize( 'mkp_investor_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-investor-section .mkp-section__title' ).text( to );
        } );
    } );
    
    // Function to check if contact section has content - similar to investor section
    function checkContactContent() {
        const $section = $( '.mkp-contact-section' );
        const $placeholder = $( '.mkp-contact__placeholder' );
        
        let hasContent = false;
        
        // Check emails with existence checks
        if ( (wp.customize.has( 'mkp_contact_general_email' ) && wp.customize( 'mkp_contact_general_email' ).get()) ||
             (wp.customize.has( 'mkp_contact_media_email' ) && wp.customize( 'mkp_contact_media_email' ).get()) ||
             (wp.customize.has( 'mkp_contact_speaking_email' ) && wp.customize( 'mkp_contact_speaking_email' ).get()) ||
             (wp.customize.has( 'mkp_contact_address' ) && wp.customize( 'mkp_contact_address' ).get()) ) {
            hasContent = true;
        }
        
        // Check social links
        if ( ! hasContent ) {
            const platforms = ['x', 'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok', 'github', 'threads'];
            for ( let platform of platforms ) {
                if ( wp.customize.has( 'mkp_contact_social_' + platform ) && 
                     wp.customize( 'mkp_contact_social_' + platform ).get() ) {
                    hasContent = true;
                    break;
                }
            }
        }
        
        // Show/hide placeholder based on content
        if ( hasContent ) {
            $placeholder.hide();
        } else {
            $placeholder.show();
        }
        
        // Don't hide the section here - let the enable/disable toggle control it
        // The section visibility should only be controlled by mkp_enable_section_contact
    }
    
    // Email fields - using specific classes like investor section
    const emailTypes = ['general', 'media', 'speaking'];
    
    emailTypes.forEach( function( type ) {
        wp.customize( 'mkp_contact_' + type + '_email', function( value ) {
            value.bind( function( to ) {
                const $item = $( '.mkp-contact__item--' + type );
                const $email = $item.find( '.mkp-contact__email' );
                
                if ( to ) {
                    $email.text( to ).attr( 'href', 'mailto:' + to );
                    $item.show();
                } else {
                    $item.hide();
                }
                
                checkContactContent();
            } );
        } );
    } );
    
    // Address
    wp.customize( 'mkp_contact_address', function( value ) {
        value.bind( function( to ) {
            const $address = $( '.mkp-contact__address' );
            const $addressText = $( '.mkp-contact__address-text' );
            
            if ( to ) {
                // For the preview, we need to replace newlines with <br> tags
                // Since we're in the customizer preview, using html() is safe here
                const lines = to.split('\n');
                const formattedAddress = lines.map(line => $('<div>').text(line).html()).join('<br>');
                $addressText.html( formattedAddress );
                $address.show();
            } else {
                $address.hide();
            }
            
            checkContactContent();
        } );
    } );
    
    // Social links
    const socialPlatforms = ['x', 'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok', 'github', 'threads'];
    
    // Function to check if we have any social links
    function checkSocialLinks() {
        let hasSocial = false;
        socialPlatforms.forEach( function( platform ) {
            // Check if the setting exists before trying to get its value
            if ( wp.customize.has( 'mkp_contact_social_' + platform ) && 
                 wp.customize( 'mkp_contact_social_' + platform ).get() ) {
                hasSocial = true;
            }
        } );
        
        const $socialSection = $( '.mkp-contact__social' );
        if ( hasSocial ) {
            $socialSection.show();
        } else {
            $socialSection.hide();
        }
    }
    
    socialPlatforms.forEach( function( platform ) {
        // Only bind if the setting exists
        if ( wp.customize.has( 'mkp_contact_social_' + platform ) ) {
            wp.customize( 'mkp_contact_social_' + platform, function( value ) {
                value.bind( function( to ) {
                    const $link = $( '.mkp-contact__social-link--' + platform );
                    
                    if ( to ) {
                        $link.attr( 'href', to ).show();
                    } else {
                        $link.hide();
                    }
                    
                    checkSocialLinks();
                    checkContactContent();
                } );
            } );
        }
    } );
    
    // Handle enable/disable contact section toggle
    // Note: Section enable/disable toggles use 'refresh' transport for reliability
    // This ensures proper PHP conditional checks and theme functions run correctly
    // The code below is kept for reference but not used:
    /*
    wp.customize( 'mkp_enable_section_contact', function( value ) {
        value.bind( function( to ) {
            const $section = $( '.mkp-contact-section' );
            
            if ( to ) {
                // Show section
                $section.css( 'display', '' );
                checkSocialLinks();
            } else {
                // Hide section
                $section.css( 'display', 'none' );
            }
        } );
    } );
    */
    
    // In The Media Section Title
    wp.customize( 'mkp_in_the_media_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-in-the-media .mkp-section__title' ).text( to );
        } );
    } );
    
    // Update media items (simplified - URL only)
    const maxMediaItems = 12;
    for ( let i = 1; i <= maxMediaItems; i++ ) {
        ( function( itemNum ) {
            // Media item URL - force refresh as embeds need server-side processing
            wp.customize( 'mkp_media_item_' + itemNum + '_url', function( value ) {
                value.bind( function( to ) {
                    wp.customize.preview.send( 'refresh' );
                } );
            } );
        } )( i );
    }
    
    // Handle enable/disable In The Media section toggle
    // Note: Section enable/disable toggles use 'refresh' transport for reliability
    // This ensures proper PHP conditional checks and theme functions run correctly
    // The code below is kept for reference but not used:
    /*
    wp.customize( 'mkp_enable_section_in_the_media', function( value ) {
        value.bind( function( to ) {
            const $section = $( '.mkp-in-the-media-section' );
            if ( to ) {
                $section.show();
            } else {
                $section.hide();
            }
        } );
    } );
    */
    
    // Text Alignment Live Preview
    wp.customize( 'mkp_about_text_align', function( value ) {
        value.bind( function( to ) {
            const $content = $( '.mkp-about-section__content' );
            $content.removeClass( 'mkp-text-align-left mkp-text-align-justify' );
            $content.addClass( 'mkp-text-align-' + to );
        } );
    } );
    
    wp.customize( 'mkp_corporations_text_align', function( value ) {
        value.bind( function( to ) {
            const $bios = $( '.mkp-corp-card__bio' );
            $bios.removeClass( 'mkp-text-align-left mkp-text-align-justify' );
            $bios.addClass( 'mkp-text-align-' + to );
        } );
    } );
    
    wp.customize( 'mkp_books_text_align', function( value ) {
        value.bind( function( to ) {
            const $descriptions = $( '.mkp-book-card__description, .mkp-masonry-card__description' );
            $descriptions.removeClass( 'mkp-text-align-left mkp-text-align-justify' );
            $descriptions.addClass( 'mkp-text-align-' + to );
        } );
    } );
    
    wp.customize( 'mkp_media_questions_text_align', function( value ) {
        value.bind( function( to ) {
            const $questions = $( '.mkp-media-questions__item, .mkp-media-questions__question' );
            $questions.removeClass( 'mkp-text-align-left mkp-text-align-justify' );
            $questions.addClass( 'mkp-text-align-' + to );
        } );
    } );
    
    wp.customize( 'mkp_testimonials_text_align', function( value ) {
        value.bind( function( to ) {
            const $quotes = $( '.mkp-testimonial-card__quote' );
            $quotes.removeClass( 'mkp-text-align-left mkp-text-align-justify' );
            $quotes.addClass( 'mkp-text-align-' + to );
        } );
    } );
    
    // Initial checks when customizer loads
    $( document ).ready( function() {
        // Small delay to ensure DOM is fully ready
        setTimeout( function() {
            checkSocialLinks();
            checkContactContent();
        }, 100 );
    } );
    
} )( jQuery );
