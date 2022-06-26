<?php 

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'WPCSP_STORE_URL', 'https://my.equalizedigital.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the download ID for the product in Easy Digital Downloads
define( 'WPCSP_ITEM_ID', 24 ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of the product in Easy Digital Downloads
define( 'WPCSP_ITEM_NAME', 'Accessibility Checker' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of the settings page for the license input to be displayed
define( 'EDD_PLUGIN_LICENSE_PAGE', 'accessibility_checker_settings' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
    // load our custom updater
	include( dirname( __FILE__ ) . '/classes/EDD_SL_Plugin_Updater.php' );
}

/**
 * Initialize the updater. Hooked into `init` to work with the
 * wp_version_check cron job, which allows auto-updates.
 */
function wpcsp_plugin_updater() {

	// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
	$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
	if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
		return;
	}

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'wpcsp_license_key' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( WPCSP_STORE_URL, WPCSP_PLUGIN_FILE,
		array(
			'version' => WPCSP_VERSION,                    // current version number
			'license' => $license_key,             // license key (used get_option above to retrieve from DB)
			'item_id' => WPCSP_ITEM_ID,       // ID of the product
			'author'  => 'Equalize Digital', // author of this plugin
			'beta'    => false,
		)
	);

}
add_action( 'init', 'wpcsp_plugin_updater' );


/************************************
* the code below is just a standard
* options page. Substitute with
* your own.
*************************************/

/* function wpcsp_sample_license_menu() {
	add_menu_page('Plugin License', 'Plugin License','manage_options', EDD_PLUGIN_LICENSE_PAGE,'wpcsp_sample_license_page' );
}
add_action('admin_menu', 'wpcsp_sample_license_menu'); */

add_action('edac_license_tab', function(){
	wpcsp_sample_license_page();
});

function wpcsp_sample_license_page() {
	$license = get_option( 'wpcsp_license_key' );
	$status  = get_option( 'wpcsp_license_status' );
	?>
		<form method="post" action="options.php">

			<?php settings_fields('wpcsp_license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="wpcsp_license_key" name="wpcsp_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="wpcsp_license_key">
							<?php
							if( $status !== false && $status == 'valid' ) {
								?>
								<span style="color:green;"><?php _e('active'); ?></span>
								<?php
							}else if( $status !== false && $status == 'expired' ) {
								?>
								<span style="color:red;"><?php _e('expired'); ?></span>
								<?php
							}else{
								_e('Enter your license key');
							}
							?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php //_e('Activate License'); ?>
						</th>
						<td>
							<?php if( $status !== false && $status == 'valid' ) { ?>
								<?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
								<input type="submit" class="button-primary" name="edd_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
							<?php } else {
								wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
								<input type="submit" class="button-primary" name="edd_license_activate" value="<?php _e('Activate License'); ?>"/>
							<?php } ?>	
						</td>
					</tr>
				</tbody>
			</table>
			
		</form>
	<?php
}

function wpcsp_sample_register_option() {
	// creates our settings in the options table
	register_setting('wpcsp_license', 'wpcsp_license_key', 'wpcsp_sanitize_license' );
}
add_action('admin_init', 'wpcsp_sample_register_option');

function wpcsp_sanitize_license( $new ) {
	$old = get_option( 'wpcsp_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'wpcsp_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}



/************************************
* this illustrates how to activate
* a license key
*************************************/

function wpcsp_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'edd_sample_nonce', 'edd_sample_nonce' ) )
			return; // get out if we didn't click the Activate button

		// sanitize and update license key option
		if(isset($_POST['wpcsp_license_key'])){
			$license = wpcsp_sanitize_license($_POST['wpcsp_license_key']);
			update_option( 'wpcsp_license_key', $license);
		}

		// retrieve the license from the database
		$license = trim( get_option( 'wpcsp_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( WPCSP_ITEM_NAME ), // the name of our product in EDD
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( WPCSP_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// save license error as an option
			update_option('wpcsp_license_error', $license_data->error);

			/* if ( false === $license_data->success ) {

				switch( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
							__( 'Your license key expired on %s.' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'disabled' :
					case 'revoked' :

						$message = __( 'Your license key has been disabled.' );
						break;

					case 'missing' :

						$message = __( 'Invalid license.' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.' );
						break;

					case 'item_name_mismatch' :

						$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), WPCSP_ITEM_NAME );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.' );
						break;

					default :

						$message = __( 'An error occurred, please try again.' );
						break;
				}

			} */

		}

		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'admin.php?page=' . EDD_PLUGIN_LICENSE_PAGE .'&tab=license' );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		// $license_data->license will be either "valid" or "invalid"
		if($license_data->license == 'valid'){
			set_transient( 'wpcsp_license_valid', true, 24 * HOUR_IN_SECONDS );
			wpcsp_scan_start();
		}
		update_option( 'wpcsp_license_status', $license_data->license );
		wp_redirect( admin_url( 'admin.php?page=' . EDD_PLUGIN_LICENSE_PAGE . '&tab=license' ) );
		exit();
	}
}
add_action('admin_init', 'wpcsp_activate_license');


/***********************************************
* Illustrates how to deactivate a license key.
* This will decrease the site count
***********************************************/

function wpcsp_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'edd_sample_nonce', 'edd_sample_nonce' ) )
			return; // get out if we didn't click the Activate button

		wpcsp_deactivate_process(home_url(),true);

	}
}
add_action('admin_init', 'wpcsp_deactivate_license');

function wpcsp_deactivate_process($url, $redirect) {
	// retrieve the license from the database
	$license = trim( get_option( 'wpcsp_license_key' ) );

	// data to send in our API request
	$api_params = array(
		'edd_action' => 'deactivate_license',
		'license'    => $license,
		'item_name'  => urlencode( WPCSP_ITEM_NAME ), // the name of our product in EDD
		'url'        => $url
	);

	// Call the custom API.
	$response = wp_remote_post( WPCSP_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

	// make sure the response came back okay
	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

		if ( is_wp_error( $response ) ) {
			$message = $response->get_error_message();
		} else {
			$message = __( 'An error occurred, please try again.' );
		}

		if($redirect == true){
			$base_url = admin_url( 'admin.php?page=' . EDD_PLUGIN_LICENSE_PAGE . '&tab=license' );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}
	}

	// decode the license data
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	// $license_data->license will be either "deactivated" or "failed"
	if( $license_data->license == 'deactivated' ) {
		delete_option( 'wpcsp_license_key' );
		delete_option( 'wpcsp_license_status' );
		delete_transient('wpcsp_license_valid');
	}

	if($redirect == true){
		wp_redirect( admin_url( 'admin.php?page=' . EDD_PLUGIN_LICENSE_PAGE . '&tab=license' ) );
		exit();
	}
}


/************************************
* this illustrates how to check if
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

function wpcsp_deactivate_license_on_domain_change(){
	$wpcsp_license_url = base64_decode(get_option('wpcsp_license_url'));
	
	if(!$wpcsp_license_url){
		update_option('wpcsp_license_url',base64_encode(home_url()));
	}
	
	$wpcsp_license_url = base64_decode(get_option('wpcsp_license_url'));

	if($wpcsp_license_url != home_url()){
		wpcsp_deactivate_process($wpcsp_license_url, false);
		delete_option('wpcsp_license_url');
	}
}

function wpcsp_check_license() {

	wpcsp_deactivate_license_on_domain_change();

	if (get_transient( 'wpcsp_license_valid' ) == true) return;

	global $wp_version;

	$license = trim( get_option( 'wpcsp_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( WPCSP_ITEM_NAME ),
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_post( WPCSP_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );
	

	if( $license_data->license == 'valid' ) {
		//echo 'valid'; exit;
		// this license is still valid

		set_transient( 'wpcsp_license_valid', true, 24 * HOUR_IN_SECONDS );


	} else {
		delete_transient('wpcsp_license_valid');
		update_option( 'wpcsp_license_status', $license_data->license );
		//echo 'invalid'; exit;
		// this license is no longer valid
	}
}
add_action('admin_init', 'wpcsp_check_license');

/**
 * This is a means of catching errors from the activation method above and displaying it to the customer
 */
function wpcsp_admin_notices() {

	$error = get_option('wpcsp_license_error');
	$license_url = get_bloginfo('url').'/wp-admin/admin.php?page=accessibility_checker_settings&tab=license';

	if ( $error ) {

		switch( $error ) {

			case 'expired' :

				$message = sprintf(
					__( 'Your %s license has expired. This plugin requires an active license key to function. <a href="https://products.equalizedigital.com/?utm_source=wpadmin" target="_blank">Please renew your license</a> to continue using %s.' ),
					WPCSP_ITEM_NAME,WPCSP_ITEM_NAME
				);
				break;

			case 'disabled' :
			case 'revoked' :

				$message = sprintf(
					__( 'Your %s license key has been disabled.' ),
					WPCSP_ITEM_NAME
				);
				break;

			case 'missing' :

				$message = sprintf(
					__( 'Your %s license is invalid. This plugin requires an active license key to function. Please <a href="%s">reenter your license key</a> or <a href="https://products.equalizedigital.com/?utm_source=wpadmin" target="_blank">purchase a new key</a> to use %s.' ),
					WPCSP_ITEM_NAME, $license_url, WPCSP_ITEM_NAME
				);
				break;

			case 'invalid' :
			case 'site_inactive' :

				$message = sprintf(
					__( 'Your %s license is not active for this URL.' ),
					WPCSP_ITEM_NAME
				);
				break;

			case 'item_name_mismatch' :

				$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), WPCSP_ITEM_NAME );
				break;

			case 'no_activations_left':

				$message = sprintf( __( 'Your %s license key has reached its activation limit.' ), WPCSP_ITEM_NAME);
				break;

			default :

				$message = sprintf( __( 'An error occurred trying to activate %s., please try again.' ), WPCSP_ITEM_NAME);
				break;
		}

		

	}elseif(!get_transient( 'wpcsp_license_valid' )){

		$message = sprintf(
			__( 'Thank you for activating %s. This plugin requires an active license key to function. Please <a href="%s">enter your license key</a>.' ),
			WPCSP_ITEM_NAME, $license_url
		);
	}

	if(isset($message)){
		$class = 'notice notice-error';
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
	}

	/* if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {

		switch( $_GET['sl_activation'] ) {

			case 'false':
				$message = urldecode( $_GET['message'] );
				?>
				<div class="error">
					<p><?php echo $message; ?></p>
				</div>
				<?php
				break;

			case 'true':
			default:
				// Developers can put a custom success message here for when activation is successful if they way.
				break;

		}
	} */
}
add_action( 'admin_notices', 'wpcsp_admin_notices' );
