<?php
/*
Plugin Name: Trading Referral
Description: Import trading_referral to WordPress post.
Version: 1.0
Author: Hztech
*/

function custom_post_type_trading_referral() {
    $labels = array(
        'name' => 'Trading Referral',
        'singular_name' => 'Trading Referral',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Trading Referral',
        'edit_item' => 'Edit Trading Referral',
        'new_item' => 'New Trading Referral',
        'view_item' => 'View Trading Referral',
        'search_items' => 'Search Trading referral',
        'not_found' => 'No Trading referral found',
        'not_found_in_trash' => 'No Trading referral found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Trading referral',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'trading_referral'),
    );

    register_post_type('trading_referral', $args);
}

add_action('init', 'custom_post_type_trading_referral');

function add_trading_referral_meta_box() {
    add_meta_box(
        'trading_referral_meta_box',
        'Trading Referral Information',
        'render_trading_referral_meta_box',
        'trading_referral',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'add_trading_referral_meta_box');

function render_trading_referral_meta_box($post) {
    // Use nonce for verification
    wp_nonce_field('custom_meta_box_nonce', 'custom_meta_box_nonce');

    $value = get_post_meta($post->ID, 'trading_referral_link', true);

    echo '<label for="trading_referral_link">Link</label>';
    echo '<br><input type="text" id="trading_referral_link" name="trading_referral_link" value="' . esc_attr($value) . '" />';
}

function save_custom_meta_box_data_trading_referral($post_id) {
    // Check if our nonce is set
    if (!isset($_POST['custom_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], 'custom_meta_box_nonce')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['trading_referral_link'])) {
        update_post_meta($post_id, 'trading_referral_link', sanitize_text_field($_POST['trading_referral_link']));
    }
}

add_action('save_post', 'save_custom_meta_box_data_trading_referral');
