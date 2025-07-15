# MediaKit Lite CSS Architecture

## Overview
This directory contains the modularized CSS for MediaKit Lite theme. The CSS has been split into logical modules for better maintainability, performance, and development experience.

## Directory Structure

```
assets/css/
├── base/           # Foundation styles
│   ├── variables.css    # CSS custom properties
│   ├── reset.css        # CSS reset/normalize
│   └── typography.css   # Base typography styles
├── layout/         # Layout components
│   ├── containers.css   # Container and section layouts
│   └── grid.css         # Grid systems
├── components/     # Reusable UI components
│   ├── header.css       # Site header
│   ├── navigation.css   # Main navigation
│   ├── cards.css        # Card components
│   ├── buttons.css      # Button styles
│   └── forms.css        # Form elements
├── sections/       # Page section styles
│   ├── gallery.css      # Image gallery section
│   ├── books.css        # Books section
│   ├── podcasts.css     # Podcasts section
│   └── ...              # Other sections
└── responsive/     # Media queries
    ├── mobile.css       # Mobile styles (≤768px)
    └── tablet.css       # Tablet styles (769px-1024px)
```

## Benefits of Modular Architecture

1. **Maintainability**: Find and update styles quickly
2. **Performance**: Load only necessary styles
3. **Development**: Less merge conflicts, easier collaboration
4. **Debugging**: Isolated modules are easier to debug
5. **Scalability**: Add new features without bloating existing files

## Usage

The main `style.css` file imports all modules in the correct order using `@import` statements. This maintains WordPress theme compatibility while providing modular development.

## Adding New Modules

1. Create a new CSS file in the appropriate directory
2. Add the `@import` statement to `style.css` in the correct section
3. Follow the existing naming conventions and structure

## Naming Conventions

- Files: `kebab-case.css`
- Classes: BEM methodology `.mkp-component__element--modifier`
- CSS Variables: `--mkp-category-property`

## Migration Status

- [x] Base styles (variables, reset, typography)
- [x] Layout (containers)
- [x] Header component
- [x] Navigation component
- [x] Gallery section
- [ ] Hero section
- [ ] Books section
- [ ] Other sections...
- [ ] Responsive styles consolidation