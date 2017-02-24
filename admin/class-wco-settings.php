<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 2/23/17
 * Time: 10:04 PM
 */

namespace WooImageOverlay;

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//global $wco_settings;

class WCO_Settings {

	public function init() {
		global $wco_settings;

		var_dump($wco_settings);

	}

}