# MediaKit Lite Theme Changelog

All notable changes to the MediaKit Lite theme will be documented in this file.

## [1.8.11] - 2025-06-26

### Added
- Footer now dynamically adopts the color of the previous section
- New `mkp_get_last_section_color()` function to track section colors

### Changed
- Footer background and text colors are now applied inline based on the last section
- Footer links now inherit color from parent with opacity for subtle effect

### Removed
- Hardcoded footer colors from CSS and dynamic styles
- White color override for footer section headings

### Improved
- Seamless visual flow from content sections to footer
- More cohesive and modern design without color breaks
- Better integration with the color theme rotation system

## [1.8.10] - 2025-06-26

### Removed
- Removed "Connect With Me" heading from contact section
- Removed unnecessary CSS for social title

### Fixed
- Reduced large gap between contact info and social media icons from 80px to 16px
- Social media icons now sit closer to contact information for better visual flow

### Improved
- Cleaner, more compact contact section layout
- Better visual hierarchy without redundant headings

## [1.8.9] - 2025-06-26

### Fixed
- Removed horizontal divider line from footer
- Removed extra padding and margin from footer bottom section
- Cleaner, more compact footer layout

## [1.8.8] - 2025-06-26

### Removed
- Removed Hero Background Image option from customizer
- Removed hero overlay color and opacity settings
- Removed related JavaScript and CSS for hero backgrounds
- Hero section now consistently uses the color theme system

### Changed  
- Updated Hero Section customizer description to reflect focus on professional images and content
- Simplified hero template to always use dynamic theme colors
- Improved design consistency by removing background image option that conflicted with color themes

### Improved
- Better visual consistency across all sections
- Cleaner customizer interface without confusing background options
- Faster page loads without large background images
- More professional appearance with consistent color theming

## [1.8.7] - 2025-06-26

### Removed
- Removed unused CTA button functionality from Hero section
- Removed CTA button HTML from hero.php template
- Removed CTA button CSS styles (.mkp-hero__buttons)
- Removed CTA button default values from JavaScript
- Cleaned up dynamic styles that referenced CTA buttons
- These buttons were never properly implemented in the customizer

## [1.8.6] - 2025-06-26

### Removed
- Removed unused "Primary Button Text" setting from Hero Section customizer
- Removed unused "Primary Button Link" setting from Hero Section customizer
- These legacy settings were not being used anywhere in the theme
- Simplifies the customizer interface by removing confusing unused options

## [1.8.5] - 2025-06-26

### Fixed
- Professional Tags separators no longer appear at end of lines when wrapping
- Changed separator implementation from CSS pseudo-elements to inline HTML elements
- Separators now flow naturally with text and wrap properly
- Improved visual appearance of multi-line professional tags

## [1.8.4] - 2025-06-26

### Changed
- Improved mobile hero section layout with better image placement
- Left-positioned images now appear above content on mobile
- Right-positioned images now appear below content on mobile
- Added proper spacing and centering for mobile hero images
- Creates balanced "sandwich" layout instead of top-heavy design

## [1.8.3] - 2025-06-26

### Fixed
- Mobile navigation hamburger menu now uses theme text color for proper visibility
- Mobile dropdown menu now matches header background color instead of white
- Fixed white-on-white text issue in mobile navigation dropdown
- Improved mobile navigation color consistency with desktop appearance

## [1.8.2] - 2025-06-26

### Changed
- Increased About section content width from 800px to 1000px
- Provides more space for biographical content while maintaining readability
- Better balance between text optimization and content space

## [1.8.1] - 2025-06-26

### Fixed
- Removed redundant max-width and extra padding from Hero section wrapper
- Hero section now uses consistent width with other sections
- Eliminated double padding issue (was 64px total, now standard 32px)
- Improved available space for hero content and images

## [1.8.0] - 2025-06-26

This release brings major improvements to the theme's color system, typography controls, and user interface consistency.

### Added
- Professional color theme system with 6 pre-defined themes (Ocean Depths, Forest Journey, Sunset Warmth, Midnight Elegance, Corporate Professional, Creative Spirit)
- Dynamic color rotation that automatically adapts to visible sections
- Hover effects for Speaking Topics and Companies cards with lift animation and enhanced shadows
- Consistent interactive feedback across all major card components

### Changed
- Replaced 12+ individual color pickers with single theme selector dropdown
- Widened Speaking Topics cards from 1000px to 1200px (4-topic layout from 700px to 1000px)
- Widened Companies section from 700px to 1200px for better content presentation
- Simplified customizer interface for better user experience
- All section templates now use dynamic theme-based color system

### Fixed
- Body and heading fonts now update immediately in customizer preview
- Fixed CSS variable conflicts preventing font changes from showing
- Fixed bullet alignment in Questions for the Media section
- Speaking Topics cards now properly inherit section colors when using card style
- Investment Verticals section titles now use theme colors instead of hardcoded values

### Removed
- All individual background color settings from customizer
- Primary, secondary, and accent color settings (replaced by theme system)
- Auto-contrast detection system (no longer needed with pre-defined themes)

## [1.7.34] - 2025-06-26

### Changed
- Widened Speaking Topics cards default width from 1000px to 1200px
- Widened Speaking Topics 4-topic layout from 700px to 1000px
- Speaking Topics cards now have more consistent spacing across different topic counts
- Aligned Speaking Topics width with other card-based sections

## [1.7.33] - 2025-06-26

### Changed
- Widened Companies section from 700px to 1200px max-width
- Companies cards now have more breathing room for logos and content
- Aligned Companies section width with other major content sections

## [1.7.32] - 2025-06-26

### Fixed
- Fixed bullet alignment in Questions for the Media section
- Bullets now properly align with the first line of wrapped text instead of the last line
- Removed display: inline-block from question text to fix alignment issue

## [1.7.31] - 2025-06-25

### Added
- Hover effects for Speaking Topics cards (lift and enhanced shadow)
- Hover effects for Companies cards (lift and enhanced shadow)
- Consistent interactive feedback across all major card components

### Changed
- Speaking Topics and Companies cards now have the same elegant hover animation as Investment Verticals
- Cards lift 4px and display enhanced shadows on hover for better user interaction

## [1.7.30] - 2025-06-25

### Fixed
- Body font now updates immediately in customizer preview
- Heading font now updates immediately in customizer preview
- Fixed CSS variable conflicts preventing font changes from showing
- Improved Google Fonts loading for better performance

## [1.7.29] - 2025-06-25

### Fixed
- Speaking Topics cards now properly inherit section colors when using card style
- Investment Verticals section titles and descriptions now use theme colors instead of hardcoded values
- Body font changes now appear immediately in customizer preview
- Dynamic Google Fonts loading based on selected fonts for better performance

## [1.7.28] - 2025-06-25

### Added
- Professional color theme system with 6 pre-defined themes
- Dynamic color rotation that adapts to visible sections
- Color themes: Ocean Depths, Forest Journey, Sunset Warmth, Midnight Elegance, Corporate Professional, Creative Spirit
- Automatic text color contrast for all themes

### Changed
- Replaced 12+ individual color pickers with single theme selector dropdown
- Simplified customizer interface for better user experience
- Updated all section templates to use dynamic color system
- Rewrote customizer-dynamic-styles.php for theme-based colors

### Removed
- All individual background color settings from customizer
- Primary, secondary, and accent color settings
- Auto-contrast detection system (no longer needed)
- Navigation background color setting

## [1.7.27] - 2025-06-25

### Changed
- Limited hero section to maximum 2 images (reduced from 4)
- Updated hero image layout to display side-by-side with spacing when room allows
- Images now stack vertically on smaller screens automatically
- Added consistent spacing between images when on same side

### Removed
- Removed hero image slots 3 and 4 from customizer settings

## [1.7.26] - 2025-06-25

### Fixed
- Fixed Companies section display issue by removing inline display:block styles that were overriding flexbox layout
- Fixed update checker version mismatch by updating MKP_THEME_VERSION constant in functions.php

## [1.7.25] - 2025-06-25

### Fixed
- Fixed navigation padding at 1200px screen width for better edge spacing
- Fixed hero section centering by adjusting flex layout and adding consistent padding
- Standardized container padding across all sections (increased from 1rem to 2rem)
- Removed percentage-based hero image sizing for more consistent layout

### Changed
- Redesigned Companies section to single-column vertical layout for better visual hierarchy
- Reduced padding and spacing in company cards for more compact display
- Simplified responsive breakpoints for Companies section

## [1.7.24] - 2025-06-25

### Fixed
- Fixed CSS specificity conflicts in Companies section by removing duplicate :has() selectors
- Ensured count-based grid layouts properly override base auto-fit rule with increased specificity
- Improved CSS maintainability by consolidating to single count-based class system

## [1.7.23] - 2025-06-25

### Fixed
- Fixed Companies section 4-item layout orphan issue by using count-based CSS classes
- Improved browser compatibility by replacing :has() selectors with explicit classes

## [1.7.22] - 2025-06-25

### Changed
- Simplified "In The Media" section to URL-only input (removed title, type, date, description, thumbnail fields)
- Expanded Speaking Topics from 5 to 6 topics
- Fixed Companies section 4-item layout to display as 2x2 grid instead of 3+1
- Fixed Speaking Topics card style 4-item layout to display as 2x2 grid
- Speaking Topics card style 6-item layout now displays as 3x2 grid

### Removed
- Removed complex metadata fields from In The Media section (now just paste media URLs)
- Cleaned up deprecated JavaScript and CSS for removed In The Media fields

## [1.7.21] - 2025-06-25

### Added
- New "In The Media" section for showcasing media appearances
- Support for automatic YouTube and Spotify embeds
- Expanded Companies section from 4 to 6 companies

### Changed
- Improved Companies section grid layout to prevent orphan items
- Single company now centers properly

### Removed
- Cleaned up legacy custom post type code
- Removed unused image sizes (portfolio, testimonial, press-logo)
- Removed unused meta-boxes and options-pages files
- Removed portfolio JavaScript filtering code

## [1.7.13] - 2025-06-22

### Changed
- Match Contact section enable/disable behavior with Investor section

## [1.7.12] - 2025-06-22

### Changed
- Fix Contact section enable/disable toggle in customizer

## [1.7.11] - 2025-06-22

### Changed
- Fix Contact section background color dynamic preview by removing inline style

## [1.7.10] - 2025-06-22

### Changed
- Remove update notice section, add upload button, fix Contact dynamic preview

## [1.7.9] - 2025-06-22

### Changed
- Fix Contact section dynamic preview with class-based visibility

## [1.7.8] - 2025-06-22

### Changed
- Sync hero name with WordPress site title

## [1.7.7] - 2025-06-22

### Changed
- Fix Contact section dynamic preview to match Investor section pattern

## [1.7.6] - 2025-06-22

### Changed
- Fix Contact section dynamic preview functionality

## [1.7.5] - 2025-06-22

### Changed
- Fix Contact section dynamic preview in customizer

## [1.7.4] - 2025-06-22

### Changed
- Fix Contact section visibility in customizer (0->1 transition)

## [1.7.3] - 2025-06-22

### Changed
- Add verbose logging to update checker for debugging

## [1.7.2] - 2025-06-22

### Changed
- Update bump script to sync root version.json file

## [1.7.1] - 2025-06-22

### Changed
- Fix version detection in update checker

## [1.7.0] - 2025-06-22

### Changed
- Add Contact section with email addresses, physical address, and social media links; Update Investor section title to Investment Vertical(s)

## [1.4.5] - 2025-06-22

### Changed
- Fixed hero images not updating in customizer

## [1.4.4] - 2025-06-22

### Changed
- Code cleanup and verification - fixed hero button default link

## [1.4.3] - 2025-06-22

### Changed
- Fixed undefined function mkp_get_default_bio error in customizer

## [1.4.2] - 2025-06-22

### Changed
- Actually remove duplicate function declarations this time

## [1.4.1] - 2025-06-22

### Changed
- Fixed duplicate function declarations causing fatal error

## [1.4.0] - 2025-06-22

### Changed
- Major architectural cleanup - removed Books, Podcast, Media Questions, Investor, In The Media, and Contact sections. Theme now focuses on Hero, About, Companies, and Speaker Topics only.

## [1.3.20] - 2025-06-22

### Changed
- Removed backup customizer files that were causing removed sections to still appear

## [1.3.19] - 2025-06-22

### Changed
- Updated theme description to emphasize personal leverage and tailored design services

## [1.3.18] - 2025-06-22

### Changed
- Fixed PHP warning about widget title property in Customizer

## [1.3.17] - 2025-06-22

### Changed
- Removed all sections except Hero, About, Companies, and Speaker Topics. Major architectural cleanup to simplify theme.

## [1.3.16] - 2025-06-22

### Changed
- Fixed CSS selectors for Questions for the Media and Investment sections card styling

## [1.3.15] - 2025-06-22

### Changed
- Refactored Contact Information section with social media icons and improved auto-contrast

## [1.3.14] - 2025-06-22

### Changed
- Added card styling with darker backgrounds to all content sections for better visual hierarchy

## [1.3.13] - 2025-06-22

### Changed
- Merged Social Media and Contact sections, verified enable/disable and auto-contrast for all sections

## [1.3.12] - 2025-06-22

### Fixed
- Section order disabled state detection (correct setting names)
- Color picker initialization with proper script enqueuing

### Enhanced
- Color picker functionality with better browser support
- Navigation background color instructions

## [1.3.11] - 2025-06-22

### Added
- Navigation background color with auto-contrast text
- Visual indicators for disabled sections in Section Order
- Eyedropper tool instructions for color pickers

### Fixed
- Navigation font live preview in customizer
- Section Order drag-and-drop functionality
- Speaker topics auto-contrast for dark backgrounds

### Changed
- Speaker topics card style from numbers to arrows
- Social media links to horizontal layout

## [1.3.10] - 2025-06-22

### Fixed
- GitHub Actions workflow version detection using jq
- Section Order drag-and-drop functionality
- Speaker topics auto-contrast for dark backgrounds
- Social media links horizontal layout

## [1.3.9] - 2025-06-22

### Changed
- Fix Section Order drag-drop, speaker topics arrows, and social links layout

## [1.3.8] - 2025-06-22

### Changed
- Move promotional content to less prominent position in admin area
- Improve GitHub Actions workflow version detection

## [1.3.7] - 2025-06-22

### Changed
- Fixed GitHub Actions workflow permissions for automated releases

## [1.3.6] - 2025-06-22

### Changed
- Improved speaking topics with list view options and larger text

## [1.3.5] - 2025-06-22

### Changed
- Test automated release

## [1.3.4] - 2025-06-22

### Fixed
- WP_Customize_Control class not found error by adding proper class_exists check

### Updated
- Theme description to accurately reflect current features
- Theme tags to better represent theme functionality

### Added
- WordPress and PHP version requirements in theme header
- readme.txt file with installation instructions and FAQ

## [1.3.3] - 2025-06-22

### Fixed
- Removed duplicate mkp_sanitize_checkbox function declaration that was causing fatal error

## [1.3.2] - 2025-06-22

### Added
- Live preview for Companies, Media Questions, and Investor sections in Customizer
- Draggable section reordering in Customizer (except Hero and Bio which remain fixed)

### Fixed
- Version check now correctly checks version.json in mediakit-lite subdirectory

### Changed
- Updated Finish Line Media contact link to point to form section

## [1.3.1] - 2025-06-22

### Refactored
- Front page structure with centralized section configuration
- Social icons functionality moved to dedicated module
- Removed unused template functions for cleaner codebase
- Fixed class naming convention (MKP_Walker_Nav_Menu to Mkp_Walker_Nav_Menu)

### Added
- Customizer helper functions for cleaner code

### Improved
- Overall code organization and maintainability

## [1.3.0] - 2025-06-22

### Fixed
- Contact/Social Media section (Get in Touch) missing from front page
- Removed duplicate contact information from footer to avoid redundancy

## [1.2.9] - 2025-06-22

### Removed
- Background Settings section from Customizer
- WordPress default Menus panel
- WordPress default Widgets panel
- Homepage Settings section
- Additional CSS section
- Contact Section from bottom of website (redundant with Social Media section)
- Custom background support from theme

### Improved
- Book cover images now have padding and use object-fit: contain for better display
- Book section changes now auto-update in Customizer preview
- Book purchase links now update instantly in preview
- Cleaner Customizer interface with fewer unnecessary options

### Fixed
- Book section live preview now uses correct CSS selectors
- Book cards properly show/hide based on content

## [1.2.8] - 2025-06-22

### Added
- Manual "Check for Updates" button in Media Kit Overview dashboard
- Manual "Check for Updates" button in WordPress dashboard widget
- Update status display in both admin locations
- Shows last checked time for updates

### Removed
- Download Stats menu item and functionality
- Import/Export menu item and functionality
- Download tracking AJAX handler
- Recent downloads display from dashboard widget

### Improved
- Simplified admin menu structure
- Cleaner dashboard interface
- Theme Updates section in Media Kit Overview

## [1.2.7] - 2025-06-22

### Added
- Live preview for Companies (Corporations) section in Customizer
- Image transport for Podcast/Show Logo and Company logos

### Changed
- Renamed "Corporations" to "Companies" throughout the theme
- Renamed "Podcast/Show" to "Your Podcast/Show" in Customizer
- All sections now update immediately in Customizer preview

### Improved
- Speaker Topics, Podcast/Show, Companies, Media Questions, and Investor sections now auto-update without page refresh
- Better real-time editing experience in WordPress Customizer

## [1.2.6] - 2025-06-22

### Fixed
- Social media links now function properly (removed customize-unpreviewable class)
- Social icon SVG sizing and visibility improved
- Hover states for social icons work correctly with proper contrast
- Removed conflicting inline styles that prevented clicking
- Added JavaScript to ensure social links remain clickable

### Improved
- Social icon CSS specificity to override any inline styles
- Added pointer-events handling for better click reliability
- Enhanced hover animations for social icons

## [1.2.5] - 2025-06-22

### Added
- Default Lorem Ipsum content for Bio section when empty
- Bio section now always displays (no longer hides when empty)

### Fixed
- Bio content selector in customizer preview (was using wrong class name)
- Bio section now properly shows Lorem Ipsum in live preview when content is cleared

### Improved
- Bio section is now permanent like Hero section, ensuring consistent page structure

## [1.2.4] - 2025-06-22

### Changed
- Moved Social Media section below Contact Information in the Customizer for better organization

### Removed
- Social Icon Style option that wasn't functioning properly
- Social icons now use a consistent circular style

### Simplified
- Social media icon display code for better reliability
- Removed unnecessary CSS classes for different icon styles

## [1.2.3] - 2025-06-22

### Added
- Auto-contrast functionality for all sections - text automatically adjusts to light/dark based on background color
- Live preview for section background colors in the Customizer

### Changed
- Hero tags now display as simple text with middle dot separators instead of button-style badges
- Professional tags now appear as "Tag1 · Tag2 · Tag3" format

### Fixed
- Hero section background color now updates immediately in Customizer preview
- Button hover states now maintain proper text color contrast
- Primary and secondary buttons now have consistent hover behavior with accent color

### Improved
- All sections now have automatic text color adjustment for better readability
- Button text remains visible on all hover states regardless of color choices

## [1.2.2] - 2025-06-22

### Changed
- Renamed theme from "MediaKit Pro" to "MediaKit Lite"
- Updated all references throughout the codebase to use the new theme name
- Updated theme directory name from mediakit-pro to mediakit-lite
- Updated all enqueue handles and script/style registrations
- Updated export scripts to use new theme name

### Updated
- Theme text domain to mediakit-lite for consistency

## [1.2.1] - 2024-06-22

### Removed
- Logo option from navigation bar and customizer settings
- "Book Me" button from header
- Custom logo support from theme
- Login page logo customization

### Changed
- Navigation menu is now right-aligned
- Updated navigation font CSS to properly apply to navigation links

### Fixed
- Navigation font changes now properly apply when changed in the Customizer

## [1.2.0] - 2024-06-22

### Changed
- Profile Photo and Family Crest now display at full size (no cropping or circular masks)
- Implemented proper grid layout for hero section:
  - Single image on left/right: takes 1/3 of width, content takes 2/3
  - Both images on same side: each takes 1/6 of width, content takes 2/3
  - Images display side-by-side when on the same side (desktop view)
- Maximum image height set to 300px (200px on mobile)
- Images maintain aspect ratio with object-fit: contain

### Fixed
- PHP syntax error from extra closing parenthesis in customizer.php

## [1.1.9] - 2024-06-22

### Added
- Separate controls for Profile Photo and Family Crest images
- Position controls (Left/Right) for both Profile Photo and Family Crest
- Automatic migration from old profile image setting to new profile photo setting

### Changed
- Split "Profile Photo / Family Crest" into two separate image uploads
- Hero section layout now supports images on both left and right sides
- Images can be positioned independently (both can be on same side or opposite sides)
- When multiple images are on the same side, they stack vertically with proper spacing
- Improved responsive layout for mobile devices

### Fixed
- Images now properly align when both are positioned on the same side

## [1.1.8] - 2024-06-22

### Changed
- Removed website name/logo from navigation header for cleaner design
- Renamed "Accent Color" to "Hover Color" in Customizer to better reflect its purpose
- Updated all hover states (links, buttons, navigation, social icons) to use the hover color consistently

### Fixed
- Consistent hover color application across all interactive elements

## [1.1.7] - 2024-06-22

### Removed
- Custom post types: Speaking Topics, Media Appearances, Portfolio Items, Testimonials, Press Mentions
- Admin menu items: Media Kit Settings, Interview Resources, Form Submissions
- Related taxonomies: Media Type, Portfolio Category
- Associated meta boxes and functions
- Template files that relied on custom post types (renamed to .deprecated)

### Changed
- Simplified admin dashboard widget to focus on Customizer
- Updated Export/Import functionality to work with theme settings instead of custom posts
- Cleaned up functions.php by removing custom post type registrations

### Fixed
- Removed orphaned references to removed functionality
- Updated schema markup to remove speaking_topic references

## [1.1.6] - 2024-06-22

### Changed
- Removed Section Visibility controls from Navigation section
- Each section now has its own enable/disable checkbox within its customizer panel
- Each section now has independent background color control
- Hero and Bio sections are now permanent (no enable/disable option)
- Removed generic section background colors from Brand Settings

### Added
- Enable/disable checkbox to each section's customizer panel (except Hero and Bio)
- Background color control to each section for independent customization
- Contact section now has enable/disable control

### Fixed
- Section templates now use their own background color settings
- Navigation menu properly reflects enabled sections only

## [1.1.5] - 2024-06-22

### Changed
- Renamed "Site Identity & Logo" section to "Navigation" in Customizer
- Removed Site Title & Tagline controls from Customizer and header display
- Moved Site Icon control to Brand Settings section
- Added section visibility checkboxes to enable/disable front page sections
- Added navigation font option to customize menu typography

### Added
- Dynamic front page navigation that shows only enabled sections
- Automatic section anchors for smooth scrolling navigation
- Section IDs to all front page template parts for navigation jumps

### Fixed
- Front page now respects section visibility settings
- Navigation dynamically updates based on enabled sections

## [1.1.4] - 2024-06-22

### Changed
- Updated all overlay controls to use separate color picker and opacity slider
- Replaced manual rgba input with user-friendly color picker + opacity range (0-100)
- Added automatic migration for existing rgba overlay values

### Fixed
- Improved user experience for setting overlay colors and transparency

## [1.1.3] - 2024-06-22

### Changed
- Merged "Section Colors" into "Brand Settings" section in the Customizer for better organization
- Renamed section colors to "Section Background" for clarity
- Improved customizer workflow by consolidating all color and typography settings

## [1.1.2] - 2024-06-22

### Changed
- Updated theme author to "Finish Line Media" with URL https://finishline.media/

## [1.1.1] - 2024-06-22

### Fixed
- Hero background image now properly displays when set in the Customizer
- Added support for background image overlay to ensure text readability
- Hero section now correctly uses the uploaded background image instead of just the section color

## [1.1.0] - 2024-06-22

### Changed (Major Update)
- Complete redesign of landing page structure with section-based layout
- Hero section now features profile photo/family crest instead of background focus
- Limited professional tags to maximum of 5 (from unlimited)
- Reorganized customizer sections for better workflow

### Added
- Section Colors: 2-3 key colors for visual section breaks
- About/Bio Section: Dedicated biography area (3-5 paragraphs)
- Books Section: Showcase up to 6 books with "coming soon" support
- Speaker Topics: Exactly 5 professional speaking themes
- Podcast/Show Section: Name, logo, and synopsis
- Corporations Section: Up to 4 companies with logos and bios
- Media Questions: 10-12 pre-written interview questions
- Investor Section: Investment focus in People, Products, Markets
- In The Media Section: Up to 12 media appearances/samples

### Removed
- Hero bio text (moved to dedicated About section)
- Unlimited tags in hero (now limited to 5)

## [1.0.7] - 2024-06-22

### Changed
- Updated Twitter to X (formerly Twitter) in social media options
- Updated Twitter/X icon to new X logo
- Social icon style now properly updates in live preview

### Removed
- Pinterest social media option
- GitHub social media option  
- Email social media option (use Contact Information section instead)

### Fixed
- Social icon style changes now properly apply to all icons
- Added missing style transport for live preview

## [1.0.6] - 2024-06-22

### Added
- Comprehensive instructions and descriptions for all Theme Customizer settings
- Helpful guidance for each Brand Settings option
- Detailed descriptions for Background Settings
- User-friendly instructions for Hero Section configuration
- Clear explanations for Social Media profile setup
- Professional tips for Contact Information fields
- SEO-focused descriptions for SEO Settings section

### Fixed
- PHP fatal error in update-notice.php when accessing themes page

### Improved
- User experience with clearer customizer field descriptions
- Onboarding process for new users configuring their media kit
- Understanding of recommended image sizes and formats
- Guidance on best practices for each setting

## [1.0.5] - 2024-06-22

### Added
- Helpful instructions for Logo upload in Site Identity section
- Enhanced description for Site Icon with usage information

### Changed
- Renamed "Site Identity" section to "Site Identity & Logo" for clarity

### Improved
- Better guidance for logo specifications (size, format recommendations)
- Clearer site icon requirements and usage explanation

## [1.0.4] - 2024-06-22

### Added
- Unified Background Settings section in customizer
- Background overlay color option for background images
- Live preview for background overlay

### Changed
- Merged WordPress core background color and background image controls into single "Background Settings" section
- Removed default WordPress "Colors" and "Background Image" sections

### Improved
- Better organization of background-related settings
- Enhanced customizer user experience with grouped settings

## [1.0.3] - 2024-06-22

### Changed
- Consolidated all custom post types under single "Media Kit" admin menu
- Changed Media Kit menu icon to more appropriate ID card icon (dashicons-id-alt)
- Improved admin menu organization with visual separator

### Added
- Manual theme update notification system
- Update instructions documentation (UPDATE.md)
- Theme changelog file (CHANGELOG.md)

### Fixed
- Admin menu loading priority to ensure proper submenu registration

## [1.0.2] - 2024-06-22

### Added
- Live preview functionality in Theme Customizer for all brand settings
- Reset buttons for individual customizer controls
- Section reset buttons to restore default values
- Google Fonts integration with live preview
- Customizer controls JavaScript for enhanced UX

### Changed
- All customizer settings now use postMessage transport for instant preview
- Improved customizer control styling

### Fixed
- Font loading in customizer preview

## [1.0.1] - 2024-06-21

### Fixed
- Duplicate function declaration (mkp_body_classes) error
- Merged body class functionality into single function in template-functions.php

## [1.0.0] - 2024-06-21

### Added
- Initial theme release
- Custom post types: Speaking Topics, Media Appearances, Portfolio, Testimonials, Press Mentions
- Native contact form system (no plugin required)
- Native meta boxes system (no ACF required)
- Theme Customizer with brand settings
- Custom Gutenberg blocks support
- Form submission management system
- Download tracking functionality
- Interview resources options page
- Import/Export functionality
- Responsive design
- Accessibility features
- Schema.org markup
- Open Graph meta tags

### Features
- Professional media kit homepage template
- Speaker profile template
- Portfolio showcase template
- Press mentions template
- Resources template
- AJAX-powered contact forms with three types (general, booking, media)
- Admin dashboard widget with quick stats
- Custom image sizes for different content types
- Social media integration
- SEO optimized structure

---

## Version Numbering

This theme follows [Semantic Versioning](https://semver.org/):
- MAJOR version (1.x.x) - Incompatible changes
- MINOR version (x.1.x) - New functionality, backwards compatible
- PATCH version (x.x.1) - Bug fixes, backwards compatible 
