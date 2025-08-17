import React, { useState, useEffect } from 'react';
import { Plus, Filter, ArrowUpDown, MoreHorizontal, Trash2, Edit, Star } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState, LoadingCard } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import EmptyState from '../components/common/EmptyState';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Input } from '../components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../components/ui/select';
import { Checkbox } from '../components/ui/checkbox';
import { stockAPI } from '../services/api';

const EnhancedWatchlist = () => {
  const [watchlist, setWatchlist] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [selectedStocks, setSelectedStocks] = useState([]);
  const [filterBy, setFilterBy] = useState('all');
  const [sortBy, setSortBy] = useState('symbol');
  const [sortOrder, setSortOrder] = useState('asc');
  const [searchQuery, setSearchQuery] = useState('');

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
      } else {
        setWatchlist([]);
      }
    } catch (err) {
      setError(err.message);
      setWatchlist([]);
    } finally {
      setLoading(false);
    }
  };

  const handleRemoveFromWatchlist = async (symbol) => {
    try {
      const response = await stockAPI.removeFromWatchlist(symbol);
      if (response.success) {
        setWatchlist(prev => prev.filter(stock => stock.symbol !== symbol));
        setSelectedStocks(prev => prev.filter(s => s !== symbol));
      }
    } catch (error) {
      console.error('Error removing from watchlist:', error);
    }
  };

  const handleBulkRemove = async () => {
    if (selectedStocks.length === 0) return;
    
    try {
      await Promise.all(selectedStocks.map(symbol => stockAPI.removeFromWatchlist(symbol)));
      setWatchlist(prev => prev.filter(stock => !selectedStocks.includes(stock.symbol)));
      setSelectedStocks([]);
    } catch (error) {
      console.error('Error removing stocks:', error);
    }
  };

  const toggleSelectAll = () => {
    if (selectedStocks.length === filteredWatchlist.length) {
      setSelectedStocks([]);
    } else {
      setSelectedStocks(filteredWatchlist.map(stock => stock.symbol));
    }
  };

  const toggleSelectStock = (symbol) => {
    setSelectedStocks(prev => 
      prev.includes(symbol) 
        ? prev.filter(s => s !== symbol)
        : [...prev, symbol]
    );
  };

  // Filter and sort watchlist
  const filteredWatchlist = React.useMemo(() => {
    let filtered = [...watchlist];

    // Search filter
    if (searchQuery) {
      filtered = filtered.filter(stock => 
        stock.symbol?.toLowerCase().includes(searchQuery.toLowerCase()) ||
        stock.company_name?.toLowerCase().includes(searchQuery.toLowerCase())
      );
    }

    // Category filter
    if (filterBy !== 'all') {
      if (filterBy === 'gainers') {
        filtered = filtered.filter(stock => (stock.change_percent || 0) > 0);
      } else if (filterBy === 'losers') {
        filtered = filtered.filter(stock => (stock.change_percent || 0) < 0);
      }
    }

    // Sort
    filtered.sort((a, b) => {
      let aVal = a[sortBy] || 0;
      let bVal = b[sortBy] || 0;
      
      if (typeof aVal === 'string') {
        aVal = aVal.toLowerCase();
        bVal = bVal.toLowerCase();
      }

      if (sortOrder === 'desc') {
        return bVal > aVal ? 1 : -1;
      }
      return aVal > bVal ? 1 : -1;
    });

    return filtered;
  }, [watchlist, searchQuery, filterBy, sortBy, sortOrder]);

  const formatPrice = (price) => price ? `$${price.toFixed(2)}` : 'N/A';
  const formatPercent = (percent) => {
    if (!percent) return '0.00%';
    const sign = percent > 0 ? '+' : '';
    return `${sign}${percent.toFixed(2)}%`;
  };

  if (loading) {
    return (
      <Layout>
        <PageHeader
          title="Enhanced Watchlist"
          subtitle="Advanced watchlist with filters, sorting, and analytics"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingCard title="Loading your watchlist..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="Enhanced Watchlist"
          subtitle="Advanced watchlist with filters, sorting, and analytics"
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
        title="Enhanced Watchlist"
        subtitle="Advanced watchlist with filters, sorting, and analytics"
        actions={[
          {
            label: 'Add Stock',
            icon: Plus,
            onClick: () => window.location.href = '/scanner',
          }
        ]}
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Filters and Controls */}
        <Card className="p-6 mb-6">
          <div className="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            {/* Search and Filters */}
            <div className="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
              <Input
                placeholder="Search stocks..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="max-w-xs"
              />
              
              <Select value={filterBy} onValueChange={setFilterBy}>
                <SelectTrigger className="w-[150px]">
                  <Filter className="h-4 w-4 mr-2" />
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Stocks</SelectItem>
                  <SelectItem value="gainers">Gainers Only</SelectItem>
                  <SelectItem value="losers">Losers Only</SelectItem>
                </SelectContent>
              </Select>

              <Select value={sortBy} onValueChange={setSortBy}>
                <SelectTrigger className="w-[150px]">
                  <ArrowUpDown className="h-4 w-4 mr-2" />
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="symbol">Symbol</SelectItem>
                  <SelectItem value="company_name">Company</SelectItem>
                  <SelectItem value="current_price">Price</SelectItem>
                  <SelectItem value="change_percent">Change %</SelectItem>
                  <SelectItem value="volume">Volume</SelectItem>
                </SelectContent>
              </Select>

              <Button
                variant="outline"
                onClick={() => setSortOrder(sortOrder === 'asc' ? 'desc' : 'asc')}
                className="px-3"
              >
                {sortOrder === 'asc' ? '↑' : '↓'}
              </Button>
            </div>

            {/* Bulk Actions */}
            {selectedStocks.length > 0 && (
              <div className="flex items-center space-x-3">
                <span className="text-sm text-slate-600">
                  {selectedStocks.length} selected
                </span>
                <Button
                  variant="outline"
                  size="sm"
                  onClick={handleBulkRemove}
                  className="text-red-600 hover:text-red-700"
                >
                  <Trash2 className="h-4 w-4 mr-2" />
                  Remove Selected
                </Button>
              </div>
            )}
          </div>
        </Card>

        {/* Watchlist Table */}
        {filteredWatchlist.length === 0 ? (
          <EmptyState
            icon={Star}
            title="Your watchlist is empty"
            message="Start by searching for stocks and adding them to your watchlist."
            actionLabel="Browse Stocks"
            onAction={() => window.location.href = '/scanner'}
          />
        ) : (
          <Card>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="border-b border-slate-200">
                    <th className="text-left py-4 px-6">
                      <Checkbox
                        checked={selectedStocks.length === filteredWatchlist.length}
                        onCheckedChange={toggleSelectAll}
                      />
                    </th>
                    <th className="text-left py-4 px-6 font-semibold text-slate-900">Symbol</th>
                    <th className="text-left py-4 px-6 font-semibold text-slate-900">Company</th>
                    <th className="text-right py-4 px-6 font-semibold text-slate-900">Price</th>
                    <th className="text-right py-4 px-6 font-semibold text-slate-900">Change</th>
                    <th className="text-right py-4 px-6 font-semibold text-slate-900">Change %</th>
                    <th className="text-right py-4 px-6 font-semibold text-slate-900">Volume</th>
                    <th className="text-center py-4 px-6 font-semibold text-slate-900">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {filteredWatchlist.map((stock) => {
                    const isPositive = (stock.change_percent || 0) > 0;
                    const isSelected = selectedStocks.includes(stock.symbol);
                    
                    return (
                      <tr 
                        key={stock.symbol} 
                        className={`border-b border-slate-100 hover:bg-slate-50 ${isSelected ? 'bg-blue-50' : ''}`}
                      >
                        <td className="py-4 px-6">
                          <Checkbox
                            checked={isSelected}
                            onCheckedChange={() => toggleSelectStock(stock.symbol)}
                          />
                        </td>
                        <td className="py-4 px-6">
                          <div className="font-bold text-slate-900">{stock.symbol}</div>
                        </td>
                        <td className="py-4 px-6">
                          <div className="text-slate-600 truncate max-w-xs">
                            {stock.company_name || 'N/A'}
                          </div>
                        </td>
                        <td className="py-4 px-6 text-right">
                          <div className="font-semibold text-slate-900">
                            {formatPrice(stock.current_price)}
                          </div>
                        </td>
                        <td className="py-4 px-6 text-right">
                          <div className={`font-semibold ${isPositive ? 'text-green-600' : 'text-red-600'}`}>
                            {isPositive ? '+' : ''}{formatPrice(stock.price_change_today)}
                          </div>
                        </td>
                        <td className="py-4 px-6 text-right">
                          <div className={`font-semibold ${isPositive ? 'text-green-600' : 'text-red-600'}`}>
                            {formatPercent(stock.change_percent)}
                          </div>
                        </td>
                        <td className="py-4 px-6 text-right">
                          <div className="text-slate-600">
                            {stock.volume ? stock.volume.toLocaleString() : 'N/A'}
                          </div>
                        </td>
                        <td className="py-4 px-6 text-center">
                          <Button
                            variant="ghost"
                            size="sm"
                            onClick={() => handleRemoveFromWatchlist(stock.symbol)}
                            className="text-red-600 hover:text-red-700"
                          >
                            <Trash2 className="h-4 w-4" />
                          </Button>
                        </td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>
            </div>
          </Card>
        )}

        {/* Statistics */}
        {filteredWatchlist.length > 0 && (
          <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Total Stocks</h3>
              <p className="text-2xl font-bold text-slate-900">{filteredWatchlist.length}</p>
            </Card>
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Gainers</h3>
              <p className="text-2xl font-bold text-green-600">
                {filteredWatchlist.filter(s => (s.change_percent || 0) > 0).length}
              </p>
            </Card>
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Losers</h3>
              <p className="text-2xl font-bold text-red-600">
                {filteredWatchlist.filter(s => (s.change_percent || 0) < 0).length}
              </p>
            </Card>
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Avg Change</h3>
              <p className="text-2xl font-bold text-slate-900">
                {filteredWatchlist.length > 0 
                  ? `${(filteredWatchlist.reduce((acc, s) => acc + (s.change_percent || 0), 0) / filteredWatchlist.length).toFixed(2)}%`
                  : '0.00%'
                }
              </p>
            </Card>
          </div>
        )}
      </div>
    </Layout>
  );
};

export default EnhancedWatchlist;