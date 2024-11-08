<?php

/**
 * Plugin Name:     EthPress NFT Access Add-On
 * Plugin URI:      https://gitlab.com/losnappas/ethpress-nft-access-addon
 * Description:     NFT ERC-721 and ERC-1155 access control support for EthPress.
 * Author:          Lynn (lynn.mvp at tutanota dot com), ethereumicoio
 * Author URI:      https://ethereumico.io/
 * Text Domain:     ethpress_nft_access_addon
 * Domain Path:     /languages
 * Version:         1.6.7
 * Update URI: https://api.freemius.com
 *
 * @package         Ethpress_NFT_Access
 */
namespace losnappas\Ethpress_NFT_Access;

defined( 'ABSPATH' ) || die;
define( 'ETHPRESS_NFT_ACCESS_ADDON_FILE', __FILE__ );
define( 'ETHPRESS_NFT_ACCESS_ADDON_NS', __NAMESPACE__ );
define( 'ETHPRESS_NFT_ACCESS_ADDON_PHP_MIN_VER', '7.0.0' );
define( 'ETHPRESS_NFT_ACCESS_ADDON_WP_MIN_VER', '4.6.0' );
// Set plugin options
global  $ETHPRESS_NFT_ACCESS_ADDON_options ;
$ETHPRESS_NFT_ACCESS_ADDON_options = get_option( 'ethpress', array() );
if ( !function_exists( 'ETHPRESS_NFT_ACCESS_ADDON_deactivate' ) ) {
    /**
     * Deactivates.
     */
    function ETHPRESS_NFT_ACCESS_ADDON_deactivate()
    {
        if ( !current_user_can( 'activate_plugins' ) ) {
            return;
        }
        deactivate_plugins( plugin_basename( ETHPRESS_NFT_ACCESS_ADDON_FILE ) );
    }

}

if ( version_compare( \get_bloginfo( 'version' ), ETHPRESS_NFT_ACCESS_ADDON_WP_MIN_VER, '<' ) || version_compare( PHP_VERSION, ETHPRESS_NFT_ACCESS_ADDON_PHP_MIN_VER, '<' ) ) {
    /**
     * Displays notification.
     */
    function ETHPRESS_NFT_ACCESS_ADDON_compatability_warning()
    {
        echo  '<div class="error"><p>' . esc_html( sprintf(
            /* translators: version numbers. */
            __( '“%1$s” requires PHP %2$s (or newer) and WordPress %3$s (or newer) to function properly. Your site is using PHP %4$s and WordPress %5$s. Please upgrade. The plugin has been automatically deactivated.', 'ethpress_nft_access_addon' ),
            'EthPress NFT Access Add-On',
            ETHPRESS_NFT_ACCESS_ADDON_PHP_MIN_VER,
            ETHPRESS_NFT_ACCESS_ADDON_WP_MIN_VER,
            PHP_VERSION,
            $GLOBALS['wp_version']
        ) ) . '</p></div>' ;
        // phpcs:ignore -- no nonces here.
        if ( isset( $_GET['activate'] ) ) {
            // phpcs:ignore -- no nonces here.
            unset( $_GET['activate'] );
        }
    }
    
    add_action( 'admin_notices', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_compatability_warning' );
    add_action( 'admin_init', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_deactivate' );
    return;
}


if ( !function_exists( 'gmp_init' ) ) {
    add_action( 'admin_init', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_deactivate' );
    add_action( 'admin_notices', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_admin_notice_gmp' );
    function ETHPRESS_NFT_ACCESS_ADDON_admin_notice_gmp()
    {
        if ( !current_user_can( 'activate_plugins' ) ) {
            return;
        }
        echo  '<div class="error"><p><strong>EthPress NFT Access Add-On</strong> requires the PHP <a target="_blank" href="http://php.net/manual/en/book.gmp.php">GMP</a> module to be installed.</p></div>' ;
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
    
    return;
}


if ( !function_exists( 'mb_strtolower' ) ) {
    add_action( 'admin_init', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_deactivate' );
    add_action( 'admin_notices', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_admin_notice_mbstring' );
    function ETHPRESS_NFT_ACCESS_ADDON_admin_notice_mbstring()
    {
        if ( !current_user_can( 'activate_plugins' ) ) {
            return;
        }
        echo  '<div class="error"><p><strong>EthPress NFT Access Add-On</strong> requires the PHP <a target="_blank" href="http://php.net/manual/en/book.mbstring.php">Multibyte String (mbstring)</a> module to be installed.</p></div>' ;
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
    
    return;
}


if ( !function_exists( __NAMESPACE__ . '\\ethpress_nft_access_addon_freemius_init' ) ) {
    // Create a helper function for easy SDK access.
    function ethpress_nft_access_addon_freemius_init()
    {
        global  $ethpress_nft_access_addon_freemius_init ;
        
        if ( !isset( $ethpress_nft_access_addon_freemius_init ) ) {
            // Activate multisite network integration.
            if ( !defined( 'WP_FS__PRODUCT_10731_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_10731_MULTISITE', true );
            }
            // Include Freemius SDK.
            
            if ( file_exists( dirname( dirname( __FILE__ ) ) . '/ethpress/freemius/start.php' ) ) {
                // Try to load SDK from parent plugin folder.
                require_once dirname( dirname( __FILE__ ) ) . '/ethpress/freemius/start.php';
            } else {
                
                if ( file_exists( dirname( dirname( __FILE__ ) ) . '/ethpress-premium/freemius/start.php' ) ) {
                    // Try to load SDK from premium parent plugin folder.
                    require_once dirname( dirname( __FILE__ ) ) . '/ethpress-premium/freemius/start.php';
                } else {
                    require_once dirname( __FILE__ ) . '/freemius/start.php';
                }
            
            }
            
            $ethpress_nft_access_addon_freemius_init = fs_dynamic_init( array(
                'id'               => '10731',
                'slug'             => 'ethpress-nft-access-addon',
                'type'             => 'plugin',
                'public_key'       => 'pk_1fe9c4d7ffb3175decb2a3c858bfd',
                'is_premium'       => true,
                'is_premium_only'  => true,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'trial'            => array(
                'days'               => 7,
                'is_require_payment' => true,
            ),
                'parent'           => array(
                'id'         => '9248',
                'slug'       => 'ethpress',
                'public_key' => 'pk_45cc0f7a099a59d2117d9fb313d01',
                'name'       => 'EthPress – Web3 Login',
            ),
                'has_affiliation'  => 'all',
                'menu'             => array(
                'slug'           => 'ethpress',
                'override_exact' => true,
                'first-path'     => 'options-general.php?page=ethpress&tab=nft',
                'support'        => false,
                'parent'         => array(
                'slug' => 'options-general.php',
            ),
            ),
                'is_live'          => true,
            ) );
        }
        
        return $ethpress_nft_access_addon_freemius_init;
    }
    
    function ethpress_nft_access_addon_freemius_init_settings_url()
    {
        return admin_url( 'options-general.php?page=ethpress&tab=nft' );
    }

}

function ethpress_nft_access_addon_freemius_init_is_parent_active_and_loaded()
{
    // Check if the parent's init SDK method exists.
    return function_exists( '\\losnappas\\Ethpress\\ethpress_fs' );
}

function ethpress_nft_access_addon_freemius_init_is_parent_active()
{
    $active_plugins = get_option( 'active_plugins', array() );
    
    if ( is_multisite() ) {
        $network_active_plugins = get_site_option( 'active_sitewide_plugins', array() );
        $active_plugins = array_merge( $active_plugins, array_keys( $network_active_plugins ) );
    }
    
    foreach ( $active_plugins as $basename ) {
        if ( 0 === strpos( $basename, 'ethpress/' ) || 0 === strpos( $basename, 'ethpress-premium/' ) ) {
            return true;
        }
    }
    return false;
}

function ethpress_nft_access_addon_freemius_init_init()
{
    
    if ( ethpress_nft_access_addon_freemius_init_is_parent_active_and_loaded() ) {
        // Init Freemius.
        ethpress_nft_access_addon_freemius_init();
        ethpress_nft_access_addon_freemius_init()->add_filter( 'connect_url', __NAMESPACE__ . '\\ethpress_nft_access_addon_freemius_init_settings_url' );
        ethpress_nft_access_addon_freemius_init()->add_filter( 'after_skip_url', __NAMESPACE__ . '\\ethpress_nft_access_addon_freemius_init_settings_url' );
        ethpress_nft_access_addon_freemius_init()->add_filter( 'after_connect_url', __NAMESPACE__ . '\\ethpress_nft_access_addon_freemius_init_settings_url' );
        ethpress_nft_access_addon_freemius_init()->add_filter( 'after_pending_connect_url', __NAMESPACE__ . '\\ethpress_nft_access_addon_freemius_init_settings_url' );
        // Signal that the add-on's SDK was initiated.
        do_action( 'ethpress_nft_access_addon_freemius_init_loaded' );
        // Parent is active, add your init code here.
        require dirname( __FILE__ ) . '/vendor/autoload.php';
        // This "if" block will be auto removed from the Free version.
        Plugin::attach_hooks();
    } else {
        /**
         * Check if EthPress Web3 Login WordPress Plugin is active
         * @see https://wordpress.stackexchange.com/a/193908/137915
         **/
        // Parent is inactive, add your error handling here.
        add_action( 'admin_init', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_deactivate' );
        add_action( 'admin_notices', __NAMESPACE__ . '\\ETHPRESS_NFT_ACCESS_ADDON_admin_notice_base' );
        function ETHPRESS_NFT_ACCESS_ADDON_admin_notice_base()
        {
            if ( !current_user_can( 'activate_plugins' ) ) {
                return;
            }
            echo  '<div class="error"><p><strong>EthPress NFT Access Add-On</strong> requires <a target="_blank" href="https://ethereumico.io/product/web3-login-wordpress-ethpress-plugin/" rel="sponsored nofollow">EthPress Web3 Login WordPress Plugin</a> PRO plugin to be installed.</p></div>' ;
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    
    }

}


if ( ethpress_nft_access_addon_freemius_init_is_parent_active_and_loaded() ) {
    // If parent already included, init add-on.
    ethpress_nft_access_addon_freemius_init_init();
} else {
    
    if ( ethpress_nft_access_addon_freemius_init_is_parent_active() ) {
        // Init add-on only after the parent is loaded.
        add_action( 'ethpress_fs_loaded', __NAMESPACE__ . '\\ethpress_nft_access_addon_freemius_init_init' );
    } else {
        // Even though the parent is not activated, execute add-on for activation / uninstall hooks.
        ethpress_nft_access_addon_freemius_init_init();
    }

}
