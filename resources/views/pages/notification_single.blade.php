@extends('pages.layout')

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
  <section id="profil">
   <div id="profil-notification" class="tab-pane fade in">
       <div class="col-lg-2">
           <img class="center-block" src="{{url('/image/'.$notication_single->avatar)}}">
       </div>
       <div class="col-lg-9">
         <p class="profil-notification-title">
             @if($notication_single->type_id==2)
               <span class="special-istek">{{$notication_single->name}}</span> adlı istifadəçi istəyinizə dəstək vermək istəyir !
             @elseif($notification_message->type_id==1)
                 <span class="special-destek">{{$notication_single->name}}</span> adlı istifadəçi dəstəyinizdən yararlanmaq istəyir !
             @endif
         </p>
         <p class="profil-notification-desc">{{$notication_single->description}}</p>
         {{-- <p class="profil-notification-full pull-right"><a href="#" class="btn zaa">Tam müraciətə bax<i class="fa fa-angle-double-right"></i></a></p> --}}
       </div>
</div>
</section>
@endsection
