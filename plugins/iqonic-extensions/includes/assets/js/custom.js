(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        jQuery('.owl-carousel.umetric-post').each(function () {
            var jQuerycarousel = jQuery(this);
            jQuerycarousel.owlCarousel({
                items: 1,
                loop: true,
                nav: false,
                dots: true,
                autoplay: true,
                navText: ['<div class="umetric-leftarrow"><div class="left-arrow tringle"></div><i class="fas fa-chevron-left"></i> </div>', '<div class="umetric-rightarrow"><div class="right-arrow tringle"></div><i class="fas fa-chevron-right"></i></div>'],
                responsiveClass: true
            });
        });
		window.dispatchEvent(new Event('resize'));
    });
})(jQuery);