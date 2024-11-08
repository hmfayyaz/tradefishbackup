<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package umetric
 */

namespace Umetric\Utility;

$post_section = umetric()->post_style();
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}

umetric()->print_styles('umetric-comments');

?>
<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if (have_comments()) {
	?>
		<h3 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			echo esc_html($comments_number);
			if ($comments_number == 1) {
				esc_html_e(' Comment', 'umetric');
			} else {
				esc_html_e(' Comments', 'umetric');
			}
			?>
		</h3>
		<?php the_comments_navigation(); ?>

		<?php umetric()->the_comments(); ?>

		<?php
		if (!comments_open()) {
		?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'umetric'); ?></p>
	<?php
		}
	}
	$comment_btn = umetric()->umetric_get_comment_btn();
	$args = array(
		'label_submit' => esc_html__('Post Comment', 'umetric'),
		'comment_notes_before' => esc_html__('Your email address will not be published. Required fields are marked *', 'umetric') . '',
		'comment_field' => '<div class="comment-form-comment">
								<textarea id="comment" name="comment" placeholder="' . esc_attr__('Comment*', 'umetric') . '" required="required"></textarea>
							</div>',
		'format'            => 'xhtml',
		'fields' => array(
			'author' => '<div class="row">
							<div class="col-lg-4">
								<div class="comment-form-author">
									<input id="author" name="author" aria-required="true" required="required" placeholder="' . esc_attr__('Name*', 'umetric') . '" />
								</div>
							</div>',
			'email' => '<div class="col-lg-4">
							<div class="comment-form-email">
								<input id="email" name="email" required="required" placeholder="' . esc_attr__('Email*', 'umetric') . '" />
							</div>
						</div>',
			'url' => 	'<div class="col-lg-4">
							<div class="comment-form-url">
								<input id="url" name="url"  placeholder="' . esc_attr__('Website', 'umetric') . '" />
							</div>
						</div>
					</div>',
			'cookies' => 	'<div class="umetric-check">
								<label>
									<input type="checkbox" required="required" /> <span class="checkmark"></span><span>' . esc_html__("Save my name, email, and website in this browser for the next time I comment.", "umetric") . '</span>
								</label>
							</div>',
		),
		'submit_button'	=> $comment_btn,
	);
	comment_form($args);
	?>
</div><!-- #comments -->