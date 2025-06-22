#!/bin/bash

# MediaKit Pro Theme Export Script
# This script creates a consistent export of the theme

# Get the directory where the script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PARENT_DIR="$(dirname "$SCRIPT_DIR")"

# Theme directory name
THEME_DIR="mediakit-pro"

# Change to parent directory
cd "$PARENT_DIR"

# Remove old zip if exists
if [ -f "$THEME_DIR.zip" ]; then
    rm "$THEME_DIR.zip"
fi

# Create the zip file
# Exclude development files, hidden files, and this script
zip -r "$THEME_DIR.zip" "$THEME_DIR" \
    -x "*.DS_Store" \
    -x "*/.git/*" \
    -x "*/.gitignore" \
    -x "*/node_modules/*" \
    -x "*/package.json" \
    -x "*/package-lock.json" \
    -x "*/composer.json" \
    -x "*/composer.lock" \
    -x "*/vendor/*" \
    -x "*.map" \
    -x "*/export-theme.sh" \
    -x "*/.vscode/*" \
    -x "*/.idea/*" \
    -x "*/tests/*" \
    -x "*/.phpunit.result.cache"

echo "Theme exported successfully as $THEME_DIR.zip"
echo "Location: $PARENT_DIR/$THEME_DIR.zip"