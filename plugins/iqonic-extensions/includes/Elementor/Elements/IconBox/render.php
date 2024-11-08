<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$html = '';

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$align = $settings['align'];
$image_html = '';

if ($settings['iqonic_has_box_shadow'] == 'yes') {

	$align .= ' iq-box-shadow';
}

$active = $settings['active_onoff'];
if ($active === "yes") {
	$align .= ' active';
}

if ($settings['media_style'] == 'image') {
	if (!empty($settings['image']['url'])) {
		$this->add_render_attribute('image', 'src', $settings['image']['url']);
		$this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
		$this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
		$image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
	}
}

if ($settings['icon_box_link']['url']) {
	$url = $settings['icon_box_link']['url'];
	$this->add_render_attribute('link_attr', 'href', esc_url($url));

	if ($settings['icon_box_link']['is_external']) {
		$this->add_render_attribute('link_attr', 'target', '_blank');
	}

	if ($settings['icon_box_link']['nofollow']) {
		$this->add_render_attribute('link_attr', 'rel', 'nofollow');
	}
	$url = '';
}


if ($settings['design_style'] == '1') {
?>

	<div class="iq-icon-box iq-icon-box-style-1 <?php echo esc_attr($align); ?>">
		<?php
		if ($settings['has_back_img']) {
		?>
			<img src="<?php echo esc_url($settings['back_image']['url']); ?>" class="hover-img" alt="image">
		<?php
		}
		?>

		<div class="icon-box-img">
			<a <?php echo $this->get_render_attribute_string('link_attr'); ?>>
				<?php echo $image_html; 
				if ($settings['media_style'] == 'icon') {

					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
				}
				?>
			</a>
		</div>
		<div class="icon-box-content">
			<?php if ($settings['section_title']) { ?>
				<<?php echo esc_attr($settings['title_tag']);  ?> class="icon-box-title"><a <?php echo $this->get_render_attribute_string('link_attr'); ?>><?php echo esc_html($settings['section_title']); ?></a>
				</<?php echo esc_attr($settings['title_tag']);  ?>>
			<?php } ?>
			<?php if ($settings['description']) { ?>
				<p class="icon-box-desc"> <?php echo sprintf('%1$s', esc_html($settings['description'], 'iqonic')); ?> </p>
			<?php } ?>
			<?php if ($settings['button_text'] && $settings['link']) {
				require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			} ?>
		</div>
	</div>
<?php
}
if ($settings['design_style'] == '2') {
?>
	<div class="iq-icon-box iq-icon-box-style-2 <?php echo esc_attr($align); ?> ">

		<div class="icon-box-img">
			<a <?php echo $this->get_render_attribute_string('link_attr'); ?>>
				<?php echo $image_html;
				if ($settings['media_style'] == 'icon') {

					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
				} ?>
			</a>
		</div>

		<div class="icon-box-content">
			<?php if ($settings['section_title']) { ?>
				<<?php echo esc_attr($settings['title_tag']);  ?> class="icon-box-title"> <a <?php echo $this->get_render_attribute_string('link_attr'); ?>><?php echo esc_html($settings['section_title']); ?></a>
				</<?php echo esc_attr($settings['title_tag']);  ?>>
			<?php } ?>
			<?php if ($settings['description']) { ?>
				<p class="icon-box-desc"> <?php echo sprintf('%1$s', esc_html($settings['description'], 'iqonic')); ?> </p>
			<?php } ?>
			<?php if ($settings['button_text'] && $settings['link']) {
				require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			} ?>
		</div>

	</div>
<?php
}

if ($settings['design_style'] == '5') {
	?>
	<div class="iq-icon-box iq-icon-box-style-5 <?php echo esc_attr($align); ?> ">
		<div class="icon-box-img">
			<a <?php echo $this->get_render_attribute_string('link_attr'); ?>>
				<?php echo $image_html; 
				if ($settings['media_style'] == 'icon') {

					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
				}
				?>
			</a>
			<?php if ($settings['section_title']) { ?>
				<<?php echo esc_attr($settings['title_tag']);  ?> class="icon-box-title"> <a <?php echo $this->get_render_attribute_string('link_attr'); ?>><?php echo esc_html($settings['section_title']); ?></a>
				</<?php echo esc_attr($settings['title_tag']);  ?>>
			<?php } ?>
			<?php if ($settings['description']) { ?>
				<p class="icon-box-desc"> <?php echo sprintf('%1$s', esc_html($settings['description'], 'iqonic')); ?> </p>
			<?php } ?>
			<?php if ($settings['button_text'] && $settings['link']) {
				require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			} ?>
		</div>
			<div class="icon-box-content">
				<a <?php echo $this->get_render_attribute_string('link_attr'); ?>>
					<?php echo $image_html; 
					if ($settings['media_style'] == 'icon') {

						Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
					}?>
				</a>
			</div>
	
		</div>
	<?php
}

if ($settings['design_style'] == '6') {
	?>
	<div class="iq-icon-box iq-icon-box-style-6 <?php echo esc_attr($align); ?> ">

		<div class="icon-box-content">
			<?php if ($settings['section_title']) { ?>
				<<?php echo esc_attr($settings['title_tag']);  ?> class="icon-box-title"> <a <?php echo $this->get_render_attribute_string('link_attr'); ?>><?php echo esc_html($settings['section_title']); ?></a>
				</<?php echo esc_attr($settings['title_tag']);  ?>>
			<?php } ?>
			<?php if ($settings['description']) { ?>
				<p class="icon-box-desc"> <?php echo sprintf('%1$s', esc_html($settings['description'], 'iqonic')); ?> </p>
			<?php } ?>
			<?php if ($settings['button_text'] && $settings['link']) {
				require  IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
			} ?>
		</div>
		<div class="icon-box-img">
			<a <?php echo $this->get_render_attribute_string('link_attr'); ?>>
				<?php echo $image_html;
				if ($settings['media_style'] == 'icon') {

					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
				}
				 ?>
			</a>
		</div>
	</div> <?php
}