<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 

class umetric_portfolio extends Widget_Base {

	public function get_name() {
		return __( 'portfolio', 'umetric' );
	}
	
	public function get_title() {
		return __( 'Portfolio', 'umetric' );
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
			'Section_Portfolio',
			[
				'label' => __( 'Portfolio Post', 'umetric' ),
			]
		);

        $this->add_control(
			'portfolio_type',
			[
				'label'      => __( 'Portfolio Type', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'1'          => __( 'Slider', 'umetric' ),
					'2'          => __( 'Gride', 'umetric' ),
				],
				'default'    => '2',
			]
		);

		$this->add_control(
			'portfolio_style',
			[
				'label'      => __( 'Portfolio Style', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'condition' => [
					'portfolio_type' => '2',
				],
				'options'    => [
					'2'          => __( 'Portfolio 2 Columns', 'umetric' ),
					'3'          => __( 'Portfolio 3 Columns', 'umetric' ),
					'4'          => __( 'Portfolio 4 Columns', 'umetric' ),
					'5'          => __( 'Portfolio 5 Columns', 'umetric' ),
				],
				'default'    => '2',
			]
		);

		$this->add_control(
			'number_post',
			[
				'label' => __( 'Number Of Portfolio', 'umetric' ),
				'condition' => [
					'portfolio_type' => '2',
				],
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'    => '-1',
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'HTML Tag', 'umetric' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'desk_number',
			[
				'label' => __( 'Desktop view', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'portfolio_type' => '1',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'lap_number',
			[
				'label' => __( 'Laptop view', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'portfolio_type' => '1',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'tab_number',
			[
				'label' => __( 'Tablet view', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'portfolio_type' => '1',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'mob_number',
			[
				'label' => __( 'Mobile view', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'portfolio_type' => '1',
				],
				'label_block' => true,
			]
		);	

		$this->add_control(
			'loop',
			[
				'label'      => __( 'Loop', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'umetric' ),
					'false'      => __( 'False', 'umetric' ),
					
				],
				'condition' => [
					'portfolio_type' => '1',
				]
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label'      => __( 'Autoplay', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'umetric' ),
					'false'      => __( 'False', 'umetric' ),
					
				],
				'condition' => [
					'blog_style' => '1',
				]
			]
		);

		$this->add_control(
			'dots',
			[
				'label'      => __( 'Dots', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'umetric' ),
					'false'      => __( 'False', 'umetric' ),
					
				],
				'condition' => [
					'portfolio_type' => '1',
				]
			]
		);

		$this->add_control(
			'nav-arrow',
			[
				'label'      => __( 'Arrow', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'umetric' ),
					'false'      => __( 'False', 'umetric' ),
					
				],
				'condition' => [
					'portfolio_type' => '1',
				]
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::SLIDER,
				
				'condition' => [
					'portfolio_type' => '1',
				]
				
			]
		);

		$this->add_control(
			'dis_tabs',
			[
				'label' => __( 'Disable Tab', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'umetric' ),
				'condition' => [
					'portfolio_type' => '2',
				],
				'no' => __( 'no', 'umetric' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'space',
			[
				'label' => __( 'Space', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'condition' => [
					'portfolio_type' => '2',
				],
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order By', 'umetric' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
						'DESC' => esc_html__('Descending', 'umetric'), 
						'ASC' => esc_html__('Ascending', 'umetric') 
				],

			]
		);
        
        $this->end_controls_section();

        /*Portfolio Tab start*/

         $this->start_controls_section(
			'section_tabASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Portfolio Tab', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        
         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfoliobox_tabs_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}}  .isotope-filters button',
			]
		);

        $this->start_controls_tabs( 'portfoliobox_tabs_tabs' );
		$this->start_controls_tab(
			'tabs_tabsQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_tabs_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .isotope-filters button ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}}  .isotope-filters button',
			]
		);

		
		
		$this->add_control(
			'iq_portfoliobox_tabs_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_portfoliobox_tabs_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}}  .isotope-filters button' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_portfoliobox_tabs_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_tabsf34OqKF8Xcsadseo9l3h4jUwHasaSSA',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_tabs_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .isotope-filters button.active,{{WRAPPER}} .isotope-filters button:hover' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .isotope-filters button.active,{{WRAPPER}} .isotope-filters button:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_tabs_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .isotope-filters button.active,{{WRAPPER}} .isotope-filters button:hover',
			]
		);

		


		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}}  .isotope-filters button:hover , {{WRAPPER}} .isotope-filters button.active' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button:hover , {{WRAPPER}} .isotope-filters button.active' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button:hover, {{WRAPPER}} .isotope-filters button.active' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_tabs_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_portfoliobox_tabs_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .isotope-filters button:hover,{{WRAPPER}} .isotope-filters button.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_portfoliobox_tabs_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .isotope-filters button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_portfoliobox_tabs_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .isotope-filters button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Portfolio Tab end*/




           /*Portfolio Box start*/

         $this->start_controls_section(
			'section_9S4dsPubH84ygQCK15Ow',

			[
				'label' => __( 'Portfolio Box', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'portfoliobox_tabs' );
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfv9L',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq-portfolio_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio ',
			]
		);

		$this->add_control(
			'section_portfoliobeforeQW232eM71xZP3pdAfv9',
			[
				'label' => __( 'Before Background ', 'umetric' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq-portfolio_box_before_background',
				'label' => __( 'Before Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio a.iq-portfolio-img:before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq-portfolio_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-portfolio',
			]
		);

		
		
		$this->add_control(
			'iq-portfolio_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq-portfolio_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq-portfolio_block_has_border'=>['yes']],
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-portfolio' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq-portfolio_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq-portfolio_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq-portfolio_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq-portfolio_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq-portfolio_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq-portfolio_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_f34OqKF8Xeo9l3h4jUwH',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq-portfolio_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq-portfolio_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-portfolio:hover',
			]
		);

		


		$this->add_control(
			'iq-portfolio_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq-portfolio_block_has_border'=>['yes']],
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-portfolio:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq-portfolio_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq-portfolio_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq-portfolio_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq-portfolio_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq-portfolio_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq-portfolio_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq-portfolio_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq-portfolio_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Portfolio box end*/


		/* Portfolio Details Start */



         $this->start_controls_section(
			'section_9dsdS4dsPubH84ygQCdsadsads',

			[
				'label' => __( 'Portfolio Details Box', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'iq_portfoliobox_details_tabs' );
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfv9Ldasdsad',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_details_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio .iq-portfolio-content ',
			]
		);

		

		
		
		$this->add_control(
			'iq_portfoliobox_details_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_portfoliobox_details_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-portfolio .iq-portfolio-content' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_portfoliobox_details_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_details_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_details_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_f34OqKF8Xeo9l3h4jUwHadsadsa',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_details_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content',
			]
		);
		
		
		


		$this->add_control(
			'iq_portfoliobox_details_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_portfoliobox_details_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_details_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_details_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_portfoliobox_details_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_portfoliobox_details_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_portfoliobox_details_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Portfolio Details End */

		/*Portfolio Title start*/

         $this->start_controls_section(
			'section_titlesASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Portfolio Title', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        
         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfoliobox_title_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color',
			]
		);

        $this->start_controls_tabs( 'portfoliobox_title_tabs' );
		$this->start_controls_tab(
			'tabs_titleQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_title_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_title_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_title_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color',
			]
		);

		
		
		$this->add_control(
			'iq_portfoliobox_title_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_portfoliobox_title_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_portfoliobox_title_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_title_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_title_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio .iq-portfolio-content a,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_titlef34OqKF8Xcsadseo9l3h4jUwHasaSSA',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_title_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio:hover .iq-portfolio-content a .link-color,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color:hover' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_title_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content a .link-color,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_title_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content a .link-color,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color:hover',
			]
		);

		


		$this->add_control(
			'iq_portfoliobox_title_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}}  .iq-portfolio:hover .iq-portfolio-content a .link-color,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_portfoliobox_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio:hover .iq-portfolio-content a .link-color,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio:hover .iq-portfolio-content a .link-color,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_portfoliobox_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}  .iq-portfolio:hover .iq-portfolio-content a .link-color,{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_portfoliobox_title_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_portfoliobox_title_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .link-color' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Portfolio Title end*/

		/*Portfolio Description start*/

         $this->start_controls_section(
			'section_portfolioDescriptionASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Portfolio Description', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfoliobox_description_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc',
			]
		);

       	$this->start_controls_tabs( 'portfoliobox_description_tabs' );
		$this->start_controls_tab(
			'tabs_titlejjksflnklljnn',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_description_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_description_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_description_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc',
			]
		);

		
		
		$this->add_control(
			'iq_portfoliobox_description_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_portfoliobox_description_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_portfoliobox_description_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_description_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_description_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_descriptionf34OqKF8Xcsadseo9l3h4jUwHasaSSA',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_description_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content .iq-portfolio-desc' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_description_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content .iq-portfolio-desc',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_description_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}}.iq-portfolio:hover .iq-portfolio-content .iq-portfolio-desc',
			]
		);

		


		$this->add_control(
			'iq_portfoliobox_description_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content .iq-portfolio-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_portfoliobox_description_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content .iq-portfolio-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_description_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content .iq-portfolio-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_description_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_portfoliobox_description_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .iq-portfolio-content .iq-portfolio-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_portfoliobox_description_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_portfoliobox_description_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio .iq-portfolio-content .iq-portfolio-desc ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Portfolio Description end*/

		/*Portfolio Button start*/

         $this->start_controls_section(
			'section_ReadMoreASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Portfolio link Button', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         $this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'umetric' ),
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
					'{{WRAPPER}} .portfolio-link .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfoliobox_readmore_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .portfolio-link .icon',
			]
		);

        $this->start_controls_tabs( 'portfoliobox_readmore_tabs' );
		$this->start_controls_tab(
			'tabs_readmoreQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_readmore_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .portfolio-link .icon' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_readmore_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .portfolio-link .icon ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_readmore_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .portfolio-link .icon',
			]
		);

		
		
		$this->add_control(
			'iq_portfoliobox_readmore_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_portfoliobox_readmore_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .portfolio-link .icon' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_portfoliobox_readmore_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .portfolio-link .icon' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_readmore_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-link .icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_readmore_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-link .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_readmoref34OqKF8Xcsadseo9l3h4jUwHasaSSA',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		$this->add_control(
			'portfoliobox_readmore_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .portfolio-link .icon, {{WRAPPER}} .portfolio-link .icon:hover' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_portfoliobox_readmore_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-portfolio:hover .portfolio-link .icon, {{WRAPPER}} .portfolio-link .icon:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_portfoliobox_readmore_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}}.iq-portfolio:hover .portfolio-link .icon',
			]
		);

		


		$this->add_control(
			'iq_portfoliobox_readmore_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'solid'  => __( 'Solid', 'umetric' ),
						'dashed' => __( 'Dashed', 'umetric' ),
						'dotted' => __( 'Dotted', 'umetric' ),
						'double' => __( 'Double', 'umetric' ),
						'outset' => __( 'outset', 'umetric' ),
						'groove' => __( 'groove', 'umetric' ),
						'ridge' => __( 'ridge', 'umetric' ),
						'inset' => __( 'inset', 'umetric' ),
						'hidden' => __( 'hidden', 'umetric' ),
						'none' => __( 'none', 'umetric' ),
						
					],
					
					'selectors' => [
						'{{WRAPPER}} .iq-portfolio:hover .portfolio-link .icon, {{WRAPPER}} .portfolio-link .icon:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_portfoliobox_readmore_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .portfolio-link .icon, {{WRAPPER}} .portfolio-link .icon:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_readmore_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .portfolio-link .icon, {{WRAPPER}} .portfolio-link .icon:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_portfoliobox_readmore_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_portfoliobox_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-portfolio:hover .portfolio-link .icon, {{WRAPPER}} .portfolio-link .icon:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => __( 'Width', 'umetric' ),
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
					'{{WRAPPER}} .portfolio-link .icon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'icon_height',
			[
				'label' => __( 'Height', 'umetric' ),
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
					' {{WRAPPER}} .portfolio-link .icon' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .portfolio-link .icon i' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'iq_portfoliobox_readmore_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-link .icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_portfoliobox_readmore_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-link .icon ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Portfolio Button end*/


	}
	
	
	protected function render() {
		$settings = $this->get_settings();
		require  umetric_TH_ROOT . '/inc/elementor/render/portfolio.php';
		if ( Plugin::$instance->editor->is_edit_mode() ) :
	?>
		<script>	

		jQuery('.owl-carousel').each(function() {
                    
                    var jQuerycarousel = jQuery(this);
                    jQuerycarousel.owlCarousel({
                        items: jQuerycarousel.data("items"),                        
                        loop: jQuerycarousel.data("loop"),
                        margin: jQuerycarousel.data("margin"),
                        nav: jQuerycarousel.data("nav"),
                        dots: jQuerycarousel.data("dots"),
                        autoplay: jQuerycarousel.data("autoplay"),
                        autoplayTimeout: jQuerycarousel.data("autoplay-timeout"),
                        navText: ["<i class='fa fa-angle-left fa-2x'></i>", "<i class='fa fa-angle-right fa-2x'></i>"],
                        responsiveClass: true,
                        responsive: {
                            // breakpoint from 0 up
                            0: {
                                items: jQuerycarousel.data("items-mobile-sm"),
                                nav: false,
                                dots: true
                            },
                            // breakpoint from 480 up
                            480: {
                                items: jQuerycarousel.data("items-mobile"),
                                nav: false,
                                dots: true
                            },
                            // breakpoint from 786 up
                            786: {
                                items: jQuerycarousel.data("items-tab")
                            },
                            // breakpoint from 1023 up
                            1023: {
                                items: jQuerycarousel.data("items-laptop")
                            },
                            1199: {
                                items: jQuerycarousel.data("items")
                            }
                        }
                    });
                });

		/*------------------------
		Isotope
		--------------------------*/
		jQuery('.isotope').isotope({
			itemSelector: '.iq-grid-item',
		});

		/*------------------------------
		filter items on button click
		-------------------------------*/
		jQuery('.isotope-filters').on('click', 'button', function() {
			var filterValue = jQuery(this).attr('data-filter');
			jQuery('.isotope').isotope({
				resizable: true,
				filter: filterValue
			});
			jQuery('.isotope-filters button').removeClass('active');
			jQuery(this).addClass('active');
		});


		/*------------------------
		Masonry
		--------------------------*/
		var jQuerymsnry = jQuery('.iq-masonry-block .iq-masonry');
		if (jQuerymsnry) {
			var jQueryfilter = jQuery('.iq-masonry-block .isotope-filters');
			jQuerymsnry.isotope({
				percentPosition: true,
				resizable: true,
				itemSelector: '.iq-masonry-block .iq-masonry-item',
				masonry: {
					gutterWidth: 0
				}
			});
			// bind filter button click
			jQueryfilter.on('click', 'button', function() {
				var filterValue = jQuery(this).attr('data-filter');
				jQuerymsnry.isotope({
					filter: filterValue
				});
			});

			jQueryfilter.each(function(i, buttonGroup) {
				var jQuerybuttonGroup = jQuery(buttonGroup);
				jQuerybuttonGroup.on('click', 'button', function() {
					jQuerybuttonGroup.find('.active').removeClass('active');
					jQuery(this).addClass('active');
				});
			});
		}
		</script>

	<?php endif; 
    }	    
		
}

Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\umetric_portfolio() );