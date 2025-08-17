import React, { useState, useEffect } from 'react';
import { Star, Plus } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import EmptyState from '../components/common/EmptyState';
import StockCard from '../components/common/StockCard';
import { stockAPI } from '../services/api';

const Watchlist = () => {
  const [watchlist, setWatchlist] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadWatchlist();
  }, []);

  const loadWatchlist = async () => {
    setLoading(true);
    setError(null);
    try {
      const response = await stockAPI.getFormattedWatchlistData();
      if (response.success && response.data) {
        setWatchlist(Array.isArray(response.data) ? response.data : []);
      }
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <Layout>
        <PageHeader
          title="Watchlist"
          subtitle="Monitor your selected stocks with real-time updates"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingState message="Loading your watchlist..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="Watchlist"
          subtitle="Monitor your selected stocks with real-time updates"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <ErrorState 
            title="Failed to load watchlist"
            message={error}
            onRetry={loadWatchlist}
          />
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      <PageHeader
        title="Watchlist"
        subtitle="Monitor your selected stocks with real-time updates"
        actions={[
          {
            label: 'Add Stock',
            icon: Plus,
            onClick: () => window.location.href = '/scanner',
          }
        ]}
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {watchlist.length === 0 ? (
          <EmptyState
            icon={Star}
            title="Your watchlist is empty"
            message="Start by searching for stocks and adding them to your watchlist."
            actionLabel="Browse Stocks"
            onAction={() => window.location.href = '/scanner'}
          />
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {watchlist.map((stock, index) => (
              <StockCard key={index} stock={stock} />
            ))}
          </div>
        )}
      </div>
    </Layout>
  );
};

export default Watchlist;