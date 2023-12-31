<?php
/**
 * The header
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<input type="checkbox" id="menu-state">
	<input type="checkbox" id="search-state">
	<header id="header" class="site-header">
		<div class="header-container">
			<?php get_template_part( 'templates/header/site', 'navbar' ); ?>
		</div>
	</header>
	<div class="backdrop"></div>
	<div id="content" <?php ffl_content_class('site-content');?>>
