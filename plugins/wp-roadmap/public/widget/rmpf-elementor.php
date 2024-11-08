<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit;

use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;

class RMPF_Elementor_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'RMPF_Elementor_Widget';
    }

    public function get_categories()
    {
        return ['wp-roadmap'];
    }

    public function get_title()
    {
        return 'Wp Roadmap';
    }

    public function get_icon()
    {
        return 'fas fa-map-signs';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'header_section',
            [
                'label' => esc_html__('Header', 'wp-roadmap'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        /** Card settings. */
        $this->add_control(
            'wp_road_map_tab_card_options',
            [
                'label' => esc_html__('Card', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'wp_road_map_card_backcolor',
            [
                'label' => esc_html__('Background Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-box' => "background-color:{{VALUE}};",
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_card_padding',
            [
                'label' => esc_html__('Card Header Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-box .header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /** Header settings. */
        $this->add_control(
            'wp_road_map_tab_title_options',
            [
                'label' => esc_html__('Tab', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'wp_road_map_tab_backcolor',
            [
                'label' => esc_html__('Background Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EFEFEF',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-box .tab-info' => "background-color:{{VALUE}};"
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_padding',
            [
                'label' => esc_html__('Tab List Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-box .tab-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_content_padding',
            [
                'label' => esc_html__('Tab Content Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 40,
                    'right' => 40,
                    'bottom' => 40,
                    'left' => 40,
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-box .tabcontent' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('wp_road_map_tab_btn_tabs');

        $this->start_controls_tab('tab_normal_btn', ['label' => esc_html__('Normal Button', 'wp-roadmap')]);

        $this->add_control(
            'wp_road_map_tab_btn_color',
            [
                'label' => esc_html__('Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .box-content ul.tab li.tablinks' => "color:{{VALUE}};"
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_btn_backcolor',
            [
                'label' => esc_html__('Background Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .box-content ul.tab li.tablinks' => "background-color:{{VALUE}};"]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('tab_active_btn', ['label' => esc_html__('Active Button', 'wp-roadmap')]);

        $this->add_control(
            'wp_road_map_tab_active_btn_color',
            [
                'label' => esc_html__('Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .box-content ul.tab li.tablinks.active' => "color:{{VALUE}};"
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_active_btn_backcolor',
            [
                'label' => esc_html__('Background Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#DCDCDC',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .box-content ul.tab li.tablinks.active' => "background-color:{{VALUE}};"]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        //Request Button effect
        $this->add_control(
            'wp_road_map_tab_Button_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'wp_road_map_tab_Button_options',
            [
                'label' => esc_html__('Request Button', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_tab_a_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .wp-roadmap .box-content  a#feature_link',
            ]
        );
        $this->add_control(
            'wp_road_map_tab_a_btn_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .box-content a#feature_link' => "color:{{VALUE}} !important;"
                ]
            ]
        );
        $this->add_control(
            'wp_road_map_tab_a_btn_backcolor',
            [
                'label' => esc_html__('Background Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#DCDCDC',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .box-content a#feature_link' => "background-color:{{VALUE}} !important;"]
            ]
        );

        $this->add_control(
            'wp_road_map_feature_btn_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .box-content a#feature_link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_feature_btn_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .box-content a#feature_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        //end

        $this->add_control(
            'wp_road_map_header_title_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /** Header settings. */
        $this->add_control(
            'wp_road_map_header_title_options',
            [
                'label' => esc_html__('Title', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_header_title_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .wp-roadmap .wp-roadmap-title',
            ]
        );

        $this->add_control(
            'wp_road_map_header_title_align',
            [
                'label' => esc_html__('Alignment', 'wp-roadmap'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => [
					'{{WRAPPER}} .wp-roadmap .wp-roadmap-title' => 'text-align: {{VALUE}};',
				],
            ]
        );

        $this->add_control(
            'wp_road_map_header_title_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .wp-roadmap-title' => "color:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_header_title_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_header_title_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_header_description_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /** Description settings. */
        $this->add_control(
            'wp_road_map_header_description_options',
            [
                'label' => esc_html__('Description', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_header_description_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .wp-roadmap .wp-roadmap-description',
            ]
        );

        $this->add_control(
            'wp_road_map_header_description_align',
            [
                'label' => esc_html__('Alignment', 'wp-roadmap'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .wp-roadmap .wp-roadmap-description' => "text-align:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_header_description_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .wp-roadmap-description' => "color:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_header_description_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_header_description_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .wp-roadmap-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'road_map_section',
            [
                'label' => esc_html__('Road Map', 'wp-roadmap'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        /** Status settings. */
        $this->add_control(
            'wp_road_map_tab_road_map_status_options',
            [
                'label' => esc_html__('Status', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_tab_road_map_status_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_3,
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '22',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ]
                ],
                'selector' => '{{WRAPPER}} .wp-roadmap .tab-roadmap li .title',
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_status_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .tab-roadmap li .title' => "color:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_status_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .tab-roadmap li .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_status_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .tab-roadmap li .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_title_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /** Task settings. */
        $this->add_control(
            'wp_road_map_tab_road_map_task_title_options',
            [
                'label' => esc_html__('Task Title', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_tab_road_map_task_title_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6',
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_title_align',
            [
                'label' => esc_html__('Alignment', 'wp-roadmap'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6' => "text-align:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_title_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6' => "color:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_title_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_title_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /** Task Id Settings. */

        $this->add_control(
            'wp_road_map_tab_road_map_task_id_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_id_options',
            [
                'label' => esc_html__('Task Id', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_tab_road_map_task_id_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6 span',
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_id_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#91A2B2',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6 span' => "color:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_id_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6 span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_road_map_task_id_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .tab-roadmap li .timeline-title h6 span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'road_map_newest_section',
            [
                'label' => esc_html__('Most Voted/Newest', 'wp-roadmap'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        /** Title settings. */
        $this->add_control(
            'wp_road_map_tab_newest_task_title_options',
            [
                'label' => esc_html__('Task Title', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_tab_newest_task_title_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' =>
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title'
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_title_align',
            [
                'label' => esc_html__('Alignment', 'wp-roadmap'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .wp-roadmap .task-list .task-title' => "text-align:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_title_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title' => "color:{{VALUE}};",
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_title_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_title_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_id_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /** Task Id Settings. */
        $this->add_control(
            'wp_road_map_tab_newest_task_id_options',
            [
                'label' => esc_html__('Task Id', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_tab_newest_task_id_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' =>
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title span'
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_id_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title span' => "color:{{VALUE}};",
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_id_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0
                ],
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_task_id_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-title span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_description_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        /** Description settings. */
        $this->add_control(
            'wp_road_map_tab_newest_description_options',
            [
                'label' => esc_html__('Description', 'wp-roadmap'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wp_road_map_tab_newest_description_typography',
                'label' => esc_html__('Typography', 'wp-roadmap'),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .wp-roadmap .task-list .task-description',
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_description_align',
            [
                'label' => esc_html__('Alignment', 'wp-roadmap'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'wp-roadmap'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .wp-roadmap .task-list .task-description' => "text-align:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_description_font_color',
            [
                'label' => esc_html__('Font Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .task-list .task-description' => "color:{{VALUE}};"]
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_description_margin',
            [
                'label' => esc_html__('Margin', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_description_padding',
            [
                'label' => esc_html__('Padding', 'wp-roadmap'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .task-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wp_road_map_tab_newest_button_options_hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wp_road_map_vote_btn_box_shadow',
                'label' => esc_html__('Button Box Shadow', 'wp-roadmap'),
                'selector' => '{{WRAPPER}} .wp-roadmap .task-list .feedback-vote-btn .wp_roadmap_add_upvote',
            ]
        );

        $this->start_controls_tabs('wp_road_map_vote_btn_tabs');

        $this->start_controls_tab('normal', ['label' => esc_html__('Normal Button', 'wp-roadmap')]);

        $this->add_control(
            'wp_road_map_vote_btn_color',
            [
                'label' => esc_html__('Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .feedback-vote-btn .wp_roadmap_add_upvote' => "color:{{VALUE}};",
                    '{{WRAPPER}} .wp-roadmap .task-list .feedback-vote-btn .wp_roadmap_add_upvote .dashicons-saved' => "color:{{VALUE}};"
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_vote_btn_backcolor',
            [
                'label' => esc_html__('Background Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .task-list .feedback-vote-btn .wp_roadmap_add_upvote' => "background-color:{{VALUE}};"]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('active', ['label' => esc_html__('Active Button', 'wp-roadmap')]);

        $this->add_control(
            'wp_road_map_vote_active_btn_color',
            [
                'label' => esc_html__('Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wp-roadmap .task-list .feedback-vote-btn .wp_roadmap_add_upvote.btn-active' => "color:{{VALUE}};",
                    '{{WRAPPER}} .wp-roadmap .task-list .feedback-vote-btn .wp_roadmap_add_upvote.btn-active .dashicons-saved' => "color:{{VALUE}};"
                ]
            ]
        );

        $this->add_control(
            'wp_road_map_vote_active_btn_backcolor',
            [
                'label' => esc_html__('Background Color', 'wp-roadmap'),
                'type' => Controls_Manager::COLOR,
                'default' => '#28a745',
                'selectors' => ['{{WRAPPER}} .wp-roadmap .task-list .feedback-vote-btn .wp_roadmap_add_upvote.btn-active' => "background-color:{{VALUE}};"]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $output = do_shortcode('[rmpf_roadmap_widget]');
        echo $output;
    }
}

Plugin::instance()->widgets_manager->register(new RMPF_Elementor_Widget());