<?php
/*
Plugin Name: AI MODEL
Description: Import AI_MODEL to WordPress post.
Version: 1.0
Author: Hztech
*/

function custom_post_type_ai_model() {
    $labels = array(
        'name' => 'AI Models',
        'singular_name' => 'AI Model',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New AI Model',
        'edit_item' => 'Edit AI Model',
        'new_item' => 'New AI Model',
        'view_item' => 'View AI Model',
        'search_items' => 'Search AI Models',
        'not_found' => 'No AI Models found',
        'not_found_in_trash' => 'No AI Models found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'AI Models',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'ai_model'),
    );

    register_post_type('ai_model', $args);
}

add_action('init', 'custom_post_type_ai_model');
