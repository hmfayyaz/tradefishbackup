<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$align = '';

if ($settings['iqonic_has_box_shadow'] == 'yes') {
	$align .= ' iq-box-shadow';
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	'post_type'         => 'iqonicteam',
	'post_status'       => 'publish',
	'paged'             => $paged,
	'posts_per_page'    => $settings['posts_per_page'],
	'order'    => $settings['order'],
);

$wp_query = new \WP_Query($args);

global $post;

$style = $settings['team_style'];
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



if ( $settings['team_style'] == 'slider' ) {	 ?>
	<div class="iq-team iq-team-slider iq-team-style-6 <?php echo esc_attr($align); ?>">
		<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>

			<?php
			if ($wp_query->have_posts()) {
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");

					$designation   = get_post_meta($post->ID, 'iqonic_team_designation', true);
					$contact   = get_post_meta($post->ID, 'iqonic_team_contact', true);
					$email   = get_post_meta($post->ID, 'iqonic_team_email', true);


					$li = '';

					$facebook   = get_post_meta($post->ID, 'iqonic_team_facebook', true);
					if (!empty($facebook)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-facebook"></i></a></li>', esc_url($facebook));
					}
					$twitter   = get_post_meta($post->ID, 'iqonic_team_twitter', true);
					if (!empty($twitter)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-twitter"></i></a></li>', esc_url($twitter));
					}

					$google   = get_post_meta($post->ID, 'iqonic_team_google', true);
					if (!empty($google)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-google"></i></a></li>', esc_url($google));
					}

					$github     = get_post_meta($post->ID, 'iqonic_team_github', true);
					if (!empty($github)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-github"></i></a></li>', esc_url($github));
					}

					$insta     = get_post_meta($post->ID, 'iqonic_team_insta', true);
					if (!empty($insta)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-instagram"></i></a></li>', esc_url($insta));
					}

					$pinterest     = get_post_meta($post->ID, 'iqonic_team_pinterest', true);
					if (!empty($pinterest)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-instagram"></i></a></li>', esc_url($pinterest));
					}
					
					$behance     = get_post_meta($post->ID, 'iqonic_team_behance', true);
					if (!empty($behance)) {
						$li .= sprintf('<li><a href="%s"><i class="fa fa-instagram"></i></a></li>', esc_url($behance));
					}

					
			?>

					<div class="iq-team-blog">
						<div class="team-blog">
							<div class="iq-team-img">
								<img class="img-fluid" src="<?php echo esc_url($full_image[0]); ?>" alt="image">
							</div>

							<div class="iq-team-description">
								<div class="line"></div>

								<div class="iq-team-info">
								<a href="<?php the_permalink(); ?>">
									<h5 class="member-text">
										<?php echo esc_html(get_the_title($post->ID)); ?>
									</h5>
				                   </a>
									<p class="designation-text"><?php echo esc_html($designation); ?></p>
								</div>


								<div class="iq-team-social">
									<ul>
										<?php echo $li; ?>
									</ul>
								</div>
							</div>
						</div>
					</div>

			<?php

				}
				wp_reset_postdata();
			}
			?>

		</div>

	</div>
<?php
}
if ($settings['team_style'] == 'grid') { ?>
	<div class="iq-team iq-team-style-grid iq-team-style-6 <?php echo esc_attr($align); ?>">
		<div class="row">
			<?php
			if ($settings['team_grid_style'] == '1') {
				$col = 'col-lg-12';
			}
			if ($settings['team_grid_style'] == '2') {
				$col = 'col-lg-6';
			}
			if ($settings['team_grid_style'] == '3') {
				$col = 'col-lg-4';
			}
			if ($settings['team_grid_style'] == '4') {
				$col = 'col-lg-3';
			}

			if ($wp_query->have_posts()) {
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");

					$designation   = get_post_meta($post->ID, 'iqonic_team_designation', true);
					$contact   = get_post_meta($post->ID, 'iqonic_team_contact', true);
					$email   = get_post_meta($post->ID, 'iqonic_team_email', true);

					$li = '';

					$facebook   = get_post_meta($post->ID, 'iqonic_team_facebook', true);
					if (!empty($facebook)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-facebook"></i></a></li>', esc_url($facebook));
					}
					$twitter   = get_post_meta($post->ID, 'iqonic_team_twitter', true);
					if (!empty($twitter)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-twitter"></i></a></li>', esc_url($twitter));
					}

					$google   = get_post_meta($post->ID, 'iqonic_team_google', true);
					if (!empty($google)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-google"></i></a></li>', esc_url($google));
					}

					$github     = get_post_meta($post->ID, 'iqonic_team_github', true);
					if (!empty($github)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-github"></i></a></li>', esc_url($github));
					}

					$insta     = get_post_meta($post->ID, 'iqonic_team_insta', true);
					if (!empty($insta)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-instagram"></i></a></li>', esc_url($insta));
					}

					$pinterest     = get_post_meta($post->ID, 'iqonic_team_pinterest', true);
					if (!empty($pinterest)) {
						$li .= sprintf('<li><a href="%s"><i class="fab fa-instagram"></i></a></li>', esc_url($pinterest));
					}
					
					$behance     = get_post_meta($post->ID, 'iqonic_team_behance', true);
					if (!empty($behance)) {
						$li .= sprintf('<li><a href="%s"><i class="fa fa-instagram"></i></a></li>', esc_url($behance));
					}
					?>

					<div class="<?php echo esc_attr($col); ?>">
						<div class="iq-team-blog">
							<div class="team-blog">
								<div class="iq-team-img">
									<img class="img-fluid" src="<?php echo esc_url($full_image[0]); ?>" alt="image">
								</div>

								<div class="iq-team-description">
									<div class="line"></div>

									<div class="iq-team-info">
									<a href="<?php the_permalink(); ?>">
										<h5 class="member-text">
											<?php echo esc_html(get_the_title($post->ID)); ?>
										</h5>
									</a>
										<p class="designation-text"><?php echo esc_html($designation); ?></p>
									</div>


									<div class="iq-team-social">
										<ul>
											<?php echo $li; ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
				</div>
			          <?php
				}
				wp_reset_postdata();
			}
			?>
		</div>
	</div>
<?php } ?>

<?php
$tot = $wp_query->found_posts;


if ($settings['team_style'] == 'grid' && $settings['pagination'] == 'yes') {
	$total_pages = $wp_query->max_num_pages;

	if ($total_pages > 1) {
		$current_page = max(1, get_query_var('paged'));
		echo paginate_links(array(
			'base' => get_pagenum_link(1) . '%_%',
			'format' => '/page/%#%',
			'current' => $current_page,
			'total' => $total_pages,
			'type'            => 'list',
			'prev_text'       => wp_kses('<span aria-hidden="true">' . __('Previous page', 'iqonic') . '</span>', 'iqonic'),
			'next_text'       => wp_kses('<span aria-hidden="true">' . __('Next page', 'iqonic') . '</span>', 'iqonic'),
		));
		
	}
}

