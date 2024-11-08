<?php

namespace Iqonic\Elementor\Elements\FancyBoxList;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_fancybox_list';
    }

    public function get_title()
    {
        return __('Iqonic FancyBox With List', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-icon-box';
    }
    protected function register_controls()
    {

		$this->start_controls_section(
			'section_6welJcFbXauf3kz4m9OI',
			[
				'label' => __( 'FancyBox With List Style', 'iqonic' ),
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'      => __('Tooltip Style', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'1' => __('Style 1', 'iqonic'),
					'2' => __('Style 2', 'iqonic'),
				
					
				],
			]
		);
		$this->end_controls_section(); 
		$this->start_controls_section(
			'section',
			[
				'label' => __( 'FancyBox With List ', 'iqonic' ),
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
				'default' => __( 'Add Your Title Text Here', 'iqonic' ),
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
				'placeholder' => __( 'Enter your Description', 'iqonic' ),
				'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'iqonic' ),
			]
		);

		$this->add_control(
			'media_style',
			[
				'label'      => __( 'Icon / Image', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'icon',
				'options'    => [
					
					'icon'          => __( 'Icon', 'iqonic' ),
					'image'          => __( 'Image', 'iqonic' ),
					'none'          => __( 'None', 'iqonic' ),
					
				]
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition' => [
					'media_style' => 'icon',
				],
				'default' => [
					'value' => 'fas fa-star'
					
				]
			]
		);

		$this->add_control(
			'image',
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
				]
			]
		);

		  
	   	$this->add_control(
			'active_onoff',
			[
				'label' => __( 'Is Active', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

        $this->add_control(
			'has_box_shadow',
			[
				'label' => __( 'Use Box Shadow?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
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

        /* List Section*/
        $this->start_controls_section(
			'section_Geu9beBjZK1b086Tf3q7',
			[
				'label' => __( 'List', 'iqonic' ),
				
			]
		);

		$this->add_control(
			'list_style',
			[
				'label'      => __( 'List Style', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'unorder',
				'options'    => [
					
					'order'          => __( 'Order List', 'iqonic' ),
					'unorder'          => __( 'Unorder List', 'iqonic' ),
                    'icon'          => __( 'icon', 'iqonic' ),
                    'image'          => __( 'Image', 'iqonic' ),
                    
					
				],
			]
        );
        
        $this->add_control(
			'list_style_type_ol',
			[
				'label'      => __( 'List Style', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'decimal',
				'options'    => [	
                    'decimal'          => __( 'Decimal', 'iqonic' ),
                    'decimal-leading-zero' => __( 'Decimal Leading Zero', 'iqonic' ),
                    'lower-alpha'          => __( 'Lower Alpha', 'iqonic' ),
                    'lower-greek'          => __( 'Lower Greek', 'iqonic' ),
                    'lower-latin'          => __( 'Lower Latin', 'iqonic' ),
                    'lower-roman'          => __( 'Lower Roman', 'iqonic' ),
                    'upper-alpha'          => __( 'Upper Alpha', 'iqonic' ),
                    'upper-roman'          => __( 'Upper Roman', 'iqonic' ),     
                ],
                'condition' => [
					'list_style' => 'order',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-list .iq-order-list li' => 'list-style-type: {{VALUE}};',
				],
			]
        );
        
        $this->add_control(
			'list_style_type_ul',
			[
				'label'      => __( 'List Style', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'circle',
				'options'    => [	
                    'circle' => __( 'Circle', 'iqonic' ),
                    'disc'   => __( 'Disc', 'iqonic' ),
                    'square' => __( 'Square', 'iqonic' ),
                    
                ],
                'condition' => [
					'list_style' => 'unorder',
				],
				'selectors' => [
					'{{WRAPPER}} .iq-list .iq-unoreder-list li' => 'list-style-type: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_icon',
			[
				'label' => __( 'Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'
					
                ],
                'condition' => [
					'list_style' => 'icon',
				],
			]
		);

		$this->add_control(
			'list_image',
			[
				'label' => __( 'Image', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'list_style' => 'image',
				],
			]
		);

		$this->add_control(
			'list_column',
			[
				'label'      => __( 'No. Of column', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'one',
				'options'    => [
					
					'one'          => __( '1 column', 'iqonic' ),
					'two'          => __( '2 column', 'iqonic' ),
                    'three'        => __( '3 column', 'iqonic' ),
                    'four'         => __( '4 column', 'iqonic' ),
                    'five' 		   => __( '5 column', 'iqonic' ),
                    'six'		   => __( '6 column', 'iqonic' ),
																									
				],
			]
		);

		$repeater = new Repeater();
        $repeater->add_control(
			'tab_title',
			[
				'label' => __( 'List Items', 'iqonic' ),
				'type' => Controls_Manager::TEXT,	
				'default' => __('List Item' , 'iqonic'),			
				'placeholder' => __( 'Tab Title', 'iqonic' ),
				'label_block' => true,
			]
        );
        
      
        $this->add_control(
			'tabs',
			[
				'label' => __( 'Lists Items', 'iqonic' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'List Items', 'iqonic' ),
                        
					]
					
				],
				'title_field' => '{{{ tab_title }}}',
			]
        );
        /* List Section End*/

       $this->end_controls_section(); 


		 /*Fancy Box start*/

     $this->start_controls_section(
			'section_NdRqkC1e0bI553e1b2fX',
			[
				'label' => __( 'Fancybox', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


     $this->start_controls_tabs( 'Fancybox_tabs' );
		$this->start_controls_tab(
			'tabs_NdRqkC1e0bI553e1b2fX',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_background',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_fancy_box_list_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-fancy-box-list',
			]
		);

		$this->add_control(
			'section_7Y9OLxwj0D2V35zn34rh',
			[
				'label' => __( 'Before Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_before_background',
				'label' => __( 'Before Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list::before',
			]
		);

		
		
		$this->add_control(
			'iq_fancybox_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
		
		$this->add_control(
			'iq_fancybox_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => [
					'iq_fancybox_has_border' => 'yes',
					],
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
						'{{WRAPPER}} .iq-fancy-box-list' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		
		$this->add_control(
			'iq_fancybox_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => [
					'iq_fancybox_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_fancybox_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => [
					'iq_fancybox_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_fancybox_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => [
					'iq_fancybox_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_5ZASitWXe7aGDw5U7Lbz',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list:hover,{{WRAPPER}} .iq-fancy-box-list.acitve'
				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_fancy_box_list_shadow_hover',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-fancy-box-list:hover',
			]
		);

		$this->add_control(
			'section_89V9pWsezJHkflibIA90',
			[
				'label' => __( 'Before Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_hover_before_background',
				'label' => __( 'Before Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list:hover::before,{{WRAPPER}} .iq-fancy-box-list.active::before ',
			]
		);

		$this->add_control(
			'iq_fancybox_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$this->add_control(
			'iq_fancybox_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => [
					'iq_fancybox_hover_has_border' => 'yes',
					],
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
						'{{WRAPPER}} .iq-fancy-box-list:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_fancybox_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => [
					'iq_fancybox_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_fancybox_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => [
					'iq_fancybox_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_fancybox_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => [
					'iq_fancybox_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'divider_89V9pWsezJHkflibIA90',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);


		$this->add_responsive_control(
			'iq_fancybox_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_fancybox_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

         /* Fancy Box  End*/

         /*Fancy Icon start*/

         $this->start_controls_section(
			'section_1zTpb6WY9f210c8R3Fhr',
			[
				'label' => __( 'Fancybox Icon/Image', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

     	$this->add_control(
			'has_icon_size',
			[
				'label' => __( 'Set Custom Icon Size?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
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
				'condition' => ['has_icon_size' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


         $this->start_controls_tabs( '_cbNonlL191pcPbB9h28v' );
		$this->start_controls_tab(
			'tabs_WmyT8vBx3MR89Xba9eKC',
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
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area i' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_icon_background',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list .iq-img-area',
			]
		);

		$this->add_control(
			'iq_fancybox_icon_border_style',
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
						'{{WRAPPER}} .iq-fancy-box-list .iq-img-area' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_fancybox_icon_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_fancybox_icon_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_fancybox_icon_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_yr3Gedx7RB8VCu7ktg7S',
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
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-img-area i,{{WRAPPER}} .iq-fancy-box-list.active .iq-img-area i' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_fancybox_icon_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => ' {{WRAPPER}} .iq-fancy-box-list:hover .iq-img-area,
				 {{WRAPPER}} .iq-fancy-box-list.active .iq-img-area ,{{WRAPPER}} .iq-fancy-box-list-style-6:hover .iq-img-area:before,{{WRAPPER}} .iq-fancy-box-list-style-6.active .iq-img-area:before',
			]
		);
		

		$this->add_control(
			'iq_fancybox_icon_hover_border_style',
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
						'{{WRAPPER}} .iq-fancy-box-list:hover .iq-img-area,
				 {{WRAPPER}} .iq-fancy-box-list.active .iq-img-area' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_fancybox_icon_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-img-area,{{WRAPPER}} .iq-fancy-box-list.active .iq-img-area' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_fancybox_icon_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-img-area,{{WRAPPER}} .iq-fancy-box-list.active .iq-img-area' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_fancybox_icon_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-img-area,{{WRAPPER}} .iq-fancy-box-list.active .iq-img-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'divider_Q1jNG1bxD9dse8kfu3T7',
			[
				'type' => Controls_Manager::DIVIDER,
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
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area,{{WRAPPER}} .iq-fancy-box-list-style-6 .iq-img-area:before' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area , {{WRAPPER}} .iq-fancy-box-list .iq-img-area i' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_fancybox_icon_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_fancybox_icon_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list .iq-img-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

         /* Fancy Box  icon*/



           /* Fancybox Title start*/

        $this->start_controls_section(
			'section_Q1jNG1bxD9dse8kfu3T7',
			[
				'label' => __( 'Fancybox Title', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => __( 'Title Tag', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h5',
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
				'selector' => '{{WRAPPER}} .iq-fancy-box-list  .iq-fancy-title',
			]
		);

		$this->start_controls_tabs( 'tabs_74hO776fjer38coDbCa1');
		$this->start_controls_tab(
			'tabs_ueEfbr5177bm77Fcwd33',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'fancybox_title_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list  .iq-fancy-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_title_background',
				'label' => __( 'Title Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list  .iq-fancy-title',
			]
		);

		$this->add_control(
			'fancybox_title_border_style',
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
						'{{WRAPPER}} .iq-fancy-box-list  .iq-fancy-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'fancybox_title_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list  .iq-fancy-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'fancybox_title_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list  .iq-fancy-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'fancybox_title_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list  .iq-fancy-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_77Al1eF4QO9d48273Ete',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'fancybox_title_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-fancy-title, {{WRAPPER}} .iq-fancy-box-list.active .iq-fancy-title' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_title_hover_background',
				'label' => __( 'Title Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box-list.active .iq-fancy-title',
			]
		);

		$this->add_control(
			'fancybox_title_hover_border_style',
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
						'{{WRAPPER}} .iq-fancy-box-list:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box-list.active .iq-fancy-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'fancybox_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box-list.active .iq-fancy-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'fancybox_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box-list.active .iq-fancy-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'fancybox_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .iq-fancy-title,{{WRAPPER}} .iq-fancy-box-list.active .iq-fancy-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'fancybox_title_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box-list   .iq-fancy-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'fancybox_title_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box-list  .iq-fancy-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		  $this->end_controls_section();
         /* Fancybox Title End*/


      
        /* Fancybox Content start*/

        $this->start_controls_section(
			'section_5SC13aobQ9eWv4LTqsH3',
			[
				'label' => __( 'Fancybox Description', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_content_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-fancy-box-list  .fancy-box-content',
			]
		);

		$this->start_controls_tabs( 'fancybox_desc_tabs' );
		$this->start_controls_tab(
			'tabs_9Vo7Ab81Z5I5rB73aT76',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'fancybox_desc_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list .fancy-box-content' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_desc_background',
				'label' => __( 'Icon Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list  .fancy-box-content',
			]
		);

		$this->add_control(
			'fancybox_desc_border_style',
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
						'{{WRAPPER}} .iq-fancy-box-list  .fancy-box-content' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'fancybox_desc_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list  .fancy-box-content' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'fancybox_desc_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list  .fancy-box-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'fancybox_desc_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list  .fancy-box-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_5nrP3y7kI802bdp45Ncs',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'fancybox_desc_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box-list.active .fancy-box-content' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancybox_desc_hover_background',
				'label' => __( 'Icon Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-fancy-box-list:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box-list.active .fancy-box-content',
			]
		);

				$this->add_control(
			'fancybox_desc_hover_border_style',
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
						'{{WRAPPER}} .iq-fancy-box-list:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box-list.active .fancy-box-content' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'fancybox_desc_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box-list.active .fancy-box-content' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'fancybox_desc_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box-list.active .fancy-box-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'fancybox_desc_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-fancy-box-list:hover .fancy-box-content,{{WRAPPER}} .iq-fancy-box-list.active .fancy-box-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'fancybox_desc_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box-list  .fancy-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'fancybox_desc_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-fancy-box-list  .fancy-box-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

	   $this->end_controls_section();
         /* Fancybox Description End*/



        $this->start_controls_section(
			'section_cF58Y7Ih1bt0zxf8Dn1i',
			[
				'label' => __( 'List', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		

		$this->start_controls_tabs( 'iq_lists_tabs' );

		$this->start_controls_tab(
            'tabs_350c1a5XeRKaHFbx0P8e',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'iq_lists_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}}  .iq-list li',
			]
		);

		$this->add_control(
			'iq_list_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list li' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
            'tabs_WFvIG3TMan19Dswpj8K8',
            [
                'label' => __( 'Hover', 'iqonic' ),
            ]
        );

         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'iq_lists_text_typography_hover',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}}  .iq-list li:hover',
			]
		);

        $this->add_control(
			'iq_list_color_hover',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list li:hover' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

        $this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

          /*Fancy Icon start*/

        $this->start_controls_section(
			'section_XZGzehHLI52s8a35jep1',
			[
				'label' => __( 'List Icon/Image', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

          $this->add_control(
			'icon_size_list',
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
					'{{WRAPPER}} .iq-list-with-icon li i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


     	$this->start_controls_tabs( 'tabs_5fej35C77eNFw1rdB6vh' );
		$this->start_controls_tab(
			'tabs_kxST1whl8s3KcY37j7Q5',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);


		$this->add_control(
			'icon_color_list',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_list_icon_background_list',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img',
			]
		);

		$this->add_control(
			'iq_list_icon_border_style_list',
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
						'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_list_icon_border_color_list',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_list_icon_border_width_list',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_list_icon_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_CP35pHb96ScOZJK912q4',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'icon_hover_color_list',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li:hover i' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_list_icon_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => ' {{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img',
			]
		);
		

		$this->add_control(
			'iq_list_icon_hover_border_style',
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
						'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_list_icon_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_list_icon_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li:hover i,{{WRAPPER}} .iq-list-with-img li:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();


        $this->add_responsive_control(
			'icon_width_list',
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
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'icon_height_list',
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
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-list-with-icon li i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_list_icon_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_list_icon_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-list-with-icon li i,{{WRAPPER}} .iq-list-with-img li img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

         /* Fancy Box  icon*/

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/FancyBoxList/render.php';
	
    }
}
