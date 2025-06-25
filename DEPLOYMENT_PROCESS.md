# MediaKit Lite Deployment Process

This document outlines the process for deploying updates and creating new releases for the MediaKit Lite theme.

## Prerequisites

- All changes must be committed to git
- You must be on the `main` branch
- The working directory must be clean (no uncommitted changes)

## Step-by-Step Deployment Process

### 1. Stage and Commit All Changes

```bash
# Check current status
git status

# Stage all changes
git add -A

# Commit with descriptive message
git commit -m "Your detailed commit message

- Feature 1
- Feature 2
- Bug fix 1"
```

### 2. Update CHANGELOG.md

Edit `CHANGELOG.md` to add a new version entry:

```markdown
## [1.7.XX] - YYYY-MM-DD

### Added
- New features

### Changed
- Modified features

### Removed
- Deleted features or code
```

Then commit the changelog:

```bash
git add CHANGELOG.md
git commit -m "Update CHANGELOG for version 1.7.XX"
```

### 3. Run Version Bump Script

The `bump-version.sh` script handles all version updates and deployment:

```bash
bash bump-version.sh 1.7.XX
```

This script will:
1. Update version in `style.css`
2. Update version in `readme.txt`
3. Update version in `functions.php` (MKP_THEME_VERSION constant)
4. Update version in `version.json`
5. Commit the version changes
6. Create a git tag (v1.7.XX)
7. Push to main branch
8. Push the tag

### 4. Automatic Release Creation

Once the tag is pushed, GitHub Actions will automatically:
1. Detect the version change
2. Create a ZIP file of the theme
3. Extract relevant changelog entries
4. Create a GitHub release with the ZIP file attached

### 5. Verify Release

Check the release at:
https://github.com/Finish-Line-Media/DMK_Lite/releases

## Important Notes

- **Never** bump version with uncommitted changes
- Always update CHANGELOG.md before bumping version
- The auto-release workflow triggers on changes to `style.css` or `version.json`
- Users will see update notifications in WordPress admin once the release is created
- Version numbers should follow semantic versioning (MAJOR.MINOR.PATCH)

## Common Issues

### Uncommitted Changes Error
If you get an error about uncommitted changes:
1. Commit your changes: `git add . && git commit -m "message"`
2. Or stash them: `git stash`
3. Or discard them: `git checkout -- .`

### Push Failures
If pushing fails:
1. Ensure you have push permissions
2. Check if you're on the main branch
3. Pull latest changes: `git pull origin main`

## Version Numbering Guidelines

- **Patch version (1.7.X)**: Bug fixes, minor tweaks
- **Minor version (1.X.0)**: New features, significant changes
- **Major version (X.0.0)**: Breaking changes, major overhauls