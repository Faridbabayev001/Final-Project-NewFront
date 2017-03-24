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
                <a data-toggle="modal" data-target="#notif-accept-modal" class="btn not-accept"><i class="fa fa-check"></i> Qəbul et</a>
                <a href="{{url('/refusal/'.$notication_single->id)}}" class="btn not-deny"><i class="fa fa-times"></i> İmtina et</a>

                {{-- ACCEPT MODAL --}}
                <div id="notif-accept-modal" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Əminsinizmi ?</h4>
                      </div>
                      <div class="modal-body">
                        <p>
                          Qəbul etdiyiniz təqdirdə sizin bütün informasiyalarınız həmin <b>{{$notication_single->name}}</b> adlı şəxsə ötürüləcək.
                        </p>
                      </div>
                      <div class="modal-footer">
                        <a href="{{url('/accept/'.$notication_single->id)}}" class="btn not-accept">Bəli</a>
                        <a data-dismiss="modal" class="btn not-deny margin0">Xeyr</a>

                      </div>
                    </div>

                  </div>
                </div>
                {{-- ACCEPT MODAL --}}

              </p>
            @else
            @endif
          </div>
        </div>
        <div id="noti">
          <div class="noti-header">
            <h5 class="noti-header-name"> {{ $notication_single->name }}</h5>
          </div>
          <div class="noti-body">
            <ul class="list-group noti-body-message list-unstyled">
            </ul>
          </div>

          <div class="noti-footer">
            <form id="notification_noti"  action="" method="post">
              <div class="col-lg-10 padding0">
                <input type="text" class="form-control noti-footer-input" name="" placeholder="Mesajınız">
              </div>

              <div class="col-lg-2 padding0">
                <button type="submit" name="button" class="btn noti-footer-btn"><i class="fa fa-paper-plane-o"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      </div>
      </div>

      </div>
    @else
      <h1 class="text-center">Sorğunuz düzgün deyil !</h1>
    @endif
    @php
        if (Auth::user()){
            $id = Auth::user()->id;
        }else{
            $id = 0;
        }
    @endphp
  </section>
  @section('scripts')

    <script src="{{url('/js/vendor/jquery-2.2.4.min.js')}}"></script>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script>
    <script type="text/javascript"></script>

  @endsection
@endsection
