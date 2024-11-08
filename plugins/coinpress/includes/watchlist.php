<?php


if (!defined('ABSPATH')) {
    exit;
}

class Watchlist {
    public $config;

    public function __construct($config) {
        global $wpdb;
        $this->config = $config;

        $this->init();

    }

    public function init() {
        
        add_action('wp_ajax_watchlist', array($this, 'watchlist_update'));
        add_action('wp_ajax_nopriv_watchlist', array($this, 'watchlist_update'));
                    
        // actions to update the watchlist user meta on register/login
        add_action( 'user_register', array($this,'register_redirect_watchlist'), 20, 1);
        add_action( 'wp_login',      array($this,'login_redirect_watchlist'), 20, 2);
    }

    public function watchlist_update(){
        $user_id = get_current_user_id();
        $action = $_POST['process'];
        $response = [];

        if($action == 'setcookie'){ 
            // setcookie('cmc_watchlist_item', $_POST['coin'], strtotime('+1 hour'));
            setcookie('cmc_watchlist_item', $_POST['coin'], (time()+3600), "/");
            $response['redirect_to'] = wp_login_url();
        }

        $response['coins'] = get_user_meta($user_id, 'cmc_watchlist', true) ? array_filter(get_user_meta($user_id, 'cmc_watchlist', true)) : [];
        if($action == 'update'){
            $index = array_search($_POST['coin'], $response['coins']);
            if($index > -1){
                array_splice($response['coins'], $index, 1);
                $response['action']  = false; // stands that coin is removed
            } else {
                array_push($response['coins'], $_POST['coin']);
                $response['action']  = true; // stands that coin is added
            }
            update_user_meta($user_id, 'cmc_watchlist', $response['coins']);
        }
        $response['coins'] = get_user_meta($user_id, 'cmc_watchlist', true);

        $response['status'] = 'success';

        wp_send_json($response);

    }

    public function update_usermeta_watchlist($user_id = null){
        global $wp;
        $watchlist_state = apply_filters('watchlist_user_control', true);
        if($watchlist_state && !empty($_COOKIE['cmc_watchlist_item'])){
            $coin = $_COOKIE['cmc_watchlist_item'];
            if($coin){
                $data = get_user_meta($user_id, 'cmc_watchlist', true);
                if(!empty($data)){
                    if(!in_array($coin, $data)){
                        $data[] = $coin;
                    }
                } else {
                    $data = [];
                    $data[] = $coin;
                }
                update_user_meta($user_id, 'cmc_watchlist', $data);
            }
        }

    }

    public function login_redirect_watchlist($meta, $user){
        $this->update_usermeta_watchlist($user->ID); 
    }

    public function register_redirect_watchlist($user_id){ 
        $this->update_usermeta_watchlist($user_id); 
    }

}