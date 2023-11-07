<?php
/**
 * Custom template tags for this theme
 */

if ( ! function_exists( 'ffl_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ffl_posted_on($icon = true) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			$icon ? ffl_get_icon_svg( 'clock', 16 ) : '',
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

if ( ! function_exists( 'ffl_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function ffl_posted_by($avatar = true) {
		printf(
			/* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */
			'<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			$avatar ? '<span class="svg-icon">'.get_avatar(get_the_author_meta( 'ID' ), 48).'</span>' : '',
			esc_html__( 'Posted by', 'bepop' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'ffl_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function ffl_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo ffl_get_icon_svg( 'message-square', 16 );

			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'bepop' ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'ffl_tags_list' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ffl_tags_list() {
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'bepop' ) );
		if ( $tags_list ) {
			printf(
				/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
				'<span class="tags-links">%1$s<span class="screen-reader-text">%2$s </span>%3$s</span>',
				ffl_get_icon_svg( 'tag', 16 ),
				esc_html__( 'Tags:', 'bepop' ),
				$tags_list
			); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'ffl_categories_list' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ffl_categories_list() {
		$categories_list = get_the_category_list( esc_html__( ', ', 'bepop' ) );
		if ( $categories_list ) {
			printf(
				/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
				'<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
				ffl_get_icon_svg( 'archive', 16 ),
				esc_html__( 'Posted in', 'bepop' ),
				$categories_list
			); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'ffl_entry_header' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ffl_entry_header() {
		if ( 'page' === get_post_type() ) return;
		echo '<div class="entry-meta">';
		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			// Posted by
			ffl_posted_by();

			// Posted on
			ffl_posted_on();

			// categories
			ffl_categories_list();

			// categories
			ffl_tags_list();
		}

		// Comment count.
		if ( is_singular() ) {
			ffl_comment_count();
		}

		echo '</div>';
	}
endif;

if ( ! function_exists( 'ffl_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ffl_entry_footer() {
		// Edit post link.
		edit_post_link(
			sprintf('<span class="edit-link">%s</span>',
				esc_html__( 'Edit', 'bepop' )
			)
		);
	}
endif;

if ( ! function_exists( 'ffl_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function ffl_post_thumbnail() {
		if ( ! ffl_can_show_post_thumbnail() ) {
			return;
		}

		$thumbnail_pos_y = get_post_meta(get_the_ID(), 'thumbnail_pos_y', true);
		$attr = array( 'style' => 'object-position: 50% '. $thumbnail_pos_y .'%', 'data-pos-y' => $thumbnail_pos_y);
		if ( is_singular() && !is_page() ) :
			?>

			<figure class="post-thumbnail">
				<?php the_post_thumbnail( 'full', $attr ); ?>
			</figure><!-- .post-thumbnail -->

			<?php
		else :
			?>

		<figure class="post-thumbnail">
			<a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( 'post-thumbnail', $attr ); ?>
			</a>
		</figure>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'ffl_the_posts_navigation' ) ) :
	/**
	 * Documentation for function.
	 */
	function ffl_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					ffl_get_icon_svg( 'chevron-left', 22 ),
					esc_html__( 'Newer posts', 'bepop' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					esc_html__( 'Older posts', 'bepop' ),
					ffl_get_icon_svg( 'chevron-right', 22 )
				),
			)
		);
	}
endif;

if ( ! function_exists( 'ffl_the_page_navigation' ) ) :
	/**
	 * Documentation for function.
	 */
	function ffl_the_page_navigation() {
		global $post;
		$children = null;
		if(ffl_contains($post->post_title, array('level','page','test','float','membership'))){
			return;
		}
		if ( $post->post_parent && $post->post_parent > 0 ) {
		    $children = wp_list_pages( array(
		        'title_li' => '',
		        'child_of' => $post->post_parent,
		        'echo'     => 0
		    ) );
		} elseif($post->ID > 0) {
		    $children = wp_list_pages( array(
		        'title_li' => '',
		        'child_of' => $post->ID,
		        'echo'     => 0
		    ) );
		};
		
		if ( $children ) : ?>
		<nav id="page-navigation" class="navigation page-navigation">
			 <?php printf( '<ul class="nav">%s</ul>', $children); ?>
		</nav>
		<?php endif;
	}
endif;

if ( ! function_exists( 'ffl_posted_sticky' ) ) :
	function ffl_posted_sticky() {
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'bepop' ) );
		}
	}
endif;

if ( ! function_exists( 'ffl_link_pages' ) ) :
	function ffl_link_pages() {
		wp_link_pages(
			array(
				'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'bepop' ) . '</span>',
				'after'  => '</div>',
			)
		);
	}
endif;
