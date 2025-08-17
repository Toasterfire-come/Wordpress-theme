<?php
/**
 * Theme Header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class('no-sidebar'); ?>>
	<?php wp_body_open(); ?>
	<div class="app-container">
		<div class="main-content-area">
			<header class="site-header">
				<div class="header-content">
					<div class="header-main">
						<div class="header-left">
							<a href="<?php echo home_url('/'); ?>" class="logo">
								<div class="logo-icon">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
										<polyline points="17 6 23 6 23 12"/>
									</svg>
								</div>
								<div class="logo-text">
									<h1>StockScan Pro</h1>
									<p>Professional Stock Analysis</p>
								</div>
							</a>
						</div>
						<div class="header-actions">
							<div class="market-status">
								<div class="market-label">S&P 500</div>
								<div class="market-value">
									<span style="color: var(--emerald-400); font-weight: 500; font-size: 0.875rem;">+0.52%</span>
									<span class="live-badge">LIVE</span>
								</div>
							</div>
						</div>
					</div>
					<nav class="full-nav">
						<ul class="nav-list">
							<li class="nav-item"><a href="<?php echo home_url('/dashboard'); ?>">Dashboard</a></li>
							<li class="nav-item"><a href="<?php echo home_url('/market-overview'); ?>">Markets</a></li>
							<li class="nav-item"><a href="<?php echo home_url('/stock-scanner'); ?>">Scanner</a></li>
							<li class="nav-item"><a href="<?php echo home_url('/watchlist'); ?>">Watchlist</a></li>
							<li class="nav-item"><a href="<?php echo home_url('/news'); ?>">News</a></li>
						</ul>
					</nav>
				</div>
			</header>
			<main class="main-content">
				<div class="page-content">