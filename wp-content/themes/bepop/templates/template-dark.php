<?php
/**
 * Template Name: Template::Dark
 * Template Post Type: post, page, product
*/

function ffl_single_body_class($classes) {
	$classes = array_diff( $classes, array('layout-app') );
    $classes[] = 'dark';
    return $classes;
}
add_filter('body_class', 'ffl_single_body_class');

get_template_part( 'templates/template' );
