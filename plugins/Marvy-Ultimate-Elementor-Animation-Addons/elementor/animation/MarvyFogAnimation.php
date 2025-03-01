<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyFogAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );

    add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_fog_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Fog Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_fog_animation',
      [
        'label' => esc_html__('Enable Fog Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_fog_animation_highlight_color',
      [
        'label' => esc_html__('Highlight Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ffc300',
        'condition' => [
          'marvy_enable_fog_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fog_animation_midtone_color',
      [
        'label' => esc_html__('Midtone Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ff1f00',
        'condition' => [
          'marvy_enable_fog_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fog_animation_lowlight_color',
      [
        'label' => esc_html__('Lowlight Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#2d00ff',
        'condition' => [
          'marvy_enable_fog_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fog_animation_base_color',
      [
        'label' => esc_html__('Base Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ffebeb',
        'condition' => [
          'marvy_enable_fog_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fog_animation_blur_factor',
      [
        'label' => esc_html__('Blur Factor', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 0.6,
        'min' => 0.1,
        'max' => 0.9,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_fog_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fog_animation_zoom',
      [
        'label' => esc_html__('Zoom', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 1,
        'min' => 0.1,
        'max' => 3,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_fog_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fog_animation_speed',
      [
        'label' => esc_html__('Speed', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 1,
        'min' => 0,
        'max' => 5,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_fog_animation' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();
    
    $default_post_id = get_option('elementor_active_kit');
    $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);

    if ($settings['marvy_enable_fog_animation'] === 'yes') {

      $marvy_settings =  [
        'data-marvy_fog_animation_highlight_color' => 'marvy_fog_animation_highlight_color',
        'data-marvy_fog_animation_midtone_color' => 'marvy_fog_animation_midtone_color',
        'data-marvy_fog_animation_lowlight_color' => 'marvy_fog_animation_lowlight_color',
        'data-marvy_fog_animation_base_color' => 'marvy_fog_animation_base_color',
        'data-marvy_fog_animation_blur_factor' => 'marvy_fog_animation_blur_factor',
        'data-marvy_fog_animation_zoom' => 'marvy_fog_animation_zoom',
        'data-marvy_fog_animation_speed' => 'marvy_fog_animation_speed'
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
      $marvy_settings['data-marvy_enable_fog_animation'] =   'true';
      
      $element->add_render_attribute(
        '_wrapper',
        $marvy_settings
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_fog_animation', 'false');
    }
  }
}
