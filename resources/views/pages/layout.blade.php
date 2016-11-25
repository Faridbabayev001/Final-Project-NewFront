<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
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
          <ul class="list-inline pull-right contact-auth">
          <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bell"></i> <span class="contact-auth-notification-number">5</span></a>
              <ul class="dropdown-menu contact-auth-notification" role="menu">
                  <li>
                    <a href="#">
                      <img src="{{url('/images/prof.png')}}" class="img-responsive pull-left" alt="Notification image" />
                      <p><span class="special-istek">Lalə Məmmədova</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <img src="{{url('/images/n1.jpg')}}" class="img-responsive pull-left" alt="Notification image" />
                      <p><span class="special-destek">Arif İsayev</span> adlı istifadəçi dəstəyinizdən yararlanmaq istəyir !</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <img src="{{url('/images/n2.jpg')}}" class="img-responsive pull-left" alt="Notification image" />
                      <p><span class="special-istek">Araz Abdullayev</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h4 class="text-center margin0">Hamısına bax ></h4>
                    </a>
                  </li>
              </ul>
          </li>
          <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle">Xoş gəldiniz, {{Auth::user()->username}} <span class="caret"></span></a>
              <ul class="dropdown-menu contact-profil-menu" role="menu">
                  <li><a href="profil.html"><img src="{{url('/uploads/prof.png')}}" class="img-responsive center-block" alt="Avatar"/></a></li>
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
                  <a href="#2"><i class="fa fa-google"></i> GOOGLE'LA DAXİL OL</a>
                </div>

                <div class="col-lg-12">
                  <h6 class="text-center">Üzv deyilsiniz? İndi <a href="{{url('/Qeydiyyat')}}">qeydiyyatdan</a> keçin</h6>
                </div>

                <div class="contact-auth-or text-center">
                  <span>YA DA</span>
                </div>
                <div class="col-lg-12 padding0 contact-login-form">
                  <form class="" action="{{ url('/login') }}" method="POST">
                    {{csrf_field()}}
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                      <input type="email" name="email" class="form-control email-placeholder-change">
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input type="password" name="password" class="form-control" placeholder="Şifrə">
                    </div>

                        <div class="col-lg-12 padding0">
                          <input type="submit" class="btn btn-default pull-right" value="Daxil ol">
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
        <li><a {{Request::is('/') ? "class=active" : ''}} href="{{url('/')}}" class=""><i class="fa fa-home"></i> ANA SƏHİFƏ</a></li>
        <li><a {{Request::is('/Haqqımızda') ? "class=active" : ''}} href="{{url('/Haqqımızda')}}"><i class="fa fa-info-circle"></i> HAQQIMIZDA</a></li>
        <li><a {{Request::is('/Əlaqə') ? "class=active" : ''}} href="{{url('/Əlaqə')}}"><i class="fa fa-phone"></i> ƏLAQƏ</a></li>
        <li class="hidden-lg hidden-md hidden-xs"><a href="istek-add.html"><i class="fa fa-plus"></i>İSTƏK ƏLAVƏ ET</a></li>
        <li class="hidden-lg hidden-md hidden-xs"><a href="destek-add.html"><i class="fa fa-plus"></i>DƏSTƏK ƏLAVƏ ET</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right navbar-right-nav hidden-sm">
        <li class="navbar-istek-elave-et"><a href="istek-add.html"><i class="fa fa-plus"></i>İSTƏK ƏLAVƏ ET</a></li>
        <li class="navbar-destek-elave-et"><a href="destek-add.html"><i class="fa fa-plus"></i>DƏSTƏK ƏLAVƏ ET</a></li>
      </ul>
    </div>
  </div>
</nav>
</section>
@yield('container')
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
</html>
