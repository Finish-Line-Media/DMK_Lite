# MediaKit Lite Release Guide

## Why Releases Are Needed

The theme's update checker looks for GitHub Releases, not just code commits. Without creating releases, users won't see update notifications even when new versions are available.

## Quick Release Process

### Option 1: Manual Release (Current Method)

1. **Run the release script**:
   ```bash
   ./create-release.sh
   ```

2. **Go to GitHub Releases**:
   - Visit: https://github.com/Finish-Line-Media/DMK_Lite/releases/new

3. **Create the release**:
   - Choose a tag: `v1.3.4` (or current version)
   - Target: `main` branch
   - Release title: `MediaKit Lite v1.3.4`
   - Description: Copy from the generated `release-notes-v1.3.4.md`
   - Attach the ZIP file (RENAME to `mediakit-lite.zip` when uploading!)
   - Publish release

### Option 2: Automated Release (Future Method)

Once the GitHub Actions workflow is committed:

1. **Commit and push your changes**
2. **Create and push a version tag**:
   ```bash
   git tag v1.3.4
   git push origin v1.3.4
   ```
3. GitHub Actions will automatically create the release with the ZIP file

## Important Notes

- The ZIP file **MUST** be named `mediakit-lite.zip` in the release assets
- The tag should be `v1.3.4` format (with the 'v' prefix)
- The update checker looks for the latest release, so always create releases for new versions

## Testing Updates

After creating a release:
1. Wait a few minutes for GitHub to process
2. In WordPress admin, click "Check for Updates" button
3. You should see the update notification

## Current Status

As of v1.3.4, there are NO releases on GitHub, which is why the update functionality isn't working. The first release needs to be created manually.