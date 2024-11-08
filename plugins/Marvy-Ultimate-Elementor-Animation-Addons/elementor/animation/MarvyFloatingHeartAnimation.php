<?php

namespace MarvyElementor\animation;

if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

class MarvyFloatingHeartAnimation
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
        $element->start_controls_section('marvy_floating_heart_animation_section',
            [
                'label' => __('<div style="float: right"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/logo.png" height="15px" width="15px" style="float:left;"></div> Floating Heart Animation', 'marvy-lang'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $element->add_control('marvy_enable_floating_heart_animation',
            [
                'label' => esc_html__('Enable Floating Heart', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_color_1',
            [
                'label' => esc_html__('Color1', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#51eaea',
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_color_2',
            [
                'label' => esc_html__('Color2', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fffde1',
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_color_3',
            [
                'label' => esc_html__('Color3', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ff9d76',
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_color_4',
            [
                'label' => esc_html__('Color4', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FB3569',
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_from_degree',
            [
                'label' => __('From Degree', 'marvy-lang'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'deg' => [
                        'min' => -360,
                        'max' => 360
                    ]
                ],
                'default' => [
                    'unit' => 'deg',
                    'size' => -180,
                ],
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_to_degree',
            [
                'label' => __('To Degree', 'marvy-lang'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'deg' => [
                        'min' => -360,
                        'max' => 360
                    ]
                ],
                'default' => [
                    'unit' => 'deg',
                    'size' => 180,
                ],
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_box_shadow_horizontal',
            [
                'label' => __( 'Box Shadow Horizontal Offset', 'marvy-lang' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_box_shadow_vertical',
            [
                'label' => __( 'Box Shadow Vertical Offset', 'marvy-lang' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_box_shadow_blur',
            [
                'label' => __( 'Box Shadow Blur', 'marvy-lang' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_heart_size',
                [
                    'label' => esc_html__('Heart Size', 'marvy-lang'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 6,
                    'min' => 0,
                    'condition' => [
                        'marvy_enable_floating_heart_animation' => 'yes',
                    ]
                ]
            );

        $element->add_control(
            'marvy_floating_heart_animation_animation_delay',
            [
                'label' => esc_html__('Animation Speed', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 12,
                'min' => 0,
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_square_count',
            [
                'label' => esc_html__('Square Count', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'min' => 5,
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_floating_heart_animation_square_size',
            [
                'label' => esc_html__('Square Size', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 18,
                'min' => 1,
                'condition' => [
                    'marvy_enable_floating_heart_animation' => 'yes',
                ]
            ]
        );

        $element->end_controls_section();
    }

    public function before_render($element)
    {
        $settings = $element->get_settings();

        $default_post_id = get_option('elementor_active_kit');
        $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);

        if ($settings['marvy_enable_floating_heart_animation'] === 'yes') {

            $marvy_settings =  [
                'data-marvy_floating_heart_animation_color_1' => 'marvy_floating_heart_animation_color_1',
                'data-marvy_floating_heart_animation_color_2' => 'marvy_floating_heart_animation_color_2',
                'data-marvy_floating_heart_animation_color_3' => 'marvy_floating_heart_animation_color_3',
                'data-marvy_floating_heart_animation_color_4' => 'marvy_floating_heart_animation_color_4',
                'data-marvy_floating_heart_animation_heart_size' => 'marvy_floating_heart_animation_heart_size',
                'data-marvy_floating_heart_animation_animation_delay' => 'marvy_floating_heart_animation_animation_delay',
                'data-marvy_floating_heart_animation_square_count' => 'marvy_floating_heart_animation_square_count',
                'data-marvy_floating_heart_animation_square_size' => 'marvy_floating_heart_animation_square_size'
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
            $marvy_settings['data-marvy_enable_floating_heart_animation'] =   'true';
            $marvy_settings['data-marvy_floating_heart_animation_from_degree'] = $settings['marvy_floating_heart_animation_from_degree']['size'];
            $marvy_settings['data-marvy_floating_heart_animation_to_degree'] = $settings['marvy_floating_heart_animation_to_degree']['size'];
            $marvy_settings['data-marvy_floating_heart_animation_box_shadow_horizontal'] = $settings['marvy_floating_heart_animation_box_shadow_horizontal']['size'];
            $marvy_settings['data-marvy_floating_heart_animation_box_shadow_vertical'] = $settings['marvy_floating_heart_animation_box_shadow_vertical']['size'];
            $marvy_settings['data-marvy_floating_heart_animation_box_shadow_blur'] = $settings['marvy_floating_heart_animation_box_shadow_blur']['size'];
            
            $element->add_render_attribute(
                '_wrapper',
                $marvy_settings
            );
        } else {
            $element->add_render_attribute('_wrapper', 'data-marvy_enable_floating_heart_animation', 'false');
        }
    }

}
