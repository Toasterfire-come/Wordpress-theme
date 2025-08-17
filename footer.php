<?php
/**
 * The template for displaying the footer
 */
?>

    <footer id="colophon" class="site-footer" style="background: #0f172a; color: #cbd5e1; margin-top: auto;">
        <div class="container">
            <div style="padding: 3rem 0 1.5rem;">
                <!-- Footer Content -->
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem; margin-bottom: 2rem;">
                    <!-- Brand Section -->
                    <div>
                        <a href="<?php echo esc_url(home_url('/')); ?>" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: white; margin-bottom: 1rem;">
                            <div style="width: 32px; height: 32px; background: #059669; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white;">
                                <span>📊</span>
                            </div>
                            <div>
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;"><?php bloginfo('name'); ?></h3>
                                <p style="font-size: 0.875rem; color: #94a3b8; margin: 0;">Professional Trading Platform</p>
                            </div>
                        </a>
                        <p style="color: #94a3b8; font-size: 0.875rem; line-height: 1.6; margin-bottom: 1rem;">
                            Professional-grade stock analysis platform with real-time data updates sub three minutes. 
                            Built for traders who demand accuracy and performance.
                        </p>
                        <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #94a3b8;">
                            <span>📞 +1 (555) 123-4567</span>
                            <span>✉️ support@stockscannerpro.com</span>
                        </div>
                    </div>

                    <!-- Quick Links -->
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
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('portfolio'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Portfolio</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('watchlist'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Watchlist</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Market News</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 style="color: white; font-weight: 600; margin-bottom: 1rem; font-size: 1rem;">Support</h4>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Pricing Plans</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('faq'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">FAQ</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Contact Us</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('status'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">System Status</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" 
                                   style="color: #94a3b8; text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease;"
                                   onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">About Us</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div style="border-top: 1px solid #334155; padding-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="text-align: center; color: #64748b; font-size: 0.875rem;">
                            <p style="margin: 0;">© <?php echo date('Y'); ?> Stock Scanner Pro. All rights reserved.</p>
                        </div>
                        <div style="display: flex; gap: 2rem; font-size: 0.875rem;">
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" 
                               style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;"
                               onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Terms</a>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy'))); ?>" 
                               style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;"
                               onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">Privacy</a>
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