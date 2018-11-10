<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/template" id="tmpl-elementor-pro-template-library-activate-license-button">
	<a class="elementor-template-library-template-action elementor-button elementor-button-go-pro" href="<?php echo \ElementorPro\License\Admin::get_url(); ?>" target="_blank">
		<i class="fa fa-external-link-square"></i>
		<span class="elementor-button-title"><?php _e( 'Activate License', 'elementor-pro' ); ?></span>
	</a>
</script>
