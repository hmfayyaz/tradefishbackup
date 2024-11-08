<?php

namespace Iqonic\Elementor\Elements\ProcessStep;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_process_steps';
    }

    public function get_title()
    {
        return __('Iqonic Process Steps', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-number-field';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section',
			[
				'label' => __( 'Process Steps', 'iqonic' ),
			]
		);
		
		
        $this->add_control(
			'step_number',
			[
				'label' => __( 'Step Number', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( '0', 'iqonic' ),
			]
		);
        $this->add_control(
			'section_title',
			[
				'label' => __( 'Title', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( 'Process Title', 'iqonic' ),
				
			]
		);

		

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'iqonic' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter Description', 'iqonic' ),
				'default' => __( 'Process Description', 'iqonic' ),
			]
		);	
		$this->add_control(
			'media_style',
			[
				'label'      => __( 'Select Style', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'none',
				'options'    => [
					
					'icon'          => __( 'Icon', 'iqonic' ),
					'image'          => __( 'Image', 'iqonic' ),
					'none'          => __( 'none', 'iqonic' ),
					
				],
			]
		);

		 $this->add_control(
			'is_before_img',
			[
				'label'      => __( 'Use Before Image', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'no',
				'options'    => [
					
					'yes'          => __( 'Yes', 'iqonic' ),
					'no'          => __( 'No', 'iqonic' ),
					
				],
			]
		);

		$this->add_control(
			'arrow_img',
			[
				'label' => __( 'Before Image', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => ['is_before_img' => 'yes']
			]
		);

		$this->add_control(
			'image_icon',
			[
				'label' => __( 'Choose Image', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'media_style' => 'image',
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		

		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Step Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				
                'default' => [
					'value' => 'fas fa-star'
					
				],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'media_style' => 'icon',
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
        $this->add_control(
			'use_button',
			[
				'label' => __( 'Use Button', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

        $this->end_controls_section();

		/*Button Start*/		
		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';
        /*Button End*/

		$this->start_controls_section(
			'section_alignment',
			[
				'label' => __( 'Content Alignment', 'iqonic' ),
			]
		);


		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'iqonic' ),
				'type' => Controls_Manager::CHOOSE,
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

         /* Process Steps start*/

         $this->start_controls_section(
			'section_MWp0z98hNkcHc6R6fj8n',
			[
				'label' => __( 'Process Steps', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


         $this->start_controls_tabs( 'Processsteps_tabs' );
		$this->start_controls_tab(
			'tabs_ebazrsyLfa2Ue8X9Oq0i',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_process_steps_background',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step-style-1 .iq-process-step,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step li,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step ,.iq-process-step-style-5 .iq-process-step  .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step  , {{WRAPPER}} .iq-process-step-style-2 .iq-process-step  .iq-step-content,{{WRAPPER}} .iq-process-step-style-7 .iq-process-step',
			]
		);

		$this->add_control(
			'iq_process_steps_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step ,.iq-process-step-style-5 .iq-process-step  .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step , {{WRAPPER}} .iq-process-step-style-2 .iq-process-step  .iq-step-content, {{WRAPPER}} .iq-process-step-style-7 .iq-process-step' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_process_steps_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step ,.iq-process-step-style-5 .iq-process-step  .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step , {{WRAPPER}} .iq-process-step-style-2 .iq-process-step  .iq-step-content, {{WRAPPER}} .iq-process-step-style-7 .iq-process-step' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_process_steps_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step ,.iq-process-step-style-5 .iq-process-step  .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-2 .iq-process-step  .iq-step-content, {{WRAPPER}} .iq-process-step-style-7 .iq-process-step' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_process_steps_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step ,.iq-process-step-style-5 .iq-process-step  .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step , {{WRAPPER}} .iq-process-step-style-2 .iq-process-step  .iq-step-content , {{WRAPPER}} .iq-process-step-style-7 .iq-process-step' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_tbx5AmaeOkc2MqZV9830',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_process_steps_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step-style-1 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step:hover,.iq-process-step-style-5 .iq-process-step:hover .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step:hover, {{WRAPPER}} .iq-process-step-style-2 .iq-process-step:hover .iq-step-content, {{WRAPPER}} .iq-process-step-style-7 .iq-process-step:hover',
			]
		);


		$this->add_control(
			'iq_process_steps_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step:hover,.iq-process-step-style-5 .iq-process-step:hover .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-2 .iq-process-step:hover .iq-step-content,  {{WRAPPER}} .iq-process-step-style-7 .iq-process-step:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_process_steps_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step:hover,.iq-process-step-style-5 .iq-process-step:hover .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step:hover, {{WRAPPER}} .iq-process-step-style-2 .iq-process-step:hover .iq-step-content,  {{WRAPPER}} .iq-process-step-style-7 .iq-process-step:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_process_steps_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step:hover,.iq-process-step-style-5 .iq-process-step:hover .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-2 .iq-process-step:hover .iq-step-content,  {{WRAPPER}} .iq-process-step-style-7 .iq-process-step:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_process_steps_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step:hover,.iq-process-step-style-5 .iq-process-step:hover .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step:hover,{{WRAPPER}} .iq-process-step-style-2 .iq-process-step:hover .iq-step-content ,  {{WRAPPER}} .iq-process-step-style-7 .iq-process-step:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_process_steps_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step ,.iq-process-step-style-5 .iq-process-step  .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step , {{WRAPPER}} .iq-process-step-style-2 .iq-process-step  .iq-step-content,  {{WRAPPER}} .iq-process-step-style-7 .iq-process-step' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_process_steps_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step-style-1 .iq-process-step,{{WRAPPER}} .iq-process-step-style-3 .iq-process-step,{{WRAPPER}} .iq-process-step-style-4 .iq-process-step,.iq-process-step-style-5 .iq-process-step  .iq-step-text-area,{{WRAPPER}} .iq-process-step-style-6 .iq-process-step ,{{WRAPPER}} .iq-process-step-style-2 .iq-process-step  .iq-step-content, {{WRAPPER}} .iq-process-step-style-7 .iq-process-step' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

         /* Process Steps End*/

         /* Process Icon start*/

        $this->start_controls_section(
			'section_6q084cd8dUQcpdlVCsT9',
			[
				'label' => __( 'Process Icon', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		 $this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],				
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-content i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_tabs' );
		$this->start_controls_tab(
			'tabs_0HcNxrZ4W22hdddBOf60',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step .iq-step-content i' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_background',
				'label' => __( 'Icon Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step  .iq-step-content',
			]
		);

		$this->add_control(
			'icon_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step  .iq-step-content' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'icon_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-content' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'icon_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step .iq-step-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_edjMeapcFs0TEIfJ923f',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-content i' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_hover_background',
				'label' => __( 'Icon Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step:hover .iq-step-content',
			]
		);


		$this->add_control(
			'icon_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step:hover .iq-step-content' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-content' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'icon_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'icon_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

         
        $this->add_responsive_control(
			'icon_width',
			[
				'label' => __( 'Width', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'icon_height',
			[
				'label' => __( 'Height', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step .iq-step-content' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


         $this->end_controls_section();


           /* Process Icon End*/

        	/* Process Number Start*/

        $this->start_controls_section(
			'section_Njpy9Mc13FSzTEbqdbe2',
			[
				'label' => __( 'Process Number', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'process_number_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-process-step  .step-number',
			]
		);



		$this->start_controls_tabs( 'process_number_tabs' );
		$this->start_controls_tab(
			'tabs_fZMn6STeyEr3d6fe8Iu5',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'process_number_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .step-number' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'process_number_background',
				'label' => __( 'Icon Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step  .step-number',
			]
		);

		$this->add_control(
			'process_number_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step  .step-number' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'process_number_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .step-number' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'process_number_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .step-number' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'process_number_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .step-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_kXwIba7VKHOefpL81590',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'process_number_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .step-number' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'process_number_hover_background',
				'label' => __( 'Icon Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step:hover .step-number',
			]
		);


		$this->add_control(
			'process_number_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step:hover .step-number' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'process_number_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .step-number' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'process_number_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .step-number' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'process_number_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .step-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'process_number_width',
			[
				'label' => __( 'Width', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step .step-number' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'process_number_height',
			[
				'label' => __( 'Height', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .step-number' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

          $this->end_controls_section();
         /* Process Number End*/

           /* Process Title start*/

        $this->start_controls_section(
			'section_03edde0cQ7pJT8eM5br0',
			[
				'label' => __( 'Process Title', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => __( 'Title Tag', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h4',
				'options'    => [
					
					'h1'          => __( 'h1', 'iqonic' ),
					'h2'          => __( 'h2', 'iqonic' ),
					'h3'          => __( 'h3', 'iqonic' ),
					'h4'          => __( 'h4', 'iqonic' ),
					'h5'          => __( 'h5', 'iqonic' ),
					'h6'          => __( 'h6', 'iqonic' ),
					
					
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_content_text_typography',
				'label' => __( 'Title Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-process-step  .iq-step-title',
			]
		);

		$this->start_controls_tabs( 'process_title_tabs' );
		$this->start_controls_tab(
			'tabs_YcUucdi26jLmI2210nhd',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'process_title_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'process_title_background',
				'label' => __( 'Title Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step  .iq-step-title',
			]
		);

		$this->add_control(
			'process_title_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step  .iq-step-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'process_title_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'process_title_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'process_title_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_ftdy6a8jqc2fATEdnP0b',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'process_title_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-title' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'process_title_hover_background',
				'label' => __( 'Title Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step:hover .iq-step-title',
			]
		);

				$this->add_control(
			'process_title_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step:hover .iq-step-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'process_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'process_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'process_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'process_title_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-process-step   .iq-step-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'process_title_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-process-step  .iq-step-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		  $this->end_controls_section();
         /* Process Title End*/


      
        /* Process Content start*/

        $this->start_controls_section(
			'section_XE3ZindC4Aceb89e8sO3',
			[
				'label' => __( 'Process Description', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_content_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-process-step  .iq-step-desc',
			]
		);

		$this->start_controls_tabs( 'process_desc_tabs' );
		$this->start_controls_tab(
			'tabs_gHBtsC8h6foR5GSf8zWO',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'process_desc_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step .iq-step-desc' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'process_desc_background',
				'label' => __( 'Icon Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step  .iq-step-desc',
			]
		);

		$this->add_control(
			'process_desc_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step  .iq-step-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'process_desc_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'process_desc_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'process_desc_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step  .iq-step-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_ZtR7TcQeHmEBLc80NG43',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'process_desc_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-desc' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'process_desc_hover_background',
				'label' => __( 'Icon Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-process-step:hover .iq-step-desc',
			]
		);

				$this->add_control(
			'process_desc_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'iqonic' ),
						'dashed' => __( 'Dashed', 'iqonic' ),
						'dotted' => __( 'Dotted', 'iqonic' ),
						'double' => __( 'Double', 'iqonic' ),
						'outset' => __( 'outset', 'iqonic' ),
						'groove' => __( 'groove', 'iqonic' ),
						'ridge' => __( 'ridge', 'iqonic' ),
						'inset' => __( 'inset', 'iqonic' ),
						'hidden' => __( 'hidden', 'iqonic' ),
						'none' => __( 'none', 'iqonic' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-process-step:hover .iq-step-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'process_desc_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'process_desc_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'process_desc_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-process-step:hover .iq-step-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'process_desc_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-process-step  .iq-step-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);



		$this->add_responsive_control(
			'process_desc_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-process-step  .iq-step-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		  $this->end_controls_section();
         /* Process Description End*/

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/ProcessStep/render.php';
    }
}
