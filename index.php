<?php
/**
 * The main template file
 * Stock Scanner Pro Theme
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php if (is_front_page()): ?>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="text-center">
                    <div style="background: rgba(52, 211, 153, 0.2); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.3); padding: 0.75rem 1.5rem; border-radius: 25px; display: inline-block; margin-bottom: 2rem;">
                        <span style="margin-right: 0.5rem;">📊</span>
                        Professional Stock Scanner &amp; Portfolio Manager
                    </div>
                    
                    <h1 class="hero-title">
                        Complete Stock Scanner<br>
                        <span style="background: linear-gradient(to right, #34d399, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            &amp; Portfolio Manager
                        </span>
                    </h1>
                    
                    <p class="hero-subtitle">
                        Professional-grade stock analysis platform with real-time data updates sub three minutes, 
                        comprehensive portfolio management, and intelligent market insights. Built for traders who demand accuracy.
                    </p>
                    
                    <div class="hero-actions">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" class="btn btn-primary btn-large">
                            Start Free Trial
                            <span style="margin-left: 0.5rem;">→</span>
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-outline btn-large" style="border-color: rgba(255,255,255,0.3); color: white;">
                            View Plans &amp; Pricing
                        </a>
                    </div>

                    <div style="display: flex; justify-content: center; align-items: center; gap: 2rem; margin-top: 2rem; flex-wrap: wrap; color: #cbd5e1;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: #34d399;">✓</span>
                            <span>No Credit Card Required</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: #34d399;">✓</span>
                            <span>15 Free Monthly Requests</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: #34d399;">✓</span>
                            <span>Production Ready</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Live Market Data Section -->
        <section class="py-12" style="background: white; border-bottom: 1px solid #e2e8f0;">
            <div class="container">
                <div class="text-center mb-8">
                    <div style="background: #d1fae5; color: #047857; padding: 0.5rem 1rem; border-radius: 20px; display: inline-block; margin-bottom: 1.5rem;">
                        <span style="margin-right: 0.5rem;">📈</span>
                        Live Market Data
                    </div>
                    <h2 style="font-size: 3rem; font-weight: bold; margin-bottom: 1.5rem;">
                        Real-Time Market Overview
                    </h2>
                    <p style="font-size: 1.25rem; color: #64748b; max-width: 600px; margin: 0 auto;">
                        Live stock market data updated sub three minutes during trading hours
                    </p>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <div class="card" style="text-align: center; border-left: 4px solid #059669;">
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.75rem;">Total Tracked</h3>
                        <p style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 0.5rem;">3,500+</p>
                        <p style="font-size: 0.875rem; color: #64748b;">Securities monitored</p>
                    </div>
                    <div class="card" style="text-align: center; border-left: 4px solid #10b981;">
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.75rem;">Gainers</h3>
                        <p style="font-size: 3rem; font-weight: bold; color: #059669; margin-bottom: 0.5rem;">Live</p>
                        <p style="font-size: 0.875rem; color: #059669;">Stocks rising</p>
                    </div>
                    <div class="card" style="text-align: center; border-left: 4px solid #ef4444;">
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.75rem;">Losers</h3>
                        <p style="font-size: 3rem; font-weight: bold; color: #dc2626; margin-bottom: 0.5rem;">Live</p>
                        <p style="font-size: 0.875rem; color: #dc2626;">Stocks falling</p>
                    </div>
                    <div class="card" style="text-align: center; border-left: 4px solid #3b82f6;">
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.75rem;">Update Freq</h3>
                        <p style="font-size: 3rem; font-weight: bold; color: #2563eb; margin-bottom: 0.5rem;">&lt;3min</p>
                        <p style="font-size: 0.875rem; color: #2563eb;">During market hours</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="py-12" style="background: #f8fafc;">
            <div class="container">
                <div class="text-center mb-8">
                    <h2 style="font-size: 3rem; font-weight: bold; margin-bottom: 2rem;">
                        Simple, Transparent Pricing
                    </h2>
                    <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 2rem;">
                        Choose the plan that fits your trading needs. Start free, upgrade when ready.
                    </p>
                </div>
                
                <div class="pricing-grid">
                    <!-- Free Plan -->
                    <div class="pricing-card">
                        <h3 class="card-title">Free</h3>
                        <div class="price">$0<span class="price-period">/month</span></div>
                        <p class="card-description">Basic stock lookup and filtering for casual users</p>
                        <ul class="feature-list">
                            <li><span class="checkmark">✓</span> 15 API requests per month</li>
                            <li><span class="checkmark">✓</span> Stock symbol lookup &amp; search</li>
                            <li><span class="checkmark">✓</span> Basic price filtering</li>
                            <li><span class="x-mark">✗</span> No portfolio management</li>
                            <li><span class="x-mark">✗</span> No email alerts</li>
                        </ul>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" class="btn btn-primary" style="width: 100%;">Get Started Free</a>
                    </div>

                    <!-- Basic Plan -->
                    <div class="pricing-card popular">
                        <h3 class="card-title">Basic</h3>
                        <div class="price">$24.99<span class="price-period">/month</span></div>
                        <p class="card-description">Enhanced features for active individual traders</p>
                        <ul class="feature-list">
                            <li><span class="checkmark">✓</span> 1,500 API requests per month</li>
                            <li><span class="checkmark">✓</span> Full stock scanner &amp; lookup</li>
                            <li><span class="checkmark">✓</span> Email alerts &amp; notifications</li>
                            <li><span class="checkmark">✓</span> News sentiment analysis</li>
                            <li><span class="checkmark">✓</span> Basic portfolio tracking</li>
                        </ul>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('checkout'))); ?>?plan=basic" class="btn btn-primary" style="width: 100%;">Start Basic Plan</a>
                    </div>

                    <!-- Pro Plan -->
                    <div class="pricing-card">
                        <h3 class="card-title">Pro</h3>
                        <div class="price">$49.99<span class="price-period">/month</span></div>
                        <p class="card-description">Professional tools for serious traders</p>
                        <ul class="feature-list">
                            <li><span class="checkmark">✓</span> 5,000 API requests per month</li>
                            <li><span class="checkmark">✓</span> Unlimited portfolios</li>
                            <li><span class="checkmark">✓</span> Advanced alert system</li>
                            <li><span class="checkmark">✓</span> Full REST API access</li>
                            <li><span class="checkmark">✓</span> Priority support</li>
                        </ul>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('checkout'))); ?>?plan=pro" class="btn btn-primary" style="width: 100%;">Start Pro Plan</a>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="pricing-card">
                        <h3 class="card-title">Enterprise</h3>
                        <div class="price">Contact Sales</div>
                        <p class="card-description">Custom solutions for institutions</p>
                        <ul class="feature-list">
                            <li><span class="checkmark">✓</span> Unlimited API requests</li>
                            <li><span class="checkmark">✓</span> Custom integrations</li>
                            <li><span class="checkmark">✓</span> Dedicated support manager</li>
                            <li><span class="checkmark">✓</span> SLA guarantees</li>
                            <li><span class="checkmark">✓</span> White-label options</li>
                        </ul>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>?plan=enterprise" class="btn btn-primary" style="width: 100%;">Contact Sales Team</a>
                    </div>
                </div>
            </div>
        </section>

    <?php else: ?>
        <!-- Default page content -->
        <div class="container py-8">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header mb-4">
                            <h1 class="entry-title text-3xl font-bold"><?php the_title(); ?></h1>
                        </header>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>