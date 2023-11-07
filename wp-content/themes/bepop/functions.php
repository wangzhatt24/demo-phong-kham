<?php

if ( ! function_exists( 'ffl_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ffl_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'bepop', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1568, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   	   => esc_html__( 'Primary Menu', 'bepop' ),
		'secondary'   	   => esc_html__( 'Secondary Menu', 'bepop' ),
		'user'   	   	   => esc_html__( 'User Menu', 'bepop' ),
		'before_login'     => esc_html__( 'Before Login Menu', 'bepop' ),
		'after_login'      => esc_html__( 'After Login Menu', 'bepop' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script', 
		'style'
	) );

	add_theme_support(
		'custom-logo'
	);

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	if ( ! isset( $content_width ) ) { $content_width = 600; }
	
}
endif;
add_action( 'after_setup_theme', 'ffl_setup' );

function ffl_scripts() {
	$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
	wp_enqueue_style( 'bepop-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'bepop-theme', get_template_directory_uri().'/assets/css/theme.css', array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'pjax', get_template_directory_uri().'/assets/js/pjax.min.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'bepop', get_template_directory_uri().'/assets/js/site'.$suffix.'.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'ffl_scripts' );

require_once get_template_directory() . '/includes/template-icons.php';
require_once get_template_directory() . '/includes/template-tags.php';
require_once get_template_directory() . '/includes/template-functions.php';
require_once get_template_directory() . '/includes/template-customize.php';

if( class_exists( 'WooCommerce' ) ){
	require_once get_template_directory() . '/woocommerce/woo.php';
}

if( class_exists( 'Easy_Digital_Downloads' ) ){
	require_once get_template_directory() . '/easy-digital-downloads/edd.php';
}

// install requried plugins
require_once get_template_directory() . '/includes/libs/TGMPA/class-tgm-plugin-activation.php';
function ffl_register_required_plugins() {
	$code = get_option('envato_purchase_code');
	$theme = get_file_data( get_template_directory().'/style.css', array('Plugin' => 'Plugin', 'Support' => 'Support') );
	$version = $theme['Plugin'];
	$url = $theme['Support'].'wp-json/wp/v2/update/?code='.$code.'&version='.$version.'&site='.site_url();
    $plugins = array(
    	array(
    		'name'      => 'WordPress Importer',
            'slug'      => 'wordpress-importer',
            'required'  => true
    	),
        array(
            'name'      => 'Play Block',
            'slug'      => 'play-block',
            'source'    => $url.'&plugin=play-block',
            'version'   => $version,
            'required'  => true
        ),
        array(
            'name'      => 'Loop Block',
            'slug'      => 'loop-block',
            'source'    => $url.'&plugin=loop-block',
            'version'   => $version,
            'required'  => true
        )
    );
    $config = array(
		'id'           => 'ffl',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );

	add_action('admin_head', function(){
        echo '<style>.appearance_page_tgmpa-install-plugins .wrap > p .code{display:none}</style>';
    });

	// import demo data
	if(is_admin() && current_user_can('manage_options') && isset( $_REQUEST['import'] ) && isset( $_REQUEST['demo'] )){
	    if (class_exists('WP_Import') && class_exists('Play_Block')) {
			if (!function_exists('wp_insert_category')) {
                require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
            }
            if (!function_exists('post_exists')) {
                require_once ABSPATH . 'wp-admin/includes/post.php';
            }
            if (!function_exists('comment_exists')) {
                require_once ABSPATH . 'wp-admin/includes/comment.php';
            }

		    require_once ABSPATH . 'wp-admin/includes/file.php';
		    require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
			
			$file = download_url($url.'&plugin=bepop-demo');
			
			if(is_wp_error($file)){
				add_action('admin_notices', function(){
			        echo '<div class="notice notice-error is-dismissible"><p>Can not import demo data</p></div>';
			    });
			}else{
				if(is_file($file) && (filesize( $file ) > 0)){
					// remove current menus
					$menus = wp_get_nav_menus();
					if (!empty($menus)) {
						foreach ($menus as $menu) {
							wp_delete_nav_menu($menu);
						}
					}

					$wp_import = new WP_Import();
					$wp_import->fetch_attachments = true;
					$wp_import->allow_fetch_attachments();

					ob_start();
					$wp_import->import($file);
					ob_end_clean();
					add_action('admin_notices', function(){
				        echo '<div class="notice notice-success is-dismissible"><p>Demo data imported</p></div>';
				    });
					
				    // Set menu
					$locations = get_theme_mod('nav_menu_locations');
					$menus = wp_get_nav_menus();
					if (!empty($menus)) {
						foreach ($menus as $menu) {
							if (is_object($menu) && $menu->name == 'Before login') {
								$locations['before_login'] = $menu->term_id;
							}
							if (is_object($menu) && $menu->name == 'After login') {
								$locations['after_login'] = $menu->term_id;
							}
							if (is_object($menu) && $menu->name == 'Main') {
								$locations['primary'] = $menu->term_id;
							}
						}
					}
					set_theme_mod('nav_menu_locations', $locations);

					// set home
					$page = get_page_by_title('discover');
				    if ($page && $page->ID) {
				         update_option('show_on_front', 'page');
				         update_option('page_on_front', $page->ID);
				    }

				    // set page area
				    $page = get_page_by_title('footer');
				    if ($page && $page->ID) {
				         update_option('page_footer', $page->ID);
				    }

				    $page = get_page_by_title('sidebar');
				    if ($page && $page->ID) {
				         update_option('page_sidebar', $page->ID);
				    }
				}else{
					add_action('admin_notices', function(){
				        echo '<div class="notice notice-error is-dismissible"><p>Import failed, Empty demo data.</p></div>';
				    });
				}
			}
		}else{
			add_action('admin_notices', function(){
				        echo '<div class="notice notice-error is-dismissible"><p>Install & Activate the required plugins first.</p></div>';
				    });
		}
	}
}
add_action( 'tgmpa_register', 'ffl_register_required_plugins' );
