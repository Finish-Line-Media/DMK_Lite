#!/bin/bash

# MediaKit Lite Release Script
# This script helps prepare and create a new release

echo "MediaKit Lite Release Helper"
echo "============================"
echo ""

# Get current version from style.css
CURRENT_VERSION=$(grep "Version:" mediakit-lite/style.css | sed 's/Version: //' | xargs)
echo "Current version: $CURRENT_VERSION"
echo ""

# Ask for new version
read -p "Enter new version number (e.g., 1.2.3): " NEW_VERSION

# Validate version format
if ! [[ $NEW_VERSION =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
    echo "Error: Invalid version format. Please use X.Y.Z format."
    exit 1
fi

# Confirm version
echo ""
echo "You are about to release version $NEW_VERSION"
read -p "Continue? (y/n): " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Release cancelled."
    exit 1
fi

echo ""
echo "Updating version numbers..."

# Update version in style.css
sed -i.bak "s/Version: $CURRENT_VERSION/Version: $NEW_VERSION/" mediakit-lite/style.css
rm mediakit-lite/style.css.bak

# Update version in functions.php
sed -i.bak "s/define( 'MKP_THEME_VERSION', '$CURRENT_VERSION' );/define( 'MKP_THEME_VERSION', '$NEW_VERSION' );/" mediakit-lite/functions.php
rm mediakit-lite/functions.php.bak

echo "✓ Version numbers updated"

# Update CHANGELOG
echo ""
echo "Please update the CHANGELOG.md file with the changes for version $NEW_VERSION"
echo "Opening CHANGELOG.md..."
echo ""
echo "Add an entry like this at the top:"
echo ""
echo "## [$NEW_VERSION] - $(date +%Y-%m-%d)"
echo ""
echo "### Added"
echo "- New features..."
echo ""
echo "### Changed"
echo "- Changes..."
echo ""
echo "### Fixed"
echo "- Bug fixes..."
echo ""
read -p "Press enter when you've updated the CHANGELOG..."

# Create theme package
echo ""
echo "Creating theme package..."
./export-theme.sh

# Git operations
echo ""
echo "Preparing git commit..."
git add mediakit-lite/style.css mediakit-lite/functions.php mediakit-lite/CHANGELOG.md
git commit -m "Prepare release v$NEW_VERSION"

echo ""
echo "Creating git tag..."
git tag -a "v$NEW_VERSION" -m "Release version $NEW_VERSION"

echo ""
echo "Ready to push to GitHub!"
echo ""
echo "Next steps:"
echo "1. Push the commit and tag:"
echo "   git push origin main"
echo "   git push origin v$NEW_VERSION"
echo ""
echo "2. Go to GitHub and create a new release:"
echo "   https://github.com/Finish-Line-Media/DMK_Lite/releases/new"
echo ""
echo "3. Select tag: v$NEW_VERSION"
echo "4. Release title: MediaKit Lite v$NEW_VERSION"
echo "5. Describe the changes (copy from CHANGELOG.md)"
echo "6. Upload the mediakit-lite.zip file"
echo "7. Publish the release"
echo ""
echo "The GitHub Action will automatically attach the theme ZIP to the release!"