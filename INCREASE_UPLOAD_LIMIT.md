# How to Increase PHP Upload File Size Limit

## Method 1: Edit php.ini File (Recommended)

1. **Find your php.ini file location:**
   - Run `php --ini` in terminal/command prompt
   - Or check `phpinfo()` output

2. **Edit php.ini and update these settings:**
   ```ini
   upload_max_filesize = 100M
   post_max_size = 100M
   max_execution_time = 300
   max_input_time = 300
   memory_limit = 256M
   ```

3. **Restart your web server:**
   - Apache: `sudo service apache2 restart` or restart Apache service
   - Nginx + PHP-FPM: `sudo service php-fpm restart`
   - XAMPP/WAMP: Restart from control panel

## Method 2: Using .htaccess (Apache only)

Create or edit `.htaccess` file in your Laravel `public` directory:

```apache
php_value upload_max_filesize 100M
php_value post_max_size 100M
php_value max_execution_time 300
php_value max_input_time 300
php_value memory_limit 256M
```

**Note:** This only works if PHP is running as Apache module (not CGI/FastCGI).

## Method 3: Using php.ini in Laravel (if allowed)

Create a `php.ini` file in your `public` directory:

```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

## Method 4: Check Current Settings

Visit: `http://your-domain/phpinfo` or use the route below to check current PHP limits.

## Important Notes:

- `post_max_size` must be **equal to or greater than** `upload_max_filesize`
- After making changes, **restart your web server**
- Some shared hosting providers don't allow changing these values
- For production, contact your hosting provider if you can't modify php.ini

## Recommended Values for Video Uploads:

- **Small videos (< 50MB):** `upload_max_filesize = 100M`, `post_max_size = 100M`
- **Medium videos (< 200MB):** `upload_max_filesize = 250M`, `post_max_size = 250M`
- **Large videos (< 500MB):** `upload_max_filesize = 500M`, `post_max_size = 500M`

## Verify Changes:

After making changes, check if they took effect by running:
```php
php -i | grep upload_max_filesize
php -i | grep post_max_size
```

Or visit the PHP info page to see current values.



