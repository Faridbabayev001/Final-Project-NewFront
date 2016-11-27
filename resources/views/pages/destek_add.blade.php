@extends('pages.layout')
@section('title','Destek')
@section('content')
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
          <h1 class="text-left">Yeni Dəstək</h1>
    </div>
  </div>
</div>
@if(Auth::user())
  <section id="add">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div id="map"></div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          @if (Session::has('destekadded'))
            <div class="alert alert-success" role="alert">{{Session::get('istekadded')}}</div>
          @endif
          @if (Session::has('imageerror'))
            <div class="alert alert-danger" role="alert">{{Session::get('imageerror')}}</div>
          @endif
          <form action="{{url('/destek-add')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-lg-6">
              <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="name">Başlıq</label>
                <input type="text" name="title" class="form-control">
                @if ($errors->has('title'))
                   <span class="help-block">
                     <strong>Boşluq buraxmayın</strong>
                   </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('location') || $errors->has('lat') && $errors->has('lng')? ' has-error' : '' }}">
                <label for="name">Ünvan</label>
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
              <div class="form-group">
                <label for="name">Təşkilat adı</label>
                <input type="text" name="org" class="form-control">
              </div>
              <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                <label for="name">Açıqlama</label>
                <textarea name="about" class="form-control" rows="6" cols="80"></textarea>
                @if ($errors->has('about'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                <label for="email">Şəkil</label>
                <input type="file" name="image" class="form-control">
                @if ($errors->has('image'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="city">Ad, Soyad</label>
                <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="operator">Əlaqə nömrəsi</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <input type="hidden" name="operator" value="55">
                        +994
                            <select name="operator-numbers">
                                  <option>55</option>
                                  <option>51</option>
                                  <option>50</option>
                                  <option>70</option>
                                  <option>77</option>
                            </select>
                        </div>
                  <input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}" maxlength="7">
                  @if ($errors->has('phone'))
                      <span class="help-block">
                        <strong>Boşluq buraxmayın</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="password">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{Auth::user()->email}}">
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>Boşluq buraxmayın</strong>
                  </span>
              @endif
              </div>
              <div class="form-group{{ $errors->has('nov') ? ' has-error' : '' }}">
                <label for="password">Növ</label>
                <input type="text" name="nov" class="form-control">
                @if ($errors->has('nov'))
                    <span class="help-block">
                      <strong>Boşluq buraxmayın</strong>
                    </span>
                @endif
              </div>
              <div class="form-group">
                <label for="date">İstəyin müddəti</label>
                <input type="date" name="date" class="form-control" id="date">
              </div>
              <div class="form-group text-center">
                <input type="submit" class="btn" value="GÖNDƏR">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@elseif(Auth::guest())
  <h1 class="text-center">login</h1>
@endif

@endsection
@section('scripts')
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAanmTrOlQYWRepobnwqSO1E2SOoHYMRBA&libraries=places&callback=initAutocomplete&language=az"
         async defer></script>
@endsection
