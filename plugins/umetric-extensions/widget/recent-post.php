<?php

function umetric_recent_post_widgets() {
	register_widget( 'iq_subscribe' );
}
add_action( 'widgets_init', 'umetric_recent_post_widgets' );

/*-------------------------------------------
		iqonic Contact Information widget
--------------------------------------------*/
class iq_subscribe extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'iq_subscribe',

			// Widget name will appear in UI
			esc_html('umetric Recent Post', 'umetric'),

			// Widget description
			array( 'description' => esc_html( 'umetric most recent Posts. ', 'umetric' ), )
		);
	}

	// Creating widget front-end

	public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : false;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;


		//$args['after_widget'];

		/* here add extra display item  */


		$iq_contact = isset($instance[ 'iq-contact' ]) ? $instance['iq-contact'] : '';

		?>

		<div class="iq-widget-menu widget">
			<?php if ( $title ) {
				echo ($args['before_title'] . $title . $args['after_title']);
			} ?>
              <div class="list-inline iq-widget-menu">
				<ul class="iq-post">
		<?php
		$args = array( 'post_type' => 'post', 'posts_per_page' => $number, );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
		?>

		<li>
		<?php
		if($iq_contact){
		foreach($iq_contact as $iq_contacts){
		?>
			<div class="post-img">
				<?php
				if($iq_contacts == "image"){
				?>
					<?php the_post_thumbnail ('thumbnail'); ?>
				<?php
				}
				?>
				<div class="post-blog">
					<div class="blog-box">
						<a class="new-link" href="<?php echo esc_url(get_permalink($loop->ID)); ?>"><h5><?php the_title(); ?></h5></a>
						<ul class="list-inline">
							<?php
							if ( $show_date ) : ?>
							<li class="list-inline-item  mr-3"><a class="date-widget" href="<?php echo esc_url(get_permalink($loop->ID)); ?>"><i class="fa fa-calendar mr-2" aria-hidden="true"></i><?php echo get_the_date();  ?></a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>

		<?php
		}
		}
		?>

		</li>

		<?php
		endwhile;
		?>
				</ul>
			</div>
		</div>
		<?php

	}

	// Widget Backend
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;

		if ( isset( $instance[ 'iq-contact' ] ) ) {
			$iq_contact = $instance[ 'iq-contact' ];
			foreach($iq_contact as $iq_contacts){

				if($iq_contacts == "image"){ $ch_image = "checked"; }
			}
		}

		?>

		<p><label for="<?php echo esc_html($this->get_field_id( 'title','umetric' )); ?>"><?php esc_html_e( 'Title:','umetric' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','umetric' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','umetric')); ?>" type="text" value="<?php echo esc_html($title,'umetric'); ?>" /></p>

		<p><label for="<?php echo esc_html($this->get_field_id( 'number','umetric' )); ?>"><?php esc_html_e( 'Number of posts to show:','umetric' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_html($this->get_field_id( 'number','umetric' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number','umetric' )); ?>" type="number" step="1" min="1" value="<?php echo esc_html($number,'umetric'); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_html($this->get_field_id( 'show_date','umetric' )); ?>" name="<?php echo esc_html($this->get_field_name( 'show_date','umetric' )); ?>" />
		<label for="<?php echo esc_html($this->get_field_id( 'show_date','umetric' )); ?>"><?php esc_html_e( 'Display post Date?','umetric' ); ?></label></p>

        <p>
 		<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'iq-contact','umetric')); ?>" name="<?php echo esc_html($this->get_field_name( 'iq-contact[]','umetric' )); ?>" value="image" <?php if(isset($ch_image)) echo esc_html($ch_image,'umetric'); ?>>
        <label for="<?php echo esc_html($this->get_field_id( 'title','umetric' )); ?>"><?php echo esc_html('Image', 'umetric'); ?></label></br />
        </p>
		<?php

	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['iq-contact'] = $new_instance['iq-contact'];
        return $instance;
	}
}
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/