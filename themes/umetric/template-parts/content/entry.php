<?php

/**
 * Template part for displaying a post
 *
 * @package umetric
 */

namespace Umetric\Utility;

$umetric_options = get_option('umetric_options');
$umetric_layout = '';
if (isset($umetric_options['blog_setting'])) {
	$umetric_layout = $umetric_options['blog_setting'];
}
if ($umetric_layout == '2' || $umetric_layout == '3') {
?>
	<div class="<?php echo esc_attr($args); ?>">
	<?php } ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
		<div class="umetric-blog-box">
			<?php
			get_template_part('template-parts/content/entry_header', get_post_type());
			if (is_single()) {
				get_template_part('template-parts/content/entry_content', get_post_type());
			} else {
				get_template_part('template-parts/content/entry_summary', get_post_type());
			}
			wp_link_pages(array(
				'before'      => '<div class="page-links">' . esc_html__('Pages:', 'umetric'),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			));
			get_template_part('template-parts/content/entry_footer', get_post_type());
			?>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
	if (is_singular(get_post_type())) {
		if (class_exists('ReduxFramework')) {
			$umetric_option = get_option('umetric_options');
			if ($umetric_option['display_comment'] == 'yes') {
				// Show comments only when the post type supports it and when comments are open or at least one comment exists.
				if (post_type_supports(get_post_type(), 'comments') && (comments_open() || get_comments_number())) {
					comments_template();
				}
			}
		} else {
			// Show comments only when the post type supports it and when comments are open or at least one comment exists.
			if (post_type_supports(get_post_type(), 'comments') && (comments_open() || get_comments_number())) {
				comments_template();
			}
		}
	}
	if ($umetric_layout == '2' || $umetric_layout == '3') { ?>
	</div>
<?php
	}
