<?php

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'EL_WL_SL_URL', 'https://powerpackelements.com' );

// the name of your product. This should match the download name in EDD exactly
define( 'EL_WL_ITEM_NAME', 'White Label Branding for Elementor' );

define( 'EL_WL_SETTING_PAGE', self::get_form_action() );

if( ! class_exists( 'ELWL_Plugin_Updater' ) ) {
	// load our custom updater
	include( 'class-el-updater.php' );
}

function el_wl_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( '_el_wl_license_key' ) );

	// setup the updater
	$edd_updater = new ELWL_Plugin_Updater( EL_WL_SL_URL, EL_WL_DIR . '/elementor-whitelabel.php', array(
			'version' 	=> EL_WL_VER, 					// current version number
			'license' 	=> $license_key, 						// license key
			'item_name' => EL_WL_ITEM_NAME, 			// name of this plugin
			'author' 	=> 'IdeaBox Creations' 	// author of this plugin
		)
	);

}
add_action( 'admin_init', 'el_wl_plugin_updater', 0 );

function el_wl_activate_license() {

	// listen for our activate button to be clicked
	if ( isset( $_POST['el_wl_license_key'] ) ) {

		// run a quick security check
	 	if( ! isset( $_POST['el_wl_activate_license'] ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( $_POST['el_wl_license_key'] );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( EL_WL_ITEM_NAME ), // the name of our product in EDD
			'url'       => network_home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( EL_WL_SL_URL, array(
			'timeout' 	=> 15,
			'sslverify' => false,
			'body' 		=> $api_params
		) );

		// make sure the response came back okay
		if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

			if (is_wp_error($response)) {
				$message = $response->get_error_message();
			}
			else {
				$message = __('An error occurred, please try again.', 'el-whitelabel');
			}

		}
		else {
			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if (false === $license_data->success) {

				switch ($license_data->error) {

					case 'expired' :

						$message = sprintf(
							__('Your license key expired on %s.', 'el-whitelabel'),
							date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
						);
						break;

					case 'revoked' :

						$message = __('Your license key has been disabled.', 'el-whitelabel');
						break;

					case 'missing' :

						$message = __('Invalid license.', 'el-whitelabel');
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __('Your license is not active for this URL.', 'el-whitelabel');
						break;

					case 'item_name_mismatch' :

						$message = sprintf(__('This appears to be an invalid license key for %s.', 'el-whitelabel'), EL_WL_ITEM_NAME);
						break;

					case 'no_activations_left':

						$message = __('Your license key has reached its activation limit.', 'el-whitelabel');
						break;

					default :

						$message = __('An error occurred, please try again.', 'el-whitelabel');
						break;
				}
			}
		}

		// Check if anything passed on a message constituting a failure
		if (!empty($message)) {
			$base_url = EL_WL_SETTING_PAGE;
			$redirect = add_query_arg(array('sl_activation' => 'false', 'message' => urlencode($message)), $base_url);

			wp_redirect($redirect);
			exit();
		}

		// $license_data->license will be either "valid" or "invalid"

		update_option( '_el_wl_license_status', $license_data->license );
		update_option( '_el_wl_license_key', $license );

		wp_redirect(EL_WL_SETTING_PAGE);
        exit();
	}
}
add_action( 'admin_init', 'el_wl_activate_license' );

function el_wl_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['el_wl_deactivate_license'] ) && isset( $_POST['el_wl_license_key'] ) ) {

		// retrieve the license from the database
		$license = trim( $_POST['el_wl_license_key'] );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( EL_WL_ITEM_NAME ), // the name of our product in EDD
			'url'       => network_home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( EL_WL_SL_URL, array(
			'timeout' 	=> 15,
			'sslverify' => false,
			'body' 		=> $api_params
		) );

		// make sure the response came back okay
		if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

			if (is_wp_error($response)) {
				$message = $response->get_error_message();
			}
			else {
				$message = __('An error occurred, please try again.', 'el-whitelabel');
			}

			$redirect = add_query_arg(array('sl_activation' => 'false', 'message' => urlencode($message)), EL_WL_SETTING_PAGE);

			wp_redirect($redirect);
			exit();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ) {
			delete_option( '_el_wl_license_status' );
		}

		wp_redirect(EL_WL_SETTING_PAGE);
        exit();
	}
}
add_action( 'admin_init', 'el_wl_deactivate_license' );

/************************************
* check if
* a license key is still valid
* so this is only needed if we
* want to do something custom
*************************************/

function el_wl_check_license( $license_key = '' ) {

	if ( !empty( $license_key ) ) {
		$license = trim( $license_key );
	}
	else {
		$license = get_option( '_el_wl_license_key' );
		$license = trim( $license );
	}

	if ( ! $license || empty( $license ) ) {
		return 'invalid';
	}

	$api_params = array(
		'edd_action' => 'check_license',
		'license' 	=> $license,
		'item_name' => urlencode( EL_WL_ITEM_NAME ),
		'url'       => network_home_url()
	);

	// Call the custom API.
	$response = wp_remote_post( EL_WL_SL_URL, array(
		'timeout' 	=> 15,
		'sslverify' => false,
		'body' 		=> $api_params
	) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	return $license_data->license;
}

 /**
  * Show update message on plugins page
  */
function el_wl_update_message( $plugin_data, $response ) {

	$status = get_option( '_el_wl_license_status' );

	if ( 'valid' != $status || 'valid' != el_wl_check_license() ) {

		$message  = '';
		$message .= '<p style="padding: 5px 10px; margin-top: 10px; background: #d54e21; color: #fff;">';
		$message .= __( '<strong>UPDATE UNAVAILABLE!</strong>', 'el-whitelabel' );
		$message .= '&nbsp;&nbsp;&nbsp;';
		$message .= __( 'Please activate the license key to enable automatic updates for this plugin.', 'el-whitelabel' );

		$message .= ' <a href="' . EL_WL_SL_URL . '" target="_blank" style="color: #fff; text-decoration: underline;">';
		$message .= __( 'Buy Now', 'el-whitelabel' );
		$message .= ' &raquo;</a>';

		$message .= '</p>';

		echo $message;
	}
}
add_action( 'in_plugin_update_message-' . EL_WL_PATH, 'el_wl_update_message', 1, 2 );
