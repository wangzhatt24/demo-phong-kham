<?php
/**
 * Template part for displaying page content in page.php
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header-container">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
		<?php ffl_post_thumbnail(); ?>
	</div>
	
	<?php ffl_the_page_navigation(); ?>

	<div class="entry-content">
		<?php
		the_content();

		ffl_link_pages();
		?>
	</div>
</article>
