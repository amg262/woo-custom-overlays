<?php

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//include __DIR__ . '/admin-scripts.php';
include __DIR__ . '/class-wco-worker.php';

class WCO_Settings_Tab {
	/**
	 * Bootstraps the class and hooks required actions & filters.
	 */
	public static function init() {

		//sadd_action( 'admin_enqueue_scripts', __CLASS__ . '::wco_admin' );
		add_action( 'wp_ajax_wco_ajax', __CLASS__ . '::wco_ajax' );
		add_action( 'wp_ajax_nopriv_wco_ajax', __CLASS__ . '::wco_ajax' );

		add_action( 'woocommerce_settings_tabs_settings_tab_wco', __CLASS__ . '::settings_tab' );


		add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
		add_action( 'woocommerce_settings_tabs_settings_tab_wco', __CLASS__ . '::settings_tab' );
		add_action( 'woocommerce_update_options_settings_tab_wco', __CLASS__ . '::update_settings' );
		add_action( 'woocommerce_settings_tabs_settings_tab_wco', __CLASS__ . '::submit_button' );
		//$set->init();
	}

	public static function wco_admin() {
		$nonce = wp_create_nonce( 'wco-nonce' );

		$file  = plugins_url( '/inc/wco-admin.js', __DIR__ );

		if ( ! empty( $file ) ) {
			wp_register_script( 'wco_admin_js', $file, array( 'jquery' ) );
			wp_enqueue_script( 'wco_admin_js' );

			$ajax_object = array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => $nonce,
				'whatever' => 'product'
			);
			wp_localize_script( 'wco_admin_js', 'ajax_object', $ajax_object );
		}
	}

	public static function wco_ajax() {
		//global $wpdb;

		check_ajax_referer( 'wco-nonce', 'security' );


		$whatever = $_POST['whatever'];
		$posts = get_posts(array('post_type'=>$whatever));

		foreach ($posts as $p) {
			echo $p->post_title . '<br>';
		}
		//$whatever = intval( $_POST['whatever'] );
		//$whatever += 10;
		//echo $whatever;
		wp_die();
	}

	public static function submit_button() {

	}

	/**
	 * Add a new settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	 *
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	 */
	public static function add_settings_tab( $settings_tabs ) {
		$settings_tabs[ 'settings_tab_wco' ] = __( 'Image Overlay', 'woo-wco' );

		return $settings_tabs;
	}

	/**
	 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	 *
	 * @uses woocommerce_admin_fields()
	 * @uses self::get_settings()
	 */
	public static function settings_tab() {

		woocommerce_admin_fields( self::get_settings() );
	}

	/**
	 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	 *
	 * @uses woocommerce_update_options()
	 * @uses self::get_settings()
	 */
	public static function update_settings() {
		woocommerce_update_options( self::get_settings() );
	}

	/**
	 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
	 *
	 * @return array Array of settings for @see woocommerce_admin_fields() function.
	 */
	public static function get_settings() {
		$data = array();

		$worker    = new WCO_Worker();
		$data      = $worker->get_cache();
		$prod_data = (array) $worker->get_products();
		$args      = array();
		$arr       = array();

		foreach ( $prod_data as $prod ) {
			$args[] = [ 'ID' => $prod->ID, 'post_title' => $prod->post_title ];
			$arr[]  = $prod->post_title;
		}

		//var_dump( $arr );
		//var_dump($prod_data);
		$cat_data = $data[ 'category' ];


		$settings_wco = array();
		echo '<div class="wco-top">';



		$rows = 1;
		$max  = 0;
		$rows = get_option( 'wco_2_rows' );
		$max  = get_option( 'wco_2_max_rows' );
		$sec  = get_option( 'wco_sec' );

		if ( $max == 0 ) {
			update_option( 'wco_2_max_rows', $rows );
		} elseif ( $rows > $max ) {
			update_option( 'wco_2_max_rows', $rows );
			//} else {
		}


		//var_dump( $settings->get_cache() );
		//var_dump($c);
		//echo $c[1];

		//var_dump($posts);
		//$arr = array('instock','wco');

		// Add Title to the Settings
		$settings_wco[] = array(
			'name' => __( 'Woocommerce Image Overlays', 'woo-wco' ),
			'type' => 'title',
			'desc' => __( 'The following options are used to configure Woocommerce Custom Overlays', 'woo-wco' ),
			'id'   => '',
		);
		// Add first checkbox option
		/*$settings_wco[] = array(
			'name'     => __( 'Disable Overlay', 'woo-wco' ),
			'desc_tip' => __( '', 'woo-wco' ),
			'id'       => 'disable_wco_2_overlay',
			'type'     => 'checkbox',
			//'css'      => 'min-width:300px;',
			'desc'     => __( '<small>&nbsp;Check this to <b>DISABLE</b> the out of stock overlay</small>', 'woo-wco' )
		);*/
		// Add second text field option
		//echo '<h3>To create a overlays, choose the number of total rows, or seperate overlay images and click save. ';
		$settings_wco[] = array(
			'name' => __( 'License Key', 'woo-wco' ),
			//'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
			'id'   => 'wco_2_license_key',
			'type' => 'text',
			'desc' => __( '&nbsp;<button class="button button-primary"><a id="" style="color:#FFF;">Save</a></button>', 'woo-wco' ),
			//'placeholder' => 'center top',
			'css'  => 'max-width:500px; width:550px;',
		);


		$settings_wco[] = array(
			'name'     => __( 'Active Rows', 'woo-wco' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
			'id'       => 'wco_2_rows',
			'type'     => 'select',
			'class'    => 'wc-enhanced-select',
			'default'  => 1,
			'desc'     => __( '&nbsp;<a class="button" id="newrow" name="newrow">New Row</a>', 'woo-wco' ),
			//'desc'     => __( '&nbps;<button class="button button-primary"><a id="submit" style="color:#FFF;">Add Row</a></button><hr style="float:left;width:90%;border: 1px solid #000;margin-top: 35px;margin-bottom:15px;">', 'woo-wco' ),
			//'placeholder' => 'center top',
			'css'      => 'text-align: right; display: inline-block!important;',
			'options'  => __( array( 1, 2, 3, 4, 5 ), 'woo-wco' ),
		);


		$settings_wco[] = array(
			'name'    => __( 'Max Rows', 'woo-wco' ),
			//'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
			'id'      => 'wco_2_max_rows',
			'type'    => 'hidden',
			//'class'    => 'wc-enhanced-select',
			'default' => 0,
			'desc'    => __( '&nbsp;', 'woo-wco' )
			//'desc'     => __( '&nbps;<button class="button button-primary"><a id="submit" style="color:#FFF;">Add Row</a></button><hr style="float:left;width:90%;border: 1px solid #000;margin-top: 35px;margin-bottom:15px;">', 'woo-wco' ),
			//'placeholder' => 'center top',
			//'css'    => 'max-width:70px;width:100%; text-align:center;',
			//'options' => __( $nums, 'woo-wco')
		);

		//$settings_wco[] = array(submit_button("Save"));

		$settings_wco[] = array(
			'name'        => __( 'Woo Secs', 'woo-wco' ),
			'desc_tip'    => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
			'id'          => 'wco_sec',
			'type'        => 'hidden',
			'desc'        => __( '', 'woo-wco' ),
			'placeholder' => '',
			'class'       => '',
		);

		echo '<div>
				<a href="#" class="button">Button</a>
                <a class="button secondary">Generate</a>
            </div>';


		if ( $rows > 0 ):

			for ( $i = 0; $i < $rows; $i ++ ) {
				//echo '<hr>';

				$settings_wco[] = array(
					'title'    => __( 'Selector Class', 'woocommerce' ),
					'desc'     => __( 'This option lets you limit which countries you are willing to sell to.', 'woocommerce' ),
					'id'       => 'wco_2_selector_' . $i,
					//'default'  => 1,
					'type'     => 'select',
					'class'    => 'wc-enhanced-select',
					'desc_tip' => true,
					//'options'  => array(
					//	'opt_'.$i      => __( $arr[$i], 'woocommerce' ),
					//)
					'options'  => __( $data[ 'native' ], 'woo-wco' ),
				);

				$settings_wco[] = array(
					'title'    => __( 'Product', 'woocommerce' ),
					'desc'     => __( 'This option lets you limit which countries you are willing to sell to.', 'woocommerce' ),
					'id'       => 'wco_2_product_' . $i,
					//'default'  => 1,
					'type'     => 'select',
					'class'    => 'wc-enhanced-select',
					'desc_tip' => true,
					//'options'  => array(
					//	'opt_'.$i      => __( $arr[$i], 'woocommerce' ),
					//)
					'options'  => __( $arr, 'woo-wco' ),
				);
				/*$settings_wco[] = array(
					'name'     => __( 'Backgroound Size', 'woo-wco' ),
					'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
					'id'       => 'wco_2_background_size_'.$i,
					'type'     => 'text',
					'desc'     => __( '', 'woo-wco' ),
					'placeholder' => '100% 100%',
					'default' => '100% 100%',
					'class'    => ''
				);*/


				$settings_wco[] = array(
					'name'        => __( 'Background Position', 'woo-wco' ),
					'desc_tip'    => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
					'id'          => 'wco_2_background_position_' . $i,
					'type'        => 'text',
					'desc'        => __( '', 'woo-wco' ),
					'placeholder' => 'center top',
					'default'     => 'center top',
					'class'       => '',
				);
				$settings_wco[] = array(
					'name'     => __( 'Background Color', 'woo-wco' ),
					'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
					'id'       => 'wco_2_background_color_' . $i,
					'type'     => 'text',
					'desc'     => __( '', 'woo-wco' ),
					'default'  => 'transparent',
					'class'    => '',
				);


				$settings_wco[] = array(
					'name'        => __( 'Background Repeat', 'woo-wco' ),
					'desc_tip'    => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
					'id'          => 'wco_2_background_repeat_' . $i,
					'type'        => 'text',
					//'default' => 'no-repeat',
					'autoload'    => false,
					///'desc'     => __( '', 'woo-wco' ),
					'placeholder' => 'no-repeat',
					'default'     => 'no-repeat',
					'class'       => '',
				);

				$settings_wco[] = array(
					'name'        => __( 'Image Opacity', 'woo-wco' ),
					'desc_tip'    => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-wco' ),
					'id'          => 'wco_2_image_opacity_' . $i,
					'type'        => 'text',
					'desc'        => __( '', 'woo-wco' ),
					'placeholder' => '.8',
					'default'     => '.8',
					'class'       => '',
				);


				$settings_wco[] = array(
					'name'     => __( 'Overlay Image URL', 'woo-wco' ),
					'desc_tip' => __( 'This will be the URL of the image you are using for the Out of Stock overlay. Make sure it is a <b>PNG</b>', 'woo-wco' ),
					'id'       => 'wco_2_image_url_' . $i,
					'default'  => plugins_url( 'assets/sign-pin.png', __DIR__ ),
					'type'     => 'text',
					'desc'     => __( '&nbsp;Make sure your image is a <b>PNG!</b><br><hr style="float:left;width:90%;border: 1px dotted #CCC;margin-top: 35px;margin-bottom:15px;">', 'woo-wco' ),
					'class'    => 'overlay-input',
					'css'      => 'max-width:700px;width:100%;',
				);

				/*$settings_wco[] = array(
					//'name'     => __( 'Overlay Image URL', 'woo-wco' ),
					//'desc_tip' => __( 'This will be the URL of the image you are using for the Out of Stock overlay. Make sure it is a <b>PNG</b>', 'woo-wco' ),
					//'id'       => ''.$i,
					//'default' => plugins_url('assets/sign-pin.png', dirname(__FILE__)),
					'type'     => 'text',
					'desc'     => __( '&nbsp;<button class="button button-primary wco-block"><a id="submit" style="color:#FFF;">Save</a></button><hr style="float:left;width:90%;border: 1px dotted #CCC;margin-top: 35px;margin-bottom:15px;">', 'woo-wco' ),
					'class'    => 'overlay-input',
					'css' => 'display:none;'
				);*/
				//submit_button("Save Row");
				//echo '<br><hr><br>';
			}
		endif;
		$settings_wco[] = array( 'type' => 'sectionend', 'id' => 'wco_2' );


		//echo '<p class="submit wco-submit">';
		//submit_button( 'Reset All', 'delete button-secondary', 'wco-delete', false, $other_attributes );
		return $settings_wco;
		//return apply_filters( 'wc_settings_tab_wco_settings', $settings_wco );
		echo '</div">';
	}
}

WCO_Settings_Tab::init();

