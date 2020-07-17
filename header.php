<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package aperabags
 */

?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="google-site-verification" content="eYMU9wHvI9cwK4rHA5VmPSE4SXRoAbXD6XCFlDQi4Vk" />
	<meta name="p:domain_verify" content="7af7e6aa3e8004eaf65dafe6a3b4ae8f"/>
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="loader-wrapper">
		<span class="loader"><span class="loader-inner"></span></span>
	</div>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'apera-bags' ); ?></a>

	<header id="masthead" class="container-fluid site-header">
		<?php
		if ( get_theme_mod( 'enable_topbar' ) ) :
			?>
			<div class="row topbar-notice" style="background:<?php echo esc_html( get_theme_mod( 'topbar_color', '#000' ) ); ?>;">
				<div class="col col-12">
					<span class="topbar-message-text"><?php echo esc_html( get_theme_mod( 'topbar_message', 'Please set notice in customizer.' ) ); ?> </span>
				</div><!-- col col-12 -->
			</div><!-- topbar-notice -->
		<?php endif; ?>
		<div class="row brand-nav-bar justify-content-end">
			<div class="col col-5 col-lg-2 branding">
				<div class="site-branding">
					<?php
						the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;
					$apera_bags_description = get_bloginfo( 'description', 'display' );
					if ( $apera_bags_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $apera_bags_description; /* WPCS: xss ok. */ ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->
			</div> <!-- .col-4 -->
			<div class="col col-5 d-lg-none cart-mobile-col">
				<?php
					$count = WC()->cart->cart_contents_count;
					wp_nav_menu(
						array(
							'theme_location' => 'menu-cart',
							'menu_id'        => 'cart-menu-mobile',
							'menu_class'     => 'wonka-cart-menu header-cart-menu',
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item menu-item-type-post"><a href="#" class="wonka-cart-open"><span class="cart-contents-count wonka-cart-badge badge badge-light">' . esc_html( $count ) . '</span></a></li></ul>',
						)
					);
					?>
			</div><!-- .cart-mobile-col -->
			<div class="col col-12 col-lg-9 text-right div-nav">

				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="hang-a-bur hang-a-bur-top"></span>
						<span class="hang-a-bur hang-a-bur-mid"></span>
						<span class="hang-a-bur hang-a-bur-bottom"></span>
					</button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-primary',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'nav-menu header-menu',
						)
					);
					wp_nav_menu(
						array(
							'theme_location' => 'menu-cart',
							'menu_id'        => 'cart-menu-desktop',
							'menu_class'     => 'wonka-cart-menu header-cart-menu d-none d-md-flex',
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item menu-item-type-post"><a href="#" class="wonka-cart-open"><span class="cart-contents-count wonka-cart-badge badge badge-light">' . esc_html( $count ) . '</span></a></li></ul>',
						)
					);
					?>
				</nav><!-- #site-navigation -->
			</div> <!-- .col-8 -->
		</div> <!-- .row -->
	</header><!-- #masthead -->																																	 
	<div id="content" class="site-content">
