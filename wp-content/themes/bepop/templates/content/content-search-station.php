<?php
/**
 * Template part for displaying loop
 */

?>
<div class="container">
<div class="block-loop-row">
	<div class="block-loop-items">
<article data-id="post-<?php the_ID(); ?>" data-play-id="<?php the_ID(); ?>" <?php post_class('block-loop-item'); ?>>
	<figure class="post-thumbnail">
		<a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'post-thumbnail' ); ?>
		</a>
		<div class="entry-action">
			<?php do_action( 'the_like_button', get_the_ID() ); ?>
			<?php do_action( 'the_play_button', get_the_ID() ); ?>
			<?php do_action( 'the_more_button', get_the_ID() ); ?>
		</div>
	</figure>

	<header class="entry-header">
		<div class="entry-header-inner">
			<?php
				the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			?>
			<div class="entry-meta">
				<?php do_action( 'the_loop_author', get_the_ID() ); ?>
			</div>
		</div>
		<footer class="entry-footer">
			<?php
				if(isset($query_args['meta_key']) && strpos( $query_args['meta_key'], 'post-count' ) !== false ){
					echo apply_filters( 'play_count', get_the_ID(), $query_args['meta_key'] ); 
				}else{
					do_action( 'the_like_button', get_the_ID() );
					do_action( 'the_download_button', get_the_ID() );
				}
			?>
			<?php do_action( 'the_more_button', get_the_ID() ); ?>
		</footer>
	</header>
</article>
</div>
</div>
</div>
