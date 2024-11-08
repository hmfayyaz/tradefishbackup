<?php

namespace Iqonic\Elementor\Elements\TitleSlider;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'Iq_Slider';
    }

    public function get_title()
    {
        return __('Section Title Slider', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-site-title';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section_slider',
			[
				'label' => __( 'Iqonic Slider', 'iqonic' ),
			]
		);
		$this->add_control(
			'iq_carousel',
			[
				'label' => __( 'Add Images', 'iqonic' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
        $this->add_control(
			'desk_number',
			[
				'label' => __( 'Desktop view', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				
				'label_block' => true,
				'default' => '3',
			]
		);

		$this->add_control(
			'lap_number',
			[
				'label' => __( 'Laptop view', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				
				'label_block' => true,
				'default' => '3',
			]
		);

		$this->add_control(
			'tab_number',
			[
				'label' => __( 'Tablet view', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				
				'label_block' => true,
				'default' => '2',
			]
		);

		$this->add_control(
			'mob_number',
			[
				'label' => __( 'Mobile view', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				
				'label_block' => true,
				'default' => '1',
			]
		);	

		$this->add_control(
			'autoplay',
			[
				'label'      => __( 'Autoplay', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'iqonic' ),
					'false'      => __( 'False', 'iqonic' ),
					
				],
				
			]
		);

		$this->add_control(
			'loop',
			[
				'label'      => __( 'Loop', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'iqonic' ),
					'false'      => __( 'False', 'iqonic' ),
					
				],
				
			]
		);

		$this->add_control(
			'dots',
			[
				'label'      => __( 'Pagination', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'iqonic' ),
					'false'      => __( 'False', 'iqonic' ),
					
				],
				
			]
		);

		$this->add_control(
			'nav-arrow',
			[
				'label'      => __( 'Arrow', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'iqonic' ),
					'false'      => __( 'False', 'iqonic' ),
					
				],
				
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
								
				
				'default' => [					
					'size' => 30
				],
				
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Image Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-slider .iq-slider-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iqonic_has_box_shadow',
			[
				'label' => __( 'Box Shadow?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'iqonic' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'text-left',
				'options' => [
					'text-left' => [
						'title' => __( 'Left', 'iqonic' ),
						'icon' => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => __( 'Center', 'iqonic' ),
						'icon' => 'eicon-text-align-center',
					],
					'text-right' => [
						'title' => __( 'Right', 'iqonic' ),
						'icon' => 'eicon-text-align-right',
					]
					
				]
			]
		);

        $this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/TitleSlider/render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                   callOwlCarousel();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
