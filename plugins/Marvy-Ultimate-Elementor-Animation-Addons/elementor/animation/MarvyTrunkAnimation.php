<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyTrunkAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );

    add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_trunk_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Trunk Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_trunk_animation',
      [
        'label' => esc_html__('Enable Trunk Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_trunk_animation_color',
      [
        'label' => esc_html__('Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#98465f',
        'condition' => [
          'marvy_enable_trunk_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_trunk_animation_background_color',
      [
        'label' => esc_html__('Background Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#222426',
        'condition' => [
          'marvy_enable_trunk_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_trunk_animation_spacing',
      [
        'label' => esc_html__('Spacing', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 0,
        'min' => 0,
        'max' => 10,
        'step' => 1,
        'condition' => [
          'marvy_enable_trunk_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_trunk_animation_chaos',
      [
        'label' => esc_html__('Chaos', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 0.5,
        'min' => 0,
        'max' => 10,
        'step' => 0.5,
        'condition' => [
          'marvy_enable_trunk_animation' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();

    $default_post_id = get_option('elementor_active_kit');
    $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);

    if ($settings['marvy_enable_trunk_animation'] === 'yes') {

      $marvy_settings =  [
        'data-marvy_trunk_animation_color' => 'marvy_trunk_animation_color',
        'data-marvy_trunk_animation_background_color' => 'marvy_trunk_animation_background_color',
        'data-marvy_trunk_animation_spacing' => 'marvy_trunk_animation_spacing',
        'data-marvy_trunk_animation_chaos' => 'marvy_trunk_animation_chaos',
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
      $marvy_settings['data-marvy_enable_trunk_animation'] =   'true';
      
      $element->add_render_attribute(
        '_wrapper',
        $marvy_settings
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_trunk_animation', 'false');
    }
  }
}
