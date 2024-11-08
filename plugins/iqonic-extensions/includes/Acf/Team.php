<?php

namespace Iqonic\Acf;

class Team
{
    public function __construct()
    {
        if (defined('IQONIC_EXTENSION_VERSION')) {
            $this->version = IQONIC_EXTENSION_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'iqonic-extension';

        $this->set_team_options();
    }

    public function set_team_options()
    {
        if (function_exists('acf_add_local_field_group')) {
            // Page Options
            acf_add_local_field_group(array(
                'key' => 'group_46Cg7N74r8t81',
                'title' => 'Social Details',
                'fields' => array(

                    array(
                        'key' => 'field_team_facebook',
                        'label' => 'Facebook',
                        'name' => 'iqonic_team_facebook',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,

                        'wrapper' => array(
                            'width' => '20%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => '',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),

                    array(
                        'key' => 'field_team_twitter',
                        'label' => 'Twitter',
                        'name' => 'iqonic_team_twitter',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,

                        'wrapper' => array(
                            'width' => '20%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => '',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ), 
                    array(
                        'key' => 'field_team_google',
                        'label' => 'Google',
                        'name' => 'iqonic_team_google',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,

                        'wrapper' => array(
                            'width' => '20%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => '',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),                                     
                    array(
                        'key' => 'field_team_insta',
                        'label' => 'Instagram',
                        'name' => 'iqonic_team_insta',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,

                        'wrapper' => array(
                            'width' => '20%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => '',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_team_github',
                        'label' => 'Github',
                        'name' => 'iqonic_team_github',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,

                        'wrapper' => array(
                            'width' => '20%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => '',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_team_pinterest',
                        'label' => 'Pinterest',
                        'name' => 'iqonic_team_pinterest',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,

                        'wrapper' => array(
                            'width' => '20%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => '',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_team_behance',
                        'label' => 'Behance',
                        'name' => 'iqonic_team_behance',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,

                        'wrapper' => array(
                            'width' => '20%',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => '',
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    )
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'iqonicteam',
                        ),

                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        }
    }
}
