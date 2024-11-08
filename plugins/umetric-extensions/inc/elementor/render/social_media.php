<?php

namespace Elementor;

use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();
?>

<div class="deatils-social">
	<span class="mr-3"><?php echo __($settings['section_title'], 'umetric'); ?></span>
	<ul class="share-social  list-inline p-0">
		<?php
		$umetric_option = get_option('umetric_options');
		if (isset($umetric_option['social-media-iq'])) {
			$top_social = $umetric_option['social-media-iq'];
			$i = 1;
			foreach ($top_social as $key => $value) {
				if ($i < 9) {
					if ($value) { ?>
						<li class="list-inline-item">
						    <a href="<?php echo esc_html($value); ?>">
							    <i class="fa fa-<?php echo esc_html($key); ?>"></i>
							</a>
						</li> <?php
					}
					$i++;
				}
			}
		} ?>
	</ul>
</div>
