<?php

namespace WP_Accessibility_Day;

class Theme {
	/**
	 * A single instance of this object.
	 */
	private static $instance = null;

	/**
	 * Get an instance.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Enqueue styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Setup i18n.
	}

	/**
	 * Enqueues Styles.
	 */
	public function enqueue_styles() {
		$parent_style = 'gutenbergbase-style';

		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
		wp_enqueue_style(
			'wpaccessibilityday-style',
			get_stylesheet_directory_uri() . '/style.css',
			array( $parent_style ),
			wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_style(
			'karla-font',
			'https://fonts.googleapis.com/css?family=Karla:400,700&display=swap',
			array( $parent_style ),
			wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_style(
			'patua-one-font',
			'https://fonts.googleapis.com/css?family=Patua+One&display=swap',
			array( $parent_style ),
			wp_get_theme()->get( 'Version' )
		);
	}
}
