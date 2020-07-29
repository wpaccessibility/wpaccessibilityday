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

	$content = ( '' !== $atts['id'] || is_numeric( $atts['id'] ) ) ? wpad_get_people_data( absint( $atts['id'] ) ) : '';

	return $content;
}
add_shortcode( 'people', 'wpad_shortcode_people' );

/**
 * Return HTML from a WordPress profile.
 *
 * @param string $id user ID.
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
	} else {
		require_once( get_stylesheet_directory() . '/simplehtmldom/simple_html_dom.php' );
	
		$url  = 'https://profiles.wordpress.org/' . trim( $id );
		$html = file_get_html( $url );
	
		$image_element = $html->find( '.photo' );
		$image         = $image_element[0]->outertext;
	
		$name_element = $html->find( 'h2.fn' );
		$name         = $name_element[0]->plaintext;
	
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
			'bio'      => $bio,
			'employer' => $employer,
			'job'      => $job,
			'country'  => $country,
			'website'  => $website,
		);

		set_transient( 'wpad_existing_data_for_member_' . esc_url( $id ), $new_people, WEEK_IN_SECONDS );
	}

	$content  = '<div class="people-profile">';
	$content .= '<h2>' . $name . '</h2>';
	$content .= $image;
	if ( ! empty( $username ) ) {
		$content .= '<p class="username">' . $username . '</p>';
	}
	if ( ! empty( $employer ) ) {
		$content .= '<p class="employer"><strong>Company:</strong> ' . $employer . '</p>';
	}
	if ( ! empty( $job ) ) {
		$content .= '<p class="job"><strong>Job title:</strong> ' . $job . '</p>';
	}
	if ( ! empty( $country ) ) {
		$content .= '<p class="country"><strong>Location:</strong> ' . $country . '</p>';
	}
	if ( ! empty( $website ) ) {
		$content .= '<p class="website"><strong>Website:</strong> ' . $website . '</p>';
	}
	if ( ! empty( $bio ) ) {
		$content .= '<div class="bio">' . $bio . '</div>';
	}
	$content .= '</div>';

	return $content;
}

