$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});

var base_url    = window.location.origin;
var _uri        = base_url.split('//');
var url         = _uri[1].split(':');
base_url        = url[0];

var notifaudio  = new Audio('/sounds/filling-your-inbox.mp3');

/* 
    - implementing socket and getting all emitted signal from your channel
    - this is a sample of a real time notification
*/
var socket      = io(base_url+':3000', {secure: true, rejectUnauthorized : false});
socket.on("ordering-notif", function(event){
    var events  = event.event;
    var item    = event.data.item;
    console.log(event);
    switch(events)
    {
        /* CATEGORY SOCKET START */
        case 'category-new':
            main_toast('success','New Category', item.name, item.id);
            break;
        case 'category-update':
            main_toast('info','Updated Category', item.name, item.id);
            break;
        case 'category-delete':
            main_toast('danger','Archived Category', item.name, item.id);
            break;
        /* CATEGORY SOCKET END */

        /* ITEM SOCKET START */
        case 'item-new':
            main_toast('success','New Item', item.name, item.id);
            break;
        case 'item-update':
            main_toast('info','Updated Item', item.name, item.id);
            break;
        case 'item-delete':
            main_toast('danger','Archived Item', item.name, item.id);
            break;
        /* ITEM SOCKET END */


        /* PERMISSION SOCKET START */
        case 'permission-new':
            main_toast('success','New Permission', item.name, item.id);
            break;
        case 'permission-update':
            main_toast('info','Updated Permission', item.name, item.id);
            break;
        case 'permission-delete':
            main_toast('danger','Archived Permission', item.name, item.id);
            break;
        /* PERMISSION SOCKET END */
    }

    notifaudio.play();
});


function main_toast(toast_type, toast_title , message, id)
{
    var _message = message +'<div class="pnotify-content" data-id="'+id+'"></dv>';
    new PNotify({
        title: toast_title,
        text: _message,
        // icon: 'icofont icofont-info-circle',
        type: toast_type,
        addClass : 'no-image',
        delay : 1800
    });
}
