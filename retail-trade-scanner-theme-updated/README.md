# Retail Trade Scanner WordPress Theme

A professional WordPress theme for stock trading and financial data platforms, integrated with external backend services.

## Features

- **Real-time Market Data**: Integration with external APIs for live stock market data
- **Portfolio Management**: Track and analyze investment portfolios
- **User Authentication**: Secure login and account management
- **Responsive Design**: Mobile-first design with Tailwind CSS styling
- **API Integration**: RESTful API proxy for seamless backend communication
- **Performance Optimized**: Fast loading with modern web standards

## Theme Structure

```
retail-trade-scanner/
├── assets/
│   ├── css/           # Additional stylesheets
│   └── js/            # JavaScript files
├── page-*.php         # Custom page templates
├── functions.php      # Theme functionality
├── style.css          # Main stylesheet
├── index.php          # Main template
├── header.php         # Header template
├── footer.php         # Footer template
└── README.md          # This file
```

## Page Templates

- **Dashboard** (`page-dashboard.php`) - User trading dashboard
- **Market Overview** (`page-market-overview.php`) - Live market data
- **Stock Scanner** (`page-scanner.php`) - Stock search and filtering
- **Portfolio** (`page-portfolio.php`) - Portfolio management
- **News** (`page-news.php`) - Market news and analysis
- **Account Settings** (`page-account.php`) - User account management
- **Billing History** (`page-billing-history.php`) - Subscription and billing
- **Contact** (`page-contact.php`) - Contact form and support
- **About** (`page-about.php`) - Company information
- **Legal Pages** (`page-terms.php`, `page-privacy.php`) - Legal documents

## Installation

1. Upload the theme to your WordPress `/wp-content/themes/` directory
2. Activate the theme in WordPress Admin → Appearance → Themes
3. Configure the backend API URL in Appearance → Customize → Retail Trade Scanner Options
4. All required pages will be created automatically upon activation

## Backend Integration

The theme includes a REST API proxy that forwards requests to an external backend service. Configure your backend URL in the theme customizer or by defining the `RETAIL_TRADE_SCANNER_API_URL` constant in your `wp-config.php`:

```php
define('RETAIL_TRADE_SCANNER_API_URL', 'https://your-backend-api.com/api');
```

## API Endpoints

The theme proxies the following endpoints:

- `/stocks/*` - Stock data and search
- `/market-data/*` - Market overview and indices  
- `/portfolio/*` - Portfolio management
- `/watchlist/*` - Stock watchlists
- `/news/*` - Market news and analysis
- `/user/*` - User profile and settings
- `/billing/*` - Subscription and billing

## Customization

### CSS Variables

The theme uses CSS custom properties for consistent styling:

```css
:root {
  --primary-blue: #1e40af;
  --emerald-600: #059669;
  --slate-900: #0f172a;
  /* ... more variables */
}
```

### JavaScript Integration

Theme JavaScript is loaded with the handle `retail-trade-scanner-script` and includes localized data:

```javascript
retail_trade_scanner_data.rest_url     // WordPress REST API base
retail_trade_scanner_data.backend_url  // External backend URL
retail_trade_scanner_data.nonce        // Security nonce
```

## Security Features

- CSRF protection with WordPress nonces
- Input sanitization and validation
- Secure API token handling
- XSS prevention
- XML-RPC disabled
- Version information removed

## Performance Features

- Deferred JavaScript loading
- Query string removal from static assets
- Emoji scripts disabled
- Optimized database queries
- Browser caching headers

## Browser Support

- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+

## Development

For development, the theme includes:

- Console error logging
- Debug mode support
- Hot reload compatible
- Development vs production API detection

## Requirements

- WordPress 5.0+
- PHP 7.4+
- Modern browser with ES6 support

## License

This theme is licensed under the GPL v2 or later.

## Support

For support and documentation, visit the Contact page or reach out to admin@retailtradescanner.com.

## Changelog

### Version 1.1.0
- Added comprehensive page templates
- Enhanced API integration
- Improved user authentication flow
- Added billing and account management
- Performance optimizations
- Security enhancements

### Version 1.0.0
- Initial release
- Basic theme structure
- API proxy implementation
- Responsive design