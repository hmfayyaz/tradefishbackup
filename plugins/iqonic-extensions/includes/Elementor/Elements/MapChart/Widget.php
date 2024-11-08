<?php

namespace Iqonic\Elementor\Elements\MapChart;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_map_chart';
    }

    public function get_title()
    {
        return __('Iqonic Map Chart', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-google-maps';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section',
			[
				'label' => __( 'Chart Map', 'iqonic' ),
			]
        );

        $this->add_control(
			'important_note',
			[
				'label' => __( 'Important Note', 'iqonic' ),
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( '<p>To Set Location On Map You Must Get Latitute And Longitute Of 
					Location. To Get Latiutte And Logitute Please <a href="https://www.latlong.net/convert-address-to-lat-long.html">Click Here</a><p><p>Copy And Paste Lat And Long Which You Get From Link</p>', 'iqonic' ),
				'content_classes' => 'your-class',
			]
		);

		$this->add_control(
			'map_label',
			[
				'label' => __( 'Map Label', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Locations', 'iqonic' ),
				'placeholder' => __( 'Locations', 'iqonic' ),
				'label_block' => true,
			]
        );
        $this->add_control(
			'more_options',
			[
				'label' => __( 'Locations', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $repeater = new Repeater();
        $repeater->add_control(
			'title',
			[
				'label' => __( 'Title & Description', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab Title', 'iqonic' ),
				'placeholder' => __( 'Tab Title', 'iqonic' ),
				'label_block' => true,
			]
        );

    	$repeater->add_control(
			'title_tag',
			[
				'label'      => __( 'Title Tag', 'iqonic' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h2',
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


		
        $repeater->add_control(
			'latitude',
			[
				'label' => __( 'Latitude', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '20.5937', 'iqonic' ),
				'placeholder' => __( 'Latitute', 'iqonic' ),
				'label_block' => true,
			]
        );



        $repeater->add_control(
			'longitude',
			[
				'label' => __( 'Longitute', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '78.9629', 'iqonic' ),
				'placeholder' => __( 'Longitute', 'iqonic' ),
				'label_block' => true,
			]
        );

        $repeater->add_control(
			'tooltip_image',
			[
				'label' => __( 'Tooltip Image', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'has_link',
			[
				'label' => __( 'Use Box Shadow?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$repeater->add_control(
			'link_text',
			[
				'label' => __( 'Link Text', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'iqonic' ),
				'placeholder' => __( 'Click Here', 'iqonic' ),
				'label_block' => true,
				'condition' => ['has_link' => 'yes']
			]
        );

		

		$repeater->add_control(
			'link',
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
			'tabs',
			[
				'label' => __( 'Lists Items', 'iqonic' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Location', 'iqonic' ),
                        
					]
					
				],
				'title_field' => '{{{ title }}}',
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

        // Button Text Style
        $this->start_controls_section(
			'section_I16t6byeNTcAgEFvcf6M',
			[
				'label' => __( 'Map Color', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);
		$this->start_controls_tabs( '_Vena6jgqW7fdL2pK8Qm9' );

		$this->start_controls_tab(
			'tabs_kchvN2rP8xd3YpKzHuMZ',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);
		$this->add_control(
			'map_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR
				
			]
		);
		$this->end_controls_tab();		
		$this->end_controls_tabs();
		$this->end_controls_section();

        
         $this->start_controls_section(
			'section_6a36eYu7cRcL98cb2nbo',
			[
				'label' => __( 'Map Info', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_map_text_typography',
				'label' => __( 'Title Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-map-chart .iq-map-lable .iq-map-location-value',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_map_desc_typography',
				'label' => __( 'Description Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .iq-map-chart .iq-map-lable .iq-map-info',
			]
		);
		$this->start_controls_tabs( 'map_title_tabs' );
		$this->start_controls_tab(
			'tabs_6fjm8XwPMA3dI9q6Rb6T',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'map_title_color',
			[
				'label' => __( 'Choose Title Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable .iq-map-location-value' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->add_control(
			'map_desc_color',
			[
				'label' => __( 'Choose Description Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable .iq-map-info' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'map_title_background',
				'label' => __( 'Title Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-map-chart .iq-map-lable',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_map_box_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-map-chart .iq-map-lable',
			]
		);
		$this->add_control(
			'iq_map_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$this->add_control(
			'map_title_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => ['iq_map_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-map-chart .iq-map-lable ' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'map_title_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => ['iq_map_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable ' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'map_title_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => ['iq_map_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable ' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'map_title_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => ['iq_map_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_F98J5Sef5IKbc2TnqX7H',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'map_title_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable:hover .iq-map-location-value,{WRAPPER}}  .iq-map-chart .iq-map-lable .iq-map-location-value:hover' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		$this->add_control(
			'map_title_desc_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable:hover .iq-map-info, {{WRAPPER}} .iq-map-chart .iq-map-lable .iq-map-info:hover' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'map_title_hover_background',
				'label' => __( 'Title Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-map-chart .iq-map-lable:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_map_box_hover_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}} .iq-map-chart .iq-map-lable:hover',
			]
		);

		$this->add_control(
			'iq_map_block_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        ); 
		$this->add_control(
			'map_title_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => ['iq_map_block_hover_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-map-chart .iq-map-lable:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'map_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => ['iq_map_block_hover_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'map_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => ['iq_map_block_hover_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'map_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => ['iq_map_block_hover_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-map-chart .iq-map-lable:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'map_lable_width',
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
					'{{WRAPPER}} .iq-map-chart .iq-map-lable' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'map_lable_height',
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
					'{{WRAPPER}} .iq-map-chart .iq-map-lable' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'map_title_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-map-chart .iq-map-lable' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'map_title_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-map-chart .iq-map-lable' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);


         $this->end_controls_section();


          $this->start_controls_section(
			'section_mK02dEx8g1zXdN9eaWOF',
			[
				'label' => __( 'Map Tooltip', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_map_tooltip_text_typography',
				'label' => __( 'Title Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .popover .tooltip-title h5',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_map_tooltip_desc_typography',
				'label' => __( 'Description Typography', 'iqonic' ),				
				'selector' => '{{WRAPPER}} .popover .tooltip-info a',
			]
		);


		$this->add_control(
			'section_cdF6R8U8v0Oc205Etqbb',
			[
				'label' => __( 'Dot', 'iqonic' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_tooltip_dot_background',
				'label' => __( 'Map Dot', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .map-marker .pulse ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_maptooltip_dot_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '{{WRAPPER}}  .map-marker .pulse ',
			]
		);
		

		$this->add_responsive_control(
			'maptooltip_dot_width',
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
					'{{WRAPPER}} .map-marker .pulse ' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'maptooltip_dot_height',
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
					'{{WRAPPER}} .map-marker .pulse ' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'map_tooltip_tabs' );
		$this->start_controls_tab(
			'tabs_61K6FqCB6XcbDa1PbauV',
			[
				'label' => __( 'Normal', 'iqonic' ),
			]
		);

		$this->add_control(
			'map_tooltip_color',
			[
				'label' => __( 'Choose Title Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .popover .tooltip-title h5' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		$this->add_control(
			'map_tooltip_desc_color',
			[
				'label' => __( 'Choose Description Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .popover .tooltip-info a' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'map_tooltip_background',
				'label' => __( 'Title Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '  .popover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_maptooltip_box_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => '  .popover',
			]
		);
		$this->add_control(
			'iq_maptooltip_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );

		$this->add_control(
			'maptooltip_title_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => ['iq_maptooltip_block_has_border'=>['yes']],
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
						' .popover ' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'maptooltip_title_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => ['iq_maptooltip_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					' .popover ' => 'border-color: {{VALUE}};',
					' .bs-popover-auto[x-placement^=top] .arrow::before, .bs-popover-top .arrow::before ' => 'border-top-color: {{VALUE}};',
					'.bs-popover-auto[x-placement^=right] .arrow::before,.bs-popover-right .arrow::before  ' => 'border-right-color: {{VALUE}};',
					'.bs-popover-auto[x-placement^=bottom] .arrow::before,.bs-popover-bottom .arrow::before ' => 'border-bottom-color: {{VALUE}};',
					'.bs-popover-auto[x-placement^=left] .arrow::before,.bs-popover-left .arrow::before ' => 'border-left-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'map_tooltip_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => ['iq_maptooltip_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					' .popover ' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'map_tooltip_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => ['iq_maptooltip_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.popover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_9sFmCbaHd8bBSAi5rb6x',
			[
				'label' => __( 'Hover', 'iqonic' ),
			]
		);

		$this->add_control(
			'map_tooltip_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .popover:hover .tooltip-title  h5' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		$this->add_control(
			'map_tooltip_desc_hover_color',
			[
				'label' => __( 'Choose Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .popover:hover  .tooltip-info a' => 'color: {{VALUE}};',
		 		],
				
			]
		);
		

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'map_tooltip_hover_background',
				'label' => __( 'Title Hover Background', 'iqonic' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => ' .popover:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_maptooltip_box_hover_shadow',
				'label' => __( 'Box Shadow', 'iqonic' ),
				'selector' => ' .popover:hover',
			]
		);

		$this->add_control(
			'iq_maptooltip_block_hover_has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        ); 
		$this->add_control(
			'map_tooltip_hover_border_style',
				[
					'label' => __( 'Border Style', 'iqonic' ),
					'condition' => ['iq_maptooltip_block_hover_has_border'=>['yes']],
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
						' .popover:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'map_tooltip_hover_border_color',
			[
				'label' => __( 'Border Color', 'iqonic' ),
				'condition' => ['iq_maptooltip_block_hover_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					' .popover:hover' => 'border-color: {{VALUE}};',
					' .bs-popover-auto[x-placement^=top].popover:hover .arrow::before, .bs-popover-top.popover:hover .arrow::before ' => 'border-top-color: {{VALUE}};',
					'.bs-popover-auto[x-placement^=right].popover:hover .arrow::before,.bs-popover-right.popover:hover .arrow::before  ' => 'border-right-color: {{VALUE}};',
					'.bs-popover-auto[x-placement^=bottom].popover:hover .arrow::before,.bs-popover-bottom.popover:hover .arrow::before ' => 'border-bottom-color: {{VALUE}};',
					'.bs-popover-auto[x-placement^=left].popover:hover .arrow::before,.bs-popover-left.popover:hover .arrow::before ' => 'border-left-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'map_tooltip_hover_border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'condition' => ['iq_maptooltip_block_hover_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					' .popover:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'map_tooltip_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'iqonic' ),
				'condition' => ['iq_maptooltip_block_hover_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					' .popover:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	
		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'maptooltip_lable_width',
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
					' .popover ' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'maptooltip_lable_height',
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
					' .popover ' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'maptooltip_title_padding',
			[
				'label' => __( 'Padding', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					' .popover .popover-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'maptooltip_title_margin',
			[
				'label' => __( 'Margin', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					' .popover .popover-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);


         $this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/MapChart/render.php';

		if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
				callMapChart();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
