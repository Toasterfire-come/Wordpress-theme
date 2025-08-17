<?php /* Template Name: Stock Screener */ ?>
<?php get_header(); ?>

<h2>Stock Screener</h2>
<p>Results below are fetched server-side from Django screening APIs.</p>

<?php
$results = make_backend_api_request('stocks/screener?min_volume=1000000&sector=Technology');
echo '<pre>' . esc_html(json_encode($results, JSON_PRETTY_PRINT)) . '</pre>';
?>

<?php get_footer(); ?>