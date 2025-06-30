#!/bin/bash

# Build script for GitHub distribution
# This creates the full version with update checker for existing users

echo "Building MediaKit Lite for GitHub..."

# Get the current version from style.css
VERSION=$(grep "Version:" style.css | awk '{print $2}')
THEME_NAME="mediakit-lite"
BUILD_DIR="build"
DEST_DIR="$BUILD_DIR/${THEME_NAME}"
ZIP_NAME="${THEME_NAME}-${VERSION}.zip"

# Clean previous build
echo "Cleaning previous build..."
rm -rf "$BUILD_DIR"
mkdir -p "$DEST_DIR"

# Copy all theme files except build artifacts
echo "Copying theme files..."
rsync -av \
    --exclude='.git' \
    --exclude='.gitignore' \
    --exclude='.gitattributes' \
    --exclude='build/' \
    --exclude='*.sh' \
    --exclude='.DS_Store' \
    --exclude='Thumbs.db' \
    --exclude='*.log' \
    --exclude='CLAUDE.md' \
    --exclude='CLAUDE.local.md' \
    --exclude='DEPLOYMENT_PROCESS.md' \
    --exclude='BUILD.md' \
    . "$DEST_DIR/"

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
echo "This is the full version with update checker for GitHub releases."
echo "Upload this file as a release asset on GitHub."