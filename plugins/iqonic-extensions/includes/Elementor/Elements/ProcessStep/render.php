<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$html = '';
$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');
$align = $settings['align'];

if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}

$media = '';
if ($settings['media_style'] == 'image') {
    $media = '<img class="hover-img" src="' . esc_url($settings['image_icon']['url']) . '" alt="fancybox">';
}

?>

<div class="iq-process iq-process-step-style-7 <?php echo esc_attr($align) ?>">

    <div class="iq-process-step">

        <?php
        if ($settings['is_before_img'] == 'yes') {
        ?>
            <img class="iq-before-img" src="<?php echo esc_url($settings['arrow_img']['url']); ?>" alt="arrow-img">
        <?php } ?>
        <div class="iq-step-content">
            <?php echo $media;
            if ($settings['media_style'] == 'icon') {
                if(!empty($settings['selected_icon']) == 'default'){
                    Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); 
               }
            }
            
            ?>
            <?php
            if (!empty($settings['step_number'])) {
            ?>
                <div class="step-number">
                    <span><?php echo esc_html($settings['step_number']); ?></span>
                </div>
            <?php } ?>
        </div>

        <div class="iq-step-text-area">

            <?php

            if (!empty($settings['section_title'])) {
            ?>
                <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-step-title"><?php echo esc_html($settings['section_title']) ?></<?php echo esc_attr($settings['title_tag']);  ?>>
            <?php
            }

            if ($settings['description']) {

            ?>
                <span class="iq-step-desc"><?php echo esc_html($settings['description']) ?></span>

            <?php
            }

            if ($settings['use_button'] == 'yes') {
                require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
            } ?>

        </div>

    </div>

</div>