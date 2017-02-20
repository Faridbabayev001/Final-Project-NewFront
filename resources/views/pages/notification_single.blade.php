@extends('pages.layout')
@section('title')
  Bildiriş
@endsection
@section('content')
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
       <div class="col-lg-12">
         <h1 class="text-left">Bildiriş</h1>
       </div>
    </div>
  </div>
  </div>
  <section id="notification-single">
    @if(isset($notication_single->id))
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <img src="{{url('/image/'.$notication_single->avatar)}}" alt="">
          </div>
          <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
            <h3 class="not-single-title">
              @if($notication_single->type_id==2)
                <span class="special-istek">{{$notication_single->name}}</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !
              @elseif($notication_single->type_id==1)
                <span class="special-destek">{{$notication_single->name}}</span> adlı istifadəçi dəstəyinizdən yararlanmaq istəyir !
              @endif
            </h3>
            <h4 class="not-single-desc">{{$notication_single->description}}</h4>
            @if($notication_single->notification==0)
              <div class="alert alert-danger" role="alert">
                @if($notication_single->type_id==1)
                  Bu istək imtina edilib !
                @elseif($notication_single->type_id==2)
                  Bu dəstək imtina edilib !
                @endif
              </div>
            @elseif($notication_single->data==0)
              <p class="pull-right">
                <a href="{{url('/accept/'.$notication_single->id)}}" class="btn not-accept"><i class="fa fa-check"></i> Qəbul et</a>
                <a href="{{url('/refusal/'.$notication_single->id)}}" class="btn not-deny"><i class="fa fa-times"></i> İmtina et</a>
              </p>
            @else
            @endif
          </div>
        </div>
        <div id="chat">
          <div class="chat-header">
            <h5 class="header-name"> {{$notication_single->username}}</h5>
          </div>
          <div class="chat-body">
            <ul class="list-group body-message list-unstyled">
            </ul>
          </div>

          <div class="chat-footer">
            <form id="notification_chat" action="" method="post">
              <div class="col-lg-10 padding0">
                <input type="text" class="form-control footer-input" name="" placeholder="Mesajınız">
              </div>

              <div class="col-lg-2 padding0">
                <button type="submit" name="button" class="btn footer-btn"><i class="fa fa-paper-plane-o"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      </div>
      </div>
      <script src="{{url('/js/vendor/jquery-2.2.4.min.js')}}"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script>
      <script type="text/javascript">
          var socket = io(':3000');
          var date = new Date();
          var data_single = {
              sender_id :{{Auth::user()->id}},
              receiver_id: {{$notication_single->user->id}},
              message :  "",
              seen: 0,
              created_at: moment().format("YYYY-MM-DD HH:mm:ss"),
              updated_at: moment().format("YYYY-MM-DD HH:mm:ss")
          };
          socket.emit('data',data_single);
          $('#notification_chat').submit(function () {
              data_single.message = $('.footer-input').val();
              socket.emit('send_message', data_single);
              $('.footer-input').val("");
              $('.chat-body ul').text('');
              socket.on('all_data',function (allData) {
                  $('.chat-body ul').text('');
                  $.each(allData,function (key,value) {
                      if (value.sender_id == {{Auth::user()->id}}){
                          $('.body-message').append(
                              '<li class="pull-right">' +
                              '<p class="message-content">'+value.message+'</p>'+
                              '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                              '</li>'+
                              '<div class="clearfix"></div>'
                          );
                      }else if (value.sender_id == {{$notication_single->user->id}} && value.receiver_id == {{Auth::user()->id}}){
                          $('.body-message').append(
                              '<li class="pull-left">' +
                              '<p class="message-content">'+value.message+'</p>'+
                              '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                              '</li>'+
                              '<div class="clearfix"></div>'
                          );
                      }
                  });
              })
              return false;
          });
          socket.on('all_data',function (allData) {
              $('.chat-body ul').text('');
              $.each(allData,function (key,value) {
                  if (value.sender_id == {{Auth::user()->id}}){
                      $('.body-message').append(
                          '<li class="pull-right">' +
                          '<p class="message-content">'+value.message+'</p>'+
                          '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                          '</li>'+
                          '<div class="clearfix"></div>'
                      );
                  }else if (value.sender_id == {{$notication_single->user->id}} && value.receiver_id == {{Auth::user()->id}}){
                      $('.chat-body ul').append(
                          '<li class="pull-left">' +
                          '<img src="/image/'+value.avatar+'" class="message-img" alt="user-image">'+
                          '<p class="message-content">'+value.message+'</p>'+
                          '</li>'+
                          '<div class="clearfix"></div>'
                      );
                  }
              });
          });

          // CHAT scroll
          $('.chat-body').animate({scrollTop: $('.chat-body').prop("scrollHeight")}, 500);
      </script>
      </div>
    @else
      <h1 class="text-center">Sorğunuz düzgün deyil !</h1>
    @endif
  </section>
@endsection
