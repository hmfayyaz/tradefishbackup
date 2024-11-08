<?php

function iq_recent_post_widgets()
{
	register_widget('iq_subscribe');
}
add_action('widgets_init', 'iq_recent_post_widgets');

/*-------------------------------------------
		iqonic image Information widget
--------------------------------------------*/
class iq_subscribe extends WP_Widget
{

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'iq_subscribe',

			// Widget name will appear in UI
			esc_html('Iqonic Recent Post', 'iqonic'),

			// Widget description
			array('description' => esc_html('Most recent Posts. ', 'iqonic'),)
		);
	}

	// Creating widget front-end

	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (!empty($instance['title'])) ? $instance['title'] : '';

		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
		if (!$number) {
			$number = 5;
		}
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : false;

		$show_name = isset($instance['show_name']) ? $instance['show_name'] : false;


		$iq_image = isset($instance['iq-image']) ? $instance['iq-image'] : '';

?>

		<div class="iq-widget-menu widget">
			<?php if ($title) {
				echo ($args['before_title'] . $title . $args['after_title']);
			} ?>
			<div class="list-inline iq-widget-menu">
				<ul class="iq-post">
					<?php
					$args = array('post_type' => 'post', 'posts_per_page' => $number,);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post();
					?>

						<li>
							<div class="post-img">
								<?php if ($iq_image) : ?>
									<div class="post-img-holder">
										<a href="<?php echo esc_url(get_permalink($loop->ID)); ?>" style="background-image:url('<?php echo get_the_post_thumbnail_url($loop->ID); ?>')">
										</a>
									</div>
								<?php endif; ?>
								<div class="post-blog">
									<div class="blog-box">
										<ul class="list-inline">
											<?php
											if ($show_date) : ?>
												<li class="list-inline-item  mr-3"><a href="<?php echo esc_url(get_permalink($loop->ID)); ?>"><i class="fa fa-calendar mr-2" aria-hidden="true"></i><?php echo get_the_date();  ?></a></li>
											<?php endif; ?>
											<?php
											if ($show_name) : ?>
												<li class="list-inline-item  mr-3"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>"><i class="fa fa-user mr-2" aria-hidden="true"></i><?php the_author();  ?></a></li>
											<?php endif; ?>
										</ul>
										<a class="new-link" href="<?php echo esc_url(get_permalink($loop->ID)); ?>">
											<h5><?php the_title(); ?></h5>
										</a>
									</div>
								</div>
							</div>
						</li>

					<?php
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
	<?php

	}

	// Widget Backend
	public function form($instance)
	{
		$title     = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number    = isset($instance['number']) ? absint($instance['number']) : 5;
		$show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
		$show_name = isset($instance['show_name']) ? (bool) $instance['show_name'] : false;

		if (isset($instance['iq-image'])) {
			$iq_image = $instance['iq-image'];
			foreach ($iq_image as $iq_images) {

				if ($iq_images == "image") {
					$ch_image = "checked";
				}
			}
		}

	?>

		<p><label for="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>"><?php esc_html_e('Title:', 'iqonic'); ?></label>
			<input class="widefat" id="<?php echo esc_html($this->get_field_id('title', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('title', 'iqonic')); ?>" type="text" value="<?php echo esc_html($title, 'iqonic'); ?>" /></p>

		<p><label for="<?php echo esc_html($this->get_field_id('number', 'iqonic')); ?>"><?php esc_html_e('Number of posts to show:', 'iqonic'); ?></label>
			<input class="tiny-text" id="<?php echo esc_html($this->get_field_id('number', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('number', 'iqonic')); ?>" type="number" step="1" min="1" value="<?php echo esc_html($number, 'iqonic'); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo esc_html($this->get_field_id('show_date', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('show_date', 'iqonic')); ?>" />
			<label for="<?php echo esc_html($this->get_field_id('show_date', 'iqonic')); ?>"><?php esc_html_e('Display post Date?', 'iqonic'); ?></label></p>

		<p><input class="checkbox" type="checkbox" <?php checked($show_name); ?> id="<?php echo esc_html($this->get_field_id('show_name', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('show_name', 'iqonic')); ?>" />
			<label for="<?php echo esc_html($this->get_field_id('show_name', 'iqonic')); ?>"><?php esc_html_e('Display post Author Name?', 'iqonic'); ?></label></p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('iq-image', 'iqonic')); ?>" name="<?php echo esc_html($this->get_field_name('iq-image[]', 'iqonic')); ?>" value="image" <?php if (isset($ch_image)) echo esc_html($ch_image, 'iqonic'); ?>>
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
		$instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
		$instance['show_name'] = isset($new_instance['show_name']) ? (bool) $new_instance['show_name'] : false;
		$instance['iq-image'] = $new_instance['iq-image'];
		return $instance;
	}
}
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/
