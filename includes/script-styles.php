<?php
namespace Nextraa;

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
 * Script styles to run jQuery on pages
 */
add_action( 'init', 'wco_setup_scripts' );
add_action( 'init', 'wco_scripts', 1 );
//add_action( 'wp_enqueue_scripts', 'oss_styles' );

function wco_setup_scripts() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
}

/**
 * Enqueue scripts
 */

function wco_scripts() { ?>

	<?php $rows = get_option( 'wco_2_rows' ); ?>

	<?php //if ( isset( $rows ) ) { ?>

	<?php
	global $arr_2;
	$arr   = [];
	$arr_2 = [];
	$set   = [
		'wco_2_background_color_',
		'wco_2_background_position_',
		'wco_2_background_repeat_',
		'wco_2_background_size_',
		'wco_2_image_opacity_',
		'wco_2_image_url_',
		'wco_2_selector_',
		'wco_2_selector_',
	];
	$i     = 0;
	$l     = 1;

	for ( $k = 0; $k < $rows; $k ++ ) {
		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_background_color_' . $k,
			'value'  => get_option( 'wco_2_background_color_' . $k ),
		];

		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_background_position_' . $k,
			'value'  => get_option( 'wco_2_background_position_' . $k ),
		];
		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_background_repeat_' . $k,
			'value'  => get_option( 'wco_2_background_repeat_' . $k ),
		];
		/*array_push($arr_2,  array('id'=>$k,
							   'option' => 'wco_2_background_size_'.$k,
							   'value'=> get_option('wco_2_background_size_'.$k)));*/

		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_image_opacity_' . $k,
			'value'  => get_option( 'wco_2_image_opacity_' . $k ),
		];
		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_image_url_' . $k,
			'value'  => get_option( 'wco_2_image_url_' . $k ),
		];

		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_selector_' . $k,
			'value'  => get_option( 'wco_2_selector_' . $k ),
		];

		$opt = get_option( 'wco_2_selector_' . $k . '_text' );
		$terms = get_terms(['taxonomy'=>'product_cat', 'name'=>$opt]);
		$prod = get_posts(['post_type'=>'product', 'post_title'=> $opt]);


		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_selector_' . $k . '_text',
			'value'  => get_option( 'wco_2_selector_' . $k . '_text' ),
		];

		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_selector_' . $k . '_obj',
			'value'  => get_option( 'wco_2_selector_' . $k . '_obj' ),
		];

		$text = get_option( 'wco_2_selector_' . $k . '_text' );

		$args = [
			'post_type' => 'product',
			'post_title'     => esc_attr($text),
		];

		$aaa = get_option( 'wco_2_classes' );
		$var = get_option( 'wco_2_selector_' . $k );
		$cla = $aaa[ intval( $var ) ];

		$arr_2[] = [
			'id'     => $k,
			'option' => 'wco_2_class_' . $k,
			'value'  => $cla,
		];
	}

	//var_dump($arr_2);

	//var_dump($arr_2[0][1]['value']);
	$p = 0;
	global $arr_3, $arr_4, $arr_5, $arr_5;
	$arr_3 = [];
	$arr_4 = [];
	$arr_5 = [];
	$arr_6 = [];

	//var_dump($arr_3);
	//var_dump($arr_4);
	//var_dump($arr_4);

	//var_dump($arr_4);

	?>
    <script type="text/javascript">

      jQuery(document).ready(function ($) {


      });

    </script>

	<?php $count = count( $arr_2 ); ?>
    <style type="text/css">'
        <?php $i = 0; ;$k = 0;$r = -1; //var_dump($arr_2); ?>
        <?php foreach ($arr_2 as $value) {//for ($p = 0; $p <= count($arr_2); $p++ ) {?>

        <?php var_dump($terms); var_dump($prod);
	
			//var_dump($val['value']);
		//}
			//var_dump($arr_2);
		$id = $value['id'];

		$option = sanitize_text_field($value['option']);
		$value = sanitize_text_field($value['value']);
		//var_dump($id); var_dump($option); var_dump($value);

	

		if ( $option ===  'wco_2_background_color_'.$id ) {
			$color = $value; var_dump($color);
		}
		if ( $option ===  'wco_2_background_position_'.$id ) {
			$position = $value;
		}
		if ( $option ===  'wco_2_background_repeat_'.$id ) {
			$repeat = $value;
		}
		/*if ( $option ===  'wco_2_background_size_'.$id ) {
			$size = $value;
		}*/
		if ( $option ===  'wco_2_image_opacity_'.$id ) {
			$opacity = $value;
		}
		if ( $option ===  'wco_2_image_url_'.$id ) {
			$url = esc_url($value);
		}
		if ( $option ===  'wco_2_selector_'.$id ) {
			$selector = $value;
		}
		if ( $option ===  'wco_2_selector_'.$id .'_text' ) {
			$selector = $value;
		}
		if ( $option ===  'wco_2_selector_'.$id.'_obj' ) {
			$selector = $value;
		}
		if ( $option ===  'wco_2_class_'.$id ) {
			$class = '.'.$value.' ';
		}
			//var_dump($i);
			
			//var_dump($i);

			//var_dump($option);
			//var_dump($val[5]);
			//var_dump($value);
		echo '';

		if ($class !== null) { ?>

        .products <?php echo $class; ?> .button:before {
            background: none !important;
            display: inherit !important;
        }

        <?php echo $class; ?>
        .images .thumbnails a:before {
            width: 75%;
            height: auto;
            background: none !important;
            display: inherit !important;
        }

        <?php echo $class; ?>
        .images a:before {
            background-image: url(' <?php echo $url; ?> ');
            background-color: <?php echo $color; ?>;
            background-repeat: <?php echo $repeat; ?>;
            background-position: <?php echo $position; ?>;
            display: inherit !important;
            opacity: <?php echo $opacity; ?>;
            z-index: 1 !important;
            float: none;
        }

        .products <?php echo $class; ?> a:before {
            background-image: url(' <?php echo $url; ?> ');
            background-color: <?php echo $color; ?>;
            background-repeat: <?php echo $repeat; ?>;
            background-position: <?php echo $position; ?>;
            display: inherit !important;
            opacity: <?php echo $opacity; ?>;
            z-index: 1 !important;
            float: none;
        }

        <?php echo $class; ?>
        .images a,
        .products <?php echo $class; ?> a {
            position: relative !important;
            /*display:block  !important;*/
        }

        <?php echo $class; ?>
        .images a:before,
        .products <?php echo $class; ?> a:before {
            content: " " !important;
            height: 100% !important;
            position: absolute !important;
            width: 100% !important;
            display: inherit;
        }

        <?php $class = null; } ?>

        <?php } ?>
    </style>

<?php }



