<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyBirdsAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );

    add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_birds_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Birds Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_birds_animation',
      [
        'label' => esc_html__('Enable Birds Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_birds_animation_background_color',
      [
        'label' => esc_html__('Background Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#07182f',
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_background_opacity',
      [
        'label' => esc_html__('Background Opacity', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 1,
        'min' => 0,
        'max' => 1,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_wings_mode',
      [
        'label' => esc_html__('Wings ColorMode', 'marvy-lang'),
        'type' => Controls_Manager::SELECT,
        'default' => 'varianceGradient',
        'options' => [
          'lerp' => esc_html__('Lerp', 'marvy-lang'),
          'variance' => esc_html__('Variance', 'marvy-lang'),
          'lerpGradient' => esc_html__('Lerp Gradient', 'marvy-lang'),
          'varianceGradient' => esc_html__('Variance Gradient', 'marvy-lang')
        ],
        'condition' => [
          'marvy_enable_birds_animation' => 'yes'
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_wings_color',
      [
        'label' => esc_html__('Wings Color1', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ff0a09',
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_wings_color_two',
      [
        'label' => esc_html__('Wings Color2', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#00d1ff',
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_quantity',
      [
        'label' => esc_html__('Quantity', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 5,
        'min' => 0,
        'max' => 5,
        'step' => 1,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_bird_size',
      [
        'label' => esc_html__('Bird Size', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 1,
        'min' => 0,
        'max' => 4,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_wing_span',
      [
        'label' => esc_html__('Wing Span', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 30,
        'min' => 0,
        'max' => 40,
        'step' => 1,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_speed_limit',
      [
        'label' => esc_html__('Speed Limit', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 5,
        'min' => 0,
        'max' => 10,
        'step' => 1,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_separation',
      [
        'label' => esc_html__('Separation', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 20,
        'min' => 0,
        'max' => 100,
        'step' => 10,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_alignment',
      [
        'label' => esc_html__('Alignment', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 20,
        'min' => 0,
        'max' => 100,
        'step' => 10,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_birds_animation_cohesion',
      [
        'label' => esc_html__('Cohesion', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 20,
        'min' => 0,
        'max' => 100,
        'step' => 10,
        'condition' => [
          'marvy_enable_birds_animation' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {  
    $settings = $element->get_settings();

    $default_post_id = get_option('elementor_active_kit');
    $color =  get_post_meta($default_post_id, '_elementor_page_settings', true);
   
    if ($settings['marvy_enable_birds_animation'] === 'yes') {

      $marvy_settings =  [
        'data-marvy_birds_animation_background_color' => 'marvy_birds_animation_background_color',
        'data-marvy_birds_animation_background_opacity' => 'marvy_birds_animation_background_opacity',
        'data-marvy_birds_animation_wings_mode' => 'marvy_birds_animation_wings_mode',
        'data-marvy_birds_animation_wings_color' => 'marvy_birds_animation_wings_color',
        'data-marvy_birds_animation_wings_color_two' => 'marvy_birds_animation_wings_color_two',
        'data-marvy_birds_animation_quantity' => 'marvy_birds_animation_quantity',
        'data-marvy_birds_animation_bird_size' => 'marvy_birds_animation_bird_size',
        'data-marvy_birds_animation_wing_span' => 'marvy_birds_animation_wing_span',
        'data-marvy_birds_animation_speed_limit' => 'marvy_birds_animation_speed_limit',
        'data-marvy_birds_animation_separation' => 'marvy_birds_animation_separation',
        'data-marvy_birds_animation_alignment' => 'marvy_birds_animation_alignment',
        'data-marvy_birds_animation_cohesion' => 'marvy_birds_animation_cohesion',
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
    $marvy_settings['data-marvy_enable_birds_animation'] =   'true';
    
      $element->add_render_attribute(
        '_wrapper',
        $marvy_settings
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_birds_animation', 'false');
    }   
  }
}
