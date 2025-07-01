# Media Query Analysis Report for style.css

## Summary

Total media queries found: **15**

### Breakpoint Usage Frequency

1. **max-width: 768px** - 7 occurrences (lines 592, 921, 1551, 1722, 2000, 2174, 2684)
2. **max-width: 767px** - 2 occurrences (lines 2120, 2358)
3. **max-width: 480px** - 2 occurrences (lines 1558, 1728)
4. **min-width: 769px and max-width: 1024px** - 1 occurrence (line 668)
5. **print** - 1 occurrence (line 684)
6. **prefers-contrast: high** - 1 occurrence (line 736)
7. **prefers-reduced-motion: reduce** - 1 occurrence (line 747)

### Key Inconsistency Found

**768px vs 767px Inconsistency**: The codebase uses both `max-width: 768px` and `max-width: 767px` for what appears to be the same breakpoint. This creates a 1px gap where neither media query applies.

## Detailed Analysis by Media Query

### 1. Line 592: `@media (max-width: 768px)` - Main Mobile Styles
**Styles included:**
- CSS custom properties adjustments
- Typography sizing (h1, h2, h3)
- Mobile navigation toggle display
- Navigation menu transformation to mobile layout
- Hero title sizing
- Footer grid to single column
- Search field responsive behavior

### 2. Line 668: `@media (min-width: 769px) and (max-width: 1024px)` - Tablet Styles
**Styles included:**
- Container padding adjustments
- Header inner padding for tablets

### 3. Line 684: `@media print` - Print Styles
**Styles included:**
- Hide header, footer, buttons, social links
- Typography adjustments for print
- Underline links
- Page break prevention after headings

### 4. Line 736: `@media (prefers-contrast: high)` - Accessibility
**Styles included:**
- High contrast color scheme adjustments
- Darker primary colors
- Enhanced borders

### 5. Line 747: `@media (prefers-reduced-motion: reduce)` - Accessibility
**Styles included:**
- Disable animations and transitions
- Set minimal animation durations
- Disable smooth scrolling

### 6. Line 921: `@media (max-width: 768px)` - Contact Form Mobile
**Styles included:**
- Contact form padding reduction
- Form row to column layout
- Inline form adjustments

### 7. Line 1551: `@media (max-width: 768px)` - Speaker Topics Mobile
**Styles included:**
- Speaker topics grid adjustments (4 and 6 count layouts to 2 columns)

### 8. Line 1558: `@media (max-width: 480px)` - Speaker Topics Small Mobile
**Styles included:**
- Speaker topics to single column

### 9. Line 1722: `@media (max-width: 768px)` - Corporations Mobile
**Styles included:**
- Corporations grid max-width adjustment

### 10. Line 1728: `@media (max-width: 480px)` - Corporations Small Mobile
**Styles included:**
- Corporations grid max-width further reduction
- Card padding adjustments

### 11. Line 2000: `@media (max-width: 768px)` - Landing Page Mobile
**Styles included:**
- Hero name font size
- Hero wrapper to column layout
- Hero images sizing and positioning
- Podcast content to single column
- Speaker topics to single column
- Investor lanes to single column
- Contact info to single column
- Book/podcast card covers height reduction
- Grids to single column

### 12. Line 2120: `@media (max-width: 767px)` - Media Grid Mobile
**Styles included:**
- Media grid to single column
- Gap adjustments

**⚠️ INCONSISTENCY: Uses 767px instead of 768px**

### 13. Line 2174: `@media (max-width: 768px)` - Blog Grid Mobile
**Styles included:**
- Blog grid to single column
- Gap adjustments

### 14. Line 2358: `@media (max-width: 767px)` - Blog Header Mobile
**Styles included:**
- Blog header title font size
- Blog grid to single column
- Blog card title font size

**⚠️ INCONSISTENCY: Uses 767px instead of 768px**

### 15. Line 2684: `@media (max-width: 768px)` - Single Post Mobile
**Styles included:**
- Comments area padding
- Comment padding
- Entry title font size
- Entry content font size
- Author bio layout changes
- Post navigation to single column

## Recommendations for Consolidation

1. **Fix the 767px/768px inconsistency**: Standardize on `max-width: 768px` throughout
2. **Consolidate the seven `max-width: 768px` queries** into fewer, organized sections
3. **Consider organizing media queries by feature** rather than scattered throughout
4. **Create a consistent breakpoint system** such as:
   - Mobile: max-width: 768px
   - Small mobile: max-width: 480px
   - Tablet: min-width: 769px and max-width: 1024px
   - Desktop: min-width: 1025px (implicit)

## Proposed Consolidation Structure

```css
/* Mobile Styles - max-width: 768px */
@media (max-width: 768px) {
  /* Base mobile adjustments */
  /* Navigation */
  /* Typography */
  /* Layout components */
  /* Forms */
  /* Blog */
  /* Landing page sections */
}

/* Small Mobile - max-width: 480px */
@media (max-width: 480px) {
  /* Further mobile adjustments */
}

/* Tablet - min-width: 769px and max-width: 1024px */
@media (min-width: 769px) and (max-width: 1024px) {
  /* Tablet-specific styles */
}

/* Accessibility media queries */
@media (prefers-contrast: high) { }
@media (prefers-reduced-motion: reduce) { }

/* Print styles */
@media print { }
```