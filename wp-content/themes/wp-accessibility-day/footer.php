<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gutenberg-starter-theme
 */

?>

<footer id="colophon" class="site-footer">
	<div class="site-info">
		<?php
		/* translators: %s: CMS name, i.e. WordPress. */
		printf( esc_html__( 'Proudly powered by %s', 'gutenberg-starter-theme' ), '<a href="https://wordpress.org/">WordPress</a>' );
		?>
		<span class="sep"> | </span>
		<?php
			/* translators: 1: Theme name, 2: Theme author. */
			printf( esc_html__( 'Theme: %s', 'gutenberg-starter-theme' ), '<a href="https://github.com/WordPress/gutenberg-starter-theme/">Gutenberg Starter Theme</a>' );
		?>
		<span class="sep"> | </span>
		<?php
			/* translators: 1: Theme name, 2: Theme author. */
			printf( esc_html__( 'Hosting: %s', 'gutenberg-starter-theme' ), '<a href="https://whodunit.fr">Whodunit</a>' );
		?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
