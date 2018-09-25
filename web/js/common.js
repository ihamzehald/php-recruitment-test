/**
 * @author Hamza al Darawsheh 25 Sep 2018 <ihamzehald@gmail.com>
 * Common methods & vars
 * Ticket Ref: task 5
 */

/**
 *Common vars
 */
var spinner_min = '<i class="global-min-spinner mgl-10 fa fa-spinner fa-spin" style="font-size:24px"></i>';


/**
 * Common methods
 */

/**
 * @author Hamza al Darawsheh 25 Sep 2018 <ihamzehald@gmail.com>
 * @param mesage as the message that you want to show in the notification
 * @param type one of bootstrap aleart types (info, success, danger)
 * @param icon on of bootstrap icons (the last part of the Glyphicon class)
 * Ticket Ref: task 5
 */
function showNotification(mesage, type = 'info', icon = 'ok'){
    $.notify({
        icon: 'glyphicon glyphicon-' + icon,
        message: mesage,
    },{
        // settings
        element: 'body',
        position: null,
        type: type,
        allow_dismiss: true,
        placement: {
            from: "top",
            align: "center"
        },
        offset: {y:100},
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0} text-center" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon" class="pull-left"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message" class="text-center">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
    });
}