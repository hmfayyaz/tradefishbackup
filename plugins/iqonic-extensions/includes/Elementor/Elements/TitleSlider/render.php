<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;



$settings = $this->get_settings();
$align = $settings['align'];

if ($settings['iqonic_has_box_shadow'] == 'yes') {
	$align .= ' iq-box-shadow';
}

$desk = $settings['desk_number'];
$lap = $settings['lap_number'];
$tab = $settings['tab_number'];
$mob = $settings['mob_number'];
$this->add_render_attribute('slider', 'data-dots', $settings['dots']);
$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
$this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);
?>
<div class="iq-slider <?php echo esc_attr($align);  ?>">
	<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
		<?php
		foreach ($settings['iq_carousel'] as $index => $attachment) {
		?>
			<div class="iq-slider-img">
				<img src="<?php echo esc_url($attachment['url']); ?>" alt="image" />
			</div>

		<?php } ?>
	</div>
</div>
