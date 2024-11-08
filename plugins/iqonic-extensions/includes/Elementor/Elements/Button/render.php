<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$html = '';
$settings = $this->get_settings_for_display();
$settings = $this->get_settings();
$settings['swap_text']=$settings['swap_text']=='yes';

$this->add_render_attribute('iq_container', 'class', 'iq-btn-container');
$icon = '';

if ($settings['button_size'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_size']));
}
if ($settings['button_shape'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_shape']));
}
if ($settings['button_style'] != 'default') {
    $this->add_render_attribute('iq_class', 'class', esc_attr($settings['button_style']));
}

if ($settings['button_type'] == 'default') {
    $this->add_render_attribute('iq_class', 'class', 'iq-button');
    $html .=  !$settings['swap_text'] ? "<span class='iq-button-inner'><span class='text'>" . esc_html($settings['button_text']) . "</span><span class='iq-btn-line'><span class='line line-1'></span><span class='line line-2'></span><span class='line line-3'></span></span></span>" : "<span class='iq-button-inner'><span class='iq-btn-line'><span class='line line-1'></span><span class='line line-2'></span><span class='line line-3'></span></span><span class='text'>" . esc_html($settings['button_text']) . "</span></span>";
}
if ($settings['has_icon'] == 'yes') {
    $this->add_render_attribute('iq_class', 'class', 'has-icon');
    $this->add_render_attribute('iq_class', 'class', 'btn-icon-right');
}
if ($settings['button_type'] != 'default') {
    $html .=  !$settings['swap_text'] ? "<span class='iq-button-inner'><span class='text'>" . esc_html($settings['button_text']) . "</span><span class='iq-btn-line'><span class='line line-1'></span><span class='line line-2'></span><span class='line line-3'></span></span></span>" : "<span class='iq-button-inner'><span class='iq-btn-line'><span class='line line-1'></span><span class='line line-2'></span><span class='line line-3'></span></span><span class='text'>" . esc_html($settings['button_text']) . "</span></span>";
}

if ($settings['button_type'] == 'animation_button') {
    $this->add_render_attribute('iq_class', 'class', 'iq-button-animated');
} elseif ($settings['button_type'] == 'animation_link') {
    $this->add_render_attribute('iq_class', 'class', 'iq-button-animated linked-btn');
}

$url = '';

if ($settings['button_action'] == 'dynamic') {
    $url =  get_permalink(get_page_by_path($settings['dynamic_link']));

    $this->add_render_attribute('iq_class', 'href', esc_url($url));
} elseif ($settings['button_action'] == 'link') {
    if ($settings['link']['url']) {
        $url = $settings['link']['url'];
        $this->add_render_attribute('iq_class', 'href', esc_url($url));

        if ($settings['link']['is_external']) {
            $this->add_render_attribute('iq_class', 'target', '_blank');
        }

        if ($settings['link']['nofollow']) {
            $this->add_render_attribute('iq_class', 'rel', 'nofollow');
        }
    }
}

$modalid = '';
if ($settings['button_action'] == 'popup') {
    $modalid = 'mymodal' . rand(10, 1000);
    $this->add_render_attribute('iq_class', 'data-toggle', 'modal');
    $this->add_render_attribute('iq_class', 'data-target', '#' . $modalid);
    $this->add_render_attribute('iq_class', 'href', '#' . $modalid);
}

?>
<div <?php echo $this->get_render_attribute_string('iq_container') ?>>
    <a <?php echo $this->get_render_attribute_string('iq_class') ?>>
        <?php
        if (!$settings['swap_text']) {
            echo $html;
            if ($settings['has_icon'] == 'yes') {
                if (!empty($settings['button_icon']) && $settings['button_type'] == 'default') {
                    Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
                }
            }
        } else {
            if ($settings['has_icon'] == 'yes') {
                if (!empty($settings['button_icon']) && $settings['button_type'] == 'default') {
                    Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
                }
            }
            echo $html;
        }
        ?>
    </a>

</div>

<?php
if ($settings['button_action'] == 'popup') {
?>
    <div class="iq-modal">
        <div class="modal fade" id="<?php echo esc_attr($modalid); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo $settings['model_title'] ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><?php

                                                        if (!empty($settings['model_selected_icon']) && $settings['button_type'] == 'default') {
                                                            Icons_Manager::render_icon($settings['model_selected_icon'], ['aria-hidden' => 'true']);
                                                        }

                                                        ?></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $this->parse_text_editor($settings['model_body']); ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
<?php }
?>