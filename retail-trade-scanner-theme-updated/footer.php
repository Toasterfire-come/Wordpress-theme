<?php
/**
 * The template for displaying the footer - Updated version
 */
?>

    <footer id="colophon" class="site-footer" style="background: #0f172a; color: #cbd5e1; margin-top: auto;">
        <div class="container">
            <div style="padding: 3rem 0 1.5rem;">
                <!-- Footer Content -->
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <!-- Brand Section -->
                    <div>
                        <a href="<?php echo esc_url(home_url('/')); ?>" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: white; margin-bottom: 1rem;">
                            <div style="width: 32px; height: 32px; background: #059669; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white;">
                                <span>📊</span>
                            </div>
                            <div>
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;">Retail Trade Scanner</h3>
                                <p style="font-size: 0.875rem; color: #94a3b8; margin: 0;">Professional Trading Platform</p>
                            </div>
                        </a>
                        <p style="color: #94a3b8; font-size: 0.875rem; line-height: 1.6; margin-bottom: 1rem;">
                            Empowering traders with institutional-grade market data, advanced analytics, and professional tools. 
                            Trusted by portfolio managers at leading financial institutions worldwide.
                        </p>
                        <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #94a3b8;">
                            <span>📍 New York, NY</span>
                            <span style="background: #059669; color: white; padding: 0.125rem 0.5rem; border-radius: 1rem; font-size: 0.75rem;">SOC 2 Compliant</span>
                        </div>
                    </div>

                    <!-- Platform Links -->
                    <div>
                        <h4 style="color: white; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">Platform</h4>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('dashboard'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Dashboard</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('scanner'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Stock Scanner</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('market-overview'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Market Data</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('portfolio'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Portfolio Tools</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">News & Analysis</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Features -->
                    <div>
                        <h4 style="color: white; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">Features</h4>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Real-time Data</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Technical Analysis</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Smart Alerts</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Portfolio Tracking</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Research Tools</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">API Access</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Company -->
                    <div>
                        <h4 style="color: white; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">Company</h4>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">About Us</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Careers</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Press Kit</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Partners</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Investors</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Blog</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 style="color: white; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">Support</h4>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Help Center</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Getting Started</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">API Documentation</span>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('status'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">System Status</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Contact Support</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <span style="color: #94a3b8; font-size: 0.875rem;">Community</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div style="border-top: 1px solid #334155; padding-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="color: #64748b; font-size: 0.875rem;">
                            <p style="margin: 0;">© <?php echo date('Y'); ?> Retail Trade Scanner. All rights reserved.</p>
                        </div>
                        <div style="display: flex; gap: 2rem; font-size: 0.875rem;">
                            <span style="color: #94a3b8;">Sitemap</span>
                            <span style="color: #94a3b8;">Accessibility</span>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy'))); ?>" 
                               style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;"
                               onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Privacy Policy</a>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" 
                               style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;"
                               onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Terms of Service</a>
                            <span style="color: #94a3b8;">Cookie Policy</span>
                            <span style="color: #94a3b8;">Security</span>
                            <span style="color: #94a3b8;">Compliance</span>
                            <span style="color: #94a3b8;">Data Protection</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Footer Widgets (if any) -->
    <?php if (is_active_sidebar('footer-widgets')) : ?>
        <div class="footer-widgets py-8" style="background: #1e293b;">
            <div class="container">
                <?php dynamic_sidebar('footer-widgets'); ?>
            </div>
        </div>
    <?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>