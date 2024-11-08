<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\Header class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;


class Header extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'umetric_header_dynamic_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_header_background_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_umetric_header_menu_text_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_umetric_header_menu_text_hover_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_umetric_header_sub_menu_text_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_umetric_header_sub_menu_text_hover_bg_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_umetric_header_sub_menu_text_hover_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_umetric_header_sub_menu_background_color'), 20);

		add_action('wp_enqueue_scripts',  array($this, 'umetric_header_togglebutton_text_color'), 20);
		add_action('wp_enqueue_scripts',  array($this, 'umetric_header_togglebutton_bg_color'), 20);
		add_action('wp_enqueue_scripts',  array($this, 'umetric_header_sticky_menu_text_color'), 20);
		add_action('wp_enqueue_scripts',  array($this, 'umetric_header_sticky_menu_text_hover_color'), 20);
		add_action('wp_enqueue_scripts',  array($this, 'umetric_header_sticky_toggle_color'), 20);

        add_action('wp_enqueue_scripts', array($this, 'umetric_button_color'), 20);

        add_action('wp_enqueue_scripts', array($this, 'umetric_header_top_background_color'), 20);
        add_action('wp_enqueue_scripts', array($this, 'umetric_header_top_text_color'), 20);
        add_action('wp_enqueue_scripts', array($this, 'umetric_header_top_text_hover_color'), 20);

        add_action('wp_enqueue_scripts', array($this, 'umetric_header_side_area_bg_styles'), 20);

        
       
	}

    public function is_umetric_header()
	{
		$is_header = true;
		$page_id = get_queried_object_id();
		$header_page_option = get_post_meta($page_id, "display_header", true);
		$header_page_option = !empty($header_page_option) ? $header_page_option : "default";
		$umetric_option = get_option('umetric_options');

		if ($header_page_option != 'default') {
			$is_header = ($header_page_option == 'no') ? false : true;
		} else if(isset($umetric_option['umetric_header_display']) && $umetric_option['umetric_header_display'] == 'no') {
			$is_header = false;
		}
		if (is_404() && !$umetric_option['header_on_404']) {
			$is_header = false;
		}
		return $is_header;
	}

    public function umetric_header_side_area_bg_styles() {

		$umetric_option = get_option('umetric_options');
        $dynamic_css = '';

        if(isset($umetric_option['header_display_side_area']) && $umetric_option['header_display_side_area'] == 'yes') {
            if(isset($umetric_option['sidearea_background_type'])) {
                $type = $umetric_option['sidearea_background_type'];
                if($type == 'color') {
                    $dynamic_css .= '.iq-menu-side-bar{
                        background: '. $umetric_option['sidearea_background_color'] .' !important;
                    }';
                }

                if($type == 'image') {
                    if(!empty($umetric_option['sidearea_background_image']['url'])) {
                        $dynamic_css .= '.iq-menu-side-bar{
                            background: url('. $umetric_option['sidearea_background_image']['url'] .') !important;
                        }';
                    }
                }

                if($type == 'transparent') {
                    $dynamic_css .= '.iq-menu-side-bar{
                        background: transparent !important;
                    }';
                }
            }
        }

        //open button color
        if(isset($umetric_option['sidearea_btn_color_type']) && $umetric_option['sidearea_btn_color_type'] == 'custom') {
            if(isset($umetric_option['sidearea_btn_open_color']) && !empty($umetric_option['sidearea_btn_open_color'])) {
                $dynamic_css .= '.iq-sidearea-btn-container {
                    background: '. $umetric_option['sidearea_btn_open_color'].' !important;
                }';
            }

            if(isset($umetric_option['sidearea_btn_open_hover']) && !empty($umetric_option['sidearea_btn_open_hover'])) {
                $dynamic_css .= '.iq-sidearea-btn-container:hover {
                    background: '. $umetric_option['sidearea_btn_open_hover'].' !important;
                }';
            }
        }

        //open button line color
        if(isset($umetric_option['sidearea_btn_color_type']) && $umetric_option['sidearea_btn_color_type'] == 'custom') {
            if(isset($umetric_option['sidearea_btn_line_color']) && !empty($umetric_option['sidearea_btn_line_color'])) {
                $dynamic_css .= '.menu-btn .line {
                    background: '. $umetric_option['sidearea_btn_line_color'].' !important;
                }';
            }

            if(isset($umetric_option['sidearea_btn_line_hover_color']) && !empty($umetric_option['sidearea_btn_line_hover_color'])) {
                $dynamic_css .= '.iq-sidearea-btn-container:hover .menu-btn .line {
                    background: '. $umetric_option['sidearea_btn_line_hover_color'].' !important;
                }';
            }
        }

        //close button color
        if(isset($umetric_option['sidearea_btn_color_type']) && $umetric_option['sidearea_btn_color_type'] == 'custom') {
            if(isset($umetric_option['sidearea_btn_close_color']) && !empty($umetric_option['sidearea_btn_close_color'])) {
                $dynamic_css .= '#menu-btn-side-close {
                    background: '. $umetric_option['sidearea_btn_close_color'].' !important;
                }';
            }

            if(isset($umetric_option['sidearea_btn_close_hover']) && !empty($umetric_option['sidearea_btn_close_hover'])) {
                $dynamic_css .= '#menu-btn-side-close:hover {
                    background: '. $umetric_option['sidearea_btn_close_hover'].' !important;
                }';
            }
        }

        //close button line color
        if(isset($umetric_option['sidearea_btn_color_type']) && $umetric_option['sidearea_btn_color_type'] == 'custom') {
            if(isset($umetric_option['sidearea_btn_close_line_color']) && !empty($umetric_option['sidearea_btn_close_line_color'])) {
                $dynamic_css .= '#menu-btn-side-close .menu-btn .line {
                    background: '. $umetric_option['sidearea_btn_close_line_color'].' !important;
                }';
            }

            if(isset($umetric_option['sidearea_btn_close_line_hover_color']) && !empty($umetric_option['sidearea_btn_close_line_hover_color'])) {
                $dynamic_css .= '#menu-btn-side-close:hover .menu-btn .line {
                    background: '. $umetric_option['sidearea_btn_close_line_hover_color'].' !important;
                }';
            }
        }

        if(!empty($dynamic_css)) {
            wp_add_inline_style('umetric-global', $dynamic_css);
        }
    }
 

	public function umetric_umetric_header_menu_text_color()
	{
		$header_menu_text_color = "";
		$umetric_option = get_option('umetric_options');
     
		if (isset($umetric_option['umetric_menu_color']) && $umetric_option['umetric_menu_color'] != 'default') {
			
			$umetric_menu_color = sanitize_hex_color($umetric_option['umetric_menu_color']);
		
			if (!empty($umetric_menu_color)) {
				
				$header_menu_text_color .= "	
				header .main-header .navbar ul li a ,
				header .main-header .navbar ul li i  { 
					color:$umetric_menu_color !important; 
				}
				@media (max-width: 992px){
					header .main-header .navbar ul li a, header .main-header .navbar ul li i, header.menu-sticky .navbar ul li.current-menu-ancestor .sub-menu li i {
						color: #1e1e1e !important;
					}
					header .navbar .sub-main .shop_list li a {
						color:#ffffff !important;
					}
				}";
			}
		}

		wp_add_inline_style('umetric-global', $header_menu_text_color);
		
		
	}

	//Set menu Text Hover Color

	public function umetric_umetric_header_menu_text_hover_color(){
           
    $header_menu_text_hover_color = "";
    $umetric_option = get_option('umetric_options');

    if (isset($umetric_option['umetric_menu_hover_color']) && $umetric_option['umetric_menu_hover_color'] != 'default') {
        $umetric_menu_hover_color = sanitize_hex_color($umetric_option['umetric_menu_hover_color']);
        if (!empty($umetric_menu_hover_color)) {
            $header_menu_text_hover_color .= "
		header .main-header .navbar ul li:hover a ,
            header .main-header .navbar ul li:hover i,
            header .main-header .navbar ul li a:hover,
            header .main-header .navbar ul li.current-menu-item a,
            header  .main-header .navbar ul li.current-menu-parent a,
            header .main-header .navbar ul li.current-menu-parent i,
            header .main-header .navbar ul li.current-menu-ancestor a,
            header .main-header .navbar ul li.current-menu-parent i,
            header  .main-header .navbar ul li.current-menu-ancestor i { 
                color:$umetric_menu_hover_color !important; 
            }


            header  .main-header .navbar-light .navbar-toggler{
                background:$umetric_menu_hover_color;
                border-color:$umetric_menu_hover_color;
            }
            header .main-header .navbar #iq-menu-container ul li a::before {
                background:$umetric_menu_hover_color;
            }
             ";
        }
    }

	wp_add_inline_style('umetric-global', $header_menu_text_hover_color);
	}

	//Set Sub menu Text  Color
	public function umetric_umetric_header_sub_menu_text_color()
	{
		$header_sub_menu_text_color = "";
		$umetric_option = get_option('umetric_options');

		// remove below line when acf color customuzation introduce option and function from custom-color folders init.php file
		

		if (isset($umetric_option['umetric_submenu_color']) && $umetric_option['umetric_submenu_color'] != 'default') {
			$umetric_submenu_color = sanitize_hex_color($umetric_option['umetric_submenu_color']);

			if (!empty($umetric_submenu_color)) {

				$header_sub_menu_text_color .= "
				header .main-header  .navbar ul li:hover .sub-menu li a, header .main-header .navbar ul li .sub-menu li a,header .main-header .navbar ul li .sub-menu li i, header .main-header  .navbar ul li:hover .sub-menu li i,header .main-header .navbar ul li:hover .sub-menu li.current-menu-parent .sub-menu li a{ color:$umetric_submenu_color !important; }";
			}
		}
	
		wp_add_inline_style('umetric-global', $header_sub_menu_text_color);
	}


	//Set Sub menu Text hover background Color
	public function umetric_umetric_header_sub_menu_text_hover_bg_color()
	{
		$header_sub_menu_text_hover_bg_color = "";
		$umetric_option = get_option('umetric_options');

		// remove below line when acf color customuzation introduce option and function from custom-color folders init.php file
		

		if (isset($umetric_option['umetric_submenu_hover_bg_color']) && $umetric_option['umetric_submenu_hover_bg_color'] != 'default') {
			$umetric_submenu_hover_bg_color = sanitize_hex_color($umetric_option['umetric_submenu_hover_bg_color']);



			if (!empty($umetric_submenu_hover_bg_color)) {

				$header_sub_menu_text_hover_bg_color .= "
				header .navbar ul li .sub-menu li.current-menu-item a, header .main-header .navbar ul li .sub-menu li:hover>a, header .main-header .navbar ul li .sub-menu li.current-menu-parent a, header .main-header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li.current-menu-item a, header .main-header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li a:hover, header .main-header .navbar ul li .sub-menu li.current-menu-item a{ 
                    background:$umetric_submenu_hover_bg_color !important; }

                    @media(max-width:992px){
                        header.menu-sticky .navbar ul li.current-menu-ancestor a, header .navbar ul li.current-menu-ancestor a, header .navbar ul li.current-menu-parent a, header .main-header .navbar ul li:hover a, header .main-header .navbar ul li:hover i, header .main-header .navbar ul li a:hover, header .main-header .navbar ul li.current-menu-item a, header .main-header .navbar ul li.current-menu-parent a, header .main-header .navbar ul li.current-menu-parent i, header .main-header .navbar ul li.current-menu-ancestor a, header .main-header .navbar ul li.current-menu-parent i, header .main-header .navbar ul li.current-menu-ancestor i,header .main-header .navbar ul li:hover  .sub-menu li:hover i{
                            background:$umetric_submenu_hover_bg_color !important;
                        }
                    }
              
                
                 ";
			}
		}
		wp_add_inline_style('umetric-global', $header_sub_menu_text_hover_bg_color);
		
	}

//Set Sub menu Text hover  Color
public function umetric_umetric_header_sub_menu_text_hover_color()
{
    $umetric_header_sub_menu_text_hover_color = "";
    $umetric_option = get_option('umetric_options');

    // remove below line when acf color customuzation introduce option and function from custom-color folders init.php file
  
    if (isset($umetric_option['umetric_submenu_hover_color']) && $umetric_option['umetric_submenu_hover_color'] != 'default') {
        $umetric_submenu_hover_color = sanitize_hex_color($umetric_option['umetric_submenu_hover_color']);
        if (!empty($umetric_submenu_hover_color)) {
            $umetric_header_sub_menu_text_hover_color .= "
			header .main-header .navbar ul li .sub-menu li.current-menu-item a,
                header .main-header .navbar ul li .sub-menu li:hover>a,
                header .main-header .navbar ul li .sub-menu li.current-menu-parent a,
                header .main-header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li.current-menu-item a,
				 header .main-header .navbar ul li .sub-menu li:hover> i,
                header .main-header .navbar ul li .sub-menu li.current-menu-parent i ,
                header .main-header .navbar ul li:hover .sub-menu li a:hover,
                header .main-header .navbar ul li:hover .sub-menu li:hover i,
                header .main-header .navbar ul li .sub-menu li.current-menu-item a,
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-item a,
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-parent a,
                header  .main-header .navbar ul li:hover .sub-menu li.current-menu-parent i,
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-ancestor a,
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-ancestor i
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-parent .sub-menu li a:hover,
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-parent .sub-menu li:hover i,
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-parent .sub-menu li.current-menu-item a,
                header .main-header .navbar ul li .sub-menu li:hover, 
				 header .main-header .navbar ul li:hover .sub-menu li.current-menu-parent .sub-menu li a:hover,
                header .main-header .navbar ul li:hover .sub-menu li.current-menu-parent .sub-menu li:hover i { 
                    color:$umetric_submenu_hover_color !important; 
                }
                header .main-header .navbar #iq-menu-container ul li a::before{
                    background:$umetric_submenu_hover_color !important; 
                }

                @media(max-width:992px){
                    header .main-header .navbar ul li:hover a, 
                    header .main-header .navbar ul li:hover i, 
                    header .main-header .navbar ul li a:hover, 
                    header .main-header .navbar ul li.current-menu-item a, 
                    header .main-header .navbar ul li.current-menu-parent a, 
                    header .main-header .navbar ul li.current-menu-parent i, 
                    header .main-header .navbar ul li.current-menu-ancestor a, 
                    header .main-header .navbar ul li.current-menu-parent i, 
                    header .main-header .navbar ul li.current-menu-ancestor i {
                        color:$umetric_submenu_hover_color !important;
                    }
                }";
        }
    }
    wp_add_inline_style('umetric-global', $umetric_header_sub_menu_text_hover_color);
}
//Set Sub menu Background  Color
public function umetric_umetric_header_sub_menu_background_color()
{
    $header_sub_menu_background_color = "";
    $umetric_option = get_option('umetric_options');

    // remove below line when acf color customuzation introduce option and function from custom-color folders init.php file
   

    if (isset($umetric_option['umetric_sub_menu_back_color']) && $umetric_option['umetric_sub_menu_back_color'] != 'default') {
        $umetric_sub_menu_back_color = sanitize_hex_color($umetric_option['umetric_sub_menu_back_color']);
        if (!empty($umetric_sub_menu_back_color)) {
            $header_sub_menu_background_color .= "
            header .main-header .navbar ul li .sub-menu, header .main-header .navbar ul li .sub-menu li a, 
            header .main-header .navbar ul li .sub-menu li.current-menu-parent .sub-menu li a { 
                background:$umetric_sub_menu_back_color !important; 
            }

            @media(max-width:992px){
                header .main-header .navbar ul li:hover  .sub-menu li i{
                background:$umetric_sub_menu_back_color !important; }
            }";
        }
    }

   
	wp_add_inline_style('umetric-global', $header_sub_menu_background_color);

}

//Set toogle menu text  Color
public function umetric_header_togglebutton_text_color()
{
    $header_menu_toggle_button_text_color = "";
    $umetric_option = get_option('umetric_options');
    if (isset($umetric_option['umetric_toggle_color'])) {
        $umetric_toggle_color = sanitize_hex_color($umetric_option['umetric_toggle_color']);
        if (!empty($umetric_toggle_color)) {

            $header_menu_toggle_button_text_color .= "
        
            header  .main-header .navbar-light .navbar-toggler{
                color:$umetric_toggle_color;
            }";
        }
    }
    wp_add_inline_style('umetric-global', $header_menu_toggle_button_text_color);
}



//Set toogle menu bg  Color
public function umetric_header_togglebutton_bg_color()
{
    $header_menu_toggle_button_bg_color = "";
    $umetric_option = get_option('umetric_options');

    if (isset($umetric_option['umetric_toogle_bg_color'])) {
        $umetric_toogle_bg_color = sanitize_hex_color($umetric_option['umetric_toogle_bg_color']);
        if (!empty($umetric_toogle_bg_color)) {

            $header_menu_toggle_button_bg_color .= "
                header  .main-header .navbar-light .navbar-toggler {
                background:$umetric_toogle_bg_color;
                border-color:$umetric_toogle_bg_color;
            }";
        }
    }

    wp_add_inline_style('umetric-global', $header_menu_toggle_button_bg_color);
}



//Set menu sticky Text Color
public function umetric_header_sticky_menu_text_color()
{
    $header_sticky_menu_text_color = "";
    $umetric_option = get_option('umetric_options');
    if (isset($umetric_option['umetric_sticky_menu_color'])) {
        $umetric_sticky_menu_color = sanitize_hex_color($umetric_option['umetric_sticky_menu_color']);

        if (!empty($umetric_sticky_menu_color)) {

            $header_sticky_menu_text_color .= "
                header.menu-sticky .main-header .navbar ul li a ,
                header.menu-sticky .main-header .navbar ul li i { 
                    color:$umetric_sticky_menu_color !important; 
                }";
        }
    }
    wp_add_inline_style('umetric-global', $header_sticky_menu_text_color);
}


//Set menu sticky Text Hover Color
public function umetric_header_sticky_menu_text_hover_color()
{
    $header_sticky_menu_text_hover_color = "";
    $umetric_option = get_option('umetric_options');
    if (isset($umetric_option['umetric_menu_sticky_hover_color'])) {
        $umetric_menu_sticky_hover_color = sanitize_hex_color($umetric_option['umetric_menu_sticky_hover_color']);

        if (!empty($umetric_menu_sticky_hover_color)) {

            $header_sticky_menu_text_hover_color .= "
                header.menu-sticky .main-header .navbar ul li:hover a ,
                header.menu-sticky .main-header .navbar ul li:hover i,
                header.menu-sticky .main-header .navbar ul li a:hover,
                header.menu-sticky .main-header .navbar ul li.current-menu-item a,
                header.menu-sticky  .main-header .navbar ul li.current-menu-parent a,
                header.menu-sticky .main-header .navbar ul li.current-menu-parent i,
                header.menu-sticky .main-header .navbar ul li.current-menu-ancestor a,
                header.menu-sticky .main-header .navbar ul li.current-menu-parent i,
                header.menu-sticky  .main-header .navbar ul li.current-menu-ancestor i { 
                    color:$umetric_menu_sticky_hover_color !important; 
                }

                header.menu-sticky .navbar-light .navbar-toggler{
                    background:$umetric_menu_sticky_hover_color;
                    border-color:$umetric_menu_sticky_hover_color;
                }
                header.menu-sticky .main-header .navbar #iq-menu-container ul li a::before {
                    background:$umetric_menu_sticky_hover_color;
                }

                @media(max-width:992px){
                    header.menu-sticky .main-header .navbar ul li:hover a ,
                    header.menu-sticky .main-header .navbar ul li:hover i,
                    header.menu-sticky .main-header .navbar ul li a:hover,
                    header.menu-sticky .main-header .navbar ul li.current-menu-item a,
                    header.menu-sticky  .main-header .navbar ul li.current-menu-parent a,
                    header.menu-sticky .main-header .navbar ul li.current-menu-parent i,
                    header.menu-sticky .main-header .navbar ul li.current-menu-ancestor a,
                    header.menu-sticky .main-header .navbar ul li.current-menu-parent i,
                    header.menu-sticky  .main-header .navbar ul li.current-menu-ancestor i { 
                        background:$umetric_menu_sticky_hover_color !important;color:#ffffff!important; 
                }

            } ";
        }
    }

    wp_add_inline_style('umetric-global', $header_sticky_menu_text_hover_color);
}



public function umetric_header_sticky_toggle_color()
{
    $header_toggle_menu_sticky_color = "";
    $umetric_option = get_option('umetric_options');
    if (isset($umetric_option['umetric_sticky_toggle_color'])) {
        $umetric_toggle_menu_color = sanitize_hex_color($umetric_option['umetric_sticky_toggle_color']);
        if (!empty($umetric_toggle_menu_color)) {
            $header_toggle_menu_sticky_color .= "header.has-sticky.menu-sticky .navbar-light .navbar-toggler{ 
                    color:$umetric_toggle_menu_color !important; 
                }";
        }
    }

    if (isset($umetric_option['umetric_sticky_toogle_bg_color'])) {
        $umetric_toggle_menu_back_color = sanitize_hex_color($umetric_option['umetric_sticky_toogle_bg_color']);
        if (!empty($umetric_toggle_menu_back_color)) {
            $header_toggle_menu_sticky_color .= "header.has-sticky.menu-sticky .navbar-light .navbar-toggler{ 
                background:$umetric_toggle_menu_back_color !important; 
                }";
        }
    }

    wp_add_inline_style('umetric-global', $header_toggle_menu_sticky_color);
}


public function umetric_button_color()
{
    $umetric_option = get_option('umetric_options');
    if (isset($umetric_option['he_button_color'])) {
        if ($umetric_option['he_button_color'] == "2") {
            $hedaer_button_color = $umetric_option['header_button_color'];
            $hedaer_button_hover_color = $umetric_option['header_button_hover_color'];
            $header_button_text_color = $umetric_option['header_button_text_color'];
            $hedaer_button_hover_text_color = $umetric_option['header_button_hover_text_color'];
        }

        $button_color = "";

        if ($umetric_option['he_button_color'] == "2") {
            $button_color .= "
            header .blue-btn.button {
                background: $hedaer_button_color !important;
            }";
            $button_color .= "
            header .blue-btn.button:hover {
                background: $hedaer_button_hover_color !important;
            }";
            $button_color .= "
            header .blue-btn.button a {
                color: $header_button_text_color !important;
            }";
            $button_color .= "
            header .blue-btn.button a:hover {
                color: $hedaer_button_hover_text_color !important;
            }";
        }
        wp_add_inline_style('umetric-global', $button_color);
    }
}

//Set header Top background Color
public function umetric_header_top_background_color()
{

    $umetric_option = get_option('umetric_options');
   
    $header_top_background_color = "";
    if (isset($umetric_option['sticky_top_header_back_opt_switch'])) {
        if ($umetric_option['sticky_top_header_back_opt_switch'] == 1) {
            if (!empty($umetric_option['top_header_back_img']['url'])) {
                $bglayout = esc_url($umetric_option['top_header_back_img']['url']);
            }

            if (!empty($bglayout)) {
                $header_top_background_color .= "
            header .sub-header {
                background:url($bglayout) !important;
            }";
            }
        }

        if ($umetric_option['sticky_top_header_back_opt_switch'] == 2) {

            $top_header_color = $umetric_option['top_header_back_color'];

            if (!empty($top_header_color)) {
                $top_header_color =  sanitize_hex_color($top_header_color);
                $header_top_background_color .= "
            header .sub-header {
                background : $top_header_color !important;
            }";
            }
        }

        if ($umetric_option['sticky_top_header_back_opt_switch'] == 3) {
            $header_top_background_color .= "
        header .sub-header {
            background:transparent !important;
        }";
        }
        wp_add_inline_style('umetric-global', $header_top_background_color);
    }
}

//Set header Top Text Color
public function umetric_header_top_text_color()
{
    $header_top_text_color = "";
    $umetric_option = get_option('umetric_options');
    if (isset($umetric_option['top_header_text_color'])) {
        $top_header_text_color = sanitize_hex_color($umetric_option['top_header_text_color']);

        if (!empty($top_header_text_color)) {
            $header_top_text_color .= "
            header .sub-header a  { 
                color:$top_header_text_color; 
            }";
        }
    }
    wp_add_inline_style('umetric-global', $header_top_text_color);
}



//Set header Top Text hover Color
public function umetric_header_top_text_hover_color()
{$header_top_text_hover_color = "";
    $umetric_option = get_option('umetric_options');
    if (isset($umetric_option['top_header_text_hover_color'])) {
        $top_header_text_hover_color = sanitize_hex_color($umetric_option['top_header_text_hover_color']);


        if (!empty($top_header_text_hover_color)) {

            $header_top_text_hover_color .= "
                 header .sub-header a:hover  { color:$top_header_text_hover_color; }
                 ";
        }
    }

    wp_add_inline_style('umetric-global', $header_top_text_hover_color);
}
	
	public function umetric_header_dynamic_style()
	{
		$page_id = get_queried_object_id();
		if (function_exists('get_field') && get_field('acf_key_header_switch', $page_id) != 'default') {
			if (get_field('acf_key_header_switch') == 'no') {
				$header_css = 'header.default-header ,
                header{ 
					display : none !important;
				}';
				wp_add_inline_style('umetric-global', $header_css);
			}
		}
	}

	public function umetric_header_background_style()
	{
		$umetric_option = get_option('umetric_options');
		$dynamic_css = '';


		if (function_exists('get_field')) {
			$page_id_header = get_queried_object_id();
	
			$key_header_back = get_field('key_dark_header', $page_id_header);
			$key_header_style = get_field('key_header_variation', $page_id_header);
	
	
			if (isset($key_header_style['header_menu_variation'])) {
				$header_style = $key_header_style['header_menu_variation'];
			}
	
			if (isset($key_header_back['name_menu_has_dark'])) {
				$has_dark = $key_header_back['name_menu_has_dark'];
			}
	
			if (isset($key_header_back['name_back_color'])) {
				$back_color = $key_header_back['name_back_color'];
			}
		}
	
		if (isset($has_dark) && $has_dark == 'yes') {
			if (isset($back_color) && !empty($back_color) && isset($header_style) && ($header_style == '1' || $header_style == 'default')) {
				$dynamic_css .= "
					header {
						background-color:$back_color !important;
					}";
			}
		}
		
		elseif (isset($umetric_option['umetric_header_background_type']) && $umetric_option['umetric_header_background_type'] != 'default') {
			$type = $umetric_option['umetric_header_background_type'];
			if ($type == 'color') {
				if (!empty($umetric_option['umetric_header_background_color'])) {
					$dynamic_css .= 'header#default-header{
							background : ' . $umetric_option['umetric_header_background_color'] . '!important;
						}';
				}
			}
			if ($type == 'image') {
				if (!empty($umetric_option['umetric_header_background_image']['url'])) {
					$dynamic_css .= 'header#default-header{
							background : url(' . $umetric_option['umetric_header_background_image']['url'] . ') !important;
						}';
				}
			}
			if ($type == 'transparent') {
				$dynamic_css .= 'header#default-header{
						background : transparent !important;
					}';
			}
		}

        if (isset($umetric_option['header_back_opt_switch'])) {
			$type = $umetric_option['header_back_opt_switch'];
			if ($type == '2') {
				if (!empty($umetric_option['umetric_header_back_color'])) {
					$dynamic_css .= 'header.default-header{
							background : ' . $umetric_option['umetric_header_back_color'] . '!important;
						}';
				}
			}
			if ($type == '1') {
				if (!empty($umetric_option['umetric_header_back_img']['url'])) {
					$dynamic_css .= 'header.default-header{
							background : url(' . $umetric_option['umetric_header_back_img']['url'] . ') !important;
						}';
				}
			}
			if ($type == '3') {
				$dynamic_css .= 'header.default-header{
						background : transparent !important;
					}';
			}
		}

        //sticky header background styles
        if (isset($umetric_option['sticky_header_back_opt_switch'])) {
			$type = $umetric_option['sticky_header_back_opt_switch'];
			if ($type == '2') {
				if (!empty($umetric_option['umetric_sticky_header_back_color'])) {
					$dynamic_css .= 'header.menu-sticky.default-header {
							background : ' . $umetric_option['umetric_sticky_header_back_color'] . '!important;
						}';
				}
			}
			if ($type == '1') {
				if (!empty($umetric_option['umetric_sticky_header_back_img']['url'])) {
					$dynamic_css .= 'header.menu-sticky.default-header {
							background : url(' . $umetric_option['umetric_sticky_header_back_img']['url'] . ') !important;
						}';
				}
			}
			if ($type == '3') {
				$dynamic_css .= 'header.menu-sticky.default-header {
						background : transparent !important;
					}';
			}
		}

		if (!empty($dynamic_css)) {
			wp_add_inline_style('umetric-global', $dynamic_css);
		}
	}
}
