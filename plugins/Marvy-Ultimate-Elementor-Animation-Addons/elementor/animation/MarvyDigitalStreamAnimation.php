<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyDigitalStreamAnimation {

    public function __construct(){
        add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
        add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );

        add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
        add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
    }

    public function register_controls( $element )
    {
        $element->start_controls_section('marvy_digitalStream_animation_section',
            [
                'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;"></div> Digital Stream Animation', 'marvy-lang'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $element->add_control('marvy_enable_digitalStream_animation',
            [
                'label' => esc_html__( 'Enable Digital Stream', 'marvy-lang'),
                'type'  => Controls_Manager::SWITCHER
            ]
        );

        $element->add_control(
            'marvy_digitalStream_animation_background_color',
            [
                'label' => esc_html__('Background Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'marvy_enable_digitalStream_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_digitalStream_animation_color_type',
            [
                'label' => esc_html__('Stream Color Type', 'marvy-lang'),
                'type' => Controls_Manager::SELECT,
                'default' => 'random',
                'options' => [
                    'random' => esc_html__('Random', 'marvy-lang'),
                    'custom' => esc_html__('Custom', 'marvy-lang')
                ],
                'condition' => [
                    'marvy_enable_digitalStream_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_digitalStream_animation_color',
            [
                'label' => esc_html__('Stream Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#30ABBD',
                'condition' => [
                    'marvy_enable_digitalStream_animation' => 'yes',
                    'marvy_digitalStream_animation_color_type' => 'custom'
                ]
            ]
        );

        $element->add_control(
            'marvy_digitalStream_animation_alpha',
            [
                'label' => esc_html__('Alpha', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.03,
                'min' => 0.01,
                'max' => 1,
                'step' => 0.03,
                'condition' => [
                    'marvy_enable_digitalStream_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_digitalStream_animation_noise_dist',
            [
                'label' => esc_html__('Noise Distance', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
                'min' => 0,
                'max' => 5000,
                'step' => 100,
                'condition' => [
                    'marvy_enable_digitalStream_animation' => 'yes'
                ]
            ]
        );

        $element->end_controls_section();
    }

    public function before_render($element) {
        $settings = $element->get_settings();

        $default_post_id = get_option('elementor_active_kit');
        $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);

        if ($settings['marvy_enable_digitalStream_animation'] === 'yes') {

            $marvy_settings =  [
                'data-marvy_digitalStream_animation_background_color' => 'marvy_digitalStream_animation_background_color',
                'data-marvy_digitalStream_animation_color_type' => 'marvy_digitalStream_animation_color_type',
                'data-marvy_digitalStream_animation_color' => 'marvy_digitalStream_animation_color',
                'data-marvy_digitalStream_animation_alpha' => 'marvy_digitalStream_animation_alpha',
                'data-marvy_digitalStream_animation_noise_dist' => 'marvy_digitalStream_animation_noise_dist',
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
            $marvy_settings['data-marvy_enable_digitalStream_animation'] =   'true';
            $element->add_render_attribute(
                '_wrapper',
                $marvy_settings
            );
        } else {
            $element->add_render_attribute('_wrapper', 'data-marvy_enable_digitalStream_animation', 'false');
        }
    }
}
