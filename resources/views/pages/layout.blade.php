
<?php
use App\Elan;
use App\User;
use App\Qarsiliq;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta property="og:url"                content="http://www.bumeranq.org" />
  <meta property="og:type"               content="article" />
  <meta property="og:title"              content="Bumeranq.org" />
  <meta property="og:description"        content="Bumeranq.org" />
  <meta property="og:image"              content="{{url('/images/favicon.png')}}" />
  <meta name="_token" content="{!!csrf_token()!!}">
  <title>Bumeranq.org | @yield('title')</title>
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="theme-color" content="#ffffff">
    <script src="{{url('/js/moment.js')}}"></script>
    <link rel="stylesheet" href="{{url('/css/style.css')}}" media="screen" title="no title">
</head>
<body>

<section id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="list-inline pull-left contact-social">
          {{-- <li class="list-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li class="list-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
          <li class="list-item"><a href="#"><i class="fa fa-google-plus"></i></a></li> --}}
          <li class="list-item"><a href="mailto:info@bumeranq.org"><i class="fa fa-envelope"></i> info@bumeranq.org</a></li>
        </ul>
        @if (Auth::guest())
          <ul class="list-inline pull-right contact-auth">
            <li class="list-item"><a href="#" data-toggle="modal" data-target="#contact-login-modal"><i class="fa fa-user"></i> Daxil ol</a></li>
            <li class="list-item"><a href="{{url('/Qeydiyyat')}}"><i class="fa fa-user-plus"></i> Qeydiyyat</a></li>
          </ul>
        @else
          <ul class="list-inline pull-right contact-auth">
              <li class="dropdown">
                  <a href="#" data-toggle="dropdown" class="dropdown-toggle socket-messages-number"> </a>
                  <ul class="dropdown-menu contact-auth-notification socket-messages-data" role="menu">
                  </ul>
              </li>

              <li class="dropdown">
                      <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="fa fa-bell"></i>
                         <span class="count">
                         </span>
                       </a>
                  <ul class="dropdown-menu contact-auth-notification notification" role="menu">

                  </ul>
              </li>
          <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle">Xoş gəldiniz, {{Auth::user()->name}} <span class="caret"></span></a>
              <ul class="dropdown-menu contact-profil-menu" role="menu">
                  <li><a href="{{url('/Profil')}}"><img src="{{url('/image/'.Auth::user()->avatar)}}" class="center-block" alt="Avatar"/></a></li>
                  <li><a href="{{url('/Profil')}}"><i class="fa fa-btn fa-user"></i> Profilim</a></li>
                  <li><a href="{{url('/Istekler')}}"><i class="fa fa-btn fa-map-marker"></i> İstəklərim</a></li>
                  <li><a href="{{url('/Destekler')}}"><i class="fa fa-btn fa-support"></i> Dəstəklərim</a></li>
                  <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Çıxış</a></li>
              </ul>
          </li>
        </ul>
        @endif
        <!-- Login Modal -->
        <div id="contact-login-modal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-sm">

            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Daxil ol</h4>
              </div>

              <div class="modal-body">

                <div class="contact-auth-facebook">
                  <a href="{{route('facebook.login')}}"><i class="fa fa-facebook"></i> FACEBOOK'LA DAXİL OL</a>
                </div>

                <div class="contact-auth-google">
                  <a href="{{route('google.login')}}"><i class="fa fa-google-plus"></i> GOOGLE+'LA DAXİL OL</a>
                </div>

                <div class="col-lg-12">
                  <h6 class="text-center">Üzv deyilsiniz? İndi <a href="{{url('/Qeydiyyat')}}">qeydiyyatdan</a> keçin</h6>
                </div>

                <div class="contact-auth-or text-center">
                  <span>YA DA</span>
                </div>
                <div class="col-lg-12 padding0 contact-login-form">
                  <form id="SubmitLogin" class="ModalLogin" action="" method="POST">
                    {{csrf_field()}}
                    <strong id="EmailError" class="text-danger"></strong>
                    <div id="EmailGroup" class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                      <input id="email" type="email" name="email" class="form-control email-placeholder-change">
                    </div>
                    <div id="PasswordGroup" class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input id="pass" type="password" name="password" class="form-control" placeholder="Şifrə">
                    </div>
                  <a class="btn btn-link" href="{{ url('/password/reset') }}">Şifrəni unutdun ?</a>
                    <strong id="PasswordError" class="text-danger"></strong>
                        <div class="col-lg-12 padding0">
                          <input id="submit"  type="submit" class="btn btn-default pull-right" value="Daxil ol">
                        </div>
                  </form>
                </div>

              </div>
              <div class="clear-fix"></div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<section id="navbar">
  <nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('/images/logo.png')}}" class="img-responsive" alt="logo" /></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-left-nav">
        <li><a {{Request::is('/') ? "class=active" : ''}} href="{{url('/')}}"><i class="fa fa-home"></i> ANA SƏHİFƏ</a></li>
        <li><a {{Request::is('Haqqımızda') ? "class=active" : ''}} href="{{url('/Haqqımızda')}}"><i class="fa fa-info-circle"></i> HAQQIMIZDA</a></li>
        <li><a {{Request::is('Əlaqə') ? "class=active" : ''}} href="{{url('/Əlaqə')}}"><i class="fa fa-phone"></i> ƏLAQƏ</a></li>
        <li class="hidden-lg hidden-md hidden-xs"><a href="{{url('/istek-add')}}"><i class="fa fa-plus"></i>İSTƏK ƏLAVƏ ET</a></li>
        <li class="hidden-lg hidden-md hidden-xs"><a href="{{url('/destek-add')}}"><i class="fa fa-plus"></i>DƏSTƏK ƏLAVƏ ET</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right navbar-right-nav hidden-sm">
        <li class="navbar-istek-elave-et"><a href="{{url('/istek-add')}}"><i class="fa fa-plus"></i>İSTƏK ƏLAVƏ ET</a></li>
        <li class="navbar-destek-elave-et"><a href="{{url('/destek-add')}}"><i class="fa fa-plus"></i>DƏSTƏK ƏLAVƏ ET</a></li>
      </ul>
    </div>
  </div>
  {{-- <p>
      @if($notification_image->type_id==2)
        <span class="special-istek">{{$notification_image->name}}</span>  adlı istifadəçi istəyinizə dəstək vermək istəyir !
      @endif
      @if($notification_image->type_id==1)
        <span class="special-destek">{{$notification_image->name}}</span>  adlı istifadəçi dəstəyinizdən yararlanmaq istəyir !
      @endif
    </p> --}}
</nav>
</section>
<script src="{{url('/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script>
            {{-- content  yield--}}
@yield('content')

<section id="footer">
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5>&copy; Copyright Bumeranq.org</h5>
    </div>
  </div>
</div>
</section>
@php
    if (Auth::user()){
        $id = Auth::user()->id;
    }else{
        $id = 0;
    }
@endphp

</body>


<script src="{{url('/js/vendor/jquery-ui.js')}}"></script>
<script src="{{url('/js/vendor/bootstrap.min.js')}}"></script>
<script src="{{url('/js/InfoBubble.js')}}" charset="utf-8"></script>
<script src="{{url('/js/AjaxSearchMap.js')}}" charset="utf-8"></script>
<script src="{{url('/js/main.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
      var socket = io(':3000');
      var count = 0;
      var data = {
          id: {{$id}}
      }

    socket.emit('message_notifications', data);
    socket.on('notifications', function(message_notification_data){
        if({{$id}} != 0){
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

    //notifications
    socket.emit('live_notification',data);
    socket.on('live_noti',function(live_notification_data){
      $('.notification').html('');
      console.log(live_notification_data);

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
              else if(value.qarsiliqs_user_id==data.id && value.data_status==1){
                if (value.data_status==1) {
                  $('.count').addClass('contact-auth-notification-number');
                   $('.contact-auth-notification-number').text(live_notification_data.length);
                }
                console.log('yes');
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
  });
    
</script>
  @yield('scripts')
</html>
