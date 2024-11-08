<?php

use Elementor\Plugin;

function marvy_pro_get_config()
{
    return $GLOBALS['marvy_pro_config']['bg-animation'];
}

function marvy_pro_get_setting($element = null)
{
    $animations = marvy_pro_get_config();
    $defaults = array_fill_keys(array_keys($animations), true);
    $elements = get_option('marvy_option_settings');
    $elements = !empty($elements) ? $elements : [];
    $elements = array_merge($defaults, $elements);

    return (isset($element) ? (isset($elements[$element]) ? $elements[$element] : 0) : array_keys(array_filter($elements)));
}

function is_marvy_pro_preview_mode()
{
    if (isset($_REQUEST['elementor-preview'])) {
        return false;
    }

    if (isset($_REQUEST['ver'])) {
        return false;
    }

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'elementor') {
        return false;
    }
    $url_params = !empty($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) : parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
   
    if(is_string($url_params)){
        parse_str($url_params, $params);
    }

    if (!empty($params['action']) && $params['action'] == 'elementor') {
        return false;
    }
    return true;
}

function marvy_pro_filter_widgets($id = null)
{
    $animations = marvy_pro_get_config();
    $defaults = array_keys($animations);
    $get_setting = marvy_pro_get_setting();
    $defaults = array_intersect($defaults, $get_setting);
    $new_default = array_map(function ($animation) {
        return 'marvy_enable_' . $animation;
    }, $defaults);

    if (!Plugin::$instance->documents->get( $id )->is_built_with_elementor()) return;

    $elements = Plugin::$instance->documents->get($id);
    $collections = get_marvy_pro_animation_in_content($elements->get_elements_data(), $new_default);

    return array_map(function ($animation) {
        return substr($animation, 13);
    }, array_intersect($new_default, $collections));

}

function get_marvy_pro_animation_in_content($elements, $animation_list)
{
    $animations = [];
    foreach ($elements as $element) {
        // collect extensions for section
        if (isset($element['elType']) && in_array($element['elType'],["section","container"])){
            $keys = array_values(array_filter(array_keys($element['settings']), function ($val) use ($animation_list) {
                return in_array($val, $animation_list);
            }));
            $animations = array_merge($animations, $keys);
        }
        if (!empty($element['elements'])) {
            $animations = array_merge($animations, get_marvy_pro_animation_in_content($element['elements'], $animation_list));
        }
    }
    return $animations;
}

/**
 * Make lite version available for Pro
 *
 */
function marvy_make_lite_version()
{
    // Get marvy animation lite version basename
    $basename = '';
    $plugins = get_plugins();
    foreach ($plugins as $key => $data) {
        if ($data['TextDomain'] === "marvy-animation-addons-for-elementor-lite") {
            $basename = $key;
        }
    }

    $plugin_data = get_marvy_plugin_data('marvy-animation-addons-for-elementor-lite');

    if (is_marvy_plugin_installed($basename)) {
        // upgrade plugin
        if (isset($plugin_data->version) && marvy_pro_get_lite_plugin_version($basename) != $plugin_data->version) {
            marvy_pro_upgrade_plugin($basename);
        }

        if (!is_plugin_active($basename)) {
            activate_plugin(marvy_call_path(WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $basename), '', false, false);
            return true;
        }
    } else {
        if (isset($plugin_data->download_link)) {
            marvy_install_plugin($plugin_data->download_link);
            return true;
        }
    }
    return false;
}

function marvy_pro_get_lite_plugin_version($basename)
{
    if (!function_exists('get_plugins')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    return $plugins[$basename]['Version'];
}

function marvy_pro_upgrade_plugin($basename)
{
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';

    $skin = new \Automatic_Upgrader_Skin;
    $upgrader = new \Plugin_Upgrader($skin);
    $upgrader->upgrade($basename);

    return $skin->result;
}

function is_marvy_plugin_installed($basename)
{
    if (!function_exists('get_plugins')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $plugins = get_plugins();

    return !empty($plugins[$basename]);
}

function marvy_call_path($path)
{
    $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);

    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
}

function marvy_install_plugin($plugin_url)
{
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';

    $skin = new \Automatic_Upgrader_Skin;
    $upgrade = new \Plugin_Upgrader($skin);
    $upgrade->install($plugin_url);

    // activate plugin
    activate_plugin($upgrade->plugin_info(), '', false, false);

    return $skin->result;
}

function get_marvy_plugin_data($slug = '')
{
    $args = array(
        'slug' => $slug,
        'fields' => array(
            'version' => false,
        ),
    );

    $response = wp_remote_post(
        'http://api.wordpress.org/plugins/info/1.0/',
        array(
            'body' => array(
                'action' => 'plugin_information',
                'request' => serialize((object)$args),
            ),
        )
    );

    if (is_wp_error($response)) {
        return false;
    } else {
        $response = unserialize(wp_remote_retrieve_body($response));

        if ($response) {
            return $response;
        } else {
            return false;
        }
    }
}

function marvy_if_failed_load()
{
    if (!current_user_can('activate_plugins')) {
        return;
    }

    $requiredPlugins = [
        [
            "textDomain" => 'elementor',
            "pluginName" => "Elementor"
        ],
        [
            "textDomain" => 'marvy-animation-addons-for-elementor-lite',
            "pluginName" => "Marvy - Ultimate Elementor Animation addons"
        ]
    ];

    $plugins = get_plugins();
    if (count($requiredPlugins) > 0) {
        foreach ($requiredPlugins as $rPlugin) {
            $basename = '';
            $url = '';
            foreach ($plugins as $key => $data) {
                if ($data['TextDomain'] === $rPlugin['textDomain']) {
                    $basename = $key;
                }
            }
            if (is_marvy_plugin_installed($basename) && !is_plugin_active($basename)) {
                $url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $basename . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $basename);
                $message = __('<strong>Marvy Animation Addons - Pro</strong> requires <strong>' . $rPlugin['pluginName'] . '</strong> plugin to be active. Please activate ' . $rPlugin['pluginName'] . ' for Marvy Animation Pro to continue.', 'marvy-animation-addons');
                $button_text = __('Activate Marvy Addons for ' . $rPlugin['pluginName'], 'marvy-animation-addons');
            }
            if ($basename === '') {
                $url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $rPlugin['textDomain']), 'install-plugin_' . $rPlugin['textDomain']);
                $message = sprintf(__('<strong>Marvy Animation Addons - Pro</strong> requires <strong>' . $rPlugin['pluginName'] . '</strong> plugin to be installed and activated. Please install ' . $rPlugin['pluginName'] . ' for Marvy Animation Pro to continue.', 'marvy-animation-addons'), '<strong>', '</strong>');
                $button_text = __('Install Marvy Addons for ' . $rPlugin['pluginName'], 'marvy-animation-addons');
            }

            if ($url !== '') {
                $button = '<p><a href="' . $url . '" class="button-primary">' . $button_text . '</a></p>';
                printf('<div class="error"><p>%1$s</p>%2$s</div>', __($message), $button);
                deactivate_plugins(MARVY_PRO_ANIMATION_ADDONS_BASE_PATH);
                break;
            }
        }
    }
}

function marvy_if_license_deactivate()
{
    if (!current_user_can('activate_plugins')) {
        return;
    }

    $url = wp_nonce_url(self_admin_url('admin.php?page=marvy-animation'));
    $message = sprintf(__('<strong>Marvy Animation Addons - Pro</strong> requires <strong>License Code</strong> for use pro features. Please enter license code for Marvy Animation Pro to continue.', 'marvy-lang'), '<strong>', '</strong>');
    $button_text = __('Add License Code for Marvy Animation Addons Pro', 'marvy-lang');

    $button = '<p><a href="' . $url . '" class="button-primary">' . $button_text . '</a></p>';

    printf('<div class="notice notice-warning"><p>%1$s</p>%2$s</div>', __($message), $button);
}