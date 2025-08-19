# Retail Trade Scanner WordPress Theme - Updated Version 2.0

A professional WordPress theme for stock trading and financial data platforms, now integrated with **PayPal payment processing** and updated to use `api.retailtradescanner.com`.

## 🚀 What's New in Version 2.0

### PayPal Integration
- **Seamless Payment Processing**: Integrated PayPal SDK for subscription payments
- **Automatic Billing**: Recurring payments for Basic ($24.99/month) and Pro ($49.99/month) plans
- **Enhanced Security**: PayPal's buyer protection and secure payment processing
- **Real-time Payment Status**: Live updates on payment completion and plan activation

### Updated API Configuration  
- **New Base URL**: Now uses `https://api.retailtradescanner.com/api` as the default backend
- **Improved API Proxy**: Enhanced REST API endpoints for better performance
- **PayPal Webhook Support**: Automatic payment status updates via webhooks

### Modern UI/UX Enhancements
- **Enhanced Pricing Cards**: Improved visual design with hover effects and animations
- **Better Loading States**: Professional loading spinners and progress indicators
- **Responsive PayPal Buttons**: Mobile-optimized payment interface
- **Dark Mode Support**: Basic dark mode compatibility for modern browsers

## 📋 Features

- **Real-time Market Data**: Integration with external APIs for live stock market data
- **Portfolio Management**: Track and analyze investment portfolios
- **User Authentication**: Secure login and account management
- **PayPal Subscriptions**: Automated recurring billing system
- **Responsive Design**: Mobile-first design with enhanced Tailwind CSS styling
- **API Integration**: RESTful API proxy for seamless backend communication
- **Performance Optimized**: Fast loading with modern web standards

## 🛠 Installation & Setup

### Prerequisites
- WordPress 5.0+
- PHP 7.4+
- PayPal Business Account
- Modern browser with ES6 support

### Step 1: Theme Installation
1. Upload the theme to your WordPress `/wp-content/themes/` directory
2. Activate the theme in WordPress Admin → Appearance → Themes
3. All required pages will be created automatically upon activation

### Step 2: PayPal Configuration
1. Create a PayPal Business account at [developer.paypal.com](https://developer.paypal.com/)
2. Create a new application and note your **Client ID** and **Client Secret**
3. In WordPress Admin, go to **Appearance → Customize → Retail Trade Scanner Options**
4. Enter your PayPal Client ID
5. Save the settings

### Step 3: API Configuration
The theme is pre-configured to use `https://api.retailtradescanner.com/api`. You can modify this in:
- **WordPress Customizer**: Appearance → Customize → Retail Trade Scanner Options
- **wp-config.php**: Add `define('RETAIL_TRADE_SCANNER_API_URL', 'your-api-url');`

## 📁 Theme Structure

```
retail-trade-scanner-theme/
├── assets/
│   ├── css/           # Additional stylesheets  
│   └── js/            # JavaScript files (with PayPal integration)
├── page-*.php         # Custom page templates
├── functions.php      # Theme functionality (with PayPal REST endpoints)
├── style.css          # Main stylesheet (enhanced with PayPal styles)
├── index.php          # Main template
├── header.php         # Header template
├── footer.php         # Footer template
└── README.md          # This file
```

## 🎯 Page Templates

- **Dashboard** (`page-dashboard.php`) - User trading dashboard
- **Market Overview** (`page-market-overview.php`) - Live market data
- **Stock Scanner** (`page-scanner.php`) - Stock search and filtering
- **Portfolio** (`page-portfolio.php`) - Portfolio management
- **News** (`page-news.php`) - Market news and analysis
- **Account Settings** (`page-account.php`) - User account management
- **Billing History** (`page-billing-history.php`) - **Enhanced with PayPal integration**
- **Premium Plans** (`page-premium-plans.php`) - **PayPal subscription checkout**
- **Contact** (`page-contact.php`) - Contact form and support
- **Legal Pages** (`page-terms.php`, `page-privacy.php`) - Legal documents

## 💳 PayPal Integration Details

### Payment Flow
1. User selects a plan on the Premium Plans page
2. PayPal button initiates secure checkout
3. Payment is processed through PayPal's API
4. Webhook confirms payment completion
5. User's subscription is activated automatically
6. Billing history is updated in real-time

### API Endpoints
The theme includes these PayPal-specific REST endpoints:
- `/wp-json/retail-trade-scanner/v1/paypal/create-order` - Create payment order
- `/wp-json/retail-trade-scanner/v1/paypal/capture-order/{id}` - Capture completed payment  
- `/wp-json/retail-trade-scanner/v1/paypal/webhook` - Handle PayPal webhooks

### Security Features
- **WordPress Nonces**: CSRF protection for all API calls
- **User Authentication**: Payment endpoints require logged-in users
- **PayPal Validation**: Webhook signature verification
- **Input Sanitization**: All data is sanitized and validated

## 🎨 Customization

### CSS Variables (Enhanced)
```css
:root {
  --primary-blue: #1e40af;
  --emerald-600: #059669;
  --slate-900: #0f172a;
  --paypal-blue: #0070ba;      /* New PayPal brand color */
  --paypal-gold: #ffc439;      /* New PayPal accent color */
  /* ... more variables */
}
```

### JavaScript Integration
Enhanced theme JavaScript with PayPal functions:
```javascript
// Available global functions
window.createPayPalOrder(planType, amount)
window.capturePayPalOrder(orderId)
window.showNotification(message, type)
```

### WordPress Hooks & Filters
```php
// Customize PayPal configuration
add_filter('retail_trade_scanner_paypal_config', function($config) {
    $config['currency'] = 'EUR'; // Change currency
    return $config;
});

// Modify payment success redirect
add_filter('retail_trade_scanner_payment_success_redirect', function($url) {
    return home_url('/welcome');
});
```

## 🚀 Performance Features

- **Deferred JavaScript Loading**: PayPal SDK loaded asynchronously
- **Query String Removal**: Clean static asset URLs
- **Emoji Scripts Disabled**: Reduced HTTP requests
- **Optimized Database Queries**: Efficient data fetching
- **Browser Caching Headers**: Improved load times
- **Compressed Assets**: Minified CSS and JavaScript

## 📱 Browser Support

- **Chrome 60+** (Full PayPal support)
- **Firefox 60+** (Full PayPal support)  
- **Safari 12+** (Full PayPal support)
- **Edge 79+** (Full PayPal support)
- **Mobile browsers** (Responsive PayPal interface)

## 🔧 Development

### Local Development Setup
1. Set PayPal to Sandbox mode in `functions.php`
2. Use PayPal's test accounts for development
3. Enable WordPress debug mode
4. Use browser developer tools for PayPal debugging

### Environment Variables
```php
// wp-config.php
define('RETAIL_TRADE_SCANNER_API_URL', 'https://api.retailtradescanner.com/api');
define('PAYPAL_CLIENT_ID', 'your-paypal-client-id');
define('PAYPAL_CLIENT_SECRET', 'your-paypal-secret'); // Backend use only
```

## 📊 Monitoring & Analytics

### Payment Tracking
- All PayPal transactions are logged
- Billing history automatically updated
- Failed payment notifications
- Revenue analytics through PayPal dashboard

### Error Handling
- Console error logging in development
- PayPal API error handling
- User-friendly error messages
- Automatic retry mechanisms

## 🔒 Security & Compliance

### PayPal Security
- **PCI Compliance**: PayPal handles all sensitive payment data
- **SSL Required**: HTTPS enforced for all payment pages
- **Webhook Validation**: Cryptographic signature verification
- **Token Security**: Secure API token handling

### WordPress Security
- **Input Sanitization**: All user input validated
- **XSS Prevention**: Output properly escaped
- **CSRF Protection**: WordPress nonces on all forms
- **Version Hiding**: WordPress version information removed

## 📞 Support & Documentation

- **Theme Support**: Contact via the theme's Contact page
- **PayPal Integration**: Refer to [PayPal Developer Documentation](https://developer.paypal.com/)
- **API Documentation**: Check the backend API documentation at `api.retailtradescanner.com/docs`
- **WordPress Forums**: Community support available

## 📝 Changelog

### Version 2.0.0 (Latest)
- ✅ **Added**: Full PayPal integration for subscription payments
- ✅ **Updated**: API base URL to `api.retailtradescanner.com`  
- ✅ **Enhanced**: Billing history page with PayPal transaction details
- ✅ **Improved**: Premium plans page with integrated PayPal checkout
- ✅ **Added**: Real-time payment status updates
- ✅ **Enhanced**: Mobile-responsive PayPal interface
- ✅ **Added**: Comprehensive error handling and user feedback
- ✅ **Improved**: CSS architecture with PayPal brand colors
- ✅ **Added**: Dark mode support preparations

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

## 📋 Requirements for PayPal Integration

### Backend API Requirements
Your backend at `api.retailtradescanner.com` should support these endpoints:
- `POST /paypal/create-order` - Create PayPal order
- `POST /paypal/capture-order/{id}` - Capture payment
- `POST /paypal/webhook` - Handle webhooks
- `GET /billing/history` - Retrieve billing history
- `GET /billing/summary` - Get billing summary

### PayPal Developer Account Setup
1. Visit [developer.paypal.com](https://developer.paypal.com/)
2. Create a business account
3. Create a new application
4. Copy Client ID and Secret
5. Configure webhook URL: `your-site.com/wp-json/retail-trade-scanner/v1/paypal/webhook`

## 🎯 Next Steps

1. **Test PayPal Integration**: Use PayPal's sandbox for testing
2. **Configure Webhooks**: Set up webhook URL in PayPal developer dashboard  
3. **Customize Branding**: Update colors and styles to match your brand
4. **Add Analytics**: Integrate with Google Analytics for tracking
5. **Deploy SSL**: Ensure HTTPS is enabled for payment security

## 📄 License

This theme is licensed under the GPL v2 or later.

---

**Retail Trade Scanner Theme v2.0** - Professional trading platform with seamless PayPal integration.