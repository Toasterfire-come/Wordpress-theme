<?php
/**
 * Template for News page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Market News</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Latest market news with sentiment analysis and personalized feeds</p>
        </div>

        <!-- News Filters -->
        <div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Category</label>
                    <select id="news-category" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                        <option value="all">All News</option>
                        <option value="market">Market Updates</option>
                        <option value="earnings">Earnings</option>
                        <option value="economic">Economic Data</option>
                        <option value="analyst">Analyst Reports</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Sentiment</label>
                    <select id="news-sentiment" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                        <option value="all">All Sentiment</option>
                        <option value="positive">Positive</option>
                        <option value="neutral">Neutral</option>
                        <option value="negative">Negative</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Time Period</label>
                    <select id="news-period" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                        <option value="1d">Last 24 Hours</option>
                        <option value="3d">Last 3 Days</option>
                        <option value="1w">Last Week</option>
                        <option value="1m">Last Month</option>
                    </select>
                </div>
                <div style="display: flex; align-items: end;">
                    <button id="filter-news" class="btn btn-primary" style="width: 100%;">Apply Filters</button>
                </div>
            </div>
        </div>

        <!-- News Grid -->
        <div id="news-container">
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <div class="loading-spinner" style="margin: 0 auto 1rem;"></div>
                <p>Loading market news...</p>
            </div>
        </div>

        <!-- Load More -->
        <div style="text-align: center; margin-top: 2rem;">
            <button id="load-more-news" class="btn btn-outline" style="display: none;">Load More News</button>
        </div>
    </div>
</main>

<script>
let currentPage = 1;
let isLoading = false;

document.addEventListener('DOMContentLoaded', function() {
    loadNews();
    
    document.getElementById('filter-news').addEventListener('click', function() {
        currentPage = 1;
        loadNews(true);
    });
    
    document.getElementById('load-more-news').addEventListener('click', function() {
        currentPage++;
        loadNews(false);
    });
});

function loadNews(reset = true) {
    if (isLoading) return;
    
    isLoading = true;
    
    if (reset) {
        document.getElementById('news-container').innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <div class="loading-spinner" style="margin: 0 auto 1rem;"></div>
                <p>Loading market news...</p>
            </div>
        `;
        document.getElementById('load-more-news').style.display = 'none';
    }
    
    const category = document.getElementById('news-category').value;
    const sentiment = document.getElementById('news-sentiment').value;
    const period = document.getElementById('news-period').value;
    
    const params = new URLSearchParams({
        page: currentPage,
        category: category,
        sentiment: sentiment,
        period: period,
        limit: 10
    });
    
    fetch(`<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/news')); ?>?${params}`, {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            displayNews(data.data, reset);
        } else {
            if (reset) {
                displayNoNews();
            }
        }
    })
    .catch(error => {
        console.error('News loading error:', error);
        if (reset) {
            displayError();
        }
    })
    .finally(() => {
        isLoading = false;
    });
}

function displayNews(articles, reset = true) {
    const container = document.getElementById('news-container');
    
    if (reset) {
        container.innerHTML = '';
    }
    
    if (articles.length === 0 && reset) {
        displayNoNews();
        return;
    }
    
    const newsHTML = articles.map(article => `
        <article class="card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: grid; grid-template-columns: ${article.image_url ? '1fr 200px' : '1fr'}; gap: 1.5rem; align-items: start;">
                <div>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <span style="background: ${getSentimentColor(article.sentiment)}; color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">
                            ${article.sentiment || 'Neutral'}
                        </span>
                        <span style="color: #64748b; font-size: 0.875rem;">${article.source}</span>
                        <span style="color: #64748b; font-size: 0.875rem;">${formatNewsDate(article.published_at)}</span>
                    </div>
                    
                    <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; line-height: 1.4;">
                        <a href="${article.url}" target="_blank" style="color: #0f172a; text-decoration: none;">
                            ${article.title}
                        </a>
                    </h2>
                    
                    <p style="color: #64748b; margin-bottom: 1rem; line-height: 1.6;">
                        ${article.summary || article.description || ''}
                    </p>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <a href="${article.url}" target="_blank" class="btn btn-outline" style="font-size: 0.875rem;">
                            Read Full Article →
                        </a>
                        ${article.related_symbols ? `
                            <div style="display: flex; gap: 0.5rem;">
                                ${article.related_symbols.slice(0, 3).map(symbol => `
                                    <span style="background: #f1f5f9; color: #1e40af; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                        ${symbol}
                                    </span>
                                `).join('')}
                            </div>
                        ` : ''}
                    </div>
                </div>
                
                ${article.image_url ? `
                    <div>
                        <img src="${article.image_url}" alt="${article.title}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                    </div>
                ` : ''}
            </div>
        </article>
    `).join('');
    
    if (reset) {
        container.innerHTML = newsHTML;
    } else {
        container.insertAdjacentHTML('beforeend', newsHTML);
    }
    
    // Show load more button if there are more articles
    if (articles.length === 10) {
        document.getElementById('load-more-news').style.display = 'block';
    } else {
        document.getElementById('load-more-news').style.display = 'none';
    }
}

function displayNoNews() {
    document.getElementById('news-container').innerHTML = `
        <div style="text-align: center; padding: 3rem; color: #64748b;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📰</div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No news found</h3>
            <p>Try adjusting your filters to see more news articles.</p>
        </div>
    `;
}

function displayError() {
    document.getElementById('news-container').innerHTML = `
        <div style="text-align: center; padding: 3rem; color: #dc2626;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">⚠️</div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Failed to load news</h3>
            <p>There was an error loading market news. Please try again.</p>
            <button onclick="loadNews(true)" class="btn btn-primary" style="margin-top: 1rem;">
                Retry
            </button>
        </div>
    `;
}

function getSentimentColor(sentiment) {
    switch (sentiment?.toLowerCase()) {
        case 'positive': return '#059669';
        case 'negative': return '#dc2626';
        case 'neutral': 
        default: return '#64748b';
    }
}

function formatNewsDate(dateString) {
    try {
        const date = new Date(dateString);
        const now = new Date();
        const diffMs = now - date;
        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
        const diffDays = Math.floor(diffHours / 24);
        
        if (diffHours < 1) {
            return 'Just now';
        } else if (diffHours < 24) {
            return `${diffHours}h ago`;
        } else if (diffDays < 7) {
            return `${diffDays}d ago`;
        } else {
            return date.toLocaleDateString();
        }
    } catch {
        return 'Recently';
    }
}
</script>

<?php get_footer(); ?>