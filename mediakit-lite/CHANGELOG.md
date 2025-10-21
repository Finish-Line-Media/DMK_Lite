# MediaKit Lite Theme Changelog

All notable changes to the MediaKit Lite theme will be documented in this file.

## [Unreleased]

### Changed
- Updated "Sahara Sunset" color theme to use darker color scheme with black navigation/footer and darker section rotations
- Sahara Sunset theme now displays copyright footer with navbar colors (black background, white text) for consistent branding
- Sahara Sunset copyright footer now spans full screen width for enhanced visual impact
- Sahara Sunset footer now sticks to bottom of viewport on short pages with increased height for stronger visual presence

### Fixed
- Eliminated gap below Sahara Sunset footer by removing footer bottom padding and matching body background to black

## [2.0.7] - 2025-10-21

### Added
- New "Sahara Sunset" color theme with warm brown and gold tones

### Fixed
- Improved mobile navigation scrolling compatibility for Android devices
- Mobile navigation overflow now only applies when menu is open, preventing conflicts with position and transform properties
- Publications (Books) cards now maintain their original order when card heights differ
- Replaced Masonry layout with CSS Grid for Publications section to prevent card repositioning
- "Read More" button now only expands the clicked card, not all cards simultaneously
- Added unique IDs and defensive checks to prevent cross-card interference
- Publications cards no longer stretch vertically when adjacent cards expand (CSS Grid align-items fix)

### Changed
- Publications section now uses CSS Grid instead of Masonry layout for better order preservation

## [2.0.6] - 2025-10-20

### Fixed
- Mobile navigation menu overflow issue - menu is now scrollable when content exceeds viewport height
- Hidden scrollbar in mobile navigation for cleaner appearance while maintaining scroll functionality

### Changed
- Updated "Books" navigation label to "Publications" for better terminology
- Updated default section title from "Books" to "Publications"

## [2.0.5] - 2025-09-16

### Changed
- Fixed text alignment not working on live sites

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.5] - 2025-09-16

### Fixed
- Text alignment not working on live sites due to CSS @import loading issues
- Added inline alignment styles output directly in wp_head to ensure they always load
- This guarantees text alignment settings work on all server configurations

## [2.0.4] - 2025-09-16

### Fixed
- Text alignment CSS specificity issue that prevented customizer text alignment settings from working properly
- Added !important flag to text alignment utility classes to ensure they override section-specific styles
- This fix affects all sections with text alignment options: About, Books, Corporations, Media Questions, and Testimonials

## [2.0.3] - 2025-09-15

### Added
- Expanded customizer options for all major sections:
  - In The Media section: Increased from 8 to 12 media items
  - Hero section: Increased from 5 to 7 professional tags
  - Companies section: Increased from 6 to 8 companies
  - Books section: Increased from 4 to 6 books
  - Podcasts section: Increased from 3 to 5 podcasts
  - Speaker Topics section: Increased from 6 to 8 topics
  - Testimonials section: Increased from 6 to 8 testimonials
  - Awards section: Increased from 6 to 8 awards
  - Media Features section: Increased from 12 to 14 media outlets
  - Stats section: Increased from 4 to 6 stats
  - Media Questions section: Increased from 12 to 14 questions
  - Investors section: Increased from 3 to 5 investors

### Changed
- Reordered About section customizer controls: Text Alignment now appears between Section Title and About Content for better UX

### Technical
- Updated all corresponding template files and JavaScript live preview handlers to support the expanded item counts
- Maintained consistent implementation patterns across all section expansions

## [2.0.2] - 2025-09-04

### Added
- Universal masonry card height control system for all masonry sections
- Read more/less functionality with smooth animations for overflow content
- Automatic overflow detection and gradient fade effects for clamped content
- Enhanced masonry relayout integration for Books, Podcasts, Awards, and Investors sections
- New masonry-cards.js for universal height management across all card-based sections

### Fixed
- Media grid positioning issues by replacing conflicting flexbox with CSS Grid
- Uneven card heights in Books and Podcasts sections with consistent 120px description limit
- Masonry positioning conflicts causing items to stack at same coordinates
- Disabled problematic Masonry JavaScript for media embeds in favor of reliable CSS Grid

### Changed
- Media section now uses CSS Grid instead of Masonry for better reliability
- All masonry sections now use shared CSS classes for maintainable code
- Enhanced masonry scripts to listen for universal relayout events
- Improved accessibility with proper ARIA attributes for expandable content

## [2.0.1] - 2025-07-18

### Changed
- Standardized card CSS across all sections (blog, archive, posts)
- Replaced hardcoded colors with opacity values for better theme integration
- Updated all spacing to use CSS variables instead of hardcoded values
- Applied glass morphism effect (.mkp-card) to comments area and sidebar widgets
- Enhanced comment form styling with glass morphism inputs
- Added visual separation for widgets and comments with subtle borders

### Fixed
- Fixed customizer refresh for sidebar toggle by removing blocking JavaScript
- Improved consistency of card-like elements throughout the theme

### Technical
- Removed duplicate glass morphism CSS implementations
- Created unified design language with consistent glass morphism effects

## [2.0.0] - 2025-07-18

### Added
- Hero image sizing options (small, medium, large) for each photo
- Mobile navigation auto-hide functionality
- Responsive video wrappers for embedded content
- Fix for missing WordPress Reading Settings when using SQLite
- Masonry layout for Books section

### Changed
- Major CSS refactoring into modular architecture
- Improved mobile responsiveness for videos in "In the Media" section
- Enhanced customizer with selective refresh disabled for better reliability
- Updated all enable/disable toggles to use refresh transport

### Fixed
- Mobile navigation now auto-hides after clicking menu items
- Video embeds no longer overflow viewport on mobile devices
- Sidebar enable/disable toggle now properly refreshes in customizer
- Blog visibility in navigation menu now respects customizer settings
- Fixed WordPress Reading Settings missing with SQLite database

### Technical
- Migrated from monolithic style.css to modular CSS architecture
- Implemented proper CSS cascade and inheritance patterns
- Added CSS custom properties for consistent theming
- Created must-use plugin for SQLite compatibility