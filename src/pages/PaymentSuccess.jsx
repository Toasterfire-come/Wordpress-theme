import React, { useState, useEffect } from 'react';
import { useSearchParams, Link } from 'react-router-dom';
import { CheckCircle, Download, ArrowRight, CreditCard, Calendar, Mail, Phone } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Badge } from '../components/ui/badge';

const PaymentSuccess = () => {
  const [searchParams] = useSearchParams();
  const [subscriptionDetails, setSubscriptionDetails] = useState(null);

  const subscriptionId = searchParams.get('subscription_id');
  const planId = searchParams.get('plan');

  const planDetails = {
    starter: {
      name: 'Starter Plan',
      price: '$29/month',
      features: ['Real-time quotes', 'Basic portfolio', 'Mobile access', 'Email support']
    },
    professional: {
      name: 'Professional Plan', 
      price: '$99/month',
      features: ['Level II data', 'Advanced analytics', 'Priority support', 'API access', 'Custom alerts']
    },
    enterprise: {
      name: 'Enterprise Plan',
      price: '$299/month', 
      features: ['All Pro features', 'Team management', 'Dedicated support', 'Custom integrations']
    }
  };

  const currentPlan = planDetails[planId] || planDetails.professional;

  const nextSteps = [
    {
      icon: Download,
      title: 'Download Mobile Apps',
      description: 'Get our iOS and Android apps for trading on the go',
      action: 'Download Apps',
      link: '/apps'
    },
    {
      icon: Calendar,
      title: 'Schedule Onboarding Call',
      description: 'Book a free 30-minute session with our trading experts',
      action: 'Book Call',
      link: '/book-onboarding'
    },
    {
      icon: Mail,
      title: 'Join Our Community',
      description: 'Connect with other traders in our private Discord server',
      action: 'Join Discord',
      link: '/community'
    }
  ];

  const benefits = [
    'Access to real-time market data from 50+ exchanges worldwide',
    'Professional-grade charting tools with 100+ technical indicators',
    'Custom alerts and notifications via email, SMS, and push notifications',
    'Advanced portfolio analytics and performance tracking',
    'Priority customer support with dedicated account management',
    'API access for custom integrations and automated trading',
    'Educational resources and weekly market analysis reports',
    'Mobile apps for iOS and Android with full feature parity'
  ];

  useEffect(() => {
    // In a real app, fetch subscription details from API
    setSubscriptionDetails({
      id: subscriptionId,
      plan: currentPlan.name,
      status: 'active',
      nextBilling: new Date(Date.now() + 14 * 24 * 60 * 60 * 1000).toLocaleDateString(),
      trialEnds: new Date(Date.now() + 14 * 24 * 60 * 60 * 1000).toLocaleDateString()
    });
  }, [subscriptionId, currentPlan.name]);

  return (
    <Layout>
      <div className="min-h-screen bg-gradient-to-br from-emerald-50 to-blue-50">
        {/* Success Hero */}
        <section className="py-20">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div className="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-8">
              <CheckCircle className="h-12 w-12 text-emerald-600" />
            </div>
            
            <h1 className="text-4xl md:text-5xl font-bold text-slate-900 mb-6">
              Welcome to Stock Scanner Pro!
            </h1>
            
            <p className="text-xl text-slate-600 mb-8 max-w-2xl mx-auto">
              Your subscription has been successfully activated. You now have access to professional-grade trading tools used by thousands of traders worldwide.
            </p>

            <div className="flex flex-col sm:flex-row gap-4 justify-center mb-8">
              <Button 
                size="lg"
                className="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4"
                onClick={() => window.location.href = '/dashboard'}
              >
                Go to Dashboard
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
              <Button 
                size="lg"
                variant="outline"
                className="border-slate-300 text-slate-700 hover:bg-slate-50 px-8 py-4"
                onClick={() => window.location.href = '/getting-started'}
              >
                Getting Started Guide
              </Button>
            </div>

            {/* Subscription Details */}
            {subscriptionDetails && (
              <Card className="max-w-md mx-auto p-6 bg-white shadow-lg">
                <div className="text-center">
                  <Badge className="bg-emerald-100 text-emerald-700 mb-4">Active Subscription</Badge>
                  <h3 className="text-lg font-bold text-slate-900 mb-2">{subscriptionDetails.plan}</h3>
                  <p className="text-2xl font-bold text-emerald-600 mb-1">{currentPlan.price}</p>
                  <p className="text-sm text-slate-600 mb-4">
                    14-day free trial • Next billing: {subscriptionDetails.nextBilling}
                  </p>
                  <div className="flex items-center justify-center space-x-2 text-sm text-slate-600">
                    <CreditCard className="h-4 w-4" />
                    <span>ID: {subscriptionDetails.id}</span>
                  </div>
                </div>
              </Card>
            )}
          </div>
        </section>

        {/* What's Included */}
        <section className="py-16 bg-white">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-slate-900 mb-4">
                What's Included in Your {currentPlan.name}
              </h2>
              <p className="text-lg text-slate-600">
                You now have access to all these professional features
              </p>
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
              {benefits.map((benefit, index) => (
                <div key={index} className="flex items-start space-x-3">
                  <CheckCircle className="h-6 w-6 text-emerald-500 mt-0.5 flex-shrink-0" />
                  <p className="text-slate-700">{benefit}</p>
                </div>
              ))}
            </div>

            <div className="bg-slate-50 rounded-2xl p-8 text-center">
              <h3 className="text-xl font-bold text-slate-900 mb-4">
                🎉 Special Welcome Bonus
              </h3>
              <p className="text-slate-600 mb-6">
                As a new subscriber, you'll receive a complimentary 1-on-1 onboarding session with one of our trading experts (valued at $200). 
                This session will help you optimize your trading setup and get the most out of our platform.
              </p>
              <Button className="bg-emerald-600 hover:bg-emerald-700 text-white">
                Schedule Your Session
              </Button>
            </div>
          </div>
        </section>

        {/* Next Steps */}
        <section className="py-16 bg-slate-50">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-slate-900 mb-4">
                Your Next Steps
              </h2>
              <p className="text-lg text-slate-600">
                Get the most out of your new subscription with these recommended actions
              </p>
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {nextSteps.map((step, index) => {
                const Icon = step.icon;
                return (
                  <Card key={index} className="p-8 text-center hover:shadow-lg transition-all duration-300">
                    <div className="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                      <Icon className="h-8 w-8 text-emerald-600" />
                    </div>
                    <h3 className="text-xl font-bold text-slate-900 mb-4">{step.title}</h3>
                    <p className="text-slate-600 mb-6 leading-relaxed">{step.description}</p>
                    <Button 
                      variant="outline"
                      className="w-full border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white"
                      onClick={() => window.location.href = step.link}
                    >
                      {step.action}
                    </Button>
                  </Card>
                );
              })}
            </div>
          </div>
        </section>

        {/* Support Section */}
        <section className="py-16 bg-white">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <Card className="p-8 bg-gradient-to-r from-slate-900 to-blue-900 text-white text-center">
              <h2 className="text-2xl font-bold mb-4">
                Need Help Getting Started?
              </h2>
              <p className="text-slate-200 mb-8 max-w-2xl mx-auto">
                Our customer success team is here to help you make the most of your new subscription. 
                Get personalized assistance setting up your trading environment.
              </p>
              
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="flex items-center space-x-4">
                  <div className="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                    <Phone className="h-6 w-6 text-emerald-400" />
                  </div>
                  <div className="text-left">
                    <p className="font-semibold text-white">Call Us Directly</p>
                    <p className="text-slate-300 text-sm">+1 (555) 123-4567</p>
                    <p className="text-slate-400 text-xs">Mon-Fri, 9 AM - 6 PM EST</p>
                  </div>
                </div>
                
                <div className="flex items-center space-x-4">
                  <div className="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center">
                    <Mail className="h-6 w-6 text-emerald-400" />
                  </div>
                  <div className="text-left">
                    <p className="font-semibold text-white">Email Support</p>
                    <p className="text-slate-300 text-sm">support@stockscannerpro.com</p>
                    <p className="text-slate-400 text-xs">Response within 2 hours</p>
                  </div>
                </div>
              </div>
            </Card>
          </div>
        </section>

        {/* Footer CTA */}
        <section className="py-16 bg-slate-50 border-t border-slate-200">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">
              Ready to Start Trading Like a Pro?
            </h2>
            <p className="text-lg text-slate-600 mb-8">
              Your professional trading journey begins now. Access your dashboard and start exploring the platform.
            </p>
            
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button 
                size="lg"
                className="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4"
                onClick={() => window.location.href = '/dashboard'}
              >
                Open Dashboard
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
              <Button 
                size="lg"
                variant="outline"
                className="border-slate-300 text-slate-700 hover:bg-slate-50 px-8 py-4"
                onClick={() => window.location.href = '/help'}
              >
                View Help Center
              </Button>
            </div>

            <div className="mt-8 text-sm text-slate-500">
              <p>
                Remember: You have a 14-day free trial and 30-day money-back guarantee. 
                <Link to="/billing" className="text-emerald-600 hover:underline ml-1">
                  Manage your subscription
                </Link>
              </p>
            </div>
          </div>
        </section>
      </div>
    </Layout>
  );
};

export default PaymentSuccess;