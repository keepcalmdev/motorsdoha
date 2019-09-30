<?php

/*
Plugin Name: ADS PRO - Ad Templates, Cornerstone Extension
Plugin URI: http://adspro.scripteo.info
Description: Premium Multi-Purpose WordPress Ad Plugin, Create Incredible Good Ad Spaces!
Author: Scripteo
Author URI: http://codecanyon.net/user/scripteo
Version: 1.0.1
*/

define( 'BSA_PRO_EXTENSION_PATH', plugin_dir_path( __FILE__ ) );
define( 'BSA_PRO_EXTENSION_URL', plugin_dir_url( __FILE__ ) );
define( 'BSA_PRO_EXTENSION_VERSION', '1.0.1' );

add_action( 'wp_enqueue_scripts', 'bsa_pro_ad_extension_enqueue' );
add_action( 'cornerstone_register_elements', 'bsa_pro_ad_extension_register_elements' );
add_filter( 'cornerstone_icon_map', 'bsa_pro_ad_extension_icon_map' );
add_filter( 'cornerstone_icon_map', 'bsa_pro_ad_space_icon_map' );

function bsa_pro_ad_extension_enqueue() {
	// Styles
	$rtl = (get_option('bsa_pro_plugin_rtl_support') == 'yes') ? 'rtl-' : null;
	if ( !wp_style_is( 'buy_sell_ads_pro_animate_stylesheet' ) ) {
		wp_register_style('buy_sell_ads_pro_animate_stylesheet', BSA_PRO_EXTENSION_URL . 'assets/styles/animate.css', array(), BSA_PRO_EXTENSION_VERSION );
		wp_enqueue_style('buy_sell_ads_pro_animate_stylesheet');
	}
	if ( !wp_style_is( 'buy_sell_ads_pro_materialize_stylesheet' ) ) {
		wp_register_style('buy_sell_ads_pro_materialize_stylesheet', BSA_PRO_EXTENSION_URL . 'assets/styles/material-design.css', array(), BSA_PRO_EXTENSION_VERSION );
		wp_enqueue_style('buy_sell_ads_pro_materialize_stylesheet');
	}
	if ( !wp_style_is( 'buy_sell_ads_pro_main_stylesheet' ) ) {
		wp_register_style('buy_sell_ads_pro_main_stylesheet', BSA_PRO_EXTENSION_URL . 'assets/styles/' . $rtl . 'style.css', array(), BSA_PRO_EXTENSION_VERSION );
		wp_enqueue_style('buy_sell_ads_pro_main_stylesheet');
	}
	if ( !wp_style_is( 'buy_sell_ads_pro_template_stylesheet' ) ) {
		wp_register_style('buy_sell_ads_pro_template_stylesheet', BSA_PRO_EXTENSION_URL . 'assets/styles/templates/' . $rtl . 'template.css.php', BSA_PRO_EXTENSION_VERSION );
		wp_enqueue_style('buy_sell_ads_pro_template_stylesheet');
	}
	wp_enqueue_style( 'buy_sell_ads_pro_overwrite_stylesheet', BSA_PRO_EXTENSION_URL . 'assets/styles/overwrite-style.css', array(), BSA_PRO_EXTENSION_VERSION );

	// Scripts
	if ( !wp_script_is( 'buy_sell_ads_pro_viewport_checker_js_script' ) ) {
		wp_register_script('buy_sell_ads_pro_viewport_checker_js_script', BSA_PRO_EXTENSION_URL . 'assets/js/jquery.viewportchecker.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('buy_sell_ads_pro_viewport_checker_js_script');
	}
	if ( !wp_script_is( 'buy_sell_ads_pro_js_script_ext' ) ) {
		wp_register_script('buy_sell_ads_pro_js_script_ext', BSA_PRO_EXTENSION_URL . 'assets/js/script.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('buy_sell_ads_pro_js_script_ext');
	}
}

function bsa_pro_ad_extension_register_elements() {

	cornerstone_register_element( 'BSA_PRO_Ad_Extension', 'ads-pro-ad-extension', BSA_PRO_EXTENSION_PATH . 'includes/bsa-pro-extension' );
	if ( class_exists('BSA_PRO_Model') ) {
		$model = new BSA_PRO_Model();
		if ( $model->getSpaces() && count($model->getSpaces()) > 0 ) {
			cornerstone_register_element( 'BSA_PRO_Ad_Space', 'ads-pro-ad-space', BSA_PRO_EXTENSION_PATH . 'includes/bsa-pro-ad-space' );
		}
	}

}

function bsa_pro_ad_extension_icon_map( $icon_map ) {
	$icon_map['ads-pro-ad-extension'] = BSA_PRO_EXTENSION_URL . 'assets/svg/icons.svg';
	return $icon_map;
}

function bsa_pro_ad_space_icon_map( $icon_map ) {
	$icon_map['ads-pro-ad-space'] = BSA_PRO_EXTENSION_URL . 'assets/svg/icons.svg';
	return $icon_map;
}
