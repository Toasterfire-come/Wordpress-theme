import React, { createContext, useContext, useEffect, useState } from 'react';
import { stockAPI } from '../services/api';

const AuthContext = createContext({
  user: null,
  loading: true,
  isAuthenticated: false,
  refresh: async () => {},
});

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  const loadUser = async () => {
    setLoading(true);
    try {
      const response = await stockAPI.getUserAccount();
      if (response && (response.success !== false)) {
        // Support various response shapes
        const data = response.data || response.user || response;
        setUser(data || null);
      } else {
        setUser(null);
      }
    } catch (e) {
      setUser(null);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadUser();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  const value = {
    user,
    loading,
    isAuthenticated: !!user,
    refresh: loadUser,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};

export const useAuth = () => useContext(AuthContext);

