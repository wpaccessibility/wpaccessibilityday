<?php

/**
 * Custom options and settings
 *
 * @return void
 */
function wpcsp_settings_init() {

	// register schedule page URL setting for "wpcs" page
	register_setting("wpcs", "wpcsp_field_speakers_page_url", "wpcsp_sanitize_field_speakers_page_url");
 
	// register schedule page URL field in the "wpcs_section_info" section, inside the "wpcs" page
	add_settings_field("wpcsp_field_speakers_page_url", "Speakers Page URL", "wpcsp_field_speakers_page_url_cb", "wpcs", "wpcs_section_settings");

	// register schedule page URL setting for "wpcs" page
	register_setting("wpcs", "wpcsp_field_sponsor_page_url", "wpcsp_sanitize_field_sponsor_page_url");
 
	// register schedule page URL field in the "wpcs_section_info" section, inside the "wpcs" page
	add_settings_field("wpcsp_field_sponsor_page_url", "Sponsor URL Redirect", "wpcsp_field_sponsor_page_url_cb", "wpcs", "wpcs_section_settings");

}
add_action( 'admin_init', 'wpcsp_settings_init', 11 );

/**
 * Speakers page url callback
 *
 * @return void
 */
function wpcsp_field_speakers_page_url_cb(){
	?>
	<input type="text" name="wpcsp_field_speakers_page_url" value="<?php echo get_option('wpcsp_field_speakers_page_url'); ?>" style="width: 450px;">
	<p class="description">The URL of the page that your speakers are embedded on.</p>
	<?php
}

/**
 * Sanitize the speakers page url value before being saved to database
 *
 * @param string $speakers_page_url
 * @return string
 */
function wpcsp_sanitize_field_speakers_page_url( $speakers_page_url ) {
	return sanitize_text_field($speakers_page_url);
}

/**
 * Sponsor page url callback
 *
 * @return void
 */
function wpcsp_field_sponsor_page_url_cb(){
	$sponsor_url = get_option('wpcsp_field_sponsor_page_url');
	?>
	<select name="wpcsp_field_sponsor_page_url" id="sponsors_url">
		<option value="sponsor_page" <?php if($sponsor_url == "sponsor_page"){ echo "selected";} ?>>Redirect to Sponsor Page</option>
		<option value="sponsor_site" <?php if($sponsor_url == "sponsor_site"){ echo "selected";} ?>>Redirect to Sponsor Site </option>
	</select>
	<p class="description">The location to redirect sponsor links to on the session single page.</p>
	<?php
}

/**
 * Sanitize the sponsor page url value before being saved to database
 *
 * @param string $redirect
 * @return string
 */
function wpcsp_sanitize_field_sponsor_page_url( $redirect ) {
	if($redirect == 'sponsor_page' || $redirect == 'sponsor_site'){
		return $redirect;
	}else{
		return;
	}
}