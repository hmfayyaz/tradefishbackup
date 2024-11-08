<?php

namespace Iqonic\Elementor\Elements\VerticalTimeline;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
	public function get_name()
	{
		return 'iqonic_vertical_time_line';
	}

	public function get_title()
	{
		return __('Iqonic Vertical Time Line', 'iqonic');
	}
	public function get_categories()
	{
		return ['iqonic-extension'];
	}

	public function get_icon()
	{
		return 'eicon-tabs';
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'section',
			[
				'label' => __( 'Tabs', 'iqonic' ),
			]
		);

        
		$repeater = new Repeater();
		
        $repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Timeline Title', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab Title', 'iqonic' ),
				'placeholder' => __( 'Tab Title', 'iqonic' ),
				'label_block' => true,
			]
        );
        
        $repeater->add_control(
			'tab_content',
			[
				'label' => __( 'Time Line Description', 'iqonic' ),
				'default' => __( 'simply dummy text of the printing Lorem Ipsum is and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s', 'iqonic' ),
				'placeholder' => __( 'Description', 'iqonic' ),
				'type' => Controls_Manager::TEXTAREA,
				'show_label' => false,
			]
		);

		 $repeater->add_control(
			'timeline_date',
			[
				'label' => __( 'Select Date', 'iqonic' ),
				'type' => Controls_Manager::DATE_TIME,
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
                'picker_options' => ['enableTime' => false]
				
			]
		);

		
        $this->add_control(
			'tabs',
			[
				'label' => __( 'Tabs Items', 'iqonic' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Tab #1', 'iqonic' ),
                        'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'iqonic' ),
                        
					]
					
				],
				'title_field' => '{{{ tab_title }}}',
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




         /* timeline  title Start*/

         $this->start_controls_section(
			'section_1Z53s28c71M09TYpE7Ru',
			[
				'label' => __( 'Title', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);

         $this->add_control(
			'title_tag',
			[
				'label'      => __( 'Title Tag', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h3',
				'options'    => [
					
					'h1'          => __( 'h1', 'iqonic' ),
					'h2'          => __( 'h2', 'iqonic' ),
					'h3'          => __( 'h3', 'iqonic' ),
					'h4'          => __( 'h4', 'iqonic' ),
					'h5'          => __( 'h5', 'iqonic' ),
					'h6'          => __( 'h6', 'iqonic' ),
					'div'          => __( 'div', 'iqonic' ),
					'span'          => __( 'span', 'iqonic' ),
					'p'          => __( 'p', 'iqonic' ),
					
					
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .timeline-title',
			]
		);


		$this->start_controls_tabs( 'title_tabs' );
		$this->start_controls_tab(
			'tabs_GcqaL53c172Vjmh2FKT6',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_6i7dbdabY91yE3cwL85Z',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'data_hover_text',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-timeline .timeline-article:hover .timeline-title, {{WRAPPER}} .iq-timeline .timeline__content:hover  .timeline-title' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		
	
		$this->end_controls_section();

		/* Title End*/


            /* timeline  Content Start*/

         $this->start_controls_section(
			'section_ysQRPL5g7X9CJW53bvh7',
			[
				'label' => __( 'Description', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);

      

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .timeline-content',
			]
		);


		$this->start_controls_tabs( 'content_tabs' );
		$this->start_controls_tab(
			'tabs_YN0Ab6Ue02fa3rslT6o9',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-content' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_a5j0dT5cf589y4oicdOK',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'desc_hover_text',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-timeline .timeline-article:hover .timeline-content ,{{WRAPPER}} .iq-timeline .timeline__content:hover .timeline-content ' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		
	
		$this->end_controls_section();

		/* Title End*/



            /* Date Start*/

         $this->start_controls_section(
			'section_8FoP47Ma0JwrTebcn8bq',
			[
				'label' => __( 'Date', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);

      

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .timeline .events-wrapper .events ol li a',
			]
		);


		$this->start_controls_tabs( 'date_tabs' );
		$this->start_controls_tab(
			'tabs_13ge7X8ydKtrk3RIz58i',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'date_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-timeline .timeline-article .timeline-date,{{WRAPPER}} .iq-timeline .timeline__content  .timeline_content_date' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_a1TQpVeL67e3b7ic7Ieh',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'date_hover_text',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-timeline .timeline-article:hover .timeline-date , {{WRAPPER}} .iq-timeline .timeline__content:hover  .timeline_content_date' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		
	
		$this->end_controls_section();

		/* Date End*/


		 /* Background Start*/

         $this->start_controls_section(
			'section_l90GEFfrjxU7NafPL2o1',
			[
				'label' => __( 'Conent Background', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);

        $this->start_controls_tabs( 'content_bg_tabs' );

		$this->start_controls_tab(
			'tabs_d7678f207ZBj65OA45Fm',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-timeline .timeline-article .content-box , {{WRAPPER}} .iq-timeline  .timeline__content  ',
			]
		);

        $this->add_control(
			'content_border_style',
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
						'{{WRAPPER}} .iq-timeline  .timeline-article .content-box, {{WRAPPER}} .iq-timeline  .timeline__content' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'content_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article .content-box , {{WRAPPER}} .iq-timeline  .timeline__content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .iq-timeline .timeline__item--left .timeline__content:after , {{WRAPPER}} .iq-timeline  .timeline__item--left  .timeline__content:before' => 'border-left-color: {{VALUE}};', 
					'{{WRAPPER}} .iq-timeline  .timeline__item--right  .timeline__content:after , {{WRAPPER}} .iq-timeline  .timeline__item--right .timeline__content:before' => 'border-right-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'content_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article .content-box, {{WRAPPER}} .iq-timeline  .timeline__content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article .content-box, {{WRAPPER}} .iq-timeline  .timeline__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		
		
        $this->end_controls_tab();

        $this->start_controls_tab(
			'tabs_Ld9ZfkE036qJeogjnUOF',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-timeline  .timeline-article:hover .content-box , {{WRAPPER}} .iq-timeline  .timeline__content:hover',
			]
		);

       	$this->add_control(
			'content_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'solid',
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
						'{{WRAPPER}} .iq-timeline  .timeline-article:hover .content-box , {{WRAPPER}} .iq-timeline  .timeline__content:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

       	$this->add_control(
			'content_hover_border_color',
			[
				'label' => __( 'Hover Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article:hover .content-box , {{WRAPPER}} .iq-timeline  .timeline__content:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .iq-timeline  .timeline__item--left .timeline__content:hover:after,{{WRAPPER}} .iq-timeline  .timeline__item--left  .timeline__content:hover:before' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .iq-timeline .timeline__item--right  .timeline__content:hover:after,{{WRAPPER}} .iq-timeline  .timeline__item--right .timeline__content:hover:before' => 'border-right-color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_control(
			'content_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline .timeline-article:hover .content-box , {{WRAPPER}} .iq-timeline  .timeline__content:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'content_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article:hover .content-box , {{WRAPPER}} .iq-timeline  .timeline__content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();


        $this->add_responsive_control(
			'container_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article .content-box, {{WRAPPER}} .iq-timeline  .timeline__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		 $this->add_responsive_control(
			'container_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article .content-box, {{WRAPPER}} .iq-timeline  .timeline__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);



    

        $this->end_controls_section();

        /* Background End*/


         /* Border Start*/

         $this->start_controls_section(
			'section_775aYe72mH6zeaCeSNE1',
			[
				'label' => __( 'Timeline Border', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);

            $this->start_controls_tabs( 'timeline_border_tabs' );

		$this->start_controls_tab(
			'tabs_dddfqecbDb5TbRjci5zL',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

       
        $this->add_control(
			'timeline_border_style',
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
						'{{WRAPPER}} .iq-timeline  .conference-center-line,{{WRAPPER}}  .iq-timeline  .timeline-article .meta-date, {{WRAPPER}} .iq-timeline .timeline-divider' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'timeline_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .conference-center-line , {{WRAPPER}}  .iq-timeline  .timeline-article .meta-date , {{WRAPPER}} .iq-timeline .timeline-divider' => 'border-color: {{VALUE}};',
					
		 		],
				
				
			]
		);

		$this->add_control(
			'timeline_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .conference-center-line ,{{WRAPPER}}  .iq-timeline  .timeline-article .meta-date , {{WRAPPER}} .iq-timeline .timeline-divider' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'timeline_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .conference-center-line , {{WRAPPER}} .iq-timeline .timeline-divider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		
		
        $this->end_controls_tab();

        $this->start_controls_tab(
			'tabs_i6I9KutaVbeR5eel15qc',
			[
				'label' => __( 'Active', 'iqonic' ),
			]
		);

       

       	$this->add_control(
			'timeline_active_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'solid',
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
						'{{WRAPPER}} .iq-timeline  .timeline-article .meta-date,{{WRAPPER}} .iq-timeline .timeline__items:before,{{WRAPPER}} .iq-timeline .timeline__items:after' => 'border-style: {{VALUE}};',
						
					],
				]
		);

       	$this->add_control(
			'timeline_active_border_color',
			[
				'label' => __( 'Hover Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					// '{{WRAPPER}} .iq-timeline  .timeline-article .meta-date ,{{WRAPPER}} .iq-timeline .events a::after, {{WRAPPER}} .iq-timeline  .cd-timeline-navigation a ,{{WRAPPER}} .iq-timeline .timeline__item:after, {{WRAPPER}} .iq-timeline .timeline__items:before,{{WRAPPER}} .iq-timeline .timeline__items:after' => 'border-color: {{VALUE}};',
					// '{{WRAPPER}} .iq-timeline .events a.selected::after, {{WRAPPER}} .iq-timeline  .cd-timeline-navigation a ,{{WRAPPER}} .iq-timeline .timeline__item:after, {{WRAPPER}} .iq-timeline .timeline__items:before, {{WRAPPER}} .iq-timeline .timeline__items:after' => 'Background-color: {{VALUE}};',
					'{{WRAPPER}} .conference-center-line:hover, {{WRAPPER}} .iq-timeline .timeline-article .meta-date:hover' => 'border-color:{{VALUE}}'
					
		 		],
				
			]
		);

		$this->add_control(
			'timeline_active_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article .meta-date , {{WRAPPER}} .iq-timeline .timeline__item:after' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'timeline_active_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-timeline  .timeline-article .meta-date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();


          $this->end_controls_section();

        /* Border End*/
	}

	protected function render()
	{
	  require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/VerticalTimeline/render.php';
	}
}
