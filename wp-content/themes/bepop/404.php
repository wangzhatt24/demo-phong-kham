<?php
/**
 * The template for displaying archive pages
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
				<div class="error-404 not-found">
					<header>
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bepop' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p>
							<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'bepop' ); ?>
						</p>
						<?php get_search_form(); ?>
						<p>
							<a class="button button-rounded button-light" href="<?php echo esc_url( home_url() ); ?>"><?php echo ffl_get_icon_svg( 'chevron-left', 16 ); ?><?php esc_html_e( 'Back to homepage', 'bepop' ); ?></a>
						</p>
					</div><!-- .page-content -->
				</div><!-- .error-404 -->
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
