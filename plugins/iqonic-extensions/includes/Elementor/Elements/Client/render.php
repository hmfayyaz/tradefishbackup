<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();



$tabs = $this->get_settings_for_display('tabs');
$col = 'iq-client-col-3';

$text_align = $settings['align'];
$align = '';

if ($settings['iq_client_list_hover_shadow'] == 'yes') {
	$align .= " iq-has-shadow";
}
if ($settings['iq_client_list_hover_grascale'] == 'yes') {
	$align .= " iq-has-grascale";
}
if ($settings['iqonic_has_box_shadow'] == 'yes') {
	$align .= ' iq-box-shadow';
}

if ($settings['design_style'] == '2') {

	$border = '';
	if($settings['iq_client_image_border'] == 'yes'){ 
		$border = 'image-border';
	}  ?>

	<div class="iq-client iq-client-style-2 <?php echo esc_attr($align) ?> <?php echo esc_attr($border); ?>">
		<?php
		if ($settings['client_style'] === "slider") {
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
			if($settings['rtl'] == 'yes'){	
			    $this->add_render_attribute('slider', 'data-rtl', 'true');
			} else {
				$this->add_render_attribute('slider', 'data-rtl', 'false');
			}

		?>

			<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
				<?php
				foreach ($tabs as $index => $item) {
				?>
					<div class="item">
						<div class="iq-client-img">
							<img src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
						</div>
						<div class="iq-client-info <?php echo esc_attr($text_align) ?>">
							<?php if (!empty($item['clinet_name'])) { ?>
								<h5><?php echo esc_html($item['clinet_name']) ?></h5>
							<?php } ?>
							<?php if (!empty($item['description'])) { ?>
								<p><?php echo esc_html($item['description']) ?></p>
							<?php } ?>
						</div>
					</div>
				<?php
				}
				?>
			</div>

			<?php } else {

			if ($settings['client_style'] === "2") {
				$col = 'iq-client-col-2';
			}
			if ($settings['client_style'] === "3") {
				$col = 'iq-client-col-3';
			}
			if ($settings['client_style'] === "4") {
				$col = 'iq-client-col-4';
			}
			if ($settings['client_style'] === "5") {
				$col = 'iq-client-col-5';
			}
			if ($settings['client_style'] === "6") {
				$col = 'iq-client-col-6';
			}
			echo '<ul class="' . esc_attr($col) . ' iq-client-grid">';
			foreach ($tabs as $index => $item) {
			?>
				<li>
					<img src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
					<?php if (!empty($item['clinet_name'])) { ?>
						<h5><?php echo esc_html($item['clinet_name']) ?></h5>
					<?php } ?>
					<?php if (!empty($item['description'])) { ?>
						<p><?php echo esc_html($item['description']) ?></p>
					<?php } ?>
				</li>
		<?php
			}
			echo '</ul>';
		} ?>
	</div>

<?php
}else if ($settings['design_style'] == '3') {
	$border = '';
	if($settings['iq_client_image_border'] == 'yes'){ 
		$border = 'image-border';
	}  ?>
	<div class="iq-client iq-client-style-3 <?php echo esc_attr($align) ?> <?php echo esc_attr($border); ?>">
		<?php
		if ($settings['client_style'] === "slider") {
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

			if($settings['rtl'] == 'yes'){	
			    $this->add_render_attribute('slider', 'data-rtl', 'true');
			} else {
				$this->add_render_attribute('slider', 'data-rtl', 'false');
			}
		?>

			<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
				<?php
				foreach ($tabs as $index => $item) {
				?>
					<div class="item">
						<a class="iq-client-img tooltip-container">
							<img src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
							<p class="iq-tooltip"><?php echo esc_html($item['description']) ?></p>
						</a>
					</div>
				<?php
				}
				?>
			</div>

			<?php } else {

			if ($settings['client_style'] === "2") {
				$col = 'iq-client-col-2';
			}
			if ($settings['client_style'] === "3") {
				$col = 'iq-client-col-3';
			}
			if ($settings['client_style'] === "4") {
				$col = 'iq-client-col-4';
			}
			if ($settings['client_style'] === "5") {
				$col = 'iq-client-col-5';
			}
			if ($settings['client_style'] === "6") {
				$col = 'iq-client-col-6';
			}
			echo '<ul class="' . esc_attr($col) . ' iq-client-grid">';
			foreach ($tabs as $index => $item) {
			?>
				<li>
					<a href="#" class="iq-client-img tooltip-container">
						<img src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
						<p class="iq-tooltip"><?php echo esc_html($item['description']); ?></p>
					</a>

				</li>
		<?php
			}
			echo '</ul>';
		} ?>
	</div>

<?php
} else if ($settings['design_style'] == '4') {
	// switch image
	$border = '';
	if($settings['iq_client_image_border'] == 'yes'){ 
		$border = 'image-border';
	}  ?>

	<div class="iq-client iq-client-style-4 <?php echo esc_attr($align) ?> <?php echo esc_attr($border); ?>">
		<?php
		if ($settings['client_style'] === "slider") {
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
			if($settings['rtl'] == 'yes'){	
			    $this->add_render_attribute('slider', 'data-rtl', 'true');
			} else {
				$this->add_render_attribute('slider', 'data-rtl', 'false');
			}
		?>

			<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
				<?php
				foreach ($tabs as $index => $item) {
				?>
					<div class="item">
						<div class="iq-client-img">
							<img class="iq-client-default-img" src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
							<img class="iq-client-hover-img" src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
						</div>
					</div>
				<?php
				}
				?>
			</div>

			<?php } else {

			if ($settings['client_style'] === "2") {
				$col = 'iq-client-col-2';
			}
			if ($settings['client_style'] === "3") {
				$col = 'iq-client-col-3';
			}
			if ($settings['client_style'] === "4") {
				$col = 'iq-client-col-4';
			}
			if ($settings['client_style'] === "5") {
				$col = 'iq-client-col-5';
			}
			if ($settings['client_style'] === "6") {
				$col = 'iq-client-col-6';
			}
			echo '<ul class="' . esc_attr($col) . ' iq-client-grid">';
			foreach ($tabs as $index => $item) {
			?>
				<div class="<?php echo esc_attr($col) ?>">
					<li>
						<img src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
						<img class="iq-client-hover-img" src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
					</li>
				</div>
		<?php
			}
			echo '</ul>';
		} ?>
	</div>

<?php
} else { 
	
	$border = '';
	if($settings['iq_client_image_border'] == 'yes'){ 
		$border = 'image-border';
	}   ?>
	<div class="iq-client iq-client-style-2 <?php echo esc_attr($align) ?> <?php echo esc_attr($border); ?>">
		<?php
		if ($settings['client_style'] === "slider") {
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
			if($settings['rtl'] == 'yes'){	
			    $this->add_render_attribute('slider', 'data-rtl', 'true');
			} else {
				$this->add_render_attribute('slider', 'data-rtl', 'false');
			}
		?>
			<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
				<?php
				foreach ($tabs as $index => $item) {
				?>
					<div class="item">
						<div class="iq-client-img">
							<img src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
						</div>
						<div class="iq-client-info  <?php echo esc_attr($text_align) ?>">
							<?php if (!empty($item['clinet_name'])) { ?>
								<h5><?php echo esc_html($item['clinet_name']) ?></h5>
							<?php } ?>
							<?php if (!empty($item['description'])) { ?>
								<p><?php echo esc_html($item['description']) ?></p>
							<?php } ?>
						</div>
					</div>
				<?php
				}
				?>
			</div>

			<?php } else {

			if ($settings['client_style'] === "2") {
				$col = 'iq-client-col-2';
			}
			if ($settings['client_style'] === "3") {
				$col = 'iq-client-col-3';
			}
			if ($settings['client_style'] === "4") {
				$col = 'iq-client-col-4';
			}
			if ($settings['client_style'] === "5") {
				$col = 'iq-client-col-5';
			}
			if ($settings['client_style'] === "6") {
				$col = 'iq-client-col-6';
			}
			echo '<ul class="' . esc_attr($col) . ' iq-client-grid">';
			foreach ($tabs as $index => $item) {
			?>
				<li>
					<img src="<?php echo esc_url($item['image']['url']) ?>" alt="client-img" />
					<?php if (!empty($item['clinet_name'])) { ?>
						<h5><?php echo esc_html($item['clinet_name']) ?></h5>
					<?php } ?>
					<?php if (!empty($item['description'])) { ?>
						<p><?php echo esc_html($item['description']) ?></p>
					<?php } ?>
				</li>
		<?php
			}
			echo '</ul>';
		} ?>
	</div>
<?php
}
?>
