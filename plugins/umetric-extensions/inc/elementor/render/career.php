<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

$args = array(
	'post_type'         => 'career',
	'post_status'       => 'publish',
	'orderby'           => $settings['order'],
	'suppress_filters'  => 0
);

$wp_query = new \WP_Query($args);
global $post;
?>

<div class="iq-accordion career-style">
	<?php
	$args = array('post_type' => 'career', 'orderby' => $settings['order']);
	$loop = new \WP_Query($args);
	while ($loop->have_posts()) : $loop->the_post();
	?>
		<div class="iq-accordion-block accordion-active">
			<div class="active-faq clearfix" style="">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-md-8 col-sm-12 text-md-left text-center mb-4 mb-md-0">
							<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>" class="accordion-title">
								<span><?php echo sprintf("%s", esc_html__(get_the_title($wp_query->ID), 'umetric')); ?></span>
							</a>
						</div>
						<div class="col-md-4 col-sm-12 text-center  text-md-right">
							<a class="iq-button iq-has-animation iq-btn-large iq-btn-circle has-icon btn-icon-right" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>"><?php echo esc_html($settings['button_title'], 'umetric'); ?><i aria-hidden="true" class="<?php echo esc_attr($settings['selected_icon']['value']); ?>"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	endwhile;
	wp_reset_postdata();
	?>
</div>