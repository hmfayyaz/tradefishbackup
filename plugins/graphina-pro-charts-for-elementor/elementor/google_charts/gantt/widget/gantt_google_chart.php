<?php

namespace Elementor;

use Elementor\Core\Schemes\Typography as Scheme_Typography;

class Gantt_google_chart extends Widget_Base
{

    public $defaultLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan1', 'Feb1', 'Mar1', 'Apr1', 'May1', 'Jun1', 'July1', 'Aug1', 'Sep1', 'Oct1', 'Nov1', 'Dec1', 'Jan2', 'Feb2', 'Mar2', 'Apr2', 'May2', 'Jun2', 'July2', 'Aug2',];

    public function __construct($data = [], $args = null)
    {
        wp_register_script('googlecharts-min', GRAPHINA_LITE_URL . '/elementor/js/gstatic/loader.js', [], GRAPHINA_LITE_CURRENT_VERSION, true);
        parent::__construct($data, $args);
    }

    public function get_script_depends()
    {
        return [
            'googlecharts-min'
        ];
    }

    public function get_name()
    {
        return 'gantt_google_chart';
    }

    public function get_title()
    {
        return 'Gantt';
    }

    public function get_icon()
    {
        return 'graphina-google-gantt-chart';
    }

    public function get_categories()
    {
        return ['iq-graphina-google-charts'];
    }

    public function get_chart_type()
    {
        return 'gantt_google';
    }

    public function register_controls()
    {
        $type = $this->get_chart_type();
        $this->color = graphina_colors('color');
        $this->gradientColor = graphina_colors('gradientColor');

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type, 0, true);


        /**
         * BOF Chart Setting Section-----------------------------------------------------------------
         */

        $this->start_controls_section(
            'iq_' . $type . '_section_2_chart_setting_element',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),
            ]
        );

        // Chart Background
        $this->add_control(
            'iq_' . $type . '_section_chart_heading',
            [
                'label' => esc_html__('Chart Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_2_chart_background',
            [
                'label' => esc_html__('Background Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
            ]
        );


        $this->add_control(
            'iq_' . $type . '_section_label_heading',
            [
                'label' => esc_html__('Lebel Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'iq_' . $type . '_section_2_chart_label_size',
            [
                'label' => esc_html__('Label Font Size (PX)', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => '12'
            ]
        );

        // Arrow Settings
        $this->add_control(
            'iq_' . $type . '_section_arrow_setting_info',
            [
                'label' => esc_html__('Arrow Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_2_chart_arrow_style',
            [
                'label' => esc_html__('Arrow Style', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '40' => esc_html__('Arrow', 'graphina-charts-for-elementor'),
                    '100' => esc_html__('Line', 'graphina-charts-for-elementor'),
                ],
                'default' => '40',
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_2_chart_arrow_width',
            [
                'label' => esc_html__('Arrow Width (PX)', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => '1',
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_2_chart_arrow_color',
            [
                'label' => esc_html__('Arrow Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_2_chart_arrow_radius',
            [
                'label' => esc_html__('Arrow Radius', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );


        $this->add_control(
            'iq_' . $type . '_section_additional_info',
            [
                'label' => esc_html__('Additional Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'iq_' . $type . '_section_grid_line_heading',
            [
                'label' => esc_html__('Grid Lines', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_3_chart_grid_line',
            [
                'label' => esc_html__('Grid Lines Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_on' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => '',
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_3_chart_grid_line_stoke',
            [
                'label' => esc_html__('Grid Stoke Size (PX)', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'default' => '0',
                'condition' => [
                    'iq_' . $type . '_section_3_chart_grid_line' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'iq_' . $type . '_section_3_chart_grid_line_color',
            [
                'label' => esc_html__('Grid Stoke Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'iq_' . $type . '_section_3_chart_grid_line' => 'yes'
                ],
            ]
        );


        $this->end_controls_section();
        /**
         * EOF Chart Setting Section--------------------------------------------------------------------
         */


        /**
         * BOF Element Section
         */
        $this->start_controls_section(
            'iq_' . $type . '_section_3_elements',
            [
                'label' => esc_html__('Elements', 'graphina-charts-for-elementor'),
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'iq_' . $type . '_chart_value_3_element_name',
            [
                'label' => 'Element Name',
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Add Element Name', 'graphina-charts-for-elementor'),
                'default' => "Task"
            ]
        );

        $repeater->add_control(
            'iq_' . $type . '_chart_value_3_element_resource',
            [
                'label' => 'Element Resource',
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Add Element Resource', 'graphina-charts-for-elementor'),
                'default' => ""
            ]
        );

        $repeater->add_control(
            'iq_' . $type . '_chart_value_3_element_start_date',
            [
                'label' => 'Start Date',
                'type' => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => false,
                ],
                'placeholder' => esc_html__('Start Date', 'graphina-charts-for-elementor'),
            ]
        );

        $repeater->add_control(
            'iq_' . $type . '_chart_value_3_element_end_date',
            [
                'label' => 'End Date',
                'type' => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => false,
                ],
                'placeholder' => esc_html__('End Date', 'graphina-charts-for-elementor'),
            ]
        );

        $repeater->add_control(
            'iq_' . $type . '_chart_value_3_element_percent_complete',
            [
                'label' => 'Percent Complete',
                'type' => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Percent Complete', 'graphina-charts-for-elementor'),
                'max' => 100,
                'min' => 0,
                'default' => rand(10, 100)
            ]
        );

        $repeater->add_control(
            'iq_' . $type . '_chart_sql_builder_refresh',
            [
                'label' => esc_html__('Refresh', 'graphina-pro-charts-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'refresh',
                'options' => [
                    "refresh" => [
                        'title' => esc_html__('Classic', 'graphina-pro-charts-for-elementor'),
                        'icon' => 'fas fa-sync'
                    ]
                ],
                'description' => esc_html__('Click if Dependencies column list is showing empty', 'graphina-pro-charts-for-elementor'),

            ]
        );


        $repeater->add_control(
            'iq_' . $type . '_chart_value_3_element_dependencies',
            [
                'label' => 'Dependencies',
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'placeholder' => esc_html__('Dependencies', 'graphina-charts-for-elementor'),
                'options' => ''
            ]
        );


        $this->add_control(
            'iq_' . $type . '_value_list_3_1_repeaters',
            [
                'label' => esc_html__('Values', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->ganttDataGenerator($type, 5),
                'title_field' => '{{{ iq_' . $type . '_chart_value_3_element_name }}}',
            ]
        );

        $this->end_controls_section();
        /**
         * EOF Element Section
         */
        graphina_style_section($this, $type);

        graphina_card_style($this, $type);

        graphina_chart_style($this, $type);

        graphina_chart_filter_style($this, $type);

        if (function_exists('graphina_pro_password_style_section')) {
            graphina_pro_password_style_section($this, $type);
        }
    }

    protected function ganttDataGenerator($type = '', $count = 3)
    {
        $result = [];
        for ($j = 1; $j <= $count; $j++) {
            $start = graphina_getRandomDate(date('Y-m-d'), 'Y-m-d', ['day' => rand(0, 5)]);
            $end = graphina_getRandomDate(date('Y-m-d', strtotime($start)), 'Y-m-d', ['day' => rand(0, 5)]);
            $result[] = [
                'iq_' . $type . '_chart_value_3_element_name' => 'Task ' . $j,
                'iq_' . $type . '_chart_value_3_element_percent_complete' => rand(10, 100),
                'iq_' . $type . '_chart_value_3_element_end_date' => $end,
                'iq_' . $type . '_chart_value_3_element_start_date' => $start,
            ];
        }
        return $result;
    }

    public function render()
    {

        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();
        $mainId = graphina_widget_id($this);
        // BOF Dynamic Data
        $data = ['series' => [], 'category' => []];
        $dataTypeOption = $settings['iq_' . $type . '_chart_data_option'] === 'manual' ? 'manual' : $settings['iq_' . $type . '_chart_dynamic_data_option'];
        if ($settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            $data = $this->graphinaGoogleChartDynamicData($data);
            if (empty($data['series'])) {
                echo "<pre><b>" . (esc_html__('Data Not Found.', 'graphina-pro-charts-for-elementor')) . "</b></pre>";
                return;
            }
            if (isset($data['fail']) && $data['fail'] === 'permission') {
                switch ($dataTypeOption) {
                    case "google-sheet":
                        echo "<pre><b>" . esc_html__('Please check file sharing permission and "Publish As" type is CSV or not. ', 'graphina-pro-charts-for-elementor') . "</b><small><a target='_blank' href='https://youtu.be/Dv8s4QxZlDk'>" . esc_html__('Click for reference.', 'graphina-pro-charts-for-elementor') . "</a></small></pre>";
                        return;
                        break;
                    case "remote-csv":
                    default:
                        echo "<pre><b>" . (isset($data['errorMessage']) ? $data['errorMessage'] : esc_html__('Please check file sharing permission.', 'graphina-pro-charts-for-elementor')) . "</b></pre>";
                        return;
                        break;
                }
            }
        }

        $lineData = [];
        if ($settings['iq_' . $type . '_chart_data_option'] != 'manual') {
            if (in_array($settings['iq_' . $type . '_chart_dynamic_data_option'], ['remote-csv','google-sheet','csv'])) {
                $lineData = $data['series'];
                $horizontal_data = [];
                foreach ($lineData as $key => $row) {
                    $values = explode("_,_", $row);
                    foreach ($values as $index => $value) {
                        $horizontal_data[$index][] = $value;
                    }
                }
                array_shift($horizontal_data);
                foreach ($horizontal_data as $index => $value) {
                    array_unshift($value, $index + 1);
                    $horizontal_data[$index] = $value;
                }
                $horizontal_data = array_map(function ($row) {
                    $row =  implode("_,_", $row);
                    return $row;
                }, $horizontal_data);


                $lineData = $horizontal_data;

            }
            if (in_array($settings['iq_' . $type . '_chart_dynamic_data_option'], ['csv', 'google-sheet', 'api'])) {
                $lineData = $data['series'];
            }
        } else {
            $dependColumn = [];
            if (!empty($settings['iq_' . $type . '_value_list_3_1_repeaters'])) {
                foreach ($settings['iq_' . $type . '_value_list_3_1_repeaters'] as $key => $value) {
                    // Depended values
                    $dependColumn[$value["_id"]] = $value['iq_' . $type . '_chart_value_3_element_name'];
                    $depend = '';
                    if (!empty($value['iq_' . $type . '_chart_value_3_element_dependencies'])) {
                        $depend = implode(',', $value['iq_' . $type . '_chart_value_3_element_dependencies']);
                    }
                    $temp = [
                        $value["_id"],
                        $value['iq_gantt_google_chart_value_3_element_name'],
                        !empty($value['iq_' . $type . '_chart_value_3_element_resource']) ? $value['iq_' . $type . '_chart_value_3_element_resource'] : 'resources' . $key,
                        $value['iq_gantt_google_chart_value_3_element_start_date'],
                        $value['iq_gantt_google_chart_value_3_element_end_date'],
                        'null',
                        $value['iq_gantt_google_chart_value_3_element_percent_complete'],
                        $depend
                    ];
                    $lineData[] = implode("_,_", $temp);
                }
            }
?>
            <script>
                jQuery(document).ready(function() {
                    var ele = jQuery(window.parent.document).find('.elementor-control-iq_gantt_google_value_list_3_1_repeaters .elementor-repeater-fields');
                    var depend_columns = JSON.parse('<?php echo json_encode($dependColumn); ?>');
                    var request_fields = JSON.parse('<?php echo json_encode($settings); ?>');
                    jQuery.each(ele, function(key, value) {
                        var depend_option_tag = '<option value="" >Select</option>';
                        var selectField = jQuery(value).find('[data-setting="iq_gantt_google_chart_value_3_element_dependencies"]');
                        var id = jQuery(value).find('[data-setting="_id"]').val();
                        if (selectField.length > 0 && Object.keys(depend_columns).length > 0) {
                            for (var key1 in depend_columns) {
                                if (id != key1) {
                                    let depend_columns_selected_field = '';
                                    if (request_fields['iq_gantt_google_value_list_3_1_repeaters'][key]['iq_gantt_google_chart_value_3_element_dependencies'] == key1) {
                                        depend_columns_selected_field = 'selected';
                                    }
                                    depend_option_tag += '<option value="' + key1.toLowerCase() + '" ' + depend_columns_selected_field + ' > ' + depend_columns[key1] + '</option>';
                                }
                            }
                            selectField.html(depend_option_tag);
                        }
                    });

                });
            </script>
        <?php
        }
        $lineData = implode("[,]", $lineData);
        if (function_exists('graphina_chart_widget_content')) {
            graphina_chart_widget_content($this, $mainId, $settings);
        }
        if (isRestrictedAccess($type, $mainId, $settings, false) === false) {
        ?>
            <script type="text/javascript">
                (function($) {
                    'use strict';
                    if (parent.document.querySelector('.elementor-editor-active') !== null) {
                        if (typeof isInit === 'undefined') {
                            var isInit = {};
                        }
                        isInit['<?php esc_attr_e($mainId); ?>'] = false;
                        google.charts.load('current', {
                            'packages': ['gantt']
                        });
                        google.charts.setOnLoadCallback(drawChart);
                    }
                    document.addEventListener('readystatechange', event => {
                        // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                        if (event.target.readyState === "complete") {
                            if (typeof isInit === 'undefined') {
                                var isInit = {};
                            }
                            isInit['<?php esc_attr_e($mainId); ?>'] = false;
                            google.charts.load('current', {
                                'packages': ['gantt']
                            });
                            google.charts.setOnLoadCallback(drawChart);
                        }
                    })

                    function drawChart() {

                        var data = new google.visualization.DataTable();

                        data.addColumn('string', 'Task ID');
                        data.addColumn('string', 'Task Name');
                        data.addColumn('string', 'Resource');
                        data.addColumn('date', 'Start Date');
                        data.addColumn('date', 'End Date');
                        data.addColumn('number', 'Duration');
                        data.addColumn('number', 'Percent Complete');
                        data.addColumn('string', 'Dependencies');

                        let temp = "<?php echo $lineData ?>".split('[,]').map(function(x) {
                            return x.split('_,_').map(function(k, j) {
                                if (j === 3 || j === 4) {
                                    k = new Date(k);
                                }
                                if (j === 5) {
                                    k = null;
                                }
                                if (j === 7 && (k === 'null' || k === '0')) {
                                    k = null;
                                }
                                if (j === 6) {
                                    k = parseInt(k)
                                }
                                return k;
                            });
                        });
                        data.addRows(temp)

                        var options = {
                            gantt: {
                                arrow: {
                                    angle: <?php echo $settings['iq_' . $type . '_section_2_chart_arrow_style'];  ?>,
                                    width: <?php echo $settings['iq_' . $type . '_section_2_chart_arrow_width'];  ?>,
                                    color: '<?php echo $settings['iq_' . $type . '_section_2_chart_arrow_color'];  ?>',
                                    radius: <?php echo $settings['iq_' . $type . '_section_2_chart_arrow_radius']; ?>
                                },
                                labelStyle: {
                                    fontSize: <?php echo $settings['iq_' . $type . '_section_2_chart_label_size']  ?>,
                                },
                                backgroundColor: {
                                    // fill: '#000000',
                                },
                                innerGridHorizLine: {
                                    stroke: '<?php if ($settings['iq_' . $type . '_section_3_chart_grid_line_color'] != "") {
                                                    echo $settings['iq_' . $type . '_section_3_chart_grid_line_color'];
                                                } else {
                                                    echo '#fff';
                                                } ?>',
                                    strokeWidth: <?php if ($settings['iq_' . $type . '_section_3_chart_grid_line_stoke'] != "") {
                                                        echo $settings['iq_' . $type . '_section_3_chart_grid_line_stoke'];
                                                    } else {
                                                        echo '0';
                                                    } ?>,
                                },
                                innerGridTrack: {
                                    fill: '<?php echo $settings['iq_' . $type . '_section_2_chart_background'];  ?>'
                                },
                                innerGridDarkTrack: {
                                    fill: '<?php echo $settings['iq_' . $type . '_section_2_chart_background'];  ?>'
                                },
                                shadowEnabled: true,
                                trackHeight: 30
                            }
                        };

                        var element = document.getElementById('gantt_google_chart<?php esc_attr_e($mainId); ?>');

                        if (typeof graphinaGoogleChartInit !== "undefined") {
                            graphinaGoogleChartInit(
                                element, {
                                    ele: element,
                                    options: options,
                                    series: data,
                                    animation: true,
                                    renderType: 'Gantt',
                                    setting_date:<?php echo Plugin::$instance->editor->is_edit_mode()?  json_encode($settings) : 'null' ; ?>
                                },
                                '<?php esc_attr_e($mainId); ?>',
                                '<?php echo $this->get_chart_type(); ?>',
                            );
                        }
                    }
                }).apply(this, [jQuery]);
            </script>
<?php
        }
    }
    function graphinaGoogleChartDynamicData($data)
    {

        $mainId = graphina_widget_id($this);
        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();

        if ($settings['iq_' . $type . '_chart_data_option'] === 'firebase') {
            return apply_filters('graphina_addons_render_section', $data, $type, $settings);
        }

        $dataFormatType = 'gantt_google';

        if ($settings['iq_' . $type . '_chart_data_option'] === 'dynamic') {

            $dataTypeOption = $settings['iq_' . $type . '_chart_dynamic_data_option'];

            switch ($dataTypeOption) {
                case "csv":
                    $data = graphina_pro_parse_csv($settings, $type, $dataFormatType);
                    break;
                case "remote-csv":
                case "google-sheet":
                    $data = graphina_pro_get_data_from_url($type, $settings, $dataTypeOption, $mainId, $dataFormatType);
                    break;
                case "api":
                    $data = graphina_pro_chart_get_data_from_api($type, $settings, $dataFormatType, []);
                    break;
                case 'filter':
                    update_post_meta(get_the_ID(), $mainId, $settings['iq_' . $type . '_element_filter_widget_id']);
                    $data = apply_filters('graphina_extra_data_option', $data, $type, $settings, $settings['iq_' . $type . '_element_filter_widget_id']);
                    break;
            }
        }

        return $data;
    }
}

Plugin::instance()->widgets_manager->register(new Gantt_google_chart());
