/**
 * @author Hamza al Darawsheh 25 Sep 2018 <ihamzehald@gmail.com>
 * Varnish related methods and functionality implementation
 * Ticket Ref: task 5
 */
$(document).ready(function(){
    $(".varnish-website-link").on("click", function (e) {
        varnishWebsiteLink(this);
    })
});

/**
 * @author Hamza al Darawsheh 25 Sep 2018 <ihamzehald@gmail.com>
 * @param self as the siurce element that bound with varnishWebsiteLink event
 * link/unlink varnish & website based on varnishWebsiteLinkStatus
 * Ticket Ref: task 5
 */
function varnishWebsiteLink(self){
    $(".global-min-spinner").remove();
    $(self).parent().append(spinner_min);

    var varnishWebsiteLinkStatus = $(self).is(":checked") ? 1 : 0;
    var varnishId = $(self).data("varnish_id");
    var websiteId = $(self).data("website_id");

    var requestData = {
        "status": varnishWebsiteLinkStatus,
        "varnish_id": varnishId,
        "website_id": websiteId
    };

    $.ajax({
        url:'/varnish-link',
        type:'POST',
        dataType:'JSON',
        data:requestData,
        success:function(res){
            $(".global-min-spinner").remove();
            if(res.status){
                showNotification(res.message, 'success');
            }else{
                showNotification(res.message, 'danger', 'remove');
            }
        },
        error:function(res){
            $(".global-min-spinner").remove();
            showNotification(res.message, 'danjer', 'remove');
        }
    });

}

