import React, { useState, useEffect } from 'react';
import { User, Mail, Phone, Shield, CreditCard, Bell, Save, Edit2 } from 'lucide-react';
import Layout from '../components/common/Layout';
import PageHeader from '../components/common/PageHeader';
import { LoadingState } from '../components/common/LoadingState';
import ErrorState from '../components/common/ErrorState';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';
import { Input } from '../components/ui/input';
import { Label } from '../components/ui/label';
import { Textarea } from '../components/ui/textarea';
import { Avatar, AvatarFallback } from '../components/ui/avatar';
import { Badge } from '../components/ui/badge';
import { stockAPI } from '../services/api';

const Account = () => {
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [saving, setSaving] = useState(false);
  const [activeTab, setActiveTab] = useState('profile');
  
  const [profileData, setProfileData] = useState({
    firstName: 'John',
    lastName: 'Doe',
    email: 'john.doe@example.com',
    phone: '+1 (555) 123-4567',
    company: 'Investment Corp',
    bio: 'Professional trader with 10+ years of experience in equity markets.',
    joinDate: '2023-01-15',
    accountType: 'Premium',
    status: 'Active'
  });

  const [notifications, setNotifications] = useState({
    emailNotifications: true,
    priceAlerts: true,
    newsUpdates: true,
    portfolioUpdates: true,
    marketHours: false,
    weeklyReports: true
  });

  const [securitySettings, setSecuritySettings] = useState({
    twoFactorEnabled: false,
    lastPasswordChange: '2024-01-15',
    loginNotifications: true
  });

  useEffect(() => {
    loadAccountData();
  }, []);

  const loadAccountData = async () => {
    setLoading(true);
    setError(null);
    
    try {
      // In a real app, this would load actual user data
      // For now, we'll simulate loading with existing mock data
      setTimeout(() => {
        setLoading(false);
      }, 1000);
    } catch (err) {
      setError(err.message);
      setLoading(false);
    }
  };

  const handleSaveProfile = async () => {
    setSaving(true);
    try {
      const response = await stockAPI.updateUserAccount(profileData);
      if (response.success) {
        // Show success message
        console.log('Profile updated successfully');
      }
    } catch (error) {
      console.error('Error updating profile:', error);
    } finally {
      setSaving(false);
    }
  };

  const handleUpdateNotifications = async () => {
    setSaving(true);
    try {
      const response = await stockAPI.updateUserSettings({ notifications });
      if (response.success) {
        console.log('Notifications updated successfully');
      }
    } catch (error) {
      console.error('Error updating notifications:', error);
    } finally {
      setSaving(false);
    }
  };

  const tabs = [
    { id: 'profile', label: 'Profile', icon: User },
    { id: 'notifications', label: 'Notifications', icon: Bell },
    { id: 'security', label: 'Security', icon: Shield },
    { id: 'billing', label: 'Billing', icon: CreditCard }
  ];

  if (loading) {
    return (
      <Layout>
        <PageHeader
          title="My Account"
          subtitle="Manage your profile and account settings"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <LoadingState message="Loading account information..." />
        </div>
      </Layout>
    );
  }

  if (error) {
    return (
      <Layout>
        <PageHeader
          title="My Account"
          subtitle="Manage your profile and account settings"
        />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <ErrorState 
            title="Failed to load account"
            message={error}
            onRetry={loadAccountData}
          />
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      <PageHeader
        title="My Account"
        subtitle="Manage your profile and account settings"
      />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="flex flex-col lg:flex-row gap-8">
          {/* Sidebar */}
          <div className="lg:w-64">
            <Card className="p-6 mb-6">
              <div className="text-center">
                <Avatar className="h-20 w-20 mx-auto mb-4">
                  <AvatarFallback className="text-lg">
                    {profileData.firstName[0]}{profileData.lastName[0]}
                  </AvatarFallback>
                </Avatar>
                <h3 className="text-lg font-semibold text-slate-900">
                  {profileData.firstName} {profileData.lastName}
                </h3>
                <p className="text-slate-600">{profileData.email}</p>
                <Badge variant="outline" className="mt-2">
                  {profileData.accountType}
                </Badge>
              </div>
            </Card>

            <nav className="space-y-2">
              {tabs.map((tab) => {
                const Icon = tab.icon;
                return (
                  <button
                    key={tab.id}
                    onClick={() => setActiveTab(tab.id)}
                    className={`w-full flex items-center px-4 py-3 text-left rounded-lg transition-colors ${
                      activeTab === tab.id
                        ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                    }`}
                  >
                    <Icon className="h-5 w-5 mr-3" />
                    {tab.label}
                  </button>
                );
              })}
            </nav>
          </div>

          {/* Main Content */}
          <div className="flex-1">
            {activeTab === 'profile' && (
              <Card className="p-6">
                <div className="flex items-center justify-between mb-6">
                  <h2 className="text-xl font-semibold text-slate-900">Profile Information</h2>
                  <Button
                    onClick={handleSaveProfile}
                    loading={saving}
                    className="flex items-center"
                  >
                    <Save className="h-4 w-4 mr-2" />
                    Save Changes
                  </Button>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <Label htmlFor="firstName">First Name</Label>
                    <Input
                      id="firstName"
                      value={profileData.firstName}
                      onChange={(e) => setProfileData({...profileData, firstName: e.target.value})}
                    />
                  </div>
                  <div>
                    <Label htmlFor="lastName">Last Name</Label>
                    <Input
                      id="lastName"
                      value={profileData.lastName}
                      onChange={(e) => setProfileData({...profileData, lastName: e.target.value})}
                    />
                  </div>
                  <div>
                    <Label htmlFor="email">Email Address</Label>
                    <Input
                      id="email"
                      type="email"
                      value={profileData.email}
                      onChange={(e) => setProfileData({...profileData, email: e.target.value})}
                    />
                  </div>
                  <div>
                    <Label htmlFor="phone">Phone Number</Label>
                    <Input
                      id="phone"
                      value={profileData.phone}
                      onChange={(e) => setProfileData({...profileData, phone: e.target.value})}
                    />
                  </div>
                  <div className="md:col-span-2">
                    <Label htmlFor="company">Company</Label>
                    <Input
                      id="company"
                      value={profileData.company}
                      onChange={(e) => setProfileData({...profileData, company: e.target.value})}
                    />
                  </div>
                  <div className="md:col-span-2">
                    <Label htmlFor="bio">Bio</Label>
                    <Textarea
                      id="bio"
                      value={profileData.bio}
                      onChange={(e) => setProfileData({...profileData, bio: e.target.value})}
                      rows={4}
                    />
                  </div>
                </div>

                <div className="border-t border-slate-200 pt-6 mt-6">
                  <h3 className="text-lg font-semibold text-slate-900 mb-4">Account Details</h3>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <Label>Member Since</Label>
                      <p className="text-slate-900">{new Date(profileData.joinDate).toLocaleDateString()}</p>
                    </div>
                    <div>
                      <Label>Account Status</Label>
                      <Badge variant="success" className="mt-1">
                        {profileData.status}
                      </Badge>
                    </div>
                  </div>
                </div>
              </Card>
            )}

            {activeTab === 'notifications' && (
              <Card className="p-6">
                <div className="flex items-center justify-between mb-6">
                  <h2 className="text-xl font-semibold text-slate-900">Notification Preferences</h2>
                  <Button
                    onClick={handleUpdateNotifications}
                    loading={saving}
                    className="flex items-center"
                  >
                    <Save className="h-4 w-4 mr-2" />
                    Save Settings
                  </Button>
                </div>

                <div className="space-y-6">
                  {Object.entries(notifications).map(([key, value]) => (
                    <div key={key} className="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                      <div>
                        <h3 className="font-medium text-slate-900">
                          {key.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase())}
                        </h3>
                        <p className="text-slate-600 text-sm">
                          {getNotificationDescription(key)}
                        </p>
                      </div>
                      <label className="relative inline-flex items-center cursor-pointer">
                        <input
                          type="checkbox"
                          checked={value}
                          onChange={(e) => setNotifications({...notifications, [key]: e.target.checked})}
                          className="sr-only peer"
                        />
                        <div className="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                      </label>
                    </div>
                  ))}
                </div>
              </Card>
            )}

            {activeTab === 'security' && (
              <Card className="p-6">
                <h2 className="text-xl font-semibold text-slate-900 mb-6">Security Settings</h2>
                
                <div className="space-y-6">
                  <div className="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">Two-Factor Authentication</h3>
                      <p className="text-slate-600 text-sm">
                        Add an extra layer of security to your account
                      </p>
                    </div>
                    <Button variant={securitySettings.twoFactorEnabled ? "outline" : "default"}>
                      {securitySettings.twoFactorEnabled ? "Disable" : "Enable"}
                    </Button>
                  </div>

                  <div className="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">Password</h3>
                      <p className="text-slate-600 text-sm">
                        Last changed on {new Date(securitySettings.lastPasswordChange).toLocaleDateString()}
                      </p>
                    </div>
                    <Button variant="outline">
                      Change Password
                    </Button>
                  </div>

                  <div className="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">Login Notifications</h3>
                      <p className="text-slate-600 text-sm">
                        Get notified when someone logs into your account
                      </p>
                    </div>
                    <label className="relative inline-flex items-center cursor-pointer">
                      <input
                        type="checkbox"
                        checked={securitySettings.loginNotifications}
                        onChange={(e) => setSecuritySettings({
                          ...securitySettings, 
                          loginNotifications: e.target.checked
                        })}
                        className="sr-only peer"
                      />
                      <div className="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                  </div>
                </div>
              </Card>
            )}

            {activeTab === 'billing' && (
              <Card className="p-6">
                <h2 className="text-xl font-semibold text-slate-900 mb-6">Billing & Subscription</h2>
                
                <div className="space-y-6">
                  <div className="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div>
                      <h3 className="font-medium text-blue-900">Current Plan: Premium</h3>
                      <p className="text-blue-700 text-sm">
                        Next billing date: March 15, 2024
                      </p>
                    </div>
                    <Button variant="outline">
                      Manage Plan
                    </Button>
                  </div>

                  <div className="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">Payment Method</h3>
                      <p className="text-slate-600 text-sm">
                        •••• •••• •••• 4567 (Expires 12/25)
                      </p>
                    </div>
                    <Button variant="outline">
                      Update Payment
                    </Button>
                  </div>

                  <div className="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                    <div>
                      <h3 className="font-medium text-slate-900">Billing History</h3>
                      <p className="text-slate-600 text-sm">
                        View and download your invoices
                      </p>
                    </div>
                    <Button variant="outline" onClick={() => window.location.href = '/billing-history'}>
                      View History
                    </Button>
                  </div>
                </div>
              </Card>
            )}
          </div>
        </div>
      </div>
    </Layout>
  );
};

const getNotificationDescription = (key) => {
  const descriptions = {
    emailNotifications: "Receive important updates via email",
    priceAlerts: "Get notified when stock prices hit your targets", 
    newsUpdates: "Stay informed with relevant market news",
    portfolioUpdates: "Receive updates about your portfolio performance",
    marketHours: "Get notifications about market open/close",
    weeklyReports: "Receive weekly performance summaries"
  };
  return descriptions[key] || "Configure this notification setting";
};

export default Account;