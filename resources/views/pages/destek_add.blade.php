@extends('pages.layout')
@section('title','Dəstək əlavə et')
@section('content')
<style type="text/css">
  form img{
    width: 60px;
    height: 60px;
    margin-left: 5px;
    float: left
  }
  form span{
    color:red;
  }
</style>
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
       <div class="col-lg-12">
         <h1 class="text-left">Yeni Dəstək</h1>
       </div>
    </div>
  </div>
</div>
@if(Auth::user())
  <section id="add">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div id="map"></div>
          <button id="MyLocation" class="btn" type="button" name="button">Məni Tap</button>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          @if (Session::has('destek_add'))
            <div class="alert alert-success" role="alert">{{Session::get('destek_add')}}</div>
          @endif
          @if (Session::has('imageerror'))
            <div class="alert alert-danger" role="alert">{{Session::get('imageerror')}}</div>
          @endif
        <div id="ajaxErrorImage" class="aler alert-danger"></div>

          <form action="{{url('/destek-add')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            {{-- <=================title input ================> --}}
            <div class="col-lg-6">
              <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="name">Başlıq<SPAN> *</SPAN></label>
                <input type="text" name="title" class="form-control" maxlength="33" value="{{ old('title') }}">
                @if ($errors->has('title'))
                   <span class="help-block">
                     <strong>Boşluq buraxmayın</strong>
                   </span>
                @endif
              </div>

              {{-- <=================location input ================> --}}
              <div class="form-group{{ $errors->has('location') || $errors->has('lat') && $errors->has('lng')? ' has-error' : '' }}">
                <label for="name">Ünvan<SPAN> *</SPAN></label>
                   <input type="hidden" id="lat" name="lat">
                    <input type="hidden" id="lng" name="lng">
                <input type="text" name="location" class="form-control" id="adress" placeholder="">
                @if ($errors->has('location'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                  @elseif($errors->has('lat') && $errors->has('lng'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın </strong>
                    </span>
                @endif
              </div>

              {{-- <=================organization input ================> --}}
              <div class="form-group">
                <label for="name">Təşkilat adı</label>
                <input type="text" name="org" class="form-control" placeholder="Yoxdursa boş buraxın" value="{{ old('org') }}">
              </div>

              {{-- <=================About input ================> --}}
              <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                <label for="name">Açıqlama<SPAN> *</SPAN></label>
                <textarea name="about" class="form-control" rows="6" cols="80">{{ old('about') }}</textarea>
                @if ($errors->has('about'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>
            {{-- <=================image input ================> --}}
              <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                <label for="email">Şəkil<SPAN> *</SPAN></label>
                <a class="forImg form-control btn btn-default">Şəkil Seç</a>
                <input id="forLimitFile" type="file" name="image[]" class="imgInput hidden form-control" value="{{ old('image') }}" multiple>
                <p>Eyni anda bir və ya bir neçə şəkil seçə bilərsiniz</p>
                @if ($errors->has('image'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>

            {{-- for showing uploaded image --}}
            <div id="viewImage"></div>

            </div>
            <div class="col-lg-6">

              {{-- <=================Name input ================> --}}
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="city">Ad, Soyad<SPAN> *</SPAN></label>
                <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>

              {{-- <=================Phone input ================> --}}
              <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="operator">Əlaqə nömrəsi<SPAN> *</SPAN></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <input id="operator" type="hidden" name="operator" value="{{substr(Auth::user()->phone,4,2) == '55' ? '55' : substr(Auth::user()->phone,4,2) }}">
                        +994
                            <select id="operator-numbers" name="operator-numbers">
                                  <option {{substr(Auth::user()->phone,4,2) == '55' ? 'selected' : '' }}>55</option>
                                  <option {{substr(Auth::user()->phone,4,2) == '51' ? 'selected' : '' }}>51</option>
                                  <option {{substr(Auth::user()->phone,4,2) == '50' ? 'selected' : '' }}>50</option>
                                  <option {{substr(Auth::user()->phone,4,2) == '70' ? 'selected' : '' }}>70</option>
                                  <option {{substr(Auth::user()->phone,4,2) == '77' ? 'selected' : '' }}>77</option>
                            </select>
                        </div>
                  <input type="text" class="form-control" name="phone" value="{{substr(Auth::user()->phone,6)}}" maxlength="7">
                  @if ($errors->has('phone'))
                      <span class="help-block">
                        <strong>Boşluq buraxmayın</strong>
                      </span>
                  @endif
                </div>
              </div>

              {{-- <=================Email input ================> --}}
              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="password">Email<SPAN> *</SPAN></label>
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{Auth::user()->email}}">
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>Boşluq buraxmayın</strong>
                  </span>
              @endif
              </div>

              {{-- <=================Nov input ================> --}}
              <div class="form-group{{ $errors->has('nov') ? ' has-error' : '' }}">
                <label for="password">Növ<SPAN> *</SPAN></label>
                <input type="text" name="nov" class="form-control" placeholder="Məsələn: Təhsil, texnologiya və s." value="{{ old('nov') }}">
                @if ($errors->has('nov'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>

              {{-- <=================Date input ================> --}}
              <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                <label for="date">İstəyin müddəti<SPAN> *</SPAN></label>
                <input type="date" name="date" class="form-control" id="date" value="{{ old('date') }}">
                @if ($errors->has('date'))
                    <span class="help-block">
                      <strong>Tarix seçin</strong>
                    </span>
                @endif
              </div>
              <div class="form-group text-right">
                <input type="submit" class="btn" value="GÖNDƏR">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@elseif(Auth::guest())
  <section id="add">
    <div class="alert alert-danger">
      <h1 class="text-center">Dəstək əlavə etmək üçün <a href="{{url('/Qeydiyyat')}}" class="register-color">qeydiyyatdan</a> keçməyiniz tələb olunur.</h1>
    </div>
  </section>
@endif

@endsection
@section('scripts')
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAanmTrOlQYWRepobnwqSO1E2SOoHYMRBA&libraries=places&callback=initAutocomplete&language=az"
         async defer></script>
@endsection
