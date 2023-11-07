<?php

// process title
function ffl_title($string){
    $arr = preg_split('/ +/', $string);
    return implode(' ', array_slice($arr, 0, ceil( count($arr)/2 ))).' <span>'.implode(' ', array_slice($arr, ceil( count($arr)/2 ), count($arr)) ).'</span>';
}

// get post thumbnail
function ffl_get_post_thumbnail($post_id, $size = 'thumbnail', $src = true){
    $img = '';
    if(!$src){
        return the_post_thumbnail();
    }
    $thumbnail_id = get_post_thumbnail_id( $post_id );
    if( !empty( $thumbnail_id ) ){
        $img = wp_get_attachment_image_url( $thumbnail_id, $size );
    }else{
        $img = get_post_meta($post_id, 'cover', true);
    }
    return $img;
}

// add icon to menu
function ffl_nav_menu_items( $items ) {
    foreach ( $items as $key => $item ) {
        if( strpos($item->attr_title, '?') !== false ){
            $item->url .= $item->attr_title;
            $item->attr_title = '';
        }
        foreach ($item->classes as $key => $value) {
          if(strpos($value, 'icon-') !== false){
            $icon = str_replace('icon-', '', $value);
            $item->title = ffl_get_icon_svg($icon).'<span>'.$item->title.'</span>';
            break;
          }
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'ffl_nav_menu_items' );

function ffl_contains($str, array $arr) {
    foreach($arr as $a) {
        if (stripos($str, $a) !== false) return true;
    }
    return false;
}

function ffl_get_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_archive() ) {
        $title = post_type_archive_title( '', false );
    }elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>' ;
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'ffl_get_archive_title');

// can show post thumbnail
function ffl_can_show_post_thumbnail() {
    $show = true;
    if( is_singular( 'product' ) ){
        $show = apply_filters('is_playable', get_the_ID());
    }
    return apply_filters( 'ffl_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() && $show );
}
