<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 

class umetric_career extends Widget_Base {

	public function get_name() {
		return __( 'Iqonic career', 'umetric' );
	}
	
	public function get_title() {
		return __( 'Iqonic Career', 'umetric' );
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
			'Section_career',
			[
				'label' => __( 'Career', 'umetric' ),
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

	$this->add_control(
			'button_title',
			[
				'label' => __( 'Button Text', 'umetric' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( 'Read More', 'umetric' ),
			]
		);

	$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'talkie' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'ion ion-record'
					
				],
			]
		);
        
        $this->end_controls_section();




        /*Career Box start*/

         $this->start_controls_section(
			'section_9S4dsPubH84ygQCK15Ow',

			[
				'label' => __( 'Career Box', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'career_tabs' );
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfv9L',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_career_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block .active-faq .row',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_career_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block',
			]
		);

		
		
		$this->add_control(
			'iq_career_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_career_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_career_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_career_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_career_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_career_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_career_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_career_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_career_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'name' => 'iq_career_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq .row',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_career_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover',
			]
		);

		


		$this->add_control(
			'iq_career_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_career_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_career_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_career_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_career_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_career_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_career_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_career_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_career_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq .row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_career_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Career box end*/


		/*Career Title start*/

         $this->start_controls_section(
			'section_titleASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Career Title', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         

         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'career_title_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title',
			]
		);

        $this->start_controls_tabs( 'career_title_tabs' );
		$this->start_controls_tab(
			'tabs_titleQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'career_title_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_career_title_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_career_title_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title',
			]
		);

		
		
		$this->add_control(
			'iq_career_title_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_career_title_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_career_title_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_career_title_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_career_title_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_career_title_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_career_title_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_career_title_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_career_title_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'career_title_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title:hover ,{{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq a.accordion-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_career_title_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title:hover , {{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq a.accordion-title',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_career_title_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title:hover , {{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq a.accordion-title',
			]
		);

		


		$this->add_control(
			'iq_career_title_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_career_title_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title:hover , {{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq a.accordion-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_career_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_career_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title:hover , {{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq a.accordion-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_career_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_career_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title:hover , {{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq a.accordion-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_career_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_career_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title:hover , {{WRAPPER}} .iq-accordion.career-style .iq-accordion-block:hover .active-faq a.accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_career_title_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_career_title_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-accordion.career-style .active-faq a.accordion-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Career Title end*/



		/*Carrer Button start*/

         $this->start_controls_section(
			'section_ReadMoreASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Carrer ReadMore Button', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'career_readmore_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-button',
			]
		);

        $this->start_controls_tabs( 'career_readmore_tabs' );
		$this->start_controls_tab(
			'tabs_readmoreQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'career_readmore_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_career_readmore_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-button ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_career_readmore_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-button',
			]
		);

		
		
		$this->add_control(
			'iq_career_readmore_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_career_readmore_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-button' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_career_readmore_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_career_readmore_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_career_readmore_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'career_readmore_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					' {{WRAPPER}} .iq-button:hover' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_career_readmore_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => ' {{WRAPPER}} .iq-button:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_career_readmore_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-button:hover',
			]
		);

		


		$this->add_control(
			'iq_career_readmore_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
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
						' {{WRAPPER}} .iq-button:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_career_readmore_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					' {{WRAPPER}} .iq-button:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_career_readmore_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					' {{WRAPPER}} .iq-button:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_career_readmore_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_career_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					' {{WRAPPER}} .iq-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_career_readmore_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-button ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_career_readmore_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-button ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Carrer Button end*/


	}
	
	
	protected function render() {
		$settings = $this->get_settings();
		require  umetric_TH_ROOT . '/inc/elementor/render/career.php';
    	}	    
		
}

Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\umetric_career() );
