<?php
/**
 * Umetric\Utility\Import\Component class
 *
 * @package umetric
 */

namespace Umetric\Utility\Import;

use RevSlider;
use Umetric\Utility\Component_Interface;
use function add_action;


class Component implements Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'import';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{

		add_filter('merlin_generate_child_functions_php', array($this, 'umetric_generate_child_functions_php'), 10, 2);
		add_filter('merlin_import_files', array($this, 'umetric_import_files'));
		add_action('merlin_after_all_import', array($this, 'umetric_after_import_setup'));
		add_filter('merlin_generate_child_screenshot', function () {
			return trailingslashit(get_template_directory()) . 'screenshot.png';
		});
	}

	function umetric_generate_child_functions_php($output, $slug)
	{

		$slug_no_hyphens = strtolower(preg_replace('#[^a-zA-Z]#', '', $slug));

		$output = "
		<?php
		/**
		 * Theme functions and definitions.
		 */
		add_action( 'wp_enqueue_scripts', '{$slug_no_hyphens}_enqueue_styles' ,99);

		function {$slug_no_hyphens}_enqueue_styles() {
				
			wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css'); 
			wp_enqueue_style( 'child-style',get_stylesheet_directory_uri() . '/style.css');
		}

		/**
		 * Set up My Child Theme's textdomain.
		*
		* Declare textdomain for this child theme.
		* Translations can be added to the /languages/ directory.
		*/
		function {$slug_no_hyphens}_child_theme_setup() {
			load_child_theme_textdomain( 'streamit', get_stylesheet_directory() . '/languages' );
		}
		add_action( 'after_setup_theme', '{$slug_no_hyphens}_child_theme_setup' );
	";

		// Let's remove the tabs so that it displays nicely.
		$output = trim(preg_replace('/\t+/', '', $output));

		// Filterable return.
		return $output;
	}

	public function generate_child_style_css($slug, $parent, $author, $version)
	{

		$output = "
			/**
			* Theme Name: {$parent} Child
			* Description: This is a child theme of {$parent}, generated by iQonic Design.
			* Author: {$author}
			* Template: {$slug}
			* Version: {$version}
			*/\n
		";

		// Let's remove the tabs so that it displays nicely.
		$output = trim(preg_replace('/\t+/', '', $output));

		return  $output;
	}

	public function umetric_import_files(): array
	{
		return array(
			array(
				'import_file_name' => esc_html__('All Content', 'umetric'),
				'local_import_file' => trailingslashit(get_template_directory()) . 'inc/Import/Demo/umetric-content.xml',
				'local_import_widget_file' => trailingslashit(get_template_directory()) . 'inc/Import/Demo/umetric-widget.wie',
				'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'inc/Import/Demo/umetric-export.dat',
				'local_import_redux' => array(
					array(
						'file_path' => trailingslashit(get_template_directory()) . 'inc/Import/Demo/umetric_redux.json',
						'option_name' => 'umetric_options',
					),
				),
				'import_preview_image_url' => get_template_directory_uri() . '/inc/Import/Demo/preview_import_image.png',
				'import_notice' => esc_html__('DEMO IMPORT REQUIREMENTS: Memory Limit of 128 MB and max execution time (php time limit) of 300 seconds. ', 'umetric') . '
									</br></br>' . esc_html__('Based on your INTERNET SPEED it could take 5 to 25 minutes. ', 'umetric'),
				'preview_url' => 'https://wordpress.iqonic.design/product/wp/umetric/',
			),
		);
	}

	public function umetric_after_import_setup()
	{

		//get file
		global $wp_filesystem;
		require_once(ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
		$content    =   '';
		$import_file =  trailingslashit(get_template_directory()) . 'inc/Import/Demo/elementor-site-settings.json';
		
		// Assign menus to their locations.
		$locations = get_theme_mod('nav_menu_locations'); // registered menu locations in theme
		$menus = wp_get_nav_menus(); // registered menus

		if ($menus) {
			foreach ($menus as $menu) { // assign menus to theme locations

				if ($menu->name == 'Main-menu') {
					$locations['top'] = $menu->term_id;
				}

				if ($menu->name == 'Vertical Menu') {
					$locations['vertical'] = $menu->term_id;
				}

			}
		}
		set_theme_mod('nav_menu_locations', $locations); // set menus to locations

		$front_page_id = get_page_by_title('Project Report');
		$blog_page_id = get_page_by_title('Blog');

		update_option('show_on_front', 'page');
		update_option('page_on_front', $front_page_id->ID);
		update_option('page_for_posts', $blog_page_id->ID);

		//post-types selection for edit with elementor option
		$enable_edit_with_elementor = [
			"post",
			"page",
			"testimonial",
			"client",
			"portfolio",
			"career",
			"iqonicteam",
			"iqonic_hf_layout"
		];
		update_option('elementor_cpt_support', $enable_edit_with_elementor);

		//elementor global settings
		if (file_exists($import_file)) {
		 	$content = $wp_filesystem->get_contents($import_file);
		 	if (!empty($content)) {
		 		$default_post_id = get_option('elementor_active_kit');
		 		update_post_meta($default_post_id, '_elementor_page_settings', json_decode($content, true));
		 	}
		}

		//Import Revolution Slider
		if (class_exists('RevSlider')) {
			$slider_array = array(
				//	Slider Paths
				get_template_directory() . "/inc/Import/slider/Corono-Info.zip",
				get_template_directory() . "/inc/Import/slider/Electric-new.zip",
				get_template_directory() . "/inc/Import/slider/environment.zip",
				get_template_directory() . "/inc/Import/slider/Medical-Info.zip",
				get_template_directory() . "/inc/Import/slider/Sales.zip",
				get_template_directory() . "/inc/Import/slider/slider-1.zip",
				get_template_directory() . "/inc/Import/slider/social-media.zip",
			);
 
			$slider = new RevSlider();

			foreach ($slider_array as $filepath) {
				$slider->importSliderFromPost(true, true, $filepath);
			}

			$menu_item = get_posts([
				'post_type' => 'nav_menu_item',
				'post_status' => 'publish',
				'numberposts' => -1,
			]);
			
			// Update Menu Item For Demo Import
			foreach ($menu_item as $key => $value) {
				wp_update_post(
					array(
						'ID' => $value->ID,
						'post_content' => $value->post_content,
					)
				);
			}
		}

		// remove default post
		wp_delete_post(1, true);
	}

}
