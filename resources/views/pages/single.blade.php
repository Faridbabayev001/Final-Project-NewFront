@extends('pages.layout')
@section('title','Ətraflı')
@section('content')
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
        <h1 class="text-left">{{$single->title}}</h1>
    </div>
  </div>
</div>

<section id="single">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="single-img">
          <div class="single-img-deadline">
            <i class="fa fa-calendar"></i>
            @if(!$diff->d == 0 && $diff->m == 0)
                {{$diff->d}} gün
            @else
                {{$diff->m}} ay {{$diff->d}} gün
            @endif
          </div>
          <img src="{{url('/image/'.$single->image)}}" class="img-responsive" alt="" />
          <div class="single-img-location">
            <i class="fa fa-map-marker"></i> {{$single->location}}
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="single-social">
          <ul class="list-inline text-center">
            <li class="single-social-facebook"><a href="#"><i class="fa fa-facebook"></i> PAYLAŞ</a></li>
            <li class="single-social-google"><a href="#"><i class="fa fa-google-plus"></i> PAYLAŞ</a></li>
          </ul>
        </div>
        <div class="single-content">
          <p>
            {{$single->about}}
          </p>
        </div>
        @if(Auth::user())
          @if(Auth::user()->id != $single->user_id)
            <div class="single-support">
              <p class="text-center">
                <a class="btn btn-success destek-ol-button" role="button"><i class="fa fa-check"></i> DƏSTƏK OLMAQ İSTƏYİRƏM</a>
                  <div class="alert alert-success destek-ol-message">
                      <form class="" action="{{url('/notification/'.$single->id)}}" method="post">
                        {{csrf_field()}}
                          <label for="">Aciqlama</label>
                          <input type="text" name="description" class="form-control">
                          <input type="submit" name="send" class="pull-right btn-success" value="Gonder">
                      </form>
                  </div>
              </p>
            </div>
        @endif

        @elseif(Auth::guest())
                    <div class="alert alert-success">
                        Destek olmaq ucun qeydiyyatdan kecin zehmet olmazsa :)
                      </div>
        @endif

      </div>
    </div>
  </div>
</section>
@endsection
