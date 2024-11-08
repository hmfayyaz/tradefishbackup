<?php

/**
 * Template part for displaying a post's header
 *
 * @package umetric
 */

namespace Umetric\Utility;

$umetric_options = get_option('umetric_options');
$post_type_obj = get_post_type_object(get_post_type());

$author_string = '';

// Show author only if the post type supports it.
if (post_type_supports($post_type_obj->name, 'author')) {
	$author_string = sprintf(
		'<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
		esc_url(get_author_posts_url(get_the_author_meta('ID'))),
		esc_html(get_the_author())
	);
}

?>
<div class="umetric-blog-detail">
	<?php
	if (!is_single()) {
		get_template_part('template-parts/content/entry_title', get_post_type());
	}

	if (!empty($author_string)) { ?>
		<div class="posted-by">
			<?php
			/* translators: %s: post author */
			$author_byline = _x('By %s', 'post author', 'umetric');
			if (!empty($time_string)) {
				/* translators: %s: post author */
				$author_byline = _x('%s', 'post author', 'umetric');
			}
			printf(
				esc_html($author_byline),
				$author_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
			?>
		</div>
	<?php } 

	if (isset($umetric_options['display_featured_image'])) {
		$options = $umetric_options['display_featured_image'];
		if ($options == "yes") {
			get_template_part('template-parts/content/entry_thumbnail', get_post_type());
		}
	} else {
		get_template_part('template-parts/content/entry_thumbnail', get_post_type());
	}

	get_template_part('template-parts/content/entry_meta', get_post_type());
	?>
	<!-- .entry-header -->