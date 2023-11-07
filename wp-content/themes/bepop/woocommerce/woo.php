<?php

function woo_theme_setup() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woo_theme_setup' );

function woo_theme_wrapper_start() {
    echo '<div class="woocommerce container">';
}
function woo_theme_wrapper_end() {
    echo '</div>';
}
add_action('woocommerce_before_main_content', 'woo_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'woo_theme_wrapper_end', 10);

// enqueue the woocommerce js/css for ajax
function woo_styles() {
	wp_enqueue_style( 'bepop-woocommerce-css', get_template_directory_uri().'/woocommerce/woo.css', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'woo_styles');

// disable the lightbox
function woo_scripts(){
	wp_enqueue_script( 'wc-single-product' );
	wp_enqueue_script( 'wc-add-to-cart-variation' );
	wp_enqueue_script( 'zoom' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'bepop-woocommerce', get_template_directory_uri().'/woocommerce/woo.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'woo_scripts' );

function woo_support(){
	remove_theme_support( 'wc-product-gallery-lightbox' );
	//remove_theme_support( 'wc-product-gallery-zoom' );
	//remove_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'template_redirect', 'woo_support', 100 );

// set the gallery thunbnail size
add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
	return array( '600', '600' );
}, 100 );

// remove sidebar for woocommerce pages 
add_action( 'get_header', 'woo_remove_storefront_sidebar' );
function woo_remove_storefront_sidebar() {
    if ( is_shop() ) {
        remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
    }
}

// change add to cart text
add_filter('woocommerce_product_add_to_cart_text', 'woo_add_to_cart_text', 999);
function woo_add_to_cart_text ($text) {
	global $product;
	$product_type = $product->get_type();
	if( $product_type == 'digital' ){
		$text = esc_html( 'Buy', 'Bepop' );
	}
	return $text;
}

// add gutenberg to woocommerce
function woo_product_taxonomy_show_in_rest( $args ) {
	$args['show_in_rest'] = true;
	return $args;
}

add_filter( 'woocommerce_taxonomy_args_product_cat', 'woo_product_taxonomy_show_in_rest');
add_filter( 'woocommerce_taxonomy_args_product_tag', 'woo_product_taxonomy_show_in_rest');

call_user_func_array(
    sprintf('remove%sfilter', '_'),
    array( 'gutenberg_can_edit_post_type', 'WC_Post_Types::gutenberg_can_edit_post_type', 10 )
);

call_user_func_array(
    sprintf('remove%sfilter', '_'),
    array( 'use_block_editor_for_post_type', 'WC_Post_Types::gutenberg_can_edit_post_type', 10 )
);

function woo_admin_scripts(){
	wp_enqueue_script( 'bepop-woocommerce-admin', get_template_directory_uri().'/woocommerce/woo.admin.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'admin_enqueue_scripts', 'woo_admin_scripts' );

// notice
add_action( 'play_single_header_end', 'woocommerce_output_all_notices', 10 );
