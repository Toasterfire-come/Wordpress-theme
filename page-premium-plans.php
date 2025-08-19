<?php
/**
 * Template for Premium Plans page - Bug-Fixed & Plugin-Compatible Version
 * Retail Trade Scanner Theme - Updated Version
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

    <!-- Pricing Section - Plugin Compatible -->
    <section style="padding: 6rem 0;">
        <div class="container">
            <div class="pricing-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto;">
                
                <!-- Free Plan -->
                <div class="pricing-card" style="background: white; border: 2px solid #e5e7eb; border-radius: 16px; padding: 2rem; text-align: center; position: relative;">
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('🆓 Free', 'retail-trade-scanner'); ?>
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
                            <?php _e('15 stocks per month', 'retail-trade-scanner'); ?>
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
                    
                    <a href="<?php echo wp_registration_url(); ?>" class="btn btn-outline" style="width: 100%; justify-content: center; padding: 1rem; text-decoration: none; display: inline-block; text-align: center;">
                        <?php _e('Get Started Free', 'retail-trade-scanner'); ?>
                    </a>
                </div>

                <!-- Bronze Plan - Aligned with Plugin Pricing -->
                <div class="pricing-card popular" style="background: white; border: 2px solid #cd7f32; border-radius: 16px; padding: 2rem; text-align: center; position: relative; transform: scale(1.05);">
                    <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #cd7f32; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                        <?php _e('Most Popular', 'retail-trade-scanner'); ?>
                    </div>
                    
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('🥉 Bronze', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin: 1rem 0;">
                        $14.99<span style="font-size: 1rem; color: #64748b;"><?php _e('/month', 'retail-trade-scanner'); ?></span>
                    </div>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Enhanced features for active traders', 'retail-trade-scanner'); ?>
                    </p>
                    
                    <ul style="list-style: none; margin: 2rem 0; text-align: left;">
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('1,000 stocks per month', 'retail-trade-scanner'); ?>
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
                    
                    <div id="bronze-payment-button" style="width: 100%; min-height: 50px;">
                        <?php if (class_exists('StockScannerIntegration') && function_exists('pmpro_url')) : ?>
                            <a href="<?php echo pmpro_url('checkout', '?level=2'); ?>" class="btn btn-primary" style="width: 100%; padding: 1rem; text-decoration: none; display: inline-block; text-align: center;">
                                <?php _e('Upgrade to Bronze', 'retail-trade-scanner'); ?>
                            </a>
                        <?php else : ?>
                            <button class="btn btn-primary upgrade-btn" data-level="2" data-price="14.99" style="width: 100%; padding: 1rem;">
                                <?php _e('Upgrade to Bronze', 'retail-trade-scanner'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Silver Plan - Aligned with Plugin Pricing -->
                <div class="pricing-card" style="background: white; border: 2px solid #c0c0c0; border-radius: 16px; padding: 2rem; text-align: center; position: relative;">
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('🥈 Silver', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin: 1rem 0;">
                        $29.99<span style="font-size: 1rem; color: #64748b;"><?php _e('/month', 'retail-trade-scanner'); ?></span>
                    </div>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Professional tools for serious traders', 'retail-trade-scanner'); ?>
                    </p>
                    
                    <ul style="list-style: none; margin: 2rem 0; text-align: left;">
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('5,000 stocks per month', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Advanced filtering & screening', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('1-year historical data', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Custom watchlists (10)', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Priority support', 'retail-trade-scanner'); ?>
                        </li>
                    </ul>
                    
                    <div id="silver-payment-button" style="width: 100%; min-height: 50px;">
                        <?php if (class_exists('StockScannerIntegration') && function_exists('pmpro_url')) : ?>
                            <a href="<?php echo pmpro_url('checkout', '?level=3'); ?>" class="btn btn-primary" style="width: 100%; padding: 1rem; text-decoration: none; display: inline-block; text-align: center;">
                                <?php _e('Upgrade to Silver', 'retail-trade-scanner'); ?>
                            </a>
                        <?php else : ?>
                            <button class="btn btn-primary upgrade-btn" data-level="3" data-price="29.99" style="width: 100%; padding: 1rem;">
                                <?php _e('Upgrade to Silver', 'retail-trade-scanner'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Gold Plan - Aligned with Plugin Pricing -->
                <div class="pricing-card" style="background: white; border: 2px solid #ffd700; border-radius: 16px; padding: 2rem; text-align: center; position: relative;">
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; color: #0f172a;">
                        <?php _e('🏆 Gold', 'retail-trade-scanner'); ?>
                    </h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin: 1rem 0;">
                        $59.99<span style="font-size: 1rem; color: #64748b;"><?php _e('/month', 'retail-trade-scanner'); ?></span>
                    </div>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Ultimate trading experience', 'retail-trade-scanner'); ?>
                    </p>
                    
                    <ul style="list-style: none; margin: 2rem 0; text-align: left;">
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('10,000 stocks per month', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('All premium features', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Real-time alerts', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Full REST API access', 'retail-trade-scanner'); ?>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="color: #059669;">✓</span>
                            <?php _e('Priority phone support', 'retail-trade-scanner'); ?>
                        </li>
                    </ul>
                    
                    <div id="gold-payment-button" style="width: 100%; min-height: 50px;">
                        <?php if (class_exists('StockScannerIntegration') && function_exists('pmpro_url')) : ?>
                            <a href="<?php echo pmpro_url('checkout', '?level=4'); ?>" class="btn btn-primary" style="width: 100%; padding: 1rem; text-decoration: none; display: inline-block; text-align: center; background: #ffd700; color: #000;">
                                <?php _e('Upgrade to Gold', 'retail-trade-scanner'); ?>
                            </a>
                        <?php else : ?>
                            <button class="btn btn-primary upgrade-btn" data-level="4" data-price="59.99" style="width: 100%; padding: 1rem; background: #ffd700; color: #000;">
                                <?php _e('Upgrade to Gold', 'retail-trade-scanner'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Plan Comparison Button -->
            <div style="text-align: center; margin-top: 3rem;">
                <p style="color: #64748b; margin-bottom: 1rem;">
                    <?php _e('Need help choosing? Compare all features below.', 'retail-trade-scanner'); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Live Demo Section -->
    <section style="padding: 6rem 0; background: white;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('📊 Live Stock Analysis Demo', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.125rem; color: #64748b;">
                    <?php _e('See our platform in action with real-time data', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
                <?php 
                // Display stock widgets if plugin is active
                if (class_exists('StockScannerIntegration')) {
                    echo do_shortcode('[stock_scanner symbol="AAPL" show_chart="true" show_details="true"]');
                    echo do_shortcode('[stock_scanner symbol="MSFT" show_chart="true" show_details="true"]');
                    echo do_shortcode('[stock_scanner symbol="GOOGL" show_chart="true" show_details="true"]');
                } else {
                    // Fallback demo widgets
                    echo '<div class="demo-widget" style="background: #f8fafc; padding: 2rem; border-radius: 12px; text-align: center;">
                        <h4>📈 AAPL Demo</h4>
                        <p style="color: #64748b;">Live widget requires Stock Scanner Plugin</p>
                        <button class="btn btn-outline">Install Plugin</button>
                    </div>';
                    echo '<div class="demo-widget" style="background: #f8fafc; padding: 2rem; border-radius: 12px; text-align: center;">
                        <h4>📊 MSFT Demo</h4>
                        <p style="color: #64748b;">Live widget requires Stock Scanner Plugin</p>
                        <button class="btn btn-outline">Install Plugin</button>
                    </div>';
                    echo '<div class="demo-widget" style="background: #f8fafc; padding: 2rem; border-radius: 12px; text-align: center;">
                        <h4>🚀 GOOGL Demo</h4>
                        <p style="color: #64748b;">Live widget requires Stock Scanner Plugin</p>
                        <button class="btn btn-outline">Install Plugin</button>
                    </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Feature Comparison Table -->
    <section style="padding: 6rem 0; background: #f8fafc;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('📋 Detailed Feature Comparison', 'retail-trade-scanner'); ?>
                </h2>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <thead>
                        <tr style="background: #0f172a; color: white;">
                            <th style="text-align: left; padding: 1.5rem; font-weight: 600;">Features</th>
                            <th style="text-align: center; padding: 1.5rem; font-weight: 600;">Free</th>
                            <th style="text-align: center; padding: 1.5rem; font-weight: 600;">Bronze</th>
                            <th style="text-align: center; padding: 1.5rem; font-weight: 600;">Silver</th>
                            <th style="text-align: center; padding: 1.5rem; font-weight: 600;">Gold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1.5rem; font-weight: 500;">Monthly Stock Lookups</td>
                            <td style="text-align: center; padding: 1.5rem;">15</td>
                            <td style="text-align: center; padding: 1.5rem; background: #fef3c7;">1,000</td>
                            <td style="text-align: center; padding: 1.5rem; background: #f3f4f6;">5,000</td>
                            <td style="text-align: center; padding: 1.5rem; background: #fef3c7;">10,000</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1.5rem; font-weight: 500;">Email List Subscriptions</td>
                            <td style="text-align: center; padding: 1.5rem;">5</td>
                            <td style="text-align: center; padding: 1.5rem;">15</td>
                            <td style="text-align: center; padding: 1.5rem;">Unlimited</td>
                            <td style="text-align: center; padding: 1.5rem;">Unlimited</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1.5rem; font-weight: 500;">Advanced Filtering</td>
                            <td style="text-align: center; padding: 1.5rem;">❌</td>
                            <td style="text-align: center; padding: 1.5rem;">Basic</td>
                            <td style="text-align: center; padding: 1.5rem;">✅</td>
                            <td style="text-align: center; padding: 1.5rem;">✅</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1.5rem; font-weight: 500;">Historical Data</td>
                            <td style="text-align: center; padding: 1.5rem;">❌</td>
                            <td style="text-align: center; padding: 1.5rem;">30 days</td>
                            <td style="text-align: center; padding: 1.5rem;">1 year</td>
                            <td style="text-align: center; padding: 1.5rem;">5 years</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1.5rem; font-weight: 500;">Custom Watchlists</td>
                            <td style="text-align: center; padding: 1.5rem;">❌</td>
                            <td style="text-align: center; padding: 1.5rem;">3</td>
                            <td style="text-align: center; padding: 1.5rem;">10</td>
                            <td style="text-align: center; padding: 1.5rem;">Unlimited</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1.5rem; font-weight: 500;">API Access</td>
                            <td style="text-align: center; padding: 1.5rem;">❌</td>
                            <td style="text-align: center; padding: 1.5rem;">❌</td>
                            <td style="text-align: center; padding: 1.5rem;">Limited</td>
                            <td style="text-align: center; padding: 1.5rem;">Full</td>
                        </tr>
                        <tr>
                            <td style="padding: 1.5rem; font-weight: 500;">Support Level</td>
                            <td style="text-align: center; padding: 1.5rem;">Community</td>
                            <td style="text-align: center; padding: 1.5rem;">Email</td>
                            <td style="text-align: center; padding: 1.5rem;">Priority</td>
                            <td style="text-align: center; padding: 1.5rem;">Phone + Manager</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Plugin Status Notice -->
    <?php if (!class_exists('StockScannerIntegration')) : ?>
    <section style="padding: 3rem 0; background: #fef3c7;">
        <div class="container">
            <div style="text-align: center; max-width: 600px; margin: 0 auto;">
                <h3 style="color: #92400e; margin-bottom: 1rem;">⚠️ Plugin Required</h3>
                <p style="color: #92400e;">To enable subscription management and live stock data, please install and activate the <strong>Stock Scanner Integration</strong> plugin.</p>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>