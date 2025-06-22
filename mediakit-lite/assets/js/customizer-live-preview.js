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
    
    // Hero Background Color with auto-contrast
    wp.customize( 'mkp_hero_background_color', function( value ) {
        value.bind( function( to ) {
            const $hero = $( '.mkp-hero' );
            
            // Update background color
            $hero.css( 'background-color', to );
            
            // Update text colors based on background
            const textColor = getContrastColor( to );
            const headingColor = getContrastColorRGBA( to, 'heading' );
            const mutedColor = getContrastColorRGBA( to, 'muted' );
            
            $hero.css( 'color', textColor );
            $hero.find( '.mkp-hero__name' ).css( 'color', headingColor );
            $hero.find( '.mkp-hero__tag' ).css( 'color', getContrastColorRGBA( to, 'text' ) );
        } );
    } );
    
    // Other section background colors with auto-contrast
    const sections = [
        { setting: 'mkp_bio_background_color', selector: '.mkp-bio-section' },
        { setting: 'mkp_books_background_color', selector: '.mkp-books-section' },
        { setting: 'mkp_podcasts_background_color', selector: '.mkp-podcasts-section' },
        { setting: 'mkp_speaker_topics_background_color', selector: '.mkp-speaker-section' },
        { setting: 'mkp_corporations_background_color', selector: '.mkp-corporations-section' }
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
                $section.find( 'h2, h3' ).css( 'color', headingColor );
                
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
                    
                    // Update arrow color to match secondary color
                    $section.find( '.mkp-speaker__topic-arrow' ).css( 'color', wp.customize( 'mkp_secondary_color' ).get() );
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
            
            // Update speaker topic arrows
            $( '.mkp-speaker__topic-arrow' ).css( 'color', to );
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
    
    // Hero tags update
    for ( let i = 1; i <= 5; i++ ) {
        ( function( tagNum ) {
            wp.customize( 'mkp_hero_tag_' + tagNum, function( value ) {
                value.bind( function( to ) {
                    const $tags = $( '.mkp-hero__tags' );
                    const $existingTags = $tags.find( '.mkp-hero__tag' );
                    const tags = [];
                    
                    // Collect all tag values
                    for ( let j = 1; j <= 5; j++ ) {
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
    
    
    // Function to update companies section title
    function updateCompaniesSectionTitle() {
        let companyCount = 0;
        for ( let i = 1; i <= 4; i++ ) {
            const name = wp.customize( 'mkp_corp_' + i + '_name' ).get();
            if ( name ) {
                companyCount++;
            }
        }
        
        const title = companyCount === 1 ? 'Company' : 'Companies';
        $( '.mkp-corporations-section .mkp-section__title' ).text( title );
    }
    
    // Companies (Corporations) section updates
    const maxCorps = 4;
    for ( let i = 1; i <= maxCorps; i++ ) {
        ( function( corpNum ) {
            // Company name
            wp.customize( 'mkp_corp_' + corpNum + '_name', function( value ) {
                value.bind( function( to ) {
                    // Update the company name
                    const $card = $( '.mkp-corp-card.mkp-corp--' + corpNum );
                    $card.find( '.mkp-corp-card__name' ).text( to );
                    
                    // Show/hide card based on content
                    if ( to ) {
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
        for ( let i = 1; i <= 4; i++ ) {
            const title = wp.customize( 'mkp_book_' + i + '_title' ).get();
            if ( title ) {
                bookCount++;
            }
        }
        
        const title = bookCount === 1 ? 'Book' : 'Books';
        $( '.mkp-books-section .mkp-section__title' ).text( title );
    }
    
    // Books section updates
    const maxBooks = 4;
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
        for ( let i = 1; i <= 3; i++ ) {
            const title = wp.customize( 'mkp_podcast_' + i + '_title' ).get();
            if ( title ) {
                podcastCount++;
            }
        }
        
        const title = podcastCount === 1 ? 'Podcast/Show' : 'Podcasts/Shows';
        $( '.mkp-podcasts-section .mkp-section__title' ).text( title );
    }
    
    // Podcasts section updates
    const maxPodcasts = 3;
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
    
    
    // Speaker Topics List Style
    wp.customize( 'mkp_speaker_topics_list_style', function( value ) {
        value.bind( function( to ) {
            // Force refresh for style changes as it requires DOM structure changes
            wp.customize.preview.send( 'refresh' );
        } );
    } );
    
    // Update speaker topics text
    for ( let i = 1; i <= 5; i++ ) {
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
            
            // Update text color based on background
            const contrastColor = getContrastColor( to );
            $( '.mkp-nav__link' ).css( 'color', contrastColor );
        } );
    } );
    
    // Navigation Font
    wp.customize( 'mkp_nav_font', function( value ) {
        value.bind( function( to ) {
            // Define font stacks
            const fontStacks = {
                'system': '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", Arial, sans-serif',
                'inter': '"Inter", sans-serif',
                'roboto': '"Roboto", sans-serif',
                'open-sans': '"Open Sans", sans-serif',
                'lato': '"Lato", sans-serif',
                'montserrat': '"Montserrat", sans-serif',
                'poppins': '"Poppins", sans-serif',
                'raleway': '"Raleway", sans-serif'
            };
            
            if ( fontStacks[to] ) {
                $( '.mkp-nav, .mkp-nav__link' ).css( 'font-family', fontStacks[to] );
                
                // Load Google font if needed
                if ( to !== 'system' ) {
                    const fontName = to.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('+');
                    const fontUrl = 'https://fonts.googleapis.com/css2?family=' + fontName + ':wght@400;500;600;700&display=swap';
                    
                    if ( ! $( 'link[href*="' + fontName + '"]' ).length ) {
                        $( 'head' ).append( '<link rel="stylesheet" href="' + fontUrl + '">' );
                    }
                }
            }
        } );
    } );
    
} )( jQuery );
