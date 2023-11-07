<?php
/**
 * Template part for displaying a message that posts cannot be found
 */

?>

<article class="no-results not-found">
	<header class="entry-header">
		<h1><?php esc_html_e( 'Nothing Found', 'bepop' ); ?></h1>
	</header><!-- .page-header -->

	<div class="entry-content">
		<?php
		if ( is_search() ) :
			?>

			<p>
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'bepop' ); ?>
			</p>
			
			<?php
			get_search_form();

		else :
			?>

			<p>
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bepop' ); ?>
			</p>

			<?php
			get_search_form();

		endif;
		?>
		<p></p>
	</div>
</article>
