<?php /* Template Name: Enhanced Watchlist */ ?>
<?php get_header(); ?>

<h2>Enhanced Watchlist</h2>
<div>
	<input type="text" id="ew-symbol" class="form-control" placeholder="Symbol" />
	<button class="btn" id="ew-add">Add to Watchlist</button>
</div>
<div id="ew-list"></div>

<script>
(function(){
	function ajax(action, payload){
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		Object.keys(payload||{}).forEach(function(k){ data.append(k, payload[k]); });
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}
	function load(){ ajax('get_formatted_watchlist_data').then(function(resp){ document.getElementById('ew-list').innerHTML = '<pre>'+JSON.stringify(resp, null, 2)+'</pre>'; }); }
	document.getElementById('ew-add').addEventListener('click', function(){ ajax('add_to_watchlist', { symbol: document.getElementById('ew-symbol').value }).then(load); });
	load();
})();
</script>

<?php get_footer(); ?>