# Retail Trade Scanner WordPress Theme

A professional WordPress theme that integrates React components with WordPress functionality, designed for stock trading and portfolio management platforms.

## Features

### ✅ **Completed Features**
- **Rebranded** from "Stock Scanner Pro" to "Retail Trade Scanner"
- **Contact banner removed** entirely (no phone/email display)
- **Expandable search bar** - clicks to expand, searches stocks via API
- **No 2FA functionality** - removed from all account settings
- **Complete account management** without placeholder text:
  - Change password functionality
  - Payment method management  
  - Billing history with download capabilities
  - Manage subscription plans
- **Notifications page** with comprehensive settings:
  - Trading alerts (price, volume, market hours)
  - Portfolio updates (daily, weekly, milestone alerts)  
  - News & market updates
  - Account & security notifications
- **WordPress + React hybrid architecture**
- **REST API integration** with external backend
- **Real-time market data** updated every 3 minutes
- **Professional UI/UX** with Tailwind-inspired styling

### 🔧 **Technical Architecture**

#### WordPress Theme Structure
```
/app/
├── style.css              # Theme stylesheet with CSS variables
├── functions.php          # WordPress functions & API proxy
├── header.php            # Header with expandable search
├── footer.php            # Footer without contact info  
├── index.php             # Main template with React integration
├── page-account.php      # Account settings (no 2FA)
├── page-notifications.php # Notification management
├── page-billing-history.php # Billing & payment history
└── assets/
    └── js/
        └── main.js       # Main JavaScript with API integration
```

#### React Integration
- **Hybrid approach**: WordPress serves pages, React handles dynamic components
- **API Proxy**: WordPress proxies requests to external REST API backend
- **Real-time updates**: Market data refreshed every 3 minutes
- **Local storage**: Non-sensitive data stored locally in browser
- **Backend integration**: All account management connects to existing REST API

#### API Integration Points
The theme connects to your REST API backend through WordPress proxy endpoints:

**User Management:**
- `POST /wp-json/retail-trade-scanner/v1/proxy/user/profile` - Update profile
- `POST /wp-json/retail-trade-scanner/v1/proxy/user/change-password` - Change password  
- `POST /wp-json/retail-trade-scanner/v1/proxy/user/update-payment` - Update payment method
- `GET /wp-json/retail-trade-scanner/v1/proxy/user/billing-history` - Get billing history
- `POST /wp-json/retail-trade-scanner/v1/proxy/user/notification-settings` - Save notifications

**Market Data:**
- `GET /wp-json/retail-trade-scanner/v1/proxy/market-data` - Real-time market overview
- `GET /wp-json/retail-trade-scanner/v1/proxy/stocks/search?q={symbol}` - Stock search
- `GET /wp-json/retail-trade-scanner/v1/proxy/stocks/{symbol}` - Stock details

## Installation

### 1. **WordPress Setup**
```bash
# Copy theme to WordPress themes directory
cp -r /app/* /path/to/wordpress/wp-content/themes/retail-trade-scanner/

# Activate theme in WordPress admin
# Appearance > Themes > Activate "Retail Trade Scanner"
```

### 2. **Backend API Configuration**
In your WordPress `wp-config.php`, add:
```php
// Your REST API backend URL
define('RETAIL_TRADE_SCANNER_API_URL', 'http://your-backend-api.com/api');
```

### 3. **Dependencies Installation**
```bash
cd /path/to/theme/
yarn install
```

### 4. **React Development** (Optional)
For React development mode:
```bash
# Start React development server  
yarn start

# Build for production
yarn build
```

## Configuration

### **WordPress Customizer Settings**
- Go to **Appearance > Customize > Retail Trade Scanner Options**
- Set your **API Endpoint URL** to connect to your backend
- Configure other theme options as needed

### **Menu Setup**  
- Go to **Appearance > Menus**
- Create navigation menu with links to:
  - Dashboard, Scanner, Watchlist, Portfolio, News, Plans, Contact

### **Page Templates**
The theme automatically creates required pages on activation:
- Home, Dashboard, Market Overview, Scanner, Watchlist, Portfolio
- Account, Notifications, Billing History, Premium Plans
- Contact, Login, Signup, Terms, Privacy, etc.

## Key Features Implementation

### 🔍 **Expandable Search Bar**
- Located in header, expands on click/focus
- Real-time stock symbol search with API integration
- Dropdown results with stock prices and changes
- Navigate to stock details on selection

### ⚙️ **Account Settings (No 2FA)**  
- **Profile Management**: Update name, email, phone, company
- **Security**: Change password (removed 2FA completely)
- **Billing**: Manage payment methods, view subscription
- **Notifications**: Comprehensive notification preferences

### 🔔 **Notifications Management**
- **Trading Alerts**: Price alerts, volume alerts, market hours  
- **Portfolio Updates**: Daily summaries, weekly reports, milestone alerts
- **News & Market**: Breaking news, earnings alerts, analyst ratings
- **Security**: Login alerts, billing updates, plan changes
- **Quick Actions**: Enable/disable all, reset to defaults
- **Real-time toggles**: Immediate UI feedback with backend sync

### 💳 **Billing & Payment Management**
- **Current Plan Display**: Show active subscription details
- **Payment History**: Downloadable invoices, filterable by year
- **Payment Methods**: Update credit cards, billing info  
- **Plan Management**: Upgrade/downgrade subscription
- **Export Functionality**: CSV export of billing history

### 📊 **Real-time Market Data**
- **Market Overview**: Updated every 3 minutes during trading hours
- **Live Ticker**: S&P 500 data in header
- **Stock Search**: Real-time stock symbol lookup
- **Portfolio Integration**: Live portfolio values and changes

## API Endpoints Expected

Your backend should provide these endpoints for full functionality:

### Authentication & User Management
```
POST /api/auth/login
POST /api/auth/logout  
GET /api/user/profile
POST /api/user/profile
POST /api/user/change-password
POST /api/user/update-payment
GET /api/user/billing-history
POST /api/user/notification-settings
GET /api/user/notification-settings
```

### Market Data  
```
GET /api/market-data
GET /api/stocks/search?q={query}
GET /api/stocks/{symbol}
GET /api/trending
GET /api/news?limit={number}
```

### Portfolio & Watchlist
```
GET /api/portfolio
POST /api/portfolio/add
DELETE /api/portfolio/{id}
GET /api/watchlist  
POST /api/watchlist/add
DELETE /api/watchlist/{id}
```

## Customization

### **Styling**
- CSS variables defined in `style.css` for easy color scheme changes
- Tailwind-inspired utility classes available
- Responsive design with mobile-first approach

### **Branding**
- All "Stock Scanner Pro" references changed to "Retail Trade Scanner"
- Logo and company name easily customizable in header.php
- Footer branding updated throughout

### **Functionality Extensions**
- Add new page templates following existing patterns
- Extend API integration in `assets/js/main.js`
- Add new notification types in notifications page
- Customize account settings in `page-account.php`

## Support & Documentation

### **File Structure Guide**
- `functions.php` - Core WordPress functionality, API proxy, theme setup
- `header.php` - Navigation, search bar, market ticker
- `footer.php` - Footer links, company branding
- `page-*.php` - Individual page templates with React integration
- `assets/js/main.js` - Frontend JavaScript, API calls, UI interactions

### **Development Notes**
- Theme uses WordPress REST API for backend communication
- React components can be added to any page template
- Market data automatically refreshes every 3 minutes
- All forms include proper nonce verification for security
- Responsive design works on all device sizes

## License
GPL v2 or later - Standard WordPress theme license

---

**Ready for Production**: This theme is built for production use with proper error handling, security measures, and performance optimization.
