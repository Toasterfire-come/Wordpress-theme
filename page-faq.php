<?php
/**
 * Template for FAQ page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="background: #f8fafc;">
    
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 6rem 0; text-align: center;">
        <div class="container">
            <h1 style="font-size: 3.5rem; font-weight: bold; margin-bottom: 1.5rem;">
                <?php _e('Frequently Asked Questions', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #cbd5e1; max-width: 600px; margin: 0 auto;">
                <?php _e('Find answers to common questions about our stock trading platform.', 'retail-trade-scanner'); ?>
            </p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section style="padding: 6rem 0;">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            
            <!-- FAQ Categories -->
            <div id="faq-categories" style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 3rem; flex-wrap: wrap;">
                <button class="category-btn active" data-category="all" style="padding: 0.75rem 1.5rem; border: none; background: #059669; color: white; border-radius: 6px; cursor: pointer; font-weight: 500;">
                    <?php _e('All', 'retail-trade-scanner'); ?>
                </button>
                <button class="category-btn" data-category="general" style="padding: 0.75rem 1.5rem; border: 1px solid #d1d5db; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-weight: 500;">
                    <?php _e('General', 'retail-trade-scanner'); ?>
                </button>
                <button class="category-btn" data-category="pricing" style="padding: 0.75rem 1.5rem; border: 1px solid #d1d5db; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-weight: 500;">
                    <?php _e('Pricing', 'retail-trade-scanner'); ?>
                </button>
                <button class="category-btn" data-category="technical" style="padding: 0.75rem 1.5rem; border: 1px solid #d1d5db; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-weight: 500;">
                    <?php _e('Technical', 'retail-trade-scanner'); ?>
                </button>
                <button class="category-btn" data-category="account" style="padding: 0.75rem 1.5rem; border: 1px solid #d1d5db; background: white; color: #64748b; border-radius: 6px; cursor: pointer; font-weight: 500;">
                    <?php _e('Account', 'retail-trade-scanner'); ?>
                </button>
            </div>

            <!-- FAQ Items -->
            <div id="faq-items">
                <!-- General FAQs -->
                <div class="faq-item" data-category="general" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('What is Retail Trade Scanner?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('Retail Trade Scanner is a professional stock analysis platform that provides real-time market data, portfolio management tools, and advanced trading analytics. Our platform is designed for both individual traders and institutional investors.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>

                <div class="faq-item" data-category="general" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('How often is the market data updated?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('Our market data is updated every 3 minutes during trading hours. We provide real-time stock prices, volume data, and market statistics to ensure you have the most current information for your trading decisions.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>

                <!-- Pricing FAQs -->
                <div class="faq-item" data-category="pricing" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('What is included in the free plan?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('The free plan includes 15 API requests per month, basic stock symbol lookup and search, and basic price filtering. It is perfect for casual users who want to try our platform.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>

                <div class="faq-item" data-category="pricing" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('Can I upgrade or downgrade my plan anytime?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately, and billing adjustments are prorated. You can manage your subscription from your account settings.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>

                <!-- Technical FAQs -->
                <div class="faq-item" data-category="technical" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('Do you provide API access?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('Yes, Pro and Enterprise plans include full REST API access. Our API provides endpoints for stock data, portfolio management, watchlists, and market analytics. Complete documentation is available for developers.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>

                <div class="faq-item" data-category="technical" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('What data sources do you use?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('We aggregate data from multiple reliable financial data providers and exchanges to ensure accuracy and completeness. Our data includes real-time and historical stock prices, volume, market cap, and fundamental analysis metrics.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>

                <!-- Account FAQs -->
                <div class="faq-item" data-category="account" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('How do I reset my password?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('You can reset your password from the login page by clicking "Forgot password?" or from your account settings. We will send you a secure reset link via email.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>

                <div class="faq-item" data-category="account" style="background: white; border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <button class="faq-question" style="width: 100%; text-align: left; padding: 2rem; border: none; background: none; cursor: pointer; font-size: 1.125rem; font-weight: 600; color: #0f172a; display: flex; justify-content: space-between; align-items: center;">
                        <?php _e('Can I cancel my subscription at any time?', 'retail-trade-scanner'); ?>
                        <span class="faq-icon" style="font-size: 1.5rem; transition: transform 0.3s;">+</span>
                    </button>
                    <div class="faq-answer" style="padding: 0 2rem 2rem; display: none; color: #64748b; line-height: 1.6;">
                        <p><?php _e('Yes, you can cancel your subscription at any time from your account settings. Your access will continue until the end of your current billing period, and you can reactivate anytime.', 'retail-trade-scanner'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section style="padding: 6rem 0; background: white; text-align: center;">
        <div class="container" style="max-width: 600px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                <?php _e("Didn't Find Your Answer?", 'retail-trade-scanner'); ?>
            </h2>
            <p style="font-size: 1.125rem; color: #64748b; margin-bottom: 2rem;">
                <?php _e('Our support team is here to help you with any questions.', 'retail-trade-scanner'); ?>
            </p>
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary btn-large">
                <?php _e('Contact Support', 'retail-trade-scanner'); ?>
            </a>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ toggle functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('.faq-icon');
            const isOpen = answer.style.display === 'block';
            
            // Close all other FAQs
            faqQuestions.forEach(q => {
                const a = q.nextElementSibling;
                const i = q.querySelector('.faq-icon');
                a.style.display = 'none';
                i.textContent = '+';
                i.style.transform = 'rotate(0deg)';
            });
            
            // Toggle current FAQ
            if (!isOpen) {
                answer.style.display = 'block';
                icon.textContent = '−';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
    
    // Category filtering
    const categoryBtns = document.querySelectorAll('.category-btn');
    const faqItems = document.querySelectorAll('.faq-item');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active button
            categoryBtns.forEach(b => {
                b.classList.remove('active');
                b.style.background = 'white';
                b.style.color = '#64748b';
            });
            
            this.classList.add('active');
            this.style.background = '#059669';
            this.style.color = 'white';
            
            // Filter FAQ items
            faqItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Close all FAQs when filtering
            faqQuestions.forEach(q => {
                const a = q.nextElementSibling;
                const i = q.querySelector('.faq-icon');
                a.style.display = 'none';
                i.textContent = '+';
                i.style.transform = 'rotate(0deg)';
            });
        });
    });
});
</script>

<?php get_footer(); ?>