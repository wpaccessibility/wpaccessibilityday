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
	<svg aria-hidden="true" class="a11y-background-svg" viewBox="0 0 846 1136">
		<path d="M545.4 -76.9627C467.734 -97.7732 387.921 -51.7491 367.132 25.8352C346.343 103.42 392.451 183.184 470.117 203.995C547.783 224.805 627.596 178.781 648.385 101.197C669.174 23.6125 623.066 -56.1522 545.4 -76.9627ZM835.833 377.27L66.7852 171.205C46.1619 165.675 24.9654 177.893 19.4418 198.495C14.3971 217.31 24.1689 236.941 42.2339 244.282L270.307 336.975C277.564 339.924 282.12 347.181 281.618 354.991C274.371 467.666 237.818 576.486 175.573 670.696L10.3795 946.962C-6.54175 971.838 -0.0675147 1005.72 24.8401 1022.64C29.1465 1025.56 33.8496 1027.86 38.8064 1029.45C58.8711 1034.47 79.9886 1026.99 92.3957 1010.47L332.038 703.395C333.631 701.457 336.495 701.177 338.436 702.769C339.287 703.468 339.856 704.452 340.036 705.538L394.04 1091.29C396.511 1111.81 411.057 1128.85 430.944 1134.52C460.386 1140.88 489.396 1122.19 495.74 1092.77C496.836 1087.69 497.199 1082.48 496.817 1077.3L491.871 755.448C485.069 642.737 507.824 530.22 557.886 429.017C561.355 422.003 568.93 417.996 576.689 419.071L820.563 452.835C841.713 455.764 861.225 441.01 864.145 419.881C866.812 400.584 854.669 382.314 835.833 377.27Z" fill="#833585" opacity="0.05"></path>
	</svg>
		<header id="masthead" class="site-header">
			<div class="site-branding">
				<?php
				// get custom logo
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$custom_logo_attr = array( 'class' => 'custom-logo', 'alt' => '' );
				// Since front page h1 is the name of the site, don't use H1 on front page logo.
				if ( is_front_page() ) : ?>
					<p class="site-title"><span class="wrapper"><?php echo wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )?><span><?php bloginfo( 'name' ); ?></span></span></p>
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
