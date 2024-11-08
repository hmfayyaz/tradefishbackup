<?php

namespace Iqonic\Acf;
 
class General
{
    public function __construct()
    {
        if (defined('IQONIC_EXTENSION_VERSION')) {
            $this->version = IQONIC_EXTENSION_VERSION;
        } else {
            $this->version = '1.1.0';
        }
        $this->plugin_name = 'iqonic-extension';

        $this->set_general_options();
    }

    public function get_hf_layout($type = 'header')
    {
        $args = array(
            'post_type'         => 'iqonic_hf_layout',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'meta_key'          => '_layout_meta_key',
            'meta_value'        => $type,
        );
        global $post;
        $wp_query = get_posts($args);
        $iqonic_header_list = [];

        if ($wp_query) {
            foreach ($wp_query as $header) {
                $iqonic_header_list[$header->post_name] = $header->post_title;
            }
        }
        return $iqonic_header_list;
    }

    public function set_general_options()
    {
        if (function_exists('acf_add_local_field_group')) :

             // Page Options
             acf_add_local_field_group(array(
            'key' => 'group_46Cg7N74r8t811VLFfR6',
            'title' => 'Page Options',
            'fields' => array(

            // Body Option
             array(
                'key' => 'field_sth54fsf22fsd',
                'label' => 'Body Settings',
                'name' => 'body_set',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ) ,

            array(
                'key' => 'key_body',
                'label' => 'Body Layout',
                'name' => 'acf_body_layout',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'layout' => 'table',
                'sub_fields' => array(

                    array(
                        'key' => 'body_variation',
                        'label' => 'Choose body background type',
                        'name' => 'body_variation',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'choices' => array(
                            'default' => 'Default',
                            'has_body_color' => 'Color',
                            'has_body_image' => 'Image',                           
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ) ,
                    
                    array(
                        'key' => 'field_body_image',
                        'label' => 'Body background image',
                        'name' => 'acf_body_image',
                        'type' => 'image',
                        'instructions' => '',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'body_variation',
                                    'operator' => '==',
                                    'value' => 'has_body_image',
                                ) ,
                            ) ,
                        ) ,
                        'required' => 0,
                        
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),

                    array(
                        'key' => 'field_body_color',
                        'label' => 'Body background color',
                        'name' => 'acf_body_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'body_variation',
                                    'operator' => '==',
                                    'value' => 'has_body_color',
                                ) ,
                            ) ,
                        ) ,
                        'required' => 0,
                        
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                ) ,
            ) ,

            // Banner Settings
            array(
                'key' => 'field_7a2p3jBTfCbZ17c4cciu',
                'label' => 'Banner Settings',
                'name' => 'banner',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ),

            array(
                'key' => 'field_QnF1',
                'label' => 'Display Banner',
                'name' => 'display_banner',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array(
                            'default' => 'Default',
                            'yes' => 'yes',
                            'no' => 'no',                            
                        ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'message' => '',
                'default_value' => 'default',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),

            array(
                'key' => 'key_pjros',
                'label' => 'Breadcrumbs Layout',
                'name' => 'breadcumb_layout',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_QnF1',
                            'operator' => '==',
                            'value' => 'yes',
                        ) ,
                    ) ,
                ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'layout' => 'table',
                'sub_fields' => array(
                    array(
                        'key' => 'field_WGCt5cd3bf759qMh8gRk',
                        'label' => 'Display Title',
                        'name' => 'display_title',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_QnF1',
                                    'operator' => '==',
                                    'value' => 'yes',
                                ) ,
                            ) ,
                        ) ,
                        'choices' => array(
                            
                            'yes' => 'yes',
                            'no' => 'no',                            
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'message' => '',
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ) ,
                    

                    array(
                        'key' => 'field_3PnJp21d93eM5Nrs8422',
                        'label' => 'Display Breadcrumbs',
                        'name' => 'display_breadcumb',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'message' => '',
                        'choices' => array(
                            
                            'yes' => 'yes',
                            'no' => 'no',                            
                        ) ,
                        'default_value' => 'default',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ) ,

                    

                ) ,
            ) ,

            array(
                'key' => 'key_banner_back',
                'label' => 'Banner Background',
                'name' => 'banner_back_option',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_QnF1',
                            'operator' => '==',
                            'value' => 'yes',
                        ) ,
                    ) ,
                ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'layout' => '',
                'sub_fields' => array(
                    array(
                        'key' => 'field_ybmis',
                        'label' => 'Background',
                        'name' => 'banner_background_type',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'choices' => array(
                            'default' => 'Default',
                            'color' => 'Color',
                            'image' => 'Image'
                        ) ,
                        'allow_null' => 0,
                        'default_value' => 'default',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ) ,
                    array(
                        'key' => 'field_egeo',
                        'label' => 'Background Color',
                        'name' => 'banner_background_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_ybmis',
                                    'operator' => '==',
                                    'value' => 'color',
                                ) ,
                            ) ,
                        ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'default_value' => '',
                    ),

                    array(
                        'key' => 'field_5d6d06b7dca4c',
                        'label' => 'Background Image',
                        'name' => 'banner_background_image',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_ybmis',
                                        'operator' => '==',
                                        'value' => 'image',
                                    ) ,
                                ) ,
                            ) ,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),

                    array(
                        'key' => 'field_ybmisxy',
                        'label' => 'Background Size',
                        'name' => 'banner_background_size',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                         'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_ybmis',
                                            'operator' => '==',
                                            'value' => 'image',
                                        ) ,
                                    ) ,
                                ) ,
                        'wrapper' => array(
                            'width' => '100',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'choices' => array(
                            'auto' => 'auto',
                            'cover' => 'cover',
                            'contain' => 'contain'
                        ) ,
                        'allow_null' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ) ,

                     array(
                        'key' => 'field_ybmiskr',
                        'label' => 'Background Repeat',
                        'name' => 'banner_background_repeat',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                         'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_ybmis',
                                            'operator' => '==',
                                            'value' => 'image',
                                        ) ,
                                    ) ,
                                ) ,
                        'wrapper' => array(
                            'width' => '100',
                            'class' => '',
                            'id' => '',
                        ) ,                        
                        'choices' => array(
                            'no-repeat' => 'no-repeat',
                            'repeat' => 'repeat',
                            'repeat-y' => 'repeat-y',
                            'repeat-x' => 'repeat-x',
                            'initial' => 'initial',
                            'inherit' => 'inherit'
                        ) ,
                        'allow_null' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ) ,

                ) ,
            ) ,

            // Header Opion
           
            array(
                'key' => 'field_TfCbZ17c4cciu',
                'label' => 'Header Options',
                'name' => 'header',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ) ,

            //dark header
            array(
                'key' => 'key_dark_header',
                'label' => 'Use Dark Color',
                'name' => 'name_dark_header',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'layout' => 'table',
                'sub_fields' => array(

                    array(
                            'key' => 'acf_menu_has_dark',
                            'label' => 'Select yes if you want dark color option',
                            'name' => 'name_menu_has_dark',
                            'type' => 'button_group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'choices' => array(
                                        'yes' => 'yes',
                                        'no' => 'no',                            
                                    ) ,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'message' => '',
                            'default_value' => 'no',
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),

                        array(
                            'key' => 'header_back_color',
                            'label' => 'Select other dark color than default',
                            'name' => 'name_back_color',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'acf_menu_has_dark',
                                        'operator' => '==',
                                        'value' => 'yes',
                                    ) ,
                                ) ,
                            ) ,
                            'required' => 0,
                            'default_value' => '#000000',
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',

                        ),
                                
                    ) ,

                 ) ,
                    
                //header layout

                array(
                    'key' => 'acf_key_header_switch',
                    'label' => 'Display Header ?',
                    'name' => 'display_header',
                    'type' => 'button_group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'choices' => array(
                        'yes' => 'yes',
                        'no' => 'no',
                    ),
                    'wrapper' => array(
                        'width' => '25%',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 'yes',
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                    
                array(
                    'key' => 'key_header_variation',
                    'label' => '',
                    'name' => 'header_layout_style',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ) ,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'acf_key_header_switch',
                                'operator' => '==',
                                'value' => 'yes',
                            ),
                            
                            
                        ),
                    ),
                    'layout' => 'table',
                    'sub_fields' => array(

                        array(
                            'key' => 'header_layout_switch',
                            'label' => 'Header Layout',
                            'name' => 'header_layout_type',
                            'type' => 'button_group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'acf_key_header_switch',
                                        'operator' => '==',
                                        'value' => 'yes',
                                    ),
                                ),
                            ),
                            'choices' => array(
                                'default' => 'Default',
                                'custom' => 'Custom',
                            ),
                            'wrapper' => array(
                                'width' => '25%',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 'default',
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),

                        array(
                            'key' => 'header_layout_key',
                            'label' => 'Select Header',
                            'name' => 'header_layout_name',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_layout_switch',
                                        'operator' => '==',
                                        'value' => 'custom',
                                    ),
                                    array(
                                        'field' => 'acf_key_header_switch',
                                        'operator' => '==',
                                        'value' => 'yes',
                                    ),

                                ),
                            ),
                            'wrapper' => [
                                'width' => '25%',
                                'class' => '',
                                'id' => '',
                            ],
                            'choices' => $this->get_hf_layout(),
                            'default_value' => [],
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 1,
                            'ajax' => 0,
                            'return_format' => 'value',
                            'placeholder' => '',
                        ),

                        array(
                            'key' => 'header_layout_position_switch',
                            'label' => 'Header Layout Position',
                            'name' => 'header_layout_position',
                            'type' => 'button_group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_layout_switch',
                                        'operator' => '==',
                                        'value' => 'custom',
                                    ),
                                ),
                            ),
                            'choices' => array(
                                'default' => 'Default',
                                'horizontal' => 'Horizontal',
                                'vertical' => 'Vertical',
                            ),
                            'wrapper' => array(
                                'width' => '25%',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 'default',
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),

                        array(
                            'key' => 'field_vertical_header_width',
                            'label' => 'Header Width',
                            'name' => '_vertical_header_width',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_layout_position_switch',
                                        'operator' => '==',
                                        'value' => 'vertical',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '15%',
                                'class' => '',
                                'id' => '',
                            ),
                            'placeholder' => '25px',
                            'message' => '',
                            'default_value' => '',
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),

                        array(
                            'key'               => 'header_position_switch',
                            'label'             => 'Header Position',
                            'name'              => 'header_position',
                            'type'              => 'button_group',
                            'instructions'      => '',
                            'required'          => 0,
                            'conditional_logic' => array(
                                array(
                                    
                                    array(
                                        'field' => 'header_layout_position_switch',
                                        'operator' => '==',
                                        'value' => 'horizontal',
                                    ),
                                ),
                            ),
                            'choices' => array(
                                'default'   => 'Default',
                                'over'      => 'Over',
                                'under'     => 'Under',
                            ),
                            'wrapper' => array(
                                'width' => '25%',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 'default',
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),
    
                        array(
                            'key' => 'header_menu_style',
                            'label' => 'Header Menu Style',
                            'name' => 'header_menu_variation',
                            'type' => 'button_group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    
                                    array(
                                        'field' => 'header_layout_switch',
                                        'operator' => '==',
                                        'value' => 'default',
                                    ),
                                ),
                            ),
                            'choices' => array(
                                'default' => 'Default',
                                '1' => 'Style 1',
                                '2' => 'Style 2',                            
                            ) ,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'message' => '',
                            'default_value' => 'default',
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ) ,

                        array(
                            'key' => 'ver_menu_collapsed',
                            'label' => 'Header Expanded/Collapsed',
                            'name' => 'header_menu_collapsed',
                            'type' => 'button_group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                        array(
                                            array(
                                                'field' => 'header_menu_style',
                                                'operator' => '==',
                                                'value' => '2',
                                            ) ,
                                        ) ,
                                    ) ,
                            'choices' => array(
                                'acf_ver_expanded' => 'Expanded',
                                'acf_ver_collapsed' => 'Collapsed',                            
                            ) ,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'message' => '',
                            'default_value' => 'default',
                            'ui' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ) ,                                              

                    ),
                ),

                array(
                    'key' => 'header_logovariation',
                    'label' => 'Set Header Logo as',
                    'name' => 'header_logo_variation',
                    'type' => 'button_group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'header_layout_switch',
                                'operator' => '==',
                                'value' => 'default',
                            ),
                            
                        ),
                    ),
                    'choices' => array(
                        'default' => 'Default',
                        '1' => 'Image',
                        '2' => 'Text',                            
                    ) ,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ) ,
                    'message' => '',
                    'default_value' => 'default',
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ) ,

                array(
                    'key' => 'key_header',
                    'label' => '',
                    'name' => 'header_layout',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_logovariation',
                                        'operator' => '!=',
                                        'value' => 'default',
                                    ) ,
                                ) ,
                            ) ,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ) ,

                    'layout' => 'table',
                    'sub_fields' => array(
                    
                        array(
                            'key' => 'field_logo',
                            'label' => 'Logo as image',
                            'name' => 'header_as_logo',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_logovariation',
                                        'operator' => '==',
                                        'value' => '1',
                                    ) ,
                                    
                                ) ,
                            ) ,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),

                        //logo as image for vertical
                        array(
                            'key' => 'field_ver_logo',
                            'label' => 'Logo as image for vertical menu',
                            'name' => 'header_ver_as_logo',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_menu_style',
                                        'operator' => '==',
                                        'value' => '2',
                                    ) ,
                                    array(
                                        'field' => 'header_logovariation',
                                        'operator' => '==',
                                        'value' => '1',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),

                        array (
                            'key' => 'field_header_text',
                            'label' => 'Logo as Text',
                            'name' => 'logo_as_text',
                            'type' => 'text',
                            'prefix' => '',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_logovariation',
                                        'operator' => '==',
                                        'value' => '2',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),

                        array(
                            'key' => 'field_logo_tag',
                            'label' => 'Text Tag',
                            'name' => 'logo_text_tag',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_logovariation',
                                        'operator' => '==',
                                        'value' => '2',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'choices' => array(
                                'h1' => 'h1',
                                'h2' => 'h2',
                                'h3' => 'h3',
                                'h4' => 'h4',
                                'h5' => 'h5',
                                'h6' => 'h6'
                            ) ,
                            'default_value' => 'h2',
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'return_format' => 'value',
                            'ajax' => 0,
                            'placeholder' => '',
                        ) ,

                        array(
                            'key' => 'field_logo_color',
                            'label' => 'Logo Color',
                            'name' => 'logo_color_text',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_logovariation',
                                        'operator' => '==',
                                        'value' => '2',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'default_value' => '',
                        ) ,

                    ) ,
                ) ,

                //logo as text for  vertical 
                array(
                    'key' => 'key_ver_header_text',
                    'label' => 'Insert text for vertical menu',
                    'name' => 'ver_header_layout',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'header_menu_style',
                                'operator' => '==',
                                'value' => '2',
                            ) ,
                            array(
                                'field' => 'header_logovariation',
                                'operator' => '==',
                                'value' => '2',
                            ) ,
                        ) ,
                    ) ,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ) ,
                    'layout' => 'table',
                    'sub_fields' => array( 
                             
                        array (
                            'key' => 'field_ver_header_text',
                            'label' => 'Insert text as logo',
                            'name' => 'ver_logo_as_text',
                            'type' => 'text',
                            'prefix' => '',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),

                        array(
                            'key' => 'field_ver_logo_tag',
                            'label' => 'Text Tag',
                            'name' => 'ver_logo_text_tag',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'choices' => array(
                                'h1' => 'h1',
                                'h2' => 'h2',
                                'h3' => 'h3',
                                'h4' => 'h4',
                                'h5' => 'h5',
                                'h6' => 'h6'
                            ) ,
                            'default_value' => 'h2',
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'return_format' => 'value',
                            'ajax' => 0,
                            'placeholder' => '',
                        ) ,

                        array(
                            'key' => 'field_ver_logo_color',
                            'label' => 'Logo Color',
                            'name' => 'ver_logo_color_text',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'required' => 0,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'default_value' => '',
                        ) ,
                    ),
                ),


                // Sticky Header
                array(
                    'key' => 'header_stick_logovariation',
                    'label' => 'Set Sticky Header Logo as',
                    'name' => 'header_stick_logo_variation',
                    'type' => 'button_group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                                        array(
                                            array(
                                                'field' => 'header_menu_style',
                                                'operator' => '!=',
                                                'value' => '2',
                                            ) ,
                                            array(
                                                'field' => 'header_layout_switch',
                                                'operator' => '==',
                                                'value' => 'default',
                                            ),
                                        ) ,
                                    ) ,
                    'choices' => array(
                        'default' => 'Default',
                        '1' => 'Image',
                        '2' => 'Text',                            
                    ) ,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ) ,
                    'message' => '',
                    'default_value' => 'default',
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),

                array(
                    'key' => 'key_stick_header',
                    'label' => 'Logo',
                    'name' => 'header_stick_layout',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_stick_logovariation',
                                        'operator' => '!=',
                                        'value' => 'default',
                                    ) ,
                                    array(
                                        'field' => 'header_menu_style',
                                        'operator' => '!=',
                                        'value' => '2',
                                    ) ,
                                    array(
                                        'field' => 'header_layout_switch',
                                        'operator' => '==',
                                        'value' => 'default',
                                    ),
                                ) ,
                            ) ,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ) ,
                    'layout' => 'table',
                    'sub_fields' => array(
                    
                        array(
                            'key' => 'field_stick_logo',
                            'label' => 'Logo as image',
                            'name' => 'header_stick_as_logo',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_stick_logovariation',
                                        'operator' => '==',
                                        'value' => '1',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array (
                            'key' => 'field_stick_header_text',
                            'label' => 'Logo as Text',
                            'name' => 'logo_stick_as_text',
                            'type' => 'text',
                            'prefix' => '',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_stick_logovariation',
                                        'operator' => '==',
                                        'value' => '2',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                            'readonly' => 0,
                            'disabled' => 0,
                        ),
                        array(
                            'key' => 'field_stick_logo_tag',
                            'label' => 'Text Tag',
                            'name' => 'logo_stick_text_tag',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_stick_logovariation',
                                        'operator' => '==',
                                        'value' => '2',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'choices' => array(
                                'h1' => 'h1',
                                'h2' => 'h2',
                                'h3' => 'h3',
                                'h4' => 'h4',
                                'h5' => 'h5',
                                'h6' => 'h6'
                            ) ,
                            'default_value' => 'h2',
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'return_format' => 'value',
                            'ajax' => 0,
                            'placeholder' => '',
                        ) ,
                        array(
                            'key' => 'field_stick_logo_color',
                            'label' => 'Logo Color',
                            'name' => 'logo_stick_color_text',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'header_stick_logovariation',
                                        'operator' => '==',
                                        'value' => '2',
                                    ) ,
                                ) ,
                            ) ,
                            'wrapper' => array(
                                'width' => '25',
                                'class' => '',
                                'id' => '',
                            ) ,
                            'default_value' => '',
                        ) ,

                        ) ,
                    ) ,

            // Footer Options
            array(
                'key' => 'field_1gY7e',
                'label' => 'Footer Settings',
                'name' => 'footer',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ) ,

            array(
                'key' => 'acf_key_footer_switch',
                'label' => 'Display Footer',
                'name' => 'display_footer',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array(
                            'default' => 'Default',
                            'yes' => 'yes',
                            'no' => 'no',                            
                        ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'message' => '',
                'default_value' => 'default',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ) ,
            array(
                'key' => 'footer_layout_switch',
                'label' => 'Footer Layout',
                'name' => 'footer_layout_type',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'acf_key_footer_switch',
                            'operator' => '==',
                            'value' => 'yes',
                        ),
                    ),
                ),
                'choices' => array(
                    'default' => 'Default',
                    'custom' => 'Custom',
                ),
                'wrapper' => array(
                    'width' => '50%',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 'default',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),

            array(
                'key' => 'footer_layout_key',
                'label' => 'Select Footer',
                'name' => 'footer_layout_name',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'footer_layout_switch',
                            'operator' => '==',
                            'value' => 'custom',
                        ),
                    ),
                ),
                'wrapper' => [
                    'width' => '50%',
                    'class' => '',
                    'id' => '',
                ],
                'choices' => $this->get_hf_layout('footer'),
                'default_value' => [],
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),

            array(
                'key' => 'acf_key_footer',
                'label' => 'Customize Footer',
                'name' => 'acf_footer_options',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'footer_layout_switch',
                            'operator' => '==',
                            'value' => 'default',
                        ) ,
                    ) ,
                ) ,
                'choices' => array(
                            'default' => 'Default',
                            '1' => 'One Column',
                            '2' => 'Two Column',                            
                            '3' => 'Three Column',                            
                            '4' => 'Four Column',                            
                            '5' => '4+3+3+2 Column',                            
                        ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'message' => '',
                'default_value' => 'default',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ) ,

            array(
                'key' => 'field_WGC',
                'label' => 'Display top footer',
                'name' => 'display_top_footer',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        'field' => 'acf_key_footer_switch',
                        'operator' => '==',
                        'value' => 'yes'
                    )
                ),
                'choices' => array(
                    'default' => 'Default',
                    'yes' => 'yes',
                    'no' => 'no',                            
                ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'message' => '',
                'default_value' => 'default',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ) ,

               // Color Options
               array(
                'key' => 'field_1ge',
                'label' => 'Color Palette',
                'name' => 'color_pallete',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ) ,
            array(
                'key' => 'key_color_switch',
                'label' => 'Use Color Palette?',
                'name' => 'name_color_switch',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array(
                    'default' => 'Default',
                    'yes' => 'yes',
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 'default',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'key_color_pallete',
                'label' => 'Color Options',
                'name' => 'color_pallete',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'key_color_switch',
                            'operator' => '==',
                            'value' => 'yes',
                        ) ,
                    ) ,
                ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'layout' => 'table',
                'sub_fields' => array(

                    array(
                        'key' => 'field_primary_color',
                        'label' => 'Primary Color',
                        'name' => 'primary_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'default_value' => '',
                    ) ,

                    array(
                        'key' => 'field_secondary_color',
                        'label' => 'Secondary Color',
                        'name' => 'secondary_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'default_value' => '',
                    ) ,

                    array(
                        'key' => 'field_title_color',
                        'label' => 'Title Color',
                        'name' => 'title_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'default_value' => '',
                    ) ,

                    array(
                        'key' => 'field_sub_title_color',
                        'label' => 'Sub Title Color',
                        'name' => 'sub_title_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'default_value' => '',
                    ) ,

                    array(
                        'key' => 'field_Body_color',
                        'label' => 'Body Text Color',
                        'name' => 'Body_text_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ) ,
                        'default_value' => '',
                    ) ,
                ) ,
            ) ,

        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ) ,

            ) ,
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ) ,

            ) ,
            

            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'umetricteam',
                ) ,

            ) ,

             array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'portfolio',
                ) ,

            ) ,

              array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testimonial',
                ) ,

            ) ,

              array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'umetriccareer',
                ) ,

            ) ,
            
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
           
        endif;
    }
}
