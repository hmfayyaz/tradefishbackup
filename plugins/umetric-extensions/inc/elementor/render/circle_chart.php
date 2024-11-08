<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$chart = $this->get_settings_for_display('chart');
?>
<?php
foreach ($chart as $index => $item) { ?>
	<div class="iq-circle-chart">
		<div class="circlechart" data-percentage="<?php echo $item['chart_percentage_data'];  ?>"> <?php
            if (!empty($item['chart_percentage_title'])) { ?>
				<span class="chart-title">
					<?php echo esc_html__($item['chart_percentage_title'], 'umetric'); ?>
				</span> <?php
            } ?>
		</div>
	</div> <?php
}
