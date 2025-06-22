#!/bin/bash

# MediaKit Lite Release Script
# This script creates a ZIP file and instructions for GitHub release

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}MediaKit Lite Release Creator${NC}"
echo "================================"

# Get the current version from style.css
VERSION=$(grep "Version:" mediakit-lite/style.css | sed 's/Version: //' | tr -d '[:space:]')

if [ -z "$VERSION" ]; then
    echo -e "${RED}Error: Could not find version in style.css${NC}"
    exit 1
fi

echo -e "Current version: ${YELLOW}$VERSION${NC}"

# Create a clean copy of the theme
echo -e "\n${GREEN}Creating clean theme copy...${NC}"
rm -rf mediakit-lite-temp
cp -r mediakit-lite mediakit-lite-temp

# Remove unnecessary files
echo -e "${GREEN}Removing development files...${NC}"
cd mediakit-lite-temp
rm -rf .git .gitignore .DS_Store
rm -f REFACTORING-SUMMARY.md
cd ..

# Create the ZIP file
echo -e "${GREEN}Creating ZIP file...${NC}"
zip -r mediakit-lite.zip mediakit-lite-temp -x "*.DS_Store"
mv mediakit-lite.zip mediakit-lite-v${VERSION}.zip

# Clean up
rm -rf mediakit-lite-temp

echo -e "\n${GREEN}✓ Release ZIP created: mediakit-lite-v${VERSION}.zip${NC}"

# Create release notes
echo -e "\n${GREEN}Creating release notes...${NC}"
cat > release-notes-v${VERSION}.md << EOF
# MediaKit Lite v${VERSION}

## Installation
1. Download \`mediakit-lite.zip\` from the assets below
2. In WordPress admin, go to Appearance > Themes > Add New > Upload Theme
3. Choose the downloaded ZIP file and click Install Now
4. Activate the theme

## What's New
Check the [CHANGELOG.md](https://github.com/Finish-Line-Media/DMK_Lite/blob/main/mediakit-lite/CHANGELOG.md) for details.

## Requirements
- WordPress 5.8 or higher
- PHP 7.4 or higher

## Support
Report issues at: https://github.com/Finish-Line-Media/DMK_Lite/issues
EOF

echo -e "${GREEN}✓ Release notes created: release-notes-v${VERSION}.md${NC}"

echo -e "\n${YELLOW}Next Steps:${NC}"
echo "1. Go to: https://github.com/Finish-Line-Media/DMK_Lite/releases/new"
echo "2. Create a new tag: v${VERSION}"
echo "3. Release title: MediaKit Lite v${VERSION}"
echo "4. Copy contents of release-notes-v${VERSION}.md to the description"
echo "5. Attach these files:"
echo "   - mediakit-lite-v${VERSION}.zip (rename to mediakit-lite.zip when uploading)"
echo "6. Publish the release"
echo ""
echo -e "${YELLOW}IMPORTANT:${NC} The ZIP file MUST be named 'mediakit-lite.zip' when attached to the release!"