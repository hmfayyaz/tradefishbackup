<?php

namespace Elementor;

Use Elementor\Core\Schemes\Typography as Scheme_Typography;

if (!defined('ABSPATH')) exit;



/**
 * Elementor Blog widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.5.7
 */

class Org_google_chart extends Widget_Base
{
    
    /**
     * Get widget name.
     *
     * Retrieve heading widget name.
     *
     * @return string Widget name.
     * @since 1.5.7
     * @access public
     *
     */

    public function __construct($data = [], $args = null)
    {
        wp_register_script('googlecharts-min', GRAPHINA_LITE_URL.'/elementor/js/gstatic/loader.js', [], GRAPHINA_LITE_CURRENT_VERSION, true);
        parent::__construct($data, $args);
    }

    public function get_script_depends() {
        return [
            'googlecharts-min'
        ];
    }

    public function get_name()
    {
        return 'org_google_chart';
    }

    /**
     * Get widget Title.
     *
     * Retrieve heading widget Title.
     *
     * @return string Widget Title.
     * @since 1.5.7
     * @access public
     *
     */

    public function get_title()
    {
        return 'Org';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the heading widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return array Widget categories.
     * @since 1.5.7
     * @access public
     *
     */

    public function get_categories()
    {
        return ['iq-graphina-google-charts'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve heading widget icon.
     *
     * @return string Widget icon.
     * @since 1.5.7
     * @access public
     *
     */

    public function get_icon()
    {
        return 'graphina-google-org-chart';
    }

    public function get_chart_type()
    {
        return 'org_google';
    }

    protected function register_controls()
    {
        $type = $this->get_chart_type();
       // $this->color = graphina_colors('color');
        //$this->gradientColor = graphina_colors('gradientColor');

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type, 0, true);

        $this->start_controls_section(
            'iq_' . $type . '_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-pro-charts-for-elementor'),
            ]
        );
        $this->add_control(
            'iq_' . $type . '_google_chart_node_collapse',
            [
                'label' => esc_html__('Collapse Node','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-pro-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-pro-charts-for-elementor'),
                'default' => 'yes'
            ]
         );

 
         $this->add_control(
            'iq_' . $type . '_googlr_chart_title_setting',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'iq_' . $type . '_googlr_chart_node_setting',
            [
                'label' => esc_html__('Node Settings', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
			'iq_' . $type . '_google_chart_node_size',
			[
				'label' => esc_html__( 'Node Size', 'graphina-pro-charts-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => [
					'small'  => esc_html__('small', 'graphina-pro-charts-for-elementor' ),
					'medium' => esc_html__('medium', 'graphina-pro-charts-for-elementor' ),
					'large' => esc_html__('large', 'graphina-pro-charts-for-elementor' ),
					
				],
			]
		);

        $this->add_control(
            'iq_' . $type . '_google_chart_node_font_size',
            [
                'label' => esc_html__('Font Size', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' =>12,
                'selectors'=>['{{WRAPPER}} .myNodeClass'=>'font-size:{{VALUE}}px']
            ]
        );
    
        $this->add_control(
			'iq_' . $type . '_google_chart_node_font_color',
			[
				'label' => esc_html__( 'Font Color', 'graphina-pro-charts-for-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default'=>'black',
				'selectors' => [
            '{{WRAPPER}} .myNodeClass' => 'color: {{VALUE}}']
           ]
		);
        $this->add_control(
            'iq_' . $type . '_google_chart_node_text_align',
            [
                'label' => esc_html__('Alignment', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'graphina-pro-charts-for-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'graphina-pro-charts-for-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'graphina-pro-charts-for-elementor'),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                            
            ]
        );
        

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'iq_' . $type . '_google_chart_node_shadow',
				'label' => esc_html__( 'Node Shadow',  'graphina-pro-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} .myNodeClass',
			]
		);
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
                'name' =>  'iq_' . $type . '_google_chart_node_background_color',
				'label' => esc_html__( 'Background', 'graphina-pro-charts-for-elementor' ),
				'types' => ['classic','gradient'],
				'selector' => '{{WRAPPER}} .myNodeClass'
			]
		);
      
    
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'iq_' . $type . '_google_chart_node_border',
				'label' => esc_html__( 'Border', 'graphina-pro-charts-for-elementor' ),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#000000',
                    ],
                ],
				'selector' => '{{WRAPPER}} .myNodeClass',
			]
		);

            
        $this->add_control(
            'iq_' . $type . '_chart_node_setting',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
      
        $this->add_control(
            'iq_' . $type . '_google_chart_sel_node_setting',
            [
                'label' => esc_html__('Selected Node Settings', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
     
        $this->add_control(
            'iq_' . $type . '_google_chart_node_font_size_sel',
            [
                'label' => esc_html__('Font Size', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' =>12,
                'selectors'=>['{{WRAPPER}} .myNodeClassSel'=>'font-size:{{VALUE}}px']
            ]
        );
    
        $this->add_control(
			'iq_' . $type . '_google_chart_sel_node_font_color',
			[
				'label' => esc_html__( 'Font Color', 'graphina-pro-charts-for-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default'=>'blue',
				'selectors' => [
            '{{WRAPPER}} .myNodeClassSel' => 'color: {{VALUE}}']
          ]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
                'name' =>  'iq_' . $type . '_google_chart_sel_node_background_color',
				'label' => esc_html__( 'Background', 'graphina-pro-charts-for-elementor' ),
				'types' => ['classic','gradient' ],
				'selector' => '{{WRAPPER}} .myNodeClassSel ',
			]
		);
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'iq_' . $type . '_google_chart_sel_node_border',
				'label' => esc_html__( 'Border', 'graphina-pro-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} .myNodeClassSel',
			]
		);

    
        $this->add_control(
            'iq_' . $type . '_google_chart_sel_node_setting_divider',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_google_chart_node_conn_Setting',
            [
                'label' => esc_html__('Connection', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_node_conn_height',
            [
                'label' => esc_html__('Height', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
               
            ]
        );
       
        
        $this->add_control(
            'iq_' . $type . '_google_chart_node_conn_width',
            [
                'label' => esc_html__('Width', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default'=>1
                   
            ]
        );
        $this->add_control(
            'iq_' . $type . '_google_chart_node_conn_style',
            [
                'label' => esc_html__('Style', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
				'options' => [
					'solid'  => esc_html__('solid', 'graphina-pro-charts-for-elementor' ),
					'dotted' => esc_html__('dotted', 'graphina-pro-charts-for-elementor' ),
					'dashed' => esc_html__('dashed', 'graphina-pro-charts-for-elementor' ),
                    'groove'  => esc_html__('groove', 'graphina-charts-for-elementor' ),
					'none' => esc_html__('none', 'graphina-charts-for-elementor' ),
					
				],
            ]
        );
        $this->add_control(
            'iq_' . $type . '_google_chart_node_conn_color',
            [
                'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default'=>'black'
                   
            ]
        );
        
        $this->add_control(
            'iq_' . $type . '_google_chart_node_conn_Setting_divider',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        
        $this->end_controls_section();
        for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {

            $this->start_controls_section(
                'iq_' . $type . '_section_3_' . $i,
                [
                    'label' => esc_html__('Element ' . ($i + 1), 'graphina-charts-for-elementor'),
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
                        'iq_' . $type . '_chart_data_option' => 'manual'
                    ],
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'relation' => 'and',
                                'terms' => [
                                    [
                                        'name' => 'iq_' . $type . '_chart_is_pro',
                                        'operator' => '==',
                                        'value' => 'false'
                                    ],
                                    [
                                        'name' => 'iq_' . $type . '_chart_data_option',
                                        'operator' => '==',
                                        'value' => 'manual'
                                    ]
                                ]
                            ],
                            [
                                'relation' => 'and',
                                'terms' => [
                                    [
                                        'name' => 'iq_' . $type . '_chart_is_pro',
                                        'operator' => '==',
                                        'value' => 'true'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            );
            
              
             
    
            $this->add_control(
                'iq_' . $type . '_google_chart_child' . $i,
                [
                    'label' => 'Child',
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Add Child', 'graphina-charts-for-elementor'),
                    'default' => 'Node ' . ($i + 1),
                    'dynamic' => [
                        'active' => true,
                    ],
                    
                ]
            );
        
            $this->add_control(
                'iq_' . $type . '_google_chart_parent' . $i,
                [
                    'label' => 'Parent Node',
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Add Parent', 'graphina-charts-for-elementor'),
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' =>'Node 1'
                    
                ]
            );
            $this->add_control(
                'iq_' . $type . '_google_chart_tooltip' . $i,
                [
                    'label' => 'Tooltip',
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Add Tooltip', 'graphina-charts-for-elementor'),
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' =>'Node',
                    
                ]
            );
       

            $this->end_controls_section();

        }

        graphina_style_section($this, $type);

        graphina_card_style($this, $type);

        graphina_chart_style($this, $type);

        graphina_chart_filter_style($this,$type);

        if (function_exists('graphina_pro_password_style_section')) {
            graphina_pro_password_style_section($this, $type);
        }
    }
 
    protected function render(){
        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();
        $mainId = graphina_widget_id($this);
        $orgData =[];
        $dataTypeOption = $settings['iq_' . $type . '_chart_data_option'] === 'manual' ? 'manual' : $settings['iq_' . $type . '_chart_dynamic_data_option'];
        if($settings['iq_' . $type . '_chart_data_option'] === 'manual'){
            for ($j = 0; $j < $settings['iq_' . $type . '_chart_data_series_count']; $j++) {
                $orgData[] = [
                    $settings['iq_' . $type . '_google_chart_child' . $j],
                    $settings['iq_' . $type . '_google_chart_parent' . $j],
                    $settings['iq_' . $type . '_google_chart_tooltip' . $j]
                ];
            }
        }

        $orgData = json_encode($orgData);

        require GRAPHINA_PRO_ROOT . '/elementor/google_charts/org/render/org_google_chart.php';

        if (isRestrictedAccess($type, $mainId, $settings, false) === false) {
            ?>
            <script type='text/javascript'>

                (function($) {
                    'use strict';
                    if(parent.document.querySelector('.elementor-editor-active') !== null){
                        // Load the Visualization API and  chart package.
                        google.charts.load('current', {'packages': ["orgchart"]});

                        // Set a callback to run when the Google Visualization API is loaded.
                        google.charts.setOnLoadCallback(drawChart);
                    }
                    document.addEventListener('readystatechange', event => {
                        // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                        if (event.target.readyState === "complete") {
                            // Load the Visualization API and  chart package.
                            google.charts.load('current', {'packages': ["orgchart"]});

                            // Set a callback to run when the Google Visualization API is loaded.
                            google.charts.setOnLoadCallback(drawChart);
                        }
                    })

                    function drawChart() {

                        // chart data
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Child');
                        data.addColumn('string', 'Parent');
                        data.addColumn('string', 'Tooltip');
                        data.addRows(<?php echo $orgData; ?>);

                        // chart options
                        var options = {
                            width: '100%',
                            allowCollapse: '<?php echo $settings['iq_' . $type . '_google_chart_node_collapse'] === 'yes' ?>',
                            size: '<?php echo $settings['iq_' . $type . '_google_chart_node_size'];?>',
                            nodeClass: 'myNodeClass',
                            selectedNodeClass: 'myNodeClassSel',
                            allowHtml: 'true'
                        }

                        if (typeof graphinaGoogleChartInit !== "undefined") {
                            graphinaGoogleChartInit(
                                document.getElementById('org_google_chart<?php esc_attr_e($mainId); ?>'),
                                {
                                    ele:document.getElementById('org_google_chart<?php esc_attr_e($mainId); ?>'),
                                    options: options,
                                    series: data,
                                    animation: true,
                                    renderType:'OrgChart',
                                    setting_date:<?php echo Plugin::$instance->editor->is_edit_mode()?  json_encode($settings) : 'null' ; ?>
                                },
                                '<?php esc_attr_e($mainId); ?>',
                                '<?php echo $this->get_chart_type(); ?>',
                            );
                        }
                        if (window['ajaxIntervalGraphina_' + '<?php esc_attr_e($mainId); ?>'] !== undefined) {
                            clearInterval(window['ajaxIntervalGraphina_' + '<?php esc_attr_e($mainId); ?>']);
                        }
                        if ('<?php echo($settings['iq_' . $type . '_chart_data_option'] !== 'manual') ?>') {
                            if ('<?php echo $settings['iq_' . $type . '_chart_data_option'] === 'forminator' || isGraphinaPro() ?>') {
                                graphina_google_chart_ajax_reload('<?php echo true ?>',
                                    '<?php echo $this->get_chart_type(); ?>',
                                    '<?php esc_attr_e($mainId); ?>',
                                    '<?php echo !empty($settings['iq_' . $type . '_can_chart_reload_ajax'])
                                    && $settings['iq_' . $type . '_can_chart_reload_ajax'] === 'yes' ? 'true' : 'false'; ?>',
                                    '<?php echo !empty($settings['iq_' . $type . '_interval_data_refresh']) ? $settings['iq_' . $type . '_interval_data_refresh'] : 5 ?>')
                            }
                        }

                    }

                }).apply(this, [jQuery]);

            </script>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register(new Org_google_chart());

    