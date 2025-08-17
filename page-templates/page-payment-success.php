<?php /* Template Name: Payment Success */ ?>
<?php get_header(); ?>

<h2>Order Confirmation</h2>
<p>Thank you for your purchase! Your payment was successful.</p>

<section>
	<h3>Receipt</h3>
	<p>A receipt has been sent to your email. You can also download it from your account page.</p>
</section>

<section>
	<h3>Getting Started</h3>
	<ol>
		<li>Visit your <a href="<?php echo home_url('/dashboard'); ?>">Dashboard</a></li>
		<li>Add symbols to your <a href="<?php echo home_url('/watchlist'); ?>">Watchlist</a></li>
		<li>Explore <a href="<?php echo home_url('/market-overview'); ?>">Market Overview</a></li>
	</ol>
</section>

<section>
	<h3>Social Sharing</h3>
	<p>Share your success on social media!</p>
</section>

<?php get_footer(); ?>