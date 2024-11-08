<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$html = '';
$image_html='';

$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');
$align = $settings['align'];
if ($settings['iqonic_has_box_shadow'] == 'yes') {

    $align .= ' iq-box-shadow';
}

$this->add_render_attribute('iq_class', 'class', 'tox-progress');
$this->add_render_attribute('iq_class', 'data-size', $settings['size']['size']);
$this->add_render_attribute('iq_class', 'data-thickness', $settings['thickness']['size']);
$this->add_render_attribute('iq_class', 'data-progress', $settings['progress_value']);
$this->add_render_attribute('iq_class', 'data-speed', $settings['speed']['size']);  
$this->add_render_attribute('iq_class', 'data-color', $settings['data-color']);
$this->add_render_attribute('iq_class', 'data-background', $settings['data-background']);

if ($settings['progress_with'] == 'image') {
    if (!empty($settings['image']['url'])) {
        $this->add_render_attribute('image', 'src', $settings['image']['url']);
        $this->add_render_attribute('image', 'srcset', $settings['image']['url']);
        $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
        $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
    }
}

if ($settings['progress_with'] == 'text') {
    $image_html = '<p class="' . esc_attr($align) . '">' . esc_html($settings['progress_text']) . '</p>';
}

?>

<div class="iq-radial-progress <?php echo esc_attr($align); ?>">
    <div <?php echo $this->get_render_attribute_string('iq_class'); ?>>

        <div class="tox-progress-content" data-vcenter="true">
            <div class="<?php echo esc_attr($align); ?>">
                <?php echo $image_html; 
                if ($settings['progress_with'] == 'icon') {
                	if(!empty($settings['selected_icon']) == 'default'){
                        Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); 
                   }
                } ?>
            </div>
        </div>
    </div>
    <p><?php echo esc_html($settings['progress_value'] . '%'); ?></p>
</div>