#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if version is provided
if [ -z "$1" ]; then
    echo "Usage: $0 <version>"
    echo "Example: $0 1.3.1"
    exit 1
fi

VERSION=$1

# Get the directory where this script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Change to the script's directory (mediakit-lite/)
cd "$SCRIPT_DIR"

echo "Working directory: $SCRIPT_DIR"

# Check for uncommitted changes
if ! git diff --quiet || ! git diff --cached --quiet; then
    echo -e "${YELLOW}Warning: You have uncommitted changes:${NC}"
    echo ""
    git status --short
    echo ""
    
    # Check if we're in a git repo
    if [ -d .git ]; then
        # Show more details about the changes
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

# Check if we're on the main branch
CURRENT_BRANCH=$(git branch --show-current)
if [ "$CURRENT_BRANCH" != "main" ]; then
    echo -e "${YELLOW}Warning: You are on branch '$CURRENT_BRANCH', not 'main'.${NC}"
    read -p "Do you want to continue? (y/N) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Update style.css
sed -i '' "s/Version: .*/Version: ${VERSION}/" style.css

# Update readme.txt
sed -i '' "s/Stable tag: .*/Stable tag: ${VERSION}/" readme.txt

# Update functions.php
sed -i '' "s/define( 'MKP_THEME_VERSION', '.*' );/define( 'MKP_THEME_VERSION', '${VERSION}' );/" functions.php

# Update version.json
if [ -f "version.json" ]; then
    sed -i '' "s/\"version\": \".*\"/\"version\": \"${VERSION}\"/" version.json
    sed -i '' "s/\"description\": \"MediaKit Lite v.*\"/\"description\": \"MediaKit Lite v${VERSION}\"/" version.json
    sed -i '' "s/download\/v[0-9.]*\/mediakit-lite.zip/download\/v${VERSION}\/mediakit-lite.zip/" version.json
    sed -i '' "s/tag\/v[0-9.]*\"/tag\/v${VERSION}\"/" version.json
    # Update release date to today
    TODAY=$(date +%Y-%m-%d)
    sed -i '' "s/\"release_date\": \".*\"/\"release_date\": \"${TODAY}\"/" version.json
fi

# Update CHANGELOG.md
if [ -f "CHANGELOG.md" ]; then
    # Get today's date if not already set
    if [ -z "$TODAY" ]; then
        TODAY=$(date +%Y-%m-%d)
    fi
    # Replace ## [Unreleased] with ## [Unreleased]\n\n## [VERSION] - DATE
    # Using perl for reliable multi-line replacement
    perl -i -pe "s/## \[Unreleased\]/## [Unreleased]\n\n## [${VERSION}] - ${TODAY}/" CHANGELOG.md
fi

echo -e "${GREEN}Version bumped to ${VERSION}${NC}"

# Git operations
git add style.css readme.txt functions.php
# Add version.json if it exists
if [ -f "version.json" ]; then
    git add version.json
fi
# Add CHANGELOG.md if it exists
if [ -f "CHANGELOG.md" ]; then
    git add CHANGELOG.md
fi
git commit -m "Bump version to ${VERSION}"

# Create and push tag
git tag -a "v${VERSION}" -m "Release version ${VERSION}"

# Push with error handling
echo "Pushing to remote..."
if git push origin main; then
    echo -e "${GREEN}✓ Pushed to main branch${NC}"
else
    echo -e "${RED}✗ Failed to push to main branch${NC}"
    exit 1
fi

if git push origin "v${VERSION}"; then
    echo -e "${GREEN}✓ Pushed tag v${VERSION}${NC}"
else
    echo -e "${RED}✗ Failed to push tag${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}✓ Version ${VERSION} committed and tagged successfully!${NC}"
echo ""
echo "GitHub Release will be created automatically via GitHub Actions."