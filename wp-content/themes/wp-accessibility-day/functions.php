<?php

use WP_Accessibility_Day\Theme;

/**
 * Autoloader.
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 */
spl_autoload_register(
	function( $class ) {
		$prefix   = 'WP_Accessibility_Day\\';
		$len      = strlen( $prefix );
		$base_dir = __DIR__ . '/classes/';

		if ( 0 !== strncmp( $prefix, $class, $len ) ) {
			return;
		}

		$relative_class = strtolower( substr( $class, $len ) );
		$file           = wp_normalize_path( $base_dir . 'class-' . str_replace( '\\', '/', $relative_class ) . '.php' );

		if ( file_exists( $file ) ) {
			require  $file;
		}
	}
);

/**
 * Declare 'wpaccessibilityday' textdomain for this theme.
 * Translations can be added to the /languages/ directory.
 */
function wp_accessibility_day_text_domain() {
	load_child_theme_textdomain( 'wpaccessibilityday', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'wp_accessibility_day_text_domain' );

// Instantiate theme.
Theme::get_instance();

// Add subtitle to home page
function wpad_home_subtitle() {
	global $post;
	if ( function_exists( 'get_field' ) ) {
		//echo '<div class="subtitle">' . get_field( 'subtitle_content', $post->ID ) . '</div>';
	} else {
		//echo '<div class="subtitle"><p class="event-date">October 2nd, 2020</p><p><a href="https://www.timeanddate.com/worldclock/fixedtime.html?hour=18&amp;min=00&amp;sec=0" class="customize-unpreviewable">From 18:00 UTC</a></p></div>';
	}
}
add_action( 'wpad_entry_header', 'wpad_home_subtitle' );

add_action( 'wp', 'wpad_custom_canonical' );
/**
 * Filter in a custom canonical URL for Yoast. Because I can't get the advanced panel to show up.
 */
function wpad_custom_canonical() {
	if ( is_single( 542 ) ) {
		add_action( 'wp_head', 'wpad_canonical' );
		remove_action( 'wp_head', 'rel_canonical' );
		add_filter( 'wpseo_canonical', 'wpad_disable_yoast_canonical' );
	}
}

function wpad_canonical() {
	$link = 'https://yoast.com/image-seo-alt-tag-and-title-tag-optimization/';

	echo "<link rel='canonical' href='$link' />\n";
}

/**
 * Return HTML from a WordPress profile via shortcode.
 *
 * @param array $atts Shortcode attributes with one parameter, user ID.
 *
 * @return string
 */
function wpad_shortcode_people( $atts ) {
	$atts = shortcode_atts( array(
		'id' => '',
	), $atts );

	$content = ( '' !== $atts['id'] ) ? wpad_get_people_data( $atts['id'] ) : '';

	return $content;
}
add_shortcode( 'people', 'wpad_shortcode_people' );

/**
 * Return HTML from a WordPress profile.
 *
 * @param string $id user slug.
 *
 * @return string
 */
function wpad_get_people_data( $id ) {
	$image    = '';
	$name     = '';
	$username = '';
	$bio      = '';
	$employer = '';
	$job      = '';
	$country  = '';
	$website  = '';

	// Remove transient & manually refresh.
	if ( current_user_can( 'manage_options' ) && isset( $_GET['wpad_transients'] ) ) {
		delete_transient( 'wpad_existing_data_for_member_' . esc_url( $id ) );
	}
	$existing_people = get_transient( 'wpad_existing_data_for_member_' . esc_url( $id ) );

	if ( ! empty( $existing_people ) ) {
		$image    = $existing_people['image'];
		$name     = $existing_people['name'];
		$username = $existing_people['username'];
		$bio      = $existing_people['bio'];
		$employer = $existing_people['employer'];
		$job      = $existing_people['job'];
		$country  = $existing_people['country'];
		$website  = $existing_people['website'];
		$url      = $existing_people['url'];
	} else {
		require_once( get_stylesheet_directory() . '/simplehtmldom/simple_html_dom.php' );
	
		$url  = 'https://profiles.wordpress.org/' . trim( $id );
		$html = file_get_html( $url );
		if ( ! $html ) {
			return $id;
		}

		$image_element = $html->find( '.photo' );
		$image         = $image_element[0]->outertext;
	
		$name_element = $html->find( 'h2.fn' );
		$name         = $name_element[0]->plaintext;
		$name         = ( ! $name ) ? 'Antonio Trifirò' : $name;
	
		$username_element = $html->find( '#slack-username' );
		$username         = $username_element[0]->innertext;

		$bio_element = $html->find( '.item-meta-about' );
		$bio         = $bio_element[0]->innertext;

		$employer_element = $html->find( '#user-company strong' );
		$employer         = $employer_element[0]->innertext;

		$job_element = $html->find( '#user-job strong' );
		$job         = $job_element[0]->innertext;

		$country_element = $html->find( '#user-location strong' );
		$country         = $country_element[0]->innertext;

		$website_element = $html->find( '#user-website strong' );
		$website         = $website_element[0]->innertext;

		$new_people = array(
			'image'    => $image,
			'name'     => $name,
			'username' => $username,
			'url'      => $url,
			'bio'      => $bio,
			'employer' => $employer,
			'job'      => $job,
			'country'  => $country,
			'website'  => $website,
		);

		set_transient( 'wpad_existing_data_for_member_' . esc_url( $id ), $new_people, WEEK_IN_SECONDS );
	}

	$content  = '<div class="people-profile">';
	$content .= '<div class="reorder">';
	$website  = '//' . strip_tags( $website );
	$content .= '<h3><a href="' . esc_url( $website ) . '">' . $name . '</a></h3>';
	$content .= $image;
	$content .= '</div>';

	$username = explode( ' on', $username );
	$username = '<a href="' . esc_url( $url ) . '">' . trim( $username[0] ) . '</a>';
	
	if ( ! empty( $username ) ) {
		$content .= '<p class="username">' . $username . '</p>';
	}
	if ( ! empty( $employer ) ) {
		//$content .= '<p class="employer"><strong>Company:</strong> ' . $employer . '</p>';
	}
	if ( ! empty( $job ) ) {
		//$content .= '<p class="job"><strong>Job title:</strong> ' . $job . '</p>';
	}
	if ( ! empty( $country ) ) {
		$content .= '<p class="country">' . $country . '</p>';
	}
	if ( ! empty( $website ) ) {
		//$content .= '<p class="website"><strong>Website:</strong> ' . $website . '</p>';
	}
	if ( ! empty( $bio ) ) {
		//$content .= '<div class="bio">' . $bio . '</div>';
	}
	$content .= '</div>';

	return $content;
}

/**
 * Parse format for time.
 */
function wpaccessibilityday_time() {
	// https://www.timeanddate.com/worldclock/fixedtime.html?iso=20201003T1400 - Format.
}

add_shortcode( 'schedule', 'wpaccessibilityday_schedule' );
function wpaccessibilityday_schedule( $atts, $content ) {
	$args = shortcode_atts( array(
		'start'     => '18',
	), $atts, 'wpaccessibilityday_schedule' );

	$query = array(
		'post_type'      => 'mcm_talk',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => '_time-in-utc',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => '_time-in-utc',
				'value'   => '',
				'compare' => '!=',
			),
		),
	);
	$posts    = get_posts( $query );
	$schedule = array();
	foreach( $posts as $post_ID ) {
		$time = str_replace( ':00', '', get_post_meta( $post_ID, '_time-in-utc', true ) );
		$schedule[ $time ] = $post_ID;
	}
	$start = $args['start'] - 24;
	for( $i = $start; $i < $args['start']; $i++ ) {
		if ( absint( $i ) != $i ) {
			$base = 24 - absint( $i );
		} else {
			$base = $i;
		}

		$time      = str_pad( $base, 2, '0', STR_PAD_LEFT );
		$datatime  = date( 'Y-m-d\TH:i:s\Z', strtotime( $time . ':00 UTC' ) );
		$time_html = '<h2 class="talk-time" data-time="' . $datatime . '">' . $time . ':00 UTC' . '</h2>';
		$talk_ID   = $schedule[ $time ];
		if ( ! $talk_ID ) {
			$output[] = $time_html . '<p>Not yet scheduled</p>';
		} else {
			$auth    = get_post_meta( $talk_ID, '_speaker', true );
			$slides  = esc_url( get_post_meta( $talk_ID, '_slides-url', true ) );
			if ( $auth ) {
				$author = get_post( $auth );
			}
			$talk         = get_post( $talk_ID );
			$time_output  = $time_html . get_the_post_thumbnail( $auth, 'medium' ) . '<p class="speaker"><a href="' . esc_url( get_the_permalink( $auth ) ) . '">' . $author->post_title . '</a></p>';
			$time_output .= ( $slides ) ? '<p class="slides"><a href="' . $slides . '">View Slides for presentation by ' . $author->post_title . '</a></p>' : '';
			$permalink    = get_the_permalink( $talk_ID );
			$talk_output  = '<h3><a href="' . esc_url( $permalink ) . '">' . $talk->post_title . '</a></h3><div class="talk-description">' . $talk->post_content . '</div>';
			$speaker_id   = sanitize_title( $author->post_title );

			$output[] = "<div class='wp-block-group alignwide trapezoid schedule' id='$speaker_id'>
				<div class='wp-block-group__inner-container'>
					<div class='wp-block-columns'>
						<div class='wp-block-column'>
							$time_output
						</div>
						<div class='wp-block-column'>
							<div class='pearl-box'>
							$talk_output
							</div>
						</div>
					</div>
				</div>
			</div>";
		}
	}

	$opening_remarks = "<div class='wp-block-group alignwide trapezoid schedule'>
				<div class='wp-block-group__inner-container'>
					<div class='wp-block-columns'>
						<div class='wp-block-column'>
							<h2 class='talk-time' data-time='2020-10-02T17:45:00Z'>17:45 UTC</h2>
							<p class='speaker'>Joe Dolson</p>
						</div>
						<div class='wp-block-column'>
							<div class='pearl-box'>
								<h3>Opening Remarks</h3>
								<div class='talk-description'>
									<p>Our lead organizer will welcome you all, and kick off WP Accessibility Day with a few brief opening comments.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>";
	$closing_remarks = "<div class='wp-block-group alignwide trapezoid schedule'>
				<div class='wp-block-group__inner-container'>
					<div class='wp-block-columns'>
						<div class='wp-block-column'>
							<h2 class='talk-time' data-time='2020-10-03T17:45:00Z'>~17:45 UTC</h2>
							<p class='speaker'>Stefano Minoia</p>
						</div>
						<div class='wp-block-column'>
							<div class='pearl-box'>
								<h3>Closing Remarks</h3>
								<div class='talk-description'>
									<p>Stefano, our incoming lead organizer for WP Accessibility Day 2021 will deliver closing remarks immediately following the end of the last talk's Q and A session.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>";
	$links = wpad_youtube_links();

	return $links . $opening_remarks . implode( PHP_EOL, $output ) . $closing_remarks;
}

function wpad_youtube_links() {
	$time = time();
	if ( $time < strtotime( '2020-10-03 0:00 UTC' ) ) {
		if ( $time < strtotime( '2020-10-02 18:00 UTC' ) ) {
			$until = human_time_diff( $time, strtotime( '2020-10-02 18:00 UTC' ) );
			$append = "Starts in only <strong>$until</strong>!";
		}
		$output = "<a href='https://youtu.be/X0BcKR2Go1E'>Watch the stream at YouTube!</a> $append";
	}
	if ( $time > strtotime( '2020-10-03 0:00 UTC' ) && $time < strtotime( '2020-10-03 6:00 UTC' ) ) {
		$output = "<a href='https://youtu.be/-fKkptFna9E'>Watch the stream at YouTube!</a>";
	}
	if ( $time > strtotime( '2020-10-03 6:00 UTC' ) && $time < strtotime( '2020-10-03 12:00 UTC' ) ) {
		$output = "<a href='https://youtu.be/V0yJ_qJBvoc'>Watch the stream at YouTube!</a>";
	}
	if ( $time > strtotime( '2020-10-03 12:00 UTC' ) && $time < strtotime( '2020-10-03 18:00 UTC' ) ) {
		$output = "<a href='https://youtu.be/9J7JlYjahMU'>Watch the stream at YouTube!</a>";
	}
	$output = '<p class="youtube-link"><span class="dashicons dashicons-youtube" aria-hidden="true"></span>' . $output . '</p>';

	return $output;
}

add_action( 'wp_enqueue_scripts', 'wp_talk_time' );
function wp_talk_time() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'wp-talk-time', get_stylesheet_directory_uri() . '/js/talk-time.js', array( 'jquery' ), '1.0.0', true );
}

add_filter( 'wp_dropdown_users_args', 'wpad_add_subscribers_to_dropdown', 10, 2 );
function wpad_add_subscribers_to_dropdown( $query_args, $r ) {
	$query_args['who'] = '';

	return $query_args;

}

class WPad_Walker_Comment extends Walker_Comment {
 
	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		global $post;
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
 
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<?php
					// Only display comment author info if speaker posts.
					if ( $comment->user_id === $post->post_author ) {
						?>
					<div class="comment-author vcard">
						<?php
						/*
						 * Eliminate comment author avatar.
						$comment_author_link = get_comment_author_link( $comment );
						$comment_author_url  = get_comment_author_url( $comment );
						$comment_author      = get_comment_author( $comment );
						$avatar              = get_avatar( $comment, $args['avatar_size'] );
						if ( 0 != $args['avatar_size'] ) {
							if ( empty( $comment_author_url ) ) {
								echo $avatar;
							} else {
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url );
								echo $avatar;
							}
						}
						 */
						/*
						 * Using the `check` icon instead of `check_circle`, since we can't add a
						 * fill color to the inner check shape when in circle form.
						 */
						if ( $comment->user_id === $post->post_author ) {
							print( '<span class="post-author-badge"><span class="dashicons dashicons-yes-alt" aria-hidden="true"></span> Speaker Response</span>' );
						}
 
						/*
						 * Eliminate comment author link
						 *
						printf(
							wp_kses(
								__( '%s <span class="screen-reader-text says">says:</span>', 'custom' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							'<b class="fn">' . get_comment_author_link( $comment ) . '</b>'
						);
 
						if ( ! empty( $comment_author_url ) ) {
							echo '</a>';
						}
						*/
						?>
					</div><!-- .comment-author -->
						<?php
					} else {
						echo '<div></div>';
					}
					?>
					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">Asked on 
							<?php
								/* translators: 1: comment date, 2: comment time */
								$comment_timestamp = sprintf( __( '%1$s at %2$s', 'custom' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
							<time datetime="<?php comment_time( 'c' ); ?>" title="<?php echo $comment_timestamp; ?>">
								<?php echo $comment_timestamp; ?>
							</time>
						</a>
						<?php
							edit_comment_link( __( 'Edit', 'custom' ), ' <span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-metadata -->
 
					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'custom' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->
 
				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->
 
			</article><!-- .comment-body -->
 
			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below'     => 'div-comment',
						'depth'         => $depth,
						'max_depth'     => $args['max_depth'],
						'before'        => '<div class="comment-reply">',
						'after'         => '</div>',
						'reply_text'    => 'Answer',
						'reply_to_text' => 'Add an Answer',
					)
				)
			);
			?>
		<?php
	}
}