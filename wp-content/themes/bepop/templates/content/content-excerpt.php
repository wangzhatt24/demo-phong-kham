<?php
/**
 * Template part for displaying post archives and search results
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		ffl_posted_sticky();
		
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		
		ffl_entry_header();
		?>
	</header>

	<?php ffl_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php ffl_entry_footer(); ?>
	</footer>
</article>
