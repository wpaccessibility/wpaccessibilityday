<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp-accessibility-day
 */

?>

<footer id="colophon" class="site-footer">
	<h2 class="sr-only">
		Footer
	</h2>
	<?php
		wp_accessibility_day_footer_sidebars();
	?>
	<div id="bottom-credits">
		<div class="wrap">
			<div class="site-logo">
				<?php 
					echo do_shortcode('[logo]');
				?>
				<p>
					© 2022 WordPress Accessibility Day
				</p>
			</div>	
			<nav id="footer-navigation" class="footer-navigation navigation" aria-label="Footer">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-3',
						'menu_id'        => 'footer-menu',
						'depth'          => 1,
					) );
				?>
			</nav><!-- #site-navigation -->
		</div><!-- #wrap -->
	</div><!-- #bottom-credits -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
