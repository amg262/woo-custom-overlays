<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
class WC_Settings_Tab_wos {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_wos', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_wos', __CLASS__ . '::update_settings' );
        add_action( 'woocommerce_settings_tabs_settings_tab_wos', __CLASS__ . '::submit_button' );
    }

    public static function submit_button() {
    	echo '<hr>';
		submit_button( 'Reset Settings', 'delete button-secondary', 'reset_wos_options' );

    }
    
    
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_wos'] = __( 'Custom Overlays', 'woo-outofstock' );
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
        

		if (isset($_REQUEST['reset_wos_options'])) {
			$arr_2 = array();
		$rows = get_option('outofstock_2_max_rows');
		for ($k=0; $k<$rows; $k++) {
			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_color_'.$k,
								   'value'=> get_option('outofstock_2_background_color_'.$k)));

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_position_'.$k,
								   'value'=> get_option('outofstock_2_background_position_'.$k)));
					array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_repeat_'.$k,
								   'value'=> get_option('outofstock_2_background_repeat_'.$k)));
			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_background_size_'.$k,
								   'value'=> get_option('outofstock_2_background_size_'.$k)));

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_image_opacity_'.$k,
								   'value'=> get_option('outofstock_2_image_opacity_'.$k)));
			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_image_url_'.$k,
								   'value'=> get_option('outofstock_2_image_url_'.$k)));

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_selector_'.$k,
								   'value'=> get_option('outofstock_2_selector_'.$k)));

			$aaa = get_option('outofstock_2_classes');
			$var = get_option('outofstock_2_selector_'.$k);
			$cla = $aaa[intval($var)];

			array_push($arr_2,  array('id'=>$k,
								   'option' => 'outofstock_2_class_'.$k,
								   'value'=> $cla));

		

		}

		foreach ($arr_2 as $value) {//for ($p = 0; $p <= count($arr_2); $p++ ) {

			$id = $value['id'];

			$option = $value['option'];
			$value = $value['value'];

			delete_option($option);
		}
		delete_option('outofstock_2_classes');
		delete_option('outofstock_2_license_key');
		delete_option('outofstock_2_rows');
		delete_option('outofstock_2_max_rows');
		delete_option('outofstock_sec');
		
	}
		
		$settings_outofstock = array();
		echo '<div class="wos-top">';

		$p = plugins_url('assets/', dirname(__FILE__));
		$arr = array();
		$sel = array();
		$nums = array();

		$classes = array();
		$native_classes = array(
			'has-post-thumbnail','downloadable','virtual','shipping-taxable',
			'purchasable','product-type-variable','has-children','instock','outofstock'
		);
		array_push($arr, 'banner-diagnoal.png');
		array_push($arr, 'sign-pin.png');
		array_push($arr, 'sold-out-banner.png');
		array_push($arr, 'sold-out-stamp.png');
		array_push($arr, 'stamp-semi-diagonal.png');
		array_push($arr, 'banner-diagnoal.png');

		for ($i=0; $i<=10; $i++) {
			array_push($nums, $i);
		}
		//var_dump($arr);

		/*foreach ($arr as $var) {
			$text = $p . $var;
			echo '<br>'.$text;
		}*/

		$rows = 0; $max = 0;
		$rows = get_option('outofstock_2_rows');
		$max = get_option('outofstock_2_max_rows');
		$sec = get_option('outofstock_sec');
		
		if ($max == 0) {
			update_option('outofstock_2_max_rows', $rows);
		} elseif ($rows > $max ) {
			update_option('outofstock_2_max_rows', $rows);
		//} else {
		}
		//var_dump($rows);

		/*
		* LOOP FOR GETTIGN ALL PRODUCT CATEGORIES
		*/
		$taxonomy     = 'product_cat';
		$orderby      = 'name';  
		$show_count   = 0;      // 1 for yes, 0 for no
		$pad_counts   = 0;      // 1 for yes, 0 for no
		$hierarchical = 1;      // 1 for yes, 0 for no  
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$all_categories = get_categories( $args );

		foreach ($all_categories as $cat) {

			if($cat->category_parent == 0) {
			    $category_id = $cat->term_id;
			    array_push($sel, $cat->slug);
			    //echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';

			    $args2 = array(
			            'taxonomy'     => $taxonomy,
			            'child_of'     => 0,
			            'parent'       => $category_id,
			            'orderby'      => $orderby,
			            'show_count'   => $show_count,
			            'pad_counts'   => $pad_counts,
			            'hierarchical' => $hierarchical,
			            'title_li'     => $title,
			            'hide_empty'   => $empty
			    );
			    $sub_cats = get_categories( $args2 );
			    if($sub_cats) {
			        foreach($sub_cats as $sub_category) {
			            //echo   ;
			            //array_push($sel, strtolower($sub_category->name));
			            array_push($sel, $sub_category->slug);
			        }   
			    }
			}       
		}

		/*
		* LOOP FOR GETTIGN ALL PRODUCTS
		*/
		$args = array( 
                'post_type' => 'product', 
                'orderby' => 'id', 
                'order' => 'ASC',
                //'product_cat' => 'My Product Category',
                'post_status' => 'publish');
		$posts = query_posts($args);

		foreach ($posts as $prod) {
			array_push($sel, 'post-'.$prod->ID);
		}

		/**
		* LOOP FOR ADDING NATIVE CLASSES
		*/
		foreach ($native_classes as $class) {
			array_push($sel, $class);
		}
		//var_dump($sel);
		/*
		* LOOP FOR building all selecter classes for overlays
		*/
		$count = 0;
		foreach ($sel as $class) {
			//array_push($classes, array('id' => $count, 'value' => $class));
			//array_push($classes, array('id' => $count, 'class' => $class));
			array_push($classes, $class);
			//'opt_'.$i      => __( $arr[$i], 'woocommerce' )
			$count++;
		}

		//set_option('')
		//var_dump($classes);
		update_option( 'outofstock_2_classes', $classes );
		$c = get_option('selector_classes');
		//var_dump($c);
		//echo $c[1];

		//var_dump($posts);
		//$arr = array('instock','outofstock');

		// Add Title to the Settings
		$settings_outofstock[] = array( 'name' => __( 'Woocommerce Custom Overlays', 'woo-outofstock' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure Woocommerce Custom Overlays', 'woo-outofstock' ), 'id' => '' );
		// Add first checkbox option
		/*$settings_outofstock[] = array(
			'name'     => __( 'Disable Overlay', 'woo-outofstock' ),
			'desc_tip' => __( '', 'woo-outofstock' ),
			'id'       => 'disable_outofstock_2_overlay',
			'type'     => 'checkbox',
			//'css'      => 'min-width:300px;',
			'desc'     => __( '<small>&nbsp;Check this to <b>DISABLE</b> the out of stock overlay</small>', 'woo-outofstock' )
		);*/
		// Add second text field option
		$settings_outofstock[] = array(
			'name'     => __( 'License Key', 'woo-outofstock' ),
			//'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
			'id'       => 'outofstock_2_license_key',
			'type'     => 'text',
			'desc'     => __( '&nbsp;<button class="button button-primary"><a id="submit" style="color:#FFF;">Save</a></button>', 'woo-outofstock' ),
			//'placeholder' => 'center top',
			'css'    => 'max-width:500px; width:550px;'
		);



		$settings_outofstock[] = array(
			'name'     => __( 'No. of Rows', 'woo-outofstock' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
			'id'       => 'outofstock_2_rows',
			'type'     => 'select',
			'class'    => 'wc-enhanced-select',
			'default' => 0,
			'desc'     => __( '&nbsp;', 'woo-outofstock' ),
			//'desc'     => __( '&nbps;<button class="button button-primary"><a id="submit" style="color:#FFF;">Add Row</a></button><hr style="float:left;width:90%;border: 1px solid #000;margin-top: 35px;margin-bottom:15px;">', 'woo-outofstock' ),
			//'placeholder' => 'center top',
			'css'    => 'max-width:70px;width:100%; text-align:center;',
			'options' => __( $nums, 'woo-outofstock')
		);

		$settings_outofstock[] = array(
			'name'     => __( 'Max Rows', 'woo-outofstock' ),
			//'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
			'id'       => 'outofstock_2_max_rows',
			'type'     => 'hidden',
			//'class'    => 'wc-enhanced-select',
			'default' => 0,
			'desc'     => __( '&nbsp;', 'woo-outofstock' )
			//'desc'     => __( '&nbps;<button class="button button-primary"><a id="submit" style="color:#FFF;">Add Row</a></button><hr style="float:left;width:90%;border: 1px solid #000;margin-top: 35px;margin-bottom:15px;">', 'woo-outofstock' ),
			//'placeholder' => 'center top',
			//'css'    => 'max-width:70px;width:100%; text-align:center;',
			//'options' => __( $nums, 'woo-outofstock')
		);

		//$settings_outofstock[] = array(submit_button("Save"));

		$settings_outofstock[] = array(
			'name'     => __( 'Woo Secs', 'woo-outofstock' ),
			'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
			'id'       => 'outofstock_sec',
			'type'     => 'hidden',
			'desc'     => __( '', 'woo-outofstock' ),
			'placeholder' => '',
			'class'    => ''
		);
	

		if ($rows > 0):

			for ($i = 0; $i < $rows; $i++) {
				//echo '<hr>';

			$settings_outofstock[] = array(
				'title'    => __( 'Selector Class', 'woocommerce' ),
				'desc'     => __( 'This option lets you limit which countries you are willing to sell to.', 'woocommerce' ),
				'id'       => 'outofstock_2_selector_'.$i,
				'default'  => __('', 'woo-outofstock'),
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'css'      => 'min-width: 350px;',
				'desc_tip' =>  true,
				//'options'  => array(
				//	'opt_'.$i      => __( $arr[$i], 'woocommerce' ),
				//)
				'options' => __( $classes, 'woo-outofstock')
			);
			/*$settings_outofstock[] = array(
				'name'     => __( 'Backgroound Size', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_size_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => '100% 100%',
				'default' => '100% 100%',
				'class'    => ''
			);*/


			$settings_outofstock[] = array(
				'name'     => __( 'Background Position', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_position_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => 'center top',
				'default' => 'center top',
				'class'    => ''
			);
			$settings_outofstock[] = array(
				'name'     => __( 'Background Color', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_color_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'default' => 'transparent',
				'class'    => ''
			);

			$settings_outofstock[] = array(
				'name'     => __( 'Background Repeat', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_background_repeat_'.$i,
				'type'     => 'text',
				//'default' => 'no-repeat',
				'autoload' => false,
				///'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => 'no-repeat',
				'default' => 'no-repeat',
				'class'    => ''
			);

			$settings_outofstock[] = array(
				'name'     => __( 'Image Opacity', 'woo-outofstock' ),
				'desc_tip' => __( 'Set the opacity of the overlay image. Default is <b>.8</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_image_opacity_'.$i,
				'type'     => 'text',
				'desc'     => __( '', 'woo-outofstock' ),
				'placeholder' => '.8',
				'default' => '.8',
				'class'    => ''
			);
			

			
			$settings_outofstock[] = array(
				'name'     => __( 'Overlay Image URL', 'woo-outofstock' ),
				'desc_tip' => __( 'This will be the URL of the image you are using for the Out of Stock overlay. Make sure it is a <b>PNG</b>', 'woo-outofstock' ),
				'id'       => 'outofstock_2_image_url_'.$i,
				'default' => plugins_url('assets/sign-pin.png', dirname(__FILE__)),
				'type'     => 'text',
				'desc'     => __( '&nbsp;Make sure your image is a <b>PNG!</b><br><hr style="float:left;width:90%;border: 1px dotted #CCC;margin-top: 35px;margin-bottom:15px;">', 'woo-outofstock' ),
				'class'    => 'overlay-input',
				'css' => 'max-width:700px;width:100%;'
			);

			/*$settings_outofstock[] = array(
				//'name'     => __( 'Overlay Image URL', 'woo-outofstock' ),
				//'desc_tip' => __( 'This will be the URL of the image you are using for the Out of Stock overlay. Make sure it is a <b>PNG</b>', 'woo-outofstock' ),
				//'id'       => ''.$i,
				//'default' => plugins_url('assets/sign-pin.png', dirname(__FILE__)),
				'type'     => 'text',
				'desc'     => __( '&nbsp;<button class="button button-primary wos-block"><a id="submit" style="color:#FFF;">Save</a></button><hr style="float:left;width:90%;border: 1px dotted #CCC;margin-top: 35px;margin-bottom:15px;">', 'woo-outofstock' ),
				'class'    => 'overlay-input',
				'css' => 'display:none;'
			);*/
			//submit_button("Save Row");
			//echo '<br><hr><br>';
		}
		endif;
		$settings_outofstock[] = array( 'type' => 'sectionend', 'id' => 'outofstock_2' );
		
	
		
    	//echo '<p class="submit wos-submit">';
    	//submit_button( 'Reset All', 'delete button-secondary', 'wos-delete', false, $other_attributes );
		return $settings_outofstock;
        //return apply_filters( 'wc_settings_tab_wos_settings', $settings_outofstock );
        echo '</div">';
       
    }
}
WC_Settings_Tab_wos::init();