<?php

namespace Iqonic\Elementor\Elements\FeatureCircle;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'Iq_Feature_Circle';
    }

    public function get_title()
    {
        return __('Iqonic Feature Circle', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-circle-o';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section',
			[
				'label' => __( 'Feature Circle', 'iqonic' ),
			]
		);

		$this->add_control(
			'section_style',
			[
				'label'      => __( 'Style', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'style-1',
				'options'    => [
					
					'style-1'          => __( 'Style 1', 'iqonic' ),
					'style-2'          => __( 'Style 2', 'iqonic' ),
					'style-3'          => __( 'Style 3', 'iqonic' ),
					
				],
			]
		);
        $this->add_control(
			'image',
			[
				'label' => __( 'Choose Logo', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
                    'active' => true,
                    
                ],            

                
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
        );
        
        $this->add_group_control(

			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'full',
				'separator' => 'none',
			]
		);       


        $repeater = new Repeater();

        $repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Title & Description', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab Title', 'iqonic' ),
				'placeholder' => __( 'Tab Title', 'iqonic' ),
				'label_block' => true,
			]
        );

        $repeater->add_control(
			'image_style',
			[
				'label'      => __( 'Icon/Image', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					
					'1'          => __( 'Icon', 'iqonic' ),
					'2'          => __( 'Image', 'iqonic' ),
					
					
				],
			]
		);
                
        $repeater->add_control(
			'tab_icon',
			[
				'label' => __( 'Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'
					
                ],
                'condition' => [
					'image_style' => '1',
				],
                
			]
        );
        
        $repeater->add_control(
			'tab_image',
			[
				'label' => __( 'Choose Image', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
                    'active' => true,
                    
                ],  
                'condition' => [
					'image_style' => '2',
				],          

                
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);	

		$repeater->add_control(
			'circle_icon_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
		 		'condition' => [
					'image_style' => '1',
				],
				
			]
			
		);

		$repeater->add_control(
			'circle_icon_background',
			[
				'label' => __( 'Icon Background Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,  
                'condition' => [
					'image_style' => '1',
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __('Link', 'iqonic'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('https://your-link.com', 'iqonic'),
				'default' => [
					'url' => '#',
				],
			]
		);

        
        $this->add_control(
			'tabs',
			[
				'label' => __( 'Tabs Items <h5 style="color:red; margin-top: 5px;">Here you can add only 8 items</h5>', 'iqonic' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'item_actions' => [
					'add'       => false,
					'duplicate' => true,
					'remove'    => true,
					'sort'      => true,
				],
				'default' => [
					[
						'tab_title' => __( 'Tab #1', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #2', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #3', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #4', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #5', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #6', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #7', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #8', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					]
					
				],
				'title_field' => '{{{ tab_title }}}',
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_style',
							'operator' => '!=',
							'value' => 'style-3'
						],
					],
				]	
			]
		);

		$this->add_control(
			'tabs_style-3',
			[
				'label' => __( 'Tabs Items <h5 style="color:red; margin-top: 5px;">Here you can add only 6 items</h5>', 'iqonic' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'item_actions' => [
					'add'       => false,
					'duplicate' => true,
					'remove'    => true,
					'sort'      => true,
				],
				'default' => [
					[
						'tab_title' => __( 'Tab #1', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #2', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #3', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #4', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #5', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
					[
						'tab_title' => __( 'Tab #6', 'iqonic' ),                        
                        'selected_icon' => __( 'fas fa-star', 'iqonic' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
				'condition' => [
					'section_style' => 'style-3'
				]	
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


        $this->end_controls_section();

        /* Logo Start*/

         $this->start_controls_section(
			'section_87S8In0es94At7xQD41V',
			[
				'label' => __( 'Logo', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);

        $this->start_controls_tabs( 'logo_tabs' );

		$this->start_controls_tab(
			'tabs_19pdV42zZ2eQ6m0w33er',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-feature-circle .circle-bg',
			]
		);

        $this->add_control(
			'logo_border_style',
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
						'{{WRAPPER}} .iq-feature-circle .circle-bg' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'logo_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-feature-circle .circle-bg' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'logo_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-feature-circle .circle-bg' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'logo_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-feature-circle .circle-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-feature-circle .circle-bg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

         
        $this->add_responsive_control(
			'width',
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
					'{{WRAPPER}} .iq-feature-circle .circle-bg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'height',
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
					'{{WRAPPER}} .iq-feature-circle .circle-bg' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);		

        $this->end_controls_section();

        /* Logo End*/

        /* Title Start*/

        $this->start_controls_section(
			'section_PEI35Y2SO53LrzZKw03M',
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
				'default'    => 'h6',
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

		$this->start_controls_tabs( 'title_tabs' );
		$this->start_controls_tab(
			'tabs_n5gEx7a2CdcYt10TZs5a',
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
					'{{WRAPPER}} .iq-feature-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_dEnTe9pjd11sxX93tiOz',
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
					'{{WRAPPER}} .iq-feature-title:hover' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-feature-title',
			]
		);

	
		$this->end_controls_section();

		/* Title End*/

		/* Icon Start*/

		$this->start_controls_section(
			'section_Uf5Lb1319Zbyx1Q9XeFM',
			[
				'label' => __( 'Icon', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);


		$this->add_control(
			'set_icon_size',
			[
				'label' => __( 'Set Icon Size?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'yes' => __( 'Yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
				'return_value' => 'yes',
				'default' => 'no',
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
				'condition' => ['set_icon_size' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_tabs' );
		$this->start_controls_tab(
			'tabs_am8B1831SQ1LagK5TnaF',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'color: {{VALUE}};',
		 		],
				
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
						'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'icon_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_59eqF0eNf1M1vKy8g36D',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img:hover' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_hover_background',
				'label' => __( 'Icon Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img:hover',
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
						'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-feature-circle .iq-img ul li .feature-info .feature-img' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		/* Icon End*/

		/* Border Start*/
		$this->start_controls_section(
			'section_59VT7db2fKXedlCa58Dm',
			[
				'label' => __( 'Border', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);

		$this->add_control(
			'iq_feature_border_style',
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
					
					'selectors' => ['
					    {{WRAPPER}} .iq-feature-circle .iq-img::before,
						{{WRAPPER}} .iq-feature-circle .effect-circle' => 'border-style: {{VALUE}};',	
					],
				]
		);

		$this->add_control(
			'iq_feature_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => ['
				    {{WRAPPER}} .iq-feature-circle .iq-img::before,
					{{WRAPPER}} .iq-feature-circle .effect-circle' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_feature_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => ['
				    {{WRAPPER}} .iq-feature-circle .iq-img::before,
					{{WRAPPER}} .iq-feature-circle .effect-circle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_feature_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => ['
				    {{WRAPPER}} .iq-feature-circle .iq-img::before,
					{{WRAPPER}} .iq-feature-circle .effect-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->end_controls_section();

		/* Border End*/


    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/FeatureCircle/render.php';
    }
}
