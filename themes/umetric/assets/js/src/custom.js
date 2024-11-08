/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function (jQuery) {
	"use strict";

	/*---------------------------------------------------------------------
		   Scroll
	-----------------------------------------------------------------------*/
	var position = jQuery(window).scrollTop();
    var options;
    var ScrollbarSidebar = window.Scrollbar;
    var header = jQuery(".header-one"),
        yOffset = 0,
        triggerPoint = 80;

	jQuery(window).scroll(function () {
		// -----sticky menu
		
		if (jQuery('header.header-default').length > 0) {
			var scroll = jQuery(window).scrollTop();
			if (scroll < position) {
				jQuery('.has-sticky').addClass('header-up');
				jQuery('body').addClass('header--is-sticky');
				jQuery('.has-sticky').removeClass('header-down');
			} else {
				jQuery('.has-sticky').addClass('header-down');
				jQuery('.has-sticky').removeClass('header-up ');
				jQuery('body').removeClass('header--is-sticky');
			}
			if (scroll == 0) {
				jQuery('.has-sticky').removeClass('header-up');
				jQuery('.has-sticky').removeClass('header-down');
				jQuery('body').removeClass('header--is-sticky');
			}
			position = scroll;
		}
		
      //back-to top
		if (jQuery(this).scrollTop() > 250) {
			jQuery('#back-to-top').fadeIn(1400);
			jQuery('#back-to-top .top').css("opacity", "1");
		} else {
			jQuery('#back-to-top').fadeOut(400);
			jQuery('#back-to-top .top').css("opacity", "0");
		}
		
		
        if(jQuery('header.header-one').length > 0){
		  
			// sidebar
			var scroll = jQuery(window).scrollTop();
			if (scroll >= 20 && jQuery("body").hasClass("side-bar-open")) {
				jQuery("body").removeClass("side-bar-open");
			}
	
	
			// header-sticky-logo
			if (jQuery(this).scrollTop() > 20) {
	
				jQuery('.has-sticky .logo').addClass('logo-display');
			} else {
				jQuery('.has-sticky .logo').removeClass('logo-display');
			}
	
	
			if (jQuery('.has-sticky').length > 0) {
			yOffset = jQuery(window).scrollTop();
	
			if (yOffset >= triggerPoint) {
				header.addClass("menu-sticky animated slideInDown");
			} else {
				header.removeClass("menu-sticky animated slideInDown");
			}
		}

		}
		 
		
 
 
		 
	});

	jQuery(window).on('load', function (e) {

		
		/*------------------------
		Page Loader
		--------------------------*/
		jQuery("#load").fadeOut();
		jQuery("#loading").delay(0).fadeOut("slow");
		

		// scroll body to 0px on click
		jQuery('#top').on('click', function () {
			jQuery('top').hide();
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

		/*---------------------------
		Vertical Menu
		---------------------------*/
		 if (jQuery('.menu-style-one.umetric-mobile-menu').length > 0) {
	    	getDefaultMenu();
		 }
		/*------------------------
		 main menu toggle
		--------------------------*/
		jQuery(document).on("click", '.custom-toggler', function () {
			if (jQuery('.umetric-mobile-menu ').hasClass('menu-open')) {
				jQuery('.umetric-mobile-menu ').toggleClass('open-delay');
				setTimeout(function () {
					jQuery('.umetric-mobile-menu ').toggleClass('menu-open');
					jQuery('.umetric-mobile-menu ').toggleClass('open-delay');
				}, 1000);
			} else {
				jQuery('.umetric-mobile-menu ').toggleClass('menu-open');
			}
			jQuery('.opn-menu').toggleClass('umetric-open');
		});

		jQuery(document).on("click", '.ham-toggle', function () {
			jQuery('.ham-toggle .menu-btn').toggleClass('is-active');
		});
		jQuery(document).on("click", '.mob-toggle', function () {
			jQuery('body').toggleClass('overflow-hidden');
		});


		
        /*------------------------
       Header
       --------------------------*/

        if (jQuery('header.default-header').hasClass('has-sticky')) {


            function headerHeight() {
                var height = jQuery(".header-one").height();
                jQuery('.iq-height').css('height', height + 'px');
            }

            jQuery(function() {

                headerHeight();
                jQuery(window).resize(headerHeight);

            });

        }
		if (jQuery("header.header-one").length > 0) {

		jQuery('.sub-menu').css('display', 'none');
        jQuery('.sub-menu').prev().addClass('isubmenu');
        jQuery(".sub-menu").before('<i class="fa fa-angle-down toggledrop" aria-hidden="true"></i>');


        jQuery('.widget .fa.fa-angle-down, #main .fa.fa-angle-down').on('click', function() {
            jQuery(this).next('.children, .sub-menu').slideToggle();
        });

        jQuery("#top-menu .menu-item .toggledrop").off("click");
        if (jQuery(window).width() < 992) {
            jQuery('#top-menu .menu-item .toggledrop').on('click', function(e) {
                e.preventDefault();
                jQuery(this).next('.children, .sub-menu').slideToggle();
            });
        }
		}
        
		/*------------------------
		Wow Animation
		--------------------------*/
		var wow = new WOW({
			boxClass: 'wow',
			animateClass: 'animated',
			offset: 0,
			mobile: true,
			live: true
		});
		wow.init();

        /*------------------------
                Searchstyle Bar
            --------------------------*/

        if (jQuery(".search__input").length > 0 && jQuery('.search').length > 0) {
            var openCtrl = document.getElementById('btn-search'),
                closeCtrl = document.getElementById('btn-search-close'),
                searchContainer = document.querySelector('.search'),
                inputSearch = searchContainer.querySelector('.search__input');

            function init() {
                initEvents();
            }

            function initEvents() {
                openCtrl.addEventListener('click', openSearch);
                closeCtrl.addEventListener('click', closeSearch);
                document.addEventListener('keyup', function(ev) {
                    // escape key.
                    if (ev.keyCode === 27) {
                        closeSearch();
                    }
                });
            }

            function openSearch() {
                searchContainer.classList.add('search--open');
                inputSearch.focus();
            }

            function closeSearch() {
                searchContainer.classList.remove('search--open');
                inputSearch.blur();
                inputSearch.value = '';
            }

            init();
        }
        /*---------------------------
        Sidebar
        ---------------------------*/
        jQuery("#menu-btn-side-open").click(function() {
            jQuery("body").toggleClass("side-bar-open");

        });

        jQuery("#menu-btn-side-close").click(function() {
            jQuery("body").toggleClass("side-bar-open");
        });

        jQuery('body').mouseup(function(e) {
            if (jQuery(e.target).closest(".iq-menu-side-bar").length === 0) {
                jQuery("body").removeClass("side-bar-open");
            }
        });


        if (jQuery('#sidebar-scrollbar').length) {
            ScrollbarSidebar.init(document.querySelector('#sidebar-scrollbar'), {
                continuousScrolling: false
            });
        }

		


	});


	jQuery(document).ready(function () {

		/*------------------------
				superfish menu
		--------------------------*/
		if (jQuery('.vertical').length > 0) {
		
            jQuery('.vertical ul .sub-menu').addClass('iq-has-sub-menu');
            jQuery('.vertical ul').removeClass('sub-menu');
            jQuery('#vertical-menu > li > ul').attr('data-parent', '#vertical-menu');

            jQuery(".vertical li.menu-item-has-children").each(function() {


                var href = jQuery(this).find('a:first').attr('href');
                var id = href.replace('#', '');

                if (id == '') {
                    id = 'menuId-' + Math.floor((Math.random() * 100000) + 1);
                    jQuery(this).find('a:first').attr('href', '#' + id);
                }

                jQuery(this).find('a:first').prepend("<i class='fa fa-angle-right iq-arrow-right'></i>");
                jQuery(this).find('a:first').attr('data-toggle', 'collapse');
                jQuery(this).find('a:first').attr('aria-expanded', 'false');
                jQuery(this).find('a:first').addClass('iq-waves-effect');
                jQuery(this).find('ul.iq-has-sub-menu:first').addClass('collapse');
                jQuery(this).find('ul.iq-has-sub-menu:first').attr('id', id);

            });

        }

        /*---------------------------------------------------------------------
        Ripple Effect
        -----------------------------------------------------------------------*/
        jQuery(document).on('click', ".iq-waves-effect", function(e) {
            // Remove any old one
            jQuery('.ripple').remove();
            // Setup
            var posX = jQuery(this).offset().left,
                posY = jQuery(this).offset().top,
                buttonWidth = jQuery(this).width(),
                buttonHeight = jQuery(this).height();

            // Add the element
            jQuery(this).prepend("<span class='ripple'></span>");


            // Make it round!
            if (buttonWidth >= buttonHeight) {
                buttonHeight = buttonWidth;
            } else {
                buttonWidth = buttonHeight;
            }

            // Get the center of the element
            var x = e.pageX - posX - buttonWidth / 2;
            var y = e.pageY - posY - buttonHeight / 2;


            // Add the ripples CSS and start the animation
            jQuery(".ripple").css({
                width: buttonWidth,
                height: buttonHeight,
                top: y + 'px',
                left: x + 'px'
            }).addClass("rippleEffect");
        });
		jQuery('ul.sf-menu').superfish({
			delay: 500,
			onBeforeShow: function (ul) {
				var elem = jQuery(this);
				var elem_offset = 0,
					elem_width = 0,
					ul_width = 0;
				// Add class if menu at the edge of the window
				if (elem.length == 1) {
					var page_width = jQuery('#page.site').width(),
						elem_offset = elem.parents('li').eq(0).offset().left,
						elem_width = elem.parents('li').eq(0).outerWidth(),
						ul_width = elem.outerWidth();

					if (elem.hasClass('iqonic-megamenu-container')) {
						if (elem.hasClass('iqonic-full-width')) {
							jQuery('.iqonic-megamenu-container.iqonic-full-width').css({
								'left': -elem_offset,
							});
						}
						if (elem.hasClass('iqonic-container-width')) {
							let containerOffset = (elem.closest('.elementor-container').length > 0) ? elem.closest('.elementor-container').offset() : elem.parents('li').eq(0).closest('header .container-fluid nav,header .container nav').offset();
							jQuery('.iqonic-megamenu-container.iqonic-container-width').css({
								'left': -(elem_offset - containerOffset.left)
							});
						}
					}
					if (elem_offset + elem_width + ul_width > page_width - 20 && elem_offset - ul_width > 0) {
						elem.addClass('open-submenu-main');
						elem.css({
							'left': 'auto',
							'right': '0'
						});
					} else {
						elem.removeClass('open-submenu-main');
						elem.css({});
					}
				}
				if (elem.parents("ul").length > 1) {
					var page_width = jQuery('#page.site').width();
					elem_offset = elem.parents("ul").eq(0).offset().left;
					elem_width = elem.parents("ul").eq(0).outerWidth();
					ul_width = elem.outerWidth();

					if (elem_offset + elem_width + ul_width > page_width - 20 && elem_offset - ul_width > 0) {
						elem.addClass('open-submenu-left');
						elem.css({
							'left': 'auto',
							'right': '100%'
						});
					} else {
						elem.removeClass('open-submenu-left');
					}
				}
			},
		});

		

		/*------------------------
			Search Bar
		--------------------------*/
		

		jQuery(".navbar-toggler").click(function () {
			if (jQuery(window).width() < 1200) {
				jQuery('body').toggleClass('overflow-hidden');
			}
		});
		jQuery(window).on('resize', function () {
			if (jQuery(window).width() > 1200) {
				if (jQuery('body').hasClass('overflow-hidden')) {
					jQuery('body').removeClass('overflow-hidden');
				}
			} else {
				if (jQuery('.navbar-toggler').hasClass('moblie-menu-active')) {
					jQuery('body').addClass('overflow-hidden');
				}
			}

			jQuery('.widget .fa.fa-angle-down, #main .fa.fa-angle-down').on('click', function() {
				jQuery(this).next('.children, .sub-menu').slideToggle();
			});
	
			jQuery("#top-menu .menu-item .toggledrop").off("click");
			if (jQuery(window).width() < 992) {
				jQuery('#top-menu .menu-item .toggledrop').on('click', function(e) {
					e.preventDefault();
					jQuery(this).next('.children, .sub-menu').slideToggle();
				});
			}
	

		});

		/*-----------------------------------------------------------------------
								Select2 
		-------------------------------------------------------------------------*/
		if (jQuery('select').length > 0) {
			jQuery('select').each(function () {

				jQuery(this).select2({
					width: '100%',
					dropdownParent:jQuery(this).parent()
				});
			});
			jQuery('.select2-container').addClass('wide');
		}

		if (jQuery('.umetric-menu-box').length > 0) {
			const moblieMenu = document.querySelector('.umetric-menu-box');

			moblieMenu.addEventListener('click', () => {
				const active = moblieMenu.classList.toggle('moblie-menu-active');
			})
		}

        /*---------------------------
        Vertical Menu
        ---------------------------*/
        var ScrollbarMenu = window.Scrollbar;
        if (jQuery('#menu-sidebar-scrollbar').length) {
            ScrollbarMenu.init(document.querySelector('#menu-sidebar-scrollbar'), {
                continuousScrolling: false
            });

        }
        

        jQuery(document).on("click", '#vertical-menu > li > a', function() {
            jQuery('#vertical-menu > li > a').parent().removeClass('active');
            jQuery(this).parent().addClass('active');
            if (jQuery(this).hasClass('collapsed')) {
                jQuery(this).parent().removeClass('active');
            }

        });

        jQuery("#vertical-menu-btn-close").click(function() {
            jQuery("body").toggleClass("vertical-menu-close");

        });

        jQuery("#vertical-menu-btn-open").click(function() {
            jQuery("body").toggleClass("vertical-menu-close");
        });

        jQuery('body').mouseup(function(e) {
            if (jQuery(e.target).closest(".style-vertical").length === 0) {
                jQuery("body").removeClass("vertical-menu-close");
            }
        });
	});

}(jQuery));

function  getDefaultMenu(){
  
		jQuery('.menu-style-one nav.mobile-menu .sub-menu').css('display', 'none ');
		jQuery('.menu-style-one nav.mobile-menu .top-menu li .dropdown').hide();
		jQuery('.menu-style-one nav.mobile-menu .sub-menu').prev().prev().addClass('submenu');
		jQuery('.menu-style-one nav.mobile-menu .sub-menu').before('<span class="toggledrop"><i class="fas fa-chevron-right"></i></span>');

		jQuery('nav.mobile-menu .widget i,nav.mobile-menu .top-menu i').on('click', function () {
			jQuery(this).next('.children, .sub-menu').slideToggle();
		});
		jQuery('.menu-style-one nav.mobile-menu .top-menu .menu-item .toggledrop').off('click');
		jQuery('.menu-style-one nav.mobile-menu .menu-item .toggledrop').on('click', function () {
			if (jQuery(this).closest(".menu-is--open").length == 0) {
				jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-is--open');
			}
			if (jQuery(this).parent().find("ul").length > 1) {
				jQuery(this).parent().addClass('menu-is--open');
			}
			jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .children,.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .sub-menu').slideUp();
			if (!jQuery(this).next('.children, .sub-menu').is(':visible') || jQuery(this).parent().hasClass("menu-is--open")) {
				jQuery(this).next('.children, .sub-menu').slideToggle();
			}
			jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .toggledrop').not(jQuery(this)).removeClass('active');

			jQuery(this).toggleClass('active');

			jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-clicked');
			jQuery(this).parent().addClass('menu-clicked');

			jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('current-menu-ancestor');
		});	
	
}