<?php /* Template Name: My Account */ ?>
<?php get_header(); ?>

<h2>My Account</h2>
<form id="account-form">
	<input type="text" id="account_name" class="form-control" placeholder="Name" />
	<input type="text" id="account_timezone" class="form-control" placeholder="Timezone" />
	<button class="btn" type="submit">Save</button>
</form>

<script>
(function(){
	document.getElementById('account-form').addEventListener('submit', function(e){
		e.preventDefault();
		var data = new FormData();
		data.append('action', 'stockscan_update_account');
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		data.append('name', document.getElementById('account_name').value);
		data.append('timezone', document.getElementById('account_timezone').value);
		fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(r=>r.json()).then(function(){ alert('Saved'); });
	});
})();
</script>

<?php get_footer(); ?>