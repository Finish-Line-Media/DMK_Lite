# MediaKit Lite CI/CD Automation Guide

## 🚀 Overview

This guide sets up a fully automated release pipeline. Once configured, you'll never need to manually create releases again!

## 🔧 One-Time Setup

### Step 1: Commit the GitHub Actions Workflow

The workflow files are already created. You just need to commit them:

```bash
git add mediakit-lite/.github/workflows/auto-release.yml
git commit -m "Add automated release workflow"
git push origin main
```

### Step 2: Create Initial Release (One Time Only)

Since no releases exist yet, create the first one manually:

1. Run: `./create-release.sh`
2. Go to: https://github.com/Finish-Line-Media/DMK_Lite/releases/new
3. Tag: `v1.3.4`
4. Upload the ZIP file as `mediakit-lite.zip`
5. Publish

## 🎯 Automated Workflow (After Setup)

### How It Works

1. **You update code** and want to release
2. **Run the bump script**: `./bump-version.sh patch "Fixed something"`
3. **Script automatically**:
   - Updates version in all files
   - Updates changelog
   - Commits changes
   - Pushes to GitHub
4. **GitHub Actions automatically**:
   - Detects version change
   - Creates ZIP file
   - Creates GitHub release
   - Attaches ZIP file

### Usage Examples

```bash
# For bug fixes (1.3.4 → 1.3.5)
./bump-version.sh patch "Fixed critical error in customizer"

# For new features (1.3.5 → 1.4.0)
./bump-version.sh minor "Added new dashboard widgets"

# For breaking changes (1.4.0 → 2.0.0)
./bump-version.sh major "Complete theme redesign"
```

## 📋 Version Bump Script Features

The `bump-version.sh` script:
- ✅ Updates version in `style.css`
- ✅ Updates version in `functions.php`
- ✅ Updates version in `version.json`
- ✅ Updates version in `readme.txt`
- ✅ Adds entry to `CHANGELOG.md`
- ✅ Commits all changes
- ✅ Pushes to GitHub
- ✅ Triggers automatic release

## 🤖 GitHub Actions Workflow

The workflow (`auto-release.yml`):
- 🔍 Monitors pushes to main branch
- 📊 Checks if version number changed
- 📦 Creates clean ZIP file (removes dev files)
- 📝 Extracts changelog for the version
- 🚀 Creates GitHub release
- 📎 Attaches ZIP file as `mediakit-lite.zip`

## 🛠️ Troubleshooting

### Release didn't create automatically?

1. Check GitHub Actions: https://github.com/Finish-Line-Media/DMK_Lite/actions
2. Look for any error messages
3. Ensure the workflow file is in `.github/workflows/`

### Version conflicts?

Always pull latest changes before bumping:
```bash
git pull origin main
./bump-version.sh patch "My changes"
```

### Need to test locally?

Create a test ZIP without releasing:
```bash
./create-release.sh
# This creates a ZIP but doesn't push anything
```

## 🎉 Benefits

- **No manual releases**: Everything is automated
- **Consistent versioning**: Script ensures all files are updated
- **Automatic changelog**: Entries are added automatically
- **Clean releases**: Dev files are automatically excluded
- **Update notifications work**: Users see updates in WordPress

## 📝 Complete Workflow Example

```bash
# 1. Make your code changes
# ... edit files ...

# 2. Test your changes
# ... test in WordPress ...

# 3. Commit your code changes
git add .
git commit -m "Fixed social media links"

# 4. Bump version and release
./bump-version.sh patch "Fixed social media links not working"

# 5. Done! Check the release at:
# https://github.com/Finish-Line-Media/DMK_Lite/releases
```

That's it! Your release will be automatically created in about 1-2 minutes.