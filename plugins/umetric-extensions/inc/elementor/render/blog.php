<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$args = array(
	'post_type'         => 'post',
	'post_status'       => 'publish',
	'suppress_filters'  => 0,
	'posts_per_page' => 6
);
$align = $settings['align'];

// global $wp_query; 
$wp_query = new \WP_Query($args);
global $post;
?>
<div class="<?php echo esc_attr($align) ?>">
	<?php
	if ($settings['blog_type'] === '1') {
		$desk = $settings['desk_number'];
		$lap = $settings['lap_number'];
		$tab = $settings['tab_number'];
		$mob = $settings['mob_number'];
		$this->add_render_attribute('slider', 'data-dots', $settings['dots']);
		$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
		$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
		$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
		$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
		$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
		$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
		$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
		$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
		$this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);

	?>

		<div class="blog-carousel owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
			<?php

			if ($wp_query->have_posts()) {
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");
			?>

					<div class="item">
						<div class="iq-blog-box">
							<div class="iq-blog-image clearfix">
								<?php echo sprintf('<img src="%1$s" alt="umetric-blog"/>', esc_url($full_image[0], 'umetric')); ?>
								<?php
								if (has_post_thumbnail()) {
								?>
									<?php
									$postcat = get_the_category();
									if ($postcat) {
									?>
										<ul class="iq-blogtag">
											<?php
											foreach ($postcat as $cat) {
											?>
												<li>
													<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>"><?php echo esc_html($cat->name); ?></a>
												</li>
											<?php
											}
											?>
										</ul>
								<?php
									}
								}
								?>
							</div>
							<div class="iq-blog-detail">
								<div class="iq-blog-meta">
									<ul>
										<?php
										//post date
										$archive_year  = get_the_time('Y', $wp_query->ID);
										$archive_month = get_the_time('m', $wp_query->ID);
										$archive_day   = get_the_time('d', $wp_query->ID);
										$date = date_create($wp_query->post_date); ?>
										<li class="list-inline-item">
											<?php echo sprintf("%s", umetric_time_link()); ?>
										</li>
									</ul>
								</div>
								<div class="blog-title">
									<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo esc_attr($settings['title_tag']);  ?> class="iq-blog-title mb-2"><?php echo sprintf("%s", esc_html__(get_the_title($wp_query->ID), 'umetric')); ?></<?php echo esc_attr($settings['title_tag']);  ?>>
									</a>

								</div>
								<p class="iq-blog-desc"><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
								<div class="blog-button">
									<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>"><?php echo __('Read More', 'umetric'); ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
					</div>

			<?php
				}
			}

			wp_reset_postdata();
			?>
		</div>

		<?php } else {
		echo '<div class="row">';
		if ($settings['blog_style'] === "2") {
			$col = 'col-lg-12';
		}
		if ($settings['blog_style'] === "3") {
			$col = 'col-lg-6 col-md-6 ';
		}
		if ($settings['blog_style'] === "4") {
			$col = 'col-lg-4 col-md-6';
		}
		if ($wp_query->have_posts()) {
			while ($wp_query->have_posts()) {
				$wp_query->the_post();
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");

		?>
				<div class="<?php echo esc_attr__($col, 'umetric') ?>">
					<div class="iq-blog-box">
						<div class="iq-blog-image clearfix">
							<?php echo sprintf('<img src="%1$s" alt="umetric-blog"/>', esc_url($full_image[0], 'umetric')); ?>
							<?php
							if (has_post_thumbnail()) {
							?>
								<?php
								$postcat = get_the_category();
								if ($postcat) {
								?>
									<ul class="iq-blogtag">
										<?php
										foreach ($postcat as $cat) {
										?>
											<li>
												<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>"><?php echo esc_html($cat->name); ?></a>
											</li>
										<?php
										}
										?>
									</ul>
							<?php
								}
							}
							?>
						</div>
						<div class="iq-blog-detail">
							<div class="iq-blog-meta">
								<ul>
									<?php
									//post date
									$archive_year  = get_the_time('Y', $wp_query->ID);
									$archive_month = get_the_time('m', $wp_query->ID);
									$archive_day   = get_the_time('d', $wp_query->ID);
									$date = date_create($wp_query->post_date); ?>
									<li class="list-inline-item">
										<?php echo sprintf("%s", umetric_time_link()); ?>
									</li>
								</ul>
							</div>
							<div class="blog-title">
								<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
									<<?php echo esc_attr($settings['title_tag']);  ?> class="iq-blog-title"><?php echo sprintf("%s", esc_html__(get_the_title($wp_query->ID), 'umetric')); ?></<?php echo esc_attr($settings['title_tag']);  ?>>
								</a>
							</div>
							<p class="iq-blog-desc"><?php echo sprintf("%s", get_the_excerpt($wp_query->ID)); ?></p>
							<div class="blog-button">
								<a class="button-link" href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>"><?php echo __('Read More', 'umetric'); ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
	<?php
			}

			$numpages = $wp_query->max_num_pages;
			$pagination_args = array(
				//'base'            => get_pagenum_link(1) . '%_%',
				'format'		  => '?paged=%#%',
				'total'           => $numpages,
				'current'         => 1,
				'show_all'        => False,
				'end_size'        => 1,
				'prev_next'       => True,
				'prev_text'       => '<span aria-hidden="true">' . esc_html__('Previous page', 'umetric') . '</span>',
				'next_text'       => '<span aria-hidden="true">' . esc_html__('Next page', 'umetric') . '</span>',
				'type'            => 'list',
				'add_args'        => false,
				'add_fragment'    => ''
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
		wp_reset_postdata();
		echo '</div>';
	} ?>
</div>