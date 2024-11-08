<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyFluidAnimation {

    public function __construct(){
        add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
        add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );

        add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
        add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
    }

    public function register_controls( $element )
    {
        $element->start_controls_section('marvy_fluid_animation_section',
            [
                'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;"></div> Fluid Animation', 'marvy-lang'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $element->add_control('marvy_enable_fluid_animation',
            [
                'label' => esc_html__( 'Enable Fluid', 'marvy-lang'),
                'type'  => Controls_Manager::SWITCHER
            ]
        );

        $element->add_control('marvy_fluid_animation_hover_effect',
            [
                'label' => esc_html__( 'Enable Hover', 'marvy-lang'),
                'type'  => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'It only works on the desktop.', 'marvy-lang'),
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_desktop_click',
            [
                'label' => esc_html__('Enabled Click Effect On Desktop', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'marvy-lang'),
                'label_off' => esc_html__('No', 'marvy-lang'),
                'default' => 'yes',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_mobile_click',
            [
                'label' => esc_html__('Enabled Tap Effect On Tablet/Mobile', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'marvy-lang'),
                'label_off' => esc_html__('No', 'marvy-lang'),
                'description' => esc_html__( 'It also effect the desktop with touch.', 'marvy-lang'),
                'default' => 'yes',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_random_splash',
            [
                'label' => esc_html__('Enabled Random Splash', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'It only works on the mobile.', 'marvy-lang'),
                'label_on' => esc_html__('Yes', 'marvy-lang'),
                'label_off' => esc_html__('No', 'marvy-lang'),
                'default' => 'no',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_random_splash_interval',
            [
                'label' => esc_html__('Random Splash Interval(Sec)', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 5,
                'step' => 1,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes',
                    'marvy_fluid_animation_random_splash' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_background_color',
            [
                'label' => esc_html__('Background Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_resolution',
            [
                'label' => esc_html__('Sim Resolution', 'marvy-lang'),
                'type' => Controls_Manager::SELECT,
                'default' => '128',
                'options' => [
                    '32' => esc_html__('32', 'marvy-lang'),
                    '64' => esc_html__('64', 'marvy-lang'),
                    '128' => esc_html__('128', 'marvy-lang'),
                    '256' => esc_html__('256', 'marvy-lang')
                ],
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_quality',
            [
                'label' => esc_html__('Quality', 'marvy-lang'),
                'type' => Controls_Manager::SELECT,
                'default' => '512',
                'options' => [
                    '1024' => esc_html__('High', 'marvy-lang'),
                    '512' => esc_html__('Medium', 'marvy-lang'),
                    '256' => esc_html__('Low', 'marvy-lang'),
                    '128' => esc_html__('Very Low', 'marvy-lang')
                ],
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_colorful',
            [
                'label' => esc_html__('Multi Color', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'marvy-lang'),
                'label_off' => esc_html__('No', 'marvy-lang'),
                'default' => 'yes',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_single_color',
            [
                'label' => esc_html__('Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#010F25',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes',
                    'marvy_fluid_animation_colorful!' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_sunrays_enabled',
            [
                'label' => esc_html__('Sun Rays', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'marvy-lang'),
                'label_off' => esc_html__('No', 'marvy-lang'),
                'default' => 'yes',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_sunrays_weight',
            [
                'label' => esc_html__('Sun Rays Weight', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes',
                    'marvy_fluid_animation_sunrays_enabled' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_density',
            [
                'label' => esc_html__('Density', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.95,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_pressure',
            [
                'label' => esc_html__('Pressure', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.8,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_velocity_diffusion',
            [
                'label' => esc_html__('Velocity Diffusion', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.95,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_vorticity',
            [
                'label' => esc_html__('Vorticity', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'min' => 0,
                'max' => 50,
                'step' => 5,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_splat_radius',
            [
                'label' => esc_html__('Splat Radius', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.25,
                'min' => 0.01,
                'max' => 2,
                'step' => 0.10,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_bloom',
            [
                'label' => esc_html__('Bloom', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'marvy-lang'),
                'label_off' => esc_html__('No', 'marvy-lang'),
                'default' => 'yes',
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_intensity',
            [
                'label' => esc_html__('Bloom Intensity', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.8,
                'min' => 0.10,
                'max' => 2,
                'step' => 0.10,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes',
                    'marvy_fluid_animation_bloom' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_animation_threshold',
            [
                'label' => esc_html__('Threshold', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.6,
                'min' => 0,
                'max' => 1,
                'step' => 0.10,
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes',
                    'marvy_fluid_animation_bloom' => 'yes'
                ]
            ]
        );

        $element->add_control(
            'marvy_fluid_boom_on_ids',
            [
                'label' => esc_html__('Boom Button Ids', 'marvy-lang'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Id, Id, Id', 'marvy-lang'),
                'description' => esc_html__("Add unique ids with comma(,) separator to add splats effect on click", 'graphina-lang'),
                'condition' => [
                    'marvy_enable_fluid_animation' => 'yes',
                ]
            ]
        );

        $element->end_controls_section();
    }

    public function before_render($element) {
        $settings = $element->get_settings();

        $default_post_id = get_option('elementor_active_kit');
        $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);

        if ($settings['marvy_enable_fluid_animation'] === 'yes') {

            $marvy_settings =  [
                'data-marvy_fluid_animation_hover_effect' => 'marvy_fluid_animation_hover_effect',
                'data-marvy_fluid_animation_desktop_click' => 'marvy_fluid_animation_desktop_click',
                'data-marvy_fluid_animation_mobile_click' => 'marvy_fluid_animation_mobile_click',
                'data-marvy_fluid_animation_random_splash' => 'marvy_fluid_animation_random_splash',
                'data-marvy_fluid_animation_random_splash_interval' => 'marvy_fluid_animation_random_splash_interval',
                'data-marvy_fluid_animation_resolution' => 'marvy_fluid_animation_resolution',
                'data-marvy_fluid_animation_quality' => 'marvy_fluid_animation_quality',
                'data-marvy_fluid_animation_colorful' => 'marvy_fluid_animation_colorful',
                'data-marvy_fluid_animation_single_color' => 'marvy_fluid_animation_single_color',
                'data-marvy_fluid_animation_sunrays_enabled' => 'marvy_fluid_animation_sunrays_enabled',
                'data-marvy_fluid_animation_sunrays_weight' => 'marvy_fluid_animation_sunrays_weight',
                'data-marvy_fluid_animation_density' => 'marvy_fluid_animation_density',
                'data-marvy_fluid_animation_pressure' => 'marvy_fluid_animation_pressure',
                'data-marvy_fluid_animation_velocity_diffusion' => 'marvy_fluid_animation_velocity_diffusion',
                'data-marvy_fluid_animation_vorticity' => 'marvy_fluid_animation_vorticity',
                'data-marvy_fluid_animation_splat_radius' => 'marvy_fluid_animation_splat_radius',
                'data-marvy_fluid_animation_bloom' => 'marvy_fluid_animation_bloom',
                'data-marvy_fluid_animation_intensity' => 'marvy_fluid_animation_intensity',
                'data-marvy_fluid_animation_threshold' => 'marvy_fluid_animation_threshold',
                'data-marvy_fluid_animation_background_color' => 'marvy_fluid_animation_background_color',
                'data-marvy_fluid_boom_on_ids' => 'marvy_fluid_boom_on_ids',
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
            $marvy_settings['data-marvy_enable_fluid_animation'] =   'true';

            $element->add_render_attribute(
                '_wrapper',
                $marvy_settings
            );
        } else {
            $element->add_render_attribute('_wrapper', 'data-marvy_enable_fluid_animation', 'false');
        }
    }
}
