# Stock Scanner Pro WordPress Theme - Deployment Guide

## Quick Start

1. **Upload Theme**
   ```bash
   # Upload the entire stock-scanner-theme folder to:
   /wp-content/themes/stock-scanner-theme/
   ```

2. **Activate Theme**
   - Go to WordPress Admin → Appearance → Themes
   - Find "Stock Scanner Pro" and click "Activate"

3. **Configure WordPress (Optional)**
   - Add the contents of `wp-config-additions.php` to your `wp-config.php` for optimal performance

## Production Checklist

### ✅ Theme Features Included
- [x] React build assets integrated
- [x] WordPress routing for React Router
- [x] REST API endpoints for React app
- [x] Security headers and optimizations
- [x] CORS handling for API requests
- [x] Production-ready asset enqueuing
- [x] WordPress admin compatibility
- [x] SEO-friendly structure
- [x] Performance optimizations

### ✅ File Structure
```
stock-scanner-theme/
├── assets/css/main.64506ea8.css     # React styles
├── assets/js/main.667b9984.js       # React application
├── functions.php                     # WordPress integration
├── index.php                         # Main template
├── style.css                         # Theme info
├── theme.json                        # WordPress theme config
└── [other WordPress templates]
```

### ✅ React Routes Handled
- `/` - Home page
- `/dashboard` - User dashboard  
- `/market-overview` - Market data
- `/scanner` - Stock scanner
- `/watchlist` - User watchlist
- `/portfolio` - Portfolio management
- `/news` - Market news
- `/account` - Account settings
- `/premium` - Premium plans
- `/login` - User authentication
- `/signup` - User registration
- `/contact` - Contact page

## Server Requirements

### Minimum Requirements
- **WordPress**: 5.0+
- **PHP**: 7.4+
- **MySQL**: 5.6+
- **Apache/Nginx**: With mod_rewrite enabled
- **Memory**: 256MB+ (recommended)

### Recommended Server Configuration
```apache
# Add to .htaccess (already included in theme)
RewriteEngine On
Header set X-Frame-Options DENY
Header set X-Content-Type-Options nosniff

# Enable Gzip compression
AddOutputFilterByType DEFLATE text/css application/javascript
```

## WordPress Configuration

### Required WordPress Settings
1. **Permalink Structure**: Set to "Post name" or custom structure
2. **User Registration**: Enable if using signup functionality
3. **REST API**: Ensure REST API is enabled (default)

### Recommended Plugins
- **Security**: Wordfence Security
- **Caching**: WP Super Cache or W3 Total Cache
- **Backup**: UpdraftPlus
- **SEO**: Yoast SEO (optional)

## Performance Optimization

### Already Included
- ✅ Gzipped assets
- ✅ Minified CSS/JS
- ✅ Browser caching headers
- ✅ Optimized WordPress head
- ✅ Disabled unnecessary WordPress features

### Additional Recommendations
1. **CDN**: Use CloudFlare or similar
2. **Caching**: Install WordPress caching plugin
3. **Image Optimization**: Use WebP images
4. **Database**: Regular database optimization

## Security Considerations

### Built-in Security Features
- ✅ Security headers (X-Frame-Options, etc.)
- ✅ CORS properly configured
- ✅ Nonce verification for API calls
- ✅ Sanitized user inputs
- ✅ Disabled file editing
- ✅ XML-RPC disabled

### Additional Security Steps
1. Use HTTPS (SSL certificate)
2. Regular WordPress updates
3. Strong admin passwords
4. Two-factor authentication
5. Security monitoring plugin

## Troubleshooting

### Common Issues

**React App Not Loading**
- Check browser console for JavaScript errors
- Verify assets are properly enqueued
- Ensure mod_rewrite is enabled

**404 Errors on React Routes**
- Check permalink settings
- Verify .htaccess rules
- Ensure React Router routes match WordPress routing

**API Requests Failing**
- Check CORS headers
- Verify REST API is enabled
- Check nonce verification

**Performance Issues**
- Enable caching plugin
- Optimize database
- Use CDN for static assets

### Debug Mode
Add to wp-config.php for debugging:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## Support

For technical support:
1. Check WordPress error logs
2. Review browser console errors
3. Verify server requirements
4. Test with default WordPress theme

## Version Information
- **Theme Version**: 1.0.0
- **WordPress Compatibility**: 5.0+
- **React Version**: 19.0.0
- **Build Date**: Generated with latest React build