<?php if ( isset( $branding['disable_pro'] ) && 'on' == $branding['disable_pro'] ) : ?>
	div#elementor-panel-elements-navigation-global,
	div.elementor-panel-nerd-box,
	div#elementor-panel-get-pro-elements,
	div.elementor-control-section_custom_css_pro,
	div.elementor-control-custom_css_pro {
		display: none;
	}
<?php endif; ?>

<?php if ( isset( $branding['hide_external_links'] ) && 'on' == $branding['hide_external_links'] ) { ?>
div.elementor-panel-menu-group:last-of-type div.elementor-panel-menu-items div.elementor-panel-menu-item:last-of-type,
#adminmenu #toplevel_page_edit-post_type-elementor_library a[href="admin.php?page=go_elementor_pro"],
#adminmenu #toplevel_page_elementor a[href="admin.php?page=go_elementor_pro"] {
	display: none;
}
tr[data-slug="elementor"] .open-plugin-details-modal,
tr[data-slug="elementor"] span.go_pro,
tr[data-slug="elementor-pro"] .open-plugin-details-modal,
tr[data-plugin="elementor-pro/elementor-pro.php"] .open-plugin-details-modal {
	display: none;
}
tr.elementor_allow_tracking a {
	display: none;
}
div.elementor-template-library-blank-footer,
.elementor-button-go-pro {
	display: none;
}
.elementor-message[data-notice_id="rate_us_feedback"] {
	display: none;
}
<?php } ?>

<?php if ( isset( $branding['hide_logo'] ) && 'on' == $branding['hide_logo'] ) : ?>
	div#elementor-panel-header-title img,
	div.elementor-loader-wrapper .elementor-loader .elementor-loader-box,
	.eicon-elementor {
		display: none;
	}
	#adminmenu #toplevel_page_elementor div.wp-menu-image:before, #adminmenu #toplevel_page_edit-post_type-elementor_library div.wp-menu-image:before {
		content: "\f111";
		font-family: dashicons;
		margin-top: auto;
		font-size: 18px;
	}
	/*
	div.elementor-panel .elementor-control-type-media .elementor-control-media-image,
	div.elementor-carousel-image {
		background-image: url("<?php echo EL_WL_URL . 'assets/img/placeholder.png'; ?>") !important;
	}
	*/
	div.elementor-templates-modal__header .elementor-templates-modal__header__logo__icon-wrapper {
		display: none !important;
	}
<?php endif; ?>

<?php if ( isset( $branding['hide_intro_page'] ) && 'on' == $branding['hide_intro_page'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=elementor-getting-started"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_settings'] ) && 'on' == $branding['hide_settings'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=el-wl-settings"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_my_templates'] ) && 'on' == $branding['hide_my_templates'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="edit.php?post_type=elementor_library"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_settings_page'] ) && 'on' == $branding['hide_settings_page'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=elementor"] {
		display: none;
	}
	tr[data-plugin="<?php echo ELEMENTOR_PLUGIN_BASE; ?>"] .row-actions a[href$="?page=elementor"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_custom_fonts'] ) && 'on' == $branding['hide_custom_fonts'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="edit.php?post_type=elementor_font"],
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=elementor_custom_fonts"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_role_manager'] ) && 'on' == $branding['hide_role_manager'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=elementor-role-manager"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_tools'] ) && 'on' == $branding['hide_tools'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=elementor-tools"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_sys_info'] ) && 'on' == $branding['hide_sys_info'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=elementor-system-info"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_knowledge_base'] ) && 'on' == $branding['hide_knowledge_base'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=go_knowledge_base_site"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['hide_license_page'] ) && 'on' == $branding['hide_license_page'] ) { ?>
	ul#adminmenu li.toplevel_page_elementor li a[href="admin.php?page=elementor-license"] {
		display: none;
	}
<?php } ?>
<?php if ( isset( $branding['primary_color'] ) && ! empty( $branding['primary_color'] ) ) { ?>
	div.elementor-panel #elementor-panel-header,
	div.elementor-add-new-section .elementor-add-section-button,
	div#elementor-mode-switcher:hover {
		background-color: <?php echo $branding['primary_color']; ?>;
	}
	div.elementor-panel .elementor-panel-navigation .elementor-panel-navigation-tab.elementor-active {
		border-bottom-color: <?php echo $branding['primary_color']; ?>;
	}
	div.elementor-panel .elementor-control-type-gallery .elementor-control-gallery-clear,
	div.elementor-panel .elementor-element:hover .icon,
	div.elementor-panel .elementor-element:hover .title,
	div.elementor-panel a,
	div.elementor-panel a:hover {
		color: <?php echo $branding['primary_color']; ?>;
	}
	div.elementor-templates-modal__header .elementor-template-library-menu-item.elementor-active {
		border-bottom-color: <?php echo $branding['primary_color']; ?>;
	}
	div.elementor-template-library-template-remote.elementor-template-library-pro-template .elementor-template-library-template-body:before {
		background-color: <?php echo $branding['primary_color']; ?>;
	}
<?php } ?>