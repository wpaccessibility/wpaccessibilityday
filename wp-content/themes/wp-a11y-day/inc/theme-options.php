<?php 

/**
 * Set up a WP-Admin page for managing turning on and off theme features.
 */
function wp_accessibility_day_add_options_page() {
	add_theme_page(
		'Theme Options',
		'Theme Options',
		'manage_options',
		'wp-accessibility-day-options',
		'wp_accessibility_day_options_page'
	);

	// Call register settings function
	add_action( 'admin_init', 'wp_accessibility_day_options' );
}
add_action( 'admin_menu', 'wp_accessibility_day_add_options_page' );


/**
 * Register settings for the WP-Admin page.
 */
function wp_accessibility_day_options() {
	register_setting( 'wp-accessibility-day-options', 'wp-accessibility-day-align-wide', array( 'default' => 1 ) );
	register_setting( 'wp-accessibility-day-options', 'wp-accessibility-day-wp-block-styles', array( 'default' => 1 ) );
	register_setting( 'wp-accessibility-day-options', 'wp-accessibility-day-editor-color-palette', array( 'default' => 1 ) );
	register_setting( 'wp-accessibility-day-options', 'wp-accessibility-day-dark-mode' );
	register_setting( 'wp-accessibility-day-options', 'wp-accessibility-day-responsive-embeds', array( 'default' => 1 ) );
}


/**
 * Build the WP-Admin settings page.
 */
function wp_accessibility_day_options_page() { ?>
	<div class="wrap">
	<h1><?php _e('Gutenberg Starter Theme Options', 'wp-accessibility-day'); ?></h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'wp-accessibility-day-options' ); ?>
		<?php do_settings_sections( 'wp-accessibility-day-options' ); ?>

			<table class="form-table">
				<tr valign="top">
					<td>
						<label>
							<input name="wp-accessibility-day-align-wide" type="checkbox" value="1" <?php checked( '1', get_option( 'wp-accessibility-day-align-wide' ) ); ?> />
							<?php _e( 'Enable wide and full alignments.', 'wp-accessibility-day' ); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment"><code>align-wide</code></a>)
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<label>
							<input name="wp-accessibility-day-editor-color-palette" type="checkbox" value="1" <?php checked( '1', get_option( 'wp-accessibility-day-editor-color-palette' ) ); ?> />
							<?php _e( 'Enable a custom theme color palette.', 'wp-accessibility-day' ); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes"><code>editor-color-palette</code></a>)
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<label>
							<input name="wp-accessibility-day-dark-mode" type="checkbox" value="1" <?php checked( '1', get_option( 'wp-accessibility-day-dark-mode' ) ); ?> />
							<?php _e( 'Enable a dark theme style.', 'wp-accessibility-day' ); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#dark-backgrounds"><code>dark-editor-style</code></a>)
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<label>
							<input name="wp-accessibility-day-wp-block-styles" type="checkbox" value="1" <?php checked( '1', get_option( 'wp-accessibility-day-wp-block-styles' ) ); ?> />
							<?php _e( 'Enable core block styles on the front end.', 'wp-accessibility-day' ); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles"><code>wp-block-styles</code></a>)
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<label>
							<input name="wp-accessibility-day-responsive-embeds" type="checkbox" value="1" <?php checked( '1', get_option( 'wp-accessibility-day-responsive-embeds' ) ); ?> />
							<?php _e( 'Enable responsive embedded content.', 'wp-accessibility-day' ); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#responsive-embedded-content"><code>responsive-embeds</code></a>)
						</label>
					</td>
				</tr>
			</table>

		<?php submit_button(); ?>
	</form>
	</div>
<?php }


/**
 * Enable alignwide and alignfull support if the wp-accessibility-day-align-wide setting is active.
 */
function wp_accessibility_day_enable_align_wide() {

	if ( get_option( 'wp-accessibility-day-align-wide', 1 ) == 1 ) {
		
		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );
	}
}
add_action( 'after_setup_theme', 'wp_accessibility_day_enable_align_wide' );

/**
 * Enable dark mode if wp-accessibility-day-dark-mode setting is active.
 */
function wp_accessibility_day_enable_dark_mode() {
	if ( get_option( 'wp-accessibility-day-dark-mode' ) == 1 ) {
		
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style-editor-dark.css' );
		
		// Add support for dark styles.
		add_theme_support( 'dark-editor-style' );
	}
}
add_action( 'after_setup_theme', 'wp_accessibility_day_enable_dark_mode' );


/**
 * Enable dark mode on the front end if wp-accessibility-day-dark-mode setting is active.
 */
function wp_accessibility_day_enable_dark_mode_frontend_styles() {
	if ( get_option( 'wp-accessibility-day-dark-mode' ) == 1 ) {
		wp_enqueue_style( 'wp-accessibility-daydark-style', get_template_directory_uri() . '/css/dark-mode.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_accessibility_day_enable_dark_mode_frontend_styles' );

/**
 * Enable core block styles support if the wp-accessibility-day-wp-block-styles setting is active.
 */
function wp_accessibility_day_enable_wp_block_styles() {

	if ( get_option( 'wp-accessibility-day-wp-block-styles', 1 ) == 1 ) {
		
		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );
	}
}
add_action( 'after_setup_theme', 'wp_accessibility_day_enable_wp_block_styles' );


/**
 * Enable responsive embedded content if the wp-accessibility-day-responsive-embeds setting is active.
 */
function wp_accessibility_day_enable_responsive_embeds() {

	if ( get_option( 'wp-accessibility-day-responsive-embeds', 1 ) == 1 ) {
		
		// Adding support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}
}
add_action( 'after_setup_theme', 'wp_accessibility_day_enable_responsive_embeds' );