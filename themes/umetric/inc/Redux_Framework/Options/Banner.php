<?php

/**
 * Umetric\Utility\Redux_Framework\Options\Banner class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Banner extends Component
{

    public function __construct()
    {
        $this->set_widget_option();
    }

    protected function set_widget_option()
    {
        Redux::set_section($this->opt_name, array(
            'title' => esc_html__('Banner Settings', 'umetric'),
            'id'    => 'banner',
            'icon'  => 'el el-cog',
            'desc'  => esc_html__('This section contains options for Page Breadcrumbs Area.', 'umetric'),
            'fields' => array(

                array(
                    'id' => 'info_' . rand(10, 1000) ,
                    'type' => 'info',
                    'style' => 'custom',
                    'title' => __('Banner Layout Options', 'umetric') ,
                ) ,

                array(
                    'id' => 'section-general'. rand(10, 1000) ,
                    'type' => 'section',
                    'indent' => true
                ) ,
        
                array(
                    'id'      => 'bg_image',
                    'type'    => 'image_select',
                    'title'   => esc_html__( 'Select Image', 'umetric' ),
                    'subtitle' => esc_html__( 'A preview of the selected image will appear underneath the select box.', 'umetric' ),
                    'options' => array(
                        '1'      => array(
                            'alt' => 'Style1',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-1.jpg',
                        ),
                        '2'      => array(
                            'alt' => 'Style2',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-2.jpg',
                        ),
                        '3'      => array(
                            'alt' => 'Style3',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-3.jpg',
                        ),
                        '4'      => array(
                            'alt' => 'Style4',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-4.jpg',
                        ),
                        '5'      => array(
                            'alt' => 'Style5',
                            'img' => get_template_directory_uri() . '/assets/images/redux/bg-5.jpg',
                        ),
                    ),
                    'default' => '2'
                ),

                array(
                    'id'       => 'banner_side_image',         
                    'type'     => 'media',
                    'url'      => false,
                    'title'    => esc_html__( 'Set Banner Side Image','umetric'),
                    'read-only'=> false,
                    'required'  => array( 'bg_image', '=', '6' ),            
                    'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/redux/bg-1.jpg' ),
                ), 
                array(
                    'id'        => 'display_banner',
                    'type'      => 'button_set',
                    'title'     => esc_html__( 'Display Banner','umetric'),
                    'options'   => array(
                                    'yes' => esc_html__('Yes','umetric'),
                                    'no' => esc_html__('No','umetric')
                                ),
                    'default'   => esc_html__('yes','umetric')
                ),
        
                array(
                    'id'        => 'display_breadcrumbs',
                    'type'      => 'button_set',
                    'title'     => esc_html__( 'Display Breadcrumbs on Banner','umetric'),
                    'options'   => array(
                                    'yes' => esc_html__('Yes','umetric'),
                                    'no' => esc_html__('No','umetric')
                                ),
                    'required'  => array( 'display_banner', '=', 'yes' ),
                 
                        'default'   => esc_html__('yes','umetric')
                ),
        
                array(
                    'id'        => 'display_title',
                    'type'      => 'button_set',
                    'title'     => esc_html__( 'Display Title on Banner','umetric'),
                    'options'   => array(
                                    'yes' => esc_html__('Yes','umetric'),
                                    'no' => esc_html__('No','umetric')
                                ),
                    'required'  => array( 'display_banner', '=', 'yes' ),
                 
                        'default'   => esc_html__('yes','umetric')
                ),
        
                array(
                    'id'            => 'breadcrumbs_color',
                    'type'          => 'color',
                    'title'         => esc_html__( 'Set Breadcrumb Color', 'umetric' ),
                    'subtitle'      => esc_html__( 'Choose Title Color', 'umetric' ),
                    'mode'          => 'background',
                    'transparent'   => false
                ),
        
                 array(
                    'id'            => 'breadcrumbs_hover_color',
                    'type'          => 'color',
                    'title'         => esc_html__( 'Set Breadcrumb Active Color', 'umetric' ),
                    'subtitle'      => esc_html__( 'Choose Title Color', 'umetric' ),
                    'mode'          => 'background',
                    'transparent'   => false
                ),
                array(
                    'id'            => 'bg_title_color',
                    'type'          => 'color',
                    'title'         => esc_html__( 'Set Title Color', 'umetric' ),
                    'subtitle'      => esc_html__( 'Choose Title Color', 'umetric' ),
                    'mode'          => 'background',
                    'transparent'   => false
                ),
                
                array(
                    'id'       => 'bg_type',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Background Set Option', 'umetric' ),
                    'subtitle' => esc_html__( 'Select this option for Background Type color or image and video.', 'umetric' ),
                    'options'  => array(
                        '1' => 'Color',
                        '2' => 'Image'
                    ),
                    'default'  => '1'
                ),
        
                array(
                    'id'       => 'banner_image',         
                    'type'     => 'media',
                    'url'      => false,
                    'title'    => esc_html__( 'Set Background Image','umetric'),
                    'read-only'=> false,
                    'required'  => array( 'bg_type', '=', '2' ),
                    'subtitle' => esc_html__( 'Upload Image for your background.','umetric'),
                    'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/redux/bg-1.jpg' ),
                ), 
        
                array(
                    'id'            => 'bg_color',
                    'type'          => 'color',
                    'title'         => esc_html__( 'Set Background Color', 'umetric' ),
                    'subtitle'      => esc_html__( 'Choose Background Color', 'umetric' ),
                    'required'  => array( 'bg_type', '=', '1' ),
                    'mode'          => 'background',
                    'transparent'   => false
                ),
        
                array(
                    'id'       => 'bg_opacity',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Background Opacity Color', 'umetric' ),
                    'required' => array( 
                        array('bg_type','!=','1') 
                    ),
                    'subtitle' => esc_html__( 'Select this option for Background Opacity Color.', 'umetric' ),
                    'options'  => array(
                        '1' => 'None',
                        '2' => 'Dark',
                        '3' => 'Custom'
                    ),
                    'default'  => '1'
                ),
        
                array(
                    'id'            => 'opacity_color',
                    'type'          => 'color_rgba',
                    'title'         => esc_html__( 'Opacity color', 'umetric' ),
                    'required'  => array( 'bg_opacity', '=', '3' ),
                    'subtitle'      => esc_html__( 'Choose body Gradient background color', 'umetric' ),
                    'default'       => 'rgba(2, 13, 30, 0.9)',
                    'transparent'   => false
                ),


            )
        ));
    }
}
