<?php /* Template Name: PayPal Checkout */ ?>
<?php get_header(); ?>

<h2>PayPal Checkout</h2>
<p>Select your plan and complete payment securely with PayPal.</p>

<section>
	<h3>Plan Selection</h3>
	<div>
		<label><input type="radio" name="plan" value="basic" checked /> Basic - $9/mo</label><br />
		<label><input type="radio" name="plan" value="pro" /> Pro - $29/mo</label><br />
		<label><input type="radio" name="plan" value="enterprise" /> Enterprise - $99/mo</label>
	</div>
</section>

<section>
	<h3>Order Summary</h3>
	<div id="order-summary">No order created yet.</div>
</section>

<section>
	<h3>Promo Code</h3>
	<div class="form-group">
		<input type="text" id="promo_code" class="form-control" placeholder="Enter promo code" />
	</div>
</section>

<section>
	<h3>Billing Information</h3>
	<form id="billing-form">
		<div class="form-group">
			<label for="billing_email">Email</label>
			<input id="billing_email" class="form-control" type="email" required />
		</div>
		<button type="submit" class="btn">Save Billing Info</button>
	</form>
</section>

<div id="paypal-button-container"></div>

<script>
(function() {
	function ajax(action, payload) {
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		Object.keys(payload || {}).forEach(function(k){ data.append(k, payload[k]); });
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}

	// Create order button (mock PayPal render)
	var btn = document.createElement('button');
	btn.className = 'btn';
	btn.textContent = 'Pay with PayPal';
	btn.addEventListener('click', function(e){
		e.preventDefault();
		var plan = document.querySelector('input[name=plan]:checked').value;
		ajax('create_paypal_order', { plan: plan }).then(function(resp){
			document.getElementById('order-summary').textContent = 'Order created: ' + JSON.stringify(resp);
			return ajax('capture_paypal_order', { orderID: (resp && resp.data && resp.data.id) || 'TEST123' });
		}).then(function(capture){
			alert('Order captured');
			window.location.href = '<?php echo home_url('/payment-success'); ?>';
		}).catch(function(){ alert('Payment failed'); });
	});
	document.getElementById('paypal-button-container').appendChild(btn);

	var subBtn = document.createElement('button');
	subBtn.className = 'btn secondary';
	subBtn.textContent = 'Subscribe with PayPal';
	subBtn.addEventListener('click', function(e){
		e.preventDefault();
		var plan = document.querySelector('input[name=plan]:checked').value;
		ajax('create_paypal_subscription', { planID: plan.toUpperCase() + '_PLAN' }).then(function(resp){
			alert('Subscription created');
		});
	});
	document.getElementById('paypal-button-container').appendChild(subBtn);
})();
</script>

<?php get_footer(); ?>