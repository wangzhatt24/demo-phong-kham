<?php
/**
 * Displays header site navbar
 */
?>
<div class="site-navbar">
	<label for="menu-state" id="icon-nav"><i class="icon-nav"><i></i></i></label>
	<div class="site-brand">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-logo"><?php the_custom_logo(); ?></div>
		<?php endif; ?>
		<?php $site_title = get_bloginfo( 'name' ); ?>
		<?php if ( ! empty( $site_title ) ) : ?>
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html($site_title); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html($site_title); ?></a></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	
	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<nav id="site-navigation" class="main-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'main-menu nav',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
			?>
		</nav>
	<?php endif; ?>

	<form id="header-search-form" method="get" action="<?php echo esc_url(home_url()); ?>">
		<input type="search" placeholder="<?php esc_attr_e('Search …', 'bepop'); ?>" value="" name="s" data-toggle="dropdown">
		<label for="search-state" id="icon-search">
			<i class="icon-search"><i></i></i>
		</label>
		<div class="dropdown-menu"></div>
	</form>

	<?php if ( !is_user_logged_in() && has_nav_menu( 'before_login' ) ) : ?>
		<nav id="user-navigation" class="main-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'before_login',
					'menu_class'     => 'user-menu nav',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
			?>
		</nav>
	<?php endif; ?>
	<?php if ( is_user_logged_in() && has_nav_menu( 'after_login' ) ) : ?>
		<nav id="user-navigation" class="main-navigation">
			<?php
			do_action('menu_after_login_before');
			wp_nav_menu(
				array(
					'theme_location' => 'after_login',
					'menu_class'     => 'user-menu nav',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
			do_action('menu_after_login_after');
			?>
		</nav>
	<?php endif; ?>
</div>
