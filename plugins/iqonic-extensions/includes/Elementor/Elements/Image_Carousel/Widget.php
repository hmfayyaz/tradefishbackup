<?php

namespace Iqonic\Elementor\Elements\Image_Carousel;

use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iqonic_image_carousel';
    }

    public function get_title()
    {
        return __('Iqonic Image Carousel', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return ' eicon-slider-push';
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section',
            [
                'label' => __('Iqonic Image Carousel', 'iqonic'),
            ]
        );

        //repeater for static slider
        $repeater = new Repeater();

        $repeater->add_control(
            'img_car_title',
            [
                'label' => __('Title', 'iqonic'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Floyd Miles', 'iqonic'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'img_car_image',
            [
                'label' => __('Choose Image', 'iqonic'),
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
            'link_type',
            [
                'label' => __('Link Type', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dynamic',
                'options' => [
                    'dynamic' => __('Dynamic', 'iqonic'),
                    'custom' => __('Custom', 'iqonic'),
                ],
            ]
        );

        $repeater->add_control(
            'dynamic_link',
            [
                'label' => esc_html__('Select Page', 'iqonic'),
                'type' => Controls_Manager::SELECT,
                'return_value' => 'true',
                'multiple' => true,
                'condition' => [
                    'link_type' => 'dynamic',
                ],
                'options' => iqonic_get_posts("page"),
            ]
        );

        $repeater->add_control(
            'open_dynamic_link_in',
            [
                'label'         => esc_html__('Open in new window', 'iqonic'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('yes', 'iqonic'),
                'label_off'     => esc_html__('Hide', 'iqonic'),
                'return_value'  => true,
                'default'       => true,
                'condition'     => [
                    'link_type' => 'dynamic',
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'iqonic'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'iqonic'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'link_type' => 'custom',
                ]
            ]
        );

        $this->add_control(
            'img_car_list',
            [
                'label' => __('Image List', 'iqonic'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'img_car_title' => __('Floyd Miles', 'iqonic'),
                    ],
                    [
                        'img_car_title' => __('Richard Villiom', 'iqonic'),
                    ],
                    [
                        'img_car_title' => __('Denver Mark', 'iqonic'),
                    ],
                ],
                'title_field' => '{{{ img_car_title }}}',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'      => __('Title Tag', 'iqonic'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'h4',
                'options'    => [
                    'h1'          => __('h1', 'iqonic'),
                    'h2'          => __('h2', 'iqonic'),
                    'h3'          => __('h3', 'iqonic'),
                    'h4'          => __('h4', 'iqonic'),
                    'h5'          => __('h5', 'iqonic'),
                    'h6'          => __('h6', 'iqonic'),
                ],
            ]
        );

        $this->add_control(
            'is_highlight',
            [
                'label' => __('Has Title?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'yes' => __('yes', 'iqonic'),
                'no' => __('no', 'iqonic'),
            ]
        );

        $this->add_control(
            'use_ajax',
            [
                'label' => esc_html__('Enable AJAX?', 'iqonic'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'iqonic'),
                'label_off' => esc_html__('No', 'iqonic'),
                'return' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'swiper_control_section',
            [
                'label' => __('Slider Controls', 'iqonic'),
            ]
        );

        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Controls/swiper_control.php';

        $this->end_controls_section();

        $this->start_controls_section(
            'section_carousel_title',
            [
                'label' => __('Title', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'carousel_title_typography',
                'label' => __('Typography', 'iqonic'),
                'selectors' => '{{WRAPPER}} .umetric-image-title',
            ]
        );

        $this->start_controls_tabs('style_title_tabs');

        $this->start_controls_tab(
            'style_title_normal_tab',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_control(
            'title_normal_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .umetric-image-title' => 'color:{{VALUE}};'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_title_hover_tab',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Color', 'iqonic'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .umetric-image-title:hover' => 'color:{{VALUE}};'],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'section_carousel_options',
            [
                'label' => __('General Options', 'iqonic'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('style_carousel_bg_tabs');
        $this->start_controls_tab(
            'style_carousel_bg_title_tab',
            [
                'label' => esc_html__('Normal', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'port_normal_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .umetric-image-box',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_carousel_bg_title_hover_tab',
            [
                'label' => esc_html__('Hover', 'iqonic'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'port_hover_background',
                'label' => __('Background', 'iqonic'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .umetric-image-box:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'carousel_margin',
            [
                'label' => __('Margin', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .umetric-image-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_padding',
            [
                'label' => __('Padding', 'iqonic'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .umetric-image-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        require 'render.php';
        if (Plugin::$instance->editor->is_edit_mode()) { ?>
            <script>
                (function($) {
                    swiperSlider();
                })(jQuery);
            </script>
<?php
        }
    }
}
