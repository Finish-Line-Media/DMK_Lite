# Local WordPress Development Setup Guide

## Step 1: Install Local by Flywheel

1. **Download Local** from https://localwp.com/
   - Choose the Mac version
   - It's free and includes everything you need (PHP, MySQL, WordPress)

2. **Install Local**
   - Open the downloaded installer
   - Drag Local to your Applications folder
   - Launch Local

## Step 2: Create Your WordPress Site

1. **In Local, click "Create a new site"**
   
2. **Choose "Create a new site"** (not from Blueprint)

3. **Site Setup:**
   - Site name: `MediaKit Dev` (or any name you prefer)
   - Click Continue

4. **Environment Setup:**
   - Choose "Preferred" (recommended) which includes:
     - PHP 8.1.23
     - Web Server: nginx 
     - Database: MySQL 8.0.16
   - Click Continue

5. **WordPress Setup:**
   - WordPress Username: `admin` (remember this!)
   - WordPress Password: (choose a password, remember it!)
   - WordPress Email: your email
   - Click "Add Site"

6. **Wait for Local to:**
   - Download WordPress
   - Set up the database
   - Configure the server
   - This takes 2-3 minutes

## Step 3: Install the MediaKit Lite Theme

1. **Find your Local site folder:**
   - In Local, right-click on your site name
   - Click "Show Folder" or "Reveal in Finder"
   - Navigate to: `app/public/wp-content/themes/`

2. **Copy the theme:**
   - Copy the entire `mediakit-lite` folder from:
     `/Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite/mediakit-lite`
   - Paste it into the `themes` folder you just opened

## Step 4: Activate the Theme

1. **Access WordPress Admin:**
   - In Local, click on your site
   - Click "WP Admin" button (opens in browser)
   - Login with the username/password you created

2. **Activate MediaKit Lite:**
   - Go to Appearance > Themes
   - Find "MediaKit Lite"
   - Click "Activate"

## Step 5: Configure Development Settings

1. **Enable Debug Mode:**
   - In Local, click on your site
   - Go to "Tools" > "Open Site Shell"
   - Or manually edit: `app/public/wp-config.php`
   
   Add these lines before "That's all, stop editing!":
   ```php
   define( 'WP_DEBUG', true );
   define( 'WP_DEBUG_LOG', true );
   define( 'WP_DEBUG_DISPLAY', false );
   define( 'SCRIPT_DEBUG', true );
   ```

2. **Install Development Plugins:**
   - In WordPress Admin, go to Plugins > Add New
   - Search and install:
     - **Query Monitor** - For debugging
     - **Theme Check** - To validate theme standards
     - **Debug Bar** (optional) - Additional debugging

## Step 6: Start Developing

### Your Development Workflow:

1. **Edit theme files** in:
   `/Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite/mediakit-lite/`

2. **Copy changed files** to Local:
   - After making changes, copy files to:
   `[Local Site]/app/public/wp-content/themes/mediakit-lite/`
   - Or work directly in the Local themes folder

3. **View your site:**
   - Click "View Site" in Local
   - URL will be something like: `http://mediakit-dev.local`

4. **Access WordPress Admin:**
   - Click "WP Admin" in Local
   - URL: `http://mediakit-dev.local/wp-admin`

### Quick Commands for Terminal:

```bash
# Navigate to your theme in the repo
cd /Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite/mediakit-lite

# Copy theme to Local (replace [LOCAL_SITE_PATH] with your actual path)
cp -r . [LOCAL_SITE_PATH]/app/public/wp-content/themes/mediakit-lite/

# Or create a symlink (advanced - files update automatically)
ln -s /Users/dixy/Documents/web-dev/LowCodeRoad/WordPress/DMK_Lite/mediakit-lite [LOCAL_SITE_PATH]/app/public/wp-content/themes/mediakit-lite
```

## Important Files to Know

### Theme Structure:
- `style.css` - Main stylesheet and theme info
- `functions.php` - Core theme functionality
- `inc/customizer/` - Theme customizer settings
- `template-parts/` - Reusable template components
- `assets/css/` - Modular CSS files
- `assets/js/` - JavaScript files

### Customizer:
- Access via: Appearance > Customize
- Configure all theme options here
- Changes appear live in preview

## Testing Your Changes

1. **After editing PHP files:**
   - Refresh the browser
   - Check for PHP errors in debug.log

2. **After editing CSS:**
   - Hard refresh: Cmd+Shift+R (Mac)
   - Check browser console for errors

3. **After editing JavaScript:**
   - Clear browser cache if needed
   - Check browser console for errors

## Troubleshooting

### Site Won't Load:
- Make sure Local is running
- Click "Start" next to your site in Local

### Changes Not Showing:
- Clear browser cache
- Make sure you copied files to the Local themes folder
- Check you're editing the right theme

### PHP Errors:
- Check `/app/public/wp-content/debug.log`
- Make sure PHP syntax is correct

## Next Steps

1. **Customize the theme:**
   - Go to Appearance > Customize
   - Add your content
   - Configure colors and settings

2. **Make code changes:**
   - Edit files in your preferred code editor
   - Test changes in Local
   - Commit to Git when ready

3. **Deploy changes:**
   - Follow DEPLOYMENT_PROCESS.md
   - Use `bump-version.sh` script
   - GitHub Actions will create releases automatically

## Useful Links

- Local Documentation: https://localwp.com/help-docs/
- WordPress Codex: https://codex.wordpress.org/
- Theme Development: https://developer.wordpress.org/themes/

---

Remember: Local handles all the server stuff, so you can focus on developing the theme!