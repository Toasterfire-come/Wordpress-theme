<?php
/**
 * Template for Premium Plans page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="background: #f8fafc;">
    
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 6rem 0; text-align: center;">
        <div class="container">
            <h1 style="font-size: 3.5rem; font-weight: bold; margin-bottom: 1.5rem;">
                <?php _e('Choose Your Trading Plan', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #cbd5e1; max-width: 600px; margin: 0 auto;">
                <?php _e('From casual lookup users to professional trading firms. Find the plan that fits your needs.', 'retail-trade-scanner'); ?>
            </p>
        </div>
    </section>

    <!-- Pricing Section -->
    <section style="padding: 6rem 0;">
        <div class="container">
            <div class="pricing-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto;">
                
                <!-- Free Plan -->
                <div class="pricing-card" style="background: white; border: 2px solid #e5e7eb; border-radius: 16px; padding: 2rem; text-align: center; position: relative;">
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('Free', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin: 1rem 0;">
                        $0<span style="font-size: 1rem; color: #64748b;"><?php _e('/month', 'retail-trade-scanner'); ?></span>
                    </div>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Basic stock lookup and filtering', 'retail-trade-scanner'); ?>
                    </p>
                    
                    <ul style="list-style: none; margin: 2rem 0; text-align: left;">
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('15 API requests per month', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Stock symbol lookup & search', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Basic price filtering', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #e5e7eb;">✗</span>
                            <?php _e('No portfolio management', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #e5e7eb;">✗</span>
                            <?php _e('No email alerts', 'retail-trade-scanner'); ?>
                        </li>
                    </ul>
                    
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" class="btn btn-outline" style="width: 100%; justify-content: center; padding: 1rem;">
                        <?php _e('Get Started Free', 'retail-trade-scanner'); ?>
                    </a>
                </div>

                <!-- Basic Plan -->
                <div class="pricing-card popular" style="background: white; border: 2px solid #059669; border-radius: 16px; padding: 2rem; text-align: center; position: relative; transform: scale(1.05);">
                    <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #059669; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                        <?php _e('Most Popular', 'retail-trade-scanner'); ?>
                    </div>
                    
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('Basic', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin: 1rem 0;">
                        $24.99<span style="font-size: 1rem; color: #64748b;"><?php _e('/month', 'retail-trade-scanner'); ?></span>
                    </div>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Enhanced features for active traders', 'retail-trade-scanner'); ?>
                    </p>
                    
                    <ul style="list-style: none; margin: 2rem 0; text-align: left;">
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('1,500 API requests per month', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Full stock scanner & lookup', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Email alerts & notifications', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('News sentiment analysis', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Basic portfolio tracking', 'retail-trade-scanner'); ?>
                        </li>
                    </ul>
                    
                    <button onclick="selectPlan('basic', 24.99)" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                        <?php _e('Start Basic Plan', 'retail-trade-scanner'); ?>
                    </button>
                </div>

                <!-- Pro Plan -->
                <div class="pricing-card" style="background: white; border: 2px solid #e5e7eb; border-radius: 16px; padding: 2rem; text-align: center; position: relative;">
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('Pro', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin: 1rem 0;">
                        $49.99<span style="font-size: 1rem; color: #64748b;"><?php _e('/month', 'retail-trade-scanner'); ?></span>
                    </div>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Professional tools for serious traders', 'retail-trade-scanner'); ?>
                    </p>
                    
                    <ul style="list-style: none; margin: 2rem 0; text-align: left;">
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('5,000 API requests per month', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Unlimited portfolios', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Advanced alert system', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Full REST API access', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Priority support', 'retail-trade-scanner'); ?>
                        </li>
                    </ul>
                    
                    <button onclick="selectPlan('pro', 49.99)" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                        <?php _e('Start Pro Plan', 'retail-trade-scanner'); ?>
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="pricing-card" style="background: white; border: 2px solid #e5e7eb; border-radius: 16px; padding: 2rem; text-align: center; position: relative; grid-column: span 1;">
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('Enterprise', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="font-size: 2rem; font-weight: bold; color: #0f172a; margin: 1rem 0;">
                        <?php _e('Contact Sales', 'retail-trade-scanner'); ?>
                    </div>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Custom solutions for institutions', 'retail-trade-scanner'); ?>
                    </p>
                    
                    <ul style="list-style: none; margin: 2rem 0; text-align: left;">
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Unlimited API requests', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Custom integrations', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Dedicated support manager', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('SLA guarantees', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('White-label options', 'retail-trade-scanner'); ?>
                        </li>
                    </ul>
                    
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>?plan=enterprise" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem; text-decoration: none;">
                        <?php _e('Contact Sales Team', 'retail-trade-scanner'); ?>
                    </a>
                </div>
            </div>

            <!-- Plan Comparison Button -->
            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('compare-plans'))); ?>" class="btn btn-outline btn-large">
                    <?php _e('Compare All Plans', 'retail-trade-scanner'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section style="padding: 6rem 0; background: white;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('All Plans Include', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.125rem; color: #64748b;">
                    <?php _e('Professional features designed for serious traders', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Secure & Reliable', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b;">
                        <?php _e('Enterprise-grade security with 99.9% uptime guarantee', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
                <div style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Real-Time Data', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b;">
                        <?php _e('Market data updated every 3 minutes during trading hours', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
                <div style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📞</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Expert Support', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b;">
                        <?php _e('Get help from our team of trading platform experts', 'retail-trade-scanner'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function selectPlan(planType, price) {
    // Handle plan selection
    if (confirm(`<?php _e('Start', 'retail-trade-scanner'); ?> ${planType.toUpperCase()} <?php _e('plan for', 'retail-trade-scanner'); ?> $${price}/<?php _e('month', 'retail-trade-scanner'); ?>?`)) {
        // Redirect to checkout or payment processing
        window.location.href = `<?php echo esc_url(get_permalink(get_page_by_path('account'))); ?>?upgrade=${planType}`;
    }
}
</script>

<?php get_footer(); ?>