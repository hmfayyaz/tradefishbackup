<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$settings = $this->get_settings();
$align = '';

if ($settings['iqonic_has_box_shadow'] == 'yes') {
	$align .= ' iq-box-shadow';
}

if ($settings['design_style'] == "1") {
?>
	<div class="iq-divider iq-divider-style-1 <?php echo esc_attr($align); ?>">
		<div class="iq-divider-left">
		</div>
	</div>
<?php
}

if ($settings['design_style'] == "2") {
	// divider with center icon
?>
	<div class="iq-divider iq-divider-style-2 <?php echo esc_attr($align); ?>">
		<div class="iq-divider-left">
		</div>
		<div class="iq-divider-center">
			<?php
			if (!empty($settings['selected_icon'])) {
			?>
				<span class="iq-divider-icon">
				<?php 
					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
					?>
				</span>
			<?php
			}
			if (!empty($settings['section_title'])) {
			?>
				<h6 class="iq-divider-title"><?php echo esc_html($settings['section_title']); ?></h6>
			<?php } ?>
		</div>
		<div class="iq-divider-right">
		</div>
	</div>
<?php
}


if ($settings['design_style'] == "3") {
	// divider with left icon
?>
	<div class="iq-divider iq-divider-style-3 <?php echo esc_attr($align); ?>">
		<div class="iq-divider-left">
			<?php
			if (!empty($settings['selected_icon']['value'])) {
			?>
				<span class="iq-divider-icon">
				<?php 
					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
					?>
				</span>
			<?php
			}
			if (!empty($settings['section_title'])) {
			?>
				<h6 class="iq-divider-title"><?php echo esc_html($settings['section_title']); ?></h6>
			<?php } ?>
		</div>
		<div class="iq-divider-right">
		</div>
	</div>

<?php
}

if ($settings['design_style'] == "4") {
	// divider with right icon
?>
	<div class="iq-divider iq-divider-style-4 <?php echo esc_attr($align); ?>">
		<div class="iq-divider-left">
		</div>
		<div class="iq-divider-right">
			<?php
			if (!empty($settings['selected_icon']['value'])) {
			?>
				<span class="iq-divider-icon">
				<?php 
					Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
					?>
				</span>
			<?php
			}
			if (!empty($settings['section_title'])) {
			?>
				<h6 class="iq-divider-title"><?php echo esc_html($settings['section_title']); ?></h6>
			<?php } ?>
		</div>
	</div>
<?php
}
if ($settings['design_style'] == "5") {
	// divider with right icon
?>
	<div class="iq-divider iq-divider-style-5 <?php echo esc_attr($align); ?>">
		<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="divider-img">
	</div>

<?php
}
?>
