#!/bin/bash

# Build script for WordPress.org distribution
# This creates a clean version without update checker and development files

echo "Building MediaKit Lite for WordPress.org..."

# Get the current version from style.css
VERSION=$(grep "Version:" style.css | awk '{print $2}')
THEME_NAME="mediakit-lite"
BUILD_DIR="build"
DEST_DIR="$BUILD_DIR/${THEME_NAME}"
ZIP_NAME="${THEME_NAME}-${VERSION}-wordpress.zip"

# Clean previous build
echo "Cleaning previous build..."
rm -rf "$BUILD_DIR"
mkdir -p "$DEST_DIR"

# Copy files, excluding those in .distignore
echo "Copying theme files..."
rsync -av --exclude-from='.distignore' --exclude="$BUILD_DIR" . "$DEST_DIR/"

# Create zip file
echo "Creating zip file..."
cd "$BUILD_DIR"
zip -r "../$ZIP_NAME" "$THEME_NAME"
cd ..

# Clean up
echo "Cleaning up..."
rm -rf "$BUILD_DIR"

echo "✅ Build complete!"
echo "📦 Created: $ZIP_NAME"
echo "📋 Version: $VERSION"
echo ""
echo "This version is ready for WordPress.org submission."
echo "It excludes the update checker and other development files."