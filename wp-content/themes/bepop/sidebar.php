<?php
/**
 * Sidebar
 */

defined( 'ABSPATH' ) || exit;

if( is_singular() && empty(get_option( 'page_sidebar' )) && empty( get_post_meta( get_the_ID(), 'sidebar', true )) ){
	return;
}
?>

<div class="sidebar">
	<div class="sticky-top">
	<?php
	$id = get_option( 'page_sidebar' );

	if( is_singular() ){
		$sidebar = get_post_meta( get_the_ID(), 'sidebar', true );
		if($sidebar) $id = $sidebar;
	}

	if ( $id ){
		$content = get_the_content('','', $id); 
		echo apply_filters( 'the_content', $content );
	}
	?>
	</div>
</div>
