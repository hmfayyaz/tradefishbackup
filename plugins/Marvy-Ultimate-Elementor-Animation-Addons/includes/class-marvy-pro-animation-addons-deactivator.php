<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://iqonic.design/
 * @since      1.7.0
 *
 * @package    Marvy_Pro_Animation_Addons
 * @subpackage Marvy_Pro_Animation_Addons/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.7.0
 * @package    Marvy_Pro_Animation_Addons
 * @subpackage Marvy_Pro_Animation_Addons/includes
 * @author     Iqonic Design <hello@iqonic.design>
 */
class Marvy_Pro_Animation_Addons_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.7.0
	 */
	public static function deactivate() {
        delete_transient('marvy_animation_pro');
	}

}
