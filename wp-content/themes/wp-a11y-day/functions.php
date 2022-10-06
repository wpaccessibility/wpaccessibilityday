<?php

if ( ! function_exists( 'wp_accessibility_day_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wp_accessibility_day_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wp-accessibility-day, use a find and replace
		 * to change 'wp-accessibility-day' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wp-accessibility-day', get_template_directory() . '/languages' );

		// Support responsive embedding.
		add_theme_support( 'responsive-embeds' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wp-accessibility-day' ),
			'menu-2' => esc_html__( 'Utility', 'wp-accessibility-day' ),
			'menu-3' => esc_html__( 'Footer', 'wp-accessibility-day' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Disable Custom Colors
		add_theme_support( 'disable-custom-colors' );

		// Editor Color Palette
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Dark Gray', 'wp-accessibility-day' ),
					'slug'  => 'dark-gray',
					'color' => '#2F3B41',
				),
				array(
					'name'  => __( 'Mid Gray', 'wp-accessibility-day' ),
					'slug'  => 'mid-gray',
					'color' => '#b2bdc2',
				),
				array(
					'name'  => __( 'Light Gray', 'wp-accessibility-day' ),
					'slug'  => 'light-gray',
					'color' => '#EBF0F6',
				),
				array(
					'name'  => __( 'Dark Purple', 'wp-accessibility-day' ),
					'slug'  => 'dark-purple',
					'color' => '#7F1177',
				),
				array(
					'name'  => __( 'Light Purple', 'wp-accessibility-day' ),
					'slug'  => 'light-purple',
					'color' => '#EFE6F0',
				),
				array(
					'name'  => __( 'Dark Blue', 'wp-accessibility-day' ),
					'slug'  => 'dark-blue',
					'color' => '#115A7F',
				),
				array(
					'name'  => __( 'Light Blue', 'wp-accessibility-day' ),
					'slug'  => 'light-blue',
					'color' => '#e4eff5',
				),
				array(
					'name'  => __( 'Black', 'wp-accessibility-day' ),
					'slug'  => 'black',
					'color' => '#000000',
				),
				array(
					'name'  => __( 'White', 'wp-accessibility-day' ),
					'slug'  => 'white',
					'color' => '#FFFFFF',
				),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'wp_accessibility_day_setup' );


/**
 * Register Widgets.
 */
function wp_accessibility_day_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'wp-accessibility-day' ),
			'id'            => 'sidebar-widget-area',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Page Sidebar', 'wp-accessibility-day' ),
			'id'            => 'page-sidebar-widget-area',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer - Full Width', 'wp-accessibility-day' ),
			'id'            => 'footer-widget-area',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer - Column 1', 'wp-accessibility-day' ),
			'id'            => 'footer-col-one-widget-area',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer - Column 2', 'wp-accessibility-day' ),
			'id'            => 'footer-col-two-widget-area',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer - Column 3', 'wp-accessibility-day' ),
			'id'            => 'footer-col-three-widget-area',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer - Column 4', 'wp-accessibility-day' ),
			'id'            => 'footer-col-four-widget-area',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
add_action( 'widgets_init', 'wp_accessibility_day_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_accessibility_day_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_accessibility_day_content_width', 781 );
}
add_action( 'after_setup_theme', 'wp_accessibility_day_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function wp_accessibility_day_scripts() {
	$css_ver   = gmdate( 'ymd-Gis', filemtime( get_stylesheet_directory() . '/css/theme.css' ) );
	$style_ver = gmdate( 'ymd-Gis', filemtime( get_stylesheet_directory() . '/style.css' ) );
	$js_ver    = gmdate( 'ymd-Gis', filemtime( get_stylesheet_directory() . '/js/navigation.js' ) );
	$ts_ver    = gmdate( 'ymd-Gis', filemtime( get_stylesheet_directory() . '/js/talk-time.js' ) );

	wp_enqueue_style( 'wp-accessibility-day-style', get_stylesheet_uri(), array(), $style_ver );
	wp_enqueue_style( 'wp-accessibility-day-theme', get_template_directory_uri() . '/css/theme.css', array( 'wp-accessibility-day-style', 'dashicons' ), $css_ver );
	wp_enqueue_script( 'wp-accessibility-day-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $js_ver, true );
	wp_enqueue_script( 'wp-accessibility-day-time', get_template_directory_uri() . '/js/talk-time.js', array(), $ts_ver, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_accessibility_day_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

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
 * Get sessions scheduled for conference.
 *
 * @return array
 */
function wpad_get_sessions() {
	$query = array(
		'post_type'      => 'wpcs_session',
		'post_status'    => 'draft',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => '_wpcs_session_time',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => '_wpcs_session_time',
				'value'   => '',
				'compare' => '!=',
			),
		),
	);
	$posts    = get_posts( $query );

	return $posts;
}

add_shortcode( 'schedule', 'wpaccessibilityday_schedule' );
/**
 * Generate schedule for WP Accessibility Day.
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Contained content.
 *
 * @return string
 */
function wpaccessibilityday_schedule( $atts, $content ) {
	$begin = strtotime( '2022-11-02 14:45 UTC' );
	$end   = strtotime( '2022-11-03 15:00 UTC' );
	$args  = shortcode_atts( array(
		'start'     => '15',
	), $atts, 'wpaccessibilityday_schedule' );

	$posts    = wpad_get_sessions();
	$schedule = array();
	foreach( $posts as $post_ID ) {
		$time              = gmdate( 'H', get_post_meta( $post_ID, '_wpcs_session_time', true ) );
		$schedule[ $time ] = $post_ID;
	}
	$start = $args['start'] - 24;
	for( $i = $start; $i < $args['start']; $i++ ) {
		if ( absint( $i ) != $i ) {
			$base = 24 - absint( $i );
		} else {
			$base = $i;
		}

		$time       = str_pad( $base, 2, '0', STR_PAD_LEFT );
		$is_current = false;

		if ( ( $begin < time() && time() < $end ) && date( 'H' ) == $time && (int) date( 'i' ) < 50 || date( 'G' ) == (int) $time - 1 && (int) date( 'i' ) > 50 ) {
			$is_current = true;
		}
		if ( (int) date( 'i' ) < 50 ) {
			$text = "Now speaking: ";
		} else {
			$text = "Up next: ";
		}
		$datatime  = date( 'Y-m-d\TH:i:s\Z', strtotime( $time . ':00 UTC' ) );
		$time_html = '<h2 class="talk-time" data-time="' . $datatime . '" id="talk-time-' . $time . '"><div class="time-wrapper">' . $time . ':00 UTC' . '</div><div class="talk-wrapper">%s</div></h2>';
		$talk_ID   = $schedule[ $time ];
		if ( $talk_ID ) {
			$talk_type = sanitize_html_class( get_post_meta( $talk_ID, '_wpcs_session_type', true ) );
			$speakers  = wpad_session_speakers( $talk_ID, $talk_type );
			$sponsors  = wpad_session_sponsors( $talk_ID );
			$slides    = esc_url( get_post_meta( $talk_ID, '_slides-url', true ) );
			$talk      = get_post( $talk_ID );

			$slides = ( $slides && 'lightning' !== $talk_type ) ? '<p class="slides"><a href="' . $slides . '">View Slides for presentation by ' . $talk->post_title . '</a></p>' : '';
			if ( current_user_can( 'manage_options' ) && 'lightning' !== $talk_type ) {
				$slides .= ( $slides ) ? '' : '<p class="slides">Admin note: Slides not yet provided.</p>';
			}
			$talk_attr_id  = sanitize_title( $talk->post_title );
			$talk_title    = '<a href="' . esc_url( get_the_permalink( $talk_ID ) ) . '" id="talk-' . $talk_attr_id . '">' . $talk->post_title . '</a>';
			$talk_title   .= '<div class="talk-speakers">' . implode( ', ', $speakers['list'] ) . '</div>';
			$talk_heading  = sprintf( $time_html, ' ' . $talk_title );
			$control       = ( isset( $_GET['buttonsoff'] ) ) ? '' : '<button type="button" class="toggle-details" aria-describedby="talk-' . $talk_attr_id . '"><span class="dashicons-plus dashicons" aria-hidden="true"></span> View Details</button>';
			if ( 'lightning' !== $talk_type ) {
				$wrap   = '<div class="wp-block-column">';
				$unwrap = '</div>';
			} else {
				$wrap   = '';
				$unwrap = '';
			}
			$talk_output  = $wrap . $sponsors;
			$talk_output .= ( 'lightning' != $talk_type ) ? '<div class="talk-description">' . $talk->post_content . '</div>' : '';
			$talk_output .= $slides . $unwrap;
			$talk_output .= $wrap . $speakers['html'] . $unwrap;

			$session_id   = sanitize_title( $talk->post_title );
			if ( $is_current ) {
				$current_talk = "<p class='current-talk alignwide'><strong>$text</strong> <a href='#$session_id'>$time:00 UTC - $talk->post_title</a></p>";
			}
			$hidden =  ( isset( $_GET['buttonsoff'] ) ) ? '' : 'hidden';

			$output[] = "
			<div class='wp-block-group alignwide schedule $talk_type' id='$session_id'>
				<div class='wp-block-group__inner-container'>
					$talk_heading
					$control
					<div class='wp-block-columns inside $hidden'>
						$talk_output
					</div>
				</div>
			</div>";
		} else {
			$talk_heading = sprintf( $time_html, '' );
			$output[]     = "
			<div class='wp-block-group alignwide schedule unset' id='unset'>
				<div class='wp-block-group__inner-container'>
					$talk_heading
					<div class='wp-block-columns inside'>
						Schedule not yet set.
					</div>
				</div>
			</div>";
		}
	}

	$opening_remarks = "<div class='wp-block-group alignwide schedule'>
				<div class='wp-block-group__inner-container'>
					<div class='wp-block-columns'>
						<div class='wp-block-column'>
							<h2 class='talk-time' data-time='2020-11-02T14:45:00Z'><div class='time-wrapper'>14:45 UTC</div> <span>Opening Remarks</span></h2>
							<div class='talk-description'>
								<p>Joe Dolson, co-lead organizer of WP Accessibility Day will kick off the event with brief opening comments.</p>
							</div>
						</div>
					</div>
				</div>
			</div>";
	$closing_remarks = '';
	$links           = wpad_youtube_links();

	return $links . $current_talk . $opening_remarks . implode( PHP_EOL, $output );
}

/**
 * Get speakers for schedule.
 *
 * @param int $session_id Talk post ID.
 *
 * @return string Output HTML
 */
function wpad_session_speakers( $session_id, $talk_type ) {
	$html         = '';
	$list         = array();
	$speakers_cpt = get_post_meta( $session_id, 'wpcsp_session_speakers', true );
	$speakers_cpt = ( is_array( $speakers_cpt ) ) ? array_reverse( $speakers_cpt ) : $speakers_cpt;

	if ( $speakers_cpt ) {
		$speakers_heading = ( count( $speakers_cpt ) > 1 ) ? '<h3>Speakers</h3>' : '<h3>Speaker</h3>';
		ob_start();
		foreach ( $speakers_cpt as $post_id ) {
			$first_name           = get_post_meta( $post_id, 'wpcsp_first_name', true );
			$last_name            = get_post_meta( $post_id, 'wpcsp_last_name', true );
			$full_name            = '<a href="' . get_permalink( $post_id ) . '">' . $first_name . ' ' . $last_name . '</a>';
			$list[]               = $first_name . ' ' . $last_name;
			$title_organization   = array();
			$title                = ( get_post_meta( $post_id, 'wpcsp_title', true ) ) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_title', true ) : null;
			$organization         = ( get_post_meta( $post_id, 'wpcsp_organization', true ) ) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_organization', true ) : null;
			$headshot             = get_the_post_thumbnail( $post_id, 'thumbnail' );
			$talk_html            = '';
			$wrap                 = '';
			$unwrap               = '';
			if ( 'lightning' === $talk_type ) {
				global $wpdb;
				$wrap      = '<div class="wp-block-column">';
				$unwrap    = '</div>';
				$result    = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_wpcs_session_speakers' AND meta_value = %d LIMIT 1", $post_id ) );
				$talk_html = '<div class="lightning-talk"><h3><a href="' . get_the_permalink( $result[0]->post_id ) . '">' . get_post_field( 'post_title', $result[0]->post_id ) . '</a></h3><div class="talk-description">' . wp_trim_words( get_post_field( 'post_content', $result[0]->post_id ) ) . '</div></div>';
			}
			echo $wrap;
			echo $talk_html;
			?>
			<div class="wpcsp-session-speaker">
				<?php
				if ( $headshot ) {
					echo $headshot;
				}
				if ( $full_name || $title_organization ) {
					?>
					<div class="wpcsp-session-speaker-data">
					<?php
				}
				if ( $full_name ) {
					?>
					<div class="wpcsp-session-speaker-name">
						<?php echo $full_name; ?>
					</div>
					<?php 
				}
				if ( $title_organization ) {
					?>
					<div class="wpcsp-session-speaker-title-organization">
						<?php echo implode( ', ', $title_organization ); ?>
					</div>
					<?php
				}
				if ( $full_name || $title_organization ) {
					?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			echo $unwrap;
		}
		$html .= ob_get_clean();
	}
	$html = ( 'lightning' !== $talk_type ) ? '<div class="wpcsp-speakers">' . $speakers_heading . $html . '</div>' : $html;

	return array( 'list' => $list, 'html' => $html );
}


/**
 * Get sponsors for schedule.
 *
 * @param int $session_id Talk post ID.
 *
 * @return string Output HTML
 */
function wpad_session_sponsors($session_id){
	$session_sponsors = get_post_meta( $session_id, 'wpcsp_session_sponsors', true );
	if ( ! $session_sponsors ) {
		return '';
	}

	$sponsors = array();
	foreach ( $session_sponsors as $sponsor_li ) {
		$sponsors[] .= '<a href="' . esc_url( get_the_permalink( $sponsor_li ) ) . '">' . get_the_title( $sponsor_li ) . '</a>';
	}

	ob_start();

	if ( $sponsors ) {
		echo '<div class="wpcs-session-sponsor"><span class="wpcs-session-sponsor-label">Session Sponsored by: </span>' . implode( ', ', $sponsors ) . '</div>';
	}
	$html = ob_get_clean();

	return $html;
}

/**
 * Swap the YouTube link based on current time.
 *
 * @return string
 */
function wpad_youtube_links() {
	$time   = time();
	$output = '';
	if ( $time < strtotime( '2022-11-02 14:50 UTC' ) ) {
		if ( $time < strtotime( '2022-11-02 15:00 UTC' ) ) {
			$until = human_time_diff( $time, strtotime( '2022-11-02 15:00 UTC' ) );
			$append = "Starts in only <strong>$until</strong>!";
		}
		$output = "<div class='wpad-callout'><p><a href='" . home_url( '/attendee-registration/' ) . "'>Register for WP Accessibility Day!</a> $append</p></div>";
	}

	return $output;
}

/**
 * This was, I believe, because we made speakers a non-publishing level of user, but assigned them as authors of their own talks.
 *
 * @return array
 */
function wpad_add_subscribers_to_dropdown( $query_args, $r ) {
	$query_args['who'] = '';

	return $query_args;
}
add_filter( 'wp_dropdown_users_args', 'wpad_add_subscribers_to_dropdown', 10, 2 );

/**
 * Custom walker for comments to handle Q & A.
 */
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
						 * Using the `check` icon instead of `check_circle`, since we can't add a
						 * fill color to the inner check shape when in circle form.
						 */
						if ( $comment->user_id === $post->post_author ) {
							print( '<span class="post-author-badge"><span class="dashicons dashicons-yes-alt" aria-hidden="true"></span> Speaker Response</span>' );
						}
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
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php echo $comment_timestamp; ?>
							</time>
						</a> <?php
							edit_comment_link( __( 'Edit', 'custom' ), '<span class="edit-link">', '</span>' );
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

/**
 * Return WP Accessibility Day site logo.
 */
function wpad_site_logo() {
	return '<svg fill="none" height="60" viewBox="0 0 60 60" width="60" xmlns="http://www.w3.org/2000/svg"><path d="m13.5471 4.36845c-.4048 0-1.0067-.14103-1.8737-.35394-.6181-.15196-1.5056-.37138-1.9056-.35866.04304.11935.04263.25009-.00115.36917-.16034.45031-.60664.43601-2.98529-.09584-.60737-.13577-1.23478-.27607-1.44566-.2787.02905.13119.01324.26837-.04489.38946-.22483.45189-.91431.34984-2.82694-.05695-.51803-.11014-1.17301-.24938-1.578206-.29425.001085.08037-.019571.15954-.059774.22909-.018243.03854-.045324.07221-.079031.09826-.033706.02605-.073083.04375-.114915.05164s-.084933.00575-.125784-.00624c-.040851-.01198-.078294-.03348-.109271-.06274-.115351-.10656-.4235478-.38935-.295298-.76505.160862-.47153.68162-.38325 2.465469-.00399.60486.12863 1.44011.30623 1.9249.34196-.00516-.10019.01726-.19987.0648-.28815.13486-.24896.50597-.41058.75503-.39703.24549-.00378.76331.10856 1.57769.29057.62289.13924 1.56667.35026 2.08953.39934-.00094-.01188-.00137-.02249-.00147-.03153-.00461-.31789.24633-.47489.36703-.55035l.01048-.00662c.00861-.0055.01754-.01048.02674-.01492.38234-.18664 1.16551-.0144 2.41021.29152.5464.1343 1.3168.32367 1.7099.34216-.0171-.06415-.0199-.13128-.0083-.19666.0116-.06537.0375-.12739.0756-.18166.2868-.38367.7796-.36612 1.1257-.31925.0073.00094.0146.00231.0219.00388.1213.02754.285.06694.4768.11318.6138.14776 2.0582.4956 2.7454.54783-.0016-.07776.0171-.15458.054-.223.0169-.0392.0428-.07386.0755-.10119.0328-.02733.0715-.04655.113-.05611.0415-.00957.0847-.00921.1261.00105s.0798.03013.1121.058c.1062.09111.4299.36833.3003.75243-.1562.46512-.6531.49171-3.6428-.22825-.1834-.04414-.3408-.08208-.4592-.10908-.1318-.02103-.2659-.02375-.3985-.0081.0291.13265.014.27117-.043.3944-.103.22163-.3012.31432-.6294.31432z" fill="#358572" class="logo-light" /><path d="m13.5471 1.48427c-.4047 0-1.0067-.14103-1.8737-.35404-.6181-.151962-1.5037-.370442-1.90571-.358672.04318.119355.04281.250172-.00105.369282-.16033.4502-.60664.43601-2.98528-.09584-.60738-.135776-1.23478-.27607-1.44566-.278697.02905.131189.01324.268357-.04489.389457-.22483.45188-.91431.34984-2.82694-.05696-.51803-.11013-1.17301-.249477-1.578206-.294245.001074.080371-.019581.159536-.059774.229095-.018254.03853-.045342.07219-.079053.09823-.033712.02604-.07309.04372-.114921.0516-.041832.00788-.084929.00574-.125775-.00626-.040846-.01199-.078282-.0335-.109252-.06276-.115351-.10645-.4235478-.388826-.295298-.764832.160862-.471742.681619-.3832574 2.465469-.004099.60486.128629 1.44011.306228 1.9249.341958-.00517-.100188.01725-.19987.0648-.288151.13486-.248955.50597-.4098458.75503-.39713013.24548-.00399336.76331.10866213 1.57769.29067513.62289.139242 1.56667.350258 2.08953.399335-.00095-.011875-.00137-.022383-.00147-.031526-.00472-.317682.24612-.47479.36702-.550243l.01049-.006725c.00867-.005495.01763-.0105122.02685-.0150286.38233-.1865319 1.1655-.0143961 2.4103.2916216.5464.134303 1.3167.323566 1.7093.342061-.0171-.064151-.02-.131288-.0083-.196664.0116-.065375.0374-.127389.0756-.181653.2869-.3836777.7799-.366023 1.1256-.3193637.0074.0010508.0147.0023113.022.0039927.1214.0275332.2854.0670467.4775.113286.6136.147123 2.0576.495387 2.7446.547721-.0015-.077806.0172-.154677.0541-.223103.0169-.039223.0428-.073912.0755-.101256.0328-.027343.0715-.046573.113-.056131.0416-.009559.0848-.009177.1261.001114.0414.010291.0798.030202.112.05812.1063.091007.43.368334.3004.752331-.1563.46512-.6533.49171-3.6421-.228045-.1837-.044137-.3413-.08218-.4599-.109187-.1319-.020935-.2659-.023693-.3985-.008198.029.132645.0139.27116-.043.3944-.1026.22173-.3008.31442-.629.31453z" fill="#358572" class="logo-light" /><path d="m13.5471 7.25288c-.4048 0-1.0067-.14103-1.8737-.35394-.6181-.15196-1.5056-.3697-1.9056-.35867.04305.11939.04264.25017-.00115.36929-.16034.45019-.60664.4359-2.98529-.09585-.60737-.13577-1.23478-.27606-1.44566-.2788.02905.13119.01324.26836-.04489.38946-.22483.45188-.91431.34984-2.82694-.05696-.51803-.11013-1.17301-.24937-1.578206-.29424.001059.08037-.019596.15952-.059774.22909-.018254.03853-.045342.07219-.079053.09823s-.07309.04373-.114921.05161-.084929.00573-.125775-.00627c-.040846-.01199-.078282-.0335-.109252-.06276-.115351-.10645-.4235478-.38883-.295298-.76494.160862-.47153.68162-.38336 2.465469-.0041.60486.12863 1.44011.30623 1.9249.34196-.00516-.10019.01726-.19986.0648-.28815.13486-.24885.50597-.40985.75503-.39703.24549-.00346.76331.10856 1.57769.29057.62289.13935 1.56667.35026 2.08953.39934-.00094-.01177-.00137-.02249-.00147-.03152-.00461-.31779.24633-.4749.36703-.55035l.01048-.00662c.00864-.00547.01756-.01045.02674-.01493.38234-.18663 1.16551-.0144 2.41021.29162.5464.13431 1.3168.32368 1.7099.34207-.0171-.06416-.0199-.13129-.0083-.19667.0116-.06537.0375-.12738.0756-.18165.2868-.38368.7796-.36624 1.1257-.31926.0073.00094.0146.00231.0219.00389.1213.02753.285.06694.4768.11318.6138.14775 2.0582.49559 2.7454.54782-.0016-.07772.017-.15452.054-.22289.0168-.03923.0427-.07393.0755-.10128.0327-.02736.0714-.0466.113-.05617.0415-.00956.0847-.00919.1261.00109s.0798.03019.1121.0581c.1062.09111.4299.36834.3003.75233-.1562.46523-.6531.49182-3.6428-.22825-.1834-.04414-.3408-.08207-.4592-.10908-.1318-.02091-.2659-.02364-.3985-.00809.0291.13264.014.27117-.043.39439-.103.22206-.3012.31443-.6294.31443z" fill="#358572" class="logo-light" /><path d="m13.5471 10.1369c-.4048 0-1.0067-.14094-1.8737-.35396-.6187-.15206-1.5058-.37044-1.9057-.35867.04317.11936.0428.25018-.00105.36929-.16024.45024-.60664.43604-2.98529-.09584-.60737-.13578-1.23478-.27607-1.44566-.2787.02891.13099.0131.26791-.04489.38883-.22483.45185-.91431.34985-2.82694-.05685-.51813-.11024-1.17301-.24938-1.578206-.29425.001022.08036-.019629.15951-.059774.22909-.018271.03852-.045367.07216-.079079.09819-.033712.02602-.073085.04369-.114908.05157-.041824.00788-.084914.00574-.125756-.00624-.040841-.01198-.078278-.03347-.109258-.06271-.115351-.10645-.4235478-.38882-.295298-.76483.160862-.47174.682354-.38326 2.465469-.0042.60476.12873 1.44011.30633 1.9249.34206-.00517-.10019.01725-.19987.0648-.28815.13486-.24896.50597-.40985.75503-.39713.24748-.00347.76341.10855 1.57779.29067.62279.13924 1.56657.35016 2.08943.39934-.00094-.01177-.00137-.02239-.00147-.03153-.00461-.31779.24633-.47479.36703-.55035l.01048-.00661c.00864-.00543.01757-.01038.02674-.01482.38234-.18674 1.16551-.01451 2.41021.29151.5464.1343 1.3168.32367 1.7099.34206-.0171-.06415-.02-.13129-.0083-.19666.0116-.06538.0374-.12739.0756-.18165.287-.38368.7799-.36592 1.1257-.31937.0073.00105.0146.00231.0219.004.1213.02742.285.06694.4768.11307.6138.14786 2.0582.4956 2.7454.54793-.0016-.07776.017-.15459.054-.223.0169-.03921.0427-.07389.0755-.10123.0327-.02734.0714-.04658.113-.05614.0415-.00957.0847-.0092.1261.00107s.0798.03015.1121.05805c.1062.09111.4299.36833.3003.75232-.1563.46524-.6533.49184-3.6428-.22814-.1834-.04425-.3408-.08208-.4592-.10908-.1318-.02099-.2659-.02375-.3985-.0082.0291.13264.014.27117-.043.39439-.103.22217-.3012.31487-.6294.31487z" fill="#358572" class="logo-light" /><path d="m13.5471 13.0217c-.4048 0-1.0067-.141-1.8737-.354-.6187-.152-1.5058-.3716-1.9057-.3586.04317.1194.0428.2502-.00105.3693-.16034.4502-.60675.4358-2.9855-.096-.60727-.1357-1.23457-.2759-1.44556-.2787.02909.1312.01332.2684-.04478.3895-.22472.4519-.91399.35-2.82683-.057-.51814-.1101-1.17312-.2493-1.578316-.2942.001059.0804-.019596.1595-.059774.2291-.018271.0385-.045367.0722-.079079.0982s-.073085.0437-.114908.0516c-.041824.0078-.084914.0057-.125756-.0063-.040841-.012-.078278-.0335-.109258-.0627-.115351-.1065-.4235478-.3888-.295298-.7649.160862-.4716.682353-.3833 2.465579-.0041.60475.1286 1.44.3062 1.92479.3419-.00517-.1002.01725-.1998.0648-.2881.13486-.249.50472-.4105.75503-.3972.24349-.0066.7632.1086 1.57748.2907.623.1393 1.56688.3503 2.08974.3994-.00094-.0119-.00137-.0225-.00147-.0316-.00461-.3178.24633-.4748.36703-.5502l.01048-.0067c.00864-.0055.01757-.0104.02674-.0149.38234-.1865 1.16551-.0144 2.41021.2916.5464.1343 1.3168.3236 1.7099.342-.0171-.0641-.0199-.1313-.0083-.1966.0116-.0654.0375-.1274.0756-.1817.2868-.3836.7798-.3657 1.1257-.3194.0073.0011.0146.0023.0219.004.1213.0276.2851.067.4769.1132.6137.1478 2.0581.4955 2.7453.5479-.0016-.0778.0171-.1546.0541-.2231.0168-.0392.0427-.0739.0754-.1013.0328-.0273.0715-.0466.113-.0561.0416-.0096.0848-.0092.1262.0011.0413.0103.0797.0302.112.0582.1062.091.4299.3678.3003.7523-.1563.4652-.6533.4917-3.6427-.2282-.1834-.0442-.3408-.0821-.4593-.1091-.1318-.0209-.2659-.0237-.3985-.0081.029.1326.0139.2711-.043.3944-.103.2212-.3012.3144-.6294.3144z" fill="#358572" class="logo-light" /><path d="m13.5471 15.9058c-.4048 0-1.0067-.141-1.8737-.3539-.6187-.1521-1.5058-.3703-1.9057-.3587.04317.1194.0428.2502-.00105.3693-.16034.4502-.60675.4359-2.9855-.0959-.60727-.1358-1.23457-.276-1.44556-.2787.02909.1311.01332.2683-.04478.3894-.22472.4519-.91399.35-2.82683-.0568-.51814-.1102-1.17312-.2495-1.578316-.2943.001075.0804-.019581.1596-.059774.2291-.018254.0385-.045342.0722-.079053.0982-.033711.0261-.07309.0438-.114921.0517-.041831.0078-.084929.0057-.125775-.0063s-.078282-.0335-.109252-.0628c-.115351-.1064-.4235478-.3888-.295298-.7649.160862-.4715.682353-.3833 2.465579-.004.60475.1286 1.44.3062 1.92479.342-.00517-.1003.01725-.2.0648-.2883.13486-.2489.50472-.4099.75503-.397.24349-.007.7632.1084 1.57748.2905.623.1393 1.56688.3503 2.08974.3994-.00094-.012-.00137-.0226-.00147-.0316-.00461-.3178.24633-.4748.36703-.5503l.01048-.0066c.00861-.0055.01754-.0105.02674-.0149.38234-.1866 1.16551-.0144 2.41021.2915.5464.1343 1.3168.3236 1.7099.3421-.0171-.0641-.0199-.1312-.0083-.1966s.0375-.1274.0756-.1817c.2868-.3834.7798-.3657 1.1257-.3192.0073.0009.0146.0023.0219.0038.1213.0276.2851.067.4769.1132.6137.1478 2.0581.4956 2.7453.548-.0016-.0778.0171-.1547.0541-.2231.0168-.0393.0427-.074.0754-.1013.0328-.0274.0715-.0466.113-.0562.0416-.0096.0848-.0092.1262.0011.0413.0103.0797.0303.112.0582.1062.091.4299.3678.3003.7523-.1563.4653-.6533.4919-3.6427-.2282-.1834-.0442-.3408-.0821-.4593-.1091-.1319-.0208-.2659-.0235-.3985-.0081.029.1327.0139.2712-.043.3944-.103.2215-.3012.3143-.6294.3143z" fill="#358572" class="logo-light" /><path d="m13.5471 18.79c-.4048 0-1.0067-.141-1.8737-.3539-.6187-.152-1.5058-.3715-1.9057-.3587.04317.1194.0428.2502-.00105.3693-.16034.4503-.60664.4359-2.98529-.0958-.60737-.1358-1.23478-.2761-1.44566-.2787.02903.1311.01322.2682-.04489.3893-.22472.4519-.91399.3501-2.82683-.0568-.51814-.1102-1.17312-.2495-1.578316-.2943.001075.0804-.019581.1595-.059774.2291-.018254.0385-.045342.0722-.079053.0982-.033711.0261-.07309.0438-.114921.0516-.041831.0079-.084929.0058-.125775-.0062s-.078282-.0335-.109252-.0628c-.115351-.1064-.4235478-.3888-.295298-.7649.160862-.4715.682353-.3833 2.465579-.004.60475.1286 1.44.3062 1.92479.3419-.00518-.1002.01724-.1999.0648-.2882.13496-.2489.50472-.4093.75503-.397.24549-.0022.76331.1086 1.57769.2906.62289.1393 1.56667.3503 2.08953.3994-.00094-.0119-.00137-.0225-.00147-.0316-.00461-.3177.24633-.4747.36703-.5503l.01048-.0066c.00864-.0055.01756-.0105.02674-.0149.38234-.1866 1.16551-.0144 2.41021.2916.5464.1343 1.3168.3236 1.7099.342-.0171-.0641-.0199-.1313-.0083-.1966.0116-.0654.0375-.1274.0756-.1817.2868-.3836.7798-.3657 1.1257-.3192.0073.0009.0146.0023.0219.0038.1213.0277.2851.0671.4769.1132.6137.1478 2.0581.4956 2.7453.548-.0016-.0778.0171-.1547.0541-.223.0168-.0393.0427-.074.0754-.1014.0327-.0273.0714-.0466.113-.0562.0415-.0095.0848-.0092.1261.0011.0414.0103.0798.0303.1121.0582.1062.0911.4299.3683.3003.7524-.1563.4653-.6533.4917-3.6427-.2282-.1834-.0442-.3408-.0822-.4593-.1092-.1319-.0208-.2659-.0235-.3985-.0081.029.1327.0139.2712-.043.3944-.103.2209-.3012.3142-.6294.3142z" fill="#358572" class="logo-light" /><path d="m20.1219 9.39478c.3486 11.95742 18.5387 13.08412 19.299 0-.3486-11.95666-18.5387-13.08342-19.299 0zm12.9298 1.30772c-.4338 1.6006-.9603 2.3719-2.5365 2.2952-3.2424-.0125-3.5714.3802-4.567-3.06066-.9543-2.27517.4689-2.72337 2.5424-4.25409 1.2153-.75863 2.0093-.24549 3.1099.603 1.176.92341 1.503.82064 1.9147 1.82633.2442 1.02557-.0455 1.16344-.4632 2.59022z" fill="#3d3d54" class="logo-dark" /><path d="m40.9296 18.6751c.0132-.0126 6.6421-7.8259 7.1189-8.3852.0894-.77105 2.117 2.5153 2.3009 2.6458.7089-.6621 2.1164-3.23915 2.5053-2.61.4216.4963 5.8581 6.8999 6.6773 7.8648 2.0733 1.2233-18.361.138-18.6024.4846z" fill="#358572" class="logo-light" /><path d="m41.0971.00372775c.009.00157633 17.5809-.00105088 18.2615 0 1.5602-.20607875-6.7348 8.19912225-6.7218 8.60570225l-2.2007-2.59222c-1.0568 1.06392-1.9745 2.96739-2.6425 2.07025-.7686-.92878-6.6803-8.0642909-6.6965-8.08373225z" fill="#358572" class="logo-light" /><path d="m48.8552 9.33943 1.5814-1.86238c2.5228 2.53025 1.0985 2.01991 0 3.72485z" fill="#358572" class="logo-light" /><path d="m.0328369 31.5772v8.0157h7.8189131c-.3019.0954-7.534625-9.0739-7.8189131-8.0157z" fill="#3d3d54" class="logo-dark" /><path d="m6.48298 20.2646h-6.4501151c-.006187 8.5858-1.2255549 3.3839 11.7905351 18.9676.4133.4027.1224.3463.5696.3608 8.6009-.0151 5.8354 1.0368 6.2386-5.863-.6136-.6797-12.14033-13.4562-12.14862-13.4654z" fill="#3d3d54" class="logo-dark" /><path d="m18.6567 28.8815c-.3146-11.6123 2.1523-8.0603-7.5783-8.6166z" fill="#3d3d54" class="logo-dark" /><path d="m39.0281 36.8584c-.0049.0012-11.6881.0736-16.4101.1038-1.5816.0573-1.4821-.0881-2.168.0759-.7537 1.6703-.0558 2.7667.5611 2.5116h17.6907c1.1231.4432 1.0427-2.6263.3263-2.6913z" fill="#358572" class="logo-light" /><path d="m39.1238 20.1669c-.0067.0025-17.9765-.0019-18.5223 0 .0209.026-.0559-.0862-.3316.1837-.0839 1.8949-.4766 5.6949.7826 5.3181h17.1468c.602.0663 1.5009-.0639 1.2942-1.7297-.1334-1.9354.353-3.6264-.3697-3.7721z" fill="#358572" class="logo-light" /><path d="m39.3568 34.8035c-5.1633-13.2989-18.5447-6.2332-18.7054.4823 2.6119-.3214 19.7126.6924 18.7054-.4823z" fill="#358572" class="logo-light" /><path d="m8.75269 41.5298c.00419.0047.2673 11.312.3795 15.8822.2091 1.5307-.32225 1.4344.27726 2.0983 6.10315.7296 10.10985.054 9.17785-.5432.0007-2.1819.0007-14.9338.0007-17.1214 1.6185-1.0871-9.59748-1.0092-9.83531-.3159z" fill="#358572" class="logo-light" /><path d="m6.87339 41.2113c-12.1621 4.9973-5.70034 17.9482.44138 18.1038-.29425-2.528.63285-19.0787-.44138-18.1038z" fill="#358572" class="logo-light" /><g fill="#3d3d54" class="logo-dark" ><path d="m59.3868 39.5734c-10.1274-.2732-15.8388 1.8159-18.151-5.7739-.5458-1.4167-.1739-12.0221-.2754-13.6345h1.9537c-.4607 20.5478.409 16.8427 16.4727 17.2307z"/><path d="m59.4599 35.6208c-14.1077.1634-15.036.8472-14.6391-15.4328h1.9537c-.3762 16.0523.3532 12.8954 12.6859 13.255z"/><path d="m59.5333 31.6682c-10.4418.2005-11.1492.2826-10.8529-11.4573h1.9539c-.2918 11.5356.2886 8.9501 8.8992 9.2794z"/><path d="m59.6066 27.7157c-6.817.2362-7.2516-.3205-7.0662-7.4823h1.9536c-.2202 6.9513.2399 5.0163 5.1126 5.304z"/><path d="m59.6797 23.763c-3.0339.2407-3.39-.8288-3.2794-3.5062h1.9537v1.3285h1.3257z"/><path d="m47.7715 58.0552c.2361-.7003.6236-1.5727.9427-2.2754-2.3616-.5734-.5984-2.7077-.0169-4.4171-2.4503-.7417-.3278-3.1375-.0282-4.4808-3.0284-1.0674 1.0778-3.9057-.6128-5.1371-.0576-.219.0629-.3654.2906-.611h-7.4173v18.6388h6.8411c-.4082-.4845-.1954-1.126.0008-1.7174z"/><path d="m53.3237 41.1342c.9422 2.0102-2.1726 3.3839.1561 4.8014.7638 1.4092-2.2558 3.3824-.1647 4.2284.2119.2242.3177.6314.2097 1.0916-2.0029 4.7335-.5477 1.642.0726 4.2152-2.2238 4.8305.2114 2.8367-.8622 4.3023h6.8057c-.4643-23.6511 2.393-17.8952-6.2172-18.6389z"/><path d="m31.8145 52.7696c-5.5453.122-4.6015.3895-4.1756-4.6029 5.3495-.2865 4.5639-.2996 4.6101 1.7838-.1157 1.8324.3411 2.5836-.4345 2.8191z"/><path d="m34.8644 55.7154c-13.9396-.4611-9.9898 3.0325-10.4313-10.3438-.0274-.5401 8.3607-.0616 10.1648-.2082.8171-.0922.7087.4414.7012 1.7887-.2033 3.3495.4914 8.8466-.4347 8.7633zm-8.8242-1.1896c10.7309-.2645 7.6421 2.0686 7.9682-7.9647-.072-.5243-6.0946-.0717-7.7075-.2081-.852-.0934-.6865.477-.6949 1.9699.1754 2.8928-.4469 6.1564.4342 6.2029z"/><path d="m39.0955 59.8018c-.002-.0056-11.0476.0041-16.0831 0-1.8371-.1015-2.6644.3118-2.8693-.4227.0683-.6621-.1212-17.694.0592-18.0934.108-.5553 7.245-.0514 12.9352-.2084 4.2098.1508 6.4272-.4241 6.3926.4948v15.5996c-.1075 1.6326.3265 2.4163-.4346 2.6301zm-14.8229-3.5686c15.3443-.5392 11.0087 3.4289 11.5036-11.3793-.3319-.5291-4.1509-.0682-7.7858-.208-3.2392.1201-4.2858-.4491-4.1526.7974.2284 2.4411-.5303 11.0237.4348 10.7899z"/></g></svg>';
}
add_shortcode( 'logo', 'wpad_site_logo' );
add_filter( 'widget_text', 'do_shortcode');
add_filter( 'widget_text', 'shortcode_unautop');

/**
 * Change speakers rewrite slug for more generic use.
 *
 * @param array  $args Post type arguments.
 * @param string $post_type Post type name.
 *
 * @return array
 */
function wpad_speakers_slug( $args, $post_type ) {
	if ( 'wpcsp_speaker' === $post_type ){
		$args['rewrite']['slug'] = 'people';
	}
 
	return $args;
}
add_filter( 'register_post_type_args', 'wpad_speakers_slug', 10, 2 );

/**
 * Replace the table of contents script with customized version.
 *
 * @param string Original src url.
 *
 * @return string
 */
function wpad_replace_optout( $src ) {
	if ( false !== strpos( $src, 'optout.js' ) ) {
		return get_stylesheet_directory_uri() . '/js/optout.js';
	}

	return $src;
}
add_filter( 'script_loader_src', 'wpad_replace_optout', 10 );

/**
 * Inline shortcode to generate event start time.
 *
 * @return string
 */
function wpad_event_start( $atts = array(), $content = '' ) {
	return '<time class="event-time" datetime="2022-11-02T14:45:00Z" data-time="2022-11-02T14:45:00Z">14:45 UTC</span>';
}
add_shortcode( 'wpad', 'wpad_event_start' );

/**
 * Fetch Gravity Forms donors.
 */
function wpad_get_donors() {
	global $wpdb;
	$donors  = array();
	$query   = "SELECT * FROM wp_gf_entry WHERE form_id = 6";
	$entries = $wpdb->get_results( $query );
	foreach ( $entries as $entry ) {
		$meta_query = "SELECT * FROM wp_gf_entry_meta WHERE entry_id = $entry->id";
		$meta       = $wpdb->get_results( $meta_query );
		$data       = array();
		foreach ( $meta as $value ) {
			$data['payment_date'] = $entry->payment_date;
			$data['paid']         = $entry->payment_status;
			switch ( $value->meta_key ) {
				case '6':
					$data['amount'] = $entry->payment_amount;
					break;
				case '3.3':
					$data['first_name'] = $value->meta_value;
					break;
				case '3.6':
					$data['last_name'] = $value->meta_value;
					break;
				case '5':
					$data['email'] = $value->meta_value;
					break;
				case '4':
					$data['company'] = $value->meta_value;
					break;
				case '8.3':
					$data['city'] = $value->meta_value;
					break;
				case '8.4':
					$data['state'] = $value->meta_value;
					break;
				case '8.6':
					$data['country'] = $value->meta_value;
					break;
				case '11':
					$data['public'] = $value->meta_value;
					break;
			}
		}
		if ( $data['public'] !== 'Yes, you can list my name, company, and location on the WP Accessibility Day list of donors.' || $data['paid'] !== 'Paid' ) {
			continue;
		} else {
			$donors[] = $data;
		}
	}

	return $donors;
}

/**
 * Display donors who agreed to be displayed.
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Contained content.
 *
 * @return string
 */
function wpad_display_donors( $atts = array(), $content = '' ) {
	$donors = wpad_get_donors();
	$output = '';
	foreach ( $donors as $donor ) {
		$name     = $donor['first_name'] . ' ' . $donor['last_name'];
		$company  = $donor['company'];
		if ( $donor['city'] === $donor['state'] ) {
			$loc = $donor['city'];
		} else {
			$loc = $donor['city'] . ', ' . $donor['state'];
		}
		$location = $loc . ', ' . $donor['country'];
		$location = ( $company ) ? ', ' . $location : $location;
		$output .= '<li><strong>' . esc_html( $name ) . '</strong><br /> ' . esc_html( $company . $location ) . '</li>';
	}

	return '<ul class="wpad-donors">' . $output . '</ul>';
}

/**
 * Add donor shortcode.
 */
add_shortcode( 'donors', 'wpad_display_donors', 10, 2 );


/**
 * Fetch Gravity Forms microsponsors.
 */
function wpad_get_microsponsors() {
	global $wpdb;
	$sponsors = array();
	$query    = "SELECT * FROM wp_gf_entry WHERE form_id = 13";
	$entries  = $wpdb->get_results( $query );
	foreach ( $entries as $entry ) {
		$meta_query = "SELECT * FROM wp_gf_entry_meta WHERE entry_id = $entry->id";
		$meta       = $wpdb->get_results( $meta_query );
		$data       = array();
		foreach ( $meta as $value ) {
			$data['payment_date'] = $entry->payment_date;
			$data['paid']         = $entry->payment_status;
			switch ( $value->meta_key ) {
				case '1.3':
					$data['first_name'] = $value->meta_value;
					break;
				case '1.6':
					$data['last_name'] = $value->meta_value;
					break;
				case '5':
					$data['email'] = $value->meta_value;
					break;
				case '6':
					$data['company'] = $value->meta_value;
					break;
				case '1.3':
					$data['fname'] = $value->meta_value;
					break;
				case '1.6':
					$data['lname'] = $value->meta_value;
					break;
				case '16':
					$data['link'] = $value->meta_value;
					break;
				case '12':
					$data['image'] = $value->meta_value;
					break;
				case '23':
					$data['paid'] = $value->meta_value;
					break;
				case '26':
					$data['public'] = $value->meta_value;
					break;
			}
		}
		if ( $data['public'] !== 'Yes' || (string) $data['paid'] === '0' ) {
			continue;
		} else {
			$sponsors[] = $data;
		}
	}

	return $sponsors;
}

/**
 * Display microsponsors who agreed to be displayed.
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Contained content.
 *
 * @return string
 */
function wpad_display_microsponsors( $atts = array(), $content = '' ) {
	$args = shortcode_atts(
		array(
			'maxheight' => '80px',
		),
		$atts,
		'microsponsors'
	);
	$mh       = $args['maxheight'];
	$sponsors = wpad_get_microsponsors();
	$output   = '';
	if ( is_array( $sponsors ) && count( $sponsors ) > 0 ) {
		foreach ( $sponsors as $sponsor ) {
			$name     = $sponsor['first_name'] . ' ' . $sponsor['last_name'];
			$company  = $sponsor['company'];
			$link     = $sponsor['link'];
			$image    = $sponsor['image'];
			if ( ! $image ) {
				continue;
			}
			$wrap     = ( wp_http_validate_url( $link ) ) ? '<a href="' . esc_url( $link ) . '">' : '';
			$unwrap   = ( '' !== $wrap ) ? '</a>' : '';

			$label = ( $company ) ? $company : $name;
			$output .= '<li class="wpcsp-sponsor"><div class="wpcsp-sponsor-description">' . $wrap . '<img class="wpcsp-sponsor-image" src="' . esc_url( $image ) . '" alt="' . esc_html( $label ) . '" style="width: auto; max-height: ' . esc_attr( $mh ) . '" />' . $unwrap . '</div></li>';
		}
	}

	return '<ul class="wpcsp-sponsor-list wpad-microsponsors">' . $output . '</ul>';
}

/**
 * Add microsponsor shortcode.
 */
add_shortcode( 'microsponsors', 'wpad_display_microsponsors', 10, 2 );

/**
 * Filter 'Protected:' out of password protected post titles.
 *
 * @return string
 */
function wpad_remove_protected_text() {
	return '%s';
}
add_filter( 'protected_title_format', 'wpad_remove_protected_text' );


/**
 * Add custom paths to Yoast breadcrumbs.
 *
 * @param string $link_output Original string.
 * @param array  $link Array of link data.
 *
 * @return string
 */
function wpad_breadcrumbs( $link_output, $link ) {
	$id = isset( $link['id'] ) ? $link['id'] : get_queried_object_id();

	if ( 'wpcsp_sponsor' === get_post_type( $id ) ) {
		return '<a href="' . home_url( '/sponsors/' ) . '">Sponsors</a>' . ' / ' . $link['text'];
	}

	if ( 'wpcs_session' === get_post_type( $id ) ) {
		return '<a href="' . home_url( '/schedule/' ) . '">Schedule</a>' . ' / ' . $link['text'];
	}

	return $link_output;
}
add_filter( 'wpseo_breadcrumb_single_link', 'wpad_breadcrumbs', 10, 2 );

/**
* Gravity Forms Custom Activation Template
* http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
*/
function custom_maybe_activate_user() {
	$template_path    = STYLESHEETPATH . '/templates/gravity-forms/activate.php';
	$is_activate_page = isset( $_GET['gfur_activation'] );

	if( ! file_exists( $template_path ) || ! $is_activate_page ) {
		return;
	}

	require_once( $template_path );

	exit();
}
add_action('wp', 'custom_maybe_activate_user', 9);
