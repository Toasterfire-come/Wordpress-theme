# Stock Scanner Pro WordPress Theme

A modern WordPress theme that integrates a React-based stock market analysis application.

## Features

- **React Integration**: Full React SPA integration with WordPress backend
- **React Router Support**: Seamless client-side routing within WordPress
- **Modern UI**: Built with Tailwind CSS and modern React components
- **Stock Market Tools**: Real-time stock data, portfolio management, and market analysis
- **WordPress Compatible**: Fully compatible with WordPress admin, users, and plugins
- **Production Ready**: Optimized build with proper asset enqueuing

## Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme in WordPress Admin > Appearance > Themes
3. The React application will automatically load on the frontend

## Theme Structure

```
stock-scanner-theme/
├── assets/
│   ├── css/           # React build CSS files
│   ├── js/            # React build JS files
│   └── images/        # Theme images
├── functions.php      # Theme functions and React integration
├── index.php          # Main template with React root
├── header.php         # HTML head and opening body
├── footer.php         # Closing body and scripts
├── page.php           # Page template
├── single.php         # Single post template
├── archive.php        # Archive template
├── 404.php            # 404 error template
├── style.css          # Theme stylesheet (WordPress required)
├── theme.json         # WordPress theme configuration
└── README.md          # This file
```

## React Routes

The theme handles the following React routes:
- `/` - Home page
- `/dashboard` - User dashboard
- `/market-overview` - Market overview
- `/scanner` - Stock scanner
- `/watchlist` - User watchlist
- `/portfolio` - Portfolio management
- `/news` - Market news
- `/account` - Account settings
- `/premium` - Premium plans
- `/login` - User login
- `/signup` - User registration
- `/contact` - Contact page

## Customization

The theme is designed to work with the React application. To customize:

1. **Styling**: Modify the React components and rebuild
2. **Functionality**: Update React components in the source
3. **WordPress Integration**: Modify `functions.php` for WordPress-specific features

## Development

To modify the React application:

1. Make changes to the React source code
2. Run `yarn build` to create production build
3. Copy build files to theme `assets/` directory
4. The WordPress theme will automatically load the updated assets

## Requirements

- WordPress 5.0+
- PHP 7.4+
- Modern browser with JavaScript enabled

## Support

This theme is designed specifically for the Stock Scanner Pro application and may require customization for other use cases.