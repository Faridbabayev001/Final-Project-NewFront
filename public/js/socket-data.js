  var socketData = function(auth_user_id, receiver_id, elan_id) {
  var socket = io(':3000');
  var count = 0;
  var data = {
      id: auth_user_id
  }
  var data_single = {
      sender_id :auth_user_id,
      receiver_id: receiver_id,
      message :  "",
      seen: 0,
      elan_id: elan_id,
      created_at: moment().format("YYYY-MM-DD HH:mm:ss"),
      updated_at: moment().format("YYYY-MM-DD HH:mm:ss")
  };

  //-----------------Message and Notification socket -----------------------------------

  socket.emit('count', data);
  socket.on('allcount', function(message_notification_data){
      if(auth_user_id != 0){
            count=0 ;
            $.each(message_notification_data,function (key,value){
              if (value.receiver_id == data.id) {
                if (value.seen == 0)
                {
                    count++;
                }
            };
          })

      }
      if (count > 0) {
          $('.socket-messages-number').empty();
          $('.socket-messages-count span').text('');
          $('.socket-messages-number').append('<a href="#" data-toggle="dropdown" class="dropdown-toggle socket-messages-count"><i class="fa fa-comments-o"></i> <span class="contact-auth-notification-number"> </span> </a>');
          $('.socket-messages-count span').text(count);
      }
      else{
          $('.socket-messages-number').empty();
          $('.socket-messages-number').append('<a href="#" data-toggle="dropdown" class="dropdownyoxdur-toggle socket-messages-count"><i class="fa fa-comments-o"></i></a>');
        //  $('.socket-messages-data').append('<li><a href="#"> <h4 class="text-center margin0">Mesajınız yoxdur</h4></a></li>');
      }
  });

  //OnClick message notification
    $('.clickNumber').on('click',function () {
        socket.emit('CountZero',data);
        socket.emit('message_notifications', data);
        // socketData(auth_user_id,receiver_id,elan_id);
    })

  //Message notifications
  socket.on('notifications', function(message_notification_data)
  {
      if(auth_user_id != 0){
            $('.socket-messages-data').empty();
            $.each(message_notification_data,function (key,value)
            {
              if (value.receiver_id == data.id)
              {
                $('.socket-messages-data').append(
                    '<li>' +
                    '<a href="/Mesajlar/'+value.id+'">' +
                    '<img src="/image/' + value.avatar + '" class="img-responsive pull-left" alt="Notification image" />' +
                    '<p>'+ '<span style="color:#0090D9;">' + value.name + ':</span> '+"<br>"+ value.message +'</p></a></li>'
                  );
            }
          })

      }
  });
  //notifications
  socket.emit('live_notification',data);
  socket.on('live_noti',function(live_notification_data)
  {
    $('.notification').html('');
    var notiLengthCount = 0;
      $.each(live_notification_data,function (key,value)
      {
        var noti_text_els_user= (value.type_id == 2) ?'<span class="special-destek">'+ value.qarsiliqs_user_name +'</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !':
        '<span class="special-istek">'+ value.qarsiliqs_user_name +'</span> adlı istifadəçi dəstəyinizə istək vermək istəyir !';

        var noti_text_qars_user= (value.type_id == 2) ?'<span class="special-istek">'+ value.els_user_name +'</span> adlı istifadəçi dəstəyinizi qəbul etdi !':
        '<span class="special-istek">'+ value.els_user_name +'</span> adlı istifadəçi istəyinizi qəbul etdi !';

            if (value.els_user_id==data.id)
            {
              if (value.status==1)
              {
                notiLengthCount++;
                $('.count').addClass('contact-auth-notification-number');
                 $('.contact-auth-notification-number').text(notiLengthCount);
              }
              $('.notification').append('<li>'+
              '<a href="/Bildiriş/'+value.qarsiliqs_id +'"class="notification-seen">'+
              '<img src="/image/' + value.avatar + '" class="img-responsive pull-left" alt="Notification image" />'+
              '<p>'+noti_text_els_user+'</p>'+
              '</a>'+
              '</li>'
              );

            }
            else if(value.qarsiliqs_user_id==data.id && value.data_status==1)
            {
              if (value.data_status==1)
              {
                notiLengthCount++;
                $('.count').addClass('contact-auth-notification-number');
                $('.contact-auth-notification-number').text(notiLengthCount);
              }
              $('.notification').append('<li>'+
              '<a href="/message/'+value.qarsiliqs_id +'"class="notification-seen">'+
              '<img src="/image/' + value.avatar + '" class="img-responsive pull-left" alt="Notification image" />'+
              '<p>'+noti_text_qars_user+'</p>'+
              '</a>'+
              '</li>'
              );
            }


      });
  });
//--------------------Message and Notification socket End -----------------------------------





//--------------------Chat blade code -------------------------------------------------------
  if (data_single.receiver_id != 0)
  {
    $('#notification_chat').submit(function (e)
    {
      e.preventDefault();
      // socketData(auth_user_id,receiver_id,elan_id);
        data_single.message = $('.chat-footer-input').val();
        socket.emit('send_message', data_single);
        socket.emit('count', data);
        $('.chat-footer-input').val("");
      return false;
    });
  }

socket.on('only_one_data',function (only_one_data)
{

  // console.log(only_one_data);
        if (only_one_data[0].sender_id == auth_user_id && only_one_data[0].receiver_id == receiver_id)
        {
            $('.chat-body-message').append(
                '<li class="pull-right">' +
                '<p class="chat-message-content">'+String(only_one_data[0].message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                '<img src="/image/'+only_one_data[0].avatar+'" class="chat-message-img" alt="user-image">'+
                '</li>'+
                '<div class="clearfix"></div>'
            );
        }
        else if (only_one_data[0].sender_id == receiver_id && only_one_data[0].receiver_id == auth_user_id)
        {
            $('.chat-body ul').append(
                '<li class="pull-left">' +
                '<img src="/image/'+only_one_data[0].avatar+'" class="chat-message-img" alt="user-image">'+
                '<p class="chat-message-content">'+String(only_one_data[0].message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                '</li>'+
                '<div class="clearfix"></div>'
            );
        }
        $('.chat-body').animate({scrollTop: $('.chat-body').prop("scrollHeight")}, 0.001);
})


//--------------------Chat blade code end ---------------------------------------------------


socket.emit('live_update');
var live_update = [];
socket.on('live_update_data',function(results)
{
  if (live_update.length > 0 )
  {
    if (live_update.length < results.length)
    {
      //sound play
      live_update = [];
      live_update.push(results);
    }
  }
  else
  {
    live_update.push(results);
  }
    $('.map-socket-section').empty();
    var socketDataCount = 0;
    $.each(results,function(key,value)
     {
        if (socketDataCount == 4)
        {
          return;
        }

        if (value.type_id == 2)
        {
          $('.map-socket-section').prepend("<a href=/elan/"+ value.slug + ">" + "<div class='map-socket-data'>" +  "<span style='color:#0AA699'>" + value.title + "</span>" + " adlı yeni istək əlavə olundu !" + "</div>"+ "</a>");
          socketDataCount++;
        }
        else if(value.type_id == 1)
        {
          $('.map-socket-section').prepend("<a href=/elan/"+ value.slug + ">" + "<div class='map-socket-data'>" + "<span style='color:#F35958'>" + value.title + "</span>" + " adlı yeni dəstək əlavə olundu !" + "</div>"+ "</a>");
          socketDataCount++;
        }
    });
});
}
