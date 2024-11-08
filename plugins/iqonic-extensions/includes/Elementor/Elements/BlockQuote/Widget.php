<?php

namespace Iqonic\Elementor\Elements\BlockQuote;

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
        return 'Iqonic Blockquote';
    }

    public function get_title()
    {
        return __('Iqonic Blockquote', 'iqonic');
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
			'section',
			[
				'label' => __( 'Blockquote', 'iqonic' ),
			]
		);
		
		$this->add_control(
			'quote',
			[
				'label' => __( 'Quote', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter Quotes', 'iqonic' ),
				
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
				'placeholder' => __( 'Enter Title Description', 'iqonic' ),
				'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'iqonic' ),
			]
        );
        
        $this->add_control(
			'author',
			[
				'label' => __( 'BY', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
                'default' => __( 'author', 'iqonic' ),
			]
        );
        
        $this->add_control(
			'source_url',
			[
				'label' => __( 'Source Url', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
                'default' => __( 'htttp://www.example.com/index.html', 'iqonic' ),
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
		
		$this->start_controls_section(
			'section_lBaZ74xe1tn1D22',
			[
				'label' => __( 'Background', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'quote_back_color',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blockquote blockquote',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_a61HD4spSNeY01xqa1eb',
			[
				'label' => __( 'Description', 'iqonic' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'symbol_color',
			[
				'label' => __( 'Symbol Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blockquote blockquote .iq-symbol' => 'color: {{VALUE}};',
					
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
			'text_color',
			[
				'label' => __( 'Text Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blockquote blockquote .iq-quote' => 'color: {{VALUE}};',
					
				],			
				
			]
		);

 		$this->end_controls_section();
			$this->start_controls_section(
				'section_Rvk5ahx241N704uCeM7Q',
				[
					'label' => __( 'Author', 'iqonic' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
			'author_color',
			[
				'label' => __( 'Author Text Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blockquote blockquote .iq-blockquote-author cite' => 'color: {{VALUE}};',
					
				],			
				
			]
		);

		

       
        $this->end_controls_section();

        $this->start_controls_section(
			'section_border_style',
			[
				'label' => __( 'Border', 'iqonic' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				
			]
		);

		$this->add_control(
			'has_border',
			[
				'label' => __( 'Set Custom Border?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        );
        $this->add_control(
			'border_style',
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
					'condition' => [
					'has_border' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .iq-blockquote blockquote' => 'border-style: {{VALUE}};',
						
					],
				]
			);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blockquote blockquote' => 'border-color: {{VALUE}};',
					
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		
		
		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blockquote blockquote' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border radius', 'iqonic' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blockquote blockquote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'has_border' => 'yes',
				],
			]
		);

		$this->end_controls_section();


    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/BlockQuote/render.php';
    }
}
