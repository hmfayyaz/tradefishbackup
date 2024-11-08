<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package umetric
 */

namespace Umetric\Utility;

$umetric_options = get_option('umetric_options');
?>
<div class="container-fluid">
	<div class="row align-items-center">
		<div class="col-sm-12">
			<nav class="umetric-menu-wrapper mobile-menu">
				<div class="navbar">

					<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
						<?php
						if (function_exists('get_field') || class_exists('ReduxFramework')) {
							$umetric_options = get_option('umetric_options');
							$key = function_exists('get_field') ? get_field('key_header') : '';
							if (!empty($key['header_logo']['url'])) {
								$options = $key['header_logo']['url'];
							} else if (isset($umetric_options['header_radio'])) {
								if ($umetric_options['header_radio'] == 1) {
									$logo_text = $umetric_options['header_text'];
									echo esc_html($logo_text);
								}
								if ($umetric_options['header_radio'] == 2) {
									$options = $umetric_options['umetric_mobile_logo']['url'];
								}
							}
						}
						if (isset($options) && !empty($options)) {
							echo '<img class="img-fluid logo" src="' . esc_url($options) . '" alt="umetric">';
						} elseif (has_header_image()) {
							$image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
							if (has_custom_logo()) {
								echo '<img class="img-fluid logo" src="' . esc_url($image) . '" alt="umetric">';
							} else {
								bloginfo('name');
							}
						} else {
							$logo_url = get_template_directory_uri() . '/assets/images/logo.png';
							echo '<img class="img-fluid logo" src="' . esc_url($logo_url) . '" alt="umetric">';
						}
						?>
					</a>

					<button class="navbar-toggler custom-toggler ham-toggle" type="button">
						<span class="menu-btn d-inline-block">
							<span class="line one"></span>
							<span class="line two"></span>
							<span class="line three"></span>
						</span>
					</button>
				</div>

				<div class="c-collapse">
					<div class="menu-new-wrapper row align-items-center">
						<div class="menu-scrollbar verticle-mn yScroller col-lg-12">
							<div id="umetric-menu-main" class="umetric-full-menu">
								<?php
								if (umetric()->is_primary_nav_menu_active()) {
									umetric()->display_primary_nav_menu(array('menu_class' => 'navbar-nav top-menu'));
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</nav><!-- #site-navigation -->
		</div>
	</div>
</div>