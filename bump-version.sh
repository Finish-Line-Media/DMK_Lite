#!/bin/bash

# MediaKit Lite Version Bump Script
# This script updates version numbers and triggers automated release

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}MediaKit Lite Version Bump Tool${NC}"
echo "================================="

# Function to display usage
usage() {
    echo -e "\nUsage: $0 [major|minor|patch] \"changelog message\""
    echo -e "\nExamples:"
    echo -e "  $0 patch \"Fixed critical error in customizer\""
    echo -e "  $0 minor \"Added new social media features\""
    echo -e "  $0 major \"Complete theme redesign\""
    exit 1
}

# Check arguments
if [ $# -lt 2 ]; then
    usage
fi

BUMP_TYPE=$1
CHANGELOG_MESSAGE=$2

# Validate bump type
if [[ ! "$BUMP_TYPE" =~ ^(major|minor|patch)$ ]]; then
    echo -e "${RED}Error: Invalid version bump type. Use major, minor, or patch${NC}"
    usage
fi

# Safety check: Check for uncommitted changes
if ! git diff --quiet || ! git diff --cached --quiet; then
    echo -e "${YELLOW}Warning: You have uncommitted changes:${NC}"
    echo ""
    git status --short
    echo ""

    CHANGED_FILES=$(git diff --name-only)
    STAGED_FILES=$(git diff --cached --name-only)

    if [ ! -z "$CHANGED_FILES" ]; then
        echo -e "${YELLOW}Modified files:${NC}"
        echo "$CHANGED_FILES" | sed 's/^/  /'
        echo ""
    fi

    if [ ! -z "$STAGED_FILES" ]; then
        echo -e "${YELLOW}Staged files:${NC}"
        echo "$STAGED_FILES" | sed 's/^/  /'
        echo ""
    fi

    echo -e "${RED}Error: Please commit your changes before bumping the version.${NC}"
    echo ""
    echo "You can either:"
    echo "  1. Commit your changes: git add . && git commit -m 'Your message'"
    echo "  2. Stash your changes: git stash"
    echo "  3. Discard your changes: git checkout -- ."
    echo ""
    exit 1
fi

# Safety check: Verify we're on the main branch
CURRENT_BRANCH=$(git branch --show-current)
if [ "$CURRENT_BRANCH" != "main" ]; then
    echo -e "${YELLOW}Warning: You are on branch '$CURRENT_BRANCH', not 'main'.${NC}"
    read -p "Do you want to continue? (y/N) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Get current version
CURRENT_VERSION=$(grep "Version:" mediakit-lite/style.css | sed 's/.*Version: //' | tr -d '[:space:]')

if [ -z "$CURRENT_VERSION" ]; then
    echo -e "${RED}Error: Could not find current version${NC}"
    exit 1
fi

echo -e "Current version: ${YELLOW}$CURRENT_VERSION${NC}"

# Parse version components
IFS='.' read -r -a VERSION_PARTS <<< "$CURRENT_VERSION"
MAJOR="${VERSION_PARTS[0]}"
MINOR="${VERSION_PARTS[1]}"
PATCH="${VERSION_PARTS[2]}"

# Increment version based on type
case $BUMP_TYPE in
    major)
        MAJOR=$((MAJOR + 1))
        MINOR=0
        PATCH=0
        ;;
    minor)
        MINOR=$((MINOR + 1))
        PATCH=0
        ;;
    patch)
        PATCH=$((PATCH + 1))
        ;;
esac

NEW_VERSION="$MAJOR.$MINOR.$PATCH"
echo -e "New version: ${GREEN}$NEW_VERSION${NC}"

# Update version in all files
echo -e "\n${BLUE}Updating version numbers...${NC}"

# Update style.css
sed -i.bak "s/Version: .*/Version: $NEW_VERSION/" mediakit-lite/style.css && rm mediakit-lite/style.css.bak
echo -e "${GREEN}✓${NC} Updated style.css"

# Update all CSS @import version parameters for cache busting
sed -i.bak "s/?ver=[0-9.]*/?ver=$NEW_VERSION/g" mediakit-lite/style.css && rm mediakit-lite/style.css.bak
echo -e "${GREEN}✓${NC} Updated CSS import versions for cache busting"

# Update functions.php
sed -i.bak "s/define( 'MKP_THEME_VERSION', '.*' );/define( 'MKP_THEME_VERSION', '$NEW_VERSION' );/" mediakit-lite/functions.php && rm mediakit-lite/functions.php.bak
echo -e "${GREEN}✓${NC} Updated functions.php"

# Update version.json
cat > mediakit-lite/version.json << EOF
{
    "version": "$NEW_VERSION",
    "description": "$CHANGELOG_MESSAGE",
    "download_url": "https://github.com/Finish-Line-Media/DMK_Lite/releases/latest/download/mediakit-lite.zip",
    "changelog_url": "https://github.com/Finish-Line-Media/DMK_Lite/blob/main/CHANGELOG.md",
    "release_date": "$(date +%Y-%m-%d)",
    "min_wp_version": "5.8",
    "tested_up_to": "6.5",
    "php_version": "7.4"
}
EOF
echo -e "${GREEN}✓${NC} Updated version.json"

# Update root version.json if it exists
if [ -f "version.json" ]; then
    cat > version.json << EOF
{
  "version": "$NEW_VERSION",
  "description": "$CHANGELOG_MESSAGE",
  "download_url": "https://github.com/Finish-Line-Media/DMK_Lite/releases/download/v$NEW_VERSION/mediakit-lite.zip",
  "changelog_url": "https://github.com/Finish-Line-Media/DMK_Lite/releases/tag/v$NEW_VERSION",
  "release_date": "$(date +%Y-%m-%d)",
  "min_wp_version": "5.8",
  "tested_up_to": "6.5",
  "php_version": "7.4"
}
EOF
    echo -e "${GREEN}✓${NC} Updated root version.json"
fi

# Update readme.txt if it exists
if [ -f "mediakit-lite/readme.txt" ]; then
    sed -i.bak "s/Stable tag: .*/Stable tag: $NEW_VERSION/" mediakit-lite/readme.txt && rm mediakit-lite/readme.txt.bak
    echo -e "${GREEN}✓${NC} Updated readme.txt"
fi

# Update CHANGELOG.md
echo -e "\n${BLUE}Updating changelog...${NC}"
TEMP_CHANGELOG=$(mktemp)
CURRENT_DATE=$(date +%Y-%m-%d)

# Create new changelog entry
{
    echo "# MediaKit Lite Theme Changelog"
    echo ""
    echo "All notable changes to the MediaKit Lite theme will be documented in this file."
    echo ""
    echo "## [$NEW_VERSION] - $CURRENT_DATE"
    echo ""
    echo "### Changed"
    echo "- $CHANGELOG_MESSAGE"
    echo ""
    # Append the rest of the changelog, skipping the header
    tail -n +5 mediakit-lite/CHANGELOG.md
} > "$TEMP_CHANGELOG"

mv "$TEMP_CHANGELOG" mediakit-lite/CHANGELOG.md
echo -e "${GREEN}✓${NC} Updated CHANGELOG.md"

# Git operations
echo -e "\n${BLUE}Committing changes...${NC}"
git add mediakit-lite/style.css mediakit-lite/functions.php mediakit-lite/version.json mediakit-lite/CHANGELOG.md
[ -f "mediakit-lite/readme.txt" ] && git add mediakit-lite/readme.txt
[ -f "version.json" ] && git add version.json

git commit -m "Bump version to $NEW_VERSION

- $CHANGELOG_MESSAGE"

echo -e "${GREEN}✓${NC} Changes committed"

# Create git tag
echo -e "\n${BLUE}Creating git tag...${NC}"
git tag -a "v$NEW_VERSION" -m "Release version $NEW_VERSION"
echo -e "${GREEN}✓${NC} Created tag v$NEW_VERSION"

# Push to trigger the release
echo -e "\n${BLUE}Pushing to GitHub...${NC}"
if git push origin main; then
    echo -e "${GREEN}✓${NC} Pushed to main branch"
else
    echo -e "${RED}✗ Failed to push to main branch${NC}"
    exit 1
fi

if git push origin "v$NEW_VERSION"; then
    echo -e "${GREEN}✓${NC} Pushed tag v$NEW_VERSION"
else
    echo -e "${RED}✗ Failed to push tag${NC}"
    exit 1
fi

echo -e "\n${GREEN}Success!${NC} Version bumped to $NEW_VERSION"
echo -e "${YELLOW}GitHub Actions will now automatically create the release.${NC}"
echo -e "\nCheck the progress at:"
echo -e "${BLUE}https://github.com/Finish-Line-Media/DMK_Lite/actions${NC}"