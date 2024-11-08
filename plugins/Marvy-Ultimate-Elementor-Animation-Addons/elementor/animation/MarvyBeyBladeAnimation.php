<?php

namespace MarvyElementor\animation;

if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;


class MarvyBeyBladeAnimation
{

    public function __construct()
    {
        add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
        add_action('elementor/element/section/section_layout/after_section_end', array($this, 'register_controls'), 1);

        add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
        add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
    }

    public function register_controls($element)
    {
        $element->start_controls_section('marvy_beyblade_animation_section',
            [
                'label' => __('<div style="float: right"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Beyblade Animation', 'marvy-lang'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $element->add_control('marvy_enable_beyblade_animation',
            [
                'label' => esc_html__('Enable Beyblade Animation', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $element->add_control('marvy_enable_beyblade_animation_block_scroll_touch',
            [
                'label' => esc_html__('Pause Scroll On Touch Event', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('In mobile and tablet it will pause scroll event in section.', 'marvy-lang'),
                'default' => 'yes',
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                ]
            ]
        );

        $element->add_responsive_control(
            'marvy_beyblade_animation_line_count',
            [
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'label' => esc_html__('Line Count', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'desktop_default' => 30,
                'tablet_default' => 20,
                'mobile_default' => 10,
                'min' => 1,
                'max' => 800,
                'step' => 5,
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                ]
            ]
        );

        $element->add_responsive_control(
            'marvy_beyblade_animation_line_width',
            [
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'label' => esc_html__('Line Width', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'desktop_default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 2,
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                ]
            ]
        );

        $element->add_responsive_control(
            'marvy_beyblade_animation_circle_radius',
            [
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'label' => esc_html__('Circle Radius', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 75,
                'desktop_default' => 75,
                'tablet_default' => 40,
                'mobile_default' => 20,
                'min' => 10,
                'step' => 5,
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                ]
            ]
        );

        $element->add_responsive_control(
            'marvy_beyblade_animation_rotation_speed',
            [
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'label' => esc_html__('Rotation Speed', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.02,
                'desktop_default' => 0.02,
                'tablet_default' => 0.02,
                'mobile_default' => 0.02,
                'min' => 0.001,
                'max' => 3,
                'step' => 0.001,
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_beyblade_animation_color_type',
            [
                'label' => esc_html__('Color Variant', 'marvy-lang'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'random',
                'options' => [
                    'single' => [
                        'title' => esc_html__('Single', 'marvy-lang'),
                        'icon' => 'eicon-paint-brush'
                    ],
                    'multiple' => [
                        'title' => esc_html__('Multiple', 'marvy-lang'),
                        'icon' => 'eicon-barcode'
                    ],
                    'random' => [
                        'title' => esc_html__('Random', 'marvy-lang'),
                        'icon' => 'eicon-sync'
                    ]
                ],
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_beyblade_animation_color_single',
            [
                'label' => esc_html__('Single Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                    'marvy_beyblade_animation_color_type' => 'single'
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'color',
            [
                'label' => esc_html__('Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF'
            ]
        );

        $element->add_control(
            'marvy_beyblade_animation_color_multiples',
            [
                'label' => esc_html__('Multiple Colors', 'marvy-lang'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['color' => '#FFFFFF'],
                    ['color' => '#FFFFFF'],
                    ['color' => '#FFFFFF'],
                    ['color' => '#FFFFFF'],
                    ['color' => '#FFFFFF'],
                    ['color' => '#FFFFFF'],
                ],
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                    'marvy_beyblade_animation_color_type' => 'multiple'
                ],
                'title_field' => '{{{ color }}}',
            ]
        );

        $element->add_control(
            'beyblade_important_note',
            [
                'show_label' => false,
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __( '<p>Colors will set randomly from the list</p>', 'marvy-lang' ),
                'condition' => [
                    'marvy_enable_beyblade_animation' => 'yes',
                    'marvy_beyblade_animation_color_type' => 'multiple'
                ],
                'content_classes' => 'marvy-editor-notice',
            ]
        );

        $element->end_controls_section();
    }

    public function before_render($element)
    {
        $settings = $element->get_settings();

        $default_post_id = get_option('elementor_active_kit');
        $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);

        if ($settings['marvy_enable_beyblade_animation'] === 'yes') {
            $colors = [];
            foreach ($settings['marvy_beyblade_animation_color_multiples'] as $multi){
                if(!empty($multi) && !empty($multi['__globals__']['color'])){
                    $control_color = explode("=",$multi['__globals__']['color'])[1];
                    $global_color = array_merge($color['system_colors'], $color['custom_colors']);
                    $index = array_search($control_color, array_column($global_color, "_id"));
                    $colors[] = $global_color[$index]['color'];
                }
                else{
                    $colors[] = $multi['color'];
                }
            }
            $marvy_settings =  [
                'data-marvy_enable_beyblade_animation_block_scroll_touch' => 'marvy_enable_beyblade_animation_block_scroll_touch',

                'data-marvy_beyblade_animation_line_count' => 'marvy_beyblade_animation_line_count',
                'data-marvy_beyblade_animation_line_width' => 'marvy_beyblade_animation_line_width',
                'data-marvy_beyblade_animation_circle_radius' => 'marvy_beyblade_animation_circle_radius',
                'data-marvy_beyblade_animation_rotation_speed' => 'marvy_beyblade_animation_rotation_speed',

                // 'data-marvy_beyblade_animation_line_count_tablet' => 'marvy_beyblade_animation_line_count_tablet',
                // 'data-marvy_beyblade_animation_line_width_tablet' => 'marvy_beyblade_animation_line_width_tablet',
                // 'data-marvy_beyblade_animation_circle_radius_tablet' => 'marvy_beyblade_animation_circle_radius_tablet',
                // 'data-marvy_beyblade_animation_rotation_speed_tablet' => 'marvy_beyblade_animation_rotation_speed_tablet',

                // 'data-marvy_beyblade_animation_line_count_mobile' => 'marvy_beyblade_animation_line_count_mobile',
                // 'data-marvy_beyblade_animation_line_width_mobile' => 'marvy_beyblade_animation_line_width_mobile',
                // 'data-marvy_beyblade_animation_circle_radius_mobile' => 'marvy_beyblade_animation_circle_radius_mobile',
                // 'data-marvy_beyblade_animation_rotation_speed_mobile' => 'marvy_beyblade_animation_rotation_speed_mobile',

                'data-marvy_beyblade_animation_color_type' => 'marvy_beyblade_animation_color_type',
                'data-marvy_beyblade_animation_color_single' => 'marvy_beyblade_animation_color_single',
            ];
    
            foreach ($marvy_settings as $key => $value) {
                if (isset($settings['__globals__'][$value]) && !empty($settings['__globals__'][$value]) && !empty($color)) {
                    $control_color = explode("=", $settings['__globals__'][$value])[1];
                    $global_color = array_merge($color['system_colors'], $color['custom_colors']);
                    $index = array_search($control_color, array_column($global_color, "_id"));
                    $marvy_settings[$key] = $global_color[$index]['color'];
                } else {
                    $marvy_settings[$key] = $settings[$value];
                }
            }
            $marvy_settings['data-marvy_enable_beyblade_animation'] =   'true';
            $marvy_settings['data-marvy_beyblade_animation_color_multiples'] = implode("--,--",$colors);

            $element->add_render_attribute(
                '_wrapper',
                $marvy_settings
            );
        } else {
            $element->add_render_attribute('_wrapper', 'data-marvy_enable_beyblade_animation', 'false');
        }
    }

}