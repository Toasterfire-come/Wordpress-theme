import React from "react";
import "./App.css";
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";

// Import services
import { stockAPI, useAsync } from "./services/api";

// Import core pages
import Home from "./pages/Home.jsx";
import PremiumPlans from "./pages/PremiumPlans.jsx";
import ComparePlans from "./pages/ComparePlans.jsx";
import Dashboard from "./pages/Dashboard.jsx";
import MarketOverview from "./pages/MarketOverview.jsx";
import Scanner from "./pages/Scanner.jsx";
import Watchlist from "./pages/Watchlist.jsx";
import Portfolio from "./pages/Portfolio.jsx";
import News from "./pages/News.jsx";
import Account from "./pages/Account.jsx";
import Contact from "./pages/Contact.jsx";
import Login from "./pages/Login.jsx";
import Signup from "./pages/Signup.jsx";
import NotFound from "./pages/NotFound.jsx";

function App() {
  return (
    <BrowserRouter>
      <div className="app-container">
        <Routes>
          {/* Main Application Routes */}
          <Route path="/" element={<Home />} />
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/market-overview" element={<MarketOverview />} />
          <Route path="/scanner" element={<Scanner />} />
          <Route path="/watchlist" element={<Watchlist />} />
          <Route path="/portfolio" element={<Portfolio />} />
          <Route path="/news" element={<News />} />

          {/* Account & Settings */}
          <Route path="/account" element={<Account />} />

          {/* Premium & Billing */}
          <Route path="/premium" element={<PremiumPlans />} />
          <Route path="/plans" element={<PremiumPlans />} />
          <Route path="/compare-plans" element={<ComparePlans />} />

          {/* Authentication */}
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<Signup />} />

          {/* Support */}
          <Route path="/contact" element={<Contact />} />

          {/* Redirects */}
          <Route path="/premium-plans" element={<Navigate to="/premium" replace />} />

          {/* 404 */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </div>
    </BrowserRouter>
  );
}

export default App;