# Professional Color Theme System Implementation Plan

## Overview
Transform MediaKit Lite from individual color pickers (12+ decisions) to professional pre-defined color themes (1 decision).

## Current State
- 12 individual background color settings for sections
- Users must manually choose each color
- Risk of unprofessional combinations
- Complex customizer with many color options

## New System Design

### 1. Color Theme Structure
Each theme includes:
- **primary**: Header/Footer background
- **primary_text**: Header/Footer text color
- **section_1**: First section color in rotation
- **section_1_text**: Text color for section_1
- **section_2**: Second section color in rotation
- **section_2_text**: Text color for section_2
- **section_3**: Third section color in rotation
- **section_3_text**: Text color for section_3
- **accent_1**: Primary CTA/button color
- **accent_2**: Secondary CTA/button color
- **neutral_light**: Light backgrounds
- **neutral_dark**: Dark text/borders

### 2. Section Color Rotation
Sections rotate through 3 colors in order:
1. Hero → section_1
2. Bio → section_2
3. Companies → section_3
4. Books → section_1 (restart rotation)
5. Podcasts → section_2
6. Speaker Topics → section_3
7. In The Media → section_1
8. Media Questions → section_2
9. Investor → section_3
10. Contact → section_1

### 3. Files to Create

#### A. `/inc/color-themes.php`
```php
<?php
/**
 * Color Theme Definitions
 */

function mkp_get_color_themes() {
    return array(
        'ocean_depths' => array(
            'name' => __('Ocean Depths', 'mediakit-lite'),
            'primary' => '#0D47A1',
            'primary_text' => '#FFFFFF',
            'section_1' => '#1976D2',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E3F2FD',
            'section_2_text' => '#0D47A1',
            'section_3' => '#BBDEFB',
            'section_3_text' => '#0D47A1',
            'accent_1' => '#FF6F61',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#00ACC1',
            'accent_2_text' => '#FFFFFF',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#37474F',
            'border' => '#E0E0E0'
        ),
        'forest_journey' => array(
            'name' => __('Forest Journey', 'mediakit-lite'),
            'primary' => '#1B5E20',
            'primary_text' => '#FFFFFF',
            'section_1' => '#2E7D32',
            'section_1_text' => '#FFFFFF',
            'section_2' => '#E8F5E9',
            'section_2_text' => '#1B5E20',
            'section_3' => '#81C784',
            'section_3_text' => '#FFFFFF',
            'accent_1' => '#FF7043',
            'accent_1_text' => '#FFFFFF',
            'accent_2' => '#FDD835',
            'accent_2_text' => '#212121',
            'neutral_light' => '#FAFAFA',
            'neutral_dark' => '#263238',
            'border' => '#C8E6C9'
        ),
        // Add more themes...
    );
}

function mkp_get_theme_names() {
    $themes = mkp_get_color_themes();
    $names = array();
    foreach ($themes as $key => $theme) {
        $names[$key] = $theme['name'];
    }
    return $names;
}
```

#### B. `/inc/theme-color-manager.php`
```php
<?php
/**
 * Theme Color Management Functions
 */

function mkp_get_section_color($section_index) {
    $theme_key = get_theme_mod('mkp_color_theme', 'ocean_depths');
    $themes = mkp_get_color_themes();
    
    if (!isset($themes[$theme_key])) {
        $theme_key = 'ocean_depths';
    }
    
    $theme = $themes[$theme_key];
    $color_num = ($section_index % 3) + 1;
    
    return $theme['section_' . $color_num];
}

function mkp_get_section_text_color($section_index) {
    $theme_key = get_theme_mod('mkp_color_theme', 'ocean_depths');
    $themes = mkp_get_color_themes();
    
    if (!isset($themes[$theme_key])) {
        $theme_key = 'ocean_depths';
    }
    
    $theme = $themes[$theme_key];
    $color_num = ($section_index % 3) + 1;
    
    return $theme['section_' . $color_num . '_text'];
}

function mkp_get_theme_color($color_key) {
    $theme_key = get_theme_mod('mkp_color_theme', 'ocean_depths');
    $themes = mkp_get_color_themes();
    
    if (!isset($themes[$theme_key])) {
        $theme_key = 'ocean_depths';
    }
    
    return $themes[$theme_key][$color_key] ?? '#000000';
}
```

### 4. Files to Modify

#### A. `/inc/customizer.php`
**Remove:**
- All `mkp_*_background_color` settings and controls
- Primary, secondary, accent color settings

**Add:**
```php
// Color Theme Setting
$wp_customize->add_setting('mkp_color_theme', array(
    'default' => 'ocean_depths',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'refresh',
));

$wp_customize->add_control('mkp_color_theme', array(
    'type' => 'select',
    'section' => 'mkp_brand_settings',
    'label' => __('Color Theme', 'mediakit-lite'),
    'description' => __('Choose a professional color theme for your entire site', 'mediakit-lite'),
    'choices' => mkp_get_theme_names(),
    'priority' => 1,
));
```

#### B. Update All Section Templates
**Files to update:**
1. `/template-parts/front-page/hero.php` (index: 0)
2. `/template-parts/front-page/bio.php` (index: 1)
3. `/template-parts/front-page/corporations.php` (index: 2)
4. `/template-parts/front-page/books.php` (index: 3)
5. `/template-parts/front-page/podcasts.php` (index: 4)
6. `/template-parts/front-page/speaker-topics.php` (index: 5)
7. `/template-parts/front-page/in-the-media.php` (index: 6)
8. `/template-parts/front-page/media-questions.php` (index: 7)
9. `/template-parts/front-page/investor.php` (index: 8)
10. `/template-parts/front-page/contact.php` (index: 9)

**Change from:**
```php
$section_color = get_theme_mod('mkp_[section]_background_color', '#default');
```

**To:**
```php
$section_index = 0; // Change number for each section
$section_color = mkp_get_section_color($section_index);
$text_color = mkp_get_section_text_color($section_index);
```

**Add to section style:**
```php
style="background-color: <?php echo esc_attr($section_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
```

#### C. `/inc/customizer-dynamic-styles.php`
**Simplify to:**
```php
// Get current theme colors
$theme_colors = mkp_get_color_themes()[get_theme_mod('mkp_color_theme', 'ocean_depths')];

?>
<style>
/* Header & Navigation */
.mkp-header {
    background-color: <?php echo $theme_colors['primary']; ?>;
    color: <?php echo $theme_colors['primary_text']; ?>;
}

/* Footer */
.mkp-footer {
    background-color: <?php echo $theme_colors['primary']; ?>;
    color: <?php echo $theme_colors['primary_text']; ?>;
}

/* Primary Buttons */
.mkp-btn--primary {
    background-color: <?php echo $theme_colors['accent_1']; ?>;
    color: <?php echo $theme_colors['accent_1_text']; ?>;
}

/* Secondary Buttons */
.mkp-btn--secondary {
    background-color: <?php echo $theme_colors['accent_2']; ?>;
    color: <?php echo $theme_colors['accent_2_text']; ?>;
}

/* Links in sections inherit text color */
.mkp-section a {
    color: inherit;
    text-decoration: underline;
}

.mkp-section a:hover {
    opacity: 0.8;
}
</style>
<?php
```

### 5. Functions to Remove
- `mkp_get_contrast_color()`
- `mkp_get_contrast_color_rgba()`
- `mkp_is_light_color()`
- All individual section color customizer preview JS

### 6. Implementation Order
1. Create color-themes.php
2. Create theme-color-manager.php
3. Update functions.php to include new files
4. Remove color settings from customizer.php
5. Add theme selector to customizer.php
6. Update each section template (one at a time)
7. Simplify customizer-dynamic-styles.php
8. Test thoroughly

### 7. Testing Checklist
- [ ] Theme selector appears in customizer
- [ ] Changing theme updates all colors
- [ ] Section rotation works correctly
- [ ] Text contrast is readable in all themes
- [ ] Buttons use accent colors properly
- [ ] No PHP errors
- [ ] No JavaScript errors
- [ ] Mobile responsive check

## Next Steps After Memory Compaction
1. Start with creating the two new PHP files
2. Then tackle customizer.php changes
3. Update templates one by one
4. Finally update dynamic styles

This represents a complete overhaul of the color system, making it professional and foolproof.