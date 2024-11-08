<?php

function iq_recent_post_slider_widgets()
{
	register_widget('Iqonic_Recent_Post_Slider');
}
add_action('widgets_init', 'iq_recent_post_slider_widgets');

/*-------------------------------------------
		iqonic Recent Post 
--------------------------------------------*/
class Iqonic_Recent_Post_Slider extends WP_Widget
{

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'Iqonic_Recent_Post_Slider',

			// Widget name will appear in UI
			esc_html('Iqonic Post Slider', 'iqonic'),

			// Widget description
			array('description' => esc_html('Most recent Posts. ', 'iqonic'),)

		);
	}
	public function call_dependent_scripts()
	{
		//Add styles
		wp_register_style('owl-carousel', IQONIC_EXTENSION_PLUGIN_URL . 'includes/assets/css/owl.carousel.min.css');
		wp_enqueue_style('owl-carousel');

		//Register scripts. this sample depends on jquery
		wp_enqueue_script('owl-carousel', IQONIC_EXTENSION_PLUGIN_URL . 'includes/Elementor/assets/js/owl.carousel.min.js', array('jquery'), "3.4.2", true);
		wp_enqueue_script('owl-general', IQONIC_EXTENSION_PLUGIN_URL . 'includes/Elementor/assets/js/owl-general.js', array('jquery'), "1.0.0", true);
	}
	// Creating widget front-end
	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (!empty($instance['title'])) ? $instance['title'] : esc_html__('Recent Post', 'iqonic');

		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
		if (!$number) {
			$number = 5;
		}
		$title_tag = empty($instance['title_tag']) ? 'h6' : $instance['title_tag'];
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
		$show_category = isset($instance['show_category']) ? $instance['show_category'] : false;
		$show_slider = isset($instance['show_slider']) ? $instance['show_slider'] : false;
		$iq_image = isset($instance['umetric-image']) ? $instance['umetric-image'] : '';

		//script
		$this->call_dependent_scripts();
?>

		<div class="blog_widget umetric-recentpost widget umetric-post-sidebar">
			<?php
			if ($title) {
				echo ($args['before_title'] . $title . $args['after_title']);
			} ?>

            <div class="owl-carousel" data-dots="true" data-nav="false" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-autoplay="true" data-loop="true" data-margin="32">
				
					<?php
					$args = [
						'post_type' => 'post',
						'post_status' => "publish",
						'posts_per_page' => $number
					];
					$recent_posts = get_posts($args);
					if ($recent_posts) :
						foreach ($recent_posts as $post) :
					?>

							<div class="umetric-image-content-wrap">

								<!-- Post Image Start -->
								<div class="post-img">
									<?php if ($iq_image) { ?>
										<div class="post-img-blog">
											<a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
												<img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>" alt="post-img">
											</a>
										</div>
									<?php } ?>
								</div>
								<!-- Post Image End -->

								<div class="post-blog-deatil">
									<div class="blog-box">

										<?php if ($show_category) : ?>
											<!-- Category Start -->
											<div class="umetric-category">
												<ul class="list-inline">
													<?php
													$postcat = get_the_category($post->ID);
													if ($postcat) {
														foreach ($postcat as $cat) {
													?>
															<li class="blog-category">
																<a href="<?php echo get_category_link($cat->cat_ID) ?>">
																	<?php echo esc_html($cat->name); ?>
																</a>
															</li>
													<?php
														}
													}
													?>
												</ul>
											</div>
											<!-- Category End -->
										<?php endif; ?>

										<!-- Title Start -->
										<a class="new-link umetric-post-title" href="<?php echo esc_url(get_permalink($post->ID)); ?>">
											<<?php echo esc_attr($title_tag);  ?> class="umetric-heading-title">
												<?php echo get_the_title($post->ID); ?>
											</<?php echo esc_attr($title_tag); ?>>
										</a>
										<!-- Title End -->

										<!-- Date Start -->
										<?php
										if ($show_date) :
											$archive_year  = get_the_time('Y');
											$archive_month = get_the_time('m');
											$archive_day   = get_the_time('d');
										?>
											<span class="list-inline-item blog-date">
												<a class="ajax-effect-link" href="<?php echo esc_url(get_day_link($archive_year, $archive_month, $archive_day)); ?>" rel="bookmark">
													<time class="entry-date published" datetime="<?php echo get_the_date(DATE_W3C, $post->ID); ?>">
														<?php echo get_the_date('', $post->ID); ?>
													</time>
												</a>

											</span>
										<?php endif; ?>
										<!-- Date End -->

									</div>
								</div>

							</div>

					<?php
						endforeach;
					endif;
					wp_reset_postdata();
					?>
			</div>

		</div>
	<?php
	}

	// Widget Backend
	public function form($instance)
	{
		$title     = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number    = isset($instance['number']) ? absint($instance['number']) : 5;
		$title_tag = isset($instance['title_tag']) ? absint($instance['title_tag']) : 'h6';
		$show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
		$show_category = isset($instance['show_category']) ? (bool) $instance['show_category'] : false;
		$show_slider = isset($instance['show_slider']) ? (bool) $instance['show_slider'] : false;

		if (isset($instance['umetric-image'])) {
			$iq_image = $instance['umetric-image'];
			if ($iq_image == "image") {
				$ch_image = "checked";
			}
		}
	?>

		<p>
			<label for="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>"><?php esc_html_e('Title:', 'iqonic'); ?></label>
			<input class="widefat" id="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('title', 'iqonic')); ?>" type="text" value="<?php echo esc_html($title, 'iqonic'); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_html($this->get_field_id('number', 'iqonic')); ?>"><?php esc_html_e('Number of posts to show:', 'iqonic'); ?></label>
			<input class="tiny-text" id="<?php echo esc_html($this->get_field_id('number', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('number', 'iqonic')); ?>" type="number" step="1" min="1" value="<?php echo esc_html($number, 'iqonic'); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo esc_html($this->get_field_id('title_tag', 'iqonic')); ?>"><?php esc_html_e('Select Title Tag:', 'iqonic'); ?></label>
			<select id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>" class="widefat">
				<option <?php if ('h1' == $title_tag) echo 'selected="selected"'; ?> value="h1">H1</option>
				<option <?php if ('h2' == $title_tag) echo 'selected="selected"'; ?> value="h2">H2</option>
				<option <?php if ('h3' == $title_tag) echo 'selected="selected"'; ?> value="h3">H3</option>
				<option <?php if ('h4' == $title_tag) echo 'selected="selected"'; ?> value="h4">H4</option>
				<option <?php if ('h5' == $title_tag) echo 'selected="selected"'; ?> value="h5">H5</option>
				<option <?php if ('h6' == $title_tag) echo 'selected="selected"'; ?> value="h6">H6</option>
			</select>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo esc_html($this->get_field_id('show_date', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('show_date', 'iqonic')); ?>" />
			<label for="<?php echo esc_html($this->get_field_id('show_date', 'iqonic')); ?>"><?php esc_html_e('Display post Date?', 'iqonic'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($show_category); ?> id="<?php echo esc_html($this->get_field_id('show_category', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('show_category', 'iqonic')); ?>" />
			<label for="<?php echo esc_html($this->get_field_id('show_category', 'iqonic')); ?>"><?php esc_html_e('Display post Category?', 'iqonic'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($show_slider); ?> id="<?php echo esc_html($this->get_field_id('show_slider', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('show_slider', 'iqonic')); ?>" />
			<label for="<?php echo esc_html($this->get_field_id('show_slider', 'iqonic')); ?>"><?php esc_html_e('Display post Slider?', 'iqonic'); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('umetric-image', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('umetric-image[]', 'iqonic')); ?>" value="image" <?php if (isset($ch_image)) echo esc_html($ch_image, 'iqonic'); ?>>
			<label for="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>"><?php echo esc_html('Image', 'iqonic'); ?></label></br />
		</p>
<?php
	}
	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];

		$instance['title_tag'] = $new_instance['title_tag'];
		$instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
		$instance['show_category'] = isset($new_instance['show_category']) ? (bool) $new_instance['show_category'] : false;
		$instance['show_slider'] = isset($new_instance['show_slider']) ? (bool) $new_instance['show_slider'] : false;
		$instance['umetric-image'] = isset($new_instance['umetric-image']) ? (bool) $new_instance['umetric-image'] : false;
		return $instance;
	}
}
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/
