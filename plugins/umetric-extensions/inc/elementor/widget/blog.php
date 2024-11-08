<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 

/**
 * Elementor Blog widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */

class umetric_Blog extends Widget_Base {
	
	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */

	public function get_name() {
		return __( 'umetric_blog', 'umetric' );
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	
	public function get_title() {
		return __( 'Blog', 'umetric' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */

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
		return 'eicon-slider-push';
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */

	protected function register_controls() {
		$this->start_controls_section(
			'section_blog',
			[
				'label' => __( 'Blog Post', 'umetric' ),
				
			]
		);

		$this->add_control(
			'blog_type',
			[
				'label'      => __( 'Blog Style', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					
					'1'          => __( 'Blog Slider', 'umetric' ),
					'2'          => __( 'Blog Gride', 'umetric' ),
				],
			]
		);

        $this->add_control(
			'blog_style',
			[
				'label'      => __( 'Blog Style', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'condition' => [
					'blog_type' => '2',
				],
				'options'    => [
					'2'          => __( 'Blog 1 Columns', 'umetric' ),
					'3'          => __( 'Blog 2 Columns', 'umetric' ),
					'4'          => __( 'Blog 3 Columns', 'umetric' ),
				],
				'default'    => '1',
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
					'blog_type' => '1',
				],
				'label_block' => true,
				'default'    => '3',
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
					'blog_type' => '1',
				],
				'label_block' => true,
				'default'    => '3',
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
					'blog_type' => '1',
				],
				'label_block' => true,
				'default'    => '2',
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
					'blog_type' => '1',
				],
				'label_block' => true,
				'default'    => '1',
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
					'blog_type' => '1',
				]
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
					'blog_type' => '1',
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
					'blog_type' => '1',
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
					'blog_type' => '1',
				]
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::SLIDER,
				
				'condition' => [
					'blog_type' => '1',
				]
				
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
		
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'umetric' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'text-left' => [
						'title' => __( 'Left', 'umetric' ),
						'icon' => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => __( 'Center', 'umetric' ),
						'icon' => 'eicon-text-align-center',
					],
					'text-right' => [
						'title' => __( 'Right', 'umetric' ),
						'icon' => 'eicon-text-align-right',
					],
					'text-justify' => [
						'title' => __( 'Justified', 'umetric' ),
						'icon' => 'eicon-text-align-justify',
					],
				]
			]
		);

		
        $this->end_controls_section();

        
        /*Blog Box start*/

         $this->start_controls_section(
			'section_9S4dsPubH84ygQCK15Ow',

			[
				'label' => __( 'Blog Box', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'blogbox_tabs' );
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfv9L',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box',
			]
		);

		
		
		$this->add_control(
			'iq_blogbox_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_blogbox_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_blogbox_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_blogbox_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_blogbox_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'name' => 'iq_blogbox_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box:hover',
			]
		);

		


		$this->add_control(
			'iq_blogbox_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_blogbox_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_blogbox_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_blogbox_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_blogbox_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_blogbox_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_blogbox_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_blogbox_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Blog box end*/

		/* Blog Details Start */



         $this->start_controls_section(
			'section_9S4dsPubH84ygQCdsadsads',

			[
				'label' => __( 'Blog Details Box', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'blogboxdetails_tabs' );
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfv9Ldasdsad',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_details_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-detail ',
			]
		);

		

		
		
		$this->add_control(
			'iq_blogbox_details_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_blogbox_details_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box .iq-blog-detail' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_blogbox_details_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_details_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_details_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'name' => 'iq_blogbox_details_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail',
			]
		);
		
		
		


		$this->add_control(
			'iq_blogbox_details_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_blogbox_details_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_details_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_details_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_blogbox_details_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_blogbox_details_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_blogbox_details_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Blog Details End */


		/*Blog Tag start*/

         $this->start_controls_section(
			'section_ASDADSASDubH84ygQCK15Ow',

			[
				'label' => __( 'Blog Tag', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'blogbox_tag_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-blog-box  .iq-blogtag li a',
			]
		);

        $this->start_controls_tabs( 'blogbox_tag_tabs' );
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'blogbox_tag_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blogtag li a' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_tag_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box  .iq-blogtag li a ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_tag_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box  .iq-blogtag li a',
			]
		);

		
		
		$this->add_control(
			'iq_blogbox_tag_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_blogbox_tag_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box  .iq-blogtag li a' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_blogbox_tag_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blogtag li a' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_tag_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blogtag li a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_tag_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blogtag li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_f34OqKF8Xeo9l3h4jUwHasaSSA',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		$this->add_control(
			'blogbox_tag_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blogtag li a:hover' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_tag_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blogtag li a:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_tag_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blogtag li a:hover',
			]
		);

		


		$this->add_control(
			'iq_blogbox_tag_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box .iq-blogtag li a:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_blogbox_tag_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blogtag li a:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_tag_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blogtag li a:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_tag_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_blogbox_tag_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blogtag li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_blogbox_tag_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blogtag li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_blogbox_tag_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blogtag li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Blog tag end*/



		/*Blog Meta start*/

         $this->start_controls_section(
			'section_metaASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Blog Meta', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'blogbox_meta_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a ,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a',
			]
		);

        $this->start_controls_tabs( 'blogbox_meta_tabs' );
		$this->start_controls_tab(
			'tabs_QW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'blogbox_meta_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a ,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_meta_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a ,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_meta_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a, {{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a',
			]
		);

		
		
		$this->add_control(
			'iq_blogbox_meta_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_blogbox_meta_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a, {{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_blogbox_meta_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a ,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_meta_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a ,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_meta_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_f34OqKF8Xcsadseo9l3h4jUwHasaSSA',
			[
				'label' => __( 'Hover', 'umetric' ),
			]
		);

		$this->add_control(
			'blogbox_meta_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box  .iq-blog-meta li a:hover ,{{WRAPPER}} .iq-blog-box:hover  .iq-blog-meta li a, {{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a:hover,{{WRAPPER}} .owl-carousel .iq-blog-box:hover  .iq-blog-meta li a ' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_meta_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-meta li a:hover ,{{WRAPPER}} .iq-blog-box:hover  .iq-blog-meta li a,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a:hover,{{WRAPPER}} .owl-carousel .iq-blog-box:hover  .iq-blog-meta li a',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_meta_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-meta li a:hover ,{{WRAPPER}} .iq-blog-box:hover  .iq-blog-meta li a,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a:hover,{{WRAPPER}} .owl-carousel .iq-blog-box:hover  .iq-blog-meta li a',
			]
		);

		


		$this->add_control(
			'iq_blogbox_meta_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box .iq-blog-meta li a:hover, {{WRAPPER}} .iq-blog-box:hover  .iq-blog-meta li a, {{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a:hover,{{WRAPPER}} .owl-carousel .iq-blog-box:hover  .iq-blog-meta li a' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_blogbox_meta_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-meta li a:hover ,{{WRAPPER}} .iq-blog-box:hover  .iq-blog-meta li a,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a:hover,{{WRAPPER}} .owl-carousel .iq-blog-box:hover  .iq-blog-meta li a' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_meta_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-meta li a:hover , {{WRAPPER}} .iq-blog-box:hover  .iq-blog-meta li a,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a:hover,{{WRAPPER}} .owl-carousel .iq-blog-box:hover  .iq-blog-meta li a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_meta_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_blogbox_meta_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-meta li a:hover , {{WRAPPER}} .iq-blog-box:hover  .iq-blog-meta li a,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a:hover,{{WRAPPER}} .owl-carousel .iq-blog-box:hover  .iq-blog-meta li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_blogbox_meta_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-meta li a,{{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_blogbox_meta_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-meta li,  {{WRAPPER}} .owl-carousel .iq-blog-box  .iq-blog-meta li ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Blog tag end*/


		/*Blog Title start*/

        $this->start_controls_section(
			'section_titleASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Blog Title', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         $this->add_control(
			'title_tag',
			[
				'label'      => __( 'Title Tag', 'umetric' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'h4',
				'options'    => [
					
					'h1'          => __( 'h1', 'umetric' ),
					'h2'          => __( 'h2', 'umetric' ),
					'h3'          => __( 'h3', 'umetric' ),
					'h4'          => __( 'h4', 'umetric' ),
					'h5'          => __( 'h5', 'umetric' ),
					'h6'          => __( 'h6', 'umetric' ),
					
					
				],
			]
		);

         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'blogbox_title_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title',
			]
		);

        $this->start_controls_tabs( 'blogbox_title_tabs' );
		$this->start_controls_tab(
			'tabs_titleQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'blogbox_title_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_title_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_title_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title',
			]
		);

		
		
		$this->add_control(
			'iq_blogbox_title_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_blogbox_title_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_blogbox_title_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_title_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_title_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a,{{WRAPPER}} .iq-blog-box .blog-title a .iq-blog-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'blogbox_title_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a:hover , {{WRAPPER}} .iq-blog-box:hover  .blog-title a .iq-blog-title' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_title_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-title a:hover , {{WRAPPER}} .iq-blog-box:hover  .blog-title a .iq-blog-title',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_title_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-title a:hover , {{WRAPPER}} .iq-blog-box:hover  .blog-title a .iq-blog-title',
			]
		);

		


		$this->add_control(
			'iq_blogbox_title_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box .blog-title a:hover , {{WRAPPER}} .iq-blog-box:hover  .blog-title a .iq-blog-title' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_blogbox_title_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a:hover , {{WRAPPER}} .iq-blog-box:hover  .blog-title a .iq-blog-title' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_title_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a:hover , {{WRAPPER}} .iq-blog-box:hover  .blog-title a .iq-blog-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_title_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_blogbox_title_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a:hover , {{WRAPPER}} .iq-blog-box:hover  .blog-title a .iq-blog-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_blogbox_title_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_blogbox_title_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-title a ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Blog Title end*/

		/*Blog Description start*/

         $this->start_controls_section(
			'section_DescriptionASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Blog Description', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'blogbox_description_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc',
			]
		);

        $this->start_controls_tabs( 'blogbox_description_tabs' );
		$this->start_controls_tab(
			'tabs_descriptionQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'blogbox_description_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_description_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_description_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc',
			]
		);

		
		
		$this->add_control(
			'iq_blogbox_description_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_blogbox_description_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_blogbox_description_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_description_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_description_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'blogbox_description_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail .iq-blog-desc' => 'color: {{VALUE}};',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_description_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail .iq-blog-desc',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_description_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}}.iq-blog-box:hover .iq-blog-detail .iq-blog-desc',
			]
		);

		


		$this->add_control(
			'iq_blogbox_description_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail .iq-blog-desc' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_blogbox_description_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail .iq-blog-desc' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_description_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail .iq-blog-desc' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_description_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_blogbox_description_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .iq-blog-detail .iq-blog-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_blogbox_description_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_blogbox_description_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .iq-blog-detail .iq-blog-desc ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Blog Description end*/


		/*Blog Button start*/

         $this->start_controls_section(
			'section_ReadMoreASDADSAdfsdfSDubH84ygQCK15Ow',

			[
				'label' => __( 'Blog ReadMore Button', 'umetric' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'blogbox_readmore_text_typography',
				'label' => __( 'Typography', 'umetric' ),				
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-button .button-link',
			]
		);

        $this->start_controls_tabs( 'blogbox_readmore_tabs' );
		$this->start_controls_tab(
			'tabs_readmoreQW232eM71xZP3pdAfzccsdfv9LDSADSAD',
			[
				'label' => __( 'Normal', 'umetric' ),
			]
		);

		$this->add_control(
			'blogbox_readmore_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-button .button-link' => 'color: {{VALUE}} !important;',
		 		],
				
			]
			
		);

		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_readmore_background',
				'label' => __( 'Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-button .button-link ',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_readmore_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box .blog-button .button-link',
			]
		);

		
		
		$this->add_control(
			'iq_blogbox_readmore_block_has_border',
			[
				'label' => __( 'Set Custom Border?', 'umetric' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'umetric' ),
				'no' => __( 'no', 'umetric' ),
			]
        );

		$this->add_control(
			'iq_blogbox_readmore_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'type' => Controls_Manager::SELECT,
					'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box .blog-button .button-link' => 'border-style: {{VALUE}};',
						
					],
				]
		);
			
		$this->add_control(
			'iq_blogbox_readmore_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-button .button-link' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_readmore_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-button .button-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_readmore_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-button .button-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'blogbox_readmore_hover_color',
			[
				'label' => __( 'Color', 'umetric' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .blog-button .button-link, {{WRAPPER}} .iq-blog-box .blog-button .button-link:hover' => 'color: {{VALUE}} !important;',
		 		],
				
			]
			
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iq_blogbox_readmore_hover_background',
				'label' => __( 'Hover Background', 'umetric' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .iq-blog-box:hover .blog-button .button-link, {{WRAPPER}} .iq-blog-box .blog-button .button-link:hover',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_blogbox_readmore_hover_box_shadow',
				'label' => __( 'Box Shadow', 'umetric' ),
				'selector' => '{{WRAPPER}} .iq-blog-box:hover .blog-button .button-link',
			]
		);

		


		$this->add_control(
			'iq_blogbox_readmore_hover_border_style',
				[
					'label' => __( 'Border Style', 'umetric' ),
					'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
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
						'{{WRAPPER}} .iq-blog-box:hover .blog-button .button-link, {{WRAPPER}} .iq-blog-box .blog-button .button-link:hover' => 'border-style: {{VALUE}};',
						
					],
				]
		);

		$this->add_control(
			'iq_blogbox_readmore_hover_border_color',
			[
				'label' => __( 'Border Color', 'umetric' ),
				'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .blog-button .button-link, {{WRAPPER}} .iq-blog-box .blog-button .button-link:hover' => 'border-color: {{VALUE}};',
		 		],
				
				
			]
		);

		$this->add_control(
			'iq_blogbox_readmore_hover_border_width',
			[
				'label' => __( 'Border Width', 'umetric' ),
				'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .blog-button .button-link, {{WRAPPER}} .iq-blog-box .blog-button .button-link:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'iq_blogbox_readmore_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'umetric' ),
				'condition' => ['iq_blogbox_readmore_block_has_border'=>['yes']],
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box:hover .blog-button .button-link, {{WRAPPER}} .iq-blog-box .blog-button .button-link:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);		

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'iq_blogbox_readmore_padding',
			[
				'label' => __( 'Padding', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-button .button-link ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'iq_blogbox_readmore_margin',
			[
				'label' => __( 'Margin', 'umetric' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iq-blog-box .blog-button .button-link ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);	


         $this->end_controls_section();

		/* Blog Button end*/


	}
	/**
	 * Render Blog widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	
	protected function render() {
		
		require  umetric_TH_ROOT . '/inc/elementor/render/blog.php';
		
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

		</script>


		
		<?php endif; 
    }	    
		
}

Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\umetric_Blog() );
