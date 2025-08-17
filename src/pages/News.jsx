import React, { useState, useEffect } from 'react';
import { Newspaper, Clock } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import EmptyState from '../components/common/EmptyState';
import { Card } from '../components/ui/card';
import { Badge } from '../components/ui/badge';
import { stockAPI } from '../services/api';

const News = () => {
  const [news, setNews] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadNews();
  }, []);

  const loadNews = async () => {
    setLoading(true);
    setError(null);
    try {
      const response = await stockAPI.getNews(20);
      if (response.success && response.data) {
        setNews(Array.isArray(response.data) ? response.data : []);
      }
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
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

  if (loading) {
    return (
      <Layout>
        <PageHeader
          title="Market News"
          subtitle="Stay updated with the latest market developments"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingState message="Loading market news..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="Market News"
          subtitle="Stay updated with the latest market developments"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <ErrorState 
            title="Failed to load news"
            message={error}
            onRetry={loadNews}
          />
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      <PageHeader
        title="Market News"
        subtitle="Stay updated with the latest market developments"
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {news.length === 0 ? (
          <EmptyState
            icon={Newspaper}
            title="No news available"
            message="Check back later for the latest market news and updates."
          />
        ) : (
          <div className="space-y-6">
            {news.map((article, index) => (
              <Card key={index} className="p-6">
                <h2 className="text-xl font-semibold text-slate-900 mb-3">
                  {article.title}
                </h2>
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
                </div>
              </Card>
            ))}
          </div>
        )}
      </div>
    </Layout>
  );
};

export default News;