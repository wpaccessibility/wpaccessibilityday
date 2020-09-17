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
		'post_status'    => 'publish, draft',
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

		$time   = str_pad( $base, 2, '0', STR_PAD_LEFT );
		$post   = $schedule[ $time ];
		$auth   = get_post_meta( $post, '_speaker', true );
		$slides = esc_url( get_post_meta( $post, '_slides-url', true ) );
		if ( $auth ) {
			$author = get_post( $auth );
		}
		$talk        = get_post( $post );
		$datatime    = date( 'Y-m-d\TH:i:s\Z', strtotime( $time . ':00 UTC' ) );
		$time_output = '<h2 class="talk-time" data-time="' . $datatime . '">' . $time . ':00 UTC' . '</h2>' . get_the_post_thumbnail( $auth );
		$talk_output = '<h3>' . $talk->post_title . '</h3><p class="speaker"><a href="' . esc_url( get_the_permalink( $auth ) ) . '">' . $author->post_title . '</a></p><div class="talk-description">' . $talk->post_content . '</div>';

		$output[] = $time_output . $talk_output;
	}

	return implode( PHP_EOL, $output );
}

add_action( 'wp_enqueue_scripts', 'wp_talk_time' );
function wp_talk_time() {
	wp_enqueue_script( 'wp-talk-time', get_stylesheet_directory_uri() . '/js/talk-time.js', array( 'jquery' ), '1.0.0', true );
}