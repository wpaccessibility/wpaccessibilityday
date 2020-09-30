<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gutenberg-starter-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			if ( has_post_thumbnail() ) :
				the_post_thumbnail();
			endif;
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php gutenberg_starter_theme_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			$auth    = get_post_meta( get_the_ID(), '_speaker', true );
			$slides  = esc_url( get_post_meta( get_the_ID(), '_slides-url', true ) );
			if ( $auth ) {
				$author = get_post( $auth );
			}
			$time_output  = '<p class="speaker">Talk by <a href="' . esc_url( get_the_permalink( $auth ) ) . '">' . $author->post_title . '</a>';
			$time_output .= ( $slides ) ? ' / <a href="' . $slides . '">View Slides</a>' : '';
			$time_output .= '</p>';
			echo $time_output;

			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'gutenberg-starter-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gutenberg-starter-theme' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php gutenberg_starter_theme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
