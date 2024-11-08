<?php

namespace MarvyElementor\animation;

if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

class MarvyDNAAnimation
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
        $element->start_controls_section('marvy_dna_animation_section',
            [
                'label' => __('<div style="float: right"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> DNA Animation', 'marvy-lang'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $element->add_control('marvy_enable_dna_animation',
            [
                'label' => esc_html__('Enable DNA Animation', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER
            ]
        );

        $element->add_control(
            'marvy_dna_animation_background_color',
            [
                'label' => esc_html__('Background Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0D1528',
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_speed',
            [
                'label' => esc_html__('Slow', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'min' => 0.1,
                'step' => 0.5,
                'max' => 200,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_fill_color_1',
            [
                'label' => esc_html__('Fill Color 1', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#122d98',
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_border_color_1',
            [
                'label' => esc_html__('Border Color 1', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#B4F1FF',
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_fill_color_2',
            [
                'label' => esc_html__('Fill Color 2', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9a13ae',
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_border_color_2',
            [
                'label' => esc_html__('Border Color 2', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f5cafe',
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_opacity',
            [
                'label' => esc_html__('Opacity', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.75,
                'min' => 0.01,
                'step' => 0.1,
                'max' => 1,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_brightness',
            [
                'label' => esc_html__('Brightness', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.1,
                'min' => 0.1,
                'step' => 0.1,
                'max' => 1,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_border_width',
            [
                'label' => esc_html__('Border Width', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1.5,
                'min' => 0,
                'step' => 0.5,
                'max' => 3,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_particles_counts',
            [
                'label' => esc_html__('Particles Count', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 200,
                'min' => 50,
                'step' => 5,
                'max' => 500,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_particles_size',
            [
                'label' => esc_html__('Particles Size', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 400,
                'min' => 50,
                'step' => 10,
                'max' => 800,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_particles_color',
            [
                'label' => esc_html__('Particles Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2a4a52',
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control('marvy_dna_animation_is_transparent',
            [
                'label' => esc_html__('Bonds Transparent', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_dna_bond_count_1',
            [
                'label' => esc_html__('DNA-1 Bonds Count', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 95,
                'min' => 50,
                'step' => 10,
                'max' => 200,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_dna_bond_count_2',
            [
                'label' => esc_html__('DNA-2 Bonds Count', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
                'min' => 50,
                'step' => 10,
                'max' => 200,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_dna_animation_dna_bond_count_3',
            [
                'label' => esc_html__('DNA-3 Bonds Count', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
                'min' => 50,
                'step' => 10,
                'max' => 200,
                'condition' => [
                    'marvy_enable_dna_animation' => 'yes',
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

        if ($settings['marvy_enable_dna_animation'] === 'yes') {

            $marvy_settings =  [
                'data-marvy_dna_animation_background_color' => 'marvy_dna_animation_background_color',
                'data-marvy_dna_animation_speed' => 'marvy_dna_animation_speed',
                'data-marvy_dna_animation_fill_color_1' => 'marvy_dna_animation_fill_color_1',
                'data-marvy_dna_animation_border_color_1' => 'marvy_dna_animation_border_color_1',
                'data-marvy_dna_animation_fill_color_2' => 'marvy_dna_animation_fill_color_2',
                'data-marvy_dna_animation_border_color_2' => 'marvy_dna_animation_border_color_2',
                'data-marvy_dna_animation_opacity' => 'marvy_dna_animation_opacity',
                'data-marvy_dna_animation_brightness' => 'marvy_dna_animation_brightness',
                'data-marvy_dna_animation_border_width' => 'marvy_dna_animation_border_width',
                'data-marvy_dna_animation_is_transparent' => 'marvy_dna_animation_is_transparent',
                'data-marvy_dna_animation_particles_counts' => 'marvy_dna_animation_particles_counts',
                'data-marvy_dna_animation_particles_size' => 'marvy_dna_animation_particles_size',
                'data-marvy_dna_animation_particles_color' => 'marvy_dna_animation_particles_color',
                'data-marvy_dna_animation_dna_bond_count_1' => 'marvy_dna_animation_dna_bond_count_1',
                'data-marvy_dna_animation_dna_bond_count_2' => 'marvy_dna_animation_dna_bond_count_2',
                'data-marvy_dna_animation_dna_bond_count_3' => 'marvy_dna_animation_dna_bond_count_3',
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
            $marvy_settings['data-marvy_enable_dna_animation'] =   'true';

            $element->add_render_attribute(
                '_wrapper',
                $marvy_settings
            );
        } else {
            $element->add_render_attribute('_wrapper', 'data-marvy_enable_dna_animation', 'false');
        }
    }
}
