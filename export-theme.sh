#!/bin/bash

# MediaKit Pro Theme Export Script
# This script creates a properly named theme ZIP file for updates

echo "MediaKit Pro Theme Export Script"
echo "================================"

# Get the directory of this script
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
THEME_DIR="$SCRIPT_DIR/mediakit-pro"
OUTPUT_FILE="$SCRIPT_DIR/mediakit-pro.zip"

# Check if theme directory exists
if [ ! -d "$THEME_DIR" ]; then
    echo "Error: Theme directory not found at $THEME_DIR"
    exit 1
fi

# Remove old zip if exists
if [ -f "$OUTPUT_FILE" ]; then
    echo "Removing old mediakit-pro.zip..."
    rm "$OUTPUT_FILE"
fi

# Create new zip file
echo "Creating mediakit-pro.zip..."
cd "$THEME_DIR"
zip -r "$OUTPUT_FILE" . \
    -x "*.DS_Store" \
    -x "__MACOSX/*" \
    -x ".git/*" \
    -x ".gitignore" \
    -x "node_modules/*" \
    -x "*.log" \
    -x "version-sample.json"

# Check if successful
if [ -f "$OUTPUT_FILE" ]; then
    # Get file size
    SIZE=$(du -h "$OUTPUT_FILE" | cut -f1)
    echo ""
    echo "✅ Success! Theme exported to:"
    echo "   $OUTPUT_FILE"
    echo "   Size: $SIZE"
    echo ""
    echo "📋 Next steps:"
    echo "   1. Upload this file to WordPress"
    echo "   2. Remember to delete the old theme first"
    echo "   3. Or upload to your update server"
else
    echo "❌ Error: Failed to create ZIP file"
    exit 1
fi