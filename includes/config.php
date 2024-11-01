<?php
defined('ABSPATH') or die();

/* ADD SETTINGS PAGE
------------------------------------------------------*/
if( !function_exists('slider_box_add_options_page') ){
	function slider_box_add_options_page() {
		add_options_page(
			'Slider Box Settings',
			'Slider Box',
			'manage_options',
			'slider-box-setting',
			'slider_box_setting_display'
		);
		
	}
}
add_action('admin_menu','slider_box_add_options_page');