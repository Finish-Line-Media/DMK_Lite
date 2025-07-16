# MediaKit Lite CSS Architecture

This directory contains the modular CSS architecture for MediaKit Lite theme. The styles have been refactored from a single 3,507-line file into organized, maintainable modules.

## Directory Structure

```
assets/css/
├── base/              # Foundation styles
│   ├── variables.css    # CSS custom properties
│   ├── reset.css        # CSS reset and box-sizing
│   ├── typography.css   # Base typography styles
│   ├── wordpress.css    # WordPress core styles
│   └── responsive.css   # Media queries and responsive utilities
├── layout/            # Layout utilities
│   ├── containers.css   # Container and section layouts
│   ├── grid.css        # Grid system utilities
│   └── utilities.css   # Glassmorphic effects
├── components/        # Reusable components
│   ├── header.css      # Site header
│   ├── navigation.css  # Navigation menu
│   ├── hero.css        # Hero section component
│   ├── buttons.css     # Button styles
│   ├── cards.css       # Card components
│   ├── forms.css       # Form elements
│   ├── footer.css      # Site footer
│   ├── blog.css        # Blog listing
│   ├── posts.css       # Single posts and archives
│   ├── comments.css    # Comments section
│   └── social.css      # Social media icons
└── sections/          # Page sections
    ├── about.css       # About section
    ├── books.css       # Books showcase
    ├── podcasts.css    # Podcast appearances
    ├── corporations.css # Corporate clients
    ├── speaker.css     # Speaking topics
    ├── in-the-media.css # Media appearances
    ├── media-questions.css # Interview questions
    ├── investor.css    # Investor section
    ├── gallery.css     # Image gallery
    └── contact.css     # Contact section
```

## Architecture Principles

1. **Modular Organization**: Each file has a single responsibility
2. **Component-Based**: Styles are organized by component/section
3. **BEM Naming**: Uses `.mkp-component__element--modifier` convention
4. **CSS Custom Properties**: Variables defined in `variables.css`
5. **Mobile-First**: Responsive styles use min-width media queries where applicable
6. **Performance**: Smaller files for better caching and faster parsing

## How It Works

The main `style-new.css` file uses `@import` statements to load all modules in the correct order:

1. Base styles (variables, reset, typography)
2. Layout utilities
3. Components (in dependency order)
4. Sections
5. WordPress-specific styles
6. Responsive overrides

## File Naming Convention

- `component-name.css` - For reusable components
- `section-name.css` - For specific page sections
- `utility-name.css` - For utility classes

## Customization

### Adding New Styles

1. Identify the appropriate category (base/layout/components/sections)
2. Create a new file following the naming convention
3. Add the `@import` statement to `style-new.css` in the appropriate section
4. Follow the existing patterns for consistency

### Modifying Existing Styles

1. Locate the specific module file
2. Make changes following the existing patterns
3. Test across different screen sizes
4. Ensure changes don't break other components

## Migration Notes

This architecture replaces the original monolithic `style.css` file. Key improvements:

- **Before**: 3,507 lines in a single file
- **After**: 30+ organized modules
- **Benefits**: Easier maintenance, better performance, clearer organization

## Best Practices

1. Keep modules focused and single-purpose
2. Use CSS custom properties for theming
3. Include responsive styles within each module
4. Comment complex sections
5. Follow the established naming conventions
6. Test changes across browsers and devices