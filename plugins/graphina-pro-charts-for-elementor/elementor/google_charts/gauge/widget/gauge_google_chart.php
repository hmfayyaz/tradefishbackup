<?php

namespace Elementor;

Use Elementor\Core\Schemes\Typography as Scheme_Typography;

class Gauge_google_chart extends Widget_Base{

    public $defaultLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan1', 'Feb1', 'Mar1', 'Apr1', 'May1','Jun1', 'July1', 'Aug1', 'Sep1', 'Oct1', 'Nov1', 'Dec1', 'Jan2', 'Feb2', 'Mar2', 'Apr2', 'May2', 'Jun2', 'July2', 'Aug2',];

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
        return 'gauge_google_chart';
    }

    public function get_title()
    {
        return 'Gauge';
    }

    public function get_icon()
    {
        return 'graphina-google-gauge-chart';
//        return 'fas fa-tachometer-alt';
    }

    public function get_categories()
    {
        return ['iq-graphina-google-charts'];
    }

    public function get_chart_type()
    {
      return 'gauge_google';
    }

    public function register_controls()
    {
        $type = $this->get_chart_type();
        $this->color = graphina_colors('color');
        $this->gradientColor = graphina_colors('gradientColor');
  
        graphina_basic_setting($this, $type);
  
        graphina_chart_data_option_setting($this, $type, 2, true);
  
        $this->start_controls_section(
          'iq_' . $type . '_section_2',
          [
              'label' => esc_html__('Chart Setting', 'graphina-pro-charts-for-elementor'),
          ]
       );
  
       $this->add_control(
          'iq_' . $type . '_google_chart_meter_width',
          [
              'label' => esc_html__('Width','graphina-pro-charts-for-elementor'),
              'type' => Controls_Manager::NUMBER,
              'step' => 10,
              'min' => 0
          ]
       );
  
       $this->add_control(
        'iq_' . $type . '_google_chart_meter_height',
        [
            'label' => esc_html__('Height','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 350,
            'min' => 0
        ]
     );

        $this->add_control(
            'iq_' . $type . '_chart_hr_ticks_prefix_1',
            [
                'type' => Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_value_prefix',
            [
                'label' => esc_html__('Value Prefix','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_value_postfix',
            [
                'label' => esc_html__('Value Postfix','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_value_decimal',
            [
                'label' => esc_html__('Decimal in float','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'step' => 1,
                'min' => 0
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_hr_ticks_prefix_2',
            [
                'type' => Controls_Manager::DIVIDER
            ]
        );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_min_value',
        [
            'label' => esc_html__('Min Value','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_max_value',
        [
            'label' => esc_html__('Max Value','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 200,
            'min' => 0
        ]
        );

     $this->add_control(
        'iq_' . $type . '_chart_hr_ticks_color',
        [
            'type' => Controls_Manager::DIVIDER
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_ticks_color',
        [
            'label' => esc_html__('Ticks Color From To', 'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::HEADING
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_green_from',
        [
            'label' => esc_html__('Green From','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_green_to',
        [
            'label' => esc_html__('Green To','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 50,
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_yellow_from',
        [
            'label' => esc_html__('Yellow From','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 50,
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_yellow_to',
        [
            'label' => esc_html__('Yellow To','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 150,
            'min' => 0
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_red_from',
        [
            'label' => esc_html__('Red From','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 150,
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_meter_red_to',
        [
            'label' => esc_html__('Red To','graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 200,
        ]
     );

     $this->add_control(
        'iq_' . $type . '_chart_ticks_color_divider',
        [
            'type' => Controls_Manager::DIVIDER
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_ticks_color_hr',
        [
            'label' => esc_html__('Ticks Color', 'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::HEADING
        ]
     );

     $this->add_control(
         'iq_' . $type . '_chart_ticks_green_color',
         [
            'label' => esc_html__('Green Color', 'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#109618',
         ]
     );

     $this->add_control(
        'iq_' . $type . '_chart_ticks_yellow_color',
        [
           'label' => esc_html__('Yellow Color', 'graphina-pro-charts-for-elementor'),
           'type' => Controls_Manager::COLOR,
           'default' => '#FF9900',
        ]
    );

    $this->add_control(
        'iq_' . $type . '_chart_ticks_red_color',
        [
           'label' => esc_html__('Red Color', 'graphina-pro-charts-for-elementor'),
           'type' => Controls_Manager::COLOR,
           'default' => '#DC3912',
        ]
    );

     $this->add_control(
        'iq_' . $type . '_chart_hr_ticks_setting',
        [
            'type' => Controls_Manager::DIVIDER
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_ticks_settings',
        [
            'label' => esc_html__('Ticks Settings', 'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::HEADING
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_minor_ticks',
        [
            'label' => esc_html__('Minor Ticks', 'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5,
            'min' => 0
        ]
     );

     $this->add_control(
        'iq_' . $type . '_google_chart_major_ticks_show',
        [
            'label' => esc_html__('Major Ticks Show', 'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-pro-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-pro-charts-for-elementor'),
            'default' => 'yes'
        ]
    );

     $repeater = new Repeater();

    $repeater->add_control(
       'iq_' . $type . '_google_chart_major_ticks_value',
       [
           'label' => esc_html__('Major Ticks', 'graphina-pro-charts-for-elementor'),
           'type' => Controls_Manager::NUMBER,
           'dynamic' => [
               'active' => true,
           ],

       ]
    );

    $this->add_control(
        'iq_' . $type . '_google_chart_major_ticks',
        [
            'label' => esc_html__('Ticks', 'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['iq_' . $type . '_google_chart_major_ticks_value' => 0],
                ['iq_' . $type . '_google_chart_major_ticks_value' => 50],
                ['iq_' . $type . '_google_chart_major_ticks_value' => 100],
                ['iq_' . $type . '_google_chart_major_ticks_value' => 150],
                ['iq_' . $type . '_google_chart_major_ticks_value' => 200],
            ],
            'condition' => [
                'iq_' . $type . '_google_chart_major_ticks_show' => 'yes'
            ]
        ]
    );

        $this->add_control(
            'iq_' . $type . '_chart_hr_needle_setting',
            [
                'type' => Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_needle_color',
            [
                'label' => esc_html__('Needle Color', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default'=> '#c63310'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_round_ball_color',
            [
                'label' => esc_html__('Round Ball Color', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default'=> '#4684ee'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_inner_circle_color',
            [
                'label' => esc_html__('Inner Circle Color', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default'=> '#f7f7f7'
            ]
        );


        $this->add_control(
            'iq_' . $type . '_google_chart_outer_circle_color',
            [
                'label' => esc_html__('Outer Circle Color', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default'=> '#cccccc'
            ]
        );
    //    graphina_animation($this, $type);

       $this->end_controls_section();

       for($i = 0; $i <= graphina_default_setting('max_series_value'); $i++)
       {
            $this->start_controls_section(
                'iq_' . $type . '_chart_element_section_'.$i,
                [
                    'label' => esc_html__('Element'. ($i + 1),'graphina-pro-charts-for-elementor'),
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range($i + 1, graphina_default_setting('max_series_value')),
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
                'iq_' . $type . '_chart_element_setting_title_'.$i,
                [
                    'label' => esc_html__('Label','graphina-pro-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'default' => $this->defaultLabel[$i],
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
        
            $this->add_control(
                'iq_' . $type . '_chart_element_setting_value_'.$i,
                [
                    'label' => esc_html__('Value','graphina-pro-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => rand(5,200),
                    'dynamic' => [
                        'active' => true,
                    ],
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

    public function render()
    {
        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();
        $mainId = graphina_widget_id($this);
        $columnData =  [];

        if(!empty($settings['iq_' . $type . '_google_chart_major_ticks'])){
            $majorticksvalue = [];
            foreach($settings['iq_' . $type . '_google_chart_major_ticks'] as $key1 => $value1){
                $majorticksvalue[] = strval($value1['iq_' . $type . '_google_chart_major_ticks_value']);
            }
            $majorticksvalue = json_encode($majorticksvalue);
        }

        for ($j = 0; $j < $settings['iq_' . $type . '_chart_data_series_count']; $j++) {
            if($settings['iq_' . $type . '_chart_data_option'] === 'manual'){
                $columnData[] = [
                    $settings['iq_' . $type . '_chart_element_setting_title_' . $j],
                    $settings['iq_' . $type . '_chart_element_setting_value_' . $j]
                ];
            }
        }

        $columnData = json_encode($columnData);
        if(function_exists('graphina_chart_widget_content')){
            graphina_chart_widget_content($this, $mainId, $settings);
        }
        if (isRestrictedAccess($type, $mainId, $settings, false) === false) {
            ?>
            <script type="text/javascript">
                (function ($) {
                    'use strict';
                    if (parent.document.querySelector('.elementor-editor-active') !== null) {
                        if (typeof isInit === 'undefined') {
                            var isInit = {};
                        }
                        isInit['<?php esc_attr_e($mainId); ?>'] = false;
                        google.charts.load('current', {'packages': ['gauge'],});
                        google.charts.setOnLoadCallback(drawRegionsMap);
                    }
                    document.addEventListener('readystatechange', event => {
                        // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                        if (event.target.readyState === "complete") {
                            if (typeof isInit === 'undefined') {
                                var isInit = {};
                            }
                            isInit['<?php esc_attr_e($mainId); ?>'] = false;
                            google.charts.load('current', {'packages': ['gauge'],});
                            google.charts.setOnLoadCallback(drawRegionsMap);
                        }
                    })

                    function drawRegionsMap() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Name')
                        data.addColumn('number', 'Meter')

                        data.addRows(<?php echo $columnData; ?>);

                        var formatter = new google.visualization.NumberFormat({
                            prefix: '<?php echo esc_html($settings['iq_' . $type . '_google_chart_value_prefix']);?>',
                            suffix: '<?php echo esc_html($settings['iq_' . $type . '_google_chart_value_postfix']);?>',
                            fractionDigits: '<?php echo esc_html($settings['iq_' . $type . '_google_chart_value_decimal']);?>'
                        });
                        formatter.format(data, 1);

                        var options = {
                            forceIFrame: false,
                            width: parseInt('<?php echo !empty($settings['iq_' . $type . '_google_chart_meter_width']) ? $settings['iq_' . $type . '_google_chart_meter_width'] : '';?>'),
                            height: parseInt('<?php echo !empty($settings['iq_' . $type . '_google_chart_meter_height']) ? $settings['iq_' . $type . '_google_chart_meter_height'] : '';?>'),
                            redFrom: parseInt('<?php echo $settings['iq_' . $type . '_google_chart_meter_red_from'];?>'),
                            redTo: parseInt('<?php echo !empty($settings['iq_' . $type . '_google_chart_meter_red_to']) ? $settings['iq_' . $type . '_google_chart_meter_red_to'] : '';?>'),
                            redColor: '<?php echo !empty($settings['iq_' . $type . '_chart_ticks_red_color']) ? $settings['iq_' . $type . '_chart_ticks_red_color'] : '';?>',
                            yellowFrom: parseInt('<?php echo $settings['iq_' . $type . '_google_chart_meter_yellow_from'];?>'),
                            yellowTo: parseInt('<?php echo $settings['iq_' . $type . '_google_chart_meter_yellow_to'];?>'),
                            yellowColor: '<?php echo !empty($settings['iq_' . $type . '_chart_ticks_yellow_color']) ? $settings['iq_' . $type . '_chart_ticks_yellow_color'] : '';?>',
                            minorTicks: parseInt('<?php echo !empty($settings['iq_' . $type . '_google_chart_minor_ticks']) ? $settings['iq_' . $type . '_google_chart_minor_ticks'] : '';?>'),
                            min: parseInt('<?php echo $settings['iq_' . $type . '_google_chart_meter_min_value'];?>'),
                            max: parseInt('<?php echo !empty($settings['iq_' . $type . '_google_chart_meter_max_value']) ? $settings['iq_' . $type . '_google_chart_meter_max_value'] : '';?>'),
                            greenFrom: parseInt('<?php echo $settings['iq_' . $type . '_google_chart_meter_green_from'];?>'),
                            greenTo: parseInt('<?php echo !empty($settings['iq_' . $type . '_google_chart_meter_green_to']) ? $settings['iq_' . $type . '_google_chart_meter_green_to'] : '';?>'),
                            greenColor: '<?php echo !empty($settings['iq_' . $type . '_chart_ticks_green_color']) ? $settings['iq_' . $type . '_chart_ticks_green_color'] : '';?>',
                        };

                        if ('<?php echo !empty($settings['iq_' . $type . '_google_chart_major_ticks_show']) && $settings['iq_' . $type . '_google_chart_major_ticks_show'] == 'yes' ?>') {
                            options.majorTicks = <?php print_r(!empty($majorticksvalue) ? $majorticksvalue : []); ?>;
                        }

                        if (typeof graphinaGoogleChartInit !== "undefined") {
                            graphinaGoogleChartInit(
                                document.getElementById('gauge_google_chart<?php esc_attr_e($mainId); ?>'),
                                {
                                    ele: document.getElementById('gauge_google_chart<?php esc_attr_e($mainId); ?>'),
                                    options: options,
                                    series: data,
                                    animation: true,
                                    renderType: 'Gauge',
                                    setting_date:<?php echo Plugin::$instance->editor->is_edit_mode()?  json_encode($settings) : 'null' ; ?>,
                                    ballColor: '<?php echo strval($settings['iq_' . $type . '_google_chart_round_ball_color']);?>',
                                    innerCircleColor: '<?php echo strval($settings['iq_' . $type . '_google_chart_inner_circle_color']);?>',
                                    outerCircleColor: '<?php echo strval($settings['iq_' . $type . '_google_chart_outer_circle_color']);?>',
                                    needleColor: '<?php echo strval($settings['iq_' . $type . '_google_chart_needle_color']);?>'
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


Plugin::instance()->widgets_manager->register(new Gauge_google_chart());