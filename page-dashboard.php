<?php /* Template Name: Dashboard */ ?>
<?php get_header(); ?>

<h2>Dashboard</h2>
<div id="dash-portfolio"></div>
<div id="dash-watchlist"></div>
<div id="dash-market"></div>
<div id="dash-news"></div>

<script>
(function(){
	function ajax(action){
		var data = new FormData();
		data.append('action', action);
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		return fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: data }).then(function(r){ return r.json(); });
	}
	function render(el, title, data){ document.getElementById(el).innerHTML = '<h3>'+title+'</h3><pre>'+JSON.stringify(data, null, 2)+'</pre>'; }
	ajax('get_formatted_portfolio_data').then(function(data){ render('dash-portfolio','Portfolio', data); });
	ajax('get_formatted_watchlist_data').then(function(data){ render('dash-watchlist','Watchlist', data); });
	fetch('<?php echo esc_url_raw( home_url('/wp-json/stock-scanner/v1/market-data') ); ?>').then(r=>r.json()).then(d=>render('dash-market','Market', d));
	fetch('<?php echo esc_url_raw( home_url('/wp-json/stock-scanner/v1/news?limit=5') ); ?>').then(r=>r.json()).then(d=>render('dash-news','News', d));
})();
</script>

<?php get_footer(); ?>