<?php

namespace Iqonic\Elementor\Elements\RadialProgress;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;


class Widget extends Widget_Base
{
    public function get_name()
    {
        return 'iq_radial_progress';
    }

    public function get_title()
    {
        return __('Iqonic Radial Progress Bars', 'iqonic');
    }
    public function get_categories()
    {
        return ['iqonic-extension'];
    }

    public function get_icon()
    {
        return 'eicon-number-field';
    }
    protected function register_controls()
    {

        $this->start_controls_section(
			'section',
			[
				'label' => __( 'Radial Progress Bar', 'iqonic' ),
			]
		);
        $this->add_control(
			'progress_value',
			[
				'label' => __( 'Progress Bar value', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( '100', 'iqonic' ),
				
			]
        );
        
        $this->add_control(
			'progress_with',
			[
				'label' => __( 'Progress With?', 'iqonic' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text'  => __( 'Text', 'iqonic' ),
					'icon' => __( 'Icon', 'iqonic' ),
					'image' => __( 'image', 'iqonic' ),					
					
				],
			]
        );

        $this->add_control(
			'progress_text',
			[
				'label' => __( 'Progress Text', 'iqonic' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
                'default' => __( 'Progress Title', 'iqonic' ),
                'condition' => [
					'progress_with' => 'text',
				],
				
			]
        );

        $this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'iqonic' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star'
					
                ],
                'condition' => [
					'progress_with' => 'icon',
				],
			]
        );

        $this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'iqonic' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'progress_with' => 'image',
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
        );
        
        $this->add_control(
			'size',
			[
				'label' => __( 'Size', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [  '%' ],
				'range' => [
					
					'%' => [
						'min' => 50,
                        'max' => 1000,
                        'step' => 1
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				
			]
        );
        
        $this->add_control(
			'thickness',
			[
				'label' => __( 'Thickness', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [  '%' ],
				'range' => [
					
					'%' => [
						'min' => 10,
                        'max' => 100,
                        'step' => 1
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 10,
				],
				
			]
        );
        
        $this->add_control(
			'speed',
			[
				'label' => __( 'speed', 'iqonic' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [  '%' ],
				'range' => [
					
					'%' => [
						'min' => 500,
                        'max' => 10000,
                        'step' => 1
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 500,
				],
				
			]
		);

		$this->add_control(
			'data-color',
			[
				'label' => __( 'Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,
				
			]
		);
		$this->add_control(
			'data-background',
			[
				'label' => __( 'Background Color', 'iqonic' ),
				'type' => Controls_Manager::COLOR,

			]
		);

        $this->add_control(
			'iqonic_has_box_shadow',
			[
				'label' => __( 'Box Shadow?', 'iqonic' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'yes' => __( 'yes', 'iqonic' ),
				'no' => __( 'no', 'iqonic' ),
			]
        ); 
       


		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'iqonic' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'text-center',
				'options' => [
					'text-left' => [
						'title' => __( 'Left', 'iqonic' ),
						'icon' => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => __( 'Center', 'iqonic' ),
						'icon' => 'eicon-text-align-center',
					],
					'text-right' => [
						'title' => __( 'Right', 'iqonic' ),
						'icon' => 'eicon-text-align-right',
					]
				]
			]
		);

        $this->end_controls_section();

    }
    protected function render()
    {
        require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/RadialProgress/render.php';
		if (Plugin::$instance->editor->is_edit_mode()) { 
            ?>
           <script>
               (function(jQuery) {
                    callProgress();
               })(jQuery);
           </script> 
               <?php
       }
    }
}
