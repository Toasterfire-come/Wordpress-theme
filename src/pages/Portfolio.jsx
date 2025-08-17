import React, { useState, useEffect } from 'react';
import { PieChart, TrendingUp, DollarSign } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import EmptyState from '../components/common/EmptyState';
import { Card } from '../components/ui/card';
import { stockAPI } from '../services/api';

const Portfolio = () => {
  const [portfolio, setPortfolio] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadPortfolio();
  }, []);

  const loadPortfolio = async () => {
    setLoading(true);
    setError(null);
    try {
      const response = await stockAPI.getFormattedPortfolioData();
      if (response.success && response.data) {
        setPortfolio(response.data);
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
          title="Portfolio"
          subtitle="Track your investment performance and holdings"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingState message="Loading your portfolio..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="Portfolio"
          subtitle="Track your investment performance and holdings"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <ErrorState 
            title="Failed to load portfolio"
            message={error}
            onRetry={loadPortfolio}
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

  return (
    <Layout>
      <PageHeader
        title="Portfolio"
        subtitle="Track your investment performance and holdings"
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {!portfolio || !portfolio.items || portfolio.items.length === 0 ? (
          <EmptyState
            icon={PieChart}
            title="Your portfolio is empty"
            message="Start tracking your investments by adding stocks to your portfolio."
            actionLabel="Find Stocks"
            onAction={() => window.location.href = '/scanner'}
          />
        ) : (
          <div className="space-y-8">
            {/* Portfolio Summary */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              <Card className="p-6">
                <div className="flex items-center">
                  <div className="p-2 bg-green-100 rounded-lg">
                    <DollarSign className="h-6 w-6 text-green-600" />
                  </div>
                  <div className="ml-4">
                    <p className="text-sm font-medium text-slate-600">Total Value</p>
                    <p className="text-2xl font-bold text-slate-900">
                      {formatCurrency(portfolio.total_value || 0)}
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
                    <p className="text-sm font-medium text-slate-600">Daily Change</p>
                    <p className={`text-2xl font-bold ${
                      (portfolio.daily_change || 0) >= 0 ? 'text-green-600' : 'text-red-600'
                    }`}>
                      {formatCurrency(portfolio.daily_change || 0)}
                    </p>
                  </div>
                </div>
              </Card>
              
              <Card className="p-6">
                <div className="flex items-center">
                  <div className="p-2 bg-purple-100 rounded-lg">
                    <PieChart className="h-6 w-6 text-purple-600" />
                  </div>
                  <div className="ml-4">
                    <p className="text-sm font-medium text-slate-600">Holdings</p>
                    <p className="text-2xl font-bold text-slate-900">
                      {portfolio.holdings || 0}
                    </p>
                  </div>
                </div>
              </Card>
            </div>

            {/* Holdings List */}
            <Card className="p-6">
              <h2 className="text-xl font-semibold text-slate-900 mb-6">Holdings</h2>
              <div className="space-y-4">
                {portfolio.items?.map((holding, index) => (
                  <div key={index} className="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">{holding.symbol}</h3>
                      <p className="text-sm text-slate-600">{holding.company_name}</p>
                    </div>
                    <div className="text-right">
                      <p className="font-medium text-slate-900">
                        {holding.shares} shares
                      </p>
                      <p className="text-sm text-slate-600">
                        {formatCurrency(holding.value || 0)}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </Card>
          </div>
        )}
      </div>
    </Layout>
  );
};

export default Portfolio;