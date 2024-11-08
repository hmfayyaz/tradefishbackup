<?php

/**
 * Template part for displaying the footer info
 *
 * @package umetric
 */

namespace Umetric\Utility;
$year = date('Y');

?>
<div class="copyright-footer">
	<div class="container">
		<div class="row">
			  <?php 
			if (class_exists('ReduxFramework')) {
				$umetric_options = get_option('umetric_options');
			    if ($umetric_options['display_copyright'] == 'yes') { ?>
					<div class="col-md-12 text-center">
						<div class="pt-3 pb-3 text-center">
						    <?php if (isset($umetric_options['footer_copyright'])) { ?>
								<span class="copyright">
									<?php 
									 $umetric_copyright = str_replace("{{year}}", $year, $umetric_options['footer_copyright']);
									 echo esc_html($umetric_options['footer_copyright']); ?>
								</span>
							<?php } else { ?>
								<span class="copyright"><a target="_blank" href="<?php echo esc_url(__('https://themeforest.net/user/iqonicthemes/portfolio/', 'umetric')); ?>"> <?php printf(esc_html__('Proudly powered by %s', 'umetric'), 'umetric.'); ?></a></span>
							<?php } ?>
						</div>
					</div>
				<?php } 
			} else { ?>
				<div class="col-sm-12">
					<div class="pt-3 pb-3 text-center">
						<span class="copyright">
							<a target="_blank" href="<?php echo esc_url(__('https://themeforest.net/user/iqonicthemes/portfolio/', 'umetric')); ?>">
							<?php esc_html_e("© ".$year."", "umetric"); ?>
								<strong><?php esc_html_e(' umetric ', 'umetric'); ?></strong>
								<?php esc_html_e('. All Rights Reserved.', 'umetric'); ?>
							</a>
						</span>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div><!-- .site-info -->