<?php
/*
* Plugin Name: Woocommerce Custom Overlays
* Plugin URI: http://andrewgunn.xyz/woocommerce-custom-overlays
* Description: Dynamically display a custom uploaded or default image overlays for products in your WooCommerce store by category, status, product, inventory status, etc..
* Version: 2.0
* Author: Andrew Gunn, Ryan Van Ess
* Author URI: http://andrewgunn.xyz
* Text Domain: woo-out-of-stock-products
* License: GPL2
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* Including files in other directories
*/
include_once('admin/woo-settings-tab.php');
//include_once('inc/shortcode.php');
//include_once('inc/outofstock.php');

include_once('inc/script-styles.php');


/**
* Register and enqueue jQuery files to run on frontend, enqueue on admin_init
*/
add_action( 'init', 'register_outofstock_scripts' );

function register_outofstock_scripts() {
	//wp_register_script( 'outofstock_js', plugins_url('inc/outofstock.js', __FILE__), array('jquery'));
	wp_register_style( 'outofstock_css', plugins_url('inc/outofstock.css', __FILE__));
	//wp_enqueue_script( 'outofstock_js' );
	wp_enqueue_style( 'outofstock_css' );

}

/*()

* Adding Settings link to plugin page
*/
add_filter( 'plugin_action_links', 'outofstock_settings_link', 10, 5 );

function outofstock_settings_link( $actions, $plugin_file )
{
	static $plugin;

	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);

		if ($plugin == $plugin_file) {

			$settings = array('settings' => '<a href="admin.php?page=wc-settings&tab=settings_tab_wos">' . __('Settings', 'General') . '</a>', 'support' => '<a href="http://andrewgunn.xyz/support" target="_blank">' . __('Support', 'General') . '</a>'//,
				//'pro' => '<a href="http://andrewgunn.xyz/woocommerce-custom-overlays-pro" target="_blank">' . __('Pro', 'General') . '</a>'
				);

    			$actions = array_merge($settings, $actions);
		}

		return $actions;
}