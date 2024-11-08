<?php

/**
 * Umetric\Utility\Actions\Component class
 *
 * @package umetric
 */

namespace Umetric\Utility\Actions;

use Umetric\Utility\Component_Interface;
use Umetric\Utility\Templating_Component_Interface;

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
		return 'actions';
	}
	public function initialize()
	{
		add_action('manage_posts_extra_tablenav', array($this, 'add_layout_navigation'));
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
			'umetric_get_blog_readmore_link' => array($this, 'umetric_get_blog_readmore_link'),
			'umetric_get_blog_readmore' => array($this, 'umetric_get_blog_readmore'),
			'umetric_get_comment_btn' => array($this, 'umetric_get_comment_btn'),
		);
	}

	//** Blog Read More Button Link **//
	public function umetric_get_blog_readmore_link($link, $label = "Read More")
	{
			echo '<a class="iq-button-animated linked-btn" href="' . esc_url($link) . '">
                            <span class="iq-button-inner">
                                <span class="text">' . esc_html($label) . '</span>
                                <span class="iq-btn-line">
                                    <span class="line line-1"></span>
                                    <span class="line line-2"></span>
                                    <span class="line line-3"></span>
                               </span>
                            </span>
                        </a>';
	}

	//** Blog Read More Button **//
	public function umetric_get_blog_readmore($link, $label)
	{
		echo '<div class="blog-button"><a class="iq-button-animated " href="' . esc_url($link) . '">
		<span class="iq-button-inner">
			<span class="text">' . esc_html($label) . '</span>
			<span class="iq-btn-line">
				<span class="line line-1"></span>
				<span class="line line-2"></span>
				<span class="line line-3"></span>
		   </span>
		</span>
	</a></div>';
	}

	//layout navigation
	function add_layout_navigation($where)
	{
		global $post_type_object;
		global $post;
		if ($post_type_object->name === 'iqonic_hf_layout' && $where == "top" && $post) {
?>
			<div class="alignleft action">
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_umetric_options&tab=6")); ?> " class="button">
					<?php echo esc_html__("Setup header layout", "umetric"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_umetric_options&tab=17")); ?> " class="button">
					<?php echo esc_html__("Setup footer layout", "umetric"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url('nav-menus.php')); ?>'" class="button">
					<?php echo esc_html__("Setup menu layout", "umetric"); ?>
				</a>
				<a target="_blank" href="<?php echo esc_url(admin_url("admin.php?page=_umetric_options&tab=15")); ?> " class="button">
					<?php echo esc_html__("Setup 404 page layout", "umetric"); ?>
				</a>
			</div>
<?php
		}
	}
	//** Comment Submit Button **//
	public function umetric_get_comment_btn()
	{
		return '<button name="submit" type="submit" id="submit" class="submit iq-button-animated" value="' . __('Post Comment' . 'umetric') . '" >
		<span class="iq-button-inner">
		        <span class="text">' . esc_html__('Post Comment', 'umetric') . '</span>
				<span class="iq-btn-line">
					<span class="line line-1"></span>
					<span class="line line-2"></span>
					<span class="line line-3"></span>
		   		</span>
		</span>
				</button>';
	}
}
