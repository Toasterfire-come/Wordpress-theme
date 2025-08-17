<?php /* Template Name: Stock News Page */ ?>
<?php get_header(); ?>

<h2>Stock News</h2>
<div id="rest-news"></div>
<div id="php-news"></div>

<script>
(function(){
	fetch('<?php echo esc_url_raw( home_url('/wp-json/stock-scanner/v1/news') ); ?>')
		.then(function(r){ return r.json(); })
		.then(function(resp){ document.getElementById('rest-news').innerHTML = '<h3>REST News</h3><pre>'+JSON.stringify(resp, null, 2)+'</pre>'; });
})();
</script>

<?php
$php_news = make_backend_api_request('news/feed?limit=10');
echo '<h3>PHP News</h3><pre>' . esc_html(json_encode($php_news, JSON_PRETTY_PRINT)) . '</pre>';
?>

<?php get_footer(); ?>