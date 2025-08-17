import React, { useState } from 'react';
import { Check, Star, ArrowRight, Zap, Shield, Users, Globe, Award, CreditCard, Sparkles, Database, Lock, Activity, AlertTriangle, FileText, PieChart, Target, Layers } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Badge } from '../components/ui/badge';

const PremiumPlans = () => {
  const [billingPeriod, setBillingPeriod] = useState('monthly');

  const monthlyPlans = [
    {
      id: 'free',
      name: 'Free',
      price: 0,
      originalPrice: null,
      description: 'Basic stock lookup and filtering for casual users',
      features: [
        '15 API requests per month',
        'Stock symbol lookup & search',
        'Basic price filtering',
        'Market hours data access',
        'Community email support'
      ],
      limitations: [
        'No portfolio management',
        'No email alerts or notifications',
        'No news access or sentiment analysis',
        'No advanced analytics',
        'Limited to basic lookup functionality'
      ],
      limits: {
        requests: '15 per month',
        portfolios: 'Not available',
        alerts: 'Not available',
        support: 'Community email'
      },
      popular: false,
      cta: 'Get Started Free',
      highlight: 'Perfect for casual users'
    },
    {
      id: 'basic',
      name: 'Basic',
      price: 24.99,
      originalPrice: null,
      description: 'Enhanced features for active individual traders',
      features: [
        '1,500 API requests per month',
        'Full stock scanner & lookup',
        'Email alerts & notifications',
        'News sentiment analysis access',
        'Basic portfolio tracking',
        'CSV import/export functionality',
        'Email support (24h response)',
        'Historical data access'
      ],
      limits: {
        requests: '1,500 per month',
        portfolios: 'Up to 3 portfolios',
        alerts: 'Up to 10 active alerts',
        support: 'Email (24h response)'
      },
      popular: true,
      cta: 'Start Basic Plan',
      highlight: 'Most popular choice'
    },
    {
      id: 'pro',
      name: 'Pro',
      price: 49.99,
      originalPrice: null,
      description: 'Professional tools for serious traders and small teams',
      features: [
        '5,000 API requests per month',
        'Unlimited portfolios & watchlists',
        'Advanced alert system',
        'Full REST API access',
        'Priority email support (4h response)',
        'Advanced performance analytics',
        'Custom alert conditions',
        'Bulk import/export operations',
        'Advanced news personalization'
      ],
      limits: {
        requests: '5,000 per month',
        portfolios: 'Unlimited',
        alerts: 'Up to 50 active alerts',
        support: 'Priority email (4h response)'
      },
      popular: false,
      cta: 'Start Pro Plan',
      highlight: 'For professional traders'
    },
    {
      id: 'enterprise',
      name: 'Enterprise',
      price: 'Contact Sales',
      originalPrice: null,
      description: 'Custom solutions for institutions and trading firms',
      features: [
        'Unlimited API requests',
        'Custom integrations & white-labeling',
        'Dedicated account manager',
        'SLA with guaranteed uptime',
        'Custom deployment options',
        'Advanced security features',
        'Custom reporting & analytics',
        'Team collaboration tools',
        'Priority feature requests',
        'Training & onboarding sessions'
      ],
      limits: {
        requests: 'Unlimited',
        portfolios: 'Unlimited',
        alerts: 'Unlimited',
        support: 'Dedicated manager + phone'
      },
      popular: false,
      cta: 'Contact Sales Team',
      highlight: 'Tailored solutions'
    }
  ];

  const yearlyPlans = monthlyPlans.map(plan => ({
    ...plan,
    price: plan.id === 'enterprise' || plan.id === 'free' ? plan.price : Math.floor(plan.price * 12 * 0.85), // 15% discount
    originalPrice: plan.id === 'free' || plan.id === 'enterprise' ? null : plan.price * 12,
    billing: 'yearly'
  }));

  const currentPlans = billingPeriod === 'monthly' ? monthlyPlans : yearlyPlans;

  const features = {
    'Monthly Rate Limits': {
      icon: Zap,
      description: 'Monthly API request quotas designed for fair usage and optimal performance across all user tiers.',
      comparison: {
        free: '15 requests',
        basic: '1,500 requests',
        pro: '5,000 requests',
        enterprise: 'Unlimited'
      }
    },
    'Security Features': {
      icon: Lock,
      description: 'Enterprise-grade security with authentication, input validation, and comprehensive audit logging.',
      comparison: {
        free: 'Basic security',
        basic: 'Enhanced security',
        pro: 'Advanced security + API',
        enterprise: 'Custom security config'
      }
    },
    'Market Data Access': {
      icon: Database,
      description: 'Real-time stock data with automated updates every 10 minutes during market hours.',
      comparison: {
        free: 'Basic lookup only',
        basic: 'Full market data',
        pro: 'Full data + API access',
        enterprise: 'Custom data feeds'
      }
    },
    'Portfolio Management': {
      icon: PieChart,
      description: 'Comprehensive portfolio tracking with performance metrics and analytics.',
      comparison: {
        free: 'Not available',
        basic: 'Up to 3 portfolios',
        pro: 'Unlimited portfolios',
        enterprise: 'Custom portfolio tools'
      }
    }
  };

  const testimonials = [
    {
      name: 'Michael Torres',
      role: 'Day Trader',
      company: 'Independent',
      content: 'The Basic plan with 1,500 monthly requests is perfect for my trading frequency. The news sentiment analysis has significantly improved my decision making.',
      rating: 5,
      plan: 'Basic'
    },
    {
      name: 'Sarah Martinez',
      role: 'Portfolio Manager',
      company: 'Investment Firm',
      content: 'Pro plan\'s 5,000 monthly requests and unlimited portfolios allow me to manage multiple client accounts efficiently. The API access is excellent.',
      rating: 5,
      plan: 'Pro'
    }
  ];

  const handlePlanSelect = (planId) => {
    if (planId === 'enterprise') {
      window.location.href = '/contact?plan=enterprise';
    } else if (planId === 'free') {
      window.location.href = '/signup';
    } else {
      window.location.href = `/checkout?plan=${planId}&billing=${billingPeriod}`;
    }
  };

  return (
    <Layout>
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <Badge className="bg-emerald-600/20 text-emerald-300 border-emerald-500/30 mb-6 px-4 py-2">
            <Sparkles className="h-4 w-4 mr-2" />
            Professional Stock Analysis Platform
          </Badge>
          
          <h1 className="text-5xl md:text-6xl font-bold mb-6">
            Choose Your
            <span className="block bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent mt-2">
              Trading Plan
            </span>
          </h1>
          
          <p className="text-xl text-slate-200 mb-12 max-w-3xl mx-auto">
            From casual lookup users to professional trading firms - select the plan that matches your needs. 
            Built with enterprise-grade security and real-time stock data updated sub three minutes.
          </p>

          {/* Billing Toggle */}
          <div className="flex items-center justify-center mb-8">
            <div className="bg-white/10 backdrop-blur-sm rounded-xl p-1 flex">
              <button
                onClick={() => setBillingPeriod('monthly')}
                className={`px-6 py-3 rounded-lg font-semibold transition-all duration-200 ${
                  billingPeriod === 'monthly'
                    ? 'bg-white text-slate-900 shadow-lg'
                    : 'text-white hover:bg-white/10'
                }`}
              >
                Monthly
              </button>
              <button
                onClick={() => setBillingPeriod('yearly')}
                className={`px-6 py-3 rounded-lg font-semibold transition-all duration-200 relative ${
                  billingPeriod === 'yearly'
                    ? 'bg-white text-slate-900 shadow-lg'
                    : 'text-white hover:bg-white/10'
                }`}
              >
                Yearly
                <Badge className="absolute -top-2 -right-2 bg-emerald-500 text-white text-xs px-2 py-0.5">
                  15% OFF
                </Badge>
              </button>
            </div>
          </div>
        </div>
      </section>

      {/* Pricing Cards */}
      <section className="py-20 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            {currentPlans.map((plan, index) => (
              <Card 
                key={plan.id} 
                className={`p-8 relative ${
                  plan.popular 
                    ? 'border-2 border-emerald-500 shadow-xl scale-105 bg-white' 
                    : 'hover:shadow-lg bg-white'
                } transition-all duration-300`}
              >
                {plan.popular && (
                  <Badge className="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-emerald-600 text-white px-6 py-2 shadow-lg">
                    <Star className="h-4 w-4 mr-1" />
                    {plan.highlight}
                  </Badge>
                )}
                
                <div className="text-center mb-8">
                  <h3 className="text-2xl font-bold text-slate-900 mb-2">{plan.name}</h3>
                  <div className="flex items-baseline justify-center mb-2">
                    <span className="text-4xl font-bold text-slate-900">
                      {typeof plan.price === 'number' ? `$${plan.price}` : plan.price}
                    </span>
                    {typeof plan.price === 'number' && plan.price > 0 && (
                      <span className="text-xl text-slate-600 ml-1">
                        {billingPeriod === 'yearly' ? '/year' : '/month'}
                      </span>
                    )}
                  </div>
                  <p className="text-slate-600 text-sm">{plan.description}</p>
                  
                  {plan.originalPrice && billingPeriod === 'yearly' && plan.id !== 'enterprise' && (
                    <p className="text-sm text-slate-500 mt-2">
                      <span className="line-through">${plan.originalPrice}/year</span>
                      <span className="text-emerald-600 font-semibold ml-2">
                        Save ${plan.originalPrice - plan.price}
                      </span>
                    </p>
                  )}
                </div>

                <div className="space-y-4 mb-8">
                  <div>
                    <h4 className="font-semibold text-slate-900 mb-3">Included Features:</h4>
                    <ul className="space-y-3">
                      {plan.features.map((feature, i) => (
                        <li key={i} className="flex items-start space-x-3">
                          <Check className="h-4 w-4 text-emerald-500 mt-0.5 flex-shrink-0" />
                          <span className="text-slate-700 text-sm">{feature}</span>
                        </li>
                      ))}
                    </ul>
                  </div>

                  {plan.limitations && (
                    <div>
                      <h4 className="font-semibold text-slate-500 mb-3">Not Included:</h4>
                      <ul className="space-y-2">
                        {plan.limitations.map((limitation, i) => (
                          <li key={i} className="flex items-start space-x-3 opacity-60">
                            <AlertTriangle className="h-4 w-4 text-slate-400 mt-0.5 flex-shrink-0" />
                            <span className="text-slate-500 text-sm">{limitation}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}
                </div>

                <div className="border-t border-slate-200 pt-6 mb-6">
                  <div className="space-y-2 text-sm text-slate-600">
                    <div className="flex justify-between">
                      <span>Monthly Requests:</span>
                      <span className="font-semibold">{plan.limits.requests}</span>
                    </div>
                    <div className="flex justify-between">
                      <span>Portfolios:</span>
                      <span className="font-semibold">{plan.limits.portfolios}</span>
                    </div>
                    <div className="flex justify-between">
                      <span>Alerts:</span>
                      <span className="font-semibold">{plan.limits.alerts}</span>
                    </div>
                    <div className="flex justify-between">
                      <span>Support:</span>
                      <span className="font-semibold text-xs">{plan.limits.support}</span>
                    </div>
                  </div>
                </div>

                <Button 
                  onClick={() => handlePlanSelect(plan.id)}
                  className={`w-full py-4 text-lg font-semibold transition-all duration-300 ${
                    plan.popular 
                      ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg hover:shadow-xl transform hover:scale-105' 
                      : 'bg-slate-900 hover:bg-slate-800 text-white'
                  }`}
                >
                  {plan.cta}
                  {!plan.cta.includes('Contact') && <ArrowRight className="ml-2 h-5 w-5" />}
                </Button>

                <div className="text-center mt-4 text-xs text-slate-600">
                  {plan.id === 'free' ? 'Always free • No credit card required' : 'Secure PayPal payments • Cancel anytime'}
                </div>
              </Card>
            ))}
          </div>

          {/* Feature Comparison */}
          <div className="mt-20">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-slate-900 mb-4">
                Compare Features in Detail
              </h2>
              <p className="text-xl text-slate-600">
                See exactly what's included in each plan based on our production system
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              {Object.entries(features).map(([name, feature]) => {
                const Icon = feature.icon;
                return (
                  <Card key={name} className="p-6 hover:shadow-lg transition-all duration-300">
                    <div className="flex items-center mb-4">
                      <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                        <Icon className="h-5 w-5 text-emerald-600" />
                      </div>
                      <h3 className="font-semibold text-slate-900">{name}</h3>
                    </div>
                    
                    <p className="text-sm text-slate-600 mb-4">{feature.description}</p>
                    
                    <div className="space-y-2 border-t border-slate-200 pt-4">
                      {Object.entries(feature.comparison).map(([plan, value]) => (
                        <div key={plan} className="flex justify-between text-sm">
                          <span className="capitalize font-medium">{plan}:</span>
                          <span className="text-slate-600">{value}</span>
                        </div>
                      ))}
                    </div>
                  </Card>
                );
              })}
            </div>
          </div>

          {/* Testimonials */}
          <div className="mt-20">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-slate-900 mb-4">
                What Our Users Say
              </h2>
              <p className="text-xl text-slate-600">
                Real feedback from traders using our platform
              </p>
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
              {testimonials.map((testimonial, index) => (
                <Card key={index} className="p-8">
                  <div className="flex items-center mb-4">
                    <div className="w-12 h-12 bg-gradient-to-br from-emerald-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                      {testimonial.name.split(' ').map(n => n[0]).join('')}
                    </div>
                    <div className="flex-1">
                      <h4 className="font-semibold text-slate-900">{testimonial.name}</h4>
                      <p className="text-sm text-slate-600">{testimonial.role}</p>
                      <p className="text-sm text-slate-500">{testimonial.company}</p>
                    </div>
                    <Badge className="bg-emerald-100 text-emerald-700">
                      {testimonial.plan}
                    </Badge>
                  </div>
                  <div className="flex mb-4">
                    {[...Array(testimonial.rating)].map((_, i) => (
                      <Star key={i} className="h-5 w-5 text-yellow-400 fill-current" />
                    ))}
                  </div>
                  <p className="text-slate-700 italic">"{testimonial.content}"</p>
                </Card>
              ))}
            </div>
          </div>

          {/* Security & Compliance */}
          <Card className="mt-16 p-8 bg-gradient-to-r from-slate-900 to-blue-900 text-white">
            <div className="text-center">
              <div className="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <Shield className="h-8 w-8 text-emerald-400" />
              </div>
              <h3 className="text-2xl font-bold text-white mb-4">
                Enterprise-Grade Security
              </h3>
              <p className="text-lg text-slate-200 mb-6">
                Built with production-ready security features including authentication, input validation, 
                rate limiting, and comprehensive audit logging for complete data protection.
              </p>
              <div className="flex flex-wrap justify-center items-center gap-6 text-sm text-slate-300">
                <div className="flex items-center">
                  <Lock className="h-4 w-4 mr-2" />
                  <span>256-bit SSL Encryption</span>
                </div>
                <div className="flex items-center">
                  <Check className="h-4 w-4 mr-2" />
                  <span>Input Validation</span>
                </div>
                <div className="flex items-center">
                  <Shield className="h-4 w-4 mr-2" />
                  <span>Secure PayPal Payments</span>
                </div>
                <div className="flex items-center">
                  <Activity className="h-4 w-4 mr-2" />
                  <span>Audit Logging</span>
                </div>
              </div>
            </div>
          </Card>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">
              Frequently Asked Questions
            </h2>
          </div>
          
          <div className="space-y-6">
            {[
              {
                question: "What's the difference between Free and paid plans?",
                answer: "Free plan provides 15 monthly requests for basic stock lookup only - no portfolio management, email alerts, or news access. Paid plans include full features, portfolio management, email alerts, news sentiment analysis, and significantly higher monthly request limits."
              },
              {
                question: "How do monthly request limits work?",
                answer: "Each API call (stock lookup, portfolio update, news request, etc.) counts toward your monthly limit. Limits reset on your billing cycle date. Free tier gets 15 requests/month, Basic gets 1,500, Pro gets 5,000, and Enterprise gets unlimited."
              },
              {
                question: "Can I upgrade or downgrade my plan anytime?",
                answer: "Yes, you can change your plan at any time. Upgrades take effect immediately with prorated billing. For downgrades, you'll continue with your current plan until the next billing cycle. All your data is preserved when changing plans."
              },
              {
                question: "What payment methods do you accept?",
                answer: "We accept secure PayPal payments for all paid plans. PayPal account is not required - you can pay with any major credit card through PayPal's secure checkout system."
              },
              {
                question: "What happens if I exceed my monthly limit?",
                answer: "If you reach your monthly request limit, API calls will be temporarily restricted until your next billing cycle. We recommend upgrading to a higher tier if you consistently approach your limits."
              },
              {
                question: "How secure is my data?",
                answer: "We use enterprise-grade security including 256-bit SSL encryption, input validation, rate limiting, and comprehensive audit logging. We never store brokerage credentials - only the portfolio data you choose to input."
              }
            ].map((faq, index) => (
              <Card key={index} className="p-6">
                <h3 className="font-semibold text-slate-900 mb-2">{faq.question}</h3>
                <p className="text-slate-600">{faq.answer}</p>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Final CTA */}
      <section className="py-20 bg-slate-900 text-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold mb-6">
            Ready to Start Professional Stock Analysis?
          </h2>
          <p className="text-xl text-slate-300 mb-8">
            Join traders who trust our platform for real-time stock data and professional portfolio management
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button 
              size="lg"
              className="bg-emerald-600 hover:bg-emerald-700 px-8 py-4 text-lg font-semibold"
              onClick={() => window.location.href = '/signup'}
            >
              Start Free Account
              <ArrowRight className="ml-2 h-5 w-5" />
            </Button>
            <Button 
              size="lg"
              variant="outline"
              className="border-white/30 text-white hover:bg-white hover:text-slate-900 px-8 py-4 text-lg font-semibold"
              onClick={() => window.location.href = '/contact'}
            >
              Contact Sales
            </Button>
          </div>
        </div>
      </section>
    </Layout>
  );
};

export default PremiumPlans;