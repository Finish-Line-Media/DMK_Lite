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
        { setting: 'mkp_speaker_topics_background_color', selector: '.mkp-speaker-section' },
        { setting: 'mkp_podcast_background_color', selector: '.mkp-podcast-section' },
        { setting: 'mkp_corporations_background_color', selector: '.mkp-corporations-section' },
        { setting: 'mkp_media_questions_background_color', selector: '.mkp-media-questions-section' },
        { setting: 'mkp_investor_background_color', selector: '.mkp-investor-section' },
        { setting: 'mkp_in_the_media_background_color', selector: '.mkp-in-the-media-section' },
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
                $section.find( 'h2, h3' ).css( 'color', headingColor );
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
    
    // Companies (Corporations) section updates
    const maxCorps = 4;
    for ( let i = 1; i <= maxCorps; i++ ) {
        ( function( corpNum ) {
            // Company name
            wp.customize( 'mkp_corp_' + corpNum + '_name', function( value ) {
                value.bind( function( to ) {
                    $( '.mkp-corp-card:nth-child(' + corpNum + ') .mkp-corp-card__name' ).text( to );
                    // Show/hide card based on content
                    const $card = $( '.mkp-corp-card:nth-child(' + corpNum + ')' );
                    if ( to ) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                } );
            } );
            
            // Company bio
            wp.customize( 'mkp_corp_' + corpNum + '_bio', function( value ) {
                value.bind( function( to ) {
                    $( '.mkp-corp-card:nth-child(' + corpNum + ') .mkp-corp-card__bio' ).html( to );
                } );
            } );
            
            // Company logo
            wp.customize( 'mkp_corp_' + corpNum + '_logo', function( value ) {
                value.bind( function( to ) {
                    const $logo = $( '.mkp-corp-card:nth-child(' + corpNum + ') .mkp-corp-card__logo img' );
                    if ( to ) {
                        // If attachment ID, fetch URL
                        if ( $.isNumeric( to ) ) {
                            wp.media.attachment( to ).fetch().then( function() {
                                const attachment = wp.media.attachment( to );
                                $logo.attr( 'src', attachment.get( 'url' ) );
                            } );
                        }
                    } else {
                        $logo.attr( 'src', '' );
                    }
                } );
            } );
        } )( i );
    }
    
    // Media Questions section updates
    const maxQuestions = 12;
    for ( let i = 1; i <= maxQuestions; i++ ) {
        ( function( questionNum ) {
            wp.customize( 'mkp_media_question_' + questionNum, function( value ) {
                value.bind( function( to ) {
                    const $questions = $( '.mkp-media-questions__list' );
                    const $question = $questions.find( 'li:nth-child(' + questionNum + ')' );
                    
                    if ( to ) {
                        if ( $question.length ) {
                            $question.text( to );
                        } else {
                            // Add new question
                            $questions.append( '<li>' + to + '</li>' );
                        }
                    } else {
                        $question.remove();
                    }
                } );
            } );
        } )( i );
    }
    
    // Speaker Topics List Style
    wp.customize( 'mkp_speaker_topics_list_style', function( value ) {
        value.bind( function( to ) {
            const $section = $( '.mkp-speaker-section' );
            
            // Remove all style classes
            $section.removeClass( 'mkp-speaker-section--bullets mkp-speaker-section--numbers mkp-speaker-section--cards' );
            
            // Add new style class
            $section.addClass( 'mkp-speaker-section--' + to );
            
            // Rebuild the content based on style
            const topics = [];
            for ( let i = 1; i <= 5; i++ ) {
                const topic = wp.customize( 'mkp_speaker_topic_' + i ).get();
                if ( topic ) {
                    topics.push( topic );
                }
            }
            
            if ( topics.length > 0 ) {
                let html = '';
                
                if ( to === 'bullets' || to === 'numbers' ) {
                    const tag = to === 'bullets' ? 'ul' : 'ol';
                    html = '<' + tag + ' class="mkp-speaker__list mkp-speaker__list--' + to + '">';
                    topics.forEach( function( topic ) {
                        html += '<li class="mkp-speaker__list-item"><h3 class="mkp-speaker__topic-title">' + topic + '</h3></li>';
                    } );
                    html += '</' + tag + '>';
                } else { // cards
                    html = '<div class="mkp-speaker__topics">';
                    topics.forEach( function( topic, index ) {
                        html += '<div class="mkp-speaker__topic">';
                        html += '<span class="mkp-speaker__topic-number">' + ( index + 1 ) + '</span>';
                        html += '<h3 class="mkp-speaker__topic-title">' + topic + '</h3>';
                        html += '</div>';
                    } );
                    html += '</div>';
                }
                
                // Replace content after the title
                const $container = $section.find( '.mkp-container' );
                $container.find( '.mkp-speaker__list, .mkp-speaker__topics' ).remove();
                $container.append( html );
            }
        } );
    } );
    
    // Update speaker topics text
    for ( let i = 1; i <= 5; i++ ) {
        ( function( topicNum ) {
            wp.customize( 'mkp_speaker_topic_' + topicNum, function( value ) {
                value.bind( function( to ) {
                    // Trigger list style update to rebuild the list
                    const currentStyle = wp.customize( 'mkp_speaker_topics_list_style' ).get();
                    wp.customize( 'mkp_speaker_topics_list_style' ).set( currentStyle );
                } );
            } );
        } )( i );
    }
    
    // Investor section updates
    wp.customize( 'mkp_investment_people', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-investor__category--people .mkp-investor__description' ).html( to );
            // Show/hide category
            const $category = $( '.mkp-investor__category--people' );
            if ( to ) {
                $category.show();
            } else {
                $category.hide();
            }
        } );
    } );
    
    wp.customize( 'mkp_investment_products', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-investor__category--products .mkp-investor__description' ).html( to );
            // Show/hide category
            const $category = $( '.mkp-investor__category--products' );
            if ( to ) {
                $category.show();
            } else {
                $category.hide();
            }
        } );
    } );
    
    wp.customize( 'mkp_investment_markets', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-investor__category--markets .mkp-investor__description' ).html( to );
            // Show/hide category
            const $category = $( '.mkp-investor__category--markets' );
            if ( to ) {
                $category.show();
            } else {
                $category.hide();
            }
        } );
    } );
    
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
