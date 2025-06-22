#!/bin/bash

# Update all PHP files from MediaKit Pro to MediaKit Lite
echo "Updating theme name from MediaKit Pro to MediaKit Lite..."

# Directory containing the theme
THEME_DIR="/Users/nathanielholzmann/Documents/Projects/DMK-Theme/mediakit-pro"

# Find and update all PHP files
find "$THEME_DIR" -name "*.php" -type f | while read -r file; do
    # Skip git directories
    if [[ "$file" == *".git"* ]]; then
        continue
    fi
    
    # Create a temporary file
    temp_file=$(mktemp)
    
    # Replace all occurrences
    sed -e "s/MediaKit Pro/MediaKit Lite/g" \
        -e "s/MediaKit_Pro/MediaKit_Lite/g" \
        -e "s/'mediakit-pro'/'mediakit-lite'/g" \
        -e "s/\"mediakit-pro\"/\"mediakit-lite\"/g" \
        -e "s/mediakit-pro\//mediakit-lite\//g" \
        "$file" > "$temp_file"
    
    # Only update if changes were made
    if ! cmp -s "$file" "$temp_file"; then
        mv "$temp_file" "$file"
        echo "Updated: $file"
    else
        rm "$temp_file"
    fi
done

echo "Theme name update complete!"