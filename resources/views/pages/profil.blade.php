@extends('pages.layout')

@section('title','Profil')

@section('content')
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
        <h1 class="text-left">Profilim</h1>
        <div class="col-lg-9 col-lg-offset-1">
          <ul class="nav nav-tabs">
            <li {{Request::is('Profil') ? "class=active" : ''}}><a data-toggle="tab" href="#profil-view">Profil görünüşü</a></li>
            <li {{Request::is('Istekler') ? "class=active" : ''}}><a data-toggle="tab" href="#profil-isteklerim">İstəklərim</a></li>
            <li {{Request::is('Destekler') ? "class=active" : ''}}><a data-toggle="tab" href="#profil-desteklerim">Dəstəklərim</a></li>
            <li><a data-toggle="tab" href="#profil-notification">Bildirişlər</a></li>
            <li><a data-toggle="tab" href="#profil-settings">Tənzimləmələr</a></li>
          </ul>
        </div>
    </div>
  </div>
</div>

<section id="profil">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 col-lg-offset-2">
        <div class="tab-content">
          <div id="profil-view" class="tab-pane fade in {{Request::is('Profil') ? "active" : ''}}">
            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-4 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-4 padding0 profil-avatar">
              <img src="{{url('/uploads/prof.png')}}" alt="Avatar">
            </div>
            <div class="col-lg-9 col-sm-9 col-xs-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-3 profil-name">
              <h2>{{Auth::user()->name}}</h2>
              <a href="#"><h2 class="pull-right"><i class="fa fa-pencil-square-o"></i></h2></a>
              <hr>
            </div>
            <div class="col-lg-9 col-sm-9 col-xs-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-3 profil-phone">
              <p><i class="fa fa-phone"></i> {{Auth::user()->phone}}</p>
            </div>
            <div class="col-lg-9 col-sm-9 col-sm-offset-2 col-xs-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-3 profil-email">
              <p><i class="fa fa-envelope"></i> {{Auth::user()->email}}</p>
            </div>
            <div class="col-lg-9 col-md-9 col-md-offset-2 col-sm-9 col-sm-offset-2 col-xs-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-3 profil-address">
              <p><i class="fa fa-map-marker"></i> {{Auth::user()->city}}</p>
            </div>
          </div>
          <div id="profil-isteklerim" class="tab-pane fade {{Request::is('Istekler') ? "in active" : ''}}">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Dərc olunub?</th>
                    <th>Bitmə vaxtı</th>
                    <th>Başlıq</th>
                    <th>Təsvir</th>
                    <th>Şəkil</th>
                    <th>Yenilə & Sil</th>
                  </tr>
                </thead>
                    @foreach ($Elan_all as $istekler)
                      <tbody>
                        <tr>
                      @if ($istekler->user_id == Auth::user()->id && $istekler->type_id == '2')
                        @php
                          $derc_status = 'Dərc olunmayıb';
                          $derc_icon = 'fa fa-times-circle-o fa-2x';
                          if ($istekler->status==1) {
															$derc_status = " Dərc olunub";
															$derc_icon = 'fa fa-check-circle-o fa-2x';
														}
                        @endphp
                        <td class="profil-isteklerim-status" title="{{$derc_status}}"><i class="{{$derc_icon}}"></i></td>
                        <td>{{$istekler->deadline}}</td>
                        <td>{{$istekler->title}}</td>
                        <td>{{$istekler->about}}</td>
                        <td class="profil-isteklerim-photo"><img src="{{url('/image/'.$istekler->image)}}" class="img-responsive" alt="News image"></td>
                        <td class="profil-isteklerim-action">
                          <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                          <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    </tbody>
                      @endif
                    @endforeach
              </table>
            </div>
          </div>
          <div id="profil-desteklerim" class="tab-pane fade {{Request::is('Destekler') ? "in active" : ''}}">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Dərc olunub?</th>
                    <th>Bitmə vaxtı</th>
                    <th>Başlıq</th>
                    <th>Təsvir</th>
                    <th>Şəkil</th>
                    <th>Yenilə & Sil</th>
                  </tr>
                </thead>
                @foreach ($Elan_all as $destekler)
                  <tbody>
                    <tr>
                  @if ($destekler->user_id == Auth::user()->id && $destekler->type_id == '1')
                    @php
                      $derc_status = 'Dərc olunmayıb';
                      $derc_icon = 'fa fa-times-circle-o fa-2x';
                      if ($destekler->status==1) {
                          $derc_status = " Dərc olunub";
                          $derc_icon = 'fa fa-check-circle-o fa-2x';
                        }
                    @endphp
                    <td class="profil-desteklerim-status" title="{{$derc_status}}"><i class="{{$derc_icon}}"></i></td>
                    <td>{{$destekler->deadline}}</td>
                    <td>{{$destekler->title}}</td>
                    <td>{{$destekler->about}}</td>
                    <td class="profil-desteklerim-photo"><img src="{{url('/image/'.$destekler->image)}}" class="img-responsive" alt="News image"></td>
                    <td class="profil-desteklerim-action">
                      <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                      <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
                  @endif
                @endforeach
              </table>
            </div>
          </div>
          <div id="profil-notification" class="tab-pane fade in">
            <div class="col-lg-12 padding0 notification-block">
              <a href="#" class="notification-block-href">
                <div class="col-lg-2">
                    <img class="center-block" src="{{url('/images/n2.jpg')}}" alt="">
                </div>
                <div class="col-lg-9">
                  <p class="profil-notification-title"><span class="special-istek">Araz Abdullayev</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !</p>
                  <p class="profil-notification-desc">Salam, Mən pulsuz developer olaraq işləyə bilərəm. Zəhmət olmasa qəbul edin. Emailim: arazzz@gmail.com. Bundan başqa...</p>
                  <p class="profil-notification-full pull-right"><a href="#" class="btn zaa">Tam müraciətə bax<i class="fa fa-angle-double-right"></i></a></p>
                </div>
              </a>
            </div>
            <div class="col-lg-12 padding0 notification-block">
              <a href="#" class="notification-block-href">
                <div class="col-lg-2">
                    <img class="center-block" src="{{url('/images/n2.jpg')}}" alt="">
                </div>
                <div class="col-lg-9">
                  <p class="profil-notification-title"><span class="special-istek">Araz Abdullayev</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !</p>
                  <p class="profil-notification-desc">Salam, Mən pulsuz developer olaraq işləyə bilərəm. Zəhmət olmasa qəbul edin. Emailim: arazzz@gmail.com. Bundan başqa...</p>
                  <p class="profil-notification-full pull-right"><a href="#" class="btn zaa">Tam müraciətə bax<i class="fa fa-angle-double-right"></i></a></p>
                </div>
              </a>
            </div>
            <div class="col-lg-12 padding0 notification-block">
              <a href="#" class="notification-block-href">
                <div class="col-lg-2">
                    <img class="center-block" src="{{url('/images/n2.jpg')}}" alt="">
                </div>
                <div class="col-lg-9">
                  <p class="profil-notification-title"><span class="special-istek">Araz Abdullayev</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !</p>
                  <p class="profil-notification-desc">Salam, Mən pulsuz developer olaraq işləyə bilərəm. Zəhmət olmasa qəbul edin. Emailim: arazzz@gmail.com. Bundan başqa...</p>
                  <p class="profil-notification-full pull-right"><a href="#" class="btn zaa">Tam müraciətə bax<i class="fa fa-angle-double-right"></i></a></p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
