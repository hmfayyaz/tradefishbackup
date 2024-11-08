<?php 

add_action( 'elementor/widgets/widgets_registered', 'umetric_register_elementor_widgets' );
function umetric_register_elementor_widgets() {
	
	if ( defined( 'ELEMENTOR_PATH' ) && class_exists('Elementor\Widget_Base') ) {
		
		
		require  umetric_TH_ROOT . '/inc/elementor/widget/blog.php';
		
		require  umetric_TH_ROOT . '/inc/elementor/widget/portfolio.php';

		require  umetric_TH_ROOT . '/inc/elementor/widget/social_media.php';

		require  umetric_TH_ROOT . '/inc/elementor/widget/career.php';

		require  umetric_TH_ROOT . '/inc/elementor/widget/circle_chart.php';
		
 	}
}

add_action( 'elementor/init', function() {
	\Elementor\Plugin::$instance->elements_manager->add_category( 
		'umetric',
		[
			'title' => __( 'umetric', 'umetric' ),
			'icon' => 'fa fa-plug',
		]
	);
});

// Add Custom Icon 



add_action( 'wp_footer', function() {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return;
	}
	?>
	<script>
		jQuery( function( $ ) {
			// Add space for Elementor Menu Anchor link
			if ( window.elementorFrontend ) {
				jQuery("#load").fadeOut();
				jQuery("#loading").delay(0).fadeOut("slow");
				
				if(jQuery('header').hasClass('has-sticky'))
                {         
                    jQuery(window).on('scroll', function() {
                        if (jQuery(this).scrollTop() > 10) {
                            jQuery('header').addClass('menu-sticky');
                            jQuery('.has-sticky .logo').addClass('logo-display');
                        } else {
                            jQuery('header').removeClass('menu-sticky');
                            jQuery('.has-sticky .logo').removeClass('logo-display');
                        }
                    });

				}
				
			}
			
		} );
		
	</script>
	<?php
} );

function umetric_plugin_pagination($numpages = '', $pagerange = '', $paged='') 
{
	if (empty($pagerange)) {
	$pagerange = 2;
	}
	global $paged;
	if (empty($paged)) {
	$paged = 1;
	}
	if ($numpages == '') {
	global $wp_query;
	$numpages = $wp_query->max_num_pages;
	if(!$numpages) {
		$numpages = 1;
	}
	}
	/**
	* We construct the pagination arguments to enter into our paginate_links
	* function.
	*/
	$pagination_args = array(
		//'base'            => get_pagenum_link(1) . '%_%',
								'format'		  => '?paged=%#%',
		'total'           => $numpages,
		'current'         => $paged,
		'show_all'        => False,
		'end_size'        => 1,
		'mid_size'        => $pagerange,
		'prev_next'       => True,
		'prev_text'       => '<span aria-hidden="true">'. esc_html__( 'Previous page', 'umetric' ) .'</span>',
		'next_text'       => '<span aria-hidden="true">'. esc_html__( 'Next page', 'umetric' ) .'</span>',
		'type'            => 'list',
		'add_args'        => false,
		'add_fragment'    => ''
		);
		
	$paginate_links = paginate_links($pagination_args);
	if ($paginate_links) {
	echo '<div class="row">';
				echo '<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="pagination justify-content-center">
							<nav aria-label="Page navigation">';
										printf( esc_html__('%s','umetric'),$paginate_links);
							echo '</nav>
					</div>
				</div>
	</div>';
	}
}
