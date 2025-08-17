<?php
/**
 * Main Template File
 *
 * @package StockScan Pro
 */

get_header();
?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( is_singular() ) : ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php endif; ?>
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>
		</article>
	<?php endwhile; ?>

	<?php if ( ! is_singular() ) : ?>
		<?php the_posts_pagination(); ?>
	<?php endif; ?>
<?php else : ?>
	<p><?php esc_html_e( 'Nothing found.', 'stockscan' ); ?></p>
<?php endif; ?>

<?php
get_footer();