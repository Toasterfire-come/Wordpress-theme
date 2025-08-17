import React, { useState, useEffect } from 'react';
import { useSearchParams, useNavigate } from 'react-router-dom';
import { Check, CreditCard, Shield, ArrowLeft, Loader2, AlertCircle } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Badge } from '../components/ui/badge';
import { Alert } from '../components/ui/alert';
import { stockAPI } from '../services/api';

const PayPalCheckout = () => {
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const [selectedPlan, setSelectedPlan] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [paypalLoaded, setPaypalLoaded] = useState(false);

  const plans = {
    basic: {
      id: 'basic',
      name: 'Basic Plan',
      price: 19,
      billing: 'monthly',
      description: 'Enhanced features for active individual traders',
      features: [
        '500 API requests per hour',
        'Advanced portfolio analytics',
        'Multiple watchlists with targets',
        'CSV/JSON import and export',
        'News sentiment analysis',
        'Email support (24h response)'
      ],
      popular: false
    },
    pro: {
      id: 'pro',
      name: 'Professional Plan',
      price: 49,
      billing: 'monthly',
      description: 'Professional tools for serious traders',
      features: [
        '2000 API requests per hour',
        'Unlimited portfolios & watchlists',
        'Advanced alert system',
        'Alert-based ROI analysis',
        'Priority email support (4h response)',
        'Full API access with authentication'
      ],
      popular: true
    },
    enterprise: {
      id: 'enterprise',
      name: 'Enterprise Plan',
      price: 199,
      billing: 'monthly',
      description: 'Custom solutions for institutions and trading firms',
      features: [
        'Unlimited API requests',
        'Custom integrations & white-labeling',
        'Dedicated account manager',
        'SLA with guaranteed uptime',
        'Custom deployment options',
        'Advanced security features'
      ],
      popular: false
    }
  };

  useEffect(() => {
    const planId = searchParams.get('plan') || 'professional';
    if (plans[planId]) {
      setSelectedPlan(plans[planId]);
    } else {
      setSelectedPlan(plans.professional);
    }

    // Load PayPal SDK
    if (!window.paypal) {
      const script = document.createElement('script');
      script.src = `https://www.paypal.com/sdk/js?client-id=${process.env.REACT_APP_PAYPAL_CLIENT_ID}&vault=true&intent=subscription`;
      script.onload = () => setPaypalLoaded(true);
      script.onerror = () => setError('Failed to load PayPal SDK');
      document.head.appendChild(script);
    } else {
      setPaypalLoaded(true);
    }
  }, [searchParams]);

  useEffect(() => {
    if (paypalLoaded && selectedPlan && window.paypal) {
      renderPayPalButton();
    }
  }, [paypalLoaded, selectedPlan]);

  const renderPayPalButton = () => {
    const container = document.getElementById('paypal-button-container');
    if (!container) return;

    // Clear existing buttons
    container.innerHTML = '';

    window.paypal.Buttons({
      style: {
        shape: 'rect',
        color: 'blue',
        layout: 'vertical',
        label: 'subscribe',
        height: 50
      },
      createSubscription: async (data, actions) => {
        setLoading(true);
        setError('');
        
        try {
          const response = await stockAPI.createPayPalSubscription(selectedPlan.id);
          
          if (response.success && response.subscription_id) {
            return response.subscription_id;
          } else {
            throw new Error(response.error || 'Failed to create subscription');
          }
        } catch (err) {
          setError(err.message);
          setLoading(false);
          throw err;
        }
      },
      onApprove: async (data, actions) => {
        try {
          // Subscription approved - redirect to success page
          navigate(`/payment-success?subscription_id=${data.subscriptionID}&plan=${selectedPlan.id}`);
        } catch (err) {
          setError('Payment approval failed. Please try again.');
          setLoading(false);
        }
      },
      onCancel: (data) => {
        setLoading(false);
        navigate('/payment-cancelled');
      },
      onError: (err) => {
        console.error('PayPal Error:', err);
        setError('Payment processing error. Please try again.');
        setLoading(false);
      }
    }).render('#paypal-button-container');
  };

  const handlePlanChange = (planId) => {
    setSelectedPlan(plans[planId]);
    navigate(`/checkout?plan=${planId}`, { replace: true });
  };

  if (!selectedPlan) {
    return (
      <Layout>
        <div className="min-h-screen flex items-center justify-center">
          <Loader2 className="h-8 w-8 animate-spin text-emerald-600" />
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      <div className="min-h-screen bg-slate-50 py-12">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Header */}
          <div className="text-center mb-12">
            <Button
              variant="ghost"
              onClick={() => navigate('/premium')}
              className="mb-6 text-slate-600 hover:text-slate-900"
            >
              <ArrowLeft className="h-4 w-4 mr-2" />
              Back to Plans
            </Button>
            <h1 className="text-4xl font-bold text-slate-900 mb-4">
              Complete Your Subscription
            </h1>
            <p className="text-xl text-slate-600">
              Secure checkout powered by PayPal
            </p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {/* Plan Selection */}
            <div className="space-y-6">
              <Card className="p-6">
                <h2 className="text-2xl font-bold text-slate-900 mb-6">Choose Your Plan</h2>
                <div className="space-y-4">
                  {Object.values(plans).map((plan) => (
                    <div
                      key={plan.id}
                      className={`p-4 rounded-lg border-2 cursor-pointer transition-all duration-200 ${
                        selectedPlan.id === plan.id
                          ? 'border-emerald-500 bg-emerald-50'
                          : 'border-slate-200 hover:border-slate-300'
                      }`}
                      onClick={() => handlePlanChange(plan.id)}
                    >
                      <div className="flex items-center justify-between mb-2">
                        <div className="flex items-center space-x-3">
                          <div className={`w-4 h-4 rounded-full border-2 ${
                            selectedPlan.id === plan.id
                              ? 'border-emerald-500 bg-emerald-500'
                              : 'border-slate-300'
                          }`}>
                            {selectedPlan.id === plan.id && (
                              <Check className="h-3 w-3 text-white" />
                            )}
                          </div>
                          <div>
                            <h3 className="font-semibold text-slate-900">{plan.name}</h3>
                            <p className="text-sm text-slate-600">{plan.description}</p>
                          </div>
                        </div>
                        <div className="text-right">
                          <span className="text-2xl font-bold text-slate-900">${plan.price}</span>
                          <span className="text-slate-600">/mo</span>
                          {plan.popular && (
                            <Badge className="ml-2 bg-emerald-100 text-emerald-700">Popular</Badge>
                          )}
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </Card>

              {/* Selected Plan Features */}
              <Card className="p-6">
                <h3 className="text-lg font-semibold text-slate-900 mb-4">
                  {selectedPlan.name} Features
                </h3>
                <ul className="space-y-3">
                  {selectedPlan.features.map((feature, index) => (
                    <li key={index} className="flex items-center space-x-3">
                      <Check className="h-5 w-5 text-emerald-500 flex-shrink-0" />
                      <span className="text-slate-700">{feature}</span>
                    </li>
                  ))}
                </ul>
              </Card>

              {/* Security Features */}
              <Card className="p-6 bg-slate-900 text-white">
                <div className="flex items-center space-x-3 mb-4">
                  <Shield className="h-6 w-6 text-emerald-400" />
                  <h3 className="text-lg font-semibold">Secure & Protected</h3>
                </div>
                <ul className="space-y-2 text-sm text-slate-300">
                  <li>• 256-bit SSL encryption</li>
                  <li>• PCI DSS compliant</li>
                  <li>• PayPal buyer protection</li>
                  <li>• Cancel anytime</li>
                </ul>
              </Card>
            </div>

            {/* Checkout */}
            <div className="space-y-6">
              <Card className="p-6">
                <h2 className="text-2xl font-bold text-slate-900 mb-6">Payment Summary</h2>
                
                <div className="space-y-4 mb-6">
                  <div className="flex justify-between items-center py-2">
                    <span className="text-slate-600">{selectedPlan.name}</span>
                    <span className="font-semibold">${selectedPlan.price}/month</span>
                  </div>
                  <hr className="border-slate-200" />
                  <div className="flex justify-between items-center py-2">
                    <span className="text-lg font-semibold text-slate-900">Total due today</span>
                    <span className="text-2xl font-bold text-emerald-600">${selectedPlan.price}</span>
                  </div>
                  <div className="text-sm text-slate-600">
                    Your subscription will be active immediately after payment.
                  </div>
                </div>

                {error && (
                  <Alert className="mb-6 border-red-200 bg-red-50">
                    <AlertCircle className="h-4 w-4 text-red-600" />
                    <div className="text-red-800">{error}</div>
                  </Alert>
                )}

                {/* PayPal Button */}
                <div className="space-y-4">
                  <div className="flex items-center space-x-2 text-sm text-slate-600 mb-4">
                    <CreditCard className="h-4 w-4" />
                    <span>Secure payment powered by PayPal</span>
                  </div>
                  
                  {paypalLoaded ? (
                    <div id="paypal-button-container" className="relative">
                      {loading && (
                        <div className="absolute inset-0 bg-white/80 flex items-center justify-center z-10">
                          <Loader2 className="h-6 w-6 animate-spin text-emerald-600" />
                        </div>
                      )}
                    </div>
                  ) : (
                    <div className="flex items-center justify-center py-12">
                      <Loader2 className="h-8 w-8 animate-spin text-emerald-600" />
                    </div>
                  )}
                </div>

                <div className="mt-6 text-center text-sm text-slate-600">
                  <p>
                    By subscribing, you agree to our{' '}
                    <a href="/terms" className="text-emerald-600 hover:underline">
                      Terms of Service
                    </a>{' '}
                    and{' '}
                    <a href="/privacy" className="text-emerald-600 hover:underline">
                      Privacy Policy
                    </a>
                  </p>
                </div>
              </Card>

              {/* Money Back Guarantee */}
              <Card className="p-6 bg-emerald-50 border-emerald-200">
                <div className="text-center">
                  <div className="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <Shield className="h-6 w-6 text-emerald-600" />
                  </div>
                  <h3 className="font-semibold text-emerald-900 mb-2">
                    30-Day Money Back Guarantee
                  </h3>
                  <p className="text-sm text-emerald-700">
                    Not satisfied? Get a full refund within 30 days, no questions asked.
                  </p>
                </div>
              </Card>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default PayPalCheckout;