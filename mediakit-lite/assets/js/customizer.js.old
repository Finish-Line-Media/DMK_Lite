/**
 * Live preview customizer updates
 *
 * @package MediaKit_Pro
 */

( function( $ ) {
    // Site title and description
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            $( '.site-title a' ).text( to );
        } );
    } );
    
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            $( '.site-description' ).text( to );
        } );
    } );
    
    // Header text color removed - not used in this theme
    
    
    // Brand Colors - Now handled by theme color system
    // These customizer controls have been removed from the theme
    // Keeping empty bindings to prevent console errors in case of cached settings
    wp.customize( 'mkp_primary_color', function( value ) {
        value.bind( function( to ) {
            // Color updates handled by theme system
        } );
    } );
    
    wp.customize( 'mkp_secondary_color', function( value ) {
        value.bind( function( to ) {
            // Color updates handled by theme system
        } );
    } );
    
    wp.customize( 'mkp_accent_color', function( value ) {
        value.bind( function( to ) {
            // Color updates handled by theme system
        } );
    } );
    
    // Typography - Font mapping
    const fontMap = {
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
    
    // Primary Font
    wp.customize( 'mkp_primary_font', function( value ) {
        value.bind( function( to ) {
            const fontFamily = fontMap[to] || fontMap['system'];
            document.documentElement.style.setProperty( '--mkp-font-primary', fontFamily );
            $( 'body' ).css( 'font-family', fontFamily );
            
            // Load Google Font if needed
            if ( to !== 'system' && to !== 'georgia' ) {
                loadGoogleFont( to );
            }
        } );
    } );
    
    // Heading Font
    wp.customize( 'mkp_heading_font', function( value ) {
        value.bind( function( to ) {
            const fontFamily = fontMap[to] || fontMap['playfair'];
            document.documentElement.style.setProperty( '--mkp-font-heading', fontFamily );
            $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', fontFamily );
            
            // Load Google Font if needed
            if ( to !== 'system' && to !== 'georgia' ) {
                loadGoogleFont( to );
            }
        } );
    } );
    
    // Section Colors - Now handled by dynamic theme color rotation
    // These old fixed section colors have been replaced
    // Keeping empty bindings to prevent console errors
    wp.customize( 'mkp_section_color_1', function( value ) {
        value.bind( function( to ) {
            // Section colors now rotate dynamically based on theme
        } );
    } );
    
    wp.customize( 'mkp_section_color_2', function( value ) {
        value.bind( function( to ) {
            // Section colors now rotate dynamically based on theme
        } );
    } );
    
    wp.customize( 'mkp_section_color_3', function( value ) {
        value.bind( function( to ) {
            // Section colors now rotate dynamically based on theme
        } );
    } );
    
    // Hero Section - Updated Structure
    wp.customize( 'mkp_hero_name', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-hero__name' ).text( to );
        } );
    } );
    
    // Profile Photo and Family Crest live updates would require complex DOM manipulation
    // These will require a page refresh to see changes
    wp.customize( 'mkp_hero_profile_photo', function( value ) {
        value.bind( function( to ) {
            // Requires refresh to properly position images
            wp.customize.previewer.refresh();
        } );
    } );
    
    wp.customize( 'mkp_hero_family_crest', function( value ) {
        value.bind( function( to ) {
            // Requires refresh to properly position images
            wp.customize.previewer.refresh();
        } );
    } );
    
    wp.customize( 'mkp_hero_profile_photo_position', function( value ) {
        value.bind( function( to ) {
            // Requires refresh to properly position images
            wp.customize.previewer.refresh();
        } );
    } );
    
    wp.customize( 'mkp_hero_family_crest_position', function( value ) {
        value.bind( function( to ) {
            // Requires refresh to properly position images
            wp.customize.previewer.refresh();
        } );
    } );
    
    // Hero Tags (1-5)
    for ( let i = 1; i <= 5; i++ ) {
        ( function( tagNum ) {
            wp.customize( 'mkp_hero_tag_' + tagNum, function( value ) {
                value.bind( function( to ) {
                    const $tag = $( '.mkp-hero__tag--' + tagNum );
                    if ( to ) {
                        if ( $tag.length ) {
                            $tag.text( to ).show();
                        } else {
                            $( '.mkp-hero__tags' ).append( '<span class="mkp-hero__tag mkp-hero__tag--' + tagNum + '">' + to + '</span>' );
                        }
                    } else {
                        $tag.hide();
                    }
                } );
            } );
        } )( i );
    }
    
    // Bio Section
    wp.customize( 'mkp_about_content', function( value ) {
        value.bind( function( to ) {
            var content = to;
            
            // If content is empty, use Lorem Ipsum default
            if ( ! content || content.trim() === '' ) {
                content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.\n\nExcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.\n\nNemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.';
            }
            
            // Fix the selector - should be mkp-about-section__content
            $( '.mkp-about-section__content' ).html( wpautop( content ) );
            
            // Always show the about section
            $( '.mkp-about-section' ).show();
        } );
    } );
    
    // Books Section
    for ( let i = 1; i <= 6; i++ ) {
        ( function( bookNum ) {
            wp.customize( 'mkp_book_' + bookNum + '_title', function( value ) {
                value.bind( function( to ) {
                    const $book = $( '.mkp-books__grid .mkp-book-card:nth-child(' + bookNum + ')' );
                    if ( to ) {
                        $book.find( '.mkp-book-card__title' ).text( to );
                        $book.show();
                    } else {
                        $book.hide();
                    }
                } );
            } );
            
            wp.customize( 'mkp_book_' + bookNum + '_cover', function( value ) {
                value.bind( function( to ) {
                    const $book = $( '.mkp-books__grid .mkp-book-card:nth-child(' + bookNum + ')' );
                    if ( to ) {
                        $book.find( '.mkp-book-card__cover img' ).attr( 'src', to );
                        $book.find( '.mkp-book-card__cover' ).show();
                    } else {
                        $book.find( '.mkp-book-card__cover' ).hide();
                    }
                } );
            } );
            
            wp.customize( 'mkp_book_' + bookNum + '_description', function( value ) {
                value.bind( function( to ) {
                    const $book = $( '.mkp-books__grid .mkp-book-card:nth-child(' + bookNum + ')' );
                    $book.find( '.mkp-book-card__description' ).html( wpautop( to ) );
                } );
            } );
            
            wp.customize( 'mkp_book_' + bookNum + '_link', function( value ) {
                value.bind( function( to ) {
                    const $book = $( '.mkp-books__grid .mkp-book-card:nth-child(' + bookNum + ')' );
                    if ( to ) {
                        $book.find( 'a.mkp-btn' ).attr( 'href', to ).show();
                    } else {
                        $book.find( 'a.mkp-btn' ).hide();
                    }
                } );
            } );
        } )( i );
    }
    
    // Speaker Topics
    for ( let i = 1; i <= 5; i++ ) {
        ( function( topicNum ) {
            wp.customize( 'mkp_speaker_topic_' + topicNum, function( value ) {
                value.bind( function( to ) {
                    const $topic = $( '.mkp-speaker__topic--' + topicNum );
                    if ( to ) {
                        if ( $topic.length ) {
                            $topic.text( to ).show();
                        } else {
                            $( '.mkp-speaker__topics' ).append( '<li class="mkp-speaker__topic mkp-speaker__topic--' + topicNum + '">' + to + '</li>' );
                        }
                    } else {
                        $topic.hide();
                    }
                } );
            } );
        } )( i );
    }
    
    // Podcast Section
    wp.customize( 'mkp_podcast_name', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-podcast__name' ).text( to );
        } );
    } );
    
    wp.customize( 'mkp_podcast_logo', function( value ) {
        value.bind( function( to ) {
            if ( to ) {
                $( '.mkp-podcast__logo img' ).attr( 'src', to );
                $( '.mkp-podcast__logo' ).show();
            } else {
                $( '.mkp-podcast__logo' ).hide();
            }
        } );
    } );
    
    wp.customize( 'mkp_podcast_synopsis', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-podcast__synopsis' ).html( wpautop( to ) );
        } );
    } );
    
    // Companies (Corporations) Section
    for ( let i = 1; i <= 4; i++ ) {
        ( function( corpNum ) {
            wp.customize( 'mkp_corp_' + corpNum + '_name', function( value ) {
                value.bind( function( to ) {
                    $( '.mkp-corp--' + corpNum + ' .mkp-corp-card__name' ).text( to );
                    if ( to ) {
                        $( '.mkp-corp--' + corpNum ).show();
                    } else {
                        $( '.mkp-corp--' + corpNum ).hide();
                    }
                } );
            } );
            
            wp.customize( 'mkp_corp_' + corpNum + '_logo', function( value ) {
                value.bind( function( to ) {
                    if ( to ) {
                        $( '.mkp-corp--' + corpNum + ' .mkp-corp-card__logo img' ).attr( 'src', to );
                    }
                } );
            } );
            
            wp.customize( 'mkp_corp_' + corpNum + '_bio', function( value ) {
                value.bind( function( to ) {
                    $( '.mkp-corp--' + corpNum + ' .mkp-corp-card__bio' ).html( wpautop( to ) );
                } );
            } );
        } )( i );
    }
    
    // Media Questions
    for ( let i = 1; i <= 12; i++ ) {
        ( function( questionNum ) {
            wp.customize( 'mkp_media_question_' + questionNum, function( value ) {
                value.bind( function( to ) {
                    const $question = $( '.mkp-media-question--' + questionNum );
                    if ( to ) {
                        if ( $question.length ) {
                            $question.text( to ).show();
                        } else {
                            $( '.mkp-media-questions__list' ).append( '<li class="mkp-media-question mkp-media-question--' + questionNum + '">' + to + '</li>' );
                        }
                    } else {
                        $question.hide();
                    }
                } );
            } );
        } )( i );
    }
    
    // Investor Section
    wp.customize( 'mkp_investment_people', function( value ) {
        value.bind( function( to ) {
            if ( to ) {
                $( '.mkp-investor__lane--people .mkp-investor__lane-content' ).html( wpautop( to ) );
                $( '.mkp-investor__lane--people' ).show();
            } else {
                $( '.mkp-investor__lane--people' ).hide();
            }
        } );
    } );
    
    wp.customize( 'mkp_investment_products', function( value ) {
        value.bind( function( to ) {
            if ( to ) {
                $( '.mkp-investor__lane--products .mkp-investor__lane-content' ).html( wpautop( to ) );
                $( '.mkp-investor__lane--products' ).show();
            } else {
                $( '.mkp-investor__lane--products' ).hide();
            }
        } );
    } );
    
    wp.customize( 'mkp_investment_markets', function( value ) {
        value.bind( function( to ) {
            if ( to ) {
                $( '.mkp-investor__lane--markets .mkp-investor__lane-content' ).html( wpautop( to ) );
                $( '.mkp-investor__lane--markets' ).show();
            } else {
                $( '.mkp-investor__lane--markets' ).hide();
            }
        } );
    } );
    
    // Social Media Links
    wp.customize( 'mkp_social_facebook', function( value ) {
        value.bind( function( to ) {
            updateSocialLink( 'facebook', to );
        } );
    } );
    
    wp.customize( 'mkp_social_twitter', function( value ) {
        value.bind( function( to ) {
            updateSocialLink( 'twitter', to );
        } );
    } );
    
    wp.customize( 'mkp_social_linkedin', function( value ) {
        value.bind( function( to ) {
            updateSocialLink( 'linkedin', to );
        } );
    } );
    
    wp.customize( 'mkp_social_instagram', function( value ) {
        value.bind( function( to ) {
            updateSocialLink( 'instagram', to );
        } );
    } );
    
    wp.customize( 'mkp_social_youtube', function( value ) {
        value.bind( function( to ) {
            updateSocialLink( 'youtube', to );
        } );
    } );
    
    wp.customize( 'mkp_social_tiktok', function( value ) {
        value.bind( function( to ) {
            updateSocialLink( 'tiktok', to );
        } );
    } );
    
    // Contact Emails
    wp.customize( 'mkp_contact_email_primary', function( value ) {
        value.bind( function( to ) {
            $( '.mkp-contact-email-primary' ).attr( 'href', 'mailto:' + to ).text( to );
        } );
    } );
    
    // Helper function to load Google Fonts
    function loadGoogleFont( fontKey ) {
        const fontNames = {
            'inter': 'Inter:wght@300;400;500;600;700',
            'roboto': 'Roboto:wght@300;400;500;700',
            'opensans': 'Open+Sans:wght@300;400;600;700',
            'lato': 'Lato:wght@300;400;700',
            'montserrat': 'Montserrat:wght@300;400;500;600;700',
            'playfair': 'Playfair+Display:wght@400;700',
            'merriweather': 'Merriweather:wght@300;400;700',
            'poppins': 'Poppins:wght@300;400;500;600;700',
            'raleway': 'Raleway:wght@300;400;500;600;700'
        };
        
        if ( fontNames[fontKey] ) {
            const fontLink = 'https://fonts.googleapis.com/css2?family=' + fontNames[fontKey] + '&display=swap';
            
            // Remove existing font link if any
            $( '#mkp-google-font-' + fontKey ).remove();
            
            // Add new font link
            $( '<link>' )
                .attr( 'id', 'mkp-google-font-' + fontKey )
                .attr( 'rel', 'stylesheet' )
                .attr( 'href', fontLink )
                .appendTo( 'head' );
        }
    }
    
    // Helper function to update social links
    function updateSocialLink( platform, url ) {
        const $link = $( '.mkp-social__link--' + platform );
        if ( url ) {
            $link.attr( 'href', url )
                .removeClass( 'customize-unpreviewable' )
                .parent().show();
        } else {
            $link.parent().hide();
        }
    }
    
    // Helper function to convert text to paragraphs (similar to PHP wpautop)
    function wpautop( text ) {
        if ( ! text ) return '';
        
        // Replace double line breaks with paragraph tags
        text = '<p>' + text.replace( /\n\n+/g, '</p><p>' ) + '</p>';
        
        // Replace single line breaks with <br>
        text = text.replace( /\n/g, '<br>' );
        
        // Remove empty paragraphs
        text = text.replace( /<p>\s*<\/p>/g, '' );
        
        return text;
    }
    
} )( jQuery );