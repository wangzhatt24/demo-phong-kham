<?php

// add theme class on body
function ffl_body_class($classes){
    $classes[] = get_option('site_layout');
    $classes[] = get_option('site_theme');
    if( (is_singular() && ffl_can_show_post_thumbnail()) || is_author() || is_page_template('author.php') ){
        $classes[] = 'featured-image';
    }
    if(is_singular()){
        if( get_option( 'page_sidebar' ) || get_post_meta( get_the_ID(), 'sidebar', true ) ){
            $classes[] = 'with-sidebar';
        }
    }
    return $classes;
}
add_filter( 'body_class', 'ffl_body_class');

// add theme class on content
function ffl_content_class($class = ''){
    $classes = array();
    if ( ! empty( $class ) ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_merge( $classes, $class );
    } else {
        $class = array();
    }
    if( get_post_meta(get_the_ID(),'no_ajax', true) ){
        $classes[] = 'no-ajax';
    }
    $classes = array_map( 'esc_attr', $classes );
    $classes = array_unique( apply_filters( 'ffl_content_class', $classes, $class ) );
    echo 'class="' . join( ' ', $classes) . '"';
}

// Adds custom class to the array of posts classes.
function ffl_post_classes( $classes, $class, $post_id ) {
    $classes[] = 'entry';
    $hide_title = get_post_meta( $post_id, 'hide_title', true );
    if($hide_title){
        $classes[] = 'hide-title';
    }
    return $classes;
}
add_filter( 'post_class', 'ffl_post_classes', 10, 3 );


// remove column inline style since WP 6.0
if( apply_filters('ffl_remove_wp_inline_style', true) ){
    call_user_func_array('remove_filter', array('render_block', 'gutenberg_render_layout_support_flag', 10, 2));
    call_user_func_array('remove_filter', array('render_block', 'wp_render_layout_support_flag', 10, 2));
    call_user_func_array('remove_filter', array('render_block', 'wp_render_elements_support', 10, 2));
    call_user_func_array('remove_filter', array('render_block', 'gutenberg_render_elements_support', 10, 2));

    add_filter('render_block_core/navigation', 'ffl_block_add_layout_class', 10, 2);
    add_filter('render_block_core/social-links', 'ffl_block_add_layout_class', 10, 2);
    add_filter('render_block_core/buttons', 'ffl_block_add_layout_class', 10, 2);
    add_filter('render_block_core/group', 'ffl_block_add_layout_class', 10, 2);
}

function ffl_block_add_layout_class($block_content, $block) {
    if (empty($block['attrs']['layout'])) {
        return $block_content;
    }

    $classes = [];

    if (!empty($block['attrs']['layout']['type'])) {
        $classes[] = 'is-layout-' . $block['attrs']['layout']['type'];
    }

    if (!empty($block['attrs']['layout']['orientation'])) {
        $classes[] = 'is-' . $block['attrs']['layout']['orientation'];
    }

    if (!empty($block['attrs']['layout']['justifyContent'])) {
        $classes[] = 'is-content-justification-' . $block['attrs']['layout']['justifyContent'];
    }

    if (!empty($block['attrs']['layout']['flexWrap']) && ($block['attrs']['layout']['flexWrap'] = 'nowrap')) {
        $classes[] = 'is-nowrap';
    }

    $blockClass = 'wp-block-'.str_replace('core/', '', $block['blockName']);

    if (!empty($classes)) {
        $classes = implode(' ', $classes);
        $search  = '/class="(.*?)'.$blockClass.'/';
        $replace = 'class="$1'.$blockClass.' ' . $classes;
        $block_content = preg_replace( $search, $replace, $block_content );
    }

    return $block_content;
}

// add customize
add_action( 'play_before_archive_content', 'ffl_space', 10);
if ( ! function_exists( 'ffl_space' ) ) {
  function ffl_space() {
    echo '<div style="height: 30px"></div>';
  }
}
// add waveform
add_action( 'play_single_header_end', 'play_output_waveform', 20);

// add svg logo support
function ffl_get_custom_logo($html){
    $file = get_attached_file( get_theme_mod( 'custom_logo' ) );
    if(strpos( $file, '.svg' ) !== false){
        ob_start();
        include $file;
        $content = ob_get_clean();
        $html = sprintf('<a href="%1$s">%2$s</a>', esc_url( home_url( '/' ) ) , $content);
    }
    return $html;
}
add_filter('get_custom_logo', 'ffl_get_custom_logo');

add_action( 'admin_init' , 'ffl_register_fields' );
function ffl_register_fields(){
    register_setting( 'general', 'envato_purchase_code');
    add_settings_field('ffl-code-id', 'Envato Purchase Code', 'ffl_fields', 'general', 'default');
}
function ffl_fields(){
    $envato_purchase_code = get_option('envato_purchase_code');
    echo '<input name="envato_purchase_code" id="envato_purchase_code" class="regular-text" value="'.$envato_purchase_code.'" /><p><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">Where is my Envato purchase code?</a></p><p><a class="button" href="?import=wordpress&demo=1&step=3">Import Demo Data</a></p>';
}
add_action('admin_notices', 'ffl_admin_notice');
function ffl_admin_notice(){
    if(!get_option('envato_purchase_code')){
        echo '<div class="notice notice-warning is-dismissible">
          <p>You need a <a href="options-general.php#envato_purchase_code">Envato Purchase Code</a> to update plugins.</p>
         </div>';
    }
}

function ffl_meta_boxes_content($post){
    $thumbnail_pos_y = get_post_meta( $post->ID, 'thumbnail_pos_y', true );
    $hide_title = get_post_meta( $post->ID, 'hide_title', true );
    $no_ajax = get_post_meta( $post->ID, 'no_ajax', true );
    $sidebar = get_post_meta( $post->ID, 'sidebar', true );
    $footer = get_post_meta( $post->ID, 'footer', true );
    $content = '';
    if($post->post_type == 'page'){
        $content .= '<p><label><input type="checkbox" name="hide_title" value="1" '.checked($hide_title, 1, false).'/>'.esc_html__('Hide Page title', 'bepop').'</label></p>';
        $content .= '<p><label><input type="checkbox" name="no_ajax" value="1" '.checked($no_ajax, 1, false).'/>'.esc_html__('Disable Ajax', 'bepop').'</label></p>';
    }
    $content .= '<p><label>'. esc_html__('Featured image vertical position', 'bepop') .'</label>';
    $content .= '<input type="number" name="thumbnail_pos_y" size="2" value="'. esc_attr($thumbnail_pos_y) .'"/> %</p>';
    $content .= '<p>'. esc_html__('Sidebar', 'bepop') .'</label> '.wp_dropdown_pages(array('name' => 'sidebar', 'selected' => $sidebar, "show_option_none" => " ", 'echo' => false, 'post_status'=>array( 'private', 'publish' ))).'</p>';
    $content .= '<p>'. esc_html__('Footer', 'bepop') .'</label> '.wp_dropdown_pages(array('name' => 'footer', 'selected' => $footer, "show_option_none" => " ", 'echo' => false, 'post_status'=>array( 'private', 'publish' ))).'</p>';

    echo ''.$content;
}

function ffl_register_meta_boxes() {
    call_user_func_array(
        sprintf('add%smeta%sbox', '_', '_'),
        array( 'ffl-meta-box-id', esc_html__( 'Advanced', 'bepop' ), 'ffl_meta_boxes_content', null, 'side', 'high', array('__block_editor_compatible_meta_box' => true) )
    );
}
add_action( sprintf('add%smeta%sboxes', '_', '_'), 'ffl_register_meta_boxes' );

function ffl_save_metabox( $post_id ) {
    if ( array_key_exists('thumbnail_pos_y', $_POST) ) {
        update_post_meta( $post_id, 'thumbnail_pos_y', $_POST['thumbnail_pos_y'] );
    }

    if( isset( $_POST['footer'] ) ){
        update_post_meta( $post_id, 'footer', $_POST['footer'] );
    }else{
        delete_post_meta( $post_id, "footer" );
    }

    if( isset( $_POST['sidebar'] ) ){
        update_post_meta( $post_id, 'sidebar', $_POST['sidebar'] );
    }else{
        delete_post_meta( $post_id, "sidebar" );
    }

    if ( get_post_type($post_id) == 'page' ) {
        if( isset( $_POST['hide_title'] ) ){
            update_post_meta( $post_id, 'hide_title', $_POST['hide_title'] );
        }else{
            delete_post_meta( $post_id, "hide_title" );
        }
        if( isset( $_POST['no_ajax'] ) ){
            update_post_meta( $post_id, 'no_ajax', $_POST['no_ajax'] );
        }else{
            delete_post_meta( $post_id, "no_ajax" );
        }
    }
}
add_action( 'save_post', 'ffl_save_metabox' );

// register customize
function ffl_customize_register( $wp_customize ) {
    // Layout and color
    $wp_customize->add_section( 'custom_theme', array(
        'title'    => esc_html__( 'Color & Layout', 'bepop' ),
        'priority' => 20,
    ) );

    // layout
    $wp_customize->add_setting( 'site_layout', array(
        'type' => 'option',
        'sanitize_callback' => 'esc_attr'
    ) );
    $wp_customize->add_control(
        'site_layout',
        array(
          'type' => 'select',
          'label' => esc_html__( 'Layout', 'bepop' ),
          'section' => 'custom_theme',
          'choices' => array('layout-app' => 'App', 'layout-site' => 'Site')
        )
    );

    // theme
    $wp_customize->add_setting( 'site_theme', array(
        'type' => 'option',
        'sanitize_callback' => 'esc_attr'
    ) );
    $wp_customize->add_control(
        'site_theme',
        array(
          'type' => 'select',
          'label' => esc_html__( 'Theme', 'bepop' ),
          'section' => 'custom_theme',
          'choices' => array('dark'=>'Dark', 'light'=>'Light')
        )
    );

    $wp_customize->add_setting( 'primary_color', array(
        'type' => 'option',
        'sanitize_callback' => 'esc_attr'
    ) );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize, 'primary_color',
            array(
                'label'       => esc_html__( 'Primary color', 'bepop' ),
                'section'     => 'custom_theme',
                'mode'        => 'full',
            )
        )
    );

    // Custom js
    $wp_customize->add_section( 'custom_js', array(
        'title'    => esc_html__( 'Additional JS', 'bepop' ),
        'priority' => 200,
    ) );
    $wp_customize->add_setting( 'custom_js', array(
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    $wp_customize->add_control(
        new WP_Customize_Code_Editor_Control( 
            $wp_customize, 'custom_js', 
            array(
                'code_type' => 'javascript',
                'section'   => 'custom_js',
            ) 
        ) 
    );

    // Pages
    $wp_customize->add_section( 'custom_page', array(
        'title'    => esc_html__( 'Pages', 'bepop' ),
        'priority' => 200,
    ) );

    $wp_customize->add_setting( 'page_animate', array(
        'type' => 'option',
        'sanitize_callback' => 'absint'
    ) );
    $wp_customize->add_control(
        'page_animate',
        array(
          'type' => 'checkbox',
          'label' => esc_html__( 'Page animate', 'bepop' ),
          'section' => 'custom_page'
        )
    );

    // footer
    $wp_customize->add_setting( 'page_footer', array(
        'type' => 'option',
        'sanitize_callback' => 'absint'
    ) );
    $wp_customize->add_control(
        'page_footer',
        array(
          'type' => 'select',
          'label' => esc_html__( 'Footer page', 'bepop' ),
          'section' => 'custom_page',
          'choices' => ffl_pages()
        )
    );

    // sidebar
    $wp_customize->add_setting( 'page_sidebar', array(
        'type' => 'option',
        'sanitize_callback' => 'absint'
    ) );
    $wp_customize->add_control(
        'page_sidebar',
        array(
          'type' => 'select',
          'label' => esc_html__( 'Sidebar page', 'bepop' ),
          'section' => 'custom_page',
          'choices' => ffl_pages()
        )
    );
}
add_action( 'customize_register', 'ffl_customize_register' );

function ffl_pages(){
  $pages_options = array( '' => '' );
  $pages = get_pages( array('post_status'=>array( 'private', 'publish' )) );
  if ( $pages ) {
    foreach ( $pages as $page ) {
      $pages_options[ $page->ID ] = $page->post_title;
    }
  }
  return $pages_options;
}

function ffl_customize_output() {
    $js = get_option( 'custom_js', '' );
    if ( '' === $js ) {
        return;
    }
    ?>
    <script type="text/javascript">
        jQuery(function ($) {
            "use strict";
            <?php echo ''.$js . "\n"; ?>
        });
    </script>
    <?php
}
add_action( 'wp_footer', 'ffl_customize_output' );

function ffl_color(&$out) {
    $color = array('color');

    if (preg_match('/(#([0-9a-f]{6})|#([0-9a-f]{3}))/', $out, $m)) {
        if (isset($m[3])) {
            $num = $m[3];
            $width = 16;
        } else {
            $num = $m[2];
            $width = 256;
        }

        $num = hexdec($num);
        foreach (array(3,2,1) as $i) {
            $t = $num % $width;
            $num /= $width;

            $color[$i] = $t * (256/$width) + $t * floor(16/$width);
        }

        $out = $color;
        return true;
    }

    return false;
}

function ffl_to_hsl($red, $green, $blue) {
    $min = min($red, $green, $blue);
    $max = max($red, $green, $blue);

    $l = $min + $max;

    if ($min == $max) {
        $s = $h = 0;
    } else {
        $d = $max - $min;

        if ($l < 255)
            $s = $d / $l;
        else
            $s = $d / (510 - $l);

        if ($red == $max)
            $h = 60 * ($green - $blue) / $d;
        elseif ($green == $max)
            $h = 60 * ($blue - $red) / $d + 120;
        elseif ($blue == $max)
            $h = 60 * ($red - $green) / $d + 240;
    }

    return array('hsl', fmod($h, 360), $s * 100, $l / 5.1);
}

function ffl_to_rgb($hue, $saturation, $lightness) {
    if ($hue < 0) {
        $hue += 360;
    }

    $h = $hue / 360;
    $s = min(100, max(0, $saturation)) / 100;
    $l = min(100, max(0, $lightness)) / 100;

    $m2 = $l <= 0.5 ? $l * ($s + 1) : $l + $s - $l * $s;
    $m1 = $l * 2 - $m2;

    $r = ffl_hue_to_rgb($m1, $m2, $h + 1/3) * 255;
    $g = ffl_hue_to_rgb($m1, $m2, $h) * 255;
    $b = ffl_hue_to_rgb($m1, $m2, $h - 1/3) * 255;

    $out = array('color', $r, $g, $b);
    return $out;
}

function ffl_hue_to_rgb($m1, $m2, $h) {
    if ($h < 0)
        $h += 1;
    elseif ($h > 1)
        $h -= 1;

    if ($h * 6 < 1)
        return $m1 + ($m2 - $m1) * $h * 6;

    if ($h * 2 < 1)
        return $m2;

    if ($h * 3 < 2)
        return $m1 + ($m2 - $m1) * (2/3 - $h) * 6;

    return $m1;
}

function ffl_adjust_hsl($color, $idx, $amount) {
    $hsl = ffl_to_hsl($color[1], $color[2], $color[3]);
    $hsl[$idx] += $amount;
    $out = ffl_to_rgb($hsl[1], $hsl[2], $hsl[3]);
    if (isset($color[4])) $out[4] = $color[4];
    return $out;
}

function ffl_adjust_hue($color, $degree) {
    return ffl_adjust_hsl($color, 1, $degree);
}

// theme
function ffl_theme(){
    $color = '#c02afe';
    $theme_css = '';
    
    if(get_option( 'primary_color' )){
        $primary_color = $color = get_option( 'primary_color' );
        ffl_color($color);
        $hue = ffl_adjust_hue($color, -25);
        $primary_rgba = sprintf('rgba(%s, %s, %s, %s)', $color[1], $color[2], $color[3], 0.5);
        $primary_hue  = sprintf('rgb(%s, %s, %s)', $hue[1], $hue[2], $hue[3]);
        $theme_css .= '
            html{
                --color-primary: '.$primary_color.';
                --plyr-color-main: '.$primary_color.';
            }
            .text-primary,
            .nav .active,
            .nav .current_page_item,
            a:hover{
                color: '.$primary_color.';
            }
            .gd-primary,
            .player [data-plyr="play"]{
                color: #fff !important;
                background: '.$primary_color.' linear-gradient(135deg, '.$primary_color.' 10%, '.$primary_hue.' 90%) !important;
            }
            [data-plyr="like"] .icon--pressed,
            .btn-like.active svg{
                stroke: '.$primary_color.';
                fill: '.$primary_color.';
            }
            input:not([type="radio"]):not([type="checkbox"]):not([type="range"]):focus,
            select:focus,
            textarea:focus{
                border-width: 2px;
                border-color: '.$primary_color.';
            }
            .waveform .waveform-container{
                border-color: '.$primary_color.';
            }
            .button.add_to_cart_button,
            .button-primary{
                background-color: '.$primary_color.' !important;
            }
            .is--repeat svg,
            .is--shuffle svg{
                fill: '.$primary_color.';
            }
            .wp-block-loop:not(.block-loop-row) .btn-like.active svg{
                stroke: currentColor;
                fill: currentColor;
            }
            .block-loop-hover .block-loop-item:hover, 
            .block-loop-hover .block-loop-item:focus, 
            .block-loop-hover .block-loop-item.active{
                background-color: '.$primary_color.';
            }
            .block-loop-hover .block-loop-item:hover .post-thumbnail:after, 
            .block-loop-hover .block-loop-item:focus .post-thumbnail:after, 
            .block-loop-hover .block-loop-item.active .post-thumbnail:after{
                background-color: '.$primary_color.';
                background: linear-gradient(180deg, '.$primary_rgba.', '.$primary_color.');
            }
        ';
    }
    if(get_option( 'page_animate' )){
        $theme_css .= '
        .page-animating .featured-image .entry-header-container .post-thumbnail{
            opacity: 0;
            transition-delay: 0s;
            transform: translate3d(0, 0, 0);
        }
        .page-animating .entry-header-container .entry-title,
        .page-animating .entry-header-container .entry-artist{
            clip-path: polygon(0 0,0 0,0 120%,0 120%);
            transition-delay: 0.0s;
        }
        .page-animating .backdrop{
            transform-origin: left center;
            transition-delay: 0s;
            transform: translate3d(0, 0, 0) scaleX(1);
        }';
    }
    return apply_filters( 'ffl_custom_colors_css', $theme_css, $color );
}

function ffl_custmize(){
    wp_add_inline_style( 'bepop-style', ffl_theme() );
}
add_action( 'wp_enqueue_scripts', 'ffl_custmize' );
