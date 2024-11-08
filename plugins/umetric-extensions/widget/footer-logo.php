<?php

function umetric_footer_logo_widgets() {
	register_widget( 'iq_footer_logo' );
}
add_action( 'widgets_init', 'umetric_footer_logo_widgets' );

/*-------------------------------------------
		umetric Contact Information widget 
--------------------------------------------*/
class iq_footer_logo extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'iq_footer_logo', 
			
			// Widget name will appear in UI
			esc_html('umetric Footer Logo', 'umetric'), 
 
			// Widget description
			array( 'description' => esc_html( 'umetric logo. ', 'umetric' ), ) 
		);
	}
 
	// Creating widget front-end
	
	public function widget( $args, $instance ) {

        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		global $wp_registered_sidebars;
		$umetric_option = get_option('umetric_options');

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '' ;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		?>

		
			<div class="footer-logo">
				<a href="<?php  echo esc_url( home_url( '/' ) ); ?>">
				<?php  
				if(isset($umetric_option['logo_footer']['url'])){ 
				    $footer_logo = $umetric_option['logo_footer']['url']; 
				    $logo_style = '';
				    if(isset($umetric_option['logo-dimensions-footer']['width']) && !empty($umetric_option['logo-dimensions-footer']['width']))
				    {
				    	$logo_width = $umetric_option['logo-dimensions-footer']['width'];	
				    }
				    if(isset($umetric_option['logo-dimensions-footer']['height']) && !empty($umetric_option['logo-dimensions-footer']['height']))
				    {
				    	$logo_height = $umetric_option['logo-dimensions-footer']['height'];	
				    	$logo_style = 'width:'.$logo_width.';height:'.$logo_height; 
				    }

				    
                    
                    
				?>
				<img class="img-fluid"  src="<?php echo esc_url($footer_logo); ?>" alt="<?php  esc_attr_e( 'umetric1', 'umetric' ); ?>" style="<?php echo esc_attr($logo_style); ?>">
				<?php } 
				else { ?>
				<img class="img-fluid" srcset="<?php echo esc_url($footer_logo); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="<?php  esc_attr_e( 'umetric2', 'umetric' ); ?>">
				<?php } ?>
				</a>
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