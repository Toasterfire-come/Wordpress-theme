import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { 
  TrendingUp, 
  Search, 
  Bell, 
  Settings, 
  User, 
  Menu,
  X,
  ChevronDown,
  Phone,
  Mail,
  MapPin,
  Facebook,
  Twitter,
  Linkedin,
  Youtube
} from 'lucide-react';

const Header = () => {
  const location = useLocation();
  const [mobileMenuOpen, setMobileMenuOpen] = React.useState(false);
  const [searchQuery, setSearchQuery] = React.useState('');

  const navigation = [
    { name: 'Dashboard', href: '/dashboard', description: 'Your trading overview' },
    { name: 'Markets', href: '/market-overview', description: 'Live market data' },
    { name: 'Scanner', href: '/scanner', description: 'Stock screening tools' },
    { name: 'Watchlist', href: '/watchlist', description: 'Track your stocks' },
    { name: 'Portfolio', href: '/portfolio', description: 'Manage investments' },
    { name: 'News', href: '/news', description: 'Market insights' },
  ];

  const handleSearch = (e) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      window.location.href = `/scanner?q=${encodeURIComponent(searchQuery.trim())}`;
    }
  };

  return (
    <header className="sticky top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        

        {/* Main Header */}
        <div className="flex items-center justify-between h-20">
          {/* Logo */}
          <div className="flex items-center">
            <Link to="/" className="flex items-center space-x-3 group">
              <div className="w-12 h-12 bg-gradient-to-br from-emerald-600 to-blue-600 rounded-xl flex items-center justify-center group-hover:shadow-lg transition-all duration-300">
                <TrendingUp className="h-7 w-7 text-white" />
              </div>
              <div className="hidden sm:block">
                <h1 className="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                  Stock Scanner Pro
                </h1>
                <p className="text-xs text-slate-500 font-medium">Professional Trading Platform</p>
              </div>
            </Link>
          </div>

          {/* Navigation */}
          <nav className="hidden lg:flex items-center space-x-1">
            {navigation.map((item) => (
              <Link
                key={item.name}
                to={item.href}
                className={`px-4 py-3 rounded-lg font-medium text-sm transition-all duration-200 group relative ${
                  location.pathname === item.href
                    ? 'text-emerald-600 bg-emerald-50'
                    : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50'
                }`}
              >
                {item.name}
                <div className="absolute left-0 right-0 bottom-0 h-0.5 bg-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200 origin-left"></div>
              </Link>
            ))}
          </nav>

          {/* Search Bar */}
          <div className="hidden md:block flex-1 max-w-md mx-8">
            <form onSubmit={handleSearch} className="relative">
              <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <Search className="h-5 w-5 text-slate-400" />
              </div>
              <input
                type="text"
                placeholder="Search stocks, symbols, companies..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="block w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-colors duration-200"
              />
            </form>
          </div>

          {/* Right Actions */}
          <div className="flex items-center space-x-3">
            {/* Market Status */}
            <div className="hidden xl:block text-right">
              <p className="text-xs text-slate-500 font-medium">S&P 500</p>
              <div className="flex items-center space-x-2">
                <span className="text-sm font-semibold text-emerald-600">4,789.45</span>
                <span className="text-xs font-medium text-emerald-600">+0.52%</span>
                <span className="px-2 py-0.5 text-xs font-bold bg-red-500 text-white rounded-full animate-pulse">
                  LIVE
                </span>
              </div>
            </div>

            {/* Action Buttons */}
            <button className="p-3 text-slate-600 hover:text-emerald-600 hover:bg-slate-100 rounded-xl relative transition-colors duration-200">
              <Bell className="h-5 w-5" />
              <span className="absolute -top-1 -right-1 h-5 w-5 bg-red-500 rounded-full flex items-center justify-center">
                <span className="text-xs font-bold text-white">3</span>
              </span>
            </button>

            <Link
              to="/settings"
              className="p-3 text-slate-600 hover:text-emerald-600 hover:bg-slate-100 rounded-xl transition-colors duration-200"
            >
              <Settings className="h-5 w-5" />
            </Link>

            <Link
              to="/account"
              className="p-3 text-slate-600 hover:text-emerald-600 hover:bg-slate-100 rounded-xl transition-colors duration-200"
            >
              <User className="h-5 w-5" />
            </Link>

            {/* CTA Button */}
            <Link
              to="/premium"
              className="hidden sm:block bg-gradient-to-r from-emerald-600 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105"
            >
              Upgrade to Pro
            </Link>

            {/* Mobile menu button */}
            <button
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              className="lg:hidden p-3 text-slate-600 hover:text-emerald-600 hover:bg-slate-100 rounded-xl transition-colors duration-200"
            >
              {mobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
            </button>
          </div>
        </div>

        {/* Mobile Navigation */}
        {mobileMenuOpen && (
          <div className="lg:hidden border-t border-slate-200 py-6 bg-white">
            {/* Mobile Search */}
            <div className="px-2 pb-6">
              <form onSubmit={handleSearch} className="relative">
                <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <Search className="h-5 w-5 text-slate-400" />
                </div>
                <input
                  type="text"
                  placeholder="Search stocks..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="block w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                />
              </form>
            </div>
            
            {/* Mobile Navigation Links */}
            <div className="space-y-2 px-2">
              {navigation.map((item) => (
                <Link
                  key={item.name}
                  to={item.href}
                  onClick={() => setMobileMenuOpen(false)}
                  className={`block px-4 py-4 rounded-xl text-base font-medium transition-colors duration-200 ${
                    location.pathname === item.href
                      ? 'bg-emerald-50 text-emerald-600'
                      : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50'
                  }`}
                >
                  <div className="flex flex-col">
                    <span>{item.name}</span>
                    <span className="text-xs text-slate-500 mt-1">{item.description}</span>
                  </div>
                </Link>
              ))}
              
              <Link
                to="/premium"
                onClick={() => setMobileMenuOpen(false)}
                className="block bg-gradient-to-r from-emerald-600 to-blue-600 text-white px-4 py-4 rounded-xl font-semibold text-base text-center mt-4"
              >
                Upgrade to Pro
              </Link>
            </div>
          </div>
        )}
      </div>
    </header>
  );
};

const Footer = () => {
  const currentYear = new Date().getFullYear();

  const footerSections = {
    product: {
      title: 'Platform',
      links: [
        { name: 'Dashboard', href: '/dashboard' },
        { name: 'Stock Scanner', href: '/scanner' },
        { name: 'Market Data', href: '/market-overview' },
        { name: 'Portfolio Tools', href: '/portfolio' },
        { name: 'News & Analysis', href: '/news' },
        { name: 'Mobile Apps', href: '/apps' },
      ]
    },
    features: {
      title: 'Features',
      links: [
        { name: 'Real-time Data', href: '/features/realtime' },
        { name: 'Technical Analysis', href: '/features/analysis' },
        { name: 'Smart Alerts', href: '/features/alerts' },
        { name: 'Portfolio Tracking', href: '/features/portfolio' },
        { name: 'Research Tools', href: '/features/research' },
        { name: 'API Access', href: '/features/api' },
      ]
    },
    company: {
      title: 'Company',
      links: [
        { name: 'About Us', href: '/about' },
        { name: 'Careers', href: '/careers' },
        { name: 'Press Kit', href: '/press' },
        { name: 'Partners', href: '/partners' },
        { name: 'Investors', href: '/investors' },
        { name: 'Blog', href: '/blog' },
      ]
    },
    support: {
      title: 'Support',
      links: [
        { name: 'Help Center', href: '/help' },
        { name: 'Getting Started', href: '/getting-started' },
        { name: 'API Documentation', href: '/docs' },
        { name: 'System Status', href: '/status' },
        { name: 'Contact Support', href: '/contact' },
        { name: 'Community', href: '/community' },
      ]
    },
    legal: {
      title: 'Legal',
      links: [
        { name: 'Privacy Policy', href: '/privacy' },
        { name: 'Terms of Service', href: '/terms' },
        { name: 'Cookie Policy', href: '/cookies' },
        { name: 'Security', href: '/security' },
        { name: 'Compliance', href: '/compliance' },
        { name: 'Data Protection', href: '/data-protection' },
      ]
    },
  };

  return (
    <footer className="bg-slate-900 text-white">
      {/* Newsletter Section */}
      <div className="border-b border-slate-800">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div>
              <h3 className="text-3xl font-bold mb-4">
                Stay Ahead of the Markets
              </h3>
              <p className="text-slate-300 text-lg">
                Get exclusive market insights, trading tips, and platform updates delivered to your inbox weekly.
              </p>
            </div>
            <div className="flex flex-col sm:flex-row gap-4">
              <input
                type="email"
                placeholder="Enter your email address"
                className="flex-1 px-6 py-4 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
              />
              <button className="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl font-semibold transition-colors duration-200 whitespace-nowrap">
                Subscribe Free
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Main Footer Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">
          {/* Brand Section */}
          <div className="lg:col-span-2">
            <Link to="/" className="flex items-center space-x-3 mb-6">
              <div className="w-12 h-12 bg-gradient-to-br from-emerald-600 to-blue-600 rounded-xl flex items-center justify-center">
                <TrendingUp className="h-7 w-7 text-white" />
              </div>
              <div>
                <h3 className="text-xl font-bold text-white">Stock Scanner Pro</h3>
                <p className="text-sm text-slate-400">Professional Trading Platform</p>
              </div>
            </Link>
            <p className="text-slate-300 text-sm leading-relaxed mb-6 max-w-md">
              Empowering traders with institutional-grade market data, advanced analytics, and professional tools. 
              Trusted by portfolio managers at leading financial institutions worldwide.
            </p>
            
            {/* Social Links */}
            <div className="flex space-x-4">
              {[
                { icon: Twitter, href: 'https://twitter.com/stockscannerpro', label: 'Twitter' },
                { icon: Linkedin, href: 'https://linkedin.com/company/stockscannerpro', label: 'LinkedIn' },
                { icon: Facebook, href: 'https://facebook.com/stockscannerpro', label: 'Facebook' },
                { icon: Youtube, href: 'https://youtube.com/stockscannerpro', label: 'YouTube' },
              ].map((social) => {
                const Icon = social.icon;
                return (
                  <a
                    key={social.label}
                    href={social.href}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="w-10 h-10 bg-slate-800 hover:bg-slate-700 rounded-lg flex items-center justify-center transition-colors duration-200"
                    aria-label={social.label}
                  >
                    <Icon className="h-5 w-5 text-slate-400 hover:text-white" />
                  </a>
                );
              })}
            </div>
          </div>

          {/* Footer Links */}
          {Object.entries(footerSections).map(([key, section]) => (
            <div key={key}>
              <h4 className="text-white font-semibold mb-6 text-sm uppercase tracking-wider">{section.title}</h4>
              <ul className="space-y-3">
                {section.links.map((link) => (
                  <li key={link.name}>
                    <Link
                      to={link.href}
                      className="text-slate-400 hover:text-white text-sm transition-colors duration-200 block py-1"
                    >
                      {link.name}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>

        {/* Bottom Section */}
        <div className="border-t border-slate-800 mt-16 pt-8">
          <div className="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
            <div className="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm text-slate-400">
              <p>© {currentYear} Stock Scanner Pro. All rights reserved.</p>
              <div className="flex items-center space-x-4">
                <Link to="/sitemap" className="hover:text-white transition-colors duration-200">
                  Sitemap
                </Link>
                <Link to="/accessibility" className="hover:text-white transition-colors duration-200">
                  Accessibility
                </Link>
                <Link to="/cookies" className="hover:text-white transition-colors duration-200">
                  Cookies
                </Link>
              </div>
            </div>
            
            <div className="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm text-slate-400">
              <div className="flex items-center space-x-2">
                <MapPin className="h-4 w-4" />
                <span>New York, NY</span>
              </div>
              <span className="text-xs bg-emerald-600 text-white px-3 py-1 rounded-full">
                SOC 2 Compliant
              </span>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

const Layout = ({ children }) => {
  return (
    <div className="min-h-screen bg-white">
      <Header />
      <main className="pt-0">
        {children}
      </main>
      <Footer />
    </div>
  );
};

export default Layout;