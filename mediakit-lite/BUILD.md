# MediaKit Lite Build Process

This document explains how to build MediaKit Lite for different distribution channels.

## Overview

MediaKit Lite maintains a single codebase but can be built for two different distribution channels:

1. **WordPress.org** - Clean version without external update checker
2. **GitHub** - Full version with update checker for existing users

## Build Scripts

### Building for WordPress.org

```bash
./build-for-wordpress.sh
```

This creates a clean version that:
- Excludes the update checker (`inc/update-notice.php`)
- Removes development files (as specified in `.distignore`)
- Creates a zip file named `mediakit-lite-{version}-wordpress.zip`

### Building for GitHub

```bash
./build-for-github.sh
```

This creates the full version that:
- Includes all theme functionality including the update checker
- Excludes only development and build files
- Creates a zip file named `mediakit-lite-{version}.zip`

## The .distignore File

The `.distignore` file specifies which files should be excluded from the WordPress.org distribution. Key exclusions include:

- `inc/update-notice.php` - External update checker (not allowed on WordPress.org)
- Build scripts and documentation
- Version control files
- Development files

## Version Management

Both build scripts automatically read the version from `style.css`, ensuring consistency across builds.

## Distribution Process

### For WordPress.org
1. Run `./build-for-wordpress.sh`
2. Upload the generated `*-wordpress.zip` file to WordPress.org

### For GitHub
1. Run `./build-for-github.sh`
2. Create a new release on GitHub
3. Upload the generated zip file as a release asset
4. Name the asset exactly `mediakit-lite.zip` (the update checker looks for this)

## Important Notes

- The theme uses conditional file loading in `functions.php`, so it works correctly regardless of which files are present
- Always test both builds before distribution
- The WordPress.org version must not contain any external update checking code
- The GitHub version provides continuity for existing users during the WordPress.org review period