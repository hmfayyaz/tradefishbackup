<?php

namespace Iqonic\Elementor\Elements\IconBox;

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
        return 'iqonic_icon_box';
    }

    public function get_title()
    {
        return __('Iqonic Icon Box', 'iqonic');
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
			'section_8weFRbC075mgara3qa2f',
			[
				'label' => __( 'Icon Box Style', 'iqonic' ),
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'      => __('Icon Box Styles', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'1' => __('Style 1', 'iqonic'),
					'2' => __('Style 2', 'iqonic'),
					'5' => __('Style 3', 'iqonic'),
					'6' => __('Style 4', 'iqonic'),
				],
			]
		);

        $this->end_controls_section();


     	$this->start_controls_section(
			'section',
			[
				'label' => __( 'Icon Box', 'iqonic' ),
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
			'section_title_1',
			[
				'label' => __( 'Sub Title', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( 'Second Title', 'iqonic' ),
				'condition' => ['design_style' => '4'],
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
			'has_link',
			[
				'label' => __( 'Use Link', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$this->add_control(
			'icon_box_link',
			[
				'label' => __( 'Link', 'iqonic' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'iqonic' ),
				'default' => [
					'url' => '#',
				],
				'condition' => ['has_link' => 'yes']
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
					
				],
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
					
				],
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
				],
			]
		);
		 $this->add_control(
			'has_back_img',
			[
				'label' => __( 'Use Background Image?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
				'condition' => [
					'design_style' => '1',
				],

			]
		);

		 $this->add_control(
			'back_image',
			[
				'label' => __( 'Choose Image', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'has_back_img' => 'yes',
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		 $this->add_control(
			'effect_icon',
			[
				'label' => __( 'Effect Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition' => [
					'media_style' => 'icon',
                ],
                'default' => [
					'value' => 'fas fa-star'				
				],
				'condition' => ['design_style' => '4']
			]
		);


		  $this->add_control(
			'has_loader',
			[
				'label' => __( 'Use loader', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
				'condition' => [
					'design_style' => '7',
				],

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


	

	/*Icon Box start*/

         $this->start_controls_section(
			'section_NELc08X86U438J8ZmnxQ',
			[
				'label' => __( 'IconBox', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


         $this->start_controls_tabs( 'Iconbox_tabs' );
		$this->start_controls_tab(
			'tabs_jefOdwB60gC8bAl3exvb',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_background',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_iconbox_box_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-icon-box',
			]
		);

		
		$this->add_control(
			'section_Jask0723YCOl8vK4162c',
			[
				'label' => __( 'Before Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style'=>['1','6']],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_before_background',
				'label' => __( 'Before Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style'=>['1','6']],
				'selector' => '{{WRAPPER}} .iq-icon-box.iq-icon-box-style-1::before,{{WRAPPER}} .iq-icon-box.iq-icon-box-style-6::before ',
			]
		);

		$this->add_control(
			'section_bODgeeUoAfwBtl3VTR37',
			[
				'label' => __( 'After Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style'=>['6']],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_after_background',
				'label' => __( 'After Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style'=>['6']],
				'selector' => '{{WRAPPER}} .iq-icon-box.iq-icon-box-style-6::after ',
			]
		);

		$this->add_control(
			'iq_iconbox_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$this->add_control(
			'iq_iconbox_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_iconbox_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-icon-box' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_iconbox_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_iconbox_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_iconbox_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_iconbox_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_iconbox_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_iconbox_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_YKc3bWU0OyR6287gk966',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box:hover,{{WRAPPER}} .iq-icon-box.acitve',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_iconbox_hover_box_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-icon-box:hover,{{WRAPPER}} .iq-icon-box.acitve',
			]
		);

		$this->add_control(
			'section_uDG49dcV7C3S6ac883I0',
			[
				'label' => __( 'Before Hover Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style'=>['1','6']],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_before_hover_background',
				'label' => __( 'Before Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style'=>['1','6']],
				'selector' => '{{WRAPPER}} .iq-icon-box.iq-icon-box-style-1:hover:before ,{{WRAPPER}} .iq-icon-box.iq-icon-box-style-1.active:before,{{WRAPPER}} .iq-icon-box.iq-icon-box-style-6:hover:before ,{{WRAPPER}} .iq-icon-box.iq-icon-box-style-6.active:before ',
			]
		);

		$this->add_control(
			'section_CVc8P3cpyOf20Rvba664',
			[
				'label' => __( 'After Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style'=>['6']],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_After_hover_background',
				'label' => __( 'After Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style'=>['6']],
				'selector' => '{{WRAPPER}} .iq-icon-box.iq-icon-box-style-6:hover:after ,{{WRAPPER}} .iq-icon-box.iq-icon-box-style-6.active:after ',
			]
		);


		$this->add_control(
			'iq_iconbox_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => ['iq_iconbox_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-icon-box:hover,{{WRAPPER}} .iq-icon-box.acitve' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_iconbox_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => ['iq_iconbox_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover,{{WRAPPER}} .iq-icon-box.acitve' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_iconbox_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => ['iq_iconbox_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover,{{WRAPPER}} .iq-icon-box.acitve' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_iconbox_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => ['iq_iconbox_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover,{{WRAPPER}} .iq-icon-box.acitve' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_iconbox_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_iconbox_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

         /* Icon Box  End*/

         /*Icon Icon start*/

         $this->start_controls_section(
			'section_285gUPrCuoL6e62Mhf7m',
			[
				'label' => __( 'Iconbox Icon/Image', 'iqonic' ),
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
					'{{WRAPPER}} .iq-icon-box .icon-box-img i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


         $this->start_controls_tabs( 'Iconbox_icon_tabs' );
		$this->start_controls_tab(
			'tabs_jeBef2kCfHObvih40638',
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
					'{{WRAPPER}} .iq-icon-box .icon-box-img i' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_icon_background',
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box .icon-box-img, {{WRAPPER}} .iq-icon-box.iq-icon-box-style-7 .img-bg',
			]
		);

		$this->add_control(
			'section_bdU34ic408o24Jb86ZR7',
			[
				'label' => __( 'Before Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style'=>['7']],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_icon_before_background',
				'label' => __( 'Before Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style'=>['7']],
				'selector' => '{{WRAPPER}} .iq-icon-box.iq-icon-box-style-7 .img-bg',
			]
		);

		$this->add_control(
			'iq_iconbox_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$this->add_control(
			'iq_iconbox_icon_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_iconbox_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-icon-box .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7 .effect-circle' => 'border-style: {{VALUE}};',
						'{{WRAPPER}} .iq-icon-box.iq-icon-box-style-7 .icon-box-img' => 'border-style:none;',
						
					],
				]
		);
			
		$this->add_control(
			'iq_iconbox_icon_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => ['iq_iconbox_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7 .effect-circle' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_iconbox_icon_before_border_color',
			[
				'label' => __( 'Before Border Color', 'iqonic' ),
				'condition' => ['design_style'=>['7']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-7 .effect-circle:before' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => ['iq_iconbox_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7 .effect-circle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_iconbox_icon_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => ['iq_iconbox_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7 .effect-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_aJ0C3kdUL5G4tW12awyR',
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
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-img i,{{WRAPPER}} .iq-icon-box.active .icon-box-img i' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_icon_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box:hover .icon-box-img ,{{WRAPPER}} .iq-icon-box.active .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7:hover .img-bg,{{WRAPPER}} .iq-icon-box-style-7.active .img-bg',
			]
		);
		$this->add_control(
			'section_ER3taX8lz268wcK1vWdj',
			[
				'label' => __( 'Before Hover Background ', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['design_style'=>['7']],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_icon_hover_before_background',
				'label' => __( 'Before Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style'=>['7']],
				'selector' => '{{WRAPPER}} .iq-icon-box.iq-icon-box-style-7:hover .img-bg,{{WRAPPER}} .iq-icon-box.iq-icon-box-style-7.active .img-bg',
			]
		);
		
		$this->add_control(
			'iq_iconbox_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$this->add_control(
			'iq_iconbox_icon_hover_border_style',
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
					'condition' => ['iq_iconbox_hover_has_border'=>['yes']],
					
					'selectors' => [
						'{{WRAPPER}} .iq-icon-box:hover .icon-box-img ,{{WRAPPER}} .iq-icon-box.active .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7:hover .effect-circle,{{WRAPPER}} .iq-icon-box-style-7.active .effect-circle' => 'border-style: {{VALUE}};',
						'{{WRAPPER}} .iq-icon-box.iq-icon-box-style-7:hover .icon-box-img,{{WRAPPER}} .iq-icon-box.iq-icon-box-style-7.active .icon-box-img' => 'border-style:none;',

						
					],
				]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_iconbox_hover_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-img ,{{WRAPPER}} .iq-icon-box.active .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7:hover .effect-circle,{{WRAPPER}} .iq-icon-box-style-7.active .effect-circle' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_iconbox_icon_before_hover_border_color',
			[
				'label' => __( 'Before Border Color', 'iqonic' ),
				'condition' => ['design_style'=>['7']],

				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-7:hover .effect-circle:before,{{WRAPPER}} .iq-icon-box-style-7.active .effect-circle:before' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);
		$this->add_control(
			'iq_iconbox_icon_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['iq_iconbox_hover_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-img ,{{WRAPPER}} .iq-icon-box.active .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7:hover .effect-circle,{{WRAPPER}} .iq-icon-box-style-7.active .effect-circle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_iconbox_icon_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['iq_iconbox_hover_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-img ,{{WRAPPER}} .iq-icon-box.active .icon-box-img,{{WRAPPER}} .iq-icon-box-style-7:hover .effect-circle,{{WRAPPER}} .iq-icon-box-style-7.active .effect-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();


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
					'{{WRAPPER}} .iq-icon-box .icon-box-img,{{WRAPPER}} .iq-icon-box .icon-box-img img,{{WRAPPER}}  .iq-icon-box-style-7 .img-bg' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .iq-icon-box .icon-box-img,{{WRAPPER}} .iq-icon-box .icon-box-img img, {{WRAPPER}}  .iq-icon-box-style-7 .img-bg' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-icon-box .icon-box-img i,,{{WRAPPER}}   .iq-icon-box-style-7 .img-bg i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_iconbox_icon_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box .icon-box-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_iconbox_icon_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box .icon-box-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

         /* Icon Box  icon*/


            /*Icon effect Icon start*/

         $this->start_controls_section(
			'section_RBsj87LT6M8hxbO3AW8n',
			[
				'label' => __( 'Effect Icon/Image', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,				
				'condition' => ['design_style'=>['4']],
			]
		);

          $this->add_control(
			'effecticon_size',
			[
				'label' => __( 'Icon Size', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],	
				'condition' => ['design_style'=>['4']],			
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
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


        $this->start_controls_tabs( 'Iconbox_effecticon_tabs' );
		$this->start_controls_tab(
			'tabs_69AQd0Xc4J33NT7v6q4w',
			[
				'label' => __( 'Normal', 'iqonic' ),
				'condition' => ['design_style'=>['4']],
			]
		);


		$this->add_control(
			'effecticon_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box i' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_effecticon_background',								
				'condition' => ['design_style'=>['4']],
				'label' => __( 'Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' =>'{{WRAPPER}} .iq-icon-box-style-4 .effect-box',
			]
		);

		$this->add_control(
			'iq_iconbox_effecticon_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['design_style'=>['4']],
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
						'{{WRAPPER}} .iq-icon-box-style-4 .effect-box' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_iconbox_effecticon_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_iconbox_effecticon_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_iconbox_effecticon_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_Owsdg0N6JrmbSYaDcER6',
			[
				'label' => __( 'Hover', 'iqonic' ),
				'condition' => ['design_style'=>['4']],
			]
		);

		$this->add_control(
			'effecticon_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4:hover .effect-box i,{{WRAPPER}} .iq-icon-box-style-4.active .effect-box i' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_iconbox_effecticon_hover_background',
				'label' => __( 'Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style'=>['4']],
				'selector' => '{{WRAPPER}} .iq-icon-box-style-4:hover .effect-box,{{WRAPPER}} .iq-icon-box-style-4.active .effect-box',
			]
		);
		

		$this->add_control(
			'iq_iconbox_effecticon_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['design_style'=>['4']],
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
						'{{WRAPPER}} .iq-icon-box-style-4:hover .effect-box,{{WRAPPER}} .iq-icon-box-style-4.active .effect-box' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_iconbox_effecticon_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4:hover .effect-box,{{WRAPPER}} .iq-icon-box-style-4.active .effect-box' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_iconbox_effecticon_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4:hover .effect-box,{{WRAPPER}} .iq-icon-box-style-4.active .effect-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_iconbox_effecticon_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4:hover .effect-box,{{WRAPPER}} .iq-icon-box-style-4.active .effect-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();


        $this->add_responsive_control(
			'effecticon_width',
			[
				'label' => __( 'Width', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style'=>['4']],
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
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box,{{WRAPPER}} .iq-icon-box-style-4 .effect-box i' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'effecticon_height',
			[
				'label' => __( 'Height', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style'=>['4']],
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
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box,{{WRAPPER}} .iq-icon-box-style-4 .effect-box i' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_iconbox_effecticon_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['design_style'=>['4']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_iconbox_effecticon_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style'=>['4']],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box-style-4 .effect-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

         /* Icon Box  effect icon end*/



           /* Iconbox Title start*/

        $this->start_controls_section(
			'section_zq808BOa6ovm3lt2xN1E',
			[
				'label' => __( 'Iconbox Title', 'iqonic' ),
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
				'selector' => '{{WRAPPER}} .iq-icon-box  .icon-box-title',
			]
		);

		$this->start_controls_tabs( 'iconbox_title_tabs' );
		$this->start_controls_tab(
			'tabs_es28o3dUL2GRtuqE5mb4',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'iconbox_title_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-title a' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_title_background',
				'label' => __( 'Title Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box  .icon-box-title',
			]
		);

		$this->add_control(
			'iconbox_title_border_style',
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
						'{{WRAPPER}} .iq-icon-box  .icon-box-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iconbox_title_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iconbox_title_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iconbox_title_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_6alC26d6Boy9qM8e4Am3',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'iconbox_title_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-title a, {{WRAPPER}} .iq-icon-box.active .icon-box-title a' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_title_hover_background',
				'label' => __( 'Title Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box:hover .icon-box-title,{{WRAPPER}} .iq-icon-box.active .icon-box-title',
			]
		);

		$this->add_control(
			'iconbox_title_hover_border_style',
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
						'{{WRAPPER}} .iq-icon-box:hover .icon-box-title,{{WRAPPER}} .iq-icon-box.active .icon-box-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iconbox_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-title,{{WRAPPER}} .iq-icon-box.active .icon-box-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iconbox_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-title,{{WRAPPER}} .iq-icon-box.active .icon-box-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iconbox_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-title,{{WRAPPER}} .iq-icon-box.active .icon-box-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iconbox_title_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-icon-box   .icon-box-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iconbox_title_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-icon-box  .icon-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		  $this->end_controls_section();
         /* Iconbox Title End*/


           /* Iconbox Sub Title Start*/
          $this->start_controls_section(
			'section_jSxlM45e2i3a0dEQ8cff',
			[
				'label' => __( 'Iconbox Sub Title', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['design_style' => '4'],
			]
		);

		$this->add_control(
			'subtitle_tag',
			[
				'label'      => __( 'Sub Title Tag', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'condition' => ['design_style' => '4'],
				'default'    => 'h6',
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
				'name' => 'subtitle_content_text_typography',
				'label' => __( 'Typography', 'iqonic' ),
				'condition' => ['design_style' => '4'],				
				'selector' => '{{WRAPPER}} .iq-icon-box  .icon-box-subtitle',
			]
		);

		$this->start_controls_tabs( 'iconbox_subtitle_tabs' );
		$this->start_controls_tab(
			'tabs_66b8DPGSis4268ctc2b4',
			[
				'label' => __( 'Normal', 'iqonic' ),
				'condition' => ['design_style' => '4'],
			]
		);

		$this->add_control(
			'iconbox_subtitle_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-subtitle' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_subtitle_background',
				'label' => __( 'Title Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style' => '4'],
				'selector' => '{{WRAPPER}} .iq-icon-box  .icon-box-subtitle',
			]
		);

		$this->add_control(
			'iconbox_subtitle_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['design_style' => '4'],
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
						'{{WRAPPER}} .iq-icon-box  .icon-box-subtitle' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iconbox_subtitle_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-subtitle' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iconbox_subtitle_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['design_style' => '4'],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-subtitle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iconbox_subtitle_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_eLx80JH8b46n28daWoa3',
			[
				'label' => __( 'Hover', 'iqonic' ),
				'condition' => ['design_style' => '4'],
			]
		);

		$this->add_control(
			'iconbox_subtitle_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,	
				'condition' => ['design_style' => '4'],			
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-subtitle, {{WRAPPER}} .iq-icon-box.active .icon-box-subtitle' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_subtitle_hover_background',
				'label' => __( 'Title Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => ['design_style' => '4'],
				'selector' => '{{WRAPPER}} .iq-icon-box:hover .icon-box-subtitle,{{WRAPPER}} .iq-icon-box.active .icon-box-subtitle',
			]
		);

		$this->add_control(
			'iconbox_subtitle_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['design_style' => '4'],
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
						'{{WRAPPER}} .iq-icon-box:hover .icon-box-subtitle,{{WRAPPER}} .iq-icon-box.active .icon-box-subtitle' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iconbox_subtitle_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-subtitle,{{WRAPPER}} .iq-icon-box.active .icon-box-subtitle' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iconbox_subtitle_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-subtitle,{{WRAPPER}} .iq-icon-box.active .icon-box-subtitle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iconbox_subtitle_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-subtitle,{{WRAPPER}} .iq-icon-box.active .icon-box-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iconbox_subtitle_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}}  .iq-icon-box   .icon-box-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iconbox_subtitle_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => ['design_style' => '4'],
				'selectors' => [
					'{{WRAPPER}}  .iq-icon-box  .icon-box-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		  $this->end_controls_section();
         /* Iconbox Sub Title End*/


      
        /* Iconbox Content start*/

        $this->start_controls_section(
			'section_i4uH428mYTbPBbF6rDe1',
			[
				'label' => __( 'Iconbox Description', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_content_text_typography',
				'label' => __( 'Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-icon-box  .icon-box-desc',
			]
		);

		$this->start_controls_tabs( 'iconbox_desc_tabs' );
		$this->start_controls_tab(
			'tabs_rT8Coe33K21a68H6Id63',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'iconbox_desc_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box .icon-box-desc' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_desc_background',
				'label' => __( 'Icon Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box  .icon-box-desc',
			]
		);

		$this->add_control(
			'iconbox_desc_border_style',
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
						'{{WRAPPER}} .iq-icon-box  .icon-box-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iconbox_desc_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iconbox_desc_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iconbox_desc_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box  .icon-box-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_asSFfYDArb8dc9Rq0o36',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'iconbox_desc_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-desc,{{WRAPPER}} .iq-icon-box.active .icon-box-desc' => 'color: {{VALUE}};',
		 		],
				
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_desc_hover_background',
				'label' => __( 'Icon Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-icon-box:hover .icon-box-desc,{{WRAPPER}} .iq-icon-box.active .icon-box-desc',
			]
		);

				$this->add_control(
			'iconbox_desc_hover_border_style',
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
						'{{WRAPPER}} .iq-icon-box:hover .icon-box-desc,{{WRAPPER}} .iq-icon-box.active .icon-box-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iconbox_desc_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-desc,{{WRAPPER}} .iq-icon-box.active .icon-box-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iconbox_desc_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-desc,{{WRAPPER}} .iq-icon-box.active .icon-box-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iconbox_desc_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-icon-box:hover .icon-box-desc,{{WRAPPER}} .iq-icon-box.active .icon-box-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iconbox_desc_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-icon-box  .icon-box-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);



		$this->add_responsive_control(
			'iconbox_desc_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-icon-box  .icon-box-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		  $this->end_controls_section();
         /* Iconbox Description End*/   

       
		/*Button Start*/
		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';
		/*Button End*/

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/IconBox/render.php';
    }
}
