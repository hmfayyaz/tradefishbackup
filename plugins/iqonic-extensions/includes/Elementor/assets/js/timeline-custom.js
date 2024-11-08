

(function(jQuery) {
    'use strict';

    jQuery(document).ready(function () {
        if (jQuery('#iq-timeline-horizontal-2.timeline').length > 0){

            horizontalTimeline();
        }
        
});

})(jQuery);

function horizontalTimeline(){

    jQuery('#iq-timeline-horizontal-2.timeline').timeline({
        forceVerticalMode: 800,
         mode: 'horizontal',
        visibleItems: 3,
    });
    
    jQuery('#iq-timeline-vertical-2.timeline ').timeline({
        forceVerticalMode: 800,
         mode: 'vertical',
        visibleItems: 2,
    });

}