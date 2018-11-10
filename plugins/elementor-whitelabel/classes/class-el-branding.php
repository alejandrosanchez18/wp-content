<?php
/**
 * Handles logic for the plugin branding.
 *
 * @since 1.0.0
 */
class Elementor_Whitelabel {

    /**
	 * Holds the arguments for plugin branding.
	 *
	 * @since 1.0.0
	 * @var array
	 */
    static public $default_data = array();

    /**
     * Holds the plugin branding data.
     *
     * @since 1.0.0
     * @var array
     */
    static public $branding = array();

    /**
	 * Initializes the branding settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
    static public function init()
    {
        self::$default_data = array(
            'plugin_name'       	=> '',
            'plugin_desc'       	=> '',
            'plugin_author'     	=> '',
            'plugin_uri'        	=> '',
            'edit_with_text'    	=> '',
            'disable_pro'       	=> 'off',
            'primary_color'     	=> '',
            'secondary_color'   	=> '',
            'hide_logo'         	=> 'off',
            'hide_external_links'	=> 'off',
			'hide_descriptions'		=> 'off',
			'hide_overview_widget'	=> 'off',
			'hide_intro_page'		=> 'off',
            'hide_settings'     	=> 'off',
            'hide_plugin'       	=> 'off',
			'hide_el_plugin'    	=> 'off',
			'hide_admin_menu'		=> 'off',
			'hide_wl_admin_menu'	=> 'off',
            'hide_my_templates'		=> 'off',
            'hide_settings_page'	=> 'off',
			'hide_custom_fonts'    	=> 'off',
			'hide_role_manager'		=> 'off',
            'hide_tools'    		=> 'off',
            'hide_sys_info'    		=> 'off',
            'hide_knowledge_base'	=> 'off',
			'hide_license_page'    	=> 'off',
			'hide_footer'    		=> 'off',
			'multisite_hide_settings' => 'off'
        );

		add_action( 'wp_head', 					__CLASS__ . '::frontend_scripts' );
        add_action( 'admin_head', 				__CLASS__ . '::branding_styles' );
		add_action( 'elementor/editor/before_enqueue_scripts', __CLASS__ . '::branding_styles' );
		add_action( 'elementor/frontend/after_enqueue_styles', __CLASS__ . '::branding_styles' );
		add_action( 'admin_menu',				__CLASS__ . '::admin_menu', 999 );
		add_filter( 'all_plugins', 				__CLASS__ . '::plugin_branding', 10, 1 );
		add_action( 'plugins_loaded',			__CLASS__ . '::plugin_meta' );
		add_filter( 'gettext', 					__CLASS__ . '::update_label', 20, 3 );
		add_filter( 'admin_footer_text', 		__CLASS__ . '::admin_footer_text', 100 );
		add_action( 'wp_dashboard_setup',		__CLASS__ . '::remove_el_widget', 100 );
    }
	
	static public function frontend_scripts()
	{
		if ( ! is_user_logged_in() ) {
			return;
		}

		$branding = self::get_branding();

		if ( $branding['hide_logo'] == 'on' ) {
			?>
			<style>
			#wpadminbar #wp-admin-bar-elementor_edit_page > .ab-item::before {
				content: none;
			}
			</style>
			<?php
		}
	}

    /**
	 * Render branding styles.
	 *
	 * @since 1.0.0
     * @return void
	 */
    static public function branding_styles()
    {
		if ( ! is_user_logged_in() ) {
			return;
		}
        $branding = self::get_branding();
        echo '<style id="el-wl-admin-style">';
		include EL_WL_DIR . 'includes/style.css.php';
		echo '</style>';
	}

	static public function admin_menu()
	{
		$branding = self::get_branding();

		if ( isset( $_GET['page'] ) && ( 'go_knowledge_base_site' === $_GET['page'] || 'go_elementor_pro' === $_GET['page'] ) ) {
			if ( isset( $branding['plugin_uri'] ) && ! empty( $branding['plugin_uri'] ) ) {
				wp_redirect( $branding['plugin_uri'] );
				die;
			}
		}

		if ( isset( $branding['hide_admin_menu'] ) && 'on' == $branding['hide_admin_menu'] ) {
			remove_menu_page( 'elementor' );
			remove_menu_page( 'edit.php?post_type=elementor_library' );
		}
	}

    /**
	 * Render branding fields.
	 *
	 * @since 1.0.0
     * @return void
	 */
    static public function render_fields()
    {
        $branding = self::get_branding();
        include EL_WL_DIR . 'includes/admin-settings-branding.php';
    }

    /**
	 * Get the branding data from options.
	 *
	 * @since 1.0.0
	 * @return array
	 */
    static public function get_branding( $cache = true )
    {
		if ( ! is_array( self::$branding ) || empty( self::$branding ) ) {
			if ( is_multisite() ) {
				self::$branding = get_blog_option( 1, '_el_whitelabel');
			} else {
				self::$branding = get_option( '_el_whitelabel');
			}
		}

        return self::$branding;
    }

    /**
	 * Add/Update the branding data to options.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
    static public function update_branding()
    {
        if ( ! isset($_POST['el_wl_nonce']) ) {
            return;
        }

        $data = array(
            'plugin_name'       => isset( $_POST['el_wl_plugin_name'] ) ? sanitize_text_field( $_POST['el_wl_plugin_name'] ) : '',
            'plugin_desc'       => isset( $_POST['el_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['el_wl_plugin_desc'] ) : '',
            'plugin_author'     => isset( $_POST['el_wl_plugin_author'] ) ? sanitize_text_field( $_POST['el_wl_plugin_author'] ) : '',
            'plugin_uri'        => isset( $_POST['el_wl_plugin_uri'] ) ? esc_url( $_POST['el_wl_plugin_uri'] ) : '',
            'edit_with_text'    => isset( $_POST['el_wl_edit_with_text'] ) ? sanitize_text_field( $_POST['el_wl_edit_with_text'] ) : self::$default_data['edit_with_text'],
            'disable_pro'    	=> isset( $_POST['el_wl_disable_pro'] ) ? sanitize_text_field( $_POST['el_wl_disable_pro'] ) : self::$default_data['disable_pro'],
            'primary_color'   	=> isset( $_POST['el_wl_primary_color'] ) ? sanitize_hex_color( $_POST['el_wl_primary_color'] ) : self::$default_data['primary_color'],
            'secondary_color'   => isset( $_POST['el_wl_secondary_color'] ) ? sanitize_hex_color( $_POST['el_wl_secondary_color'] ) : self::$default_data['secondary_color'],
            'hide_logo'         => isset( $_POST['el_wl_hide_logo'] ) ? sanitize_text_field( $_POST['el_wl_hide_logo'] ) : self::$default_data['hide_logo'],
			'hide_external_links'	=> isset( $_POST['el_wl_hide_external_links'] ) ? sanitize_text_field( $_POST['el_wl_hide_external_links'] ) : self::$default_data['hide_external_links'],
			'hide_descriptions'     => isset( $_POST['el_wl_hide_descriptions'] ) ? sanitize_text_field( $_POST['el_wl_hide_descriptions'] ) : self::$default_data['hide_descriptions'],
            'hide_overview_widget'  => isset( $_POST['el_wl_hide_overview_widget'] ) ? sanitize_text_field( $_POST['el_wl_hide_overview_widget'] ) : self::$default_data['hide_overview_widget'],
            'hide_intro_page'     	=> isset( $_POST['el_wl_hide_intro_page'] ) ? sanitize_text_field( $_POST['el_wl_hide_intro_page'] ) : self::$default_data['hide_intro_page'],
            'hide_settings'     	=> isset( $_POST['el_wl_hide_settings'] ) ? sanitize_text_field( $_POST['el_wl_hide_settings'] ) : self::$default_data['hide_settings'],
            'hide_plugin'       	=> isset( $_POST['el_wl_hide_plugin'] ) ? sanitize_text_field( $_POST['el_wl_hide_plugin'] ) : self::$default_data['hide_plugin'],
			'hide_el_plugin'    	=> isset( $_POST['el_wl_hide_el_plugin'] ) ? sanitize_text_field( $_POST['el_wl_hide_el_plugin'] ) : self::$default_data['hide_el_plugin'],
			'hide_admin_menu'		=> isset( $_POST['el_wl_hide_admin_menu'] ) ? sanitize_text_field( $_POST['el_wl_hide_admin_menu'] ) : self::$default_data['hide_admin_menu'],
			'hide_wl_admin_menu'	=> isset( $_POST['el_wl_hide_wl_admin_menu'] ) ? sanitize_text_field( $_POST['el_wl_hide_wl_admin_menu'] ) : self::$default_data['hide_wl_admin_menu'],
			'hide_my_templates'		=> isset( $_POST['el_wl_hide_my_templates'] ) ? sanitize_text_field( $_POST['el_wl_hide_my_templates'] ) : self::$default_data['hide_my_templates'],
			'hide_settings_page'	=> isset( $_POST['el_wl_hide_settings_page'] ) ? sanitize_text_field( $_POST['el_wl_hide_settings_page'] ) : self::$default_data['hide_settings_page'],
            'hide_custom_fonts'    	=> isset( $_POST['el_wl_hide_custom_fonts'] ) ? sanitize_text_field( $_POST['el_wl_hide_custom_fonts'] ) : self::$default_data['hide_custom_fonts'],
            'hide_role_manager'    	=> isset( $_POST['el_wl_hide_role_manager'] ) ? sanitize_text_field( $_POST['el_wl_hide_role_manager'] ) : self::$default_data['hide_role_manager'],
            'hide_tools'    		=> isset( $_POST['el_wl_hide_tools'] ) ? sanitize_text_field( $_POST['el_wl_hide_tools'] ) : self::$default_data['hide_tools'],
            'hide_sys_info'    		=> isset( $_POST['el_wl_hide_system_info'] ) ? sanitize_text_field( $_POST['el_wl_hide_system_info'] ) : self::$default_data['hide_sys_info'],
            'hide_knowledge_base'	=> isset( $_POST['el_wl_hide_knowledge_base'] ) ? sanitize_text_field( $_POST['el_wl_hide_knowledge_base'] ) : self::$default_data['hide_knowledge_base'],
			'hide_license_page'    	=> isset( $_POST['el_wl_hide_license_page'] ) ? sanitize_text_field( $_POST['el_wl_hide_license_page'] ) : self::$default_data['hide_license_page'],
			'hide_footer'    		=> isset( $_POST['el_wl_hide_footer'] ) ? sanitize_text_field( $_POST['el_wl_hide_footer'] ) : self::$default_data['hide_footer'],
			'multisite_hide_settings' => isset( $_POST['el_wl_multisite_hide_settings'] ) ? sanitize_text_field( $_POST['el_wl_multisite_hide_settings'] ) : self::$default_data['multisite_hide_settings'],
        );

		update_option( '_el_whitelabel', $data );
		self::$branding = $data;
    }

    /**
	 * Set the branding data to plugin.
	 *
	 * @since 1.0.0
	 * @return array
	 */
    static public function plugin_branding( $all_plugins )
    {
		if ( ! defined( 'ELEMENTOR_PLUGIN_BASE' ) || ! isset( $all_plugins[ELEMENTOR_PLUGIN_BASE] ) ) {
			return $all_plugins;
		}

		$branding = self::get_branding();
        
    	$all_plugins[ELEMENTOR_PLUGIN_BASE]['Name']           = ! empty( $branding['plugin_name'] )     ? $branding['plugin_name']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Name'];
    	$all_plugins[ELEMENTOR_PLUGIN_BASE]['PluginURI']      = ! empty( $branding['plugin_uri'] )      ? $branding['plugin_uri']       : $all_plugins[ELEMENTOR_PLUGIN_BASE]['PluginURI'];
    	$all_plugins[ELEMENTOR_PLUGIN_BASE]['Description']    = ! empty( $branding['plugin_desc'] )     ? $branding['plugin_desc']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Description'];
    	$all_plugins[ELEMENTOR_PLUGIN_BASE]['Author']         = ! empty( $branding['plugin_author'] )   ? $branding['plugin_author']    : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Author'];
    	$all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorURI']      = ! empty( $branding['plugin_uri'] )      ? $branding['plugin_uri']       : $all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorURI'];
    	$all_plugins[ELEMENTOR_PLUGIN_BASE]['Title']          = ! empty( $branding['plugin_name'] )     ? $branding['plugin_name']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Title'];
		$all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorName']     = ! empty( $branding['plugin_author'] )   ? $branding['plugin_author']    : $all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorName'];
		
		if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
			$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Name']           = ! empty( $branding['plugin_name'] )     ? $branding['plugin_name'] . __( ' Pro', 'el-whitelabel' ) : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Name'];
			$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['PluginURI']      = ! empty( $branding['plugin_uri'] )      ? $branding['plugin_uri']       : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['PluginURI'];
			$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Description']    = ! empty( $branding['plugin_desc'] )     ? $branding['plugin_desc']      : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Description'];
			$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Author']         = ! empty( $branding['plugin_author'] )   ? $branding['plugin_author']    : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Author'];
			$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorURI']      = ! empty( $branding['plugin_uri'] )      ? $branding['plugin_uri']       : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorURI'];
			$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Title']          = ! empty( $branding['plugin_name'] )     ? $branding['plugin_name']      : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['Title'];
			$all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorName']     = ! empty( $branding['plugin_author'] )   ? $branding['plugin_author']    : $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE]['AuthorName'];
		}

    	if ( $branding['hide_el_plugin'] == 'on' ) {
			unset( $all_plugins[ELEMENTOR_PLUGIN_BASE] );
			if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
				unset( $all_plugins[ELEMENTOR_PRO_PLUGIN_BASE] );
			}
		}
		
		if ( $branding['hide_plugin'] == 'on' ) {
			unset( $all_plugins[EL_WL_PATH] );
		}

    	return $all_plugins;
	}

	static public function plugin_meta()
	{
		add_filter( 'plugin_action_links', 		__CLASS__ . '::plugin_action_links', 1, 4 );
		add_filter( 'plugin_row_meta', 			__CLASS__ . '::plugin_row_meta', 20, 2);
	}

	static public function plugin_action_links( $actions, $plugin_file, $plugin_data, $context )
	{
		$branding = self::get_branding();

		if ( ! isset( $branding['hide_external_links'] ) || 'on' != $branding['hide_external_links'] ) {
			return $actions;
		}

		if ( defined( 'ELEMENTOR_PLUGIN_BASE' ) && ELEMENTOR_PLUGIN_BASE === $plugin_file ) {
			if ( isset( $actions['go_pro'] ) ) {
				unset( $actions['go_pro'] );
			}
		}

		return $actions;
	}

	static public function plugin_row_meta($plugin_meta, $plugin_file)
	{
		$branding = self::get_branding();

		if ( ! isset( $branding['hide_external_links'] ) || 'on' != $branding['hide_external_links'] ) {
			return $plugin_meta;
		}

		if ( defined( 'ELEMENTOR_PLUGIN_BASE' ) && ELEMENTOR_PLUGIN_BASE === $plugin_file ) {
			if ( isset( $plugin_meta['docs'] ) ) {
				unset( $plugin_meta['docs'] );
			}
			if ( isset( $plugin_meta['ideo'] ) ) {
				unset( $plugin_meta['ideo'] );
			}
			if ( isset( $plugin_meta['video'] ) ) {
				unset( $plugin_meta['video'] );
			}
		}

		if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
			if ( ELEMENTOR_PRO_PLUGIN_BASE === $plugin_file ) {
				if ( isset( $plugin_meta['docs'] ) ) {
					unset( $plugin_meta['docs'] );
				}
				if ( isset( $plugin_meta['ideo'] ) ) {
					unset( $plugin_meta['ideo'] );
				}
				if ( isset( $plugin_meta['video'] ) ) {
					unset( $plugin_meta['video'] );
				}
				if ( isset( $plugin_meta['changelog'] ) ) {
					unset( $plugin_meta['changelog'] );
				}
			}
		}

		return $plugin_meta;
	}
	
	static public function update_label( $translated_text, $text, $domain )
	{
		$branding = self::get_branding();
		$new_text = $translated_text;
		$name = isset( $branding['plugin_name'] ) && ! empty( $branding['plugin_name'] ) ? $branding['plugin_name'] : '';

		if ( ! empty( $name ) ) {
			$new_text = str_replace( 'Elementor', $name, $new_text );
		}
		
		return $new_text;
	}

	static public function admin_footer_text( $footer_text )
	{
		$branding = self::get_branding();

		if ( ! isset( $branding['hide_footer'] ) || 'on' != $branding['hide_footer'] ) {
			return $footer_text;
		}

		$current_screen = get_current_screen();
		$is_elementor_screen = ( $current_screen && false !== strpos( $current_screen->id, 'elementor' ) );

		if ( $is_elementor_screen ) {
			return '';
		}

		return $footer_text;
	}

	static public function remove_el_widget()
	{
		$branding = self::get_branding();

		if ( ! isset( $branding['hide_overview_widget'] ) || 'on' != $branding['hide_overview_widget'] ) {
			return;
		}

		global $wp_meta_boxes;

		if ( is_array( $wp_meta_boxes ) ) {
			if ( isset( $wp_meta_boxes['dashboard']['normal']['core']['e-dashboard-overview'] ) ) {
				unset( $wp_meta_boxes['dashboard']['normal']['core']['e-dashboard-overview'] );
			}
		}
	}
}

// Initializes Elementor_Whitelabel class.
Elementor_Whitelabel::init();
