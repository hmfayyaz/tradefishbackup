<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package umetric
 */

namespace Umetric\Utility;

use Elementor\Plugin;
use Umetric\Utility\Dynamic_Style\Styles\Footer;


$footer_class = '';
$umetric_options = get_option('umetric_options');
$is_default = $is_footer = true;
$topfooter = '';

if (function_exists("get_field") || class_exists('ReduxFramework')) {
	$footer = new Footer();
	$is_footer = $footer->is_umetric_footer();
}

if($is_footer) {

	if (function_exists('get_field') && class_exists('ReduxFramework')) {

		if (isset($umetric_options['footer_type'])) {
			if ($umetric_options['footer_type'] == "1" && $umetric_options['footer_option'] == '2') {
				$f_color = esc_html__('iq-over-dark-90', 'umetric');
			} elseif ($umetric_options['footer_type'] == "2" && $umetric_options['footer_option'] == '2') {
				if (isset($umetric_options['footer_image']['url'])) {
					$bgurl = $umetric_options['footer_image']['url'];
				}
			}
		}

		if (isset($umetric_options['footer_opacity'])) {
			if ($umetric_options['footer_opacity'] == "2" && $umetric_options['footer_option'] == '2') {
				$op_color = esc_html__('iq-over-dark-90', 'umetric');
			}
		}

		$id = (get_queried_object_id()) ? get_queried_object_id() : '';
		$footer_display = !empty($id) ? get_post_meta($id, 'display_footer', true) : '';
		$umetric_footer_layout = !empty($id) ? get_post_meta($id, 'footer_layout_type', true) : '';
		$footer_name = !empty($id) ? get_post_meta($id, 'footer_layout_name', true) : '';

		if($footer_display === 'yes' && $umetric_footer_layout == 'default') {
			$is_default = true;
		} else {
			if ($footer_display === 'yes' && $umetric_footer_layout !== 'default' && !empty($footer_name)) {
				$is_default = false;
				$footer = $footer_name;
				$my_layout = get_page_by_path($footer, '', 'iqonic_hf_layout');
				$footer_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);
				echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($footer_response) : $footer_response;
			} else if (isset($umetric_options['umetric_footer_layout']) && $umetric_options['umetric_footer_layout'] == 'custom') {
				$is_default = false;
				$footer = $umetric_options['umetric_footer_style'];
				$my_layout = get_page_by_path($footer, '', 'iqonic_hf_layout');
				$footer_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);
				echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($footer_response) : $footer_response;
			}
		}
	}

	if ($is_default) { ?>
<footer id="contact" class="footer"> <?php 
		get_template_part('template-parts/footer/footer','top');
		get_template_part('template-parts/footer/widget');
		get_template_part('template-parts/footer/info');
	?>
</footer><!-- #colophon -->
<?php }
} ?>



<!-- === back-to-top === -->
<?php
if (isset($umetric_options['umetric_back_to_top'])) {
	$options = $umetric_options['umetric_back_to_top'];
	if ($options == "yes") {
?>
<!-- === back-to-top === -->
<div id="back-to-top">
	<a class="top" id="top" href="#top"> <i class="ion-ios-arrow-up"></i> </a>
</div>
<!-- === back-to-top End === -->
<?php
	}
} else {
?>
<!-- === back-to-top === -->
<div id="back-to-top">
	<a class="top" id="top" href="#top"> <i class="ion-ios-arrow-up"></i> </a>
</div>
<!-- === back-to-top End === -->
<?php 
} ?>
<!-- === back-to-top End === -->
</div><!-- #page -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php wp_footer(); ?>
<script>	
	// jQuery('').slick({
	//   dots: false,
	//   infinite: true,
	//   speed: 500,
	//   slidesToShow: 4,
	//   slidesToScroll: 1,
	//   autoplay:true,
	//   autoplaySpeed:5000,
	//   responsive: [
	//     {
	//       breakpoint: 1025,
	//       settings: {
	//         slidesToShow: 3,
	//         slidesToScroll: 1,
	//         infinite: true,
	//         dots: true
	//       }
	//     },
	//     {
	//       breakpoint: 600,
	//       settings: {
	//         slidesToShow: 2,
	//         slidesToScroll: 2
	//       }
	//     },
	//     {
	//       breakpoint: 480,
	//       settings: {
	//         slidesToShow: 1,
	//         slidesToScroll: 1
	//       }
	//     }
	//   ]
	// });

	jQuery('.Signlstpbx-main').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		nav:true,
		dots:false,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		responsive:{
			0:{
				items:1,
			},
			600:{
				items:2,
			},
			1000:{
				items:4,
			}
			1280:{
			items:4,
		}
	}
										   })
	jQuery('.owl-prev').hide();
	jQuery('.owl-next').click(function(){
		jQuery('.owl-prev').show();
	});
	jQuery('.owl-prev').click(function(){
		jQuery('.owl-next').show();
	});
</script>
</body>
</html>