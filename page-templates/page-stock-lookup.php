<?php /* Template Name: Stock Lookup Page */ ?>
<?php get_header(); ?>

<h2>Stock Lookup</h2>
<form id="lookup-form">
	<input type="text" id="lookup-symbol" class="form-control" placeholder="Enter symbol (e.g., AAPL)" required />
	<button type="submit" class="btn">Get Quote</button>
</form>
<div id="quote"></div>
<div id="usage"></div>

<script>
(function(){
	function ajax(action, payload){
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		Object.keys(payload||{}).forEach(function(k){ data.append(k, payload[k]); });
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}
	document.getElementById('lookup-form').addEventListener('submit', function(e){
		e.preventDefault();
		var s = document.getElementById('lookup-symbol').value;
		ajax('stock_scanner_get_quote', { symbol: s }).then(function(resp){
			document.getElementById('quote').innerHTML = '<h3>Quote</h3><pre>'+JSON.stringify(resp, null, 2)+'</pre>';
			return ajax('get_usage_stats');
		}).then(function(usage){
			document.getElementById('usage').innerHTML = '<h3>Usage Stats</h3><pre>'+JSON.stringify(usage, null, 2)+'</pre>';
		});
	});
})();
</script>

<?php get_footer(); ?>