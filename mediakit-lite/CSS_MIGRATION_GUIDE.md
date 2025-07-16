# CSS Migration Guide

## Overview
The MediaKit Lite theme has been updated to use a modular CSS architecture. The original 3,507-line `style.css` file has been refactored into organized modules located in `assets/css/`.

## Current Status
- **Active CSS File**: `style-modular.css` (loads all CSS modules via @import)
- **Legacy CSS File**: `style.css` (kept for reference, not actively used)
- **CSS Modules**: Located in `assets/css/` directory

## Changes Made
1. Updated `functions.php` to enqueue `style-modular.css` instead of `style.css`
2. Created 30+ organized CSS modules in `assets/css/`
3. Added comprehensive documentation in `assets/css/README.md`

## Testing Checklist
- [ ] All pages display correctly
- [ ] Responsive design works on mobile/tablet
- [ ] Theme customizer options apply correctly
- [ ] No console errors
- [ ] Performance is same or better

## Rollback Instructions
If issues arise, you can rollback by:
1. Edit `functions.php` line 87
2. Change: `wp_enqueue_style( 'mediakit-lite-style', MKP_THEME_URI . '/style-modular.css', array(), MKP_THEME_VERSION );`
3. To: `wp_enqueue_style( 'mediakit-lite-style', get_stylesheet_uri(), array(), MKP_THEME_VERSION );`

## Next Steps
Once testing is complete and the new architecture is verified:
1. Delete the old `style.css` file
2. Consider renaming `style-modular.css` to `style.css`
3. Update any documentation references

## Benefits
- **Maintainability**: Easier to find and update specific styles
- **Performance**: Better browser caching with smaller files
- **Organization**: Clear structure with BEM naming
- **Scalability**: Easy to add new components/sections