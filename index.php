<?php
/*
Plugin Name: Slider Box
Description: Slider Box is a plugin show posts widget.
Plugin URI: https://wordpress.org/plugins/slider-box
Author: De Mos
Author URI: http://photoboxone.com/
Version: 1.0.1
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
define('WP_SB_URL_AUTHOR', 'http://photoboxone.com/' ); 

defined('ABSPATH') or die();

define('WP_SB_PATH', dirname(__FILE__) ); 
define('WP_SB_PATH_INCLUDES', dirname(__FILE__).'/includes' ); 


include_once( WP_SB_PATH_INCLUDES .'/widget.php' );

if( is_admin() ):
	
	require WP_SB_PATH_INCLUDES.'/config.php';
	
	$action = isset($_GET['action'])?$_GET['action']:'';
	$page 	= isset($_GET['page'])?$_GET['page']:'';
	$plugins = preg_match('/plugins.php/i',$_SERVER['REQUEST_URI']);
	$options = preg_match('/options/i',$_SERVER['REQUEST_URI']);
	
else:
	
	if ( ! function_exists( 'slider_box_head' ) ) :
		function slider_box_head() {
			echo '<!-- Slider Box at http://photoboxone.com -->'."\n";
			echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">'."\n";
			echo '<link rel="stylesheet" id="slider-box-style" href="'.plugins_url('', __FILE__).'/media/jslider.css" type="text/css" media="all" />'."\n";
			echo '<script id="slider-box-jslider" src="'.plugins_url('', __FILE__).'/media/jslider.js" /></script>'."\n";
			//echo '<scr'.'ipt id="slider-box-core" src="'.WP_PB_URL_AUTHOR. 'js/jquery.min.js" /></scr'.'ipt>'."\n";	
		}
		add_action( 'wp_head', 'slider_box_head');
	endif; // slider_box_head
	
	
endif; // main_setup
