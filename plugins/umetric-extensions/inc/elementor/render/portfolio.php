<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();
$args = array(
	'post_type'         => 'portfolio',
	'post_status'       => 'publish',
	'posts_per_page'    => $settings['number_post'],
	'order'             => $settings['order'],
);
$wp_query = new \WP_Query($args);
global $post;
$style = $settings['portfolio_type'];
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

<?php
if ($settings['portfolio_type'] === '1') {
?>
	<div class="iq-masonry-block ">
		<div class="owl-carousel owl-loaded owl-drag" <?php echo $this->get_render_attribute_string('slider'); ?>>
			<?php
			$args = array('post_type' => 'portfolio', 'posts_per_page' => $settings['number_post'], 'order' => $settings['order']);
			$loop = new \WP_Query($args);
			while ($loop->have_posts()) : $loop->the_post();
				$wp_query->the_post();
				$term_list = wp_get_post_terms(get_the_ID(), 'portfolio-categories');
				$slugs = array();
				foreach ($term_list as $term)
				$slugs[] = $term->slug;
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");
			?>
				<div class="iq-masonry-item <?php echo implode(' ', $slugs); ?>">
					<div class="iq-portfolio">
						<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>" class="iq-portfolio-img">
							<?php echo sprintf('<img src="%1$s" alt="umetric-portfolio"/>', esc_url($full_image[0])); ?>
							<div class="portfolio-link">
								<div class="icon">
									<i class="fa fa-link" aria-hidden="true"></i>
								</div>
							</div>
						</a>

						<div class="iq-portfolio-content">
							<div class="details-box clearfix">
								<div class="consult-details">
									<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
										<<?php echo sprintf('%1$s', esc_html($settings['title_size'], 'umetric')); ?> class="link-color">
											<?php echo sprintf("%s", esc_html__(get_the_title($wp_query->ID), 'umetric')); ?>
										</<?php echo sprintf('%1$s', esc_html($settings['title_size'], 'umetric')); ?>>
										<p class="mb-0 iq-portfolio-desc"><?php echo $term->name; ?></p>
									</a>
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
	</div>
<?php
}

if ($settings['portfolio_type'] === '2') {
?>
	<div class="iq-masonry-block ">
		<?php if ($settings['dis_tabs'] == 'yes') {
		} else {
		?>
			<div class="isotope-filters isotope-tooltip">
				<?php $terms = get_terms(array('taxonomy' => 'portfolio-categories',)); ?>
				<button data-filter="" class="active">All<i aria-hidden="true" class="ion ion-record ml-3"></i><span class="post_no"><?php $wp_query->post_count; ?></span></button>
				<?php foreach ($terms as $term) { ?>
					<button data-filter=".<?php echo $term->slug; ?>"><?php echo $term->name; ?><i aria-hidden="true" class="ion ion-record ml-3"></i><span class="post_no"><?php $term->count; ?></span></button>
				<?php } ?>
			</div>
		<?php
		}
		?>
		<?php if ($settings['space'] == 'yes') { ?>
			<div class=" iq-masonry iq-columns-<?php echo $settings['portfolio_style']; ?> no-padding">
			<?php } else { ?>
				<div class=" iq-masonry iq-columns-<?php echo $settings['portfolio_style']; ?>">
				<?php
			}
				?>
				<?php
				$args = array('post_type' => 'portfolio', 'posts_per_page' => $settings['number_post'], 'order' => $settings['order']);

				$loop = new \WP_Query($args);

				while ($loop->have_posts()) : $loop->the_post();
					$wp_query->the_post();
					$term_list = wp_get_post_terms(get_the_ID(), 'portfolio-categories');

					$slugs = array();
					foreach ($term_list as $term)
						$slugs[] = $term->slug;
					$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");
				?>
					<div class="iq-masonry-item <?php echo implode(' ', $slugs); ?>">
						<div class="iq-portfolio">

							<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>" class="iq-portfolio-img">
								<?php echo sprintf('<img src="%1$s" alt="umetric-portfolio"/>', esc_url($full_image[0], 'umetric')); ?>
								<div class="portfolio-link">
									<div class="icon">
										<i class="fa fa-link" aria-hidden="true"></i>
									</div>
								</div>
							</a>

							<div class="iq-portfolio-content">
								<div class="details-box clearfix">
									<div class="consult-details">
										<a href="<?php echo sprintf("%s", esc_url(get_permalink($wp_query->ID))); ?>">
											<<?php echo sprintf('%1$s', esc_html($settings['title_size'], 'umetric')); ?> class="link-color">
												<?php echo sprintf("%s", esc_html__(get_the_title($wp_query->ID), 'umetric')); ?>
											</<?php echo sprintf('%1$s', esc_html($settings['title_size'], 'umetric')); ?>>
											<p class="mb-0 iq-portfolio-desc"><?php echo $term->name; ?></p>
										</a>
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
			</div>
		<?php
	}
		?>