<?php /* Template Name: Payment Cancelled */ ?>
<?php get_header(); ?>

<h2>Payment Cancelled</h2>
<p>Your payment was cancelled. Below are common Cancellation Reasons and options to try again.</p>

<section>
	<h3>Cancellation Reasons</h3>
	<ul>
		<li>Payment method declined</li>
		<li>Network issue</li>
		<li>Changed your mind</li>
	</ul>
</section>

<section>
	<h3>Try Again</h3>
	<p>You can retry the payment process.</p>
	<a class="btn" href="<?php echo home_url('/paypal-checkout'); ?>">Retry Payment</a>
</section>

<section>
	<h3>Feedback</h3>
	<form id="cancellation-feedback-form">
		<div class="form-group">
			<label for="cancel_reason">Tell us more</label>
			<textarea id="cancel_reason" name="reason" class="form-control" rows="4"></textarea>
		</div>
		<button class="btn" type="submit">Submit Feedback</button>
	</form>
</section>

<section>
	<h3>Special Offer</h3>
	<p>Subscribe to our newsletter for updates and special offers.</p>
	<form id="newsletter-form">
		<div class="form-group">
			<input type="email" id="newsletter_email" class="form-control" placeholder="Email" required />
		</div>
		<button class="btn" type="submit">Subscribe</button>
	</form>
</section>

<script>
(function() {
	function ajax(action, payload) {
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		Object.keys(payload || {}).forEach(function(k){ data.append(k, payload[k]); });
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}
	document.getElementById('cancellation-feedback-form').addEventListener('submit', function(e){
		e.preventDefault();
		ajax('submit_contact_form', { message: document.getElementById('cancel_reason').value }).then(function(){ alert('Thank you for your feedback'); });
	});
	document.getElementById('newsletter-form').addEventListener('submit', function(e){
		e.preventDefault();
		ajax('subscribe_newsletter', { email: document.getElementById('newsletter_email').value }).then(function(){ alert('Subscribed'); });
	});
})();
</script>

<?php get_footer(); ?>