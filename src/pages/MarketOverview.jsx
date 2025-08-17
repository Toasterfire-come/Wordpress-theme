import React, { useState, useEffect } from 'react';
import { TrendingUp, TrendingDown, Activity, RefreshCw } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { stockAPI } from '../services/api';

const MarketOverview = () => {
  const [marketData, setMarketData] = useState(null);
  const [topGainers, setTopGainers] = useState([]);
  const [topLosers, setTopLosers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadMarketData();
  }, []);

  const loadMarketData = async () => {
    setLoading(true);
    setError(null);
    
    try {
      const [marketResponse, gainersResponse, losersResponse] = await Promise.all([
        stockAPI.getMarketData(),
        stockAPI.getMarketMovers(),
        stockAPI.getMarketMovers()
      ]);

      if (marketResponse && marketResponse.market_overview) {
        setMarketData(marketResponse);
      }

      if (gainersResponse.success && gainersResponse.data?.gainers) {
        setTopGainers(gainersResponse.data.gainers.slice(0, 10));
      }

      if (losersResponse.success && losersResponse.data?.losers) {
        setTopLosers(losersResponse.data.losers.slice(0, 10));
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
          title="Market Overview"
          subtitle="Real-time market data and performance metrics"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingState message="Loading market data..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="Market Overview"
          subtitle="Real-time market data and performance metrics"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <ErrorState 
            title="Failed to load market data"
            message={error}
            onRetry={loadMarketData}
          />
        </div>
      </Layout>
    );
  }

  const formatPrice = (price) => price ? `$${price.toFixed(2)}` : 'N/A';
  const formatPercent = (percent) => {
    if (!percent) return '0.00%';
    const sign = percent > 0 ? '+' : '';
    return `${sign}${percent.toFixed(2)}%`;
  };

  return (
    <Layout>
      <PageHeader
        title="Market Overview"
        subtitle="Real-time market data and performance metrics"
        actions={[
          {
            label: 'Refresh',
            icon: RefreshCw,
            onClick: loadMarketData,
            variant: 'outline'
          }
        ]}
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Market Statistics */}
        {marketData && (
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <Card className="p-6 text-center">
              <div className="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <Activity className="h-6 w-6 text-slate-600" />
              </div>
              <h3 className="text-sm font-medium text-slate-600 mb-2">Total Stocks</h3>
              <p className="text-3xl font-bold text-slate-900">
                {marketData.market_overview?.total_stocks?.toLocaleString() || 'N/A'}
              </p>
            </Card>

            <Card className="p-6 text-center">
              <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <TrendingUp className="h-6 w-6 text-green-600" />
              </div>
              <h3 className="text-sm font-medium text-slate-600 mb-2">Gainers</h3>
              <p className="text-3xl font-bold text-green-600">
                {marketData.market_overview?.gainers?.toLocaleString() || 'N/A'}
              </p>
            </Card>

            <Card className="p-6 text-center">
              <div className="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <TrendingDown className="h-6 w-6 text-red-600" />
              </div>
              <h3 className="text-sm font-medium text-slate-600 mb-2">Losers</h3>
              <p className="text-3xl font-bold text-red-600">
                {marketData.market_overview?.losers?.toLocaleString() || 'N/A'}
              </p>
            </Card>

            <Card className="p-6 text-center">
              <div className="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <Activity className="h-6 w-6 text-slate-600" />
              </div>
              <h3 className="text-sm font-medium text-slate-600 mb-2">Unchanged</h3>
              <p className="text-3xl font-bold text-slate-900">
                {marketData.market_overview?.unchanged?.toLocaleString() || 'N/A'}
              </p>
            </Card>
          </div>
        )}

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          {/* Top Gainers */}
          <Card className="p-6">
            <h2 className="text-xl font-semibold text-slate-900 mb-6">Top Gainers</h2>
            {topGainers.length > 0 ? (
              <div className="space-y-4">
                {topGainers.map((stock, index) => (
                  <div key={index} className="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">{stock.ticker}</h3>
                      <p className="text-sm text-slate-600">{stock.company_name || stock.name}</p>
                    </div>
                    <div className="text-right">
                      <p className="font-semibold text-slate-900">
                        {formatPrice(stock.current_price)}
                      </p>
                      <p className="text-sm font-medium text-green-600">
                        {formatPercent(stock.change_percent)}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            ) : (
              <p className="text-center text-slate-600 py-8">No gainers data available</p>
            )}
          </Card>

          {/* Top Losers */}
          <Card className="p-6">
            <h2 className="text-xl font-semibold text-slate-900 mb-6">Top Losers</h2>
            {topLosers.length > 0 ? (
              <div className="space-y-4">
                {topLosers.map((stock, index) => (
                  <div key={index} className="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">{stock.ticker}</h3>
                      <p className="text-sm text-slate-600">{stock.company_name || stock.name}</p>
                    </div>
                    <div className="text-right">
                      <p className="font-semibold text-slate-900">
                        {formatPrice(stock.current_price)}
                      </p>
                      <p className="text-sm font-medium text-red-600">
                        {formatPercent(stock.change_percent)}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            ) : (
              <p className="text-center text-slate-600 py-8">No losers data available</p>
            )}
          </Card>
        </div>
      </div>
    </Layout>
  );
};

export default MarketOverview;