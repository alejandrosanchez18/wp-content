<?php
	$action = Elementor_Whitelabel_Plugin::get_form_action();
	$license_key = get_option( '_el_wl_license_key' );
	$license_key = ( ! $license_key ) ? '' : $license_key;
	$license_status = get_option( '_el_wl_license_status' );
?>

<?php if ( 'off' == $branding['hide_settings'] || empty( $branding['hide_settings'] ) ) : ?>

<div class="el-wl-settings-header">
	<h3><?php _e('White Label Branding', 'el-whitelabel'); ?></h3>
</div>

<div class="el-wl-settings-wrap">
	<?php Elementor_Whitelabel_Plugin::render_update_message(); ?>

	<div class="el-wl-settings">
		<form method="post" id="<?php echo Elementor_Whitelabel_Plugin::$settings_page; ?>-form" action="<?php echo $action; ?>">

			<?php wp_nonce_field( 'el_wl_nonce', 'el_wl_nonce' ); ?>

			<div class="el-wl-setting-tabs">
				<a href="#el-wl-license" class="el-wl-tab el-wl-tab-license active"><?php _e('License', 'el-whitelabel'); ?></a>
				<a href="#el-wl-branding" class="el-wl-tab"><?php _e('Branding', 'el-whitelabel'); ?></a>
				<a href="#el-wl-admin-links" class="el-wl-tab"><?php _e('Admin Extras', 'el-whitelabel'); ?></a>
				<a href="#el-wl-ghost-mode" class="el-wl-tab"><?php _e('Ghost Mode', 'el-whitelabel'); ?></a>
			</div>

			<div class="el-wl-setting-tabs-content">

				<div id="el-wl-license" class="el-wl-setting-tab-content active">
					<h3><?php _e('License', 'el-whitelabel'); ?></h3>
					<table class="form-table el-whitelabel-branding">
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_license_key"><?php esc_html_e('License Key', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_license_key" name="el_wl_license_key" type="password" class="regular-text" value="<?php echo $license_key; ?>" autocomplete="off" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
							</th>
							<td>
								<?php if ( ! $license_status || empty( $license_status ) || 'invalid' == $license_status ) { ?> 
								<span class="el-wl-license-status el-wl-license-inactive"><?php _e('Not Active', 'el-whitelabel'); ?></span>
								<button type="submit" name="el_wl_activate_license" class="button" value="1"><?php _e('Activate License', 'el-whitelabel'); ?></button>
								<?php } ?>
								<?php if ( 'valid' == $license_status ) { ?>
								<span class="el-wl-license-status el-wl-license-active"><?php _e('Active', 'el-whitelabel'); ?></span>
								<button type="submit" name="el_wl_deactivate_license" class="button" value="1"><?php _e('Deactivate License', 'el-whitelabel'); ?></button>
								<?php } ?>
							</td>
						</tr>
					</table>
				</div>

				<div id="el-wl-branding" class="el-wl-setting-tab-content">
					<h3 class="el-whitelabel-section-title"><?php esc_html_e('Branding', 'el-whitelabel'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'el-whitelabel'); ?></p>
					<table class="form-table el-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_plugin_name"><?php esc_html_e('Plugin Name', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_plugin_name" name="el_wl_plugin_name" type="text" class="regular-text" value="<?php echo $branding['plugin_name']; ?>" placeholder="" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_plugin_desc" name="el_wl_plugin_desc" type="text" class="regular-text" value="<?php echo $branding['plugin_desc']; ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_plugin_author" name="el_wl_plugin_author" type="text" class="regular-text" value="<?php echo $branding['plugin_author']; ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_plugin_uri"><?php esc_html_e('Website URL', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_plugin_uri" name="el_wl_plugin_uri" type="text" class="regular-text" value="<?php echo $branding['plugin_uri']; ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_edit_with_text"><?php echo sprintf( esc_html__('Edit with %s - Text', 'el-whitelabel'), 'Elementor'); ?></label>
								</th>
								<td>
									<input id="el_wl_edit_with_text" name="el_wl_edit_with_text" type="text" class="regular-text" value="<?php echo ( isset( $branding['edit_with_text'] ) ) ? $branding['edit_with_text'] : ''; ?>" placeholder="<?php echo sprintf( esc_html__('Edit with %s', 'el-whitelabel'), 'Elementor'); ?>"/>
								</td>
							</tr>
							<?php if ( ! defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) { ?>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_disable_pro"><?php esc_html_e('Disable Pro Upgrade Messages', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_disable_pro" name="el_wl_disable_pro" type="checkbox" class="" value="on" <?php echo 'on' == $branding['disable_pro'] ? ' checked="checked" ' : ''; ?>/>
								</td>
							</tr>
							<?php } ?>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_hide_external_links"><?php echo sprintf( esc_html__('Hide %s External Links', 'el-whitelabel'), 'Elementor' ); ?></label>
								</th>
								<td>
									<input id="el_wl_hide_external_links" name="el_wl_hide_external_links" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_external_links'] ) && 'on' == $branding['hide_external_links'] ? ' checked="checked" ' : ''; ?>/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_hide_logo"><?php esc_html_e('Hide Logo', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_hide_logo" name="el_wl_hide_logo" type="checkbox" class="" value="on" <?php echo 'on' == $branding['hide_logo'] ? ' checked="checked" ' : ''; ?>/>
								</td>
							</tr>
							<!-- <tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_hide_descriptions"><?php esc_html_e('Hide descriptions which have Elementor in string', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_hide_descriptions" name="el_wl_hide_descriptions" type="checkbox" class="" value="on" <?php echo 'on' == $branding['hide_descriptions'] ? ' checked="checked" ' : ''; ?>/>
								</td>
							</tr> -->
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="el_wl_primary_color"><?php esc_html_e('Primary Color', 'el-whitelabel'); ?></label>
								</th>
								<td>
									<input id="el_wl_primary_color" name="el_wl_primary_color" type="text" class="el-wl-color-picker" value="<?php echo $branding['primary_color']; ?>" />
								</td>
							</tr>
						</tbody>
					</table>
					<?php if ( is_multisite() && is_main_site() ) { ?>
						<h3 class="el-whitelabel-section-title"><?php esc_html_e('Multisite', 'el-whitelabel'); ?></h3>
						<table class="form-table el-wl-fields">
							<tbody>
								<tr valign="top">
									<th scope="row" valign="top">
										<label for="el_wl_multisite_hide_settings"><?php esc_html_e('Hide WL options from sub-sites', 'el-whitelabel'); ?></label>
									</th>
									<td>
										<input id="el_wl_multisite_hide_settings" name="el_wl_multisite_hide_settings" type="checkbox" class="" value="on" <?php echo isset( $branding['multisite_hide_settings'] ) && 'on' == $branding['multisite_hide_settings'] ? ' checked="checked" ' : ''; ?>/>
									</td>
								</tr>
							</tbody>
						</table>
					<?php } ?>
				</div>

				<div id="el-wl-admin-links" class="el-wl-setting-tab-content">
					<h3><?php _e('Dashboard Widget', 'el-whitelabel'); ?></h3>
					<table class="form-table el-whitelabel-branding">
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_overview_widget"><?php echo _e('Hide Overview Widget', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_overview_widget" name="el_wl_hide_overview_widget" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_overview_widget'] ) && 'on' == $branding['hide_overview_widget'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
					</table>
					<h3><?php _e('Admin Links', 'el-whitelabel'); ?></h3>
					<table class="form-table el-whitelabel-branding">
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_admin_menu"><?php echo sprintf( esc_html__('Hide %s from Menu', 'el-whitelabel'), 'Elementor' ); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_admin_menu" name="el_wl_hide_admin_menu" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_admin_menu'] ) && 'on' == $branding['hide_admin_menu'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_my_templates"><?php esc_html_e('Hide My Templates', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_my_templates" name="el_wl_hide_my_templates" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_my_templates'] ) && 'on' == $branding['hide_my_templates'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_intro_page"><?php esc_html_e('Hide Intro Page', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_intro_page" name="el_wl_hide_intro_page" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_intro_page'] ) && 'on' == $branding['hide_intro_page'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_settings_page"><?php esc_html_e('Hide Settings Page', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_settings_page" name="el_wl_hide_settings_page" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_settings_page'] ) && 'on' == $branding['hide_settings_page'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_custom_fonts"><?php esc_html_e('Hide Custom Fonts', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_custom_fonts" name="el_wl_hide_custom_fonts" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_custom_fonts'] ) && 'on' == $branding['hide_custom_fonts'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_role_manager"><?php esc_html_e('Hide Role Manager', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_role_manager" name="el_wl_hide_role_manager" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_role_manager'] ) && 'on' == $branding['hide_role_manager'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_tools"><?php esc_html_e('Hide Tools', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_tools" name="el_wl_hide_tools" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_tools'] ) && 'on' == $branding['hide_tools'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_system_info"><?php esc_html_e('Hide System Info', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_system_info" name="el_wl_hide_system_info" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_sys_info'] ) && 'on' == $branding['hide_sys_info'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_knowledge_base"><?php esc_html_e('Hide Knowledge Base', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_knowledge_base" name="el_wl_hide_knowledge_base" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_knowledge_base'] ) && 'on' == $branding['hide_knowledge_base'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_license_page"><?php esc_html_e('Hide License Page', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_license_page" name="el_wl_hide_license_page" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_license_page'] ) && 'on' == $branding['hide_license_page'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
					</table>
					<h3><?php _e('Admin Footer', 'el-whitelabel'); ?></h3>
					<p><?php _e('Removes Elementor review message from footer.', 'el-whitelabel'); ?></p>
					<table class="form-table el-white-label-branding">
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_footer"><?php esc_html_e('Hide Footer Message', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_footer" name="el_wl_hide_footer" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_footer'] ) && 'on' == $branding['hide_footer'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
					</table>
				</div>

				<div id="el-wl-ghost-mode" class="el-wl-setting-tab-content">
					<h3><?php _e('Ghost Mode', 'el-whitelabel'); ?></h3>
					<p>
						<?php echo sprintf( esc_html__('You can hide both %s and White Label plugin to prevent your client from seeing these settings.', 'el-whitelabel'), 'Elementor' ); ?>
						<?php echo sprintf( __( '<br />Save this URL %s to re-enable the plugins and settings. Alternatively, you can deactivate the White Label plugin and activate it again.', 'el-whitelabel'), '<code style="font-size: 12px;">' . Elementor_Whitelabel_Plugin::get_form_action('&el_wl_reset=1') . '</code>' ); ?>
					</p>
					<table class="form-table el-whitelabel-branding">
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_settings"><?php esc_html_e('Hide White Label Options', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_settings" name="el_wl_hide_settings" type="checkbox" class="" value="on" <?php echo 'on' == $branding['hide_settings'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_el_plugin"><?php echo sprintf( esc_html__('Hide %s Plugin', 'el-whitelabel'), 'Elementor' ); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_el_plugin" name="el_wl_hide_el_plugin" type="checkbox" class="" value="on" <?php echo isset( $branding['hide_el_plugin'] ) && 'on' == $branding['hide_el_plugin'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="el_wl_hide_plugin"><?php esc_html_e('Hide White Label Plugin', 'el-whitelabel'); ?></label>
							</th>
							<td>
								<input id="el_wl_hide_plugin" name="el_wl_hide_plugin" type="checkbox" class="" value="on" <?php echo 'on' == $branding['hide_plugin'] ? ' checked="checked" ' : ''; ?>/>
							</td>
						</tr>
					</table>
				</div>

				<div class="el-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="submit" id="el_save_branding" class="button button-primary el-whitelabel-button" value="<?php esc_html_e('Save Settings', 'el-whitelabel'); ?>" />
					</p>
				</div>
			</div>
		</form>
	</div>
</div>

<?php else : ?>
<div class="notice notice-info" style="margin-top: 50px;">
	<?php $reset_url = Elementor_Whitelabel_Plugin::get_form_action('&el_wl_reset=1'); ?>
	<p><?php echo sprintf( __('<a href="%s">Click here</a> to reset the plugin interface OR save this URL to reset anytime %s'), $reset_url, '<code>' . $reset_url . '</code>' ); ?></p>
</div>
<?php endif; ?>