# MediaKit Lite Deployment Process

This document provides the complete, step-by-step process for deploying a new version of MediaKit Lite to production.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Detailed Deployment Steps](#detailed-deployment-steps)
- [What Happens Automatically](#what-happens-automatically)
- [Verification](#verification)
- [Troubleshooting](#troubleshooting)
- [Important Notes](#important-notes)

---

## Prerequisites

Before deploying a new version, ensure:

1. **All changes are committed**
   ```bash
   git status
   ```
   Should show: "nothing to commit, working tree clean"

2. **You're on the main branch**
   ```bash
   git branch --show-current
   ```
   Should show: "main"

3. **Local testing is complete**
   - Test all changes in a local WordPress environment
   - Verify functionality across different themes/color schemes
   - Test responsive design on mobile/tablet/desktop

4. **You have push access to the repository**
   - Ensure you can push to the main branch
   - Confirm GitHub Actions are enabled

---

## Quick Start

For experienced users, here's the one-command deployment:

```bash
./bump-version.sh patch "Description of changes"
```

Replace `patch` with:
- `patch` - Bug fixes and minor updates (2.0.14 → 2.0.15)
- `minor` - New features, non-breaking changes (2.0.14 → 2.1.0)
- `major` - Breaking changes, major rewrites (2.0.14 → 3.0.0)

That's it! The script handles everything else automatically.

---

## Detailed Deployment Steps

### Step 1: Prepare for Deployment

```bash
# Navigate to repository root
cd /path/to/DMK_Lite

# Ensure working directory is clean
git status

# Pull latest changes (if working with a team)
git pull origin main
```

### Step 2: Run the Version Bump Script

**Location:** ROOT directory (NOT inside mediakit-lite/)

**Command:**
```bash
./bump-version.sh [major|minor|patch] "Changelog message"
```

**Examples:**
```bash
# Bug fix or minor update
./bump-version.sh patch "Fix navbar positioning to fixed top and adjust spacing"

# New feature
./bump-version.sh minor "Add new social media integration features"

# Major update
./bump-version.sh major "Complete theme redesign with new architecture"
```

### Step 3: Monitor Script Output

The script will:
1. ✅ Validate bump type and arguments
2. ✅ Check for uncommitted changes (will exit if found)
3. ✅ Verify you're on main branch (will prompt if not)
4. ✅ Display current and new version numbers
5. ✅ Update all version files
6. ✅ Update CSS cache busting parameters
7. ✅ Update CHANGELOG.md
8. ✅ Commit changes
9. ✅ Create git tag
10. ✅ Push to GitHub

**Expected Output:**
```
MediaKit Lite Version Bump Tool
=================================
Current version: 2.0.14
New version: 2.0.15

Updating version numbers...
✓ Updated style.css
✓ Updated CSS import versions for cache busting
✓ Updated functions.php
✓ Updated version.json
✓ Updated root version.json
✓ Updated readme.txt

Updating changelog...
✓ Updated CHANGELOG.md

Committing changes...
✓ Changes committed

Creating git tag...
✓ Created tag v2.0.15

Pushing to GitHub...
✓ Pushed to main branch
✓ Pushed tag v2.0.15

Success! Version bumped to 2.0.15
GitHub Actions will now automatically create the release.

Check the progress at:
https://github.com/Finish-Line-Media/DMK_Lite/actions
```

### Step 4: Wait for GitHub Actions

GitHub Actions automatically:
1. Detects the new tag push
2. Runs the workflow defined in `.github/workflows/release.yml`
3. Builds the theme ZIP file
4. Creates a GitHub Release
5. Attaches the ZIP file to the release

**Wait time:** Approximately 2-3 minutes

---

## What Happens Automatically

The `./bump-version.sh` script handles ALL of the following:

### Version Updates
- ✅ `mediakit-lite/style.css` - Theme header version
- ✅ `mediakit-lite/functions.php` - MKP_THEME_VERSION constant
- ✅ `mediakit-lite/version.json` - Theme version metadata
- ✅ `version.json` - Root version file for update checker
- ✅ `mediakit-lite/readme.txt` - Stable tag version

### CSS Cache Busting
- ✅ Updates ALL `?ver=X.X.X` parameters in CSS `@import` statements
- ✅ Example: `@import url('assets/css/base/variables.css?ver=2.0.14');`
  becomes `@import url('assets/css/base/variables.css?ver=2.0.15');`
- ✅ Prevents browser caching issues where users don't see style updates

### CHANGELOG.md
- ✅ Creates new version entry with current date
- ✅ Adds your changelog message
- ✅ Maintains proper markdown formatting

### Git Operations
- ✅ Stages all changed files
- ✅ Creates commit with descriptive message
- ✅ Creates annotated git tag (e.g., `v2.0.15`)
- ✅ Pushes both commit and tag to GitHub
- ✅ Includes error handling for failed pushes

### GitHub Actions Trigger
- ✅ Tag push triggers automated build workflow
- ✅ Creates release on GitHub with ZIP attachment
- ✅ No manual intervention required

---

## Verification

After the script completes, verify the deployment:

### 1. Check Git Status
```bash
git log -1
# Should show your "Bump version to X.X.X" commit

git tag | tail -1
# Should show vX.X.X tag

git status
# Should show clean working tree
```

### 2. Monitor GitHub Actions
Visit: `https://github.com/Finish-Line-Media/DMK_Lite/actions`

- Look for the latest workflow run
- Should show "Release Theme" workflow with green checkmark
- Typically completes in 2-3 minutes

### 3. Verify GitHub Release
Visit: `https://github.com/Finish-Line-Media/DMK_Lite/releases`

- New release should appear with version tag (e.g., v2.0.15)
- Should include release notes from CHANGELOG
- Should have `mediakit-lite.zip` attached

### 4. Verify CSS Cache Busting
```bash
grep "?ver=" mediakit-lite/style.css | head -5
```

All lines should show the NEW version number:
```
@import url('assets/css/base/variables.css?ver=2.0.15');
@import url('assets/css/base/reset.css?ver=2.0.15');
...
```

### 5. Test Update on Production Site (Optional)
Within 24 hours, production sites should see update notification:
- WordPress Admin → Appearance → Themes
- "Update available" badge should appear
- Clicking update should fetch the new version

---

## Troubleshooting

### Script Exits: "You have uncommitted changes"

**Cause:** Working directory has uncommitted changes

**Solution:**
```bash
# Option 1: Commit your changes
git add .
git commit -m "Your message"
./bump-version.sh patch "Your release message"

# Option 2: Stash your changes
git stash
./bump-version.sh patch "Your release message"
git stash pop

# Option 3: Discard changes (be careful!)
git checkout -- .
./bump-version.sh patch "Your release message"
```

### Script Exits: "You are on branch 'feature', not 'main'"

**Cause:** You're not on the main branch

**Solution:**
```bash
# Switch to main branch
git checkout main

# Merge your feature branch if needed
git merge feature-branch-name

# Run bump script
./bump-version.sh patch "Your release message"
```

### Failed to Push to Main Branch

**Cause:** No push permissions or network issue

**Solution:**
```bash
# Check remote URL
git remote -v

# Check if you can push
git push --dry-run origin main

# If authentication fails, update credentials
gh auth login
# OR
git remote set-url origin git@github.com:Finish-Line-Media/DMK_Lite.git
```

### Failed to Push Tag

**Cause:** Tag already exists or network issue

**Solution:**
```bash
# Check if tag exists remotely
git ls-remote --tags origin

# If tag exists and you need to recreate it
git tag -d v2.0.15              # Delete local tag
git push origin :refs/tags/v2.0.15  # Delete remote tag
./bump-version.sh patch "Your message"  # Re-run script
```

### GitHub Actions Fails

**Cause:** Build error or missing secrets

**Solution:**
1. Visit GitHub Actions page to see error details
2. Check workflow logs for specific error message
3. Common issues:
   - Missing repository secrets
   - Invalid workflow YAML syntax
   - Node version incompatibility

### CSS Changes Not Appearing for Users

**Cause:** Browser caching old CSS files

**This should NOT happen if you used the bump script correctly!**

**Verification:**
```bash
# Check if CSS versions were updated
grep "?ver=" mediakit-lite/style.css | grep -v "$(grep 'Version:' mediakit-lite/style.css | awk '{print $3}')"
```

If the command returns results, CSS versions are out of sync. This means the script didn't run correctly.

**Solution:** Manually update or re-run the bump process

---

## Important Notes

### ⚠️ ALWAYS Use the ROOT Bump Script

**DO:**
```bash
./bump-version.sh patch "Your message"
```

**DON'T:**
```bash
cd mediakit-lite
./bump-version.sh  # This script doesn't exist (archived as .old)
```

The ROOT script (`/bump-version.sh`) is the ONLY script that:
- Updates CSS cache busting parameters
- Updates root version.json
- Has proper safety checks
- Creates git tags correctly

### 🎯 CSS Cache Busting is Critical

The `?ver=X.X.X` parameters in CSS @import statements are REQUIRED for users to see style changes. The bump script automatically updates these. Never manually edit them.

### 📝 CHANGELOG.md is Auto-Generated

Don't manually edit CHANGELOG.md before bumping. The script will:
1. Read your changelog message from the command
2. Create a properly formatted entry
3. Insert it at the top of the file

### 🏷️ Git Tags Must Match Versions

The script creates tags in format `vX.X.X` (e.g., `v2.0.15`). These tags:
- Must match the version in style.css
- Trigger GitHub Actions workflow
- Become the release version on GitHub

### ⏱️ GitHub Actions Takes 2-3 Minutes

Don't panic if the release doesn't appear immediately. The build process:
1. Checks out code
2. Runs any build steps
3. Creates ZIP file
4. Creates GitHub release
5. Uploads ZIP attachment

### 🚀 Update Notifications Take Up to 24 Hours

WordPress sites check for updates:
- Every 24 hours automatically
- When visiting Themes page
- When manually checking for updates

The update checker is cached, so immediate updates won't show on production sites.

### 🔄 Semantic Versioning Guidelines

- **Patch (X.X.Y):** Bug fixes, minor style changes, typo corrections
- **Minor (X.Y.0):** New features, new sections, non-breaking changes
- **Major (Y.0.0):** Breaking changes, complete redesigns, architecture changes

When in doubt, use `patch`.

---

## Additional Resources

- **Build Process:** See `mediakit-lite/BUILD.md` for manual build instructions
- **Update Instructions:** See `mediakit-lite/UPDATE.md` for end-user update guide
- **Project Instructions:** See `CLAUDE.md` for development guidelines
- **GitHub Actions Workflow:** See `.github/workflows/release.yml` for automation details

---

## Quick Reference

```bash
# Standard patch release
./bump-version.sh patch "Fix navbar positioning and spacing"

# Minor feature release
./bump-version.sh minor "Add new testimonials section with customizer controls"

# Major release
./bump-version.sh major "Theme 3.0 - Complete redesign with block theme support"

# Check deployment status
git log -1                           # See last commit
git tag | tail -1                    # See last tag
open https://github.com/Finish-Line-Media/DMK_Lite/actions  # Check build
open https://github.com/Finish-Line-Media/DMK_Lite/releases # Check release
```

---

**Last Updated:** 2025-10-28
**Script Version:** Enhanced with CSS cache busting, safety checks, and git tag automation
