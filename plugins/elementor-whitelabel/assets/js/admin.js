;(function($) {
	$(document).ready(function() {
		// Color Picker.
		if ( 'undefined' !== typeof $.fn.wpColorPicker ) {
			// Add Color Picker to all inputs that have 'el-wl-color-picker' class.
			$( '.el-wl-color-picker' ).wpColorPicker();
		}
	});
	
	$('.el-wl-setting-tabs').on('click', '.el-wl-tab', function(e) {
		e.preventDefault();

		var id = $(this).attr('href');
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		$('.el-wl-setting-tabs-content .el-wl-setting-tab-content').removeClass('active');
		$('.el-wl-setting-tabs-content').find(id).addClass('active');

		var formAction = $('#el-wl-settings-form').attr('action').split('#')[0];
		formAction += '#!' + id.split('#')[1];

		location.href = formAction;

		$('#el-wl-settings-form').attr('action', formAction);
	});

	$(window).load(function() {
		if ( location.hash ) {
			var activeTab = '#' + location.hash.split('#!')[1];

			if ( $('.el-wl-setting-tabs-content').find(activeTab).length > 0 ) {
				$('.el-wl-setting-tabs .el-wl-tab').removeClass('active');
				$('.el-wl-setting-tabs [href="'+activeTab+'"]').addClass('active');
				$('.el-wl-setting-tabs-content .el-wl-setting-tab-content').removeClass('active');
				$('.el-wl-setting-tabs-content').find(activeTab).addClass('active');
			}
		}
	});
})(jQuery);