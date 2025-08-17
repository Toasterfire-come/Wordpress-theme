<?php
/**
 * Template for Compare Plans page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 4rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                <?php _e('Compare Plans', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #64748b; max-width: 600px; margin: 0 auto;">
                <?php _e('Choose the perfect plan for your trading needs. From casual investors to professional trading firms.', 'retail-trade-scanner'); ?>
            </p>
        </div>

        <!-- Pricing Toggle -->
        <div style="display: flex; justify-content: center; margin-bottom: 3rem;">
            <div style="background: white; border-radius: 8px; padding: 0.5rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1);">
                <button id="monthly-toggle" class="pricing-toggle active" data-period="monthly" style="padding: 0.75rem 1.5rem; border: none; background: #059669; color: white; border-radius: 6px; cursor: pointer; font-weight: 500; transition: all 0.2s;">
                    <?php _e('Monthly', 'retail-trade-scanner'); ?>
                </button>
                <button id="yearly-toggle" class="pricing-toggle" data-period="yearly" style="padding: 0.75rem 1.5rem; border: none; background: transparent; color: #64748b; border-radius: 6px; cursor: pointer; font-weight: 500; transition: all 0.2s;">
                    <?php _e('Yearly', 'retail-trade-scanner'); ?>
                    <span style="background: #dcfce7; color: #059669; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; margin-left: 0.5rem;">20% OFF</span>
                </button>
            </div>
        </div>

        <!-- Pricing Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 4rem; max-width: 1000px; margin-left: auto; margin-right: auto;">
            
            <!-- Free Plan -->
            <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center; position: relative;">
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">Free</h3>
                <div style="margin-bottom: 2rem;">
                    <div id="free-price" style="font-size: 3rem; font-weight: bold; color: #0f172a;">$0</div>
                    <div style="color: #64748b; font-size: 0.875rem;">forever</div>
                </div>
                <div style="margin-bottom: 2rem; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Basic market data</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">5 watchlist stocks</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Basic charts</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #ef4444;">✗</span>
                        <span style="font-size: 0.875rem; color: #64748b;">Real-time data</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #ef4444;">✗</span>
                        <span style="font-size: 0.875rem; color: #64748b;">Advanced scanner</span>
                    </div>
                </div>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" style="display: inline-block; width: 100%; background: #f1f5f9; color: #374151; padding: 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    <?php _e('Get Started', 'retail-trade-scanner'); ?>
                </a>
            </div>
            
            <!-- Pro Plan -->
            <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 8px 25px -5px rgb(0 0 0 / 0.1); text-align: center; position: relative; transform: scale(1.05); border: 2px solid #059669;">
                <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #059669; color: white; padding: 0.5rem 1.5rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                    <?php _e('Most Popular', 'retail-trade-scanner'); ?>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">Pro</h3>
                <div style="margin-bottom: 2rem;">
                    <div id="pro-price" style="font-size: 3rem; font-weight: bold; color: #0f172a;">$29</div>
                    <div id="pro-period" style="color: #64748b; font-size: 0.875rem;">per month</div>
                </div>
                <div style="margin-bottom: 2rem; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Real-time market data</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Unlimited watchlists</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Advanced scanner</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Portfolio analytics</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Price alerts</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Email support</span>
                    </div>
                </div>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" style="display: inline-block; width: 100%; background: #059669; color: white; padding: 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    <?php _e('Start Free Trial', 'retail-trade-scanner'); ?>
                </a>
            </div>
            
            <!-- Enterprise Plan -->
            <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center; position: relative;">
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">Enterprise</h3>
                <div style="margin-bottom: 2rem;">
                    <div id="enterprise-price" style="font-size: 3rem; font-weight: bold; color: #0f172a;">$99</div>
                    <div id="enterprise-period" style="color: #64748b; font-size: 0.875rem;">per month</div>
                </div>
                <div style="margin-bottom: 2rem; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Everything in Pro</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Level 2 data</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">API access</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Custom indicators</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">Priority support</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="color: #10b981;">✓</span>
                        <span style="font-size: 0.875rem; color: #374151;">White labeling</span>
                    </div>
                </div>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" style="display: inline-block; width: 100%; background: #0f172a; color: white; padding: 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    <?php _e('Contact Sales', 'retail-trade-scanner'); ?>
                </a>
            </div>
            
        </div>

        <!-- Feature Comparison Table -->
        <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 4rem;">
            <h2 style="font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 2rem; color: #0f172a;">
                <?php _e('Detailed Feature Comparison', 'retail-trade-scanner'); ?>
            </h2>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #f1f5f9;">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Feature</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Free</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; background: #f0fdf4;">Pro</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">Enterprise</th>
                        </tr>
                    </thead>
                    <tbody id="feature-table">
                        <!-- Features populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FAQ Section -->
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 2rem; color: #0f172a;">
                <?php _e('Frequently Asked Questions', 'retail-trade-scanner'); ?>
            </h2>
            
            <div id="faq-list">
                <!-- FAQ items populated by JavaScript -->
            </div>
        </div>

    </div>
</main>

<script>
// Compare Plans page JavaScript
let currentPeriod = 'monthly';

const pricing = {
    monthly: {
        free: { price: 0, period: 'forever' },
        pro: { price: 29, period: 'per month' },
        enterprise: { price: 99, period: 'per month' }
    },
    yearly: {
        free: { price: 0, period: 'forever' },
        pro: { price: 23, period: 'per month, billed yearly' },
        enterprise: { price: 79, period: 'per month, billed yearly' }
    }
};

const features = [
    { name: 'Market Data', free: 'Delayed 15min', pro: 'Real-time', enterprise: 'Real-time + Level 2' },
    { name: 'Watchlist Stocks', free: '5', pro: 'Unlimited', enterprise: 'Unlimited' },
    { name: 'Portfolio Tracking', free: '✗', pro: '✓', enterprise: '✓' },
    { name: 'Advanced Scanner', free: '✗', pro: '✓', enterprise: '✓' },
    { name: 'Price Alerts', free: '✗', pro: '✓', enterprise: '✓' },
    { name: 'Technical Indicators', free: 'Basic', pro: 'Advanced', enterprise: 'Custom' },
    { name: 'News & Analysis', free: 'Limited', pro: 'Full Access', enterprise: 'Full Access + API' },
    { name: 'Data Export', free: '✗', pro: 'CSV', enterprise: 'CSV + API' },
    { name: 'Support', free: 'Community', pro: 'Email', enterprise: 'Priority Phone' },
    { name: 'API Access', free: '✗', pro: '✗', enterprise: '✓' },
    { name: 'White Labeling', free: '✗', pro: '✗', enterprise: '✓' },
    { name: 'Custom Integrations', free: '✗', pro: '✗', enterprise: '✓' }
];

const faqs = [
    {
        question: 'Can I switch plans at any time?',
        answer: 'Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately, and billing adjustments are prorated.'
    },
    {
        question: 'Is there a free trial for paid plans?',
        answer: 'Yes, we offer a 14-day free trial for both Pro and Enterprise plans. No credit card required to start.'
    },
    {
        question: 'What payment methods do you accept?',
        answer: 'We accept all major credit cards (Visa, MasterCard, American Express) and PayPal. Enterprise customers can also pay by wire transfer or ACH.'
    },
    {
        question: 'How accurate is your market data?',
        answer: 'Our real-time data comes directly from major exchanges and is updated every few seconds. We maintain 99.9% uptime and data accuracy.'
    },
    {
        question: 'Do you offer refunds?',
        answer: 'Yes, we offer a 30-day money-back guarantee for all paid plans. If you\'re not satisfied, contact support for a full refund.'
    },
    {
        question: 'Can I cancel my subscription anytime?',
        answer: 'Absolutely. You can cancel your subscription at any time from your account settings. You\'ll continue to have access until the end of your billing period.'
    }
];

document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    setupEventListeners();
});

function initializePage() {
    updatePricing();
    displayFeatureTable();
    displayFAQ();
}

function setupEventListeners() {
    // Pricing toggle buttons
    document.querySelectorAll('.pricing-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            switchPricingPeriod(this.dataset.period);
        });
    });
}

function switchPricingPeriod(period) {
    currentPeriod = period;
    
    // Update toggle buttons
    document.querySelectorAll('.pricing-toggle').forEach(btn => {
        if (btn.dataset.period === period) {
            btn.style.background = '#059669';
            btn.style.color = 'white';
        } else {
            btn.style.background = 'transparent';
            btn.style.color = '#64748b';
        }
    });
    
    updatePricing();
}

function updatePricing() {
    const prices = pricing[currentPeriod];
    
    // Update Free plan (always the same)
    document.getElementById('free-price').textContent = `$${prices.free.price}`;
    
    // Update Pro plan
    document.getElementById('pro-price').textContent = `$${prices.pro.price}`;
    document.getElementById('pro-period').textContent = prices.pro.period;
    
    // Update Enterprise plan
    document.getElementById('enterprise-price').textContent = `$${prices.enterprise.price}`;
    document.getElementById('enterprise-period').textContent = prices.enterprise.period;
}

function displayFeatureTable() {
    const container = document.getElementById('feature-table');
    
    container.innerHTML = features.map(feature => `
        <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 1rem; font-weight: 500; color: #374151;">${feature.name}</td>
            <td style="padding: 1rem; text-align: center; color: #64748b; font-size: 0.875rem;">${feature.free}</td>
            <td style="padding: 1rem; text-align: center; background: #f0fdf4; font-weight: 500; color: #059669;">${feature.pro}</td>
            <td style="padding: 1rem; text-align: center; color: #374151; font-weight: 500;">${feature.enterprise}</td>
        </tr>
    `).join('');
}

function displayFAQ() {
    const container = document.getElementById('faq-list');
    
    container.innerHTML = faqs.map((faq, index) => `
        <div style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); overflow: hidden;">
            <button onclick="toggleFAQ(${index})" style="width: 100%; text-align: left; padding: 1.5rem; border: none; background: white; cursor: pointer; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='white'">
                <span>${faq.question}</span>
                <span id="faq-icon-${index}" style="font-size: 1.25rem; transition: transform 0.2s;">+</span>
            </button>
            <div id="faq-answer-${index}" style="display: none; padding: 0 1.5rem 1.5rem; color: #64748b; line-height: 1.6;">
                ${faq.answer}
            </div>
        </div>
    `).join('');
}

function toggleFAQ(index) {
    const answer = document.getElementById(`faq-answer-${index}`);
    const icon = document.getElementById(`faq-icon-${index}`);
    
    if (answer.style.display === 'none') {
        answer.style.display = 'block';
        icon.textContent = '−';
        icon.style.transform = 'rotate(0deg)';
    } else {
        answer.style.display = 'none';
        icon.textContent = '+';
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<?php get_footer(); ?>