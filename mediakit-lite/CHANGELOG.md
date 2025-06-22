# MediaKit Lite Theme Changelog

All notable changes to the MediaKit Lite theme will be documented in this file.

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