<?php /* Template Name: Portfolio Management */ ?>
<?php get_header(); ?>

<h2>Portfolio Management</h2>
<div id="portfolio-data"></div>
<div id="server-side-portfolio"></div>

<script>
(function(){
	function ajax(action){
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}
	ajax('get_formatted_portfolio_data').then(function(resp){
		document.getElementById('portfolio-data').innerHTML = '<h3>Client AJAX Portfolio</h3><pre>'+JSON.stringify(resp, null, 2)+'</pre>';
	});
})();
</script>

<?php
// Server-side PHP fetch example
$resp = make_backend_api_request('portfolio/list');
echo '<h3>Server-side Portfolio</h3><pre>' . esc_html(json_encode($resp, JSON_PRETTY_PRINT)) . '</pre>';
?>

<?php get_footer(); ?>