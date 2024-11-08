(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".umetric-notice-dismiss").click(function (e) {
            e.preventDefault();
            $(this).parent().parent(".umetric-notice").fadeOut(600, function () {
                $(this).parent().parent(".umetric-notice").remove();
            });
            notify_wordpress($(this).data("msg"));
        });
    });
}(jQuery));

function notify_wordpress(message) {
    var param = {
        action: 'umetric_dismiss_notice',
        data: message
    };
    jQuery.post(ajaxurl, param);
}