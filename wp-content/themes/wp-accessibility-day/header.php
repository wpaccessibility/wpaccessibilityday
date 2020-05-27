<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gutenberg-starter-theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'gutenberg-starter-theme' ); ?></a>
		<header id="masthead" class="site-header">
			<div class="site-branding">
				<?php
				// get custom logo
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$custom_logo_attr = array( 'class' => 'custom-logo', 'alt' => '' );

				if ( is_front_page() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )?><span><?php bloginfo( 'name' ); ?></span></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )?><span><?php bloginfo( 'name' ); ?></span></a></p>
				<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<?php if ( ! function_exists( 'get_field' ) || ! get_field('hide_menu') ) : ?>
			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'gutenberg-starter-theme' ); ?></button>
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
				?>
			</nav><!-- #site-navigation -->
		<?php endif; ?>
		</header><!-- #masthead -->
