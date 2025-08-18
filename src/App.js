import { useEffect } from "react";
import "./App.css";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Layout from "./components/common/Layout";
import Dashboard from "./pages/Dashboard";
import Scanner from "./pages/Scanner";
import MarketOverview from "./pages/MarketOverview";
import Portfolio from "./pages/Portfolio";
import News from "./pages/News";
import PremiumPlans from "./pages/PremiumPlans";
import Contact from "./pages/Contact";
import Privacy from "./pages/Privacy";
import Terms from "./pages/Terms";
import CookiePolicy from "./pages/CookiePolicy";
import Security from "./pages/Security";
import Status from "./pages/Status";
import Sitemap from "./pages/Sitemap";
import Accessibility from "./pages/Accessibility";
import About from "./pages/About";
import HelpCenter from "./pages/HelpCenter";
import GettingStarted from "./pages/GettingStarted";
import MobileApps from "./pages/MobileApps";
import TechnicalAnalysis from "./pages/TechnicalAnalysis";
import ResearchTools from "./pages/ResearchTools";
import Partners from "./pages/Partners";
import Investors from "./pages/Investors";
import Press from "./pages/Press";
import BillingHistory from "./pages/BillingHistory";
import axios from "axios";

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
const API = `${BACKEND_URL}/api`;

const Home = () => {
  const helloWorldApi = async () => {
    try {
      const response = await axios.get(`${API}/`);
      console.log(response.data.message);
    } catch (e) {
      console.error(e, `errored out requesting / api`);
    }
  };

  useEffect(() => {
    helloWorldApi();
  }, []);

  return (
    <div>
      <header className="App-header">
        <a
          className="App-link"
          href="https://emergent.sh"
          target="_blank"
          rel="noopener noreferrer"
        >
          <img src="https://avatars.githubusercontent.com/in/1201222?s=120&u=2686cf91179bbafbc7a71bfbc43004cf9ae1acea&v=4" />
        </a>
        <p className="mt-5">Building something incredible ~!</p>
      </header>
    </div>
  );
};

function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/scanner" element={<Scanner />} />
          <Route path="/market-overview" element={<MarketOverview />} />
          <Route path="/portfolio" element={<Portfolio />} />
          <Route path="/news" element={<News />} />
          <Route path="/premium" element={<PremiumPlans />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="/privacy" element={<Privacy />} />
          <Route path="/terms" element={<Terms />} />
          <Route path="/cookies" element={<CookiePolicy />} />
          <Route path="/security" element={<Security />} />
          <Route path="/status" element={<Status />} />
          <Route path="/sitemap" element={<Sitemap />} />
          <Route path="/accessibility" element={<Accessibility />} />
          <Route path="/about" element={<About />} />
          <Route path="/help" element={<HelpCenter />} />
          <Route path="/getting-started" element={<GettingStarted />} />
          <Route path="/apps" element={<MobileApps />} />
          <Route path="/features/analysis" element={<TechnicalAnalysis />} />
          <Route path="/features/research" element={<ResearchTools />} />
          <Route path="/partners" element={<Partners />} />
          <Route path="/investors" element={<Investors />} />
          <Route path="/press" element={<Press />} />
          <Route path="/billing-history" element={<BillingHistory />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
