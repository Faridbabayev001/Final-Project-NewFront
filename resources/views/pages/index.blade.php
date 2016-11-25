@extends('pages.layout')

@section('title')
  Bumeranq.org | Ana Səhifə
@endsection

@section('container')
  <section id="map">
  <div class="container-fluid">
    <div class="row">
      <div id="searchBoxDrag">
            <form id="mapSearch" class="form-inline" method="get">
                 <ul>
                   <li>
                       <label> Şəhər/region :</label>
                       <input id="Loc" type="text" class="hidden" name="keyword" value="all">
                       <select class="Test" id="acar">
                         <option name="location" value="all">Hamisi</option>
                         @foreach ($datas as $data)
                           @if ($data->status == 1)
                             <option name="location" value="{{$data->location}}">{{$data->location}}</option>
                           @endif
                         @endforeach
                       </select>
                   </li>
                     <li>
                       <label> Istek/Destek :</label>
                       <input id="Type" type="text" class="hidden" name="city" value="all">
                       <select class="Test" id="seher">
                         <option  name="type" value="all">Hamisi</option>
                         <option name="type" value="1">Destek</option>
                         <option name="type" value="2">Istek</option>
                       </select>
                     </li>
                     <li>
                       <label> Nov :</label><br>
                       <input id="Nov" type="text" class="hidden" name="category" value="all">
                       <select class="Test" id="kategory">
                         <option  name="nov" value="all">Hamisi</option>
                         @foreach ($datas as $data)
                           @if ($data->status == 1)
                             <option name="nov" value="{{$data->nov}}">{{$data->nov}}</option>
                           @endif
                         @endforeach
                       </select>
                   </li>
                 </ul>
           </form>
           </div>
      <img class="Load openLoad closeLoad" src="{{url('images/info-loading.gif')}}">
      <div id="InfoMap" style="width: 100%;height: 600px;">
      </div>
    </div>
  </div>
</section>
<section id="news">
  <div class="container">
     <div class="row">
      <div class="news-left col-lg-6 col-md-6 col-sm-12 col-xs-12 padding0">
        <div class="col-lg-12 news-type-title">
          <h1>İSTƏKLƏR</h1>
          <hr>
        </div>
        <!-- News block -->
        @foreach ($datas as $data)
          @if($data->status=='1' && $data->type_id=='1')
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
              <div class="news-block">
                <div class="news-image col-lg-12 padding0">
                  <div class="news-type news-istek">
                    İstək
                  </div>
                  <a href="{{url('/single/'.$data->id)}}"><img src="{{url('/uploads/'.$data->image)}}" alt="İstək image" /></a>
                </div>
                <div class="news-content col-lg-12 padding0">
                  <div class="news-title">
                    <a href="single.html">{{$data->title}}</a>
                  </div>
                  <div class="news-location col-lg-12">
                    <p><i class="fa fa-map-marker"></i>{{$data->location}}</p>
                  </div>
                </div>
              </div>
            </div>
          @endif
        @endforeach
        <!-- News block end -->

        <!-- News block -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
          <div class="news-block">
            <div class="news-image col-lg-12 padding0">
              <div class="news-type news-istek">
                İstək
              </div>
              <a href="single.html"><img src="{{url('/images/a.jpg')}}" alt="İstək image" /></a>
            </div>
            <div class="news-content col-lg-12 padding0">
              <div class="news-title">
                <a href="single.html">Web developer lazımdı təcili</a>
              </div>
              <div class="news-location col-lg-12">
                <p><i class="fa fa-map-marker"></i> Neftçala, Azərbaycan</p>
              </div>
            </div>
          </div>
        </div>
        <!-- News block end -->

        <!-- News block -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
          <div class="news-block">
            <div class="news-image col-lg-12 padding0">
              <div class="news-type news-istek">
                İstək
              </div>
              <a href="single.html"><img src="{{url('/images/a.jpg')}}" alt="İstək image" /></a>
            </div>
            <div class="news-content col-lg-12 padding0">
              <div class="news-title">
                <a href="single.html">Web developer lazımdı təcili</a>
              </div>
              <div class="news-location col-lg-12">
                <p><i class="fa fa-map-marker"></i> Neftçala, Azərbaycan</p>
              </div>
            </div>
          </div>
        </div>
        <!-- News block end -->

        <!-- News block -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
          <div class="news-block">
            <div class="news-image col-lg-12 padding0">
              <div class="news-type news-istek">
                İstək
              </div>
              <a href="single.html"><img src="{{url('/images/a.jpg')}}" alt="İstək image" /></a>
            </div>
            <div class="news-content col-lg-12 padding0">
              <div class="news-title">
                <a href="single.html">Web developer lazımdı təcili</a>
              </div>
              <div class="news-location col-lg-12">
                <p><i class="fa fa-map-marker"></i> Neftçala, Azərbaycan</p>
              </div>
            </div>
          </div>
        </div>
        <!-- News block end -->
      </div>

      <div class="news-right col-lg-6 col-md-6 col-sm-12 col-xs-12 padding0">
        <div class="col-lg-12 news-type-title">
          <h1>DƏSTƏKLƏR</h1>
          <hr>
        </div>
        <!-- News block -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
          <div class="news-block">
            <div class="news-image col-lg-12 padding0">
              <div class="news-type news-destek">
                Dəstək
              </div>
              <a href="single.html"><img src="{{url('/images/a.jpg')}}" alt="İstək image" /></a>
            </div>
            <div class="news-content col-lg-12 padding0">
              <div class="news-title">
                <a href="single.html">Web developer lazımdı təcili</a>
              </div>
              <div class="news-location col-lg-12">
                <p><i class="fa fa-map-marker"></i> Neftçala, Azərbaycan</p>
              </div>
            </div>
          </div>
        </div>
        <!-- News block end -->

        <!-- News block -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
          <div class="news-block">
            <div class="news-image col-lg-12 padding0">
              <div class="news-type news-destek">
                Dəstək
              </div>
              <a href="single.html"><img src="{{url('/images/a.jpg')}}" alt="İstək image" /></a>
            </div>
            <div class="news-content col-lg-12 padding0">
              <div class="news-title">
                <a href="single.html">Web developer lazımdı təcili</a>
              </div>
              <div class="news-location col-lg-12">
                <p><i class="fa fa-map-marker"></i> Neftçala, Azərbaycan</p>
              </div>
            </div>
          </div>
        </div>
        <!-- News block end -->

        <!-- News block -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
          <div class="news-block">
            <div class="news-image col-lg-12 padding0">
              <div class="news-type news-destek">
                Dəstək
              </div>
              <a href="single.html"><img src="{{url('/images/a.jpg')}}" alt="İstək image" /></a>
            </div>
            <div class="news-content col-lg-12 padding0">
              <div class="news-title">
                <a href="single.html">Web developer lazımdı təcili</a>
              </div>
              <div class="news-location col-lg-12">
                <p><i class="fa fa-map-marker"></i> Neftçala, Azərbaycan</p>
              </div>
            </div>
          </div>
        </div>
        <!-- News block end -->

        <!-- News block -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0 thumbnail">
          <div class="news-block">
            <div class="news-image col-lg-12 padding0">
              <div class="news-type news-destek">
                Dəstək
              </div>
              <a href="single.html"><img src="{{url('/images/a.jpg')}}" alt="İstək image" /></a>
            </div>
            <div class="news-content col-lg-12 padding0">
              <div class="news-title">
                <a href="single.html">Web developer lazımdı təcili</a>
              </div>
              <div class="news-location col-lg-12">
                <p><i class="fa fa-map-marker"></i> Neftçala, Azərbaycan</p>
              </div>
            </div>
          </div>
        </div>
        <!-- News block end -->
      </div>
    </div>
  </div>
</section>
  {{-- <script src="{{url('/js/InfoBubble.js')}}" charset="utf-8"></script>
  <script src="{{url('/js/AxajSearchMap.js')}}" charset="utf-8"></script> --}}
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAanmTrOlQYWRepobnwqSO1E2SOoHYMRBA&callback=Mydata&language=az" async defer></script>
@endsection
