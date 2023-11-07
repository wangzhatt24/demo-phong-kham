<?php
/**
 * Template Name: Template::Sidebar
 * Template Post Type: post, page, product
*/

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-header-container">
					<header class="entry-header">
						<?php 
						the_title( '<h1 class="entry-title">', '</h1>' );
						
						ffl_entry_header();
						?>
					</header>
					<?php ffl_post_thumbnail(); ?>
				</div>
				
				<?php ffl_the_page_navigation(); ?>
				<div class="entry-content">
					<div class="entry-content-wrap">
						<div class="entry-content-inner">
							<?php
							the_content();

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bepop' ),
									'after'  => '</div>',
								)
							);

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}

							?>
						</div>
						<?php
							get_template_part( 'sidebar' );
						?>
					</div>
				</div>
			</article>
			<?php
			endwhile; // End of the loop.
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
