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
├── assets/              # CSS, JS, images
├── inc/                 # PHP includes
│   ├── customizer.php   # Theme customizer settings
│   ├── template-tags.php # Custom template functions
│   ├── blocks.php       # Gutenberg block registration
│   └── acf-fields.php   # ACF field configurations
├── template-parts/      # Reusable template components
├── templates/           # Page templates
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
1. Main styles in `style.css`
2. Use CSS custom properties for theming
3. Follow BEM naming convention: `.mkp-component__element--modifier`
4. Ensure mobile-first responsive design

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