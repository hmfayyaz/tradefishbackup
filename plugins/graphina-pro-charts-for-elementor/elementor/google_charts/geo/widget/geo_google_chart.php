<?php

namespace Elementor;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

class Geo_google_chart extends Widget_Base{

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
        return 'geo_google_chart';
    }

    public function get_title()
    {
        return 'Geo';
    }

    public function get_icon()
    {
//        return 'fas fa-globe-asia';
        return 'graphina-google-geo-chart';
    }

    public function get_categories()
    {
        return ['iq-graphina-google-charts'];
    }

    public function get_chart_type()
    {
        return 'geo_google';
    }

    public function register_controls()
    {
        $type = $this->get_chart_type();
        $this->color = graphina_colors('color');
        $this->gradientColor = graphina_colors('gradientColor');

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type, 0, true);

        $this->start_controls_section(
            'iq_' . $type . '_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-pro-charts-for-elementor'),
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_settings_heading',
            [
                'label' => esc_html__('Chart Configuration','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        // $this->add_control(
        //     'iq_' . $type . '_google_chart_width',
        //     [
        //         'label' => esc_html__('Width','graphina-pro-charts-for-elementor'),
        //         'type' => Controls_Manager::NUMBER,
        //         'min' => 0,
        //         'default' => 560
        //     ]
        // );

        $this->add_control(
            'iq_' . $type . '_google_chart_height',
            [
                'label' => esc_html__('Height','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 360
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_region_show',
            [
                'label' => esc_html__('Show Region','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'description' => __('Note: Enable it to highlight the region of the particular country, Click <strong><a href="https://developers.google.com/chart/interactive/docs/gallery/geochart#regions-mode-format" target="_blank">here</a></strong> for more information','graphina-charts-for-elementor')
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_label_text',
            [
                'label' => esc_html__('label','graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Latitude','graphina-pro-charts-for-elementor')
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_region',
            [
                'label' => esc_html__('Region','graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'iq_' . $type . '_google_chart_region_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_geo_background',
            [
                'label' => esc_html__('Background', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#81d4fa'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_background_stroke_color',
            [
                'label' => esc_html__('Stroke Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_background_stroke_width',
            [
                'label' => esc_html__('Stroke Width','graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 0
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_geo_default_color',
            [
                'label' => esc_html__('Geo Default Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_geo_data_less_color',
            [
                'label' => esc_html__('Geo No Data Region', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fbffee'
            ]
        );

        graphina_tooltip($this, $type);

        $this->add_control(
            'iq_' . $type . '_chart_hr_category_listing',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ],
            ]
        );


        $repeater = new Repeater();

        $repeater->add_control(
            'iq_' . $type . '_chart_category',
            [
                'label' => esc_html__('Category Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                'dynamic' => [
                    'active' => true,
                ],
                'description' => esc_html__('Note: For multiline text seperate Text by comma(,) ','graphina-charts-for-elementor')
            ]
        );

        /** Chart value list. */
        $this->add_control(
            'iq_' . $type . '_category_list',
            [
                'label' => esc_html__('Categories', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['iq_' . $type . '_chart_category' => 'Germany'],
                    ['iq_' . $type . '_chart_category' => 'Japan'],
                    ['iq_' . $type . '_chart_category' => 'Mexico'],
                    ['iq_' . $type . '_chart_category' => 'India'],
                    ['iq_' . $type . '_chart_category' => 'South Africa'],
                    ['iq_' . $type . '_chart_category' => 'Russia'],
                ],
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ],
                'title_field' => '{{{ iq_' . $type . '_chart_category }}}',
            ]
        );

        $this->end_controls_section();

        graphina_advance_legend_setting($this, $type);

        $this->start_controls_section(
            'iq_' . $type . '_section_color_axis',
            [
                'label' => esc_html__('Color Axis', 'graphina-charts-for-elementor'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'iq_' . $type . '_chart_color_axis_index',
            [
                'label' => esc_html__('Color Axis', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_color_axis',
            [
                'label' => esc_html__('Color Axis', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['iq_' . $type . '_chart_color_axis_index' => '#f8bbd0'],
                    ['iq_' . $type . '_chart_color_axis_index' => '#00853f'],
                    ['iq_' . $type . '_chart_color_axis_index' => '#e31b23']
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'iq_' . $type . '_chart_color_axis_number',
            [
                'label' => esc_html__('Color Axis Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_color_axis_value',
            [
                'label' => esc_html__('Color Axis Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['iq_' . $type . '_chart_color_axis_number' => 0],
                    ['iq_' . $type . '_chart_color_axis_number' => 10],
                    ['iq_' . $type . '_chart_color_axis_number' => 20]
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'iq_' . $type . '_section_3_element_setting',
            [
                'label' => esc_html__('Element Settings', 'graphina-charts-for-elementor'),
                'condition' => [
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
            'iq_' . $type . '_chart_title_3_element_setting',
            [
                'label' => esc_html__('Title','graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Add Tile', 'graphina-charts-for-elementor'),
                'default' => 'Element',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'iq_' . $type . '_chart_value_3_element_setting',
            [
                'label' => esc_html__('Element Value','graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        /** Chart value list. */
        $this->add_control(
            'iq_' . $type . '_value_list_3_1_element_setting',
            [
                'label' => esc_html__('Values', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['iq_' . $type . '_chart_value_3_element_setting' => rand(10, 200)],
                    ['iq_' . $type . '_chart_value_3_element_setting' => rand(10, 200)],
                    ['iq_' . $type . '_chart_value_3_element_setting' => rand(10, 200)],
                    ['iq_' . $type . '_chart_value_3_element_setting' => rand(10, 200)],
                    ['iq_' . $type . '_chart_value_3_element_setting' => rand(10, 200)],
                    ['iq_' . $type . '_chart_value_3_element_setting' => rand(10, 200)]
                ],
                'title_field' => '{{{ iq_' . $type . '_chart_value_3_element_setting }}}',
            ]
        );

        $this->end_controls_section();

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
        $geoData =  $colorAxisData = $colorAxisValue = [];
        $colorAxis = !empty($settings['iq_' . $type . '_chart_color_axis']) ? $settings['iq_' . $type . '_chart_color_axis'] : [];
        $colorAxisNum = !empty($settings['iq_' . $type . '_chart_color_axis_value']) ? $settings['iq_' . $type . '_chart_color_axis_value'] : [];
        foreach ($colorAxis as $key => $value){
            if(!empty($value['iq_' . $type . '_chart_color_axis_index'])
                && !empty($colorAxisNum[$key]['iq_' . $type . '_chart_color_axis_number'])){
                $colorAxisData[] = $value['iq_' . $type . '_chart_color_axis_index'];
                $colorAxisValue[] = $colorAxisNum[$key]['iq_' . $type . '_chart_color_axis_number'];
            }
        }

        if($settings['iq_' . $type . '_chart_data_option'] === 'manual'){
            foreach ($settings['iq_' . $type . '_category_list'] as $key => $value) {
                $geoData[] = [
                    $value['iq_' . $type . '_chart_category'],
                    !empty($settings['iq_' . $type . '_value_list_3_1_element_setting'][$key]['iq_' . $type . '_chart_value_3_element_setting']) ? $settings['iq_' . $type . '_value_list_3_1_element_setting'][$key]['iq_' . $type . '_chart_value_3_element_setting'] : rand(0,200)
                ];
            }
        }
        
        $colorAxisData = json_encode($colorAxisData);
        $colorAxisValue = json_encode($colorAxisValue);
        $geoData = json_encode($geoData);
        if(function_exists('graphina_chart_widget_content')){
            graphina_chart_widget_content($this, $mainId, $settings);
        }
        if( isRestrictedAccess($type,$mainId,$settings,false) === false)
        {
        ?>
        <script type="text/javascript">

            (function($) {
                'use strict';
                if(parent.document.querySelector('.elementor-editor-active') !== null){
                    if (typeof isInit === 'undefined') {
                        var isInit = {};
                    }
                    isInit['<?php esc_attr_e($mainId); ?>'] = false;
                    google.charts.load('current', {'packages': ['geochart']});
                    google.charts.setOnLoadCallback(drawRegionsMap);
                }
                document.addEventListener('readystatechange', event => {
                    // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                    if (event.target.readyState === "complete") {
                        if (typeof isInit === 'undefined') {
                            var isInit = {};
                        }
                        isInit['<?php esc_attr_e($mainId); ?>'] = false;
                        google.charts.load('current', {'packages': ['geochart']});
                        google.charts.setOnLoadCallback(drawRegionsMap);
                    }
                })

                function drawRegionsMap() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', '<?php echo strval($settings['iq_' . $type . '_chart_title_3_element_setting']); ?>')
                    data.addColumn('number', '<?php echo strval($settings['iq_' . $type . '_google_chart_label_text']); ?>')

                    data.addRows(<?php echo $geoData; ?>);

                    var options = {
                        width: '100%',
                        height: '<?php echo !empty($settings['iq_' . $type . '_google_chart_height']) ? $settings['iq_' . $type . '_google_chart_height'] : '';?>',
                        enableRegionInteractivity: '<?php echo empty($settings['iq_' . $type . '_chart_tooltip_show']) ? 'false' : 'true';?>',
                        colorAxis: {
                            colors: <?php echo !empty($colorAxisData) ? $colorAxisData : ''; ?>,
                            values: <?php echo !empty($colorAxisValue) ? $colorAxisValue : ''; ?>
                        },
                        backgroundColor : {
                            fill: '<?php echo !empty($settings['iq_' . $type . '_google_geo_background']) ? $settings['iq_' . $type . '_google_geo_background'] : '';?>',
                            stroke: '<?php echo !empty($settings['iq_' . $type . '_google_background_stroke_color']) ? $settings['iq_' . $type . '_google_background_stroke_color'] : '';?>',
                            strokeWidth: '<?php echo !empty($settings['iq_' . $type . '_google_background_stroke_width']) ? $settings['iq_' . $type . '_google_background_stroke_width'] : '';?>'
                        },
                        defaultColor : '<?php echo !empty($settings['iq_' . $type . '_chart_geo_default_color']) ? $settings['iq_' . $type . '_chart_geo_default_color'] : '';?>',
                        datalessRegionColor : '<?php echo !empty($settings['iq_' . $type . '_chart_geo_data_less_color']) ? $settings['iq_' . $type . '_chart_geo_data_less_color'] : '';?>',
                        tooltip:{
                            textStyle: {
                                color: '<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_color']) ? $settings['iq_' . $type . '_chart_tooltip_color'] : '#000000';?>',
                                fontSize: '<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_font_size']) ? $settings['iq_' . $type . '_chart_tooltip_font_size'] : '';?>',
                                bold: '<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_bold']) && $settings['iq_' . $type . '_chart_tooltip_bold'] == 'yes' ? 'true' : 'false';?>',
                                italic: '<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_italic']) && $settings['iq_' . $type . '_chart_tooltip_italic'] == 'yes' ? 'true' : 'false';?>'
                            },
                            trigger: '<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_trigger']) ? $settings['iq_' . $type . '_chart_tooltip_trigger'] : '';?>'
                        }
                    };

                    if ('<?php echo !empty($settings['iq_' . $type . '_google_chart_region']) ?>') {
                        options.region = '<?php echo !empty($settings['iq_' . $type . '_google_chart_region']) ? $settings['iq_' . $type . '_google_chart_region'] : '';?>';
                        options.displayMode = 'region';
                        options.resolution = 'provinces';
                    }
                    if('<?php echo $settings['iq_' . $type . '_google_chart_legend_show'] === 'yes' ?>'){
                        options.legend = {
                            textStyle: {
                                color: '<?php echo !empty($settings['iq_' . $type . '_google_legend_color']) ? $settings['iq_' . $type . '_google_legend_color'] : '#000000';?>',
                                fontSize: '<?php echo !empty($settings['iq_' . $type . '_google_legend_size']) ? $settings['iq_' . $type . '_google_legend_size'] : '';?>',
                                bold: '<?php echo !empty($settings['iq_' . $type . '_google_legend_bold']) && $settings['iq_' . $type . '_google_legend_bold'] == 'yes' ? 'true' : 'false';?>',
                                italic: '<?php echo !empty($settings['iq_' . $type . '_google_legend_italic']) && $settings['iq_' . $type . '_google_legend_italic'] == 'yes' ? 'true' : 'false';?>'
                            },
                            numberFormat: '<?php echo !empty($settings['iq_' . $type . '_google_legend_format']) && $settings['iq_' . $type . '_google_legend_format'] == 'yes' ? '.###' : '';?>'
                        }
                    }else{
                        options.legend = 'none';
                    }
                    if (typeof graphinaGoogleChartInit !== "undefined") {
                        graphinaGoogleChartInit(
                            document.getElementById('geo_google_chart<?php esc_attr_e($mainId); ?>'),
                            {
                                ele:document.getElementById('geo_google_chart<?php esc_attr_e($mainId); ?>'),
                                options: options,
                                series: data,
                                animation: true,
                                renderType:'GeoChart',
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


Plugin::instance()->widgets_manager->register(new Geo_google_chart());