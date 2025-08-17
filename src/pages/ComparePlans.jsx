import React from 'react';
import { Check, X, ArrowRight, Zap, Shield, Database, PieChart, Bell, FileText, Target, Activity, Lock } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Badge } from '../components/ui/badge';

const ComparePlans = () => {
  const plans = [
    {
      name: 'Free',
      price: '$0',
      period: '/month',
      color: 'slate'
    },
    {
      name: 'Basic', 
      price: '$24.99',
      period: '/month',
      color: 'emerald',
      popular: true
    },
    {
      name: 'Pro',
      price: '$49.99', 
      period: '/month',
      color: 'blue'
    },
    {
      name: 'Enterprise',
      price: 'Contact Sales',
      period: '',
      color: 'purple'
    }
  ];

  const features = [
    {
      category: 'API Access & Usage',
      icon: Zap,
      items: [
        {
          name: 'Monthly API Requests',
          free: '15 requests',
          basic: '1,500 requests',
          pro: '5,000 requests',
          enterprise: 'Unlimited'
        },
        {
          name: 'Rate Limiting',
          free: 'Basic throttling',
          basic: 'Enhanced limits',
          pro: 'Priority access',
          enterprise: 'No limits'
        },
        {
          name: 'API Response Time',
          free: 'Standard',
          basic: 'Standard',
          pro: 'Priority',
          enterprise: 'Guaranteed SLA'
        }
      ]
    },
    {
      category: 'Core Features',
      icon: Database,
      items: [
        {
          name: 'Stock Symbol Lookup',
          free: true,
          basic: true,
          pro: true,
          enterprise: true
        },
        {
          name: 'Real-time Market Data',
          free: 'Basic access',
          basic: 'Full access',
          pro: 'Full access',
          enterprise: 'Custom feeds'
        },
        {
          name: 'Historical Data',
          free: false,
          basic: true,
          pro: true,
          enterprise: true
        },
        {
          name: 'Market Scanner',
          free: 'Basic filtering',
          basic: 'Advanced filtering',
          pro: 'Custom filters',
          enterprise: 'White-label scanner'
        }
      ]
    },
    {
      category: 'Portfolio Management', 
      icon: PieChart,
      items: [
        {
          name: 'Portfolio Tracking',
          free: false,
          basic: 'Up to 3 portfolios',
          pro: 'Unlimited portfolios',
          enterprise: 'Custom portfolio tools'
        },
        {
          name: 'Performance Analytics',
          free: false,
          basic: 'Basic metrics',
          pro: 'Advanced analytics',
          enterprise: 'Custom reporting'
        },
        {
          name: 'ROI Calculations',
          free: false,
          basic: 'Basic ROI',
          pro: 'Advanced ROI + alerts',
          enterprise: 'Custom calculations'
        },
        {
          name: 'CSV/JSON Export',
          free: false,
          basic: 'Basic export',
          pro: 'Bulk operations',
          enterprise: 'Custom formats'
        }
      ]
    },
    {
      category: 'Alerts & Notifications',
      icon: Bell,
      items: [
        {
          name: 'Email Alerts',
          free: false,
          basic: 'Up to 10 alerts',
          pro: 'Up to 50 alerts',
          enterprise: 'Unlimited alerts'
        },
        {
          name: 'Price Threshold Alerts',
          free: false,
          basic: true,
          pro: true,
          enterprise: true
        },
        {
          name: 'Custom Alert Conditions',
          free: false,
          basic: false,
          pro: true,
          enterprise: true
        },
        {
          name: 'Alert Response Time',
          free: 'N/A',
          basic: 'Within 5 minutes',
          pro: 'Within 2 minutes',
          enterprise: 'Real-time'
        }
      ]
    },
    {
      category: 'News & Analysis',
      icon: FileText,
      items: [
        {
          name: 'Market News Access',
          free: false,
          basic: 'General market news',
          pro: 'Personalized feeds',
          enterprise: 'Custom news sources'
        },
        {
          name: 'Sentiment Analysis',
          free: false,
          basic: 'Basic sentiment scores',
          pro: 'Advanced sentiment + trends',
          enterprise: 'Custom AI models'
        },
        {
          name: 'News Alerts',
          free: false,
          basic: 'Keyword alerts',
          pro: 'Smart news alerts',
          enterprise: 'Custom news alerts'
        }
      ]
    },
    {
      category: 'Security & Support',
      icon: Shield,
      items: [
        {
          name: 'Support Level',
          free: 'Community email',
          basic: 'Email (24h response)',
          pro: 'Priority email (4h)',
          enterprise: 'Dedicated manager + phone'
        },
        {
          name: 'Security Features',
          free: 'Basic encryption',
          basic: 'Enhanced security',
          pro: 'Advanced security + API',
          enterprise: 'Custom security config'
        },
        {
          name: 'SLA Guarantee',
          free: false,
          basic: false,
          pro: false,
          enterprise: '99.9% uptime guarantee'
        },
        {
          name: 'Data Backup',
          free: 'Basic backup',
          basic: 'Daily backups',
          pro: 'Real-time backups',
          enterprise: 'Custom backup schedule'
        }
      ]
    }
  ];

  const renderFeatureValue = (value, planName) => {
    if (typeof value === 'boolean') {
      return value ? (
        <Check className="h-5 w-5 text-green-500 mx-auto" />
      ) : (
        <X className="h-5 w-5 text-slate-300 mx-auto" />
      );
    }
    
    if (typeof value === 'string') {
      const isUnavailable = value === 'N/A' || value === false;
      return (
        <span className={`text-sm ${isUnavailable ? 'text-slate-400' : 'text-slate-700'} text-center`}>
          {value}
        </span>
      );
    }
    
    return <span className="text-sm text-slate-700 text-center">{value}</span>;
  };

  const handlePlanSelect = (planName) => {
    const planId = planName.toLowerCase();
    if (planId === 'enterprise') {
      window.location.href = '/contact?plan=enterprise';
    } else if (planId === 'free') {
      window.location.href = '/signup';
    } else {
      window.location.href = `/checkout?plan=${planId}`;
    }
  };

  return (
    <Layout>
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-bold mb-6">
            Compare All Plans
            <span className="block bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent mt-2">
              Side by Side
            </span>
          </h1>
          <p className="text-xl text-slate-200 mb-8 max-w-3xl mx-auto">
            Find the perfect plan for your trading needs. Compare features, limits, and pricing across all tiers.
          </p>
        </div>
      </section>

      {/* Plans Header */}
      <section className="py-12 bg-white border-b border-slate-200">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-5 gap-6">
            <div className="col-span-1">
              <h3 className="text-lg font-semibold text-slate-900">Plans</h3>
            </div>
            {plans.map((plan, index) => (
              <div key={index} className="col-span-1 text-center">
                <div className={`p-6 rounded-xl border-2 ${
                  plan.popular 
                    ? 'border-emerald-500 bg-emerald-50' 
                    : 'border-slate-200 bg-white'
                }`}>
                  {plan.popular && (
                    <Badge className="bg-emerald-600 text-white px-3 py-1 mb-3">
                      Most Popular
                    </Badge>
                  )}
                  <h3 className="text-xl font-bold text-slate-900 mb-2">{plan.name}</h3>
                  <div className="text-3xl font-bold text-slate-900 mb-1">{plan.price}</div>
                  <div className="text-slate-600">{plan.period}</div>
                  <Button 
                    onClick={() => handlePlanSelect(plan.name)}
                    className={`w-full mt-4 ${
                      plan.popular 
                        ? 'bg-emerald-600 hover:bg-emerald-700' 
                        : 'bg-slate-900 hover:bg-slate-800'
                    } text-white`}
                  >
                    {plan.name === 'Enterprise' ? 'Contact Sales' : 
                     plan.name === 'Free' ? 'Get Started' : 'Select Plan'}
                    {plan.name !== 'Enterprise' && <ArrowRight className="ml-2 h-4 w-4" />}
                  </Button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Feature Comparison */}
      <section className="py-12 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {features.map((category, categoryIndex) => {
            const CategoryIcon = category.icon;
            return (
              <div key={categoryIndex} className="mb-12">
                <div className="flex items-center mb-6">
                  <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-4">
                    <CategoryIcon className="h-5 w-5 text-emerald-600" />
                  </div>
                  <h2 className="text-2xl font-bold text-slate-900">{category.category}</h2>
                </div>
                
                <Card className="overflow-hidden">
                  <div className="bg-slate-50 border-b border-slate-200">
                    <div className="grid grid-cols-5 gap-6 p-4">
                      <div className="col-span-1">
                        <span className="text-sm font-semibold text-slate-600 uppercase tracking-wide">
                          Feature
                        </span>
                      </div>
                      {plans.map((plan, index) => (
                        <div key={index} className="col-span-1 text-center">
                          <span className="text-sm font-semibold text-slate-600 uppercase tracking-wide">
                            {plan.name}
                          </span>
                        </div>
                      ))}
                    </div>
                  </div>
                  
                  <div className="divide-y divide-slate-200">
                    {category.items.map((item, itemIndex) => (
                      <div key={itemIndex} className="grid grid-cols-5 gap-6 p-4 hover:bg-slate-50 transition-colors">
                        <div className="col-span-1 flex items-center">
                          <span className="font-medium text-slate-900">{item.name}</span>
                        </div>
                        <div className="col-span-1 flex items-center justify-center">
                          {renderFeatureValue(item.free, 'Free')}
                        </div>
                        <div className="col-span-1 flex items-center justify-center">
                          {renderFeatureValue(item.basic, 'Basic')}
                        </div>
                        <div className="col-span-1 flex items-center justify-center">
                          {renderFeatureValue(item.pro, 'Pro')}
                        </div>
                        <div className="col-span-1 flex items-center justify-center">
                          {renderFeatureValue(item.enterprise, 'Enterprise')}
                        </div>
                      </div>
                    ))}
                  </div>
                </Card>
              </div>
            );
          })}
        </div>
      </section>

      {/* Summary Section */}
      <section className="py-16 bg-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-6">
            Choose the Right Plan for Your Needs
          </h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <Card className="p-6 border-l-4 border-l-slate-400">
              <h3 className="font-bold text-slate-900 mb-2">Free</h3>
              <p className="text-sm text-slate-600">Perfect for casual users who need basic stock lookup functionality</p>
            </Card>
            <Card className="p-6 border-l-4 border-l-emerald-500">
              <h3 className="font-bold text-slate-900 mb-2">Basic</h3>
              <p className="text-sm text-slate-600">Ideal for individual traders who want portfolio tracking and alerts</p>
            </Card>
            <Card className="p-6 border-l-4 border-l-blue-500">
              <h3 className="font-bold text-slate-900 mb-2">Pro</h3>
              <p className="text-sm text-slate-600">Best for professional traders who need advanced analytics and API access</p>
            </Card>
            <Card className="p-6 border-l-4 border-l-purple-500">
              <h3 className="font-bold text-slate-900 mb-2">Enterprise</h3>
              <p className="text-sm text-slate-600">Custom solutions for institutions and trading firms</p>
            </Card>
          </div>
          
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button 
              size="lg"
              className="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4"
              onClick={() => window.location.href = '/signup'}
            >
              Start Free Account
              <ArrowRight className="ml-2 h-5 w-5" />
            </Button>
            <Button 
              size="lg"
              variant="outline"
              className="border-slate-300 text-slate-700 hover:bg-slate-50 px-8 py-4"
              onClick={() => window.location.href = '/premium'}
            >
              View All Plans
            </Button>
          </div>
        </div>
      </section>
    </Layout>
  );
};

export default ComparePlans;