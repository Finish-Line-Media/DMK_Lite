# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

MediaKit Lite is a professional WordPress theme designed for individual digital media kits. It showcases multiple professional facets, emphasizes storytelling, and provides easy media access to booking agents and journalists.

## Development Commands

### Local Development
- **WordPress Local Setup**: Use Local by Flywheel, MAMP, or similar for local WordPress development
- **Theme Location**: Install theme in `/wp-content/themes/mediakit-lite/`
- **Activate Theme**: Go to WordPress Admin > Appearance > Themes

### Build Commands
```bash
# Install dependencies (if using build tools)
npm install

# Watch for changes
npm run watch

# Build for production
npm run build

# Check PHP compatibility
composer check-cs

# Fix PHP coding standards
composer fix-cs
```

### Testing
- **PHP Linting**: `php -l *.php`
- **Theme Check Plugin**: Install and run WordPress Theme Check plugin
- **Browser Testing**: Test in Chrome, Firefox, Safari, Edge
- **Mobile Testing**: Test responsive design at 320px, 768px, 1024px, 1440px

## Architecture

### Theme Structure
```
mediakit-lite/
├── assets/              # CSS, JS, images (modular CSS architecture)
│   ├── css/            
│   │   ├── base/       # Variables, reset, typography, WordPress core
│   │   ├── components/ # Header, nav, cards, buttons, forms, etc.
│   │   ├── layout/     # Containers, grid, utilities
│   │   └── sections/   # Individual section styles
│   └── js/             # JavaScript files including masonry layouts
├── inc/                 # PHP includes
│   ├── customizer/      # Modular customizer architecture
│   │   ├── customizer-main.php
│   │   ├── helpers/     # Sanitization functions
│   │   └── sections/    # Individual customizer sections
│   ├── template-tags.php # Custom template functions
│   ├── blocks.php       # Gutenberg block registration
│   └── acf-fields.php   # ACF field configurations
├── template-parts/      # Reusable template components
├── templates/           # Page templates
├── style.css            # Main theme stylesheet (imports modular CSS)
├── style-old.css        # Legacy monolithic CSS (deprecated)
└── functions.php        # Core theme functionality
```

### Custom Post Types
1. **Speaking Topics** (`speaking_topic`) - Professional speaking offerings
2. **Media Appearances** (`media_appearance`) - TV, podcast, radio features
3. **Portfolio Items** (`portfolio_item`) - Work samples and projects
4. **Testimonials** (`testimonial`) - Client feedback
5. **Press Mentions** (`press_mention`) - Media coverage

### Key Template Files
- `template-media-kit.php` - Main media kit homepage template
- `template-speaker.php` - Speaking page with topics and booking
- `template-portfolio.php` - Portfolio gallery with filtering
- `template-press.php` - Media appearances and press mentions
- `template-resources.php` - Download center for media assets

### Theme Features
- Full Gutenberg block editor support
- Custom blocks for hero sections, timelines, stats, media logos
- Elementor compatibility with full-width templates
- Advanced Custom Fields integration for content management
- Responsive design with mobile-first approach
- Accessibility features (ARIA labels, keyboard navigation)
- SEO optimization with schema markup
- Masonry layouts for Books and Podcasts sections using Masonry.js
- Dynamic color system with rotating section backgrounds
- Glass-morphism design pattern for cards and containers
- SQLite database compatibility with custom fixes

### Customizer Options
The theme includes extensive customizer options organized into sections:
- Brand Settings (colors, typography)
- Hero Section (background, text, CTAs)
- Social Media (platform links)
- Contact Information
- SEO Settings

### Performance Considerations
- Lazy loading for images and videos
- Minified CSS/JS in production
- Optimized image sizes with custom dimensions
- Caching-friendly structure
- CDN compatibility

## Common Development Tasks

### Adding a New Custom Post Type
1. Register in `functions.php` using `register_post_type()`
2. Create single template: `single-{post-type}.php`
3. Create archive template: `archive-{post-type}.php`
4. Add to customizer if needed
5. Flush permalinks: Settings > Permalinks > Save

### Creating a New Page Template
1. Create file in theme root: `template-{name}.php`
2. Add template header comment
3. Include template parts as needed
4. Select template when creating page in WordPress

### Adding Custom Fields
1. Use ACF if available, define in `inc/acf-fields.php`
2. For native meta boxes, hook into `add_meta_boxes` action
3. Save data with proper sanitization
4. Display in templates with escaping

### Modifying Styles
1. **Modular CSS Architecture**: Styles are organized in `assets/css/` directories
   - Base styles: Variables, reset, typography in `assets/css/base/`
   - Components: Reusable UI elements in `assets/css/components/`
   - Sections: Page section-specific styles in `assets/css/sections/`
2. Main `style.css` uses `@import` to load all modules
3. Use CSS custom properties for theming (defined in `assets/css/base/variables.css`)
4. Follow BEM naming convention: `.mkp-component__element--modifier`
5. Ensure mobile-first responsive design
6. **Card Pattern**: All card-like elements (blog cards, sidebar, comments, etc.) should use the `.mkp-card` base class for consistent glass-morphism effect
7. **Color Inheritance**: Use `color: inherit` and `opacity` modifiers instead of hardcoded colors to respect dynamic section colors

### Adding Customizer Live Preview
When adding new sections with customizer controls that should update live:

1. **Set transport to postMessage** in the customizer setting:
```php
$wp_customize->add_setting( 'mkp_field_name', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage', // Enable live preview
) );
```

2. **Add JavaScript handlers** in `assets/js/customizer-live-preview.js`:
```javascript
// Example for a simple text field
wp.customize( 'mkp_field_name', function( value ) {
    value.bind( function( to ) {
        $( '.target-element' ).text( to );
    } );
} );
```

3. **Use the centralized pattern** for card-based sections:
```javascript
setupCardSectionUpdates({
    sectionPrefix: 'mkp_example_',
    sectionClass: 'mkp-example-section',
    cardClass: 'mkp-example-card',
    maxItems: 6,
    fields: [
        {
            name: 'title',
            updateFn: function( $card, value ) {
                $card.find( '.mkp-example-card__title' ).text( value );
            }
        },
        {
            name: 'description',
            updateFn: function( $card, value ) {
                const formatted = '<p>' + value.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br />') + '</p>';
                $card.find( '.mkp-example-card__description' ).html( formatted );
            }
        }
    ]
});
```

4. **Ensure proper DOM structure** with consistent class naming:
   - Section: `.mkp-{section}-section`
   - Cards: `.mkp-{item}-card.mkp-{item}--{number}`
   - Elements: `.mkp-{item}-card__{element}`

## Security Best Practices
- Escape all output: `esc_html()`, `esc_attr()`, `esc_url()`
- Sanitize all input: `sanitize_text_field()`, `wp_kses_post()`
- Use nonces for forms: `wp_nonce_field()`, `check_admin_referer()`
- Validate capabilities: `current_user_can()`

## Debugging
- Enable `WP_DEBUG` in `wp-config.php`
- Check error logs in `/wp-content/debug.log`
- Use Query Monitor plugin for performance analysis
- Test with Theme Check plugin before deployment

## Development Philosophy
- **"Less is More"**: Avoid unnecessary complexity in code. When faced with a choice, prefer the simpler solution that accomplishes the goal.
- **Consolidation**: Keep related functionality together. Avoid scattering similar styles or functionality across multiple files when they can be consolidated.
- **Maintainability First**: Write code that is easy to understand and maintain. Clear, simple code is better than clever, complex code.
- **CSS Inheritance**: Leverage CSS inheritance rather than explicit declarations. Remove redundant styles and let elements inherit from their parents.
- **Single Source of Truth**: Define styles, especially repeated patterns like glass-morphism effects, in one place rather than duplicating across multiple selectors.

## Development Memories
- Remember to use `./bump-version.sh` which automatically updates all version numbers (style.css, functions.php, version.json, and CSS cache busting parameters).
- Remember to ask me which build I'd like when I ask you to build.
- **CSS Architecture**: The theme uses a modular CSS architecture. The main `style.css` imports all modules from `assets/css/`. Never edit `style-old.css` as it contains the deprecated monolithic CSS.
- **Customizer Refactoring**: The customizer has been refactored from a single 1,861-line file into a modular structure under `inc/customizer/` with separate files for each section.
- **Glass-morphism Cards**: All cards use a unified glass-morphism effect defined in the base `.mkp-card` class for consistency and maintainability.
- **Deployment Process**: Use the deployment process documented in `DEPLOYMENT_PROCESS.md`. The theme now includes a `CHANGELOG.md` file in the mediakit-lite directory which is required for GitHub Actions auto-release.
- **Version Bumping**: ALWAYS use the ROOT `./bump-version.sh` script (NOT `mediakit-lite/bump-version.sh`). The root script automatically handles:
  - Version updates in `style.css`, `functions.php` (MKP_THEME_VERSION), and `version.json` files
  - CHANGELOG.md entry generation
  - **CSS Cache Busting**: Updates all `?ver=X.X.X` parameters in CSS `@import` statements to prevent browser caching issues
  - Git commit, tag creation, and push to trigger GitHub Actions release
  - Usage: `./bump-version.sh patch "Description of changes"` (or `minor`/`major` for bigger releases)
- **Media Grid Layout**: The media section uses CSS Grid instead of Masonry due to positioning conflicts with embedded content. Other sections (Books, Podcasts, Gallery, Awards) continue using Masonry for optimal content flow.
- **Universal Masonry Card Heights**: All masonry sections use shared `.mkp-masonry-card__description` class with 120px height limit, automatic read more/less functionality, and relayout integration. The universal system is managed by `masonry-cards.js` and shared CSS in `components/cards.css`.
- **Hybrid Layout Strategy**: The theme uses different layout approaches based on content type - CSS Grid for variable embedded content (media section) and Masonry for consistent card content (books, podcasts, awards, investors).

## Known Issues
- **Customizer Exit Behavior**: When exiting the WordPress Customizer without saving changes (clicking the X button), the theme may occasionally deactivate. This is an edge case related to how WordPress handles unsaved changesets. **Workaround**: Always save/publish your changes before exiting the Customizer. This ensures proper theme state persistence.