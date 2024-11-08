<?php

function umetric_subscribe_widgets() {
	register_widget( 'iq_contact_info' );
}
add_action( 'widgets_init', 'umetric_subscribe_widgets' );

/*-------------------------------------------
		umetric Contact Information widget 
--------------------------------------------*/
class iq_contact_info extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'iq_contact_info', 
			
			// Widget name will appear in UI
			esc_html('umetric Subscribe', 'umetric'), 
 
			// Widget description
			array( 'description' => esc_html( 'umetric subscribe. ', 'umetric' ), ) 
		);
	}
 
	// Creating widget front-end
	
	public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html( '', 'umetric' );
		
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : false;
		
		
		
		//$args['after_widget'];

		/* here add extra display item  */ 
		$iq_contact = isset($instance[ 'iq-contact' ]) ? $instance['iq-contact'] : '';
				
		?>
		<div class="widget">
		<?php
		if ( $title ) {
			echo ($args['before_title'] . $title . $args['after_title']);
		}

		$umetric_option = get_option('umetric_options');

		if(isset($umetric_option['umetric_subscribe'])){ 
			$umetric_subscribe = $umetric_option['umetric_subscribe']; 
		}
		
			echo do_shortcode($umetric_subscribe);
		?>
		</div>
		<?php
				
	}
         
	// Widget Backend 
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';		
		?>
		
		<p><label for="<?php echo esc_html($this->get_field_id( 'title','umetric' )); ?>"><?php esc_html_e( 'Title:','umetric' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','umetric' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','umetric')); ?>" type="text" value="<?php echo esc_html($title,'umetric'); ?>" /></p>
		
		<?php 
							
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
        return $instance;
	}
} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/	