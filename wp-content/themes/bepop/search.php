<?php
/**
 * The template for displaying search results pages
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			
			<div class="container clear">
				<h1 class="page-title"><?php printf( esc_html__( 'Search results for: %s', 'bepop' ), '<strong>' . get_search_query() . '</strong>' ); ?></h1>
			</div>

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				$type = get_post_type();
				if( $type == 'station' || $type == 'product' ){
					get_template_part( 'templates/content/content', 'search-station' );
				}else{
					get_template_part( 'templates/content/content', 'search' );
				}

				// End the loop.
			endwhile;

			ffl_the_posts_navigation();

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'templates/content/content', 'none' );

		endif;
		?>
		</main>
	</div>

<?php
get_footer();
