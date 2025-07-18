# MediaKit Lite Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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