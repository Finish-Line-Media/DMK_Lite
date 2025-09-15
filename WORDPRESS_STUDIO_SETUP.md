# WordPress Studio Setup with Symlink

This guide helps you set up MediaKit Lite theme with WordPress Studio using a symbolic link for automatic file syncing.

## Prerequisites

1. **Download WordPress Studio** from https://developer.wordpress.com/studio/
2. **Install WordPress Studio** by dragging it to your Applications folder
3. **Create a WordPress site** in Studio

## Quick Setup (Automatic)

Run our setup script:

```bash
cd /Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite
./setup-studio.sh
```

The script will:
- ✅ Detect WordPress Studio installation
- ✅ Find your WordPress sites
- ✅ Create a symlink for automatic syncing
- ✅ Provide activation instructions

## Manual Setup (If Script Doesn't Work)

### Step 1: Find Your WordPress Studio Site

WordPress Studio stores sites in `~/Studio/`. Each site has its own folder.

```bash
# List your Studio sites
ls ~/Studio/
```

### Step 2: Create the Symlink

```bash
# Navigate to your theme repo
cd /Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite

# Create symlink (replace [SITE_NAME] with your actual site folder name)
ln -s $(pwd)/mediakit-lite ~/Studio/[SITE_NAME]/wp-content/themes/mediakit-lite
```

### Step 3: Verify the Symlink

```bash
# Check if symlink was created
ls -la ~/Studio/[SITE_NAME]/wp-content/themes/ | grep mediakit-lite

# You should see something like:
# mediakit-lite -> /Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite/mediakit-lite
```

## Activating the Theme

1. **Open WordPress Studio**
2. **Start your site** (click Start if needed)
3. **Click "WP Admin"** to open WordPress admin
4. **Navigate to Appearance → Themes**
5. **Find "MediaKit Lite" and click Activate**

## How Symlinks Work

A symbolic link (symlink) creates a reference from one location to another:

```
WordPress Studio themes folder
    ↓
    mediakit-lite (symlink)
    ↓
Your repo: /Users/dixy/.../mediakit-lite (actual files)
```

**Benefits:**
- 🚀 **Instant updates** - Changes in your repo appear immediately in WordPress
- 📁 **Single source** - No need to copy files back and forth
- 🔄 **Always in sync** - Perfect for active development
- 💾 **Git-friendly** - Work directly in your git repository

## Development Workflow

1. **Edit files** in your repository:
   ```
   /Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite/mediakit-lite/
   ```

2. **See changes instantly** in WordPress Studio (just refresh browser)

3. **Commit changes** when ready:
   ```bash
   git add .
   git commit -m "Your changes"
   git push
   ```

## Troubleshooting

### Symlink Not Working?

1. **Check permissions:**
   ```bash
   ls -la ~/Studio/[SITE_NAME]/wp-content/themes/
   ```

2. **Remove and recreate:**
   ```bash
   rm ~/Studio/[SITE_NAME]/wp-content/themes/mediakit-lite
   ln -s $(pwd)/mediakit-lite ~/Studio/[SITE_NAME]/wp-content/themes/mediakit-lite
   ```

### Theme Not Showing in WordPress?

1. **Verify symlink exists:**
   ```bash
   ls ~/Studio/[SITE_NAME]/wp-content/themes/ | grep mediakit
   ```

2. **Check theme files are accessible:**
   ```bash
   cat ~/Studio/[SITE_NAME]/wp-content/themes/mediakit-lite/style.css | head -5
   ```

3. **Restart WordPress Studio** and try again

### Port Conflicts?

WordPress Studio typically uses port 8881. If you see port conflicts:
1. Stop other local development tools (Local, MAMP, etc.)
2. Restart WordPress Studio
3. Check site URL in Studio settings

## Common WordPress Studio URLs

- **Site**: http://localhost:8881
- **Admin**: http://localhost:8881/wp-admin
- **Customizer**: http://localhost:8881/wp-admin/customize.php

## Tips for Development

1. **Keep Studio Running** - WordPress Studio must be running for your site to work
2. **Use Browser DevTools** - For CSS/JS debugging (F12 or Cmd+Option+I)
3. **Enable Debug Mode** - Add to wp-config.php:
   ```php
   define( 'WP_DEBUG', true );
   define( 'WP_DEBUG_LOG', true );
   ```
4. **Clear Cache** - Hard refresh with Cmd+Shift+R when testing CSS changes

## Removing the Symlink

If you want to remove the symlink and use a regular copy instead:

```bash
# Remove symlink
rm ~/Studio/[SITE_NAME]/wp-content/themes/mediakit-lite

# Copy theme instead
cp -r mediakit-lite ~/Studio/[SITE_NAME]/wp-content/themes/
```

## Next Steps

1. ✅ Theme is linked and activated
2. 📝 Start developing in your repo
3. 🔄 Changes sync automatically
4. 🚀 Deploy when ready using `./bump-version.sh`

Happy developing with WordPress Studio! 🎉