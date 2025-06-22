# Release Process for MediaKit Lite

This document outlines the process for creating new releases of the MediaKit Lite theme.

## Overview

MediaKit Lite uses GitHub Releases to distribute updates. Users receive update notifications directly in their WordPress admin panel.

## Version Numbering

We follow Semantic Versioning (SemVer):
- **MAJOR.MINOR.PATCH** (e.g., 1.2.3)
- **MAJOR**: Breaking changes
- **MINOR**: New features (backwards compatible)
- **PATCH**: Bug fixes

## Release Process

### 1. Prepare the Release

Use the release helper script:
```bash
./release.sh
```

This script will:
- Update version numbers in `style.css` and `functions.php`
- Prompt you to update the CHANGELOG
- Create the theme ZIP package
- Create a git commit and tag

### 2. Manual Steps

If not using the script, manually:

1. Update version in `mediakit-lite/style.css`
2. Update version in `mediakit-lite/functions.php` (MKP_THEME_VERSION)
3. Update `mediakit-lite/CHANGELOG.md`
4. Run `./export-theme.sh` to create the ZIP
5. Commit changes: `git commit -m "Prepare release vX.Y.Z"`
6. Create tag: `git tag -a vX.Y.Z -m "Release version X.Y.Z"`

### 3. Push to GitHub

```bash
git push origin main
git push origin vX.Y.Z
```

### 4. Create GitHub Release

1. Go to: https://github.com/Finish-Line-Media/DMK_Lite/releases/new
2. Choose your tag (vX.Y.Z)
3. Release title: `MediaKit Lite vX.Y.Z`
4. Description: Copy relevant section from CHANGELOG.md
5. Mark as pre-release if applicable
6. Publish release

The GitHub Action will automatically:
- Build the theme ZIP
- Attach it to the release
- Update `version.json` in the repository

## Update Distribution

Users will receive update notifications through:

1. **Admin Notices**: Dashboard notification when update available
2. **Themes Page**: Update indicator on theme card
3. **Direct Download**: Link to download the latest version

## Testing Updates

To test the update system:

1. Install an older version of the theme
2. Check WordPress admin for update notifications
3. Verify download links work correctly
4. Test the update process

## Pre-releases

For beta/test releases:
- Mark as "pre-release" on GitHub
- These won't show to regular users
- Developers can enable with: `add_filter('mkp_show_prerelease_updates', '__return_true');`

## Rollback

If issues are found:
1. Delete the problematic release on GitHub
2. Fix the issues
3. Create a new release with the same or incremented version

## Version History

All releases are maintained at:
https://github.com/Finish-Line-Media/DMK_Lite/releases