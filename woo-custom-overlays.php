<?php
/*
* Plugin Name: WooCommerce Image Overlay
* Plugin URI: https/nextraa.us
* Description: Dynamically display a custom uploaded or default image overlays for products in your WooCommerce store by category, status, product, inventory status, etc..
* Version: 1.0
* Author: Andrew Gunn, Ryan Van Ess
* Author URI: https/nextraa.us
* Text Domain: woo-custom-overlays
* License: GPL2
*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
 *
 *//**
 *
 */
define( 'WCO_JS', plugins_url( 'inc/wco.js', __FILE__ ) );
/**
 *
 */
define( 'WCO_CSS', plugins_url( 'inc/wco.css', __FILE__ ) );
/**
 *
 */
define( 'WCO_OPTIONS', 'wco_options' );


/**
 * Classes and interfaces
 */
class WCO_Plugin {
	/**
	 * @var
	 */
	private $options;

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 *
	 */
	public function init() {
		/**
		 * Including files in other directories
		 */
		include_once __DIR__ . '/admin/class-wco-options.php';
		include_once __DIR__.'/inc/script-styles.php';

		add_action( 'wp_enqueue_scripts', array( $this, 'load_includes' ) );
		add_filter( 'plugin_action_links', array($this, 'wco_settings_link'), 10, 5 );

		$this->add_options();
	}

	/**
	 * @return mixed|void
	 */
	public function add_options() {

		$this->options = get_option(WCO_OPTIONS);

		if ( ! $this->options ) {
			$args = array( 'init' => true, 'upgrade' => false );
			add_option( WCO_OPTIONS, $args );
		}
	}



	/**
	 *
	 */
	public function load_includes() {
		wp_register_script( 'wco_js', WCO_JS, array( 'jquery' ) );
		wp_register_style( 'wco_css', WCO_CSS );
		wp_enqueue_script( 'wco_js' );
		wp_enqueue_style( 'wco_css' );
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function wco_settings_link( $actions, $plugin_file ) {
		static $plugin;

		if ( ! isset( $plugin ) ) {
			$plugin = plugin_basename( __FILE__ );
		}

		if ( $plugin == $plugin_file ) {

			$settings = array(
				'settings' => '<a href="admin.php?page=wc-settings&tab=settings_tab_wco">' . __( 'Settings', 'General' ) . '</a>',
				'support'  => '<a href="http://andrewgunn.org/support" target="_blank">' . __( 'Support', 'General' ) . '</a>'
				//,
				//'pro' => '<a href="http://andrewgunn.xyz/woocommerce-custom-overlays-pro" target="_blank">' . __('Pro', 'General') . '</a>'
			);

			$actions = array_merge( $settings, $actions );
		}

		return $actions;
	}
}

//$ece->ece_init();
$plugin = new WCO_Plugin();

