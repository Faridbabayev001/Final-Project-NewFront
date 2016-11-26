@extends('pages.layout')
@section('title','Istek')
@section('content')

<div id="breadcrumb">
<div class="container">
   <div class="row">
      <h1 class="text-center">Yeni İstək</h1>
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
        <form action="{{url('/istek-add')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="col-lg-6">
            <div class="form-group">
              <label for="name">Başlıq</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
              <label for="name">Ünvan</label>
                 <input type="hidden" id="lat" name="lat">
                  <input type="hidden" id="lng" name="lng">
              <input type="text" name="location" class="form-control" id="adress" placeholder="">
            </div>
            <div class="form-group">
              <label for="name">Təşkilat adı</label>
              <input type="text" name="org" class="form-control">
            </div>
            <div class="form-group">
              <label for="name">Açıqlama</label>
              <textarea name="about" class="form-control" rows="6" cols="80"></textarea>
            </div>
            <div class="form-group">
              <label for="email">Şəkil</label>
              <input type="file" name="image" class="form-control">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="city">Ad, Soyad</label>
              <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
            </div>
            <div class="form-group">
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
              </div>
            </div>
            <div class="form-group">
              <label for="password">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Email" value="{{Auth::user()->email}}">
            </div>
            <div class="form-group">
              <label for="password">Növ</label>
              <input type="text" name="nov" class="form-control">
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
