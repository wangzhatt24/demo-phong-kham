<?php
/**
 * Displays the footer 
 */

$id = get_option( 'page_footer' );
if( !$id ){ 
	get_template_part( 'templates/footer/site-footer', 'default' );
	return;
}

if( is_singular() ){
	$footer = get_post_meta( get_the_ID(), 'footer', true );
	if($footer) $id = $footer;
}

$content = get_the_content('','', $id);
if ( is_attachment() ) {
	call_user_func_array(
	    sprintf('the%scontent', '_'),
	    array('prepend_attachment')
	);
}
echo apply_filters( 'the_content', $content );
