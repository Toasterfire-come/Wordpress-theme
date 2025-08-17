<?php
/**
 * Template for Market News page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">
                <?php _e('Market News', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #64748b;">
                <?php _e('Latest market news with sentiment analysis and personalized feeds', 'retail-trade-scanner'); ?>
            </p>
        </div>

        <!-- News Filters -->
        <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="news-category active" data-category="all" style="padding: 0.5rem 1rem; border: 1px solid #059669; background: #059669; color: white; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            <?php _e('All News', 'retail-trade-scanner'); ?>
                        </button>
                        <button class="news-category" data-category="breaking" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            <?php _e('Breaking', 'retail-trade-scanner'); ?>
                        </button>
                        <button class="news-category" data-category="earnings" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            <?php _e('Earnings', 'retail-trade-scanner'); ?>
                        </button>
                        <button class="news-category" data-category="fed" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            <?php _e('Fed News', 'retail-trade-scanner'); ?>
                        </button>
                        <button class="news-category" data-category="crypto" style="padding: 0.5rem 1rem; border: 1px solid #e2e8f0; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                            <?php _e('Crypto', 'retail-trade-scanner'); ?>
                        </button>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <label style="font-size: 0.875rem; font-weight: 500; color: #374151;">Sentiment:</label>
                        <select id="sentiment-filter" style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white; font-size: 0.875rem;">
                            <option value="all">All</option>
                            <option value="positive">Positive</option>
                            <option value="neutral">Neutral</option>
                            <option value="negative">Negative</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button id="refresh-news" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                        🔄 <?php _e('Refresh', 'retail-trade-scanner'); ?>
                    </button>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></div>
                        <span style="font-size: 0.875rem; color: #059669; font-weight: 500;">Live Feed</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Layout -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            
            <!-- Main News Feed -->
            <div>
                <!-- Featured News -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <span style="background: #dc2626; color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">BREAKING</span>
                        <span style="font-size: 0.875rem; color: #64748b;">2 minutes ago</span>
                    </div>
                    <h2 style="font-size: 1.5rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem; line-height: 1.4;">
                        Federal Reserve Signals Potential Rate Cut as Inflation Shows Signs of Cooling
                    </h2>
                    <p style="color: #64748b; line-height: 1.6; margin-bottom: 1.5rem;">
                        The Federal Reserve indicated today that it may consider cutting interest rates in the coming months as new data shows inflation continuing to moderate. This development has sent markets higher across all major indices...
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="background: #dcfce7; color: #059669; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">📈 Bullish</span>
                                <span style="font-size: 0.875rem; color: #64748b;">85% confidence</span>
                            </div>
                            <div style="font-size: 0.875rem; color: #64748b;">
                                Source: Reuters
                            </div>
                        </div>
                        <button style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                            <?php _e('Read More', 'retail-trade-scanner'); ?>
                        </button>
                    </div>
                </div>

                <!-- News List -->
                <div id="news-list">
                    <!-- News items populated by JavaScript -->
                </div>

                <!-- Load More -->
                <div style="text-align: center; margin-top: 2rem;">
                    <button id="load-more-news" style="background: white; border: 1px solid #e2e8f0; color: #374151; padding: 1rem 2rem; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        <?php _e('Load More News', 'retail-trade-scanner'); ?>
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                
                <!-- Market Sentiment -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">
                        <?php _e('Market Sentiment', 'retail-trade-scanner'); ?>
                    </h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.875rem; color: #64748b;">Overall Sentiment</span>
                            <span style="font-size: 0.875rem; font-weight: 500; color: #059669;">Bullish</span>
                        </div>
                        <div style="background: #f1f5f9; border-radius: 4px; height: 8px; overflow: hidden;">
                            <div style="background: #10b981; height: 100%; width: 68%; transition: width 0.3s;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">
                            <span>Bearish</span>
                            <span>68% Bullish</span>
                        </div>
                    </div>
                    
                    <div id="sentiment-breakdown">
                        <!-- Sentiment data populated by JavaScript -->
                    </div>
                </div>

                <!-- Trending Topics -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">
                        <?php _e('Trending Topics', 'retail-trade-scanner'); ?>
                    </h3>
                    
                    <div id="trending-topics">
                        <!-- Trending topics populated by JavaScript -->
                    </div>
                </div>

                <!-- Economic Calendar -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">
                        <?php _e('Economic Calendar', 'retail-trade-scanner'); ?>
                    </h3>
                    
                    <div id="economic-events">
                        <!-- Economic events populated by JavaScript -->
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

<script>
// Market News page JavaScript
let currentCategory = 'all';
let currentSentiment = 'all';

const newsData = [
    {
        id: 1,
        title: 'Tech Giants Report Strong Q4 Earnings Despite Economic Headwinds',
        summary: 'Apple, Microsoft, and Google all exceeded analyst expectations with robust quarterly results, signaling resilience in the technology sector.',
        source: 'Bloomberg',
        time: '15 minutes ago',
        sentiment: 'positive',
        confidence: 78,
        category: 'earnings',
        tickers: ['AAPL', 'MSFT', 'GOOGL']
    },
    {
        id: 2,
        title: 'Oil Prices Surge on Middle East Tensions and Supply Concerns',
        summary: 'Crude oil futures jumped 3.2% today as geopolitical tensions in the Middle East raise concerns about potential supply disruptions.',
        source: 'CNBC',
        time: '32 minutes ago',
        sentiment: 'negative',
        confidence: 82,
        category: 'breaking',
        tickers: ['XOM', 'CVX', 'COP']
    },
    {
        id: 3,
        title: 'Bitcoin Breaks Above $45,000 as Institutional Adoption Accelerates',
        summary: 'The leading cryptocurrency reached a new multi-month high as major financial institutions announce expanded crypto services.',
        source: 'CoinDesk',
        time: '1 hour ago',
        sentiment: 'positive',
        confidence: 85,
        category: 'crypto',
        tickers: ['BTC', 'ETH']
    },
    {
        id: 4,
        title: 'Manufacturing Data Shows Continued Contraction in Industrial Sector',
        summary: 'The latest PMI data indicates ongoing weakness in manufacturing, with new orders and production both declining for the third consecutive month.',
        source: 'MarketWatch',
        time: '2 hours ago',
        sentiment: 'negative',
        confidence: 71,
        category: 'fed',
        tickers: ['SPY', 'IWM']
    },
    {
        id: 5,
        title: 'Biotech Stocks Rally on FDA Approval of Breakthrough Cancer Treatment',
        summary: 'Shares of biotechnology companies surged after the FDA approved a revolutionary new cancer therapy, sparking optimism across the sector.',
        source: 'Reuters',
        time: '3 hours ago',
        sentiment: 'positive',
        confidence: 89,
        category: 'breaking',
        tickers: ['BIIB', 'GILD', 'AMGN']
    }
];

const trendingTopics = [
    { topic: 'Federal Reserve Policy', mentions: 1247, trend: 'up' },
    { topic: 'AI & Machine Learning', mentions: 892, trend: 'up' },
    { topic: 'Electric Vehicles', mentions: 756, trend: 'down' },
    { topic: 'Cryptocurrency', mentions: 634, trend: 'up' },
    { topic: 'Climate Change', mentions: 523, trend: 'neutral' },
    { topic: 'Supply Chain', mentions: 445, trend: 'down' }
];

const economicEvents = [
    { event: 'FOMC Meeting Minutes', time: 'Today 2:00 PM', impact: 'high' },
    { event: 'Initial Jobless Claims', time: 'Tomorrow 8:30 AM', impact: 'medium' },
    { event: 'Consumer Price Index', time: 'Wed 8:30 AM', impact: 'high' },
    { event: 'Retail Sales', time: 'Thu 8:30 AM', impact: 'medium' },
    { event: 'Producer Price Index', time: 'Fri 8:30 AM', impact: 'low' }
];

document.addEventListener('DOMContentLoaded', function() {
    initializeNews();
    setupEventListeners();
    displaySentimentBreakdown();
    displayTrendingTopics();
    displayEconomicEvents();
});

function initializeNews() {
    displayNewsList();
}

function setupEventListeners() {
    // Category buttons
    document.querySelectorAll('.news-category').forEach(btn => {
        btn.addEventListener('click', function() {
            switchCategory(this.dataset.category);
        });
    });
    
    // Sentiment filter
    document.getElementById('sentiment-filter').addEventListener('change', function() {
        currentSentiment = this.value;
        displayNewsList();
    });
    
    // Refresh button
    document.getElementById('refresh-news').addEventListener('click', refreshNews);
    
    // Load more button
    document.getElementById('load-more-news').addEventListener('click', loadMoreNews);
}

function switchCategory(category) {
    currentCategory = category;
    
    // Update button styles
    document.querySelectorAll('.news-category').forEach(btn => {
        btn.style.background = 'white';
        btn.style.color = '#64748b';
        btn.style.borderColor = '#e2e8f0';
    });
    
    const activeBtn = document.querySelector(`[data-category="${category}"]`);
    activeBtn.style.background = '#059669';
    activeBtn.style.color = 'white';
    activeBtn.style.borderColor = '#059669';
    
    displayNewsList();
}

function displayNewsList() {
    const container = document.getElementById('news-list');
    let filteredNews = newsData;
    
    // Filter by category
    if (currentCategory !== 'all') {
        filteredNews = filteredNews.filter(news => news.category === currentCategory);
    }
    
    // Filter by sentiment
    if (currentSentiment !== 'all') {
        filteredNews = filteredNews.filter(news => news.sentiment === currentSentiment);
    }
    
    container.innerHTML = filteredNews.map(news => `
        <article style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); margin-bottom: 1.5rem; transition: transform 0.2s; cursor: pointer;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
            
            <!-- Article Header -->
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="background: ${getSentimentColor(news.sentiment)}; color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                        ${getSentimentIcon(news.sentiment)} ${news.sentiment.toUpperCase()}
                    </span>
                    <span style="font-size: 0.875rem; color: #64748b;">${news.time}</span>
                </div>
                <button style="background: none; border: none; color: #64748b; cursor: pointer; font-size: 1.25rem;" title="Save article">⭐</button>
            </div>
            
            <!-- Article Title -->
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem; line-height: 1.4;">
                ${news.title}
            </h3>
            
            <!-- Article Summary -->
            <p style="color: #64748b; line-height: 1.6; margin-bottom: 1.5rem;">
                ${news.summary}
            </p>
            
            <!-- Article Footer -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span style="font-size: 0.875rem; color: #64748b;">
                        Source: ${news.source}
                    </span>
                    <div style="display: flex; gap: 0.5rem;">
                        ${news.tickers.map(ticker => `
                            <span style="background: #f1f5f9; color: #374151; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                ${ticker}
                            </span>
                        `).join('')}
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span style="font-size: 0.875rem; color: #64748b;">
                        ${news.confidence}% confidence
                    </span>
                    <button style="background: #f8fafc; border: 1px solid #e2e8f0; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                        Read More
                    </button>
                </div>
            </div>
        </article>
    `).join('');
    
    if (filteredNews.length === 0) {
        container.innerHTML = `
            <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1);">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📰</div>
                <h3 style="margin-bottom: 0.5rem; color: #0f172a;">No news found</h3>
                <p style="color: #64748b;">Try adjusting your filters to see more results.</p>
            </div>
        `;
    }
}

function displaySentimentBreakdown() {
    const container = document.getElementById('sentiment-breakdown');
    
    const sentimentData = [
        { label: 'Positive News', count: 156, color: '#10b981' },
        { label: 'Neutral News', count: 89, color: '#64748b' },
        { label: 'Negative News', count: 73, color: '#ef4444' }
    ];
    
    container.innerHTML = sentimentData.map(item => `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 12px; height: 12px; background: ${item.color}; border-radius: 2px;"></div>
                <span style="font-size: 0.875rem; color: #374151;">${item.label}</span>
            </div>
            <span style="font-size: 0.875rem; font-weight: 500; color: #0f172a;">${item.count}</span>
        </div>
    `).join('');
}

function displayTrendingTopics() {
    const container = document.getElementById('trending-topics');
    
    container.innerHTML = trendingTopics.map(topic => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; cursor: pointer; transition: background-color 0.2s;" onmouseenter="this.style.backgroundColor='#f8fafc'" onmouseleave="this.style.backgroundColor='transparent'">
            <div>
                <div style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">${topic.topic}</div>
                <div style="font-size: 0.875rem; color: #64748b;">${topic.mentions.toLocaleString()} mentions</div>
            </div>
            <div style="font-size: 1.25rem;">
                ${topic.trend === 'up' ? '📈' : topic.trend === 'down' ? '📉' : '➡️'}
            </div>
        </div>
    `).join('');
}

function displayEconomicEvents() {
    const container = document.getElementById('economic-events');
    
    const impactColors = {
        high: '#dc2626',
        medium: '#f59e0b',
        low: '#64748b'
    };
    
    container.innerHTML = economicEvents.map(event => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
            <div>
                <div style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">${event.event}</div>
                <div style="font-size: 0.875rem; color: #64748b;">${event.time}</div>
            </div>
            <span style="background: ${impactColors[event.impact]}; color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">
                ${event.impact}
            </span>
        </div>
    `).join('');
}

function getSentimentColor(sentiment) {
    switch (sentiment) {
        case 'positive': return '#10b981';
        case 'negative': return '#ef4444';
        default: return '#64748b';
    }
}

function getSentimentIcon(sentiment) {
    switch (sentiment) {
        case 'positive': return '📈';
        case 'negative': return '📉';
        default: return '➡️';
    }
}

function refreshNews() {
    // Mock refresh functionality
    const btn = document.getElementById('refresh-news');
    btn.innerHTML = '🔄 Refreshing...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = '🔄 Refresh';
        btn.disabled = false;
        displayNewsList();
    }, 1000);
}

function loadMoreNews() {
    // Mock load more functionality
    alert('Loading more news...');
}

// Add pulse animation
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
`;
document.head.appendChild(style);
</script>

<?php get_footer(); ?>