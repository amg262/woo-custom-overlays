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
namespace WooImageOverlay;

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
 *
 */
define( 'WCO_ADMIN', plugins_url( 'inc/wco-admin.js', __FILE__ ) );
/**
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
define( 'WCO_SETTINGS', 'wco_settings' );

global $wco_options;
global $wco_settings;
$wco_options = get_option( WCO_OPTIONS );
$wco_settings = get_option( WCO_SETTINGS );

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
		//add_action( 'admin_enqueue_scripts', array( $this, 'admin_js' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_includes' ) );
		add_action( 'wp_ajax_wco_ajax', array( $this, 'wco_ajax' ) );
		add_action( 'wp_ajax_nopriv_wco_ajax', array( $this, 'wco_ajax' ) );

		add_filter( 'plugin_action_links', array($this, 'wco_settings_link'), 10, 5 );

		$this->add_options();
		$this->add_settings();


	}

	/**
	 * @return mixed|void
	 */
	public function add_options() {

		global $wco_options;

		if ( ! $wco_options ) {
			$args = array( 'init' => true, 'upgrade' => false );
			add_option( WCO_OPTIONS, $args );
		}
	}

	/**
	 * @return mixed|void
	 */
	public function add_settings() {

		global $wco_settings;

		if ( ! $wco_settings ) {
			$args = array( 'init' => true );
			add_option( WCO_SETTINGS, $args );
		}
	}

	/**
	 *
	 */
	public function admin_js() {

		$nonce = wp_create_nonce( 'wco-nonce' );
		$js    = plugins_url( '/inc/wco-admin.js', __FILE__ );

		if ( ! empty( $js ) ) {
			wp_register_script( 'admin_js', $js, array( 'jquery' ) );
			wp_enqueue_script( 'admin_js' );

			$ajax_object = array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => $nonce,
			);
			wp_localize_script( 'admin_js', 'ajax_object', $ajax_object );
		}
	}

	// Same handler function...
	/**
	 *
	 */
	public function wco_ajax() {
		//global $wpdb;
		//$whatever = intval( $_POST['whatever'] );
		//$whatever += 10;
		//echo $whatever;
		//wp_die();
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

