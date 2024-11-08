<?php 
/*
Plugin Name: Umetric Extensions	
Plugin URI: https://wordpress.iqonic.design/umetric/
Description: umetric plugin provides custom team post type, gallery post type with related functionality.
Author: https://iqonic.design/
Version: 1.4.3
Author URI: https://iqonic.design/
Text Domain: umetric_NAME
*/

if( !defined( 'umetric_TH_ROOT' ) ) 
	define('umetric_TH_ROOT', plugin_dir_path( __FILE__ ));

if( !defined( 'umetric_TH_URL' ) ) 
	define( 'umetric_TH_URL', plugins_url( '', __FILE__ ) );

if( !defined( 'umetric_NAME' ) ) 
	define( 'umetric_NAME', 'umetric' );

$umetric_option = get_option('umetric_options');


// Faqs custom post type
add_action( 'init', 'umetric_career' );
function umetric_career() {
	$labels = array(
		'name'                  => esc_html__( 'Career', 'post type general name', 'umetric' ),
		'singular_name'         => esc_html__( 'Career', 'post type singular name', 'umetric' ),
		'featured_image'        => esc_html__( 'Career Photo', 'umetric'  ),
		'set_featured_image'    => esc_html__( 'Set Career Photo', 'umetric'  ),
		'remove_featured_image' => esc_html__( 'Remove Career Photo', 'umetric'  ),
		'use_featured_image'    => esc_html__( 'Use as Career Photo', 'umetric'  ),
		'menu_name'             => esc_html__( 'Career', 'admin menu', 'umetric' ),
		'name_admin_bar'        => esc_html__( 'Career', 'add new on admin bar', 'umetric' ),
		'add_new'               => esc_html__( 'Add New', 'Career', 'umetric' ),
		'add_new_item'          => esc_html__( 'Add New Career', 'umetric' ),
		'new_item'              => esc_html__( 'New Career', 'umetric' ),
		'edit_item'             => esc_html__( 'Edit Career', 'umetric' ),
		'view_item'             => esc_html__( 'View Career', 'umetric' ),
		'all_items'             => esc_html__( 'All Careers', 'umetric' ),
		'search_items'          => esc_html__( 'Search Career', 'umetric' ),
		'parent_item_colon'     => esc_html__( 'Parent Career:', 'umetric' ),
		'not_found'             => esc_html__( 'No Classs found.', 'umetric' ),
		'not_found_in_trash'    => esc_html__( 'No Classs found in Trash.', 'umetric' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'career' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-media-text',
		'supports'           => array( 'title', 'editor', 'thumbnail','category','tag')
	);

	register_post_type( 'career', $args );
}

// Custom taxonomy Faqs
add_action( 'after_setup_theme', 'umetric_custom_faq_taxonomy' );
function umetric_custom_faq_taxonomy() {
	register_taxonomy(
		'umetricfaqs-categories',
		'umetricfaqs',
		array(
			'label' => esc_html__( 'Faq Category', 'umetric' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
	register_taxonomy(
		'umetricfaqs-tag',
		'umetricfaqs',
		array(
			'label' => esc_html__( 'Faq Tag', 'umetric' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
}

require_once(umetric_TH_ROOT . 'widget/footer-contact.php');

require_once(umetric_TH_ROOT . 'widget/footer-logo.php');

require_once(umetric_TH_ROOT . 'widget/subscribe.php');

require_once(umetric_TH_ROOT . 'widget/social_media.php');

require_once(umetric_TH_ROOT . 'widget/recent-post.php');

require_once(umetric_TH_ROOT . 'inc/elementor/init.php');

if( function_exists( 'get_field' ) ){
	require_once( umetric_TH_ROOT. 'inc/meta-box/init.php' );
}

/*---------------------------------------
		umetric admin enque
---------------------------------------*/
function umetric_enqueue_custom_admin_style() {

	wp_register_style( 'umetric_wp_admin_css', umetric_TH_URL . '/extensions/assets/css/umetric.min.css', false, '1.0.0' );
	wp_enqueue_style( 'umetric_wp_admin_css' );

}
add_action( 'admin_enqueue_scripts', 'umetric_enqueue_custom_admin_style' );



?>