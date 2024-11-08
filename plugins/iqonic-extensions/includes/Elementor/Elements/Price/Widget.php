<?php

namespace Iqonic\Elementor\Elements\Price;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_price';
    }

    public function get_title()
    {
        return __('Iqonic Pricing Plan', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-price-table';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section_9lwfiID3Ld0NMx7XhB58',
			[
				'label' => __( 'Pricing Table Style', 'iqonic' ),
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'      => __('Client Styles', 'iqonic'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '0',
				'options'    => [
					'0' => __('Style 1', 'iqonic'),
					'4' => __('Style 2', 'iqonic'),
					'5' => __('Style 3', 'iqonic'),
				],
			]
		);

        $this->end_controls_section();
		$this->start_controls_section(
			'section',
			[
				'label' => __( 'Pricing Plan', 'iqonic' ),
			]
		);
		
		
        
        $this->add_control(
			'price',
			[
				'label' => __( 'Price', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( '10', 'iqonic' ),
				
			]
		);


		$this->add_control(
			'price_label',
			[
				'label' => __( 'Price Label', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( 'starter', 'iqonic' ),
			]
		);

		

		$this->add_control(
			'time_period',
			[
				'label' => __( 'Time Period', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( '/month', 'iqonic' ),
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
				'condition' => [
					'design_style' => ['1','6'],
				],
				'placeholder' => __( 'Enter Description', 'iqonic' ),
				
			]
		);
		$resultarr = [];
		$currrency = get_currency_symbol();
		foreach ($currrency as $key => $value) {
    	$resultarr[$value.' '.iqonic_random_strings(strtotime('now'))] = $value.' '.$key;
 	 }
  

		$this->add_control(
			'currency_symbol',
			[
				'label' => __( 'Currency Symbol', 'iqonic' ),
				'type' => Controls_Manager::SELECT2,
				
				'options' => $resultarr,
			]
        );

		$this->add_control(
			'active',
			[
				'label' => __( 'Is Active?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
		);

		$this->add_control(
			'has_price_shadow',
			[
				'label' => __( 'Use Box Shadow', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
		);

        
        
        $repeater = new Repeater();
        $repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Plan info List', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Service Item', 'iqonic' ),
				'placeholder' => __( 'Service Item', 'iqonic' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'has_service_active',
			[
				'label' => __( 'Disable this feature?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
		 $repeater->add_control(
			'has_service_icon',
			[
				'label' => __( 'Use Icon?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$repeater->add_control(
			'service_icon',
			[
				'label' => __( 'Service Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'
					
				],
				'condition' => [
					'has_service_icon' => 'yes',
				],
				'label_block' => false,
				'skin' => 'inline',

				
			]
		);       

        
        $this->add_control(
			'tabs',
			[
				'label' => __( 'List Items', 'iqonic' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Service Item', 'iqonic' ),
						
                        
					]
					
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'      => __( 'Price Tag', 'iqonic' ),
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

		/*Button Start*/		
		require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/iq_btn_controls.php';
        /*Button End*/

		 /* Price Table Start*/

        $this->start_controls_section(
			'section_fyWdp0abeSvr3Mi44LVm',
			[
				'label' => __( 'Price Table', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'price_table_tabs' );
		$this->start_controls_tab(
            'tabs_yL0o668ZXM4g9zsUSjCi',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
        
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_table_background',
                'label' => __( 'Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container',
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_price_table_box_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-price-container',
			]
		);

         $this->add_control(
			'section_oqfR22l3fbiF25GTU02H',
			[
				'label' => __( 'Before Background', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'design_style' => '6',
					],
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_table_before_background',
                'label' => __( 'Before Background', 'iqonic' ),
                'condition' => [
					'design_style' => '6',
					],
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-table-6::before',
            ]
        );
		$this->add_control(
			'price_table_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
        $this->add_control(
			'price_table_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'condition' => [
					'price_table_has_border' => 'yes',
					],
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
						'{{WRAPPER}} .iq-price-container ' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_table_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => [
					'price_table_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_table_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => [
					'price_table_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_table_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => [
					'price_table_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_f1pW85xe0693t0fKBV1Y',
            [
                'label' => __( 'Active', 'iqonic' ),
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_table_hover_background',
                'label' => __( 'Hover Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container:hover ,{{WRAPPER}} .iq-price-container.active',
            ]
        );
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_price_table_hover_box_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-price-container:hover ,{{WRAPPER}} .iq-price-container.active',
			]
		);

        $this->add_control(
			'section_C075nlXNgZ03Afe5d0Is',
			[
				'label' => __( 'Before Hover Background', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'design_style' => '6',
					],
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_table_hover_before_background',
                'label' => __( 'Hover Before Background', 'iqonic' ),
                'condition' => [
					'design_style' => '6',
					],
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-table-6.active::before',
            ]
        );
        $this->add_control(
			'price_table_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
        $this->add_control(
			'price_table_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => [
					'price_table_hover_has_border' => 'yes',
					],
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
						'{{WRAPPER}} .iq-price-container:hover ,{{WRAPPER}} .iq-price-container.active' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_table_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => [
					'price_table_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover,{{WRAPPER}} .iq-price-container.active' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_table_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => [
					'price_table_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover,{{WRAPPER}} .iq-price-container.active' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_table_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => [
					'price_table_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover,{{WRAPPER}} .iq-price-container.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_responsive_control(
			'price_table_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_table_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);


		$this->end_controls_section();

		 /* Price table End*/



        /* Price Header Start*/

		$this->start_controls_section(
			'section_K570f6fbXo53dcT4m2eN',
			[
				'label' => __( 'Price Header', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		/*currency Start*/
		$this->add_control(
			'section_mX28erE332RbyLve03nU',
			[
				'label' => __( 'Currency', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_currency_text_typography',
				'label' => __( 'Currency Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}}  .iq-price-header .iq-price small:first-child	',
			]
		);

		$this->start_controls_tabs( 'price_currency_tabs' );
		$this->start_controls_tab(
            'tabs_Lfkb48DXYs0eBP93241E',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_currency_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-header .iq-price small:first-child' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_fmjB3Off9KF4v53WZ8Xh',
            [
                'label' => __( 'Hover', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_currency_hover_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-header .iq-price small:first-child,
					 {{WRAPPER}} .iq-price-container.active .iq-price-header .iq-price small:first-child' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'price_currency_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price small:first-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_currency_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price small:first-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		/*Currency End*/

		/*Price Start*/

		$this->add_control(
			'section_YxSwfrRT69442fI6mbCp',
			[
				'label' => __( 'Price', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_text_typography',
				'label' => __( 'Price Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-price-header .iq-price',
			]
		);

		$this->start_controls_tabs( 'price_text_tabs' );
		$this->start_controls_tab(
            'tabs_FqDe9pYKt6UXJnGh82d2',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_text_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-header .iq-price' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_B2b426p9P3hRJ8sxrUTO',
            [
                'label' => __( 'Hover', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_text_hover_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-header .iq-price,
					 {{WRAPPER}} .iq-price-container.active .iq-price-header .iq-price' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'price_text_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_text_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		/*Price End*/

		/*Duration Start*/

		$this->add_control(
			'section_60rHB44IC3AdVSnFPgj7',
			[
				'label' => __( 'Duration', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_duration_text_typography',
				'label' => __( 'Duration Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-price-header .iq-price-desc,{{WRAPPER}}  .iq-price-header .iq-price small ',
			]
		);

		$this->start_controls_tabs( 'price_duration_tabs' );
		$this->start_controls_tab(
            'tabs_c5Qbq8WLv6d5307l0Uu3',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
	$this->add_control(
			'price_duration_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-header .iq-price-desc,{{WRAPPER}}  .iq-price-header .iq-price small ' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_3A639G6mPd309Rl889Yy',
            [
                'label' => __( 'Hover', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_duration_hover_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-header .iq-price-desc,
					 {{WRAPPER}} .iq-price-container:hover  .iq-price-header .iq-price small,
					 {{WRAPPER}} .iq-price-container.active .iq-price-header .iq-price-desc,
					 {{WRAPPER}} .iq-price-container.active  .iq-price-header .iq-price small ' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'price_duration_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price-desc,{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price small' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_duration_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price-desc,{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price small' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		/*Duration End*/

		/*Title Start*/

		$this->add_control(
			'section_TnSdjH5Zb7wEm8sxQVuG',
			[
				'label' => __( 'Title', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_title_text_typography',
				'label' => __( 'Title Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-price-header .iq-price-label',
			]
		);

		

		$this->start_controls_tabs( 'price_title_tabs' );
		$this->start_controls_tab(
            'tabs_09OPJST046UeIAYb1Kba',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_title_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-header .iq-price-label' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_title_background',
                'label' => __( 'Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container .iq-price-header .iq-price-label',
            ]
        );

        $this->add_control(
			'price_title_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

         $this->add_control(
			'price_title_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => [
					'price_title_has_border' => 'yes',
					],
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
						'{{WRAPPER}} .iq-price-container .iq-price-header .iq-price-label' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_title_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => [
					'price_title_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-header .iq-price-label' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .iq-price-container .iq-price-header .iq-price-label:before' => 'border-top-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_title_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => [
					'price_title_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-header .iq-price-label' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_title_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => [
					'price_title_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-header .iq-price-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_cT0eg16qd070xv7muc2b',
            [
                'label' => __( 'Hover', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_title_hover_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container:hover .iq-price-header .iq-price-label,
					 {{WRAPPER}}  .iq-price-container.active .iq-price-header .iq-price-label' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_title_hover_background',
                'label' => __( 'Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}}  .iq-price-container:hover .iq-price-header .iq-price-label,
					 {{WRAPPER}}  .iq-price-container.active .iq-price-header .iq-price-label',
            ]
        );
        $this->add_control(
			'price_title_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

         $this->add_control(
			'price_title_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => [
					'price_title_hover_has_border' => 'yes',
					],
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
						'{{WRAPPER}}  .iq-price-container:hover .iq-price-header .iq-price-label,
					 {{WRAPPER}}  .iq-price-container.active .iq-price-header .iq-price-label' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => [
					'price_title_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container:hover .iq-price-header .iq-price-label,
					{{WRAPPER}}  .iq-price-container.active .iq-price-header .iq-price-label'=> 'border-color: {{VALUE}};'
		 		],
				
				
			]
		);

		$this->add_control(
			'price_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => [
					'price_title_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container:hover .iq-price-header .iq-price-label,
					 {{WRAPPER}}  .iq-price-container.active .iq-price-header .iq-price-label' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => [
					'price_title_hover_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container:hover .iq-price-header .iq-price-label,
					 {{WRAPPER}}  .iq-price-container.active .iq-price-header .iq-price-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'price_title_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_title_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		/*Title End*/


		/*Sub Title Start*/


		$this->add_control(
			'section_cxKaO95c5CZW4Nz3w36M',
			[
				'label' => __( 'Subtitle', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_subtitle_text_typography',
				'label' => __( 'Subtitle Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-price-header .iq-price-description ',
			]
		);

		$this->start_controls_tabs( 'price_subtitle_tabs' );
		$this->start_controls_tab(
            'tabs_Fu3Wm8nztYqbbkbpSc6J',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_subtitle_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-header .iq-price-description ' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_rXQ60813pl6Rn3B1Sx9d',
            [
                'label' => __( 'Hover', 'iqonic' ),
            ]
        );
		$this->add_control(
			'price_subtitle_hover_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-header .iq-price-description ,{{WRAPPER}} .iq-price-container.active .iq-price-header .iq-price-description ' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_responsive_control(
			'price_subtitle_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_subtitle_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header .iq-price-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		/*Sub Title End*/

		/*Header Backgrund Start*/

		$this->add_control(
			'section_O75inm3q9CVk7962gh96',
			[
				'label' => __( 'Pricing Header Background', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'price_header_tabs' );
		$this->start_controls_tab(
            'tabs_5D6V6NS96w3QI6bdMU23',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_header_background',
                'label' => __( 'Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container .iq-price-header',
            ]
        );
        $this->add_control(
			'price_header_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

        $this->add_control(
			'price_header_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => [
					'price_header_has_border' => 'yes',
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
						'{{WRAPPER}} .iq-price-container .iq-price-header' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_header_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => [
					'price_header_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-header' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_header_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_header_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-header' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_header_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => [
					'price_header_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_rH655IP80scfKQz9Wnq6',
            [
                'label' => __( 'Active', 'iqonic' ),
            ]
        );
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_header_hover_background',
                'label' => __( 'Hover Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container:hover .iq-price-header,{{WRAPPER}} .iq-price-container.active .iq-price-header',
            ]
        );
        $this->add_control(
			'price_header_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
        $this->add_control(
			'price_header_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => [
					'price_header_hover_has_border' => 'yes',
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
						'{{WRAPPER}} .iq-price-container:hover .iq-price-header,{{WRAPPER}} .iq-price-container.active .iq-price-header' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_header_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'price_header_hover_has_border' => 'yes',
					],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-header,{{WRAPPER}} .iq-price-container.active .iq-price-header' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_header_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_header_hover_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-header,{{WRAPPER}} .iq-price-container.active .iq-price-header' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_header_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_header_hover_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-header,{{WRAPPER}} .iq-price-container.active .iq-price-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->end_controls_tabs();
	
		$this->add_responsive_control(
			'price_header_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_header_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
        $this->end_controls_section();

        /* Price Header End*/

        /* Price Body Start*/

        $this->start_controls_section(
			'section_Odd5qY6t9Lnb095371uS',
			[
				'label' => __( 'Price Body', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_body_text_typography',
				'label' => __( 'Body Content Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-price-container .iq-price-body',
			]
		);

		$this->start_controls_tabs( 'price_body_tabs' );
		$this->start_controls_tab(
            'tabs_K6SG9lsU9Ibb5BZHQNdf',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
        $this->add_control(
			'price_body_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-body' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_body_background',
                'label' => __( 'Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container .iq-price-body ul',
            ]
        );

		$this->add_control(
			'price_body_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

        $this->add_control(
			'price_body_border_style',
				[
					'label' => __( 'Body Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => [
					'price_body_has_border' => 'yes',
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
						'{{WRAPPER}} .iq-price-container .iq-price-body ul' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_body_border_color',
			[
				'label' => __( 'Body Border Color', 'iqonic' ),
				'condition' => [
					'price_body_has_border' => 'yes',
					],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-body ul' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_body_border_width',
			[
				'label' => __( 'Body Border Width', 'iqonic' ),
				'condition' => [
					'price_body_has_border' => 'yes',
					],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-body ul' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_body_border_radius',
			[
				'label' => __( 'Body Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_body_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-body ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_37679POVcpZ0xdBrH236',
            [
                'label' => __( 'Active', 'iqonic' ),
            ]
        );
        $this->add_control(
			'price_body_hover_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container:hover .iq-price-body, {{WRAPPER}}  .iq-price-container.active .iq-price-body' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_body_hover_background',
                'label' => __( 'Hover Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container:hover .iq-price-body ul,{{WRAPPER}} .iq-price-container.active .iq-price-body ul',
            ]
        );
        $this->add_control(
			'price_body_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
        $this->add_control(
			'price_body_hover_border_style',
				[
					'label' => __( 'Body Border Style', 'iqonic' ),
					'condition' => [
					'price_body_hover_has_border' => 'yes',
					],
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
						'{{WRAPPER}} .iq-price-container:hover .iq-price-body ul,{{WRAPPER}} .iq-price-container.active .iq-price-body ul' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_body_hover_border_color',
			[
				'label' => __( 'Body Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'price_body_hover_has_border' => 'yes',
					],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-body ul,{{WRAPPER}} .iq-price-container.active .iq-price-body ul' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_body_hover_border_width',
			[
				'label' => __( 'Body Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'price_body_hover_has_border' => 'yes',
					],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-body ul,{{WRAPPER}} .iq-price-container.active .iq-price-body ul' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_body_hover_border_radius',
			[
				'label' => __( 'Body Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'price_body_hover_has_border' => 'yes',
					],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-body ul,{{WRAPPER}} .iq-price-container.active .iq-price-body ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'price_body_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-body ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_body_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-body ul' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		/*Body End*/

		/*Pricing List Start*/

		$this->add_control(
			'section_95xiZHF76mKJ1bE9dS6u',
			[
				'label' => __( 'Pricing list', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'priceing_list_text_typography',
				'label' => __( 'Pricing List Content Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-price-container .iq-price-body ul li',
			]
		);

		$this->start_controls_tabs( 'priceing_list_tabs' );
		$this->start_controls_tab(
            'tabs_jwryR96oG27O78J6HT8b',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
        $this->add_control(
			'priceing_list_color',
			[
				'label' => __( 'Text color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-body ul li' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_control(
			'priceing_inactive_list_color',
			[
				'label' => __( 'Icon color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-body ul li.inactive i' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_85j6g91EM579Gcdx6T6b',
            [
                'label' => __( 'Disabled features', 'iqonic' ),
            ]
        );

		$this->add_control(
			'priceing_list_hover_color',
			[
				'label' => __( 'Text color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-body ul li.active' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_control(
			'priceing_active_list_color',
			[
				'label' => __( 'Icon color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-body ul li.active i' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'priceing_list_padding',
			[
				'label' => __( 'Pricing List Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-body ul li ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'priceing_list_margin',
			[
				'label' => __( 'Pricing List Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-body ul li ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);


		$this->end_controls_section();

		 /* Price Body End*/

		 /* Price footer Start End*/

        $this->start_controls_section(
			'section_fx9Nm3Z6LD6P50r9TFY8',
			[
				'label' => __( 'Price Footer', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'price_footer_tabs' );
		$this->start_controls_tab(
            'tabs_7SsC2Xby38hDba3850rm',
            [
                'label' => __( 'Normal', 'iqonic' ),
            ]
        );
        
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_footer_background',
                'label' => __( 'Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container .iq-price-footer',
            ]
        );

        $this->add_control(
			'price_footer_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

        $this->add_control(
			'price_footer_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'type' => Controls_Manager::SELECT,
					'condition' => [
					'price_footer_has_border' => 'yes',
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
						'{{WRAPPER}} .iq-price-container .iq-price-footer' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_footer_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'price_footer_has_border' => 'yes',
					],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-footer' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_footer_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_footer_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-footer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_footer_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_footer_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container .iq-price-footer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->start_controls_tab(
            'tabs_z67bhXB90O5P0cibF3U1',
            [
                'label' => __( 'Active', 'iqonic' ),
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_footer_hover_background',
                'label' => __( 'Hover Background', 'iqonic' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .iq-price-container:hover .iq-price-footer,{{WRAPPER}} .iq-price-container.active .iq-price-footer',
            ]
        );
        $this->add_control(
			'price_footer_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
        $this->add_control(
			'price_footer_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => [
					'price_footer_hover_has_border' => 'yes',
					],
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
						'{{WRAPPER}} .iq-price-container:hover .iq-price-footer,{{WRAPPER}} .iq-price-container.active .iq-price-footer' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'price_footer_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'price_footer_hover_has_border' => 'yes',
					],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-footer,{{WRAPPER}} .iq-price-container.active .iq-price-footer' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'price_footer_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_footer_hover_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-footer,{{WRAPPER}} .iq-price-container.active .iq-price-footer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'price_footer_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'price_footer_hover_has_border' => 'yes',
					],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-price-container:hover .iq-price-footer,{{WRAPPER}} .iq-price-container.active .iq-price-footer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		
		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_responsive_control(
			'price_footer_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'price_footer_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-price-container .iq-price-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);


		$this->end_controls_section();

		 /* Price Footer End*/
        

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Price/render.php';
    }
}
