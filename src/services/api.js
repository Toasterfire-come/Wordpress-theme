// Stock Scanner Pro - WordPress REST API Integration
// Professional API service for React SPA with WordPress backend

import React from 'react';

// Get WordPress API configuration from localized data
const getWpApiData = () => {
  return window.wpApiData || {
    apiUrl: '/wp-json/retail-trade-scanner/v1/',
    wpRestUrl: '/wp-json/wp/v2/',
    nonce: '',
    homeUrl: '/',
    isLoggedIn: false,
    currentUser: null
  };
};

// WordPress REST API Handler
export const wpApiCall = async (endpoint, options = {}) => {
  const wpData = getWpApiData();
  const url = endpoint.startsWith('http') ? endpoint : `${wpData.apiUrl}${endpoint.replace(/^\//, '')}`;
  
  try {
    const response = await fetch(url, {
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': wpData.nonce,
        ...options.headers
      },
      credentials: 'same-origin',
      ...options
    });
    
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    
    const result = await response.json();
    return result;
  } catch (error) {
    console.error(`WordPress API Error (${endpoint}):`, error);
    return { success: false, error: error.message };
  }
};

// External API proxy through WordPress
export const externalApiCall = async (endpoint, options = {}) => {
  return await wpApiCall(`proxy/${endpoint}`, options);
};

// WordPress native REST API calls
export const wpRestCall = async (endpoint, options = {}) => {
  const wpData = getWpApiData();
  const url = `${wpData.wpRestUrl}${endpoint.replace(/^\//, '')}`;
  
  try {
    const response = await fetch(url, {
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': wpData.nonce,
        ...options.headers
      },
      credentials: 'same-origin',
      ...options
    });
    
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    
    return await response.json();
  } catch (error) {
    console.error(`WordPress REST Error (${endpoint}):`, error);
    return { success: false, error: error.message };
  }
};

// Main Stock Scanner API Integration
export const stockAPI = {
  // Market Data
  async getMarketData() {
    return await wpApiCall('market-data');
  },

  async getMajorIndices() {
    return await wpApiCall('market-data');
  },

  async getMarketMovers() {
    return await wpApiCall('market-data');
  },

  // Stock Data
  async getStockQuote(symbol) {
    return await wpApiCall(`stocks/${symbol}`);
  },

  async getStockData(symbol) {
    return await wpApiCall(`stocks/${symbol}`);
  },

  async searchStocks(query) {
    return await externalApiCall(`stocks/search?q=${encodeURIComponent(query)}`);
  },

  // Watchlist Management (requires authentication)
  async getWatchlist() {
    return await wpApiCall('watchlist');
  },

  async addToWatchlist(symbol) {
    return await wpApiCall('watchlist', {
      method: 'POST',
      body: JSON.stringify({ symbol })
    });
  },

  async removeFromWatchlist(symbol) {
    return await wpApiCall(`watchlist?symbol=${symbol}`, {
      method: 'DELETE'
    });
  },

  // Portfolio Management (requires authentication)
  async getPortfolio() {
    return await wpApiCall('portfolio');
  },

  async updatePortfolio(portfolioData) {
    return await wpApiCall('portfolio', {
      method: 'PUT',
      body: JSON.stringify(portfolioData)
    });
  },

  // Contact Form
  async submitContactForm(formData) {
    return await wpApiCall('contact', {
      method: 'POST',
      body: JSON.stringify(formData)
    });
  },

  // System Status
  async getSystemStatus() {
    return await wpApiCall('status');
  },

  // News (proxy to external API)
  async getNews(limit = 10) {
    return await externalApiCall(`news?limit=${limit}`);
  },

  async getStockNews(ticker, limit = 5) {
    return await externalApiCall(`news/stock/${ticker}?limit=${limit}`);
  },

  // User Management (WordPress native)
  async getCurrentUser() {
    const wpData = getWpApiData();
    if (!wpData.isLoggedIn) {
      return { success: false, error: 'Not logged in' };
    }
    return { success: true, data: wpData.currentUser };
  },

  async updateUserProfile(userData) {
    const wpData = getWpApiData();
    if (!wpData.isLoggedIn) {
      return { success: false, error: 'Not logged in' };
    }
    
    return await wpRestCall(`users/${wpData.currentUser.ID}`, {
      method: 'POST',
      body: JSON.stringify(userData)
    });
  },

  // Authentication (these would typically redirect to WordPress login/register pages)
  async loginUser(credentials) {
    // Redirect to WordPress login
    window.location.href = `${getWpApiData().homeUrl}wp-login.php`;
    return { success: true };
  },

  async registerUser(userData) {
    // Redirect to WordPress registration or custom signup page
    window.location.href = `${getWpApiData().homeUrl}wp-login.php?action=register`;
    return { success: true };
  },

  async logoutUser() {
    // Redirect to WordPress logout
    window.location.href = `${getWpApiData().homeUrl}wp-login.php?action=logout`;
    return { success: true };
  },

  // Usage Statistics
  async getUsageStats() {
    return await wpApiCall('usage-stats');
  },

  // PayPal Integration (proxy to external API)
  async createPayPalOrder(planId, amount) {
    return await externalApiCall('payments/paypal/create-order', {
      method: 'POST',
      body: JSON.stringify({ plan_id: planId, amount })
    });
  },

  async capturePayPalOrder(orderId) {
    return await externalApiCall('payments/paypal/capture-order', {
      method: 'POST',
      body: JSON.stringify({ order_id: orderId })
    });
  },

  // Newsletter Subscription
  async subscribeNewsletter(email) {
    return await wpApiCall('newsletter/subscribe', {
      method: 'POST',
      body: JSON.stringify({ email })
    });
  }
};

// Utility hook for API calls with loading states
export const useAsync = (deps, asyncFunction) => {
  const [state, setState] = React.useState({ 
    loading: true, 
    data: null, 
    error: null 
  });
  
  React.useEffect(() => {
    let cancelled = false;
    setState({ loading: true, data: null, error: null });
    
    Promise.resolve()
      .then(asyncFunction)
      .then(data => {
        if (!cancelled) {
          setState({ loading: false, data, error: null });
        }
      })
      .catch(error => {
        if (!cancelled) {
          setState({ 
            loading: false, 
            data: null, 
            error: error?.message || 'Unknown error' 
          });
        }
      });
    
    return () => { cancelled = true; };
  }, deps);
  
  return state;
};

// Loading state hook with retry functionality
export const useAsyncWithRetry = (deps, asyncFunction, retryCount = 3) => {
  const [state, setState] = React.useState({ 
    loading: true, 
    data: null, 
    error: null,
    retryAttempt: 0
  });
  
  const executeFunction = React.useCallback(async (attempt = 0) => {
    if (attempt === 0) {
      setState(prev => ({ ...prev, loading: true, error: null }));
    }
    
    try {
      const data = await asyncFunction();
      setState({ loading: false, data, error: null, retryAttempt: 0 });
    } catch (error) {
      if (attempt < retryCount) {
        setState(prev => ({ ...prev, retryAttempt: attempt + 1 }));
        setTimeout(() => executeFunction(attempt + 1), 1000 * (attempt + 1));
      } else {
        setState({ 
          loading: false, 
          data: null, 
          error: error?.message || 'Unknown error',
          retryAttempt: attempt 
        });
      }
    }
  }, [asyncFunction, retryCount]);
  
  React.useEffect(() => {
    executeFunction();
  }, deps);
  
  const retry = () => executeFunction();
  
  return { ...state, retry };
};

// WordPress-specific utilities
export const wpUtils = {
  isLoggedIn: () => getWpApiData().isLoggedIn,
  getCurrentUser: () => getWpApiData().currentUser,
  getHomeUrl: () => getWpApiData().homeUrl,
  getSiteName: () => getWpApiData().siteName,
  getSiteDescription: () => getWpApiData().siteDescription,
  
  // Generate WordPress URLs
  getLoginUrl: () => `${getWpApiData().homeUrl}wp-login.php`,
  getRegisterUrl: () => `${getWpApiData().homeUrl}wp-login.php?action=register`,
  getLogoutUrl: () => `${getWpApiData().homeUrl}wp-login.php?action=logout&_wpnonce=${getWpApiData().nonce}`,
  getAdminUrl: () => `${getWpApiData().homeUrl}wp-admin/`,
  
  // Handle WordPress redirects
  redirectToLogin: () => {
    window.location.href = wpUtils.getLoginUrl();
  },
  
  redirectToRegister: () => {
    window.location.href = wpUtils.getRegisterUrl();
  },
  
  redirectToLogout: () => {
    window.location.href = wpUtils.getLogoutUrl();
  }
};

export default stockAPI;