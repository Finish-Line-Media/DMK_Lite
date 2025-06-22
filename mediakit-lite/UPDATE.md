# MediaKit Pro Theme Update Instructions

## Important: Preventing Duplicate Themes

To update MediaKit Pro without creating duplicate themes in your WordPress installation, follow these instructions carefully.

## Update Methods

### Method 1: WordPress Admin (Recommended)

1. **Download the Update**
   - Download the latest `mediakit-lite.zip` file
   - **Important**: The file MUST be named exactly `mediakit-lite.zip` (not `mediakit-lite-v1.0.3.zip` or similar)

2. **Prepare for Update**
   - Go to **Appearance > Themes** in WordPress admin
   - Activate a different theme temporarily (like Twenty Twenty-Three)

3. **Remove Old Version**
   - Click on the MediaKit Pro theme
   - Click **Delete** in the bottom right corner
   - Confirm deletion

4. **Install New Version**
   - Click **Add New** at the top of the themes page
   - Click **Upload Theme**
   - Choose the `mediakit-pro.zip` file
   - Click **Install Now**

5. **Reactivate Theme**
   - Once installed, click **Activate**
   - Your settings and customizations will be preserved

### Method 2: FTP/File Manager

1. **Access Your Server**
   - Connect via FTP or use your hosting control panel's file manager
   - Navigate to `/wp-content/themes/`

2. **Backup Current Theme** (Optional but recommended)
   - Download or rename the `mediakit-pro` folder to `mediakit-pro-backup`

3. **Upload New Version**
   - Delete the existing `mediakit-pro` folder
   - Upload and extract the new `mediakit-pro.zip` file
   - Ensure the folder is named exactly `mediakit-pro`

4. **Verify Update**
   - Go to **Appearance > Themes** in WordPress admin
   - Check that the version number has updated

## Preserving Customizations

### Use a Child Theme
If you've made direct modifications to theme files:

1. Create a child theme before updating
2. Move your customizations to the child theme
3. Update the parent theme using the methods above

### Theme Settings
- Theme Customizer settings are stored in the database and will be preserved
- Widget configurations will remain intact
- Menu assignments will be maintained

## Checking Your Version

Current version can be found in:
- **Appearance > Themes** (hover over MediaKit Pro)
- **style.css** file (Version: X.X.X)
- **WordPress admin footer** when theme is active

## Troubleshooting

### "Destination folder already exists" Error
This means you're trying to install over an existing theme:
1. Delete the old theme first (Method 1)
2. Or use FTP to replace files (Method 2)

### Lost Customizations
- Check if you had modifications in the theme files
- Consider using a child theme for future customizations
- Theme Customizer settings should still be in the database

### Theme Not Updating
- Ensure the ZIP file is named exactly `mediakit-pro.zip`
- Clear your browser cache
- Check file permissions on your server

## Update Notifications

The theme includes an update notification system that:
- Checks for updates once daily
- Shows a dismissible notice in WordPress admin
- Provides a download link for the latest version

To see update notices, ensure your server can connect to external URLs.

## Support

If you encounter issues updating the theme:
1. Check the theme documentation
2. Ensure you're following the naming convention
3. Verify file permissions on your server

---

**Remember**: Always backup your website before updating themes!