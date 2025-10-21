# Deploy to Production - Quick Guide

## Simple 2-Step Deployment Process

### Step 1: Check Current Version

Find the current version:
```bash
git tag --list | tail -1
```

Or check: `mediakit-lite/style.css` (line 7) or `mediakit-lite/version.json` (line 2)

**Current version: 2.0.6**

---

### Step 2: Bump Version and Deploy

From any directory, run:

```bash
bash mediakit-lite/bump-version.sh <new-version>
```

**Example:**
```bash
bash mediakit-lite/bump-version.sh 2.0.7
```

---

## What Happens Automatically

The script will:

1. ✅ Update version in:
   - `style.css`
   - `functions.php`
   - `version.json`
   - `readme.txt`

2. ✅ Update release date to today

3. ✅ Commit changes with message: "Bump version to X.X.X"

4. ✅ Create git tag: `vX.X.X`

5. ✅ Push commit and tag to GitHub

6. ✅ Trigger GitHub Actions to:
   - Build theme ZIP file
   - Create GitHub release
   - Attach ZIP to release

7. ✅ Users see update notification in WordPress admin

---

## Version Numbering Guidelines

- **Patch (2.0.X)**: Bug fixes, minor tweaks
- **Minor (2.X.0)**: New features, significant changes
- **Major (X.0.0)**: Breaking changes, major overhauls

---

## Before You Deploy

**Make sure:**
- ✅ All changes are committed
- ✅ You're on the `main` branch
- ✅ `CHANGELOG.md` is updated with new version entry
- ✅ You've tested changes locally

---

## After Deployment

1. **Wait 2-3 minutes** for GitHub Actions to complete

2. **Verify release created:**
   - Visit: https://github.com/Finish-Line-Media/DMK_Lite/releases
   - Check that `vX.X.X` appears with ZIP file attached

3. **Update production sites:**
   - Go to WordPress Admin → Appearance → Themes
   - You should see update notification
   - Click "Update Now" or manually upload the ZIP

---

## Troubleshooting

### No update notification appearing on production?

**Option 1: Wait 24 hours** (cache expires automatically)

**Option 2: Force update check** (immediate):
1. Add these 2 lines to `functions.php` (after line 1185):
   ```php
   delete_transient( 'mkp_update_last_checked' );
   delete_transient( 'mkp_remote_version' );
   ```
2. Load any WordPress admin page
3. **Immediately remove those 2 lines**
4. Refresh admin - update should appear

### Script fails with "uncommitted changes"?

Commit your changes first:
```bash
git add .
git commit -m "Your commit message"
```

Then run the bump script again.

### Wrong directory error?

The script should work from any directory now. If it fails:
```bash
cd mediakit-lite
bash bump-version.sh 2.0.7
```

---

## Full Documentation

For detailed deployment process, see: [DEPLOYMENT_PROCESS.md](DEPLOYMENT_PROCESS.md)
