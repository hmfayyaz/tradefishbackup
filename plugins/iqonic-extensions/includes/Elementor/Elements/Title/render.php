<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$settings = $this->get_settings();
$align = $settings['align'];
if(empty($align)) {
	$align = "center";
}

$image_html = '';

if ($settings['iqonic_has_box_shadow'] == 'yes') {

	$this->add_render_attribute('iq-section', 'class', 'iq-box-shadow');
}
$subtitle = $align;
switch ($subtitle) {
	case 'left':
		$subtitle = 'start';
		break;

	case 'right':
		$subtitle = 'end';
		break;
	default:
		$subtitle = 'center';
		break;
}
$subtitle_class=' justify-content-' . $subtitle;
$this->add_render_attribute('iq-section-sub-title', 'class', );
$this->add_render_attribute('iq-section', 'class', $align);
$this->add_render_attribute('iq-section', 'class', 'iq-title-box');
$this->add_render_attribute('iq-section', 'class', $settings['title_style']);

if ($settings['media_style'] == 'image') {
	if (!empty($settings['image']['url'])) {
		$this->add_render_attribute('image', 'src', $settings['image']['url']);
		$this->add_render_attribute('image', 'srcset', $settings['image']['url']);
		$this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
		$this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
		$image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
	}
}




if ($settings['design_style'] == 1) {

	$this->add_render_attribute('iq-section', 'class', 'iq-title-box-1');
}
if ($settings['design_style'] == 2) {

	$this->add_render_attribute('iq-section', 'class', 'iq-title-box-2');
}


if ($settings['design_style'] == "1") {
?>

	<div <?php echo $this->get_render_attribute_string('iq-section'); ?>>
		<div class="iq-title-icon">
			<?php echo $image_html;
			if ($settings['media_style'] == 'icon') {
				if (!empty($settings['selected_icon']) == 'default') {
					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
				}
			} ?>
		</div>
		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'before') {
			$sub_border = '';
			if ($settings['iqonic_has_subtitle_border'] == 'yes') {

				$sub_border = ' iq-sub-title-border';
			}
			echo sprintf('<span class="iq-subtitle %2$s">%1$s</span>', esc_html($settings['sub_title']), esc_attr($sub_border.$subtitle_class));
		}
		?>

		<<?php echo esc_attr($settings['title_tag']);  ?> class="iq-title">
			<?php echo wp_kses($settings['section_title'], array('br' => true, 'span' => array('style'=>array()))); ?>
		</<?php echo esc_attr($settings['title_tag']); ?>>
		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'after') {
			$sub_border = '';
			if ($settings['iqonic_has_subtitle_border'] == 'yes') {
				$sub_border = ' iq-sub-title-border';
			}
			
			echo sprintf('<span class="iq-subtitle %2$s">%1$s</span>', esc_html($settings['sub_title']), esc_attr($sub_border.$subtitle_class));
		}
		?>
		<?php
		if (!empty($settings['description']) && $settings['has_description'] == 'yes') {
			echo sprintf('<p class="iq-title-desc">%1$s</p>', $this->parse_text_editor($settings['description']));
		}
		?>
	</div>
<?php } elseif ($settings['design_style'] == "2") {
?>
	<div <?php echo $this->get_render_attribute_string('iq-section'); ?>>
		<div class="iq-title-icon">
			<?php echo $image_html; ?>
		</div>
		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'before') {
			$sub_border = '';
			if ($settings['iqonic_has_subtitle_border'] == 'yes') {

				$sub_border = ' iq-sub-title-border';
			}
			
			echo sprintf('<span class="iq-subtitle %2$s">%1$s</span>', esc_html($settings['sub_title']), esc_attr($sub_border.$subtitle_class));
		}
		?>
		<<?php echo esc_attr($settings['title_tag']);  ?> class="iq-title">
			<?php echo wp_kses($settings['section_title'], array('br' => true, 'span' => array('style'=>array())));; ?>
		</<?php echo esc_attr($settings['title_tag']); ?>>
		<?php
		if (!empty($settings['sub_title']) && $settings['sub_title_position'] == 'after') {
			$sub_border = '';
			if ($settings['iqonic_has_subtitle_border'] == 'yes') {
				$sub_border = ' iq-sub-title-border';
			}
			
			echo sprintf('<span class="iq-subtitle %2$s">%1$s</span>', esc_html($settings['sub_title']), esc_attr($sub_border.$subtitle_class));
		}
		?>
		<?php
		if (!empty($settings['description']) && $settings['has_description'] == 'yes') {
			echo sprintf('<p class="iq-title-desc">%1$s</p>', $this->parse_text_editor($settings['description']));
		}

		?>
	</div>

<?php } ?>