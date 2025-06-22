#!/bin/bash

# Check if version is provided
if [ -z "$1" ]; then
    echo "Usage: $0 <version>"
    echo "Example: $0 1.5.0"
    exit 1
fi

VERSION=$1

echo "Creating release for MediaKit Lite v${VERSION}"
echo ""
echo "Steps to create the release manually:"
echo ""
echo "1. Go to: https://github.com/Finish-Line-Media/DMK_Lite/releases/new"
echo ""
echo "2. Fill in the following:"
echo "   - Tag: v${VERSION}"
echo "   - Target: main"
echo "   - Release title: MediaKit Lite v${VERSION}"
echo ""
echo "3. Copy this release description:"
echo "----------------------------------------"
cat << EOF
# MediaKit Lite v${VERSION}

## 📥 Installation
1. Download **mediakit-lite.zip** from the assets below
2. In WordPress admin, go to **Appearance > Themes > Add New > Upload Theme**
3. Choose the downloaded ZIP file and click **Install Now**
4. Activate the theme

## 🎉 What's New

### Version ${VERSION}
- Fixed Speaking Topics section dynamic updates
- Fixed Companies section dynamic heading (Company/Companies)
- Improved customizer live preview functionality
- Fixed GitHub Actions workflow for automated releases

## 📋 Requirements
- WordPress 5.8 or higher
- PHP 7.4 or higher

## 🆘 Support
- Report issues: https://github.com/Finish-Line-Media/DMK_Lite/issues
- Documentation: https://github.com/Finish-Line-Media/DMK_Lite#readme
EOF
echo "----------------------------------------"
echo ""
echo "4. Attach the file: mediakit-lite-v${VERSION}.zip"
echo ""
echo "5. Click 'Publish release'"
echo ""

if [ -f "mediakit-lite-v${VERSION}.zip" ]; then
    echo "✓ ZIP file found: mediakit-lite-v${VERSION}.zip"
else
    echo "⚠️  ZIP file not found. Creating it now..."
    # Create the ZIP
    mkdir -p build/mediakit-lite
    rsync -av --exclude='.git' --exclude='.github' --exclude='.gitignore' \
      --exclude='*.md' --exclude='.DS_Store' --exclude='build' \
      --exclude='bump-version.sh' --exclude='node_modules' --exclude='create-release.sh' \
      ./ build/mediakit-lite/
    cd build
    zip -r mediakit-lite.zip mediakit-lite -x "*.DS_Store" "*.git*"
    mv mediakit-lite.zip ../mediakit-lite-v${VERSION}.zip
    cd ..
    rm -rf build
    echo "✓ Created: mediakit-lite-v${VERSION}.zip"
fi