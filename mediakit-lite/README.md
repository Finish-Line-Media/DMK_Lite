# MediaKit Lite - WordPress Theme

A professional WordPress theme designed for individual digital media kits that showcases multiple professional facets, emphasizes storytelling, and provides easy media access to booking agents and journalists.

## Features

- **No Plugin Dependencies**: Built with native WordPress functionality - no ACF required!
- **5 Custom Post Types**: Speaking Topics, Media Appearances, Portfolio Items, Testimonials, Press Mentions
- **5 Page Templates**: Media Kit Homepage, Speaker Page, Portfolio Gallery, Press/Media, Download Center
- **Custom Gutenberg Blocks**: Hero sections, timelines, stats counters, media logos, video sections
- **Responsive Design**: Mobile-first approach with full accessibility support
- **Theme Customizer**: Extensive options for colors, typography, social links, and more
- **Performance Optimized**: Lazy loading, minification ready, CDN compatible

## Installation

1. Upload the `mediakit-lite` folder to `/wp-content/themes/`
2. Activate the theme through the 'Themes' menu in WordPress
3. Navigate to **Appearance > Customize** to configure your theme
4. Visit **Media Kit** in the admin menu to access theme-specific settings

## Getting Started

### 1. Configure Your Brand
- Go to **Appearance > Customize > Brand Settings**
- Set your primary and secondary colors
- Choose your typography preferences
- Upload your logo

### 2. Set Up Global Media Kit Information
- Navigate to **Media Kit > Media Kit Settings**
- Upload professional headshots
- Add your bio (short and long versions)
- List key achievements
- Specify what you're available for

### 3. Add Your Content

#### Speaking Topics
- Go to **Speaking Topics > Add New**
- Enter your topic title and description
- Fill in the custom fields:
  - Target Audience
  - Duration
  - Key Takeaways (minimum 3)

#### Media Appearances
- Go to **Media Appearances > Add New**
- Add appearance details:
  - Date
  - Media outlet name
  - Embed URL for video/audio
  - External link to original content

#### Portfolio Items
- Go to **Portfolio > Add New**
- Upload project images
- Add project details:
  - Project date
  - Client name
  - Project URL

#### Testimonials
- Go to **Testimonials > Add New**
- Add the testimonial quote
- Include author details:
  - Name (required)
  - Title/Position
  - Company
  - Photo
  - Rating (1-5 stars)

#### Press Mentions
- Go to **Press Mentions > Add New**
- Add publication details:
  - Publication name
  - Article title
  - Publication date
  - Article link
  - Pull quote
  - Publication logo

### 4. Create Your Pages

Use the custom page templates for different sections:

1. **Media Kit Homepage Template**
   - Create a new page
   - Select "Media Kit Homepage" template
   - This creates a full-featured landing page

2. **Speaker Page Template**
   - Showcases all speaking topics
   - Includes booking information
   - Displays speaking statistics

3. **Portfolio Gallery Template**
   - Visual grid of portfolio items
   - Filterable by category
   - Hover effects and lightbox ready

4. **Press/Media Template**
   - Displays media appearances
   - Shows press mentions
   - Features media outlet logos

5. **Download Center Template**
   - Central location for downloadable assets
   - Professional photos
   - One-sheet PDFs
   - Brand guidelines

## Custom Fields Without ACF

This theme uses native WordPress meta boxes instead of ACF. All custom fields are:
- Properly sanitized and validated
- Easy to use with intuitive interfaces
- Include repeater functionality for dynamic content
- Support media uploads and galleries

### For Developers

Access custom field values using standard WordPress functions:

```php
// Get a simple field
$value = get_post_meta( $post_id, '_mkp_field_name', true );

// Get repeater field
$items = get_post_meta( $post_id, '_mkp_repeater_field', true );
if ( ! empty( $items ) ) {
    foreach ( $items as $item ) {
        echo $item;
    }
}

// Get option values
$option = get_option( 'mkp_option_name' );
```

The theme includes ACF-compatible helper functions if you prefer that syntax:

```php
// ACF-style functions (work without ACF installed)
$value = get_field( 'field_name' );
the_field( 'field_name' );

// For option pages
$option = get_field( 'option_name', 'option' );
```

## Theme Customization

### Colors & Typography
- Navigate to **Appearance > Customize**
- Modify colors, fonts, and spacing
- Changes preview in real-time

### Custom CSS
- Use **Appearance > Customize > Additional CSS**
- Or create a child theme for extensive modifications

### Template Overrides
- Copy template files to a child theme
- Modify as needed while preserving updates

## Performance Tips

1. **Optimize Images**
   - Use appropriate image sizes
   - Theme includes custom image sizes for different contexts
   - Enable lazy loading (built-in)

2. **Caching**
   - Compatible with all major caching plugins
   - Includes proper cache headers

3. **CDN Ready**
   - All assets use relative URLs
   - Compatible with CDN plugins

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Accessibility

- WCAG 2.1 AA compliant
- Keyboard navigation support
- Screen reader optimized
- High contrast mode compatible
- Skip links included

## Support

For support, please:
1. Check the theme documentation
2. Review common issues in the FAQ
3. Contact support with detailed information

## License

GPL v2 or later

## Credits

- Built on WordPress best practices
- Uses native WordPress functionality
- No premium plugin dependencies
- Designed for performance and accessibility