<?php /* Template Name: Market Overview Page */ ?>
<?php get_header(); ?>

<h2>Market Overview</h2>
<div id="indices" class="card"></div>
<div id="movers" class="card"></div>
<div id="losers" class="card"></div>

<script>
(function(){
	function ajax(action, payload){
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		Object.keys(payload||{}).forEach(function(k){ data.append(k, payload[k]); });
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}
	function render(el, title, data){
		document.getElementById(el).innerHTML = '<h3>'+title+'</h3><pre>'+JSON.stringify(data, null, 2)+'</pre>';
	}
	ajax('get_major_indices').then(function(resp){ render('indices','Major Indices', resp); });
	ajax('get_market_movers', { category: 'gainers' }).then(function(resp){ render('movers','Top Gainers', resp); });
	fetch('<?php echo home_url('/api/stocks/?category=losers&limit=10&sort_by=change_percent&sort_order=asc'); ?>')
		.then(function(r){ return r.json(); })
		.then(function(resp){ render('losers','Top Losers (Direct Django)', resp); });
})();
</script>

<?php get_footer(); ?>