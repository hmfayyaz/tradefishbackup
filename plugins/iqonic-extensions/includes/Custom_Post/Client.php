<?php

// Register Team Member custom post type
add_action( 'init', 'iqonic_client' );
function iqonic_client() {
	$labels = array(
		'name'                  => esc_html__( 'Client Member', 'iqonic' ),
		'singular_name'         => esc_html__( 'Client Member', 'iqonic' ),
		'featured_image'        => esc_html__( 'Client Member Photo', 'iqonic'  ),
		'set_featured_image'    => esc_html__( 'Set Client Member Photo', 'iqonic'  ),
		'remove_featured_image' => esc_html__( 'Remove Client Member Photo', 'iqonic'  ),
		'use_featured_image'    => esc_html__( 'Use as Client Member Photo', 'iqonic'  ),
		'menu_name'             => esc_html__( 'Our Client', 'iqonic' ),
		'name_admin_bar'        => esc_html__( 'Client Member',  'iqonic' ),
		'add_new'               => esc_html__( 'Add New', 'iqonic' ),
		'add_new_item'          => esc_html__( 'Add New Client Member', 'iqonic' ),
		'new_item'              => esc_html__( 'New Client Member', 'iqonic' ),
		'edit_item'             => esc_html__( 'Edit Client Member', 'iqonic' ),
		'view_item'             => esc_html__( 'View Client Member', 'iqonic' ),
		'all_items'             => esc_html__( 'All Client Members', 'iqonic' ),
		'search_items'          => esc_html__( 'Search Client Member', 'iqonic' ),
		'parent_item_colon'     => esc_html__( 'Parent Client Member:', 'iqonic' ),
		'not_found'             => esc_html__( 'No Classs found.', 'iqonic' ),
		'not_found_in_trash'    => esc_html__( 'No Classs found in Trash.', 'iqonic' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'client' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-businessman',
		'supports'           => array( 'title', 'thumbnail' ,'editor' ,'excerpt')
	);

	register_post_type( 'client', $args );
}

