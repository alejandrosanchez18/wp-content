<?php
/**
 * Plugin Name:       White Label Branding for Elementor
 * Plugin URI:        https://powerpackelements.com/white-label-elementor/
 * Description:       White Label Branding for Elementor. 
 * Version:           1.0.4
 * Author:            IdeaBox Creations
 * Author URI:        https://ideaboxcreations.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       el-whitelabel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' )) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'EL_WL_VER', '1.0.4' );
define( 'EL_WL_DIR', plugin_dir_path( __FILE__ ) );
define( 'EL_WL_URL', plugins_url( '/', __FILE__ ) );
define( 'EL_WL_PATH', plugin_basename( __FILE__ ) );

final class Elementor_Whitelabel_Plugin {

	/**
	 * Holds any errors that may arise from
	 * saving admin settings.
	 *
	 * @since 1.0.0
	 * @var array $errors
	 */
	static public $errors = array();


    /**
     * Holds the plugin settings page slug.
     *
     * @since 1.0.0
     * @var string
     */
    static public $settings_page = 'el-wl-settings';

    /**
	 * Initializes the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function init()
	{
		if ( ! function_exists( '_is_elementor_installed' ) ) {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
				return;
			}
		}

		require_once EL_WL_DIR . 'classes/class-el-branding.php';
		add_action( 'plugins_loaded', __CLASS__ . '::init_hooks' );
	}

	/**
	 * Adds the admin menu and enqueues CSS/JS if we are on
	 * the plugin's admin settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function init_hooks()
	{
		if ( ! is_admin() ) {
			return;
		}

		include EL_WL_DIR . 'includes/updater/update-config.php';

		self::save_settings();

		if ( isset( $_GET['el_wl_reset'] ) ) {
			el_wl_plugin_activation();
		}

        add_action( 'admin_menu', __CLASS__ . '::menu', 100 );
        add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );

	}

    static public function is_valid_page()
    {
		if ( is_admin() && isset( $_GET['page'] ) && self::$settings_page == $_GET['page'] ) {
            return true;
        }

        return false;

    }

	static public function menu()
	{
		if ( is_multisite() && ! is_main_site() ) {
			$branding = Elementor_Whitelabel::get_branding();

			if ( isset( $branding['multisite_hide_settings'] ) && 'on' == $branding['multisite_hide_settings'] ) {
				return;
			}
		}

        $admin_label = __('White Label', 'el-whitelabel');

		if ( current_user_can( 'manage_options' ) ) {

			$title = $admin_label;
			$cap   = 'manage_options';
			$slug  = self::$settings_page;
			$func  = __CLASS__ . '::render';

			add_submenu_page( 'elementor', $title, $title, $cap, $slug, $func );
		}
	}
	
	static public function enqueue_scripts($hook)
	{
		if ( strpos( $hook, 'el-wl-settings' ) === false ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'el-wl-style', EL_WL_URL . 'assets/css/admin.css', array(), EL_WL_VER );
		wp_enqueue_script( 'el-wl-script', EL_WL_URL . 'assets/js/admin.js', array('jquery'), EL_WL_VER, true );
	}

     /**
	 * Renders the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function render()
	{
		Elementor_Whitelabel::render_fields();
	}

	/**
	 * Renders the action for a form.
	 *
	 * @since 1.0.0
	 * @param string $type The type of form being rendered.
	 * @return void
	 */
	static public function get_form_action( $type = '' )
	{
		return admin_url( '/admin.php?page=' . self::$settings_page . $type );
	}

	/**
	 * Renders the update message.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function render_update_message()
	{
		if ( ! empty( self::$errors ) ) {
			foreach ( self::$errors as $message ) {
				echo '<div class="error el-wl-message"><p>' . $message . '</p></div>';
			}
		}

		if ( isset( $_GET['message'] ) ) {
			echo '<div class="error el-wl-message"><p>' . $_GET['message'] . '</p></div>';
		}

		if ( isset( $_POST['el_wl_nonce'] ) && isset( $_POST['submit'] ) ) {
			echo '<div class="notice notice-success el-wl-message"><p>' . __('Settings saved.', 'el-whitelabel') . '</p></div>';
		}
	}

	static public function save_settings()
	{
		if ( ! isset( $_POST['el_wl_nonce'] ) || ! wp_verify_nonce( $_POST['el_wl_nonce'], 'el_wl_nonce' ) ) {
			return;
		}

		if ( ! isset( $_POST['submit'] ) ) {
			return;
		}

		self::save_license();
		self::save_branding();
	}

	static public function save_license()
	{
		if ( isset( $_POST['el_wl_license_key'] ) ) {
			$license_key = trim( $_POST['el_wl_license_key'] );

			update_option( '_el_wl_license_key', $license_key );
		}
	}

	/**
	 * Saves the branding.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
    static public function save_branding()
    {
        Elementor_Whitelabel::update_branding();
    }
}
Elementor_Whitelabel_Plugin::init();

register_activation_hook( __FILE__, 'el_wl_plugin_activation' );
function el_wl_plugin_activation()
{
	$branding = get_option( '_el_whitelabel' );
	
	if ( is_array( $branding ) ) {
		if ( isset( $branding['hide_admin_menu'] ) ) {
			$branding['hide_admin_menu'] = 'off';
		}
		if ( isset( $branding['hide_plugin'] ) ) {
			$branding['hide_plugin'] = 'off';
		}
		if ( isset( $branding['hide_el_plugin'] ) ) {
			$branding['hide_el_plugin'] = 'off';
		}
		if ( isset( $branding['hide_settings'] ) ) {
			$branding['hide_settings'] = 'off';
		}

		update_option( '_el_whitelabel', $branding );
	}
}