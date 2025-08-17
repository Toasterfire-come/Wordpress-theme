# Retail Trade Scanner - React SPA + WordPress Integration

## Architecture Overview

This setup uses **React as the complete frontend** with **WordPress serving as the REST API backend**. WordPress handles:
- User authentication & management
- Database storage (watchlists, portfolios, user data)
- REST API endpoints
- Content management
- Email functionality

React handles:
- All UI rendering and user interactions
- Client-side routing
- Real-time data updates
- Modern SPA experience

## File Structure

```
/workspace/
├── src/                          # React application source
│   ├── pages/                    # React page components
│   ├── components/               # React UI components
│   ├── services/api.js          # WordPress REST API integration
│   └── App.js                   # React router configuration
├── functions.php                # WordPress REST API setup
├── index.php                    # Serves React app
├── header.php                   # Minimal header for React
├── footer.php                   # Minimal footer for React
├── .htaccess                    # URL routing configuration
└── page-*.php                   # Existing WordPress templates (kept)
```

## API Integration

### WordPress REST Endpoints

All endpoints are available at `/wp-json/retail-trade-scanner/v1/`:

- `GET /market-data` - Market overview data
- `GET /stocks/{symbol}` - Individual stock data
- `GET|POST|DELETE /watchlist` - Watchlist management (auth required)
- `GET|PUT /portfolio` - Portfolio management (auth required)
- `POST /contact` - Contact form submission
- `GET /status` - System status
- `GET /proxy/{endpoint}` - Proxy to external FastAPI backend

### React API Service

The `stockAPI` service in `/src/services/api.js` provides:

```javascript
import { stockAPI, wpUtils } from '../services/api';

// Market data
const marketData = await stockAPI.getMarketData();

// User authentication
if (wpUtils.isLoggedIn()) {
  const watchlist = await stockAPI.getWatchlist();
}

// External API proxy
const searchResults = await stockAPI.searchStocks('AAPL');
```

## Development Setup

### 1. Start React Development Server
```bash
cd /workspace
npm start
# Runs on http://localhost:3000
```

### 2. WordPress serves React in development
- WordPress detects no build files exist
- Automatically loads React dev server at localhost:3000
- API calls go through WordPress REST API

### 3. Production Build
```bash
npm run build
# Creates /build/ directory
# WordPress automatically serves built files
```

## URL Routing

### React Router Handles:
- `/` - Home page
- `/dashboard` - User dashboard
- `/market-overview` - Market data
- `/scanner` - Stock scanner
- `/watchlist` - Watchlist management
- `/portfolio` - Portfolio tracking
- `/news` - Market news
- `/account` - User account
- `/premium` - Premium plans
- `/contact` - Contact form
- All other app routes

### WordPress Handles:
- `/wp-admin/` - WordPress admin
- `/wp-login.php` - Authentication
- `/wp-json/` - REST API endpoints
- Static assets and uploads

## Authentication Flow

1. React app checks `wpUtils.isLoggedIn()`
2. If not logged in, redirects to `/wp-login.php`
3. After WordPress login, user returns to React app
4. React app gets user data from `window.wpApiData`
5. Authenticated API calls include WordPress nonce

## Data Flow

```
React Component → stockAPI → WordPress REST API → External FastAPI (if needed)
                                    ↓
                              WordPress Database
                                    ↓
                              Response → React State
```

## Key Features

✅ **React SPA Experience**: Fast, modern single-page application
✅ **WordPress Backend**: Robust user management and database
✅ **REST API**: Clean separation between frontend and backend
✅ **External API Proxy**: Seamless integration with FastAPI backend
✅ **Authentication**: WordPress handles login/registration
✅ **SEO Ready**: Server-side rendering for search engines
✅ **Production Ready**: Optimized builds and caching

## Environment Variables

Create `.env` file in React root:
```
REACT_APP_BACKEND_URL=http://localhost:8001
```

WordPress will automatically configure API URLs via `window.wpApiData`.

## Troubleshooting

### React not loading?
- Check if build files exist in `/build/`
- Verify WordPress is serving `index.php`
- Check browser console for errors

### API calls failing?
- Verify WordPress nonce in requests
- Check CORS headers in browser dev tools
- Ensure user is authenticated for protected endpoints

### Routing issues?
- Check `.htaccess` configuration
- Verify `template_redirect` hook in `functions.php`
- Ensure React Router is properly configured

## Security Considerations

- WordPress handles all authentication
- API endpoints use WordPress nonces
- CORS headers configured for API access
- User data stored securely in WordPress database
- External API calls proxied through WordPress for security