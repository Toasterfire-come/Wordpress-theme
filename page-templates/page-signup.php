<?php /* Template Name: User Signup Page */ ?>
<?php get_header(); ?>

<h2>Sign Up</h2>
<form id="signup-form">
	<div class="form-group">
		<label for="signup_email">Email</label>
		<input id="signup_email" type="email" class="form-control" required />
	</div>
	<div class="form-group">
		<label for="signup_password">Password</label>
		<input id="signup_password" type="password" class="form-control" required />
	</div>
	<button class="btn" type="submit">Create Account</button>
</form>

<script>
(function(){
	document.getElementById('signup-form').addEventListener('submit', function(e){
		e.preventDefault();
		var data = new FormData();
		data.append('action', 'stock_scanner_register_user');
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		data.append('email', document.getElementById('signup_email').value);
		data.append('password', document.getElementById('signup_password').value);
		fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(r=>r.json()).then(function(resp){ alert('Signup submitted'); });
	});
})();
</script>

<?php get_footer(); ?>