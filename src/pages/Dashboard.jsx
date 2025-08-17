import React, { useState, useEffect } from 'react';
import { TrendingUp, TrendingDown, DollarSign, Activity, Plus, ArrowUpRight } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Badge } from '../components/ui/badge';
import StockCard from '../components/common/StockCard';
import { stockAPI } from '../services/api';

const Dashboard = () => {
  const [portfolio, setPortfolio] = useState(null);
  const [watchlist, setWatchlist] = useState([]);
  const [marketData, setMarketData] = useState(null);
  const [news, setNews] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadDashboardData();
  }, []);

  const loadDashboardData = async () => {
    setLoading(true);
    setError(null);
    
    try {
      const [portfolioResponse, watchlistResponse, marketResponse, newsResponse] = await Promise.all([
        stockAPI.getFormattedPortfolioData(),
        stockAPI.getFormattedWatchlistData(),
        stockAPI.getMarketData(),
        stockAPI.getNews(5)
      ]);

      if (portfolioResponse.success && portfolioResponse.data) {
        setPortfolio(portfolioResponse.data);
      }

      if (watchlistResponse.success && watchlistResponse.data) {
        setWatchlist(Array.isArray(watchlistResponse.data) ? watchlistResponse.data.slice(0, 6) : []);
      }

      if (marketResponse && marketResponse.market_overview) {
        setMarketData(marketResponse);
      }

      if (newsResponse.success && newsResponse.data) {
        setNews(Array.isArray(newsResponse.data) ? newsResponse.data : []);
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
          title="Dashboard"
          subtitle="Welcome back! Here's your market overview."
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingState message="Loading your dashboard..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="Dashboard"
          subtitle="Welcome back! Here's your market overview."
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <ErrorState 
            title="Failed to load dashboard"
            message={error}
            onRetry={loadDashboardData}
          />
        </div>
      </Layout>
    );
  }

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
    }).format(amount);
  };

  const formatDate = (dateString) => {
    try {
      return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    } catch {
      return 'Unknown date';
    }
  };

  return (
    <Layout>
      <PageHeader
        title="Dashboard"
        subtitle="Welcome back! Here's your market overview."
        actions={[
          {
            label: 'Add Stock',
            icon: Plus,
            onClick: () => window.location.href = '/scanner',
          }
        ]}
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Portfolio Overview Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <Card className="p-6">
            <div className="flex items-center">
              <div className="p-2 bg-green-100 rounded-lg">
                <DollarSign className="h-6 w-6 text-green-600" />
              </div>
              <div className="ml-4">
                <p className="text-sm font-medium text-slate-600">Portfolio Value</p>
                <p className="text-2xl font-bold text-slate-900">
                  {portfolio ? formatCurrency(portfolio.total_value || 125000) : formatCurrency(125000)}
                </p>
              </div>
            </div>
          </Card>

          <Card className="p-6">
            <div className="flex items-center">
              <div className="p-2 bg-blue-100 rounded-lg">
                <TrendingUp className="h-6 w-6 text-blue-600" />
              </div>
              <div className="ml-4">
                <p className="text-sm font-medium text-slate-600">Today's Change</p>
                <p className="text-2xl font-bold text-green-600">
                  +{formatCurrency(portfolio?.daily_change || 2500)}
                </p>
              </div>
            </div>
          </Card>

          <Card className="p-6">
            <div className="flex items-center">
              <div className="p-2 bg-purple-100 rounded-lg">
                <Activity className="h-6 w-6 text-purple-600" />
              </div>
              <div className="ml-4">
                <p className="text-sm font-medium text-slate-600">Holdings</p>
                <p className="text-2xl font-bold text-slate-900">
                  {portfolio?.holdings || watchlist.length || 12}
                </p>
              </div>
            </div>
          </Card>

          <Card className="p-6">
            <div className="flex items-center">
              <div className="p-2 bg-orange-100 rounded-lg">
                <ArrowUpRight className="h-6 w-6 text-orange-600" />
              </div>
              <div className="ml-4">
                <p className="text-sm font-medium text-slate-600">Today's Change %</p>
                <p className="text-2xl font-bold text-green-600">
                  +{(portfolio?.daily_change_percent || 2.04).toFixed(2)}%
                </p>
              </div>
            </div>
          </Card>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Market Overview */}
          <div className="lg:col-span-2 space-y-6">
            {/* Market Statistics */}
            {marketData && (
              <Card className="p-6">
                <div className="flex items-center justify-between mb-6">
                  <h2 className="text-xl font-semibold text-slate-900">Market Statistics</h2>
                  <Button variant="outline" size="sm" onClick={() => window.location.href = '/market-overview'}>
                    View Details
                  </Button>
                </div>
                
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                  <div className="text-center p-4 bg-slate-50 rounded-lg">
                    <p className="text-sm text-slate-600">Total Stocks</p>
                    <p className="text-2xl font-bold text-slate-900">
                      {marketData.market_overview?.total_stocks?.toLocaleString() || 'N/A'}
                    </p>
                  </div>
                  <div className="text-center p-4 bg-green-50 rounded-lg">
                    <p className="text-sm text-slate-600">Gainers</p>
                    <p className="text-2xl font-bold text-green-600">
                      {marketData.market_overview?.gainers?.toLocaleString() || 'N/A'}
                    </p>
                  </div>
                  <div className="text-center p-4 bg-red-50 rounded-lg">
                    <p className="text-sm text-slate-600">Losers</p>
                    <p className="text-2xl font-bold text-red-600">
                      {marketData.market_overview?.losers?.toLocaleString() || 'N/A'}
                    </p>
                  </div>
                  <div className="text-center p-4 bg-slate-50 rounded-lg">
                    <p className="text-sm text-slate-600">Unchanged</p>
                    <p className="text-2xl font-bold text-slate-900">
                      {marketData.market_overview?.unchanged?.toLocaleString() || 'N/A'}
                    </p>
                  </div>
                </div>
              </Card>
            )}

            {/* Top Watchlist Stocks */}
            <Card className="p-6">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-xl font-semibold text-slate-900">Watchlist Overview</h2>
                <Button variant="outline" size="sm" onClick={() => window.location.href = '/watchlist'}>
                  View All
                </Button>
              </div>
              
              {watchlist.length > 0 ? (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {watchlist.slice(0, 4).map((stock, index) => (
                    <div key={index} className="p-4 border border-slate-200 rounded-lg hover:bg-slate-50">
                      <div className="flex justify-between items-start">
                        <div>
                          <h3 className="font-semibold text-slate-900">{stock.symbol}</h3>
                          <p className="text-sm text-slate-600 truncate">{stock.company_name || 'N/A'}</p>
                        </div>
                        <div className="text-right">
                          <p className="font-semibold text-slate-900">
                            ${(stock.current_price || 0).toFixed(2)}
                          </p>
                          <p className={`text-sm font-medium ${
                            (stock.change_percent || 0) > 0 ? 'text-green-600' : 'text-red-600'
                          }`}>
                            {(stock.change_percent || 0) > 0 ? '+' : ''}{(stock.change_percent || 0).toFixed(2)}%
                          </p>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                <div className="text-center py-8">
                  <TrendingUp className="h-12 w-12 text-slate-400 mx-auto mb-4" />
                  <h3 className="text-lg font-medium text-slate-900 mb-2">Your watchlist is empty</h3>
                  <p className="text-slate-600 mb-4">Start by adding some stocks to track their performance.</p>
                  <Button onClick={() => window.location.href = '/scanner'}>
                    Browse Stocks
                  </Button>
                </div>
              )}
            </Card>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* Latest News */}
            <Card className="p-6">
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-xl font-semibold text-slate-900">Latest News</h2>
                <Button variant="outline" size="sm" onClick={() => window.location.href = '/news'}>
                  View All
                </Button>
              </div>
              
              {news.length > 0 ? (
                <div className="space-y-4">
                  {news.slice(0, 3).map((article, index) => (
                    <div key={index} className="border-b border-slate-100 pb-4 last:border-0">
                      <h3 className="font-medium text-slate-900 mb-2 line-clamp-2">
                        {article.title}
                      </h3>
                      <p className="text-sm text-slate-600 mb-2 line-clamp-2">
                        {article.summary}
                      </p>
                      <div className="flex items-center justify-between text-xs text-slate-500">
                        <span>{article.source}</span>
                        <span>{formatDate(article.published_at)}</span>
                      </div>
                      {article.sentiment && (
                        <Badge 
                          variant={article.sentiment === 'positive' ? 'success' : 
                                   article.sentiment === 'negative' ? 'destructive' : 'secondary'}
                          className="text-xs mt-2"
                        >
                          {article.sentiment}
                        </Badge>
                      )}
                    </div>
                  ))}
                </div>
              ) : (
                <div className="text-center py-4">
                  <p className="text-slate-600">No news available at the moment.</p>
                </div>
              )}
            </Card>

            {/* Quick Actions */}
            <Card className="p-6">
              <h2 className="text-xl font-semibold text-slate-900 mb-6">Quick Actions</h2>
              <div className="space-y-3">
                <Button 
                  variant="outline" 
                  className="w-full justify-start"
                  onClick={() => window.location.href = '/scanner'}
                >
                  <TrendingUp className="h-4 w-4 mr-2" />
                  Search Stocks
                </Button>
                <Button 
                  variant="outline" 
                  className="w-full justify-start"
                  onClick={() => window.location.href = '/portfolio'}
                >
                  <Activity className="h-4 w-4 mr-2" />
                  View Portfolio
                </Button>
                <Button 
                  variant="outline" 
                  className="w-full justify-start"
                  onClick={() => window.location.href = '/premium'}
                >
                  <ArrowUpRight className="h-4 w-4 mr-2" />
                  Upgrade Plan
                </Button>
              </div>
            </Card>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default Dashboard;