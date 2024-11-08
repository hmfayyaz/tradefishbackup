<?php

namespace Iqonic\Elementor\Elements\Marquee_Text;

use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_marquee_text';
    }

    public function get_title()
    {
        return esc_html__('Iqonic Marquee Text', 'iqonic');
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
        $repeater_title = [
            'label'         => esc_html__('Title', 'iqonic'),
            'type'          => Controls_Manager::TEXT,
            'placeholder'   => esc_html__('Title', 'iqonic'),
            'default'       => esc_html__('Title', 'iqonic'),
            'label_block'   => true,
        ];
        $repeater_link = [
            'label'         => 'Title Link',
            'type'          => Controls_Manager::URL,
            'dynamic'       => [
                'active' => true,
            ],
            'placeholder'   => esc_html__('https://your-link.com', 'iqonic'),
            'default'       => [
                'url' => '',
            ],
        ];

        $this->start_controls_section(
            'section_marquee_style',
            [
                'label' => esc_html__('Marquee', 'iqonic'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            $repeater_title
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Items', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Title', 'iqonic'),
                    ]
                ],
                'title_field' => '{{{ title }}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_marquee_options',
            [
                'label' => esc_html__('Options', 'iqonic'),
            ]
        );
        $this->add_control(
            'title_tag',
            [
                'label'      => esc_html__('Title Tag', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'h5',
                'options'    => [

                    'h1'          => esc_html__('h1', 'iqonic'),
                    'h2'          => esc_html__('h2', 'iqonic'),
                    'h3'          => esc_html__('h3', 'iqonic'),
                    'h4'          => esc_html__('h4', 'iqonic'),
                    'h5'          => esc_html__('h5', 'iqonic'),
                    'h6'          => esc_html__('h6', 'iqonic'),
                ],
            ]
        );
        $this->add_control(
            'display_separator',
            [
                'label' => esc_html__('Display Separator?', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'set',
                'options'    => [
                    'set'   => esc_html__('Yes', 'iqonic'),
                    'unset' => esc_html__('No', 'iqonic'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .marquee-text .marquees-list li::before' => 'content: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'has_direction',
            [
                'label' => esc_html__('Direction ?', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'right',
                'options'    => [
                    'left'  => esc_html__('Left', 'iqonic'),
                    'right' => esc_html__('Right', 'iqonic'),
                ],
            ]
        );

        $this->end_controls_section();

        /* marquee Title start*/

        $this->start_controls_section(
            'section_zq808BOa6ovm3lt2xN1E',
            [
                'label' => esc_html__('Title', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_content_text_typography',
                'label' => esc_html__('Title Typography', 'iqonic'),
                'selector' => '{{WRAPPER}} .marquee-text .marquees-list .marquee-title',
            ]
        );

        $this->add_control(
            'marquee_title_color',
            [
                'label' => esc_html__('Title Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .marquee-text .marquees-list .marquee-title, {{WRAPPER}}  .umetric-marquee .umetric-marquee-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .umetric-marquee-title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'marqueebox_title_hover_color',
            [
                'label' => esc_html__('Title Hover Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .marquee-text .marquees-list .marquee-title:hover, {{WRAPPER}} .umetric-marquee .item:hover .umetric-marquee-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'marqueebox_title_padding',
            [
                'label' => esc_html__('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .marquee-text .marquees-list li, {{WRAPPER}} .umetric-marquee .umetric-marquee-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'marqueebox_title_margin',
            [
                'label' => esc_html__('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .marquee-text .marquees-list .marquee-title, {{WRAPPER}}  .umetric-marquee-blog .umetric-marquee-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        /* Marqueebox Title End*/

        /* Marqueebox line Start*/
        $this->start_controls_section(
            'section_line6ovm3lt2xN1E',
            [
                'label' => esc_html__('Circle', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label' => esc_html__('Choose Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .marquee-text .marquees-list li::before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_width',
            [
                'label' => esc_html__('Width', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
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
                    '{{WRAPPER}} .marquee-text .marquees-list li::before' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_height',
            [
                'label' => esc_html__('Height', 'iqonic'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
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
                    '{{WRAPPER}} .marquee-text .marquees-list li::before' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        /* Marqueebox line End*/
    }

    protected function render()
    {
        require 'render.php';
    }
}
