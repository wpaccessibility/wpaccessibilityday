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
	<?php
		wp_accessibility_day_footer_sidebars();
	?>
	<nav id="footer-navigation" class="footer-navigation navigation" aria-label="Footer">
		<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-3',
				'menu_id'        => 'footer-menu',
				'depth'          => 1,
			) );
		?>
	</nav><!-- #site-navigation -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
