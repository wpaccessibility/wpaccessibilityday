<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gutenberg-starter-theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			printf( // WPCS: XSS OK.
				/* translators: 1: comment count number, 2: title. */
				esc_html( _nx( 'Question on &ldquo;%2$s&rdquo;', 'Questions on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'gutenberg-starter-theme' ) ),
				number_format_i18n( $comment_count ),
				'<span>' . get_the_title() . '</span>'
			);
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'walker'     => new WPad_Walker_Comment(),
					'style'      => 'ol',
					'short_ping' => false,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'gutenberg-starter-theme' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().

	if ( is_user_logged_in() ) {
		$args = array(
			'title_reply'   => 'Ask a Question',
			'label_submit'  => 'Post a Question',
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Question', 'noun' ) . '</label><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
		);
		comment_form( $args );
	}
	?>

</div><!-- #comments -->
