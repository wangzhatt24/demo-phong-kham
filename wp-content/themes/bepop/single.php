<?php
/**
 * The template for displaying all single posts
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'templates/content/content', 'single' );

				if ( is_singular( 'post' ) ) {
					// Previous/next post navigation.
					the_post_navigation(
						array(
							'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next Post', 'bepop' ) . '</span> ' .
								'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'bepop' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous Post', 'bepop' ) . '</span> ' .
								'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'bepop' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
						)
					);
				}

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
