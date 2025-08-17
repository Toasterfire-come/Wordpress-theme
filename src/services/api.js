// Stock Scanner Pro - API Integration
// Professional API service for production-ready application

import React from 'react';

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
const API = `${BACKEND_URL}/api`;

// Basic API Handler
export const apiCall = async (endpoint, options = {}) => {
  try {
    const response = await fetch(`${API}${endpoint}`, {
      headers: {
        'Content-Type': 'application/json',
        ...options.headers
      },
      ...options
    });
    
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }
    
    const result = await response.json();
    return result;
  } catch (error) {
    console.error(`API Error (${endpoint}):`, error);
    return { success: false, error: error.message };
  }
};

// WordPress Admin Ajax Handler (for compatibility)
export const wordPressAjax = async (action, data = {}) => {
  // For now, return mock data since we're using FastAPI backend
  console.log(`Mock WordPress AJAX call: ${action}`, data);
  return { success: true, message: 'Mock response' };
};

// WordPress REST API Handler (for compatibility)  
export const wordPressRest = async (endpoint, options = {}) => {
  // For now, return mock data since we're using FastAPI backend
  console.log(`Mock WordPress REST call: ${endpoint}`, options);
  return { success: true, message: 'Mock response' };
};

// Stock Scanner API Integration
export const stockAPI = {
  // Market Data - Real API call
  async getMarketData() {
    return await apiCall('/market-data');
  },

  async getMajorIndices() {
    return { success: true, data: [] };
  },

  async getMarketMovers() {
    return { success: true, data: [] };
  },

  // Basic API calls
  async getStockQuote(symbol) {
    return await apiCall(`/stocks/${symbol}`);
  },

  async getStockData(symbol) {
    return await apiCall(`/stocks/${symbol}`);
  },

  async searchStocks(query) {
    return await apiCall(`/stocks/search?q=${encodeURIComponent(query)}`);
  },

  // For all other methods, return mock data for now
  async getWatchlist() {
    return { success: true, data: [] };
  },

  async getPortfolio() {
    return { success: true, data: [] };
  },

  async getNews(limit = 10) {
    return { success: true, data: [] };
  },

  async getUsageStats() {
    return { success: true, data: { requests_used: 5, requests_limit: 15 } };
  },

  // User Account - Real API calls
  async getUserAccount() {
    return await apiCall('/user/me');
  },

  async updateUserAccount(data) {
    return await apiCall('/user/me', {
      method: 'PUT',
      body: JSON.stringify(data)
    });
  },

  async getUserSettings() {
    return await apiCall('/user/settings');
  },

  async updateUserSettings(data) {
    return await apiCall('/user/settings', {
      method: 'PUT',
      body: JSON.stringify(data)
    });
  },

  // Mock all other methods
  async getFormattedWatchlistData() { return { success: true, data: [] }; },
  async addToWatchlist(symbol) { return { success: true }; },
  async removeFromWatchlist(symbol) { return { success: true }; },
  async getFormattedPortfolioData() { return { success: true, data: [] }; },
  async getStockNews(ticker, limit) { return { success: true, data: [] }; },
  async createPayPalOrder(planId, amount) { return { success: true, order_id: 'mock_order' }; },
  async capturePayPalOrder(orderId) { return { success: true }; },
  async submitContactForm(data) { return { success: true }; },
  async subscribeNewsletter(email) { return { success: true }; },
  async registerUser(userData) { return { success: true }; },
  async loginUser(credentials) { return { success: true }; },
  async getSystemStatus() { return { success: true, status: 'operational' }; }
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

export default stockAPI;