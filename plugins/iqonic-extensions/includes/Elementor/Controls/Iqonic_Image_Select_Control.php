<?php
namespace Iqonic\Elementor\Controls;
use Elementor\Base_Data_Control;

class Iqonic_Image_Select_Control extends Base_Data_Control
{
    public function get_type(): string
    {
        return 'iqonic_image_select_control';
    }

    protected function get_default_settings(): array
    {
        return [
            'label_block' => true,
            'option' => [],
        ];
    }

    public function content_template()
    {
        $control_uid = $this->get_control_uid();
        ?> 
        <style type="text/css">
            /* HIDE RADIO */
            [class=iq-radio] {
                position: absolute;
                opacity: 0;
                width: 0;
                height: 0;
            }

            /* IMAGE STYLES */
            [class=iq-radio] + img {
                cursor: pointer;
                padding: 10px;
            }

            /* CHECKED STYLES */
            [class=iq-radio]:checked + img {
                outline: 2px solid #0d1e67;
            }
        </style>
        <div class="elementor-control-field">
            <label for="<?php echo esc_attr($control_uid); ?>" class="elementor-control-title">{{{ data.label
                }}}</label>
            <div class="elementor-control-input-wrapper">

                <# _.each( data.option, function( item, index ) { #>

                <label>
                    <input type="radio" data-setting="{{ data.name }}" id="<?php echo esc_attr($control_uid); ?>"
                           class="iq-radio" value="{{  index }}" name="{{ data.name }}">
                    <img src="{{ item }}">
                </label>

                <#
                } );
                #>

            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>

        <?php
    }
}
