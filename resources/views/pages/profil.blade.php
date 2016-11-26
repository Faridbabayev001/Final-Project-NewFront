@extends('pages.layout')

@section('title','Profil')

@section('content')
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
        <h1 class="text-center">Profilim</h1>
        <div class="col-lg-9 col-lg-offset-3">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#profil-view">Profil görünüşü</a></li>
            <li><a data-toggle="tab" href="#profil-isteklerim">İstəklərim</a></li>
            <li><a data-toggle="tab" href="#profil-desteklerim">Dəstəklərim</a></li>
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
          <div id="profil-view" class="tab-pane fade in active">
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
          <div id="profil-isteklerim" class="tab-pane fade">
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
                <tbody>
                  <tr>
                    <td class="profil-isteklerim-status" title="Dərc olunub"><i class="fa fa-check-circle-o fa-2x"></i></td>
                    <td>25 Noyabr 2016</td>
                    <td>Web developer lazımdı təcili </td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</td>
                    <td class="profil-isteklerim-photo"><img src="assets/images/a.jpg" class="img-responsive" alt="News image"></td>
                    <td class="profil-isteklerim-action">
                      <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                      <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td class="profil-isteklerim-status" title="Dərc olunmayıb"><i class="fa fa-times-circle-o fa-2x"></i></td>
                    <td class="profil-isteklerim-deadline">Vaxt Bitib !</td>
                    <td>İşçi axtarılır </td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</td>
                    <td class="profil-isteklerim-photo"><img src="assets/images/n2.jpg" class="img-responsive" alt="News image"></td>
                    <td class="profil-isteklerim-action">
                      <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                      <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td class="profil-isteklerim-status" title="Yoxlanış gözlənilir"><i class="fa fa-clock-o fa-2x"></i></td>
                    <td>3 Gün</td>
                    <td>Təhsil sərgisinə könüllü </td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</td>
                    <td class="profil-isteklerim-photo"><img src="assets/images/avatar.png" class="img-responsive" alt="News image"></td>
                    <td class="profil-isteklerim-action">
                      <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                      <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div id="profil-desteklerim" class="tab-pane fade">
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
                <tbody>
                  <tr>
                    <td class="profil-desteklerim-status" title="Dərc olunub"><i class="fa fa-check-circle-o fa-2x"></i></td>
                    <td>1 Dekabr 2016</td>
                    <td>Köhnə kitab </td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</td>
                    <td class="profil-desteklerim-photo"><img src="assets/images/a.jpg" class="img-responsive" alt="News image"></td>
                    <td class="profil-desteklerim-action">
                      <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                      <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td class="profil-desteklerim-status" title="Dərc olunmayıb"><i class="fa fa-times-circle-o fa-2x"></i></td>
                    <td class="profil-isteklerim-deadline">Vaxt Bitib !</td>
                    <td>Artıq Tv </td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</td>
                    <td class="profil-desteklerim-photo"><img src="assets/images/n2.jpg" class="img-responsive" alt="News image"></td>
                    <td class="profil-desteklerim-action">
                      <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                      <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td class="profil-desteklerim-status" title="Yoxlanış gözlənilir"><i class="fa fa-clock-o fa-2x"></i></td>
                    <td>3 Gün</td>
                    <td>Pulsuz laptop təmiri </td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</td>
                    <td class="profil-desteklerim-photo"><img src="assets/images/avatar.png" class="img-responsive" alt="News image"></td>
                    <td class="profil-desteklerim-action">
                      <a href="#" class="btn action-edit"><i class="fa fa-pencil-square"></i></a>
                      <a href="#" class="btn action-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
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
