<?php

/**
 * Fired during plugin activation
 *
 * @link       https://iqonic.design/
 * @since      1.7.0
 *
 * @package    Marvy_Pro_Animation_Addons
 * @subpackage Marvy_Pro_Animation_Addons/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.7.0
 * @package    Marvy_Pro_Animation_Addons
 * @subpackage Marvy_Pro_Animation_Addons/includes
 * @author     Iqonic Design <hello@iqonic.design>
 */
class Marvy_Pro_Animation_Addons_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.7.0
     */
    public static function activate()
    {
        $defaults = array_fill_keys(array_keys($GLOBALS['marvy_pro_config']['bg-animation']), 1);
        set_transient('marvy_animation_pro', '1', 0);
        update_option('MarvyPro_is_install',1);
        $options = get_option('marvy_option_settings');
        if(!empty($options)){
            $defaults = array_merge($defaults,$options);
            update_option('marvy_option_settings',$defaults);
        }else{
            update_option('marvy_option_settings',$defaults);
        }
        return marvy_make_lite_version();
    }
}
