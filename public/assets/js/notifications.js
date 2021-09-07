/*
 * notifications.js
 * @since 2020.06.30
 */

var PATH = '/public/';

$(document).ready(function()
{
    getNotifications();
    updateIcon();
    updateNotifications();
});

function getNotifications()
{
    $.ajax({
       method: 'POST',
       url: PATH+'Notifications',
       data: {
            '_token' : $("input[name='_token']").val()
        },
       success: function(response){

           var obj = JSON.parse(response); //create json object

           //console.log(obj['count']);
           if(obj['count'] > 0){
                $('.noti-icon-badge').html(obj['count']);
            }else{
                $('.noti-icon-badge').html('');
            }
           if(obj['count'] > 0){
                $('.noti-title h5').html('Alerts: ('+obj['count']+')');
            }else{
                $('.noti-title h5').html('No unread alerts');
            }
           $('.slimscroll-noti').html(obj['items']);
       },
       error: function(jqXHR, textStatus, errorThrown){
           //console.log(JSON.stringify(jqXHR));
           console.log("assets/js/notification.js AJAX error: "+textStatus+' : '+errorThrown);
       }
    });

}

function updateIcon()
{

}

function updateNotifications()
{

}


