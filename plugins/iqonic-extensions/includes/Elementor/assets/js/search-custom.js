(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        
        searchCustom();

    });
    
})(jQuery);

function searchCustom(){
 
    if (jQuery(".btn-search").length > 0) {
        jQuery(".btn-search").click(function () {
            jQuery(this).parent().find('.umetric-search').toggleClass('search--open');
            
        });
        jQuery(".btn-search-close").click(function () {
            jQuery(this).closest('.umetric-search').toggleClass('search--open');
        });
    }
}