  var socketData = function(auth_user_id, receiver_id, check) {
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
      created_at: moment().format("YYYY-MM-DD HH:mm:ss"),
      updated_at: moment().format("YYYY-MM-DD HH:mm:ss")
  };

  //-----------------Message and Notification socket -----------------------------------
  socket.emit('message_notifications', data);
  socket.on('notifications', function(message_notification_data){
      if(auth_user_id != 0){
            $('.socket-messages-data').empty();
            count=0 ;
            $.each(message_notification_data,function (key,value){
              if (value.receiver_id == data.id) {
                if (value.seen == 0) {
                    count++;
                }
                $('.socket-messages-data').append(
                    '<li>' +
                    '<a href="/Mesajlar/'+value.id+'">' +
                    '<img src="/image/' + value.avatar + '" class="img-responsive pull-left" alt="Notification image" />' +
                    '<p>'+ '<span style="color:#0090D9;">' + value.name + '</span>' + ': '+ value.message +'</p></a></li>'
                  );
            };
          })

      }else{
          count = 0;
      }
      if (count > 0) {
          $('.socket-messages-number').empty();
          $('.socket-messages-count span').text('');
          $('.socket-messages-number').append('<a href="#" data-toggle="dropdown" class="dropdown-toggle socket-messages-count"><i class="fa fa-comments-o"></i> <span class="contact-auth-notification-number"> </span> </a>');
          $('.socket-messages-count span').text(count);
      }else{
          $('.socket-messages-number').empty();
          $('.socket-messages-number').append('<a href="#" data-toggle="dropdown" class="dropdownyoxdur-toggle socket-messages-count"><i class="fa fa-comments-o"></i></a>');
  //            $('.socket-messages-data').append('<li><a href="#"> <h4 class="text-center margin0">Mesajınız yoxdur</h4></a></li>');
      }
  });

  //OnClick message notification
    $('.clickNumber').on('click',function () {
        socket.emit('CountZero',data);
        socket.emit('message_notifications', data);
    })

  //notifications
  socket.emit('live_notification',data);
  $('#notification_chat').submit(function () {
      socket.emit('live_notification',data);
  })
  socket.on('live_noti',function(live_notification_data){
    $('.notification').html('');

      $.each(live_notification_data,function (key,value) {
        var noti_text_els_user= (value.type_id == 2) ?'<span class="special-destek">'+ value.qarsiliqs_user_name +'</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !':
        '<span class="special-istek">'+ value.qarsiliqs_user_name +'</span> adlı istifadəçi desteyinize istek vermək istəyir !';

        var noti_text_qars_user= (value.type_id == 2) ?'<span class="special-istek">'+ value.els_user_name +'</span> adlı istifadəçi desteyinizi qəbul etdi !':
        '<span class="special-istek">'+ value.els_user_name +'</span> adlı istifadəçi istəyinizi qəbul etdi !';

            if (value.els_user_id==data.id) {
              if (value.status==1) {
                $('.count').addClass('contact-auth-notification-number');
                 $('.contact-auth-notification-number').text(live_notification_data.length);
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
                $('.count').addClass('contact-auth-notification-number');
                 $('.contact-auth-notification-number').text(live_notification_data.length);
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



//--------------------Notification_single chat code :D -----------------------------------
if (data_single.receiver_id != 0 && check==2)
{
  socket.emit('data',data_single);
  $('#notification_noti').submit(function ()
  {
    socketData(auth_user_id,receiver_id);
      data_single.message = $('.noti-footer-input').val();
      socket.emit('send_message', data_single);
      $('.noti-footer-input').val("");
      $('.noti-body ul').text('');
      socket.on('all_data',function (allData)
      {
          $('.noti-body ul').text('');
          $.each(allData,function (key,value)
          {
              if (value.sender_id == auth_user_id && value.receiver_id == receiver_id)
              {
                  $('.noti-body-message').append(
                      '<li class="pull-right">' +
                      '<p class="noti-message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                      '<img src="/image/'+value.avatar+'" class="noti-message-img" alt="user-image">'+
                      '</li>'+
                      '<div class="clearfix"></div>'
                  );
              }
              else if (value.sender_id == receiver_id && value.receiver_id == auth_user_id)
              {
                  $('.noti-body-message').append(
                      '<li class="pull-left">' +
                      '<img src="/image/'+value.avatar+'" class="noti-message-img" alt="user-image">'+
                      '<p class="noti-message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                      '</li>'+
                      '<div class="clearfix"></div>'
                  );
              }
          });
      })
      return false;
  });
  socket.on('all_data',function (allData)
  {
      $('.noti-body ul').text('');
      $.each(allData,function (key,noti_value)
       {
          if (noti_value.sender_id == auth_user_id && noti_value.receiver_id == receiver_id)
          {
              $('.noti-body ul').append(
                  '<li class="pull-right">' +
                  '<p class="noti-message-content">'+String(noti_value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                  '<img src="/image/'+noti_value.avatar+'" class="noti-message-img" alt="user-image">'+
                  '</li>'+
                  '<div class="clearfix"></div>'
              );
          }
          else if (noti_value.sender_id == receiver_id && noti_value.receiver_id == auth_user_id)
          {
              $('.noti-body ul').append(
                  '<li class="pull-left">' +
                  '<img src="/image/'+noti_value.avatar+'" class="noti-message-img" alt="user-image">'+
                  '<p class="noti-message-content">'+String(noti_value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                  '</li>'+
                  '<div class="clearfix"></div>'
              );
          }
      });
  });

  // CHAT scroll
  $('.noti-body').animate({scrollTop: $('.noti-body').prop("scrollHeight")}, 500);
}

//--------------------Notification_single chat code END:D -----------------------------------





//--------------------Chat blade code -------------------------------------------------------
  if (data_single.receiver_id != 0 && check==1)
  {
    socket.emit('data',data_single);
    $('#notification_chat').submit(function ()
    {
      socketData(auth_user_id,receiver_id);
        data_single.message = $('.chat-footer-input').val();
        socket.emit('send_message', data_single);
        $('.chat-footer-input').val("");
    //            $('.chat-body').text('');
        socket.on('all_data',function (allData)
        {
            $('.chat-body ul').text('');
            $.each(allData,function (key,value)
            {
                if (value.sender_id == auth_user_id && value.receiver_id == receiver_id)
                {
                    $('.chat-body-message').append(
                        '<li class="pull-right">' +
                        '<p class="chat-message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                        '<img src="/image/'+value.avatar+'" class="chat-message-img" alt="user-image">'+
                        '</li>'+
                        '<div class="clearfix"></div>'
                    );
                }
                else if (value.sender_id == receiver_id && value.receiver_id == auth_user_id)
                {
                    $('.chat-body ul').append(
                        '<li class="pull-left">' +
                        '<img src="/image/'+value.avatar+'" class="chat-message-img" alt="user-image">'+
                        '<p class="chat-message-content">'+String(value.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                        '</li>'+
                        '<div class="clearfix"></div>'
                    );
                }
            });
        })
        return false;
    });
    socket.on('all_data',function (allData)
    {
        $('.chat-body ul').text('');
        if (Object.keys(allData).length === 0)
        {
         $(".dsp_none").css("display","none");
        }
        $.each(allData,function (key,values)
        {
            $('.chat-header-name').text(values.username);
            if (values.sender_id == auth_user_id && values.receiver_id == receiver_id)
            {
                $('.chat-body ul').append(
                    '<li class="pull-right">' +
                    '<p class="chat-message-content">'+String(values.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                    '<img src="/image/'+values.avatar+'" class="chat-message-img" alt="user-image">'+
                    '</li>'+
                    '<div class="clearfix"></div>'
                );
            }
            else if (values.sender_id == receiver_id && values.receiver_id == auth_user_id)
            {
                $('.chat-body ul').append(
                    '<li class="pull-left">' +
                    '<img src="/image/'+values.avatar+'" class="chat-message-img" alt="user-image">'+
                    '<p class="chat-message-content">'+String(values.message).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')+'</p>'+
                    '</li>'+
                    '<div class="clearfix"></div>'
                );
                $('.chat-body').animate({scrollTop: $('.chat-body').prop("scrollHeight")}, 0.001);
            }
        });
    });

    //CHAT scroll
    $('.chat-body').animate({scrollTop: $('.chat-body').prop("scrollHeight")}, 0.001);

  }


//--------------------Chat blade code end ---------------------------------------------------


socket.emit('live_update');
var live_update = [];
socket.on('live_update_data',function(results){
  if (live_update.length > 0 ) {
    console.log('live_update length = '+ live_update.length);
    console.log('results length = '+ results.length);
    if (live_update.length < results.length) {
      //sound play
      live_update = [];
      live_update.push(results);
    }
  }else {
    live_update.push(results);
  }
    $('.map-socket-section').empty();
    $.each(results,function(key,value){
        if (value.type_id == 2){
          $('.map-socket-section').prepend("<a href=/single/"+ value.id + ">" + "<div class='map-socket-data'>" +  "<span style='color:#0AA699'>" + value.title + "</span>" + " adlı yeni istək əlavə olundu !" + "</div>"+ "</a>");
        }else if(value.type_id == 1){
            $('.map-socket-section').prepend("<a href=/single/"+ value.id + ">" + "<div class='map-socket-data'>" + "<span style='color:#F35958'>" + value.title + "</span>" + " adlı yeni dəstək əlavə olundu !" + "</div>"+ "</a>");
        }
    });
});
}
