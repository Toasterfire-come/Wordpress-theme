import React, { useState, useEffect } from 'react';
import { Newspaper, Filter, Clock, TrendingUp, Star } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import EmptyState from '../components/common/EmptyState';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Badge } from '../components/ui/badge';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../components/ui/select';
import { stockAPI } from '../services/api';

const PersonalizedNews = () => {
  const [news, setNews] = useState([]);
  const [watchlist, setWatchlist] = useState([]);
  const [portfolio, setPortfolio] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [selectedFilter, setSelectedFilter] = useState('all');
  const [sentimentFilter, setSentimentFilter] = useState('all');

  useEffect(() => {
    loadData();
  }, []);

  const loadData = async () => {
    setLoading(true);
    setError(null);
    
    try {
      const [newsResponse, watchlistResponse, portfolioResponse] = await Promise.all([
        stockAPI.getNews(50),
        stockAPI.getFormattedWatchlistData(),
        stockAPI.getFormattedPortfolioData()
      ]);

      // Get user's tracked symbols
      const watchlistSymbols = Array.isArray(watchlistResponse.data) 
        ? watchlistResponse.data.map(item => item.symbol).filter(Boolean)
        : [];
      
      const portfolioSymbols = portfolioResponse.data?.items 
        ? portfolioResponse.data.items.map(item => item.symbol).filter(Boolean)
        : [];

      const trackedSymbols = [...new Set([...watchlistSymbols, ...portfolioSymbols])];

      setWatchlist(watchlistSymbols);
      setPortfolio(portfolioSymbols);

      if (newsResponse.success && newsResponse.data) {
        // Enhance news with personalization flags
        const enhancedNews = (Array.isArray(newsResponse.data) ? newsResponse.data : []).map(article => ({
          ...article,
          isPersonalized: trackedSymbols.some(symbol => 
            article.title?.toLowerCase().includes(symbol.toLowerCase()) ||
            article.summary?.toLowerCase().includes(symbol.toLowerCase())
          ),
          relevanceScore: Math.random() * 100 // Mock relevance score
        }));

        // Sort by personalized first, then by date
        enhancedNews.sort((a, b) => {
          if (a.isPersonalized && !b.isPersonalized) return -1;
          if (!a.isPersonalized && b.isPersonalized) return 1;
          return new Date(b.published_at) - new Date(a.published_at);
        });

        setNews(enhancedNews);
      }
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  // Filter news based on selections
  const filteredNews = React.useMemo(() => {
    let filtered = [...news];

    // Filter by category
    if (selectedFilter !== 'all') {
      if (selectedFilter === 'personalized') {
        filtered = filtered.filter(article => article.isPersonalized);
      } else if (selectedFilter === 'watchlist') {
        filtered = filtered.filter(article => 
          watchlist.some(symbol => 
            article.title?.toLowerCase().includes(symbol.toLowerCase()) ||
            article.summary?.toLowerCase().includes(symbol.toLowerCase())
          )
        );
      } else if (selectedFilter === 'portfolio') {
        filtered = filtered.filter(article => 
          portfolio.some(symbol => 
            article.title?.toLowerCase().includes(symbol.toLowerCase()) ||
            article.summary?.toLowerCase().includes(symbol.toLowerCase())
          )
        );
      }
    }

    // Filter by sentiment
    if (sentimentFilter !== 'all') {
      filtered = filtered.filter(article => article.sentiment === sentimentFilter);
    }

    return filtered;
  }, [news, selectedFilter, sentimentFilter, watchlist, portfolio]);

  const getSentimentBadge = (sentiment) => {
    const sentimentConfig = {
      positive: { variant: 'success', label: 'Positive' },
      negative: { variant: 'destructive', label: 'Negative' },
      neutral: { variant: 'secondary', label: 'Neutral' }
    };

    const config = sentimentConfig[sentiment] || sentimentConfig.neutral;
    return (
      <Badge variant={config.variant} className="text-xs">
        {config.label}
      </Badge>
    );
  };

  const formatDate = (dateString) => {
    try {
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    } catch {
      return 'Unknown date';
    }
  };

  if (loading) {
    return (
      <Layout>
        <PageHeader
          title="Personalized News"
          subtitle="News tailored to your watchlist and portfolio"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingState message="Loading personalized news feed..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="Personalized News"
          subtitle="News tailored to your watchlist and portfolio"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <ErrorState 
            title="Failed to load news"
            message={error}
            onRetry={loadData}
          />
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      <PageHeader
        title="Personalized News"
        subtitle="News tailored to your watchlist and portfolio"
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Filters */}
        <Card className="p-6 mb-6">
          <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div className="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
              <Select value={selectedFilter} onValueChange={setSelectedFilter}>
                <SelectTrigger className="w-[200px]">
                  <Filter className="h-4 w-4 mr-2" />
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All News</SelectItem>
                  <SelectItem value="personalized">
                    <div className="flex items-center">
                      <Star className="h-4 w-4 mr-2 text-yellow-500" />
                      Personalized
                    </div>
                  </SelectItem>
                  <SelectItem value="watchlist">Watchlist Related</SelectItem>
                  <SelectItem value="portfolio">Portfolio Related</SelectItem>
                </SelectContent>
              </Select>

              <Select value={sentimentFilter} onValueChange={setSentimentFilter}>
                <SelectTrigger className="w-[150px]">
                  <TrendingUp className="h-4 w-4 mr-2" />
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Sentiment</SelectItem>
                  <SelectItem value="positive">Positive</SelectItem>
                  <SelectItem value="neutral">Neutral</SelectItem>
                  <SelectItem value="negative">Negative</SelectItem>
                </SelectContent>
              </Select>
            </div>

            <div className="text-sm text-slate-600">
              {filteredNews.length} articles found
            </div>
          </div>
        </Card>

        {/* News Grid */}
        {filteredNews.length === 0 ? (
          <EmptyState
            icon={Newspaper}
            title="No personalized news found"
            message="Add stocks to your watchlist or portfolio to see relevant news articles."
            actionLabel="Browse Stocks"
            onAction={() => window.location.href = '/scanner'}
          />
        ) : (
          <div className="space-y-6">
            {filteredNews.map((article, index) => (
              <Card key={index} className="p-6 hover:shadow-lg transition-shadow duration-200">
                <div className="flex items-start justify-between">
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center space-x-3 mb-3">
                      {article.isPersonalized && (
                        <Star className="h-4 w-4 text-yellow-500 flex-shrink-0" />
                      )}
                      <h2 className="text-xl font-semibold text-slate-900 leading-tight">
                        {article.title}
                      </h2>
                    </div>
                    
                    <p className="text-slate-600 mb-4 leading-relaxed">
                      {article.summary}
                    </p>
                    
                    <div className="flex flex-wrap items-center gap-4 text-sm">
                      <div className="flex items-center text-slate-500">
                        <Clock className="h-4 w-4 mr-1" />
                        {formatDate(article.published_at)}
                      </div>
                      
                      <div className="flex items-center text-slate-500">
                        <span className="font-medium">{article.source}</span>
                      </div>
                      
                      {article.sentiment && getSentimentBadge(article.sentiment)}
                      
                      {article.isPersonalized && (
                        <Badge variant="outline" className="text-xs border-yellow-300 text-yellow-700">
                          <Star className="h-3 w-3 mr-1" />
                          Personalized
                        </Badge>
                      )}
                    </div>
                  </div>
                </div>

                {/* Sentiment Score Bar */}
                {article.sentiment_score && (
                  <div className="mt-4 pt-4 border-t border-slate-100">
                    <div className="flex items-center justify-between text-xs text-slate-600 mb-2">
                      <span>Sentiment Score</span>
                      <span>{Math.abs(article.sentiment_score * 100).toFixed(0)}%</span>
                    </div>
                    <div className="w-full bg-slate-200 rounded-full h-2">
                      <div
                        className={`h-2 rounded-full ${
                          article.sentiment_score > 0 ? 'bg-green-500' : 'bg-red-500'
                        }`}
                        style={{
                          width: `${Math.abs(article.sentiment_score) * 100}%`
                        }}
                      />
                    </div>
                  </div>
                )}
              </Card>
            ))}
          </div>
        )}

        {/* Personalization Stats */}
        {news.length > 0 && (
          <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Total Articles</h3>
              <p className="text-2xl font-bold text-slate-900">{news.length}</p>
            </Card>
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Personalized</h3>
              <p className="text-2xl font-bold text-yellow-600">
                {news.filter(article => article.isPersonalized).length}
              </p>
            </Card>
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Positive Sentiment</h3>
              <p className="text-2xl font-bold text-green-600">
                {news.filter(article => article.sentiment === 'positive').length}
              </p>
            </Card>
            <Card className="p-6">
              <h3 className="text-sm font-medium text-slate-600 mb-2">Tracked Stocks</h3>
              <p className="text-2xl font-bold text-blue-600">
                {[...new Set([...watchlist, ...portfolio])].length}
              </p>
            </Card>
          </div>
        )}
      </div>
    </Layout>
  );
};

export default PersonalizedNews;