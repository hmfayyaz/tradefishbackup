<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyNetAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );

    add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_net_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Net Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_net_animation',
      [
        'label' => esc_html__('Enable Net Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_net_animation_background_color',
      [
        'label' => esc_html__('Background Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#23153c',
        'condition' => [
          'marvy_enable_net_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_net_animation_color',
      [
        'label' => esc_html__('Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ff3f81',
        'condition' => [
          'marvy_enable_net_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_net_animation_points',
      [
        'label' => esc_html__('Points', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 10,
        'min' => 1,
        'max' => 20,
        'step' => 1,
        'condition' => [
          'marvy_enable_net_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_net_animation_max_distance',
      [
        'label' => esc_html__('Max Distance', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 20,
        'min' => 10,
        'max' => 40,
        'step' => 5,
        'condition' => [
          'marvy_enable_net_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_net_animation_spacing',
      [
        'label' => esc_html__('Spacing', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 15,
        'min' => 10,
        'max' => 20,
        'step' => 1,
        'condition' => [
          'marvy_enable_net_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_net_animation_show_dots',
      [
        'label' => esc_html__('Show Dots', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
        'default' => true,
        'label_on' => __( 'Show', 'marvy-lang' ),
        'label_off' => __( 'Hide', 'marvy-lang' ),
        'condition' => [
          'marvy_enable_net_animation' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();

    $default_post_id = get_option('elementor_active_kit');
    $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);

    if ($settings['marvy_enable_net_animation'] === 'yes') {

      $marvy_settings =  [
        'data-marvy_net_animation_background_color' => 'marvy_net_animation_background_color',
        'data-marvy_net_animation_color' => 'marvy_net_animation_color',
        'data-marvy_net_animation_points' => 'marvy_net_animation_points',
        'data-marvy_net_animation_max_distance' => 'marvy_net_animation_max_distance',
        'data-marvy_net_animation_spacing' => 'marvy_net_animation_spacing',
        'data-marvy_net_animation_show_dots' => 'marvy_net_animation_show_dots',
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
      $marvy_settings['data-marvy_enable_net_animation'] =   'true';

      $element->add_render_attribute(
        '_wrapper',
        $marvy_settings
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_net_animation', 'false');
    }
  }
}
