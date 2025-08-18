import React, { useState } from 'react';
import { Mail, Send, CheckCircle, HeadphonesIcon } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Input } from '../components/ui/input';
import { Textarea } from '../components/ui/textarea';
import { Badge } from '../components/ui/badge';
import { stockAPI } from '../services/api';

const Contact = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    company: '',
    subject: '',
    message: '',
    category: 'general'
  });
  const [loading, setLoading] = useState(false);
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    
    try {
      const response = await stockAPI.submitContactForm(formData);
      if (response.success) {
        setSubmitted(true);
        setFormData({
          name: '',
          email: '',
          company: '',
          subject: '',
          message: '',
          category: 'general'
        });
      }
    } catch (error) {
      console.error('Error submitting form:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const contactMethods = [
    {
      icon: Mail,
      title: 'Email Support',
      description: 'Get help from our support team',
      contact: 'admin@retailtradesanner.com',
      response: 'Response within 24-48 hours',
      color: 'emerald'
    }
  ];

  const offices = [];

  const faqs = [
    {
      question: "How do I get started with Stock Scanner Pro?",
      answer: "sign up for free"
    },
    {
      question: "What markets and exchanges do you cover?",
      answer: "nyse"
    },
    {
      question: "Is my financial data secure?",
      answer: "Yes, we use bank-level 256-bit SSL encryption and are SOC 2 compliant. We never store your brokerage credentials and all data is protected with the highest security standards."
    },
    {
      question: "Can I cancel my subscription anytime?",
      answer: "Absolutely. You can cancel your subscription at any time from your account settings. You'll continue to have access until the end of your current billing period."
    }
  ];

  if (submitted) {
    return (
      <Layout>
        <div className="min-h-screen flex items-center justify-center bg-slate-50">
          <Card className="max-w-md mx-auto p-8 text-center">
            <div className="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <CheckCircle className="h-8 w-8 text-emerald-600" />
            </div>
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Message Sent Successfully!</h2>
            <p className="text-slate-600 mb-6">
              Thank you for contacting us. Our team will get back to you within 24 hours.
            </p>
            <Button onClick={() => setSubmitted(false)} className="w-full">
              Send Another Message
            </Button>
          </Card>
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white py-24">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <Badge className="bg-emerald-600/20 text-emerald-300 border-emerald-500/30 mb-8 px-6 py-3">
            <HeadphonesIcon className="h-5 w-5 mr-2" />
            Email Support Available
          </Badge>
          
          <h1 className="text-5xl md:text-6xl font-bold mb-8">
            Get in Touch
            <span className="block bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent mt-2">
              We're Here to Help
            </span>
          </h1>
          
          <p className="text-xl text-slate-200 mb-12 max-w-3xl mx-auto">
            Have questions about our platform? Need technical support? Want to discuss enterprise solutions? 
            Our team of trading experts is ready to assist you.
          </p>
        </div>
      </section>

      {/* Contact Methods */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">
              Multiple Ways to Reach Us
            </h2>
            <p className="text-xl text-slate-600">
              Choose the method that works best for you
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {contactMethods.map((method, index) => {
              const Icon = method.icon;
              const colorClasses = {
                emerald: 'bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white',
                blue: 'bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white',
                purple: 'bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white',
                orange: 'bg-orange-100 text-orange-600 group-hover:bg-orange-600 group-hover:text-white'
              };
              
              return (
                <Card key={index} className="p-6 text-center hover:shadow-lg transition-all duration-300 group cursor-pointer">
                  <div className={`w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 ${colorClasses[method.color]}`}>
                    <Icon className="h-8 w-8" />
                  </div>
                  <h3 className="text-lg font-bold text-slate-900 mb-2">{method.title}</h3>
                  <p className="text-sm text-slate-600 mb-3">{method.description}</p>
                  <p className="font-semibold text-slate-900 mb-1">{method.contact}</p>
                  <p className="text-xs text-slate-500">{method.response}</p>
                </Card>
              );
            })}
          </div>
        </div>
      </section>

      {/* Contact Form */}
      <section className="py-20 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-1 gap-16">
            {/* Contact Form */}
            <Card className="p-8">
              <h2 className="text-3xl font-bold text-slate-900 mb-8">Send Us a Message</h2>
              
              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-semibold text-slate-700 mb-2">
                      Full Name *
                    </label>
                    <Input
                      name="name"
                      value={formData.name}
                      onChange={handleChange}
                      placeholder="Your full name"
                      required
                      className="w-full"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-semibold text-slate-700 mb-2">
                      Email Address *
                    </label>
                    <Input
                      type="email"
                      name="email"
                      value={formData.email}
                      onChange={handleChange}
                      placeholder="your@email.com"
                      required
                      className="w-full"
                    />
                  </div>
                </div>

                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-2">
                    Company (Optional)
                  </label>
                  <Input
                    name="company"
                    value={formData.company}
                    onChange={handleChange}
                    placeholder="Your company name"
                    className="w-full"
                  />
                </div>

                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-2">
                    Subject Category
                  </label>
                  <select
                    name="category"
                    value={formData.category}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                  >
                    <option value="general">General Inquiry</option>
                    <option value="technical">Technical Support</option>
                    <option value="billing">Billing Question</option>
                    <option value="enterprise">Enterprise Sales</option>
                    <option value="partnership">Partnership</option>
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-2">
                    Subject *
                  </label>
                  <Input
                    name="subject"
                    value={formData.subject}
                    onChange={handleChange}
                    placeholder="Brief description of your inquiry"
                    required
                    className="w-full"
                  />
                </div>

                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-2">
                    Message *
                  </label>
                  <Textarea
                    name="message"
                    value={formData.message}
                    onChange={handleChange}
                    placeholder="Please provide detailed information about your inquiry..."
                    required
                    rows={6}
                    className="w-full"
                  />
                </div>

                <Button
                  type="submit"
                  disabled={loading}
                  className="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 text-lg font-semibold"
                >
                  {loading ? 'Sending...' : 'Send Message'}
                  <Send className="ml-2 h-5 w-5" />
                </Button>
              </form>
            </Card>

            
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">
              Frequently Asked Questions
            </h2>
            <p className="text-xl text-slate-600">
              Quick answers to common questions
            </p>
          </div>
          
          <div className="space-y-6">
            {faqs.map((faq, index) => (
              <Card key={index} className="p-6">
                <h3 className="text-lg font-bold text-slate-900 mb-3">{faq.question}</h3>
                <p className="text-slate-600 leading-relaxed">{faq.answer}</p>
              </Card>
            ))}
          </div>

          <div className="text-center mt-12">
            <p className="text-slate-600 mb-4">Still have questions?</p>
            <Button 
              onClick={() => window.location.href = '/help'}
              variant="outline"
              className="border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white"
            >
              Visit Help Center
            </Button>
          </div>
        </div>
      </section>
    </Layout>
  );
};

export default Contact;