<?php

function umetric_social_media_widgets()
{
	register_widget('iq_socail_media');
}
add_action('widgets_init', 'umetric_social_media_widgets');

/*-------------------------------------------
		umetric Contact Information widget 
--------------------------------------------*/
class iq_socail_media extends WP_Widget
{

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'iq_socail_media',

			// Widget name will appear in UI
			esc_html('umetric Social Media', 'umetric'),

			// Widget description
			array('description' => esc_html('umetric social media. ', 'umetric'),)
		);
	}

	// Creating widget front-end

	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$title = (!empty($instance['title'])) ? $instance['title'] : false;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);


		//$args['after_widget'];

		/* here add extra display item  */


		$iq_contact = isset($instance['iq-contact']) ? $instance['iq-contact'] : '';


		$umetric_option = get_option('umetric_options');
		if (isset($umetric_option['umetric_display_social_media'])) {
			if ($umetric_option['umetric_display_social_media'] == 'yes') {
				$top_social = $umetric_option['social-media-iq'];


?>
				<span class="text-white d-inline"><?php echo esc_html($title); ?></span>
				<ul class="info-share d-inline">
					<?php
					$i = 1;
					foreach ($top_social as $key => $value) {
						if ($i < 9) {
							if ($value) {
								echo '<li><a href="' . $value . '"><i class="fa fa-' . $key . '"></i></a></li>';
							}
							$i++;
						}
					}
					?>
				</ul>

		<?php
			}
		}
	}

	// Widget Backend 
	public function form($instance)
	{
		$title     = isset($instance['title']) ? esc_attr($instance['title']) : '';

		?>

		<p><label for="<?php echo esc_html($this->get_field_id('title', 'umetric')); ?>"><?php esc_html_e('Title:', 'umetric'); ?></label>
			<input class="widefat" id="<?php echo esc_html($this->get_field_id('title', 'umetric')); ?>" name="<?php echo esc_html($this->get_field_name('title', 'umetric')); ?>" type="text" value="<?php echo esc_html($title, 'umetric'); ?>" />
		</p>

<?php

	}

	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = sanitize_text_field($new_instance['title']);
		return $instance;
	}
} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/
