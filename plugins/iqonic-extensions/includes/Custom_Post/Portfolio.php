<?php
// Register Portfolio custom post type
add_action( 'init', 'iqonic_portfolio' );
function iqonic_portfolio() {
	$labels = array(
		'name'                  => esc_html__( 'Portfolio',  'iqonic' ),
		'singular_name'         => esc_html__( 'Portfolio', 'iqonic' ),
		'featured_image'        => esc_html__( 'Portfolio Photo', 'iqonic'  ),
		'set_featured_image'    => esc_html__( 'Set Portfolio Photo', 'iqonic'  ),
		'remove_featured_image' => esc_html__( 'Remove Portfolio Photo', 'iqonic'  ),
		'use_featured_image'    => esc_html__( 'Use as Portfolio Photo', 'iqonic'  ),
		'menu_name'             => esc_html__( 'Portfolio',  'iqonic' ),
		'name_admin_bar'        => esc_html__( 'Portfolio', 'iqonic' ),
		'add_new'               => esc_html__( 'Add New','iqonic' ),
		'add_new_item'          => esc_html__( 'Add New Portfolio', 'iqonic' ),
		'new_item'              => esc_html__( 'New Portfolio', 'iqonic' ),
		'edit_item'             => esc_html__( 'Edit Portfolio', 'iqonic' ),
		'view_item'             => esc_html__( 'View Portfolio', 'iqonic' ),
		'all_items'             => esc_html__( 'All Portfolio', 'iqonic' ),
		'search_items'          => esc_html__( 'Search Portfolio', 'iqonic' ),
		'parent_item_colon'     => esc_html__( 'Parent Portfolio :', 'iqonic' ),
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
		'rewrite'            => true,
		'capability_type'    => 'post',
		'show_in_nav_menus'   => TRUE,
		'has_archive'        => true,
		'hierarchical'       => false,		
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-category',
		'supports'           => array( 'title', 'editor', 'thumbnail','category','tag')
	);

	register_post_type( 'portfolio', $args );
}



// Custom taxonomy
add_action( 'after_setup_theme', 'iqonic_custom_taxonomy' );
function iqonic_custom_taxonomy() {
	$labels = '';
	register_taxonomy(
		'portfolio-categories',
		'portfolio',
		array(
			'label' => esc_html__( 'Portfolio Category', 'iqonic' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
	register_taxonomy('portfolio-tag','portfolio',array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'tag' ),
	));
}