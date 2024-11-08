<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 

class umetric_circle_chart extends Widget_Base {

	public function get_name() {
		return __( 'Iqonic circle_chart', 'umetric' );
	}
	
	public function get_title() {
		return __( 'Iqonic Circle Chart', 'umetric' );
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
			'Section_circle_chart',
			[
				'label' => __( 'Circle Chart', 'umetric' ),
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
			'chart_percentage_title',
			[
				'label' => __( 'Chart Title', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'jQuery', 'umetric' ),
				'placeholder' => __( 'Enter Title', 'umetric' ),
				'label_block' => true,
			]
        ); 

        $repeater->add_control(
			'chart_percentage_data',
			[
				'label' => __( 'Percentage Data', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '33', 'umetric' ),
				'placeholder' => __( 'Enter data', 'umetric' ),
				'label_block' => true,
			]
        );

        $this->add_control(
			'chart',
			[
				'label' => __( 'Chart Items', 'umetric' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'chart_percentage_title' => __( 'Chart Title #1', 'umetric' ),
						'chart_percentage_data' => __( 'Data #1', 'umetric' ),                   
                       
					]
					
				],
				'title_field' => '{{{ chart_percentage_title }}}',
			]
        );

        $this->add_control(
			'chart_success',
			[
				'label' => __( 'Success Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .success-stroke' => 'stroke: {{VALUE}} !important;',
					
				],
			]
		);


		$this->add_control(
			'chart_incomplete',
			[
				'label' => __( 'Incomplete Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .circle-chart__background' => 'stroke: {{VALUE}} !important;',
					
				],
			]
		);

		$this->add_control(
			'chart_height',
			[
				'label' => __( 'Circle Height', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '150', 'umetric' ),
				'placeholder' => __( 'Enter Title', 'umetric' ),
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .circle-chart' => 'height: {{VALUE}}px !important;',
					
				],
			]
        ); 

        $this->add_control(
			'chart_width',
			[
				'label' => __( 'Circle Width', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '150', 'umetric' ),
				'placeholder' => __( 'Enter Title', 'umetric' ),
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .circle-chart' => 'width: {{VALUE}}px !important;',
					
				],
			]
        ); 
	

        
        $this->end_controls_section();
	}
	
	
	protected function render() {
		$settings = $this->get_settings();
		require  umetric_TH_ROOT . '/inc/elementor/render/circle_chart.php'; 
		if ( Plugin::$instance->editor->is_edit_mode() ) {

            ?>
		<script type="text/javascript"> 
			
            /*------------------------
            Circle Chart
            --------------------------*/

            jQuery('.circlechart').circlechart(); // Initialization

		</script>
		<?php 
        }
		
    }	    
		
}

Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\umetric_circle_chart() );
