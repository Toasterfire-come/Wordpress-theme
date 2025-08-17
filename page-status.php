<?php /* Template Name: System Status */ ?>
<?php get_header(); ?>

<h2>System Status</h2>
<ul>
	<li><a href="<?php echo home_url('/endpoint-status/'); ?>">Django Endpoint Status</a></li>
	<li><a href="<?php echo home_url('/api/health/'); ?>">API Health</a></li>
</ul>

<div id="health"></div>

<script>
(function(){
	fetch('<?php echo home_url('/api/health/'); ?>').then(function(r){ return r.json(); }).then(function(resp){
		document.getElementById('health').innerHTML = '<h3>Health</h3><pre>'+JSON.stringify(resp, null, 2)+'</pre>';
	});
})();
</script>

<?php get_footer(); ?>