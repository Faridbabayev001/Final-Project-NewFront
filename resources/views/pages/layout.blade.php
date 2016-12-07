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
  <meta name="_token" content="{!!csrf_token()!!}">
  <title>Bumerang.org | @yield('title')</title>
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="{{url('/css/style.css')}}" media="screen" title="no title">
</head>
<body>

<section id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="list-inline pull-left contact-social">
          <li class="list-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li class="list-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
          <li class="list-item"><a href="#"><i class="fa fa-google-plus"></i></a></li>
          <li class="list-item"><a href="#"><i class="fa fa-envelope"></i> contact@test.com</a></li>
        </ul>
        @if (Auth::guest())
          <ul class="list-inline pull-right contact-auth">
            <li class="list-item"><a href="#" data-toggle="modal" data-target="#contact-login-modal"><i class="fa fa-user"></i> Daxil ol</a></li>
            <li class="list-item"><a href="{{url('/Qeydiyyat')}}"><i class="fa fa-user-plus"></i> Qeydiyyat</a></li>
          </ul>
        @else

          @php
          $noti = Elan::join('users', 'users.id', '=', 'els.user_id')
                     ->join('qarsiliqs', 'qarsiliqs.elan_id', '=', 'els.id')
                     ->select('els.type_id','users.name','users.avatar','qarsiliqs.notification','qarsiliqs.id','qarsiliqs.status','qarsiliqs.data')
                      ->where([
                            ['qarsiliqs.status', '=', 1],
                            ['els.user_id', '=', Auth::user()->id]
                        ])
                        ->orWhere('qarsiliqs.data_status', '=', 1)
                        ->get();

           $noti_image = Qarsiliq::join('users', 'users.id', '=', 'qarsiliqs.user_id')
                     ->join('els', 'els.id', '=', 'qarsiliqs.elan_id')
                     ->select('users.name','users.avatar','qarsiliqs.created_at','els.type_id','qarsiliqs.user_id','qarsiliqs.id','qarsiliqs.status','qarsiliqs.data')
                     ->orderBy('created_at', 'desc')
                      ->where('els.user_id', '=', Auth::user()->id)
                      ->orWhere('qarsiliqs.user_id', '=', Auth::user()->id)
                     ->take(3)
                     ->get();

                     $data_join=Qarsiliq::join('els', 'els.id', '=', 'qarsiliqs.elan_id')
                               ->join('users', 'users.id', '=', 'els.user_id')
                               ->select('users.name','els.type_id','users.email','users.city','qarsiliqs.id','users.avatar')
                               ->where('qarsiliqs.user_id','=',Auth::user()->id)
                               ->get();
                        // dd($data_join);
          @endphp
          <ul class="list-inline pull-right contact-auth">
          <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bell"></i>
                <?php if(count($noti) != 0){ ?>

                 <span class="contact-auth-notification-number">
                   {{count($noti)}}
                 </span>
                 <?php } ?>
               </a>
              <ul class="dropdown-menu contact-auth-notification" role="menu">
                @foreach($noti_image as $key => $notification_image)
                  @if($notification_image->user_id != Auth::user()->id)
                    <li>
                      @if($notification_image->status==0)
                          <a href="{{url('/Bildiriş/'.$notification_image->id)}}" class="notification-seen">
                            <img src="{{url('/image/'.$notification_image->avatar)}}" class="img-responsive pull-left" alt="Notification image" />
                              <p>
                                @if($notification_image->type_id==2)
                                  <span class="special-istek">{{$notification_image->name}}</span>  adlı istifadəçi istəyinizə dəstək vermək istəyir !
                                @endif
                                @if($notification_image->type_id==1)
                                  <span class="special-destek">{{$notification_image->name}}</span>  adlı istifadəçi dəstəyinizdən yararlanmaq istəyir !
                                @endif
                              </p>
                          </a>
                        @else
                          <a href="{{url('/Bildiriş/'.$notification_image->id)}}">
                            <img src="{{url('/image/'.$notification_image->avatar)}}" class="img-responsive pull-left" alt="Notification image" />
                            <p>
                              @if($notification_image->type_id==2)
                                <span class="special-istek">{{$notification_image->name}}</span>  adlı istifadəçi istəyinizə dəstək vermək istəyir !
                              @endif
                              @if($notification_image->type_id==1)
                                <span class="special-destek">{{$notification_image->name}}</span>  adlı istifadəçi dəstəyinizdən yararlanmaq istəyir !
                              @endif
                            </p>
                          </a>
                    @endif
                  </li>

                @elseif($notification_image->user_id == Auth::user()->id)
                   <li>
                       @foreach($data_join as $key => $data_join)
                         @if($notification_image->data_status==0)
                         <a href="{{url('/message/'.$data_join->id)}}" class="notification-seen">
                           <img src="{{url('/image/'.$data_join->avatar)}}" class="img-responsive pull-left" alt="Notification image" />
                           <p>
                             @if($data_join->type_id==2)
                               <span class="special-istek">{{$data_join->name}}</span>  adlı istifadəçi desteyinizi qəbul etdi !
                             @endif
                             @if($data_join->type_id==1)
                               <span class="special-destek">{{$data_join->name}}</span>  adlı istifadəçi istəyinizi qəbul etdi !
                             @endif
                           </p>
                         </a>
                       @else
                         <a href="{{url('/message/'.$data_join->id)}}">
                           <img src="{{url('/image/'.$data_join->avatar)}}" class="img-responsive pull-left" alt="Notification image" />
                           <p>
                             @if($data_join->type_id==2)
                               <span class="special-istek">{{$data_join->name}}</span>  adlı istifadəçi desteyinizi qəbul etdi !
                             @endif
                             @if($data_join->type_id==1)
                               <span class="special-destek">{{$data_join->name}}</span>  adlı istifadəçi istəyinizi qəbul etdi !
                             @endif
                           </p>
                         </a>
                     @endif
                         @endforeach
                      </li>
                  @endif
                @endforeach
                  <li>
                    <a href="{{url('/Bildirişlər')}}">
                      <h4 class="text-center margin0">Hamısına bax ></h4>
                    </a>
                  </li>
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
                  <a href="#1"><i class="fa fa-facebook"></i> FACEBOOK'LA DAXİL OL</a>
                </div>

                <div class="contact-auth-google">
                  <a href="#2"><i class="fa fa-google-plus"></i> GOOGLE+'LA DAXİL OL</a>
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
                    <div id="EmailGroup" class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                      <input id="email" type="email" name="email" class="form-control email-placeholder-change">
                    </div>
                      <strong id="EmailError" class="text-danger"></strong>
                    <div id="PasswordGroup" class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input id="pass" type="password" name="password" class="form-control" placeholder="Şifrə">
                    </div>
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
</nav>
</section>
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


</body>

<script src="{{url('/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{url('/js/vendor/jquery-ui.js')}}"></script>
<script src="{{url('/js/vendor/bootstrap.min.js')}}"></script>
<script src="{{url('/js/InfoBubble.js')}}" charset="utf-8"></script>
<script src="{{url('/js/AjaxSearchMap.js')}}" charset="utf-8"></script>
<script src="{{url('/js/main.js')}}"></script>
  @yield('scripts')
</html>
