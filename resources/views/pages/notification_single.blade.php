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
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <img src="/images/avatar.png" alt="">
        </div>
        <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
          <h3 class="not-single-title">
            @if($notication_single->type_id==2)
              <span class="special-istek">{{$notication_single->name}}</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !
            @elseif($notification_message->type_id==1)
                <span class="special-destek">{{$notication_single->name}}</span> adlı istifadəçi dəstəyinizdən yararlanmaq istəyir !
            @endif
          </h3>
          <h4 class="not-single-desc">{{$notication_single->description}}</h4>
          <p class="pull-right">
            <a href="#" class="btn not-accept"><i class="fa fa-check"></i> Qəbul et</a>
            <a href="#" class="btn not-deny"><i class="fa fa-times"></i> İmtina et</a>
          </p>
        </div>
      </div>
    </div>
  </section>
@endsection
