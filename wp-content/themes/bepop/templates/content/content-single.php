<?php
/**
 * Template part for displaying posts
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header-container">
		<header class="entry-header">
			<?php 
			ffl_posted_sticky();
			
			if ( is_page() ) :
				the_title( '<h2 class="entry-title h1">', '</h2>' );
			else :
				the_title( '<h1 class="entry-title">', '</h1>' );
			endif;
			
			ffl_entry_header();
			?>
		</header>
		<?php ffl_post_thumbnail(); ?>
	</div>

	<div class="entry-content">
		<?php
		the_content(
			esc_html__( 'Continue reading', 'bepop' )
		);

		ffl_link_pages();
		?>
	</div>
	<footer class="entry-footer">
		<?php ffl_entry_footer(); ?>
	</footer>
</article>
