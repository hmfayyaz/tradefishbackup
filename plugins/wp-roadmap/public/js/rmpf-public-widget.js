(function( $ ) {
    'use strict';

    //Toggle Upvote Button in Frontend Widget
    $('.button-box').click(function(){
        $(this).toggleClass('btn-active');
    });

    $(document).on('click', '.view-more', function(){
        const loadmore = $(this).attr('data-value')
        const wrapper = $(this).closest("li").find("#wp-roadmap-loadmore-"+loadmore)
        const showing =  wrapper.find('.wp-roadmap-loadmore:visible').length;
        wrapper.find('.wp-roadmap-loadmore').slice(showing - 1, showing + 5).show();
        if(wrapper.find('.wp-roadmap-loadmore:hidden').length == 0) {
            $(this).hide()
        }
    })
   
    //Ajax Request for Upvote Adding Functionality.
    $(document).on("click",".wp_roadmap_add_upvote", function (event) {
        var feedback_id = $(this).attr("data-feedback-id");
        var visitor_ip_address = $(this).attr("data-ip");
        $.ajax({
            url: wp_roadmap_widget_localize.ajaxurl,
            method: "POST",
            data: {
                action: "rmpf_add_upvote",
                _ajax_nonce: wp_roadmap_widget_localize.nonce,
                feedback_id:feedback_id,
                visitor_ip_address:visitor_ip_address
            },
            success: function (response) {
                $('#feedback-upvote-count-'+ response.data.id).text(response.data.total_upvote)
                $('#feedback-upvote-count-vote-'+ response.data.id).text(response.data.total_upvote)
            }
        });
    });
})( jQuery );

//Frontend Widget Tab Active Js.
function openTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}