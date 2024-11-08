<?php

/**
 * Umetric\Utility\Comments\Component class
 *
 * @package umetric
 */

namespace Umetric\Utility\Common;

use Umetric\Utility\Component_Interface;
use Umetric\Utility\Templating_Component_Interface;
use function add_action;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `umetric()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'common';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_filter('widget_tag_cloud_args', array($this, 'umetric_widget_tag_cloud_args'), 100);
		add_filter('wp_list_categories', array($this, 'umetric_categories_postcount_filter'), 100);
		add_filter('get_archives_link', array($this, 'umetric_style_the_archive_count'), 100);
		add_filter('upload_mimes', array($this, 'umetric_mime_types'), 100);
		add_action('wp_enqueue_scripts', array($this, 'umetric_remove_wp_block_library_css'), 100);
		add_filter('pre_get_posts', array($this, 'umetric_searchfilter'), 100);
        add_action( 'umetric_logo_dispaly', array($this,'umetric_logos_dispaly' ) );
		add_action('admin_enqueue_scripts', array($this, 'wpdocs_selectively_enqueue_admin_script'));
		add_action('admin_notices',  array($this, 'umetric_latest_version_announcement'));
		add_action('wp_ajax_umetric_dismiss_notice', array($this, 'umetric_dismiss_notice'), 10);
		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		));
	}

	public function __construct()
	{
		add_filter('the_content', array($this, 'umetric_remove_empty_p'));
		add_filter('get_the_content', array($this, 'umetric_remove_empty_p'));
		add_filter('get_the_excerpt', array($this, 'umetric_remove_empty_p'));
		add_filter('the_excerpt', array($this, 'umetric_remove_empty_p'));
		add_filter('body_class', array($this, 'umetric_add_body_classes'));
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `umetric()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array
	{
		return array(
			'umetric_pagination' 		=> array($this, 'umetric_pagination'),
			'umetric_inner_breadcrumb' 	=> array($this, 'umetric_inner_breadcrumb'),
			'umetric_get_embed_video' 	=> array($this, 'umetric_get_embed_video'),
		);
	}

	function umetric_add_body_classes($classes)
	{
		if (class_exists('ReduxFramework')) {
			$umetric_option = get_option('umetric_options');
			$id = get_queried_object_id();

			if( isset($umetric_option['umetric_site_layout_genaral']) ) {
				if($umetric_option['umetric_site_layout_genaral'] == 1){
					$classes = array_merge($classes, array('boxed_layout'));
				} else{
					$classes = array_merge($classes, array('full_width_layout'));
				}
				
			}

			if(function_exists('get_field'))
			{
				$page_id_header = get_queried_object_id();
		
				// $key_header_back = get_field('key_dark_header' , $page_id_header);
		
				// if(isset($key_header_back['name_menu_has_dark']) && $key_header_back['name_menu_has_dark'] == 'yes')
				// {
				//   // array_push($classes, 'iq-dark-mode'); 
				// }
		
				$key_header_style = get_field('key_header_variation' , $page_id_header);
			}
			if(isset($key_header_style['header_menu_variation']) && $key_header_style['header_menu_variation'] == '2')
			{
				if(isset($key_header_style['header_menu_collapsed']) && $key_header_style['header_menu_collapsed'] == 'acf_ver_collapsed')
				{
					array_push($classes, 'vertical-menu-collapsed');
				}
				else
				{
					array_push($classes, 'vertical-menu-expanded');
				}
			}elseif(isset($umetric_option['umetric_header_variation'])  && $umetric_option['umetric_header_variation'] == '2') {
				
				if(isset($umetric_option['umetric_vertical_hedader_collapsed']) && $umetric_option['umetric_vertical_hedader_collapsed'] == "collapsed") {
					array_push($classes, 'vertical-menu-collapsed');
				} else {
					array_push($classes, 'vertical-menu-expanded');
				}
			}

			// $page_header_layout = (function_exists('get_field') && !empty($id)) ? get_post_meta($id, 'header_layout_type', true) : '';
			// if ($umetric_option['header_layout'] == 'custom' || $page_header_layout == 'custom') {
			// 	$classes = array_merge($classes, array('umetric-custom-header'));
			// } else {
			// 	$classes = array_merge($classes, array('umetric-default-header'));
			// }
		} else {
			$classes = array_merge($classes, array('umetric-default-header'));
		}

		return $classes;
	}

	function umetric_get_embed_video($post_id)
	{
		$post = get_post($post_id);
		$content = do_shortcode(apply_filters('the_content', $post->post_content));
		$embeds = get_media_embedded_in_content($content);
		if (!empty($embeds)) {
			foreach ($embeds as $embed) {
				if (strpos($embed, 'video') || strpos($embed, 'youtube') || strpos($embed, 'vimeo') || strpos($embed, 'dailymotion') || strpos($embed, 'vine') || strpos($embed, 'wordPress.tv') || strpos($embed, 'embed') || strpos($embed, 'audio') || strpos($embed, 'iframe') || strpos($embed, 'object')) {
					return $embed;
				}
			}
		} else {
			return;
		}
	}

	function umetric_remove_empty_p($string)
	{
		return preg_replace('/<p>(?:\s|&nbsp;)*?<\/p>/i', '', $string);
	}

	function umetric_remove_wp_block_library_css()
	{
		wp_dequeue_style('wp-block-library-theme');
	}

	public function umetric_widget_tag_cloud_args($args)
	{
		$args['largest'] = 1;
		$args['smallest'] = 1;
		$args['unit'] = 'em';
		$args['format'] = 'list';

		return $args;
	}
	function umetric_mime_types($mimes)
	{
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	function umetric_categories_postcount_filter($variable)
	{
		$variable = str_replace('(', '<span class="archiveCount"> (', $variable);
		$variable = str_replace(')', ') </span>', $variable);
		return $variable;
	}

	function umetric_style_the_archive_count($links)
	{
		$links = str_replace('</a>&nbsp;(', '</a> <span class="archiveCount"> (', $links);
		$links = str_replace('&nbsp;)</li>', ' </li></span>', $links);
		return $links;
	}

	public function umetric_pagination($numpages = '', $pagerange = '', $paged = '')
	{
		$umetric_option = get_option('umetric_options');
		if(isset($umetric_option['display_pagination']) && $umetric_option['display_pagination'] == 'no') {
			return;
		}

		if (empty($pagerange)) {
			$pagerange = 2;
		}
		global $paged;
		if (empty($paged)) {
			$paged = 1;
		}
		if ($numpages == '') {
			global $wp_query;
			$numpages = $wp_query->max_num_pages;
			if (!$numpages) {
				$numpages = 1;
			}
		}
		/**
		 * We construct the pagination arguments to enter into our paginate_links
		 * function.
		 */
		$pagination_args = array(
			'format' => '?paged=%#%',
			'total' => $numpages,
			'current' => $paged,
			'show_all' => false,
			'end_size' => 1,
			'mid_size' => $pagerange,
			'prev_next' => true,
			'prev_text'       => '<i class="fas fa-chevron-left"></i>',
			'next_text'       => '<i class="fas fa-chevron-right"></i>',
			'type' => 'list',
			'add_args' => false,
			'add_fragment' => ''
		);

		$paginate_links = paginate_links($pagination_args);
		if ($paginate_links) {
			echo '<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="pagination justify-content-center">
								<nav aria-label="Page navigation">';
			printf(esc_html__('%s', 'umetric'), $paginate_links);
			echo '</nav>
					</div>
				</div>';
		}
	}

	public function umetric_inner_breadcrumb()
	{
		$umetric_option = get_option('umetric_options');
		$breadcrumb_style = '';
		if (!is_front_page() && !is_404()) {

			$options = '';
			if (isset($umetric_option['bg_opacity'])) {
				$options = $umetric_option['bg_opacity'];
			}
			if ($options == "1") {
				$bg_class = esc_html__('iq-bg-over black', 'umetric');
			} elseif ($options == "2") {
				$bg_class = esc_html__('iq-bg-over iq-over-dark-80', 'umetric');
			} elseif ($options == "3") {
				$bg_class = esc_html__('breadcrumb-bg breadcrumb-ui', 'umetric');
			} else {
				$bg_class = esc_html__('iq-bg-over iq-over-dark-80', 'umetric');
			}
?>
			<div class="text-left iq-breadcrumb-one <?php if (!empty($bg_class)) { echo esc_attr($bg_class); } ?>">
				<div class="container">
					<?php
					if (!empty($umetric_option['bg_image'])) {
						$breadcrumb_style = $umetric_option['bg_image'];
					}
					
					if (class_exists('ReduxFramework') && $breadcrumb_style == '1') { ?>
						<div class="row align-items-center justify-content-center text-center">
							<div class="col-sm-12">
								<nav aria-label="breadcrumb" class="umetric-breadcrumb-nav">
									<?php	
									$this->umetric_breadcrumbs_title();								
									if (isset($umetric_option['display_breadcrumbs'])) {
										$display_breadcrumb = $umetric_option['display_breadcrumbs'];
										if ($display_breadcrumb == "yes") {
									?>
											<ol class="breadcrumb main-bg">
												<?php $this->umetric_custom_breadcrumbs(); ?>
											</ol>
									<?php
										}
									}
									?>
								</nav>

							</div>
						</div>
					<?php } elseif (class_exists('ReduxFramework') && $breadcrumb_style == '2') { ?>

						<div class="row align-items-center">
							<div class="col-lg-8 col-md-8 text-left align-self-center">
								<nav aria-label="breadcrumb" class="text-left">
									<?php
                                    $this->umetric_breadcrumbs_title();
									if (isset($umetric_option['display_breadcrumbs'])) {
										$display_breadcrumb = $umetric_option['display_breadcrumbs'];
										if ($display_breadcrumb == "yes") { ?>
											<ol class="breadcrumb main-bg">
												<?php $this->umetric_custom_breadcrumbs(); ?>
											</ol> <?php
												}
											}
											 ?>
								</nav>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 text-right wow fadeInRight">
								<?php $this->umetric_breadcrumbs_feature_image(); ?>
							</div>
						</div>
					<?php } elseif (class_exists('ReduxFramework') && $breadcrumb_style == '3') { ?>

						<div class="row align-items-center">
							<div class="col-lg-4 col-md-4 col-sm-12 wow fadeInLeft">
								<?php $this->umetric_breadcrumbs_feature_image(); ?>
							</div>
							<div class="col-lg-8 col-md-8 text-right align-self-center">
								<nav aria-label="breadcrumb" class="text-right">
									<?php
									$this->umetric_breadcrumbs_title();
									if (isset($umetric_option['display_breadcrumbs'])) {
										$display_breadcrumb = $umetric_option['display_breadcrumbs'];
										if ($display_breadcrumb == "yes") { ?>
											<ol class="breadcrumb main-bg justify-content-end">
												<?php $this->umetric_custom_breadcrumbs(); ?>
											</ol>
									<?php
										}
									}
									
									?>
								</nav>
							</div>
						</div>
					<?php } elseif (class_exists('ReduxFramework') && $breadcrumb_style == '4') { ?>

						<div class="row align-items-center">
							<div class="col-sm-6 mb-3 mb-lg-0 mb-md-0">
								<?php $this->umetric_breadcrumbs_title(); ?>
							</div>
							<div class="col-sm-6 ext-lg-right text-md-right text-sm-left">
								<nav aria-label="breadcrumb" class="umetric-breadcrumb-nav">
									<?php
									if (isset($umetric_option['display_breadcrumbs'])) {
										$display_breadcrumb = $umetric_option['display_breadcrumbs'];
										if ($display_breadcrumb == "yes") {
									?>
											<ol class="breadcrumb main-bg justify-content-end">
												<?php $this->umetric_custom_breadcrumbs(); ?>
											</ol>
									<?php
										}
									} ?>
								</nav>
							</div>
						</div>
					<?php } elseif (class_exists('ReduxFramework') && $breadcrumb_style == '5') { ?>

						<div class="row align-items-center umetric-breadcrumb-three">
							<div class="col-sm-6 mb-3 mb-lg-0 mb-md-0">
								<nav aria-label="breadcrumb" class="text-left umetric-breadcrumb-nav">
									<?php
									if (isset($umetric_option['display_breadcrumbs'])) {
										$display_breadcrumb = $umetric_option['display_breadcrumbs'];
										if ($display_breadcrumb == "yes") {
									?>
											<ol class="breadcrumb main-bg justify-content-start">
												<?php $this->umetric_custom_breadcrumbs(); ?>
											</ol>
									<?php
										}
									}
									?>
								</nav>
							</div>
							<div class="col-sm-6 text-right">
								<?php $this->umetric_breadcrumbs_title(); ?>
							</div>
						</div>
					<?php } else { ?>
						<div class="row align-items-center">
							<div class="col-sm-12">
								<nav aria-label="breadcrumb" class="text-center">
									<?php $this->umetric_breadcrumbs_title(); ?>
									<ol class="breadcrumb main-bg">
										<?php $this->umetric_custom_breadcrumbs(); ?>
									</ol>
									
								</nav>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php
		}
	}

	function umetric_breadcrumbs_title()
	{

		$umetric_options = get_option('umetric_options');
		$title_tag = 'h2';
		$title = '';
		if (isset($umetric_options['breadcum_title_tag'])) {
			$title_tag = $umetric_options['breadcum_title_tag'];
		}

		if (is_archive()) {
			$title = get_the_archive_title();
		} elseif (is_search()) {
			$title = esc_html__('Search', 'umetric');
		} elseif (is_404()) {
			if (isset($umetric_options['umetric_fourzerofour_title'])) {
				$title = $umetric_options['umetric_fourzerofour_title'];
			} else {
				$title = __('Oops! That page can not be found.', 'umetric');
			}
		} elseif (is_home()) {
			$title = wp_title('', false);
		} elseif ('iqonic_hf_layout' === get_post_type()) {
			$id = (get_queried_object_id()) ? get_queried_object_id() : '';
			$title = get_the_title($id);
		} else {
			$title = get_the_title();
		}
		if (!empty(trim($title))) :
		?>
			<<?php echo esc_attr($title_tag); ?> class="title">
				<?php echo wp_kses($title, array(['span' => array()])); ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php
		endif;
	}

	function umetric_breadcrumbs_feature_image()
	{
		$umetric_options = get_option('umetric_options');
		$bnurl = '';
		$page_id = get_queried_object_id();
		if (has_post_thumbnail($page_id) && !is_single()) {
			$image_array = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'full');
			$bnurl = $image_array[0];
		} elseif (is_404()) {
			if (!empty($umetric_options['404_banner_image']['url'])) {
				$bnurl = $umetric_options['404_banner_image']['url'];
			}
		} elseif (is_home()) {
			if (!empty($umetric_options['blog_default_banner_image']['url'])) {
				$bnurl = $umetric_options['blog_default_banner_image']['url'];
			}
		} else {
			if (!empty($umetric_options['page_default_banner_image']['url'])) {
				$bnurl = $umetric_options['page_default_banner_image']['url'];
			}
		}

		if (!empty($bnurl)) {
			$img_pos = "";
			if (!empty($umetric_option['bg_image']) && !$umetric_option['bg_image'] == 1) {
				$img_pos = 'float-right';
			}
		?>
			<img src="<?php echo esc_url($bnurl); ?>" class="img-fluid <?php echo esc_attr($img_pos) ?>" alt="<?php esc_attr_e('banner', 'umetric'); ?>">
<?php
		}
	}
	function umetric_custom_breadcrumbs()
	{

		$show_on_home = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$home = '' . esc_html__('Home', 'umetric') . ''; // text for the 'Home' link
		$show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show

		global $post;
		$home_link = esc_url(home_url());

		if (is_front_page()) {

			if ($show_on_home == 1) echo '<li class="breadcrumb-item"><a href="' . $home_link . '"><i class="fa fa-home mr-2"></i>' . $home . '</a></li>';
		} else {

			echo '<li class="breadcrumb-item"><a href="' . $home_link . '"><i class="fa fa-home mr-2"></i>' . $home . '</a></li> ';

			if (is_home()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Blogs', 'umetric') . '</li>';
			} elseif (is_category()) {
				$this_cat = get_category(get_query_var('cat'), false);
				if ($this_cat->parent != 0) echo '<li class="breadcrumb-item">' . get_category_parents($this_cat->parent, TRUE, '  ') . '</li>';
				echo  '<li class="breadcrumb-item active">' . esc_html__('Archive by category : ', 'umetric') . ' "' . single_cat_title('', false) . '" </li>';
			} elseif (is_search()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Search results for : ', 'umetric') . ' "' . get_search_query() . '"</li>';
			} elseif (is_day()) {
				echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ';
				echo '<li class="breadcrumb-item"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li>  ';
				echo  '<li class="breadcrumb-item active">' . get_the_time('d') . '</li>';
			} elseif (is_month()) {
				echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ';
				echo  '<li class="breadcrumb-item active">' . get_the_time('F') . '</li>';
			} elseif (is_year()) {
				echo  '<li class="breadcrumb-item active">' . get_the_time('Y') . '</li>';
			} elseif (is_single() && !is_attachment()) {
				if (get_post_type() != 'post') {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					if (!empty($slug)) {
						echo '<li class="breadcrumb-item"><a href="' . $home_link . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
					}
					if ($show_current == 1) echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
				} else {
					$cat = get_the_category();
					if (!empty($cat)) {
						$cat = $cat[0];

						if ($show_current == 0) $cat = preg_replace("#^(.+)\s\s$#", "$1", $cat);
						echo '<li class="breadcrumb-item">' . get_category_parents($cat, TRUE, '  ') . '</li>';
						if (!empty(get_the_title())) {
							if ($show_current == 1) echo  '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
						}
					}
				}
			} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
				$post_type = get_post_type_object(get_post_type());
				if ($post_type) {
					echo  '<li class="breadcrumb-item active">' . $post_type->labels->singular_name . '</li>';
				}
			} elseif (!is_single() && is_attachment()) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID);
				$cat = $cat[0];
				echo '<li class="breadcrumb-item">' . get_category_parents($cat, TRUE, '  ') . '</li>';
				echo '<li class="breadcrumb-item"><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
				if ($show_current == 1) echo '<li class="breadcrumb-item active"> ' .  get_the_title() . '</li>';
			} elseif (is_page() && !$post->post_parent) {
				if ($show_current == 1) echo  '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
			} elseif (is_page() && $post->post_parent) {
				$trail = '';
				if ($post->post_parent) {
					$parent_id = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_post($parent_id);
						$breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
						$parent_id  = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach ($breadcrumbs as $crumb) $trail .= $crumb;
				}

				echo wp_kses($trail, ["li" => ["class" => true], "a" => ["href" => true]]);
				if ($show_current == 1) echo '<li class="breadcrumb-item active"> ' .  get_the_title() . '</li>';
			} elseif (is_tag()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Posts tagged', 'umetric') . ' "' . single_tag_title('', false) . '"</li>';
			} elseif (is_author()) {
				global $author;
				$userdata = get_userdata($author);
				echo  '<li class="breadcrumb-item active">' . esc_html__('Articles posted by : ', 'umetric') . ' ' . $userdata->display_name . '</li>';
			} elseif (is_404()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Error 404', 'umetric') . '</li>';
			}

			if (get_query_var('paged')) {
				echo '<li class="breadcrumb-item active">' . esc_html__('Page', 'umetric') . ' ' . get_query_var('paged') . '</li>';
			}
		}
	}

	function umetric_searchfilter($query)
	{
		if (!is_admin()) {
			if ($query->is_search) {
				$query->set('post_type', 'post');
			}
			return $query;
		}
	}



    /********* Start logo ***********/

	function umetric_logos_dispaly() {

		if (function_exists('get_field') && class_exists('ReduxFramework')) {

			$umetric_option= get_option('umetric_options');
			$page_id = get_queried_object_id();
			$key = get_field('header_logovariation');
			$menu_style_key = get_field('key_header_variation');
			$stick_key = get_field('header_stick_logovariation');
		
			if( $key != 'default' ) {
				$this->iq_get_acf_logo( $key );
			} else {
				if(isset($umetric_option['umetric_logo_type'])){
					$this->iq_get_redux_logo($umetric_option['umetric_logo_type']);
				}
			}
			
			$menu_var = '';
			if(!empty($menu_style_key['header_menu_variation']))
			{
				$menu_var = $menu_style_key['header_menu_variation'];
			}
			if($menu_var != '2') {
				if( $stick_key != 'default') {
					$this->iq_get_acf_stick_logo($stick_key);
				} else {
					if(isset($umetric_option['umetric_logo_sticky_type']) && $umetric_option['umetric_header_variation'] != '2'){
						$this->iq_get_redu_stickx_logo($umetric_option['umetric_logo_sticky_type']);
					}
				}
			}
		}
		
	}
	
	function umetric_ver_logo_dispaly() {
	
		$umetric_option= get_option('umetric_options');
		$page_id = get_queried_object_id();
		$key = get_field('header_logovariation');
		$stick_key = get_field('header_stick_logovariation');
	
		if( $key != 'default' ) {
			$this->iq_get_acf_ver_logo( $key );
		} else {
			if(isset($umetric_option['vertical_header_radio'])){
				$this->iq_get_redux_ver_logo($umetric_option['vertical_header_radio']);
			}
		}
		
	}
	
	// ACF Normal Logo
	function iq_get_acf_logo($logo = ''){
	
		$page_id = get_queried_object_id();
		$key = get_field('header_layout');
		$iq_logo_img = $key['header_as_logo']['url'];
		$iq_logo_text = $key['logo_as_text'];
		$iq_logo_tag = $key['logo_text_tag'];
		$iq_logo_color = $key['logo_color_text'];
	   
		if($logo == '1'){ ?>
	
			<img class="img-fluid logo" src="<?php echo esc_url($iq_logo_img); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php
	
		} elseif($logo == '2'){
			$style = '';
			if(!empty($iq_logo_color)) {
				$style = 'style=color:'.sanitize_hex_color($iq_logo_color).'';
			}
			if(!empty($iq_logo_text)) {
				echo '<'.esc_attr($iq_logo_tag).' class="logo" '.esc_attr($style).'>'.esc_html($iq_logo_text).'</'.esc_attr($iq_logo_tag).'>'; 
			}			
		}
	
	}
	// ACF Normal Logo for vertical menu
	function iq_get_acf_ver_logo($logo = ''){
	
		$page_id = get_queried_object_id();
		$key = get_field('header_layout');
		$key_text = get_field('key_ver_header_text');
	
		$iq_ver_logo_img = $key['header_ver_as_logo']['url'];
		$iq_ver_logo_text = $key_text['ver_logo_as_text'];
		$iq_ver_logo_tag = $key_text['ver_logo_text_tag'];
		$iq_ver_logo_color = $key_text['ver_logo_color_text'];
	   
		if($logo == '1'){ ?>
	
			<img class="img-fluid logo" src="<?php echo esc_url($iq_ver_logo_img); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php
	
		} elseif($logo == '2'){
			$style = '';
			if(!empty($iq_ver_logo_color)) {
				$style = 'style=color:'.sanitize_hex_color($iq_ver_logo_color).'';
			}
			if(!empty($iq_ver_logo_text)) {
				echo '<'.esc_attr($iq_ver_logo_tag).' class="logo" '.esc_attr($style).'>'.esc_html($iq_ver_logo_text).'</'.esc_attr($iq_ver_logo_tag).'>'; 
			}			
		}
	
	}
	
	// ACF Sticky Logo
	function iq_get_acf_stick_logo($logo = ''){
	
		$page_id = get_queried_object_id();
		$key = get_field('header_stick_layout');
		$iq_logo_img = $key['header_stick_as_logo']['url'];
		$iq_logo_tag = $key['logo_stick_text_tag'];
		$iq_logo_text = $key['logo_stick_as_text'];
		$iq_logo_color = $key['logo_stick_color_text'];
	
		if($logo == '1') { ?>
	
			<img class="img-fluid logo-sticky" src="<?php echo esc_url($iq_logo_img); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php
	
		} elseif($logo == '2') {
	
			if(!empty($iq_logo_color)){
				$style = 'style=color:'.sanitize_hex_color($iq_logo_color).'';
			}
			if(!empty($iq_logo_text)) {
				echo '<'.esc_attr($iq_logo_tag).' class="logo-sticky" '.esc_attr($style).'>'.esc_html($iq_logo_text).'</'.esc_attr($iq_logo_tag).'>'; 
			}
			
		}
	}
	
	//Redux Nornal  Logo
	function iq_get_redux_logo($logo = ''){
	
		if($logo == '1'){
			
			$umetric_option= get_option('umetric_options');
	
			if(isset($umetric_option['umetric_logo_type']) && $umetric_option['umetric_logo_type'] == 1) {
	
			  if(isset($umetric_option['umetric_logo']['url']) && $umetric_option['umetric_logo']['url'] != '') { 
	
				$logo = $umetric_option['umetric_logo']['url']; ?>
	
				  <img class="img-fluid logo" src="<?php echo esc_url($logo); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>">  <?php
			  } else { ?>
	
				  <img class="img-fluid logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php 
	
			  }
		  }
	
		} elseif($logo == '2'){
	
			$umetric_option= get_option('umetric_options');
	
			if(isset($umetric_option['umetric_logo_type']) && $umetric_option['umetric_logo_type'] == 2) {
	
				if (isset($umetric_option['umetric_header_logo_text']) && $umetric_option['umetric_header_logo_text'] != '')  {
	
					if(isset($umetric_option['umetric_header_logo_tag'])) {
						$tag= $umetric_option['umetric_header_logo_tag'];
					}
	
					if(isset($umetric_option['header_logo_color'])) {
	
						$style = "color:".sanitize_hex_color($umetric_option['header_logo_color'])."";
	
					} else {
						$style = '';
					}
	
					echo '<'.esc_attr($tag).' style='.esc_attr($style).' class="logo">'.esc_html($umetric_option['umetric_header_logo_text']).'</'.esc_attr($tag).'>'; 
				}
			}
	
		}
	
	}
	
	//Redux Normal  Logo for vertical menu
	function iq_get_redux_ver_logo($logo = ''){
	
		if($logo == '1'){
			
			$umetric_option= get_option('umetric_options');
	
			if(isset($umetric_option['vertical_header_radio']) && $umetric_option['vertical_header_radio'] == 1) {
	
			  if(isset($umetric_option['umetric_vertical_logo']['url']) && $umetric_option['umetric_vertical_logo']['url'] != '') { 
	
				$logo = $umetric_option['umetric_vertical_logo']['url']; ?>
	
				  <img class="img-fluid logo" src="<?php echo esc_url($logo); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>">  <?php
			  } else { ?>
	
				  <img class="img-fluid logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php 
	
			  }
		  }
	
		} elseif($logo == '2'){
	
			$umetric_option= get_option('umetric_options');
	
			if(isset($umetric_option['vertical_header_radio']) && $umetric_option['vertical_header_radio'] == 2) {
	
				if (isset($umetric_option['vertical_header_logo_text']) && $umetric_option['vertical_header_logo_text'] != '')  {
	
					if(isset($umetric_option['umetric_ver_header_logo_tag'])) {
						$tag= $umetric_option['umetric_ver_header_logo_tag'];
					}
	
					if(isset($umetric_option['ver_header_logo_color'])) {
	
						$style = "color:".sanitize_hex_color($umetric_option['ver_header_logo_color'])."";
	
					} else {
						$style = '';
					}
	
					echo '<'.esc_attr($tag).' style='.esc_attr($style).' class="logo">'.esc_html($umetric_option['vertical_header_logo_text']).'</'.esc_attr($tag).'>'; 
				}
			}
	
		}
	
	}
	
	//Redux Sticky Logo
	function iq_get_redu_stickx_logo($logo = ''){
	
		if($logo == '1'){
			
			$umetric_option= get_option('umetric_options');
	
			if(isset($umetric_option['umetric_logo_sticky_type']) && $umetric_option['umetric_logo_sticky_type'] == 1) {
	
			    if (class_exists('ReduxFramework')){
			  
					if(isset($umetric_option['umetric_header_logo_sticky']['url']) && $umetric_option['umetric_header_logo_sticky']['url'] != '') { 
	
				        $logo = $umetric_option['umetric_header_logo_sticky']['url']; ?>
				        <img class="img-fluid logo-sticky" src="<?php echo esc_url($logo); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>">  <?php
					}
				
			    } 
		  }
	
		} elseif($logo == '2'){
	
			$umetric_option= get_option('umetric_options');
	
			if(isset($umetric_option['umetric_logo_sticky_type']) && $umetric_option['umetric_logo_sticky_type'] == 2) {
	
				if (isset($umetric_option['umetric_header_logo_sticky_text']) && $umetric_option['umetric_header_logo_sticky_text'] != '')  {
	
					if(isset($umetric_option['umetric_header_logo_sticky_tag'])) {
						$tag= $umetric_option['umetric_header_logo_sticky_tag'];
					}
	
					if(isset($umetric_option['header_logo_sticky_color'])) {
	
						$style = "color:".sanitize_hex_color($umetric_option['header_logo_sticky_color'])."";
	
					} else {
						$style = '';
					}
	
					echo '<'.esc_attr($tag).' style='.esc_attr($style).' class="logo-sticky">'.esc_html($umetric_option['umetric_header_logo_sticky_text']).'</'.esc_attr($tag).'>'; 
				}
			}
	
		}
	
	}
	/********* End logo ***********/
	public function wpdocs_selectively_enqueue_admin_script()
	{
		wp_enqueue_script('admin-custom', get_template_directory_uri() . '/assets/js/src/admin-custom.js', array());
		wp_enqueue_style('admin-custom', get_template_directory_uri() . '/assets/css/src/admin-custom.css');
	}
	public function umetric_latest_version_announcement()
	{
		global $current_user;
		$user_id = $current_user->ID;
		if (!get_user_meta($user_id, 'umetric_notification_2_0_0')) { ?>
				<div class="notice notice-warning umetric-notice  is-dismissible" id="umetric_notification_2_0_0">
					<div class="umetric-notice-main-box d-flex">
						<div class="umetric-notice-logo-push">
							<span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/redux/options.png"> </span>
						</div>
						<div class="umetric-notice-message">
							<h3><?php esc_html_e('Umetric for v2.0 Important Information!', 'umetric'); ?></h3>
							<div class="umetric-notice-message-inner">
								<p><?php esc_html_e('Umetric brings your site to life with header video and immersive featured images. With a focus on business sites, it features multiple sections on the front page as well as widgets, navigation and social menus, a logo, and more.', 'umetric'); ?></p>
								<div class="umetric-notice-action">
									<a target="_blank" href="<?php echo esc_url(home_url()); ?>" class="button button-primary"><?php esc_html_e('Visit Site', 'umetric'); ?></a>
									&nbsp&nbsp&nbsp<a target="_blank" href="https://assets.iqonic.design/documentation/wordpress/umetric-doc/index.html#rollback-old-version/" class="button button-primary"><?php esc_html_e('Rollback to Old Version', 'umetric'); ?></a>
									&nbsp&nbsp&nbsp<a target="_blank" href="https://iqonic.desky.support/" class="button button-primary"><?php esc_html_e('Support Ticket', 'umetric'); ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="umetric-notice-cta">
						<button class="umetric-notice-dismiss umetric-dismiss-welcome notice-dismiss" data-msg="umetric_notification_2_0_0"><span class="screen-reader-text"><?php esc_html_e('Dismiss', 'umetric'); ?></span></button>
					</div>
				</div>
	<?php
		}
	}
	public 	function umetric_dismiss_notice()
	{
		global $current_user;
		$user_id = $current_user->ID;
		if (!empty($_POST['action']) && $_POST['action'] == 'umetric_dismiss_notice') {

			add_user_meta($user_id, 'umetric_notification_2_0_0', 'true', true);
			wp_send_json_success();
		}
	}
}
