@extends('pages.layout')
@section('title','Ətraflı')
@section('content')
<style type="text/css">
  .littleImg{
    margin: 3% 0 0 2%;
    width: 18%;
    border-radius: 5%;
    height: 100px;
    overflow: hidden;
    float: left;
  }

</style>
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
       <div class="col-lg-12">
         <h1 class="text-left">{{$single->title}}</h1>
       </div>
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
            @elseif(!$diff->y == 0 && !$diff->m == 0 && $diff->d == 0)
              {{$diff->y}} il {{$diff->m}} ay
            @elseif (!$diff->y == 0 && $diff->m == 0 && $diff->d == 0)
              {{$diff->y}} il
            @elseif ($diff->y == 0 && !$diff->m == 0 && !$diff->d == 0)
              {{$diff->m}} ay {{$diff->d}} gün
            @else
                {{$diff->y}} il {{$diff->m}} ay {{$diff->d}} gün
            @endif
          </div>
          <div class="mainImg">

            <img src="{{url('/image/'.$single->shekiller[0]->imageName)}}" class="img-responsive img-single-big" alt="" />
          </div>
          <div class="single-img-location">
            <i class="fa fa-map-marker"></i> {{$single->location}}
          </div>
            {{-- SLIDER PART --}}

            @foreach($single->shekiller as $imgName)
            <div class="littleImg">
                <img src="{{url('/image/'.$imgName->imageName)}}" class="img-responsive img-single-small" alt="" />
            </div>
            @endforeach
        </div>
      </div>
      @php
        $url = 'http://bumeranq.org/single/'.$single->id;
      @endphp
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="single-social">
          <ul class="list-inline">
              <li class="single-social-facebook faceBook">
                <div class="social-buttons">
                    <a
                            data-open-share="facebook"
                            data-open-share-link="{{ $url }}"
                            data-open-share-picture="{{url('/image/'.$single->shekiller[0]->imageName)}}"
                            data-open-share-caption="Bumeranq.org"
                            data-open-share-description="{{$single->about}}"
                            data-open-share-dynamic="{{$single->title}}"

                            target="_blank">
                        <i class="fa fa-facebook"></i> PAYLAŞ
                    </a>
              </div>
              </li>

            <li  class="single-social-google" >
              <div class="social-buttons">
                <a
                  data-open-share="google"
                  data-open-share-url="{{ $url }}"
                  data-open-share-dynamic="{{$single->title}}"
                  target="_blank">
              <i class="fa fa-facebook"></i> PAYLAŞ
                </a>
              </div>
            </li>
          </ul>
        </div>
        <div class="single-content">
          <p>
            {{$single->about}}
          </p>
        </div>
        @if(Auth::user())
            @if (!$check)
              @if(Auth::user()->id != $single->user_id)
                <div class="single-support">
                  <p class="text-right">
                    @if ($single->type_id == 2)
                      @if (Session::has('description_destek'))
                        <div class="alert alert-success" role="alert">{{Session::get('description_destek')}}</div>
                      @endif
                      <a class="btn destek-ol-button" role="button"><i class="fa fa-check"></i> DƏSTƏK OLMAQ İSTƏYİRƏM</a>
                      @else
                        @if (Session::has('description_istek'))
                          <div class="alert alert-success" role="alert">{{Session::get('description_istek')}}</div>
                        @endif
                      <a class="btn destek-ol-button" role="button"><i class="fa fa-check"></i> DƏSTƏKDƏN YARARLANMAQ İSTƏYİRƏM</a>
                    @endif
                      <div class="alert alert-success destek-ol-message">

                          <form class="" action="{{url('/notification/'.$single->id)}}" method="post">
                            {{csrf_field()}}
                              <label for=""><h4>Açıqlama</h4></label>
                              <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
                              <input type="submit" name="send" class="pull-right btn" value="Göndər">
                              <div class="clear-fix"></div>
                          </form>
                      </div>
                  </p>
                </div>
            @endif
          @else
              @if (Session::has('description_destek'))
                <div class="alert alert-success" role="alert">{{Session::get('description_destek')}}</div>
              @elseif (Session::has('description_istek'))
                <div class="alert alert-success" role="alert">{{Session::get('description_istek')}}</div>
              @elseif ($single->type_id == 1)
                <div class="alert alert-success" role="alert">Siz artıq bu dəstəkdən yararlanmaq üçün müraciət etmisiniz.</div>
              @elseif ($single->type_id == 2)
                <div class="alert alert-success" role="alert">Siz artıq bu istəyə dəstək göndərmisiniz.</div>
              @endif
          @endif


        @elseif(Auth::guest() && $check == false)
          <div class="single-support">
            <p class="text-right">
              @if ($single->type_id == 2)
                <a class="btn destek-ol-button" role="button"><i class="fa fa-check"></i> DƏSTƏK OLMAQ İSTƏYİRƏM</a>
                @else
                <a class="btn destek-ol-button" role="button"><i class="fa fa-check"></i> DƏSTƏKDƏN YARARLANMAQ İSTƏYİRƏM</a>
              @endif
            </p>
          </div>
          <div class="alert alert-danger destek-ol-message">
            @if ($single->type_id == 2)
              <h5 class="text-center">Dəstək olmaq üçün <a href="/Qeydiyyat" class="register-color">qeydiyyatdan</a> keçməyiniz tələb olunur.<a href="#" data-toggle="modal" data-target="#contact-login-modal"> Daxil ol</a></h5>
              @else
              <h5 class="text-center">Dəstəkdən yararlanmaq üçün <a href="/Qeydiyyat" class="register-color">qeydiyyatdan</a> keçməyiniz tələb olunur .Zəhmət ol<a href="#" data-toggle="modal" data-target="#contact-login-modal"> Daxil ol</a></h5>
            @endif
          </div>
        @endif

      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')--}}
    <script src='https://cdn.rawgit.com/OpenShare/openshare/master/dist/openshare.js'></script>
@endsection
