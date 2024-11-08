<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 

class umetric_social_media extends Widget_Base {

	public function get_name() {
		return __( 'social_media', 'umetric' );
	}
	
	public function get_title() {
		return __( 'Social Media', 'umetric' );
	}

	public function get_categories() {
		return [ 'umetric' ];
	}

	

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image';
	}

	

	protected function register_controls() {

		$this->start_controls_section(
			'Section_social_media',
			[
				'label' => __( 'Social Media', 'umetric' ),
			]
		);

        
	$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
                'default' => __( 'Share', 'umetric' ),
			]
		);

        
        $this->end_controls_section();
	}
	
	
	protected function render() {
		$settings = $this->get_settings();
		require  umetric_TH_ROOT . '/inc/elementor/render/social_media.php';
    	}	    
		
}

Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\umetric_social_media() );
