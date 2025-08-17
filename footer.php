				</div>
			</main>
		</div>
	</div>
	<footer class="site-footer">
		<div class="footer-content">
			<div class="footer-grid">
				<div>
					<a href="<?php echo home_url('/'); ?>" class="footer-brand">
						<div class="footer-brand-icon">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
								<polyline points="17 6 23 6 23 12"/>
							</svg>
						</div>
						<div class="footer-brand-text">
							<h3>StockScan Pro</h3>
							<p>Professional Stock Analysis</p>
						</div>
					</a>
					<p class="footer-description">
						Advanced stock scanning and market analysis tools for professional traders and investors.
					</p>
				</div>
				<div class="footer-section">
					<h4>Quick Links</h4>
					<?php if ( has_nav_menu('footer') ) : ?>
						<?php wp_nav_menu([
							'theme_location' => 'footer',
							'container' => false,
							'menu_class' => 'footer-links',
							'fallback_cb' => false,
						]); ?>
					<?php else : ?>
						<ul class="footer-links">
							<li><a href="<?php echo home_url('/dashboard'); ?>">Dashboard</a></li>
							<li><a href="<?php echo home_url('/stock-scanner'); ?>">Stock Scanner</a></li>
							<li><a href="<?php echo home_url('/market-overview'); ?>">Market Overview</a></li>
							<li><a href="<?php echo home_url('/watchlist'); ?>">Watchlist</a></li>
							<li><a href="<?php echo home_url('/news'); ?>">Market News</a></li>
						</ul>
					<?php endif; ?>
				</div>
				<div class="footer-section">
					<h4>Legal</h4>
					<ul class="footer-links">
						<li><a href="<?php echo home_url('/terms'); ?>">Terms of Service</a></li>
						<li><a href="<?php echo home_url('/privacy'); ?>">Privacy Policy</a></li>
						<li><a href="<?php echo home_url('/security'); ?>">Security</a></li>
						<li><a href="<?php echo home_url('/accessibility'); ?>">Accessibility</a></li>
						<li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
					</ul>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="footer-copyright">
					© <?php echo date('Y'); ?> StockScan Pro. All rights reserved. Market data provided by third-party sources.
				</div>
			</div>
		</div>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>