<?php
/*
* Plugin Name: WooCommerce Custom Overlays
* Plugin URI: http://andrewgunn.org/woocommerce-custom-overlays
* Description: Dynamically display a custom uploaded or default image overlays for products in your WooCommerce store by category, status, product, inventory status, etc..
* Version: 2.0
* Author: Andrew Gunn
* Author URI: http://andrewgunn.org
* Text Domain: woo-custom-overlays
* License: GPL2
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
 * Including files in other directories
 */
include_once( 'admin/woo-settings-tab.php' );
include_once( 'inc/script-styles.php' );


/**
 * Register and enqueue jQuery files to run on frontend, enqueue on admin_init
 */
add_action( 'init', 'register_wco_scripts' );

/**
 *
 */
function register_wco_scripts() {
	//wp_register_script( 'wco_js', plugins_url('inc/wco.js', __FILE__), array('jquery'));
	wp_register_style( 'wco_css', plugins_url( 'inc/wco.css', __FILE__ ) );
	//wp_enqueue_script( 'wco_js' );
	wp_enqueue_style( 'wco_css' );

}

/*()

* Adding Settings link to plugin page
*/
add_filter( 'plugin_action_links', 'wco_settings_link', 10, 5 );

/**
 * @param $actions
 * @param $plugin_file
 *
 * @return array|void
 */
function wco_settings_link( $actions, $plugin_file ) {
	static $plugin;

	if ( ! isset( $plugin ) ) {
		$plugin = plugin_basename( __FILE__ );
	}

	if ( $plugin == $plugin_file ) {

		$settings = [
			'settings' => '<a href="admin.php?page=wc-settings&tab=settings_tab_wco">' . __( 'Settings', 'General' ) . '</a>',
		];

		$actions = array_merge( $settings, $actions );
	}

	return $actions;
}