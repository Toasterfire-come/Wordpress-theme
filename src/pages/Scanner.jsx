import React, { useState } from 'react';
import { Search, Filter, Star } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Input } from '../components/ui/input';
import StockCard from '../components/common/StockCard';
import { stockAPI } from '../services/api';

const Scanner = () => {
  const [searchQuery, setSearchQuery] = useState('');
  const [searchResults, setSearchResults] = useState([]);
  const [loading, setLoading] = useState(false);

  const handleSearch = async (e) => {
    e.preventDefault();
    if (!searchQuery.trim()) return;

    setLoading(true);
    try {
      const response = await stockAPI.searchStocks(searchQuery);
      if (response.success && response.results) {
        setSearchResults(response.results);
      }
    } catch (error) {
      console.error('Search error:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleAddToWatchlist = async (symbol) => {
    try {
      const response = await stockAPI.addToWatchlist(symbol);
      if (response.success) {
        console.log(`Added ${symbol} to watchlist`);
      }
    } catch (error) {
      console.error('Error adding to watchlist:', error);
    }
  };

  return (
    <Layout>
      <PageHeader
        title="Stock Scanner"
        subtitle="Search and analyze individual stocks with real-time data"
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <Card className="p-6 mb-8">
          <form onSubmit={handleSearch} className="flex gap-4">
            <div className="flex-1 relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 h-5 w-5" />
              <Input
                type="text"
                placeholder="Enter stock symbol (e.g., AAPL, MSFT, GOOGL)"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-10"
              />
            </div>
            <Button type="submit" loading={loading}>
              {loading ? 'Searching...' : 'Search'}
            </Button>
          </form>
        </Card>

        {searchResults.length > 0 && (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {searchResults.map((stock, index) => (
              <StockCard
                key={index}
                stock={stock}
                showAddToWatchlist={true}
                onAddToWatchlist={handleAddToWatchlist}
              />
            ))}
          </div>
        )}

        {!loading && searchResults.length === 0 && searchQuery && (
          <Card className="p-12 text-center">
            <Search className="h-12 w-12 text-slate-400 mx-auto mb-4" />
            <h3 className="text-lg font-medium text-slate-900 mb-2">No results found</h3>
            <p className="text-slate-600">Try searching for a different stock symbol.</p>
          </Card>
        )}
      </div>
    </Layout>
  );
};

export default Scanner;