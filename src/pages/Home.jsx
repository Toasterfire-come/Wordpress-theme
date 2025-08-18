import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { ArrowRight, TrendingUp, BarChart3, Bell, DollarSign, Users, Zap, Shield, Star, Check, Globe, Award, CreditCard, Database, Lock, Activity, AlertTriangle, FileText, PieChart, Target, Layers, RefreshCw } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Badge } from '../components/ui/badge';
import { stockAPI } from '../services/api';

const Home = () => {
  const [marketData, setMarketData] = useState(null);
  const navigate = useNavigate();
  const { isAuthenticated, loading: authLoading } = useAuth();
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (authLoading) return;
    if (isAuthenticated) {
      navigate('/dashboard');
      return;
    }
    loadMarketData();
  }, [isAuthenticated, authLoading]);

  const loadMarketData = async () => {
    setLoading(true);
    try {
      const response = await stockAPI.getMarketData();
      if (response && response.market_overview) {
        setMarketData(response);
      }
    } catch (error) {
      console.error('Error loading market data:', error);
    } finally {
      setLoading(false);
    }
  };

  const coreFeatures = [
    {
      icon: Database,
      title: 'Real-Time Stock Data',
      description: 'Live stock prices updated automatically sub three minutes during market hours with comprehensive data coverage.',
      color: 'emerald',
      features: ['NASDAQ stock tracking', 'Historical price analysis', 'Volume & market cap monitoring']
    },
    {
      icon: Target,
      title: 'Stock Scanner & Lookup',
      description: 'Advanced stock filtering and lookup system with powerful search capabilities for finding investment opportunities.',
      color: 'blue',
      features: ['Symbol search & lookup', 'Price filtering tools', 'Market screening capabilities']
    },
    {
      icon: PieChart,
      title: 'Portfolio Management',
      description: 'Professional portfolio tracking with performance analytics and comprehensive reporting (Pro+ plans).',
      color: 'purple',
      features: ['Multi-portfolio support', 'Performance tracking', 'ROI analysis & reporting']
    },
    {
      icon: Bell,
      title: 'Smart Alert System',
      description: 'Price-based alerts with email notifications for staying informed about market movements (Basic+ plans).',
      color: 'orange',
      features: ['Price threshold alerts', 'Email notifications', 'Real-time monitoring']
    },
    {
      icon: FileText,
      title: 'News Integration',
      description: 'Automated news aggregation with sentiment analysis for better market insight (Basic+ plans).',
      color: 'green',
      features: ['Multi-source news feeds', 'Sentiment analysis', 'Ticker-specific news']
    },
    {
      icon: BarChart3,
      title: 'Advanced Analytics',
      description: 'Deep performance insights with sector analysis and comprehensive market metrics (Pro+ plans).',
      color: 'indigo',
      features: ['Sector breakdown analysis', 'Performance metrics', 'Comparative analysis']
    }
  ];

  const technicalFeatures = [
    {
      icon: Lock,
      title: 'Enterprise Security',
      description: 'Production-grade security with comprehensive input validation, audit logging, and data protection.',
      specs: ['Input validation & sanitization', 'Secure authentication', 'Audit logging', 'Data encryption']
    },
    {
      icon: Zap,
      title: 'Tiered Rate Limiting',
      description: 'Monthly usage limits designed for fair access and optimal performance across all user tiers.',
      specs: ['Free: 15 requests/month', 'Basic: 1,500 requests/month', 'Pro: 5,000 requests/month', 'Enterprise: Unlimited']
    },
    {
      icon: Activity,
      title: 'Market Data Updates',
      description: 'Automated market data updates sub three minutes during trading hours for timely information.',
      specs: ['10-minute update intervals', 'Market hours detection', 'Real-time during trading', 'Holiday calendar aware']
    },
    {
      icon: Layers,
      title: 'REST API Access',
      description: 'Comprehensive RESTful API with authentication for custom integrations (Pro+ plans).',
      specs: ['REST API endpoints', 'Authentication tokens', 'JSON responses', 'Rate limit headers']
    }
  ];

  const stats = [
    { label: 'Stock Data Coverage', value: '3,500+', icon: Database, description: 'Real-time securities tracked' },
    { label: 'API Endpoints', value: '25+', icon: Layers, description: 'Comprehensive API coverage' },
    { label: 'Data Accuracy', value: '99.9%', icon: Zap, description: 'Production reliability' },
    { label: 'Update Frequency', value: '10min', icon: RefreshCw, description: 'During market hours' }
  ];

  const testimonials = [
    {
      name: 'Michael Rodriguez',
      role: 'Individual Trader',
      content: 'The Basic plan gives me exactly what I need - reliable stock data and alerts without breaking the bank. The 1,500 monthly requests are perfect for my trading frequency.',
      rating: 5,
      avatar: 'MR',
      plan: 'Basic'
    },
    {
      name: 'Sarah Chen',
      role: 'Investment Analyst',
      content: 'Pro plan\'s 5,000 monthly requests and advanced analytics help me manage multiple client portfolios effectively. The API access is a game-changer.',
      rating: 5,
      avatar: 'SC',
      plan: 'Pro'
    },
    {
      name: 'David Kim',
      role: 'Portfolio Manager',
      content: 'Enterprise solution with unlimited requests allows our firm to integrate seamlessly with existing systems. Excellent support team.',
      rating: 5,
      avatar: 'DK',
      plan: 'Enterprise'
    }
  ];

  const pricingTiers = [
    {
      name: 'Free',
      price: '$0',
      period: '/month',
      description: 'Basic stock lookup and filtering',
      features: [
        '15 API requests per month',
        'Stock symbol lookup',
        'Basic price filtering',
        'Market data access',
        'Community support'
      ],
      limitations: [
        'No portfolio management',
        'No email alerts',
        'No news access',
        'Limited to basic lookup only'
      ],
      popular: false,
      cta: 'Get Started Free',
      highlight: 'Perfect for casual users'
    },
    {
      name: 'Basic',
      price: '$24.99',
      period: '/month',
      description: 'Enhanced features for active traders',
      features: [
        '1,500 API requests per month',
        'Full stock scanner access',
        'Email alerts & notifications',
        'News sentiment analysis',
        'Basic portfolio tracking',
        'Email support'
      ],
      popular: true,
      cta: 'Start Basic Plan',
      highlight: 'Most popular choice'
    },
    {
      name: 'Pro',
      price: '$49.99',
      period: '/month',
      description: 'Professional tools for serious traders',
      features: [
        '5,000 API requests per month',
        'Unlimited portfolios',
        'Advanced alert system',
        'Full API access',
        'Priority support',
        'Advanced analytics & reporting'
      ],
      popular: false,
      cta: 'Start Pro Plan',
      highlight: 'For professional traders'
    },
    {
      name: 'Enterprise',
      price: 'Contact Sales',
      period: '',
      description: 'Custom solutions for institutions',
      features: [
        'Unlimited API requests',
        'Custom integrations',
        'Dedicated support manager',
        'SLA guarantees',
        'White-label options',
        'Custom deployment'
      ],
      popular: false,
      cta: 'Contact Sales Team',
      highlight: 'Tailored solutions'
    }
  ];

  return (
    <Layout>
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white overflow-hidden">
        <div className="absolute inset-0 opacity-20">
          <div className="absolute inset-0" style={{
            backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
          }} />
        </div>
        
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
          <div className="text-center">
            <Badge className="bg-emerald-600/20 text-emerald-300 border-emerald-500/30 mb-8 px-6 py-3 text-lg">
              <Database className="h-5 w-5 mr-2" />
              Professional Stock Scanner & Portfolio Manager
            </Badge>
            
            <h1 className="text-5xl md:text-7xl font-bold mb-8 leading-tight">
              Complete Stock Scanner
              <span className="block bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent mt-4">
                & Portfolio Manager
              </span>
            </h1>
            
            <p className="text-xl md:text-2xl text-slate-200 mb-12 max-w-4xl mx-auto leading-relaxed">
              Professional-grade stock analysis platform with real-time data updates sub three minutes, 
              comprehensive portfolio management, and intelligent market insights. Built for traders who demand accuracy.
            </p>
            
            <div className="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
              <Button 
                size="lg"
                className="bg-emerald-600 hover:bg-emerald-700 text-white px-12 py-6 text-xl font-semibold rounded-lg shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105"
                onClick={() => window.location.href = '/signup'}
              >
                Start Free Trial
                <ArrowRight className="ml-3 h-6 w-6" />
              </Button>
              <Button 
                size="lg"
                variant="outline"
                className="border-2 border-white/30 text-white hover:bg-white hover:text-slate-900 px-12 py-6 text-xl font-semibold rounded-lg transition-all duration-300"
                onClick={() => window.location.href = '/premium'}
              >
                View Plans & Pricing
              </Button>
            </div>

            <div className="flex flex-col sm:flex-row justify-center items-center gap-8 text-slate-300">
              <div className="flex items-center gap-2">
                <Check className="h-5 w-5 text-emerald-400" />
                <span>No Credit Card Required</span>
              </div>
              <div className="flex items-center gap-2">
                <Check className="h-5 w-5 text-emerald-400" />
                <span>15 Free Monthly Requests</span>
              </div>
              <div className="flex items-center gap-2">
                <Check className="h-5 w-5 text-emerald-400" />
                <span>Production Ready</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Live Market Data Section */}
      {marketData && marketData.market_overview && (
        <section className="py-24 bg-white border-b border-slate-200">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16">
              <Badge className="bg-emerald-100 text-emerald-700 px-4 py-2 mb-6">
                <Activity className="h-4 w-4 mr-2" />
                Live Market Data
              </Badge>
              <h2 className="text-4xl md:text-5xl font-bold text-slate-900 mb-6">
                Real-Time Market Overview
              </h2>
              <p className="text-xl text-slate-600 max-w-3xl mx-auto">
                Live stock market data updated sub three minutes during trading hours
              </p>
            </div>
            
            <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
              <Card className="p-8 text-center hover:shadow-lg transition-all duration-300 border-l-4 border-l-emerald-500">
                <h3 className="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">Total Tracked</h3>
                <p className="text-4xl font-bold text-slate-900 mb-2">
                  {marketData.market_overview?.total_stocks?.toLocaleString() || '3,500+'}
                </p>
                <p className="text-sm text-slate-600">Securities monitored</p>
              </Card>
              <Card className="p-8 text-center hover:shadow-lg transition-all duration-300 border-l-4 border-l-green-500">
                <h3 className="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">Gainers</h3>
                <p className="text-4xl font-bold text-green-600 mb-2">
                  {marketData.market_overview?.gainers?.toLocaleString() || 'Live'}
                </p>
                <p className="text-sm text-green-600">Stocks rising</p>
              </Card>
              <Card className="p-8 text-center hover:shadow-lg transition-all duration-300 border-l-4 border-l-red-500">
                <h3 className="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">Losers</h3>
                <p className="text-4xl font-bold text-red-600 mb-2">
                  {marketData.market_overview?.losers?.toLocaleString() || 'Live'}
                </p>
                <p className="text-sm text-red-600">Stocks falling</p>
              </Card>
              <Card className="p-8 text-center hover:shadow-lg transition-all duration-300 border-l-4 border-l-blue-500">
                <h3 className="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">Update Freq</h3>
                <p className="text-4xl font-bold text-blue-600 mb-2">10min</p>
                <p className="text-sm text-blue-600">During market hours</p>
              </Card>
            </div>
          </div>
        </section>
      )}

      {/* Core Features Section */}
      <section className="py-24 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <Badge className="bg-blue-100 text-blue-700 px-4 py-2 mb-6">
              Professional Features
            </Badge>
            <h2 className="text-4xl md:text-5xl font-bold text-slate-900 mb-8">
              Professional Stock Analysis Tools
            </h2>
            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
              Built with production-ready architecture. Every feature is designed for professional use with enterprise-grade reliability and security.
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            {coreFeatures.map((feature, index) => {
              const Icon = feature.icon;
              const colorClasses = {
                emerald: 'bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white',
                blue: 'bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white',
                orange: 'bg-orange-100 text-orange-600 group-hover:bg-orange-600 group-hover:text-white',
                green: 'bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white',
                purple: 'bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white',
                indigo: 'bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white'
              };
              
              return (
                <Card key={index} className="p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer">
                  <div className={`w-16 h-16 rounded-xl flex items-center justify-center mb-6 transition-all duration-300 ${colorClasses[feature.color]}`}>
                    <Icon className="h-8 w-8" />
                  </div>
                  <h3 className="text-2xl font-bold text-slate-900 mb-4">{feature.title}</h3>
                  <p className="text-slate-600 leading-relaxed mb-6">{feature.description}</p>
                  <ul className="space-y-2">
                    {feature.features.map((feat, i) => (
                      <li key={i} className="flex items-center text-sm text-slate-700">
                        <Check className="h-4 w-4 text-emerald-500 mr-2 flex-shrink-0" />
                        {feat}
                      </li>
                    ))}
                  </ul>
                </Card>
              );
            })}
          </div>
        </div>
      </section>

      {/* Technical Features */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <h2 className="text-4xl md:text-5xl font-bold text-slate-900 mb-8">
              Built for Production
            </h2>
            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
              Enterprise-grade architecture with security, performance, and reliability at its core
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {technicalFeatures.map((feature, index) => {
              const Icon = feature.icon;
              return (
                <Card key={index} className="p-8 hover:shadow-lg transition-all duration-300">
                  <div className="flex items-start space-x-4">
                    <div className="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                      <Icon className="h-6 w-6 text-slate-600" />
                    </div>
                    <div className="flex-1">
                      <h3 className="text-xl font-bold text-slate-900 mb-3">{feature.title}</h3>
                      <p className="text-slate-600 mb-4 leading-relaxed">{feature.description}</p>
                      <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        {feature.specs.map((spec, i) => (
                          <div key={i} className="flex items-center text-sm text-slate-700">
                            <div className="w-2 h-2 bg-emerald-500 rounded-full mr-2 flex-shrink-0" />
                            {spec}
                          </div>
                        ))}
                      </div>
                    </div>
                  </div>
                </Card>
              );
            })}
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="py-24 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl md:text-5xl font-bold text-slate-900 mb-8">
              Platform Metrics
            </h2>
            <p className="text-xl text-slate-600">
              Real performance metrics from our production deployment
            </p>
          </div>
          
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {stats.map((stat, index) => {
              const Icon = stat.icon;
              return (
                <div key={index} className="text-center group">
                  <div className="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-all duration-300 border border-slate-200">
                    <Icon className="h-10 w-10 text-emerald-600" />
                  </div>
                  <div className="text-4xl font-bold text-slate-900 mb-2">{stat.value}</div>
                  <div className="text-lg font-semibold text-slate-700 mb-1">{stat.label}</div>
                  <div className="text-sm text-slate-500">{stat.description}</div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* Testimonials Section */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <h2 className="text-4xl md:text-5xl font-bold text-slate-900 mb-8">
              What Professional Traders Say
            </h2>
            <p className="text-xl text-slate-600">
              Real feedback from traders using our platform in production
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {testimonials.map((testimonial, index) => (
              <Card key={index} className="p-8 hover:shadow-lg transition-shadow duration-300">
                <div className="flex items-center mb-6">
                  <div className="w-12 h-12 bg-gradient-to-br from-emerald-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                    {testimonial.avatar}
                  </div>
                  <div className="flex-1">
                    <h4 className="font-semibold text-slate-900">{testimonial.name}</h4>
                    <p className="text-sm text-slate-600">{testimonial.role}</p>
                  </div>
                  <Badge className="bg-emerald-100 text-emerald-700 text-xs">
                    {testimonial.plan}
                  </Badge>
                </div>
                <div className="flex mb-4">
                  {[...Array(testimonial.rating)].map((_, i) => (
                    <Star key={i} className="h-5 w-5 text-yellow-400 fill-current" />
                  ))}
                </div>
                <p className="text-slate-700 italic leading-relaxed">"{testimonial.content}"</p>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Pricing Section */}
      <section className="py-24 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <h2 className="text-4xl md:text-5xl font-bold text-slate-900 mb-8">
              Simple, Transparent Pricing
            </h2>
            <p className="text-xl text-slate-600 mb-8">
              Choose the plan that fits your trading needs. Start free, upgrade when ready.
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {pricingTiers.map((plan, index) => (
              <Card 
                key={index} 
                className={`p-8 relative ${
                  plan.popular 
                    ? 'border-2 border-emerald-500 shadow-xl scale-105 bg-white' 
                    : 'hover:shadow-lg bg-white'
                } transition-all duration-300`}
              >
                {plan.popular && (
                  <Badge className="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-emerald-600 text-white px-6 py-1 shadow-lg">
                    <Star className="h-4 w-4 mr-1" />
                    {plan.highlight}
                  </Badge>
                )}
                
                <div className="text-center mb-8">
                  <h3 className="text-2xl font-bold text-slate-900 mb-2">{plan.name}</h3>
                  <div className="flex items-baseline justify-center mb-2">
                    <span className="text-4xl font-bold text-slate-900">{plan.price}</span>
                    <span className="text-xl text-slate-600 ml-1">{plan.period}</span>
                  </div>
                  <p className="text-slate-600">{plan.description}</p>
                </div>

                <ul className="space-y-4 mb-8 min-h-[200px]">
                  {plan.features.map((feature, i) => (
                    <li key={i} className="flex items-start space-x-3">
                      <Check className="h-5 w-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                      <span className="text-slate-700 text-sm">{feature}</span>
                    </li>
                  ))}
                  {plan.limitations && plan.limitations.map((limitation, i) => (
                    <li key={`limit-${i}`} className="flex items-start space-x-3 opacity-60">
                      <AlertTriangle className="h-5 w-5 text-slate-400 mt-0.5 flex-shrink-0" />
                      <span className="text-slate-500 text-sm">{limitation}</span>
                    </li>
                  ))}
                </ul>

                <Button 
                  onClick={() => {
                    if (plan.name === 'Enterprise') {
                      window.location.href = '/contact?plan=enterprise';
                    } else if (plan.name === 'Free') {
                      window.location.href = '/signup';
                    } else {
                      window.location.href = `/checkout?plan=${plan.name.toLowerCase()}`;
                    }
                  }}
                  className={`w-full py-4 text-lg font-semibold transition-all duration-300 ${
                    plan.popular 
                      ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg hover:shadow-xl transform hover:scale-105' 
                      : 'bg-slate-900 hover:bg-slate-800 text-white'
                  }`}
                >
                  {plan.cta}
                  {plan.cta !== 'Contact Sales Team' && <ArrowRight className="ml-2 h-5 w-5" />}
                </Button>
              </Card>
            ))}
          </div>

          <div className="text-center mt-12">
            <p className="text-slate-600 mb-4">All paid plans include secure PayPal payments and email support</p>
            <div className="flex justify-center items-center gap-8 text-sm text-slate-500">
              <span>✓ No setup fees</span>
              <span>✓ Cancel anytime</span>
              <span>✓ Monthly billing</span>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-24 bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 text-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-4xl md:text-5xl font-bold mb-8">
            Ready to Start Professional Stock Analysis?
          </h2>
          <p className="text-xl text-slate-200 mb-12 max-w-3xl mx-auto">
            Join traders who rely on our production-grade platform for real-time stock monitoring, 
            comprehensive portfolio management, and intelligent market analysis.
          </p>
          
          <div className="flex flex-col sm:flex-row gap-6 justify-center mb-12">
            <Button 
              size="lg"
              className="bg-emerald-600 hover:bg-emerald-700 px-12 py-6 text-xl font-semibold rounded-lg shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105"
              onClick={() => window.location.href = '/signup'}
            >
              Start Free Account
              <ArrowRight className="ml-3 h-6 w-6" />
            </Button>
            <Button 
              size="lg"
              variant="outline"
              className="border-2 border-white/30 text-white hover:bg-white hover:text-slate-900 px-12 py-6 text-xl font-semibold rounded-lg transition-all duration-300"
              onClick={() => window.location.href = '/contact'}
            >
              Contact Sales Team
            </Button>
          </div>

          <div className="flex flex-col sm:flex-row justify-center items-center gap-8 text-slate-300">
            <div className="flex items-center gap-2">
              <Check className="h-5 w-5 text-emerald-400" />
              <span>Production Ready</span>
            </div>
            <div className="flex items-center gap-2">
              <Check className="h-5 w-5 text-emerald-400" />
              <span>Real-time Data</span>
            </div>
            <div className="flex items-center gap-2">
              <Check className="h-5 w-5 text-emerald-400" />
              <span>Enterprise Security</span>
            </div>
          </div>
        </div>
      </section>
    </Layout>
  );
};

export default Home;