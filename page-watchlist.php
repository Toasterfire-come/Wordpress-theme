<?php /* Template Name: Watchlist */ ?>
<?php get_header(); ?>

<h2>Watchlist</h2>
<form id="add-form">
	<input type="text" id="symbol" class="form-control" placeholder="Add symbol" required />
	<button class="btn" type="submit">Add</button>
</form>
<div id="watchlist-data"></div>

<script>
(function(){
	function ajax(action, payload){
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		Object.keys(payload||{}).forEach(function(k){ data.append(k, payload[k]); });
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}
	function load(){ ajax('get_formatted_watchlist_data').then(function(resp){ document.getElementById('watchlist-data').innerHTML = '<pre>'+JSON.stringify(resp, null, 2)+'</pre>'; }); }
	document.getElementById('add-form').addEventListener('submit', function(e){ e.preventDefault(); ajax('add_to_watchlist', { symbol: document.getElementById('symbol').value }).then(load); });
	load();
})();
</script>

<?php
$server = make_backend_api_request('watchlist/list');
echo '<h3>Server-side Watchlist</h3><pre>' . esc_html(json_encode($server, JSON_PRETTY_PRINT)) . '</pre>';
?>

<?php get_footer(); ?>