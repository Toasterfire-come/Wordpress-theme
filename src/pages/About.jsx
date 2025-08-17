import React from 'react';
import { Users, Award, Globe, Shield, TrendingUp, Zap, Heart, Target } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Badge } from '../components/ui/badge';

const About = () => {
  const stats = [
    { label: 'Active Traders', value: '100,000+', icon: Users },
    { label: 'Countries Served', value: '50+', icon: Globe },
    { label: 'Years of Experience', value: '8+', icon: Award },
    { label: 'System Uptime', value: '99.99%', icon: Shield }
  ];

  const values = [
    {
      icon: Target,
      title: 'Precision',
      description: 'We deliver accurate, real-time market data with institutional-grade precision that professionals demand.',
      color: 'emerald'
    },
    {
      icon: Zap,
      title: 'Innovation', 
      description: 'Continuously pushing the boundaries of trading technology to give our users a competitive edge.',
      color: 'blue'
    },
    {
      icon: Shield,
      title: 'Security',
      description: 'Your data and investments are protected with bank-level security and compliance standards.',
      color: 'purple'
    },
    {
      icon: Heart,
      title: 'Community',
      description: 'Building a community of successful traders through education, support, and shared knowledge.',
      color: 'red'
    }
  ];

  const team = [
    {
      name: 'Sarah Chen',
      role: 'Chief Executive Officer',
      background: 'Former Goldman Sachs VP, 15 years Wall Street experience',
      avatar: 'SC'
    },
    {
      name: 'Michael Rodriguez', 
      role: 'Chief Technology Officer',
      background: 'Ex-Google Senior Engineer, specialized in real-time systems',
      avatar: 'MR'
    },
    {
      name: 'David Kim',
      role: 'Head of Product',
      background: 'Former BlackRock Portfolio Manager, 12 years institutional trading',
      avatar: 'DK'
    },
    {
      name: 'Jennifer Walsh',
      role: 'Head of Data Science',
      background: 'PhD in Quantitative Finance, former Renaissance Technologies',
      avatar: 'JW'
    }
  ];

  const timeline = [
    {
      year: '2016',
      title: 'Company Founded',
      description: 'Started with a mission to democratize institutional-grade trading tools for individual traders.'
    },
    {
      year: '2018', 
      title: 'Real-Time Data Integration',
      description: 'Launched our real-time market data platform, serving over 1,000 professional traders.'
    },
    {
      year: '2020',
      title: 'Global Expansion',
      description: 'Expanded to serve 25 international markets and reached 50,000 active users worldwide.'
    },
    {
      year: '2022',
      title: 'Enterprise Platform',
      description: 'Launched enterprise solutions for institutional clients including hedge funds and asset managers.'
    },
    {
      year: '2024',
      title: 'AI Integration',
      description: 'Introduced AI-powered market analysis and predictive analytics for all users.'
    }
  ];

  return (
    <Layout>
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white py-24">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <Badge className="bg-emerald-600/20 text-emerald-300 border-emerald-500/30 mb-8 px-6 py-3">
              <Award className="h-5 w-5 mr-2" />
              Industry Leaders Since 2016
            </Badge>
            
            <h1 className="text-5xl md:text-6xl font-bold mb-8">
              Empowering Traders
              <span className="block bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent mt-2">
                Around the World
              </span>
            </h1>
            
            <p className="text-xl text-slate-200 mb-12 max-w-4xl mx-auto leading-relaxed">
              We're on a mission to democratize institutional-grade trading tools, making professional market analysis 
              accessible to traders at every level. From Wall Street veterans to aspiring day traders, 
              we provide the technology that levels the playing field.
            </p>
          </div>

          {/* Stats */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16">
            {stats.map((stat, index) => {
              const Icon = stat.icon;
              return (
                <div key={index} className="text-center">
                  <div className="w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <Icon className="h-8 w-8 text-emerald-400" />
                  </div>
                  <div className="text-3xl font-bold text-white mb-2">{stat.value}</div>
                  <div className="text-slate-300">{stat.label}</div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* Mission Section */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
              <h2 className="text-4xl font-bold text-slate-900 mb-8">
                Our Mission: Leveling the Trading Field
              </h2>
              <p className="text-xl text-slate-600 mb-8 leading-relaxed">
                For too long, institutional-grade trading tools have been exclusive to Wall Street firms and hedge funds. 
                We believe every trader deserves access to the same quality of market data, analytics, and technology 
                that drive professional trading decisions.
              </p>
              <p className="text-lg text-slate-600 mb-8 leading-relaxed">
                Founded by former Goldman Sachs and BlackRock executives, we've built the platform we wished we had 
                during our years on Wall Street – powerful, intuitive, and accessible to traders everywhere.
              </p>
              <div className="flex items-center space-x-4">
                <Badge className="bg-emerald-100 text-emerald-700 px-4 py-2">SOC 2 Certified</Badge>
                <Badge className="bg-blue-100 text-blue-700 px-4 py-2">ISO 27001</Badge>
                <Badge className="bg-purple-100 text-purple-700 px-4 py-2">PCI Compliant</Badge>
              </div>
            </div>
            <div className="relative">
              <div className="bg-gradient-to-br from-emerald-500 to-blue-600 rounded-2xl p-8 text-white">
                <TrendingUp className="h-16 w-16 mb-6" />
                <h3 className="text-2xl font-bold mb-4">Professional Tools for Everyone</h3>
                <p className="text-emerald-100 leading-relaxed">
                  We've served over 100,000 traders across 50 countries, from individual day traders to 
                  portfolio managers at Fortune 500 companies. Our platform processes over 10 billion 
                  data points daily to keep you ahead of the markets.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Values Section */}
      <section className="py-24 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <h2 className="text-4xl font-bold text-slate-900 mb-6">
              Our Core Values
            </h2>
            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
              These principles guide everything we do, from product development to customer support
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {values.map((value, index) => {
              const Icon = value.icon;
              const colorClasses = {
                emerald: 'bg-emerald-100 text-emerald-600',
                blue: 'bg-blue-100 text-blue-600',
                purple: 'bg-purple-100 text-purple-600',
                red: 'bg-red-100 text-red-600'
              };
              
              return (
                <Card key={index} className="p-8 hover:shadow-lg transition-all duration-300">
                  <div className={`w-16 h-16 rounded-2xl flex items-center justify-center mb-6 ${colorClasses[value.color]}`}>
                    <Icon className="h-8 w-8" />
                  </div>
                  <h3 className="text-2xl font-bold text-slate-900 mb-4">{value.title}</h3>
                  <p className="text-slate-600 leading-relaxed">{value.description}</p>
                </Card>
              );
            })}
          </div>
        </div>
      </section>

      {/* Team Section */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <h2 className="text-4xl font-bold text-slate-900 mb-6">
              Leadership Team
            </h2>
            <p className="text-xl text-slate-600">
              Industry veterans from Goldman Sachs, BlackRock, Google, and Renaissance Technologies
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {team.map((member, index) => (
              <Card key={index} className="p-6 text-center hover:shadow-lg transition-all duration-300">
                <div className="w-20 h-20 bg-gradient-to-br from-emerald-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                  <span className="text-white font-bold text-2xl">{member.avatar}</span>
                </div>
                <h3 className="text-xl font-bold text-slate-900 mb-2">{member.name}</h3>
                <p className="text-emerald-600 font-semibold mb-3">{member.role}</p>
                <p className="text-sm text-slate-600 leading-relaxed">{member.background}</p>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Timeline Section */}
      <section className="py-24 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <h2 className="text-4xl font-bold text-slate-900 mb-6">
              Our Journey
            </h2>
            <p className="text-xl text-slate-600">
              From startup to industry leader - key milestones in our growth
            </p>
          </div>
          
          <div className="space-y-8">
            {timeline.map((item, index) => (
              <div key={index} className="flex items-start space-x-6">
                <div className="flex-shrink-0 w-24 text-right">
                  <Badge className="bg-emerald-100 text-emerald-700 px-3 py-1 text-lg font-bold">
                    {item.year}
                  </Badge>
                </div>
                <div className="flex-shrink-0 w-4 h-4 bg-emerald-600 rounded-full mt-2"></div>
                <div className="flex-1">
                  <h3 className="text-xl font-bold text-slate-900 mb-2">{item.title}</h3>
                  <p className="text-slate-600 leading-relaxed">{item.description}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-24 bg-gradient-to-r from-slate-900 to-blue-900 text-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-4xl font-bold mb-6">
            Join Our Mission
          </h2>
          <p className="text-xl text-slate-200 mb-8">
            Be part of the community that's democratizing professional trading tools for everyone
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <button 
              className="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-200"
              onClick={() => window.location.href = '/signup'}
            >
              Start Trading Today
            </button>
            <button 
              className="border-2 border-white/30 text-white hover:bg-white hover:text-slate-900 px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-200"
              onClick={() => window.location.href = '/careers'}
            >
              Join Our Team
            </button>
          </div>
        </div>
      </section>
    </Layout>
  );
};

export default About;