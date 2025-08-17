<?php /* Template Name: User Settings Page */ ?>
<?php get_header(); ?>

<h2>User Settings</h2>
<form id="settings-form">
	<label><input type="checkbox" id="notifications" /> Enable notifications</label><br />
	<label><input type="checkbox" id="email_reports" /> Email reports</label><br />
	<button class="btn" type="submit">Save Settings</button>
</form>

<script>
(function(){
	document.getElementById('settings-form').addEventListener('submit', function(e){
		e.preventDefault();
		var data = new FormData();
		data.append('action', 'stockscan_update_settings');
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		data.append('notifications', document.getElementById('notifications').checked ? '1' : '0');
		data.append('email_reports', document.getElementById('email_reports').checked ? '1' : '0');
		fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(r=>r.json()).then(function(){ alert('Settings saved'); });
	});
})();
</script>

<?php get_footer(); ?>